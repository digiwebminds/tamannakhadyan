<?php
if(isset($_POST['cc'])){
    // $loantype =$_POST['loantype'];
    // echo $loantype;
    include "../connect.php";

    $sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
  (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.loan_type = 1 and status = 1
GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
HAVING phone_count > 0";

  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo '<div class="relative overflow-x-auto">
    <div class="p-4 bg-gray-800 text-green-400 mb-1">
    <p class="font-medium flex justify-between items-center">
        <span>CC Loans Dues List! (Active Loans only)</span>
        <button type="button" id="closebtncc" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Close</button>
    </p>
    </div>
        <table class="w-full text-sm text-left text-gray-400 mb-5">
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
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
    $loan_type = $row['loan_type'];
    $loanid = $row['id'];
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

      $totalInstallmentstilldate = floor(($today - $startDate) / (60 * 60 * 24 * $frequency)); 
      $currentDate = $startDate;
      $paidInstallments = $row['emi_count'];
      $unpaidInstallments = $totalInstallmentstilldate - $paidInstallments;

      $remprincipal = $row['principle']- $row["total_principal_paid"];
      $reminstallmentamount = $remprincipal*($row["roi"]/100);
      include_once "../functions.php";
      $amountduetilltoday = totalEmiAmountDue_in_CCloan($loanid);

      $totalamountduetilldate[] = $amountduetilltoday;
      $totalprincipalamount[] = $row['principle'];
      $totalprincipalamountpaid[] = $row['total_principal_paid'];
      $totalinstallmentamountpaidtilldate[] = $row['amount_paid'];
      $totalprincipalamountdue[] = $row['principle']-$row['total_principal_paid'];
      $totalreminstallmentamount[] = $reminstallmentamount;
      $totalrem_principal[] = $remprincipal;

      echo '<tr class="border-b bg-gray-800 border-gray-700">
      <td class="px-6 py-4">
      '.$i++.'
      </td>
      <td class="px-6 py-4">
          '.$row['id'].'
      </td>
      <td class="px-6 py-4">
      '.$row['name'].'
      </td>
      <td class="px-6 py-4">
      '.$row['phone'].'
      </td>
      <td class="px-6 py-4">
      '.$row['address'].'
      </td>
      <td class="px-6 py-4">
      '.$row['principle'].'
      </td>
        <td class="px-6 py-4">
        '.$remprincipal.'
        </td>
      <td class="px-6 py-4">
      '.$reminstallmentamount.'
      </td>
      <td class="px-6 py-4">
      '.$row['total_principal_paid'].'
      </td>
      <td class="px-6 py-4">
      '.$row['amount_paid'].'
      </td>
      <td class="px-6 py-4">
          '.$amountduetilltoday.'
      </td>
      <td class="px-6 py-4">';
      $latefinearray = lateFineCalforCC_daily($loanid);
      echo $l = array_sum($latefinearray);
      $totalLateFine[] = $l;
      echo'</td>
      <td class="px-6 py-4">
          '.($totalAmountduewithLatefineall[] = $remprincipal + $amountduetilltoday + $l).'
      </td>
  </tr>';
    }
echo '<tr class="border-b text-medium font-bold bg-gray-700 border-gray-700 text-white">
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
}
}



