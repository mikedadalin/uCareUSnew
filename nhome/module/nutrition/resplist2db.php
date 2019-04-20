<?php
include("../../class/DB.php");
include("../../class/function.php");
$namelist = explode(";",$_POST['totaln']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);
for ($i=0;$i<count($namelist);$i++) {
	$HospNo = $namelist[$i];
	$PersonID = getPID($HospNo);
	$loinc_188334 = $_POST['vs_188334_'.$HospNo];
	if ($_POST['date']!="") {
		$date = str_replace("/","-",$_POST['date']);
	} else {
		$date = date(Y."-".m."-".d);
	}
	$RecordedTime = $date." ".date(H).":".date(i).date(":".s.".0000000");
	$MeasureDateWithYMOnly = substr($date,0,4).substr($date,5,2);
	if ($loinc_188334!='') { $db1 = new DB; $db1->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '18833-4', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_188334."', '1', '".$Qfiller."')"); }
}
echo "<script>window.location.href='../../index.php?mod=nutrition&func=resplist2';</script>";
?>