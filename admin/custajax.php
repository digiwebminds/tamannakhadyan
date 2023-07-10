<?php
session_start(); 
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

if(isset($_GET["searchvalue"]) && isset($_GET["searchby"])){
	if($_GET["searchby"] == 1){
		$searchby = "id";
	}elseif($_GET["searchby"] == 2){
		$searchby = "name";
	}elseif($_GET["searchby"] == 3){
		$searchby = "phone";
	}elseif($_GET["searchby"] == 4){
		$searchby = "sname";
	}
	$searchvalue = "%".$_GET["searchvalue"]."%";
	$sql = "SELECT * FROM customers WHERE deleted = 0 AND $searchby LIKE '$searchvalue' ORDER BY id DESC";
	$result  = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($result);
	if($rowcount > 0){
		$_GET["rowcount"] = $rowcount;
	}
	else{
		$nralert = '<div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300" role="alert"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg><span class="sr-only">Info</span><div><span class="font-medium">Customer Not Found!</span> Enter Correct ';
		if($_GET["searchby"] == 1){
			$nralert .= "Customer ID";
		}elseif($_GET["searchby"] == 2){
			$nralert .= "Customer Name";
		}elseif($_GET["searchby"] == 3){
			$nralert .= "Mobile No.";
		}elseif($_GET["searchby"] == 4){
			$nralert .= "Shop Name";
		}
		$nralert .= ' !</div></div>';
		echo $nralert;
		return;
	}
}
else{
	$sql = "SELECT * FROM customers WHERE deleted = 0 ORDER BY id DESC";
}

$paginationlink = "custajax.php?page=";

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
				Cust. Id
			</th>
			<th scope="col" class="px-6 py-3">
				Name
			</th>
			<th scope="col" class="px-6 py-3">
				Address
			</th>
			<th scope="col" class="px-6 py-3">
				Mobile
			</th>
			<th scope="col" class="px-6 py-3">
				Guarantor Name
			</th>
			<th scope="col" class="px-6 py-3">
				Guarantor Details
			</th>
			<th scope="col" class="px-6 py-3">
				Date of Reg.
			</th>
			<th scope="col" class="px-6 py-3">
				Cust. Photo
			</th>
			<th scope="col" class="px-6 py-3">
				Gtr. Photo
			</th>';
			if($_SESSION['role'] != 0){
				$output .='<th scope="col" class="px-6 py-3">
							</th>
							<th scope="col" class="px-6 py-3">
							</th>';
			}
	$output .= '</tr>
	</thead>
	<tbody>';
$i = $start * 1;
foreach ($faq as $k => $v) {
	$i++;
	if ($faq[$k]['photo'] != null || $faq[$k]['photo'] != '') {
		$image = $faq[$k]['photo'];
	} else {
		$image = "../uploaded/defaultcustomer.png";
	}
	if ($faq[$k]['gphoto'] != null || $faq[$k]['gphoto'] != '') {
		$gimage = $faq[$k]['gphoto'];
	} else {
		$gimage = "../uploaded/defaultcustomer.png";
	}
	$output .= "<tr class='border-b text-gray-200 bg-gray-800 border-gray-700'>
		<th>" . $i . "</th>
		<td>" . $faq[$k]['id'] . "</td>
		<td>" . $faq[$k]['name'] . "</td>
		<td>" . $faq[$k]['address'] . "</td>
		<td>" . $faq[$k]['phone'] . "</td>
		<td>" . $faq[$k]['gname'] . "</td>
		<td>" . $faq[$k]['gaddress'] . "</td>
		<td>" . $faq[$k]['dor'] . "</td>
		<td><img src='$image' style='object-fit:fill; width:60px; height:60px;'></td>
		<td><img src='$gimage' style='object-fit:fill; width:60px; height:60px;'></td>";
	if($_SESSION['role'] != 0){
		$output .= '<td><a class="bg-blue-700 py-1 px-2 rounded" href="add_user.php?id='.$faq[$k]['id'].'">Update</a></td><td><a id="deletecust" class="bg-red-700 py-1 px-2 rounded" href="" value="'.$faq[$k]['id'].'">Delete</a></td></tr>';
	}
}
$output .= '</tbody>
        </table>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;
