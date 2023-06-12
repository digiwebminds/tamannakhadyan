<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tamanna_khadyan";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn)
    {
        echo "Database connection error";
    }

?>