<?php
include("DB.php");
include("array.php");
include("function.php");
foreach ($_POST as $k=>$v) {
	if (substr($k,0,14)=="QeffectOption1") {
		if ($v==1) {
			$options = explode("_",$k);
			$QeffectOption1 .= ($options[1]).';';
		}
	}
}
$HospNo = $_POST['HospNo'];
$QUseDate = str_replace("/","",$_POST['QUseDate']);
$Qmedtime1 = mysql_escape_string($_POST['Qmedtime1']);
$Qmedicine1 = mysql_escape_string($_POST['Qmedicine1']);
$Qeffect1 = mysql_escape_string($_POST['Qeffect1']);
$Qway1 = mysql_escape_string($_POST['Qway1']);
$Qdose1 = mysql_escape_string($_POST['Qdose1']);
$Qusage1 = mysql_escape_string($_POST['Qusage1']);
$QNeedUseDate = mysql_escape_string($_POST['QNeedUseDate']);
$QNeedUseTime = mysql_escape_string($_POST['QNeedUseTime']);
$QMedicationRecordType = mysql_escape_string($_POST['QMedicationRecordType']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);
$db = new DB;
$db->query("INSERT INTO `nurseform17a` VALUES ('".$HospNo."','".$QUseDate."', '".$Qmedtime1."', '".$Qmedicine1."', '".$Qeffect1."', '".$QeffectOption1."', '".$Qway1."','".$Qdose1."', '".$Qusage1."', '".$QNeedUseDate."', '".$QNeedUseTime."', '".$QMedicationRecordType."', '".$Qfiller."')");
//echo formatdate($QUseDate).";".substr($Qmedtime1,0,2).":".substr($Qmedtime1,2,2).";".$Qmedicine1.";".$Qeffect1.$QeffectOption1.";".$Qway1.";".$Qdose1.";".$Qusage1;
?>