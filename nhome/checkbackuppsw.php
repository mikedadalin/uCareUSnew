<?php
session_start();
include('class/DB.php');
include('class/DB2.php');
include('class/function.php');

$dbp = new DB2;
$dbp->query("SELECT `backupPassword` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$rp = $dbp->fetch_assoc();
if ($_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01") {
	echo "OK";
} else {
	if ($rp['backupPassword']=="") {
		echo "NOTSET";
	} elseif ($rp['backupPassword']!=md5($_POST['backuppsw'])) {
		echo "NOTMATCH";
	} else {
		echo "OK";
	}
}
?>