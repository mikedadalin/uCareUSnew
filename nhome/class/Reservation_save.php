<?php
include("DB.php");

$_POST['ReservationDate'] = str_replace('/','',$_POST['ReservationDate']);
$dba = new DB;
$dba->query("SELECT * FROM `reservation` WHERE `SSN`='".mysql_escape_string($_POST['SSN'])."'");
if ($dba->num_rows()>0) {
	$dbb = new DB;
	$dbb->query("UPDATE `reservation` SET `date`='".date("Ymd")."', `bedID`='".mysql_escape_string($_POST['bed'])."', `ResidentName`='".mysql_escape_string($_POST['ResidentName'])."', `Contact`='".mysql_escape_string($_POST['Contact'])."', `Phone`='".mysql_escape_string($_POST['Phone'])."',  `ReservationDate`='".mysql_escape_string($_POST['ReservationDate'])."', `Qfiller`='".$_SESSION['ncareID_lwj']."' WHERE `SSN`='".mysql_escape_string($_POST['SSN'])."'");
	echo 'Update';
}else{
	$dbb = new DB;
	$dbb->query("INSERT INTO `reservation` (`no`, `SSN`, `date`, `bedID`, `ReservationDate`, `ResidentName`, `Contact`, `Phone`, `Qfiller`) VALUES ('', '".mysql_escape_string($_POST['SSN'])."', '".date("Ymd")."', '".mysql_escape_string($_POST['bed'])."', '".mysql_escape_string($_POST['ReservationDate'])."', '".mysql_escape_string($_POST['ResidentName'])."', '".mysql_escape_string($_POST['Contact'])."', '".mysql_escape_string($_POST['Phone'])."', '".$_SESSION['ncareID_lwj']."');");
	echo 'Save';
}
?>