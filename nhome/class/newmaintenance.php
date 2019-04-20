<?php
include("DB.php");

$ApplyDate = mysql_escape_string($_POST['ApplyDate']);
$ApplyFloor = mysql_escape_string($_POST['ApplyFloor']);
$ApplyContent1 = str_replace("\n","<br>",mysql_escape_string($_POST['ApplyContent1']));
$ApplyContent2 = str_replace("\n","<br>",mysql_escape_string($_POST['ApplyContent2']));
/*$db2 = new DB;
$db2->query("SELECT * FROM `maintenance_phrase1` WHERE `phraseID`='".$ApplyContent2."'");
$r2 = $db2->fetch_assoc();
$ApplyContent2txt = $r2['content'];*/
$Applicant = mysql_escape_string($_POST['Applicant']);
if($_POST['mainID']==""){
	$db1 = new DB;
	$db1->query("INSERT INTO `maintenance` (`ApplyDate`, `ApplyFloor`, `ApplyContent1`, `ApplyContent2`, `Applicant`) VALUES ('".$ApplyDate."', '".$ApplyFloor."', '".$ApplyContent1."', '".$ApplyContent2."', '".$Applicant."');");
	echo "insert";
}else{
	$db1 = new DB;
	$db1->query("UPDATE `maintenance` SET `ApplyFloor`='".$ApplyFloor."', `ApplyContent1`='".$ApplyContent1."', `ApplyContent2`='".$ApplyContent2."' WHERE `mainID`='".mysql_escape_string($_POST['mainID'])."'");
	echo "update";
}
?>