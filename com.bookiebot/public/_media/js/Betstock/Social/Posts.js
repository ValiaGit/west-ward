var Posts = {
    templates: {

        comment: '<div class="comment" id="comment-item-{{comment_id}}">' +
            '<div class="comment-info">' +
            ' {{remove}}' +
            ' <div class="comment-avatar">' +
            '      <img src="{{avatar}}" alt="" />' +
            '  </div>' +
            '  <!-- comment-avatar -->' +
            '  <div class="comment-author">' +
            '     <h3><a href="#">{{fullname}}</a></h3>' +
            '    <div class="comment-date">' +
            '         <i class="icon-date"></i> {{adddate}}' +
            '   </div>' +
            '     <!-- comment date -->' +
            '</div>' +
            ' <!-- comment author -->' +
            '</div>' +
            '<!-- comment info -->' +
            '<div class="comment-content">' +
            '{{content}}' +
            '</div>' +
            ' <!-- comment content -->' +
            '</div>',


        post: '' +
            '<div class="feed-item" id="feed_item-{{post_id}}">' +
            '{{remove_post}}' +
            '<div class="feed-info">' +
            '<div class="feed-avatar">' +
            '   <a href="{{big_avatar}}" class="highslide" onclick="return hs.expand(this)"><img src="{{avatar}}" alt="" /></a>' +
            '</div>' +
            '<!-- feed-avatar -->' +
            '<div class="feed-author">' +
            '    <h3><a href="#">{{fullname}}</a></h3>' +
            '    <div class="feed-date">' +
            '       <i class="icon-date"></i> {{post_date}}' +
            '   </div>' +
            '<!-- feed date -->' +
            ' </div>' +
            '<!-- feed author -->' +
            ' </div>' +
            '    <!-- feed info -->' +
            '   <div class="feed-content">' +
            '   <p style="margin-bottom:10px;">{{content}}</p>{{image}}' +
            '   </div>' +
            '    <!-- feed content -->' +
            '   <ul class="feed-buttons">' +
            '       <li class="like-btn /*has-liked*/">' +
            '          <a href="#" onclick="Posts.like({{post_id}});return false;"><i class="icon-heart"></i> Like <span>({{likes_number}})</span></a>' +
            '     </li>' +
            '      <!-- like btn -->' +
            '      <li class="comments-btn">' +
            '         <a href="#" ><i class="icon-comments"></i> Comment <span>({{comments_number}})</span></a>' +
            '      </li>' +
            '      <!-- comments btn -->' +
            '   </ul>' +
            '   <!-- feed-buttons -->' +
            '    <div class="feed-comments">{{comments}}' +
            '       <div class="comment-form">' +
            '           <form onsubmit="Posts.addComment(this,{{post_id}});return false;" method="post">' +
            '               <div class="container-fluid">' +
            '               <div class="row">' +
            '                       <div class="col-md-12">' +
            '                       <input class="form-control input-comment" type="text" name="comment" placeholder="' + lang_arr.write_a_comment + '..." />' +
            '                       </div>' +
            '                   <!-- col -->' +
            '                      <!-- <div class="col-md-3">' +
            '                     <button class="btn btn-block btn-dark-blue">' + lang_arr.post + '</button>' +
            '                      </div>' +
            '                       col -->' +
            '                   </div>' +
            '           </div>' +
            '           </form>' +
            '   </div>' +
            '       <!-- comment form -->' +
            '</div>' +
            '   <!-- feed comments -->' +
            '</div>' +
            '<!-- feed item -->' +
            ''
    },



    /**************************************************
     * Post Messages on Feed And Delete Messages
     */
    addPost: function (form,community_id) {
        var me = Posts;

        var image = $('#file').val();
        if(image != "") {
            me.addImagePost(form,community_id);
            return false;
        }



        var formData = Util.Form.serialize($(form));
        if (formData.content == "") {
            Util.Popup.open({
               content: "Please Enter Text"
            });
            return false;
        }
        var user_id = Util.Cookie.get("user_id");


        var method = "addPost";
        var params = {user_id: user_id, content: formData.content,community_id:community_id};

        Util.addLoader($('.block-post'));
        API.call("social.posts", method, params, function (response) {
            Util.removeLoader($('.block-post'));
            if (response.code == 10) {
                $('#message_text').val("");
                if(community_id) {
                    me.getFriendsFeed(community_id);
                } else {
                    me.getFriendsFeed();
                }

            }
        });

    },


    addImagePost: function (form,community_id) {
        var me = this;
        var formData = Util.Form.serializeUploadForm(form);

        Util.addLoader($('.block-post'));
        API.callWithMimeFile("social.posts", "addImagePost", formData, function (response) {
            Util.removeLoader($('.block-post'));
            if (response.code == 10) {
                $('#message_text').val("");
                if(community_id) {
                    Community.getCommunity(community_id);
                } else {
                    me.getFriendsFeed();
                }

            }
        });
    },


    refreshPostDetails: function (post_id) {
        var me = this;
        var params = {
            user_id: Util.Cookie.get("user_id"),
            post_id: post_id
        };


        API.call("social.posts", "refreshPostDetails", params, function (data) {
            me.renderRefreshedPost(data.data[0]);
        });
    },

    renderRefreshedPost: function (current) {
        var intemplate = this.templates.post;
        var intemplate = intemplate.replace("{{content}}", current['content']);


        if (current['type']==2) {
            intemplate = intemplate.replace("{{image}}", '<img class="thumbnail" src="' + current['image_thumb'] + '" />');
        } else {
            intemplate = intemplate.replace("{{image}}", '');
        }

        //If Post Belongs To Usr Can Delete
        if (current.core_users_id == Util.Cookie.get("user_id")) {
            intemplate = intemplate.replace("{{remove_post}}", '<a class="icon-close btn-remove" href="#" onclick="Posts.deletePost(' + current['post_id'] + ');return false;" title="Remove"></a>');
        } else {
            intemplate = intemplate.replace("{{remove_post}}", '');
        }

        var commentsHTML = "";
        for (var index in current.comments) {
            var currentComment = current.comments[index];
            commentsHTML += Posts.getCommentHTML(currentComment);
        }


        intemplate = intemplate.replace("{{post_date}}", current['post_date']);
        intemplate = intemplate.replace("{{avatar}}", current['avatar']);
        intemplate = intemplate.replace("{{fullname}}", current['fullname']);
        intemplate = intemplate.replace("{{likes_number}}", current['likes_number']);
        intemplate = intemplate.replace("{{unlikes_number}}", current['unlikes_number']);
        intemplate = intemplate.replace("{{comments_number}}", current['comments_number']);
        intemplate = intemplate.replace("{{comments}}", commentsHTML);
        intemplate = intemplate.replace(/{{post_id}}/g, current['post_id']);


//        $('#feed_item-'+current.post_id).hide();
        $('#feed_item-' + current.post_id).html(intemplate);
    },

    /**************************************************
     *Post Messages on Feed And Delete Messages
     */
    /**************************************************
     * Render Friends Feed
     */
    getFriendsFeed: function (community_id) {
        var user_id = Util.Cookie.get("user_id");
        Util.addLoader($('#stream'));
        API.call("social.posts", "getFriendsFeed", {user_id: user_id,community_id:community_id}, function (response) {
            Util.removeLoader($('#stream'));
            if (response.code == 10) {
                Posts.renderFeed(response.data);
            } else {
                $('#stream').html("<p style='padding:5px'>There are no any posts yet!</p>");
            }
        });
    },


    renderFeed: function (data) {
        var template = Posts.templates.post;
        var html = "";
        for (var i = 0; i < data.length; i++) {
            var current = data[i];
            if(current['content'].indexOf("http")!=-1) {
                current['content'] = 'Link: <a href="#" onclick=\'window.open("'+current["content"]+'","Test","width=1024,height=768")\'>'+current["content"]+'</a>';
            }
            var intemplate = template.replace("{{content}}", current['content']);

            if (current['type']==2) {
                intemplate = intemplate.replace("{{image}}", '' +
                '<a href="' + current['image_original'] + '" class="highslide" onclick="return hs.expand(this)">' +
                '<img class="thumbnail" src="' + current['image_thumb'] + '" />' +
                '</a>');
            } else {
                intemplate = intemplate.replace("{{image}}", '');
            }

            //If Post Belongs To Usr Can Delete
            if (current.core_users_id == Util.Cookie.get("user_id")) {
                intemplate = intemplate.replace("{{remove_post}}", '<a class="icon-close btn-remove" href="#" onclick="Posts.deletePost(' + current['post_id'] + ');return false;" title="Remove"></a>');
            } else {
                intemplate = intemplate.replace("{{remove_post}}", '');
            }

            var commentsHTML = "";
            for (var index in current.comments) {
                var currentComment = current.comments[index];
                commentsHTML += Posts.getCommentHTML(currentComment, current['post_id']);
            }

            intemplate = intemplate.replace("{{post_date}}", current['post_date']);
            intemplate = intemplate.replace("{{avatar}}", current['avatar']);
            intemplate = intemplate.replace("{{big_avatar}}", current['big_avatar']);
            intemplate = intemplate.replace("{{fullname}}", current['fullname']);
            intemplate = intemplate.replace("{{likes_number}}", current['likes_number']);
            intemplate = intemplate.replace("{{unlikes_number}}", current['unlikes_number']);
            intemplate = intemplate.replace("{{comments_number}}", 0);
            intemplate = intemplate.replace("{{comments}}", commentsHTML);
            intemplate = intemplate.replace(/{{post_id}}/g, current['post_id']);
            html += intemplate;
        }

        console.log(data.length);
        if(!data.length) {
            $('#stream').html("<p style='padding:5px'>There are no any posts yet!</p>");
        } else {
            $('#stream').html(html);
        }


    },

    getCommentHTML: function (data, post_id) {
        var me = this;
        var template = me.templates.comment;

        template = template.replace("{{avatar}}", data.avatar);
        template = template.replace("{{fullname}}", data.fullname);
        template = template.replace("{{content}}", data.content);
        template = template.replace("{{comment_id}}", data.comment_id);
        template = template.replace("{{adddate}}", data.adddate);

        //If Comments Belongs To Usr Can Delete
        if (data.user_id == Util.Cookie.get("user_id")) {
            template = template.replace("{{remove}}", '<a class="icon-close btn-remove" href="#" onclick="Posts.deleteComment(' + data['comment_id'] + ',' + post_id + ');return false;" title="Remove"></a>');
        } else {
            template = template.replace("{{remove}}", '');
        }

        return template;
    },

    deleteComment: function (comment_id, post_id) {
        var me = this;
        var params = {
            comment_id: comment_id,
            user_id: Util.Cookie.get("user_id")
        };
        API.call("social.comments", "deleteComment", params, function (response) {
            if (response.code == 10) {
                $('#comment-item-' + comment_id).fadeOut();
            }

        });
    },
    /**************************************************
     * End Render Friends Feed
     */

    /**************************************************
     * Comments
     */

    /**************************************************
     * Comments
     */


    getPostDetails: function (post_id) {
        var user_id = Util.Cookie.get("user_id");

        API.call("social.posts", "getPostDetails", {user_id: user_id, post_id: post_id}, function (response) {
            if (response.code == 10) {
                Util.Popup.open({
                    content: "Success!"
                });
            }
        });
    },


    deletePost: function (post_id) {
        var user_id = Util.Cookie.get("user_id");
        var me = this;
        API.call("social.posts", "deletePost", {user_id: user_id, post_id: post_id}, function (response) {
            if (response.code == 10) {
                $('#feed_item-' + post_id).fadeOut();
//                me.getFriendsFeed();
            }
        });
    },


    addComment: function (form, post_id) {
        var me = this;
        var data = Util.Form.serialize($(form));
        if (data.comment && data.comment != "" && post_id) {
            var params = {
                user_id: Util.Cookie.get('user_id'),
                post_id: post_id,
                content: data.comment
            };
            API.call("social.comments", "addComment", params, function (response) {
                me.refreshPostDetails(post_id);
            });

        }

        return false;
    },


    like: function (id) {
        var me = this;
        var post_id = id;
        var user_id = Util.Cookie.get("user_id");

        API.call("social.posts", "like", {user_id: user_id, post_id: post_id}, function (response) {
            if (response.code == 10) {
                me.refreshPostDetails(post_id);
            }
        });

    },

    dislike: function (id) {
        var post_id = id;
        var user_id = Util.Cookie.get("user_id");

        API.call("social.posts", "unlike", {user_id: user_id, post_id: post_id}, function (response) {
            if (response.code == 10) {
                Util.Popup.open({
                    content: "Success!"
                });
            }
        });
    }




};




