<?php
include("DB2.php");
$data = '';
$db = new DB2;
$db->query("SELECT DISTINCT `city` FROM `address` WHERE `country`='".mysql_escape_string($_POST['country'])."' AND `state`='".mysql_escape_string($_POST['state'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$data .= $r['city'].':';
}
echo $data;
?>