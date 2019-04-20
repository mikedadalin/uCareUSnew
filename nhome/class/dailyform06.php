<?php
include("DB.php");
include("array.php");
$date = str_replace("/","",$_POST['date']);
$time = $_POST['time'];
$Q1 = $_POST['Q1'];
$Q2 = $_POST['Q2'];
$Qcontent = $_POST['Qcontent'];
$Qfiller = $_POST['Qfiller'];
$db = new DB;
$db->query("INSERT INTO `nurseform06a` VALUES ('".$date."','".$time."','2','".$Q1."','".$Q2."','".$Qcontent."','".$Qfiller."')");
?>