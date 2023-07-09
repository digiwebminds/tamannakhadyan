<?php
if(isset($_GET['custid'])){
    $custid=$_GET['custid'];
    require_once("../include/connect.php");
    
    $sql = "UPDATE customers SET deleted = 1 WHERE id = $custid";
    mysqli_query($conn, $sql);
    
    echo 1;
}
if(isset($_GET['empid'])){
    $empid=$_GET['empid'];
    require_once("../include/connect.php");
    
    $sql = "UPDATE staff SET deleted = 1 WHERE id = $empid";
    mysqli_query($conn, $sql);

    echo 1;
}

if(isset($_GET['loanid'])){
    $loanid=$_GET['loanid'];
    require_once("../include/connect.php");
    
    $sql = "UPDATE loans SET delete_status = 1 WHERE id = $loanid";
    mysqli_query($conn, $sql);
    
    echo 1;
}

if(isset($_GET['clid'])){
    $clid=$_GET['clid'];
    require_once("../include/connect.php");
    
    $sql = "UPDATE loans SET status = 0 WHERE id = $clid";
    mysqli_query($conn, $sql);
    
    echo 1;
}

?>