if(isset($_POST['daily'])){
    // $loantype =$_POST['loantype'];
    // echo $loantype;
    include "../connect.php";

    $sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
  (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.loan_type = 2
GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
HAVING phone_count > 0";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo '<div class="relative overflow-x-auto">
    <div class="p-4 bg-gray-800 text-green-400 mb-1">
    <p class="font-medium flex justify-between items-center">
        <span>Daily Loans Dues List! (Active Loans only)</span>
        <button type="button" id="closebtnd" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Close</button>
    </p>
    </div>
        <table class="w-full text-sm text-left text-gray-400 mb-5">
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
                        Principal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Installment Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No. of Installments
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Late Fine
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount Paid
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due Amount (Emi + Latefine)
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
            $totalamountDueWithLateFine = [];
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      $loan_type = $row['loan_type'];
    $loanid = $row['id'];
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
      $amountduetilltoday = $totalInstallmentstilldate*$row['installment'] - $row['amount_paid'];

      $totalamountduetilldate[] = ($totalInstallmentstilldate*$row['installment'] - $row['amount_paid']);
      $totalprincipalamount[] = $row['principle'];
      $totalprincipalamountpaidtilldate[] = $row['total_principal_paid'];
      $totalinstallmentamountpaidtilldate[] = $row['amount_paid'];
      $totalprincipalamountdue[] = $row['principle']-$row['total_principal_paid'];
      $totalinstallmentamount[] = $row['installment'];



      echo '<tr class="border-b bg-gray-800 border-gray-700">
      <td class="px-6 py-4">
          '.$i++.'
      </td>
      <td class="px-6 py-4">
          '.$row['id'].'
      </td>
      <td class="px-6 py-4">
      '.$row['name'].'
      </td>
      <td class="px-6 py-4">
      '.$row['phone'].'
      </td>
      <td class="px-6 py-4">
      '.$row['address'].'
      </td>
      <td class="px-6 py-4">
      '.$row['principle'].'
      </td>
      <td class="px-6 py-4">
      '.$row['installment'].'
      </td>
      <td class="px-6 py-4">
      '.$row['days_weeks_month'].'
      </td>
      <td class="px-6 py-4">';
      include_once "../functions.php";
      $latefinearray = lateFineCalforCC_daily($loanid);
      echo $l = array_sum($latefinearray);
      $totalLateFine[] = $l;
      echo '</td>
      <td class="px-6 py-4">
      '.$row['amount_paid'].'
      </td>
      <td class="px-6 py-4">
          '.$amountduetilltoday.'
      </td>
      <td class="px-6 py-4">';
      echo $amountDueWithLateFine = $amountduetilltoday + $l;
      $totalamountDueWithLateFine[] = $amountDueWithLateFine;
      echo '</td>
  </tr>';
    }
echo '<tr class="border-b text-medium font-bold bg-gray-700 border-gray-700 text-white">
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
      '.array_sum($totalinstallmentamount).'
      </td>
      <td class="px-6 py-4">
      --
      </td>
      <td class="px-6 py-4">'.
      array_sum($totalLateFine)
      .'</td>
      <td class="px-6 py-4">
      '.array_sum($totalinstallmentamountpaidtilldate).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalamountduetilldate).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalamountDueWithLateFine).'
      </td>
  </tr>

</tbody>
</table>

<div class="font-bold border border-black p-4 mb-4">
<p class="text-red-900">Total Installment Amount Due (आज तक): '.array_sum($totalamountduetilldate).'</p>
<p class="text-red-900">Total Installment Amount Paid (आज तक): '.array_sum($totalinstallmentamountpaidtilldate).'</p>

</div>

</div>';
}
}


if(isset($_POST['weekly'])){
    // $loantype =$_POST['loantype'];
    // echo $loantype;
    include "../connect.php";

    $sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
  (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.loan_type = 3
GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
HAVING phone_count > 0";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo '<div class="relative overflow-x-auto">
    <div class="p-4 bg-gray-800 text-green-400 mb-1">
    <p class="font-medium flex justify-between items-center">
        <span>Weekly Loans Dues List! (Active Loans only)</span>
        <button type="button" id="closebtnw" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Close</button>
    </p>
    </div>
        <table class="w-full text-sm text-left text-gray-400 mb-5">
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
                        Principal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Installment
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No. of Installments
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Late Fine
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount Paid
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due Amounts (Emi + Latefine)
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
            $totalDueWithLateFine = [];
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      $loan_type = $row['loan_type'];
        $loanid = $row['id'];
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
      $amountduetilltoday = $totalInstallmentstilldate*$row['installment'] - $row['amount_paid'];

      $totalamountduetilldate[] = ($totalInstallmentstilldate*$row['installment'] - $row['amount_paid']);
      $totalprincipalamount[] = $row['principle'];
      $totalprincipalamountpaidtilldate[] = $row['total_principal_paid'];
      $totalinstallmentamountpaidtilldate[] = $row['amount_paid'];
      $totalprincipalamountdue[] = $row['principle']-$row['total_principal_paid'];
      $totalinstallmentamount[] = $row['installment'];

      echo '<tr class="border-b bg-gray-800 border-gray-700">
      <td class="px-6 py-4">
      '.$i++.'
      </td>
      <td class="px-6 py-4">
          '.$row['id'].'
      </td>
      <td class="px-6 py-4">
      '.$row['name'].'
      </td>
      <td class="px-6 py-4">
      '.$row['phone'].'
      </td>
      <td class="px-6 py-4">
      '.$row['address'].'
      </td>
      <td class="px-6 py-4">
      '.$row['principle'].'
      </td>
      <td class="px-6 py-4">
      '.$row['installment'].'
      </td>
      <td class="px-6 py-4">
      '.$row['days_weeks_month'].'
      </td>
      <td class="px-6 py-4">';
      include_once "../functions.php";
      $latefinearray = lateFineCalforweekly($loanid);
      echo $l = array_sum($latefinearray);
      $totalLateFine[] = $l;
      echo'</td>
      <td class="px-6 py-4">
      '.$row['amount_paid'].'
      </td>
      <td class="px-6 py-4">
          '.$amountduetilltoday.'
      </td>
      <td class="px-6 py-4">';
      echo $duewithLateFine = $amountduetilltoday + $l;
      $totalDueWithLateFine[] = $duewithLateFine;
      echo '</td>
  </tr>';
    }
echo '<tr class="border-b text-medium font-bold bg-gray-700 border-gray-700 text-white">
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
      '.array_sum($totalinstallmentamount).'
      </td>
      <td class="px-6 py-4">
      --
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalLateFine).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalinstallmentamountpaidtilldate).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalamountduetilldate).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalDueWithLateFine).'
      </td>
  </tr>

