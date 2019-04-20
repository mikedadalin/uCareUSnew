<?php
session_start();
include("DB.php");
$med2 = $_POST['med2'];
	$db2 = new DB;
	$db2->query("SELECT DISTINCT `Qeffect`,`QeffectOption` FROM `nurseform17` WHERE `Qeffect` LIKE '%".mysql_escape_string($med2)."%'");
	for ($i=0;$i<$db2->num_rows();$i++) {
		$r2 = $db2->fetch_assoc();
		$result2 .= trim($r2['Qeffect']).",";
	}
	echo substr($result2,0,(strlen($result2)-1));
?>