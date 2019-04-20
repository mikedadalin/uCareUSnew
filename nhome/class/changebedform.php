<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$patientID = getPID($HospNo);
$bedID = strtoupper($_POST['NewBed']);
$areaID = $_POST['BedArea'];

$db0 = new DB;
$db0->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".$patientID."'");
$r0 = $db0->fetch_assoc();

$indate = $r0['indate'];
$oldbed = strtoupper($r0['bed']);

$db2 = new DB;
$db2->query("DELETE FROM `inpatientinfo` WHERE `bed`='".strtoupper($r0['bed'])."'");

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

$db1b = new DB;
$db1b->query("SELECT * FROM `bedinfo` WHERE `bedID`='".$bedID."'");
if ($db1b->num_rows()==0) {
	$db1c = new DB;
	$db1c->query("INSERT INTO `bedinfo` VALUES ('".$bedID."', '".$areaID."', '36000', '')");
} else {
	$r1b = $db1b->fetch_assoc();
	if ($r1b['Area']=="") {
		$db1c = new DB;
		$db1c->query("UPDATE `bedinfo` SET `Area`='".$areaID."' WHERE `bedID`='".$bedID."'");
	}
}

echo $bedID;

?>