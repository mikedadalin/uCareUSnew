<?php
include("DB.php");
$_POST['Insurance'] = str_replace("'","\'",$_POST['Insurance']);
$_POST['BillTime'] = str_replace('/','',$_POST['BillTime']);
$_POST['PeriodStart'] = str_replace('/','',$_POST['PeriodStart']);
$_POST['PeriodEnd'] = str_replace('/','',$_POST['PeriodEnd']);

$dba = new DB;
$dba->query("SELECT * FROM `insurance` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `InsuranceNo`='".mysql_escape_string($_POST['InsuranceNo'])."'");
if ($dba->num_rows()>0) {
	$dbb = new DB;
	$dbb->query("UPDATE `insurance` SET `date`='".date("Ymd")."', `Insurance`='".mysql_escape_string($_POST['Insurance'])."', `InsuranceNumber`='".mysql_escape_string($_POST['InsuranceNumber'])."', `PeriodStart`='".mysql_escape_string($_POST['PeriodStart'])."', `PeriodEnd`='".mysql_escape_string($_POST['PeriodEnd'])."', `Amount`='".mysql_escape_string($_POST['Amount'])."', `BillTime`='".mysql_escape_string($_POST['BillTime'])."', `Qfiller`='".$_SESSION['ncareID_lwj']."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `InsuranceNo`='".mysql_escape_string($_POST['InsuranceNo'])."'");
	echo 'Update';
}else{
	$dbb = new DB;
	$dbb->query("INSERT INTO `insurance` (`no`, `HospNo`, `date`, `InsuranceNo`, `Insurance`, `InsuranceNumber`, `PeriodStart`, `PeriodEnd`, `Amount`, `BillTime`, `Qfiller`) VALUES ('', '".mysql_escape_string($_POST['HospNo'])."', '".date("Ymd")."', '".mysql_escape_string($_POST['InsuranceNo'])."', '".mysql_escape_string($_POST['Insurance'])."', '".mysql_escape_string($_POST['InsuranceNumber'])."', '".mysql_escape_string($_POST['PeriodStart'])."', '".mysql_escape_string($_POST['PeriodEnd'])."', '".mysql_escape_string($_POST['Amount'])."', '".mysql_escape_string($_POST['BillTime'])."', '".$_SESSION['ncareID_lwj']."');");
	echo 'Save';
}
?>