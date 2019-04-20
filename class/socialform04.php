<?php
include("DB.php");
include("array.php");
include("function.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Qproblem = $_POST['Qproblem'];
$Qinteraction = $_POST['Qinteraction'];
$Qcontent = $_POST['Qcontent'];
$Qfiller = $_POST['Qfiller'];

$db = new DB;
$db->query("INSERT INTO `socialform04` VALUES ('".$HospNo."','".$date."', '".$Qproblem."', '".$Qinteraction."', '".$Qcontent."', '".$Qfiller."')");

echo formatdate($date).";".$Qproblem.";".$Qinteraction.";".$Qcontent;

?>