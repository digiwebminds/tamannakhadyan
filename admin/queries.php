<?php
session_start();
//query to enter emi repayment
if (isset($_POST['emiRepaySubmit'])) {
    require_once "../include/connect.php";
    $dorepay = $_POST['dorepay'];
    $loanid = $_POST['loan_id'];
    $installmentamt = $_POST['install-amount'];
    $comment = $_POST['comment_repay'];
    $entryby = $_SESSION['username'];
  
    $sql = "INSERT INTO `repayment` (`loan_id`, `DORepayment`, `installment_amount`,`comment_repay`,`entryby`) VALUES ('$loanid', '$dorepay', '$installmentamt','$comment','$entryby')";
    $result = mysqli_query($conn,$sql);
    if($result){
        $message = "Success ! Repayment Done Successfully";
      header("location:repaymentPage.php?loanid=".$loanid."&smessage=".$message);
    }else{
    $message = "Alert ! There is Some Problem Please Try Again";
    header("location:repaymentPage.php?loanid=".$loanid."&emessage=".$message);
    }
  }

// queries to enter principal repayment
  if (isset($_POST['repayPrincipalSubmit'])) {
    require_once "../include/connect.php";
    $dorepay = $_POST['dorepay-principal'];
    $loanid = $_POST['loan_id'];
    $principleamt = $_POST['principleAmountRepay'];
    $comment = $_POST['comment_prirepay'];
    $info = 0;
    $entryby = $_SESSION['username'];
  
    $sql = "INSERT INTO `principle_repayment` (`loan_id`, `dorepayment`, `repay_amount`,`comment_prirepay`,`entryby`,`info`) VALUES ('$loanid', '$dorepay', '$principleamt','$comment','$entryby','$info')";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo $message = "Success ! Principal Repayment Done Successfully";
        header("location:repaymentPage.php?loanid=".$loanid."&smessage=".$message);
    }else{
        echo $message = "Alert ! There is Some Problem Please Try Again";
        header("location:repaymentPage.php?loanid=".$loanid."&emessage=".$message);
    }
}

//quesries to ender Lend more principal
if (isset($_POST['lendMorePrincipalSubmit'])) {
    require_once "../include/connect.php";
    $dorepay = $_POST['dorepay-principall'];
    $loanid = $_POST['loan_idl'];
    $principleamt = $_POST['principle_amount_repayl'];
    $comment = $_POST['comment_prirepayl'];
    $entryby = $_SESSION['username'];
    $info = 1;
    $principleamt = -$principleamt;
  
    $sql = "INSERT INTO `principle_repayment` (`loan_id`, `dorepayment`, `repay_amount`,`comment_prirepay`,`entryby`,`info`) VALUES ('$loanid', '$dorepay', '$principleamt','$comment','$entryby','$info')";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo $message = "Success ! Lend More Principal Done Successfully";
        header("location:repaymentPage.php?loanid=".$loanid."&smessage=".$message);
    }else{
        echo $message = "Alert ! There is Some Problem Please Try Again";
        header("location:repaymentPage.php?loanid=".$loanid."&emessage=".$message);
    }
}