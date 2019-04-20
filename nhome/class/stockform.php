<?php
include("DB.php");
include("DB2.php");
include("function.php");

$StockID = mysql_escape_string($_POST['StockID']);
$STK_NO = mysql_escape_string($_POST['STK_NO']);
$STK_DATE = mysql_escape_string($_POST['STK_DATE']);
$arrDateFunction = chkDate($STK_DATE);
$strSQL = "SELECT ((`BE_STK` + `IN_STK` - `OUT_STK`) + `ADJ_STK`) AS `QTY` FROM  `stockform` ";
$strSQL .= " WHERE `StockID` =  '".$StockID."' AND `STK_NO` = '".$STK_NO."'";
$strSQL .= " AND `STK_YEAR` = '".$arrDateFunction['year']."' AND `STK_MONTH` = '".$arrDateFunction['month']."'";
$db = new DB;
$db->query($strSQL);

$db1 = new DB;
$db1->query("SELECT `SAFE_QTY` FROM `arkstock` WHERE `STK_NO`='".$STK_NO."'");

if($db->num_rows()>0){
	$rs = $db->fetch_assoc();
	$rs1 = $db1->fetch_assoc();
	$safeQTY = $rs1['SAFE_QTY'];
	if ($safeQTY=="") $safeQTY=0;
	if ($safeQTY>=$rs['QTY']) { echo "1:"; } else { echo "0:"; }
	echo $rs['QTY'];
}else{
	echo '0:0';
}
?>