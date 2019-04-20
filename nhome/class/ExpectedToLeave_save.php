<?php
include("DB.php");

$_POST['ExpectedLeaveDate'] = str_replace('/','',$_POST['ExpectedLeaveDate']);
$dba = new DB;
$dba->query("SELECT * FROM `expectedtoleave` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."'");
if ($dba->num_rows()>0) {
	$dbb = new DB;
	$dbb->query("UPDATE `expectedtoleave` SET `date`='".date("Ymd")."', `ExpectedLeaveDate`='".mysql_escape_string($_POST['ExpectedLeaveDate'])."', `Qfiller`='".$_SESSION['ncareID_lwj']."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."'");
	echo 'Update';
}else{
	$dbb = new DB;
	$dbb->query("INSERT INTO `expectedtoleave` (`no`, `HospNo`, `date`, `bedID`, `ExpectedLeaveDate`, `Qfiller`) VALUES ('', '".mysql_escape_string($_POST['HospNo'])."', '".date("Ymd")."', '".mysql_escape_string($_POST['bed'])."', '".mysql_escape_string($_POST['ExpectedLeaveDate'])."', '".$_SESSION['ncareID_lwj']."');");
	echo 'Save';
}
?>