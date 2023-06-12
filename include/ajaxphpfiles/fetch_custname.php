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


if (isset($_POST['loanid'])) {

  $loanid = $_POST['loanid'];

  // $sql = "SELECT c.id AS cust_id, l.id, c.name, c.fname, c.city, COUNT(c.phone) AS phone_count,COUNT(re.loan_id) as emi_count, c.photo, l.principle, l.dor, l.loan_type, l.installment, l.roi
  // FROM customers AS c
  // JOIN loans AS l ON c.id = l.customer_id
  // LEFT JOIN repayment AS re ON l.id = re.loan_id
  // WHERE l.id = $loanid
  // GROUP BY c.id, l.id, c.name, c.fname, c.city, c.photo, l.principle, l.dor, l.loan_type, l.installment, l.roi
  // HAVING phone_count > 0;";

  $sql = "SELECT c.id AS cust_id, l.id,l.days_weeks_month, c.name, c.fname, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.	installment_amount) as amount_paid,
  (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
FROM customers AS c
JOIN loans AS l ON c.id = l.customer_id
LEFT JOIN repayment AS re ON l.id = re.loan_id
WHERE l.id = $loanid
GROUP BY c.id, l.id, c.name, c.fname, c.city, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
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

      echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
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
  <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Principal Amount Remaining </th>
  <td class="px-6 py-2 border border-gray-700 text-gray-900">' . $remprincipal . ' &nbsp; &nbsp; &nbsp; | Principal Paid :- '.$row["total_principal_paid"].' | Total Principal :- '.$row["principle"].'

  &nbsp;<button id="openprincipalpaidtable" class="text-black font-bold py-2 px-4 rounded">
  <i class="fa-solid fa-circle-info"></i>
  </button>

  </td>
  </tr>';
}else {
  echo '<tr class="border-b border-gray-200 dark:border-gray-700">
  <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Principal Amount </th>
  <td class="px-6 py-2 border border-gray-700 text-gray-900">'.$row["principle"].'
  </td>
  </tr>';
}
  if($loan_type == 1){
    
    echo '<tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Installment Amount </th>
    <td class="px-6 py-2 border border-gray-700">' . $reminstallmentamount . '
    </td>
    </tr>';
  }else{
    echo '<tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Installment Amount </th>
    <td class="px-6 py-2 border border-gray-700">' . $row['installment'] . '
    </td>
    </tr>';
  }

  if($loan_type != 1){
    
    echo '<tr class="border-b border-gray-200 dark:border-gray-700">
    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Total Installment </th>
    <td class="px-6 py-2 border border-gray-700">' . $row['days_weeks_month'] . '

    &nbsp;<button id="opentotalinstallmenttablemodal" class="text-black font-bold py-2 px-4 rounded">
      <i class="fa-solid fa-circle-info"></i>
      </button>

    </td>
    </tr>';
  }


      echo '<tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Total Installment Till Today </th>
      <td class="px-6 py-2 border border-gray-700">'. $totalInstallmentstilldate .'
      </td>
      </tr>

      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Paid Installments & Amount </th>
      <td class="px-6 py-2 border border-gray-700">'.$paidInstallments.'&nbsp;( Paid Amount: '. $row["amount_paid"].')
      
      &nbsp;<button id="openpaidinstallmentinfo" class="text-black font-bold py-2 px-4 rounded">
      <i class="fa-solid fa-circle-info"></i>
      </button>
      
      </td>
      </tr>

      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> UnPaid Installments </th>
      <td class="px-6 py-2 border border-gray-700">'.$unpaidInstallments.'

      &nbsp;<button id="openunpaidinstallmenttablemodal" class="text-black font-bold py-2 px-4 rounded">
      <i class="fa-solid fa-circle-info"></i>
      </button>

      </td>
      </tr>
      </tr>
      <tr class="border-b border-gray-200 dark:border-gray-700">
      <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Repay </th>
      <td class="px-6 py-2 border border-gray-700">
      <button id="openModalButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded">Pay Installment</button>
      </td>
      </tr>';
      if ($loan_type == 1) {
        echo '<tr class="border-b border-gray-200 dark:border-gray-700">
        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 border border-gray-700"> Repay Principle </th>
        <td class="px-6 py-2 border border-gray-700">
        <button id="openModalprinciplerepay" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pay Principle</button>
        </td>
        </tr>';
      }
      echo '</tbody>
      </table>
</div>';




      /// repayment modal below
      echo '<div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
// <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
<div class="modal-content bg-white text-gray-800 rounded shadow-lg w-1/2">
  
<form action="" method="POST">
              <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 p-4">
                  
                  <div>
                      <label for="dorepay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">D.O.Repayment</label>
                      <input type="date" name="dorepay" id="dorepay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>
                  <div>
                      <label for="loan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan ID</label>
                      <input type="number" name="loan_id" id="loan_id" value="' . $row['id'] . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                  </div>
                  <div>
                      <label for="loantype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan Type</label>
                      <input type="text" name="loantype" id="loantype" value="';

      if ($loan_type == 1) {
        echo "CC Loan";
      } elseif ($loan_type == 2) {
        echo "Daily Loan";
      } elseif ($loan_type == 3) {
        echo "Weekly Loan";
      } else {
        echo "Monthly Loan";
      }

      echo '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                  </div>
                  <div>
                      <label for="install-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Installment Amount</label>
                      <input type="number" name="install-amount" id="install-amount" value="';
                      if($loan_type==1){

                       echo $reminstallmentamount;  
                      }else {
                       echo $row['installment'];
                      }
                      
                      echo '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>
                  <div id="repaymentalert"></div>
                  <button type="submit" id="repaysubmitbtnn" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                      Pay Installment
                  </button>
              </div>
          </form>
  
</div>
</div>';


// repay principle modal below

echo '<div id="myModalrepayprinciple" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
// <div class="modal-overlay outsidemodal absolute w-full h-full bg-gray-900 opacity-50"></div>
<div class="modal-content bg-white text-gray-800 rounded shadow-lg w-1/2">
  
<form action="" method="POST">
              <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 p-4">
                  <div>
                      <label for="dorepay-principal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">D.O.Repayment</label>
                      <input type="date" name="dorepay-principal" id="dorepay-principal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>
                  <div>
                      <label for="loan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan ID</label>
                      <input type="number" name="loan_id" id="loan_id" value="' . $row['id'] . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                  </div>
                  <div>
                      <label for="loantype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan Type</label>
                      <input type="text" name="loantype" id="loantype" value="';

      if ($loan_type == 1) {
        echo "CC Loan";
      } elseif ($loan_type == 2) {
        echo "Daily Loan";
      } elseif ($loan_type == 3) {
        echo "Weekly Loan";
      } else {
        echo "Monthly Loan";
      }

      echo '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                  </div>
                  <div>
                      <label for="principle-amount-repay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Principle Amount</label>
                      <input type="number" name="principle-amount-repay" id="principle-amount-repay" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>
                  <div id="principlerepayalert"></div>
                  <button type="submit" id="repay-principle-submitbtnn" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                      Pay Principle
                  </button>
              </div>
          </form>
  
</div>
</div>';

//paid installments table modal here

echo '<div id="paidinstallmentModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  
  <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
    <!-- Modal Content -->
    <div class="modal-content py-4 text-left px-6">
      <!-- Close Button/Icon -->

      <button id="closeInstallmentinfoModal" class="close-button border bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
      <i class="fa-solid fa-xmark"></i>
</button>
      <table class="text-left w-full">
		<thead class="bg-black flex text-white w-full">
			<tr class="flex w-full mb-4">
				<th class="p-4 w-1/4">Date</th>
				<th class="p-4 w-1/4">Installment</th>
			</tr>
		</thead>
    <!-- Remove the nasty inline CSS fixed height on production and replace it with a CSS class — this is just for demonstration purposes! -->
		<tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 30vh;">
			';
      require_once "../connect.php";
      
      $sql2 = "SELECT DORepayment,installment_amount FROM `repayment` where loan_id=$loanid";
      $result2 = mysqli_query($conn,$sql2);
      if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {

          echo '<tr class="flex w-full mb-4">
          <td class="p-4 w-1/4 font-bold">'.$row2['DORepayment'].'</td>
          <td class="p-4 w-1/4 font-bold">'.$row2['installment_amount'].'</td></tr>';

            }
          }
				echo'</tbody>
  </table>
  </div>
  </div>
  </div>
