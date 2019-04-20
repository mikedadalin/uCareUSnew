<?php
session_start();
include("../../class/DB.php");
include("../../class/function.php");
$namelist = explode(";",$_POST['totaln']);
//print_r($namelist);
for ($i=0;$i<count($namelist);$i++) {
	$HospNo = $namelist[$i];
	$PersonID = getPID($HospNo);
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
	/*if ($_POST['date']!="") {
		$date = str_replace("/","-",$_POST['date']);
		$arrDate = explode("-",$date);
		if (strlen($arrDate[1])==1) { $arrDate[1] = "0".$arrDate[1]; }
		if (strlen($arrDate[2])==1) { $arrDate[2] = "0".$arrDate[2]; }
		$date = $arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
	} else {
		$date = date(Y."-".m."-".d);
	}
	
	$RecordedTime = $date." ".date(H).":".date(i).date(":".s.".0000000");
	$MeasureDateWithYMOnly = substr($date,0,4).substr($date,5,2);*/
	
	if ($_POST['Qdate']!="") {
		$date = str_replace("/","-",$_POST['Qdate']);
		$arrDate = explode("-",$date);
		if (strlen($arrDate[1])==1) { $arrDate[1] = "0".$arrDate[1]; }
		if (strlen($arrDate[2])==1) { $arrDate[2] = "0".$arrDate[2]; }
		$date = $arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
	} else {
		$date = date(Y."-".m."-".d);
	}
	$MeasureDateWithYMOnly = substr($date,0,4).substr($date,5,2);
	
	if ($_POST['Qtime']!="") {
		if ($_POST['Qtime2']==60) {
			$minute = mt_rand(0, (date(i)-1));
		} else {
			$minute = $_POST['Qtime2'];
		}
		if (strlen($_POST['Qtime'])==1) { $hour = "0".$_POST['Qtime']; } else { $hour = $_POST['Qtime']; }
		if (strlen($minute)==1) { $minute = "0".$minute; }
		$time = $hour.':'.$minute.':'.date(s).'.0000000';
		$time2 = $hour.$minute;
	}
	$MeasureTime = $date." ".$time;
	$RecordedTime = date("Y-m-d H:i:s.0000000");
	
	if ($loinc_8480!='') { $db1 = new DB; $db1->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8480-6', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_8480."', '1', '".$Qfiller."')"); }
	if ($loinc_8462!='') { $db2 = new DB; $db2->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8462-4', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_8462."', '1', '".$Qfiller."')"); }
	if ($loinc_8867!='') { $db3 = new DB; $db3->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8867-4', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_8867."', '1', '".$Qfiller."')"); }
	if ($loinc_2710!='') { $db4 = new DB; $db4->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '2710-2', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_2710."', '1', '".$Qfiller."')"); }
	if ($loinc_14743!='') { $db5 = new DB; $db5->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '14743-9', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_14743."', '1', '".$Qfiller."')");
		if ($_SESSION['ncareglucoseRecord_lwj']==1) {
		$db5_1 = new DB; $db5_1->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".str_replace('-','',$date)."', '".$time2."', '', 'AC Blood glucose ".$loinc_14743." mg/dl', '', '".$Qfiller."')");
		}
	}
	if ($loinc_150755!='') { $db5a = new DB; $db5a->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '15075-5', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_150755."', '1', '".$Qfiller."')");
		if ($_SESSION['ncareglucoseRecord_lwj']==1) {
		$db5_2 = new DB; $db5_2->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".str_replace('-','',$date)."', '".$time2."', '', 'PC Blood glucose ".$loinc_150755." mg/dl', '', '".$Qfiller."')");
		}

	}
	if ($loinc_8310!='') { $db6 = new DB; $db6->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8310-5', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_8310."', '1', '".$Qfiller."')"); }
	if ($loinc_9279!='') { $db7 = new DB; $db7->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '9279-1', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_9279."', '1', '".$Qfiller."')"); }
	if ($loinc_460337!='') {
		$db8 = new DB;
		$db8->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '46033-7', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_460337."', '1', '".$Qfiller."')");
	}
	if ($loinc_188334!='') { $db8 = new DB; $db8->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '18833-4', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_188334."', '1', '".$Qfiller."')"); }
	if ($loinc_391060!='') { $db9 = new DB; $db9->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '39106-0', '".$MeasureDateWithYMOnly."', '".$MeasureTime."', '".$RecordedTime."', '".$loinc_391060."', '1', '".$Qfiller."')"); }

}

echo "<script>window.location.href='../../index.php?mod=dailywork&func=resplist2';</script>";
?>