/**
 * Categories View
 */
WhereismoneyView = {


    initContent: function () {
        $("#MiddleContainer").removeAttr('class').addClass('col-md-12 home-middle').html('<div id="where_is_money-panel"></div>');

        var html = '<div class="panel panel-grid grid-top" id="WhereIsTheMoneyInner">' +
            '<div class="panel-heading soccer"><h2 class="grid-title">'+lang_arr['where_is_the_money']+'</h2></div>' +
            '<div class="panel-content leagues">' +
            '    <table class="table table-responsive">' +
            '       <thead>' +
            '            <tr>' +
            '               <th class="half">'+lang_arr['pair']+'</th>' +
            '              <th class="text-center">'+lang_arr['unmatched_amount']+'</th>' +
            '         </tr>' +
            '     </thead>' +
            '     <tbody>' +
            '{matches}' +
            '     </tbody>' +
            ' </table>' +
            '</div>' +
            '</div>';


        var matches_html = '';
        Util.addLoader('#MiddleContainer');
        API.call("betting.matches", "getMatchesThatHaveMoney", {}, function (response) {
            Util.removeLoader('#MiddleContainer');
            for (var index in response) {
                var currentMatchWithMoney = response[index];
                var sport_title = currentMatchWithMoney.sTitle+" / "+currentMatchWithMoney.cTitle+" / "+currentMatchWithMoney.tTitle;

                matches_html += '<tr>' +
                '             <td class="match_name">' +
                '' +
                '<a class="match-link" onclick="App.getController(\'matches\').initMatchById(' + currentMatchWithMoney.match_id + ');">' +
                '<i class="has_tooltip sport-'+currentMatchWithMoney.sCode+'" data-original-title="'+sport_title+'"></i> ' +
                '' + currentMatchWithMoney.h + ' - ' + currentMatchWithMoney.a + '' +
                '</a>' +
                '               <span class="date" style="margin-top:-4px;">'+moment(currentMatchWithMoney.starttime).format('dddd HH:mm')+'</span>' +
                '             </td>' +
                '             <td class="unmatched">' + (currentMatchWithMoney.unmatched_amount / 100).toFixed(2) + ' &#8364;</td>' +
                '         </tr>';
            }

            html = html.replace("{matches}", matches_html);

            $('#where_is_money-panel').html(html);

            if(!response.length) {
                $('#where_is_money-panel #WhereIsTheMoneyInner').append('<div><p style="padding:10px;color:white">'+lang_arr['there_are_no_markets_with_unmatched_money']+'</p></div>');
            }

            $('i.has_tooltip').tooltip();
        },function() {
            Util.removeLoader('#MiddleContainer');
        });


    }

};