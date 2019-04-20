<?php
session_start();
include("DB2.php");
$iVN = md5($_POST['iVN']);
$dbVN = new DB2;
$dbVN->query("SELECT * FROM `userinfo` WHERE `userID`='".mysql_escape_string($_SESSION['ncareID_lwj'])."'");
$rVN = $dbVN->fetch_assoc();

if ($rVN['VN']==$iVN) {
	echo "YES";
} else {
	echo "NO";
}
?>