<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION['username'])){
    header('location:dashboard.php');
} else{

    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        include '../include/connect.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM admin WHERE username='$username' and password='$password'" ;
        $result = mysqli_query($conn,$sql);
    if ($result){
        $num2 = mysqli_num_rows($result);
        if($num2 > 0){
        echo "User Verified";
        session_start();
        $_SESSION['username']=$username;
        // // $_SESSION['email']=$email;
        header ('location:dashboard.php'); 
    } else {
        echo "<script>alert('Invalid Username or Password'); </script>";
        // echo '<script>alert("Your message here");</script>';
        // header ('location:signup.php');
    }
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
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<!--Header start-->
 <nav class="bg-gray-900 w-full z-20 border-b border-gray-200 border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="#" class="flex items-center">
        <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo"> -->
        <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">TamannaKhadyan</span>
    </a>
    <div class="flex md:order-2">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0">Login</button>
        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
          <!-- <span class="sr-only">Open main menu</span> -->
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <!-- <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium text-sm border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 bg-gray-900">
        <li>
          <a href="#" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0" aria-current="page">Contact Us</a>
        </li>
        <li>
          <a href="#" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">About Us</a>
        </li>
        
      </ul> -->
    </div>
    </div>
  </nav>
<!--header end-->

<!-- login Form -->
<!-- <section class="bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight md:text-2xl text-white">
                  Sign in to your account
              </h1>
              <form class="space-y-4 md:space-y-6" action="#" method="post">
                  <div>
                      <label for="username" class="block mb-2 text-sm font-medium text-white">Username</label>
                      <input type="text" name="username" id="username" class="border sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-white">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="border sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div class="flex items-center justify-between">
                      <div class="flex items-start">
                </div>
                  </div>
                  <button type="submit" name="submit" class="w-full text-white hover:bg-primary-700 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-blue-400 bg-blue-800 text-center bg-primary-600 focus:ring-primary-800">Sign in</button>
              </form>
          </div>
      </div>
  </div>
</section> -->





<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Sign in to your account
              </h1>
              <form class="space-y-4 md:space-y-6" action="#" method="post">
                  <div>
                      <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                      <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Your Username" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div class="flex items-center justify-between">
                      <div class="flex items-start"> 
                      </div>
                  </div>
                  <button type="submit" name="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800">Sign in</button>
              </form>
          </div>
      </div>
  </div>
</section>



    
</body>
<?php
  include ("../include/footer.php");
?>
</html>