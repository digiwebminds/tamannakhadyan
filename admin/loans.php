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
    <title>Loans</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../include/js/loans.js"></script>
</head>
<body>
    <?php
    include ("../include/navbar.php");
    ?>
<!-- Title -->
<div class="flex justify-between items-center">
    <h1 class="flex-grow bg-gray-700 text-white text-xl p-3 border-gray-800 relative">
        List of Loans
        <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 mr-3 border border-white rounded">
            <a href="add_loan.php" class="text-white">Add loan</a>
        </button>
    </h1>
</div>

<!-- Search Box -->
<span class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 my-2">
    <label for="searchvalue" class="text-gray-700 font-bold">Search</label>
    <input type="text" id="searchvalue" name="searchvalue" class="border border-gray-300 rounded px-2 py-1">
    <label for="searchby" class="text-gray-700">By</label>
    <select id="searchby" class="border border-gray-300 rounded px-2 py-1">
        <option value="1">Customer Code</option>
        <option value="2">Loan Code</option>
        <option value="3">Loan Type</option>
    </select>
    <button id="searchbutton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
</span>
<!-- Search Box -->

<div class="relative" id="pagination-result">
        <div id="overlay">
            <div><img src="../include/loading.gif" width="64px" height="64px" /></div>
        </div>
</div>

    <?php
    include("../include/connect.php");
    $query = "SELECT * FROM loans WHERE status = 1 AND delete_status = 0 ORDER BY id DESC";
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
        getresult("loanajax.php");
        $(document).ready(function(){
            $("#searchbutton").click(function(){
                $("#pagination-result").html("");
                var searchvalue = $("#searchvalue").val().trim();
                var searchby = $("#searchby").val();

                $.ajax({
                    url: 'loanajax.php',
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
            });
        });
    </script>
<!-- Footer start-->
<?php 
include "../include/footer.php"; 
?>
<!-- Footer End-->
</body>
</html>