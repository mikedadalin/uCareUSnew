<?php 
if($_GET['FirmDiv'] <> ""){
	//$fid = str_pad($_GET['FirmDiv'],6,'0',STR_PAD_LEFT);
	$fid = getHospNo(getPIDByHospNoDisplay($_GET['FirmDiv']));
}
?>
<h3>Resident reconciliation list</h3>
<div class="nurseform-table">
<table style="width:100%">
  <tr>
    <td><b>Bed Number: <span id="log4"><?php if ($fid=="") { echo ""; } else { echo getBedID(getPID($fid)); } ?></span></b></td>
    <td><b><span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select Delivery Date Range : </span> &nbsp;<script> $(function() { $( "#3printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="3printdate1" id="3printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#3printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="3printdate2" id="3printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12"></b></td>
  </tr>
  <tr>
  	<td colspan="2"><b><div>
  		Resident: <input name="FirmDiv" type="text" id="FirmDiv" onblur="showPatient();" size="5" value="<?php if ($fid=="") { echo ""; } else { echo getHospNoDisplayByHospNo($fid); } ?>"/>
    <button onclick="window.open('class/consump.php?query=3', '_blank', 'width=450, height=200, scrollbars=yes'); return false;" >...</button>
    <span id="log0"><?php if ($fid=="") { echo ""; } else { echo getPatientName(getPID($fid)); } ?></span>
    </b><input type="button" value="Search" onclick="datefunction('view','3');" /><input type="button" value="Print" onclick="datefunction('print','3');" /></div>
	</td>
  </tr> 
</table>
</div>
<table cellpadding="7" style="100%">
<?php
echo '
  <tr class="title">
    <td width="10%">Delivery Note ID#</td>
    <td width="10%">Shipping Date</td>
    <td width="10%">Product Serial Number</td>
	<td width="*">Product Name</td>
	<td width="10%" >Delivery Quantity</td>	
	<td width="10%" >Unit</td>
	<td width="10%" >Delivery Unit Price</td>	
	<td width="10%" >Delivery $ Amount</td>		
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT *, RIGHT(EXTRACT(YEAR_MONTH FROM a.`STK_Date` ),4) ordDate FROM `".$strModule."` a ";
$str0 .= "WHERE a.`type`='".$type."' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND a.IsStatus <> 'D'";
$str0 .=" and left(a.firmID,4)<>'Area' ";

if($fid<>""){
	$str0 .=" and a.firmID='".$fid."'";
}
$db0->query($str0);
if($db0->num_rows() > 0){
	$total1 = 0;
	$NET1 = 0;
	$TAX1 = 0;
	$TOT1 = 0;
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	//$IN = $type.$r0['ordDate'].$r0['firmStockID'];
  	$db0_1 = new DB;
	$str1 = "SELECT * FROM `".$subModule."` a inner join `arkstock` b on a.STK_NO=b.STK_NO WHERE `type`='".$r0['type']."' and `firmStockID` = '".$r0['firmStockID']."' and `STK_Date`='".$r0['STK_Date']."' AND a.IsStatus <> 'D'";
	$db0_1->query($str1);	
	  if($db0_1->num_rows() > 0){		 
	  $NET = 0;
	  $TAX = 0;
	  $TOT = 0;
	    for ($i1=0;$i1<$db0_1->num_rows();$i1++) {
	    $r0_1 = $db0_1->fetch_assoc();
		$disQTY = $r0_1['QTY'];
		$disPrice = $r0_1['Price'];				
		$NET += $disQTY*$disPrice;
		$TAX = $r0['STK_TAX'];
		$TOT = $NET + $TAX;
		//echo $NET."@@";
		echo '
		<tr>
		  <td align="center">'.$r0['type'].$r0['ordDate'].$r0['firmStockID'].'</td>
		  <td align="center">'.$r0['STK_Date'].'</td>
		  <td width="100" align="center">'.$r0_1['STK_NO'].'</td>
		  <td width="*" align="left">'.$r0_1['STK_NAME'].'</td>
		  <td width="120" align="right">'.$disQTY.'</td>		  		  
		  <td width="120" align="center">'.$r0_1['STK_UNIT'].'</td>		  
		  <td width="120" align="right">$ '.$disPrice.'</td>		  		  		  
		  <td width="120" align="right">$ '.$disQTY*$disPrice.'</td>		  		  		  
		</tr>'."\n";

		  if($i1==$db0_1->num_rows()-1){
		  	$total1 += $db0_1->num_rows();
			$NET1 += $NET;
			$TAX1 += $TAX;
			$TOT1 += $TOT;
			  
			  echo '
			  <tr><td colspan="8" align="right">Subtotal:'.$db0_1->num_rows().' data ,出貨淨額： $ '.$NET.'，出貨稅額： $ '.$TAX.'，出貨總額： $ '.$TOT.'&nbsp;</td>
			  </tr>';
			  echo  '</tr>'."\n";
			  if($i==$db0->num_rows()-1){
				  echo '
				  <tr><td colspan="8" align="right">Total :'.$total1.' data ,出貨淨額： $ '.$NET1.'，出貨稅額： $ '.$TAX1.'，出貨總額： $ '.$TOT1.'&nbsp;</td>
				  </tr>';
			  }
			  
		  }
	    }
	  }
echo  "\n";
  
	}
}
?>
</table>
