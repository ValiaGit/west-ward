$().ready(function() {


    // Make Betslip Sticky on Scroll
    $(".betslip").sticky({topSpacing:50, getWidthFrom: '.right-sidebar'});
    $("#odds-panel").sticky({topSpacing:50, getWidthFrom: '.home-middle'});

    $('select.custom-select').select2({
        minimumResultsForSearch: -1
    }).on("change", function(e) {
        //alert('opened');
        $('.select2-container').removeClass('select2-container-active');
    });


    //Handle Get Variables
    var GetRequestParams = Util.getUrlVars();




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


    $('#signInButton').click(function() {
        $(this).attr('href','https://accounts.google.com/o/oauth2/auth?scope=' +
            'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read https://www.googleapis.com/auth/plus.me&' +
            'state='+sault+'&' +
            'redirect_uri='+base_href+'/'+cur_lang+'/google/login&'+
            'response_type=code&' +
            'client_id=1044031908183-d9f8g1b9iimvm7h1pr3f5ibv6fl243rn.apps.googleusercontent.com&' +
            'access_type=offline');
        return true; // Continue with the new href.
    });

Util.Hash.init();





});





