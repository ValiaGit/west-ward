$(function() {

    $.ajaxSetup({
        headers: {
            'jwt': jwtoken
        }
    });

    $( ".datapicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $('#dateSubmit').on('click',function(){
        affiliates.rendDashboardChilds();
        affiliates.rendDashboardGraph();
        $('.user_search #user_id').val('');
        $('#searchclear').hide();
        return false;
    });

    $('.min_stat_item #select_level').on('change',function(){
        affiliates.renderEasyStats( $(this).val() );
        affiliates.rendDashboardChilds();
        affiliates.rendDashboardGraph();
        $('.user_search #user_id').val('');
        $('#searchclear').hide();
    });

    $('.user_search #searchSubmit').on('click',function(){
        var user_id = $('.user_search #user_id').val();

        if ( user_id.length == 6) {
            affiliates.searchUser(user_id);
            affiliates.rendDashboardGraph(user_id);
            $('#searchclear').show();
            return false;
        } else {
            alert ('affiliate ID must be contain 6 symbols');
            return false;
        }
    });

    $('#searchclear').on('click',function(){
        $('.user_search #user_id').val('');
        $('#searchclear').hide();
        affiliates.rendDashboardChilds();
        affiliates.rendDashboardGraph();
        return false;
    });

    $(document).on('click','#pagination ul.pagination li:not(.active)',function(){
        affiliates.rendDashboardChilds( $(this).data('page') );
        console.log($(this).data('page'));
        return false;
    });

    affiliates.renderEasyStats();
    affiliates.rendDashboardChilds();
    affiliates.rendDashboardGraph();

});
