<?php
session_start();
if (isset($_SESSION['username'])){
    $role = $_SESSION['role'];
    if($role == 0){
    //   header('location:loans.php') ;
    }elseif($role == 1){
    //   header('location:loans.php') ;
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

    <title>Customers</title>
    <script src="../include/js/add_user.js"></script>
</head>

<body>
    <?php
    include "../include/navbar.php";
    ?>
<!-- Title -->
<div class="flex justify-between items-center">
    <h1 class="flex-grow bg-gray-700 text-white text-xl p-3 border-gray-800 relative">
        List of Customers
        <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 mr-3 border border-white rounded">
            <a href="add_user.php" class="text-white">Add Customer</a>
        </button>
    </h1>
</div>
<!-- Search Box -->
    <span class="flex items-center space-x-2 my-2">
    <label for="searchvalue" class="text-gray-700 font-bold">Search</label>
    <input type="text" id="searchvalue" name="searchvalue" class="border border-gray-300 rounded px-2 py-1">
    <label for="searchby" class="text-gray-700">By</label>
    <select id="searchby" class="border border-gray-300 rounded px-2 py-1">
        <option value="1">Customer Code</option>
        <option value="2">Cust. Name</option>
        <option value="3">Mobile No.</option>
        <option value="4">Shop Name</option>
    </select>
    <button id="searchbutton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
</span>


    <div class="relative" id="pagination-result">
        <div id="overlay">
            <div><img src="../include/loading.gif" width="64px" height="64px" /></div>
        </div>

    </div>

    <?php
    include("../include/connect.php");
    $query = "SELECT * FROM customers WHERE deleted = 0";
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
        getresult("custajax.php");
        $(document).ready(function(){
            $("#searchbutton").click(function(){
                $("#pagination-result").html("");
                var searchvalue = $("#searchvalue").val().trim();
                var searchby = $("#searchby").val();

                $.ajax({
                    url: 'custajax.php',
                    type: 'GET',
                    data: { 'searchvalue': searchvalue, 'searchby' : searchby },
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
                // console.log(searchby+searchvalue);
            });
        });
    </script>


</body>

</html>