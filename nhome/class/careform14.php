<?php
include("DB.php");
include("array.php");
include("function.php");
$checktime = $_POST['checktime'];
$status = $_POST['status'];
$HospNo = $_POST['HospNo'];
$Qfiller = $_SESSION['ncareID_lwj'];

$db = new DB;
$db->query("INSERT INTO `careform14` VALUES ('', '".$HospNo."', '".date(Ymd)."', '".$checktime."', '".$status."', '".$Qfiller."')");
?>