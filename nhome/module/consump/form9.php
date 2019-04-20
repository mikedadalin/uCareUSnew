<script type="text/javascript" src="js/share.js"></script>
<?php

//模組名稱
$strModule = "stockform";

/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 10;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }


$strQry = "";

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
		$strQry .=" AND t1.STK_MONTH ='".date(m)."'";
	}


$pageString = "STK_NO1=".$_GET["STK_NO1"]."&STK_NO2=".$_GET["STK_NO2"];
$pageString .= "&SSTOCK_INFO1=".$_GET["SSTOCK_INFO1"]."&SSTOCK_INFO2=".$_GET["SSTOCK_INFO2"];
$pageString .= "&Syear=".$_GET["Syear"]."&Smonth=".$_GET["Smonth"];
$pageString .= "&Sword=".$_GET["Sword"];

// 總頁次及總筆數
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 inner join `stockinfo` b on t1.StockID=b.stockinfoID inner join arkstock c on t1.STK_NO=c.STK_NO ".$strQry."";
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
//$sql1="SELECT * FROM ";
$sql1.="SELECT t1.* ,b.Title tTitle, c.STK_UNIT from `".$strModule."` t1 inner join `stockinfo` b on t1.StockID=b.stockinfoID inner join arkstock c on t1.STK_NO=c.STK_NO ".$strQry."  ORDER BY t1.STK_YEAR DESC,t1.STK_MONTH DESC, t1.OUT_STK DESC, t1.`StockID` LIMIT ".(($pn-1)*$ps).", ".$ps."";
//$sql1.=" ORDER BY T2.STK_YEAR DESC,T2.STK_MONTH DESC, T2.OUT_STK DESC, T2.`StockID` LIMIT 0 ,".$ps."";

//echo $sql1;

?>
<h3>Inventory record</h3>
<form method="post" action="index.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
<div align="left" class="content-query">
<table class="printcol">
  <tr class="title">
    <td colspan="10">Filter condition</td>
  </tr>

  <tr>
    <td class="title"><center><b>Product(Start)</b></center></td>
    <td><input name="STK_NO1" type="text" id="STK_NO1" onblur="blurselect(1);"/></td>  
    <td><button onclick="window.open('class/searchSTK3.php?query=1', '_blank', 'width=960, height=150'); return false;" >...</button></td>
    <td><input type="text" id="STK_NAME1" name="STK_NAME1"  disabled="disabled"/></td>
    <td class="title"><center><b>Product(Until)</b></center></td>
    <td><input name="STK_NO2" type="text" id="STK_NO2" onblur="blurselect(2);"/></td>  
    <td><button onclick="window.open('class/searchSTK3.php?query=2', '_blank', 'width=960, height=150'); return false;" >...</button></td>
    <td><input type="text" id="STK_NAME2" name="STK_NAME2"  disabled="disabled"/></td>
    
   </tr>
  <tr>
   <td class="title"><center><b>Storehouse(Start)</b></center></td>
    <td ><input name="SSTOCK_INFO1" type="text" id="SSTOCK_INFO1" onblur="stockINFO(1);this.value = this.value.toUpperCase();"/></td>  
    <td><button onclick="window.open('class/consump.php?query=2&c=1', '_blank', 'width=300, height=200'); return false;" >...</button></td>
    <td ><input type="text" id="SSTOCK_INFO_NAME1" name="SSTOCK_INFO_NAME1" disabled="disabled"/></td>
   <td class="title"><center><b>Storehouse(Until)</b></center></td>
    <td ><input name="SSTOCK_INFO2" type="text" id="SSTOCK_INFO2" onblur="stockINFO(2);this.value = this.value.toUpperCase();"/></td>  
    <td><button onclick="window.open('class/consump.php?query=2&c=2', '_blank', 'width=300, height=200'); return false;" >...</button></td>
    <td ><input type="text" id="SSTOCK_INFO_NAME2" name="SSTOCK_INFO_NAME2" disabled="disabled"/></td>
    </tr>
   <tr>
    <td class="title">Inventory (annual) </td>
    <td align="left"  colspan="3" >
	<select name="Syear" id="Syear">
    <?php for($ii = 2014 ;$ii<= 2024; $ii++){ ?>
    	<option value="<?php echo $ii; ?>" <?php if($_GET['Syear']==$ii) { echo 'selected'; } elseif ($_GET['Syear']==NULL && date(Y)==$ii) { echo 'selected'; } ?>><?php echo $ii."Year"; ?></option>
    <?php }?>
    </select>
	</td>
    <td class="title">Inventory (monthly) </td>
    <td align="left"  colspan="3">
	<select name="Smonth" id="Smonth">
    <?php 
		
		for($ii = 1 ;$ii<= 12; $ii++){
			
	?>
    	<option value="<?php if($ii<10){echo "0".$ii;}else{echo $ii;} ?>" <?php if($_GET['Smonth']==$ii) { echo 'selected'; } elseif ($_GET['Smonth']==NULL && date(m)==$ii) { echo 'selected'; } ?>><?php echo $ii."Month"; ?></option>
      <?php }?>
    </select>
	</td>
    </tr>
    <tr>
    <td class="title">Product keyword</td>
    <td align="left"  colspan="8">
      <input type="text" name="Sword" id="Sword" value="" size="50" >
	</td>
    </tr>
  <tr>
    <td colspan="10"><center>
