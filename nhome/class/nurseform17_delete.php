<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$QUseDate = str_replace("/","",$_POST['QUseDate']);
$Qmedtime = mysql_escape_string($_POST['Qmedtime1']);
$db = new DB;
$db->query("DELETE FROM `nurseform17a` WHERE `HospNo`='".$HospNo."' AND `QUseDate`='".$QUseDate."' AND `Qmedtime1`='".$Qmedtime."'");
?>