<?php
include("DB.php");
include("array.php");
include("function.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$patientID = getPID($HospNo);
$Qclosedate = str_replace("/","",$_POST['Qclosedate']);
$Qreason = $_POST['Qreason'];
$Qmemo = $_POST['Qmemo'];

$db0 = new DB;
$db0->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".$patientID."'");
$r0 = $db0->fetch_assoc();

$db = new DB;
$db->query("INSERT INTO `closedcase` VALUES ('".$r0['patientID']."','".$r0['indate']."', '".$Qclosedate."','".$Qreason."','".$Qmemo."')");

$db2 = new DB;
$db2->query("DELETE FROM `inpatientinfo` WHERE `bed`='".$r0['bed']."'");

$db2 = new DB;
$db2->query("DELETE FROM `bedinfo` WHERE `bedID`='".$r0['bed']."'");
?>