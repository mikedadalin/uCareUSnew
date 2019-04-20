<?php
include("DB.php");
$freqID = $_POST['freqID'];
$db = new DB;
$db->query("SELECT * FROM `medfreq` WHERE `freqID` = '".mysql_escape_string($freqID)."'");
$r = $db->fetch_assoc();
$result = trim($r['code']).'||'.trim($r['name'])."||".trim($r['time']);

echo $result;
?>