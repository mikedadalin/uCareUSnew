<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02g` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02g` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
?>
<!-- MDS P100 form-->
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Restraint demand assessment</h3>
<table width="100%">
  <tr>
    <td colspan="2" class="title" style="text-align:left;" width="200">&nbsp;1. Reason for restraint</td>
  </tr>
  <tr>
    <td td colspan="2"><?php echo draw_option("Q1","Unstable emotion ;Physical body change;Cognitive change;High falling rate;Scratching the skin;Extricate pipeline easily","xl","multi",$Q1,true,3); ?></td>
  </tr>
  <tr>
    <td td colspan="2" class="title" style="text-align:left;">&nbsp;2. Restraint</td>
  </tr>
  <tr>
    <td td colspan="2"><?php echo draw_option("Q2","Restraining band;Lower back protector;Restraint vest;Glove(s);Other","l","multi",$Q2,false,0); ?> <input type="text" name="Q3" id="Q3" size="22"  value="<?php echo $Q3; ?>"></td>
  </tr>

<!--Restraints Insert part-->
  <tr>
    <td colspan="2" class="title" style="text-align:left;" width="200">&nbsp;3. Physical Restraints</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s" style="text-align:left;">&nbsp;Used in Bed</td>
  </tr>

  <tr>
    <td colspan="1" style="text-align:left;" width="50">&nbsp;Bed rail</td>
  
    <td colspan="1" width="150"><?php echo draw_option("Q9","Not used;Used less than daily;Used daily","l","single",$Q9,false,0); ?></td>
  </tr>
  
  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Trunk restraint</td>
    <td colspan="1"><?php echo draw_option("Q10","Not used;Used less than daily;Used daily","l","single",$Q10,false,0); ?></td>
  </tr>

  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Limb restraint</td>
    <td colspan="1"><?php echo draw_option("Q11","Not used;Used less than daily;Used daily","l","single",$Q11,false,0); ?></td>
  </tr>

  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Other</td>
    <td colspan="1"><?php echo draw_option("Q12","Not used;Used less than daily;Used daily","l","single",$Q12,false,0); ?></td>
  </tr>

  <tr>
    <td colspan="2" class="title_s" style="text-align:left;">&nbsp;Used in Chair or Out of Bed</td>
  </tr>
  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Trunk restraint</td>
    <td colspan="1"><?php echo draw_option("Q13","Not used;Used less than daily;Used daily","l","single",$Q13,false,0); ?></td>
  </tr>
  
  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Limb restraint</td>
    <td colspan="1"><?php echo draw_option("Q14","Not used;Used less than daily;Used daily","l","single",$Q14,false,0); ?></td>
  </tr>

  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Chair prevents rising</td>
    <td colspan="1"><?php echo draw_option("Q15","Not used;Used less than daily;Used daily","l","single",$Q15,false,0); ?></td>
  </tr>

  <tr>
    <td colspan="1" style="text-align:left;">&nbsp;Other</td>
  
    <td colspan="1"><?php echo draw_option("Q16","Not used;Used less than daily;Used daily","l","single",$Q16,false,0); ?></td>
  </tr>


<!--Insert end-->
  <tr>
    <td colspan="2"class="title" style="text-align:left;">&nbsp;4. Restraint part(s)</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_option("Q4","Chest & abdomen;Knee(s);Ankle(s);Wrist(s);Other","l","multi",$Q4,false,0); ?> <input type="text" name="Q5" id="Q5" size="22"  value="<?php echo $Q5; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title" style="text-align:left;">&nbsp;5. Time of restraint</td>
  </tr>
  <tr>
    <td colspan="2"><input type="text" name="Q6" id="Q6" size="96"  value="<?php echo $Q6; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title" style="text-align:left;">&nbsp;6. Preventive measures before restraint</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q7","Increase visitation and companionship;Protective measures such as pillows;Lower the bed, move the bed to against the wall;Take the initiative to meet the demand;Remind the usage of  service bell and place it on readily available location;Meaningful activities, in order to disperse the attention of residents, such as watching TV or play games.",$Q7,"multi"); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title" style="text-align:left;">&nbsp;7. Nursing intervention(s) before restraint</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q8","Applied other preventive measures before restraint.;Evaluate the reason,necessity and possible complications of restraint.;Consultation/ meeting with other caregivers to think of care method other than restraint.;Establish restraint necessity after evaluation of physician and nurses. Then explain it to the resident and families.;Families have fully understand method and body part of the restraint.;Families agree to restrain and fill the consent of restrain. Apply restraint.;Families disagree with the restraint.",$Q8,"multi"); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02g" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}  else {
		${$k} = "";
	}
}
}
?>