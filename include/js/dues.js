$(document).ready(function () {
    $("#ccduelistresult").hide();
    $("#dailyduelistresult").hide();
    $("#weeklyduelistresult").hide();
    $("#monthlyduelistresult").hide();

    $("#ccduelistbtn").click(function() {
        $("#ccduelistresult").show();
    });
    $("#dailyduelistbtn").click(function() {
        $("#dailyduelistresult").show();
    });
    $("#weeklyduelistbtn").click(function() {
        $("#weeklyduelistresult").show();
    });
    $("#monthlyduelistbtn").click(function() {
        $("#monthlyduelistresult").show();
    });

    $(document).on("click", "#closebtncc", function() {
        $("#ccduelistresult").hide();
    });
    $(document).on("click", "#closebtnd", function() {
        $("#dailyduelistresult").hide();
    });
    $(document).on("click", "#closebtnw", function() {
        $("#weeklyduelistresult").hide();
    });
    $(document).on("click", "#closebtnm", function() {
        $("#monthlyduelistresult").hide();
    });
});