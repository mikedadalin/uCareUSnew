<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$no = $_POST['no'];
$formID = $_POST['formID'];

$db = new DB;
$db->query("DELETE FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `no`='".$no."'");

?>