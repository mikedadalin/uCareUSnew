<?php
include("DB.php");
include("array.php");

$PatientID = $_POST['PID'];
$DateTime = str_replace("/","",$_POST['date']);
$arrDateTime = explode(" ",$DateTime);
$time = str_replace(":","",$arrDateTime[1]);
$Value = $_POST['BWvalue'];
$Qfiller = $_POST['Qfiller'];

$db = new DB;
$db->query("INSERT INTO `vitalsign` (`VitalSignID`, `PatientID`, `date`, `time`, `Qfiller`, `loinc_18833_4`) VALUES ('', '".$PatientID."', '".$arrDateTime[0]."', '".$time."', '".$Qfiller."', '".$Value."')");
echo "OK";
?>