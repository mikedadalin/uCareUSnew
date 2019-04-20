<?php
include("DB.php");
$Qcontent = $_POST['Qcontent'];
$HospNo = $_POST['HospNo'];
$date = formatdate($_POST['date']);
$Qfiller = $_POST['Qfiller'];

$Qwcontent = "長輩於".$date."看診，醫師意見：".$Qcontent;

$db = new DB;
$db->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".$date."', '".date(Hi)."', '看診醫師回覆', '".$Qwcontent."', '', '".$Qfiller."')");
?>