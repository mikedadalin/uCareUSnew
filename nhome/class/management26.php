<?php
include("DB.php");
include("array.php");

$date = $_POST['date'];
$time = $_POST['timeH'].':'.$_POST['timeI'].':00';
$datetime = str_replace('/','-',$date).' '.$time;
$department = $_POST['department'];
$doctor = $_POST['doctor'];
$follower = $_POST['follower'];
$sUser = $_POST['sUser'];

$db1 = new DB;
$db1->query("INSERT INTO `opdinfo` (`date`, `department`, `doctor`, `follower`, `sUser`, `sDate`) VALUES ('".$datetime."', '".$department."', '".$doctor."', '".$follower."', '".$sUser."', '".date('Y-m-d H:i:s')."')");
?>