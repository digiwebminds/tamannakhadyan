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

$sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name, c.fname, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.	installment_amount) as amount_paid,
(SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.id = $loanid
GROUP BY c.id, l.id, c.name, c.fname, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
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
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Start Date </th>
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
<td class="px-6 py-2 border border-gray-700 text-gray-900">' . $remprincipal . ' &nbsp; &nbsp; &nbsp; | Principal Paid :- '.$row["total_principal_paid"].' | Total Principal :- '.$row["principle"].'

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

echo '<tr class="border-b border-gray-200 dark:border-gray-700">
<th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Amount Due (कुल शेष राशि)</th>
<td class="px-6 py-2 border border-gray-700 text-red-900">'.$row["total"].'
</td>
</tr>';

if($loan_type != 1){
  
  echo '<tr class="border-b border-gray-200 dark:border-gray-700">
  <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Total Installment (कुल किश्त)</th>
  <td class="px-6 py-2 border border-gray-700">' . $row['days_weeks_month'] . '
  </td>
  </tr>';
}


    echo '<tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Total Installment Till Today (आज तक की कुल किश्त)</th>
    <td class="px-6 py-2 border border-gray-700">'. $totalInstallmentstilldate .'
    </td>
    </tr>

    <tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Paid Installments & Amount (भारी किस्त और राशि)</th>
    <td class="px-6 py-2 border border-gray-700">'.$paidInstallments.'&nbsp;( Paid Amount: '. $row["amount_paid"].')
    
    </td>
    </tr>

    <tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> UnPaid Installments (बिना भारी किस्त)</th>
    <td class="px-6 py-2 border border-gray-700">'.$unpaidInstallments;
    if($loan_type != 1){

      echo "<span>( Total Amount Due (कुल शेष राशि):</span><span font-red>".$unpaidInstallments*$row['installment'].")</span>";
    }

    echo '</td>
    </tr>
    </tr>
    <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Due Amount Till Today (बकाया राशि आज तक)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">' .$unpaidInstallments*$row['installment']. '
      </td>
    </tr>
    
    
    
    </tbody>
    </table>  
</div>';


//Total EMI with date table modal here
//have to do some work here

echo '<div id="totalinstallmenttableModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
<div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
<!-- Modal Content -->
<div class="modal-content py-4 text-left px-6">
  <!-- Close Button/Icon -->

  <button id="closetotalinstallmenttableModal" class="close-button border bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
  <i class="fa-solid fa-xmark"></i>
</button>

  <table class="text-left w-full">
<thead class="bg-black flex text-white w-full">
  <tr class="flex w-full">
    <th class="p-4 w-1/2">Date</th>
    <th class="p-4 w-1/2">Installment</th>
  </tr>
</thead>
<!-- Remove the nasty inline CSS fixed height on production and replace it with a CSS class — this is just for demonstration purposes! -->
<tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 30vh;">
  ';


require_once "../connect.php";
if($loan_type == 2){

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
foreach ($alldates as $date => $status) {
// echo $date . "<br>";
echo '<tr class="flex w-full">
<td class="p-4 w-1/2 font-bold">'.$date.'</td>';
if($status == 'Pending'){
  echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
}elseif($status == 'Coming'){
  echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
}elseif($status == 'Paid'){
  echo '<td class="p-4 w-1/2 text-green-900 font-bold">'.$status.'</td></tr>';
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
foreach ($alldates as $date => $status) {
// echo $date . "<br>";
echo '<tr class="flex w-full">
<td class="p-4 w-1/2 font-bold">'.$date.'</td>';
if($status == 'Pending'){
  echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
}elseif($status == 'Coming'){
  echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
}elseif($status == 'Paid'){
  echo '<td class="p-4 w-1/2 text-green-900 font-bold">'.$status.'</td></tr>';
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
foreach ($alldates as $date => $status) {
// echo $date . "<br>";
echo '<tr class="flex w-full">
<td class="p-4 w-1/2 font-bold">'.$date.'</td>';
if($status == 'Pending'){
  echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
}elseif($status == 'Coming'){
  echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
}elseif($status == 'Paid'){
  echo '<td class="p-4 w-1/2 text-green-900 font-bold">'.$status.'</td></tr>';
}
}
}
echo'</tbody>
</table>
</div>
</div>
</div>
</div>';


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