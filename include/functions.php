<?php

// total emi amount due in cc loan , according to current principal amount left
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
      // print($initial_loan_amount);
    }
    // Calculate installment changes from the last repayment date till the current date
    while ($previousDate <= $loanLastDate) {
      $installmentChange = ($initial_loan_amount * $roi / 100); // Calculate installment change
      $alldues[date('Y-m-d', $previousDate)] = $installmentChange; // Store installment change for the date
      $previousDate += 86400; // Move to the next day (86400 seconds = 1 day)
    }
    return $Final_emi_cc_due = (array_sum($alldues) - $total_repayment_amount);
}



// to calculate late Fine for CC and enter into Principal

function lateFineCalforCC($loanid){
  include "connect.php";
  $sqlloan = "SELECT * FROM loans WHERE id = $loanid";
  $resultloan = mysqli_query($conn, $sqlloan);
  $rowloan = mysqli_fetch_assoc($resultloan);
  
  $sqlrepayment = "SELECT * FROM repayment WHERE loan_id = $loanid ORDER BY DORepayment ASC";
  $resultrepayment = mysqli_query($conn, $sqlrepayment);
  
  $paidDates = [];
  while ($rowrepay = mysqli_fetch_assoc($resultrepayment)) {
    $paidDates[] = strtotime($rowrepay['DORepayment']); // Convert repayment dates to epoch format and store in an array
  }
  
  $loanStartDate = $rowloan['dor']; // Loan start date
  $startDate = strtotime($loanStartDate); // Convert to epoch format
  $startDate += 86400;
  $lateFine = $rowloan['latefine'];
  $lateFineAfter = $rowloan['latefineafter'];
  $loanLastDate = time();
  
  $totalLateFine = [];
  $previousDate = $startDate;
  
  foreach ($paidDates as $pd) {
    $pdEpoch = $pd;
    $lateFineAfterEpoch = 86400 * $lateFineAfter; // Convert days into seconds
    $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
    if ($fineStartDate <= $pdEpoch) {
      $currentDate = $previousDate;
      while ($currentDate < $pdEpoch) {
        $dateKey = date('Y-m-d', $currentDate);
        // Check if the late fine for the date has already been added to the principal repayment table
        $sqlCheck = "SELECT * FROM principle_repayment WHERE loan_id = $loanid AND dorepayment = '$dateKey'";
        $resultCheck = mysqli_query($conn, $sqlCheck);
        $existingRow = mysqli_fetch_assoc($resultCheck);
        
        if (!$existingRow) {
          $lateFine = -$lateFine;
          // Add the late fine to the principal repayment table
          $info = 2;
          $sqlInsert = "INSERT INTO principle_repayment (loan_id, dorepayment,repay_amount,info) VALUES ('$loanid', '$dateKey', $lateFine,'$info')";
          mysqli_query($conn, $sqlInsert);
          $lateFine = -$lateFine;
          $totalLateFine[$dateKey] = $lateFine; // Store the late fine for the date
        }
        else{
          $totalLateFine[$dateKey] = $lateFine;
        }
        
        $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
      }
    }
  
    $previousDate = $pdEpoch + 86400; // Move to the next repayment date
  }
  
  // Calculate late fine from the last repayment date till the current date
  $lateFineAfterEpoch = 86400 * $lateFineAfter; // Convert days into seconds
  $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
  if ($fineStartDate <= $loanLastDate) {
    $currentDate = $previousDate;
    while ($currentDate < $loanLastDate) {
      $dateKey = date('Y-m-d', $currentDate);
      // Check if the late fine for the date has already been added to the principal repayment table
      $sqlCheck = "SELECT * FROM principle_repayment WHERE loan_id = $loanid AND dorepayment = '$dateKey'";
      $resultCheck = mysqli_query($conn, $sqlCheck);
      $existingRow = mysqli_fetch_assoc($resultCheck);
      
      if (!$existingRow) {
        $lateFine = -$lateFine;
        $info = 2;
        // Add the late fine to the principal repayment table
        $sqlInsert = "INSERT INTO principle_repayment (loan_id, dorepayment,repay_amount,info) VALUES ('$loanid', '$dateKey','$lateFine','$info')";
        mysqli_query($conn, $sqlInsert);
        $lateFine = -$lateFine;
        $totalLateFine[$dateKey] = $lateFine; // Store the late fine for the date
      }
      else{
        $totalLateFine[$dateKey] = $lateFine;
      }
      
      $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
    }
  }
  
  return $totalLateFine;
}


