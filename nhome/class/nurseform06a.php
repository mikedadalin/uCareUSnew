<?php
include("DB.php");
include("array.php");
$date = str_replace("/","",$_POST['date']);
$time = $_POST['time'];
$Qcate = $_POST['Qcate'];
$Q1 = $_POST['Q1'];
$Q2 = $_POST['Q2'];
$Qcontent = $_POST['Qcontent'];
$dbc = new DB;
$dbc->query("SELECT * FROM `nurseform06a` WHERE `date`='".$date."' AND `time`='".$time."'");
if ($dbc->num_rows()==0) {
	$db = new DB;
	$db->query("INSERT INTO `nurseform06a` VALUES ('".$date."','".$time."','".$Qcate."','".$Q1."','".$Q2."','".$Qcontent."','".$_SESSION['ncareID_lwj']."')");
} else {
	return "exist";
}
?>