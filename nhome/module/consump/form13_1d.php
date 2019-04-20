<h3>Vendors reconciliation list</h3>
<?php 
if($_GET['dis']==""){$dis =1;}else{$dis=$_GET['dis'];}
if($_GET['FirmDiv'] <> ""){
	$fid = str_pad($_GET['FirmDiv'],4,'0',STR_PAD_LEFT);
}
?>
<div class="content-query">
<table  class="noborder" width="97%">
  <tr>
    <td bgcolor="#FFFFFF">Print time:<?php echo date('Y-m-d H:i:s'); ?></td>
    <td bgcolor="#FFFFFF" align="right" width="520"> <span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select the purchase date range:</span> Since &nbsp;<script> $(function() { $( "#3printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="3printdate1" id="3printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#3printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="3printdate2" id="3printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12">Ends</td>
  </tr>
  <tr>
  	<td bgcolor="#FFFFFF">Vendor: <input name="FirmDiv" type="text" id="FirmDiv" onblur="newORD();" size="5" value="<?php if ($fid=="") { echo ""; } else { echo $fid; } ?>"/>
    <button onclick="window.open('class/consump.php?query=1', '_blank', 'width=450, height=200, scrollbars=yes'); return false;" >...</button>
    <span id="log0"><?php if ($fid=="") { echo ""; } else { echo getFirmName($fid); } ?></span>
    </td>
    <td align="right"  bgcolor="#FFFFFF" ><?php echo draw_option("dis","Purchase;With return","m","single",$dis,false,2); ?><input type="button" value="Search" onclick="datefunction('view','3');" /><input type="button" value="Print" onclick="datefunction('print','3');" /></td>
  </tr> 
</table>
</div>
<table width="97%">
<?php
echo '
  <tr class="title">
    <td width="10%">Purchase bill #</td>
    <td width="10%">Purchase date</td>
	<td width="10%" >Tax category</td>	
	<td width="10%" >Invoice/reciept No.</td>	
	<td width="10%" colspan="4">Comment</td>	
  </tr>'."\n".'
  <tr class="title">
    <td width="10%"></td>
    <td width="10%">product serial number</td>
	<td width="*">Product name</td>
	<td width="10%" >Unit</td>
	<td width="10%" >Storehouse name</td>	
	<td width="10%" >Purchase unit price</td>	
	<td width="10%" >Purchase quantity</td>	
	<td width="10%" >Purchase payment amount</td>		
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `".$strModule."` a inner join `firm` b on a.firmID=b.firmID ";
$str0 .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
if($fid<>""){
	$str0 .=" and a.firmID='".$fid."'";
}

$db0->query($str0);
if($db0->num_rows() > 0){
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	$IN = $type.$r0['ordDate'].$r0['firmStockID'];
echo '
  <tr>
    <td align="center">'.$r0['type'].$r0['ordDate'].$r0['firmStockID'].'</td>
    <td align="center">'.$r0['STK_Date'].'</td>
	<td align="center">'.($r0['Tax_1']==1 ? "Taxable" : "Exemption").'</td>	
	<td align="center">'.$r0['ReceiptNO'].'</td>	
	<td colspan="4">'.$r0['Fmark'].'</td>
  </tr>'."\n".'
  <tr><td colspan="8"><table width="100%" class="noborder">';
  	$db0_1 = new DB;
	$str1 = "SELECT * FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO WHERE `type`='".$r0['type']."' and `firmStockID` = '".$r0['firmStockID']."' and `STK_Date`='".$r0['STK_Date']."'";
	$db0_1->query($str1);
	  if($db0_1->num_rows() > 0){
	    for ($i1=0;$i1<$db0_1->num_rows();$i1++) {
	    $r0_1 = $db0_1->fetch_assoc();
		//
		if($dis==2){
			
			$db0_2 = new DB;
			$str2 = "SELECT * FROM  `firmstock` a INNER JOIN  `firmstockinfo` b ON a.firmStockID = b.firmStockID ";
			$str2 .=" AND a.type = b.type AND a.STK_DATE = b.STK_DATE WHERE a.type = 'OC' AND a.`IsStatus` <> 'D'";
			$str2 .="AND a.IN_firmStockID = '".$IN."' and b.STK_NO='".$r0_1['STK_NO']."'";					
			$db0_2->query($str2);
			
			if($db0_2->num_rows() > 0){				
				$r0_2 = $db0_2->fetch_assoc();
				$disQTY = $r0_1['QTY']-$r0_2['QTY'];
				$disPrice = $r0_2['Price'];				
			}else{
				$disQTY = $r0_1['QTY'];
				$disPrice = $r0_1['Price'];		
			}	
			
			$db0_3 = new DB;
			$str3 = "SELECT SUM(  `STK_NET` ) NET, SUM(  `STK_TAX` ) TAX, SUM(  `STK_TOT` ) TOT";
			$str3 .= " FROM  `firmstock` a";
			$str3 .= " INNER JOIN  `firmstockinfo` b ON a.firmStockID = b.firmStockID";
			$str3 .= " AND a.type = b.type";
			$str3 .= " AND a.STK_DATE = b.STK_DATE";
			$str3 .= " WHERE a.type =  'OC' ";
			$str3 .= " AND a.`IsStatus` <>  'D'";
			$str3 .= " AND a.IN_firmStockID =  '".$IN."' ";			
			$db0_3->query($str3);
			if($db0_3->num_rows() > 0){
				$r0_3 = $db0_3->fetch_assoc();
			}
			
			//$d2 = ($disQTY*$disPrice)*$r0['Discount']/100;
			
			$NET = $r0['STK_NET']-$r0_3['NET'];
			$TAX = $r0['STK_TAX']-$r0_3['TAX'];
			$TOT = $r0['STK_TOT']-$r0_3['TOT'];
			//echo $i."@@".$r0['STK_NET'].'-'.$r0_3['STK_NET']."<br>";
		}else{
			$disQTY = $r0_1['QTY'];
			$disPrice = $r0_1['Price'];				
			$NET = $r0['STK_NET'];
			$TAX = $r0['STK_TAX'];
			$TOT = $r0['STK_TOT'];
		}	
		//
		echo '
		<tr>
		  <td width="80">&nbsp;</td>
		  <td width="100" align="center">'.$r0_1['STK_NO'].'</td>
		  <td width="*" align="left">'.$r0_1['STK_NAME'].'</td>
		  <td width="90" align="center">'.$r0_1['STK_UNIT'].'</td>		  
		  <td width="90" align="center">'.getStockName($r0_1['StockID']).'</td>		  		  
		  <td width="110" align="right">$ '.$disPrice.'</td>		  		  		  
		  <td width="110" align="right">'.$disQTY.'</td>		  		  
		  <td width="110" align="right">$ '.$disQTY*$disPrice.'</td>		  		  		  
		</tr>'."\n";

		  if($i1==$db0_1->num_rows()-1){
		  	$total1 += $db0_1->num_rows();
			$NET1 += $NET;
			$TAX1 += $TAX;
			$TOT1 += $TOT;
		  
			  echo '
			  <tr><td colspan="8" align="right">Subtotal:'.$db0_1->num_rows().' data ,進貨淨額： $ '.$NET.'，進貨稅額： $ '.$TAX.'，進貨總額： $ '.$TOT.'&nbsp;</td>
			  </tr>';
		  }
	    }
	  }
echo  '</table></td></tr>'."\n";
		  if($i==$db0->num_rows()-1){
			  echo '
			  <tr><td colspan="8" align="right">Total :'.$total1.' data ,進貨淨額： $ '.$NET1.'，進貨稅額： $ '.$TAX1.'，進貨總額： $ '.$TOT1.'&nbsp;</td>
			  </tr>';
		  }
	}//end for
}//end if
?>
</table>
