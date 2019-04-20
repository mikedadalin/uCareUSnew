<?php 
if($_GET['FirmDiv'] <> ""){
	$fid = str_pad($_GET['FirmDiv'],6,'0',STR_PAD_LEFT);
}
?>
<h3>Individual Shippment Statistic</h3>
<div class="nurseform-table">
<table style="width:100%">
  <tr>
    <td width="120" class="title"><center><b>Shipping Date (Start)</b></center></td>
    <td colspan="2"><script> $(function() { $( "#6printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="6printdate1" id="6printdate1" value="<?php if (@$_GET['date3']=="") { echo date("Y/m/d"); } else { echo @$_GET['date3']; } ?>" size="12"></td>  
    <td width="120" class="title"><center><b>Shipping Date (Until)</b></center></td>
    <td colspan="3"><script> $(function() { $( "#6printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="6printdate2" id="6printdate2" value="<?php if (@$_GET['date4']=="") { echo date("Y/m/d"); } else { echo @$_GET['date4']; } ?>" size="12"> </td>  
    </tr>
  <tr>
    <td width="120" class="title">Product Serial Number</td>
    <td colspan="2"><input name="STK_NO3" type="text" id="STK_NO3" onblur="blurselect(3);" value="<?php if (@$_GET['STK_NO3']=="") { echo ""; } else { echo @$_GET['STK_NO3']; } ?>"/>　<button onclick="window.open('class/searchSTK3.php?query=3', '_blank', 'width=960, height=150'); return false;" title="點選查詢">...</button></td>  
    <td width="120" class="title">Product Name</td>
    <td colspan="3"><input type="text" id="STK_NAME3" name="STK_NAME3"  disabled="disabled"  /></td>
    </tr>
  <tr>
    <td align="center" colspan="7"><input type="button" value="Search" onclick="datefunction('view','6');" /></td>
  </tr> 
</table>
</div>
<?php
$db1 = new DB;
$strSQL = "SELECT `type`, RIGHT( EXTRACT( YEAR_MONTH FROM  `STK_Date` ) , 4 ) ordDate , `firmStockID`, STK_NO, STK_DATE, `QTY` FROM `firmstockinfo` WHERE `type`='SP' AND `IsStatus` <> 'D' AND`STK_NO`='".mysql_escape_string($_GET['STK_NO3'])."' AND `STK_DATE` BETWEEN '".mysql_escape_string($_GET['date3'])."' AND '".mysql_escape_string($_GET['date4'])."' ORDER BY `STK_DATE` DESC";
$db1->query($strSQL);
if ($db1->num_rows() >0) {
	echo '<div class="content-table"><table id="recordtable">
			<thead>
			<tr class="title">
				<th>Shipping date</th>
				<th>Delivery note ID#</th>
				<th>Name</th>
				<th>product serial number</th>
				<th>Product name</th>
				<th>Delivery quantity</th>
			</tr>
			</thead>
	';
	for($i=0;$i<$db1->num_rows();$i++){
		$r1 = $db1->fetch_assoc();
		$db1a = new DB;
		$db1a->query("SELECT `firmID` FROM `firmstock` WHERE `firmStockID`='".$r1['firmStockID']."' AND `STK_DATE`='".$r1['STK_DATE']."' AND `type`='SP'");
		$r1a = $db1a->fetch_assoc();
		echo '
			<tr>
				<td>'.$r1['STK_DATE'].'</td>
				<td>'.$r1['type'].$r1['ordDate'].$r1['firmStockID'].'</td>
				<td>'.(substr($r1a['firmID'],0,4)=="Area"?getArkAreaName(str_replace('Area','',$r1a['firmID'])):getPatientName(getPID($r1a['firmID']))).'</td>
				<td>'.$r1['STK_NO'].'</td>
				<td>'.STK_NAME($r1['STK_NO']).'</td>
				<td>'.$r1['QTY'].'</td>
			</tr>
		';
	}
	echo '</div></table>';
}

$db = new DB;
$db->query("SELECT `STK_NO`, sum(`QTY`) 'QTY', sum(`Price`) 'PRICE'  FROM `firmstockinfo` WHERE `type`='SP' AND `IsStatus` <> 'D' AND`STK_NO`='".mysql_escape_string($_GET['STK_NO3'])."' AND `STK_DATE` BETWEEN '".mysql_escape_string($_GET['date3'])."' AND '".mysql_escape_string($_GET['date4'])."' GROUP BY `STK_NO` ");
$r = $db->fetch_assoc();
if($db->num_rows() > 0){
?>
<div class="content-table">
<table>
	<tr>
    	<td class="title" colspan="2">查詢結果小計</td>
    </tr>
	<tr>
    	<td class="title" width="160">product Serial Number</td>
        <td><?php echo $r['STK_NO']; ?></td>
    </tr>
	<tr>
    	<td class="title" width="160">Product Name</td>
        <td><?php echo STK_NAME($r['STK_NO']); ?></td>
    </tr>
	<tr>
    	<td class="title" width="160">出貨總數</td>
        <td><?php echo $r['QTY']; ?></td>
    </tr>
	<tr>
    	<td class="title" width="160">出貨總價</td>
        <td><?php echo $r['PRICE']; ?></td>
    </tr>
</table>
<?php 
}else{
?>
<table>
	<tr>
        <td class="title">No Data</td>
    </tr>
</table>    
<?php	
}?>
</div>
<script>
$(function(){
	$('#recordtable').dataTable();
})
</script>
