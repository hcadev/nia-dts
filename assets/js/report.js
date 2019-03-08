$(function(){
    $("#report-settings").submit(function(e){
        var from = $(this).find('input[name=from]').val();
        var to = $(this).find('input[name=to]').val();
        var type = $(this).find('select[name=type]').val();
        var municipality = $(this).find('select[name=municipality]').val();

        if (type == 'status_all')
        {
            $("#report-content").load('report/status?filter=all', {from : from, to : to, municipality : municipality});
        }
        else if (type == 'status_ongoing')
        {
            $("#report-content").load('report/status?filter=ongoing', {from : from, to : to, municipality : municipality});
        }
        else if (type == 'status_completed')
        {
            $("#report-content").load('report/status?filter=completed', {from : from, to : to, municipality : municipality});
        }
        else if (type == 'statistics')
        {
            $("#report-content").load('report/statistics', {from : from, to : to, municipality : municipality});
        }

        e.preventDefault();
        e.stopImmediatePropagation();
    });
});