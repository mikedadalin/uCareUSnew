<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform10b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform10b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<h3>Individual care plan</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save&permission=ignore">
<table border="0" style="width:100%;">
  <tr>
    <td class="title" colspan="6">Problem Status and Demand Assessment</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Filled Date</td>
    <td colspan="5" align="left"><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); }else{ echo date("Y/m/d");} ?>" size="10"></td>
  </tr>
  <tr>
    <td colspan="6" class="title">Nursing group</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Past Medical History</td>
    <td colspan="5"><?php echo $Q1; ?></td>
  </tr>
  <tr>
    <td class="title_s">Medication Status</td>
    <td colspan="5"><?php echo $Q2; ?></td>
  </tr>
  <tr>
    <td class="title_s">Cognitive Function</td>
    <td colspan="5"><?php echo $Q3; ?></td>
    </td>
  </tr>
  <tr>
    <td class="title_s">Problem Assessment<br>(Please List)</td>
    <td colspan="5"><?php echo $Q4; ?></td>
  </tr>
  <tr>
    <td colspan="6" class="title" width="100">Social working group</td>
  </tr>
  <tr>
    <td class="title_s">Psychological Level</td>
    <td colspan="5"><textarea id="Q5" name="Q5"  cols="30" rows="2"><?php echo $Q5; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Environmental Adaptation</td>
    <td colspan="5"><textarea id="Q6" name="Q6"  cols="30" rows="2"><?php echo $Q6; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Social Resource<br />(Including the ecosystem level)</td>
    <td colspan="5"><textarea id="Q7" name="Q7"  cols="30" rows="2"><?php echo $Q7; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Resident's Family Status<br />(Including emotional, economy status)</td>
    <td colspan="5"><textarea id="Q8" name="Q8"  cols="30" rows="2"><?php echo $Q8; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Resistance Assessment<br />Demand Assessment<br />(Please List)</td>
    <td colspan="5"><textarea id="Q9" name="Q9"  cols="30" rows="4"><?php echo $Q9; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="6" class="title" width="100">Rehabilitation Group</td>
  </tr>
  <tr>
    <td class="title_s">Joint Activity</td>
    <td colspan="5"><?php echo $Q10; ?></td>
  </tr>
  <tr>
    <td class="title_s">Muscle Strength Performance</td>
    <td colspan="5"><?php echo $Q11; ?></td>
  </tr>
  <tr>
    <td class="title_s">Sensation</td>
    <td colspan="5"><?php echo $Q12; ?></td>
  </tr>
  <tr>
    <td class="title_s">Physical Performance</td>
    <td colspan="5"><?php echo $Q13; ?></td>
  </tr>
  <tr>
    <td class="title_s">Problem Assessment<br />(Please List)</td>
    <td colspan="5"><?php echo $Q14; ?></td>
  </tr>
  <tr>
    <td colspan="6" class="title">Comprehensive care goal(s)</td>
  </tr>
  <tr>
    <td class="title_s" width="100">Nursing Group</td>
    <td colspan="5"><?php echo $Q15; ?></td>
  </tr>
  <tr>
    <td class="title" colspan="6">Treatment (include care goals and implementation)</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Nursing Group</td>
    <td colspan="5"><?php echo $Q16; ?>
    </td>
  </tr>
  <tr>
    <td class="title_s" width="100">Social Working Group</td>
    <td colspan="5"><textarea id="Q17" name="Q17"  cols="60" rows="5"><?php echo $Q17; ?></textarea></td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Rehabilitation Group</td>
    <td colspan="5"><?php echo $Q18; ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">Nursing Group Staff</td>
    <td width="200"><?php echo $Qfiller1==""?"":checkusername($Qfiller1); ?></td>
    <td class="title_s">Social Working Group Staff</td>
    <td width="200"><?php echo $Qfiller2==""?checkusername($_SESSION['ncareID_lwj']):checkusername($Qfiller2); ?><input type="hidden" name="Qfiller2" id="Qfiller2" value="<?php echo $_SESSION['ncareID_lwj']; ?>" /></td>
    <td class="title_s">Rehabilitation Group Staff</td>
    <td width="200"><?php echo $Qfiller3==""?"":checkusername($Qfiller3); ?></td>
  </tr>
</table>
<center><div style="margin-top:40px"><input type="hidden" name="formID" id="formID" value="socialform10b" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></div></center>
</form><br>
</div>