<script>
function oblurselect(id) {
	
	$.ajax({
		url: "class/searchSTK2a.php",
		type: "POST",
		data: {"STK_SELECT": $("#oldSTK_NO"+id).val()},
		success: function(data) {
			var arr = data.split("||");
			$('#oldSTK_NO'+id).val(arr[0]);
			$('#oldSTK_NAME'+id).val(arr[1]);
			$('#oldSTK_SPK'+id).val(arr[2]);
			$('#oldSTK_MODEL'+id).val(arr[3]);
			$('#oldSTK_UNIT'+id).val(arr[4]);
			$('#oldSTK_NO_txt'+id).val(arr[0]);
			$('#oldOUT_PRC'+id).val(((arr[7]*100)/100).toFixed(2));
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


function oS_AMT(id) { //計算金額 Quantity*單價amount($) quantity*unit price
	var pt = 0;
	var QTY = parseFloat($('#olddQTY'+id).val());
	var PRC = parseFloat($('#oldOUT_PRC'+id).val());
	var fCount = $("#oldCount1").val();
	var QTYabs = Math.abs(QTY);
	if(QTYabs >= 0 && PRC >= 0){
	  pt=(QTY*PRC).toFixed(2);	
	  $("#oldT_PRC"+id).val(round(pt,0));
    }
	
	$("#oldT_PRC").val(round(pt,0)); //單項金額individual item price
	
	  //全部金額total amount($)
	  var AMT=0;	  
	  for (i = 1; i <= fCount; i++){					  	
	  	if($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
		  p = parseFloat($("#oldT_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}		  
	  }
	  $("#T_PRC").val(round(AMT,0));
//test(round(AMT,0));
	oS_NET(round(AMT,0));
}

function oS_AMT1() { //移除金額 Quantity*單價remove amount($) quantity * unit price
	var fCount = parseFloat($('#oldCount').val()-1);
	var dCount = parseFloat($('#oldCount1').val());
	$('#oldCount').val(fCount) 
	
	  //全部金額total amount($)
	  AMT=0;
	  for (i = 1; i <= dCount; i++){					  
	  	if ($("#oldT_PRC"+i).val()!='' && $("#oldT_PRC"+i).val()!=null){
		  p = parseFloat($("#oldT_PRC"+i).val());
		  AMT=AMT+p;		
		}
	  }
	  //for add
	  for (i = 1; i <= dCount; i++){					  	
	  	if($("#T_PRC"+i).val()!='' && $("#T_PRC"+i).val()!=null){	
		  p = parseFloat($("#T_PRC"+i).val());		  		  
		  AMT=AMT+p;		
		}
	  }
	  
	  $("#T_PRC").val(round(AMT,0));
	
	oS_NET(round(AMT,0));
}
function test(aa){
	var AMT = parseFloat(aa);
	alert($('#log2').val());
	var DS = $('#log2').val();
//	if(DS != 0){
//		pt=((AMT*DS)/100).toFixed(2);
//	}else{
//		pt= (AMT).toFixed(2);
//	}
//	$('#STK_NET').val(round(pt,0));
//	//S_TAX(round(pt,0),$('#btn_Tax_1').val());
//	S_TAX(round(pt,0));
	
}
function oS_NET(t) { //計算淨額 Amount of fee*折扣calcultae net amount($) amount($)*discount

	var AMT = parseFloat(t);
	var DS = $('#log2').val();
	//var DS = 0;
	if(DS != 0){
		var pt=((AMT*DS)/100).toFixed(2);
	}else{
		var pt= (AMT).toFixed(2);
	}
	$('#STK_NET').val(round(pt,0));
	//S_TAX(round(pt,0),$('#btn_Tax_1').val());
	oS_TAX(round(pt,0));
}

function oS_TAX(t,bt) { //計算稅額 折扣後價格*稅額caculate tax amount amount after discount*tax rate(amount)
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

function S_TOT(net,t) { //計算總額 淨額+稅額 calculate total amount($) net amount + tax amount
	var NET = parseFloat(net);
	var TAX = parseFloat(t);
	if(NET > 0 ){
		pt= NET+TAX;
	}else{
		pt= NET+TAX;
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
	$("#oldRemoved"+id).val("1");	
	if($('#oldCount').val()==0 && $('#fileCount').val()==0){
		$("#submit").hide();
	}  
}

</script>
<?php 
$db = new DB;
$db1 = new DB; 
if($pID!=""){ $strS = " AND a.`PS_NO` =  '".mysql_escape_string($tmpID)."' ";}
if($areaID!=""){ $strS = " AND a.`PS_NAME` = 'Area".$tmpID."' ";}
$strP = "SELECT a.`ORD_DATE`, a.`ORD_SEQ` , a.`ORD_SEQ1` , b.`STK_NO` , a.`STK_NAME` , a.`ORD_QTY` , a.`STK_UNIT` , c.`OUT_PRC`, c.`LAY_NO`, c.`SAFE_QTY` ";
$strP .="FROM `arkord` a INNER JOIN  `arkstockforapply` b ON a.`STK_NO` = b.`applyitemID` INNER JOIN  `arkstock` c ON b.`STK_NO` = c.`STK_NO`";
$strP .=" WHERE 1=1 AND a.`ORD_QTY` > a.`OUT_QTY` ".$strS." ";
$strP .="ORDER BY b.`STK_NO`";
//echo $strP."<br>";
$db->query($strP);
//$db->query("SELECT *, b.STK_NAME, b.STK_UNIT, c.Title FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO left join `stockinfo` c on a.StockID=c.stockinfoID WHERE a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' and STK_DATE='".$STKDATE."' order by a.infoOrd");

//列出原有檔案區塊print original file block
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
  $tmpNO = "";
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
				
		if($tmpNO == ""){
			$tmpNO = $r['STK_NO'];
			$tmpName = $r['STK_NAME'];
			$tmpUNIT = $r['STK_UNIT'];
			$tmpLAYNO = $r['LAY_NO'];
			$infoOrd =1	;
			$SAFE_QTY = $r['SAFE_QTY'];
			$arrDateFunction = chkDate($STKDATE);	  
			$strSQL = "SELECT ((`BE_STK` + `IN_STK` - `OUT_STK`) + `ADJ_STK`) AS `QTY` FROM  `stockform` ";
			$strSQL .= " WHERE `StockID` =  '".$tmpLAYNO."' AND `STK_NO` = '".$tmpNO."'";
			$strSQL .= " AND `STK_YEAR` = '".$arrDateFunction['year']."' AND `STK_MONTH` = '".$arrDateFunction['month']."'";
			$db1->query($strSQL);
			$tmp = $db1->fetch_assoc();
			  if($SAFE_QTY >= $tmp['QTY']){
				  $str = 'style="background:#F00; color:#FFF;"';
				  $str .= 'title="'.$tmpNO.'[低於安全庫存量] 目前庫存量為:'.$tmp['QTY'];
			  }else{
				  $str = 'style="background:#FFF; color:#21689F;"';
				  $str .= 'title="'.$tmpNO.'目前庫存量為:'.$tmp['QTY'].'"';	  
			  }
		}
		
		if( $tmpNO != $r['STK_NO']){
		
?>      	  
		<input type="hidden" name="oldORD_NO<?php echo $infoOrd; ?>" value="<?php echo $tmpORD_NO; ?>">
		<input type="hidden" name="oldinfoOrd" value="<?php echo $infoOrd; ?>">	
          <tr id="DelTR<?php echo $infoOrd;?>">
          	<td width="80"><input class="validate[custom[integer],required]" type="text" size="8" id="oldSTK_NO<?php echo $infoOrd;?>" name="oldSTK_NO<?php echo $infoOrd;?>" onblur="oblurselect('<?php echo $infoOrd;?>');"  value="<?php echo $tmpNO; ?>" /></td>
          	<td width="200"><input type="text" size="30" id="oldSTK_NAME<?php echo $infoOrd; ?>" name="oldSTK_NAME<?php echo $infoOrd; ?>" value="<?php echo $tmpName ; ?>" readonly title="<?php echo "申請單號:".$tmpORD_NO;?>" /></td>
          	<td width="50"><input class="validate[custom[<?php echo $num;?>],min[0],required]" type="text" size="3" id="olddQTY<?php echo $infoOrd;?>" name="olddQTY<?php echo $infoOrd;?>" onblur="oS_AMT('<?php echo $infoOrd;?>');" value="<?php echo $tmpORD_QTY; ?>" <?php echo $str; ?> /></td>
            <td width="50"><input type="text" size="3" id="oldSTK_UNIT<?php echo $infoOrd;?>" name="oldSTK_UNIT<?php echo $infoOrd;?>" value="<?php echo $tmpUNIT; ?>" disabled="disabled" /></td>
            <td width="80"><input type="text" size="6" id="oldOUT_PRC<?php echo $infoOrd;?>" name="oldOUT_PRC<?php echo $infoOrd;?>" value="<?php echo $OPRC; ?>" readonly /></td>
            <td width="80"><input type="text" size="6" id="oldT_PRC<?php echo $infoOrd;?>" name="oldT_PRC<?php echo $infoOrd;?>"  value="<?php echo $tmpTPRC; ?>" readonly /></td>
            <td width="200">
            	<input class="validate[required]" type="text" size="5" id="oldSTOCK_INFO<?php echo $infoOrd;?>" name="oldSTOCK_INFO<?php echo $infoOrd;?>" onblur="stock_old_INFO('<?php echo $infoOrd;?>');this.value = this.value.toUpperCase();" value="<?php echo $tmpLAYNO; ?>" />
            	<button onclick="window.open('class/consump.php?query=2&c=<?php echo $infoOrd;?>&t=old', '_blank', 'width=300, height=200'); return false;" >...</button>
                <input class="validate[required]" type="text" size="8" value="<?php echo getStockName($tmpLAYNO);?>" id="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" name="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" readonly="readonly"/>
          </td>
          	<td width="*"><input type="button" value="Select product" onclick="window.open('class/searchSTK3.php?query=<?php echo $infoOrd;?>&t=old', '_blank', 'width=960, height=150'); return false;"> &nbsp;<input type="button" value="Remove" onclick="isDEL('<?php echo $infoOrd;?>');" /></td>
          </tr>
        <input type="hidden" value="0" id="oldRemoved<?php echo $infoOrd; ?>">
<?php 	
			$tmpORD_QTY = 0;
			$OPRC = intval($r['OUT_PRC']*100)/100;
			$tmpTPRC =0;
			$tmpORD_NO = "";	
			$tmpNO = $r['STK_NO'];
			$tmpName = $r['STK_NAME'];
			$tmpUNIT = $r['STK_UNIT'];
			$tmpLAYNO = $r['LAY_NO'];
			$SAFE_QTY = $r['SAFE_QTY'];
			$infoOrd ++	;
			$str="";
			
		 }
		if($tmpNO == $r['STK_NO']){
			$tmpORD_QTY += $r['ORD_QTY'];
			$OPRC = intval($r['OUT_PRC']*100)/100;
			$tmpTPRC = $tmpORD_QTY * $OPRC;			
			if ($tmpORD_NO!="") { $tmpORD_NO .= ';'; }
			$tmpORD_NO .= $r['ORD_SEQ']."-".$r['ORD_SEQ1'];
			
			$SAFE_QTY = $r['SAFE_QTY'];
			$arrDateFunction = chkDate($STKDATE);	  
			$strSQL = "SELECT ((`BE_STK` + `IN_STK` - `OUT_STK`) + `ADJ_STK`) AS `QTY` FROM  `stockform` ";
			$strSQL .= " WHERE `StockID` =  '".$r['LAY_NO']."' AND `STK_NO` = '".$r['STK_NO']."'";
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
		}
  
   }?>
   <!--,max[<?php //echo getStockQTY($tmpLAYNO,$tmpNO,date("Y"),date("m"));?>]-->
		<input type="hidden" name="oldORD_NO<?php echo $infoOrd; ?>" value="<?php echo $tmpORD_NO; ?>">
   		<input type="hidden" name="oldinfoOrd" value="<?php echo $infoOrd; ?>">  
          <tr id="DelTR<?php echo $infoOrd;?>">
          	<td width="80"><input class="validate[custom[integer],required]" type="text" size="8" id="oldSTK_NO<?php echo $infoOrd;?>" name="oldSTK_NO<?php echo $infoOrd;?>" onblur="oblurselect('<?php echo $infoOrd;?>');"  value="<?php echo $tmpNO; ?>" /></td>
          	<td width="200"><input type="text" size="30" id="oldSTK_NAME<?php echo $infoOrd; ?>" name="oldSTK_NAME<?php echo $infoOrd; ?>" value="<?php echo $tmpName ; ?>" readonly title="<?php echo "申請單號:".$tmpORD_NO;?>" /></td>
          	<td width="50"><input class="validate[custom[<?php echo $num;?>],min[0],required]" type="text" size="3" id="olddQTY<?php echo $infoOrd;?>" name="olddQTY<?php echo $infoOrd;?>" onblur="oS_AMT('<?php echo $infoOrd;?>');" value="<?php echo $tmpORD_QTY; ?>" <?php echo $str; ?> /></td>
            <td width="50"><input type="text" size="3" id="oldSTK_UNIT<?php echo $infoOrd;?>" name="oldSTK_UNIT<?php echo $infoOrd;?>" value="<?php echo $tmpUNIT; ?>" disabled="disabled" /></td>
            <td width="80"><input type="text" size="6" id="oldOUT_PRC<?php echo $infoOrd;?>" name="oldOUT_PRC<?php echo $infoOrd;?>" value="<?php echo $OPRC; ?>" readonly /></td>
            <td width="80"><input type="text" size="6" id="oldT_PRC<?php echo $infoOrd;?>" name="oldT_PRC<?php echo $infoOrd;?>"  value="<?php echo $tmpTPRC; ?>" readonly /></td>
            <td width="200">
            	<input class="validate[required]" type="text" size="5" id="oldSTOCK_INFO<?php echo $infoOrd;?>" name="oldSTOCK_INFO<?php echo $infoOrd;?>" onblur="stock_old_INFO('<?php echo $infoOrd;?>');this.value = this.value.toUpperCase();" value="<?php echo $tmpLAYNO; ?>" />
            	<button onclick="window.open('class/consump.php?query=2&c=<?php echo $infoOrd;?>&t=old', '_blank', 'width=300, height=200'); return false;" >...</button>
                <input class="validate[required]" type="text" size="8" value="<?php echo getStockName($tmpLAYNO);?>" id="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" name="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" readonly/>
          </td>
          	<td width="*"><input type="button" value="Select product" onclick="window.open('class/searchSTK3.php?query=<?php echo $infoOrd;?>&t=old', '_blank', 'width=960, height=150'); return false;"> &nbsp;<input type="button" value="Remove" onclick="isDEL('<?php echo $infoOrd;?>');" /></td>
          </tr>
        <input type="hidden" value="0" id="oldRemoved<?php echo $infoOrd; ?>">	
      </table>
    </td>
  </tr>
  </TBODY>
</TABLE>
<?php 
}?>
  <input type="hidden" value="<?php echo $infoOrd ?>" id="oldCount1" name="oldCount1">
  <input type="hidden" value="<?php echo $infoOrd ?>" id="oldCount" name="oldCount">  
