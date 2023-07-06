<?php
if(isset($_GET['id'])){
    $id=$_GET['id'];
    require_once("../include/connect.php");
    
    $sql = "UPDATE customers SET deleted = 1 WHERE id = $id";
    mysqli_query($conn, $sql);
    
    header("Location: customers.php");
}
if(isset($_GET['sid'])){
    $sid=$_GET['sid'];
    require_once("../include/connect.php");
    
    $sql = "UPDATE staff SET deleted = 1 WHERE id = $sid";
    mysqli_query($conn, $sql);
    
    header("Location: staffmembers.php");
}

if(isset($_GET['lid'])){
    $lid=$_GET['lid'];
    echo $lid;
    require_once("../include/connect.php");
    
    $sql = "UPDATE loans SET delete_status = 1 WHERE id = $lid";
    mysqli_query($conn, $sql);
    
    header("Location: loans.php");
}

?>