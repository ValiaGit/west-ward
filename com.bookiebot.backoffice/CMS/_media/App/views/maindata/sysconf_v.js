App.view('sysconf', {

    /**
     * You're dummy if u need comment for Init function
     */
    init: function (bet_id,users_id) {

        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=bets]').addClass("active");

        var me = this,
            model = me.myModel(),
            container = new Tab({
                id: 'sysconf',
                name: "sysconf"
            });


            container.load("http://office.bookiebot.com/CMS/sysconf.html");
            //container.html("<h1>System Configuration</h1><p></p>");


        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function () {


    }//end renderData();


});//end {}