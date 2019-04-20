<?php
include("DB2.php");
$db = new DB2;
$db->query("SELECT `road` FROM `address` WHERE `city`='".$city."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$result .= "".$r['road'].",";
}
echo substr($result,0,(strlen($result)-1));
?>