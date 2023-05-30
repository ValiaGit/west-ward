var UpcomingsWidget = {

    data:{},

    template:'<div class="list-custom list-light-blue">'+
        '<ul class="navigation level-1">'+
        '<li class="list-group-item" >'+
        '<a href="#" class="expand {{sCode}}" ><i class="sport-{{sCode}}"></i>{{sTitle}} <span class="badge widget-badge pull-right" style="margin-top: -3px;margin-right: 8px;">{{matches_count}}</span></a>'+
        '  <ul class="level-2" style="display: none">'+
        '      {{matches}}'+
        '      </ul>'+
        '   </li>'+
        '</ul>'+
        '  </div>',


    getData:function() {
        var me = this;

        var user_id = Util.Cookie.get("user_id");
        var params = {
            user_id:user_id
        };
        Util.addLoader($('#upcoming_widget'));
        API.call("betting.matches","getUpcomingMatches",params,function(response) {
            me.arrangeData(response);
        });
    },



    arrangeData:function(data) {

        var me = this;

        for(var index in data) {

            var current = data[index];
            var sId = current.sId;
            if(!me.data[sId]) {
                me.data[sId] = {
                    sTitle:current.sTitle,
                    sCode:current.sCode,
                    matches:[]
                };
            }

            me.data[sId].matches.push({
                id:current.id,
                a:current.a,
                h:current.h,
                t:current.t
            });
        }


        me.renderData();
    },


    renderData:function() {

        var me = this;

        var data = me.data;
        var html = "";
        var iterator = 0;
        for(var index in data) {

            var sport = data[index];

            var matchesHTML = "";
            var matches = sport.matches;
            for(var jindex in matches) {
                var match = matches[jindex];
                var time = match.t;
                var mmt = moment(time),  time = mmt.format("DD-MM HH:mm");

                matchesHTML+='<li class="list-group-item" title="'+match.h+' - '+match.a+'"><a href="'+base_href+'/'+cur_lang+'/p/match/'+match.id+'"><span class="time">'+time+'</span> <span class="pair">'+match.h+' - '+match.a+'</span></a></li>';
            }

            var template = me.template;
            template = template.replace("{{sTitle}}",sport.sTitle);
            template = template.replace(/\{\{sCode\}\}/gi,sport.sCode);
            if(iterator == 0) {
                template = template.replace(/\{\{is_expanded\}\}/g,"expanded");
            } else {
                template = template.replace(/\{\{is_expanded\}\}/g,"");
            }

            template = template.replace("{{matches}}",matchesHTML);
            template = template.replace("{{matches_count}}",matches.length);
            html+=template;

            iterator++;
        }
        $('#upcoming_widget').html(html);
        $('a.expand').collapsible({
            defaultOpen: 'level-1,third-level',
            cssOpen: 'expanded',
            cssClose: 'collapsed',
            speed: 150
        });


    }



}