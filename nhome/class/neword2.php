<?php
include("DB.php");
include("function.php");

$aID = mysql_escape_string($_POST['aID']);
$ORDUSER = mysql_escape_string($_POST['ORDUSER']);

$dbc1 = new DB;
$dbc1->query("SELECT * FROM `arkordinfo` WHERE `PS_NAME`='Area".$aID."' AND `ORD_USER`='".$ORDUSER."' ORDER BY `ORD_SEQ` DESC LIMIT 0,1");
if ($dbc1->num_rows()==0) {
	$db = new DB;
	$db->query("INSERT INTO `arkordinfo` (`ORD_DATE`, `PS_NAME`, `ORD_USER`) VALUES ('".date('Y-m-d H:i:s')."', 'Area".$aID."', '".$ORDUSER."')");
	$db1 = new DB;
	$db1->query("SELECT `ORD_SEQ` FROM `arkordinfo` WHERE `PS_NAME`='Area".$aID."' AND `ORD_USER`='".$ORDUSER."' ORDER BY `ORD_DATE` DESC LIMIT 0,1");
	$r1 = $db1->fetch_assoc();
	echo $r1['ORD_SEQ'];
} else {
	$rc1 = $dbc1->fetch_assoc();
	$dbc2 = new DB;
	$dbc2->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$rc1['ORD_SEQ']."'");
	if ($dbc2->num_rows()>0) {
		$db = new DB;
		$db->query("INSERT INTO `arkordinfo` (`ORD_DATE`, `PS_NAME`, `ORD_USER`) VALUES ('".date('Y-m-d H:i:s')."', 'Area".$aID."', '".$ORDUSER."')");
		$db1 = new DB;
		$db1->query("SELECT `ORD_SEQ` FROM `arkordinfo` WHERE `ORD_USER`='".$ORDUSER."' ORDER BY `ORD_DATE` DESC LIMIT 0,1");
		$r1 = $db1->fetch_assoc();
		echo $r1['ORD_SEQ'];
	} else {
		$db1 = new DB;
		$db1->query("UPDATE `arkordinfo` SET `ORD_DATE`='".date('Y-m-d H:i:s')."' WHERE `ORD_SEQ`='".$rc1['ORD_SEQ']."'");
		echo $rc1['ORD_SEQ'];
	}
}
?>