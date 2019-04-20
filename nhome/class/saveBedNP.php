<?php
include("DB.php");
$bedID = mysql_escape_string($_POST['bedID']);
$bedNP = mysql_escape_string($_POST['NP']);

$db = new DB;
$db->query("UPDATE `bedinfo` SET `np`='".$bedNP."' WHERE `bedID`='".$bedID."'");

echo "OK";
?>