<?php
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

$sql = "SELECT * from staff WHERE deleted = 0 ORDER BY id DESC";

$paginationlink = "staffajax.php?page=";

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
				Name
			</th>
			<th scope="col" class="px-6 py-3">
				Father name
			</th>
            <th scope="col" class="px-6 py-3">
                Address
            </th>
			<th scope="col" class="px-6 py-3">
				Phone
			</th>
			<th scope="col" class="px-6 py-3">
                Salary
            </th>
			<th scope="col" class="px-6 py-3">
                Username
			</th>
			<th scope="col" class="px-6 py-3">
				Password
			</th>
			<th scope="col" class="px-6 py-3">
				Photo
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
	$output .= "<tr class='border-b bg-gray-800 border-gray-700'>
		<th>" . $i . "</th>
		<td>" . $faq[$k]['name'] . "</td>
        <td>" . $faq[$k]['fname'] . "</td>
		<td>" . $faq[$k]['address'] . "</td>
		<td>" . $faq[$k]['phone'] . "</td>
		<td>" . $faq[$k]['salary'] . "</td>
		<td>" . $faq[$k]['username'] . "</td>
		<td>" . $faq[$k]['password'] . "</td>
		<td><img src='$image' style='object-fit:fill; width:60px; height:60px;'></td>
		<td>" . '<button> <a href="add_staff.php?id='.$faq[$k]['id'].'">Update</a></button></td>
		<td><button><a href="delete.php?sid='.$faq[$k]['id'].'" >Delete</a></button>
			</tr>';
}
$output .= '</tbody>
        </table>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;
