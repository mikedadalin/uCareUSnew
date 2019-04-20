<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4` FROM `nurseform01` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=4;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
if (isset($_POST['submit_delete'])) {
	$db1 = new DB;
	$db1->query("DELETE FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."'");
	echo '<script>window.location.href=\'index.php?mod=nurseform&func=formview&pid='.getPID($_POST['HospNo']).'&id=2j\';</script>';
}
?>
<div class="content-query">
<table align="center">
  <tr>
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title">Full name</td>
    <td><?php echo $name; ?></td>
    <td class="title">DOB</td>
    <td><?php echo $birth.' ('.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title">Admission date</td>
    <td><?php echo $indate; ?></td>
    <td class="title">Diagnosis</td>
    <td><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
<table border="0" style="text-align:left; padding-left:20px;">
  <tr>
    <td>
    <h3>Confirm deletion of this data?</h3>
    <?php
	$db3 = new DB;
	$db3->query("SELECT * FROM `nurseform02j` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."'");
	if ($db3->num_rows()>0) {
		$r3 = $db3->fetch_assoc();
		foreach ($r3 as $k=>$v) {
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
    <div class="content-query">
<table width="100%">
  <tr>
    <td class="title" width="120"><p>Date</p></td>
    <td width="220"><?php echo $nurseform02j_Q1; ?></td>
    <td class="title" width="120"><p>Time </p></td>
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
    <td class="title">Start time</td>
    <td><?php echo $nurseform02j_Q8; ?> <?php echo $nurseform02j_Q9; ?>:<?php echo $nurseform02j_Q10; ?></td>
    <td class="title"><p>Duration</p></td>
    <td colspan="3"><?php echo option_result("nurseform02j_Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$nurseform02j_Q11,false,0); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Pain reaction</p></td>
    <td><?php echo option_result("nurseform02j_Q12","Avoid pressing;Frown;Afraid to move;Moan;Lean;Other","m","multi",$nurseform02j_Q12,false,5); ?>：<?php echo $nurseform02j_Q12a; ?></td>
    <td class="title"><p>Pain location</p></td>
    <td><?php echo $nurseform02j_Q13; ?></td>
    <td class="title"><p>inflammation</p></td>
    <td colspan="3">Appearance <?php echo option_result("nurseform02j_Q14","Reddish;Swollen;Heat;Pain","s","multi",$nurseform02j_Q14,false,5); ?>：<?php echo $nurseform02j_Q14a; ?></td>
  </tr>
  <tr>
    <td class="title"><p>Pain Severity</p></td>
    <td><?php echo option_result("nurseform02j_Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$nurseform02j_Q15,false,5); ?></td>
    <td class="title"><p>Pain characteristic</p></td>
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
    <td class="title"><p>Notify physiotherapist</p></td>
    <td><?php echo option_result("nurseform02j_Q20","Notify;Do Not notify","m","multi",$nurseform02j_Q20,true,6); ?></td>
    <td class="title"><p>Notify social worker</p></td>
    <td><?php echo option_result("nurseform02j_Q21","Notify;Do Not notify","m","multi",$nurseform02j_Q21,true,6); ?></td>
    <td class="title"><p>Filled by</p></td>
    <td><?php echo checkusername($nurseform02j_Qfiller); ?></td>
  </tr>
</table>
    <form action="index.php?mod=nurseform&func=nurseform2jdelete" method="post">
    <input type="hidden" id="formID" name="formID" value="nurseform05">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $HospNo; ?>">
    <input type="hidden" id="date" name="date" value="<?php echo @$_GET['date']; ?>">
    <input type="hidden" id="time" name="time" value="<?php echo @$_GET['time']; ?>">
    <input type="hidden" id="Q2" name="Q2" value="<?php echo @$_GET['Q2']; ?>">
    <input type="submit" name="submit_delete" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>