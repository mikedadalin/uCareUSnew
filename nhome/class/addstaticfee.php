<?php
include("DB.php");

print_r($_POST);

$db = new DB;
$db->query("SELECT `feeID` FROM `staticfee` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' ORDER BY `feeID` DESC LIMIT 0,1");
$r = $db->fetch_assoc();
$feeID = $r['feeID']+1;

if ($_POST['minus']=="checked") {
	$minus = 1;
} else {
	$minus = 0;
}

$db1 = new DB;
$db1->query("INSERT INTO `staticfee` VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".$feeID."', '".mysql_escape_string($_POST['feeName'])."', '".mysql_escape_string($_POST['fee'])."', '".$minus."')");

?>