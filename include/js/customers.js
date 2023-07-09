$(document).ready(function(){

    $(document).on("click", "#deletecust", function(e) {
      e.preventDefault();
      if(confirm("Delete Customer ?") == true){
        var custid = $(this).attr('value');
    
        $.ajax({
            url: 'delete.php',
            type: 'GET',
            data: { 'custid': custid },
            success: function(data) {
                if(data == 1){
                  window.location.replace("customers.php");
                }
            }
        });
      }
    });

});