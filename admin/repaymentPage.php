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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repayment Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../include/js/repayment.js"></script>
    <script src="https://kit.fontawesome.com/0ef3c59d0f.js" crossorigin="anonymous"></script>
    <style>
  .modal {
    display: none;
  }

  .modal-overlay {
    opacity: 0.5;
    z-index: -1;
  }

  .modal-header {
    border-color: #ddd;
  }
</style>
</head>
<body>
<?php
    include "../include/navbar.php";
    date_default_timezone_set("Asia/Calcutta");
?>
<?php 
//success & error message for Emi Repayment
if(isset($_GET['smessage'])){
    $message = $_GET['smessage'];
    echo '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <span class="font-medium">'.$message.'
    </div>';
}
if(isset($_GET['emessage'])){
    echo '<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <span class="font-medium">'.$message.'</div>';
}

//for repayment
if (isset($_GET['loanid'])) {

include_once '../include/connect.php';
$loanid = $_GET['loanid'];
$sql = "SELECT c.id AS cust_id,c.sname,l.latefine,l.latefineafter, l.id,l.days_weeks_month,l.total, c.name, c.fname, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.	installment_amount) as amount_paid,
(SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.id = $loanid and l.status=1 and l.delete_status=0
GROUP BY c.id,c.sname, l.id,l.latefine,l.latefineafter, c.name, c.fname, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
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
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Loan ID </th>
        <td class="px-6 py-2 border border-gray-700">' . $loanid . '
        </td>
</tr>
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
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Father Name </th>
        <td class="px-6 py-2 border border-gray-700">' . $row['fname'] . '
        </td>
        </tr>
        <tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Shop Name </th>
        <td class="px-6 py-2 border border-gray-700">' . $row['sname'] . '
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
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> City </th>
      <td class="px-6 py-2 border border-gray-700">' . $row['city'] . '
      </td>
      </tr>';

if($loan_type==1){ 
  echo '<tr class="border-b border-gray-200 dark:border-gray-700">
  <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Loan Amount Remaining (शेष ऋण राशि)</th>
  <td class="px-6 py-2 border border-gray-700 text-gray-900">' . $remprincipal . ' &nbsp; &nbsp; |<span class="text-white bg-gray-800 p-1 mr-2"> Principal Paid : '.$row["total_principal_paid"].'</span><span class="text-white bg-gray-800 p-1"> | Initial Principal : '.$row["principle"].'</span>
  &nbsp;<a href="../include/modals/tables_modals/tables.php?loanidpri='.$loanid.'" target="_blank"><button id="openprincipalpaidtable" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">
  info
  </button></a>
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
    &nbsp;<a href="../include/modals/tables_modals/tables.php?loanidt='.$loanid.'&loantype='.$loan_type.'" target="_blank"><button id="opentotalinstallmenttablemodal" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">
    info
      </button>
    </td>
    </tr>';
  }
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Late Fine Till Date </th>
      <td class="px-6 py-2 border text-red-500 border-gray-700">';
      include_once "../include/functions.php";
      // calculating late fees
  if ($loan_type == 1){
    include_once "../include/functions.php";
    $lateFinearray = lateFineCalforCC($loanid);
    echo $lateFinesum = array_sum($lateFinearray);
    echo '&nbsp;&nbsp;&nbsp;<a href="../include/modals/tables_modals/tables.php?loanidlcc='.$loanid.'" target="_blank"><button id="openlateFineTableModalbtn" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">
    info
    </button>';
  }elseif($loan_type == 2){
    include_once "../include/functions.php";
    $lateFinearray = lateFineCalfordaily($loanid);
    echo $lateFinesum = array_sum($lateFinearray);
  }elseif($loan_type ==3){
    include_once "../include/functions.php";
    $lateFinearray = lateFineCalforweekly($loanid);
    echo $lateFinesum = array_sum($lateFinearray);
  }elseif($loan_type ==4){
    include_once "../include/functions.php";
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
      
      &nbsp;<a href="../include/modals/tables_modals/tables.php?loanidr='.$loanid.'" target="_blank"><button id="openpaidinstallmentinfo" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">
      info
      </button></a>
      </td>
      </tr>

      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> UnPaid Installments (बिना भारी किस्त)</th>
      <td class="px-6 py-2 border border-gray-700">'.$unpaidInstallments.'&nbsp<button id="openunpaidinstallmenttablemodal" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">
      info
      </button>

      </td>
      </tr>
      </tr>
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Repay Installment (किश्त चुकाएं)</th>
      <td class="px-6 py-2 border border-gray-700">
      <button id="openModalButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded">Pay Installment</button>
      </td>
      </tr>';
      if ($loan_type == 1) {
        echo '<tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Repay Principal (मूलधन चुकाएं)</th>
        <td class="px-6 py-2 border border-gray-700">
        <button id="openModalprinciplerepay" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pay Principle</button>
        </td>
        </tr>';
      }
      if ($loan_type == 1) {
        echo '<tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Give More Principal </th>
        <td class="px-6 py-2 border border-gray-700">
        <button id="openModalprinciplelend" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Give More Principle</button>
        </td>
        </tr>';
      }
      $duetilldate = ($totalInstallmentstilldate*$row['installment']-$row["amount_paid"]);
      if($loan_type !=1){
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Amount Due Till Today (बकाया ऋण आज तक)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">'.$duetilldate.'</td>
      </tr>';
      //need to change this .\// need to change this
    }


    if($loan_type == 1 ){
      echo'
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">';
      $lateFinearray = lateFineCalforCC($loanid);
      $lateFinesum = array_sum($lateFinearray);
      echo ($dueee + $lateFinesum + $remprincipal);
      echo'</td>
      </tr>';
    }elseif($loan_type == 2){
      echo'
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">';
      $lateFinearray = lateFineCalfordaily($loanid);
      $lateFinesum = array_sum($lateFinearray);
      echo ($lateFinesum + $duetilldate);
      echo'</td>
      </tr>';
    }elseif($loan_type == 3){
      echo'
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">';
      $lateFinearray = lateFineCalforweekly($loanid);
      $lateFinesum = array_sum($lateFinearray);
      echo ($lateFinesum + $duetilldate);
      echo'</td>
      </tr>';
    }else{
      echo'
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">';
      $lateFinearray = lateFineCalformonthly($loanid);
      $lateFinesum = array_sum($lateFinearray);
      echo ($lateFinesum + $duetilldate);
      echo'</td>
      </tr>';
    }
     echo '</tbody>
      </table>  
    </div>';


/// repayment modal below
include_once "../include/modals/emi_repayment_modal.php";

// repay principle modal below
include_once "../include/modals/repay_principal_modal.php";

// lend more principle modal below
include_once "../include/modals/lend_more_principal_modal.php";

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

  
}
} else {
    echo '<div class="flex p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div>
      <span class="font-medium">Loan Not Found!</span> Enter Correct LoanID !
    </div>
  </div>';
  }
}


?>
<?php
    include "../include/footer.php";
?>    
</body>
</html>