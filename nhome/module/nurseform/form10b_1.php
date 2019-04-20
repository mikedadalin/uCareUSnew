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
    <td class="title" colspan="6">Problem status and demand assessment</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Filled date</td>
    <td colspan="5"><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); }else{ echo date("Y/m/d");} ?>" size="10"></td>
  </tr>
  <tr>
    <td colspan="6" class="title">Nursing group</td>
  </tr>
  <tr>
    <td class="title_s" width="120">Past medical history</td>
    <td colspan="5"><?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller1 || $Qfiller1=="") { ?><textarea id="Q1" name="Q1"  cols="30" rows="2"><?php echo $Q1; ?></textarea><?php } else { echo $Q1; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Medication status</td>
    <td colspan="5"><?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller1 || $Qfiller1=="") { ?><textarea id="Q2" name="Q2"  cols="30" rows="2"><?php echo $Q2; ?></textarea><?php } else { echo $Q2; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Cognitive function</td>
    <td colspan="5"><?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller1 || $Qfiller1=="") { ?><textarea id="Q3" name="Q3"  cols="30" rows="2"><?php echo $Q3; ?></textarea><?php } else { echo $Q3; } ?></td>
    </td>
  </tr>
  <tr>
    <td class="title_s">Problem assessment<br>(please list)</td>
    <td colspan="5"><?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller1 || $Qfiller1=="") { ?><textarea id="Q4" name="Q4"  cols="30" rows="4"><?php echo $Q4; ?></textarea><?php } else { echo $Q4; } ?></td>
  </tr>
  <tr>
    <td colspan="6" class="title" width="100">Social working group</td>
  </tr>
  <tr>
    <td class="title_s">Psychological level</td>
    <td colspan="5"><?php echo $Q5; ?></td>
  </tr>
  <tr>
    <td class="title_s">Environmental adaptation</td>
    <td colspan="5"><?php echo $Q6; ?></td>
  </tr>
  <tr>
    <td class="title_s">Social resource<br />(Including the ecosystem level)</td>
    <td colspan="5"><?php echo $Q7; ?></td>
  </tr>
  <tr>
    <td class="title_s">Resident's family status<br />(Including emotional, economy status)</td>
    <td colspan="5"><?php echo $Q8; ?></td>
  </tr>
  <tr>
    <td class="title_s">Resistance assessment<br />Demand assessment<br />(please list)</td>
    <td colspan="5"><?php echo $Q9; ?></td>
  </tr>
  <tr>
    <td colspan="6" class="title" width="100">Rehabilitation group</td>
  </tr>
  <tr>
    <td class="title_s">Joint activity</td>
    <td colspan="5"><?php echo $Q10; ?></td>
  </tr>
  <tr>
    <td class="title_s">Muscle strength performance</td>
    <td colspan="5"><?php echo $Q11; ?></td>
  </tr>
  <tr>
    <td class="title_s">Sensation</td>
    <td colspan="5"><?php echo $Q12; ?></td>
  </tr>
  <tr>
    <td class="title_s">Physical performance</td>
    <td colspan="5"><?php echo $Q13; ?></td>
  </tr>
  <tr>
    <td class="title_s">Problem assessment<br />(please list)</td>
    <td colspan="5"><?php echo $Q14; ?></td>
  </tr>
  
  <tr>
    <td colspan="6" class="title">Comprehensive care goal(s)</td>
    </tr>
  <tr>
    <td colspan="6"><?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller1) { ?><textarea id="Q15" name="Q15"  cols="60" rows="5"><?php echo $Q15; ?></textarea><?php } else { echo $Q15; } ?></td>
  </tr>
  <tr>
    <td class="title" colspan="6">Treatment (include care goals and implementation)</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Nursing group</td>
    <td colspan="5"><?php if ($_SESSION['ncareLevel_lwj']>=4 || $_SESSION['ncareID_lwj']==$Qfiller1) { ?><textarea id="Q16" name="Q16"  cols="60" rows="5"><?php echo $Q16; ?></textarea><?php } else { echo $Q16; } ?></td>
  </tr>
  <tr>
    <td class="title_s" width="100">Social working group</td>
    <td colspan="5"><?php echo $Q17; ?>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Rehabilitation group</td>
    <td colspan="5"><?php echo $Q18; ?>
    </td>
  </tr>
  <tr>
    <td class="title_s">Nursing group staff</td>
    <td width="200"><?php echo $Qfiller1==""?checkusername($_SESSION['ncareID_lwj']):checkusername($Qfiller1); ?><input type="hidden" name="Qfiller1" id="Qfiller1" value="<?php echo $_SESSION['ncareID_lwj']; ?>" /></td>
    <td class="title_s">Social working group staff</td>
    <td width="200"><?php echo $Qfiller2==""?"":checkusername($Qfiller2); ?></td>
    <td class="title_s">Rehabilitation group staff</td>
    <td width="200"><?php echo $Qfiller3==""?"":checkusername($Qfiller3); ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform10b" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
