<?php
session_start();
include("../../class/DB.php");
include("../../class/function.php");
$namelist = explode(";",$_POST['totaln']);
//print_r($namelist);
for ($i=0;$i<count($namelist);$i++) {
	$HospNo = $namelist[$i];
	$PatientID = getPID($HospNo);
	$Qfiller = $_POST['Qfiller'];
	
	$loinc_8480 = $_POST['vs_84806_'.$HospNo];
	$loinc_8462 = $_POST['vs_84624_'.$HospNo];
	$loinc_8867 = $_POST['vs_88674_'.$HospNo];
	$loinc_2710 = $_POST['vs_27102_'.$HospNo];
	$loinc_14743 = $_POST['vs_14743_'.$HospNo];
	$loinc_150755 = $_POST['vs_150755_'.$HospNo];
	$loinc_8310 = $_POST['vs_83105_'.$HospNo];
	$loinc_9279 = $_POST['vs_92791_'.$HospNo];
	$loinc_460337 = $_POST['vs_460337_'.$HospNo];
	$loinc_188334 = $_POST['vs_188334_'.$HospNo];
	$loinc_391060 = $_POST['vs_391060_'.$HospNo];
	
	if ($_POST['Qdate']!="") {
		$date = str_replace("/","",$_POST['Qdate']);
	} else {
		$date = date(Ymd);
	}
	
	if ($_POST['Qtime']!="") {
		if ($_POST['Qtime2']==60) {
			$minute = mt_rand(0, (date(i)-1));
		} else {
			$minute = $_POST['Qtime2'];
		}
		if (strlen($_POST['Qtime'])==1) { $hour = "0".$_POST['Qtime']; } else { $hour = $_POST['Qtime']; }
		if (strlen($minute)==1) { $minute = "0".$minute; }
		$time = $hour.$minute;
	}	
	
	
	if($loinc_8480!='' || $loinc_8462!='' || $loinc_8867!='' || $loinc_2710!='' || $loinc_14743!='' || $loinc_150755!='' || $loinc_8310!='' || $loinc_9279!='' || $loinc_460337!='' || $loinc_188334!='' || $loinc_391060!=''){
	
	$db0a = new DB;
	$db0a->query("SELECT `VitalSignID` FROM `vitalsign` WHERE `PatientID`='".$PatientID."' AND `date`='".$date."' AND `time`='".$time."'");
	if($db0a->num_rows()>0){
		$sec = substr($time,0,2)*60*60+substr($time,2,2)*60;
		$NEWsec = strtotime("next min", $sec);
		$time = date("Hi",mktime(0,0,$NEWsec));
	}
	
	$db0b = new DB;
	$db0b->query("INSERT INTO `vitalsign` (`VitalSignID`, `PatientID`, `date`, `time`, `Qfiller`) VALUES ('', '".$PatientID."', '".$date."', '".$time."', '".$Qfiller."')");
	$db0c = new DB;
	$db0c->query("SELECT `VitalSignID` FROM `vitalsign` WHERE `PatientID`='".$PatientID."' AND `date`='".$date."' AND `time`='".$time."'");
	$r0c = $db0c->fetch_assoc();
	$VitalSignID = $r0c['VitalSignID'];
	
	if ($loinc_8310!='') { $db1 = new DB; $db1->query("UPDATE `vitalsign` SET `loinc_8310_5`='".$loinc_8310."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_8867!='') { $db2 = new DB; $db2->query("UPDATE `vitalsign` SET `loinc_8867_4`='".$loinc_8867."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_9279!='') { $db3 = new DB; $db3->query("UPDATE `vitalsign` SET `loinc_9279_1`='".$loinc_9279."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_8480!='') { $db4 = new DB; $db4->query("UPDATE `vitalsign` SET `loinc_8480_6`='".$loinc_8480."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_8462!='') { $db5 = new DB; $db5->query("UPDATE `vitalsign` SET `loinc_8462_4`='".$loinc_8462."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_2710!='') { $db6 = new DB; $db6->query("UPDATE `vitalsign` SET `loinc_2710_2`='".$loinc_2710."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_460337!='') { $db7 = new DB; $db7->query("UPDATE `vitalsign` SET `loinc_46033_7`='".$loinc_460337."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_14743!='') {
		$db8 = new DB;
		$db8->query("UPDATE `vitalsign` SET `loinc_14743_9`='".$loinc_14743."' WHERE `VitalSignID`='".$VitalSignID."'");
		if ($_SESSION['ncareglucoseRecord_lwj']==1) {
			$db8a = new DB;
			$db8a->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".$date."', '".date(H).date(i)."', '', 'AC Blood glucose ".$loinc_14743." mg/dl', '', '".$Qfiller."')");
		}
	}
	if ($loinc_150755!='') {
		$db9 = new DB;
		$db9->query("UPDATE `vitalsign` SET `loinc_15075_5`='".$loinc_150755."' WHERE `VitalSignID`='".$VitalSignID."'");
		if ($_SESSION['ncareglucoseRecord_lwj']==1) {
			$db9a = new DB;
			$db9a->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".$date."', '".date(H).(date(i)+1)."', '', 'PC Blood glucose ".$loinc_150755." mg/dl', '', '".$Qfiller."')");
		}
	}
	if ($loinc_391060!='') { $db10 = new DB; $db10->query("UPDATE `vitalsign` SET `loinc_39106_0`='".$loinc_391060."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	if ($loinc_188334!='') { $db11 = new DB; $db11->query("UPDATE `vitalsign` SET `loinc_18833_4`='".$loinc_188334."' WHERE `VitalSignID`='".$VitalSignID."'"); }
	}
}

echo "<script>window.location.href='../../index.php?mod=dailywork&func=resplist2';</script>";
?>