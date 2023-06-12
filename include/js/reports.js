$(document).ready(function () {
    //will change ir latter
    $("#customeridsearchbutton").click(function (e) {
        e.preventDefault();

        var custid = $("#search_report").val();
        $.ajax({
            url: '../include/ajaxphpfiles/reports_ajax.php',
            type: 'POST',
            data: { 'custid': custid },
            success: function (data) {
                $("#reportinfo").html(data);
            }
        });
    });
})