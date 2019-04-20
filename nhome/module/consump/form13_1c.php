<h3><?php echo $typeName; ?> Price list</h3>
<div class="content-query">
<table class="noborder" width="100%">
  <tr>
    <td bgcolor="#FFFFFF">Print time:<?php echo date('Y-m-d H:i:s'); ?></td>
    <td bgcolor="#FFFFFF" align="right" width="700"> <span <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>Select<?php echo $typeName; ?> date range :</span> Since &nbsp;<script> $(function() { $( "#2printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="2printdate1" id="2printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#2printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="2printdate2" id="2printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } ?>" size="12">Ends<input type="button" value="Search" onclick="datefunction('view','2');" /><input type="button" value="Print" onclick="datefunction('print','2');" /></td>
  </tr>
</table>
</div>
<table width="900" class="noborder3">
<?php
echo '
  <tr class="title">
	<td width="8%" align="center">Vendor ID#</td>
	<td width="*">Vendor\'s name</td>
	<td width="8%" align="center" >product serial number</td>	
	<td width="22%" >Product name</td>	
	<td width="6%">Unit</td>	
	<td width="6%">Unit price</td>	
	<td width="10%">Latest '.$typeName.' Day(s)</td>		
  </tr>'."\n";

$db0 = new DB;
$str0 = "SELECT DISTINCT(firmID) FROM `firmstock` WHERE `STK_Date`>='".mysql_escape_string($_GET['date1'])."' and `STK_Date`<='".mysql_escape_string($_GET['date2'])."' AND `type`='".$type."' AND IsStatus <>  'D' order by firmID";

$db0->query($str0);
if($db0->num_rows() > 0){
	for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
  	$db0_1 = new DB;
	$str1 = "SELECT DISTINCT (b.STK_NO), a.firmID, b.Price,b.STK_DATE FROM `firmstock` a INNER JOIN `firmstockinfo` b ON ";
	$str1 .=" a.firmstockID = b.firmstockID AND a.type = b.type AND a.STK_DATE=b.STK_DATE WHERE a.type = '".$type."' ";
	$str1 .=" AND a.`firmID`='".$r0['firmID']."' AND a.IsStatus <> 'D' and a.`STK_Date`>='".mysql_escape_string($_GET['date1'])."' and a.`STK_Date`<='".mysql_escape_string($_GET['date2'])."' ";
	$db0_1->query($str1);
	  if($db0_1->num_rows() > 0){
		  for ($ii=0;$ii<$db0_1->num_rows();$ii++){
		  $r0_1 = $db0_1->fetch_assoc();
		  echo '<tr>';
			 if($tmp!=$r0['firmID']){
			  echo '
			  <td width="8%" rowspan="'.$db0_1->num_rows().'" valign="top" align="center">'.$r0['firmID'].'</td>
			  <td width="20%" rowspan="'.$db0_1->num_rows().'" valign="top">'.getFirmName($r0['firmID']).'</td>';
			 }
			  echo '
			  <td width="8%" align="center">'.$r0_1['STK_NO'].'</td>	
			  <td width="20%" >'.STK_NAME($r0_1['STK_NO']).'</td>	
			  <td width="6%">'.getUNIT($r0_1['STK_NO']).'</td>	
			  <td width="6%" align="right">'.$r0_1['Price'].'</td>	
			  <td width="10%" align="center">'.$r0_1['STK_DATE'].'</td>		
			 </tr>'."\n";
			 
		  $tmp=$r0['firmID'];
		  	if($ii==$db0_1->num_rows()-1){
		  	 	echo '<tr><td colspan="8" class="btL">&nbsp;</td></tr>'."\n";	
			}
		  }
  	  }
	}
}
?>
</table>
