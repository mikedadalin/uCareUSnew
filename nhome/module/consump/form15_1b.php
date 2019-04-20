<h3><?php echo $typeName; ?> Statistics</h3>
<div class="nurseform-table">
<table style="width:100%">
  <tr>
    <td><b>Print time:<?php echo date('Y-m-d H:i:s'); ?></b></td>
    <td><b><span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select <?php echo $typeName; ?> Date Range : </span> &nbsp;<script> $(function() { $( "#1printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="1printdate1" id="1printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#1printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="1printdate2" id="1printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view','1');" /><input type="button" value="Print" onclick="datefunction('print','1');" /></b></td>
  </tr>
</table>
</div>
<table cellpadding="7" class="lightLine" style="width:100%">
<?php
echo '
  <tr class="title">
	<td width="10%">Care ID#</td>
	<td width="*">Name</td>
	<td width="20%" >'.$typeName.' net amount</td>	
	<td width="20%" >'.$typeName.' tax amount</td>	
	<td width="20%">'.$typeName.' total amount</td>	
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT DISTINCT(firmID) FROM `firmstock` WHERE `STK_Date`>='".mysql_escape_string($_GET['date1'])."' and `STK_Date`<='".mysql_escape_string($_GET['date2'])."' ";
$str0 .= " AND `type`='".$type."' AND IsStatus <> 'D' order by firmID";
$db0->query($str0);
if($db0->num_rows() > 0){
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	
  	$db0_1 = new DB;
	$str1 = "SELECT SUM( a.`STK_NET` ) net, SUM( a.`STK_TAX` ) tax, SUM( a.`STK_TOT` ) total FROM `".$strModule."` a ";
	$str1 .=" WHERE a.type='".$type."' ";
	$str1 .=" AND a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."'";
	$str1 .=" AND a.`firmID`='".$r0['firmID']."' AND a.IsStatus <> 'D' ";
	$db0_1->query($str1);
	  if($db0_1->num_rows() > 0){
		  $r0_1 = $db0_1->fetch_assoc();
		  echo '
			<tr>
			  <td width="10%" align="center">'.(substr($r0['firmID'],0,4)=="Area" ? "---" : $r0['firmID']).'</td>
			  <td width="*">'.(substr($r0['firmID'],0,4)=="Area" ? getArkAreaName($r0['firmID']) : getPatientName(getPID($r0['firmID']))).'</td>
			  <td width="20%" align="right">'.$r0_1['net'].'</td>	
			  <td width="20%" align="right">'.$r0_1['tax'].'</td>	
			  <td width="20%" align="right">'.$r0_1['total'].'</td>	
			 </tr>'."\n";
			 $count++;
			 $net += $r0_1['net'];
			 $tax += $r0_1['tax'];
			 $total += $r0_1['total'];
  	  }

	}
	echo '
	<tr><td colspan="5" align="right">Subtotal:'.$count.' data ,'.$typeName.'net amount : $ '.$net.'，'.$typeName.' Tax amount : $ '.$tax.'，'.$typeName.' Total amount : $ '.$total.'&nbsp;</td>
	</tr>';
}
?>
</table>
