<script type="text/javascript" src="js/share.js"></script>
<?php

//模組名稱
$strModule = "stockform";

if($_POST["act"]==""){
	//$strQry .=" and `STK_YEAR`='".date("Y")."' and STK_MONTH='".date("m")."'";
}
	
	
	//product serial number
	if($_GET["STK_NO1"]!=""){
		$strQry .= " AND t1.STK_NO >= ".$_GET["STK_NO1"];
	}
	if($_GET["STK_NO2"]!=""){
		$strQry .= " AND t1.STK_NO <= ".$_GET["STK_NO2"];
	}
	
	//Storehouse ID#
	if($_GET["SSTOCK_INFO1"]!=""){
		$strQry .= " AND t1.StockID >= '".mysql_escape_string($_GET["SSTOCK_INFO1"])."'";
	}
	if($_GET["SSTOCK_INFO2"]!=""){
		$strQry .= " AND t1.StockID <= '".mysql_escape_string($_GET["SSTOCK_INFO2"])."'";
	}

	//關鍵字
	if($_GET["Sword"]!=""){
		$strQry .=" AND t1.Title like '%".trim($_GET["Sword"])."%'";
	}
	//年度
	if($_GET["Syear"]!=""){
		$strQry .=" AND t1.STK_YEAR = '".trim($_GET["Syear"])."'";
	} else {
		$strQry .=" AND t1.STK_YEAR = '".date(Y)."'";
	}
	// month
	if($_GET["Smonth"]!=""){
		$strQry .=" AND t1.STK_MONTH ='".trim($_GET["Smonth"])."'";
	} else {
		$strQry .=" AND t1.STK_MONTH = '".date(m)."'";
	}

//主SQL
$sql1="";
$sql1="SELECT * FROM ";
$sql1.="(SELECT t1.* ,b.Title tTitle, c.STK_UNIT from `".$strModule."` t1 inner join `stockinfo` b on t1.StockID=b.stockinfoID inner join arkstock c on t1.STK_NO=c.STK_NO ".$strQry."  ORDER BY t1.STK_NO DESC, t1.Title DESC, t1.`StockID` DESC) AS T2";
$sql1.=" ORDER BY T2.STK_NO, T2.Title, T2.`StockID`";

//echo $sql1;

?>
<h3>Inventory record <span id="date"></span></h3>
<div class="content-table">
<table width="100%">
<tr class="title">
  <td width="50">Storehouse</td>
  <td width="80">Storehouse name</td>
  <td width="80">product serial number</td>
  <td width="*">Product name</td>
  <td width="70">Unit</td>
  <td width="70">Beginning quantity</td>
  <!--<td width="70">期初金額</td>-->
  <td width="70">Purchase quantity</td>
  <td width="70">Delivery quantity</td>
  <td width="70">Ending quantity</td>
  <!--<td width="70">期末金額</td>-->
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
  <td align="center"><?php echo $r['StockID']; ?></td>
  <td><?php echo $r['tTitle']; ?></td>
  <td>&nbsp;<?php echo $r['STK_NO']; ?></td>
  <td><?php echo $r['Title'] ?></td>
  <td align="center"><?php echo $r['STK_UNIT']; ?></td>
  <td align="right"><?php echo $r['BE_STK']; ?></td>
  <!--<td align="right"><?php //echo $r['BE_PRC']; ?>&nbsp;</td>-->
  <td align="right"><?php echo $r['IN_STK']+$r['ADJ_STK']; ?>&nbsp;</td>
  <td align="right"><?php echo $r['OUT_STK']; ?>&nbsp;</td>
  <td align="right"><?php echo ($r['BE_STK']+$r['IN_STK']-$r['OUT_STK'])+$r['ADJ_STK']; ?>&nbsp;</td>
  <!--<td align="right"><?php //echo ($r['BE_PRC']+$r['IN_PRC']-$r['OUT_PRC'])+$r['ADJ_PRC']; ?>&nbsp;</td>-->
</tr>
<?php }}else{?>
<tr>
  <td align="center" colspan="13">No data yet!!</td>
</tr>

<?php
}
?>
</table>
</div>
<input type="hidden" name="act" id="act" />
</form>

<p>&nbsp;</p>
<script>
$(document).ready( function() {
	$('#date').html('(<?php echo $r['STK_YEAR']; ?>Year<?php echo $r['STK_MONTH']; ?>Month)');
});
</script>
	