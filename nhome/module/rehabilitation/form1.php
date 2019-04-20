<script>
function loadPatInfo(HospNo){
	//var HospNo= $("#HospNo").val();
	$.ajax({
		url: 'class/patinfo.php',
		type: "POST",
		async: false,
		data: { med: HospNo }
	}).done(function(meds){
		medList2 = meds.split(',');
	});
	return medList2[0]+medList2[1]+medList2[2]+medList2[3];
}
$(function() {
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 390,
		width: 500,
		modal: true,
		buttons: {
			"Save": function() {
				$.ajax({
					url: "class/rehabilitationform01.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "Name": $("#Name").val(), "ChairNo": $("#ChairNo").val(), "ChairNo2": $("#ChairNo2").val(), "ChairNo3": $("#ChairNo3").val() },
					success: function(data) {
						$( "#dialog-form" ).dialog( "close" );
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$("#HospNo").val('');
				$("#Name").val('');
				$("#ChairNo").val('');
				$("#ChairNo2").val('');
				$("#ChairNo3").val('');
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
});
function dialogform_set(id){
		var ClickedID = id;
		var arrHospNo = ClickedID.split('_');
		$("#HospNo").val(arrHospNo[1]);
		$("#Name").val(loadPatInfo(arrHospNo[1]));
		if ($('#editchair1_'+arrHospNo[1]).val()!="---") { $("#ChairNo").val($('#editchair1_'+arrHospNo[1]).val()); }
		if ($('#editchair2_'+arrHospNo[1]).val()!="---") { $("#ChairNo2").val($('#editchair2_'+arrHospNo[1]).val()); }
		if ($('#editchair3_'+arrHospNo[1]).val()!="---") { $("#ChairNo3").val($('#editchair3_'+arrHospNo[1]).val()); }
		openVerificationForm('#dialog-form');
}
</script>

<?php
$db1 = new DB;
$db1->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
$arrArea = array();
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$arrArea[$r1['areaID']] = $r1['areaName'];
}
?>

<h3>Usage Of Wheelchair</h3>
<table width="100%">
  <tr class="title">
    <td valign="middle">Floor/area</td>
    <td valign="middle">Care ID#</td>
    <td valign="middle">Full name</td>
    <td valign="middle">Wheelchair No.</td>
    <td valign="middle">Air cushion No.</td>
    <td valign="middle">Assistive device No.</td>
    <td valign="middle">Edit</td>
  </tr>
  <?php
  $db2 = new DB;
  $db2->query("SELECT * FROM `bedinfo` ORDER BY `Area` ASC, `bedID` ASC;");
  for ($i=0;$i<$db2->num_rows();$i++) {
	  $r2 = $db2->fetch_assoc();
	  $db3 = new DB;
	  $db3->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r2['bedID']."'");
	  $r3 = $db3->fetch_assoc();
	  $db3a = new DB;
	  $db3a->query("SELECT `patientID`,`HospNo`,`instat` FROM `patient` WHERE `patientID`='".$r3['patientID']."'");
	  $r3a = $db3a->fetch_assoc();
	  $db3b = new DB;
	  $db3b->query("SELECT * FROM `areainfo` WHERE `areaID`='".$r2['Area']."'");
	  $r3b = $db3b->fetch_assoc();
	  $db4 = new DB;
	  $db4->query("SELECT * FROM `rehabilitationform01` WHERE `HospNo`='".$r3a['HospNo']."'");
	  $r4 = $db4->fetch_assoc();
	  if ($r4['ChairNo']==NULL) { $ChairNo = "---"; } else { $ChairNo = $r4['ChairNo']; }
	  if ($r4['ChairNo2']==NULL) { $ChairNo2 = "---"; } else { $ChairNo2 = $r4['ChairNo2']; }
	  if ($r4['ChairNo3']==NULL) { $ChairNo3 = "---"; } else { $ChairNo3 = $r4['ChairNo3']; }
	  	echo '
  <tr '.($_SESSION['ncareOrgStatus_lwj']==2 && $r3a['instat']==0?' style="display:none;"':'').'>
    <td valign="middle" align="center">'.$r3b['areaName'].'</td>
    <td valign="middle" align="center">'.$r3a['HospNo'].'</td>
    <td valign="middle" align="center">'.getPatientName($r3a['patientID']).'</td>
	<td valign="middle" align="center"><input type="hidden" id="editchair1_'.$r3a['HospNo'].'" value="'.$ChairNo.'">'.$ChairNo.'</td>
	<td valign="middle" align="center"><input type="hidden" id="editchair2_'.$r3a['HospNo'].'" value="'.$ChairNo2.'">'.$ChairNo2.'</td>
	<td valign="middle" align="center"><input type="hidden" id="editchair3_'.$r3a['HospNo'].'" value="'.$ChairNo3.'">'.$ChairNo3.'</td>
	<td valign="middle" align="center"><center><input type="button" id="editrecord_'.$r3a['HospNo'].'" value="Edit" onclick="dialogform_set(this.id);"/></center></td>
  </tr>
	  	'."\n";
  }
  ?>
</table>


<div id="dialog-form" title="新增輪椅使用情況" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td><input type="text" name="HospNo" id="HospNo" value="" size="12" onkeyup="loadPatInfo()"></td>
      </tr>
      <tr>
        <td class="title">Full name</td>
        <td><input type="text" name="Name" id="Name" value="" size="12" readonly></td>
      </tr>
      <tr>
        <td class="title">Wheelchair No.</td>
        <td><input type="text" name="ChairNo" id="ChairNo" size="12"> <input type="button" onclick="document.getElementById('ChairNo').value='None';" value="None" /> <input type="button" onclick="document.getElementById('ChairNo').value='Self-owned';" value="Self-owned" /></td>
      </tr>
      <tr>
        <td class="title">Air cushion No.</td>
        <td><input type="text" name="ChairNo2" id="ChairNo2" size="12"> <input type="button" onclick="document.getElementById('ChairNo2').value='None';" value="None" /> <input type="button" onclick="document.getElementById('ChairNo2').value='Self-owned';" value="Self-owned" /></td>
      </tr>
      <tr>
        <td class="title">Assistive device No.</td>
        <td><input type="text" name="ChairNo3" id="ChairNo3" size="12"> <input type="button" onclick="document.getElementById('ChairNo3').value='None';" value="None" /> <input type="button" onclick="document.getElementById('ChairNo3').value='Self-owned';" value="Self-owned" /></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div><br><br>