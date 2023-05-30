var Autobet =  {
    make:function() {
        console.log('called');

        if(!Session.userData) {
            Session.showLoginPopup();
        }

        var activeTab = $('#top_matches_content .tab-pane.active');
        var gameRows = activeTab.find('tr');
        var gameRowsLength = gameRows.length;

        var randRowIndex = Math.floor( (Math.random() * gameRowsLength) + 1 );

        var selectedRow = gameRows.eq(randRowIndex);


        var balance = parseFloat(Session.userData.balance);
        if(balance<800) {
            alert("You should have at list 2 Euros on your balance!");
            return false;
        }

        var fourthBalance = 2.00;

        var odds = selectedRow.find(".odd");
        odds.each(function() {
            $(this).find('button').click();
        });

        $('.input-odd').val(2);
        $('.input-bs.input-stake').val(fourthBalance);


        console.log(odds);



        $('.input-bs').keyup();

    }
};


