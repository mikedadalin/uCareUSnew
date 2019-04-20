<?php
include("DB.php");
include("array.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Q2 = $_POST['Q2'];
$Qcontent = $_POST['Qcontent'];
$Qjiaoban = $_POST['Qjiaoban'];
$db = new DB;
$db->query("INSERT INTO `nurseform05` VALUES ('".$HospNo."','".$date."','".$Q2."','".$Qcontent."','".$Qjiaoban."')");
$Q2 = (int) $Q2;
echo $arrNursediag[$Q2];
?>