<input type="button" value="Search" id="btnSearch" name="btnSearch" /> 
    </center></td>
    </tr>
</table>
</div>
<div align="right">
<input type="button" name="btnMove" id="btnMove" value=" Storehouse shifting " />
<input type="button" name="btnAdd" id="btnAdd" value=" Storehouse information " />
</div>
<div class="content-table">
<table>
<tr class="title">
  <td>Year</td>
  <td> month</td>
  <td>Storehouse</td>
  <td>Storehouse name</td>
  <td>product serial number</td>
  <td>Product name</td>
  <td>Unit</td>
  <!--<td width="70">期初金額</td>-->
  <td>Beginning quantity</td>
  <td>Purchase quantity</td>
  <td>Delivery quantity</td>
  <td>Adjust quantity</td>
  <td>Ending quantity</td>
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
  <td align="center"><?php echo $r['STK_YEAR'] ?></td>
  <td align="center"><?php echo $r['STK_MONTH'] ?></td>
  <td align="center"><?php echo $r['StockID']; ?></td>
  <td><?php echo $r['tTitle']; ?></td>
  <td>&nbsp;<?php echo $r['STK_NO']; ?></td>
  <td><?php echo $r['Title'] ?></td>
  <td align="center"><?php echo $r['STK_UNIT']; ?></td>
  <td align="right"><?php echo $r['BE_STK']; ?></td>
  <!--<td align="right"><?php //echo $r['BE_PRC']; ?>&nbsp;</td>-->
  <td align="right"><?php echo $r['IN_STK']; ?>&nbsp;</td>
  <td align="right"><?php echo $r['OUT_STK']; ?>&nbsp;</td>
  <td align="right"><?php echo $r['ADJ_STK']; ?>&nbsp;</td>
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
<!--page Start-->
<table style="border-collapse: collapse;" cellpadding="5" border="0">
  <tr>
    <td align="center" class="title page">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=consump&func=formview&id=9");
    ?>
    </td>
  </tr>
</table>
<!--page End-->
</div>
<input type="hidden" name="act" id="act" />
</form>

<p>&nbsp;</p>
<script language="javascript">
$(function() {
  $('#btnSearch').click(function() {
	$('#act').val('search');
	var ST1 = "&STK_NO1=" + $('#STK_NO1').val();
	var ST2 = "&STK_NO2=" + $('#STK_NO2').val();
	var ST3 = "&SSTOCK_INFO1=" + $("#SSTOCK_INFO1").val();
	var ST4 = "&SSTOCK_INFO2=" + $("#SSTOCK_INFO2").val();
	var ST5 = "&Sword=" + $("#Sword").val();
	var ST6 = "&Syear=" + $("#Syear").val();
	var ST7 = "&Smonth=" + $("#Smonth").val();
	var ST = ST1 + ST2 + ST3 + ST4 + ST5 +ST6 + ST7 ;
	$('form').attr('action', "index.php?mod=consump&func=formview&id=9"+ ST);	
	$('form').submit();
  });

  $('#btnAdd').click(function() {
	location.href='index.php?mod=consump&func=formview&id=1c';
   });
  $('#btnMove').click(function() {
	location.href='index.php?mod=consump&func=formview&id=9_1';
   });  
});

function blurselect(id) {//取得產品資訊
	$.ajax({
		url: "class/searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#STK_NO"+id).val() },
		success: function(data) {
			var arr = data.split("||");
			$('#STK_NO'+id).val(arr[0]);
			$('#STK_NAME'+id).val(arr[1]);
		}
	});
}

function stockINFO(id) {
  $.ajax({
	  url: "class/stockInfo.php",
	  type: "POST",
	  data: { "PID": $("#SSTOCK_INFO"+id).val()},
	  success: function(data) {
		  var STOCK_INFO_NAME = document.getElementById('SSTOCK_INFO_NAME'+id);
		  $('#SSTOCK_INFO_NAME'+id).val(data);
	  }
  });
}

</script>
	