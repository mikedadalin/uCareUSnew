<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);

$db = new DB;
$db->query("DELETE FROM `socialform05` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."'");

?>