</div>';


//paid principal table modal here

echo '<div id="paidprincipaltableModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  
  <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
    <!-- Modal Content -->
    <div class="modal-content py-4 text-left px-6">
      <!-- Close Button/Icon -->

      <button id="closeprincipaltableModal" class="close-button border bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
      <i class="fa-solid fa-xmark"></i>
</button>
      <table class="text-left w-full">
		<thead class="bg-black flex text-white w-full">
			<tr class="flex w-full mb-4">
				<th class="p-4 w-1/4">Date</th>
				<th class="p-4 w-1/4">Installment</th>
			</tr>
		</thead>
    <!-- Remove the nasty inline CSS fixed height on production and replace it with a CSS class — this is just for demonstration purposes! -->
		<tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 30vh;">
			';
      require_once "../connect.php";
      
      $sql3 = "SELECT dorepayment,repay_amount FROM `principle_repayment` where loan_id=$loanid";
      $result3 = mysqli_query($conn,$sql3);
      if (mysqli_num_rows($result3) > 0) {
        while ($row3 = mysqli_fetch_assoc($result3)) {

          echo '<tr class="flex w-full mb-4">
          <td class="p-4 w-1/4 font-bold">'.$row3['dorepayment'].'</td>
          <td class="p-4 w-1/4 font-bold">'.$row3['repay_amount'].'</td></tr>';
            }
          }
				echo'</tbody>
  </table>
  </div>
  </div>
  </div>
