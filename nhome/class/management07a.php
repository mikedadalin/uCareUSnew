<?php
include("DB.php");
include("array.php");
$date = str_replace("/","",$_POST['date']);
$time = $_POST['time'];
$Q1 = $_POST['Q1'];
$Qcontent = $_POST['Qcontent'];
$Qfiller = $_POST['Qfiller'];
$db = new DB;
$db->query("INSERT INTO `management07a` VALUES ('".$date."','".$time."','".$Q1."','".$Qcontent."','".$Qfiller."')");
?>