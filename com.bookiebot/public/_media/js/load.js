Number.prototype.trunc = function(digits) {
    var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
        m = this.toString().match(re);
    m = m ? parseFloat(m[1]) : this.valueOf();
    return (+m).toFixed(digits);

}


/**
 *
 */
function openSocial() {
    var user_id = Util.Cookie.get("user_id");
    if(user_id) {
        window.location.href=base_href+"/"+cur_lang+"/social";
    } else {
        Util.Popup.open({
            content:"Please login or register to view social part of website!"
        });
    }

}


$(function() {







    $('.sortable').sortable().disableSelection();





    App.init();
    Session.init(function() {



        console.log(111);

        try {
            if(request_uri.indexOf('/sport')!=-1) {
                Sport.init();
            }

        }catch(e) {
            console.log(e);
        }

        try {
            if(typeof page != 'undefined') {
                if(page == "main") {
                    introJs().start();
                }
            }
        }catch(e) {

        }

    });
    Util.AddCSRFToken();


    // Make Betslip Sticky on Scroll
    $(".betslip").sticky({topSpacing:50, getWidthFrom: '.right-sidebar'});

    $("#odds-panel").sticky({topSpacing:50, getWidthFrom: '.home-middle'});

    $('.current-time').html(moment().format("HH:mm MMM DD, YYYY, ZZ"));


    $(window).scroll(function(e){
        var scrollFromTop = $(window).scrollTop();


        if(scrollFromTop >= 30) {
            $(".social-sidebar-inside").css({'position':'fixed'});
            $(".social-sidebar-inside").stop().css({"top": "100px",'z-index':'9999'});


            //$('.navbar.navbar-default.navbar-sub-header').css({
            //    "position":"fixed",
            //    "right": 0,
            //    "left": 0,
            //    "top": "50px",
            //    "border-bottom":"1px solid black",
            //    "z-index": 99999
            //});

        }

        else {
            $(".social-sidebar-inside").css({'position':''});

            $(".social-right-inside").css({'position':''});
            //$('.navbar.navbar-default.navbar-sub-header').attr("style","");
        }








    });
    //$(".social-sidebar-inside").sticky({position: "fixed"});


    $('select.custom-select').select2({
        minimumResultsForSearch: -1
    }).on("change", function(e) {
        //alert('opened');
        $('.select2-container').removeClass('select2-container-active');
    });




    $(".modal-wide").on("show.bs.modal", function() {
        var height = $(window).height() - 200;
        $(this).find(".modal-body").css("max-height", height);
    });

    //Handle Get Variables
    var GetParams = Util.getUrlVars();



    if(GetParams['resetPass']=="true" && GetParams['token']!=undefined) {

    }



    $('.home-slider').swiper({
        pagination: '.swiper-pagination',
        paginationClickable: 1
    });


    var body = $('body');
    body.on('click', '.match-odds .trigger', function(e) {
        var self = $(this);
        self.closest('.match-odds').toggleClass('expanded collapsed');
        e.preventDefault();
    });



    Util.Hash.init();





});





