<?php
include("DB2.php");

$CodeNumber = $_POST['CodeNumber'];

$db = new DB2;
$db->query("SELECT * FROM `nic_activity` WHERE `CodeNumber`='".$CodeNumber."' ORDER BY `ActivityNumber` ASC");

if ($db->num_rows()>0) {
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if ($out!="") { $out .= ';'; }
		$out .= $r['ActivityNumber'].'_'.$r['Activity'];
	}
	echo $out;
}
?>