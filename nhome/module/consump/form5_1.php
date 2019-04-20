<?php
$db0 = new DB;
$db0->query("SELECT `areaName` FROM `arkarea` WHERE `areaID`='".mysql_escape_string($_GET['area'])."'");
$r0 = $db0->fetch_assoc();
$areaName = $r0['areaName'];
?>
<h3>撿貨單 (<?php echo $areaName; ?>)</h3>
<script>
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/","-"); date1 = date1.replace("/","-");
	var date2 = (document.getElementById('printdate2').value).replace("/","-"); date2 = date2.replace("/","-");
	if (functioname=='print') {
		window.location.href='print.php?mod=consump&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=5_1&area=<?php echo @$_GET['area']; ?>&date1='+date1+'&date2='+date2+'&allrecord=<?php echo @$_GET['allrecord']; ?>';
	} else if (functioname=='view') {
		window.location.href='index.php?mod=consump&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=5_1&area=<?php echo @$_GET['area']; ?>&date1='+date1+'&date2='+date2+'&allrecord=<?php echo @$_GET['allrecord']; ?>';
	}
}
</script>
<table id="form5tbl1" <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>
  <tr>
    <td bgcolor="#FFFFFF">Print time:<?php echo date('Y-m-d H:i:s'); ?></td>
    <td bgcolor="#FFFFFF" align="right"><form><?php echo @$_GET['allrecord']==1?"<input type='button' value='只顯示未出貨紀錄' onclick='window.location.href=\"index.php?mod=consump&func=formview&id=5_1&area=".@$_GET['area']."&date1=".@$_GET['date1']."&date2=".@$_GET['date2']."\"' />":"<input type='button' value='Display all records' onclick='window.location.href=\"index.php?mod=consump&func=formview&id=5_1&area=".@$_GET['area']."&date1=".@$_GET['date1']."&date2=".@$_GET['date2']."&allrecord=1\"' />"; ?> 選擇申請日期範圍：<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']=="") { echo date("Y-m-d"); } else { echo @$_GET['date1']; } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']=="") { echo date("Y-m-d"); } else { echo @$_GET['date2']; } ?>" size="12"><input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="Print" onclick="datefunction('print');" /></form></td>
  </tr>
