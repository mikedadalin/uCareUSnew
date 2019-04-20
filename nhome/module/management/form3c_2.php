<?php
$targetID = mysql_escape_string($_GET['tID']);

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part2` WHERE `targetID`='".$targetID."'");
$r1 = $db1->fetch_assoc();
$pid = getPID($r1['HospNo']);
$reason = '';
if ($r1['reason1']==1) { $reason .= 'Fall prevent'; }
if ($r1['reason2']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Pipeline Protect'; }
if ($r1['reason3']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Self-injury prevent'; }
if ($r1['reason4']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Behavioral disorders'; }
if ($r1['reason5']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Assist treatment'; }
if ($r1['reason6']==1) { if ($reason!='') { $reason.='、'; } $reason .= 'Other(s):'.$r1['reasonother']; }
$equipment = '';
if ($r1['equipment1']==1) { $equipment .= 'Restraint strap'; }
if ($r1['equipment2']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'T-shape restraint strap'; }
if ($r1['equipment3']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Magnetic clasp(s)'; }
if ($r1['equipment4']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Glove(s)'; }
if ($r1['equipment5']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Special dinner plate(s)'; }
if ($r1['equipment6']==1) { if ($equipment!='') { $equipment.='、'; } $equipment .= 'Other(s):'.$r1['equipmentother']; }
$bodypart = '';
if ($r1['bodypart1']==1) { $bodypart .= 'Waist'; }
if ($r1['bodypart2']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Ankle(s)'; }
if ($r1['bodypart3']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Wrist(s)'; }
if ($r1['bodypart4']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Knee(s)'; }
if ($r1['bodypart5']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Torso'; }
if ($r1['bodypart6']==1) { if ($bodypart!='') { $bodypart.='、'; } $bodypart .= 'Other(s):'.$r1['bodypartother']; }
if ($r1['releasedate']=='') { $releasedate = '---'; } else { $releasedate = $r1['releasedate']; }
$releasereason = '';
if ($r1['releasereason1']==1) { $releasereason .= 'Cognitive Improvement'; }
if ($r1['releasereason2']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Emotion stabilized'; }
if ($r1['releasereason3']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Deterioration'; }
if ($r1['releasereason4']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Death'; }
if ($r1['releasereason5']==1) { if ($releasereason!='') { $releasereason.='、'; } $releasereason .= 'Other(s):'.$r1['releasereasonother']; }
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=delete&targetID=<?php echo $targetID; ?>">
<h3>Restraint record</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table width="100%">
  <tr>
    <td class="title" width="160">Full name</td>
    <td><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
    <td class="title" width="160">Care ID#</td>
    <td><?php echo getHospNoDisplayByPID($pid); ?></td>
  </tr>
  <tr>
    <td class="title">Restraint date</td>
    <td colspan="3"><?php echo $r1['startdate']; ?></td>
  </tr>
  <tr>
    <td class="title">Restraint reason</td>
    <td colspan="3"><?php echo $reason; ?> <?php echo $reasonother; ?></td>
  </tr>
  <tr>
    <td class="title">Restraint equipment</td>
    <td colspan="3"><?php echo $equipment; ?> <?php echo $equipmentother; ?></td>
  </tr>
  <tr>
    <td class="title">Restraint part(s)</td>
    <td colspan="3"><?php echo $bodypart; ?> <?php echo $bodypartother; ?></td>
  </tr>
  <tr>
    <td class="title">Relieve date</td>
    <td colspan="3"><?php echo $releasedate; ?></td>
  </tr>
  <tr>
    <td class="title">Relieve reason</td>
    <td colspan="3"><?php echo $releasereason; ?> <?php echo $releasereasonother; ?></td>
  </tr>
  <tr>
    <td class="title">Filled by</td>
    <td colspan="3"><?php echo checkusername($_SESSION['ncareID_lwj']); ?></td>
  </tr>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="3"><input type="hidden" name="formID" id="formID" value="sixtarget_part2" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
  </table>
</form>