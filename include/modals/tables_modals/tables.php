<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<?php
// Paid Emi Table
if(isset($_GET['loanidr'])){
    
    $loanid = $_GET['loanidr'];

    echo '
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
    <tr>
    <th scope="col" class="px-6 py-3">
    S.No.
    </th>
    <th scope="col" class="px-6 py-3">
    Date
    </th>
    <th scope="col" class="px-6 py-3">
    Installment
    </th>
    <th scope="col" class="px-6 py-3">
    Comment
    </th>
    <th scope="col" class="px-6 py-3">
    EntryBy
    </th>
    </tr>
    </thead>
    <tbody>';
    
    require_once "../../connect.php";
    $sql2 = "SELECT * FROM `repayment` where loan_id=$loanid";
    $result2 = mysqli_query($conn,$sql2);
    if (mysqli_num_rows($result2) > 0) {
        $i = 1;
        while ($row2 = mysqli_fetch_assoc($result2)) {
            echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            '.$i++.'
            </th>
            <td class="px-6 py-4">
            '.$row2['DORepayment'].'
            </td>
            <td class="px-6 py-4">
            '.$row2['installment_amount'].'
            </td>
            <td class="px-6 py-4">
            '.$row2['comment_repay'].'
            </td>
            <td class="px-6 py-4">
            '.$row2['entryby'].'
                </td>
                </tr>';
            }
        }
        
        echo '</tbody>
        </table>
        </div>';
    }


//Total EMi Table
    if(isset($_GET['loanidt']) and isset($_GET['loantype'])){
    
    $loanid = $_GET['loanidt'];
    $loan_type = $_GET['loantype'];

    echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
    <tr>
    <th scope="col" class="px-6 py-3">
    S.No.
    </th>
    <th scope="col" class="px-6 py-3">
    Date
    </th>
    <th scope="col" class="px-6 py-3">
    Installment Status
    </th>
    </tr>
    </thead>
    <tbody>';
        
    require_once "../../connect.php";
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
        $i=1;
        foreach ($alldates as $date => $status) {
          // echo $date . "<br>";

          echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          '.$i++.'
          </th>
          <td class="px-6 py-4">
          '.$date.'
          </td>';
          
          if($status == 'Pending'){
            echo '<td class="px-6 py-4 text-red-400">'.$status.'</td>';
          }elseif($status == 'Coming'){
            echo '<td class="px-6 py-4">'.$status.'</td>';
          }elseif($status == 'Paid'){
            echo '<td class="px-6 py-4 text-green-400">'.$status.'</td>';
          }
        echo '</tr>';
        }
        echo '</tbody>
        </table>
        </div>';


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
        $i=1;
        foreach ($alldates as $date => $status) {
          // echo $date . "<br>";

          echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          '.$i++.'
          </th>
          <td class="px-6 py-4">
          '.$date.'
          </td>';
          
          if($status == 'Pending'){
            echo '<td class="px-6 py-4 text-red-400">'.$status.'</td>';
          }elseif($status == 'Coming'){
            echo '<td class="px-6 py-4">'.$status.'</td>';
          }elseif($status == 'Paid'){
            echo '<td class="px-6 py-4 text-green-400">'.$status.'</td>';
          }
        echo '</tr>';
        }
        echo '</tbody>
        </table>
        </div>';


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
        $i=1;
        foreach ($alldates as $date => $status) {
          // echo $date . "<br>";

          echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          '.$i++.'
          </th>
          <td class="px-6 py-4">
          '.$date.'
          </td>';
          
          if($status == 'Pending'){
            echo '<td class="px-6 py-4 text-red-400">'.$status.'</td>';
          }elseif($status == 'Coming'){
            echo '<td class="px-6 py-4">'.$status.'</td>';
          }elseif($status == 'Paid'){
            echo '<td class="px-6 py-4 text-green-400">'.$status.'</td>';
          }
        echo '</tr>';
        }
        echo '</tbody>
        </table>
        </div>';
        }
        echo'</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>';
}


// Late Fine Table With Dates

if(isset($_GET['loanidlcc'])){
  $loanid = $_GET['loanidlcc'];

  echo '
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
    <tr>
    <th scope="col" class="px-6 py-3">
    S.No.
    </th>
    <th scope="col" class="px-6 py-3">
    Date
    </th>
    <th scope="col" class="px-6 py-3">
    Late Fine
    </th>
    </tr>
    </thead>
    <tbody>';
    include_once "../../functions.php";
      $lateFinearray = lateFineCalforCC($loanid);
      $i=1;
      foreach($lateFinearray as $date => $latefine){


        echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            '.$i++.'
            </th>
            <td class="px-6 py-4">
            '.$date.'
            </td>
            <td class="px-6 py-4">
            '.$latefine.'
            </td>
            </tr>';
      }
      echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Total-
            </th>
            <td class="px-6 py-4">
            --
            </td>
            <td class="px-6 py-4 text-white font-bold">
            '.array_sum($lateFinearray).'
            </td>
            </tr>';
      echo '</tbody>
  </table>
  </div>
  </div>
  </div>
</div>';
}


if(isset($_GET['loanidpri'])){
  $loanid = $_GET['loanidpri'];

  echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
    <tr>
    <th scope="col" class="px-6 py-3">
    S.No.
    </th>
    <th scope="col" class="px-6 py-3">
    Date
    </th>
    <th scope="col" class="px-6 py-3">
    Amount
    </th>
    <th scope="col" class="px-6 py-3">
    Type
    </th>
    </tr>
    </thead>
    <tbody>';

      require_once "../../connect.php";
      
      $sql3 = "SELECT dorepayment,repay_amount,info FROM `principle_repayment` where loan_id=$loanid";
      $result3 = mysqli_query($conn,$sql3);
      if (mysqli_num_rows($result3) > 0) {
        $i=1;
        while ($row3 = mysqli_fetch_assoc($result3)) {
          $info = $row3['info'];
          if($info == 0){
            echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            '.$i++.'
            </th>
            <td class="px-6 py-4">
            '.$row3['dorepayment'].'
            </td>
            <td class="px-6 py-4">
            '.$row3['repay_amount'].'
            </td>
            <td class="px-6 py-4">
            Received Principal
            </td>
            </tr>';
          }elseif($info == 1){

            echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            '.$i++.'
            </th>
            <td class="px-6 py-4">
            '.$row3['dorepayment'].'
            </td>
            <td class="px-6 py-4">
            '.(-$row3['repay_amount']).'
            </td>
            <td class="px-6 py-4">
            Given Principal
            </td>
            </tr>';
          }
          // else if($info == 2){
          //   echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          //   <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          //   '.$i++.'
          //   </th>
          //   <td class="px-6 py-4">
          //   '.$row3['dorepayment'].'
          //   </td>
          //   <td class="px-6 py-4">
          //   '.$row3['repay_amount'].'
          //   </td>
          //   <td class="px-6 py-4">
          //   Late Fine Added
          //   </td>
          //   </tr>';
          // }
        }
      }
				echo'</tbody>
  </table>
  </div>
  </div>
  </div>
</div>';






}
    ?>
    
    </body>
    </html>
    