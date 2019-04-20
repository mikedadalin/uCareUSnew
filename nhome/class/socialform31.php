<?php
include("DB.php");
include("array.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$time = $_POST['time'];
$Q2 = $_POST['Q2'];
$Qcontent = $_POST['Qcontent'];
$Qfiller = $_POST['Qfiller'];
$db = new DB;
$db->query("INSERT INTO `socialform31` VALUES ('".$HospNo."','".$date."','".$time."','".$Q2."','".$Qcontent."','".$Qfiller."')");
$Q2 = (int) $Q2;
echo $arrNursediag[$Q2];
?>