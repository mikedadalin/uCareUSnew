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

$db = new DB;
$db->query("DELETE FROM `nurseform18` WHERE `HospNo`='".$HospNo."' AND `Qstartdate`='".$Qstartdate."' AND `Qmedtime`='".$Qmedtime."'");
?>