<?php
include("DB.php");
$town = mysql_escape_string($_GET['town']);
$db = new DB;
$db->query("SELECT DISTINCT `zip` FROM `address` WHERE `town`='".$town."'");
$r = $db->fetch_assoc();
echo $r['zip'];
?>