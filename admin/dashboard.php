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
    <title>Admin DashBoard</title>
    <script src="https://cdn.tailwindcss.com"></script>    
</head>
<body>
 <!--Header start-->
<?php 
include "../include/navbar.php";
?>
<!--header end-->
  
<!-- Footer start-->
<?php 
include "../include/footer.php"; 
?>
<!-- Footer End-->


</body>
</html>