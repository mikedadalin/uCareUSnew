<script>
function isDEL(id){
	$("#DelTR"+id).remove();
	$("#removed"+id).val("1");
	$('#oldCount').val(parseFloat($('#oldCount').val()-1));
	if($('#oldCount').val()==0){
		$("#submit").hide();
	}  
}
</script>
<?php 
$db = new DB;
$db1 = new DB;
$db2 = new DB;
$db->query("SELECT *, b.STK_NAME, b.STK_UNIT, c.Title FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO left join `stockinfo` c on a.StockID=c.stockinfoID WHERE a.`IsStatus` <>'D' AND a.type='".$type."' and a.`".$strModule."ID`='".mysql_escape_string($firmstockID)."' and STK_DATE='".$STKDATE."' order by a.infoOrd");

//列出原有檔案區塊
if ($db->num_rows()>0) {
?>

<table align="left"  width="100%" style="font-size:10pt; margin-left:0px;">
  <TBODY>
  <tr>
    <td>
      <table border="0" class="a1" width="100%">
      	<tbody>
          <tr>
            <th class="title" width="80">product serial number</th>
            <th class="title" width="150">Product name</th>
            <th class="title" width="30">Quantity</th>
            <th class="title" width="30">Unit</th>
            <th class="title" width="250">Storehouse</th>
            <th class="title" width="150">Manufactured date</th>
            <th class="title" width="150">Expire date</th>
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
		
		//取產品進貨數
		$db2->query("SELECT sum(b.QTY) IC_QTY FROM `".$strModule."` a inner join `".$subModule."` b on a.firmStockID=b.firmStockID and a.type=b.type WHERE a.type='IC' and a.firmStockID='".substr($IN,-4)."' and b.STK_NO='".$r['STK_NO']."' and b.isStatus<>'D' ");
		if ($db2->num_rows()>0) {			
			$r2 = $db2->fetch_assoc();
			$IC = $r2['IC_QTY'];
		}
		

		//取該產品退貨總數
		$db1->query("SELECT sum(b.QTY) OC_QTY FROM `".$strModule."` a inner join `".$subModule."` b on a.firmStockID=b.firmStockID and a.type=b.type WHERE a.type='OC' and a.IN_firmStockID='".$IN."' and b.STK_NO='".$r['STK_NO']."' and b.isStatus<>'D' ");

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
          	<td width="30"><input type="text" size="3" id="olddQTY<?php echo $infoOrd;?>" name="olddQTY<?php echo $infoOrd;?>" onblur="oS_AMT(<?php echo $infoOrd;?>);" value="<?php echo $OC; ?>" readonly/></td>
            <td width="30"><input type="text" size="3" id="oldSTK_UNIT<?php echo $infoOrd;?>" name="oldSTK_UNIT<?php echo $infoOrd;?>" value="<?php echo $r['STK_UNIT']; ?>" disabled="disabled" /></td>
            <td width="250">
            	<input type="text" size="5" id="oldSTOCK_INFO<?php echo $infoOrd;?>" name="oldSTOCK_INFO<?php echo $infoOrd;?>" value="<?php echo $r['StockID']; ?>" readonly="readonly" />
                <input type="text" size="8" value="<?php echo $Title;?>" id="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" name="oldSTOCK_INFO_NAME<?php echo $infoOrd;?>" readonly="readonly"/>
          </td>
            <td width="150"><input type="text" size="8" id="oldcdate<?php echo $infoOrd;?>" name="oldcdate<?php echo $infoOrd;?>"  value="<?php echo $r['oldcdate']; ?>" /><script> $(function() { $( "#oldcdate<?php echo $infoOrd;?>").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></td>          
            <td width="150"><input type="text" size="8" id="oldeDate<?php echo $infoOrd;?>" name="oldeDate<?php echo $infoOrd;?>"  value="<?php echo $r['oldeDate']; ?>" /><script> $(function() { $( "#oldeDate<?php echo $infoOrd;?>").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></td>          
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