</table>
<table width="960px" id="form5tbl2">
<?php
$arrHospNo = array();
$db0 = new DB;
$db0->query("SELECT * FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_GET['area'])."'");
for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	$db0_1 = new DB;
	$db0_1->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r0['bedID']."'");
	$r0_1 = $db0_1->fetch_assoc();
	$HospNo = getHospNo($r0_1['patientID']);
	if ($HospNo!="") { array_push($arrHospNo, $HospNo); }
}
echo '
  <thead>
  <tr class="title">
    <th>Requisition ID#</th>
    <th>Resident</th>
    <th>Item</th>
    <th>Requested quantity</th>
    <th>Delivery quantity</th>
    <th>Date of requisition</th>
    <th>Applicant</th>
	<th class="printcol" width="66">Edit</th>
  </tr>
  </thead>'."\n";
  for ($k=0;$k<count($arrHospNo);$k++) {
	  if (@$_GET['date1']==NULL && @$_GET['date2']==NULL) {
		  $sql = "SELECT * FROM `arkordinfo` WHERE `PS_NO`='".$arrHospNo[$k]."' AND LEFT(`PS_NAME`,4)<>'Area' AND `PS_NAME`<>'' ORDER BY `ORD_DATE` DESC";
	  } else {
		  $sql = "SELECT * FROM `arkordinfo` WHERE `PS_NO`='".$arrHospNo[$k]."' AND `ORD_DATE`>='".mysql_escape_string($_GET['date1'])." 00:00:00' AND `ORD_DATE`<='".mysql_escape_string($_GET['date2'])." 23:59:59' AND LEFT(`PS_NAME`,4)<>'Area' AND `PS_NAME`<>'' ORDER BY `ORD_DATE` DESC";
	  }
	  $db1 = new DB;
	  $db1->query($sql);
	  for ($i=0;$i<$db1->num_rows();$i++) {
		  $r1 = $db1->fetch_assoc();
		  $db2 = new DB;
		  $db2->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$r1['ORD_SEQ']."'");
		  if ($db2->num_rows()>0) {
			  for ($j=0;$j<$db2->num_rows();$j++) {
				  $r2 = $db2->fetch_assoc();
				  $db2b = new DB;
				  $db2b->query("SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".$r2['STK_NO']."'");
				  $r2b = $db2b->fetch_assoc();
				  if (@$_GET['allrecord']==1) {
					  $count_patient++;
					  echo '
					  <tr>
						<td>'.(int)$r1['ORD_SEQ'].'</td>
						<td>'.getBedID(getPID($arrHospNo[$k])).' '.getPatientName(getPID($arrHospNo[$k])).'['.getHospNoDisplayByHospNo($arrHospNo[$k]).']</td>
						<td> ['.$r2b['STK_NO'].'] '.$r2['STK_NAME'].'</td>
						<td>'.$r2['ORD_QTY'].' '.$r2['STK_UNIT'].'</td>
						<td>'.($r2['OUT_QTY']>0?$r2['OUT_QTY']:"&nbsp;").'</td>
						<td>'.$r1['ORD_DATE'].'</td>
						<td>'.$r1['ORD_USER'].'</td>
						<td class="printcol"><a href="index.php?mod=consump&func=formview&id=3_1&pid='.getPID($r2['PS_NO']).'&ORDSEQ='.$r1['ORD_SEQ'].'"><img src="Images/edit_icon.png" width="30"></a> <a href="index.php?mod=consump&func=formview&id=12_2&pid='.getPID($r2['PS_NO']).'" target="_blank"><img src="Images/insert_to_shopping_cart.png" width="30" title="Shippment"></a></td>
					  </tr>
					  '."\n";
				  } else {
					  if ($r2['OUT_QTY']<$r2['ORD_QTY']) {
						  $count_patient++;
						  echo '
						  <tr>
							<td>'.(int)$r1['ORD_SEQ'].'</td>
							<td>'.getBedID(getPID($arrHospNo[$k])).' '.getPatientName(getPID($arrHospNo[$k])).'['.getHospNoDisplayByHospNo($arrHospNo[$k]).']</td>
							<td> ['.$r2b['STK_NO'].'] '.$r2['STK_NAME'].'</td>
							<td>'.$r2['ORD_QTY'].' '.$r2['STK_UNIT'].'</td>
							<td>&nbsp;</td>
							<td>'.$r1['ORD_DATE'].'</td>
							<td>'.$r1['ORD_USER'].'</td>
							<td class="printcol"><a href="index.php?mod=consump&func=formview&id=3_1&pid='.getPID($r2['PS_NO']).'&ORDSEQ='.$r1['ORD_SEQ'].'"><img src="Images/edit_icon.png" width="30"></a> '.($r2['ORD_RMK']=='1'?'<a href="index.php?mod=consump&func=formview&id=12_2&pid='.getPID($r2['PS_NO']).'"><img src="Images/warning.png" width="30" title="已出貨但數量有缺"></a>':($r2['ORD_RMK']=='2'?'<img src="Images/accept.png" width="30" title="已完成出貨">':'<a href="index.php?mod=consump&func=formview&id=12_2&pid='.getPID($r2['PS_NO']).'" target="_blank"><img src="Images/insert_to_shopping_cart.png" width="30" title="Shippment"></a>')).'</td>
						  </tr>
						  '."\n";
					  }
				  }
			  }
		  }
	  }
  }
