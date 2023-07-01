<?php
session_start();
if (!isset($_SESSION['username'])){
    header('location:adminlogin.php');
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