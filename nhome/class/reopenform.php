<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$patientID = getPID($HospNo);
$bedID = $_POST['NewBed'];
$areaID = $_POST['BedArea'];
$reindate = str_replace("/","",$_POST['Reindate']);

$db1 = new DB;
$db1->query("INSERT INTO `inpatientinfo` VALUES ('".$patientID."', '".$bedID."', '".$reindate."')");

$db0 = new DB;
$db0->query("SELECT * FROM `bedinfo` WHERE `bedID`='".$bedID."'");
if ($db0->num_rows()==0) {
	$db1 = new DB;
	$db1->query("INSERT INTO `bedinfo` VALUES ('".$bedID."', '".$areaID."', '36000', '0000')");
}

//echo "INSERT INTO `inpatientinfo` VALUES ('".$patientID."', '".$bedID."', '".$reindate."')";
echo 'OK';
?>