<?php
include("DB.php");

$actNo = mysql_escape_string($_POST['actNo']);

$db1 = new DB;
$db1->query("DELETE FROM `socialform08` WHERE `actNo`='".$actNo."'");
$db2 = new DB;
$db2->query("DELETE FROM `socialform08a` WHERE `actNo`='".$actNo."'");

echo "OK";
?>