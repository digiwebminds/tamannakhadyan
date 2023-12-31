<?php
session_start();
if (isset($_SESSION['username'])){
  $role = $_SESSION['role'];
  if($role == 0){
  //   header('location:loans.php') ;
  }elseif($role == 1){
  //   header('location:loans.php') ;
  }elseif($role == 2){
  //   header('location:dashboard.php') ;
  }
}else{
    header('location: ../index.php');
}
if(time() - $_SESSION['logintime'] > 600) { //subtract new timestamp from the old one
  unset($_SESSION['username'], $_SESSION['logintime']);
  // $_SESSION['logged_in'] = false;
  header("Location:../index.php"); //redirect to index.php
  exit;
} else {
  $_SESSION['logintime'] = time(); //set new timestamp
}
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $loadid = $_POST['search-loanid'];
  header('location:repaymentPage.php?loanid='.$loadid);

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repayments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../include/js/repayment.js"></script>
    <script src="https://kit.fontawesome.com/0ef3c59d0f.js" crossorigin="anonymous"></script>
  <style>
  .modal {
    display: none;
  }

  .modal-overlay {
    opacity: 0.5;
    z-index: -1;
  }

  .modal-header {
    border-color: #ddd;
  }
</style>
</head>
<body>
    <?php
    include "../include/navbar.php";
    ?>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-4 px-4 mx-auto max-w-2xl lg:py-2">
            <!--<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Enter</h2> -->
            <form action="" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2 relative">
                      <form action="" method="post">

                        <input type="number" name="search-loanid" id="search-loanid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Loan ID" required>

                        <button type="submit" name="submit" id="loanidsearchbutton" class="text-white absolute right-1 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                      </form>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <div id="loaninfo"></div>

    <!-- model code -->

    <!-- <button id="openModalButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Open Modal</button> -->

    <?php 
    include "../include/footer.php"; 
    ?>
</body>

</html>