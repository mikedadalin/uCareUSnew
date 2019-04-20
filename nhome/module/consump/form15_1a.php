<h3><?php echo $typeName; ?> notes detail</h3>
<div class="nurseform-table">
<table style="width:100%;">
  <tr>
    <td><b>Print Time: <?php echo date('Y-m-d H:i:s'); ?></b></td>
    <td><b><span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select <?php echo $typeName; ?> Date Range : </span> &nbsp;<script> $(function() { $( "#0printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="0printdate1" id="0printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#0printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="0printdate2" id="0printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view','0');" /><input type="button" value="Print" onclick="datefunction('print','0');" /></b></td>
  </tr>
</table>
</div>
<table cellpadding="7" style="width:100%;">
<?php
echo '
  <tr class="title">
    <td width="100">'.$typeName.' Note ID#</td>
    <td width="100">'.$typeName.'Date</td>
	<td width="100">Care ID#</td>
	<td width="300" colspan="2">Name</td>
	<td width="80" >Tax Category</td>	
	<td width="80" >Invoice/Reciept No.</td>	
	<td width="80">Comment</td>	
  </tr>'."\n".'
  <tr class="title">
    <td width="100"></td>
    <td width="100" align="center">Product Serial Number</td>
	<td width="267">Product Name</td>
	<td width="100" align="center">Unit</td>
	<td width="100" align="center">Storehouse Name</td>	
	<td width="80" align="center">'.$typeName.' Unit Price</td>	
	<td width="80" align="center" >'.$typeName.' Quantity</td>	
	<td width="80" align="center">'.$typeName.' Amount of Fee</td>		
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `".$strModule."` a ";
$str0 .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
$db0->query($str0);

if($db0->num_rows() > 0){
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();

echo '
  <tr>
    <td align="center" width="100">'.$r0['type'].$r0['ordDate'].$r0['firmStockID'].'</td>
    <td align="center" width="100">'.$r0['STK_Date'].'</td>
	<td align="center" width="100">'.(substr($r0['firmID'],0,4)=="Area" ? "---" : $r0['firmID']).'</td>
	<td colspan="2" width="300">'.(substr($r0['firmID'],0,4)=="Area" ? getArkAreaName($r0['firmID']) : getPatientName(getPID($r0['firmID']))).'</td>
	<td align="center" width="80">'.($r0['Tax_1']==1 ? "Taxable" : "Exemption").'</td>	
	<td align="center" width="80">'.$r0['ReceiptNO'].'</td>	
	<td width="80">'.$r0['Fmark'].'</td>
  </tr>'."\n".'
  <tr><td colspan="8"><table width="100%" class="noborder">';
  	$db0_1 = new DB;
	$str1 = "SELECT * FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO WHERE `type`='".$r0['type']."' and a.`firmStockID` = '".$r0['firmStockID']."' and a.`STK_Date`='".$r0['STK_Date']."' AND a.IsStatus <> 'D'";

	$db0_1->query($str1);
	  if($db0_1->num_rows() > 0){
		  
	    for ($i1=0;$i1<$db0_1->num_rows();$i1++) {
	    $r0_1 = $db0_1->fetch_assoc();
		echo '
		<tr>
		  <td width="100">&nbsp;</td>
		  <td width="100" align="center">'.$r0_1['STK_NO'].'</td>
		  <td width="267" align="left">'.$r0_1['STK_NAME'].'</td>
		  <td width="100" align="center">'.$r0_1['STK_UNIT'].'</td>		  
		  <td width="100" align="center">'.getStockName($r0_1['StockID']).'</td>		  		  
		  <td width="80" align="right">$ '.$r0_1['Price'].'</td>		  		  		  
		  <td width="80" align="right">'.$r0_1['QTY'].'</td>		  		  
		  <td width="80" align="right">$ '.$r0_1['QTY']*$r0_1['Price'].'</td>		  		  		  
		</tr>'."\n";

		  if($i1==$db0_1->num_rows()-1){
			  echo '
			  <tr class="bLineB1"><td colspan="8" align="right" style="width: 100%;">Subtotal:'.$db0_1->num_rows().' data ,'.$typeName.'net amount : $ '.$r0['STK_NET'].'，'.$typeName.' Tax amount : $ '.$r0['STK_TAX'].'，'.$typeName.' Total amount : $ '.$r0['STK_TOT'].'&nbsp;</td>
			  </tr>';
		  	$total1 += $db0_1->num_rows();
			$NET1 += $r0['STK_NET'];
			$TAX1 += $r0['STK_TAX'];
			$TOT1 += $r0['STK_TOT'];
			  
		  }
	    }
	  }
echo  '</table></td></tr>'."\n";
		  if($i==$db0->num_rows()-1){
			  echo '
			  <tr  class="bLineB"><td colspan="8" align="right" style="width: 100%;">Total :'.$total1.' data ,進貨淨額： $ '.$NET1.'，進貨稅額： $ '.$TAX1.'，進貨總額： $ '.$TOT1.'&nbsp;</td>
			  </tr>';
		  }
  
	}
}
?>
</table>
