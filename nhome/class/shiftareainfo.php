<?php
include("DB.php");
$db1 = new DB;
$db1->query("SELECT * FROM `shift_area` ORDER BY `areaID` ASC");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	if ($response==NULL) {
		$response = '[';
	} else {
		$response .= ',';
	}
	$response .= '{ "id": "'.$r1['areaID'].'", "label": "'.$r1['areaName'].'", "value": "'.$r1['areaName'].'" }';
}

echo $response.']';
?>