<?php
session_start();
if (!isset($_SESSION['username'])){
    header('location:adminlogin.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DashBoard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--google font start-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caladea:ital@1&family=Varela+Round&display=swap" rel="stylesheet">
<style>
  *{
    font-family: 'Caladea', serif;
  font-family: 'Varela Round', sans-serif;
  }
  </style>
  <!--google font end-->
    
</head>
<body>
 <!--Header start-->
<?php 
include "../include/navbar.php";
?>
<!--header end-->
  <!--hero section -->
  <!-- Hero -->
  <div class="bg-slate-900">
  <div class="bg-gradient-to-b from-violet-600/[.15] via-transparent pt-20 pb-20">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-24 space-y-8">
      <!-- Announcement Banner -->
      <!-- <div class="flex justify-center">
        <a class="group inline-block bg-white/[.05] hover:bg-white/[.1] border border-white/[.05] p-1 pl-4 rounded-full shadow-md" href="../figma.html">
          <p class="mr-2 inline-block text-white text-sm">
            Preline UI Figma is live.
          </p>
          <span class="group-hover:bg-white/[.1] py-2 px-3 inline-flex justify-center items-center gap-x-2 rounded-full bg-white/[.075] font-semibold text-white text-sm">
            <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </span>
        </a>
      </div> -->
      <!-- End Announcement Banner -->

      <!-- Title -->
      <div class="max-w-3xl text-center mx-auto">
        <h1 class="block font-medium text-gray-200 text-4xl sm:text-5xl md:text-6xl lg:text-7xl">
          Now it's easier to Manage Track your Loans
        </h1>
      </div>
      <!-- End Title -->

      <div class="max-w-3xl text-center mx-auto">
        <p class="text-lg text-gray-400">Keep track of all the loans from one place</p>
      </div>

      <!-- Buttons -->
      <div class="text-center">
        <a href="#" class="inline-flex justify-center text-xl items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 shadow-lg shadow-transparent hover:shadow-blue-700/50 border border-transparent text-white text-sm font-medium rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white py-3 px-6 focus:ring-offset-gray-800" href="#">
          Staff Login
          <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </a>
      </div>
      <!-- End Buttons -->
    </div>
  </div>
</div>
<!-- End Hero -->
<!-- Footer start-->
<?php 
include "../include/footer.php"; 
?>
<!-- Footer End-->


</body>
</html>