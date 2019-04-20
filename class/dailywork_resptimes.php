<?php
include("DB.php");
include("array.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$bedID = $_POST['bedID'];

$db0 = new DB;
$db0->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$bedID."'");
$r0 = $db0->fetch_assoc();
$PersonID = $r0['patientID'];

$loinc_8480 = $_POST['loinc_8480-6'];
$loinc_8462 = $_POST['loinc_8462-4'];
$loinc_8867 = $_POST['loinc_8867-4'];
$loinc_2710 = $_POST['loinc_2710-2'];
$loinc_14743 = $_POST['loinc_14743-9'];
$loinc_8310 = $_POST['loinc_8310-5'];
$loinc_9279 = $_POST['loinc_9279-1'];
$RecordedTime = $_POST['date']." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2).date(":s.0000000");

if ($loinc_8480!='') { $db1 = new DB; $db1->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8480-6', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8480."', '1')"); }
if ($loinc_8462!='') { $db2 = new DB; $db2->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8462-4', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8462."', '1')"); }
if ($loinc_8867!='') { $db3 = new DB; $db3->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8867-4', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8867."', '1')"); }
if ($loinc_2710!='') { $db4 = new DB; $db4->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '2710-2', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_2710."', '1')"); }
if ($loinc_14743!='') { $db5 = new DB; $db5->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '14743-9', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_14743."', '1')"); }
if ($loinc_8310!='') { $db6 = new DB; $db6->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8310-5', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8310."', '1')"); }
if ($loinc_9279!='') { $db7 = new DB; $db7->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '9279-1', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_9279."', '1')"); }
?>