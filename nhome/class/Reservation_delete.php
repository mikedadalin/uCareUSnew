<?php
include("DB.php");

$db = new DB;
$db->query("DELETE FROM `reservation` WHERE `SSN`='".mysql_escape_string($_POST['SSN'])."' AND `bedID`='".mysql_escape_string($_POST['bedID'])."'");
echo 'Delete';
?>