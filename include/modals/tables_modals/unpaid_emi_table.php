<?php

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

?>