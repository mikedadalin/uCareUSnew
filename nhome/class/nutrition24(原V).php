<?php
include("DB.php");
include("array.php");

$PersonID = $_POST['PID'];
$date = str_replace("/","-",$_POST['date']).':00.0000000';
$tDate = date("Ym", strtotime($date));
$Value = $_POST['BWvalue'];
$Qfiller = $_POST['Qfiller'];

$db = new DB;
$db->query("INSERT INTO `vitalsigns` VALUES ('', '".$PersonID."', '18833-4', '".$tDate."', '".$date."', '".$date."', '".$Value."', '1', '".$Qfiller."')");
echo "OK";
?>