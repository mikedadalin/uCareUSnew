<?php
include("DB.php");

$bedID = $_POST['bedID'];

$db = new DB;
$db->query("SELECT * FROM `inpatientinfo` WHERE `bed`='".$bedID."'");

if ($db->num_rows()>0) {
	echo "F";
} else {
	echo "T";
}

?>