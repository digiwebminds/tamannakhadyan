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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DueList</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../include/js/dues.js"></script>

</head>
<body>
<?php
    include "../include/navbar.php";
    date_default_timezone_set("Asia/Calcutta");
    ?>
<!-- <p>Click Button to get dues List</p> -->
<div class="mb-4 mt-4">
  <button id="ccduelistbtn" value="1" type="button" class="text-white focus:outline-none focus:ring-4 rounded font-medium text-sm px-2.5 py-2.5 text-center ml-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">CC Loan Due List</button>
  <div id="ccduelistresult"></div> <div></div>

  <button id="dailyduelistbtn" value="2" type="button" class="text-white focus:outline-none focus:ring-4 rounded font-medium text-sm px-2.5 py-2.5 text-center ml-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Daily Loan Due List</button>
  <div id="dailyduelistresult"></div> <div></div>

  <button id="weeklyduelistbtn" value="3" type="button" class="text-white focus:outline-none focus:ring-4 rounded font-medium text-sm px-2.5 py-2.5 text-center ml-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Weekly Loan Due List</button>
  <div id="weeklyduelistresult"></div> <div></div>

  <button id="monthlyduelistbtn" value="4" type="button" class="text-white focus:outline-none focus:ring-4 rounded font-medium text-sm px-2.5 py-2.5 text-center ml-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Monthly Loan Due List</button>
  <div id="monthlyduelistresult"></div> <div></div>
</div>

<?php 
    include "../include/footer.php"; 
?>
</body>
</html>