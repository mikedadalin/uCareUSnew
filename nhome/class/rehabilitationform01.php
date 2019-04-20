<?php
include("DB.php");

$HospNo = mysql_escape_string($_POST['HospNo']);
$Name = mysql_escape_string($_POST['Name']);
$ChairNo = mysql_escape_string($_POST['ChairNo']);
$ChairNo2 = mysql_escape_string($_POST['ChairNo2']);
$ChairNo3 = mysql_escape_string($_POST['ChairNo3']);

$dbc = new DB;
$dbc->query("SELECT * FROM `rehabilitationform01` WHERE `HospNo`='".$HospNo."'");
if ($dbc->num_rows()==0) {
	$db1 = new DB;
	$db1->query("INSERT INTO `rehabilitationform01` VALUES ('".$HospNo."', '".$Name."', '".$ChairNo."', '".$ChairNo2."', '".$ChairNo3."');");
} else {
	$db1 = new DB;
	$db1->query("UPDATE `rehabilitationform01` SET `Name`='".$Name."', `ChairNo`='".$ChairNo."', `ChairNo2`='".$ChairNo2."', `ChairNo3`='".$ChairNo3."' WHERE `HospNo`='".$HospNo."';");
}
?>