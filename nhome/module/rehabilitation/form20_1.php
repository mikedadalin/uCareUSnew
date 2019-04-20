<?php
if (isset($_POST['save_socialform20_1'])) {
	$Qfiller = $_SESSION['ncareID_lwj'];
	$datetodb = str_replace("/","",$_POST['date']);
	$dbc = new DB;
	$dbc->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($datetodb)."' AND `Qreplyto`='".mysql_escape_string($_POST['Qreplyto'])."'");
	if ($dbc->num_rows()==0) {
		$db1 = new DB;
		$db1->query("INSERT INTO `socialform20_1` VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".$datetodb."', '".mysql_escape_string($_POST['Q1_1'])."', '".mysql_escape_string($_POST['Q1_5'])."', '".mysql_escape_string($_POST['Q1_2'])."', '".mysql_escape_string($_POST['Q1_6'])."', '".mysql_escape_string($_POST['Q1_3'])."', '".mysql_escape_string($_POST['Q1_7'])."', '".mysql_escape_string($_POST['Q1a'])."', '".mysql_escape_string($_POST['Q1_4'])."', '".mysql_escape_string($_POST['Q1_8'])."', '".mysql_escape_string($_POST['Q1b'])."', '".mysql_escape_string($_POST['Q2_1'])."', '".mysql_escape_string($_POST['Q2_6'])."', '".mysql_escape_string($_POST['Q2c'])."', '".mysql_escape_string($_POST['Q2_2'])."', '".mysql_escape_string($_POST['Q2_7'])."', '".mysql_escape_string($_POST['Q2a'])."', '".mysql_escape_string($_POST['Q2d'])."', '".mysql_escape_string($_POST['Q2_3'])."', '".mysql_escape_string($_POST['Q2_8'])."', '".mysql_escape_string($_POST['Q2e'])."', '".mysql_escape_string($_POST['Q2_4'])."', '".mysql_escape_string($_POST['Q2_9'])."', '".mysql_escape_string($_POST['Q2f'])."', '".mysql_escape_string($_POST['Q2_5'])."', '".mysql_escape_string($_POST['Q2b'])."', '".mysql_escape_string($_POST['Qreplyto'])."', '".mysql_escape_string($Qfiller)."');");
	} else {
		$db1 = new DB;
		$db1->query("UPDATE `socialform20_1` SET `Q1_1`='".mysql_escape_string($_POST['Q1_1'])."', `Q1_5`='".mysql_escape_string($_POST['Q1_5'])."', `Q1_2`='".mysql_escape_string($_POST['Q1_2'])."', `Q1_6`='".mysql_escape_string($_POST['Q1_6'])."', `Q1_3`='".mysql_escape_string($_POST['Q1_3'])."', `Q1_7`='".mysql_escape_string($_POST['Q1_7'])."', `Q1a`='".mysql_escape_string($_POST['Q1a'])."', `Q1_4`='".mysql_escape_string($_POST['Q1_4'])."', `Q1_8`='".mysql_escape_string($_POST['Q1_8'])."', `Q1b`='".mysql_escape_string($_POST['Q1b'])."', `Q2_1`='".mysql_escape_string($_POST['Q2_1'])."', `Q2_6`='".mysql_escape_string($_POST['Q2_6'])."', `Q2c`='".mysql_escape_string($_POST['Q2c'])."', `Q2_2`='".mysql_escape_string($_POST['Q2_2'])."', `Q2_7`='".mysql_escape_string($_POST['Q2_7'])."', `Q2a`='".mysql_escape_string($_POST['Q2a'])."', `Q2d`='".mysql_escape_string($_POST['Q2d'])."', `Q2_3`='".mysql_escape_string($_POST['Q2_3'])."', `Q2_8`='".mysql_escape_string($_POST['Q2_8'])."', `Q2e`='".mysql_escape_string($_POST['Q2e'])."', `Q2_4`='".mysql_escape_string($_POST['Q2_4'])."', `Q2_9`='".mysql_escape_string($_POST['Q2_9'])."', `Q2f`='".mysql_escape_string($_POST['Q2f'])."', `Q2_5`='".mysql_escape_string($_POST['Q2_5'])."', `Q2b`='".mysql_escape_string($_POST['Q2b'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($datetodb)."' AND `Qreplyto`='".mysql_escape_string($_POST['Qreplyto'])."'");
	}
	echo "<script>window.onbeforeunload=null;window.location.href='index.php?mod=rehabilitation&func=formview&pid=".@$_GET['pid']."&id=20'</script>";
}

$pid = (int) @$_GET['pid'];
$db1 = new DB;
$db1->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."' AND `Qreplyto`='".mysql_escape_string($_GET['reply'])."'");
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
<form  method="post" onSubmit="return checkForm();" action="index.php?mod=rehabilitation&func=formview&pid=<?php echo mysql_escape_string($pid); ?>&id=20_1">
<h3>Rehabilitation Therapy Notification</h3>

