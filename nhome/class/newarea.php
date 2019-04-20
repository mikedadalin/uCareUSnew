<?php
include("DB.php");
$areaName = $_POST['areaName'];
$db = new DB;
$db->query("INSERT INTO `areainfo` VALUES ('','".$areaName."','')");
$db2 = new DB;
$db2->query("INSERT INTO `shift_area` VALUES ('','".$areaName."')");
?>