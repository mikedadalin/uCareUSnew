<?php
include("DB2.php");
$userID = mysql_escape_string($_POST['userID']);
$db = new DB2;
$db->query("SELECT `userID` FROM `userinfo` WHERE `userID`='".$userID."'");
if ($db->num_rows()>0) {
	echo "EXISTED";
}
?>