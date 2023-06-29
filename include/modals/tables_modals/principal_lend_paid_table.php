<?php

echo '<div id="paidprincipaltableModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  
  <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
    <!-- Modal Content -->
    <div class="modal-content py-4 text-left px-6">
      <!-- Close Button/Icon -->

      <button id="closeprincipaltableModal" class="close-button border bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
      <i class="fa-solid fa-xmark"></i>
</button>
      <table class="text-left w-full">
		<thead class="bg-black flex text-white w-full">
			<tr class="flex w-full mb-4">
				<th class="p-1 w-1/4">Date</th>
				<th class="p-1 w-1/4">Installment</th>
        <th class="p-1 w-1/4">Type</th>
			</tr>
		</thead>
    <!-- Remove the nasty inline CSS fixed height on production and replace it with a CSS class — this is just for demonstration purposes! -->
		<tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 30vh;">
			';
      require_once "../connect.php";
      
      $sql3 = "SELECT dorepayment,repay_amount,info FROM `principle_repayment` where loan_id=$loanid";
      $result3 = mysqli_query($conn,$sql3);
      if (mysqli_num_rows($result3) > 0) {
        while ($row3 = mysqli_fetch_assoc($result3)) {
          $info = $row3['info'];

          echo '<tr class="flex w-full mb-4">
          <td class="p-1 w-1/4 font-bold">'.$row3['dorepayment'].'</td>
          <td class="p-1 w-1/4 font-bold">'.$row3['repay_amount'].'</td>
          <td class="p-1 w-1/4 font-bold">';
          if($info == 0){
            echo "Received Principal";
          }elseif($info == 1){
            echo "Given Principal";
          }
          echo'</td>
          </tr>';
            }
          }
				echo'</tbody>
  </table>
  </div>
  </div>
  </div>
</div>';

?>