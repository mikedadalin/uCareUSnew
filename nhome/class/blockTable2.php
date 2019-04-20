<script>
function oblurselect(id) {
	
	$.ajax({
		url: "class/searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#oldSTK_NO"+id).val() },
		success: function(data) {
			var arr = data.split("||");
			$('#oldSTK_NO'+id).val(arr[0]);
			$('#oldSTK_NAME'+id).val(arr[1]);
			$('#oldSTK_SPK'+id).val(arr[2]);
			$('#oldSTK_MODEL'+id).val(arr[3]);
			$('#oldSTK_UNIT'+id).val(arr[4]);
			$('#oldSTK_NO_txt'+id).val(arr[0]);
			//$('#oldIN_PRC'+id).val(arr[5]);
			$('#oldSTOCK_INFO'+id).val(arr[6]);
			$('#oldIN_PRC'+id).val(((arr[7]*100)/100).toFixed(2));
			stock_old_INFO(id);
		}
	});
}

function stock_old_INFO(id) {
  $.ajax({
	  url: "class/stockInfo.php",
	  type: "POST",
	  data: { "PID": $("#oldSTOCK_INFO"+id).val()},
	  success: function(data) {
		  var STOCK_INFO_NAME = document.getElementById('oldSTOCK_INFO_NAME'+id);
		  $('#oldSTOCK_INFO_NAME'+id).val(data);	
	  }
  });
}	


