<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform12a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform12a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<?php
$formID = "nurseform12a";
$db_fname = new DB2;
$db_fname->query("SELECT * FROM `formnamealias` WHERE `formID`='".$formID."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
if ($db_fname->num_rows()==0) {
	$formName = "醫師定期巡診紀錄單";
} else {
	$rFname = $db_fname->fetch_assoc();
	$formName = $rFname['formName'];
}
?>
<h3><?php echo $formName; ?></h3>
<table width="100%">
  <tr>
    <td class="title" colspan="7">Major medical representative</td>
  </tr>
  <tr>
    <td colspan="7"><textarea cols="80" rows="4" name="Q1" id="Q1"><?php echo $Q1; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" colspan="7">Reason of home care visit</td>
  </tr>
  <tr>
    <td colspan="7"><textarea cols="80" rows="4" name="Q2" id="Q2"><?php echo $Q2; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" nowrap>Past Medical History</td>
    <td class="title_s">BW</td>
    <td><input type="text" name="Q3a" id="Q3a" size="10" value="<?php echo $Q3a; ?>"> lbs</td>
    <td class="title_s">BH</td>
    <td colspan="3"><input type="text" name="Q3b" id="Q3b" size="10" value="<?php echo $Q3b; ?>"></td>
  </tr>
  <tr>
    <td class="title" nowrap>Physical Examinations</td>
    <td class="title_s">BP</td>
    <td><input type="text" name="Q4a" id="Q4a" size="10" value="<?php echo $Q4a; ?>"> mmHg</td>
    <td class="title_s">TPR</td>
    <td><input type="text" name="Q4b" id="Q4b" size="10" value="<?php echo $Q4b; ?>"></td>
    <td class="title_s">Oximeter</td>
    <td><input type="text" name="Q4c" id="Q4c" size="10" value="<?php echo $Q4c; ?>">%</td>
  </tr>
  <tr>
    <td class="title" rowspan="2" nowrap>1. Consciousness</td>
    <td class="title_s">GCS</td>
    <td colspan="5">E <input type="text" name="Q5a" id="Q5a" size="2" value="<?php echo $Q5a; ?>"> M <input type="text" name="Q5b" id="Q5b" size="2" value="<?php echo $Q5b; ?>"> V <input type="text" name="Q5c" id="Q5c" size="2" value="<?php echo $Q5c; ?>"></td>
  </tr>
  <tr>
    <td colspan="6"><?php echo draw_option("Q6","Clear;Agitated;Confused;Delirium;Stupor;Vegetable;Coma;Drowsy;Other","m","single",$Q6,true,6); ?></td>
  </tr>
  <tr>
    <td class="title" nowrap>2. Psychological status</td>
    <td colspan="6"><?php echo draw_option("Q7","Appropriate;Depressed;Anxious;Can’t assess","m","single",$Q7,true,6); ?></td>
  </tr>
  <tr>
    <td class="title" rowspan="2">3. Communication </td>
    <td class="title_s">a. Understand</td>
    <td colspan="5"><?php echo draw_option("Q8","Yes;No","m","single",$Q8,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">b. Express</td>
    <td colspan="5"><?php echo draw_option("Q9","Language;Body language;Device;No","m","single",$Q9,false,6); ?></td>
  </tr>
  <tr>
    <td class="title" rowspan="3">4. HEENT</td>
    <td class="title_s">a. Conjunctiva</td>
    <td colspan="5"><input type="text" name="Q10a" id="Q10a" size="80" value="<?php echo $Q10a; ?>"></td>
  </tr>
  <tr>
    <td class="title_s">b. Sclera</td>
    <td colspan="5"><input type="text" name="Q10b" id="Q10b" size="80" value="<?php echo $Q10b; ?>"></td>
  </tr>
  <tr>
    <td class="title_s">c. Pupil</td>
    <td colspan="5"><input type="text" name="Q10c" id="Q10c" size="80" value="<?php echo $Q10c; ?>"></td>
  </tr>
  <tr>
    <td class="title">5. Hearing</td>
    <td colspan="6"><?php echo draw_option("Q11","Grossly normal;Impaired;Severely impaired;Deafness","l","single",$Q11,false,6); ?></td>
  </tr>
  <tr>
    <td class="title">6. Neck</td>
    <td colspan="6"><input type="text" name="Q12" id="Q12" size="80" value="<?php echo $Q12; ?>"></td>
  </tr>
  <tr>
    <td class="title">7. Chest</td>
    <td colspan="3"><input type="text" name="Q13a" id="Q13a" size="30" value="<?php echo $Q13a; ?>"></td>
    <td class="title">BS:</td>
    <td colspan="3"><input type="text" name="Q13b" id="Q13b" size="30" value="<?php echo $Q13b; ?>"></td>
  </tr>
  <tr>
    <td class="title">8. Heart</td>
    <td colspan="3"><input type="text" name="Q14a" id="Q14a" size="30" value="<?php echo $Q14a; ?>"></td>
    <td class="title">HS:</td>
    <td colspan="3"><input type="text" name="Q14b" id="Q14b" size="30" value="<?php echo $Q14b; ?>"></td>
  </tr>
  <tr>
    <td class="title" rowspan="3">9. Abdomen</td>
    <td class="title_s">a. Bowel sound</td>
    <td colspan="5"><input type="text" name="Q15a" id="Q15a" size="80" value="<?php echo $Q15a; ?>"></td>
  </tr>
  <tr>
    <td class="title_s">b. Bowel function</td>
    <td colspan="5"><?php echo draw_option("Q15b","Normal;Incontinence;Constipation;Diarrhea","m","single",$Q15b,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">c. Liver / Spleen</td>
    <td colspan="5"><?php echo draw_option("Q15c","Palpable;Not palpable","m","single",$Q15c,false,6); ?></td>
  </tr>
  <tr>
    <td class="title" rowspan="2">10. Extremities</td>
    <td colspan="6"><?php echo draw_checkbox_2col("Q16","Freely movable;Edema: <input type=\"text\" name=\"Q16a\" id=\"Q16a\" size=\"20\" value=\"".$Q16a."\" >;Paralysis;Paresis;Deformity;Spasticity: <input type=\"text\" name=\"Q16b\" id=\"Q16b\" size=\"20\" value=\"".$Q16b."\" >;Contracture: <input type=\"text\" name=\"Q16c\" id=\"Q16c\" size=\"20\" value=\"".$Q16c."\" >",$Q16,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Muscle power</td>
    <td colspan="6"><?php echo draw_checkbox_2col("Q17","Left arm: <input type=\"text\" name=\"Q17a\" id=\"Q17a\" size=\"10\" value=\"".$Q17a."\" >;Right arm: <input type=\"text\" name=\"Q17b\" id=\"Q17b\" size=\"10\" value=\"".$Q17b."\" >;Left leg: <input type=\"text\" name=\"Q17c\" id=\"Q17c\" size=\"10\" value=\"".$Q17c."\" >;Right leg: <input type=\"text\" name=\"Q17d\" id=\"Q17d\" size=\"10\" value=\"".$Q17d."\" >",$Q17,"single"); ?></td>
  </tr>
  <tr>
    <td class="title">11. Skin</td>
    <td colspan="6"><?php echo draw_checkbox_2col("Q18","Normal;Dry;Ecchymosis;Petechiae;Other: <input type=\"text\" name=\"Q18a\" id=\"Q18a\" size=\"40\" value=\"".$Q18a."\" >;Wound (location and size <input type=\"text\" name=\"Q18b\" id=\"Q18b\" size=\"40\" value=\"".$Q18b."\" >)",$Q18,"single"); ?></td>
  </tr>
  <tr>
    <td class="title">12. Tubing</td>
    <td colspan="6"><?php echo draw_option("Q19","Tracheostomy;Feeding tube;Urinary catheter","l","single",$Q19,false,6); ?></td>
  </tr>
  <tr>
    <td class="title">13. Care &amp; Treatment</td>
    <td colspan="6"><?php echo draw_checkbox_2col("Q20","change position prevent bed sore;keep electrolyte balance;intensive chest care;nutrition supply;keep airway suction prn;bronchoidilator Tx;stem inhalation prm	;pain control(relief);wound care with Tx;keep present Tx;Other(s):<input type=\"text\" name=\"Q20a\" id=\"Q20a\" size=\"40\" value=\"".$Q20a."\" >;轉介：<input type=\"text\" name=\"Q20b\" id=\"Q20b\" size=\"40\" value=\"".$Q20b."\" >",$Q20,"single"); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform12a" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
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