if (@$_GET['date1']==NULL && @$_GET['date2']==NULL) {
	$sql2 = "SELECT * FROM `arkordinfo` WHERE `PS_NAME`='Area".@$_GET['area']."' AND LEFT(`PS_NAME`,4)='Area' ORDER BY `ORD_DATE` DESC";
} else {
	$sql2 = "SELECT * FROM `arkordinfo` WHERE `PS_NAME`='Area".@$_GET['area']."' AND `ORD_DATE`>='".mysql_escape_string($_GET['date1'])." 00:00:00' AND `ORD_DATE`<='".mysql_escape_string($_GET['date2'])." 23:59:59' AND LEFT(`PS_NAME`,4)='Area' ORDER BY `ORD_DATE` DESC";
}
$db1a = new DB;
$db1a->query($sql2);
for ($i1=0;$i1<$db1a->num_rows();$i1++) {
	$r1a = $db1a->fetch_assoc();
	$db2a = new DB;
	$db2a->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$r1a['ORD_SEQ']."'");
	if ($db2a->num_rows()>0) {
		for ($j2=0;$j2<$db2a->num_rows();$j2++) {
			$r2a = $db2a->fetch_assoc();
			$db2b = new DB;
			$db2b->query("SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".$r2a['STK_NO']."'");
			$r2b = $db2b->fetch_assoc();
			if (@$_GET['allrecord']==1) {
				$count_common++;
				echo '
				<tr>
				  <td>'.(int)$r1a['ORD_SEQ'].'</td>
				  <td>'.$areaName.'</td>
				  <td> ['.$r2b['STK_NO'].'] '.$r2a['STK_NAME'].'</td>
				  <td>'.$r2a['ORD_QTY'].' '.$r2a['STK_UNIT'].'</td>
				  <td>&nbsp;</td>
				  <td>'.$r1a['ORD_DATE'].'</td>
				  <td>'.$r1a['ORD_USER'].'</td>
				  <td class="printcol"><a href="index.php?mod=consump&func=formview&id=10_1&ORDSEQ='.$r1a['ORD_SEQ'].'"><img src="Images/edit_icon.png" width="30"></a> <a href="index.php?mod=consump&func=formview&id=12_2&aID='.str_replace("Area","",$r1a['PS_NAME']).'" target="_blank"><img src="Images/insert_to_shopping_cart.png" width="30" title="Shippment"></a></td>
				</tr>
				'."\n";
			} else {
				if ($r2a['OUT_QTY']<$r2a['ORD_QTY']) {
					$count_common++;
					echo '
					<tr>
					  <td>'.(int)$r1a['ORD_SEQ'].'</td>
					  <td>'.$areaName.'</td>
					  <td> ['.$r2b['STK_NO'].'] '.$r2a['STK_NAME'].'</td>
					  <td>'.$r2a['ORD_QTY'].' '.$r2a['STK_UNIT'].'</td>
					  <td>&nbsp;</td>
					  <td>'.$r1a['ORD_DATE'].'</td>
					  <td>'.$r1a['ORD_USER'].'</td>
					  <td class="printcol"><a href="index.php?mod=consump&func=formview&id=10_1&ORDSEQ='.$r1a['ORD_SEQ'].'"><img src="Images/edit_icon.png" width="30"></a> '.($r2a['ORD_RMK']=='1'?'<a href="index.php?mod=consump&func=formview&id=12_2&aID='.str_replace("Area","",$r1a['PS_NAME']).'"><img src="Images/warning.png" width="30" title="已出貨但數量有缺"></a>':($r2a['ORD_RMK']=='2'?'<img src="Images/accept.png" width="30" title="已完成出貨">':'<a href="index.php?mod=consump&func=formview&id=12_2&aID='.str_replace("Area","",$r1a['PS_NAME']).'" target="_blank"><img src="Images/insert_to_shopping_cart.png" width="30" title="Shippment">')).'</a></td>
					</tr>
					'."\n";
				}
			}
		}
	}
}
?>
</table>
<script>
$('#form5tbl2').DataTable({
	paging: false,
	"order": [[ 1, "asc" ]]
});
</script>