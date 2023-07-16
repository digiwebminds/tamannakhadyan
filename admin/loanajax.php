<?php
session_start();
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

if(isset($_GET["searchvalue"]) && isset($_GET["searchby"])){
	$searchvalue = "%".$_GET["searchvalue"]."%";
	if($_GET["searchby"] == 1){
		$searchby = "customer_id";
	}elseif($_GET["searchby"] == 2){
		$searchby = "id";
	}elseif($_GET["searchby"] == 3){
		$searchby = "loan_type";
		if(strtolower($_GET["searchvalue"]) == 'cc'){
			$searchvalue = 1;
		}elseif(strtolower($_GET["searchvalue"]) == 'daily'){
			$searchvalue = 2;
		}elseif(strtolower($_GET["searchvalue"]) == 'weekly'){
			$searchvalue = 3;
		}elseif(strtolower($_GET["searchvalue"]) == 'monthly'){
			$searchvalue = 4;
		}
	}
	$sql = "SELECT * FROM loans WHERE status = 1 and delete_status = 0 AND $searchby LIKE '$searchvalue' ORDER BY id DESC";
	$result  = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($result);
	if($rowcount > 0){
		$_GET["rowcount"] = $rowcount;
	}
	else{
		$nralert = '<div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300" role="alert"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg><span class="sr-only">Info</span><div><span class="font-medium">Loan Not Found!</span> Enter Correct ';
		if($_GET["searchby"] == 1){
			$nralert .= "Customer Code";
		}elseif($_GET["searchby"] == 2){
			$nralert .= "Loan Code";
		}elseif($_GET["searchby"] == 3){
			$nralert .= "Loan Type";
		}
		$nralert .= ' !</div></div>';
		echo $nralert;
		return;
	}
}
else{
$sql = "SELECT * from loans WHERE status = 1 and delete_status = 0 ORDER BY id DESC";
}

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
<table class="mb-2 w-full text-sm text-left text-gray-400">
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
			</th>';
			if($_SESSION['role'] != 0){
				$output .='<th scope="col" class="py-2 px-2">
							</th>
							<th scope="col" class="py-2 px-2">
							</th>
							<th scope="col" class="py-2 px-2">
							</th>';
			}

$output .= '</tr>
	</thead>
	<tbody>';
$i = $start * 1;
foreach ($faq as $k => $v) {
	$i++;
	$output .= "<tr class='border-b text-gray-200 bg-gray-800 border-gray-700'>
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
		$sql = "SELECT name, fname FROM customers WHERE id = $userid";
		$result = mysqli_query($conn,$sql);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$name = $row['name'];
			$output .= "<td class='py-2 px-2'>" . $row['name'] . "<br>(S/D of ". $row['fname'].")</td>";
		}
	$output .= "<td class='py-2 px-2'>" . $faq[$k]['principle'] . "</td>
		<td class='py-2 px-2'>" . $faq[$k]['installment'] . "</td>
		<td class='py-2 px-2'>" . $faq[$k]['dor'] . "</td>
		<td class='py-2 px-2'>" . $faq[$k]['ldol'] . "</td>";
		$output .= '<td><a id="repayment" class="bg-cyan-700 py-1 px-2 rounded" href="repaymentPage.php?loanid='.$faq[$k]['id'].'" value="'.$faq[$k]['id'].'">Repayment</a></td>';

	if($_SESSION['role'] != 0){
		$output .= "<td>" . '<a id="closeloan" class="bg-blue-700 py-1 px-2 rounded" href="" value="'.$faq[$k]['id'].'">Close</a></td>
		<td><a id="deleteloan" class="bg-red-700 py-1 px-2 rounded" href="" value="'.$faq[$k]['id'].'">Delete</a></td>';
	}

	$output .= '</tr>';
}
$output .= '</tbody>
       		</table>
			</div>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;