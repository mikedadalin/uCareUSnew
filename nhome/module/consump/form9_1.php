<h3>Storehouse shifting</h3>
<?php

//模組名稱
$strModule = "stockform";
//$subModule = "firmstockinfo";
/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 10;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }
	$arrDate = chkDate(date("Y/m/d"));
	
	$strQry = " and `STK_YEAR`='".$arrDate['year']."' and STK_MONTH='".$arrDate['month']."'";
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
$pageString = "STK_NO1=".$_GET["STK_NO1"]."&STK_NO2=".$_GET["STK_NO2"];
$pageString .= "&SSTOCK_INFO1=".$_GET["SSTOCK_INFO1"]."&SSTOCK_INFO2=".$_GET["SSTOCK_INFO2"];



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
$sql1="SELECT * FROM ";
$sql1.="(SELECT t1.* ,b.Title tTitle, c.STK_UNIT from `".$strModule."` t1 inner join `stockinfo` b on t1.StockID=b.stockinfoID inner join arkstock c on t1.STK_NO=c.STK_NO where t1.IsStatus='N' AND (t1.BE_STK + t1.IN_STK - t1.OUT_STK + t1.ADJ_STK) <>0 ".$strQry." ORDER BY t1.STK_NO DESC, t1.Title DESC, t1.`StockID` DESC LIMIT 0, ".abs($totalRecord-($pn-1)*$ps)." ) AS T2";
$sql1.=" ORDER BY T2.STK_NO, T2.Title, T2.`StockID` LIMIT 0 ,".$ps."";

//echo $sql1;
?>
<form method="post" action="index.php?<?php echo $_SERVER['QUERY_STRING']; ?>" id="form1" name="form1">
<div align="left" class="content-query">
<table>
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
    <td colspan="10"><center>
<input type="button" value="Search" id="btnSearch" name="btnSearch" /> 
    </center></td>
    </tr>
</table>
</div>
<div class="content-table">
<table>
<tr class="title">
  <td>Storehouse</td>
  <td>Storehouse name</td>
  <td>product serial number</td>
  <td>Product name</td>
  <td>Unit</td>
  <td>Current storage</td>
  <td>Current storage amount of dollar</td>
  <td>Function</td>
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
	  	  $STK = ($r['BE_STK']+$r['IN_STK']-$r['OUT_STK'])+$r['ADJ_STK'];
		  $PRC = ($r['BE_PRC']+$r['IN_PRC']-$r['OUT_PRC'])+$r['ADJ_PRC'];
?>
<tr>
  <td align="center"><?php echo $r['StockID']; ?></td>
  <td><?php echo $r['tTitle']; ?></td>
  <td>&nbsp;<?php echo $r['STK_NO']; ?></td>
  <td><?php echo $r['Title'] ?></td>
  <td align="center"><?php echo $r['STK_UNIT']; ?></td>
  <td align="right"><?php echo $STK; ?>&nbsp;</td>
  <td align="right"><?php echo $PRC; ?>&nbsp;</td>
  <td><input type="button" value="Storehouse shifting" onclick="moveStock('<?php echo $r['StockID'];?>','<?php echo $r['STK_NO']; ?>','<?php echo $r['STK_YEAR'] ?>','<?php echo $r['STK_MONTH'] ?>','<?php echo $STK; ?>','<?php echo $PRC; ?>');"/></td>
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
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=consump&func=formview&id=9_1");
    ?>
    </td>
  </tr>
</table>
<!--page End-->
</div>
<input type="hidden" name="act" id="act" />
</form>
<div id="dialog" title="" style="display:none;">
<form>
  <fieldset>
    <table>
      <tr>
        <td>Select storehouse</td>
        <td>
        <select id="NewArea">
          <option></option>
          <?php
		  $db_area = new DB;
		  $db_area->query("SELECT * FROM `stockinfo`");
		  for ($i=0;$i<$db_area->num_rows();$i++) {
			  $r_area = $db_area->fetch_assoc();
			  echo '<option value="'.$r_area['stockinfoID'].'">'.$r_area['stockinfoID']." - ".$r_area['Title'].'</option>'."\n";
		  }
		  ?>
        </select>
        </td>
      </tr>
      <tr>
      	<td>Shifting due to</td>
        <td><textarea id="fmark" name="fmark" cols="30" rows="2"></textarea></td>
      </tr>
    </table>
  </fieldset>
  </form>

</div>

<p>&nbsp;</p>
<script language="javascript">
$(function() {
  $('#btnSearch').click(function() {
	$('#act').val('search');
	var ST1 = "&STK_NO1=" + $('#STK_NO1').val();
	var ST2 = "&STK_NO2=" + $('#STK_NO2').val();
	var ST3 = "&SSTOCK_INFO1=" + $("#SSTOCK_INFO1").val();
	var ST4 = "&SSTOCK_INFO2=" + $("#SSTOCK_INFO2").val();
	var ST = ST1 + ST2 + ST3 + ST4 ;
	$('#form1').attr('action', "index.php?mod=consump&func=formview&id=9_1"+ ST);	
	$('#form1').submit();
  });
  $("#dialog").dialog({		  
	  autoOpen: false,
	  title: 'Storehouse shifting',
	  width: 500,
	  height: 300,
	  modal: true,
	  overlay:{opacity: 0.7, background: "#FF8899" },
	  buttons: {
		  'Confirm shifting': function(){
			  //alert($(this).data('mid'));
			  if($("#NewArea").val()=="" || $("#fmark").val()==""){return false;}
				$.ajax({
					url: "class/movestock.php",
					type: "POST",
					data: {"mid": $(this).data('mid'),"NewStock":$("#NewArea").val(),"fmark":$("#fmark").val()},
					success: function(data) {
						//alert(data);
						$( "#dialog" ).dialog( "close" );
						alert("Shifting completed");
						window.location.reload();
					}
				});
			  
			  
		  },
		  'Close': function() {
			  $(this).dialog('close');
			  window.location.reload();
		  }			  
	  }
   });
});
function moveStock(id,no,y,m,qty,prc){

	$( "#dialog" ).data('mid',''+id+','+no+','+y+','+m+','+qty+','+prc).dialog( "open" );
	var areaoptions = document.getElementById('NewArea').options.length;
	var areas = [];
	for (var i = 0; i < areaoptions; i++) {
		if (document.getElementById('NewArea').options[i].value==id) {
			document.getElementById('NewArea').remove(i);
		}
	}
}
function blurselect(id) {//取得產品資訊
	$.ajax({
		url: "class/searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#STK_NO"+id).val() },
		success: function(data) {
			var arr = data.split("||");
			$('#STK_NO'+id).val(arr[0]);
			$('#STK_NAME'+id).val(arr[1]);
			$('#STOCK_INFO'+id).val(arr[6]);
			stockINFO(id);
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
	