<div align="left">
	<?php
//使用說明 Start
//$manual_table="reminderlist2";
//include("class/useInfo.php");
//使用說明 End
	?>
</div>
<script>
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
	if (functioname=='print') {
		window.open('printreminderlist2.php?id=5&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?func=reminderlist2&date1='+date1+'&date2='+date2;
	}
}
</script>
<div class="nurseform-table" style="background-color: rgba(255,255,255,0.9); border-radius: 10px; padding:10px; margin-bottom:30px;">
	<h3 style="width:100%;">Special reminder list (<?php echo formatdate(@$_GET['date1']); ?> - <?php echo formatdate(@$_GET['date2']); ?>)</h3>
	<table style="width:100%;" <?php  if (strpos($_SERVER['PHP_SELF'],'printreminderlist2.php')!==false) { echo 'style="display:none;"'; } ?>>
		<tr>
			<td align="center"><form><script> $(function() { $( "#printdate1" ).datepicker(); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2" ).datepicker(); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /><!--<input type="button" value="Print" onclick="datefunction('print');" />--></form></td>
		</tr>
	</table>
	<table id="recordlist" style="margin-bottom:10px; width:100%;">
		<thead>
			<tr class="title">
				<td width="100">Date</td>
				<td width="60">Bed location</td>
				<td width="80">Resident</td>
				<td width="180">Special note</td>
				<td width="60">Set up by staff</td>
			</tr>
		</thead>
		<tbody>
			<?php
			if (@$_GET['date1']==NULL) {
				$db2 = new DB;
				$db2->query("SELECT * FROM `reminder2` ORDER BY `remindDate` DESC");
			} else {
				$db2 = new DB;
				$db2->query("SELECT * FROM `reminder2` WHERE `remindDate`>='".mysql_escape_string(formatdate(@$_GET['date1']))."' AND `remindDate`<='".mysql_escape_string(formatdate(@$_GET['date2']))."' ORDER BY `remindDate` DESC");
			}
			for ($i=0;$i<$db2->num_rows();$i++) {
				$r2 = $db2->fetch_assoc();
				$pid = getPID($r2['HospNo']);
				$db2a = new DB;
				$db2a->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
				$r2a = $db2a->fetch_assoc();
				echo '
				<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2a['instat']==0?' style="display:none;"':'').'>
				<td valign="top" style="color:#585858; text-align:center; vertical-align:middle;">'.$r2['remindDate'].'</td>
				<td valign="top" style="color:#585858; text-align:center; vertical-align:middle;">'.getBedID($pid).'</td>
				<td valign="top" style="color:#585858; text-align:center; vertical-align:middle;">'.getPatientName($pid).'</td>
				<td valign="top" style="color:#585858; padding-left:10px; vertical-align:middle;">'.$r2['remindContent'].'</td>
				<td valign="top" style="color:#585858; text-align:center; vertical-align:middle;">'.checkusername($r2['Qfiller']).'</td>
				</tr>'."\n";
			}
			?>
		</tbody>
	</table>
</div>