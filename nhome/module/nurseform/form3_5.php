<script>
function loadPatInfo(tab){
	var HospNo= $("#HospNo_"+tab).val();
	$.ajax({
		url: 'class/patinfo.php',
		type: "POST",
		async: false,
		data: { med: HospNo }
	}).done(function(meds){
		medList2 = meds.split(',');
		document.getElementById('Name_'+tab).value = medList2[0];
		if (tab=="tab1") { if (medList2[1]!="0") { document.getElementById('indate').value = medList2[1].substr(0,4) + '/' + medList2[1].substr(4,2) + '/' + medList2[1].substr(6,2); } else { document.getElementById('indate').value =''; } }
		if (tab=="tab3") {
			document.getElementById('Gender_tab3').value = medList2[2];
			document.getElementById('Age_tab3').value = medList2[3];
			document.getElementById('Diag_tab3').value = medList2[4];
			document.getElementById('ADLtotal_tab3').value = medList2[5];
		}
	});
	return medList;
}
</script>
<h3>壓瘡紀錄</h3>
<table width="100%" bgcolor="#ffffff">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <div id="tab5">
    <form><input type="button" value="壓瘡情況登錄" id="newrecord5" onclick="openVerificationForm('#dialog-form5');" /></form>
<script>
$(function() {
    $( "#dialog-form5" ).dialog({
		autoOpen: <?php echo ($_GET['autoOpen']==''?'false':$_GET['autoOpen']); ?>,
		height: 340,
		width: 780,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/sixtarget_part5.php",
					type: "POST",
					data: {'HospNo': $('#HospNo_tab5').val(), 'Name': $('#Name_tab5').val(), 'startdate': $('#part5_startdate').val(), 'enddate': $('#part5_enddate').val(), 'level1': $('#part5_level_1').val(), 'level2': $('#part5_level_2').val(), 'level3': $('#part5_level_3').val(), 'level4': $('#part5_level_4').val(), 'Qfiller': $('#Qfiller').val(), "transform": "1" },
					success: function(data) {
						$( "#dialog-form5" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form5" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form5" title="壓瘡情況登錄" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td colspan="3"><input type="text" size="8" value="<?php echo getHospNoDisplayByPID($_GET['pid']); ?>" readonly><input type="hidden" name="HospNo" id="HospNo_tab5" value="<?php echo $HospNo; ?>"> Full name <input type="text" name="Name" id="Name_tab5" readonly  size="8"></td>
      </tr>
      <tr>
        <td class="title">壓瘡發生日期</td>
        <td><script> $(function() { $( "#part5_startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part5_startdate" id="part5_startdate" value="<?php echo date(Y."/".m."/".d); ?>"></td>
        <td class="title">Healed date</td>
        <td><script> $(function() { $( "#part5_enddate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part5_enddate" id="part5_enddate" value=""><input type="button" onclick="document.getElementById('part5_enddate').value='<?php echo date(Y."/".m."/".d); ?>'" value="Today" /></td>
      </tr>
      <tr>
        <td class="title">Pressure ulcer(s) stage</td>
        <td colspan="3"><?php echo draw_option("part5_level","一級;二級;三級;四級","m","single",$part5_level,false,3); ?></td>
      </tr>
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </table>
  </fieldset>
  </form>
</div>
    <div id="tab5_part1">
    <table class="content-query" style="font-size:8pt; font-weight:normal;">
      <tr class="title">
        <td>Care ID#</td>
        <td>Full name</td>
        <td>發生日期</td>
        <td>Healed date</td>
        <td>Pressure ulcer(s) stage</td>
      </tr>
    <?php
	$dbp1_5 = new DB;
	$dbp1_5->query("SELECT * FROM  `sixtarget_part5` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_5->num_rows()==0) {
	?>
      <tr>
        <td colspan="8"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i5=0;$p1_i5<$dbp1_5->num_rows();$p1_i5++) {
		$rp1_5 =$dbp1_5->fetch_assoc();
		$level = '';
		if ($rp1_5['level1']==1) { $level .= '一級'; }
		if ($rp1_5['level2']==1) { if ($level!='') { $level.='、'; } $level .= '二級'; }
		if ($rp1_5['level3']==1) { if ($level!='') { $level.='、'; } $level .= '三級'; }
		if ($rp1_5['level4']==1) { if ($level!='') { $level.='、'; } $level .= '四級'; }
	?>
      <tr>
        <td><?php echo getHospNoDisplayByPID(@$_GET['pid']); ?></td>
        <td><?php echo $rp1_5['Name']; ?></td>
        <td><?php echo $rp1_5['startdate']; ?></td>
        <td><?php echo $rp1_5['enddate']; ?></td>
        <td><?php echo $level; ?></td>
      </tr>
    <?php
	}
	}
	?>
    </table>
    </div>
    </div>
    </td>
  </tr>
</table>
<script>
$(document).ready( function () {
	//$('#HospNo_tab5').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab5');
});
</script>