<?php
include("DB2.php");
$data = '';
$db = new DB2;
$db->query("SELECT DISTINCT `country` FROM `address` WHERE `state`='".mysql_escape_string($_POST['state'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$data .= $r['country'].':';
}
echo $data;
?>