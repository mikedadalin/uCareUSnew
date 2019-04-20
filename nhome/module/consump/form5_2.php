<h3>Picking invoice list</h3>
<script>
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/","-"); date1 = date1.replace("/","-");
	var date2 = (document.getElementById('printdate2').value).replace("/","-"); date2 = date2.replace("/","-");
	if (functioname=='print') {
		window.location.href='print.php?mod=consump&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=5_2&area=<?php echo @$_GET['area']; ?>&date1='+date1+'&date2='+date2+'&allrecord=<?php echo @$_GET['allrecord']; ?>';
	} else if (functioname=='view') {
		window.location.href='index.php?mod=consump&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=5_2&area=<?php echo @$_GET['area']; ?>&date1='+date1+'&date2='+date2+'&allrecord=<?php echo @$_GET['allrecord']; ?>';
	}
}
function gotoview(view) {
	window.location.href='index.php?mod=consump&func=formview&id=5_2&view='+view;
}
$(function() {
<?php
if ($_GET['view']==1) {
	$view = 1;
	echo '$(".ApplyDetail").remove();';
} else {
	$view = 2;
}
?>
	$('#format').buttonset();
});
</script>
<div align="right" id="format" class="printcol">
  <input type="radio" id="view1" name="view" value="1" <?php if ($view==1) { echo 'checked'; } ?> onclick="gotoview('1');"><label for="view1">Hide detail</label>
  <input type="radio" id="view2" name="view" value="2" <?php if ($view==2) { echo 'checked'; } ?> onclick="gotoview('2');"><label for="view2">Display detail</label>
</div>
<table width="960px" cellpadding="6">
<?php
echo '
  <thead>
  <tr class="title">
    <th>Item</th>
    <th width="80">Requested Quantity</th>
	<th width="80">Unit</th>
  </tr>
  </thead>'."\n";
  $db2 = new DB;
  $db2->query("SELECT `ORD_SEQ`, `STK_NO`, `STK_NAME`, SUM(`ORD_QTY`) AS `ORD_QTY`, `STK_UNIT`, `ORD_RMK` FROM `arkord` WHERE `ORD_QTY`>`OUT_QTY` AND `PS_NAME`<>'' AND (`ORD_RMK` IS NULL OR `ORD_RMK`='1') GROUP BY `STK_NO`;");
  if ($db2->num_rows()>0) {
	  for ($j=0;$j<$db2->num_rows();$j++) {
		  $r2 = $db2->fetch_assoc();
		  $db2b = new DB;
		  $db2b->query("SELECT * FROM `arkstockforapply` WHERE `ApplyItemID`='".$r2['STK_NO']."'");
		  $r2b = $db2b->fetch_assoc();
		  echo '
		  <tr>
			<td> ['.$r2b['STK_NO'].'] '.$r2['STK_NAME'].'</td>
			<td>'.$r2['ORD_QTY'].'</td>
			<td>'.$r2['STK_UNIT'].'</td>
		  </tr>
		  <tr class="ApplyDetail">
			<td colspan="3" style="padding-left:12px;">
			<table width="100%">';
				$db2a = new DB;
				$db2a->query("SELECT `PS_NO`, `PS_NAME`, SUM(`ORD_QTY`) AS `ORD_QTY`, `STK_UNIT` FROM `arkord` WHERE `STK_NO`='".$r2['STK_NO']."' AND `ORD_QTY`>`OUT_QTY` AND `PS_NAME`<>'' AND (`ORD_RMK` IS NULL OR `ORD_RMK`='1') GROUP BY `PS_NAME`");
				$pName = "";
				$arrTOT = array();
				for ($i2=0;$i2<$db2a->num_rows();$i2++) {
					$r2a = $db2a->fetch_assoc();
					if (substr($r2a['PS_NAME'],0,4)=="Area") {
						$db3 = new DB;
						$db3->query("SELECT areaName FROM arkarea WHERE `areaID`='".str_replace("Area","",$r2a['PS_NAME'])."'");
						$r3 = $db3->fetch_assoc();
						$arrTOT[$r3['areaName']] += $r2a['ORD_QTY'];
					} else {
						if (getPatientArea(getPID($r2a['PS_NO']))!="---") {
							$arrTOT[getPatientArea(getPID($r2a['PS_NO']))] += $r2a['ORD_QTY'];
						} else {
							$arrTOT[getPatientArea(getPID($r2a['PS_NO'])).' '.getPatientName(getPID($r2a['PS_NO'])).' ['.getHospNoDisplayByPID(getPID($r2a['PS_NO'])).']'] += $r2a['ORD_QTY'];
						}
					}
				}
				ksort($arrTOT);
				$count = 0;
				foreach ($arrTOT as $k1=>$v1) {
					$count++;
					echo '
				<tr style="background:#fff;">
				  <td width="24" style="border:none;">'.$count.'.</td>
				  <td style="border:none; text-align:left;">'.str_replace('---','Discharged/case closed',$k1).'</td>
				  <td width="160" style="border:none;">'.$v1.'</td>
				</tr>
					'."\n";
				}
			echo '</table>
			</td>
		  </tr>
		  '."\n";
	  }
  }
?>
</table>