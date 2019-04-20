<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = getHospNo($_POST['PID']);
$action = $_POST['Action'];
$MemoID = "MemoID_".$_POST['MemoID'];
if($action=="ON"){
	$db = new DB;
	$db->query("SELECT * FROM `workmemocheck` WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."'");
	if($db->num_rows()>0){
		$db1 = new DB;
		$db1->query("UPDATE `workmemocheck` SET `".$MemoID."`='1' WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."'");
	}else{
		$db1 = new DB;
		$db1->query("INSERT INTO `workmemocheck` (`HospNo`, `date`, `Qfiller`) VALUES ('".$HospNo."', '".date(Ymd)."', '".mysql_escape_string($_SESSION['ncareID_lwj'])."');");
		$db2 = new DB;
		$db2->query("UPDATE `workmemocheck` SET `".$MemoID."`='1' WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."'");
	}
}
if($action=="OFF"){
	$db = new DB;
	$db->query("UPDATE `workmemocheck` SET `".$MemoID."`='0' WHERE `HospNo`='".$HospNo."' AND `date`='".date(Ymd)."' AND `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."'");
}
?>