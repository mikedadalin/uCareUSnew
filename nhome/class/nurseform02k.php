<?php
session_start();
include("DB.php");
include("DB2.php");
include("array.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Q1 = $_POST['Q1'];
$Q2 = $_POST['Q2'];
$Q3 = $_POST['Q3'];
$Q4 = $_POST['Q4'];
$Qfiller = $_POST['Qfiller'];
$db3 = new DB;
$db3->query("SELECT `PipelineNo` FROM `nurseform02k` WHERE `HospNo`='".$HospNo."' ORDER BY CAST(PipelineNo AS UNSIGNED) DESC LIMIT 0,1");
if($db3->num_rows()>0){
	$rdb3 = $db3->fetch_assoc();
	$PipelineNo = $rdb3['PipelineNo']+1;
}else{
	$PipelineNo = 1;
}
//insert next
$db2 = new DB;
$db2->query("INSERT INTO `nurseform02k` VALUES ('".$HospNo."','".$date."','".$Q1."','".$Q2."','".$Q3."','".$Q4."','0','".$PipelineNo."','1','".$Qfiller."')");
?>