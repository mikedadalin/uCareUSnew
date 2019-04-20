<?php
include("DB.php");
foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$med = $_POST['med'];
$db = new DB;
$db->query("SELECT `name`, `name2` FROM `drug` WHERE `name2` LIKE '%".$med."%'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$result .= trim($r['name'])." (".trim($r['name2'])."),";
}
echo substr($result,0,(strlen($result)-1));
?>