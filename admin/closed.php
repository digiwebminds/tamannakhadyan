<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- <title>Add User</title> -->
    <script src="../include/js/closed.js"></script>
</head>

<body>
    <?php
    include "../include/navbar.php";
    ?>
    <!-- <button href="closed.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"><a href="add_user.php">Add User</a></button> -->

    <h2>List of closed loans</h2>

    <div class="relative" id="pagination-result">
        <div id="overlay">
            <div><img src="../include/loading.gif" width="64px" height="64px" /></div>
        </div>

    </div>

    <?php
    include("../include/connect.php");
    // $query = "SELECT * FROM customers WHERE deleted = 0";
    $query = "SELECT DISTINCT l.*
    FROM loans AS l
    JOIN repayment AS r ON l.id = r.loan_id
    WHERE l.days_weeks_month = (
        SELECT COUNT(loan_id)
        FROM repayment
        WHERE loan_id = l.id
    )";

    $result  = mysqli_query($conn, $query);
    $rowcount = mysqli_num_rows($result);
    echo '<input type="hidden" name="rowcount" id="rowcount" value=' . $rowcount . '>';
    ?>
    <script>
        function getresult(url) {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    rowcount: $("#rowcount").val()
                },
                beforeSend: function() {
                    $("#overlay").show();
                },
                success: function(data) {
                    $("#pagination-result").html(data);
                    setInterval(function() {
                        $("#overlay").hide();
                    }, 500);
                }
            });
        }
        getresult("closedajax.php");
    </script>


</body>

</html>