<script type="text/javascript" src="js/share.js"></script>
<h3>Adjustment note detail</h3>
<?php

//模組名稱
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = "A";

/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 10;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }


$strQry = "";
//預設帶入目前系統年月
if($_POST["act"]==""){
	$strQry .= " AND YEAR( t1.STK_Date ) =  '".date("Y")."' AND  MONTH(t1.`STK_Date`) ='".date("m")."'";
}
		
if($_POST["act"]=="search"){
	//抓取預設日期
	if($_POST["firmID"]=="" && $_POST["firmStockID"]=="" && $_POST["sSTK_Date"]==""){
		$strQry .= " AND YEAR( t1.STK_Date ) =  '".date("Y")."' AND  MONTH(t1.`STK_Date`) ='".date("m")."'";
	}

}

//Adjusted date
if($_GET["sSTK_Date"]!=""){
	$strQry .= " AND t1.STK_Date >= '".mysql_escape_string($_GET["sSTK_Date"])."'";
}
if($_GET["eSTK_Date"]!=""){
	$strQry .= " AND t1.STK_Date <= '".mysql_escape_string($_GET["eSTK_Date"])."'";
}

//Adjustment note ID#
if($_GET["firmStockID1"]!=""){
	$tmpDate1 = substr($_GET["firmStockID1"], 0, 2);
	$tmpDate2 = substr($_GET["firmStockID1"], 2, 2);
	$tmpStockID = substr($_GET["firmStockID1"], 4, 4);		
	$strQry .= " AND RIGHT( YEAR(  `STK_Date` ) , 2 ) =".$tmpDate1."";
	$strQry .= " AND LEFT( MONTH(  `STK_Date` ) , 2 ) =".$tmpDate2."";
	$strQry .=" AND  a.`firmStockID` >=".$tmpStockID;
}

if($_GET["firmStockID2"]!=""){
	$tmpDate1 = substr($_GET["firmStockID2"], 0, 2);
	$tmpDate2 = substr($_GET["firmStockID2"], 2, 2);
	$tmpStockID = substr($_GET["firmStockID2"], 4, 4);		
	$strQry .= " AND RIGHT( YEAR(  `STK_Date` ) , 2 ) =".$tmpDate1."";
	$strQry .= " AND LEFT( MONTH(  `STK_Date` ) , 2 ) =".$tmpDate2."";
	$strQry .=" AND  a.`firmStockID` <=".$tmpStockID;
}

	//product serial number
	if($_GET["STK_NO1"]!=""){
		$strQry .= " AND a.STK_NO >= ".$_GET["STK_NO1"];
	}
	if($_GET["STK_NO2"]!=""){
		$strQry .= " AND a.STK_NO <= ".$_GET["STK_NO2"];
	}
	
	//Storehouse ID#
	if($_GET["SSTOCK_INFO1"]!=""){
		$strQry .= " AND a.StockID >= '".mysql_escape_string($_GET["SSTOCK_INFO1"])."'";
	}
	if($_GET["SSTOCK_INFO2"]!=""){
		$strQry .= " AND a.StockID <= '".mysql_escape_string($_GET["SSTOCK_INFO2"])."'";
	}

$pageString = "sSTK_Date=".$_GET["sSTK_Date"]."&eSTK_Date=".$_GET["eSTK_Date"]."&firmStockID1=".$_GET["firmStockID1"]."&firmStockID2=".$_GET["firmStockID2"]."&STK_NO1=".$_GET["STK_NO1"]."&STK_NO2=".$_GET["STK_NO2"]."&SSTOCK_INFO1=".$_GET["SSTOCK_INFO1"]."&SSTOCK_INFO2=".$_GET["SSTOCK_INFO2"];


