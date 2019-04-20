<?php
include("DB2.php");

$DomainID = $_POST['DomainID'];
$ClassID = $_POST['ClassID'];

$db = new DB2;
$db->query("SELECT * FROM `diagnoses_code` WHERE `DomainID`='".$DomainID."' AND `ClassID`='".$ClassID."' ORDER BY `no` ASC");

if ($db->num_rows()>0) {
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if ($out!="") { $out .= ';'; }
		$out .= $r['Code'].'_'.$r['Diagnoses'];
	}
	echo $out;
}
?>