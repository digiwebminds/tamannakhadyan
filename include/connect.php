<?php
    
    $servername = "localhost";
    $username = "mrawal";
    $password = "Admin@123";
    $dbname = "mrawal_tamanna_khadyan";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn)
    {
        echo "Database connection error";
    }

?>