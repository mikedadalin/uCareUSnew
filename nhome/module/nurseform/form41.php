<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform41` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform41` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save&url=<?php echo urlencode($_GET['url']); ?>">
<h3>Functional Status</h3>
<table width="100%">
  <tr>
    <td class="title" colspan="3" width="15%">Activities of Daily Living Assistance</td>
    <td class="title" colspan="1" width="42.5%">ADL Self-Performance</td>
    <td class="title" colspan="1" width="42.5%">ADL Support Provided</td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Bed mobility</td>
    <td colspan="1"><?php echo draw_option("Q1","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q1,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q2","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q2,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Transfer</td>
    <td colspan="1"><?php echo draw_option("Q3","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q3,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q4","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q4,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Walk in room</td>
    <td colspan="1"><?php echo draw_option("Q5","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q5,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q6","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q6,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Walk in corridor</td>
    <td colspan="1"><?php echo draw_option("Q7","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q7,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q8","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q8,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Locomotion on unit</td>
    <td colspan="1"><?php echo draw_option("Q9","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q9,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q10","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q10,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Locomotion off unit</td>
    <td colspan="1"><?php echo draw_option("Q11","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q11,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q12","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q12,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Dressing</td>
    <td colspan="1"><?php echo draw_option("Q13","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q13,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q14","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q14,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Eating</td>
    <td colspan="1"><?php echo draw_option("Q15","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q15,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q16","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q16,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Toilet use</td>
    <td colspan="1"><?php echo draw_option("Q17","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q17,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q18","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q18,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Personal hygiene</td>
    <td colspan="1"><?php echo draw_option("Q19","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity occurred only once or twice;Activity did not occur","xxl","single",$Q19,true,1); ?></td>
    <td colspan="1"><?php echo draw_option("Q20","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q20,true,1); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Bathing</td>
    <td colspan="1"><?php echo draw_option("Q21","Independent;Supervision;Limited assistance;Exensive assistance;Total dependence;Activity did not occur","l","single",$Q21,true,2); ?></td>
    <td colspan="1"><?php echo draw_option("Q22","No setup or physical help from staff;Setup help only;One person physical assist;2+ persons physical assist;ADL activity didn't occur or others provide care 100%","xxxxxl","single",$Q22,true,1); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title_s" width="30%">Resident believes he or she is capable of increased independence</td>
    <td width="28%"><?php echo draw_option("Q23","No;Yes;Unable to determine","l","single",$Q23,false,6); ?></td>
    <td class="title_s" width="30%">Direct care staff believe resident is capable of increased independence</td>
    <td width="12%"><?php echo draw_option("Q24","No;Yes","s","single",$Q24,false,6); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by：<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
  <div style="margin:20px auto;">
    <input type="hidden" name="formID" id="formID" value="nurseform41" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
  </div>
</center>
</form>
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
