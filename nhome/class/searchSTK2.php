<?php
include("DB.php");

$STK_NO = $_POST['STK_SELECT'];

$sql = "SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".$STK_NO."' AND `STOP_ID`='0'";

$db = new DB;
$db->query($sql);
$r = $db->fetch_assoc();
$result = $r['ApplyItemID'].'||'.$r['STK_NAME'].'||'.$r['STK_SPK'].'||'.$r['STK_MODEL'].'||'.$r['STK_UNIT'].'||'.$r['IN_PRC'].'||'.$r['LAY_NO'];

echo $result;
?>