// to calculate late Fine for Daily Loans

function lateFineCalfordaily($loanid){
  include "connect.php";
  $sqlloan = "SELECT * FROM loans WHERE id = $loanid";
  $resultloan = mysqli_query($conn, $sqlloan);
  $rowloan = mysqli_fetch_assoc($resultloan);
  
  $sqlrepayment = "SELECT * FROM repayment WHERE loan_id = $loanid ORDER BY DORepayment ASC";
  $resultrepayment = mysqli_query($conn, $sqlrepayment);
  
  $paidDates = [];
  while ($rowrepay = mysqli_fetch_assoc($resultrepayment)) {
    $paidDates[] = strtotime($rowrepay['DORepayment']); // Convert repayment dates to epoch format and store in an array
  }
  
  $loanStartDate = $rowloan['dor']; // Loan start date
  $startDate = strtotime($loanStartDate); // Convert to epoch format
  $startDate += 86400;
  $lateFine = $rowloan['latefine'];
  $lateFineAfter = $rowloan['latefineafter'];
  $loanLastDate = time();
  
  $totalLateFine = [];
  $previousDate = $startDate;
  
  foreach ($paidDates as $pd) {
    $pdEpoch = $pd;
    $lateFineAfterEpoch = 86400 * $lateFineAfter; // Convert days into seconds
    $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
    if ($fineStartDate <= $pdEpoch) {
      $currentDate = $previousDate;
      while ($currentDate < $pdEpoch) {
        $totalLateFine[date('Y-m-d', $currentDate)] = $lateFine; // Store the late fine for the date
        // echo date('Y-m-d',$currentDate);
        // echo "<br/>";
        $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
      }
    }
  
    $previousDate = $pdEpoch + 86400; // Move to the next repayment date
  }
  
  // Calculate late fine from the last repayment date till the current date
  $lateFineAfterEpoch = 86400 * $lateFineAfter; // Convert days into seconds
  $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
  if ($fineStartDate <= $loanLastDate) {
    $currentDate = $previousDate;
    while ($currentDate < $loanLastDate) {
      $totalLateFine[date('Y-m-d', $currentDate)] = $lateFine; // Store the late fine for the date
      // echo date('Y-m-d',$currentDate);
      //   echo "<br/>";
      $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
    }
  }
  // return array_sum($totalLateFine);
  return $totalLateFine;
}



