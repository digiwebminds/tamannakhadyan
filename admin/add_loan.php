<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: adminlogin.php');
    exit(); // Make sure to exit after redirecting
}

// Check if the staff is logged in
if (!isset($_SESSION['username_staff'])) {
    header('location: ../staff/login.php');
    exit(); // Make sure to exit after redirecting
}

// At this point, both admin and staff are logged in

if ($_SESSION['emptype'] == 0) {
    header('location: loans.php');
    exit(); // Make sure to exit after redirecting
}

?>
<?php

require_once("../include/connect.php");

if(isset($_GET['lid'])){
    $id = $_GET['lid'];
    $sql2 = "SELECT * FROM loans WHERE id = $id";
    $result = mysqli_query($conn,$sql2);
    $loan = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dorloan = $_POST['dorloan'];
    $loancategory = $_POST['loancategory'];
    $customerid = $_POST['customerid'];
    $principle = $_POST['principle-amount'];
    $comment = $_POST['comment'];
    $installment = $_POST['installment'];
    $timestamp = time();
    $latefine = $_POST['latefine'];
    $latefineafter = $_POST['latefineafter'];
    
    if($loancategory == 1){
        $roi = $_POST['roi'];

        $sql = "INSERT INTO `loans` (`customer_id`, `principle`, `comment`, `dor`, `loan_type`, `installment`,`timestamp`,`roi`,`latefine`,`latefineafter`) VALUES ('$customerid', '$principle', '$comment', '$dorloan', '$loancategory', '$installment',$timestamp,$roi,$latefine,$latefineafter)";

        $result = mysqli_query($conn, $sql);
    
        if ($result) {
    
            echo '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Loan Created!</span><a href="loans.php"> Click here to View Loan Page </a>
              </div>';
        } else {
            die(mysqli_error($conn));
        }
    }else{
        $total = $_POST['total'];
        $days_weeks_months = $_POST['days'];
        $ldol = $_POST['ldorloan'];

        $sql = "INSERT INTO `loans` (`customer_id`, `principle`, `comment`, `dor`, `loan_type`, `installment`,`total`,`days_weeks_month`,`timestamp`,`ldol`,`latefine`,`latefineafter`) VALUES ('$customerid', '$principle', '$comment', '$dorloan', '$loancategory', '$installment',$total,$days_weeks_months,$timestamp,'$ldol',$latefine,$latefineafter)";

        $result = mysqli_query($conn, $sql);
    
        if ($result) {
    
            echo '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Loan Created!</span><a href="loans.php"> Click here to View Loan Page </a>
              </div>';
        } else {
            die(mysqli_error($conn));
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Loan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../include/js/add_loan.js"></script>
</head>

<body>
    <?php
    include "../include/navbar.php";
    date_default_timezone_set("Asia/Calcutta");
    ?>

    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new Loan</h2>
            <form action="" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="dorloan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Registration</label>
                        <input type="date" name="dorloan" id="dorloan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required value="<?php if(isset($_GET['lid'])){echo $loan['dor'];} else{echo date("Y-m-d");} ?>">
                    </div>
                    <div>
                        <label for="customerid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer ID</label>
                        <input type="number" name="customerid" id="customerid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" value="<?php if(isset($_GET['lid'])){echo $loan['customer_id'];} ?>">
                    </div>
                    <div>
                        <label for="loancategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Loan Type</label>
                        <select id="loancategory" name="loancategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option >Select Loan Type</option>
                            <option value="1" <?php if(isset($_GET['lid'])){ if($loan['loan_type'] == 1){echo "selected";}} ?>>CC Loan</option>
                            <option value="2" <?php if(isset($_GET['lid'])){ if($loan['loan_type'] == 2){echo "selected";}} ?>>Daily Loan</option>
                            <option value="3" <?php if(isset($_GET['lid'])){ if($loan['loan_type'] == 3){echo "selected";}} ?>>Weekly Loan</option>
                            <option value="4" <?php if(isset($_GET['lid'])){ if($loan['loan_type'] == 4){echo "selected";}} ?>>Monthly Loan</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="customer-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Name</label>
                        <input type="text" name="customer-name" id="customer-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                    </div>
                    <div id="lcdependent" class="sm:col-span-2">
                    <!-- <div class="w-full">
                        <label for="principle-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Principle Amount</label>
                        <input type="number" name="principle-amount" id="principle-amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div class="w-full">
                        <label for="roi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rate of Interest
                        </label>
                        <input type="text" name="roi" id="roi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required placeholder="%">
                    </div>
                    <div class="w-full">
                        <label for="installment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Installment Amount
                        </label>
                        <input type="text" name="installment" id="installment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                    <div class="w-full">
                        <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Amount
                        </label>
                        <input type="text" name="total" id="total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                    <div class="w-full">
                        <label for="days" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Days
                        </label>
                        <input type="text" name="days" id="days" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                    <div class="w-full">
                        <label for="ldorloan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last date of Repayment</label>
                        <input type="date" name="ldorloan" id="ldorloan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>-->
                    </div>
                    <div class="sm:col-span-2">
                        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                        <textarea name="comment" id="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Your Comments here"></textarea>
                    </div>
                    <button type="submit" name="submit" id="submit" class="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800">
                        Add Loan
                    </button>
                    <?php
                        if(isset($_GET['lid'])){
                            echo '<a href="loans.php" class ="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800">Cancel</a>';
                        }
                    ?>
                </div>
            </form>
        </div>
    </section>

<?php 
    include "../include/footer.php"; 
?>
</body>

</html>