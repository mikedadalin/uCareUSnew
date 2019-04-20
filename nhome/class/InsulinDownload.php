<?php
session_start();
include("DB.php");
$Qmedicine = $_POST['Qmedicine'];
$HospNo = $_POST['HospNo'];
$db = new DB;
$db->query("SELECT `Qmedicine`,`Qdose` FROM `nurseform18` WHERE `Qmedicine` = '".mysql_escape_string($Qmedicine)."' AND `HospNo` = '".mysql_escape_string($HospNo)."' ORDER BY `date` DESC");
$r = $db->fetch_assoc();
$result = trim($r['Qmedicine'])."||".trim($r['Qdose']);

echo $result;
?>