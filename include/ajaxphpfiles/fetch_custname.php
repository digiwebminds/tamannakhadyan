<?php
include "../connect.php";

if (isset($_POST['customer_id'])) {
  $cust_id = $_POST['customer_id'];

  // Prepare the query using a parameterized statement
  $sql = "SELECT name FROM customers WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $cust_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $name = $row['name'];
    // echo json_encode($name);
  } else {
    echo 'Customer not found';
  }

  $stmt->close();
}

if(isset($_POST['ccprincipal'])){
  if(isset($_POST['ccroi'])){
    $roi = $_POST['ccroi'];
    $principal = $_POST['ccprincipal'];
    $installment = $principal * ($roi / 100);
    echo $installment;
  }
  if(isset($_POST['ccinstallment'])){
    $installment = $_POST['ccinstallment'];
    $principal = $_POST['ccprincipal'];
    $roi = ($installment/$principal)*100;
    echo $roi;
  }
}

///for rapayment

if (isset($_POST['loanid'])) {

  $loanid = $_POST['loanid'];
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
    include_once "../functions.php";
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
      include_once "../functions.php";
      $lateFineSum = lateFineCalforCC_daily($loanid);
  // calculating late fees
  if ($loan_type == 1 ){
    echo $lateFineSum;
  }elseif($loan_type == 2){
    echo $lateFineSum;
  }elseif($loan_type ==3){
    echo $lateFineSum = lateFineCalforweekly($loanid);
  }elseif($loan_type ==4){
    echo $lateFineSum = lateFineCalformonthly($loanid);
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
      if($loan_type !=1){
      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Amount Due Till Today (बकाया ऋण आज तक)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">' .$unpaidInstallments*$row['installment']. '
      </td>
      </tr>';
      //need to change this .\// need to change this
    }
    if($loan_type == 1){
      echo'
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">';
      echo ($dueee + $lateFineSum + $remprincipal);
      echo'</td>
      </tr>';
    }else{
      echo'
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700">Total Due Amount (P + I + LateFine)</th>
      <td class="px-6 py-2 border border-gray-700 text-red-900">';
      echo ($lateFineSum + ($unpaidInstallments*$row['installment']));
      echo'</td>
      </tr>';
    }
     echo '</tbody>
      </table>  
</div>';


/// repayment modal below
include_once "../modals/emi_repayment_modal.php";

// repay principle modal below
include_once "../modals/repay_principal_modal.php";

// lend more principle modal below
include_once "../modals/lend_more_principal_modal.php";

//paid installments table modal here
include_once "../modals/tables_modals/paid_emi_table_modal.php";

//paid principal table modal here
include_once "../modals/tables_modals/principal_lend_paid_table.php";

//unpaid Emi tilldate table modal here
include_once "../modals/tables_modals/unpaid_emi_table.php";

//Total EMI with date table modal here
include_once "../modals/tables_modals/total_emi_table.php";

  
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


// code to enter repayment details in database 

if (isset($_POST['dorepay']) && isset($_POST['loan_id']) && isset($_POST['installmentamt'])) {
  require_once "../connect.php";
  $dorepay = $_POST['dorepay'];
  $loan_id = $_POST['loan_id'];
  $installmentamt = $_POST['installmentamt'];
  $comment = $_POST['comment'];

  $sql = "INSERT INTO `repayment` (`loan_id`, `DORepayment`, `installment_amount`,`comment_repay`) VALUES ('$loan_id', '$dorepay', '$installmentamt','$comment')";
  $result = mysqli_query($conn,$sql);
  if($result){
    echo '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <span class="font-medium">Success !</span> Repayment Done Successfully
  </div>';
  }else{
    echo '<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <span class="font-medium">Alert !</span> There is some problem Please try Again !
  </div>';
  }
}

// code to enter principle repayment details in database 

if (isset($_POST['dorepay']) && isset($_POST['loan_id']) && isset($_POST['principleamt'])) {
  require_once "../connect.php";
  $dorepay = $_POST['dorepay'];
  $loan_id = $_POST['loan_id'];
  $principleamt = $_POST['principleamt'];
  $comment = $_POST['comment'];

  $sql = "INSERT INTO `principle_repayment` (`loan_id`, `dorepayment`, `repay_amount`,`comment_prirepay`) VALUES ('$loan_id', '$dorepay', '$principleamt','$comment')";
  $result = mysqli_query($conn,$sql);
  if($result){
    echo '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <span class="font-medium">Success !</span> Repayment Done Successfully
  </div>';
  }else{
    echo '<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <span class="font-medium">Alert !</span> There is some problem Please try Again !
  </div>';
  }
}

// code to enter lend more principle details in database 

if (isset($_POST['dorepayl']) && isset($_POST['loan_id']) && isset($_POST['principleamtl'])) {
  require_once "../connect.php";
  $dorepay = $_POST['dorepayl'];
  $loan_id = $_POST['loan_id'];
  $principleamt = $_POST['principleamtl'];
  $comment = $_POST['commentl'];

  if (is_numeric($principleamt)) {
    $principleamt_in_minus = -($principleamt);
    // Proceed with further calculations or database operations
  } else {
    // Convert non-numeric value to numeric value
    $numericValue = intval($principleamt); // or intval($principleamt) if an integer is desired
  
    if (is_numeric($numericValue)) {
      $principleamt_in_minus = -($numericValue);
      // Proceed with further calculations or database operations
    } else {
      echo "Error: The value entered could not be converted to a numeric value.";
    }
  }

  $sql = "INSERT INTO `principle_repayment` (`loan_id`, `dorepayment`, `repay_amount`,`comment_prirepay`) VALUES ('$loan_id', '$dorepay', '$principleamt_in_minus','$comment')";
  $result = mysqli_query($conn,$sql);
  if($result){
    echo '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <span class="font-medium">Success !</span> Lend Principal Done Successfully
  </div>';
  }else{
    echo '<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <span class="font-medium">Alert !</span> There is some problem Please try Again !
  </div>';
  }
}


//this code is for interdependent no. of days/weeks/month & last day of repayment

if(isset($_POST['dor'])){

  if(isset($_POST['days']) && isset($_POST['loancat'])){
    $loancat = $_POST['loancat'];
    $principal = $_POST['principal'];
    $result = [];
    if($loancat == 2){
      $dor = strtotime($_POST['dor']);
      $days = $_POST['days'] * 86400;
      $ldorloan = $dor + $days;
      $ldorloan = date("Y-m-d",$ldorloan);
    }elseif($loancat == 3){
      $dor = strtotime($_POST['dor']);
      $weeks = $_POST['days'] * 7 * 86400;
      $ldorloan = $dor + $weeks;
      $ldorloan = date("Y-m-d",$ldorloan);
    }elseif($loancat == 4){
      $dor = strtotime($_POST['dor']);
      $months = $_POST['days'] * 30 * 86400;
      $ldorloan = $dor + $months;
      $ldorloan = date("Y-m-d",$ldorloan);
    }
    $result['ldorloan'] = $ldorloan;
    if(isset($_POST['installment'])){
      $installment = (int) $_POST['installment'];
      $total = $_POST['days'] * $installment;
      $result['total'] = $total;
    }

    echo json_encode($result);
  }

  if(isset($_POST['ldorloan']) && isset($_POST['loancat'])){
    $loancat = $_POST['loancat'];
    if($loancat == 2){
      $dor = strtotime($_POST['dor']);
      $ldorloan = strtotime($_POST['ldorloan']);
      $days = $ldorloan - $dor;
      echo date("j",$days);
    }elseif($loancat == 3){
      $dor = strtotime($_POST['dor']);
        $ldorloan = strtotime($_POST['ldorloan']);
        $days = ($ldorloan - $dor) / 86400; // Convert seconds to days
        $weeks = ceil($days / 7); // Round up to the nearest week
        echo $weeks;
    }elseif($loancat == 4){
      $dor = strtotime($_POST['dor']);
        $ldorloan = strtotime($_POST['ldorloan']);
        $days = ($ldorloan - $dor) / 86400; // Convert seconds to days
        $months = ceil($days / 30); // Round up to the nearest month
        echo $months;
    }
  }
}

//input fields according to loan category select
if(isset($_POST['tol'])){
  if($_POST['tol'] == 1){
    echo '<div class="w-full">
        <label for="ccprinciple-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Principle Amount</label>
        <input type="number" name="principle-amount" id="ccprinciple-amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
    </div>
    <div class="w-full">
        <label for="ccroi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rate of Interest (in %)
        </label>
        <input type="text" name="roi" id="ccroi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required placeholder="%">
    </div>
    <div class="w-full">
        <label for="ccinstallment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Installment Amount
        </label>
        <input type="text" name="installment" id="ccinstallment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>
    <div class="w-full">
        <label for="latefine" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Late Fine
        </label>
        <input type="number" name="latefine" id="latefine" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>
    <div class="w-full">
        <label for="latefineafter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Late Fine after Days
        </label>
        <input type="number" name="latefineafter" id="latefineafter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>';
  }
  if($_POST['tol'] == 2 || $_POST['tol'] == 3 || $_POST['tol'] == 4){
    echo '<div class="w-full">
        <label for="principle-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Principle Amount</label>
        <input type="number" name="principle-amount" id="principle-amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
    </div>
    <div class="w-full">';
    if($_POST['tol'] == 2){
      echo '<label for="days" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Days
      </label>';
    }elseif($_POST['tol'] == 3){
      echo '<label for="days" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Weeks
      </label>';
    }else{
      echo '<label for="days" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Months
      </label>';
    }
       echo '<input type="text" name="days" id="days" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>
    <div class="w-full">
    <label for="installment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Installment Amount
    </label>
    <input type="text" name="installment" id="installment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>
    <div class="w-full">
        <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Amount
        </label>
        <input type="text" name="total" id="total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly>
    </div>
    <div class="w-full">
        <label for="latefine" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Late Fine
        </label>
        <input type="number" name="latefine" id="latefine" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>
    <div class="w-full">
        <label for="latefineafter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Late Fine after ';
        if($_POST['tol'] == 2){
          echo "Days";
        }elseif($_POST['tol'] == 3){
          echo "Weeks";
        }else{
          echo "Months";
        }
        echo '</label>
        <input type="number" name="latefineafter" id="latefineafter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    </div>
    <div class="w-full">
        <label for="ldorloan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last date of Repayment</label>
        <input type="date" name="ldorloan" id="ldorloan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
    </div>
    </div>';
  }
}