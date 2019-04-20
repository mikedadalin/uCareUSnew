<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform02` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform02` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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

//ADL欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform02c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02c_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02c_'.$k} = $v; } }  else { ${'nurseform02c_'.$k} = $v; } } }

//MMSE欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform02h` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02h_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02h_'.$k} = $v; } }  else { ${'nurseform02h_'.$k} = $v; } } }
?>
<h3>Preliminary assessment</h3>
<center>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%">
  <tr>
    <td class="title" width="120">Preliminary assessment date</td>
    <td colspan="4"><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
  </tr>
  <tr>
    <td class="title">Resident source (came from)</td>
    <td colspan="4"><?php echo draw_option('Q40','Referral by healthcare agency ;Hospital swing bed;Internet search;Self contact;Referral by relatives/friends;Other facility transfer;Other',"xl","single",$Q40,true,4); ?><input type="text" name="Q40a" id="Q40a" value="<?php echo $Q40a; ?>" size='8' /></td>
  </tr>
  <tr>
    <td class="title">Basic assessment</td>
    <td class="title_s" width="120">MMSE</td>
    <td><input type="text" name="Q41a" id="Q41a" value="<?php if ($Q41a==NULL) { echo $nurseform02h_Q32; } else { echo $Q41a; } ?>" size="2" /></td>
    <td class="title_s" width="120">ADL</td>
    <td><input type="text" name="Q42a" id="Q42a" value="<?php if ($Q42a==NULL) { echo $nurseform02c_Qtotal; } else { echo $Q42a; } ?>" size="2" /></td>
  </tr>
  <tr>
    <td class="title" colspan="5">Resident's status description</td>
  </tr>
  <tr>
    <td class="title_s">Resident's status</td>
    <td colspan="4"><textarea name="Q42" id="Q42" rows="5" cols="90"><?php echo $Q42; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Family status overview</td>
    <td colspan="4"><textarea name="Q43" id="Q43" rows="5" cols="90"><?php echo $Q43; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Adaptation status <br> of new admission</td>
    <td colspan="4"><textarea name="Q44" id="Q44" rows="5" cols="90"><?php echo $Q44; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td colspan="4" class="title" style="text-align:left;">1. Economic status</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Demand assessment</td>
    <td class="title_s">Assessment results</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Economic status</td>
    <td valign="top"><?php echo draw_checkbox("Q1","Ecomomy sustainable;Economic deprivation;Apply for resources",$Q1,"single"); ?></td>
    <td valign="top" rowspan="2"><?php echo draw_checkbox("Q2","No subsidy needed;Intend to assist in applying certify of disability;Intends to assist in applying for certify of major injuries;Intend to assist in applying subsidy of assistive device;Intends to assist in applying subsidy for asylum/resettlement <br><input type=\"text\" name=\"Q3a\" id=\"Q3a\" size=\"20\" value=\"".$Q3a."\" />;Intend to assist in applying barrier-free accommodation<br>Care fee subsidy:<input type=\"text\" name=\"Q3b\" id=\"Q3b\" size=\"20\" value=\"".$Q3b."\" />;Other subsidies:<input type=\"text\" name=\"Q3c\" id=\"Q3c\" size=\"10\" value=\"".$Q3c."\" />",$Q2,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Social welfare/security</td>
    <td valign="top"><h4 class="printcol">Governmental resources</h4><?php echo draw_checkbox_2col("Q48","Proof of disability;Proof of major injury;Rural social security;Veteran/Veteran's dependents;Mid-low/Low-income;Other(s):<input type='text' name='Q48a' id='Q48a' size='15' value='".$Q48a."'>",$Q48,"multi"); ?><h4 class="printcol">Private resources</h4><?php echo draw_checkbox_2col("Q49","Attention of volunteer;Other(s):<input type='text' name='Q49a' id='Q49a' size='15' value='".$Q49a."'>",$Q49,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Economic sources</td>
    <td valign="top" colspan="3"><textarea name="Q52" id="Q52" rows="3" ><?php echo $Q52; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="3" class="title" style="text-align:left;">2. Emotion and behavior</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Demand assessment</td>
    <td class="title_s">Assessment results</td>
  </tr>
  <tr>
    <td class="title_s">Sleep conditions</td>
    <td><?php echo draw_option("Q4","Good;Normal;Day/Night reversed;Rely on medication","l","multi",$Q4,true,2); ?></td>
    <td rowspan="9" valign="top"><?php echo draw_checkbox("Q5","No response;Good adaptation;Adaptation improving, continue processMaladaptive, continue process;Provide emotional support;Encourage participation in group activities",$Q5,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Appetite / tube feeding status</td>
    <td><?php echo draw_option("Q6","Good;Normal;Poor;Antifeeding","m","multi",$Q6,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Mental Status</td>
    <td><?php echo draw_option("Q7","Pleasant;Stable;Normal;Feeling lost;Sad;Irritable;Anxious;Other","sm","multi",$Q7,true,4); ?><input type="text" name="Q7a" id="Q7a" size="10" value="<?php echo $Q7a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Behavior</td>
    <td><?php echo draw_option("Q8","Good;Normal;Behavioral problems","l","multi",$Q8,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Activities participation</td>
    <td><?php echo draw_option("Q9","High;Normal;Low;Refuse;Unable to participate","l","multi",$Q9,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Attention</td>
    <td><?php echo draw_option("Q45","Concentrate;Poor;Excessive concentration;Other","xl","multi",$Q45,true,2); ?><input type="text" name="Q45a" id="Q45a" size="10" value="<?php echo $Q45a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Cerebration/thinking</td>
    <td><?php echo draw_option("Q46","Normal;Delusions;Relaxation;Lack;Jumping/Leaping;Other","xm","multi",$Q46,true,2); ?><input type="text" name="Q46a" id="Q46a" size="10" value="<?php echo $Q46a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Attitude</td>
    <td><?php echo draw_option("Q47","Friendly;Hostile;Wary;Uncooperative;Refuse;Stubborn;Suspicious;Other","m","multi",$Q47,true,3); ?><input type="text" name="Q47a" id="Q47a" size="10" value="<?php echo $Q47a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Comprehension</td>
    <td><?php echo draw_option("Q53","Good;Normal;Poor;Unassessable","xm","single",$Q53,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title" style="text-align:left;">Social dimension </td>
  </tr>
  <tr>
    <td class="title_s">Social skills</td>
    <td colspan="2"><?php echo draw_option("Q54","Active / easy to make friends;Fair;Passive / depend on other;Loner;Resist;Unassessable","xl","single",$Q54,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ability to communicate:</td>
    <td colspan="2"><?php echo draw_option("Q55","Normal;Semantic confusion;Language barrier;Strong accent;Body movements;Unassessable","l","single",$Q55,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with relatives</td>
    <td colspan="2"><?php echo draw_option("Q56","Good;Basic Interaction;Isolated;No relatives;Other","l","single",$Q56,true,3); ?> <input type="text" name="Q56a" id="Q56a" size="18"  value="<?php echo $Q56a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with friends</td>
    <td colspan="2"><?php echo draw_option("Q57","Frequently and good;Occasional;Never;No friend;Other","l","single",$Q57,true,3); ?> <input type="text" name="Q57a" id="Q57a" size="18"  value="<?php echo $Q57a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Interacting with neighbors</td>
    <td colspan="2"><?php echo draw_option("Q58","Frequently and good;Occasional;Never;No neighbor;Other","l","single",$Q58,true,3); ?> <input type="text" name="Q58a" id="Q58a" size="18"  value="<?php echo $Q58a; ?>" /></td>
  </tr>
  <tr>
    <td colspan="3" class="title" style="text-align:left;">3. Relatives visit frequency</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Demand assessment</td>
    <td class="title_s">Assessment results</td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><?php echo draw_checkbox("Q10","Weekly at least <input type=\"text\" name=\"Q11\" id=\"Q11\" size=\"3\" value=\"".$Q11."\" />Time(s);Monthly at least <input type=\"text\" name=\"Q12\" id=\"Q12\" size=\"3\" value=\"".$Q12."\" />Time(s);Occasionally visit;Occasionally visits;Never visited",$Q10,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q13","Invite family members to support caring;Contact family members and held a meeting;Held a case study conference;Keep the family in contact;Provide information of benefits and subsidy",$Q13,"multi"); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title" style="text-align:left;">4. Family support to the facility (involvement of the activity and event)</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Demand assessment</td>
    <td class="title_s">Assessment results</td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><?php echo draw_checkbox("Q14","Highly support;Somewhat support;Not support;Benefits consulting",$Q14,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q15","Invite family members to support caring;Contact family members and held a meeting;Held a case study conference;Keep the family in contact;Provide information of benefits and subsidy",$Q15,"multi"); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title" style="text-align:left;">5. Interpersonal relationships status</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Demand assessment</td>
    <td class="title_s">Assessment results</td>
  </tr>
  <tr>
    <td class="title_s">Interaction with staff</td>
    <td><?php echo draw_option("Q16","Good;Fair;Alienation;Poor/harsh","xs","single",$Q16,false,3); ?></td>
    <td rowspan="3"><?php echo draw_checkbox("Q17","No response;Encourage participation in group activities;Request other resident(s)/ volunteers to assist caring;Help establishing friendship",$Q17,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with other residents</td>
    <td><?php echo draw_option("Q18","Good;Fair;Alienation;Poor/harsh","xs","single",$Q18,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction with family</td>
    <td><?php echo draw_option("Q19","Good;Fair;Alienation;Poor/harsh","xs","single",$Q19,false,3); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title" style="text-align:left;">6. Activity arrangements</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Demand assessment</td>
    <td class="title_s">Assessment results</td>
  </tr>
  <tr>
    <td class="title_s">Activity category</td>
    <td><?php echo draw_option("Q20","Dynamic;Static;Birthday party;Assistive treatment;Other","l","multi",$Q20,true,2); ?><input type="text" name="Q21" id="Q21" size="10" value="<?php echo $Q21; ?>" /></td>
    <td rowspan="2"><?php echo draw_checkbox("Q22","Arrange cultural and recreational activities according to the needs of residents;Evaluate after activity/event;Inform the family if special behavior occurs in the activity",$Q22,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Frequecy of <br>activity arrangement</td>
    <td><?php echo draw_checkbox("Q23","Weekly<input type=\"text\" name=\"Q24\" id=\"Q24\" size=\"3\" value=\"".$Q24."\" />Time(s);Monthly<input type=\"text\" name=\"Q25\" id=\"Q25\" size=\"3\" value=\"".$Q25."\" />Time(s)",$Q23,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="3">Resident's/family expectation to the facility</td>
  </tr>
  <tr>
    <td class="title_s">Resident</td>
    <td colspan="2"><?php echo draw_option("Q50","None;Yes","s","single",$Q50,true,4); ?><input type="text" name="Q50a" id="Q50a" size="80" value="<?php echo $Q50a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Family</td>
    <td colspan="2"><?php echo draw_option("Q51","None;Yes","s","single",$Q51,true,4); ?><input type="text" name="Q51a" id="Q51a" size="80" value="<?php echo $Q51a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Admission information</td>
    <td colspan="2"><?php echo draw_checkbox_2col("Q59","Physical examination report;Admission note;Contract and appendix signature;Open case description",$Q59,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Overall assessment</td>
    <td colspan="2"><textarea name="Q30" id="Q30" cols="90" rows="6" ><?php echo $Q30; ?></textarea></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform02" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form></center><br><br>