</div>';



//unpaid Emi tilldate table modal here

echo '<div id="unpaidinstallmenttableModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  
  <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
    <!-- Modal Content -->
    <div class="modal-content py-4 text-left px-6">
      <!-- Close Button/Icon -->

      <button id="closeunpaidinstallmenttableModal" class="close-button border bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
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
if($loan_type == 1){
  // Fetch loan start date and last date from the loans table
  $sql4 = "SELECT dor, ldol FROM loans WHERE id =$loanid";
  $result4 = mysqli_query($conn, $sql4);
  $row4 = mysqli_fetch_assoc($result4);
  
  $loanStartDate = $row4['dor'];
  $loanLastDate = time();

  
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
  $endDate = $loanLastDate;
  $missingDates = array();
  $currentDate = $startDate;
  while ($currentDate <= $endDate) {

      $date = date('Y-m-d', $currentDate);
      if (!in_array($date, $paidDates)) {
        $missingDates[$date] = 'Pending';
      }
      $currentDate = strtotime('+1 day', $currentDate);
    
  }
  
  // Display the missing payment dates
  foreach ($missingDates as $date => $status) {
    // echo $date . "<br>";
    echo '<tr class="flex w-full">
    <td class="p-4 w-1/2 font-bold">'.$date.'</td>';
    if($status == 'Pending'){
      echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
    }elseif($status == 'Coming'){
      echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
    }
  }
}
elseif($loan_type == 2){

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
  $missingDates = array();
  $currentDate = $startDate;
  while ($currentDate <= $endDate) {
    if($currentDate > time()){
      
      $date = date('Y-m-d', $currentDate);
      $missingDates[$date] = 'Coming';
      $currentDate = strtotime('+1 day', $currentDate);
    }else{
      $date = date('Y-m-d', $currentDate);
      if (!in_array($date, $paidDates)) {
        $missingDates[$date] = 'Pending';
      }
      $currentDate = strtotime('+1 day', $currentDate);
    }
  }
  
  // Display the missing payment dates
  foreach ($missingDates as $date => $status) {
    // echo $date . "<br>";
    echo '<tr class="flex w-full">
    <td class="p-4 w-1/2 font-bold">'.$date.'</td>';
    if($status == 'Pending'){
      echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
    }elseif($status == 'Coming'){
      echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
    }
  }
}elseif($loan_type == 3){
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
  $startDate += 86400*7; // adding 7 days to start days to exclude loan given date 
  $endDate = strtotime($loanLastDate);
  $missingDates = array();
  $currentDate = $startDate;
  while ($currentDate <= $endDate) {
    if($currentDate > time()){
      
      $date = date('Y-m-d', $currentDate);
      $missingDates[$date] = 'Coming';
      $currentDate = strtotime('+7 day', $currentDate);
    }else{
      $date = date('Y-m-d', $currentDate);
      if (!in_array($date, $paidDates)) {
        $missingDates[$date] = 'Pending';
      }
      $currentDate = strtotime('+7 day', $currentDate);
    }
  }
  
  // Display the missing payment dates
  foreach ($missingDates as $date => $status) {
    // echo $date . "<br>";
    echo '<tr class="flex w-full">
    <td class="p-4 w-1/2 font-bold">'.$date.'</td>';
    if($status == 'Pending'){
      echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
    }elseif($status == 'Coming'){
      echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
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
  $startDate += 86400*30; // adding 7 days to start days to exclude loan given date 
  $endDate = strtotime($loanLastDate);
  $missingDates = array();
  $currentDate = $startDate;
  while ($currentDate <= $endDate) {
    if($currentDate > time()){
      
      $date = date('Y-m-d', $currentDate);
      $missingDates[$date] = 'Coming';
      $currentDate = strtotime('+30 day', $currentDate);
    }else{
      $date = date('Y-m-d', $currentDate);
      if (!in_array($date, $paidDates)) {
        $missingDates[$date] = 'Pending';
      }
      $currentDate = strtotime('+30 day', $currentDate);
    }
  }
  
  // Display the missing payment dates
  foreach ($missingDates as $date => $status) {
    // echo $date . "<br>";
    echo '<tr class="flex w-full">
    <td class="p-4 w-1/2 font-bold">'.$date.'</td>';
    if($status == 'Pending'){
      echo '<td class="p-4 w-1/2 text-red-900 font-bold">'.$status.'</td></tr>';
    }elseif($status == 'Coming'){
      echo '<td class="p-4 w-1/2 text-yellow-900 font-bold">'.$status.'</td></tr>';
    }
  }
}
  echo'</tbody>
  </table>
  </div>
  </div>
  </div>
  </div>';

//Total EMI with date table modal here

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


// code to enter repayment details in database 

if (isset($_POST['dorepay']) && isset($_POST['loan_id']) && isset($_POST['installmentamt'])) {
  require_once "../connect.php";
  $dorepay = $_POST['dorepay'];
  $loan_id = $_POST['loan_id'];
  $installmentamt = $_POST['installmentamt'];

  $sql = "INSERT INTO `repayment` (`loan_id`, `DORepayment`, `installment_amount`) VALUES ('$loan_id', '$dorepay', '$installmentamt')";
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

  $sql = "INSERT INTO `principle_repayment` (`loan_id`, `dorepayment`, `repay_amount`) VALUES ('$loan_id', '$dorepay', '$principleamt')";
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


//interdependent code of last date of repayment and number of days

// commenting this if other is not worked 

// if(isset($_POST['dor'])){
//   if(isset($_POST['days'])){
//     $dor = strtotime($_POST['dor']);
//     $days = $_POST['days'] * 86400;
//     $ldorloan = $dor + $days;
//     echo date("Y-m-d",$ldorloan);
//   }
//   if(isset($_POST['ldorloan'])){
//     $dor = strtotime($_POST['dor']);
//     $ldorloan = strtotime($_POST['ldorloan']);
//     $days = $ldorloan - $dor;
//     echo date("j",$days);
//   }
// }

//this code is for interdependent no. of days/weeks/month & last day of repayment

if(isset($_POST['dor'])){

  if(isset($_POST['days']) && isset($_POST['loancat'])){
    $loancat = $_POST['loancat'];
    $roi = $_POST['roi'];
    $principal = $_POST['principal'];
    $result = [];
    if($loancat == 2){
      $dor = strtotime($_POST['dor']);
      $days = $_POST['days'] * 86400;
      $ldorloan = $dor + $days;
      $result['ldorloan'] = date("Y-m-d",$ldorloan);
    }elseif($loancat == 3){
      $dor = strtotime($_POST['dor']);
      $weeks = $_POST['days'] * 7 * 86400;
      $ldorloan = $dor + $weeks;
      $result['ldorloan'] = date("Y-m-d",$ldorloan);
    }elseif($loancat == 4){
      $dor = strtotime($_POST['dor']);
      $months = $_POST['days'] * 30 * 86400;
      $ldorloan = $dor + $months;
      $result['ldorloan'] = date("Y-m-d",$ldorloan);
    }
    $roirupees = ($roi/100) * $principal;
    $total = ($roirupees * $_POST['days']) + $principal;
    $result['total'] = $total;
    $installment = $total / $_POST['days'];
    $result['installment'] = $installment;
    //roi(in %) to roi(in rupees)
    $result['roir'] = ($_POST['roi']/100) * $_POST['principal'];
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
        $months = ceil($days / 7); // Round up to the nearest week
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
        <label for="roi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rate of Interest (in %)
        </label>
        <input type="text" name="roi" id="roi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required placeholder="%">
    </div>
    <div class="w-full">
        <label for="roir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rate of Interest (in ₹)
        </label>
        <input type="text" name="roir" id="roir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required placeholder="₹" readonly>
    </div>
    <div class="w-full">
        <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Amount
        </label>
        <input type="text" name="total" id="total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly>
    </div>
    <div class="w-full">
        <label for="installment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Installment Amount
        </label>
        <input type="text" name="installment" id="installment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly>
    </div>
    <div class="w-full">
        <label for="ldorloan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last date of Repayment</label>
        <input type="date" name="ldorloan" id="ldorloan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
    </div>
    </div>';
  }
}