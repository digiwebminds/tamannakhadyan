<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mrawal_tamanna_khadyan";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn)
    {
        echo "Database connection error";
    }

?>