<?php
include("DB.php");

$db = new DB;
$db->query("DELETE FROM `expectedtoleave` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `bedID`='".mysql_escape_string($_POST['bedID'])."'");
echo 'Delete';
?>