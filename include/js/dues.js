$(document).ready(function () {

    $("#ccduelistbtn").click(function() {
        var cc = $(this).val();
        // alert(loantype);
        $.ajax({
            url: '../include/ajaxphpfiles/duelist_ajax.php',
            type: 'POST',
            data: { 'cc': cc },
            success: function(data) {
                $("#ccduelistresult").html(data);
            }
        });
    });

    $("#dailyduelistbtn").click(function() {
        var daily = $(this).val();
        // alert(loantype);
        $.ajax({
            url: '../include/ajaxphpfiles/duelist_ajax.php',
            type: 'POST',
            data: { 'daily': daily },
            success: function(data) {
                $("#dailyduelistresult").html(data);
            }
        });
    });

    $("#weeklyduelistbtn").click(function() {
        var weekly = $(this).val();
        // alert(loantype);
        $.ajax({
            url: '../include/ajaxphpfiles/duelist_ajax.php',
            type: 'POST',
            data: { 'weekly': weekly },
            success: function(data) {
                $("#weeklyduelistresult").html(data);
            }
        });
    });

    $("#monthlyduelistbtn").click(function() {
        var monthly = $(this).val();
        // alert(loantype);
        $.ajax({
            url: '../include/ajaxphpfiles/duelist_ajax.php',
            type: 'POST',
            data: { 'monthly': monthly },
            success: function(data) {
                $("#monthlyduelistresult").html(data);
            }
        });
    });

});