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

$input = $_POST['input_'.$HospNo];
$output1 = $_POST['output1_'.$HospNo];
$output2 = $_POST['output2_'.$HospNo];
$output3 = $_POST['output3_'.$HospNo];
$output = $output1 + $output2 + $output3;
$iostatus = $input - $output;

$RecordedTime = $_POST['date']." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2).date(":s.0000000");

$db1 = new DB;
$db1->query("INSERT INTO `iostatus` VALUES ('', '".$PersonID."', '".$input."', '".$output."', '".$output1."', '".$output2."', '".$output3."', '".$iostatus."', '".$Qfiller."')");
?>