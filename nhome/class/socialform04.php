<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Qproblem = mysql_escape_string($_POST['Qproblem']);
$Qinteraction = mysql_escape_string($_POST['Qinteraction']);
$Qcontent = mysql_escape_string($_POST['Qcontent']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);
$timeH = mysql_escape_string($_POST['timeH']);
$timeI = mysql_escape_string($_POST['timeI']);

$db = new DB;
$db->query("INSERT INTO `socialform04` VALUES ('".$HospNo."', '".$date."', '".$timeH.":".$timeI.":00', '', '".$Qproblem."', '".$Qinteraction."', '".$Qcontent."', '".$Qfiller."')");

echo formatdate($date).";".$Qproblem.";".$Qcontent;

?>