
$(document).ready(function() {
    //to fetch customer name from customerid input
    $(document).on("keyup", "#customerid", function() {
        var customer_id = $(this).val();

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'customer_id': customer_id },
            success: function(data) {
                $("#customer-name").val(data);
            }
        });
    });

    //to calculate installment on basis of ROI & Principle amount
    $(document).on("keyup", "#ccroi", function() {
        var roi = $(this).val();
        var principal = $("#ccprinciple-amount").val();

        if(!$.isNumeric(roi) || principal == ""){
            $(this).css("border","2px solid red");
            $("#ccinstallment").css("border","2px solid red");
            $("#ccinstallment").val("");
            return false;
        }else{
            $(this).css("border","");
            $("#ccinstallment").css("border","");
        }

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'ccroi': roi ,'ccprincipal': principal },
            success: function(data) {
                $("#ccinstallment").val(data);
            }
            // error: function() {
            //     alert("error");
            //   }
        });
    });

    //to calculate roi on basis of Installment amount & Principle amount
    $(document).on("keyup", "#ccinstallment", function() {
        var installment = $(this).val();
        var principal = $("#ccprinciple-amount").val();

        if(!$.isNumeric(installment) || principal == ""){
            $(this).css("border","2px solid red");
            $("#ccroi").css("border","2px solid red");
            $("#ccroi").val("");
            return false;
        }else{
            $(this).css("border","");
            $("#ccroi").css("border","");
        }

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'ccinstallment': installment ,'ccprincipal': principal },
            success: function(data) {
                $("#ccroi").val(data);
            }
        });
    });

    //to calculate roi(in ₹) on basis of roi(in %) and principal amount
    // $(document).on("keyup", "#roi", function() {
    //     var roi = $(this).val();
    //     var principal = $("#principle-amount").val();

    //     if(!$.isNumeric(roi) || principal == ""){
    //         $(this).css("border","2px solid red");
    //         $("#roir").css("border","2px solid red");
    //         $("#roir").val("");
    //         return false;
    //     }else{
    //         $(this).css("border","");
    //         $("#roir").css("border","");
    //     }

    //     $.ajax({
    //         url: '../include/ajaxphpfiles/fetch_custname.php',
    //         type: 'POST',
    //         data: { 'roi': roi ,'principal': principal },
    //         success: function(data) {
    //             $("#roir").val(data);
    //         }
    //         // error: function() {
    //         //     alert("error");
    //         //   }
    //     });
    // });

    //to calculate last date of repayment, total amount, installments on the basis of number of days, date of registration and principal amount
    $(document).on("keyup", "#days, #dorloan, #roi, #principle-amount, #ldorloan", function() {
        var dor = $("#dorloan").val();
        var days = $("#days").val();
        var loancat = $("#loancategory").val();
        var roi = $("#roi").val();
        var principal = $("#principle-amount").val();
        // alert(loancat);

        if(!$.isNumeric(days) || !$.isNumeric(roi) || !$.isNumeric(principal)){
            $("#days").css("border","2px solid red");
            $("#roi").css("border","2px solid red");
            $("#principle-amount").css("border","2px solid red");
            $("#ldorloan").css("border","2px solid red");
            $("#submit").attr("disabled", true);
            $("#submit").css("color","#ff3333");
            $("#submit").css("border","2px solid red");
            return false;
        }else{
            $("#days").css("border","");
            $("#roi").css("border","");
            $("#principle-amount").css("border","");
            $("#ldorloan").css("border","");
            $("#submit").attr("disabled", false);
            $("#submit").css("color","");
            $("#submit").css("border","");
        }

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'dor': dor ,'days': days, 'loancat': loancat, 'roi' : roi, 'principal' : principal},
            success: function(data) {
                // console.log(data);
                var data = JSON.parse(data);
                $("#ldorloan").val(data.ldorloan);
                $("#total").val(data.total);
                $("#installment").val(data.installment);
                $("#roir").val(data.roir);
            }
        });
    });

    //to calculate number of days on the basis of last date of repayment and date of registration
    $(document).on("change", "#ldorloan", function(){
        var dor = $("#dorloan").val();
        var ldorloan = $(this).val();
        var loancat = $("#loancategory").val();
        // alert(loancat);

        if(ldorloan < dor){
            $(this).css("border","2px solid red");
            $("#days").css("border","2px solid red");
            return false;
        }else{
            $(this).css("border","");
            $("#days").css("border","");
        }

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'dor': dor ,'ldorloan': ldorloan , 'loancat': loancat},
            success: function(data) {
                $("#days").val(data);
            }
        });
    });

    //on change of type of loan fields changes
    $(document).on("change", "#loancategory", function(){
        var tol = $(this).val();

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'tol': tol},
            success: function(data) {
                $("#lcdependent").html(data);
            }
        });
    });



});


  