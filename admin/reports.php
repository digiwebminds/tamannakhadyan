<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reports </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../include/js/reports.js"></script>
    <script src="https://kit.fontawesome.com/0ef3c59d0f.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include "../include/navbar.php";
    date_default_timezone_set("Asia/Calcutta");
    ?>

    <section class="bg-white dark:bg-gray-900">
        <div class="py-4 px-4 mx-auto max-w-2xl lg:py-2">
            <!--      <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Enter</h2> -->
            <form action="" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2 relative">
                        <input type="number" name="search_report" id="search_report" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Customer ID" required>
                        <button type="submit" name="submit" id="customeridsearchbutton" class="text-white absolute right-1 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <div id="reportinfo"></div>

</body>

</html>