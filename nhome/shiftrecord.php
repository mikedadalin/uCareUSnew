<script>
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
	//window.location.href='print.php?mod=nurseform&func=formview&pid=<?php //echo @$_GET['pid']; ?>&id=5&date1='+date1+'&date2='+date2;
	if (functioname=='print') {
		window.open('print.php?func=shiftrecord&date1='+date1+'&date2='+date2);
	} else if (functioname=='printnew') {
		var startprint = prompt("請輸入起始列印行數，如果是列印在新的紙張上，填0即可","0");
		window.open('printnurserecord.php?id=5&date1='+date1+'&date2='+date2+'&startprint='+startprint);
	} else if (functioname=='view') {
		window.location.href='index.php?func=shiftrecord&date1='+date1+'&date2='+date2;
	}
}
</script>
<div class="nurseform-table" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom:30px;">
<h3>Nursing record (<?php echo formatdate(@$_GET['date1']); ?> - <?php echo formatdate(@$_GET['date2']); ?>)</h3>
<div <?php  if (strpos($_SERVER['PHP_SELF'],'print.php')!==false) { echo 'style="display:none;"'; } ?>>
    <form style="margin-bottom:5px;"><script> $(function() { $( "#printdate1" ).datepicker(); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2" ).datepicker(); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="Print" onclick="datefunction('print');" /><!--<input type="button" value="Print new (新版)" onclick="datefunction('printnew');" />--></form>
</div>
<table cellpadding="5" style="margin-bottom:10px; width:100%; table-layout:fixed;">
  <thead>
  <tr class="title">
    <td style="width:9%">Date and Time</td>
    <td style="width:7%">Bed Location</td>
    <td style="width:10%">Resident</td>
    <td style="width:20%">Focus Problem</td>
    <td>Record Content</td>
    <td style="width:10%">Staff</td>
  </tr>
  </thead>
  <tbody>
    <?php
	$db1 = new DB;
	$db1->query("SELECT `patientID` FROM `inpatientinfo` ORDER by `bed` ASC");
	for ($i0=0;$i0<$db1->num_rows();$i0++) {
		$r0 = $db1->fetch_assoc();
		$HospNo = getHospNo($r0['patientID']);
		if (@$_GET['date1']==NULL) {
			$db2 = new DB;
			$db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' ORDER BY `date` ASC");
		} else {
			$db2 = new DB;
			$db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".mysql_escape_string($_GET['date1'])."' AND `date`<='".mysql_escape_string($_GET['date2'])."' ORDER BY `date` ASC");
		}
		for ($i=0;$i<$db2->num_rows();$i++) {
			$r2 = $db2->fetch_assoc();
			$pid = getPID($r2['HospNo']);
			$db2a = new DB;
			$db2a->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
			$r2a = $db2a->fetch_assoc();
			echo '
		  <tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2a['instat']==0?' style="display:none;"':'').'>
			<td style="text-align:center; vertical-align:middle;">'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).'</td>
			<td style="text-align:center; vertical-align:middle;">'.getBedID($pid).'</td>
			<td style="text-align:center; vertical-align:middle;">'.getPatientName($pid).'</td>
			<td style="vertical-align:middle;">'; if ($r2['Q2']!="") { echo $r2['Q2']; } else { echo '&nbsp;'; } echo '</td>
			<td style="vertical-align:middle;">'.$r2['Qcontent'].'</td>
			<td style="text-align:center; vertical-align:middle;">';
			$db_filler = new DB2;
			$db_filler->query("SELECT `name` FROM `userinfo` WHERE `userID`='".$r2['Qfiller']."' AND `orgID`='".$_SESSION['nOrgID_lwj']."'");
			$r_filler = $db_filler->fetch_assoc();
			echo $r_filler['name'];
			echo '</td>
		  </tr>';
		}
	}
    ?>
  </tbody>
</table>
</div>