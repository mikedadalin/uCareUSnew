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
<h3>Individual care plan</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save&permission=ignore">
<table width="100%" border="0">
  <tr>
    <td class="title" colspan="2">Problem Status and Demand Assessment</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Filled date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); }else{ echo date("Y/m/d");} ?>" size="10"></td>
  </tr>
  <tr>
    <td colspan="2" class="title">Nursing Group</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Past medical history</td>
    <td><?php echo $Q1; ?></td>
  </tr>
  <tr>
    <td class="title_s">Medication status</td>
    <td><?php echo $Q2; ?></td>
  </tr>
  <tr>
    <td class="title_s">Cognitive function</td>
    <td><?php echo $Q3; ?></td>
    </td>
  </tr>
  <tr>
    <td class="title_s">Problem assessment<br>(please list)</td>
    <td><?php echo $Q4; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title" width="100">Social Working Group</td>
  </tr>
  <tr>
    <td class="title_s">Psychological level</td>
    <td><?php echo $Q5; ?></td>
  </tr>
  <tr>
    <td class="title_s">Environmental adaptation</td>
    <td><?php echo $Q6; ?></td>
  </tr>
  <tr>
    <td class="title_s">Social resource<br />(Including the ecosystem level)</td>
    <td><?php echo $Q7; ?></td>
  </tr>
  <tr>
    <td class="title_s">Resident's family status<br />(Including emotional, economy status)</td>
    <td><?php echo $Q8; ?></td>
  </tr>
  <tr>
    <td class="title_s">Resistance assessment<br />Demand assessment<br />(please list)</td>
    <td><?php echo $Q9; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title" width="100">Rehabilitation Group</td>
  </tr>
  <tr>
    <td class="title_s">Joint activity</td>
    <td><textarea id="Q10" name="Q10"  cols="30" rows="2"><?php echo $Q10; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Muscle strength performance</td>
    <td><textarea id="Q11" name="Q11"  cols="30" rows="2"><?php echo $Q11; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Sensation</td>
    <td><textarea id="Q12" name="Q12"  cols="30" rows="2"><?php echo $Q12; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Physical performance</td>
    <td><textarea id="Q13" name="Q13"  cols="30" rows="2"><?php echo $Q13; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Problem assessment<br />(please list)</td>
    <td><textarea id="Q14" name="Q14"  cols="30" rows="4"><?php echo $Q14; ?></textarea></td>
  </tr>
  
  <tr>
    <td colspan="2" class="title">Comprehensive Care Goal(s)</td>
  </tr>
  <tr>
    <td class="title_s" width="100">Nursing group</td>
    <td><?php echo $Q15; ?></td>
  </tr>
<tr>
    <td class="title" colspan="2">Treatment (include care goals and implementation)</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Nursing group</td>
    <td><?php echo $Q16; ?></td>
  </tr>
  <tr>
    <td class="title_s" width="100">Social working group</td>
    <td><?php echo $Q17; ?>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Rehabilitation group</td>
    <td><textarea id="Q18" name="Q18"  cols="60" rows="5"><?php echo $Q18; ?></textarea></td>
  </tr>
</table>
<center>
  <div style="margin-top:50px;">
  <input type="hidden" name="formID" id="formID" value="socialform10b" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
  </div>
</center>
</form><br><br>