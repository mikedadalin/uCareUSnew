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
			$('#oldIN_PRC'+id).val(arr[5]);
			$('#oldSTOCK_INFO'+id).val(arr[6]);
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


function oS_AMT(id) { //計算金額 Quantity*單價calculate amount = quantity*unit price
	var QTY = parseFloat($('#olddQTY'+id).val());
	var PRC = parseFloat($('#oldIN_PRC'+id).val());
	var fCount = $("#oldCount1").val();
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
	  $("#T_PRC").val(round(AMT,0));
	  
	S_NET(round(AMT,0));
}

function oS_AMT1() { //移除金額 Quantity*單價remove amount($) = quantity*unit price
	//var fCount = parseFloat($('#oldCount').val()-1);
	var dCount = parseFloat($('#oldCount1').val());
	//$('#oldCount').val(fCount) 
	
	  //全部金額
	  AMT=0;
	  for (i = 1; i <= dCount; i++){				
	  	if($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
		  //alert("2-" + $("#T_PRC"+i).val());	
		  p = parseFloat($("#oldT_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}
	  }
	  $("#T_PRC").val(round(AMT,0));

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
	$("#removed"+id).val("1");
	$('#oldCount').val(parseFloat($('#oldCount').val()-1));
	if($('#oldCount').val()==0){
		$("#submit").hide();
	}  
	
	oS_AMT1();
}
</script>
<?php 
$db = new DB;
$db1 = new DB;
$db2 = new DB;
$db->query("SELECT *, b.STK_NAME, b.STK_UNIT, c.Title FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO left join `stockinfo` c on a.StockID=c.stockinfoID WHERE a.`IsStatus` <>'D' AND a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' and STK_DATE='".$STKDATE."' order by a.infoOrd");

//列出原有檔案區塊list original file block
if ($db->num_rows()>0) {
?>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <table border="0" class="a1" width="100%">
      	<tbody>
          <tr>
            <th class="title" width="80">Product serial number</th>
            <th class="title" width="200">Product name</th>
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
		$tmp = $db->num_rows();
		
		//取產品進貨數aquire product perchage number
		$db2->query("SELECT sum(b.QTY) IC_QTY FROM `".$strModule."` a inner join `".$subModule."` b on a.firmStockID=b.firmStockID and a.type=b.type WHERE a.type='IC' and a.firmStockID='".substr($IN,-4)."' and b.STK_NO='".$r['STK_NO']."' ");
		if ($db2->num_rows()>0) {			
			$r2 = $db2->fetch_assoc();
			$IC = $r2['IC_QTY'];
		}
		

		//取該產品退貨總數aquire product return number
		$db1->query("SELECT sum(b.QTY) OC_QTY FROM `".$strModule."` a inner join `".$subModule."` b on a.firmStockID=b.firmStockID and a.type=b.type WHERE a.type='OC' and a.IN_firmStockID='".$IN."' and b.STK_NO='".$r['STK_NO']."'");

		if ($db1->num_rows()>0) {			
		$rs = $db1->fetch_assoc();
			if($_GET['id']=='8_1OC'){
				$OC = $r['QTY'] - $rs['OC_QTY'];
				${'OC_'.($i+1)} = $OC;
				if($rs['OC_QTY']==NULL){$xQTY = "0";}else{$xQTY = $rs['OC_QTY'];};
			}else{
				$OC = $r['QTY'];
				$xQTY = $rs['OC_QTY'];
			}
		}
		
?>        
		<input type="hidden" name="oldinfoOrd" value="<?php echo $infoOrd; ?>">  
        <input type="hidden" value="<?php echo $r['QTY'];?>" id="maxCount<?php echo $infoOrd;?>" name="maxCount<?php echo $infoOrd;?>" />
        <input type="hidden" value="<?php echo $xQTY;?>" id="xCount<?php echo $infoOrd;?>" name="xCount<?php echo $infoOrd;?>" />
        <input type="hidden" value="<?php echo $IC;?>" id="ICount<?php echo $infoOrd;?>" name="ICount<?php echo $infoOrd;?>" />
          <tr id="DelTR<?php echo $infoOrd;?>">
          	<td width="80"><input type="text" size="8" id="oldSTK_NO<?php echo $infoOrd;?>" name="oldSTK_NO<?php echo $infoOrd;?>" value="<?php echo $r['STK_NO']; ?>" readonly="readonly" /></td>
          	<td width="200"><input type="text" size="30" id="oldSTK_NAME<?php echo $infoOrd; ?>" name="oldSTK_NAME<?php echo $infoOrd; ?>" value="<?php echo $r['STK_NAME']; ?>" readonly="readonly" /></td>
          	<td width="50"><input type="text" size="3" id="olddQTY<?php echo $infoOrd;?>" name="olddQTY<?php echo $infoOrd;?>" onblur="oS_AMT(<?php echo $infoOrd;?>);" value="<?php echo $OC; ?>" /></td>
            <td width="50"><input type="text" size="3" id="oldSTK_UNIT<?php echo $infoOrd;?>" name="oldSTK_UNIT<?php echo $infoOrd;?>" value="<?php echo $r['STK_UNIT']; ?>" disabled="disabled" /></td>
            <td width="80"><input type="text" size="6" id="oldIN_PRC<?php echo $infoOrd;?>" name="oldIN_PRC<?php echo $infoOrd;?>"  value="<?php echo $r['Price']; ?>" readonly="readonly" /></td>
            <td width="80"><input type="text" size="6" id="oldT_PRC<?php echo $infoOrd;?>" name="oldT_PRC<?php echo $infoOrd;?>"  value="<?php echo $OC * $r['Price']; ?>" readonly="readonly" /></td>
            <td width="200">
            	<input type="text" size="5" id="oldSTOCK_INFO<?php echo $infoOrd;?>" name="oldSTOCK_INFO<?php echo $infoOrd;?>" value="<?php echo $r['StockID']; ?>" readonly="readonly" />
                <input type="text" size="8" value="<?php echo $Title;?>" id="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" name="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" readonly="readonly"/>
          </td>
          	<td width="*"> &nbsp;<input type="button" value="Remove" onclick="isDEL(<?php echo $infoOrd;?>);" /></td>
          </tr>
          <?php }?>
      </table>
    </td>
  </tr>
  </TBODY>
</TABLE>
<?php 
}?>
  <input type="hidden" value="<?php echo $tmp ?>" id="oldCount1" name="oldCount1">
  <input type="hidden" value="<?php echo $tmp ?>" id="oldCount" name="oldCount">
  
<?php
for ($i1=1;$i1<=$tmp;$i1++) {
	$i2 = 0;
	$removed = 0;
	if (${'OC_'.$i1}==0) {		
		if($_GET['id']=='8_1OC'){
			$i2 +=1;
			$removed = 1;
			?>
			<script>
				$("#DelTR"+<?php echo $i1;?>).remove();
				$('#oldCount').val(parseFloat($('#oldCount').val()-<?php echo $i2;?>));				
            </script>	

            <?php
		}
	}
	
?>
<input type="hidden" value="<?php echo $removed; ?>" id="removed<?php echo $i1; ?>">
<?php
}
?>
<script>oS_AMT1();</script>
