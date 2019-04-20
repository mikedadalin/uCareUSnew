<?php
include("DB.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$town = $_POST['town'];
$db = new DB;
$db->query("SELECT `road` FROM `address` WHERE `town`='".$town."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$result .= "".$r['road'].",";
}
echo substr($result,0,(strlen($result)-1));
?>