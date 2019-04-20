<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$no = $_POST['no'];

$db = new DB;
$db->query("DELETE FROM `rehabilitationform02` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `no`='".$no."'");

?>