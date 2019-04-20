<?php
session_start();
include("DB.php");
include("DB2.php");
$ok = 0;
$i = 1;
while($ok == 0) {
	$db = new DB;
	$db->query("SELECT `HospNo` FROM `patient` ORDER BY `HospNo` DESC LIMIT 0,1");
	$r = $db->fetch_assoc();
	$newHospNo = ((int)$r['HospNo']) + $i;
	$db1 = new DB;
	$db1->query("SELECT `HospNoDisplay` FROM `patient` WHERE `HospNoDisplay`='".$newHospNo."'");
	if ($db1->num_rows()==0) {
		$ok = 1;
	} else {
		$ok = 0;
		$i++;
	}
}
$newHospNo = (int)$newHospNo;
/*for ($i1=6;$i1>(6-strlen($newHospNo));$i1--) {
	echo "0";
}*/
$db2 = new DB2;
$db2->query("SELECT `HospNoLength` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$r2 = $db2->fetch_assoc();
if ($r2['HospNoLength']!=0) {
	$newHospNo = str_pad($newHospNo, $r2['HospNoLength'], "0", STR_PAD_LEFT);
} else {
	$newHospNo = str_pad($newHospNo, 6, "0", STR_PAD_LEFT);
}
echo $newHospNo;
?>