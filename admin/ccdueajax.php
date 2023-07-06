<?php
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

$sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
(SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.loan_type = 1 and status = 1
GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
HAVING phone_count > 0";

$paginationlink = "ccdueajax.php?page=";

$page = 1;
if (!empty($_GET["page"])) {
	$page = $_GET["page"];
}

$start = ($page - 1) * $perPage->perpage;
if ($start < 0) $start = 0;

$query =  $sql . " limit " . $start . "," . $perPage->perpage;
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
	$resultset[] = $row;
}
$faq = $resultset;

if (empty($_GET["rowcount"])) {
	$result  = mysqli_query($conn, $query);
	$rowcount = mysqli_num_rows($result);
	$_GET["rowcount"] = $rowcount;
}
$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink);

$output = '';
$output .= '
<div class="relative overflow-x-auto">
<div class="p-4 bg-gray-800 text-green-400 mb-1">
    <p class="font-medium flex justify-between items-center">
        <span>CC Loans Dues List! (Active Loans only)</span>
        <button type="button" id="closebtncc" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Close</button>
    </p>
</div>
<table class="mb-2 w-full text-sm text-left text-gray-400">
	<thead class="text-medium uppercase bg-gray-700 text-white">
		<tr>
            <th scope="col" class="px-6 py-3">
                S.No.
            </th>
            <th scope="col" class="px-6 py-3">
                Loan ID
            </th>
            <th scope="col" class="px-6 py-3">
                Customer
            </th>
            <th scope="col" class="px-6 py-3">
                Phone No.
            </th>
            <th scope="col" class="px-6 py-3">
                Address
            </th>
            <th scope="col" class="px-6 py-3">
            Initial Principal
            </th>
            <th scope="col" class="px-6 py-3">
            Remaining Principal
            </th>
            <th scope="col" class="px-6 py-3">
                Installment Amount
            </th>
            <th scope="col" class="px-6 py-3">
                Principal Paid
            </th>
            <th scope="col" class="px-6 py-3">
                Installment Amount Paid
            </th>
            <th scope="col" class="px-6 py-3">
                Installment Due Amount
            </th>
            <th scope="col" class="px-6 py-3">
                Late Fine
            </th>
            <th scope="col" class="px-6 py-3">
                Total Amount Due (P + I + Latefine )
            </th>
		</tr>
	</thead>
	<tbody>';
    
    $totalprincipalamount = [];
    $totalprincipalamountpaidtilldate = [];
    $totalamountduetilldate = [];
    $totalinstallmentamountpaidtilldate = [];
    $totalprincipalamountdue =[];
    $totalinstallmentamount = [];
    $totalLateFine = [];
    $totalAmountduewithLatefineall = [];

$i = $start * 1;
foreach ($faq as $k => $v) {
	$i++;
    $loan_type = $faq[$k]['loan_type'];
    $loanid = $faq[$k]['id'];
    $startDate = strtotime($faq[$k]['dor']);
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

      $totalInstallmentstilldate = floor(($today - $startDate) / (60 * 60 * 24 * $frequency)); 
      $currentDate = $startDate;
      $paidInstallments = $faq[$k]['emi_count'];
      $unpaidInstallments = $totalInstallmentstilldate - $paidInstallments;

      $remprincipal = $faq[$k]['principle']- $faq[$k]["total_principal_paid"];
      $reminstallmentamount = $remprincipal*($faq[$k]["roi"]/100);
      include_once "../include/functions.php";
      $amountduetilltoday = totalEmiAmountDue_in_CCloan($loanid);

      $totalamountduetilldate[] = $amountduetilltoday;
      $totalprincipalamount[] = $faq[$k]['principle'];
      $totalprincipalamountpaid[] = $faq[$k]['total_principal_paid'];
      $totalinstallmentamountpaidtilldate[] = $faq[$k]['amount_paid'];
      $totalprincipalamountdue[] = $faq[$k]['principle']-$faq[$k]['total_principal_paid'];
      $totalreminstallmentamount[] = $reminstallmentamount;
      $totalrem_principal[] = $remprincipal;

      $output .= '<tr class="border-b bg-gray-800 border-gray-700">
      <td class="px-6 py-4">
      '.$i.'
      </td>
      <td class="px-6 py-4">
          '.$faq[$k]['id'].'
      </td>
      <td class="px-6 py-4">
      '.$faq[$k]['name'].'
      </td>
      <td class="px-6 py-4">
      '.$faq[$k]['phone'].'
      </td>
      <td class="px-6 py-4">
      '.$faq[$k]['address'].'
      </td>
      <td class="px-6 py-4">
      '.$faq[$k]['principle'].'
      </td>
        <td class="px-6 py-4">
        '.$remprincipal.'
        </td>
      <td class="px-6 py-4">
      '.$reminstallmentamount.'
      </td>
      <td class="px-6 py-4">
      '.$faq[$k]['total_principal_paid'].'
      </td>
      <td class="px-6 py-4">
      '.$faq[$k]['amount_paid'].'
      </td>
      <td class="px-6 py-4">
          '.$amountduetilltoday.'
      </td>
      <td class="px-6 py-4">';
      $latefinearray = lateFineCalforCC($loanid);
      $l = array_sum($latefinearray);
      $output .= $l;
      $totalLateFine[] = $l;
      $output .= '</td>
      <td class="px-6 py-4">
          '.($totalAmountduewithLatefineall[] = $remprincipal + $amountduetilltoday + $l).'
      </td>
  </tr>';
}
$output .= '<tr class="border-b text-medium font-bold bg-gray-700 border-gray-700 text-white">
<td class="px-6 py-4">
    Total
</td>
<td class="px-6 py-4">
    -
</td>
<td class="px-6 py-4">
-
</td>
<td class="px-6 py-4">
-
</td>
<td class="px-6 py-4">
-
</td>
<td class="px-6 py-4">
'.array_sum($totalprincipalamount).'
</td>
<td class="px-6 py-4">
'.array_sum($totalrem_principal).'
</td>
<td class="px-6 py-4">
'.array_sum($totalreminstallmentamount).'
</td>
<td class="px-6 py-4">
'.array_sum($totalprincipalamountpaid).'
</td>
<td class="px-6 py-4">
'.array_sum($totalinstallmentamountpaidtilldate).'
</td>
<td class="px-6 py-4">
'.array_sum($totalamountduetilldate).'
</td>
<td class="px-6 py-4">
'.array_sum($totalLateFine).'
</td>
<td class="px-6 py-4">
'.array_sum($totalAmountduewithLatefineall).'
</td>
</tr>

</tbody>
</table>
<div class="font-bold border border-black p-4 mb-4">
<p class="text-red-900">Total Principal Amount Due: '.array_sum($totalprincipalamountdue).'</p>
<p class="text-red-900">Total Installment Amount Due (आज तक): '.array_sum($totalamountduetilldate).'</p>
</div>

</div>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;