// 總頁次及總筆數
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 inner join ".$subModule." a on a.`firmStockID`=t1.`firmStockID` and a.`type`=t1.`type` and  a.`STK_Date`=t1.`STK_Date` inner join `arkstock` b on b.STK_NO=a.STK_NO inner join `stockinfo` c on c.stockinfoID=a.StockID where t1.type='".$type."' and t1.IsStatus<>'D' ".$strQry."";
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
$sql1.="(SELECT t1.STK_Date stkdate, t1.Fmark fk, a.*, b.STK_NAME,c.Title, RIGHT( EXTRACT( YEAR_MONTH FROM  t1.`STK_Date` ) , 4 ) ordDate from ".$strModule." t1 inner join ".$subModule." a on a.`firmStockID`=t1.`firmStockID` and a.`type`=t1.`type` and  a.`STK_Date`=t1.`STK_Date` inner join `arkstock` b on b.STK_NO=a.STK_NO inner join `stockinfo` c on c.stockinfoID=a.StockID where t1.type='".$type."' and t1.IsStatus<>'D' ".$strQry." ORDER BY t1.`".$strModule."ID` DESC LIMIT 0, ".abs($totalRecord-($pn-1)*$ps).") AS T2";
$sql1.=" ORDER BY T2.`".$strModule."ID`  LIMIT 0 ,".$ps."";
//echo $sql1;
?>
<form method="post">
<div align="left" class="content-query">
<table width="100%" class="printcol">
  <tr class="title">
    <td colspan="8">Filter condition</td>
  </tr>

  <tr>
    <td width="120" class="title"><center><b>Adjustment note ID#(Start)</b></center></td>
    <td align="left" colspan="3"><?php echo $type;?><input type="text" id="firmStockID1" name="firmStockID1" /></td>
    <td width="120" class="title"><center><b>Adjustment note ID#(Until)</b></center></td>
    <td align="left" colspan="3"><?php echo $type;?><input type="text" id="firmStockID2" name="firmStockID2" /></td>
</tr>
  <tr>
    <td class="title" width="120">Adjusted date(Start)</td>
    <td align="left" colspan="3">
      <input type="text" name="sSTK_Date" id="sSTK_Date" value="" size="12" > 
	</td>
    <td class="title" width="120">Adjusted date(Until)</td>
    <td align="left" colspan="3">
      <input type="text" name="eSTK_Date" id="eSTK_Date" value="" size="12" > 
	</td>
    </tr>
  <tr>
    <td width="120" class="title"><center><b>Product(Start)</b></center></td>
    <td><input name="STK_NO1" type="text" id="STK_NO1" onblur="blurselect(1);"/></td>  
    <td><button onclick="window.open('class/searchSTK3.php?query=1', '_blank', 'width=960, height=150'); return false;" >...</button></td>
    <td><input type="text" id="STK_NAME1" name="STK_NAME1"  disabled="disabled"/></td>
    <td width="120" class="title"><center><b>Product(Until)</b></center></td>
    <td><input name="STK_NO2" type="text" id="STK_NO2" onblur="blurselect(2);"/></td>  
    <td><button onclick="window.open('class/searchSTK3.php?query=2', '_blank', 'width=960, height=150'); return false;" >...</button></td>
    <td><input type="text" id="STK_NAME2" name="STK_NAME2"  disabled="disabled"/></td>
    
   </tr>
  <tr>
   <td width="120" class="title"><center><b>Storehouse(Start)</b></center></td>
    <td ><input name="SSTOCK_INFO1" type="text" id="SSTOCK_INFO1" onblur="stockINFO(1);this.value = this.value.toUpperCase();"/></td>  
    <td><button onclick="window.open('class/consump.php?query=2&c=1', '_blank', 'width=300, height=200'); return false;" >...</button></td>
    <td ><input type="text" id="SSTOCK_INFO_NAME1" name="SSTOCK_INFO_NAME1" disabled="disabled"/></td>
   <td width="120" class="title"><center><b>Storehouse(Until)</b></center></td>
    <td><input name="SSTOCK_INFO2" type="text" id="SSTOCK_INFO2" onblur="stockINFO(2);this.value = this.value.toUpperCase();"/></td>  
    <td><button onclick="window.open('class/consump.php?query=2&c=2', '_blank', 'width=300, height=200'); return false;" >...</button></td>
    <td ><input type="text" id="SSTOCK_INFO_NAME2" name="SSTOCK_INFO_NAME2" disabled="disabled"/></td>
    </tr>
  <tr>
    <td colspan="8"><center>
<input type="button" value="Search" id="btnSearch" name="btnSearch" /> 
    </center></td>
    </tr>
</table>
</div>
<div align="right">
<input type="button" name="btnBack" id="btnBack" value=" Back to adjustment ">	
</div>
<div class="content-table">
<table width="100%">
<tr class="title">
  <td width="100">Adjustment note ID#</td>
  <td width="100">Adjusted date</td>
  <td width="100">product serial number</td>
  <td width="*">Product name</td>
  <td width="50">Storehouse</td>
  <td width="80">Storehouse name</td>
  <td width="40">Quantity</td>
  <td width="40">Unit price</td>
  <td width="40">Amount of fee</td>
  <td width="100">Comment</td>
</tr>
<?php

