  $(document).ready(function(){

    $("#password").keyup(function(){
      pass_check();
    });
    $("#cpassword").keyup(function(){
      cpass_check();
    });

    function pass_check()
    {
        var passcheck = $("#password").val();

        if(passcheck.length == "")
        {
            $("#password").css("border","2px solid red");
        }
        else
        {
            $("#password").css("border","2px solid skyblue");
        }
    }

    function cpass_check()
    {
        var passcheck = $("#password").val();
        var cpasscheck = $("#cpassword").val();

        if(cpasscheck != "")
        {
            if(cpasscheck!=passcheck)
            {
                $("#password").css("border","2px solid red");
                $("#cpassword").css("border","2px solid red");
                $("#submit").attr("disabled", true);
                $("#submit").css("color","#ff3333");
                $("#submit").css("border","2px solid red");
            }
            else
            {
                $("#password").css("border","2px solid green");
                $("#cpassword").css("border","2px solid green");
                $("#submit").attr("disabled", false);
                $("#submit").css("color","");
                $("#submit").css("border","");
            }
        }        
    }

    $(document).on("click", "#deletestaff", function(e) {
      e.preventDefault();
      if(confirm("Delete Employee ?") == true){
        var empid = $(this).attr('value');
    
        $.ajax({
            url: 'delete.php',
            type: 'GET',
            data: { 'empid': empid },
            success: function(data) {
                if(data == 1){
                  window.location.replace("staffmembers.php");
                }
            }
        });
      }
    });

  });