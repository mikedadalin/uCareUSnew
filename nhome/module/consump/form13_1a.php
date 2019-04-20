<h3><?php echo $typeName; ?> notes detail</h3>
<div class="content-query">
<table  class="noborder" width="100%">
  <tr>
    <td bgcolor="#FFFFFF" >Print time:<?php echo date('Y-m-d H:i:s'); ?></td>
    <td bgcolor="#FFFFFF" align="right" width="700"><span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select<?php echo $typeName; ?> date range :</span> Since &nbsp;<script> $(function() { $( "#0printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="0printdate1" id="0printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#0printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="0printdate2" id="0printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12">Ends<input type="button" value="Search" onclick="datefunction('view','0');" /><input type="button" value="Print" onclick="datefunction('print','0');" /></td>
  </tr>
</table>
</div>
<table width="900" class="noborder">
<?php
echo '
  <tr class="title">
    <td width="100">'.$typeName.' note ID#</td>
    <td width="100">'.$typeName.'Date</td>
	<td width="100">Vendor ID#</td>
	<td width="300" colspan="2">Vendor\'s name</td>
	<td width="80" >Tax category</td>	
	<td width="80" >Invoice/reciept No.</td>	
	<td width="80">Comment</td>	
  </tr>'."\n".'
  <tr class="title">
    <td width="100"></td>
    <td width="100" align="center">product serial number</td>
	<td width="267">Product name</td>
	<td width="100" align="center">Unit</td>
	<td width="100" align="center">Storehouse name</td>	
	<td width="80" align="center">'.$typeName.'Unit price</td>	
	<td width="80" align="center" >'.$typeName.'Quantity</td>	
	<td width="80" align="center">'.$typeName.'Amount of fee</td>		
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `".$strModule."` a inner join `firm` b on a.firmID=b.firmID ";
$str0 .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
$db0->query($str0);

if($db0->num_rows() > 0){
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();

echo '
  <tr>
    <td align="center" width="100">'.$r0['type'].$r0['ordDate'].$r0['firmStockID'].'</td>
    <td align="center" width="100">'.$r0['STK_Date'].'</td>
	<td align="center" width="100">'.$r0['firmID'].'</td>
	<td colspan="2" width="300">'.$r0['Title'].'</td>
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
			  <tr class="bLineB1"><td colspan="8" align="right" width="924">Subtotal:'.$db0_1->num_rows().' data ,'.$typeName.'net amount : $ '.$r0['STK_NET'].'，'.$typeName.' Tax amount : $ '.$r0['STK_TAX'].'，'.$typeName.' Total amount : $ '.$r0['STK_TOT'].'&nbsp;</td>
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
			  <tr  class="bLineB"><td colspan="8" align="right" width="924">Total :'.$total1.' data ,'.$typeName.'net amount : $ '.$NET1.'，'.$typeName.' Tax amount : $ '.$TAX1.'，'.$typeName.' Total amount : $ '.$TOT1.'&nbsp;</td>
			  </tr>';
		  }
  
	}
}
?>
</table>
