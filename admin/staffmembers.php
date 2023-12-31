<?php
session_start();
if (isset($_SESSION['username'])){
    $role = $_SESSION['role'];
    if($role == 0){
      header('location:loans.php') ;
    }elseif($role == 1){
      header('location:loans.php') ;
    }elseif($role == 2){
    //   header('location:dashboard.php') ;
    }
}else{
      header('location: ../index.php');
}

if(time() - $_SESSION['logintime'] > 600) { //subtract new timestamp from the old one
    unset($_SESSION['username'], $_SESSION['logintime']);
    // $_SESSION['logged_in'] = false;
    header("Location:../index.php"); //redirect to index.php
    exit;
  } else {
    $_SESSION['logintime'] = time(); //set new timestamp
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <title>Staff Members</title>
    <script src="../include/js/add_staff.js"></script>
</head>

<body>
    <?php
        include "../include/navbar.php";
    ?>
    <!-- Title -->
    <div class="flex justify-between items-center">
        <h1 class="flex-grow bg-gray-700 text-white text-xl p-3 border-gray-800 relative">
            List of Employees
            <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 mr-3 border border-white rounded">
                <a href="add_staff.php" class="text-white">Add Employee</a>
            </button>
        </h1>
    </div>

    <div class="relative" id="pagination-result">
        <div id="overlay">
            <div><img src="../include/loading.gif" width="64px" height="64px" /></div>
        </div>

    </div>

    <?php
    include("../include/connect.php");
    $query = "SELECT * FROM staff WHERE deleted = 0";
    $result  = mysqli_query($conn, $query);
    $rowcount = mysqli_num_rows($result);
    echo '<input type="hidden" name="rowcount" id="rowcount" value=' . $rowcount . '>';
    ?>
    
    <script>
        function getresult(url) {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    rowcount: $("#rowcount").val()
                },
                beforeSend: function() {
                    $("#overlay").show();
                },
                success: function(data) {
                    $("#pagination-result").html(data);
                    setInterval(function() {
                        $("#overlay").hide();
                    }, 500);
                }
            });
        }
        getresult("staffajax.php");
    </script>

    <?php 
        include "../include/footer.php"; 
    ?>

</body>

</html>