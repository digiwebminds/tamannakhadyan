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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DashBoard</title>
    <script src="https://cdn.tailwindcss.com"></script>    
</head>
<body>
 <!--Header start-->
<?php 
include "../include/navbar.php";
?>
<!--header end-->

<!-- dashboard data -->
<!-- loan table data -->
<div class="flex items-center justify-center bg-gray-800 p-4 border-white border-2 rounded-xl">
    <div class="flex flex-col max-w-7xl w-full md:w-[70%]">
    <div class="flex flex-col lg:flex-row ">

<?php 
require_once "../include/connect.php";

$sql = "SELECT 
COUNT(id) AS total_loans,
SUM(principle) AS total_principal,
SUM(CASE WHEN loan_type = 1 THEN 1 ELSE 0 END) AS cc_loan_count,
SUM(CASE WHEN loan_type = 2 THEN 1 ELSE 0 END) AS daily_loan_count,
SUM(CASE WHEN loan_type = 3 THEN 1 ELSE 0 END) AS weekly_loan_count,
SUM(CASE WHEN loan_type = 4 THEN 1 ELSE 0 END) AS monthly_loan_count,
SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS active_loans,
SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS closed_loans,
SUM(CASE WHEN delete_status = 0 THEN 1 ELSE 0 END) AS not_deleted_loans,
SUM(CASE WHEN delete_status = 1 THEN 1 ELSE 0 END) AS deleted_loans,
SUM(CASE WHEN status = 1 THEN principle ELSE 0 END) AS sum_principal_active,
SUM(CASE WHEN loan_type != 1 THEN principle ELSE 0 END) AS sumprincipal_except_ccloan,
SUM(CASE WHEN loan_type != 1 THEN total ELSE 0 END) AS total_except_ccloan
FROM loans;";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-bold font-medium text-cyan-300 my-1">Total Loans (Active + Closed)</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.$row['total_loans'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-medium text-cyan-300 my-1">Active Loans</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.$row['active_loans'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-medium text-cyan-300 my-1">Closed Loans</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.$row['closed_loans'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-medium text-cyan-300 my-1">Loan Types </div>
            <div class="class flex items-center">
            <div class="text-sm font-bold text-gray-200">CC : </div><div class="text-sm font-bold text-gray-200">'.$row['cc_loan_count'].'</div>
            </div>
            <div class="class flex items-center">
            <div class="text-sm font-bold text-gray-200">Daily : </div><div class="text-sm font-bold text-gray-200">'.$row['daily_loan_count'].'</div>
            </div>
            <div class="class flex items-center">
            <div class="text-sm font-bold text-gray-200">Weekly : </div><div class="text-sm font-bold text-gray-200">'.$row['weekly_loan_count'].'</div>
            </div>
            <div class="class flex items-center">
            <div class="text-sm font-bold text-gray-200">Monthly : </div><div class="text-sm font-bold text-gray-200">'.$row['monthly_loan_count'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-medium text-cyan-300 my-1">Principal Given Till Date</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.$row['total_principal'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-medium text-cyan-300 my-1">Active Principal in market</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.$row['sum_principal_active'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-medium text-cyan-300 my-1">Total Interest (Except CC loan)</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.($row['total_except_ccloan']-$row['sumprincipal_except_ccloan']).'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>
';
  }
}
echo '</div>';
echo '<div class="flex flex-col lg:flex-row ">';
$sql2 = "SELECT SUM(repay_amount) as extra_principal FROM `principle_repayment`;";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0) {
  while ($row2 = mysqli_fetch_assoc($result2)) {
    echo '<div class="bg-gray-700 shadow-lg border-white border-2 rounded-xl flex items-start h-27 w-[90%] lg:w-1/4 justify-center py-2 px-2 mx-2 my-1">
    <div class="flex items-center justify-start w-full">
        <div class="flex-col w-[85%]">
            <div class="text-sm font-bold font-medium text-cyan-300 my-1">Extra PrinciPal Given</div>
            <div class="class flex items-center">
                <div class="text-xl font-bold text-gray-200">'.$row2['extra_principal'].'</div>
            </div>
            <div class="w-full h-1 rounded bg-gray-300 my-1">
                <div class="w-[100%] h-1 rounded bg-green-500"></div>
            </div>
        </div>
    </div>
</div>
';
  }
}
    ?>
        
    </div> 
    </div>
    </div>                                          
</div>
<!-- loan table data end-->

  
<!-- Footer start-->
<?php 
include "../include/footer.php"; 
?>
<!-- Footer End-->


</body>
</html>