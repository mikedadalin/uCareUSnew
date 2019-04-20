<?php
include("DB.php");
include("array.php");
include("function.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);

$db = new DB;
$db->query("DELETE FROM `socialform05` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."'");
?>