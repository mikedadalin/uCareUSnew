<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Q1 = mysql_escape_string($_POST['Q1']);
$Q2 = mysql_escape_string($_POST['Q2']);
$Qmemo = mysql_escape_string($_POST['Qmemo']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);

$db = new DB;
$db->query("INSERT INTO `rehabilitationform02` VALUES ('".$HospNo."', '".$date."', '', '".$Q1."', '".$Q2."', '".$Qmemo."', '".$Qfiller."')");

echo formatdate($date).";".$Qproblem.";".$Qcontent;

?>