<?php
if (@$_GET['reply']=="") {
	$sql = "SELECT * FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['reply'])."'";
} else {
	$sql = "SELECT * FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['reply'])."'";
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
<table width="100%">
  <tr>
    <td class="title" colspan="6" style="font-size:18px;">Nursing Department</td>
  </tr>
  <tr>
    <td class="title_s" width="120"><p>Date</p></td>
    <td width="220"><?php echo $nurseform02j_Q1; ?></td>
    <td class="title_s" width="120"><p>Time </p></td>
    <td colspan="3"><?php echo $nurseform02j_Q2; ?>:<?php echo $nurseform02j_Q3; ?></td>
  </tr>
  <tr>

    <td class="title_s"><p>Consciousness</p></td>
    <td><?php echo option_result("nurseform02j_Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","m","single",$nurseform02j_Q4,false,0); ?> (Glasgow coma scale: E <?php echo $nurseform02j_Q5_a; ?> M <?php echo $nurseform02j_Q5_b; ?> V <?php echo $nurseform02j_Q5_c; ?>)</td>
    <td class="title_s"><p>Cognition</p></td>
    <td width="160"><?php echo option_result("nurseform02j_Q6","Clear;Dementia","m","single",$nurseform02j_Q6,false,0); ?></td>
    <td class="title_s" width="120"><p>Observation</p></td>
    <td><?php echo option_result("nurseform02j_Q7","Chief complaint;Behavior observed","m","single",$nurseform02j_Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Start time</td>
    <td><?php echo $nurseform02j_Q8; ?> <?php echo $nurseform02j_Q9; ?>:<?php echo $nurseform02j_Q10; ?></td>
    <td class="title_s"><p>Duration</p></td>
    <td colspan="3"><?php echo option_result("nurseform02j_Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$nurseform02j_Q11,false,0); ?></td>
  </tr>
  <tr>

    <td class="title_s"><p>Pain reaction</p></td>
    <td><?php echo option_result("nurseform02j_Q12","Avoid pressing;Frown;Afraid to move;Moan;Lean;Other","m","multi",$nurseform02j_Q12,false,5); ?>：<?php echo $nurseform02j_Q12a; ?></td>
    <td class="title_s"><p>Pain location</p></td>

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

    <td class="title_s"><p>Aggravating factors</p></td>
    <td><?php echo option_result("nurseform02j_Q17","Movement;Touch;Pressing;Cough;Other","m","multi",$nurseform02j_Q17,true,6); ?>：<?php echo $nurseform02j_Q17a; ?></td>
    <td class="title_s"><p>Alleviating factors</p></td>
    <td><?php echo option_result("nurseform02j_Q18","Fixed;Not touch;Icing;Other","m","multi",$nurseform02j_Q18,true,6); ?>：<?php echo $nurseform02j_Q18a; ?></td>
    <td class="title_s"><p>Associated influence</p></td>
    <td><?php echo option_result("nurseform02j_Q19","睡眠障礎;食慾變差;無法參與活動;無法下床;無法行走;情緒影響;不想理人;Irritability;Other","m","multi",$nurseform02j_Q19,true,6); ?>：<?php echo $nurseform02j_Q19a; ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" colspan="6" style="font-size:18px;">Rehabilitation Department</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Priority care</td>
    <td><?php echo draw_checkbox_2col("Q1","Icing;Bed rest;Rehabilitation therapy;Sore muscle relief ointments;Observation/monitoring;Hospitalize;Medication prescription:<input type=\"text\" name=\"Q1a\" id=\"Q1a\" size=\"30\" value=\"".$Q1a."\" />;Other(s):<input type=\"text\" name=\"Q1b\" id=\"Q1b\" size=\"35\" value=\"".$Q1b."\" />",$Q1,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s" width="120">Aftercare suggestion</td>
    <td><?php echo draw_checkbox_2col("Q2","Arrange rehabilitation;Wheelchair<input type=\"text\" name=\"Q2a\" id=\"Q2a\" size=\"1\" value=\"".$Q2a."\" />Day(s);Sore muscle relief ointments;Sore muscle relief patch;Assistive devices recommendations:<input type=\"text\" name=\"Q2b\" id=\"Q2b\" size=\"20\" value=\"".$Q2b."\" />;Placement recommendations:<input type=\"text\" name=\"Q2c\" id=\"Q2c\" size=\"20\" value=\"".$Q2c."\" />;Displacement recommendation:<input type=\"text\" name=\"Q2d\" id=\"Q2d\" size=\"20\" value=\"".$Q2d."\" />;Medication prescription:<input type=\"text\" name=\"Q2e\" id=\"Q2e\" size=\"20\" value=\"".$Q2e."\" />;Other(s):<input type=\"text\" name=\"Q2f\" id=\"Q2f\" size=\"25\" value=\"".$Q2f."\" />",$Q2,"multi"); ?></td>
  </tr>
</table>
<?php
if (@$_GET['reply']=="") {
	$sql = "SELECT * FROM `socialform20_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['reply'])."'";
} else {
	$sql = "SELECT * FROM `socialform20_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['reply'])."'";
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
    <td class="title" colspan="2" style="font-size:18px;">Social Working Group</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Social workers' suggestion</td>
    <td><?php echo checkbox_result("socialform20_2_Q1","Status understood, thanks for notifying !;Psychological/mental support;Arrange care / social activities;Hospice care;Family expectation consulting and communication;Adaptational counseling-New resident admission/bed relocate;Social welfare resource consulting;Family economic difficulties assistance;Other(s):".$socialform20_2_Q1a."",$socialform20_2_Q1,"multi"); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
	<div style="margin-top:50px;">
	<input type="hidden" name="Qreplyto" id="Qreplyto" value="<?php echo mysql_escape_string($_GET['reply']); ?>" /><input type="hidden" name="formID" id="formID" value="socialform20_1" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" id="save_socialform20_1" name="save_socialform20_1" value="Save" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
	</div>
</center>
</form><br><br>
