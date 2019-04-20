<?php
include("DB.php");

print_r($_POST);

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}

$db = new DB;
$db->query("SELECT `feeID` FROM `staticfee` WHERE `HospNo`='".$_POST['HospNo']."' ORDER BY `feeID` DESC LIMIT 0,1");
$r = $db->fetch_assoc();
$feeID = $r['feeID']+1;

if ($_POST['minus']=="checked") {
	$minus = 1;
} else {
	$minus = 0;
}

$db1 = new DB;
$db1->query("INSERT INTO `staticfee` VALUES ('".$_POST['HospNo']."', '".$feeID."', '".$_POST['feeName']."', '".$_POST['fee']."', '".$minus."')");
?>