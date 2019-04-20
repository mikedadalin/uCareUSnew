<?php
include("DB.php");
include("array.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Q1 = $_POST['Q1'];
$Q2 = $_POST['Q2'];
$Q3 = $_POST['Q3'];
$Q4 = $_POST['Q4'];
$db = new DB;
$db->query("INSERT INTO `nurseform02k` VALUES ('".$HospNo."','".$date."','".$Q1."','".$Q2."','".$Q3."','".$Q4."','".$_SESSION['ncareID_lwj']."')");
echo $arrForm2k_Q1[$Q1].','.$arrForm2k_Q2[$Q2].','.$Q3.','.$Q4;
?>