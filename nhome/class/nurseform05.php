<?php
include("DB.php");
include("array.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$time = $_POST['time'];
$Q2 = $_POST['Q2'];
$Qcontent = htmlspecialchars(strip_tags($_POST['Qcontent']), ENT_QUOTES);
$Qjiaoban = $_POST['Qjiaoban'];
$Qfiller = $_POST['Qfiller'];
$db = new DB;
$db->query("INSERT INTO `nurseform05` VALUES ('".$HospNo."','".$date."','".$time."','".$Q2."','".$Qcontent."','".$Qjiaoban."','".$Qfiller."')");
$Q2 = (int) $Q2;
echo $arrNursediag[$Q2];
?>