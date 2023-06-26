
$(document).ready(function () {
    //will change ir latter
    $("#loanidsearchbutton").click(function (e) {
        e.preventDefault();

        var loanid = $("#search-loanid").val();
        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'loanid': loanid },
            success: function (data) {
                $("#loaninfo").html(data);
            }
        });
    });



    // Open the modal when the button is clicked
    $(document).on('click', '#openModalButton', function () {
        // Open the modal
        $("#myModal").removeClass("hidden");
    });

    // Close the modal when the close button or outside modal area is clicked
    $(document).on('click', '.close, .modal-overlay', function () {
        // Open the modal
        $("#myModal").addClass("hidden");
    });

    // Prevent modal from closing when the modal content is clicked
    $(document).on('click', '.modal-content', function (e) {
        // Open the modal
        e.stopPropagation();
    });

    // Prevent modal from closing on submit button click
    $(document).on('click', '#submitButton', function (e) {
        // Open the modal
        e.preventDefault();
    });




    //repayment installment entry 

    $(document).on('click', '#repaysubmitbtnn', function (e) {
        e.preventDefault();
        var dorepay = $("#dorepay").val();
        var loan_id = $("#loan_id").val();
        var installmentamt = $("#install-amount").val();
        var comment = $("#comment_repay").val();

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'dorepay': dorepay, 'loan_id': loan_id, 'installmentamt': installmentamt,'comment': comment},
            success: function (data) {
                $("#repaymentalert").html(data);
                window.setTimeout(function(){
                    $("#myModal").addClass("hidden");
                }, 2000);
            }
        });
    })

    //principle repayment installment entry 
    $(document).on('click', '#repay-principle-submitbtnn', function (e) {
        e.preventDefault();
        var dorepay = $("#dorepay-principal").val();
        var loan_id = $("#loan_id").val();
        var principleamt = $("#principle-amount-repay").val();
        var comment = $("#comment_prirepay").val();

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'dorepay': dorepay, 'loan_id': loan_id, 'principleamt': principleamt,'comment': comment},
            success: function (data) {
                $("#principlerepayalert").html(data);
                window.setTimeout(function(){
                    $("#myModalrepayprinciple").addClass("hidden");
                }, 2000);
            }
        });
    })


    // this is for modalrepayment PRINCIPLE

    // Open the modal when the button is clicked
    $(document).on('click', '#openModalprinciplerepay', function () {
        // Open the modal
        $("#myModalrepayprinciple").removeClass("hidden");
    });

    // Close the modal when the close button or outside modal area is clicked
    $(document).on('click', '.close, .modal-overlay', function () {
        // Open the modal
        $("#myModalrepayprinciple").addClass("hidden");
    });

    // Prevent modal from closing when the modal content is clicked
    $(document).on('click', '.modal-content', function (e) {
        // Open the modal
        e.stopPropagation();
    });

    // Prevent modal from closing on submit button click
    $(document).on('click', '#repayprinciplesubmitbtnn', function (e) {
        // Open the modal
        e.preventDefault();
    });


    //principle lend more entry 

    $(document).on('click', '#lend-principle-submitbtnn', function (e) {
        e.preventDefault();
        var dorepayl = $("#dorepay-principall").val();
        var loan_id = $("#loan_idl").val();
        var principleamtl = $("#principle-amount-repayl").val();
        var commentl = $("#comment_prirepayl").val();

        $.ajax({
            url: '../include/ajaxphpfiles/fetch_custname.php',
            type: 'POST',
            data: { 'dorepayl': dorepayl, 'loan_id': loan_id, 'principleamtl': principleamtl,'commentl': commentl},
            success: function (data) {
                $("#principlelendalert").html(data);
                // window.setTimeout(function(){
                //     $("#myModallendprinciple").addClass("hidden");
                // }, 2000);
            }
        });
    })


    // this is for modal for Lend More PRINCIPLE

      // Open the modal when the button is clicked
      $(document).on('click', '#openModalprinciplelend', function () {
        // Open the modal
        $("#myModallendprinciple").removeClass("hidden");
    });

    // Close the modal when the close button or outside modal area is clicked
    $(document).on('click', '.close, .modal-overlay', function () {
        // Open the modal
        $("#myModallendprinciple").addClass("hidden");
    });

    // Prevent modal from closing when the modal content is clicked
    $(document).on('click', '.modal-content', function (e) {
        // Open the modal
        e.stopPropagation();
    });

    // Prevent modal from closing on submit button click
    $(document).on('click', '#lendprinciplesubmitbtnn', function (e) {
        // Open the modal
        e.preventDefault();
    });




    //all jquery for installment info modal


    $(document).on('click','#openpaidinstallmentinfo', function(){
      $('#paidinstallmentModal').removeClass('hidden');

    })

    $(document).on('click','#closeInstallmentinfoModal', function(){
      $('#paidinstallmentModal').addClass('hidden');
      })



      //all jquery for principal table modal

    $(document).on('click','#openprincipalpaidtable', function(){
      $('#paidprincipaltableModal').removeClass('hidden');

    })

    $(document).on('click','#closeprincipaltableModal', function(){
      $('#paidprincipaltableModal').addClass('hidden');
      })

    //all jquery for unpaid installment table modal

    $(document).on('click','#openunpaidinstallmenttablemodal', function(){
        $('#unpaidinstallmenttableModal').removeClass('hidden');
      })
  
    $(document).on('click','#closeunpaidinstallmenttableModal', function(){
        $('#unpaidinstallmenttableModal').addClass('hidden');
        })


     //all jquery for total installment table modal

    $(document).on('click','#opentotalinstallmenttablemodal', function(){
        $('#totalinstallmenttableModal').removeClass('hidden');
   })
  
    $(document).on('click','#closetotalinstallmenttableModal', function(){
        $('#totalinstallmenttableModal').addClass('hidden');
        })




  

});


