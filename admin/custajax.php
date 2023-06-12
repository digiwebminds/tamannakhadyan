<?php
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

$sql = "SELECT * FROM customers WHERE deleted = 0";
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
			</th>
			<th scope="col" class="px-6 py-3">
			</th>
			<th scope="col" class="px-6 py-3">
			</th>
		</tr>
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
	$output .= "<tr class='border-b bg-gray-800 border-gray-700'>
		<th>" . $i . "</th>
		<td>" . $faq[$k]['id'] . "</td>
		<td>" . $faq[$k]['name'] . "</td>
		<td>" . $faq[$k]['address'] . "</td>
		<td>" . $faq[$k]['phone'] . "</td>
		<td>" . $faq[$k]['gname'] . "</td>
		<td>" . $faq[$k]['gaddress'] . "</td>
		<td>" . $faq[$k]['dor'] . "</td>
		<td><img src='$image' style='object-fit:fill; width:60px; height:60px;'></td>
		<td><img src='$gimage' style='object-fit:fill; width:60px; height:60px;'></td>
		<td>" . '<button> <a href="add_user.php?id='.$faq[$k]['id'].'">Update</a></button></td>
		<td><button><a href="delete.php?id='.$faq[$k]['id'].'" >Delete</a></button>
			</tr>';
}
$output .= '</tbody>
        </table>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;
