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
<h3>Individual care plan (1st follow up assessment - 3 months after conference)</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save&permission=ignore">
<table style="width:100%;" border="0">
  <tr>
    <td class="title" colspan="2">Problem status and demand assessment</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Filled date</td>
    <td align="left"><?php if ($date != NULL) { echo formatdate($date); } ?><input type="hidden" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="10"></td>
  </tr>
  <tr>
    <td colspan="2" class="title">Nursing group</td>
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
    <td class="title_s">Problem assessment</td>
    <td><?php echo $Q4; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title" width="100">Social working group</td>
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
    <td class="title_s">Resistance assessment<br />Demand assessment</td>
    <td><?php echo $Q9; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title" width="100">Rehabilitation group</td>
  </tr>
  <tr>
    <td class="title_s">Joint activity</td>
    <td><?php echo $Q10; ?></td>
  </tr>
  <tr>
    <td class="title_s">Muscle strength performance</td>
    <td><?php echo $Q11; ?></td>
  </tr>
  <tr>
    <td class="title_s">Sensation</td>
    <td><?php echo $Q12; ?></td>
  </tr>
  <tr>
    <td class="title_s">Physical performance</td>
    <td><?php echo $Q13; ?></td>
  </tr>
  <tr>
    <td class="title_s">Problem assessment<br />(please list)</td>
    <td><?php echo $Q14; ?></td>
  </tr>
  
  <tr>
    <td colspan="2" class="title">Comprehensive care goal(s)</td>
    </tr>
  <tr>
    <td colspan="2"><?php echo $Q15; ?></td>
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
    <td><?php echo $Q17; ?></td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Rehabilitation group</td>
    <td><?php echo $Q18; ?></td>
  </tr>
</table>
<table style="width:100%;" border="0">
  <tr>
    <td colspan="6" class="title">1st follow up assessment(3 months after conference)</td>
  </tr>
  <tr>
    <td class="title_s">Filled date</td>
    <td colspan="5"><script> $(function() { $( "#Qdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qdate1" id="Qdate1" value="<?php if ($Qdate1 != NULL) { echo $Qdate1; } ?>" size="10"></td>
  </tr>
  <tr>
    <td class="title_s" width="120">Nursing group</td>
    <td colspan="5"><?php echo $Q19?></td>
  </tr>
  <tr>
    <td class="title_s">Social working group</td>
    <td colspan="5">
    Previous care goal implementation and effectiveness
    <?php echo draw_checkbox("Q20","Completed, description:<input type=\"text\" name=\"Q20a\" id=\"Q20a\" value=\"".$Q20a."\" size=\"50\" >;Partially completed, reason:<input type=\"text\" name=\"Q20b\" id=\"Q20b\" value=\"".$Q20b."\" size=\"50\" >;Incomplete / not performed, reason:<input type=\"text\" name=\"Q20c\" id=\"Q20c\" value=\"".$Q20c."\" size=\"50\" >",$Q20,"single"); ?>
    </td>
  </tr>
  <tr>
    <td  class="title_s">Rehabilitation group</td>
    <td colspan="5"><?php echo $Q21; ?></td>
  </tr>
  <tr>
    <td colspan="6" class="title">Comprehensive care goal (objectives) after 1st follow up assessment</td>
  </tr>
  <tr>
    <td colspan="6" ><?php echo $Q22; ?></td>
  </tr>
  <tr>
    <td class="title" colspan="6">Treatment after first follow up assessment (include care goals and implementation)</td>
    </tr>
  <tr>
    <td class="title_s" width="100">Nursing group</td>
    <td colspan="5"><?php echo $Q23; ?></td>
  </tr>
  <tr>
    <td class="title_s" width="100">Social working group</td>
    <td colspan="5">
    1.The work objectives:
    <?php echo draw_option("Q24","Maintain;Alter","xs","single",$Q24,true,2); ?><br /><textarea name="Q24a" id="Q24a" cols="60" rows="4"><?php echo $Q24a; ?></textarea><br />
    2. The implementation measures: 
    <textarea id="Q25" name="Q25"  cols="60" rows="10"><?php echo $Q25; ?></textarea>
    </td>
  </tr>
  <tr>
    <td  class="title_s" width="100">Rehabilitation group</td>
    <td colspan="5"><?php echo $Q26; ?></td>
  </tr>
  <tr>
    <td class="title_s">Nursing group staff</td>
    <td width="200"><?php echo $Qfiller4==""?"":checkusername($Qfiller4); ?></td>
    <td class="title_s">Social working group staff</td>
    <td width="200"><?php echo $Qfiller5==""?checkusername($_SESSION['ncareID_lwj']):checkusername($Qfiller5); ?><input type="hidden" name="Qfiller5" id="Qfiller5" value="<?php echo $_SESSION['ncareID_lwj']; ?>" /></td>
    <td class="title_s">Rehabilitation group staff</td>
    <td width="200"><?php echo $Qfiller6==""?"":checkusername($Qfiller6); ?></td>
  </tr>
</table>  
<center><div style="margin-top:40px"><input type="hidden" name="formID" id="formID" value="socialform10b" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></div></center>
</form><br>
</div>