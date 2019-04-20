<?php
include("../../class/DB.php");
include("../../class/function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Select purchase bill</title>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.8.2.min.js"></script>
</head>

<body>

<?php

//模組名稱
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = "IC";

$status = mysql_escape_string($_GET['status']);
/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 10;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }
$pageString="&status=".$status;

$strQry = "";
//預設帶入目前系統年月
if($_POST["act"]==""){
	//$strQry .= " AND RIGHT( YEAR(t1.`STK_Date`),2 ) =".date("Y")." AND LEFT( MONTH(t1.`STK_Date`),2 ) =".date("m");
	$strQry="";
}
// 總頁次及總筆數
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 inner join `firm` b on t1.firmID=b.firmID where t1.type='".$type."' and t1.IsStatus='N' ".$strQry."";
$dbpage = new DB;
$dbpage->query($strQry1);
$p = $dbpage->fetch_assoc();
$totalRecord = $p['tbCount'];
//echo $strQry1;

if($totalRecord < $ps){
	$totalPage = 1;	
}else{
	if($totalRecord % $ps <> 0){
		$totalPage = floor($totalRecord / $ps) +1;		
	}else{
		$totalPage = $totalRecord / $ps;
	}
}

//主SQL
$sql1="";
$sql1="SELECT * FROM ";
$sql1.="(SELECT t1.*,b.title tTitle, RIGHT( EXTRACT( YEAR_MONTH FROM  t1.`STK_Date` ) , 4 ) ordDate from `".$strModule."` t1 inner join `firm` b on t1.firmID=b.firmID where t1.IsStatus='N' and t1.type='".$type."' ".$strQry."  ORDER BY t1.`".$strModule."ID` DESC LIMIT 0, ".abs($totalRecord-($pn-1)*$ps)." ) AS T2";
$sql1.=" ORDER BY T2.`".$strModule."ID`  LIMIT 0 ,".$ps."";
?>
<center>
	<h3>Purchase bill</h3>
</center>

<div class="nurse-formlist_1">
<table width="100%">

<tr class="title">
  <td width="70">ID #</td>
  <td width="70">Purchase date</td>
  <td width="*">Vendor's name</td>
  <td width="100">Purchase total value</td>
  
</tr>
<?php
$db = new DB;
$db->query($sql1);
if ($db->num_rows()>0) {
//echo $sql1;	
  for ($i=0;$i<$db->num_rows();$i++) {
	  $r = $db->fetch_assoc();
	  foreach ($r as $k=>$v) {
		  $arrPatientInfo = explode("_",$k);
		  if (count($arrPatientInfo)==2) {
			  if ($v==1) {
				  ${$arrPatientInfo[0]} = $arrPatientInfo[1];
			  }
		  } else {
			  ${$k} = $v;
		  }
	  }
?>
<tr>
  <td>&nbsp;<a href="javascript:void(0);" id="firmStockID" onclick="ADDOC('<?php echo $r['firmStockID']; ?>','<?php echo $r['STK_Date']; ?>','<?php echo $status;?>');"><?php echo $type.$ordDate.$firmStockID; ?></a></td>
  <td>&nbsp;<?php echo $r['STK_Date']; ?></td>
  <td>&nbsp;<?php echo $tTitle ?></td>
  <td align="right"><?php echo $r['STK_TOT']; ?>&nbsp;</td>
</tr>
<?php
}}
?>
</table>
<table width="100%" style="border-collapse: collapse;" cellpadding="5" bordercolor="#f7bbc3" border="1">
  <tr>
    <td align="center" class="title page">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"?");
    ?>
    </td>
  </tr>
</table>
<!--page End-->
</div>
<!--page Start-->

<script type="text/javascript">
  function ADDOC(t,d,s)
  {
	  if(s==""){
	  	window.parent.location.href='../../index.php?mod=consump&func=formview&id=8_1OC&firmstockID='+t+'&STK_DATE='+d;
	  } else {
		window.parent.location.href='../../index.php?mod=consump&func=formview&id='+s+'&firmstockID='+t+'&STK_DATE='+d;  
	  }
  }
</script>
<p>&nbsp;</p>
</body>
</html>


