<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$Qstartdate = str_replace("/","",$_POST['Qstartdate1']);
$Qmedtime = mysql_escape_string($_POST['Qmedtime1']);

$db = new DB;
$db->query("DELETE FROM `nurseform18_1` WHERE `HospNo`='".$HospNo."' AND `Qstartdate1`='".$Qstartdate."' AND `Qmedtime1`='".$Qmedtime."'");

?>
