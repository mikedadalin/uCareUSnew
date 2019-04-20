<?php
session_start();
include("DB.php");
$med = $_POST['med'];

	$db = new DB;
	$db->query("SELECT DISTINCT `Qmedicine` FROM `nurseform17` WHERE `Qmedicine` LIKE '%".mysql_escape_string($med)."%'");
	if ($db->num_rows()>0) {
		for ($i=0;$i<$db->num_rows();$i++) {
			$r = $db->fetch_assoc();
			$result .= trim($r['Qmedicine']).",";
		}
		echo substr($result,0,(strlen($result)-1));
	} else {
		$db2 = new DB;
		$db2->query("SELECT `name`, `name2` FROM `drug` WHERE `name2` LIKE '%".mysql_escape_string($med)."%'");
		for ($i=0;$i<$db2->num_rows();$i++) {
			$r = $db2->fetch_assoc();
			$result .= trim($r['name'])." (".trim($r['name2'])."),";
		}
		echo substr($result,0,(strlen($result)-1));
	}
?>