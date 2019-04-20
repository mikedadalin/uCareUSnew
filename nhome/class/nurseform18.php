<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$Qstartdate1 = str_replace("/","",$_POST['Qstartdate1']);
$Qmedtime1 = mysql_escape_string($_POST['Qmedtime1']);
$Qmedicine1 = mysql_escape_string($_POST['Qmedicine1']);
$Qdose1 = mysql_escape_string($_POST['Qdose1']);
$Qpart1 = mysql_escape_string($_POST['Qpart1']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);
$QACvalue1 = mysql_escape_string($_POST['QACvalue1']);
$QNeedUseDate = mysql_escape_string($_POST['QNeedUseDate']);
$QNeedUseTime = mysql_escape_string($_POST['QNeedUseTime']);
$QInsulinRecordType = mysql_escape_string($_POST['QInsulinRecordType']);



$rTime = str_replace("/","-",formatdate($Qstartdate1)).' '.substr($Qmedtime1,0,2).':'.substr($Qmedtime1,2,2).':00.0000000';
$MeasureDateWithYMOnly = substr($Qstartdate1,0,4).':'.substr($Qstartdate1,4,2);

$db = new DB;
$db->query("INSERT INTO `nurseform18_1` VALUES ('".$HospNo."','".$Qstartdate1."', '".$Qmedtime1."', '".$QACvalue1."', '".$Qmedicine1."','".$Qdose1."', '".$Qpart1."', '".$QNeedUseDate."', '".$QNeedUseTime."', '".$QInsulinRecordType."', '".$Qfiller."')");

if ($QACvalue1!='') {
	/* 原V
	$db2 = new DB;
	$db2->query("INSERT INTO `vitalsigns` VALUES ('', '".getPID($HospNo)."', '14743-9', '".$MeasureDateWithYMOnly."', '".$rTime."', '".$rTime."', '".$QACvalue1."', '1', '".$Qfiller."')");
	*/
	// 新V START
	
	$db0a = new DB;
	$db0a->query("SELECT `VitalSignID` FROM `vitalsign` WHERE `PatientID`='".getPID($HospNo)."' AND `date`='".$Qstartdate1."' AND `time`='".$Qmedtime1."'");
	if($db0a->num_rows()>0){
		$sec = substr($Qmedtime1,0,2)*60*60+substr($Qmedtime1,2,2)*60;
		$NEWsec = strtotime("next min", $sec);
		$time = date("Hi",mktime(0,0,$NEWsec));
	}else{
		$time = $Qmedtime1;
	}
	$db0b = new DB;
	$db0b->query("INSERT INTO `vitalsign` (`VitalSignID`, `PatientID`, `date`, `time`, `Qfiller`, `loinc_14743_9`) VALUES ('', '".getPID($HospNo)."', '".$Qstartdate1."', '".$time."', '".$Qfiller."', '".$QACvalue1."')");

	if ($_SESSION['ncareglucoseRecord_lwj']==1) {
		$db8a = new DB;
		$db8a->query("INSERT INTO `nurseform05` VALUES ('', '".getPID($HospNo)."', '".$Qstartdate1."', '".$Qmedtime1."', '', 'AC Blood glucose ".$QACvalue1." mg/dl', '', '".$Qfiller."')");
	}
	// 新V END
}

if ($_SESSION['ncareglucoseRecord_lwj']==1) {
	if ($QACvalue1!='') {
		$Qcontent = "Blood glucose ".$QACvalue1."mg/dl";
	}
	if ($Qmedicine1!='' && $Qmedicine1!="Hold") {
		if ($Qcontent != '') { $Qcontent .= "，"; }
		$Qcontent .= "胰島素".$Qmedicine1." ".$Qdose1."uint 施打";
	}
	if ($Qcontent !='') {
		$Qcontent .= '。';
		$db2a = new DB;
		$db2a->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".$Qstartdate1."', '".$Qmedtime1."', '', '".$Qcontent."', '', '".$Qfiller."')");
	}
}

echo formatdate($Qstartdate1).";".substr($Qmedtime1,0,2).":".substr($Qmedtime1,2,2).";".$QACvalue1.";".$Qmedicine1.";".$Qdose1.";".$Qpart1.";".$_SESSION['ncareName_lwj'];


?>
	<script>
    alert("Please make sure to fill.")
    document.location.href="index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=18";
    </script>