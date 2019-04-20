<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform07` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform07` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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

//護理表單2h欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform02h` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02h_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02h_'.$k} = $v; } }  else { ${'nurseform02h_'.$k} = $v; } } }

//護理表單2h欄位
$db4 = new DB;
$db4->query("SELECT * FROM `nurseform02c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r4 = $db4->fetch_assoc();
if ($db4->num_rows()>0) { foreach ($r4 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02c_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02c_'.$k} = $v; } }  else { ${'nurseform02c_'.$k} = $v; } } }

//社工表單01欄位
$db5 = new DB;
$db5->query("SELECT * FROM `socialform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r5 = $db5->fetch_assoc();
if ($db5->num_rows()>0) { foreach ($r5 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'socialform01_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'socialform01_'.$k} = $v; } }  else { ${'socialform01_'.$k} = $v; } } }

//護理表單01欄位
$db6 = new DB;
$db6->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r6 = $db6->fetch_assoc();
if ($db6->num_rows()>0) { foreach ($r6 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform01_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform01_'.$k} = $v; } }  else { ${'nurseform01_'.$k} = $v; } } }
?>
<h3>Periodic demand assessment</h3>
<center>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%">
  <tr>
    <td class="title" width="80">Admission date</td>
    <td width="260"><script> $(function() { $( "#inpatientinfo_indate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><p align="left"><input type="text" id="inpatientinfo_indate" name="inpatientinfo_indate" value="<?php echo $indate; ?>" size="12" /></p></td>
    <td class="title" width="80">Assess date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td class="title" width="80">Assess by</td>
    <td><?php if ($Qfiller != NULL) { echo checkusername($Qfiller); } ?></td>
  </tr>
  <tr>
    <td class="title">Status</td>
    <td>
	<?php
	if ($nurseform01_QillnessType == 1) { $Q1 = 1; } elseif ($nurseform01_QillnessType == 3) { $Q1 = 2; }
	echo draw_option("Q1","General;Middle-low income","l","single",$Q1,false,5);
	?>
    </td>
    <td class="title">Subsidy</td>
    <td colspan="3">&nbsp;$ <input type="text" name="Q1a" id="Q1a" value="<?php echo $Q1a; ?>" size="8"></td>
  </tr>
  <tr>
    <td class="title" height="110">Major carer</td>
    <td><input type="text" name="Q2" id="Q2" value="<?php echo $Q2; ?>" size="12" ></td>
    <td class="title">relationship</td>
    <td><input type="text" name="Q3" id="Q3" value="<?php echo $Q3; ?>" size="12" ></td>
    <td class="title" width="80">Phone #</td>
    <td colspan="3"><input type="text" name="Q4" id="Q4" value="<?php echo $Q4; ?>" size="12"><br /><?php echo draw_checkbox("Q4a","Replaced",$Q4a,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" height="110">Contract signed by</td>
    <td><input type="text" name="Q5" id="Q5" value="<?php echo $Q5; ?>" size="12" ></td>
    <td class="title">relationship</td>
    <td><input type="text" name="Q6" id="Q6" value="<?php echo $Q6; ?>" size="12" ></td>
    <td class="title">Phone #</td>
    <td colspan="3"><input type="text" name="Q7" id="Q7" value="<?php echo $Q7; ?>" size="12" ><br /><?php echo draw_checkbox("Q7a","Replaced",$Q7a,"single"); ?></td>
  </tr>
  <tr>
    <td class="title">Basic assessment</td>
    <td colspan="5">
    <?php echo draw_checkbox("Q8","MMSE <input type=\"text\" name=\"nurseform02h_Q32\" id=\"nurseform02h_Q32\" value=\"".$nurseform02h_Q32."\" size=\"6\" >Score;ADL <input type=\"text\" name=\"nurseform02c_Qtotal\" id=\"nurseform02c_Qtotal\" value=\"".$nurseform02c_Qtotal."\" size=\"6\" >Score;Other(s):<input type=\"text\" name=\"Q8a\" id=\"Q8a\" value=\"".$Q8a."\" size=\"20\" >",$Q8,"multi"); ?>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td rowspan="3" class="title" width="80">Resources applied</td>
    <td class="title_s" width="80">Social welfare/security</td>
    <td colspan="2">
	<?php echo draw_option("Q9","None;Yes","m","single",$Q9,true,6); ?>
    <?php echo draw_checkbox("Q10","Governmental resources:<input type=\"text\" name=\"Q10a\" id=\"Q10a\" value=\"".$Q10a."\" size=\"20\" >;Private resources:<input type=\"text\" name=\"Q10b\" id=\"Q10b\" value=\"".$Q10b."\" size=\"20\" >",$Q10,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">Current subsidy</td>
    <td colspan="2">

	<?php echo draw_option("Q11","None;Yes","m","single",$Q11,true,2); ?>

    <?php echo draw_checkbox("Q12","Disabled care subsidy;Shelter subsidy;Respite Care;Other(s):<input type=\"text\" name=\"Q12a\" id=\"Q12a\" value=\"".$Q12a."\" size=\"20\" >",$Q12,"single"); ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">Intend to help<br> applying subsidies</td>
    <td colspan="2"><?php echo draw_option("Q13","None;Disability proof;Assistive device;Mobile device;Shelter;Other","xm","single",$Q13,true,4); ?> description:<input type="text" name="Q13a" id="Q13a" value="<?php echo $Q13a; ?>" size="20" ></td>
  </tr>
  <tr>
    <td rowspan="8" class="title" width="80">Psychological level</td>
    <td class="title_s" width="80">Emotional status</td>
    <td colspan="2"><?php echo draw_option("Q37","Stable;Depression;Anxiety;Impulsive;Temper easily;Unassessable","xm","multi",$Q37,true,6); ?><br>
    <b>Acute Onset Mental Status Change</b><br>
	  <b>Is there evidence of an acute change in mental status</b> from the resident's baseline?
	  <?php echo draw_option("Q60","No;Yes","m","multi",$Q60,true,6); ?>
	</td>
  </tr>
  <tr>
    <td class="title_s">Behavior</td>
    <td><?php echo draw_checkbox("Q38","Appropriate;Slow;Flinch;Impatient;Wandering;Giggling;Irritable;Attack;Abuse;Unassessable",$Q38,"multi"); ?></td>
	<td>
	<div>
	<table style="width:100%">
	  <tr><td><b style="font-size:16px">If patient has any behavior listed above, please check the frequency</b></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51a"," 1 to 3 days; 4 to 6 days; daily",$Q51a,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51b"," 1 to 3 days; 4 to 6 days; daily",$Q51b,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51c"," 1 to 3 days; 4 to 6 days; daily",$Q51c,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51d"," 1 to 3 days; 4 to 6 days; daily",$Q51d,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51e"," 1 to 3 days; 4 to 6 days; daily",$Q51e,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51f"," 1 to 3 days; 4 to 6 days; daily",$Q51f,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51g"," 1 to 3 days; 4 to 6 days; daily",$Q51g,"single"); ?></td></tr>
	  <tr><td>Behavior occurred<?php echo draw_checkbox_nobr("Q51h"," 1 to 3 days; 4 to 6 days; daily",$Q51h,"single"); ?></td></tr>
	  <tr><td></td></tr>
	</table>
	</div>
    </td>
  </tr>
  <tr>
    <td class="title_s">Wandering</td>
    <td colspan="2">
	  <b>A. Does the wandering place the resident at significant risk of getting to a potentially dangerous place?</b><br>(e.g., stairs, outside of the facility)<br>
	  <?php echo draw_option("Q62","No;Yes","m","single",$Q62,true,6); ?><br>
	  <b>B. Does the wandering significantly intrude on the privacy or activities of others?</b><br>
	  <?php echo draw_option("Q63","No;Yes","m","single",$Q63,true,6); ?>
	</td>
  </tr>
  <tr>
    <td class="title_s">Psychomotor retardation</td>
    <td colspan="2"><?php echo draw_checkbox("Q52","Behavior not present;Behavior continuously present, does not fluctuate;Behavior present, fluctuates",$Q52,"single"); ?></td>

  </tr>
  <tr>
    <td class="title_s">Attitude</td>
    <td colspan="2"><?php echo draw_option("Q39","Friendly;Hostile;Wary;Uncooperative;Refuse;Stubborn;Suspicious;Unassessable","xm","multi",$Q39,true,4); ?></td>
  </tr>
  <tr>
    <td class="title_s">Attention</td>
    <td colspan="2"><?php echo draw_option("Q40","Concentrate;Inattention;Excessive concentration;Unassessable","xl","single",$Q40,true,6); ?>
      <br />&nbsp;&nbsp;&nbsp;<b>If patient has any inattention behavior, please check the frequency</b>
      <br /><?php echo draw_checkbox("Q53","Behavior continuously present, does not fluctuate;Behavior present, fluctuates",$Q53,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Cogitation</td>
    <td colspan="2"><?php echo draw_option("Q41","Normal;Delusions;Relaxation;Lack;Jumping/Leaping;Disorganized thinking;Hallucination;Unassessable","l","multi",$Q41,true,4); ?>
      <br />&nbsp;&nbsp;&nbsp;<b>If patient has any behavior listed above, please check the frequency</b>
      <br /><?php echo draw_checkbox("Q50","Behavior continuously present, does not fluctuate;Behavior present, fluctuates",$Q50,"single"); ?></td>

  </tr>
  <tr>
    <td class="title_s">Comprehension</td>
    <td colspan="2"><?php echo draw_option("Q42","Good;Normal;Poor;Unassessable","l","multi",$Q42,true,6); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td rowspan="3" class="title" width="165">Impact of the identified symptom(s) on resident</td>
    <td class="title_s" width="550">Put the resident at significant risk for physical illness or injury</td>
    <td colspan="2"><?php echo draw_option("Q54","No;Yes","m","single",$Q54,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Significantly interfere with the resident's care</td>
    <td colspan="2"><?php echo draw_option("Q55","No;Yes","m","single",$Q55,true,5); ?>
  </tr>
  <tr>
    <td class="title_s">Significantly interfere with the resident's participation in activities or social interactions</td>
    <td colspan="2"><?php echo draw_option("Q56","No;Yes","m","single",$Q56,true,5); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" width="170">Rejection of Care</td>
    <td class="title_s" width="400"><b>Did the resident reject evaluation or care that is necessary <br>to achieve the resident's goals for health and well-being?</b></td>
    <td colspan="2"><?php echo draw_checkbox("Q61","Behavior not exhibited;Behavior of this type occurred 1 to 3 days;Behavior of this type occurred 4 to 6 days, <br>but less than daily;Behavior of this type occurred daily",$Q61,"single"); ?></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Impact of the identified symptom(s) on resident</td>
    <td class="title_s">Put the resident at significant risk for physical illness or injury</td>
    <td colspan="2"><?php echo draw_option("Q54","No;Yes","m","single",$Q54,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Significantly interfere with the resident's care</td>
    <td colspan="2"><?php echo draw_option("Q55","No;Yes","m","single",$Q55,true,5); ?>
  </tr>
  <tr>
    <td class="title_s">Significantly interfere with the resident's <br>participation in activities or social interactions</td>
    <td colspan="2"><?php echo draw_option("Q56","No;Yes","m","single",$Q56,true,5); ?></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Impact of the identified symptom(s) on others</td>
    <td class="title_s">Put others at significant risk for physical injury</td>
    <td colspan="2"><?php echo draw_option("Q57","No;Yes","m","single",$Q57,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Significantly intrude on the privacy or activity of others</td>
    <td colspan="2"><?php echo draw_option("Q58","No;Yes","m","single",$Q58,true,5); ?>
  </tr>
  <tr>
    <td class="title_s">Significantly disrupt care or living environment</td>
    <td colspan="2"><?php echo draw_option("Q59","No;Yes","m","single",$Q59,true,5); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td rowspan="3" class="title" width="165">Impact of the identified symptom(s) on others</td>
    <td class="title_s" width="550">Put others at significant risk for physical injury</td>
    <td colspan="2"><?php echo draw_option("Q57","No;Yes","m","single",$Q57,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Significantly intrude on the privacy or activity of others</td>
    <td colspan="2"><?php echo draw_option("Q58","No;Yes","m","single",$Q58,true,5); ?>
  </tr>
  <tr>
    <td class="title_s">Significantly disrupt care or living environment</td>
    <td colspan="2"><?php echo draw_option("Q59","No;Yes","m","single",$Q59,true,5); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td rowspan="5" class="title" width="80">Social dimension </td>
    <td class="title_s" width="80">Social skills</td>
    <td colspan="2"><?php echo draw_option("Q43","Active / easy to make friends;Fair;Passive / depend on other;Loner;Resist;Unassessable","xl","multi",$Q43,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ability to communicate:</td>
    <td colspan="2"><?php echo draw_option("Q44","Normal;Semantic confusion;Language barrier;Strong accent;Body movements;Unassessable","l","multi",$Q44,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with family</td>
    <td colspan="2"><?php echo draw_option("Q45","Good;Basic Interaction;Isolated;No relatives;Other","l","multi",$Q45,true,3); ?> <input type="text" name="Q46" id="Q46" size="18"  value="<?php echo $Q46; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with other residents</td>
    <td colspan="2"><?php echo draw_option("Q47","Interact well;Occasionally interact;No interaction;Other","l","multi",$Q47,false,2); ?> <input type="text" name="Q14a" id="Q14a" size="18"  value="<?php echo $Q14a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Adaptation status</td>
    <td colspan="2"><?php echo draw_option("Q48","Good;Fair;Poor;Other","l","multi",$Q48,false,2); ?> <input type="text" name="Q15a" id="Q15a" size="18"  value="<?php echo $Q15a; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="title">Activity participation </td>
    <td colspan="2"><?php echo draw_option("Q49","Dynamic;Static;Birthday party;Assistive treatment;Other","l","multi",$Q49,false,3); ?> <input type="text" name="Q16a" id="Q16a" size="18"  value="<?php echo $Q16a; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="title">Resident's/family expectation to the facility</td>
    <td colspan="2"><textarea name="Q17" id="Q17" cols="60" rows="6" ><?php echo $Q17; ?></textarea></td>
  </tr>
  <tr>
    <td rowspan="11" class="title">Demand category</td>
    <td class="title_s">Economic demand</td>
    <td colspan="2"><input type="text" name="Q18" id="Q18" size="80"  value="<?php echo $Q18; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Emotional problem(s)</td>
    <td colspan="2"><input type="text" name="Q19" id="Q19" size="80"  value="<?php echo $Q19; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Adaptation issues</td>
    <td colspan="2"><input type="text" name="Q20" id="Q20" size="80"  value="<?php echo $Q20; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Healthcare demand</td>
    <td colspan="2"><input type="text" name="Q21" id="Q21" size="80"  value="<?php echo $Q21; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Social interaction demand</td>
    <td colspan="2"><input type="text" name="Q22" id="Q22" size="80"  value="<?php echo $Q22; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Transfer/referrals to other facility</td>
    <td colspan="2"><input type="text" name="Q23" id="Q23" size="80"  value="<?php echo $Q23; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Families - emotional support, stress adaptation</td>
    <td colspan="2"><input type="text" name="Q24" id="Q24" size="80"  value="<?php echo $Q24; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Families - welfare information or assist applicants</td>
    <td colspan="2"><input type="text" name="Q25" id="Q25" size="80"  value="<?php echo $Q25; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Families - demand for courses</td>
    <td colspan="2"><input type="text" name="Q26" id="Q26" size="80"  value="<?php echo $Q26; ?>" /><br /><?php echo draw_option("Q28","Health education (awareness of the disease);Family adjustment to face dementia;Grief lessening guidance;Other","xxxl","single",$Q28,true,2); ?> <input type="text" name="Q29a" id="Q29a" size="18"  value="<?php echo $Q29a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Hospice care</td>
    <td colspan="2"><input type="text" name="Q27" id="Q27" size="80"  value="<?php echo $Q27; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Other</td>
    <td colspan="2"><input type="text" name="Q30" id="Q30" size="80"  value="<?php echo $Q30; ?>" /></td>
  </tr>
  <tr>
    <td class="title" rowspan="5">Care plan</td>
    <td class="title_s">Objectives</td>
    <td colspan="2">
    <?php echo draw_option("Q31","Maintain;Alter","m","single",$Q31,false,3); ?><br /><textarea name="Q32" id="Q32" cols="60" rows="3" ><?php echo $Q32; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Execution strategy</td>
    <td colspan="2"><textarea name="Q33" id="Q33" cols="60" rows="3" ><?php echo $Q33; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Assistance analysis</td>
    <td colspan="2"><textarea name="Q34" id="Q34" cols="60" rows="3" ><?php echo $Q34; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Resistance assessment</td>
    <td colspan="2"><textarea name="Q35" id="Q35" cols="60" rows="3" ><?php echo $Q35; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Previous objectives result/effectiveness</td>
    <td colspan="2"><textarea name="Q36" id="Q36" cols="60" rows="3" ><?php echo $Q36; ?></textarea></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform07" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form></center><br><br>