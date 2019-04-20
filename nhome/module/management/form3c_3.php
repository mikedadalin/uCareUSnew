<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['tID']);

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part3` WHERE `targetID`='".$targetID."'");
$r1 = $db1->fetch_assoc();
$pid = getPID($r1['HospNo']);
$location = '';
if ($r1['location_1']==1) { $location .= 'Room'; }
if ($r1['location_2']==1) { if ($location!='') { $location.='、'; } $location .= 'Bedside'; }
if ($r1['location_3']==1) { if ($location!='') { $location.='、'; } $location .= 'Bathroom'; }
if ($r1['location_4']==1) { if ($location!='') { $location.='、'; } $location .= 'Activity area'; }
if ($r1['location_5']==1) { if ($location!='') { $location.='、'; } $location .= 'Walkway'; }
if ($r1['location_6']==1) { if ($location!='') { $location.='、'; } $location .= 'Other(s):'.$r1['locationother']; }
$movement = '';
if ($r1['movement_1']==1) { $movement .= '	Toileting'; }
if ($r1['movement_2']==1) { if ($movement!='') { $movement.='、'; } $movement .= '上下床活動當中'; }
if ($r1['movement_3']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Slip(wheelchair)'; }
if ($r1['movement_4']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Stand up(wheelchair)'; }
if ($r1['movement_5']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Across(Bed rails)'; }
if ($r1['movement_6']==1) { if ($movement!='') { $movement.='、'; } $movement .= 'Other(s):'.$r1['movementother']; }
$reason = '';
if ($r1['reason_1']==1) { $reason .= 'Resident\'s health'; }
if ($r1['reason_2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Treatment/medication'; }
if ($r1['reason_3']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Environmental risk'; }
if ($r1['reason_4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$r1['reasonother']; }
$object = '';
if ($r1['object_1']==1) { $object .= 'Bed rails(2)'; }
if ($r1['object_2']==1) { if ($object!='') { $object.='、'; } $object .= 'Bed rail(1)'; }
if ($r1['object_3']==1) { if ($object!='') { $object.='、'; } $object .= 'Waist restraint straps'; }
if ($r1['object_4']==1) { if ($object!='') { $object.='、'; } $object .= 'Posey vest'; }
if ($r1['object_5']==1) { if ($object!='') { $object.='、'; } $object .= 'No restraint'; }
$med = '';
if ($r1['med_1']==1) { $med .= 'Antihistamine'; }
if ($r1['med_2']==1) { if ($med!='') { $med.='、'; } $med .= 'Antihypertensive'; }
if ($r1['med_3']==1) { if ($med!='') { $med.='、'; } $med .= 'Sedative-hypnotic'; }
if ($r1['med_4']==1) { if ($med!='') { $med.='、'; } $med .= 'Muscle relaxants'; }
if ($r1['med_5']==1) { if ($med!='') { $med.='、'; } $med .= 'Laxative'; }
if ($r1['med_6']==1) { if ($med!='') { $med.='、'; } $med .= 'Diuretics'; }
if ($r1['med_7']==1) { if ($med!='') { $med.='、'; } $med .= 'Antidepressant'; }
if ($r1['med_8']==1) { if ($med!='') { $med.='、'; } $med .= 'Hypoglycemic'; }
$injurlv = '';
if ($r1['injurlv_1']==1) { $injurlv .= 'None'; }
if ($r1['injurlv_2']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level1'; }
if ($r1['injurlv_3']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level2'; }
if ($r1['injurlv_4']==1) { if ($injurlv!='') { $injurlv.='、'; } $injurlv .= 'Level3'; }
$bodypart = '';
if ($r1['bodypart_1']==1) { $bodypart .= 'Waist'; }
if ($r1['bodypart_2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
if ($r1['bodypart_3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
if ($r1['bodypart_4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
if ($r1['bodypart_5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
if ($r1['bodypart_6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$r1['bodypartother']; }
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=delete&targetID=<?php echo $targetID; ?>">
<h3>Fall record</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table width="100%">
  <tr>
    <td class="title" width="160">Full name</td>
    <td width="400"><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
    <td class="title" width="160">Care ID#</td>
    <td><?php echo getHospNoDisplayByPID($pid); ?></td>
  </tr>
  <tr>
      <td class="title">Gender</td>
      <td><?php echo $r1['Gender']; ?></td>
      <td class="title">Age</td>
      <td><?php echo $r1['Age']; ?></td>
    </tr>
    <tr>
      <td class="title">Major diagnosis</td>
      <td><?php echo $r1['Diag']; ?></td>
      <td class="title">ADL score</td>
      <td><?php echo $r1['ADLtotal']; ?></td>
    </tr>
    <tr>
      <td class="title">Date</td>
      <td><?php echo $r1['date']; ?></td>
      <td class="title">Time</td>
      <td><?php echo $r1['time']; ?></td>
    </tr>
    <tr>
      <td class="title">Location</td>
      <td colspan="3"><?php echo $location; ?></td>
    </tr>
    <tr>
      <td class="title">Scenarios</td>
      <td colspan="3"><?php echo $movement; ?> <?php echo $r1['movementother']; ?></td>
    </tr>
    <tr>
      <td class="title">Reason</td>
      <td colspan="3"><?php echo $reason; ?> <?php echo $r1['reasonother']; ?></td>
    </tr>
    <tr>
      <td class="title">Restraints</td>
      <td colspan="3"><?php echo $object; ?></td>
    </tr>
    <tr>
      <td class="title">Medication</td>
      <td colspan="3"><?php echo $med; ?></td>
    </tr>
    <tr>
      <td class="title">Injury severity</td>
      <td colspan="3"><?php echo $injurlv; ?></td>
    </tr>
    <tr>
      <td class="title">Body part</td>
      <td colspan="3"><?php echo $bodypart; ?> <?php echo $r1['bodypartother']; ?></td>
    </tr>
    <tr>
      <td class="title">Status description</td>
      <td colspan="3"><?php echo $r1['description']; ?></td>
    </tr>
    <tr>
      <td class="title">Filled by</td>
      <td colspan="3"><?php echo checkusername($_SESSION['ncareID_lwj']); ?></td>
    </tr>
    <tr>
      <td class="title"><span class="rangeH">Confirm delete?</span></td>
      <td colspan="3"><input type="hidden" name="formID" id="formID" value="sixtarget_part3" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
    </tr>
  </table>
</form>