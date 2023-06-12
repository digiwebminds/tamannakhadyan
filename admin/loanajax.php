<?php
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

$sql = "SELECT * from loans";
$paginationlink = "loanajax.php?page=";

$page = 1;
if (!empty($_GET["page"])) {
	$page = $_GET["page"];
}

$start = ($page - 1) * $perPage->perpage;
if ($start < 0) $start = 0;

$query =  $sql . " limit " . $start . "," . $perPage->perpage;
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
	$resultset[] = $row;
}
$faq = $resultset;

if (empty($_GET["rowcount"])) {
	$result  = mysqli_query($conn, $query);
	$rowcount = mysqli_num_rows($result);
	$_GET["rowcount"] = $rowcount;
}
$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink);

$output = '';
$output .= '<table class="w-full text-sm text-left text-gray-400">
	<thead class="text-xs uppercase bg-gray-700 text-gray-200">
		<tr>
			<th scope="col" class="px-6 py-3">
				S.no.
			</th>
			<th scope="col" class="px-6 py-3">
				Loan type
			</th>
			<th scope="col" class="px-6 py-3">
				Cust. Id
			</th>
			<th scope="col" class="px-6 py-3">
				Cust. Name
			</th>
			<th scope="col" class="px-6 py-3">
                Principal
            </th>
			<th scope="col" class="px-6 py-3">
                Installment
			</th>
			<th scope="col" class="px-6 py-3">
				Date of Reg.
			</th>
			<th scope="col" class="px-6 py-3">
			</th>
		</tr>
	</thead>
	<tbody>';
$i = $start * 1;
foreach ($faq as $k => $v) {
	$i++;
	$output .= "<tr class='border-b bg-gray-800 border-gray-700'>
		<th>" . $i . "</th>
		<td>" . $faq[$k]['loan_type'] . "</td>
		<td>" . $faq[$k]['customer_id'] . "</td>
		<td>" . $faq[$k]['customer_name'] . "</td>
		<td>" . $faq[$k]['principle'] . "</td>
		<td>" . $faq[$k]['installment'] . "</td>
		<td>" . $faq[$k]['dor'] . "</td>
		<td>" . '<button> <a href="update.php?updateSno=' . $faq[$k]['id'] . '" > Update</a></button> <button><a href="delete.php?deleteSno=' . $faq[$k]['id'] . '" > Delete </a> </button></td>
			</tr>';
}
$output .= '</tbody>
        </table>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;
// foreach ($faq as $k => $v) {
// 	$i++;
// 	$output .= "<tr class='border-b bg-gray-800 border-gray-700'>
// 		<th>" . $i . "</th>
// 		<td>";
//     if($faq[$k]['loan_type'] == 1){ $output .= "CC";}
//     if($faq[$k]['loan_type'] == 2){ $output .= "Daily";}
//     if($faq[$k]['loan_type'] == 3){ $output .= "Weekly";}
//     if($faq[$k]['loan_type'] == 4){ $output .= "Monthly";}
//     $output = "</td>
// 		<td>" . $faq[$k]['customer_id'] . "</td>
// 		<td>" . $faq[$k]['customer_name'] . "</td>
// 		<td>" . $faq[$k]['principle'] . "</td>
// 		<td>" . $faq[$k]['installment'] . "</td>\
// 		<td>" . $faq[$k]['dor'] . "</td>
// 		<td>" . '<button> <a href="update.php?updateSno=' . $faq[$k]['id'] . '" > Update</a></button> <button><a href="delete.php?deleteSno=' . $faq[$k]['id'] . '" > Delete </a> </button></td>
// 			</tr>';
// }