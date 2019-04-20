<?php
include("DB2.php");
$account = mysql_escape_string($_POST['account']);
if ($account!="") {
	$db1 = new DB2;
	$db1->query("UPDATE `userinfo` SET `rfidno`='' WHERE `userID`='".$account."'");
}
?>