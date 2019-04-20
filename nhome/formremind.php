<?php
if (@$_GET['type']==1) { $type="Nursing Care"; } elseif (@$_GET['type']==2) { $type="Social Work"; }
$db1 = new DB;
$db1->query("SELECT * FROM `formremind` WHERE `formType`='".$type."' AND `remindDay`>0 ORDER BY `formID`");
?>
<div class="nurseform-table" style="font-size:10pt; width=100%; background-color: rgba(255,255,255,0.9); border-radius: 10px; padding: 0% 2%; margin-bottom:30px;">
<div align="center" style="padding-top:15px;"><h3 style="color:#69b3b6;">Form schedule reminder</h3></div>
<form method="post">
<div style="width:100%; overflow-x:hidden; text-align:center;margin-bottom:20px;">
<table style="table-layout:fixed; border-radius:10px;" id="remindlist">
  <thead>
  <tr class="title">
    <th width="90">Resident</th>
	<?php
    for ($i1=0;$i1<$db1->num_rows();$i1++) {
        $r1 = $db1->fetch_assoc();
    ?>
    <th width="75"><?php echo $r1['formName']; ?><br>(<?php echo $r1['remindDay']; ?>Day(s))</th>
	<?php
    }
    ?>
  </tr>
  </thead>
  <?php
  $db = new DB;
  $db->query("SELECT * FROM `inpatientinfo` ORDER BY `bed` ASC");
  for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='1' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			echo '
			<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>
			  <td align="left">'.$r['bed'].'<br>'.getPatientName($r1['patientID']).'<br>'.$r1['HospNoDisplay'].'<br>'.formatdate($r['indate']).'</td>'."\n";
			  $db2 = new DB;
			  $db2->query("SELECT * FROM `formremind` WHERE `formType`='".$type."' AND `remindDay`>0 ORDER BY `formID`");
			  for ($i2=0;$i2<$db2->num_rows();$i2++) {
				  $r2 = $db2->fetch_assoc();
				  $db3 = new DB;
				  $db3->query("SELECT `date` FROM `".$r2['formID']."` WHERE `HospNo`='".$r1['HospNo']."' ORDER BY `date` DESC LIMIT 0,1");
				  $r3 = $db3->fetch_assoc();
				  $dateFilled = $r3['date'];
				  $today = date('Ymd');
				  $linktmp = $r2['formLink'];
				  $link = str_replace('{PID}',$r['patientID'],$linktmp);
				  if ($dateFilled!="") {
					  $dateDiff = abs(calcperiod($dateFilled, $today));
					  $dateDiff2 = abs(calcperiod($dateFilled, $indate));
					  if ($r2['remindDay']==3) {
						  echo '<td><span class="rangeL">Filled:<br>'.formatdate($dateFilled).'</span></td>';
					  } elseif ($r2['remindDay']>0 && $dateDiff > $r2['remindDay']) {
						  echo '<td><a href="'.$link.'" target="_blank"><button type="button" class="formRemindBtn">Filled:<br>'.formatdate($dateFilled).'<br>Overtime:<br>'.($dateDiff-$r2['remindDay']).'Day(s)</button></a></td>';
					  } else {
						  echo '<td><span class="rangeL">Filled:<br>'.formatdate($dateFilled).'<br><font class="rangeG">Next time:<br>'.calcdayafterday($dateFilled,$r2['remindDay']).'</font></span></td>';
					  }
				  } else {
					  $dateDiff = abs(calcperiod($indate, $today));
					  if ($r2['remindDay']>0 && $dateDiff > $r2['remindDay']) {
						  echo '<td><a href="'.$link.'" target="_blank"><button type="button" class="formRemindBtn">Unfilled'.'<br>Overtime:<br>'.($dateDiff-$r2['remindDay']).'Day(s)</button></a></td>';
					  } else {
						  echo '<td><a href="'.$link.'" target="_blank"><button type="button" class="formRemindBtn">Unfilled<br><font class="rangeG">Next time:<br>'.calcdayafterday($indate,$r2['remindDay']).'</font></button></a></td>';
					  }
				  }
            }
			echo '</tr>'."\n";
		}
  }
?>
</table>
</div>
</form><br>
</div>
<script>
$(document).ready(function () {
	var table123 = $('#remindlist').DataTable({
		"scrollY": false,
        "scrollX": true,
        "scrollCollapse": false,
        "paging": false,
		"ordering": false,
		"searching": false
	});
	new $.fn.dataTable.FixedColumns( table123, {
		"iLeftColumns": 1,
      	"iRightColumns": 0
	});
})
</script>