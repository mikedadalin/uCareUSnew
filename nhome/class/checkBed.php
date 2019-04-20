<?php
include("DB.php");
include("array.php");
include("function.php");
$bedID = $_POST['bedID'];

$db0 = new DB;
$db0->query("SELECT * FROM `inpatientinfo` WHERE `bed`='".$bedID."'");

if ($db0->num_rows()>0) {
	$r0 = $db0->fetch_assoc();
	if ($r0['patientID']=='0') {
		echo "OK";
	} else {
		echo "ERROR";
	}
} else {
	echo "OK";
}


?>