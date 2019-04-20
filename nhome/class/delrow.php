<?php
include("DB.php");
$db1 = new DB;
$db1->query("DELETE FROM `".$_POST['formID']."` WHERE `".$_POST['colID']."`='".mysql_escape_string($_POST['autoID'])."'");
echo "OK";
?>