<?php
include("DB.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$PipelineNo = $_POST['PipelineNo'];
$db = new DB;
$db->query("DELETE FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `PipelineNo`='".$PipelineNo."'");
?>