<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = getHospNo($_POST['PID']);
$action = $_POST['Action'];
if($action=="ON"){
	$db = new DB;
	$db->query("INSERT INTO `nurserounds` (`HospNo`, `date`, `round`, `Qfiller`) VALUES ('".$HospNo."', '".date(Ymd)."', '1', '".mysql_escape_string($_SESSION['ncareID_lwj'])."');");
}
if($action=="OFF"){
	$db = new DB;
	$db->query("DELETE FROM `nurserounds` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".$_SESSION['ncareID_lwj']."'");
}
?>