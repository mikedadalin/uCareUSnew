<?php
include("DB2.php");

$DomainID = $_POST['DomainID'];

$db = new DB2;
$db->query("SELECT * FROM `diagnoses_classification` WHERE `DomainID`='".$DomainID."' ORDER BY `ClassID` ASC");

if ($db->num_rows()>0) {
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if ($out!="") { $out .= ';'; }
		$out .= $r['ClassID'].'_'.$r['ClassName'];
	}
	echo $out;
}
?>