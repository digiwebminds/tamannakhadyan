<?php
session_start();
if (isset($_SESSION['username'])){
    $role = $_SESSION['role'];
    if($role == 0){
      header('location:loans.php') ;
    }elseif($role == 1){
      header('location:loans.php') ;
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
    include("../include/connect.php");

    $query = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
    (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
    FROM customers AS c
    JOIN loans AS l ON c.id = l.customer_id
    LEFT JOIN repayment AS re ON l.id = re.loan_id
    WHERE l.loan_type = 1 and status = 1
    GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
    HAVING phone_count > 0";
    $result  = mysqli_query($conn, $query);
    $rowcount = mysqli_num_rows($result);
    echo '<input type="hidden" id="ccrowcount" value=' . $rowcount . '>';

    $query = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
    (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
    FROM customers AS c
    JOIN loans AS l ON c.id = l.customer_id
    LEFT JOIN repayment AS re ON l.id = re.loan_id
    WHERE l.loan_type = 2
    GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
    HAVING phone_count > 0";
    $result  = mysqli_query($conn, $query);
    $rowcount = mysqli_num_rows($result);
    echo '<input type="hidden" id="drowcount" value=' . $rowcount . '>';

    $query = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
    (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
    FROM customers AS c
    JOIN loans AS l ON c.id = l.customer_id
    LEFT JOIN repayment AS re ON l.id = re.loan_id
    WHERE l.loan_type = 3
    GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
    HAVING phone_count > 0";
    $result  = mysqli_query($conn, $query);
    $rowcount = mysqli_num_rows($result);
    echo '<input type="hidden" id="wrowcount" value=' . $rowcount . '>';

    $query = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
    (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
    FROM customers AS c
    JOIN loans AS l ON c.id = l.customer_id
    LEFT JOIN repayment AS re ON l.id = re.loan_id
    WHERE l.loan_type = 4
    GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
    HAVING phone_count > 0";
    $result  = mysqli_query($conn, $query);
    $rowcount = mysqli_num_rows($result);
    echo '<input type="hidden" id="mrowcount" value=' . $rowcount . '>';
?>
<script>
    function getresult(url) {
        if(url.indexOf("ccdueajax.php") != -1){
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    rowcount: $("#ccrowcount").val()
                },
                success: function(data) {
                    $("#ccduelistresult").html(data);
                }
            });
        }else if(url.indexOf("ddueajax.php") != -1){
            $.ajax({
            url: url,
            type: "GET",
            data: {
                rowcount: $("#drowcount").val()
            },
            success: function(data) {
                $("#dailyduelistresult").html(data);
            }
        });
        }else if(url.indexOf("wdueajax.php") != -1){
            $.ajax({
            url: url,
            type: "GET",
            data: {
                rowcount: $("#wrowcount").val()
            },
            success: function(data) {
                $("#weeklyduelistresult").html(data);
            }
        });
        }else if(url.indexOf("mdueajax.php") != -1){
            $.ajax({
            url: url,
            type: "GET",
            data: {
                rowcount: $("#mrowcount").val()
            },
            success: function(data) {
                $("#monthlyduelistresult").html(data);
            }
        });
        }
    }
    getresult("ccdueajax.php");
    getresult("ddueajax.php");
    getresult("wdueajax.php");
    getresult("mdueajax.php");
</script>
</body>
</html>