<?php
include("DB.php");

$formID = mysql_escape_string($_POST['formID']);
$HospNo = mysql_escape_string($_POST['HospNo']);
$date = mysql_escape_string($_POST['date']);
$no = mysql_escape_string($_POST['no']);

$db0 = new DB;
$db0->query("SELECT * FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' ".($no!=""?" AND `no`='".$no."'":""));
$r0 = $db0->fetch_assoc();

foreach ($r0 as $k0=>$v0) {
	if ($backuptxt!="") { $backuptxt .= ';'; }
	$backuptxt .= $k0.':'.$v0;
}

$db1 = new DB;
$db1->query("INSERT INTO `deletelog` VALUES ('', '".$formID."', '".$HospNo."', '".$date."', '".$no."', '".$backuptxt."', '".$Qfiller."');");

$db2 = new DB;
$db2->query("DELETE FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' ".($no!=""?" AND `no`='".$no."'":""));
?>