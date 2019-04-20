<?php
include("DB.php");
$HospNo = mysql_escape_string($_POST['HospNo']);
$remindContent = mysql_escape_string($_POST['QremindContent']);
$remindDate = mysql_escape_string($_POST['QremindDate']);
$active = mysql_escape_string($_POST['active']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);
$db = new DB;
$db->query("INSERT INTO `reminder2` VALUES ('', '".$HospNo."', '".$remindDate."', '".$remindContent."', '".$active."', '".$Qfiller."')");
?>