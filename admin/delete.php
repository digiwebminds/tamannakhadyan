<?php
$id=$_GET['id'];
require_once("../include/connect.php");

$sql = "UPDATE customers SET deleted = 1 WHERE id = $id";
mysqli_query($conn, $sql);

header("Location: customers.php");
?>