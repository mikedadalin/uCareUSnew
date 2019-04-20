<script>
function datefunction(functioname) {
	var date1 = (document.getElementById('printdate1').value).replace("/",""); date1 = date1.replace("/","");
	var date2 = (document.getElementById('printdate2').value).replace("/",""); date2 = date2.replace("/","");
	if (functioname=='print') {
		window.open('print.php?func=form2klist&date1='+date1+'&date2='+date2);
	} else if (functioname=='view') {
		window.location.href='index.php?func=form2klist&date1='+date1+'&date2='+date2;
	}
}
</script>
<div class="nurseform-table" style="background-color: rgba(255,255,255,0.9); border-radius: 10px; padding:15px;">
<h3 style="background-color: rgba(255,255,255,0.8); border-radius: 10px; width: 100%; padding: 13px 0px; letter-spacing:1px;margin-bottom: 20px; color: #69b3b6; font-size: 22px;">&nbsp&nbspPipeline summary list (<?php echo formatdate(@$_GET['date1']); ?> - <?php echo formatdate(@$_GET['date2']); ?>)</h3>
<table <?php  if (strpos($_SERVER['PHP_SELF'],'printreminderlist.php')!==false) { echo 'style="display:none; width:43%; position:absolute; top:4%; right: 1%; margin-bottom:20px;"'; }else{ echo 'style="width:100%; margin-bottom:20px;"'; } ?>>
  <tr>
    <td align="center" class="printcol" style="border-radius:10px; background-color:rgba(0,0,0,0.1);"><form>Select date:<script> $(function() { $( "#printdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate1" id="printdate1" value="<?php if (@$_GET['date1']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date1']); } ?>" size="12"> ~ <script> $(function() { $( "#printdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="printdate2" id="printdate2" value="<?php if (@$_GET['date2']==NULL) { echo date(Y."/".m."/01"); } else { echo formatdate(@$_GET['date2']); } ?>" size="12"> <input type="button" value="Search" onclick="datefunction('view');" /><input type="button" value="Print" onclick="datefunction('print');" /></form></td>
  </tr>
</table>
<table width="100%" id="recordlist">
  <thead>
  <tr class="title">
    <th width="60">Bed location</th>
    <th width="80">Resident</th>
    <th>Pipeline</th>
    <th>Material</th>
    <th>Caliber</th>
    <th>Date of latest replacement</th>
    <th>Replacement period</th>
    <th>Date of next replacement</th>
    <th class="printcol">Function</th>
  </tr>
  </thead>
  <tbody>
    <?php
    if (@$_GET['date1']==NULL) {
		$db2 = new DB;
		$db2->query("SELECT * FROM `nurseform02k` WHERE `Q5`=0 ORDER BY `date` DESC");
	} else {
		$db2 = new DB;
		$db2->query("SELECT * FROM `nurseform02k` WHERE `Q5`=0 AND `date`>='".mysql_escape_string($_GET['date1'])."' AND `date`<='".mysql_escape_string($_GET['date2'])."' ORDER BY `date` DESC");
	}
    for ($i=0;$i<$db2->num_rows();$i++) {
		$r2 = $db2->fetch_assoc();
		$pid = getPID($r2['HospNo']);
//		$db = new DB;
//		$db->query("");
		echo '
	  <tr>
		<td>'.getBedID($pid).'</td>
		<td valign="top">'.getPatientName($pid).'('.getHospNoDisplayByPID($pid).')</td>
		<td>'.$arrForm2k_Q1[$r2['Q1']].'</td>
		<td>'.$arrForm2k_Q2[$r2['Q2']].'</td>
		<td >'.$r2['Q3']; if ($r2['Q3']!="") { echo 'Fr.'; } echo '</td>
    	<td>'.formatdate($r2['date']).'</td>
		<td>'.$r2['Q4'].'</td>
		<td>'.calcdayafterday($r2['date'],$r2['Q4']).'</td>
		<td class="printcol"><form><input type="button" id="Q4_'.$pid.'_'.$r2['date'].'" value="Pipeline management" onclick="go2k(this.id);">';
		echo '</form>
		</td>
	  </tr>
		'."\n";
    }
    ?>
  </tbody>
</table>
</div><br><br>
<script>
$(function(){
	$("#recordlist").dataTable({"paging": false});
});
function go2k(id){
	var postinfo = id.split(/_/);
	window.location.href='index.php?mod=nurseform&func=formview&pid='+postinfo[1]+'&id=2k';
}
</script>
<style>
@media print {
	.fg-toolbar {
		display:none;
	}
}
</style>

