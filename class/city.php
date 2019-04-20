<?php
include("DB.php");

$city = mysql_escape_string($_GET['city']);
$db = new DB;
$db->query("SELECT DISTINCT `town` FROM `address` WHERE `city`='".$city."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	echo $r['town'].':';
}
?>