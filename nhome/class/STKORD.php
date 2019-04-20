<?php
include("DB.php");
//include("DB3.php");
include("function.php");

$ORDSEQ = $_POST['ORDSEQ'];
$STK_NO = $_POST['STK_NO'];
$ORDQTY = $_POST['ORDQTY'];

//$db = new DB3;
$db = new DB;
$db->query("SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".$STK_NO."'");
$r = $db->fetch_assoc();

$ORDAMT = $r['ORD_PRC']*$ORDQTY;

$db1 = new DB;
$db1->query("SELECT * FROM `arkordinfo` WHERE `ORD_SEQ`='".$ORDSEQ."'");
$r1 = $db1->fetch_assoc();

$db2 = new DB;
$db2->query("SELECT `ORD_SEQ1` FROM `arkord` WHERE `ORD_SEQ`='".$ORDSEQ."' ORDER BY `ORD_SEQ1` DESC LIMIT 0,1");
$r2 = $db2->fetch_assoc();
$seq1no = $r2['ORD_SEQ1']+1;

$db2 = new DB;
$db2->query("INSERT INTO `arkord` (`ORD_SEQ`, `ORD_SEQ1`, `ORD_DATE`, `PS_NO`, `PS_NAME`, `BED_NO`, `ORD_USER`, `STK_NO`, `STK_NAME`, `STK_UNIT`, `ORD_QTY`, `ORD_PRC`, `ORD_AMT`, `STK_KIND1`, `STK_KIND2`, `STK_KIND3`, `CHG_DATE`, `CHG_USER`) VALUES ('".$ORDSEQ."', '".$seq1no."', '".$r1['ORD_DATE']."', '".$r1['PS_NO']."', '".$r1['PS_NAME']."', '".$r1['BED_NO']."', '".$r1['ORD_USER']."', '".$STK_NO."', '".$r['STK_NAME']."', '".$r['STK_UNIT']."', '".$ORDQTY."', '".$r['ORD_PRC']."', '".$ORDAMT."', '".$r['STK_KIND1']."', '".$r['STK_KIND2']."','".$r['STK_KIND3']."', '".date('Y-m-d H:i:s')."', '".$r1['ORD_USER']."')");

echo $STK_NO.'||'.$r['STK_NAME'].'||'.$ORDQTY.'||'.$r['STK_UNIT'];
?>