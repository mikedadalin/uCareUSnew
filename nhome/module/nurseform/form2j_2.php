<?php
if (@$_GET['date']=='') {
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
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
</table><br><br>