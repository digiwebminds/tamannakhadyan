<?php
require_once "../connect.php";

if(isset($_POST['custid'])){
    $custid = $_POST['custid'];
$sql = "SELECT * FROM customers where id= $custid";
$result = mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){

            echo '<div class="border border-gray-400 p-4 flex">
            <div class="w-1/3">
            <img style="width:100px;height:100px;" src="'.$row['photo'].'" alt="Photo" class="float-left mr-4" />
            </div>
            <div class="w-2/3">
            <p class="text-medium font-bold">Name: '.$row['name'].'</p>
            <p class="text-medium font-bold">Father Name: '.$row['fname'].'</p>
            <p class="text-medium font-bold">Phone No: '.$row['phone'].'</p>
            <p class="text-medium font-bold">Address: '.$row['address'].'</p>
            </div>
            </div>';
            $sql ="SELECT c.id AS cust_id,l.status, l.id,l.days_weeks_month,l.total, c.name, c.fname, c.city, COUNT(c.phone) AS phone_count, COUNT(re.loan_id) AS emi_count, c.photo, l.principle, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi,SUM(re.	installment_amount) as amount_paid,
            (SELECT SUM(repay_amount) FROM principle_repayment WHERE loan_id = l.id) AS total_principal_paid
          FROM customers AS c
          JOIN loans AS l ON c.id = l.customer_id
          LEFT JOIN repayment AS re ON l.id = re.loan_id
          WHERE c.id = $custid
          GROUP BY c.id, l.id, c.name, c.fname,l.status, c.city, c.photo, l.principle,l.total, l.dor, l.loan_type,l.dor,l.ldol, l.installment, l.roi
          HAVING phone_count > 0";
          
           $result = mysqli_query($conn,$sql);
           if($result){
            echo '<div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-medium uppercase bg-gray-700 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            S.No.
                         </th>
                        <th scope="col" class="px-6 py-3">
                            Loan ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Loan Start Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Loan End Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Loan Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Principal (Loan Amount)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Amount (Principal + Interest)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No. of Installment
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Installment Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount Paid
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Late Fine
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount Due
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount Due with Late Fine
                        </th>
                        <th scope="col" class="px-6 py-3">
                        Loan Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Loan Summary
                        </th>
                    </tr>
                </thead>
                <tbody>';


            $paidamountsum = [];
            $totalprincipleamount = [];
            $totalinstallmentamountduetilldate = [];
            $totalinstallmentamount =[];
            $count = [];
            $totallatefine = [];
            $totalDueWithLateFine = [];
            $i= 1;
            while($row = mysqli_fetch_assoc($result)){
            $loanid = $row['id'];
            $loan_type = $row['loan_type'];
            $paidamountsum[] = $row['amount_paid'];

            $remprincipal = $row['principle']- $row["total_principal_paid"];
            $reminstallmentamount = $remprincipal*($row["roi"]/100);
            
            $count[] =  $row['phone_count'];
                echo '<tr class="border-b bg-gray-800 border-gray-700">
                 <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap ">
                  '. $i++ .'
                   </th>
                 <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap ">
                     '.$row['id'].'
                 </th>
                 <td class="px-6 py-4">
                 '.$row['dor'].'  
                 </td>
                 <td class="px-6 py-4">
                 '.$row['ldol'].'  
                 </td>
                 <td class="px-6 py-4">';
                 if ($loan_type == 1) {
                     echo 'CC Loan';
                   } elseif ($loan_type == 2) {
                     echo 'Daily Loan';
                   } elseif ($loan_type == 3) {
                     echo 'Weekly Loan';
                   } else {
                     echo 'Monthly Loan';
                   }
                 echo '</td>
                 <td class="px-6 py-4">';
                 if($loan_type != 1 ){
                    echo  $row['principle'];
                    $totalprincipleamount[] = $row['principle'];
                 }else{
                     echo $remprincipal;
                     $totalprincipleamount[] = $remprincipal;
                 }
                 echo'</td>';
                 if($loan_type != 1 ){
                     echo '<td class="px-6 py-4">
                     '.$row['total'].' 
                     </td>';
                 }else{
                     echo '<td class="px-6 py-4">
                     NA
                     </td>';
                 } 
                 if ($loan_type != 1){
                      echo '<td class="px-6 py-4">
                     '.$row['days_weeks_month'].'
                     </td>';
                 }else {
                     echo '<td class="px-6 py-4">
                     NA
                     </td>';
                 }
                 echo '<td class="px-6 py-4">';
                 if($loan_type != 1){
                     echo $row['installment'];
                     $totalinstallmentamount[] = $row['installment'];
                 }else{
                    echo $reminstallmentamount;
                    $totalinstallmentamount[] = $reminstallmentamount;
                 }
                 echo '</td>
                 <td class="px-6 py-4">
                 '.$row['amount_paid'].'
                 </td>
                 <td class="px-6 py-4">';
                 include_once "../functions.php";
                 if($loan_type == 1 or $loan_type ==2){
                    $latefine = lateFineCalforCC_daily($loanid);
                    echo $l = array_sum($latefine);
                    $totallatefine[] = $l;
                 }elseif($loan_type==3){
                     $latefine = lateFineCalforweekly($loanid);
                     echo $l = array_sum($latefine);
                      $totallatefine[] = $l;
                  }elseif($loan_type == 4){
                      $latefine = lateFineCalformonthly($loanid);
                      echo $l = array_sum($latefine);
                      $totallatefine[] = $l;
                  }
                  echo '</td>
                  <td class="px-6 py-4">';
                  $startDate = strtotime($row['dor']);
                  $today = strtotime(date('Y-m-d'));
                  if ($loan_type == 1) {
                      $frequency = 1;
                  }elseif ($loan_type == 2) {
                      $frequency = 1;
                  } elseif ($loan_type == 3) {
                      $frequency = 7;
                  } else {
                      $frequency = 30;
                  }
            $totalInstallmentstilldate = floor(($today - $startDate) / (60 * 60 * 24 * $frequency)); 
            $currentDate = $startDate;
            $paidInstallments = $row['emi_count'];
            $unpaidInstallments = $totalInstallmentstilldate - $paidInstallments;
            if($loan_type != 1){
                echo $amountDue = $totalInstallmentstilldate*$row['installment'] - $row['amount_paid'];
                $totalinstallmentamountduetilldate[] = $amountDue;
            }else{
                include_once "../functions.php";
                echo $amountDue = totalEmiAmountDue_in_CCloan($loanid);
                $totalinstallmentamountduetilldate[] = $amountDue;
            }
            //some changes may needs to calculate for CC loan type
            echo '</td>
            <td class="px-6 py-4">';
            echo ($amountDue + $l);
            $totalDueWithLateFine[] = ($amountDue + $l);
            echo '</td>
            <td class="px-6 py-4">';
            if($row['status'] == 1){
                echo "Active";
            }else{
                echo "Closed";
            }
            echo '</td>
            <td class="px-6 py-4">     
            <a href="loansummary.php?id='.$row['id'].'"><button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Click</button></a>
            </td>
            </tr>';
            }
            echo '<tr class="text-medium font-bold uppercase bg-gray-700 text-white">
            <td class="px-6 py-4">
            Total
            </td>
            <td class="px-6 py-4">
            '.count($count).'
            </td>
            <td class="px-6 py-4">
            -
            </td>
            <td class="px-6 py-4">
                 --  
                 </td>
            <td class="px-6 py-4">
            - 
            </td>
            <td class="px-6 py-4">
            '.array_sum($totalprincipleamount).'
            </td>
            <td class="px-6 py-4">
            -- 
            </td>
            <td class="px-6 py-4">
            --
            </td>
            <td class="px-6 py-4">
            '.array_sum($totalinstallmentamount).'
            </td>
            <td class="px-6 py-4">
            '.array_sum($paidamountsum).'
            </td>
            <td class="px-6 py-4">
            '.array_sum($totallatefine).'
            </td>
            <td class="px-6 py-4 text-xl">
            '.array_sum($totalinstallmentamountduetilldate).'
            </td>
            <td class="px-6 py-4">
            '.array_sum($totalDueWithLateFine).'
            </td>
            <td class="px-6 py-4">
            --
            </td>
            <td class="px-6 py-4">
            --
            </td>
            </tr>
            </tbody>
            </table>
            <div class="font-bold border border-black p-4 md:p-8">
            
            <p class="text-red-900">Total Amount Due till today (आज तक): '.array_sum($totalinstallmentamountduetilldate).'</p>
            <p>Total Loan Amount: '.array_sum($totalprincipleamount).'</p>
            </div>

        </div>';
           }
        }
    }else {
        echo '<div class="flex p-4 mb-4 text-sm rounded-lg bg-gray-800 text-yellow-300" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div>
      <span class="font-medium">Loan Not Found!</span> Enter Correct CustomerID !
    </div>
  </div>';
    }
    }




include "../footer.php"; 

}



?>