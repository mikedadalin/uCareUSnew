<?php
include("DB.php");
include("array.php");
$HospNo = $_POST['HospNo'];
$drugName = $_POST['drugName'];

$medname = explode('(',$drugName);
$medname1 = trim($medname[0]);
$medname2 = explode(')',$medname[1]);
$medname2 = trim($medname2[0]);
$db0 = new DB;
$db0->query("SELECT `drugID` FROM `drug` WHERE `name` = '".$medname1."' AND `name2` = '".$medname2."'");
$r0 = $db0->fetch_assoc();
$drugID = $r0['drugID'];

$db = new DB;
$db->query("INSERT INTO `allergicmed` VALUES ('".$HospNo."','".$drugID."','".$drugName."')");
$db2 = new DB;
$db2->query("SELECT * FROM `allergicmed` WHERE `HospNo` = '".$HospNo."'");
$number = $db2->num_rows();
echo $drugName.":".$number;
?>