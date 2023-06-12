<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loans</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <?php
    include ("../include/navbar.php");
    ?>
    <button href="add_user.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"><a href="add_loan.php">Add loan</a></button>
    <h1>fetch loans here</h1>

    <div class="relative" id="pagination-result">
        <div id="overlay">
            <div><img src="../include/loading.gif" width="64px" height="64px" /></div>
        </div>

    </div>

    <?php
    include("../include/connect.php");
    $query = "SELECT * FROM loans";
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
        getresult("loanajax.php");
    </script>

</body>
</html>