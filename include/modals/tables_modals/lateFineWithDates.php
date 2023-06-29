<?php

echo '<div id="lateFineTableModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  
  <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
    <!-- Modal Content -->
    <div class="modal-content py-4 text-left px-6">
      <!-- Close Button/Icon -->

      <button id="closeLateFineTableModal" class="close-button border bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
      <i class="fa-solid fa-xmark"></i>
</button>
      <table class="text-left w-full border">
		<thead class="bg-black flex text-white w-full border">
			<tr class="flex w-full mb-1 border">
				<th class="p-4 w-1/2">Date</th>
				<th class="p-4 w-1/2">Late Fine</th>
			</tr>
		</thead>
    <!-- Remove the nasty inline CSS fixed height on production and replace it with a CSS class — this is just for demonstration purposes! -->
		<tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 30vh;">
			';

      foreach($lateFinearray as $date => $latefine){

        echo '<tr class="flex w-full mb-1 border">
        <td class="p-4 w-1/2 font-bold border">'.$date.'</td>
        <td class="p-4 w-1/2 font-bold border">'.$latefine.'</td>
        </tr>';
        
      }
          echo '
          </tbody>
  </table>
  </div>
  </div>
  </div>
</div>';

?>