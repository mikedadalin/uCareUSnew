<?php
include("DB.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}

$date = str_replace("/",'',$_POST['date']);
$memo = str_replace("\n","<br>",$_POST['memo']);

$db = new DB;
$db->query("SELECT `feeID` FROM `monthlyfee` WHERE `HospNo`='".$_POST['HospNo']."' AND `date`='".$date."' ORDER BY `feeID` DESC LIMIT 0,1");
$r = $db->fetch_assoc();
$feeID = $r['feeID']+1;

if ($_POST['minus']=="checked") {
	$minus = 1;
} else {
	$minus = 0;
}

$db1 = new DB;
$db1->query("INSERT INTO `monthlyfee` VALUES ('".$_POST['HospNo']."', '".$date."', '".$feeID."', '".$_POST['feeName']."', '".$_POST['fee']."', '".$memo."', '".$minus."')");
?>