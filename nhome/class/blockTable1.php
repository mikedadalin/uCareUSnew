<script>

function oS_AMT(id) { //計算金額 Quantity*Unit price calculate amount($) = quantity * unit price
	var QTY = parseFloat($('#olddQTY'+id).val());
	var PRC = parseFloat($('#oldIN_PRC'+id).val());
	var fCount = $("#oldCount1").val();
	var QTYabs = Math.abs(QTY);
	if(QTYabs >= 0 && PRC >= 0){
	  pt=(QTY*PRC).toFixed(2);	
	  $("#oldT_PRC"+id).val(round(pt,0));
    }
	
	$("#oldT_PRC").val(round(pt,0)); //單項金額individaul item price
	
	  //全部金額 total amount
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

function oS_AMT1() { //移除金額 Quantity*單價remove amount = quantity* unit price
	var fCount = parseFloat($('#oldCount').val()-1);
	var dCount = parseFloat($('#oldCount1').val());
	$('#oldCount').val(fCount) 
	
	  //全部金額total amount($)
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

function S_NET(t) { //計算淨額 Amount of fee*折扣 calculate net amount($) amount*discount
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

function S_TAX(t,bt) { //計算稅額 折扣後價格*稅額calculate tax amount = amount($) after discount + tax amount
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

function S_TOT(net,t) { //計算總額 淨額+稅額
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
	oS_AMT1();
}

</script>
<?php 
$db = new DB;
$db1 = new DB;
$db2 = new DB;
$db->query("SELECT *, b.STK_NAME, b.STK_UNIT, c.Title FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO left join `stockinfo` c on a.StockID=c.stockinfoID WHERE a.type='".$type."' and a.`IsStatus`='N' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' order by a.infoOrd");

//列出原有檔案區塊original file block lists
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
	  $tmp = $db->num_rows();


		//取該產品退貨總數aquire product return quantity
		$db1->query("SELECT sum(b.QTY) OC_QTY FROM `".$strModule."` a inner join `".$subModule."` b on a.firmStockID=b.firmStockID and a.type=b.type WHERE a.type='OC' and a.`IsStatus`='N' and a.IN_firmStockID='".$IN."' and b.STK_NO=".$r['STK_NO']."");


		if ($db1->num_rows()>0) {			
		$rs = $db1->fetch_assoc();
			if($_GET['id']=='8a'){
				$OC = $r['QTY'] - $rs['OC_QTY'];
				if($rs['OC_QTY']==NULL){$xQTY = "0";}else{$xQTY = $rs['OC_QTY'];};
			}else{
				$OC = $r['QTY'];
				$xQTY = $rs['OC_QTY'];
			}
		}
		if( $r['QTY'] - $xQTY > 0){
				
?> 
		<input type="hidden" name="Ord<?php echo $infoOrd; ?>" id="Ord<?php echo $infoOrd; ?>" value="<?php echo $infoOrd; ?>">         
        <input type="hidden" value="<?php echo $r['QTY'];?>" id="maxCount<?php echo $infoOrd;?>" name="maxCount<?php echo $infoOrd;?>" />
        <input type="hidden" value="<?php echo $xQTY;?>" id="xCount<?php echo $infoOrd;?>" name="xCount<?php echo $infoOrd;?>" />
          <tr id="DelTR<?php echo $infoOrd;?>">
          	<td width="80"><input type="text" size="8" id="oldSTK_NO<?php echo $infoOrd;?>" name="oldSTK_NO<?php echo $infoOrd;?>" value="<?php echo $r['STK_NO']; ?>"  readonly="readonly"/></td>
          	<td width="200"><input type="text" size="30" id="oldSTK_NAME<?php echo $infoOrd; ?>" name="oldSTK_NAME<?php echo $infoOrd; ?>" value="<?php echo $r['STK_NAME']; ?>" readonly="readonly" /></td>
          	<td width="50"><input type="text" size="3" id="olddQTY<?php echo $infoOrd;?>" name="olddQTY<?php echo $infoOrd;?>" onblur="oS_AMT(<?php echo $infoOrd;?>);" value="<?php echo $OC;?>" /></td>
            <td width="50"><input type="text" size="3" id="oldSTK_UNIT<?php echo $infoOrd;?>" name="oldSTK_UNIT<?php echo $infoOrd;?>" value="<?php echo $r['STK_UNIT']; ?>" disabled="disabled" /></td>
            <td width="80"><input type="text" size="6" id="oldIN_PRC<?php echo $infoOrd;?>" name="oldIN_PRC<?php echo $infoOrd;?>" onblur="oS_AMT(<?php echo $infoOrd;?>);"  value="<?php echo $r['Price']; ?>" /></td>
            <td width="80"><input type="text" size="6" id="oldT_PRC<?php echo $infoOrd;?>" name="oldT_PRC<?php echo $infoOrd;?>"  value="<?php echo $r['QTY']* $r['Price']; ?>" readonly="readonly" /></td>
            <td width="200">
            	<input type="text" size="5" id="oldSTOCK_INFO<?php echo $infoOrd;?>" name="oldSTOCK_INFO<?php echo $infoOrd;?>" readonly="readonly" value="<?php echo $r['StockID']; ?>" />            	
                <input type="text" size="8" value="<?php echo $Title;?>" id="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" name="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" readonly="readonly"/>
          </td>
          	<td width="*"><input type="button" value="Remove" onclick="isDEL(<?php echo $infoOrd;?>);" /></td>
          </tr>
          
<?php
		}
  }?>
      </table>
    </td>
  </tr>
        <input type="hidden" value="<?php echo $tmp ?>" id="oldCount1" name="oldCount1">
        <input type="hidden" value="<?php echo $tmp ?>" id="oldCount" name="oldCount">  
  </TBODY>
</TABLE>
<?php 
}?>
