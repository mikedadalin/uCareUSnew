<?php
session_start();
include("DB.php");
$Qmedicine = $_POST['Qmedicine'];
$HospNo = $_POST['HospNo'];
$db = new DB;
$db->query("SELECT `Qeffect`,`QeffectOption`,`Qway`,`Qdose`,`Qdoseq`,`Qusage` FROM `nurseform17` WHERE `Qmedicine` = '".mysql_escape_string($Qmedicine)."' AND `HospNo` = '".mysql_escape_string($HospNo)."' ORDER BY `date` DESC");
$r = $db->fetch_assoc();
$result = trim($r['Qeffect'])."||".trim($r['QeffectOption'])."||".trim($r['Qway'])."||".trim($r['Qdose'])."||".trim($r['Qdoseq'])."||".trim($r['Qusage']);

echo $result;
?>