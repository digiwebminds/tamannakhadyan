<?php
require_once("../include/connect.php");
require_once("pagination.class.php");

$perPage = new PerPage();

$sql =  "SELECT DISTINCT l.*
FROM loans AS l
JOIN repayment AS r ON l.id = r.loan_id
WHERE l.days_weeks_month = (
    SELECT COUNT(loan_id)
    FROM repayment
    WHERE loan_id = l.id
)";
$paginationlink = "closedajax.php?page=";

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
				loan_id
			</th>
			<th scope="col" class="px-6 py-3">
				Cust. Id
			</th>
			<th scope="col" class="px-6 py-3">
				Name
			</th>
			<th scope="col" class="px-6 py-3">
				principle
			</th>
			<th scope="col" class="px-6 py-3">
				duration
			</th>
			<th scope="col" class="px-6 py-3">
				loan type
			</th>
			
		</tr>
	</thead>
	<tbody>';
$i = $start * 1;
foreach ($faq as $k => $v) {
	$i++;
	$output .= "<tr class='border-b bg-gray-800 border-gray-700'>
		<th>" . $i . "</th>
        <td>" . $faq[$k]['id'] . "</td>
        <td>" . $faq[$k]['customer_id'] . "</td>
		<td>" . $faq[$k]['customer_name'] . "</td>
		<td>" . $faq[$k]['principle'] . "</td>
		<td>" . $faq[$k]['days_weeks_month'] . "</td>
		<td>" . $faq[$k]['loan_type'] . "</td>
			</tr>";
}
$output .= '</tbody>
        </table>';
if (!empty($perpageresult)) {
	$output .= '<div id="pagination grid h-screen place-items-center">' . $perpageresult . '</div>';
}
print $output;
