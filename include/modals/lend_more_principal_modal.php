<?php

echo '<div id="myModallendprinciple" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
// <div class="modal-overlay outsidemodal absolute w-full h-full bg-gray-900 opacity-50"></div>
<div class="modal-content bg-white text-gray-800 rounded shadow-lg w-1/2">
  
<form action="queries.php" method="POST">
              <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 p-4">
                  <div>
                      <label for="dorepay-principall" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">D.O.Repayment</label>
                      <input type="date" name="dorepay-principall" id="dorepay-principall" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>
                  <div>
                      <label for="loan_idl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan ID</label>
                      <input type="number" name="loan_idl" id="loan_idl" value="' . $loanid . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                  </div>
                  <div>
                      <label for="loantype" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Loan Type</label>
                      <input type="text" name="loantype" id="loantype" value="CC Loan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                  </div>
                  <div>
                      <label for="principle_amount_repayl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Principle Amount</label>
                      <input type="number" name="principle_amount_repayl" id="principle_amount_repayl" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>
                  <div>
                      <label for="comment_prirepayl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">Comment</label>
                      <input type="text" name="comment_prirepayl" id="comment_prirepayl" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                  </div>

                  <div id="principlelendalert"></div>
                  <button type="submit" id="lend-principle-submitbtnn" name="lendMorePrincipalSubmit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                      Give Principle
                  </button>
              </div>
          </form>
  
</div>
</div>';

?>