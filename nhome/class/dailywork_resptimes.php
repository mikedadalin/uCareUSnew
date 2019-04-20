<?php
// 新V START
include("DB.php");
include("array.php");
include("function.php");
$bedID = $_POST['bedID'];
$db0 = new DB;
$db0->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$bedID."'");
$r0 = $db0->fetch_assoc();

$PatientID = $r0['patientID'];
$date = str_replace("-","",$_POST['date']);
$time = $_POST['measuretime'];
$loinc_8310 = $_POST['loinc_8310-5'];                 // loinc_8310_5  體溫
$loinc_8867 = $_POST['loinc_8867-4'];                 // loinc_8867_4  心跳
$loinc_9279 = $_POST['loinc_9279-1'];                 // loinc_9279_1  呼吸頻率
$loinc_8480 = $_POST['loinc_8480-6'];                 // loinc_8480_6  收縮壓
$loinc_8462 = $_POST['loinc_8462-4'];                 // loinc_8462_4  舒張壓
$loinc_2710 = $_POST['loinc_2710-2'];                 // loinc_2710_2  血氧
$loinc_460337 = $_POST['loinc_46033-7'];              // loinc_46033_7 疼痛指數
$loinc_14743 = $_POST['loinc_14743-9'];               // loinc_14743_9 飯前血糖 AC
$loinc_150755 = $_POST['loinc_15075-5'];              // loinc_15075_5 飯後血糖 PC
$loinc_391060 = $_POST['loinc_39106-0'];              // loinc_39106_0 腋溫
$loinc_188334 = ((int)$_POST['loinc_18833-4']);       // loinc_18833_4 體重
$Qfiller = $_SESSION['ncareID_lwj'];



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
		$db8a->query("INSERT INTO `nurseform05` VALUES ('', '".getHospNo($PatientID)."', '".$date."', '".date(H).date(i)."', '', 'AC Blood glucose ".$loinc_14743." mg/dl', '', '".$Qfiller."')");
	}
}
if ($loinc_150755!='') {
	$db9 = new DB;
	$db9->query("UPDATE `vitalsign` SET `loinc_15075_5`='".$loinc_150755."' WHERE `VitalSignID`='".$VitalSignID."'");
	if ($_SESSION['ncareglucoseRecord_lwj']==1) {
		$db9a = new DB;
		$db9a->query("INSERT INTO `nurseform05` VALUES ('', '".getHospNo($PatientID)."', '".$date."', '".date(H).(date(i)+1)."', '', 'PC Blood glucose ".$loinc_150755." mg/dl', '', '".$Qfiller."')");
	}
}
if ($loinc_391060!='') { $db10 = new DB; $db10->query("UPDATE `vitalsign` SET `loinc_39106_0`='".$loinc_391060."' WHERE `VitalSignID`='".$VitalSignID."'"); }
if ($loinc_188334!='') { $db11 = new DB; $db11->query("UPDATE `vitalsign` SET `loinc_18833_4`='".$loinc_188334."' WHERE `VitalSignID`='".$VitalSignID."'"); }
// 新V END


/*  原V
include("DB.php");
include("array.php");
include("function.php");
$bedID = $_POST['bedID'];

$db0 = new DB;
$db0->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$bedID."'");
$r0 = $db0->fetch_assoc();
$PersonID = $r0['patientID'];



$loinc_8310 = $_POST['loinc_8310-5'];                 // loinc_8310-5  體溫
$loinc_8867 = $_POST['loinc_8867-4'];                 // loinc_8867-4  心跳
$loinc_9279 = $_POST['loinc_9279-1'];                 // loinc_9279-1  呼吸頻率
$loinc_8480 = $_POST['loinc_8480-6'];                 // loinc_8480-6  收縮壓
$loinc_8462 = $_POST['loinc_8462-4'];                 // loinc_8462-4  舒張壓
$loinc_2710 = $_POST['loinc_2710-2'];                 // loinc_2710-2  血氧
$loinc_460337 = $_POST['loinc_46033-7'];              // loinc_46033-7 疼痛指數
$loinc_14743 = $_POST['loinc_14743-9'];               // loinc_14743-9 飯前血糖 AC
$loinc_150755 = $_POST['loinc_15075-5'];              // loinc_15075-5 飯後血糖 PC
$loinc_391060 = $_POST['loinc_39106-0'];              // loinc_39106-0 腋溫
$loinc_188334 = ((int)$_POST['loinc_18833-4']);       // loinc_18833-4 體重

$date = str_replace("/","-",$_POST['date']);
$arrDate = explode("-",$date);
if (strlen($arrDate[1])==1) { $arrDate[1] = "0".$arrDate[1]; }
if (strlen($arrDate[2])==1) { $arrDate[2] = "0".$arrDate[2]; }
$date = $arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
$MeasureDateWithYMOnly = substr($date,0,4).substr($date,5,2);
$RecordedTime = str_replace(":","",$_POST['measuretime']);
$RecordedTime = $date." ".substr($RecordedTime,0,2).":".substr($RecordedTime,2,2).date(":s.0000000");
$Qfiller = $_POST['Qfiller'];

if ($loinc_8480!='') { $db1 = new DB; $db1->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8480-6', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8480."', '1', '".$Qfiller."')"); }
if ($loinc_8462!='') { $db2 = new DB; $db2->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8462-4', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8462."', '1', '".$Qfiller."')"); }
if ($loinc_8867!='') { $db3 = new DB; $db3->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8867-4', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8867."', '1', '".$Qfiller."')"); }
if ($loinc_2710!='') { $db4 = new DB; $db4->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '2710-2', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_2710."', '1', '".$Qfiller."')"); }
if ($loinc_14743!='') {
	$db5 = new DB;
	$db5->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '14743-9', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_14743."', '1', '".$Qfiller."')");
	if ($_SESSION['ncareglucoseRecord_lwj']==1) {
		$db5_1 = new DB;
		$db5_1->query("INSERT INTO `nurseform05` VALUES ('', '".getHospNo($PersonID)."', '".str_replace('-','',$date)."', '".date(H).date(i)."', '', 'AC Blood glucose ".$loinc_14743." mg/dl', '', '".$Qfiller."')");
	}
}
if ($loinc_150755!='') {
	$db5a = new DB;
	$db5a->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '15075-5', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_150755."', '1', '".$Qfiller."')");
	if ($_SESSION['ncareglucoseRecord_lwj']==1) {
		$db5_2 = new DB;
		$db5_2->query("INSERT INTO `nurseform05` VALUES ('', '".getHospNo($PersonID)."', '".str_replace('-','',$date)."', '".date(H).(date(i)+1)."', '', 'PC Blood glucose ".$loinc_150755." mg/dl', '', '".$Qfiller."')");
	}
}
if ($loinc_8310!='') { $db6 = new DB; $db6->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '8310-5', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_8310."', '1', '".$Qfiller."')"); }
if ($loinc_9279!='') { $db7 = new DB; $db7->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '9279-1', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_9279."', '1', '".$Qfiller."')"); }
if ($loinc_460337!='') {
	$db8 = new DB;
	$db8->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '46033-7', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_460337."', '1', '".$Qfiller."')");
}
if ($loinc_188334!='') { $db9 = new DB; $db9->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '18833-4', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_188334."', '1', '".$Qfiller."')"); }
if ($loinc_391060!='') { $db10 = new DB; $db10->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '39106-0', '".$MeasureDateWithYMOnly."', '".$RecordedTime."', '".$RecordedTime."', '".$loinc_391060."', '1', '".$Qfiller."')"); }
*/
?>