</tbody>
</table>

<div class="font-bold border border-black p-4 mb-4">
<p class="text-red-900">Total Installment Amount Due (आज तक): '.array_sum($totalamountduetilldate).'</p>
<p class="text-red-900">Total Installment Amount Paid (आज तक): '.array_sum($totalinstallmentamountpaidtilldate).'</p>

</div>

</div>';
}
}



if(isset($_POST['monthly'])){
    // $loantype =$_POST['loantype'];
    // echo $loantype;
    include "../connect.php";

    $sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month,l.total, c.name,c.address, c.fname,c.phone, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.installment_amount) as amount_paid,
  (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.loan_type = 4
GROUP BY c.id, l.id, c.name, c.fname,c.phone,c.address, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
HAVING phone_count > 0";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo '<div class="relative overflow-x-auto">
    <div class="p-4 bg-gray-800 text-green-400 mb-1">
    <p class="font-medium flex justify-between items-center">
        <span>Monthly Loans Dues List! (Active Loans only)</span>
        <button type="button" id="closebtnm" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Close</button>
    </p>
    </div>
        <table class="w-full text-sm text-left text-gray-400 mb-5">
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
                        Principal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Installment Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No . of Installments
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Late fine
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount Paid
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due Amount (Emi + LateFine) 
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
            $totalDuewithLateFine = [];
            $totalLateFine = [];
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      $loan_type = $row['loan_type'];
      $loanid = $row['id'];

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
      $amountduetilltoday = $totalInstallmentstilldate*$row['installment'] - $row['amount_paid'];

      $totalamountduetilldate[] = ($totalInstallmentstilldate*$row['installment'] - $row['amount_paid']);
      $totalprincipalamount[] = $row['principle'];
      $totalprincipalamountpaidtilldate[] = $row['total_principal_paid'];
      $totalinstallmentamountpaidtilldate[] = $row['amount_paid'];
      $totalprincipalamountdue[] = $row['principle']-$row['total_principal_paid'];
      $totalinstallmentamount[] = $row['installment'];

      echo '<tr class="border-b bg-gray-800 border-gray-700">
      <td class="px-6 py-4">
      '.$i++.'
      </td>
      <td class="px-6 py-4">
          '.$row['id'].'
      </td>
      <td class="px-6 py-4">
      '.$row['name'].'
      </td>
      <td class="px-6 py-4">
      '.$row['phone'].'
      </td>
      <td class="px-6 py-4">
      '.$row['address'].'
      </td>
      <td class="px-6 py-4">
      '.$row['principle'].'
      </td>
      <td class="px-6 py-4">
      '.$row['installment'].'
      </td>
      <td class="px-6 py-4">
      '.$row['days_weeks_month'].'
      </td>
      <td class="px-6 py-4">';
      include_once "../functions.php";
      $latefinearray = lateFineCalformonthly($loanid);
      echo $l = array_sum($latefinearray);
      $totalLateFine[] = $l;
      echo '</td>
      <td class="px-6 py-4">
      '.$row['amount_paid'].'
      </td>
      <td class="px-6 py-4">
          '.$amountduetilltoday.'
      </td>
      <td class="px-6 py-4">';
      echo $duewithLateFine = $amountduetilltoday + $l;
      $totalDuewithLateFine[]  = $duewithLateFine;
      echo '</td>
  </tr>';
    }
echo '<tr class="border-b text-medium font-bold bg-gray-700 border-gray-700 text-white">
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
      '.array_sum($totalinstallmentamount).'
      </td>
      <td class="px-6 py-4">
      -
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalLateFine).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalinstallmentamountpaidtilldate).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalamountduetilldate).'
      </td>
      <td class="px-6 py-4">
      '.array_sum($totalDuewithLateFine).'
      </td>
  </tr>

</tbody>
</table>

<div class="font-bold border border-black p-4 mb-4">
<p class="text-red-900">Total Installment Amount Due (आज तक): '.array_sum($totalamountduetilldate).'</p>
<p class="text-red-900">Total Installment Amount Paid (आज तक): '.array_sum($totalinstallmentamountpaidtilldate).'</p>

</div>

</div>';
}
}
?>