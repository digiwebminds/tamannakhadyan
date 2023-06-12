<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<?php
    include "../include/navbar.php";
    date_default_timezone_set("Asia/Calcutta");
    include "../include/connect.php";
    $sql = "SELECT l.*,c.name,c.fname,c.phone,c.sname,c.city FROM loans as l
    JOIN customers as c on c.id=l.customer_id;";
    $result = mysqli_query($conn,$sql);
    if($result){
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

              $loanid = $row['id'];
              $loantype = $row['loan_type'];
              $loanstartDate = $row['dor'];
              $loanendDate = $row['ldol'];

              $sql2 = "SELECT * FROM repayment where loan_id = $loanid";
              $result2 = mysqli_query($conn,$sql2);
              $paidDates = [];
              while($row2 = mysqli_fetch_assoc($result2)){
                  $paidDates[] = $row2['DORepayment'];
              }
            // different calculation for different loantype  
              if($loantype ==1){

                // $startDate = strtotime($loanstartDate);
                // $startDate += 86400;
                // $endDate = strtotime($loanendDate);
                // $currentDate = $startDate;
                    $today = date('Y-m-d');
                    if(!in_array($today, $paidDates)){
                        // Today's date is not found in either array
                        echo '<div class="flex p-2 mb-1 text-sm rounded-lg bg-gray-800 text-yellow-200" role="alert">
                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                         <span class="sr-only">Installment Pending !</span>
                        <div>
                        <div class=""><span class="font-medium">Loan ID:</span> <span class="font-medium text-white">'.$loanid.'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Loan Type:</span> <span class="font-medium text-white">CC Loan</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Name:</span> <span class="font-medium text-white">'.$row['name'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Father Name:</span> <span class="font-medium text-white">'.$row['fname'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Phone:</span> <span class="font-medium text-white">'.$row['phone'].'</span> <br/></div>
                        <div class="pt-0.5 pb-1"><span class="font-medium">Installment Amount:</span> <span class="font-medium text-white">'.$row['installment'].'</span> <br/> </div>

                        <button type="button" class="text-gray-900 bg-white hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-800 hover:bg-white hover:text-blue-900 focus:ring-gray-700 border-gray-700"><a href="repayment.php"> Repayment Page</a></button>

                        
                         </div>
                         </div>';
                    }
            
            }elseif($loantype == 2){
                $startDate = strtotime($loanstartDate);
                $startDate += 86400;
                $endDate = strtotime($loanendDate);
                $currentDate = $startDate;
                $emiDates = [];
                 //calculating the all emi dates
                while ($currentDate <= $endDate){
                
                $date = date('Y-m-d', $currentDate);
                $emiDates[] = $date; 
                $currentDate = strtotime('+1 day', $currentDate);
                }

                $today = date('Y-m-d');
                if (in_array($today, $emiDates)) {
                    if(!in_array($today, $paidDates)){
                        // Today's date is not found in either array
                        echo '<div class="flex p-2 mb-1 text-sm rounded-lg bg-gray-800 text-yellow-200" role="alert">
                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                         <span class="sr-only">Installment Pending !</span>
                        <div>
                        <div class=""><span class="font-medium">Loan ID:</span> <span class="font-medium text-white">'.$loanid.'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Loan Type:</span> <span class="font-medium text-white"> Daily</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Name:</span> <span class="font-medium text-white">'.$row['name'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Father Name:</span> <span class="font-medium text-white">'.$row['fname'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Phone:</span> <span class="font-medium text-white">'.$row['phone'].'</span> <br/></div>
                        <div class="pt-0.5 pb-1"><span class="font-medium">Installment Amount:</span> <span class="font-medium text-white">'.$row['installment'].'</span> <br/> </div>

                        <button type="button" class="text-gray-900 bg-white hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-800 hover:bg-white hover:text-blue-900 focus:ring-gray-700 border-gray-700"><a href="repayment.php"> Repayment Page</a></button>

                        
                         </div>
                         </div>';
                    }
                } 

              }elseif($loantype == 3){
                $startDate = strtotime($loanstartDate);
                $startDate += 86400*7;
                $endDate = strtotime($loanendDate);
                $currentDate = $startDate;
                $emiDates = [];
                 //calculating the all emi dates
                while ($currentDate <= $endDate){
                
                $date = date('Y-m-d', $currentDate);
                $emiDates[] = $date; 
                $currentDate = strtotime('+7 day', $currentDate);
                }

                $today = date('Y-m-d');
                if (in_array($today, $emiDates)) {
                    if(!in_array($today, $paidDates)){
                        // Today's date is not found in either array
                        echo '<div class="flex p-2 mb-1 text-sm rounded-lg bg-gray-800 text-yellow-200" role="alert">
                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                         <span class="sr-only">Installment Pending !</span>
                        <div>
                        <div class=""><span class="font-medium">Loan ID:</span> <span class="font-medium text-white">'.$loanid.'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Loan Type:</span> <span class="font-medium text-white"> Weekly </span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Name:</span> <span class="font-medium text-white">'.$row['name'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Father Name:</span> <span class="font-medium text-white">'.$row['fname'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Phone:</span> <span class="font-medium text-white">'.$row['phone'].'</span> <br/></div>
                        <div class="pt-0.5 pb-1"><span class="font-medium">Installment Amount:</span> <span class="font-medium text-white">'.$row['installment'].'</span> <br/> </div>

                        <button type="button" class="text-gray-900 bg-white hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-800 hover:bg-white hover:text-blue-900 focus:ring-gray-700 border-gray-700"><a href="repayment.php"> Repayment Page</a></button>

                        
                         </div>
                         </div>';
                    }
                } 
              }elseif($loantype == 4){
                $startDate = strtotime($loanstartDate);
                $startDate += 86400*30;
                $endDate = strtotime($loanendDate);
                $currentDate = $startDate;
                $emiDates = [];
                 //calculating the all emi dates
                while ($currentDate <= $endDate){
                
                $date = date('Y-m-d', $currentDate);
                $emiDates[] = $date; 
                $currentDate = strtotime('+30 day', $currentDate);
                }

                $today = date('Y-m-d');
                
                if (in_array($today, $emiDates)) {
                    if(!in_array($today, $paidDates)){
                        // Today's date is not found in either array
                        echo '<div class="flex p-2 mb-1 text-sm rounded-lg bg-gray-800 text-yellow-200" role="alert">
                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                         <span class="sr-only">Installment Pending !</span>
                        <div>
                        <div class=""><span class="font-medium">Loan ID:</span> <span class="font-medium text-white">'.$loanid.'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Loan Type:</span> <span class="font-medium text-white"> Monthly</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Name:</span> <span class="font-medium text-white">'.$row['name'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Father Name:</span> <span class="font-medium text-white">'.$row['fname'].'</span> <br/></div>
                        <div class="pt-0.5"><span class="font-medium">Phone:</span> <span class="font-medium text-white">'.$row['phone'].'</span> <br/></div>
                        <div class="pt-0.5 pb-1"><span class="font-medium">Installment Amount:</span> <span class="font-medium text-white">'.$row['installment'].'</span> <br/> </div>

                        <button type="button" class="text-gray-900 bg-white hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-800 hover:bg-white hover:text-blue-900 focus:ring-gray-700 border-gray-700"><a href="repayment.php"> Repayment Page</a></button>

                        
                         </div>
                         </div>';
                    }
                }
              }
            }
        }
    }
?>
</body>
</html>