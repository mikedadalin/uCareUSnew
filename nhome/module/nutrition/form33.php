<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `height`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				if (${$arrPatientInfo[0]} != NULL) { ${$arrPatientInfo[0]} .= ';'; }
				${$arrPatientInfo[0]} .= $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
}
   /*===== 身高轉換 START =====*/
   $inch = $height;
   $feet = floor($inch/12);
   $inch = $inch%12;
   $heightfeet = $feet."'".$inch;
   /*===== 身高轉換 END =====*/
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform33` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform33` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
   /*===== 身高轉換 START =====*/
   $inch = $Q2;
   $feet = floor($inch/12);
   $inch = $inch%12;
   $Q2feet = $feet."'".$inch;
   /*===== 身高轉換 END =====*/

//護理表單2b欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform11` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform11_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform11_'.$k} = $v; } }  else { ${'nurseform11_'.$k} = $v; } } }
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Nutritional assessment</h3>
<table width="100%">
  <tr>
    <td class="title" width="100">Full name</td>
    <td width="240"><?php echo $name; ?></td>
    <td width="100" class="title">Gender/Age</td>
    <td colspan="3" width="240"><?php echo checkgender(mysql_escape_string($_GET['pid'])); ?> / <input type="text" name="Q1" id="Q1" size="3" value="<?php if ($Q1==NULL) { echo calcagenum($Birth); } else { echo $Q1; } ?>" tabindex="1" />Years old</td>
  </tr>
    <script>
	function calcbmi() {
		var feetArray = document.getElementById('Q2').value.split("'");
		var feet = new Number(feetArray[0]);
		var inch = new Number(feetArray[1]);
		var inchTotal = eval(feet*12+inch);
		var height = inchTotal*2.54/100;
		var weight = parseInt(document.getElementById('Q2a').value);
		if (weight>10 && height>0.5) {
			var bmindx = weight/eval(inchTotal*inchTotal)*703;
			bmindx = Math.round(bmindx*10) / 10;
			document.getElementById('Q2b').value = bmindx;
			var bmindx2 = eval(height*height)*22;
			bmindx2 = bmindx2/0.454;
			bmindx2 = Math.round(bmindx2*10) / 10;
			document.getElementById('Q3a').value = bmindx2;
		}
		var bwnow = parseInt(document.getElementById('Q2a').value);
		var bwlast = parseInt(document.getElementById('Q3b').value);
		var bwchange = ((bwnow / bwlast ) - 1)*100;
		bwchange = Math.round(bwchange*100) / 100;
		document.getElementById('Q3e').value = bwchange;
	}
	function calclastbmi() {
		var feetArray = document.getElementById('Q2').value.split("'");
		var feet = new Number(feetArray[0]);
		var inch = new Number(feetArray[1]);
		var inchTotal = eval(feet*12+inch);
		var height = inchTotal*2.54/100;
		var weight = parseInt(document.getElementById('Q3b').value);
		if (weight>10 && height>0.5) {
			var bmindx = weight/eval(inchTotal*inchTotal)*703;
			bmindx = Math.round(bmindx*10) / 10;
			document.getElementById('Q3d').value = bmindx;
		}
		var bwnow = parseInt(document.getElementById('Q2a').value);
		var bwlast = parseInt(document.getElementById('Q3b').value);
		var bwchange = ((bwnow / bwlast ) - 1)*100;
		bwchange = Math.round(bwchange*100) / 100;
		document.getElementById('Q3e').value = bwchange;
	}
	</script>
  <tr>
    <td class="title">Height</td>
    <td><input type="text" name="Q2" id="Q2" value="<?php if ($tabsID==0) { echo $heightfeet; } else { echo $Q2feet; } ?>" size="4" onkeyup="calcbmi();" tabindex="2">(e.g. 5'11)</td>

    <td class="title">Ideal weight</td>
    <?php
	/* 原V
	$db_bw_now = new DB;
	$db_bw_now->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".@$_GET['pid']."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	$r_bw_now = $db_bw_now->fetch_assoc();
	*/
	// 新V START
	$db_bw_now = new DB;
	$db_bw_now->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	$r_bw_now = $db_bw_now->fetch_assoc();
	// 新V END
	if ($height!="" && $height!="0" && $r_bw_now['Value']!="" && $r_bw_now['Value']!="0") {
		$BMI = $r_bw_now['Value']/($height*$height)*703;
		$BMI = round($BMI,1);
		$heightM = $height*2.54/100;
		$idealweight = 22*($heightM*$heightM);
		$idealweightlbs = $idealweight/0.454;
		$idealweightlbs = round($idealweightlbs,1);
		$idealweight = round($idealweight,1);
	}
	/* 原V
	$db_bw_last = new DB;
	$db_bw_last->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".@$_GET['pid']."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 1,1");
	$r_bw_last = $db_bw_last->fetch_assoc();
	*/
	// 新V START
	$db_bw_last = new DB;
	$db_bw_last->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' AND `date` LIKE '".date("Ym",strtotime('-1 month'))."%' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	$r_bw_last = $db_bw_last->fetch_assoc();
	// 新V END
	if ($r_bw_now['Value']=="" || $r_bw_last['Value']=="") {
		$bw_change = '0';
	} else {
		$bw_change = round((($r_bw_now['Value']/$r_bw_last['Value'])-1)*100,2);
	}
	
	if ($height!="" && $r_bw_last['Value']!="") {
		$BMI_last = $r_bw_last['Value']/($height*$height)*703;
		$BMI_last = round($BMI_last,1);
	}
	?>
    <td colspan="3"><input type="text" name="Q3a" id="Q3a" value="<?php if ($tabsID==0) { echo $idealweightlbs; } else { echo $Q3a; } ?>" size="4" tabindex="3" />
      lbs</td>
    </tr>
  <tr>
    <td class="title">Current weight</td>
    <td><input type="text" name="Q2a" id="Q2a" value="<?php if ($tabsID==0) { echo $r_bw_now['Value']; } else { echo $Q2a; } ?>" size="4"  onkeyup="calcbmi();" tabindex="4" />
      lbs</td>
    <td class="title">Current BMI</td>
    <td><input type="text" name="Q2b" id="Q2b" value="<?php if ($tabsID==0) { echo $BMI; } else { echo $Q2b; } ?>" size="4" tabindex="5" /></td>
    <td width="100" rowspan="2" class="title">Weight change</td>
    <td rowspan="2"><input type="text" name="Q3e" id="Q3e" value="<?php if ($tabsID==0) { echo $bw_change; } else { echo $Q3e; } ?>" size="4" onfocus="calcbwchange();" tabindex="8"> %</td>
  </tr>
  <tr>
    <td class="title">Weight of previous month</td>
    <td><input type="text" name="Q3b" id="Q3b" value="<?php if ($tabsID==0) { echo $r_bw_last['Value']; } else { echo $Q3b; } ?>" size="4" onkeyup="calclastbmi();" tabindex="6" />
      lbs</td>
    <td class="title"><p>Last month BMI</p></td>
    <td><input type="text" name="Q3d" id="Q3d" value="<?php if ($tabsID==0) { echo $BMI_last; } else { echo $Q3d; } ?>" size="4" tabindex="7" /></td>
    </tr>
  <tr>

  <td class="title">Amputation</td>
    <td colspan="5"><?php echo draw_option("Q4","None;Yes","s","single",$Q4,false,3); ?>Part(s):<input type="text" name="Q4a" id="Q4a" value="<?php echo $Q7a; ?>" size="20" /></td>

  </tr>
  <tr>
    <td class="title">Edema</td>
    <td colspan="5"><?php echo draw_option("Q5","None;Yes","s","single",$Q5,false,3); ?>Severity:<input type="text" name="Q5a" id="Q5a" value="<?php echo $Q5a; ?>" size="20" /> / part(s):<input type="text" name="Q5b" id="Q5b" value="<?php echo $Q5b; ?>" size="20" /></td>
  </tr>
  <tr>

    <td class="title">Pressure ulcer(s)</td>
    <td colspan="5"><?php echo draw_option("Q6","None;Yes","s","single",$Q6,false,3); ?> Location and size:<input type="text" name="Q6a" id="Q6a" value="<?php echo $Q6a; ?>" size="50" /></td>
  </tr>
  <tr>
    <td class="title">Disease diagnosis</td>
    <td colspan="5"><?php echo draw_option("Q7","Renal function decline;Dialysis;Hypertension;Hyperlipidemia;Gout;Diabetes;COPD;Heart disease;Peptic ulcer;Stroke;Dementia;Other","xl","multi",$Q7,true,4); ?><input type="text" name="Q7a" id="Q7a" value="<?php echo $Q7a; ?>" size="20" /></td>
  </tr>
</table>
<?php
$db4a = new DB;
$db4a->query("SELECT DISTINCT `date` FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `date` DESC LIMIT 0,1");
$r4a = $db4a->fetch_assoc();
$db4b = new DB;
$db4b->query("SELECT * FROM `labpatient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".$r4a['date']."'");
for ($i=0;$i<$db4b->num_rows();$i++) {
	$r4b = $db4b->fetch_assoc();
	${'lab_'.$r4b['labID']} = $r4b['value'];
}
?>
Examination date:<?php echo formatdate($r4a['date']); ?>
<table width="100%" style="text-align:center;">
  <tr class="title">
    <td colspan="3">Urinalysis</td>
    <td colspan="9">Blood tests</td>
  </tr>
  <tr class="title_s" style="font-size:10pt;">
    <td>PH<br />(5-8)</td>
    <td>Protein<br />(-)</td>
    <td>Glucose<br />(-)</td>
    <td>WBC (K/mm<sup>3</sup>)<br />3.9–10.8</td>
    <td>RBC (M/mm<sup>3</sup>)<br />male4.4–6.2<br />female3.8–5.4</td>
    <td>Hb (g/dl)<br />male13–18<br />female11.5–16</td>
    <td>Ht (%)<br />male39–53<br />female35–47</td>
    <td>TP (g/dl)<br />6.2–8.4</td>
    <td>Alb (g/dl)<br />3.5–5.5</td>
    <td>BUN (mg/dl)<br />7–20</td>
    <td>CRE (mg/dl)<br />0.4–1.4</td>
    <td>UA (mg/dl)<br />male3.5–7.2<br />female2.6–6</td>
  </tr>
  <tr>
    <td>---</td>
    <td><?php echo $lab_402; ?></td>
    <td>---</td>
    <td><?php echo $lab_300/1000; ?></td>
    <td><?php echo $lab_301; ?></td>
    <td><?php echo $lab_304; ?></td>
    <td><?php echo $lab_307; ?></td>
    <td>---</td>
    <td>---</td>
    <td>---</td>
    <td><?php echo $lab_575; ?></td>
    <td>---</td>
  </tr>
  <tr class="title">
    <td colspan="12">Blood tests</td>
  </tr>
  <tr class="title_s" style="font-size:10pt;">
    <td>GOT(U/L)<br />5–37</td>
    <td>GPT(U/L)<br />5–42</td>
    <td>TG (mg/dl)<br />50–150</td>
    <td>Chol (mg/dl)<br />120–200</td>
    <td>Na (mmol/L)<br />135–145</td>
    <td>K (mmol/L)<br />3.5–5.5</td>
    <td>Ca (mg/dl)<br />8.4–10.2</td>
    <td>P (mg/dl)<br />2.4–4.7</td>
    <td>HbA1c (%)<br />4.4–6.4</td>
    <td>Blood glucose before meals(mg/dl)<br />65–110</td>
    <td colspan="2">Recent before meals (A.C.)<br />Blood glucose</td>
  </tr>
  <tr>
    <td><?php echo $lab_566; ?></td>
    <td><?php echo $lab_567; ?></td>
    <td><?php echo $lab_531; ?></td>
    <td><?php echo $lab_532; ?></td>
    <td>---</td>
    <td>---</td>
    <td>---</td>
    <td>---</td>
    <td>---</td>
    <td><?php echo $lab_511; ?></td>
    <td colspan="2">---</td>
  </tr>
</table>
<input type="hidden" name="Qlab_402" value="<?php echo $lab_402; ?>" />
<input type="hidden" name="Qlab_300" value="<?php echo $lab_300; ?>" />
<input type="hidden" name="Qlab_301" value="<?php echo $lab_301; ?>" />
<input type="hidden" name="Qlab_304" value="<?php echo $lab_304; ?>" />
<input type="hidden" name="Qlab_307" value="<?php echo $lab_307; ?>" />
<input type="hidden" name="Qlab_575" value="<?php echo $lab_575; ?>" />
<input type="hidden" name="Qlab_566" value="<?php echo $lab_566; ?>" />
<input type="hidden" name="Qlab_567" value="<?php echo $lab_567; ?>" />
<input type="hidden" name="Qlab_531" value="<?php echo $lab_531; ?>" />
<input type="hidden" name="Qlab_532" value="<?php echo $lab_532; ?>" />
<input type="hidden" name="Qlab_511" value="<?php echo $lab_511; ?>" />
<table width="100%">
  <tr>
    <td class="title" colspan="2">Dietary patterns and physiological function</td>
  </tr>
  <tr>
    <td class="title_s">Dietary ability</td>
    <td><?php echo draw_option("Q8","Self-feeding;Oral feeding;Nasogastric feeding;Gastrostomy;Other","xm","single",$Q8,true,3); ?><input type="text" name="Q8a" id="Q8a" value="<?php echo $Q8a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Ability to chew</td>
    <td><?php echo draw_option("Q9","Normal(Normal diet);Fair(Soft/chopped);Poor(Liquid/Semi-liquid diet);None(Tube feeding)","xl","single",$Q9,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Swallowing ability</td>
    <td><?php echo draw_option("Q10","Good(Smoothly without coughing);Fair(Occasionally bucking);Poor(Unable to swallow)","xxl","single",$Q10,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Diet habits</td>
    <td><?php echo draw_option("Q11","None;Lacto vegetarian;Vegan;Other","xm","single",$Q11,false,3); ?><input type="text" name="Q11a" id="Q11a" value="<?php echo $Q11a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Food allergies</td>
    <td><?php echo draw_option("Q35","None;Yes","m","single",$Q35,false,3); ?><input type="text" name="Q35a" id="Q35a" value="<?php echo $Q35a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Mobility</td>
    <td><?php echo draw_option("Q12","Coma;Bedfast;Wheelchair;Move freely;Other","m","single",$Q12,false,3); ?><input type="text" name="Q12a" id="Q12a" value="<?php echo $Q12a; ?>" /></td>

  </tr>
  <tr>
    <td class="title_s">Recent<br />Gastrointestinal system</td>
    <td><?php echo draw_option("Q13","Normal;Nausea;Vomiting;Abdominal distention;Diarrhea;Constipation;Slow digestion;Poor appetite;Other","l","single",$Q13,true,3); ?><input type="text" name="Q13a" id="Q13a" value="<?php echo $Q13a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Comprehensive subjective assessment</td>
    <td><?php echo draw_option("Q16","Adequate nutrition;Undernutrition;Severe undernutrition","l","single",$Q16,false,3); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Assess</td>
  </tr>
  <tr>
    <td class="title_s">Weight change</td>
    <td><?php echo draw_option("Q17","Normal;Underweight;Overweight;1 month>5%;3 months>7.5%;6 months>10%","xm","single",$Q17,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Caloric requirement</td>
    <td><input type="text" name="Q18" id="Q18" value="<?php if ($Q18=="") { echo (30*$idealweight); } else { echo $Q18; } ?>" /> kcal/day</td>
  </tr>
  <tr>
    <td class="title_s">Protein requirement</td>
    <td><input type="text" name="Q19" id="Q19" value="<?php echo $Q19; ?>" /> g/day</td>
  </tr>
  <tr>
    <td class="title_s">Water requirement</td>
    <td><input type="text" name="Q20" id="Q20" value="<?php if ($Q20=="") { echo (35*$r_bw_now['Value']); } else { echo $Q20; } ?>" /> cc/day</td>
  </tr>
  <tr>
    <td class="title_s">Salt(Sodium) requirement</td>
    <td><input type="text" name="Q21" id="Q21" value="<?php echo $Q21; ?>" /> g/day</td>
  </tr>
  <tr>
    <td class="title_s">Intake reach requirment %</td>
    <td><?php echo draw_option("Q22",">100%;80%;50%;25%;<25%","m","single",$Q22,false,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Dietary / feeding patterns</td>
    <td><?php echo draw_checkbox("Q23","Appropriate, maintain;Poorly diet, observation;Unhealthy eating patterns, should be improved",$Q23,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Medication condition</td>
  </tr>
  <tr>
    <td colspan="2">
    <?php
	$db4 = new DB;
	$db4->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND `Qstartdate`<='".date('Y/m/d')."' AND (`Qenddate`>='".date('Y/m/d')."' OR `Qenddate`='')");
	for ($j=0;$j<$db4->num_rows();$j++) {
		$r4 = $db4->fetch_assoc();		
		$Qnursedescript2 .= ($j+1).'、'.$r4['Qmedicine'].' ('.$r4['Qdose'].$r4['Qdoseq'].') '.$r4['Qusage'].' ' .$r4['Qway'].' '.$r4['Qfreq'];
		if ($j != $db4->num_rows()) { $Qnursedescript2 .= '<br>'; }
	}
	?>
    <?php echo $Qnursedescript2; ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Overall</td>
  </tr>
  <tr>
    <td class="title_s">Related problems</td>
    <td><textarea cols="90" rows="5" name="Q24" id="Q24"><?php echo $Q24; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Cause of disease</td>
    <td><textarea cols="90" rows="5" name="Q25" id="Q25"><?php echo $Q25; ?></textarea></td>
  </tr>
  <tr>
    <td class="title_s">Symptoms</td>
    <td><textarea cols="90" rows="5" name="Q26" id="Q26"><?php echo $Q26; ?></textarea></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Plan</td>
  </tr>
  <tr>
    <td class="title_s">Dietary categories<br />and frequency</td>
    <td>
	<?php echo draw_option("Q27","Oral Diet;NG Diet;Oral+NG Diet","l","single",$Q27,false,3); ?><br>
    <?php echo draw_option("Q34","Low salt;Diabetic;Low cholesterol","l","multi",$Q34,false,3); ?>
	<textarea cols="90" rows="10" name="Q28" id="Q28"><?php echo $Q28; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title_s">Water intake<br />status</td>
    <td>
    Pipeline water intake volume:<input type="text" name="Q29" id="Q29" value="<?php echo $Q29; ?>" /> cc/day<br />
    Pipeline water flush volume:<input type="text" name="Q30" id="Q30" value="<?php echo $Q30; ?>" /> cc/day<br />
    Other water intake:<input type="text" name="Q31" id="Q31" value="<?php echo $Q31; ?>" /> cc/day<br />
    Total:<input type="text" name="Q32" id="Q32" value="<?php echo $Q32; ?>" /> cc/day<br />
    </td>
  </tr>
  <tr>
    <td class="title" colspan="2">Follow up tracking and improvment status</td>
  </tr>
  <tr>
    <td colspan="2">
    <textarea cols="90" rows="15" name="Q33" id="Q33"><?php echo $Q33; ?></textarea>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform33" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br>