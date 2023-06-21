<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:adminlogin.php');
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
    <button href="add_user.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 my-1 border border-blue-700 rounded"><a href="add_user.php">Add User</a></button>

    <div class="bg-purple-500 item-center text-white font-bold text-xl p-3 border-gray-800 rounded">
        <h1>List of Customers</h1>
    </div>
    <span>
        <label for="searchvalue">Search</label>
        <input type="text" id="searchvalue" name="searchvalue">
        <label for="searchby">By</label>
        <select id="searchby">
            <option value="1">Customer Code</option>
            <option value="2">Cust. Name</option>
            <option value="3">Mobile No.</option>
            <option value="4">Shop Name</option>
        </select>
        <button id="searchbutton">Search</button>
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