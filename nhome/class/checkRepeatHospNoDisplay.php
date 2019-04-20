<?php
include("DB.php");

$HospNoDisplay = $_POST['HospNoDisplay'];
if ($_POST['Type_1']==1) {
	$type = 1;
} elseif ($_POST['Type_2']==1) {
	$type = 2;
} elseif ($_POST['Type_3']==1) {
	$type = 3;
} elseif ($_POST['Type_4']==1) {
	$type = 4;
} elseif ($_POST['Type_5']==1) {
	$type = 5;
} else {
	$type = '';
}

if ($type != '') {
	$db = new DB;
	$db->query("SELECT * FROM `patient` WHERE `type`='".$type."' AND `HospNoDisplay`='".$HospNoDisplay."'");
	
	if ($db->num_rows()>0) {
		echo "F";
	} else {
		echo "T";
	}
} else {
	echo "E";
}
?>