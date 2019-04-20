<?php
session_start();
include("class/DB.php");
if($_SESSION['ncareID_lwj']!=""){
	$dbTrackURL = new DB;
	$dbTrackURL->query("INSERT INTO `useractiontrack` (`date`, `time`, `action`, `userID`, `OrgID`, `username`, `position`) VALUES ('".date(Ymd)."', '".date("H:i:s")."', 'Logout', '".$_SESSION['ncareID_lwj']."', '".$_SESSION['nOrgID_lwj']."', '".$_SESSION['ncareName_lwj']."', '".$_SESSION['ncarePos_lwj']."');");
}
session_destroy();
session_start();
$_SESSION['QR_URL_lwj'] = $_GET['QR_URL'];
echo "<script>window.location='../index.php';</script>";
?>