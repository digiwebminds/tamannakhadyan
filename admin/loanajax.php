<?php
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

$sql = "SELECT * from loans ORDER BY id DESC";
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
$output .= '
<div class="relative overflow-x-auto">
<table class="mt-5 mb-2 w-full text-sm text-left text-gray-400">
	<thead class="text-medium uppercase bg-gray-700 text-white">
		<tr>
			<th scope="col" class="py-2 px-2">
				S.no.
			</th>
			<th scope="col" class="py-2 px-2">
				Loan Id
			</th>
			<th scope="col" class="py-2 px-2">
				Loan type
			</th>
			<th scope="col" class="py-2 px-2">
				Cust. Id
			</th>
			<th scope="col" class="py-2 px-2">
				Cust. Name
			</th>
			<th scope="col" class="py-2 px-2">
                Principal
            </th>
			<th scope="col" class="py-2 px-2">
                Installment
			</th>
			<th scope="col" class="py-2 px-2">
				Date of Reg.
			</th>
			<th scope="col" class="py-2 px-2">
				Loan End Date
			</th>
			<th scope="col" class="py-2 px-2">
			Action
			</th>
		</tr>
	</thead>
	<tbody>';
$i = $start * 1;
foreach ($faq as $k => $v) {
	$i++;
	$output .= "<tr class='border-b bg-gray-800 border-gray-700'>
		<th class='py-2 px-2'>" . $i . "</th>
		<td class='py-2 px-2'>" . $faq[$k]['id'] . "</td>";
		if($faq[$k]['loan_type'] == 1){
			$output .= "<td class='py-2 px-2' >CC</td>";
		}
		if($faq[$k]['loan_type'] == 2){
			$output .= "<td class='py-2 px-2' >Daily</td>";
		}
		if($faq[$k]['loan_type'] == 3){
			$output .= "<td class='py-2 px-2' >Weekly</td>";
		}
		if($faq[$k]['loan_type'] == 4){
			$output .= "<td class='py-2 px-2'>Monthly</td>";
		}
	$output .= "
		<td class='py-2 px-2' >" . $faq[$k]['customer_id'] . "</td>";
		$userid = $faq[$k]['customer_id'];
		$sql = "SELECT name FROM customers WHERE id = $userid";
		$result = mysqli_query($conn,$sql);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$name = $row['name'];
			$output .= "<td class='py-2 px-2'>" . $row['name'] . "</td>";
		}
	$output .= "<td class='py-2 px-2'>" . $faq[$k]['principle'] . "</td>
		<td class='py-2 px-2'>" . $faq[$k]['installment'] . "</td>
		<td class='py-2 px-2'>" . $faq[$k]['dor'] . "</td>
		<td class='py-2 px-2'>" . $faq[$k]['ldol'] . "</td>
		<td class='py-2 px-2'>" . '<button> <a href="add_loan.php?lid=' . $faq[$k]['id'] . '" > Update</a></button> <button><a href="delete.php?lid=' . $faq[$k]['id'] . '" > Delete </a> </button></td>
		</tr>
		';
}
$output .= '</tbody>
       		</table>
			</div>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;