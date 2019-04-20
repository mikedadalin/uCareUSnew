<?php
include("DB2.php");
$data = '';
$db = new DB2;
$db->query("SELECT DISTINCT `zip` FROM `address` WHERE `city`='".mysql_escape_string($_POST['city'])."' AND `country`='".mysql_escape_string($_POST['country'])."' AND `state`='".mysql_escape_string($_POST['state'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$data .= $r['zip'].':';
}
echo $data;
?>