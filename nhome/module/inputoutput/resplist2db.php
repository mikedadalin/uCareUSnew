<?php
include("../../class/DB.php");
include("../../class/function.php");
$namelist = explode(";",$_POST['totaln']);
for ($i=0;$i<count($namelist);$i++) {
	$HospNo = $namelist[$i];
	$PersonID = getPID($HospNo);
	$Qfiller = $_POST['Qfiller'];
	
	$input = $_POST['input_'.$HospNo];
	$output1 = $_POST['output1_'.$HospNo];
	$output2 = $_POST['output2_'.$HospNo];
	$output3 = $_POST['output3_'.$HospNo];
	$output = $_POST['output_'.$HospNo];
	$iostatus = $_POST['IO_'.$HospNo];
	
	/*if ($_POST['date']!="") {
		$date = str_replace("/","-",$_POST['date']);
	} else {
		$date = date(Y."-".m."-".d);
	}
	$RecordedTime = $date." ".date(H).":".date(i).date(":".s.".0000000");*/
	
	if ($_POST['Qdate']!="") {
		$date = str_replace("/","-",$_POST['Qdate']);
		$arrDate = explode("-",$date);
		if (strlen($arrDate[1])==1) { $arrDate[1] = "0".$arrDate[1]; }
		if (strlen($arrDate[2])==1) { $arrDate[2] = "0".$arrDate[2]; }
		$date = $arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
	} else {
		$date = date(Y."-".m."-".d);
	}
	
	if ($_POST['Qtime']!="") {
		$minute = mt_rand(0, (date(i)-1));
		if (strlen($_POST['Qtime'])==1) { $hour = "0".$_POST['Qtime']; } else { $hour = $_POST['Qtime']; }
		if (strlen($minute)==1) { $minute = "0".$minute; }
		$time = $hour.':'.$minute.':'.date(s).'.0000000';
		$time2 = $hour.$minute;
	}
	$MeasureTime = $date." ".$time;
	$RecordedTime = date("Y-m-d H:i:s.0000000");
	
	if ($input !='' || $output1 !='' || $output2 !='' || $output3 !='' || $output !='' || $iostatus !='') {
		$db1 = new DB;
		$db1->query("INSERT INTO `iostatus` VALUES ('', '".$PersonID."', '".$input."', '".$output."', '".$output1."', '".$output2."', '".$output3."', '".$iostatus."', '".$MeasureTime."', '".$Qfiller."')");
	}

}

echo "<script>window.location.href='../../index.php?mod=inputoutput&func=resplist2';</script>";
?>