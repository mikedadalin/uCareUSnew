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
	$sql = "SELECT * FROM `socialform32` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform32` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Nutrition notification</h3>
<table width="100%">
  <tr>
    <td class="title" width="100">Full name</td>
    <td width="240"><?php echo $name; ?></td>
    <td width="100" class="title">Gender/Age</td>
    <td colspan="3" width="240"><?php echo checkgender(mysql_escape_string($_GET['pid'])); ?> / <input type="text" name="Q1" id="Q1" size="3" value="<?php if ($Q1==NULL) { echo calcagenum($Birth); } else { echo $Q1; } ?>" />Years old</td>
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
	}
	</script>
  <tr>

    <td class="title">Height</td>
    <td><input type="text" name="Q2" id="Q2" value="<?php if ($tabsID==0) { echo $heightfeet; } else { echo $Q2feet; } ?>" size="4" onkeyup="calcbmi();">(e.g. 5'11)</td>
    
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
	}
	/* 原V
	$db_bw_last = new DB;
	$db_bw_last->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".@$_GET['pid']."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 1,1");
	$r_bw_last = $db_bw_last->fetch_assoc();
	*/
	// 新V START
	$db_bw_last = new DB;
	$db_bw_last->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 1,1");
	$r_bw_last = $db_bw_last->fetch_assoc();
	// 新V END
	if ($r_bw_now['Value']=="" || $r_bw_last['Value']=="") {
		$bw_change = '0';
	} else {
		$bw_change = round((($r_bw_now['Value']/$r_bw_last['Value'])-1)*100,2);
	}
	?>
    
    <td class="title">Current weight</td>
    <td><input type="text" name="Q2a" id="Q2a" value="<?php if ($tabsID==0) { echo $r_bw_now['Value']; } else { echo $Q2a; } ?>" size="4"  onkeyup="calcbmi();">lbs</td>
    <td class="title" width="100">BMI</td>
    <td><input type="text" name="Q2b" id="Q2b" value="<?php if ($tabsID==0) { echo $BMI; } else { echo $Q2b; } ?>" size="4" ></td>
  </tr>
  <tr>
    <td class="title">Ideal weight</td>
    <td><input type="text" name="Q3a" id="Q3a" value="<?php if ($tabsID==0) { echo $idealweightlbs; } else { echo $Q3a; } ?>" size="4" >lbs</td>
    <td class="title">Ideal BMI</td>
    <td colspan="3">22</td>
  </tr>
  <tr>
  <td class="title">Amputation</td>

    <td colspan="5"><?php echo draw_option("Q4","None;Yes","m","single",$Q4,false,3); ?>Part(s):<input type="text" name="Q4a" id="Q4a" value="<?php echo $Q4a; ?>" size="20" /></td>

  </tr>
  <tr>
    <td class="title">Edema</td>
    <td colspan="5"><?php echo draw_option("Q5","None;Yes","m","single",$Q5,false,3); ?>Severity:<input type="text" name="Q5a" id="Q5a" value="<?php echo $Q5a; ?>" size="20" /> / part(s):<input type="text" name="Q5b" id="Q5b" value="<?php echo $Q5b; ?>" size="20" /></td>
  </tr>
  <tr>
    <td class="title">Pressure ulcer(s)</td>
    <td colspan="5"><?php echo draw_option("Q6","None;Yes","m","single",$Q6,false,3); ?> Location and size:<input type="text" name="Q6a" id="Q6a" value="<?php echo $Q6a; ?>" size="50" /></td>
  </tr>
  <!--<tr>
    <td class="title">Disease diagnosis</td>
    <td colspan="5"><?php //echo draw_option("Q7","Renal function decline;Dialysis;Hypertension;Hyperlipidemia;Gout;Diabetes;COPD;Heart disease;Peptic ulcer;Stroke;Dementia;Other","m","multi",$Q7,true,7); ?>：<input type="text" name="Q7a" id="Q7a" value="<?php echo $Q7a; ?>" size="20" /></td>
  </tr>-->
  <tr>
    <td class="title">Disease diagnosis</td>
    <td colspan="5"><input type="text" name="Q7a" id="Q7a" value="<?php if ($Q7a==NULL) { echo $diagMsg; } else { echo $Q7a; } ?>" size="80" /></td>
  </tr>
  <tr>
    <td class="title">Reason for notification</td>
    <td colspan="5"><?php echo draw_option("Q19","New admission;Readmission;Nutritional status change;Return from hospitalization;Other","xl","multi",$Q19,true,3); ?>：<input type="text" name="Q19a" id="Q19a" value="<?php echo $Q19a; ?>" size="20" /></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" width="200">Percent Intake by Artificial Route</td>
    <td class="title_s" colspan="1">While NOT a resident</td>
    <td class="title_s" colspan="1">While a Resident</td>
    <td class="title_s" colspan="1">During entire 7 days</td>
  </tr>
  <tr>
    <td class="title_s">Proportion of total calories the resident received through parenteral or tube feeding</td>
    <td><?php echo draw_option("Q21","25% or less;26-50%;51% or more","m","single",$Q21,false,1); ?></td>
    <td><?php echo draw_option("Q22","25% or less;26-50%;51% or more","m","single",$Q22,false,1); ?></td>
    <td><?php echo draw_option("Q23","25% or less;26-50%;51% or more","m","single",$Q23,false,1); ?></td>
  </tr>
  <tr>
    <td class="title_s">Average fluid intake per day by IV or tube feeding</td>
    <td><?php echo draw_checkbox_2col("Q24","500 cc/day or less;501 cc/day or more",$Q24,"single"); ?></td>
    <td><?php echo draw_checkbox_2col("Q25","500 cc/day or less;501 cc/day or more",$Q25,"single"); ?></td>
    <td><?php echo draw_checkbox_2col("Q26","500 cc/day or less;501 cc/day or more",$Q26,"single"); ?></td>
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
    <td><?php echo $lab_579; ?></td>
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
    <td colspan="3">Blood glucose before meals(mg/dl)<br />65–110</td>
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
    <td colspan="3"><?php echo $lab_511; ?></td>
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
    <td colspan="6" class="title">Current eating patterns</td>
  </tr>
  <tr>
    <td width="120" class="title_s">Oral intake</td>
    <td colspan="5"><?php echo draw_option("Q8a","General;Crushed meal;Mashed meal;Oral intake full liquid diet;Vegetarian (All meals);Vegetarian (Breakfast);Vegetarian (once/month);Vegetarian (memorial day);Cooked rice;Porridge;Nutritious porridge;Large bowl;Small bowl;Jelly;Milk","xl","multi",$Q8a,true,3); ?>：<input type="text" name="Q8b" value="<?php echo $Q8b; ?>" size="14" /></td>
  </tr>
  <tr class="title_s">
    <td>&nbsp;</td>
    <td>Date</td>
    <td>Breakfast</td>
    <td>Lunch</td>
    <td>Refreshment</td>
    <td>Dinner</td>
  </tr>
  <tr>
    <td width="120" class="title_s" rowspan="3">Food intake</td>
    <td><script> $(function() { $( "#Q12a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q12a" id="Q12a" value="<?php if ($Q12a != NULL) { echo $Q12a; } ?>" size="10"></td>
    <td><?php echo draw_checkbox("Q12b","Fully;2/3;1/2;1/4;Not eat",$Q12b,"single"); ?></td>
    <td><?php echo draw_checkbox("Q12c","Fully;2/3;1/2;1/4;Not eat",$Q12c,"single"); ?></td>
    <td><?php echo draw_checkbox("Q12d","Fully;2/3;1/2;1/4;Not eat",$Q12d,"single"); ?></td>
    <td><?php echo draw_checkbox("Q12e","Fully;2/3;1/2;1/4;Not eat",$Q12e,"single"); ?></td>
  </tr>
  <tr>
    <td><script> $(function() { $( "#Q13a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q13a" id="Q13a" value="<?php if ($Q13a != NULL) { echo $Q13a; } ?>" size="10"></td>
    <td><?php echo draw_checkbox("Q13b","Fully;2/3;1/2;1/4;Not eat",$Q13b,"single"); ?></td>
    <td><?php echo draw_checkbox("Q13c","Fully;2/3;1/2;1/4;Not eat",$Q13c,"single"); ?></td>
    <td><?php echo draw_checkbox("Q13d","Fully;2/3;1/2;1/4;Not eat",$Q13d,"single"); ?></td>
    <td><?php echo draw_checkbox("Q13e","Fully;2/3;1/2;1/4;Not eat",$Q13e,"single"); ?></td>
  </tr>
  <tr>
    <td><script> $(function() { $( "#Q14a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q14a" id="Q14a" value="<?php if ($Q14a != NULL) { echo $Q14a; } ?>" size="10"></td>
    <td><?php echo draw_checkbox("Q14b","Fully;2/3;1/2;1/4;Not eat",$Q14b,"single"); ?></td>
    <td><?php echo draw_checkbox("Q14c","Fully;2/3;1/2;1/4;Not eat",$Q14c,"single"); ?></td>
    <td><?php echo draw_checkbox("Q14d","Fully;2/3;1/2;1/4;Not eat",$Q14d,"single"); ?></td>
    <td><?php echo draw_checkbox("Q14e","Fully;2/3;1/2;1/4;Not eat",$Q14e,"single"); ?></td>
  </tr>
</table>
<table>
  <tr>
    <td width="120" class="title_s">Intubation feeding</td>
    <td colspan="7"><?php echo draw_checkbox_2col("Q15a",'Nasogastric tube;Nasointestinal tube;Gastrostomy;Colostomy;Feeding bag;Tube feeding:<input type="text" name="Q15b" value="'.$Q15b.'" size="4" />ml * <input type="text" name="Q15c" value="'.$Q15c.'" size="2" />Meal(s);Self-prepared:<input type="text" name="Q15d" value="'.$Q15d.'" size="14" />',$Q15a,"multi"); ?></td>
  </tr>
  <tr class="title_s">
    <td>&nbsp;</td>
    <td>Date</td>
    <td>06:30</td>
    <td>10:30</td>
    <td>14:30</td>
    <td>16:30</td>
    <td>22:30</td>
    <td>02:30</td>
  </tr>
  <tr>
    <td width="120" class="title_s" rowspan="3">Food intake</td>
    <td><script> $(function() { $( "#Q16a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q16a" id="Q16a" value="<?php if ($Q16a != NULL) { echo $Q16a; } ?>" size="10"></td>
    <td><?php echo draw_checkbox("Q16b","Fully;2/3;1/2;1/4;Undigested",$Q16b,"single"); ?></td>
    <td><?php echo draw_checkbox("Q16c","Fully;2/3;1/2;1/4;Undigested",$Q16c,"single"); ?></td>
    <td><?php echo draw_checkbox("Q16d","Fully;2/3;1/2;1/4;Undigested",$Q16d,"single"); ?></td>
    <td><?php echo draw_checkbox("Q16e","Fully;2/3;1/2;1/4;Undigested",$Q16e,"single"); ?></td>
    <td><?php echo draw_checkbox("Q16f","Fully;2/3;1/2;1/4;Undigested",$Q16f,"single"); ?></td>
    <td><?php echo draw_checkbox("Q16g","Fully;2/3;1/2;1/4;Undigested",$Q16g,"single"); ?></td>
  </tr>
  <tr>
    <td><script> $(function() { $( "#Q17a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q17a" id="Q17a" value="<?php if ($Q17a != NULL) { echo $Q17a; } ?>" size="10"></td>
    <td><?php echo draw_checkbox("Q17b","Fully;2/3;1/2;1/4;Undigested",$Q17b,"single"); ?></td>
    <td><?php echo draw_checkbox("Q17c","Fully;2/3;1/2;1/4;Undigested",$Q17c,"single"); ?></td>
    <td><?php echo draw_checkbox("Q17d","Fully;2/3;1/2;1/4;Undigested",$Q17d,"single"); ?></td>
    <td><?php echo draw_checkbox("Q17e","Fully;2/3;1/2;1/4;Undigested",$Q17e,"single"); ?></td>
    <td><?php echo draw_checkbox("Q17f","Fully;2/3;1/2;1/4;Undigested",$Q17f,"single"); ?></td>
    <td><?php echo draw_checkbox("Q17g","Fully;2/3;1/2;1/4;Undigested",$Q17g,"single"); ?></td>
  </tr>
  <tr>
    <td><script> $(function() { $( "#Q18a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q18a" id="Q18a" value="<?php if ($Q18a != NULL) { echo $Q18a; } ?>" size="10"></td>
    <td><?php echo draw_checkbox("Q18b","Fully;2/3;1/2;1/4;Undigested",$Q18b,"single"); ?></td>
    <td><?php echo draw_checkbox("Q18c","Fully;2/3;1/2;1/4;Undigested",$Q18c,"single"); ?></td>
    <td><?php echo draw_checkbox("Q18d","Fully;2/3;1/2;1/4;Undigested",$Q18d,"single"); ?></td>
    <td><?php echo draw_checkbox("Q18e","Fully;2/3;1/2;1/4;Undigested",$Q18e,"single"); ?></td>
    <td><?php echo draw_checkbox("Q18f","Fully;2/3;1/2;1/4;Undigested",$Q18f,"single"); ?></td>
    <td><?php echo draw_checkbox("Q18g","Fully;2/3;1/2;1/4;Undigested",$Q18g,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Comment</td>
    <td colspan="7">
    <textarea cols="90" rows="5" name="Q8" id="Q8"><?php echo $Q8; ?></textarea>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title">Assessment results</td>
  </tr>
  <tr>
    <td>
    <textarea cols="90" rows="5" name="Q9" id="Q9"><?php echo $Q9; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title">Treatment</td>
  </tr>
  <tr>
    <td>
    <textarea cols="90" rows="5" name="Q10" id="Q10"><?php echo $Q10; ?></textarea>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform32" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br>