<?php
include("DB.php");
include("function.php");

$PID = mysql_escape_string($_POST['PID']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);
$newHospNo = mysql_escape_string($_POST['HospNoDisplay']);
for ($i=1;$i<=5;$i++) {
	if ($_POST['type'.$i]==1) {
		$newType = $i;
	}
}

$db0 = new DB;
$db0->query("SELECT * FROM `patient` WHERE `HospNo` != '".mysql_escape_string($_POST['PID'])."' AND `HospNoDisplay`='".$newHospNo."' AND `type`='".$newType."'");
if ($db0->num_rows()>0) {
	echo "EXISTED";
} else {
	$db = new DB;
	$db->query("SELECT `HospNoDisplay`, `type` FROM `patient` WHERE `HospNo` = '".mysql_escape_string($_POST['PID'])."'");
	if ($db->num_rows()>0) {
		$r = $db->fetch_assoc();
		$oldHospNo = $r['HospNoDisplay'];
		$oldType = $r['type'];
		$db1 = new DB;
		$db1->query("INSERT INTO `pInfoLog` VALUES ('".getPID($PID)."', '".date("Y-m-d H:i:s")."', '".$oldHospNo."', '".$oldType."', '".$newHospNo."', '".$newType."', '".$Qfiller."')");
		$db2 = new DB;
		$db2->query("UPDATE `patient` SET `type`='".$newType."'  WHERE `HospNo` = '".mysql_escape_string($_POST['PID'])."'");
		//$db2->query("UPDATE `patient` SET `HospNoDisplay`='".$newHospNo."', `type`='".$newType."'  WHERE `HospNo` = '".mysql_escape_string($_POST['PID'])."'");
		echo "OK";
	} else {
		echo "NORECORD";
	}
}
//echo $sql;
?>