<?php
session_start();
if (isset($_SESSION['username'])) {
    $role = $_SESSION['role'];
    if ($role == 0) {
        header('location:loans.php');
    } elseif ($role == 1) {
        header('location:loans.php');
    } elseif ($role == 2) {
        //   header('location:dashboard.php') ;
    }
} else {
    header('location: ../index.php');
}

if (time() - $_SESSION['logintime'] > 600) { //subtract new timestamp from the old one
    unset($_SESSION['username'], $_SESSION['logintime']);
    // $_SESSION['logged_in'] = false;
    header("Location:../index.php"); //redirect to index.php
    exit;
} else {
    $_SESSION['logintime'] = time(); //set new timestamp
}
?>
<?php

require_once("../include/connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM staff WHERE id = $id";
    $result = mysqli_query($conn, $sql2);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $emptype = $_POST['emptype'];
    if (isset($_FILES['photo'])) {
        $photo = $_FILES['photo'];
    }
    $salary = $_POST['salary'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $imageupload = null;
    if (isset($_FILES['photo'])) {
        $imagefilename = $photo['name'];
        $imagetemp = $photo['tmp_name'];
        $imageerror = $photo['error'];
        $image_seperate = explode('.', $imagefilename);
        $image_extension = strtolower(end($image_seperate));
        $extension = array("jpg", "jpeg", "png");
        if (in_array($image_extension, $extension)) {
            $imageupload = '../uploaded/' . $imagefilename;
            move_uploaded_file($imagetemp, $imageupload);
        }
    }

    if ($password == $cpassword) {
        if (isset($_GET['id'])) {
            $sid = $_GET['id'];
            $sql = "UPDATE staff SET name='$name', fname='$fname', address='$address', phone='$phone', salary='$salary', username='$username', password='$password' WHERE id='$sid'";
        } else {
            $sql = "INSERT INTO `staff` (name,fname,address,phone,photo,salary,username,password,emptype) VALUES ('$name','$fname','$address','$phone','$imageupload','$salary','$username','$password','$emptype')";
        }
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: staffmembers.php");
            exit();
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../include/js/customers.js"></script>

    <title>Add Staff Member</title>
</head>

<body>
    <?php
    include("../include/navbar.php");
    date_default_timezone_set("Asia/Calcutta");
    ?>
    <section class="bg-gray-400">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Add Employee
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" enctype="multipart/form-data" method="post">
                        <div>
                            <label for="emptype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Loan Type</label>
                            <select id="emptype" name="emptype" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option>Select Employee Type</option>
                                <option value="0">Staff</option>
                                <option value="1">Manager</option>
                            </select>
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                echo "value='" . $user['name'] . "'";
                                                                                                                                                                                                                                                                                                                                                            } ?> required>
                        </div>
                        <div>
                            <label for="fname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Father's Name</label>
                            <input type="text" name="fname" id="fname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                echo "value='" . $user['fname'] . "'";
                                                                                                                                                                                                                                                                                                                                                            } ?> required>
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            <input type="textarea" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                        echo "value='" . $user['address'] . "'";
                                                                                                                                                                                                                                                                                                                                                                    } ?> required>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone No.</label>
                            <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                echo "value='" . $user['phone'] . "'";
                                                                                                                                                                                                                                                                                                                                                            } ?> required placeholder="+91 ">
                        </div>
                        <?php if (!isset($_GET['id'])) { ?>
                            <div>
                                <label for="photo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Photo</label>
                                <input type="file" name="photo" id="photo" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        <?php } ?>
                        <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
                        <div>
                            <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary</label>
                            <input type="text" name="salary" id="salary" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                    echo "value='" . $user['salary'] . "'";
                                                                                                                                                                                                                                                                                                                                                                } ?> required>
                        </div>
                        <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                        echo "value='" . $user['username'] . "'";
                                                                                                                                                                                                                                                                                                                                                                    } ?> required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                            echo "value='" . $user['password'] . "'";
                                                                                                                                                                                                                                                                                                                                                                        } ?> required>
                        </div>
                        <div>
                            <label for="cpassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                            <input type="password" name="cpassword" id="cpassword" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                                                                            echo "value='" . $user['password'] . "'";
                                                                                                                                                                                                                                                                                                                                                                        } ?> required>
                        </div>
                        <button type="submit" name="submit" id="submit" class="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800"><?php if (isset($_GET['id'])) {
                                                                                                                                                                                                                                                                                                                echo "Update Staff Member";
                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                echo "Add Staff Member";
                                                                                                                                                                                                                                                                                                            } ?></button>
                        <?php
                        if (isset($_GET['id'])) {
                            echo '<a href="staffmembers.php" class="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800">Cancel</a>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
<?php
include("../include/footer.php");
?>

</html>