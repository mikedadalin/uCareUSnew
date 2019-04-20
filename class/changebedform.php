<?php
include("DB.php");
include("array.php");
include("function.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}

$HospNo = $_POST['HospNo'];
$patientID = getPID($HospNo);
$bedID = $_POST['NewBed'];

$db0 = new DB;
$db0->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".$patientID."'");
$r0 = $db0->fetch_assoc();

$indate = $r0['indate'];
$oldbed = $r0['bed'];

$db2 = new DB;
$db2->query("UPDATE `inpatientinfo` SET `patientID`='', `indate`='0' WHERE `bed`='".$r0['bed']."'");

$db1 = new DB;
$db1->query("SELECT * FROM `inpatientinfo` WHERE `bed`='".$bedID."'");

if ($db1->num_rows()>0) {
	$r1 = $db1->fetch_assoc();
	$db1a = new DB;
	$db1a->query("UPDATE `inpatientinfo` SET `patientID`='".$patientID."', `indate`='".$indate."' WHERE `bed`='".$bedID."'");
} else {
	$db1a = new DB;
	$db1a->query("INSERT INTO `inpatientinfo` VALUES ('".$patientID."', '".$bedID."', '".$indate."')");
}

echo $bedID;
?>