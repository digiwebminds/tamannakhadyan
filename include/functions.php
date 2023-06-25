<?php
function totalEmiAmountDue_in_CCloan($loanid){

    include 'connect.php';

    $sql4 = "SELECT * FROM loans WHERE id = $loanid";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_assoc($result4);
    
    $loanStartDate = $row4['dor']; // Loan start date
    $startDate = strtotime($loanStartDate); // Convert to epoch format
    $startDate += 86400;
    $initial_loan_amount = $row4['principle'];
    $installmentamount = $row4['installment'];
    $roi = ($installmentamount * 100) / $initial_loan_amount;
    $loanLastDate = time();
    
    // Fetch sum of all repayment from the repayment table
    $sql6 = "SELECT sum(installment_amount) as sum_of_repayments FROM repayment WHERE loan_id = $loanid";
    $result6 = mysqli_query($conn, $sql6);
    $row6 = mysqli_fetch_assoc($result6);
    $total_repayment_amount = $row6['sum_of_repayments'];


    // Fetch Principal payment dates from the repayment table
    $sql5 = "SELECT * FROM principle_repayment WHERE loan_id = $loanid ORDER BY dorepayment ASC";
    $result5 = mysqli_query($conn, $sql5);
    $paidDates = [];
    while ($row5 = mysqli_fetch_assoc($result5)) {
      $repayDate = $row5['dorepayment'];
      $paidDates[$repayDate] = [
        'repay_amount' => $row5['repay_amount']
      ];
    }
    
    $alldues = [];
    $previousDate = $startDate;
    foreach ($paidDates as $repayDate => $values) {
      $repayEpoch = strtotime($repayDate); // Convert repayment date to epoch format
        while ($previousDate <= $repayEpoch) {
          $installmentNew = ($initial_loan_amount * $roi / 100);
          $alldues[date('Y-m-d', $previousDate)] = $installmentNew; // Store installment change for the date
          $previousDate += 86400; // Move to the next day (86400 seconds = 1 day)
        }
      $previousDate = $repayEpoch + 86400; // Move to the next day after the repayment date
      $initial_loan_amount -= $values['repay_amount'];
    }
    // Calculate installment changes from the last repayment date till the current date
    while ($previousDate <= $loanLastDate) {
      $installmentChange = ($initial_loan_amount * $roi / 100); // Calculate installment change
      $alldues[date('Y-m-d', $previousDate)] = $installmentChange; // Store installment change for the date
      $previousDate += 86400; // Move to the next day (86400 seconds = 1 day)
    }
    return $Final_emi_cc_due = (array_sum($alldues) - $total_repayment_amount);
    

}
?>