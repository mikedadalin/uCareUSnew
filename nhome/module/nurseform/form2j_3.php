<?php
if (@$_GET['Q1']=='') {
	$sql = "SELECT * FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
					${'nurseform02j_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'nurseform02j_'.$k} = $v;
			}
		}  else {
			${'nurseform02j_'.$k} = $v;
		}
	}
}
?>
<h3>Pain assessment and rehabilitation, social working notification form</h3>
<table width="100%">
  <tr>
    <td class="title" colspan="6">Nursing department</td>
  </tr>
  <tr>
    <td class="title_s" width="120"><p>Date</p></td>
    <td width="220"><?php echo $nurseform02j_Q1; ?></td>
    <td class="title_s" width="120"><p>Time </p></td>
    <td colspan="3"><?php echo $nurseform02j_Q2; ?>:<?php echo $nurseform02j_Q3; ?></td>
  </tr>
  <tr>
    <td class="title"><p>Consciousness</p></td>
    <td><?php echo option_result("nurseform02j_Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","m","single",$nurseform02j_Q4,false,0); ?> (Glasgow coma scale: E <?php echo $nurseform02j_Q5_a; ?> M <?php echo $nurseform02j_Q5_b; ?> V <?php echo $nurseform02j_Q5_c; ?>)</td>
    <td class="title"><p>Cognition</p></td>
    <td width="160"><?php echo option_result("nurseform02j_Q6","Clear;Dementia","m","single",$nurseform02j_Q6,false,0); ?></td>
    <td class="title" width="120"><p>Observation</p></td>

    <td><?php echo option_result("nurseform02j_Q7","Chief complaint;Behavior observed","m","single",$nurseform02j_Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Start time</td>
    <td><?php echo $nurseform02j_Q8; ?> <?php echo $nurseform02j_Q9; ?>:<?php echo $nurseform02j_Q10; ?></td>
    <td class="title_s"><p>Duration</p></td>
    <td colspan="3"><?php echo option_result("nurseform02j_Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$nurseform02j_Q11,false,0); ?></td>
  </tr>
  <tr>

    <td class="title"><p>Pain reaction</p></td>
    <td><?php echo option_result("nurseform02j_Q12","Avoid pressing;Frown;Afraid to move;Moan;Lean;Other","m","multi",$nurseform02j_Q12,false,5); ?>：<?php echo $nurseform02j_Q12a; ?></td>
    <td class="title"><p>Pain location</p></td>

    <td><?php echo $nurseform02j_Q13; ?></td>
    <td class="title_s"><p>inflammation</p></td>
    <td colspan="3">Appearance <?php echo option_result("nurseform02j_Q14","Reddish;Swollen;Heat;Pain","s","multi",$nurseform02j_Q14,false,5); ?>：<?php echo $nurseform02j_Q14a; ?></td>
  </tr>
  <tr>
    <td class="title_s"><p>Pain Severity</p></td>
    <td><?php echo option_result("nurseform02j_Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$nurseform02j_Q15,false,5); ?></td>
    <td class="title_s"><p>Pain characteristic</p></td>
    <td colspan="3"><?php echo option_result("nurseform02j_Q16","Soreness;Throbbing;Stinging;Dull pain;Searing pain;Indescribable;Can't express","m","multi",$nurseform02j_Q16,false,5); ?></td>
  </tr>
  <tr>

    <td class="title"><p>Aggravating factors</p></td>
    <td><?php echo option_result("nurseform02j_Q17","Movement;Touch;Pressing;Cough;Other","m","multi",$nurseform02j_Q17,true,6); ?>：<?php echo $nurseform02j_Q17a; ?></td>
    <td class="title"><p>Alleviating factors</p></td>
    <td><?php echo option_result("nurseform02j_Q18","Fixed;Not touch;Icing;Other","m","multi",$nurseform02j_Q18,true,6); ?>：<?php echo $nurseform02j_Q18a; ?></td>
    <td class="title"><p>Associated influence</p></td>
    <td><?php echo option_result("nurseform02j_Q19","睡眠障礎;食慾變差;無法參與活動;無法下床;無法行走;情緒影響;不想理人;Irritability;Other","m","multi",$nurseform02j_Q19,true,6); ?>：<?php echo $nurseform02j_Q19a; ?></td>

  </tr>
  <tr>
    <td class="title_s"><p>Notify physiotherapist</p></td>
    <td><?php echo option_result("nurseform02j_Q20","Notify;Do Not notify","m","multi",$nurseform02j_Q20,true,6); ?></td>
    <td class="title_s"><p>Notify social worker</p></td>
    <td><?php echo option_result("nurseform02j_Q21","Notify;Do Not notify","m","multi",$nurseform02j_Q21,true,6); ?></td>
    <td class="title_s"><p>Filled by</p></td>
    <td><?php echo checkusername($nurseform02j_Qfiller); ?></td>
  </tr>
</table>

<?php
$sql = "SELECT * FROM `socialform20_1` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `Qreplyto`='".mysql_escape_string($_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'socialform20_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'socialform20_'.$k} = $v;
			}
		}  else {
			${'socialform20_'.$k} = $v;
		}
	}
}
?>
<table width="100%">
  <tr>
    <td class="title" colspan="2">Rehabilitation department</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Priority care</td>
    <td><?php echo checkbox_2col_result("socialform20_Q1","Icing;Bed rest;Rehabilitation therapy;Sore muscle relief ointments;Observation/monitoring;Hospitalize;Medication prescription:".$socialform20_Q1a.";Other(s):".$socialform20_Q1b,$socialform20_Q1,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s" width="120">Aftercare suggestion</td>
    <td><?php echo checkbox_2col_result("socialform20_Q2","Arrange rehabilitation;Wheelchair ".$socialform20_Q2a." Day(s);Sore muscle relief ointments;Sore muscle relief patch;Assistive devices recommendations:".$socialform20_Q2b.";Placement recommendations:".$socialform20_Q2c.";Displacement recommendation:".$socialform20_Q2d.";Medication prescription:".$socialform20_Q2e.";Other(s):".$socialform20_Q2f."",$socialform20_Q2,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Filled by</td>
    <td><?php echo checkusername($socialform20_Qfiller); ?></td>
  </tr>
</table>
<?php
$sql = "SELECT * FROM `socialform20_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `Qreplyto`='".mysql_escape_string($_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${'socialform20_2_'.$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${'socialform20_2_'.$k} = $v;
			}
		}  else {
			${'socialform20_2_'.$k} = $v;
		}
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%">
  <tr>
    <td class="title" colspan="2">Social working group</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Social workers' suggestion</td>
    <td><?php echo checkbox_result("socialform20_2_Q1","Status understood, thanks for notifying !;Psychological/mental support;Arrange care / social activities;Hospice care;Family expectation consulting and communication;Adaptational counseling-New resident admission/bed relocate;Social welfare resource consulting;Family economic difficulties assistance;Other(s):".$socialform20_2_Q1a."",$socialform20_2_Q1,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Filled by</td>
    <td><?php echo checkusername($socialform20_2_Qfiller); ?></td>
  </tr>
</table>

<?php
if (isset($_POST['saveassess'])) {
	$dbc = new DB;
	$dbc->query("SELECT * FROM `nurseform02j_3` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `Q1`='".mysql_escape_string($_POST['Q1'])."'");
	if ($dbc->num_rows()==0) {
		$db = new DB;
		$db->query("INSERT INTO `nurseform02j_3` VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".str_replace("/","",$_POST['date'])."', '".mysql_escape_string($_POST['Q1'])."', '".mysql_escape_string($_POST['Q2_1'])."', '".mysql_escape_string($_POST['Q2_2'])."', '".mysql_escape_string($_POST['Q2_3'])."', '".mysql_escape_string($_POST['Q2_4'])."', '".mysql_escape_string($_POST['Q2_5'])."', '".mysql_escape_string($_POST['Q2a'])."', '".mysql_escape_string($_POST['Q3_1'])."', '".mysql_escape_string($_POST['Q3_2'])."', '".mysql_escape_string($_POST['Q3_3'])."', '".mysql_escape_string($_POST['Q3_4'])."', '".mysql_escape_string($_POST['Q3_5'])."', '".mysql_escape_string($_POST['Q3_6'])."', '".str_replace("/n","<br>",$_POST['Q4'])."','".str_replace("/n","<br>",$_POST['Q5'])."', '".mysql_escape_string($_POST['Q6_1'])."', '".mysql_escape_string($_POST['Q6_2'])."', '".mysql_escape_string($_POST['Q6_3'])."', '".mysql_escape_string($_POST['Q6_4'])."', '".mysql_escape_string($_POST['Q6_5'])."', '".mysql_escape_string($_POST['Q6a'])."', '".mysql_escape_string($_POST['Qfiller'])."')");
	} else {
		$db = new DB;
		$db->query("UPDATE `nurseform02j_3` SET `Q2_1`='".mysql_escape_string($_POST['Q2_1'])."', `Q2_2`='".mysql_escape_string($_POST['Q2_2'])."', `Q2_3`='".mysql_escape_string($_POST['Q2_3'])."', `Q2_4`='".mysql_escape_string($_POST['Q2_4'])."', `Q2_5`='".mysql_escape_string($_POST['Q2_5'])."', `Q2a`='".mysql_escape_string($_POST['Q2a'])."', `Q3_1`='".mysql_escape_string($_POST['Q3_1'])."', `Q3_2`='".mysql_escape_string($_POST['Q3_2'])."', `Q3_3`='".mysql_escape_string($_POST['Q3_3'])."', `Q3_4`='".mysql_escape_string($_POST['Q3_4'])."', `Q3_5`='".mysql_escape_string($_POST['Q3_5'])."', `Q3_6`='".mysql_escape_string($_POST['Q3_6'])."', `Q4`= '".str_replace("\n","<br>",$_POST['Q4'])."', `Q5`= '".str_replace("\n","<br>",$_POST['Q5'])."', `Q6_1`='".mysql_escape_string($_POST['Q6_1'])."', `Q6_2`='".mysql_escape_string($_POST['Q6_2'])."', `Q6_3`='".mysql_escape_string($_POST['Q6_3'])."', `Q6_4`='".mysql_escape_string($_POST['Q6_4'])."', `Q6_5`='".mysql_escape_string($_POST['Q6_5'])."', `Q6a`='".mysql_escape_string($_POST['Q6a'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `Q1`='".mysql_escape_string($_POST['Q1'])."'");
	}
	echo '<script>window.location.href=\'index.php?mod=nurseform&func=formview&pid='.getPID($_POST['HospNo']).'&id=2j\';</script>';
}
?><hr>
<form action="index.php?mod=nurseform&func=formview&id=2j_3" method="post">
<table width="100%">
  <tr>
    <td class="title" colspan="7">Tracing evaluation</td>
  </tr>
  <tr class="title_s">
    <td width="90" nowrap>Evaluation date</td>
    <td width="90" nowrap>Case closed reason</td>
    <td width="180" nowrap>inflammation</td>
    <td width="90" nowrap>Pain Severity</td>
    <td nowrap>Changes in pain relieving</td>
    <td nowrap>Amended treatment</td>
    <td width="90">Evaluators</td>
  </tr>
<?php
$db2 = new DB;
$db2->query("SELECT * FROM `nurseform02j_3` WHERE `HospNo`='".$HospNo."' AND `Q1`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` ASC");
for ($i=0;$i<$db2->num_rows();$i++) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
	echo '
  <tr>
	<td >'.formatdate($date).'</td>
	<td ><center>'.option_result("Q6","Improved;Discharged;Transfered;Death;Other","m","single",$Q6,true,3,2).'</center></td>
	<td ><center>'.checkbox_result("Q2","Reddish;Swollen (".$Q2a.");Heat;Pain;No longer inflammation",$Q2,"single").'</center></td>
	<td ><center>'.option_result("Q3","No pain(0);Mild pain(2);Moderate pain(4);Moderate pain(6);Severe pain(8);Worst pain possible(10)","l","single",$Q3,true,3,2).'</center></td>
	<td ><center>'.$Q4.'</center></td>
	<td ><center>'.$Q5.'</center></td>
	<td ><center>'.checkusername($Qfiller).'</center></td>
  </tr>'."\n";
	foreach ($r2 as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}
}
?>
</table>
</form>
<?php
$db2a = new DB;
$db2a->query("SELECT * FROM `nurseform02j_3` WHERE `HospNo`='".$HospNo."' AND `Q1`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC LIMIT 0,1");
if ($db2a->num_rows()>0) {
	$r2a = $db2a->fetch_assoc();
	foreach ($r2a as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
}
?>
<br />
<div class="printcol">
<form action="index.php?mod=nurseform&func=formview&id=2j_3" method="post">
<table width="100%">
  <tr>
    <td rowspan="6" class="title" width="20">Follow up<br />assessment</td>
    <td class="title_s">inflammation</td>
    <td><?php echo draw_checkbox_2col("Q2","Reddish;Swollen (<input type='text' name='Q2a' id='Q2a' value='".$Q2a."' size='1'>);Heat;Pain;No longer inflammation",$Q2,"single"); ?></td>
    <td class="title_s" width="100">Pain Severity</td>
    <td width="240"><?php echo draw_option("Q3","No pain(0);Mild pain(2);Moderate pain(4);Moderate pain(6);Severe pain(8);Worst pain possible(10)","xl","single",$Q3,true,1); ?></td>
  </tr>
  <tr>
    <td class="title_s" nowrap>Changes in<br />pain relieving</td>
    <td><textarea name="Q4" id="Q4" cols="40" rows="5"><?php echo str_replace("<br>","\n",$Q4); ?></textarea></td>
    <td class="title_s">Amended treatment</td>
    <td><textarea name="Q5" id="Q5" cols="40" rows="5"><?php echo str_replace("<br>","\n",$Q5); ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Case closed reason</td>
    <td><?php echo draw_option("Q6","Improved;Discharged;Transfered;Death;Other","m","single",$Q6,true,3); ?><input type="text" id="Q6a" name="Q6a" value="<?php echo $Q6a; ?>" /></td>
    <td width="100" class="title_s">Evaluation date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="date" name="date" value="<?php echo ($date==""?date("Y/m/d"):formatdate($date)); ?>" size="12" />
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $HospNo; ?>" />
    <input type="hidden" id="Q1" name="Q1" value="<?php echo @$_GET['date']; ?>" />
    <input type="hidden" id="Qfiller" name="Qfiller" value="<?php echo ($Qfiller==""?$_SESSION['ncareID_lwj']:$Qfiller); ?>" />
    <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="hidden" id="saveassess" name="saveassess" value="Save"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?>
    </td>
  </tr>
</table>
</form><br><br>
</div>