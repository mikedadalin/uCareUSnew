<?php
include("DB.php");

$Area = $_POST['Area'];

$db = new DB;
$db->query("SELECT * FROM `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$Area."' AND (b.patientID IS NOT NULL OR b.patientID!='')");

if ($db->num_rows()>0) {
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if ($out!="") { $out .= ';'; }
		$out .= $r['bedID'];
	}
	echo $out;
} else {
	echo "nobed";
}
?>