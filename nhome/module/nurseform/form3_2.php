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
		document.getElementById('Name_'+tab).value = medList2[0]+medList2[1]+medList2[2]+medList2[3];
		if (tab=="tab1") { if (medList2[4]!="0") { document.getElementById('indate').value = medList2[4].substr(0,4) + '/' + medList2[4].substr(4,2) + '/' + medList2[4].substr(6,2); } else { document.getElementById('indate').value =''; } }
		if (tab=="tab3") {
			document.getElementById('Gender_tab3').value = medList2[5];
			document.getElementById('Age_tab3').value = medList2[6];
			document.getElementById('Diag_tab3').value = medList2[7];
			document.getElementById('ADLtotal_tab3').value = medList2[8];
		}
	});
	return medList;
}
</script>
<h3>Restraint record</h3>
<table width="100%" bgcolor="#ffffff">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <div id="tab2">
	<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
    <form><input type="button" value="Add restraint record" id="newrecord2" onclick="openVerificationForm('#dialog-form2');" /></form>
	<?php }?>
<script>
$(function() {
    $( "#dialog-form2" ).dialog({
		autoOpen: <?php echo ($_GET['autoOpen']==''?'false':$_GET['autoOpen']); ?>,
		height: 660,
		width: 820,
		modal: true,
		buttons: {
			"Add record": function() {
				$.ajax({
					url: "class/sixtarget_part2.php",
					type: "POST",
					data: {'HospNo': $('#HospNo_tab2').val(), 'Name': $('#Name_tab2').val(),
					'startdate': $('#part2_startdate').val(), 
					'reason1': $('#part2_reason_1').val(), 
					'reason2': $('#part2_reason_2').val(), 
					'reason3': $('#part2_reason_3').val(), 
					'reason4': $('#part2_reason_4').val(), 
					'reason5': $('#part2_reason_5').val(), 
					'reason6': $('#part2_reason_6').val(), 
					'reasonother': $('#part2_reasonother').val(), 
					'equipment1': $('#part2_equipment_1').val(), 
					'equipment2': $('#part2_equipment_2').val(), 
					'equipment3': $('#part2_equipment_3').val(), 
					'equipment4': $('#part2_equipment_4').val(), 
					'equipment5': $('#part2_equipment_5').val(), 
					'equipment6': $('#part2_equipment_6').val(), 
					'equipmentother': $('#part2_equipmentother').val(), 
					'UseInBed11': $('#part2_UseInBed1_1').val(),
					'UseInBed12': $('#part2_UseInBed1_2').val(),
					'UseInBed13': $('#part2_UseInBed1_3').val(),
					'UseInBed21': $('#part2_UseInBed2_1').val(),
					'UseInBed22': $('#part2_UseInBed2_2').val(),
					'UseInBed23': $('#part2_UseInBed2_3').val(),
					'UseInBed31': $('#part2_UseInBed3_1').val(),
					'UseInBed32': $('#part2_UseInBed3_2').val(),
					'UseInBed33': $('#part2_UseInBed3_3').val(),
					'UseInBed41': $('#part2_UseInBed4_1').val(),
					'UseInBed42': $('#part2_UseInBed4_2').val(),
					'UseInBed43': $('#part2_UseInBed4_3').val(),
					'UseInChair11': $('#part2_UseInChair1_1').val(),
					'UseInChair12': $('#part2_UseInChair1_2').val(),
					'UseInChair13': $('#part2_UseInChair1_3').val(),
					'UseInChair21': $('#part2_UseInChair2_1').val(),
					'UseInChair22': $('#part2_UseInChair2_2').val(),
					'UseInChair23': $('#part2_UseInChair2_3').val(),
					'UseInChair31': $('#part2_UseInChair3_1').val(),
					'UseInChair32': $('#part2_UseInChair3_2').val(),
					'UseInChair33': $('#part2_UseInChair3_3').val(),
					'UseInChair41': $('#part2_UseInChair4_1').val(),
					'UseInChair42': $('#part2_UseInChair4_2').val(),
					'UseInChair43': $('#part2_UseInChair4_3').val(),
					'bodypart1': $('#part2_bodypart_1').val(), 
					'bodypart2': $('#part2_bodypart_2').val(), 
					'bodypart3': $('#part2_bodypart_3').val(), 
					'bodypart4': $('#part2_bodypart_4').val(), 
					'bodypart5': $('#part2_bodypart_5').val(), 
					'bodypart6': $('#part2_bodypart_6').val(), 
					'bodypartother': $('#part2_bodypartother').val(), 
					'releasedate': $('#part2_releasedate').val(), 
					'releasereason1': $('#part2_releasereason_1').val(), 
					'releasereason2': $('#part2_releasereason_2').val(), 
					'releasereason3': $('#part2_releasereason_3').val(), 
					'releasereason4': $('#part2_releasereason_4').val(), 
					'releasereason5': $('#part2_releasereason_5').val(), 
					'releasereasonother': $('#part2_releasereasonother').val(), 
					'Qfiller': $('#Qfiller').val(), "transform": "1" },
					success: function(data) {
						$( "#dialog-form2" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form2" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form2" title="Add restraint record" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td colspan="2"><input type="text" size="8" value="<?php echo getHospNoDisplayByPID($_GET['pid']); ?>" readonly><input type="hidden" name="HospNo" id="HospNo_tab2" value="<?php echo $HospNo; ?>"> Full name <input type="text" name="Name" id="Name_tab2" readonly  size="16"></td>
      </tr>
      <tr>
      <td class="title">Restraint date</td>
      <td colspan="2"><script> $(function() { $( "#part2_startdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part2_startdate" id="part2_startdate" value="<?php echo date(Y."/".m."/".d); ?>"></td>
    </tr>
      <tr>
        <td class="title">Restraint reason</td>
        <td colspan="2"><?php echo draw_option("part2_reason","Fall prevent;Pipeline Protect;Self-injury prevent;Behavioral disorders;Assist treatment;Other","xl","single",$part2_reason,true,3); ?> <input type="text" name="part2_reasonother" id="part2_reasonother" size="15"></td>
      </tr>
      <tr>
        <td class="title">Restraint equipment</td>
        <td colspan="2"><?php echo draw_option("part2_equipment","Restraint strap;T-shape restraint strap;Magnetic clasp(s);Glove(s);Special dinner plate(s);Other","xl","multi",$part2_equipment,true,3); ?> <input type="text" name="part2_equipmentother" id="part2_equipmentother" size="15"></td>
      </tr>
      <tr>
        <td rowspan="4" class="title">Used in Bed</td>
        <td class="title_s">Bed rail</td>
		<td><?php echo draw_option("part2_UseInBed1","Not used;Used less than daily;Used daily","l","single",$part2_UseInBed1,false,0); ?></td>
      </tr>
	  <tr>
	    <td class="title_s">Trunk restraint</td>
		<td><?php echo draw_option("part2_UseInBed2","Not used;Used less than daily;Used daily","l","single",$part2_UseInBed2,false,0); ?></td>
	  </tr>
	  <tr>
	    <td class="title_s">Limb restraint</td>
		<td><?php echo draw_option("part2_UseInBed3","Not used;Used less than daily;Used daily","l","single",$part2_UseInBed3,false,0); ?></td>
	  </tr>
	  <tr>
	    <td class="title_s">Other</td>
		<td><?php echo draw_option("part2_UseInBed4","Not used;Used less than daily;Used daily","l","single",$part2_UseInBed4,false,0); ?></td>
	  </tr>
      <tr>
        <td rowspan="4" class="title">Used in Chair <br>or Out of Bed</td>
        <td class="title_s">Trunk restraint</td>
		<td><?php echo draw_option("part2_UseInChair1","Not used;Used less than daily;Used daily","l","single",$part2_UseInChair1,false,0); ?></td>
      </tr>
	  <tr>
	    <td class="title_s">Limb restraint</td>
		<td><?php echo draw_option("part2_UseInChair2","Not used;Used less than daily;Used daily","l","single",$part2_UseInChair2,false,0); ?></td>
	  </tr>
	  <tr>
	    <td class="title_s">Chair prevents rising</td>
		<td><?php echo draw_option("part2_UseInChair3","Not used;Used less than daily;Used daily","l","single",$part2_UseInChair3,false,0); ?></td>
	  </tr>
	  <tr>
	    <td class="title_s">Other</td>
		<td><?php echo draw_option("part2_UseInChair4","Not used;Used less than daily;Used daily","l","single",$part2_UseInChair4,false,0); ?></td>
	  </tr>
      <tr>
        <td class="title">Restraint part(s)</td>
        <td colspan="2"><?php echo draw_option("part2_bodypart","Waist;Ankle(s);Wrist(s);Knee(s);Torso;Other","m","multi",$part2_bodypart,false,3); ?> <input type="text" name="part2_bodypartother" id="part2_bodypartother" size="15"></td>
      </tr>
      <tr>
        <td class="title">Relieve date</td>
        <td colspan="2"><script> $(function() { $( "#part2_releasedate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part2_releasedate" id="part2_releasedate" value=""></td>
      </tr>
      <tr>
        <td class="title">Relieve reason</td>
        <td colspan="2"><?php echo draw_option("part2_releasereason","Cognitive Improvement;Emotion stabilized;Deterioration;Death;Other","xl","single",$part2_releasereason,true,3); ?> <input type="text" name="part2_releasereasonother" id="part2_releasereasonother" size="15"></td>
      </tr>
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </table>
  </fieldset>
  </form>
</div>
    <div id="tab2_part1">
    <table class="content-query" style="font-size:8pt; font-weight:normal;">
      <tr class="title">
      <td class="printcol">View</td>
      <td>Care ID#</td>
      <td>Full name</td>
      <td>Restraint date</td>
      <td>Restraint reason</td>
      <td>Restraint equipment</td>
      <td>Restraint part(s)</td>
      <td>Relieve date</td>
      <td>Relieve reason</td>
      <td class="printcol">Print</td>
      </tr>
    <?php
	$dbp1_2 = new DB;
	$dbp1_2->query("SELECT * FROM  `sixtarget_part2` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_2->num_rows()==0) {
	?>
      <tr>
        <td colspan="10"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i1=0;$p1_i1<$dbp1_2->num_rows();$p1_i1++) {
		$rp1_2 =$dbp1_2->fetch_assoc();
	/*== 解 START ==*/
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$rp1_2['Name']);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $rp1_2['Name'] = $rp1_2['Name'].$prdpart;
            }
	    }else{
		   $rp1_2['Name'] = $rsa->privDecrypt($rp1_2['Name']);
	    }
	/*== 解 END ==*/
		$reason = '';
		if ($rp1_2['reason1']==1) { $reason .= 'Fall prevent'; }
		if ($rp1_2['reason2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Pipeline Protect'; }
		if ($rp1_2['reason3']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Self-injury prevent'; }
		if ($rp1_2['reason4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Behavioral disorders'; }
		if ($rp1_2['reason5']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Assist treatment'; }
		if ($rp1_2['reason6']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$rp1_2['reasonother']; }
		$equipment = '';
		if ($rp1_2['equipment1']==1) { $equipment .= 'Restraint strap'; }
		if ($rp1_2['equipment2']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'T-shape restraint strap'; }
		if ($rp1_2['equipment3']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Magnetic clasp(s)'; }
		if ($rp1_2['equipment4']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Glove(s)'; }
		if ($rp1_2['equipment5']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Special dinner plate(s)'; }
		if ($rp1_2['equipment6']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Other(s):'.$rp1_2['equipmentother']; }
		$bodypart = '';
		if ($rp1_2['bodypart1']==1) { $bodypart .= 'Waist'; }
		if ($rp1_2['bodypart2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
		if ($rp1_2['bodypart3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
		if ($rp1_2['bodypart4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
		if ($rp1_2['bodypart5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
		if ($rp1_2['bodypart6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$rp1_2['bodypartother']; }
		if ($rp1_2['releasedate']=='') { $releasedate = '---'; } else { $releasedate = $rp1_2['releasedate']; }
		$releasereason = '';
		if ($rp1_2['releasereason1']==1) { $releasereason .= 'Cognitive Improvement'; }
		if ($rp1_2['releasereason2']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Emotion stabilized'; }
		if ($rp1_2['releasereason3']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Deterioration'; }
		if ($rp1_2['releasereason4']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Death'; }
		if ($rp1_2['releasereason5']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Other(s):'.$rp1_2['releasereasonother']; }
	?>
      <tr>
        <td class="printcol"><center><a href="index.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_2&tID=<?php echo $rp1_2['targetID']; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
        <td><center><?php echo getHospNoDisplayByPID(@$_GET['pid']); ?></center></td>
        <td><center><?php echo $rp1_2['Name']; ?></center></td>
        <td><center><?php echo $rp1_2['startdate']; ?></center></td>
        <td><center><?php echo $reason; ?></center></td>
        <td><center><?php echo $equipment; ?></center></td>
        <td><center><?php echo $bodypart; ?></center></td>
        <td><center><?php echo $rp1_2['releasedate']; ?></center></td>
        <td><center><?php echo $releasereason; ?></center></td>
        <td class="printcol"><center><a href="print.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_2&tID=<?php echo $rp1_2['targetID']; ?>" target="_blank"><img src="Images/print.png" /></a></center></td>
      </tr>
    <?php
	}
	}
	?>
    </table>
    </div>
    </td>
  </tr>
</table><br><br>
<script>
$(document).ready( function () {
	$('#HospNo_tab2').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab2');
});
</script>