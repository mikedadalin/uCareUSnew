<h3><?php echo $typeName; ?> Statistics</h3>
<div class="content-query">
<table  class="noborder" width="97%">
  <tr>
    <td bgcolor="#FFFFFF">Print time:<?php echo date('Y-m-d H:i:s'); ?></td>
    <td bgcolor="#FFFFFF" align="right" width="700"> <span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select<?php echo $typeName; ?> date range :</span> Since &nbsp;<script> $(function() { $( "#1printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="1printdate1" id="1printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#1printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="1printdate2" id="1printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12">Ends<input type="button" value="Search" onclick="datefunction('view','1');" /><input type="button" value="Print" onclick="datefunction('print','1');" /></td>
  </tr>
</table>
</div>
<table width="97%"  class="lightLine">
<?php
echo '
  <tr class="title">
	<td width="10%">Vendor ID#</td>
	<td width="*">Vendor\'s name</td>
	<td width="10%" >'.$typeName.' net amount</td>	
	<td width="10%" >'.$typeName.' tax amount</td>	
	<td width="10%">'.$typeName.' total amount</td>	
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT DISTINCT(firmID) FROM `firmstock` WHERE `STK_Date`>='".mysql_escape_string($_GET['date1'])."' and `STK_Date`<='".mysql_escape_string($_GET['date2'])."' ";
$str0 .= " AND `type`='".$type."' AND IsStatus <> 'D' order by firmID";

$db0->query($str0);
if($db0->num_rows() > 0){
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	
  	$db0_1 = new DB;
	$str1 = "SELECT b.Title, SUM( a.`STK_NET` ) net, SUM( a.`STK_TAX` ) tax, SUM( a.`STK_TOT` ) total FROM `".$strModule."` a ";
	$str1 .=" INNER JOIN  `firm` b ON a.firmID = b.firmID WHERE a.type='".$type."' ";
	$str1 .=" AND a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."'";
	$str1 .=" AND a.`firmID`='".$r0['firmID']."' AND a.IsStatus <> 'D' group by b.Title";
	$db0_1->query($str1);
	  if($db0_1->num_rows() > 0){
		  $r0_1 = $db0_1->fetch_assoc();
		  echo '
			<tr>
			  <td width="10%" align="center">'.$r0['firmID'].'</td>
			  <td width="*">'.$r0_1['Title'].'</td>
			  <td width="10%" align="right">'.$r0_1['net'].'</td>	
			  <td width="10%" align="right">'.$r0_1['tax'].'</td>	
			  <td width="10%" align="right">'.$r0_1['total'].'</td>	
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
