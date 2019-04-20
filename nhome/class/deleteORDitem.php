<?php
include("DB.php");
//include("DB3.php");
include("function.php");

$ORDID = $_POST['ORDID'];

$ORDID = explode('_',$ORDID);
$ORDSEQ = $ORDID[1];
$ORDSEQ1 = $ORDID[2];

$db1 = new DB;
$db1->query("DELETE FROM `arkord` WHERE `ORD_SEQ`='".$ORDSEQ."' AND `ORD_SEQ1`='".$ORDSEQ1."'");

echo "OK";
?>