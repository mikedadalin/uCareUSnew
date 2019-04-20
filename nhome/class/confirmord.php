<?php
include("DB.php");
//include("DB3.php");
include("function.php");

$ORDSEQ = $_POST['SEQ'];
$ORDSEQ1 = $_POST['SEQ1'];
$ORDQTY = $_POST['OUTQTY'];

$db1a = new DB;
$db1a->query("UPDATE `arkord` SET `OUT_QTY`='".$ORDQTY."' WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'");

$db1 = new DB;
$db1->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'");
$r1 = $db1->fetch_assoc();

//$db2 = new DB3;
$db2 = new DB;
$db2->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'");
if ($db2->num_rows()==0) {
	$sql = "INSERT INTO `arkord` VALUES ('".$ORDSEQ."', '".$ORDSEQ1."', '".$r1['ORD_DATE']."', '".$r1['PS_NO']."', '".$r1['PS_NAME']."', '".$r1['BED_NO']."', '".$r1['ORD_USER']."', '".$r1['STK_NO']."', '".$r1['STK_NAME']."', '".$r1['STK_UNIT']."', '".$ORDQTY."', '".$r1['ORD_PRC']."', '".$r1['ORD_AMT']."', '', '', '0', '".$r1['ORD_RMK']."', '".$r1['KIND_NO']."', '".$r1['STK_KIND1']."', '".$r1['STK_KIND2']."', '".$r1['STK_KIND3']."', '".$r1['CHG_DATE']."', '".$r1['CHG_USER']."')";
	//$sql = iconv('utf-8','big5',$sql);
	//$db2 = new DB3;
	$db2 = new DB;
	$db2->query($sql);
} else {
	$sql = "UPDATE `arkord` SET `OUT_QTY`='".$ORDQTY."' WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'";
	//$sql = iconv('utf-8','big5',$sql);
	//$db2 = new DB3;
	$db2 = new DB;
	$db2->query($sql);
}

echo "OK";
?>