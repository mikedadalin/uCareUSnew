<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02g_1` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02g_1` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Clinical pressure ulcer risk assessment</h3>
<form action="" onSubmit="return checkForm();"   method="post" onSubmit="return checkForm();">
<table width="100%">
  <tr class="title">
    <td width="40">Assessment item</td>
    <td width="198">1 point</td>
    <td width="198">2 point</td>
    <td width="198">3 point</td>
    <td width="198">4 point</td>
    <td>Subtotal</td>
  </tr>
  <tr>
    <td class="title">Mental status</td>
    <td valign="top"><?php echo draw_checkbox("Q1","Clear / aware;When,Who,Where all aware",$Q1,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q2","Apathy;When,Who,Where 1-2 confused",$Q2,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q3","Orderless;When,Who,Where all confused",$Q3,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q4","Stupor,Somnolence,Comma;No reaction other than pain",$Q4,"multi"); ?></td>
    <td><input type="text" name="Q1total" id="Q1total" size="4"  value="<?php echo $Q1total; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Excretion status</td>
    <td valign="top"><?php echo draw_checkbox("Q5","Able to control;Indwelling catheter;Constipation",$Q5,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q6","Occasionally incontinence;Occasionally fecal incontinence.Occasionally =1-2 times/day",$Q6,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q7","Frequently incontinence;Frequently fecal incontinence or diarrhea. Frequently = 3-6times/day",$Q7,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q8","Incontinence, or diarrhea ≧ 7 times/day",$Q8,"multi"); ?></td>
    <td><input type="text" name="Q2total" id="Q2total" size="4"  value="<?php echo $Q2total; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Mobility</td>
    <td valign="top"><?php echo draw_checkbox("Q9","Limbs can fully & freely move ;Free to ambulation;Move freely with assistive device",$Q9,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q10","Need assistance for ambulation ;can turn over on their own with minor restriction in limb movement",$Q10,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q11","In a wheelchair;Physical activity limited by traction, plaster or stent restrictions.",$Q11,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q12","Bedridden;Completely unable to turn over on their own.;Prescription to fix on bed",$Q12,"multi"); ?></td>
    <td><input type="text" name="Q3total" id="Q3total" size="4"   value="<?php echo $Q3total; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Local touch sensation</td>
    <td valign="top"><?php echo draw_checkbox("Q13","Normal sensation",$Q13,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q14","Hypersensitivity / abnormalities, such as: hemp, burning, tingling",$Q14,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q15","Hypoesthesia",$Q15,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q16","Sensation completely lost",$Q16,"multi"); ?></td>
    <td><input type="text" name="Q4total" id="Q4total" size="4"  value="<?php echo $Q4total; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Skin conditions / blood circulation</td>
    <td valign="top"><?php echo draw_checkbox("Q17","Good elasticity;Capillary refill time < 5 sec",$Q17,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q18","Dried and fragile skin;Capillary refill time > 5 sec;Local pipeline oppression, such as: nasogastric, drainage tube",$Q18,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q19","Obesity: over Standard weight 20%%;Underweight: 20% less than standard weight %;Dehydration: skin, mucosal dried;Slight edema: below the ankle",$Q19,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q20","Moderate edema: below lower leg;Severe edema: below thigh or generalized edema;Pressure at the bony prominences",$Q20,"multi"); ?></td>
    <td><input type="text" name="Q5total" id="Q5total" size="4"  value="<?php echo $Q5total; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Nutritional status</td>
    <td valign="top"><?php echo draw_checkbox("Q21","Eyelid rosy;Hb≧12g%;Albumin≧3.5mg/dl",$Q21,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q22","Eyelids minor pale;10g%≦Hb＜12g%;2.8≦Albumin＜3.4 mg/dl",$Q22,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q23","Eyelid significantly pale ;Hb＜10g%;Albumin≦2.7 mg/dl",$Q23,"multi"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q24","Eyelid extremely pale;Hb＜8g%;Cachexia, such as: terminal cancer, uremia",$Q24,"multi"); ?></td>
    <td><input type="text" name="Q6total" id="Q6total" size="4"  value="<?php echo $Q6total; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:right" colspan="5">Total score:</td>
    <td><input type="text" name="Qtotal" id="Qtotal" size="4"  value="<?php echo $Qtotal; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:right" colspan="5">Pressure ulcer(s) occurred:</td>
    <td><?php echo draw_option("Q25","Yes;No","ss","multi",$Q25,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left" colspan="4">Risk:<br />Low：6-9 points；<br />Mild：10-14 points；<br />Moderate：15-19 points；<br />High: ≧20 points；<br />Score ≧10 points require to list on nursing care problem and measures for continuously monitoring the skin condition.</td>
    <td class="title_s" style="text-align:right">Risk Assessment Results:</td>
    <td><input type="text" name="Qresult" id="Qresult" size="6"   value="<?php echo $Qresult; ?>"/></td>
  </tr>
  <tr>
    <td colspan="3">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td colspan="3" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02g_1" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
<script>
$(document).ready(function () {
	calcTotal();
	$("[id*='btn_Q']").click(function() {
		calcTotal();
	});
})

function calcQ1() {
	var Q1total = 0;
	if ($('#Q1_1').val()==1 || $('#Q1_2').val()==1) { Q1total += 1; }
	if ($('#Q2_1').val()==1 || $('#Q2_2').val()==1) { Q1total += 2; }
	if ($('#Q3_1').val()==1 || $('#Q3_2').val()==1) { Q1total += 3; }
	if ($('#Q4_1').val()==1 || $('#Q4_2').val()==1) { Q1total += 4; }
	$('#Q1total').val(Q1total);
}

function calcQ2() {
	var Q2total = 0;
	if ($('#Q5_1').val()==1 || $('#Q5_2').val()==1 || $('#Q5_3').val()==1) { Q2total += 1; }
	if ($('#Q6_1').val()==1 || $('#Q6_2').val()==1) { Q2total += 2; }
	if ($('#Q7_1').val()==1 || $('#Q7_2').val()==1) { Q2total += 3; }
	if ($('#Q8_1').val()==1) { Q2total += 4; }
	$('#Q2total').val(Q2total);
}

function calcQ3() {
	var Q3total = 0;
	if ($('#Q9_1').val()==1 || $('#Q9_2').val()==1 || $('#Q9_3').val()==1) { Q3total += 1; }
	if ($('#Q10_1').val()==1 || $('#Q10_2').val()==1) { Q3total += 2; }
	if ($('#Q11_1').val()==1 || $('#Q11_2').val()==1) { Q3total += 3; }
	if ($('#Q12_1').val()==1 || $('#Q12_2').val()==1 || $('#Q12_3').val()==1) { Q3total += 4; }
	$('#Q3total').val(Q3total);
}

function calcQ4() {
	var Q4total = 0;
	if ($('#Q13_1').val()==1) { Q4total += 1; }
	if ($('#Q14_1').val()==1) { Q4total += 2; }
	if ($('#Q15_1').val()==1) { Q4total += 3; }
	if ($('#Q16_1').val()==1) { Q4total += 4; }
	$('#Q4total').val(Q4total);
}

function calcQ5() {
	var Q5total = 0;
	if ($('#Q17_1').val()==1 || $('#Q17_2').val()==1) { Q5total += 1; }
	if ($('#Q18_1').val()==1 || $('#Q18_2').val()==1 || $('#Q18_3').val()==1) { Q5total += 2; }
	if ($('#Q19_1').val()==1 || $('#Q19_2').val()==1 || $('#Q19_3').val()==1 || $('#Q19_4').val()==1) { Q5total += 3; }
	if ($('#Q20_1').val()==1 || $('#Q20_2').val()==1 || $('#Q20_3').val()==1) { Q5total += 4; }
	$('#Q5total').val(Q5total);
}

function calcQ6() {
	var Q6total = 0;
	if ($('#Q21_1').val()==1 || $('#Q21_2').val()==1 || $('#Q21_3').val()==1) { Q6total += 1; }
	if ($('#Q22_1').val()==1 || $('#Q22_2').val()==1 || $('#Q22_3').val()==1) { Q6total += 2; }
	if ($('#Q23_1').val()==1 || $('#Q23_2').val()==1 || $('#Q23_3').val()==1) { Q6total += 3; }
	if ($('#Q24_1').val()==1 || $('#Q24_2').val()==1 || $('#Q24_3').val()==1) { Q6total += 4; }
	$('#Q6total').val(Q6total);
}

function calcTotal() {
	calcQ1();	calcQ2();	calcQ3();	calcQ4();	calcQ5();	calcQ6();
	var Qtotal = parseInt($('#Q1total').val())+parseInt($('#Q2total').val())+parseInt($('#Q3total').val())+parseInt($('#Q4total').val())+parseInt($('#Q5total').val())+parseInt($('#Q6total').val());
	$('#Qtotal').val(Qtotal);
	if (Qtotal<6) { $('#Qresult').val("None"); $('#Qresult').css({"background-color": "#ffffff"}); }
	else if (Qtotal<=9) { $('#Qresult').val("Low"); $('#Qresult').css({"background-color": "#D1E3B1"}); }
	else if (Qtotal<=14) { $('#Qresult').val("Mild"); $('#Qresult').css({"background-color": "#F6F6AB"}); }
	else if (Qtotal<=19) { $('#Qresult').val("Moderate"); $('#Qresult').css({"background-color": "#FFB871"}); }
	else { $('#Qresult').val("High"); $('#Qresult').css({"background-color": "#FF7171"}); }
}
</script>
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