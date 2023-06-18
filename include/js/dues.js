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

});