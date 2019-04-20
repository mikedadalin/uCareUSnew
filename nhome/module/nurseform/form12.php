<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform12` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform12` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
$formID = "nurseform12";
$db_fname = new DB2;
$db_fname->query("SELECT * FROM `formnamealias` WHERE `formID`='".$formID."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
if ($db_fname->num_rows()==0) {
	$formName = "Attendant physician record";
} else {
	$rFname = $db_fname->fetch_assoc();
	$formName = $rFname['formName'];
}
?>
<h3><?php echo $formName; ?></h3>
<table width="100%">
  <tr>
    <td class="title" colspan="7">Systematic review</td>
  </tr>
  <tr>
    <td class="title" width="120">Systemic</td>
    <td class="title_s">weight loss</td>
    <td><?php echo draw_option("Q1","(-);(+)","s","multi",$Q1,false,5); ?></td>
    <td class="title_s">easy-fatigability</td>
    <td><?php echo draw_option("Q2","(-);(+)","s","multi",$Q2,false,5); ?></td>
    <td class="title_s">night sweats</td>
    <td><?php echo draw_option("Q3","(-);(+)","s","multi",$Q3,false,5); ?></td>
  </tr>  
  <tr>
    <td rowspan="2" class="title">Skin</td>
    <td class="title_s">petechiae</td>
    <td><?php echo draw_option("Q4","(-);(+)","s","multi",$Q4,false,5); ?></td>
    <td class="title_s">purpurae</td>
    <td><?php echo draw_option("Q5","(-);(+)","s","multi",$Q5,false,5); ?></td>
    <td class="title_s">skin rash</td>
    <td><?php echo draw_option("Q6","(-);(+)","s","multi",$Q6,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">itching</td>
    <td colspan="5"><?php echo draw_option("Q7","(-);(+)","s","multi",$Q7,false,5); ?></td>
  </tr>      
  <tr>
    <td rowspan="6" class="title">HEENT</td>
    <td class="title_s">headache</td>
    <td><?php echo draw_option("Q8","(-);(+)","s","multi",$Q8,false,5); ?></td>
    <td class="title_s">dizziness</td>
    <td><?php echo draw_option("Q9","(-);(+)","s","multi",$Q9,false,5); ?></td>
    <td class="title_s">blurred vision</td>
    <td><?php echo draw_option("Q10","(-);(+)","s","multi",$Q10,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">strabismus</td>
    <td><?php echo draw_option("Q11","(-);(+)","s","multi",$Q11,false,5); ?></td>
    <td class="title_s">ocular pain</td>
    <td><?php echo draw_option("Q12","(-);(+)","s","multi",$Q12,false,5); ?></td>
    <td class="title_s">otalgia</td>
    <td><?php echo draw_option("Q13","(-);(+)","s","multi",$Q13,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">otorrhea</td>
    <td><?php echo draw_option("Q14","(-);(+)","s","multi",$Q14,false,5); ?></td>
    <td class="title_s">hearing impairment</td>
    <td><?php echo draw_option("Q15","(-);(+)","s","multi",$Q15,false,5); ?></td>
    <td class="title_s">tinnitus</td>
    <td><?php echo draw_option("Q16","(-);(+)","s","multi",$Q16,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">vertigo</td>
    <td><?php echo draw_option("Q17","(-);(+)","s","multi",$Q17,false,5); ?></td>
    <td class="title_s">nasal stuffiness</td>
    <td><?php echo draw_option("Q18","(-);(+)","s","multi",$Q18,false,5); ?></td>
    <td class="title_s">nasal discharge</td>
    <td><?php echo draw_option("Q19","(-);(+)","s","multi",$Q19,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">epistaxis</td>
    <td><?php echo draw_option("Q20","(-);(+)","s","multi",$Q20,false,5); ?></td>
    <td class="title_s">gum bleeding</td>
    <td><?php echo draw_option("Q21","(-);(+)","s","multi",$Q21,false,5); ?></td>
    <td class="title_s">sore throat</td>
    <td><?php echo draw_option("Q22","(-);(+)","s","multi",$Q22,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s" >oral ulcer</td>
    <td colspan="5"><?php echo draw_option("Q23","(-);(+)","s","multi",$Q23,false,5); ?></td>    
  </tr>  
  <tr>
    <td rowspan="2" class="title">Cardiovascular</td>
    <td class="title_s">exertional chest tightness</td>
    <td><?php echo draw_option("Q24","(-);(+)","s","multi",$Q24,false,5); ?></td>
    <td class="title_s">nocturnal dyspnea</td>
    <td><?php echo draw_option("Q25","(-);(+)","s","multi",$Q25,false,5); ?></td>
    <td class="title_s">orthopnea</td>
    <td><?php echo draw_option("Q26","(-);(+)","s","multi",$Q26,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">syncope</td>
    <td><?php echo draw_option("Q27","(-);(+)","s","multi",$Q27,false,5); ?></td>
    <td class="title_s">palpitation</td>
    <td><?php echo draw_option("Q28","(-);(+)","s","multi",$Q28,false,5); ?></td>
    <td class="title_s">intermittent claudication</td>
    <td><?php echo draw_option("Q29","(-);(+)","s","multi",$Q29,false,5); ?></td>
  </tr>  
  <tr>
    <td rowspan="2" class="title">Respiratory</td>
    <td class="title_s">dyspnea</td>
    <td><?php echo draw_option("Q30","(-);(+)","s","multi",$Q30,false,5); ?></td>
    <td class="title_s">cough</td>
    <td><?php echo draw_option("Q31","(-);(+)","s","multi",$Q31,false,5); ?></td>
    <td class="title_s">chest pain</td>
    <td><?php echo draw_option("Q32","(-);(+)","s","multi",$Q32,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">hemoptysis</td>
    <td><?php echo draw_option("Q33","(-);(+)","s","multi",$Q33,false,5); ?></td>
    <td class="title_s">productive cough</td>
    <td><?php echo draw_option("Q34","(-);(+)","s","multi",$Q34,false,5); ?></td>
    <td class="title_s">pleuritic chest pain</td>
    <td><?php echo draw_option("Q35","(-);(+)","s","multi",$Q35,false,5); ?></td>
  </tr>  
  <tr>
    <td rowspan="6" class="title">Gastrointestinal</td>
    <td class="title_s">anorexia</td>
    <td><?php echo draw_option("Q36","(-);(+)","s","multi",$Q36,false,5); ?></td>
    <td class="title_s">nausea</td>
    <td><?php echo draw_option("Q37","(-);(+)","s","multi",$Q37,false,5); ?></td>
    <td class="title_s">vomiting</td>
    <td><?php echo draw_option("Q38","(-);(+)","s","multi",$Q38,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">dysphagia</td>
    <td><?php echo draw_option("Q39","(-);(+)","s","multi",$Q39,false,5); ?></td>
    <td class="title_s">heartburn</td>
    <td><?php echo draw_option("Q40","(-);(+)","s","multi",$Q40,false,5); ?></td>
    <td class="title_s">acid regurgitation</td>
    <td><?php echo draw_option("Q41","(-);(+)","s","multi",$Q41,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">abdominal fullness</td>
    <td><?php echo draw_option("Q42","(-);(+)","s","multi",$Q42,false,5); ?></td>
    <td class="title_s">hunger pain</td>
    <td><?php echo draw_option("Q43","(-);(+)","s","multi",$Q43,false,5); ?></td>
    <td class="title_s">midnight pain</td>
    <td><?php echo draw_option("Q44","(-);(+)","s","multi",$Q44,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">constipation</td>
    <td><?php echo draw_option("Q45","(-);(+)","s","multi",$Q45,false,5); ?></td>
    <td class="title_s">diarrhea</td>
    <td><?php echo draw_option("Q46","(-);(+)","s","multi",$Q46,false,5); ?></td>
    <td class="title_s">melena</td>
    <td><?php echo draw_option("Q47","(-);(+)","s","multi",$Q47,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">change of bowel habit</td>
    <td><?php echo draw_option("Q48","(-);(+)","s","multi",$Q48,false,5); ?></td>
    <td class="title_s">small caliber of stool</td>
    <td><?php echo draw_option("Q49","(-);(+)","s","multi",$Q49,false,5); ?></td>
    <td class="title_s">tenesmus</td>
    <td><?php echo draw_option("Q50","(-);(+)","s","multi",$Q50,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">flatulence</td>
    <td><?php echo draw_option("Q51","(-);(+)","s","multi",$Q51,false,5); ?></td>
    <td class="title_s">stool incontinence</td>
    <td><?php echo draw_option("Q52","(-);(+)","s","multi",$Q52,false,5); ?></td>
    <td class="title_s">tenesmus</td>
    <td><?php echo draw_option("Q53","(-);(+)","s","multi",$Q53,false,5); ?></td>
  </tr>  
  <tr>
    <td rowspan="4" class="title">Urogenital</td>
    <td class="title_s">flank pain</td>
    <td><?php echo draw_option("Q54","(-);(+)","s","multi",$Q54,false,5); ?></td>
    <td class="title_s">hematuria</td>
    <td><?php echo draw_option("Q55","(-);(+)","s","multi",$Q55,false,5); ?></td>
    <td class="title_s">urinary frequency</td>
    <td><?php echo draw_option("Q56","(-);(+)","s","multi",$Q56,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">urgency</td>
    <td><?php echo draw_option("Q57","(-);(+)","s","multi",$Q57,false,5); ?></td>
    <td class="title_s">dysuria</td>
    <td><?php echo draw_option("Q58","(-);(+)","s","multi",$Q58,false,5); ?></td>
    <td class="title_s">hesitancy</td>
    <td><?php echo draw_option("Q59","(-);(+)","s","multi",$Q59,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">small stream of urine</td>
    <td><?php echo draw_option("Q60","(-);(+)","s","multi",$Q60,false,5); ?></td>
    <td class="title_s">nocturia</td>
    <td><?php echo draw_option("Q61","(-);(+)","s","multi",$Q61,false,5); ?></td>
    <td class="title_s">polyuria</td>
    <td><?php echo draw_option("Q62","(-);(+)","s","multi",$Q62,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">oliguria</td>
    <td><?php echo draw_option("Q63","(-);(+)","s","multi",$Q63,false,5); ?></td>
    <td class="title_s">urinary incontinence</td>
    <td colspan="3"><?php echo draw_option("Q64","(-);(+)","s","multi",$Q64,false,5); ?></td>
  </tr>  
  <tr>
    <td rowspan="2" class="title">Musculoskeletal</td>
    <td class="title_s">bone pain</td>
    <td><?php echo draw_option("Q65","(-);(+)","s","multi",$Q65,false,5); ?></td>
    <td class="title_s">arthralgia</td>
    <td><?php echo draw_option("Q66","(-);(+)","s","multi",$Q66,false,5); ?></td>
    <td class="title_s">myalgia</td>
    <td><?php echo draw_option("Q67","(-);(+)","s","multi",$Q67,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title_s">weakness</td>
    <td><?php echo draw_option("Q68","(-);(+)","s","multi",$Q68,false,5); ?></td>
    <td class="title_s">back pain</td>
    <td colspan="3"><?php echo draw_option("Q69","(-);(+)","s","multi",$Q69,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title">Nervous</td>
    <td class="title_s">numbness </td>
    <td><?php echo draw_option("Q70","(-);(+)","s","multi",$Q70,false,5); ?></td>
    <td class="title_s">paresis/plegia</td>
    <td colspan="3"><?php echo draw_option("Q71","(-);(+)","s","multi",$Q71,false,5); ?></td>
  </tr>  
  <tr>
    <td class="title" colspan="7">Physical examination</td>
  </tr>
  <tr>
    <td class="title">Consciousness</td>
    <td class="title_s">bone pain</td>
    <td colspan="5">
    E<input type='text' name='Q72' id='Q72' size='5' value='<?php echo $Q72; ?>' />
    M<input type='text' name='Q73' id='Q73' size='5' value='<?php echo $Q73; ?>' />
    V<input type='text' name='Q74' id='Q74' size='5' value='<?php echo $Q74; ?>' />，<input type='text' name='Q75' id='Q75' size='30' value='<?php echo $Q75; ?>' />    
    </td>
  </tr>
  <tr>
      <td rowspan="4" class="title">HEENT</td>
      <td class="title_s">conjunctiva</td>
      <td colspan="5"><input type="text" name="Q76" id="Q76" size="40" value="<?php echo $Q76; ?>"></td>
  </tr>
  <tr>
      <td class="title_s">sclera</td>
      <td colspan="5"><input type="text" name="Q77" id="Q77" size="40" value="<?php echo $Q77; ?>"></td>
  </tr>
  <tr>
      <td class="title_s">pupil</td>
      <td class="title_s">R</td>
      <td><input type="text" name="Q78" id="Q78" size="5" value="<?php echo $Q78; ?>">mm</td>
      <td class="title_s">L</td>
      <td colspan="2"><input type="text" name="Q79" id="Q79" size="5" value="<?php echo $Q79; ?>">mm</td>
  </tr>
  <tr>
      <td class="title_s">light reflex</td>
      <td class="title_s">R</td>
      <td><?php echo draw_option("Q80","(-);(+)","s","multi",$Q80,false,5); ?></td>
      <td class="title_s">L</td>
      <td colspan="2"><?php echo draw_option("Q81","(-);(+)","s","multi",$Q81,false,5); ?></td>
  </tr>
  <tr>
      <td rowspan="3" class="title">Neck</td>
      <td class="title_s">supple</td>
      <td colspan="5"><?php echo draw_option("Q82","(-);(+)","s","multi",$Q82,false,5); ?></td>
      </tr>
  <tr>
      <td class="title_s">jugular vein engorgement</td>
      <td colspan="5"><?php echo draw_option("Q83","(-);(+)","s","multi",$Q83,false,5); ?></td>
      </tr>
  <tr>
      <td class="title_s">Thyroid</td>
      <td colspan="5"><input type="text" name="Q84" id="Q84" size="40" value="<?php echo $Q84; ?>"></td>
  </tr>
  <tr>
      <td class="title">Chest</td>
      <td colspan="6"><input type="text" name="Q85" id="Q85" size="40" value="<?php echo $Q85; ?>"></td>
      </tr>
  <tr>
      <td class="title">Heart</td>
      <td colspan="6"><input type="text" name="Q86" id="Q86" size="40" value="<?php echo $Q86; ?>"></td>
  </tr>  
  <tr>
      <td class="title" rowspan="5">Abdomen</td>
      <td colspan="6"><input type="text" name="Q87" id="Q87" size="40" value="<?php echo $Q87; ?>"></td>
  </tr>
  <tr>
      <td class="title_s">bowel sound</td>
      <td colspan="5"><input type="text" name="Q88" id="Q88" size="40" value="<?php echo $Q88; ?>"></td>
  </tr>
  <tr>
      <td class="title_s">spleen</td>
      <td colspan="5"><input type="text" name="Q89" id="Q89" size="40" value="<?php echo $Q89; ?>"></td>
  </tr>
  <tr>
      <td class="title_s"> liver span</td>
      <td colspan="5"><input type="text" name="Q90" id="Q90" value="<?php echo $Q90; ?>" size="5">cm</td>
  </tr>
  <tr>
      <td class="title_s">Flank knocking pain</td>
      <td class="title_s">R</td>
      <td><?php echo draw_option("Q91","(-);(+)","s","multi",$Q91,false,5); ?></td>
      <td class="title_s">L</td>
      <td colspan="2"><?php echo draw_option("Q92","(-);(+)","s","multi",$Q92,false,5); ?></td>
  </tr>
  <tr>
      <td class="title">Extremities</td>
      <td class="title_s">pitting edema</td>
      <td colspan="2"><?php echo draw_option("Q93","(-);(+)","s","multi",$Q93,false,5); ?></td>
      <td class="title_s">cyanosis </td>
      <td colspan="2"><?php echo draw_option("Q94","(-);(+)","s","multi",$Q94,false,5); ?></td>
  </tr>
  <tr>
      <td class="title">Skin</td>
      <td colspan="6"><input type="text" name="Q95" id="Q95" size="40" value="<?php echo $Q95; ?>"></td>
      </tr>
  <tr>
    <td class="title" colspan="7">Neurological Examination</td>
  </tr>
  <tr>
      <td class="title">EOM</td>
      <td colspan="6"><input type="text" name="Q96" id="Q96" size="40" value="<?php echo $Q96; ?>"></td>
  </tr>
  <tr>
      <td class="title">Ptosis</td>
      <td class="title_s">R</td>
      <td colspan="2"><?php echo draw_option("Q97","(-);(+)","s","multi",$Q97,false,5); ?></td>
      <td class="title_s">L</td>
      <td colspan="2"><?php echo draw_option("Q98","(-);(+)","s","multi",$Q98,false,5); ?></td>
  </tr>
  <tr>
      <td rowspan="8" class="title">Muscle power</td>
      <td rowspan="4" class="title_s">Right</td>
      <td>upper proximal</td>
      <td colspan="4"><?php echo draw_option("Q99","0;1;2;3;4;5","s","multi",$Q99,false,0); ?></td>
  </tr>
  <tr>
      <td>upper distal</td>
      <td colspan="4"><?php echo draw_option("Q100","0;1;2;3;4;5","s","multi",$Q100,false,0); ?></td>
  </tr>
  <tr>
      <td>lower proximal</td>
      <td colspan="4"><?php echo draw_option("Q101","0;1;2;3;4;5","s","multi",$Q101,false,0); ?></td>
  </tr>
  <tr>
      <td>lower distal</td>
      <td colspan="4"><?php echo draw_option("Q102","0;1;2;3;4;5","s","multi",$Q102,false,0); ?></td>
  </tr>
  <tr>
      <td rowspan="4" class="title_s">Left</td>
      <td>upper proximal</td>
      <td colspan="4"><?php echo draw_option("Q103","0;1;2;3;4;5","s","multi",$Q103,false,0); ?></td>
  </tr>
  <tr>
      <td>upper distal</td>
      <td colspan="4"><?php echo draw_option("Q104","0;1;2;3;4;5","s","multi",$Q104,false,0); ?></td>
  </tr>
  <tr>
      <td>lower proximal</td>
      <td colspan="4"><?php echo draw_option("Q105","0;1;2;3;4;5","s","multi",$Q105,false,0); ?></td>
  </tr>
  <tr>
      <td>lower distal</td>
      <td colspan="4"><?php echo draw_option("Q106","0;1;2;3;4;5","s","multi",$Q106,false,0); ?></td>
  </tr>
  <tr>
      <td class="title">Gait</td>
      <td colspan="6"><input type="text" name="Q107" id="Q107" size="40" value="<?php echo $Q107; ?>"></td>
      </tr>
  <tr>
    <td class="title" colspan="7">Diagnosis</td>
  </tr>
  <tr>
    <td colspan="7"><textarea cols="80" rows="4" name="Q109" id="Q109"><?php echo $Q109; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" colspan="7">Treatment and recommendations</td>
  </tr>
  <tr>
    <td colspan="7"><textarea cols="80" rows="24" name="Q108" id="Q108"><?php echo $Q108; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform12" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
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