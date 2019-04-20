<?php
include("DB.php");
$newNP = mysql_escape_string($_POST['newNP']);
$newArea = mysql_escape_string($_POST['newArea']);
$newBedID = mysql_escape_string($_POST['newBedID']);

$db = new DB;
$db->query("SELECT * FROM `bedinfo` WHERE `bedID`='".$newBedID."'");
if ($db->num_rows()>0) {
	echo "repeated";
} else {
	$db1 = new DB;
	$db1->query("INSERT INTO `bedinfo` VALUES ('".$newBedID."', '".$newArea."', '36000', '".$newNP."')");
	echo "OK";
}

?>