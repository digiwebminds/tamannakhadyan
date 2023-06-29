<?php
  echo '<div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
  // <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  <div class="modal-content bg-white text-gray-800 rounded shadow-lg w-1/2">
    
  <form action="" method="POST">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 p-4">
                    
                    <div>
                        <label for="dorepay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">D.O.Repayment</label>
                        <input type="date" name="dorepay" id="dorepay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div>
                        <label for="loan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan ID</label>
                        <input type="number" name="loan_id" id="loan_id" value="' . $row['id'] . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                    </div>
                    <div>
                        <label for="loantype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan Type</label>
                        <input type="text" name="loantype" id="loantype" value="';
  
        if ($loan_type == 1) {
          echo "CC Loan";
        } elseif ($loan_type == 2) {
          echo "Daily Loan";
        } elseif ($loan_type == 3) {
          echo "Weekly Loan";
        } else {
          echo "Monthly Loan";
        }
  
        echo '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                    </div>
                    <div>
                        <label for="install-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Installment Amount</label>
                        <input type="number" name="install-amount" id="install-amount" value="';
                        if($loan_type==1){
  
                         echo $reminstallmentamount;  
                        }else {
                         echo $row['installment'];
                        }
                        
                        echo '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
  
                    <div>
                        <label for="comment_repay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Comment</label>
                        <input type="text" name="comment_repay" id="comment_repay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
  
                    <div id="repaymentalert"></div>
                    <button type="submit" id="repaysubmitbtnn" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        Pay Installment
                    </button>
                </div>
            </form>
  </div>
  </div>';
?>