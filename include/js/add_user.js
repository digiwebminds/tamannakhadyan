tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a"}
        }
      },
      fontFamily: {
        'body': [
      'Inter', 
      'ui-sans-serif', 
      'system-ui', 
      '-apple-system', 
      'system-ui', 
      'Segoe UI', 
      'Roboto', 
      'Helvetica Neue', 
      'Arial', 
      'Noto Sans', 
      'sans-serif', 
      'Apple Color Emoji', 
      'Segoe UI Emoji', 
      'Segoe UI Symbol', 
      'Noto Color Emoji'
    ],
        'sans': [
      'Inter', 
      'ui-sans-serif', 
      'system-ui', 
      '-apple-system', 
      'system-ui', 
      'Segoe UI', 
      'Roboto', 
      'Helvetica Neue', 
      'Arial', 
      'Noto Sans', 
      'sans-serif', 
      'Apple Color Emoji', 
      'Segoe UI Emoji', 
      'Segoe UI Symbol', 
      'Noto Color Emoji'
    ]
      }
    }
  }

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
        else if(passcheck.length < 8)
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

  });