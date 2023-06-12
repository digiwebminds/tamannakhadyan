<?php
require_once "../connect.php";

if(isset($_POST['custid'])){
    $custid = $_POST['custid'];
//     $sql ="SELECT c.name,c.fname,c.phone, c.photo,c.gaddress,l.* FROM customers as c
// JOIN loans as l ON c.id = l.customer_id where c.id = $custid";
$sql = "SELECT * FROM customers where id= $custid";
$result = mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result) > 0){  
        while($row = mysqli_fetch_assoc($result)){

            echo '<div class="border border-gray-400 p-4 flex">
            <div class="w-1/3">
            <img style="width:100px;height:100px;" src="'.$row['photo'].'" alt="Photo" class="float-left mr-4" />
            </div>
            <div class="w-2/3">
            <p class="text-medium font-semibold">Name: '.$row['name'].'</p>
            <p class="text-medium font-semibold">Father Name: '.$row['fname'].'</p>
            <p class="text-medium font-semibold">Phone No: '.$row['phone'].'</p>
            <p class="text-medium font-semibold">Address: '.$row['address'].'</p>
            </div>
            </div>
            ';
            $sql ="SELECT c.name,c.fname,c.phone, c.photo,c.gaddress,l.* FROM customers as c
           JOIN loans as l ON c.id = l.customer_id where c.id = $custid";
           $result = mysqli_query($conn,$sql);
           if($result){
            echo '<div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Loan ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Loan Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Loan Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Principal (Loan Amount)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No. of Installment
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Installment Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount Paid
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount Due
                        </th>
                    </tr>
                </thead>
                <tbody>';
            while($row = mysqli_fetch_assoc($result)){
            $loan_type = $row['loan_type'];
                echo '
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    '.$row['id'].'
                                </th>
                                <td class="px-6 py-4">
                                '.$row['dor'].'  
                                </td>
                                <td class="px-6 py-4">';
                                if ($loan_type == 1) {
                                    echo 'CC Loan';
                                    // $frequency = 1;
                                  } elseif ($loan_type == 2) {
                                    echo 'Daily Loan';
                                    // $frequency = 1;
                                  } elseif ($loan_type == 3) {
                                    echo 'Weekly Loan';
                                    // $frequency = 7;
                                  } else {
                                    echo 'Monthly Loan';
                                    // $frequency = 30;
                                  }
                                echo '</td>
                                <td class="px-6 py-4">
                                '.$row['principle'].' 
                                </td>
                                <td class="px-6 py-4">
                                '.$row['days_weeks_month'].'
                                </td>
                                <td class="px-6 py-4">
                                '.$row['installment'].'
                                </td>
                            </tr>          
                        ';
            }
            echo '</tbody>
            </table>
        </div>';
           }
        }
    }
}

}

?>