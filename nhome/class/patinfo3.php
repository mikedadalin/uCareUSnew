<?php
include("DB.php");
include("function.php");

$sql = "SELECT `HospNoDisplay`, `type` FROM `patient` WHERE `HospNo` = '".mysql_escape_string($_POST['PID'])."'";

$db = new DB;
$db->query($sql);
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	echo $r['HospNoDisplay'].";".$r['type'];
} else {
	echo "NORECORD";
}
//echo $sql;
?>