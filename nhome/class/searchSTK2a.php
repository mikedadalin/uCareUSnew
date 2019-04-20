<?php
//include("DB3.php");
include("DB.php");

$STK_NO = $_POST['STK_SELECT'];

$sql = "SELECT * FROM `arkstock` WHERE `STK_NO`='".$STK_NO."' AND `STOP_ID`='N'";

//$db = new DB3;
$db = new DB;
$db->query($sql);
$r = $db->fetch_assoc();
$result = $r['STK_NO'].'||'.$r['STK_NAME'].'||'.$r['STK_SPK'].'||'.$r['STK_MODEL'].'||'.$r['STK_UNIT'].'||'.$r['IN_PRC'].'||'.$r['LAY_NO'].'||'.$r['OUT_PRC'];

echo $result;
?>