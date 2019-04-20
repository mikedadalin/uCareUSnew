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
<h3>Fall record</h3>
<table width="100%" bgcolor="#ffffff">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <div id="tab3">
    <form><input type="button" value="Add fall record" id="newrecord3" onclick="openVerificationForm('#dialog-form3');" /></form>
<script>
$(function() {
    $( "#dialog-form3" ).dialog({
		autoOpen: <?php echo ($_GET['autoOpen']==''?'false':$_GET['autoOpen']); ?>,
		height: 680,
		width: 900,
		modal: true,
		buttons: {
			"Add record": function() {
			    //document.getElementById('Qcontent').value = document.getElementById('QcontentHTML').innerHTML;
				$.ajax({
					url: "class/sixtarget_part3.php",
					type: "POST",
					data: { 'HospNo': $('#HospNo_tab3').val(), 'Name': $('#Name_tab3').val(), 'Gender': $('#Gender_tab3').val(), 'Age': $('#Age_tab3').val(), 'Diag': $('#Diag_tab3').val(), 'ADLtotal': $('#ADLtotal_tab3').val(), 'date': $('#part3_date').val(), 'time': $('#part3_time').val(), 'location_1': $('#part3_location_1').val(), 'location_2': $('#part3_location_2').val(), 'location_3': $('#part3_location_3').val(), 'location_4': $('#part3_location_4').val(), 'location_5': $('#part3_location_5').val(), 'location_6': $('#part3_location_6').val(), 'locationother': $('#part3_locationother').val(), 'movement_1': $('#part3_movement_1').val(), 'movement_2': $('#part3_movement_2').val(), 'movement_3': $('#part3_movement_3').val(), 'movement_4': $('#part3_movement_4').val(), 'movement_5': $('#part3_movement_5').val(), 'movement_6': $('#part3_movement_6').val(), 'movement_7': $('#part3_movement_7').val(), 'movementother': $('#part3_movementother').val(), 'reason_1': $('#part3_reason_1').val(), 'reason_2': $('#part3_reason_2').val(), 'reason_3': $('#part3_reason_3').val(), 'reason_4': $('#part3_reason_4').val(), 'reasonother': $('#part3_reasonother').val(), 'object_1': $('#part3_object_1').val(), 'object_2': $('#part3_object_2').val(), 'object_3': $('#part3_object_3').val(), 'object_4': $('#part3_object_4').val(), 'object_5': $('#part3_object_5').val(), 'med_1': $('#part3_med_1').val(), 'med_2': $('#part3_med_2').val(), 'med_3': $('#part3_med_3').val(), 'med_4': $('#part3_med_4').val(), 'med_5': $('#part3_med_5').val(), 'med_6': $('#part3_med_6').val(), 'med_7': $('#part3_med_7').val(), 'med_8': $('#part3_med_8').val(), 'injurlv_1': $('#part3_injurlv_1').val(), 'injurlv_2': $('#part3_injurlv_2').val(), 'injurlv_3': $('#part3_injurlv_3').val(), 'injurlv_4': $('#part3_injurlv_4').val(), 'Fracture_1': $('#part3_Fracture_1').val(), 'Fracture_2': $('#part3_Fracture_2').val(), 'Fracture_3': $('#part3_Fracture_3').val(), 'bodypart_1': $('#part3_bodypart_1').val(), 'bodypart_2': $('#part3_bodypart_2').val(), 'bodypart_3': $('#part3_bodypart_3').val(), 'bodypart_4': $('#part3_bodypart_4').val(), 'bodypart_5': $('#part3_bodypart_5').val(), 'bodypart_6': $('#part3_bodypart_6').val(), 'bodypartother': $('#part3_bodypartother').val(), 'description': $('#part3_description').val(), 'Qfiller': $('#Qfiller').val(), "transform": "1" },
					success: function(data) {
						$( "#dialog-form3" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form3" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form3" title="Add fall record" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td><input type="text" size="8" value="<?php echo getHospNoDisplayByPID($_GET['pid']); ?>" readonly><input type="hidden" name="HospNo" id="HospNo_tab3" value="<?php echo $HospNo; ?>">
        <td class="title">Full name</td>
        <td><input type="text" name="Name" id="Name_tab3" readonly  size="16"></td>
      </tr>
      <tr>
        <td class="title">Gender</td>
        <td><input type="text" name="Gender" id="Gender_tab3" value="" size="8">
        <td class="title">Age</td>
        <td><input type="text" name="Age" id="Age_tab3" size="8"></td>
      </tr>
      <tr>
        <td class="title">Major diagnosis</td>
        <td><input type="text" name="Diag" id="Diag_tab3" value="" size="30" >
        <td class="title">ADL score</td>
        <td><input type="text" name="ADLtotal" id="ADLtotal_tab3"  size="8"></td>
      </tr>
      <tr>
        <td class="title">Date</td>
        <td><script> $(function() { $( "#part3_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="part3_date" id="part3_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
        <td class="title">Time</td>
        <td><input type="text" name="part3_time" id="part3_time" value="<?php echo date(Hi); ?>"></td>
      </tr>
      <tr>
        <td class="title">Location</td>
        <td colspan="3"><?php echo draw_option("part3_location","Room;Bedside;Bathroom;Activity area;Walkway;Other","xm","single",$part3_location,true,3); ?> <input type="text" name="part3_locationother" id="part3_locationother" size="12"></td>
      </tr>
      <tr>
        <td class="title">Scenarios</td>
        <td colspan="3"><?php echo draw_option("part3_movement","Toileting;In/out bed;During activity;Slip(wheelchair);Stand up(wheelchair);Across(Bed rails);Other","xl","single",$part3_movement,true,3); ?> <input type="text" name="part3_movementother" id="part3_movementother" size="12"></td>
      </tr>
      <tr>
        <td class="title">Reason</td>
        <td colspan="3"><?php echo draw_option("part3_reason","Resident's health;Treatment/Medication;Environmental risk;Other","xl","multi",$part3_reason,true,2); ?> <input type="text" name="part3_reasonother" id="part3_reasonother" size="12"></td>
      </tr>
      <tr>
        <td class="title">Restraints</td>
        <td colspan="3"><?php echo draw_option("part3_object","Bed rails(2);Bed rail(1);Waist restraint straps;Posey vest;No restraint","xl","multi",$part3_object,true,3); ?></td>
      </tr>
      <tr>
        <td class="title">Medication</td>
        <td colspan="3"><?php echo draw_option("part3_med","Antihistamine;Antihypertensive;Sedative-hypnotic;Muscle relaxants;Laxative;Diuretics;Antidepressant;Hypoglycemic","l","multi",$part3_med,true,4); ?></td>
      </tr>
      <tr>
        <td class="title">Body part</td>
        <td colspan="3"><?php echo draw_option("part3_bodypart","Waist;Ankle(s);Wrist(s);Knee(s);Torso;Other","m","multi",$part3_bodypart,false,3); ?> <input type="text" name="part3_bodypartother" id="part3_bodypartother" size="10"></td>
      </tr>
      <tr>
        <td class="title">Injury severity</td>
        <td colspan="3">
		<?php echo draw_option("part3_injurlv","None;Level1;Level2;Level3","m","multi",$part3_injurlv,false,6); ?>
        <div style="font-size:10pt;">
        <b>Level1:</b> Refers to the degree of injury does not require treatment or just a bit of treatment and observation, such as abrasions, contusions, small lacerations that do not need suturing.<br>
        <b>Level2:</b> Refers to the need ice, bandaging, suturing kind of care treatment. Such as sprains, large or deep lacerations.<br>
        <b>Level3:</b> Refers to the servirity that require medical attention. Such as fractures, loss of consciousness, change of mental or physical state. Injury seriously affect resident's treatment and prolong hospital stay.</div>
        </td>
      </tr>
	  <tr>
        <td class="title">Fracture</td>
        <td colspan="3"><?php echo draw_option("part3_Fracture","No;Yes;Unable to determine","xl","single",$part3_Fracture,false,3); ?></td>
      </tr>
      <tr>
        <td class="title">Status description</td>
        <td colspan="3"><textarea name="part3_description" id="part3_description" rows="6"></textarea></td>
      </tr>
      <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </table>
  </fieldset>
  </form>  
</div>
    <div id="tab3_part1">
    <table class="content-query" style="font-size:8pt; font-weight:normal;">
      <tr class="title">
        <td rowspan="2" class="printcol">View</td>
        <td colspan="6">Profile</td>
        <td colspan="7">Characteristic analysis of falls</td>
        <td colspan="3">Physical injury</td>
        <td rowspan="2" class="printcol">Print</td>
      </tr>
      <tr class="title">
        <td>Care ID#</td>
        <td>Full name</td>
        <td>Gender</td>
        <td>Age</td>
        <td>Major diagnosis</td>
        <td>ADL<br />Score</td>
        <td>Date</td>
        <td>Time</td>
        <td>Location</td>
        <td>Scenarios</td>
        <td>Reason</td>
        <td>Restraints</td>
        <td>Medication</td>
        <td>Injury<br />level</td>
        <td>Body part</td>
        <td>Status description</td>
      </tr>
    <?php
	$dbp1_3 = new DB;
	$dbp1_3->query("SELECT * FROM  `sixtarget_part3` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	if ($dbp1_3->num_rows()==0) {
	?>
      <tr>
        <td colspan="18"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
	} else {
	for ($p1_i1=0;$p1_i1<$dbp1_3->num_rows();$p1_i1++) {
		$rp1_3 =$dbp1_3->fetch_assoc();
	/*== 解 START ==*/
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$rp1_3['Name']);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $rp1_3['Name'] = $rp1_3['Name'].$prdpart;
            }
	    }else{
		   $rp1_3['Name'] = $rsa->privDecrypt($rp1_3['Name']);
	    }
	/*== 解 END ==*/
		$location = '';
		if ($rp1_3['location_1']==1) { $location .= 'Room'; }
		if ($rp1_3['location_2']==1) { if ($location!='') { $location.='、'; } $location .= 'Bedside'; }
		if ($rp1_3['location_3']==1) { if ($location!='') { $location.='、'; } $location .= 'Bathroom'; }
		if ($rp1_3['location_4']==1) { if ($location!='') { $location.='、'; } $location .= 'Activity area'; }
		if ($rp1_3['location_5']==1) { if ($location!='') { $location.='、'; } $location .= 'Walkway'; }
		if ($rp1_3['location_6']==1) { if ($location!='') { $location.='、'; } $location .= 'Other(s):'.$rp1_3['locationother']; }
		$movement = '';
		if ($rp1_3['movement_1']==1) { $movement .= '	Toileting'; }
		if ($rp1_3['movement_2']==1) { if ($movement!='') { $movement.='、'; } $movement .= '上下床活動當中'; }
		if ($rp1_3['movement_3']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Slip(wheelchair)'; }
		if ($rp1_3['movement_4']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Stand up(wheelchair)'; }
		if ($rp1_3['movement_5']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Across(Bed rails)'; }
		if ($rp1_3['movement_6']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Other(s):'.$rp1_3['movementother']; }
		$reason = '';
		if ($rp1_3['reason_1']==1) { $reason .= 'Resident health'; }
		if ($rp1_3['reason_2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Treatment/Medication'; }
		if ($rp1_3['reason_3']==1) { if ($reason!='') { $reason.='、'; } $reason .= '環境中危險因子'; }
		if ($rp1_3['reason_4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$rp1_3['reasonother']; }
		$object = '';
		if ($rp1_3['object_1']==1) { $object .= 'Bed rails(2)'; }
		if ($rp1_3['object_2']==1) { if ($object!='') { $object.='、'; } $object .= 'Bed rail(1)'; }
		if ($rp1_3['object_3']==1) { if ($object!='') { $object.='、'; } $object .= 'Waist restraint straps'; }
		if ($rp1_3['object_4']==1) { if ($object!='') { $object.='、'; } $object .= 'Posey vest'; }
		if ($rp1_3['object_5']==1) { if ($object!='') { $object.='、'; } $object .= 'No restraint'; }
		$med = '';
		if ($rp1_3['med_1']==1) { $med .= 'Antihistamine'; }
		if ($rp1_3['med_2']==1) { if ($med!='') { $med.='、'; } $med .= 'Antihypertensive'; }
		if ($rp1_3['med_3']==1) { if ($med!='') { $med.='、'; } $med .= 'Sedative-hypnotic'; }
		if ($rp1_3['med_4']==1) { if ($med!='') { $med.='、'; } $med .= 'Muscle relaxants'; }
		if ($rp1_3['med_5']==1) { if ($med!='') { $med.='、'; } $med .= 'Laxative'; }
		if ($rp1_3['med_6']==1) { if ($med!='') { $med.='、'; } $med .= 'Diuretics'; }
		if ($rp1_3['med_7']==1) { if ($med!='') { $med.='、'; } $med .= 'Antidepressant'; }
		if ($rp1_3['med_8']==1) { if ($med!='') { $med.='、'; } $med .= 'Hypoglycemic'; }
		$injurlv = '';
		if ($rp1_3['injurlv_1']==1) { $injurlv .= 'None'; }
		if ($rp1_3['injurlv_2']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level1'; }
		if ($rp1_3['injurlv_3']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level2'; }
		if ($rp1_3['injurlv_4']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level3'; }
		$bodypart = '';
		if ($rp1_3['bodypart_1']==1) { $bodypart .= 'Waist'; }
		if ($rp1_3['bodypart_2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
		if ($rp1_3['bodypart_3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
		if ($rp1_3['bodypart_4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
		if ($rp1_3['bodypart_5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
		if ($rp1_3['bodypart_6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$rp1_3['bodypartother']; }
	?>
      <tr>
        <td class="printcol"><center><a href="index.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_3&tID=<?php echo $rp1_3['targetID']; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
        <td><?php echo getHospNoDisplayByPID(@$_GET['pid']); ?></td>
        <td><?php echo $rp1_3['Name']; ?></td>
        <td><?php echo $rp1_3['Gender']; ?></td>
        <td><?php echo $rp1_3['Age']; ?></td>
        <td><?php echo $rp1_3['Diag']; ?></td>
        <td><?php echo $rp1_3['ADLtotal']; ?></td>
        <td><?php echo $rp1_3['date']; ?></td>
        <td><?php echo substr($rp1_3['time'],0,2).":".substr($rp1_3['time'],2,2); ?></td>
        <td><?php echo $location; ?></td>
        <td><?php echo $movement; ?></td>
        <td><?php echo $reason; ?></td>
        <td><?php echo $object; ?></td>
        <td><?php echo $med; ?></td>
        <td><?php echo $injurlv; ?></td>
        <td><?php echo $bodypart; ?></td>
        <td><?php echo $rp1_3['description']; ?></td>
        <td class="printcol"><center><a href="print.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_3&tID=<?php echo $rp1_3['targetID']; ?>" target="_blank"><img src="Images/print.png" /></a></center></td>
      </tr>
    <?php
	}
	}
	?>
    </table>
    </div>
    </td>
  </tr>
</table>
<br><br>
<script>
$(document).ready( function () {
	//$('#HospNo_tab3').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab3');
});
</script>