// to calculate late Fine for Weekly Loans
function lateFineCalforweekly($loanid){
  include "connect.php";
  $sqlloan = "SELECT * FROM loans WHERE id = $loanid";
  $resultloan = mysqli_query($conn, $sqlloan);
  $rowloan = mysqli_fetch_assoc($resultloan);
  
  $sqlrepayment = "SELECT * FROM repayment WHERE loan_id = $loanid ORDER BY DORepayment ASC";
  $resultrepayment = mysqli_query($conn, $sqlrepayment);
  
  $paidDates = [];
  while ($rowrepay = mysqli_fetch_assoc($resultrepayment)) {
    $paidDates[] = strtotime($rowrepay['DORepayment']); // Convert repayment dates to epoch format and store in an array
  }
  
  $loanStartDate = $rowloan['dor']; // Loan start date
  $startDate = strtotime($loanStartDate); // Convert to epoch format
  $startDate += 86400;
  $lateFine = $rowloan['latefine'];
  $lateFineAfter = $rowloan['latefineafter'];
  $loanLastDate = time();
  
  $totalLateFine = [];
  $previousDate = $startDate;
  
  foreach ($paidDates as $pd) {
    $pdEpoch = $pd;
    $lateFineAfterEpoch = 86400 * $lateFineAfter * 7; // Convert days into seconds
    $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
    if ($fineStartDate <= $pdEpoch) {
      $currentDate = $previousDate;
      while ($currentDate < $pdEpoch) {
        $totalLateFine[date('Y-m-d', $currentDate)] = $lateFine; // Store the late fine for the date
        // echo date('Y-m-d',$currentDate);
        // echo "<br/>";
        $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
      }
    }
  
    $previousDate = $pdEpoch + 86400; // Move to the next repayment date
  }
  
  // Calculate late fine from the last repayment date till the current date
  $lateFineAfterEpoch = 86400 * $lateFineAfter * 7; // Convert days into seconds
  $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
  if ($fineStartDate <= $loanLastDate) {
    $currentDate = $previousDate;
    while ($currentDate < $loanLastDate) {
      $totalLateFine[date('Y-m-d', $currentDate)] = $lateFine; // Store the late fine for the date
      // echo date('Y-m-d',$currentDate);
      //   echo "<br/>";
      $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
    }
  }
  // return array_sum($totalLateFine);
  return $totalLateFine;
}

// to calculate late Fine for Monthly Loans

function lateFineCalformonthly($loanid){
  include "connect.php";
  $sqlloan = "SELECT * FROM loans WHERE id = $loanid";
  $resultloan = mysqli_query($conn, $sqlloan);
  $rowloan = mysqli_fetch_assoc($resultloan);
  
  $sqlrepayment = "SELECT * FROM repayment WHERE loan_id = $loanid ORDER BY DORepayment ASC";
  $resultrepayment = mysqli_query($conn, $sqlrepayment);
  
  $paidDates = [];
  while ($rowrepay = mysqli_fetch_assoc($resultrepayment)) {
    $paidDates[] = strtotime($rowrepay['DORepayment']); // Convert repayment dates to epoch format and store in an array
  }
  
  $loanStartDate = $rowloan['dor']; // Loan start date
  $startDate = strtotime($loanStartDate); // Convert to epoch format
  $startDate += 86400;
  $lateFine = $rowloan['latefine'];
  $lateFineAfter = $rowloan['latefineafter'];
  $loanLastDate = time();
  
  $totalLateFine = [];
  $previousDate = $startDate;
  
  foreach ($paidDates as $pd) {
    $pdEpoch = $pd;
    $lateFineAfterEpoch = 86400 * $lateFineAfter * 30; // Convert days into seconds
    $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
    if ($fineStartDate <= $pdEpoch) {
      $currentDate = $previousDate;
      while ($currentDate < $pdEpoch) {
        $totalLateFine[date('Y-m-d', $currentDate)] = $lateFine; // Store the late fine for the date
        // echo date('Y-m-d',$currentDate);
        // echo "<br/>";
        $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
      }
    }
  
    $previousDate = $pdEpoch + 86400; // Move to the next repayment date
  }
  
  // Calculate late fine from the last repayment date till the current date
  $lateFineAfterEpoch = 86400 * $lateFineAfter * 30; // Convert days into seconds
  $fineStartDate = $previousDate + $lateFineAfterEpoch; // Calculate the start date for late fine
  
  if ($fineStartDate <= $loanLastDate) {
    $currentDate = $previousDate;
    while ($currentDate < $loanLastDate) {
      $totalLateFine[date('Y-m-d', $currentDate)] = $lateFine; // Store the late fine for the date
      // echo date('Y-m-d',$currentDate);
      //   echo "<br/>";
      $currentDate += 86400; // Move to the next day (86400 seconds = 1 day)
    }
  }
  // return array_sum($totalLateFine);
  return $totalLateFine;
}
?>