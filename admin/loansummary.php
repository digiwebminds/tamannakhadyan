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
    <title>Loan Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../include/js/loansummary.js"></script>
    <script src="https://kit.fontawesome.com/0ef3c59d0f.js" crossorigin="anonymous"></script>

</head>
<body>
<?php
    include "../include/navbar.php";
    date_default_timezone_set("Asia/Calcutta");
?>

<?php 
    
if (isset($_GET['id'])) {
    include "../include/connect.php";
    $loanid = $_GET['id'];
    $sql = "SELECT c.id AS cust_id,l.latefine,l.latefineafter, l.id,l.days_weeks_month,l.total, c.name, c.fname, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.	installment_amount) as amount_paid,
    (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
  FROM customers AS c
  JOIN loans AS l ON c.id = l.customer_id
  LEFT JOIN repayment AS re ON l.id = re.loan_id
  WHERE l.id = $loanid
  GROUP BY c.id, l.id,l.latefine,l.latefineafter, c.name, c.fname, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
  HAVING phone_count > 0";
  
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $loan_type = $row['loan_type'];
  
        $startDate = strtotime($row['dor']);
        $today = strtotime(date('Y-m-d'));
        if ($loan_type == 1) {
          $loanname = 'CC Loan';
          $frequency = 1;
        } elseif ($loan_type == 2) {
          $loanname = 'Daily Loan';
          $frequency = 1;
        } elseif ($loan_type == 3) {
          $loanname = 'Weekly Loan';
          $frequency = 7;
        } else {
          $loanname = 'Monthly Loan';
          $frequency = 30;
        }
  
        $totalInstallmentstilldate = floor(($today - $startDate) / (60 * 60 * 24 * $frequency)); //have to change this
        $currentDate = $startDate;
        $paidInstallments = $row['emi_count'];
        $unpaidInstallments = $totalInstallmentstilldate - $paidInstallments;
  
        $remprincipal = $row['principle']- $row["total_principal_paid"];
        $reminstallmentamount = $remprincipal*($row["roi"]/100);
  
        echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-1">
    <table class="w-full text-sm text-left font-bold text-gray-500 dark:text-gray-900">
    <tbody>
    <tr class="border-b border-gray-200 dark:border-gray-700">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Loan Type </th>
          <td class="px-6 py-2 border border-gray-700">' . $loanname . '
          </td>
        </tr>
  
    <tr class="border-b border-gray-200 dark:border-gray-700">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Name </th>
          <td class="px-6 py-2 border border-gray-700">' . $row['name'] . '
          </td>
        </tr>
        <tr class="border-b border-gray-200 dark:border-gray-700">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Loan Start Date </th>
          <td class="px-6 py-2 border border-gray-700">' . $row['dor'] . '
          </td>
        </tr>';
        if($loan_type != 1 ){
          echo '<tr class="border-b border-gray-200 dark:border-gray-700">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> End Date </th>
          <td class="px-6 py-2 border border-gray-700">' . $row['ldol'] . '
          </td>
          </tr>';
        }
        echo '<tr class="border-b border-gray-200 dark:border-gray-700">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Father Name </th>
          <td class="px-6 py-2 border border-gray-700">' . $row['fname'] . '
          </td>
          </tr>
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> City </th>
        <td class="px-6 py-2 border border-gray-700">' . $row['city'] . '
        </td>
        </tr>';
  
  if($loan_type==1){ 
    echo '<tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Loan Amount Remaining (शेष ऋण राशि)</th>
    <td class="px-6 py-2 border border-gray-700 text-gray-900">' . $remprincipal . ' &nbsp; &nbsp; | Principal Paid : '.$row["total_principal_paid"].' , Initial Principal : '.$row["principle"].'
  
    &nbsp;<button id="openprincipalpaidtable" class="text-black font-bold py-2 px-4 rounded">
    <i class="fa-solid fa-circle-info"></i>
    </button>
  
    </td>
    </tr>';
  }else {
    echo '<tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Loan Amount (ऋण की राशि)</th>
    <td class="px-6 py-2 border border-gray-700 text-gray-900">'.$row["principle"].'
    </td>
    </tr>';
  }
    if($loan_type == 1){
      
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Installment Amount (किस्त की राशि)</th>
      <td class="px-6 py-2 border border-gray-700">' . $reminstallmentamount . '
      </td>
      </tr>';
    }else{
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Installment Amount (किस्त की राशि)</th>
      <td class="px-6 py-2 border border-gray-700">' . $row['installment'] . '
      </td>
      </tr>';
    }
    if($loan_type == 1){
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Interest Due Till Today (बकाया ऋण आज तक)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-500">';
      include_once "../include/functions.php";
      $dueee = totalEmiAmountDue_in_CCloan($loanid);
      echo $dueee ;
      echo'
      </td>
      </tr>';
    }
    if($loan_type == 1){
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Amount Due (कुल शेष राशि) (P+I)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-500">';
      echo ($dueee + $remprincipal);
      echo '</td>
      </tr>';
    }else{
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Amount (P+I)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-500">'.$row['total'].'</td>
      </tr>';
    }
  
    if($loan_type != 1){
      
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Total Installment (कुल किश्त)</th>
      <td class="px-6 py-2 border border-gray-700">' . $row['days_weeks_month'] . '
  
      &nbsp;<button id="opentotalinstallmenttablemodal" class="text-black font-bold py-2 px-4 rounded">
        <i class="fa-solid fa-circle-info"></i>
        </button>
      </td>
      </tr>';
    }
        echo '<tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Late Fine Till Date </th>
        <td class="px-6 py-2 border text-red-500 border-gray-700">';
        include_once "../include/functions.php";
        $lateFinearray = lateFineCalforCC_daily($loanid);
        $lateFinesum = array_sum($lateFinearray);
        // calculating late fees
    if ($loan_type == 1){
      $lateFinearray = lateFineCalforCC_daily($loanid);
      echo $lateFinesum = array_sum($lateFinearray);
      echo '&nbsp;<button id="openlateFineTableModalbtn" class="text-black font-bold py-2 px-4 rounded">
      <i class="fa-solid fa-circle-info"></i>
      </button>';
    }elseif($loan_type == 2){
      $lateFinearray = lateFineCalforCC_daily($loanid);
      echo $lateFinesum = array_sum($lateFinearray);
    }elseif($loan_type ==3){
      $lateFinearray = lateFineCalforweekly($loanid);
      echo $lateFinesum = array_sum($lateFinearray);
    }elseif($loan_type ==4){
      $lateFinearray = lateFineCalformonthly($loanid);
      echo $lateFinesum = array_sum($lateFinearray);
    }
        echo'</td>
        </tr>
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Total Installment Till Today (आज तक की कुल किश्त)</th>
        <td class="px-6 py-2 border border-gray-700">'. $totalInstallmentstilldate .'
        </td>
        </tr>
  
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Paid Installments & Amount (भारी किस्त और राशि)</th>
        <td class="px-6 py-2 border border-gray-700">'.$paidInstallments.'&nbsp;( Paid Amount: '. $row["amount_paid"].')
        
        &nbsp;<button id="openpaidinstallmentinfo" class="text-black font-bold py-2 px-4 rounded">
        <i class="fa-solid fa-circle-info"></i>
        </button>
        </td>
        </tr>
  
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> UnPaid Installments (बिना भारी किस्त)</th>
        <td class="px-6 py-2 border border-gray-700">'.$unpaidInstallments.'&nbsp;<button id="openunpaidinstallmenttablemodal" class="text-black font-bold py-2 px-4 rounded">
        <i class="fa-solid fa-circle-info"></i>
        </button>
  
        </td>
        </tr>
        </tr>';

        if($loan_type !=1){
        echo '<tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Amount Due Till Today (बकाया ऋण आज तक)</th>
        <td class="px-6 py-2 border border-gray-700 text-red-900">' .$unpaidInstallments*$row['installment']. '
        </td>
        </tr>';
        //need to change this .\// need to change this
      }
  
  
      if($loan_type == 1 ){
        echo'
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
        <td class="px-6 py-2 border border-gray-700 text-red-900">';
        $lateFinearray = lateFineCalforCC_daily($loanid);
        $lateFinesum = array_sum($lateFinearray);
        echo ($dueee + $lateFinesum + $remprincipal);
        echo'</td>
        </tr>';
      }elseif($loan_type == 2){
        echo'
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
        <td class="px-6 py-2 border border-gray-700 text-red-900">';
        $lateFinearray = lateFineCalforCC_daily($loanid);
        $lateFinesum = array_sum($lateFinearray);
        echo ($lateFinesum + ($unpaidInstallments*$row['installment']));
        echo'</td>
        </tr>';
      }elseif($loan_type == 3){
        echo'
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
        <td class="px-6 py-2 border border-gray-700 text-red-900">';
        $lateFinearray = lateFineCalforweekly($loanid);
        $lateFinesum = array_sum($lateFinearray);
        echo ($lateFinesum + ($unpaidInstallments*$row['installment']));
        echo'</td>
        </tr>';
      }else{
        echo'
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
        <td class="px-6 py-2 border border-gray-700 text-red-900">';
        $lateFinearray = lateFineCalformonthly($loanid);
        $lateFinesum = array_sum($lateFinearray);
        echo ($lateFinesum + ($unpaidInstallments*$row['installment']));
        echo'</td>
        </tr>';
      }
  
  
       echo '</tbody>
        </table>  
  </div>';

  echo '<button type="button" id="viewallemi" class="text-black bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Click Here to View all EMI</button>';

  //paid installments table modal here
include_once "../include/modals/tables_modals/paid_emi_table_modal.php";

//paid principal table modal here
include_once "../include/modals/tables_modals/principal_lend_paid_table.php";

//unpaid Emi tilldate table modal here
include_once "../include/modals/tables_modals/unpaid_emi_table.php";

//Total EMI with date table modal here
include_once "../include/modals/tables_modals/total_emi_table.php";

// LateFineTable modal here
include_once "../include/modals/tables_modals/lateFineWithDates.php";


//Total EMI with date table modal here


echo '<div id="toggleemitable">
<div class="relative overflow-x-auto mt-2 mb-4">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-medium uppercase bg-gray-700 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            S.No.
                         </th>
                        <th scope="col" class="px-6 py-3">
                            Date of Loan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Installment Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Comment
                        </th>
                    </tr>
                </thead>
                <tbody>';


require_once "../include/connect.php";
if($loan_type == 1){

  // Fetch loan start date and last date from the loans table
  $sql4 = "SELECT dor, ldol FROM loans WHERE id =$loanid";
  $result4 = mysqli_query($conn, $sql4);
  
  $row4 = mysqli_fetch_assoc($result4);
  
  $loanStartDate = $row4['dor'];
  $loanLastDate = $row4['ldol'];
  
  
  // Fetch installment payment dates from the repayment table
  $sql5 = "SELECT DORepayment,installment_amount,comment_repay FROM repayment WHERE loan_id = $loanid";
  $result5 = mysqli_query($conn, $sql5);
  $paidDates = [];
  while ($row5 = mysqli_fetch_assoc($result5)) {
  $paidDates[] = $row5['DORepayment'];
  }
  
  // Calculate the missing payment dates
  $startDate = strtotime($loanStartDate);
  $startDate += 86400;   // adding 1 days to start days to exclude loan given date 
  $endDate = strtotime($loanLastDate);
  // $enddate2 = $endDate + 86400; // adding 1 day to include last date
  $alldates = [];
  
  $missingDates = array();
  $currentDate = $startDate;
  //calculating the all emi dates
  while ($currentDate <= time()){
    $date = date('Y-m-d', $currentDate);
    $alldates[$date] = 'Pending'; // Set initial status as 'Pending'
    $currentDate = strtotime('+1 day', $currentDate);

  }
  
  // Mark paid dates as 'Paid'
  foreach ($paidDates as $date) {
  if (array_key_exists($date, $alldates)) {
    $alldates[$date] = 'Paid';
  }
  }
  // Display all payment dates with Status
  $i = 1;
  foreach ($alldates as $date => $status) {
  $sql6 = "SELECT installment_amount, comment_repay FROM repayment WHERE loan_id = $loanid AND DORepayment = '$date'";
  $result6 = mysqli_query($conn, $sql6);
  $row6 = mysqli_fetch_assoc($result6);
  
  if ($row6) {
    $installmentAmount = $row6['installment_amount'];
    $commentRepay = $row6['comment_repay'];
  } else {
    $installmentAmount = "Not Paid Yet";
    $commentRepay = "Not Paid Yet";
  }

  echo '<tr class="border-b bg-gray-800 border-gray-700">
  <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap ">'. $i++ .' </th>
  <td class="px-6 py-4">'.$date.'</td>';
  if($status == 'Pending'){
    echo '<td class="px-6 py-4 text-red-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-red-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-red-400 font-bold">'.$commentRepay.'</td>
    </tr>';
  }elseif($status == 'Paid'){
    echo '<td class="px-6 py-4 text-green-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-green-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-green-400 font-bold">'.$commentRepay.'</td>
    </tr>';
  }
  
  }
  }elseif($loan_type == 2){

// Fetch loan start date and last date from the loans table
$sql4 = "SELECT dor, ldol FROM loans WHERE id =$loanid";
$result4 = mysqli_query($conn, $sql4);

$row4 = mysqli_fetch_assoc($result4);

$loanStartDate = $row4['dor'];
$loanLastDate = $row4['ldol'];


// Fetch installment payment dates from the repayment table
$sql5 = "SELECT DORepayment FROM repayment WHERE loan_id = $loanid";
$result5 = mysqli_query($conn, $sql5);
$paidDates = [];
while ($row5 = mysqli_fetch_assoc($result5)) {
$paidDates[] = $row5['DORepayment'];
}

// Calculate the missing payment dates
$startDate = strtotime($loanStartDate);
$startDate += 86400;   // adding 1 days to start days to exclude loan given date 
$endDate = strtotime($loanLastDate);
// $enddate2 = $endDate + 86400; // adding 1 day to include last date
$alldates = [];

$missingDates = array();
$currentDate = $startDate;
//calculating the all emi dates
while ($currentDate <= $endDate){
if($currentDate > time()){
  $date = date('Y-m-d', $currentDate);
$alldates[$date] = 'Coming'; // Set initial status as 'Pending'
$currentDate = strtotime('+1 day', $currentDate);
}else{
  $date = date('Y-m-d', $currentDate);
  // $alldates[] = $date;
  $alldates[$date] = 'Pending'; // Set initial status as 'Pending'
  $currentDate = strtotime('+1 day', $currentDate);
}
}

// Mark paid dates as 'Paid'
foreach ($paidDates as $date) {
if (array_key_exists($date, $alldates)) {
  $alldates[$date] = 'Paid';
}
}
// Display all payment dates with Status
$i = 1;
foreach ($alldates as $date => $status) {
// echo $date . "<br>";
$sql6 = "SELECT installment_amount, comment_repay FROM repayment WHERE loan_id = $loanid AND DORepayment = '$date'";
$result6 = mysqli_query($conn, $sql6);
$row6 = mysqli_fetch_assoc($result6);

if ($row6) {
  $installmentAmount = $row6['installment_amount'];
  $commentRepay = $row6['comment_repay'];
} else {
  $installmentAmount = "Not Paid Yet";
  $commentRepay = "Not Paid Yet";
}

echo '<tr class="border-b bg-gray-800 border-gray-700">
<th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap ">'. $i++ .' </th>
<td class="px-6 py-4">'.$date.'</td>';
if($status == 'Pending'){
  echo '<td class="px-6 py-4 text-red-400 font-bold">'.$status.'</td>
  <td class="px-6 py-4 text-red-400 font-bold">'.$installmentAmount.'</td>
  <td class="px-6 py-4 text-red-400 font-bold">'.$commentRepay.'</td>
  </tr>';
}elseif($status == 'Coming'){
  echo '<td class="px-6 py-4 text-yellow-400 font-bold">'.$status.'</td>
  <td class="px-6 py-4 text-yellow-400 font-bold">'.$installmentAmount.'</td>
  <td class="px-6 py-4 text-yellow-400 font-bold">'.$commentRepay.'</td></tr>';
}elseif($status == 'Paid'){
  echo '<td class="px-6 py-4 text-green-400 font-bold">'.$status.'</td>
  <td class="px-6 py-4 text-green-400 font-bold">'.$installmentAmount.'</td>
  <td class="px-6 py-4 text-green-400 font-bold">'.$commentRepay.'</td></tr>';
}

}
}elseif($loan_type ==3){
// Fetch loan start date and last date from the loans table
$sql4 = "SELECT dor, ldol FROM loans WHERE id =$loanid";
$result4 = mysqli_query($conn, $sql4);

$row4 = mysqli_fetch_assoc($result4);

$loanStartDate = $row4['dor'];
$loanLastDate = $row4['ldol'];


// Fetch installment payment dates from the repayment table
$sql5 = "SELECT DORepayment FROM repayment WHERE loan_id = $loanid";
$result5 = mysqli_query($conn, $sql5);
$paidDates = [];
while ($row5 = mysqli_fetch_assoc($result5)) {
$paidDates[] = $row5['DORepayment'];
}

// Calculate the missing payment dates
$startDate = strtotime($loanStartDate);
$startDate += 86400*7;   // adding 1 days to start days to exclude loan given date 
$endDate = strtotime($loanLastDate);
// $enddate2 = $endDate + 86400; // adding 1 day to include last date
$alldates = [];

$missingDates = array();
$currentDate = $startDate;
//calculating the all emi dates
while ($currentDate <= $endDate){
if($currentDate > time()){
  $date = date('Y-m-d', $currentDate);
$alldates[$date] = 'Coming'; // Set initial status as 'Pending'
$currentDate = strtotime('+7 day', $currentDate);
}else{
  $date = date('Y-m-d', $currentDate);
  // $alldates[] = $date;
  $alldates[$date] = 'Pending'; // Set initial status as 'Pending'
  $currentDate = strtotime('+7 day', $currentDate);
}
}

// Mark paid dates as 'Paid'
foreach ($paidDates as $date) {
if (array_key_exists($date, $alldates)) {
  $alldates[$date] = 'Paid';
}
}
// Display all payment dates with Status
$i = 1;
foreach ($alldates as $date => $status) {
  // echo $date . "<br>";
  $sql6 = "SELECT installment_amount, comment_repay FROM repayment WHERE loan_id = $loanid AND DORepayment = '$date'";
  $result6 = mysqli_query($conn, $sql6);
  $row6 = mysqli_fetch_assoc($result6);
  
  if ($row6) {
    $installmentAmount = $row6['installment_amount'];
    $commentRepay = $row6['comment_repay'];
  } else {
    $installmentAmount = "Not Paid Yet";
    $commentRepay = "Not Paid Yet";
  }
  
  echo '<tr class="border-b bg-gray-800 border-gray-700">
  <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap ">'. $i++ .' </th>
  <td class="px-6 py-4">'.$date.'</td>';
  if($status == 'Pending'){
    echo '<td class="px-6 py-4 text-red-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-red-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-red-400 font-bold">'.$commentRepay.'</td>
    </tr>';
  }elseif($status == 'Coming'){
    echo '<td class="px-6 py-4 text-yellow-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-yellow-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-yellow-400 font-bold">'.$commentRepay.'</td></tr>';
  }elseif($status == 'Paid'){
    echo '<td class="px-6 py-4 text-green-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-green-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-green-400 font-bold">'.$commentRepay.'</td></tr>';
  }
  
  }
}elseif($loan_type == 4){
// Fetch loan start date and last date from the loans table
$sql4 = "SELECT dor, ldol FROM loans WHERE id =$loanid";
$result4 = mysqli_query($conn, $sql4);

$row4 = mysqli_fetch_assoc($result4);

$loanStartDate = $row4['dor'];
$loanLastDate = $row4['ldol'];


// Fetch installment payment dates from the repayment table
$sql5 = "SELECT DORepayment FROM repayment WHERE loan_id = $loanid";
$result5 = mysqli_query($conn, $sql5);
$paidDates = [];
while ($row5 = mysqli_fetch_assoc($result5)) {
$paidDates[] = $row5['DORepayment'];
}

// Calculate the missing payment dates
$startDate = strtotime($loanStartDate);
$startDate += 86400*30;   // adding 1 days to start days to exclude loan given date 
$endDate = strtotime($loanLastDate);
// $enddate2 = $endDate + 86400; // adding 1 day to include last date
$alldates = [];

$missingDates = array();
$currentDate = $startDate;
//calculating the all emi dates
while ($currentDate <= $endDate){
if($currentDate > time()){
  $date = date('Y-m-d', $currentDate);
$alldates[$date] = 'Coming'; // Set initial status as 'Pending'
$currentDate = strtotime('+30 day', $currentDate);
}else{
  $date = date('Y-m-d', $currentDate);
  // $alldates[] = $date;
  $alldates[$date] = 'Pending'; // Set initial status as 'Pending'
  $currentDate = strtotime('+30 day', $currentDate);
}
}

// Mark paid dates as 'Paid'
foreach ($paidDates as $date) {
if (array_key_exists($date, $alldates)) {
  $alldates[$date] = 'Paid';
}
}
// Display all payment dates with Status
$i = 1;
foreach ($alldates as $date => $status) {
  // echo $date . "<br>";
  $sql6 = "SELECT installment_amount, comment_repay FROM repayment WHERE loan_id = $loanid AND DORepayment = '$date'";
  $result6 = mysqli_query($conn, $sql6);
  $row6 = mysqli_fetch_assoc($result6);
  
  if ($row6) {
    $installmentAmount = $row6['installment_amount'];
    $commentRepay = $row6['comment_repay'];
  } else {
    $installmentAmount = "Not Paid Yet";
    $commentRepay = "Not Paid Yet";
  }
  
  echo '<tr class="border-b bg-gray-800 border-gray-700">
  <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap ">'. $i++ .' </th>
  <td class="px-6 py-4">'.$date.'</td>';
  if($status == 'Pending'){
    echo '<td class="px-6 py-4 text-red-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-red-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-red-400 font-bold">'.$commentRepay.'</td>
    </tr>';
  }elseif($status == 'Coming'){
    echo '<td class="px-6 py-4 text-yellow-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-yellow-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-yellow-400 font-bold">'.$commentRepay.'</td></tr>';
  }elseif($status == 'Paid'){
    echo '<td class="px-6 py-4 text-green-400 font-bold">'.$status.'</td>
    <td class="px-6 py-4 text-green-400 font-bold">'.$installmentAmount.'</td>
    <td class="px-6 py-4 text-green-400 font-bold">'.$commentRepay.'</td></tr>';
  }
  
  }

}
echo'</tbody>
</table>
</div>
</div>
</div>
</div>
</div>';

}
}
}
?>


<?php 
    include "../include/footer.php"; 
?>
</body>
</html>