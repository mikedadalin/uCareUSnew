<?php
include("DB.php");
$db = new DB;
$db->query("SELECT `Module` FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
$r = $db->fetch_assoc();
echo $r['Module'];
?>