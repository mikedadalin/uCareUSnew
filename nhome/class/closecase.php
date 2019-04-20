<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$patientID = getPID($HospNo);
$Qclosedate = str_replace("/","",$_POST['Qclosedate']);
$Qclosetype = mysql_escape_string($_POST['Qclosetype']);
$Qreason = mysql_escape_string($_POST['Qreason']);
$Qmemo = mysql_escape_string($_POST['Qmemo']);

$db0 = new DB;
$db0->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".$patientID."'");
$r0 = $db0->fetch_assoc();

$dba = new DB;
$dba->query("SELECT * FROM `closedcase` WHERE `patientID`='".$patientID."' AND `indate`='".$r0['indate']."' AND `outdate`='".$Qclosedate."'");
if ($dba->num_rows()>0) {
	$dbb = new DB;
	$dbb->query("DELETE FROM `closedcase` WHERE `patientID`='".$patientID."' AND `indate`='".$r0['indate']."' AND `outdate`='".$Qclosedate."'");
}
$db = new DB;
$db->query("INSERT INTO `closedcase` VALUES ('".$r0['patientID']."','".$r0['indate']."', '".$Qclosedate."','".$Qreason."','".$Qmemo."', '0','".$Qclosetype."')");

$db2 = new DB;
$db2->query("DELETE FROM `inpatientinfo` WHERE `patientID`='".$r0['patientID']."'");
echo "ok";
//$db2 = new DB;
//$db2->query("DELETE FROM `bedinfo` WHERE `bedID`='".$r0['bed']."'");
?>