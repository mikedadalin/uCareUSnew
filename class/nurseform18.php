<?php
include("DB.php");
include("array.php");
include("function.php");
foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$Qstartdate = str_replace("/","",$_POST['Qstartdate']);
$Qmedtime = $_POST['Qmedtime'];
$Qmedicine = $_POST['Qmedicine'];
$Qdose = $_POST['Qdose'];
$Qpart = $_POST['Qpart'];
$Qfiller = $_POST['Qfiller'];
$QACvalue = $_POST['QACvalue'];

$db = new DB;
$db->query("INSERT INTO `nurseform18` VALUES ('".$HospNo."','".$Qstartdate."', '".$Qmedtime."', '".$QACvalue."', '".$Qmedicine."','".$Qdose."', '".$Qpart."', '".$Qfiller."')");

echo formatdate($Qstartdate).";".substr($Qmedtime,0,2).":".substr($Qmedtime,2,2).";".$QACvalue.";".$Qmedicine.";".$Qdose.";".$Qpart;
?>