$db = new DB;
$db1 = new DB;
$db->query($sql1);
if ($db->num_rows()>0) {

$tmp = "";
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
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 inner join ".$subModule." a on a.`firmStockID`=t1.`firmStockID` and a.`type`=t1.`type` and  a.`STK_Date`=t1.`STK_Date` inner join `arkstock` b on b.STK_NO=a.STK_NO inner join `stockinfo` c on c.stockinfoID=a.StockID where t1.type='".$type."' and t1.IsStatus<>'D' ".$strQry." and a.firmStockID='".$r['firmStockID']."' and a.`STK_Date`='".$r['stkdate']."'";

//echo $strQry1."<br>";
$db1->query($strQry1);
$rs1 = $db1->fetch_assoc();
$IDdate = $r['stkdate']."+".$r['firmStockID'];

if($tmp == $IDdate){
	${'qty_'.$IDdate} += $r['QTY'];
	${'prc_'.$IDdate} += $r['QTY']*$r['Price'];
} else {
	${'qty_'.$IDdate} = $r['QTY'];
	${'prc_'.$IDdate} = $r['QTY']*$r['Price'];
}
${'count_'.$IDdate}++;

?>
<tr>
  <?php if($tmp != $IDdate){ ?>
  	<td rowspan="<?php echo $rs1['tbCount']; ?>">&nbsp;<?php echo $type.$ordDate.$firmStockID; ?></td>
    <td rowspan="<?php echo $rs1['tbCount']; ?>">&nbsp;<?php echo $r['stkdate']; ?></td>
  <?php }?>
  <td>&nbsp;<?php echo $r['STK_NO']; ?></td>
  <td>&nbsp;<?php echo $r['STK_NAME']; ?></td>
  <td>&nbsp;<?php echo $r['StockID']; ?></td>
  <td>&nbsp;<?php echo $r['Title']; ?></td>
  <td align="right">&nbsp;<?php echo $r['QTY']; ?></td>  
  <td align="right">&nbsp;<?php echo $r['Price']; ?></td>  
  <td align="right">&nbsp;<?php echo $r['QTY']*$r['Price']; ?></td>  
  <?php if($tmp != $IDdate){ ?>
  <td rowspan="<?php echo $rs1['tbCount']; ?>" valign="top">&nbsp;<?php echo $r['fk']; ?></td>
  <? }?>
</tr>
<?php
if ($rs1['tbCount']==${'count_'.$IDdate}) {
	echo '<tr><td colspan="10" align="right">Subtotal:'.$rs1['tbCount'].' data ,數量調整：'.${'qty_'.$IDdate}.'，金額調整： $ '.${'prc_'.$IDdate}.'&nbsp;</td>';
	echo '</tr>';
}
?>
<?php 
$tmp = $IDdate;
}
}else{?>
<tr>
  <td align="center" colspan="10">No data yet!!</td>
</tr>

<?php
}
?>
</table>
<!--page Start-->
<table width="100%" style="border-collapse: collapse;" cellpadding="5" bordercolor="#f7bbc3" border="1" class="printcol">
  <tr>
    <td align="center" class="title page">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=consump&func=formview&id=8_6");
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
function newORD() {
  $.ajax({
	  url: "class/firm.php",
	  type: "POST",
	  data: { "PID": $("#firmID").val()},
	  success: function(data) {
		  var dataArr = data.split(';');
		  for (i = 0; i < dataArr.length; i++){				
			  $( "#log"+i ).val( dataArr[i] );
		  }
	  }
  });
}

$(function() {
  $('#btnSearch').click(function() {
	$('#act').val('search');
	var sDate, eDate;
	sDate = new Date($('#sSTK_Date').val().replace(/-/g, "/"));
	eDate = new Date($('#eSTK_Date').val().replace(/-/g, "/"));
	if (($('#sSTK_Date').val() != "") && ($('#eSTK_Date').val() != "")) {
	  if (sDate.getTime() > eDate.getTime()) {
		alert('起始日期不可大於截止日期！');
		$('#sSTK_Date').focus();
		return false;
	  }
	}  
	var url1 = "&firmStockID1="+$('#firmStockID1').val()+"&firmStockID2="+$('#firmStockID2').val();
	var url2 = "&sSTK_Date="+$('#sSTK_Date').val()+"&eSTK_Date="+$('#eSTK_Date').val();
	var url3 = "&STK_NO1="+$("#STK_NO1").val()+"&STK_NO2="+$("#STK_NO2").val();
	var url4 = "&SSTOCK_INFO1="+$("#SSTOCK_INFO1").val()+"&SSTOCK_INFO2="+$("#SSTOCK_INFO2").val();
	$('form').attr('action', "index.php?mod=consump&func=formview&id=8_6"+url1+url2+url3+url4);
	$('form').submit();
  });

  $('#btnBack').click(function() {
	location.href='index.php?mod=consump&func=formview&id=8_3';
   });
  
  $( "#sSTK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
  $( "#eSTK_Date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true});
  
  
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
		