function oS_AMT(id) { //計算金額 Quantity*Unit price calculate amount = quantity*unit price
	var QTY = parseFloat($('#olddQTY'+id).val());
	var PRC = parseFloat($('#oldIN_PRC'+id).val());
	var fCount = $("#oldCount1").val(); //block
	var fileCount1 = $("#fileCount1").val(); //addtable
	var QTYabs = Math.abs(QTY);
	if(QTYabs >= 0 && PRC >= 0){
	  pt=(QTY*PRC).toFixed(2);	
	  $("#oldT_PRC"+id).val(round(pt,0));
    }
	
	$("#oldT_PRC").val(round(pt,0)); //單項金額unit price
	
	  //全部金額total amount($)
	  var AMT=0;	  
	  for (i = 1; i <= fCount; i++){					  	
	  	if($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
		  p = parseFloat($("#oldT_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}		  
	  }
	  //add table
	  if (fileCount1!="") {
		  for (i = 1; i <= fileCount1; i++){					  	
			if($("#T_PRC"+i).val()!='' && $("#T_PRC"+i).val()!=null){
			  p = parseFloat($("#T_PRC"+i).val());		  		  
			  AMT=AMT+p;		
			}		  
		  }
	  }
	  $("#T_PRC").val(round(AMT,0));
	  
	S_NET(round(AMT,0));
}

function oS_AMT1() { //移除金額 Quantity*單價remove amount($) = quantity*unit price
	var fCount = parseFloat($('#oldCount').val()-1);
	var dCount = parseFloat($('#oldCount1').val());
	$('#oldCount').val(fCount) 
	
	  //全部金額 total amount($)
	  AMT=0;
	  for (i = 1; i <= dCount; i++){				
	  	if($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
		  //alert("2-" + $("#T_PRC"+i).val());	
		  p = parseFloat($("#oldT_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}
	  }
	  $("#T_PRC").val(round(AMT,0));
	  //add table
	  if ($('#fileCount1').val()!='') {
		  for (i = 1; i <= $('#fileCount1').val(); i++){				
			if($("#T_PRC"+i).val()!='' && $("#T_PRC"+i).val()!=null){
			  p = parseFloat($("#T_PRC"+i).val());		  		  
			  AMT=AMT+p;		
			}
		  }
	  }
	  
	S_NET(round(AMT,0));
}

function S_NET(t) { //計算淨額 Amount of fee*折扣calculate net amount($) = amount($)*discount
	var AMT = parseFloat(t);
	var DS = $('#log2').val()
	if(DS != 0){
		pt=((AMT*DS)/100).toFixed(2);
	}else{
		pt= (AMT).toFixed(2);
	}
	$('#STK_NET').val(round(pt,0));
	//S_TAX(round(pt,0),$('#btn_Tax_1').val());
	S_TAX(round(pt,0));
}

function S_TAX(t,bt) { //計算稅額 折扣後價格*稅額calculate tax amount($) = amount($) after discount*tax rate(amount)
	var NET = parseFloat(t);
	var TAX = $('#Tax_1').val()
	if(TAX == 1){
		if(NET > 0){
			pt=((NET*5)/100).toFixed(2);
		}else{
			pt=0;
		}
	}else{
		pt= 0;
	}
	$('#STK_TAX').val(round(pt,0));
	S_TOT(NET,pt);
}

function S_TOT(net,t) { //計算總額 淨額+稅額calculate total amount($) = net amount($) + tax amount($)
	var NET = parseFloat(net);
	var TAX = parseFloat(t);
	if(NET > 0 ){
		pt= NET+TAX;
	}else{
		pt=0;
	}
	
	$('#STK_TOT').val(round(pt,0));
}

function round(num, pos)
{
  return (Math.round( num * Math.pow(10,pos) ) / Math.pow(10,pos)).toFixed(pos);
}

function isDEL(id){
	$("#DelTR"+id).remove();
	$("#oldRemoved"+id).val("1");
	oS_AMT1();
	if(($('#fileCount').val() == 0) && ($('#oldCount').val() ==0)){		
		$("#submit").hide();		
	}	
	
}
</script>
<?php 
$db = new DB;
$db1 = new DB;
$db->query("SELECT *, b.STK_NAME, b.STK_UNIT, c.Title, b.LAY_NO, a.STK_NO,a.STK_DATE FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO left join `stockinfo` c on a.StockID=c.stockinfoID WHERE a.`IsStatus` <> 'D' AND a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' and STK_DATE='".$STKDATE."' order by a.infoOrd");
//列出原有檔案區塊
if ($db->num_rows()>0) {
	
	//數量判斷開放使用小數點
		$num = "integer";
	
?>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <table border="0" class="a1" width="100%">
      	<tbody>
          <tr>
            <th class="title" width="80">Product serial number</th>
            <th class="title" width="200">product name</th>
            <th class="title" width="50">Quantity</th>
            <th class="title" width="50">Unit</th>
            <th class="title" width="80">Unit price</th>
            <th class="title" width="80">Amount</th>
            <th class="title" width="200">Storage</th>
            <th class="title" width="*">Function</th>
          </tr>
<?php 
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
	    $arrDateFunction = chkDate($r['STK_DATE']);	  
		$strSQL = "SELECT ((`BE_STK` + `IN_STK` - `OUT_STK`) + `ADJ_STK`) AS `QTY` FROM  `stockform` ";
		$strSQL .= " WHERE `StockID` =  '".$StockID."' AND `STK_NO` = '".$r['STK_NO']."'";
		$strSQL .= " AND `STK_YEAR` = '".$arrDateFunction['year']."' AND `STK_MONTH` = '".$arrDateFunction['month']."'";
		$db1->query($strSQL);	
        $tmp = $db1->fetch_assoc();
		  if($r['SAFE_QTY'] >= $tmp['QTY']){
			  $str = 'style="background:#F00; color:#FFF;"';
			  $str .= 'title="'.$r['STK_NO'].'[低於安全庫存量] 目前庫存量為:'.$tmp['QTY'].'"';
		  }else{
			  $str = 'style="background:#FFF; color:#21689F;"';
			  $str .= 'title="'.$r['STK_NO'].'目前庫存量為:'.$tmp['QTY'].'"';	  
		  }
?>        
		<input type="hidden" name="oldinfoOrd" value="<?php echo $infoOrd; ?>">  
        
          <tr id="DelTR<?php echo $infoOrd;?>">
          	<td width="80"><input class="validate[custom[integer],required]" type="text" size="8" id="oldSTK_NO<?php echo $infoOrd;?>" name="oldSTK_NO<?php echo $infoOrd;?>" onblur="oblurselect(<?php echo $infoOrd;?>);"  value="<?php echo $r['STK_NO']; ?>" /></td>
          	<td width="200"><input type="text" size="30" id="oldSTK_NAME<?php echo $infoOrd; ?>" name="oldSTK_NAME<?php echo $infoOrd; ?>" value="<?php echo $r['STK_NAME']; ?>" readonly /></td>
          	<td width="50"><input class="validate[custom[<?php echo $num;?>],min[0],max[<?php echo '9999'; //echo getStockQTY($r['LAY_NO'],$r['STK_NO'],date("Y"),date("m")); ?>],required]" type="text" size="3" id="olddQTY<?php echo $infoOrd;?>" name="olddQTY<?php echo $infoOrd;?>" onblur="oS_AMT(<?php echo $infoOrd;?>);" value="<?php echo $r['QTY']; ?>" <?php echo $str; ?> /></td>
            <td width="50"><input type="text" size="3" id="oldSTK_UNIT<?php echo $infoOrd;?>" name="oldSTK_UNIT<?php echo $infoOrd;?>" value="<?php echo $r['STK_UNIT']; ?>" disabled="disabled" /></td>
            <td width="80"><input type="text" size="6" id="oldIN_PRC<?php echo $infoOrd;?>" name="oldIN_PRC<?php echo $infoOrd;?>" value="<?php echo $r['Price']; ?>" readonly="readonly" /></td>
            <td width="80"><input type="text" size="6" id="oldT_PRC<?php echo $infoOrd;?>" name="oldT_PRC<?php echo $infoOrd;?>"  value="<?php echo $r['QTY']* $r['Price']; ?>" readonly="readonly" /></td>
            <td width="200">
            	<input class="validate[required]" type="text" size="5" id="oldSTOCK_INFO<?php echo $infoOrd;?>" name="oldSTOCK_INFO<?php echo $infoOrd;?>" onblur="stock_old_INFO(<?php echo $infoOrd;?>);this.value = this.value.toUpperCase();" value="<?php echo $r['StockID']; ?>" />
            	<button onclick="window.open('class/consump.php?query=2&c=<?php echo $infoOrd;?>&t=old', '_blank', 'width=300, height=200'); return false;" >...</button>
                <input class="validate[required]" type="text" size="8" value="<?php echo $Title;?>" id="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" name="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" readonly="readonly"/>
          </td>
          	<td width="*"><input type="button" value="Select product" onclick="window.open('class/searchSTK3.php?query=<?php echo $infoOrd;?>&t=old', '_blank', 'width=960, height=150'); return false;"> &nbsp;<input type="button" value="Remove" onclick="isDEL(<?php echo $infoOrd;?>);" /></td>
          </tr>
          <input type="hidden" value="0" id="oldRemoved<?php echo $infoOrd; ?>">
          <?php }?>
      </table>
    </td>
  </tr>
  </TBODY>
</TABLE>
<?php 
}?>
  <input type="hidden" value="<?php echo $tmp1; ?>" id="oldCount1" name="oldCount1">
  <input type="hidden" value="<?php echo $tmp1; ?>" id="oldCount" name="oldCount">  
