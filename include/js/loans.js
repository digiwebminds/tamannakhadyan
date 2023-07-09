$(document).ready(function(){

    $(document).on("click", "#deleteloan", function(e) {
      e.preventDefault();
      if(confirm("Delete Loan ?") == true){
        var loanid = $(this).attr('value');
    
        $.ajax({
            url: 'delete.php',
            type: 'GET',
            data: { 'loanid': loanid },
            success: function(data) {
                if(data == 1){
                  window.location.replace("loans.php");
                }
            }
        });
      }
    });

});