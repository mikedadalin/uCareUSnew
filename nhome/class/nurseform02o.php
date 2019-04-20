<?php
include("DB.php");
include("array.php");
include("function.php");
$db = new DB;
$db->query("INSERT INTO `nurseform02o` (`targetID`) VALUES ('')");
$db1 = new DB;
$db1->query("SELECT LAST_INSERT_ID();");
$r1 = $db1->fetch_assoc();
$targetID = $r1['LAST_INSERT_ID()'];
foreach ($_POST as $k=>$v) {
	//if ($k=="HospNo") { $v = getHospNoByHospNoDisplayNoType($v); }
	$db2 = new DB;
	$db2->query("UPDATE `nurseform02o` SET `".$k."`='".$v."' WHERE `targetID`='".$targetID."'");
}
echo "OK";
?>