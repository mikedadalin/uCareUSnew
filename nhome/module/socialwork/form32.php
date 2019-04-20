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

//護理表單2b欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform11` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform11_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform11_'.$k} = $v; } }  else { ${'nurseform11_'.$k} = $v; } } }
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>新住民營養照會單</h3>
<table width="100%">
  <tr>
    <td class="title" width="100">Full name</td>
    <td width="240"><?php echo $name; ?></td>
    <td width="100" class="title">Gender/Age</td>
    <td colspan="3" width="240"><?php echo $arrGender[$Gender]; ?> / <input type="text" name="Q1" id="Q1" size="3" value="<?php if ($Q1==NULL) { echo calcagenum($Birth); } else { echo $Q1; } ?>" />Years old</td>
  </tr>
  <script>
	function calcbmi() {
		var height = (parseInt(document.getElementById('Q2').value))/100;
		var weight = parseInt(document.getElementById('Q2a').value);
		if (weight>10 && height>0.5) {
			var bmindx = weight/eval(height*height);
			bmindx = Math.round(bmindx*10) / 10;
			document.getElementById('Q2b').value = bmindx;
			var bmindx2 = eval(height*height)*22;
			bmindx2 = Math.round(bmindx2*10) / 10;
			document.getElementById('Q3a').value = bmindx2;
			var bmindx3 = bmindx2/eval(height*height);
			bmindx3 = Math.round(bmindx3*10) / 10;
			document.getElementById('Q3b').value = bmindx3;
		}
	}
	</script>
  <tr>
    <td class="title">Height</td>
    <td><input type="text" name="Q2" id="Q2" value="<?php if($nurseform11_Q5==''){ echo $heightfeet; }else{ echo $nurseform11_Q5; } ?>" size="4" onkeyup="calcbmi();">Cm</td>
    <td class="title">Weight (admission)</td>
    <td><input type="text" name="Q2a" id="Q2a" value="<?php if ($Q2a==NULL) { echo $Q2a; } else { echo $nurseform11_Q4; } ?>" size="4"  onkeyup="calcbmi();">Kilogram</td>
    <td class="title" width="100">BMI</td>
    <td><input type="text" name="Q2b" id="Q2b" value="<?php if ($Q2b==NULL) { echo $Q2b; } else { echo $nurseform11_Q5; } ?>" size="4" ></td>
  </tr>
  <tr>
    <td class="title">Ideal weight</td>
    <td><input type="text" name="Q3a" id="Q3a" value="<?php echo $nurseform11_Q4; ?>" size="4" >Kilogram</td>
    <td class="title">Ideal BMI</td>
    <td colspan="3"><input type="text" name="Q3b" id="Q3b" value="<?php echo $Q3b; ?>" size="4" ></td>
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
    <td colspan="5"><?php echo draw_option("Q7","Renal function decline;Dialysis;Hypertension;Hyperlipidemia;Gout;Diabetes;COPD;Heart disease;Peptic ulcer;Stroke;Dementia;Other","m","multi",$Q7,true,7); ?>：<input type="text" name="Q7a" id="Q7a" value="<?php echo $Q7a; ?>" size="20" /></td>
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
    <td class="title">Current eating patterns</td>
  </tr>
  <tr>
    <td>
    <textarea cols="90" rows="5" name="Q8" id="Q8"><?php echo $Q8; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title">問題</td>
  </tr>
  <tr>
    <td>
    <textarea cols="90" rows="5" name="Q9" id="Q9"><?php echo $Q9; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title">Assess</td>
  </tr>
  <tr>
    <td>
    <textarea cols="90" rows="5" name="Q10" id="Q10"><?php echo $Q10; ?></textarea>
    </td>
  </tr>
  <tr>
    <td class="title">建議配方與計畫</td>
  </tr>
  <tr>
    <td>
    <textarea cols="90" rows="5" name="Q11" id="Q11"><?php echo $Q11; ?></textarea>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform32" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>