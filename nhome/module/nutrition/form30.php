<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `Gender_1`,`Gender_2`,`height`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
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
	$sql = "SELECT * FROM `socialform30` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform30` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>新住民72小時營養評估篩檢表</h3>
<table>
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
    <td><input type="text" name="Q2" id="Q2" value="<?php if($nurseform11_Q5==""){ echo $heightfeet; }else{ echo $nurseform11_Q5; } ?>" size="4" onkeyup="calcbmi();">Cm</td>
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
    <td class="title">主觀判讀</td>
    <td colspan="5"><?php echo draw_option("Q4","很瘦;瘦;剛好;稍胖;很胖","m","single",$Q4,false,3); ?></td>
  </tr>
  <tr>
    <td class="title">情緒狀況</td>
    <td colspan="5"><?php echo draw_option("Q5","Normal;Apathy;Depression;不安","m","single",$Q5,false,3); ?></td>
  </tr>
  <tr>
    <td class="title">Blood pressure</td>
    <td>
    <?php
	/* 原V
    $db1a = new DB;
	$db1a->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8480-6' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	$r1a = $db1a->fetch_assoc();
    $db1b = new DB;
	$db1b->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8462-4' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	$r1b = $db1b->fetch_assoc();
	*/
	// 新V START
    $db1a = new DB;
	$db1a->query("SELECT `loinc_8480_6` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8480_6`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	$r1a = $db1a->fetch_assoc();
    $db1b = new DB;
	$db1b->query("SELECT `loinc_8462_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8462_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	$r1b = $db1b->fetch_assoc();
	// 新V END
	?>
    <input type="text" name="Q6a" id="Q6a" value="<?php if ($Q6a==NULL) { echo $r1a['Value']; } else { echo $Q6a; } ?>" size="2" />/<input type="text" name="Q6b" id="Q6b" value="<?php if ($Q6b==NULL) { echo $r1b['Value']; } else { echo $Q6b; } ?>" size="2" /> mmHg
	</td>
    <td class="title">Amputation</td>
    <td colspan="3"><?php echo draw_option("Q7","None;Yes","m","single",$Q7,false,3); ?>Part(s):<input type="text" name="Q7a" id="Q7a" value="<?php echo $Q7a; ?>" size="20" /></td>
  </tr>
  <tr>
    <td class="title">Ascites</td>
    <td colspan="5"><?php echo draw_option("Q8","Normal;Mild;Moderate;Severe","m","single",$Q8,false,3); ?></td>
  </tr>
  <tr>
    <td class="title">Edema</td>
    <td colspan="5"><?php echo draw_option("Q9","None;Yes","m","single",$Q9,false,3); ?>Severity: <input type="text" name="Q9a" id="Q9a" value="<?php echo $Q9a; ?>" size="20" /> / part(s):<input type="text" name="Q9b" id="Q9b" value="<?php echo $Q9b; ?>" size="20" /></td>
  </tr>
  <tr>
    <td class="title">Pressure ulcer(s)</td>
    <td colspan="5"><?php echo draw_option("Q10","None;Yes","m","single",$Q10,false,3); ?> Location and size:<input type="text" name="Q10a" id="Q10a" value="<?php echo $Q10a; ?>" size="50" /></td>
  </tr>
  <tr>
    <td class="title">Dental status</td>
    <td><?php echo draw_option("Q11a","Fair;無牙","m","single",$Q11a,false,3); ?></td>
    <td class="title">假牙</td>

    <td colspan="5"><?php echo draw_option("Q11b","None;Fully;半;部分","m","single",$Q11b,false,3); ?></td>
  </tr>
  <tr>
    <td class="title" rowspan="3">Blood glucose</td>
    <td class="title_s" rowspan="2">有糖尿病史 - 測量兩次</td>
    <td><font size="2">第1天空腹血糖</font></td>
    <td colspan="3"><input type="text" name="Q12a" id="Q12a" value="<?php echo $Q12a; ?>" size="3" /> mg/dl</td>
  </tr>
  <tr>
    <td><font size="2">第2天空腹血糖</font></td>
    <td  colspan="3"><input type="text" name="Q12b" id="Q12b" value="<?php echo $Q12b; ?>" size="3" /> mg/dl</td>
  </tr>
  <tr>
    <td class="title_s">無糖尿病史</td>
    <td>空腹血糖</td>
    <td colspan="3"><input type="text" name="Q12c" id="Q12c" value="<?php echo $Q12c; ?>" size="3" /> mg/dl</td>
  </tr>
  <tr>
    <td class="title">病史</td>
    <td colspan="5"><?php echo draw_option("Q13","Renal function decline;Dialysis;Hypertension;Hyperlipidemia;Gout;Diabetes;COPD;Heart disease;Peptic ulcer;Stroke;Dementia;Other","m","multi",$Q13,true,7); ?>：<input type="text" name="Q13a" id="Q13a" value="<?php echo $Q13a; ?>" size="20" /></td>
  </tr>
  <tr>
    <td class="title">飲食型態</td>
    <td colspan="5">
    <?php echo draw_option("Q14a","一般盤餐;Crushed meal;Mashed meal;Oral intake full liquid diet","l","single",$Q14a,false,7); ?><br />
    <?php echo draw_option("Q14c","General;Vegan;早素;初一;十五","m","single",$Q14c,false,7); ?><br />
    <?php echo draw_option("Q14d","Cooked rice;Porridge","m","multi",$Q14c,false,7); ?>
    <?php echo draw_checkbox_2col("Q14e","<input type='text' name='Q14f' id='Q14f' value='".$Q14f."' size='1'>Large bowl;<input type='text' name='Q14g' id='Q14g' value='".$Q14g."' size='1'>Small bowl;Tube feeding <input type='text' name='Q14h' id='Q14h' value='".$Q14h."' size='1'>ml * <input type='text' name='Q14i' id='Q14i' value='".$Q14i."' size='1'>Meal(s);Self-prepared:<input type='text' name='Q14j' id='Q14j' value='".$Q14j."' size='40'>",$Q14e,"multi"); ?>
    </td>
  </tr>
  <tr>
    <td class="title">Eating patterns</td>
    <td colspan="5"><?php echo draw_checkbox("Q15","可以自行進食;Mild difficulty when self-feeding;需人協助",$Q15,"single"); ?></td>
  </tr>
  <tr>
    <td class="title">Intubation feeding</td>
    <td colspan="5"><?php echo draw_option("Q16","Nasogastric tube;Nasointestinal tube;Gastrostomy","m","single",$Q16,false,1); ?></td>
  </tr>
  <tr>

    <td class="title">Ability to chew</td>
    <td colspan="5"><?php echo draw_option("Q17","佳（無障礙）;Fair;Poor","m","single",$Q17,false,1); ?></td>
  </tr>
  <tr>
    <td class="title">Swallowing ability</td>
    <td colspan="5"><?php echo draw_option("Q18","佳（無障礙）;Fair;Poor","m","single",$Q18,false,1); ?></td>
  </tr>
  <tr>
    <td class="title">Special food preferences</td>
    <td><input type="text" name="Q19" id="Q19" value="<?php echo $Q19; ?>" size="20" /></td>
    <td class="title">過敏食物</td>
    <td><input type="text" name="Q20" id="Q20" value="<?php echo $Q20; ?>" size="20" /></td>
    <td class="title">不喜歡食物</td>
    <td><input type="text" name="Q21" id="Q21" value="<?php echo $Q21; ?>" size="20" /></td>
  </tr>
  <tr>
    <td class="title">Weight change</td>
    <td colspan="5"><?php echo draw_checkbox_2col("Q22a","None;是，時間：<input type='text' name='Q22b' id='Q22b' value='".$Q22b."'>",$Q22a,"single"); ?><div style="margin-left:220px;"><?php echo draw_option("Q22c","上升;下降","s","single",$Q22c,false,1); ?>：<input type="text" name="Q22d" id="Q22d" value="<?php echo $Q22d; ?>" size="2" />Kilogram</div></td>
  </tr>
  <tr>
    <td class="title">Gastrointestinal symptoms<br /><font size="2">More than two days</font></td>
    <td colspan="5"><?php echo draw_option("Q23","Normal;Poor appetite;Nausea;Vomiting;Diarrhea;Constipation;Other","m","multi",$Q23,false,1); ?>：<input type="text" name="Q23a" id="Q23a" value="<?php echo $Q23a; ?>" size="10" /></td>
  </tr>
  <tr>
    <td class="title">Mobility</td>
    <td colspan="5"><?php echo draw_option("Q24","Bedfast;Wheelchair;Move freely;Other","m","multi",$Q24,false,1); ?>：<input type="text" name="Q23a" id="Q23a" value="<?php echo $Q23a; ?>" size="10" /></td>
  </tr>
  <tr>
    <td class="title" colspan="6">◎如有腹水/Edema/Dialysis/脫水個案請記錄三天</td>
  </tr>
  <tr>
    <td class="title_s" colspan="2">第一天I/O量</td>
    <td class="title_s" colspan="2">第二天I/O量</td>
    <td class="title_s" colspan="2">第三天I/O量</td>
  </tr>
  <tr>
    <td class="title_s">輸入量</td>
    <td><input type="text" name="Q25a" id="Q25a" size="6" value="<?php echo $Q25a; ?>" /></td>
    <td class="title_s">輸入量</td>
    <td><input type="text" name="Q26a" id="Q26a" size="6" value="<?php echo $Q26a; ?>" /></td>
    <td class="title_s">輸入量</td>
    <td><input type="text" name="Q27a" id="Q27a" size="6" value="<?php echo $Q27a; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Output</td>
    <td><input type="text" name="Q25b" id="Q25b" size="6" value="<?php echo $Q25b; ?>" /></td>
    <td class="title_s">Output</td>
    <td><input type="text" name="Q26b" id="Q26b" size="6" value="<?php echo $Q26b; ?>" /></td>
    <td class="title_s">Output</td>
    <td><input type="text" name="Q27b" id="Q27b" size="6" value="<?php echo $Q27b; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s" colspan="6">Intake含灌藥、沖管、餐間、配方水、果汁···等</td>
  </tr>
  <tr>
    <td class="title">補充品</td>
    <td colspan="5"><?php echo draw_option("Q28","None;果汁;B群;其它","m","multi",$Q28,false,1); ?>：<input type="text" name="Q28a" id="Q28a" value="<?php echo $Q28a; ?>" size="10" /></td>
  </tr>
  <tr>
    <td class="title">醫師特別處方</td>
    <td colspan="5"><?php echo draw_checkbox_2col("Q29a","限水：<input type='text' name='Q29b' id='Q29b' value='".$Q29b."' size='10' />;None;限鈉：<input type='text' name='Q29c' id='Q29c' value='".$Q29c."' size='10' />",$Q29a,"multi"); ?></td>
  </tr>
</table>
<table width="100%">
  <tr class="title">
    <td rowspan="3">&nbsp;</td>
    <td colspan="2">入住日</td>
    <td colspan="2">第二天</td>
    <td colspan="2">第三天</td>
  </tr>
  <tr class="title_s">
    <td colspan="2">Filled date：<script> $(function() { $( "#Q30a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q30a" id="Q30a" value="<?php if ($Q30a != NULL) { echo $Q30a; } else { echo $indate; } ?>" size="12"></td>
    <td colspan="2">Filled date：<script> $(function() { $( "#Q30b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q30b" id="Q30b" value="<?php if ($Q30b != NULL) { echo $Q30b; } else { echo calcdayafterday($indate,1); } ?>" size="12"></td>
    <td colspan="2">Filled date：<script> $(function() { $( "#Q30c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q30c" id="Q30c" value="<?php if ($Q30c != NULL) { echo $Q30c; } else { echo calcdayafterday($indate,2); } ?>" size="12"></td>
  </tr>
  <tr class="title_s">
    <td>Oral intake</td>
    <td>Tube feeding</td>
    <td>Oral intake</td>
    <td>Tube feeding</td>
    <td>Oral intake</td>
    <td>Tube feeding</td>
  </tr>
  <tr>
    <td class="title_s">Breakfast<br />0900</td>
    <td valign="top"><?php echo draw_checkbox("Q31a","全部吃完;2/3;1/2;1/4;完全沒吃",$Q31a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q32a","反抽無消化液;反抽有消化液;未灌食",$Q32a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q31b","全部吃完;2/3;1/2;1/4;完全沒吃",$Q31b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q32b","反抽無消化液;反抽有消化液;未灌食",$Q32b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q31c","全部吃完;2/3;1/2;1/4;完全沒吃",$Q31c,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q32c","反抽無消化液;反抽有消化液;未灌食",$Q32c,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Lunch<br />1300</td>
    <td valign="top"><?php echo draw_checkbox("Q33a","全部吃完;2/3;1/2;1/4;完全沒吃",$Q33a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q34a","反抽無消化液;反抽有消化液;未灌食",$Q34a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q33b","全部吃完;2/3;1/2;1/4;完全沒吃",$Q33b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q34b","反抽無消化液;反抽有消化液;未灌食",$Q34b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q33c","全部吃完;2/3;1/2;1/4;完全沒吃",$Q33c,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q34c","反抽無消化液;反抽有消化液;未灌食",$Q34c,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Refreshment<br />1700</td>
    <td valign="top"><?php echo draw_checkbox("Q35a","全部吃完;2/3;1/2;1/4;完全沒吃",$Q35a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q36a","反抽無消化液;反抽有消化液;未灌食",$Q36a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q35b","全部吃完;2/3;1/2;1/4;完全沒吃",$Q35b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q36b","反抽無消化液;反抽有消化液;未灌食",$Q36b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q35c","全部吃完;2/3;1/2;1/4;完全沒吃",$Q35c,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q36c","反抽無消化液;反抽有消化液;未灌食",$Q36c,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Dinner<br />2100</td>
    <td valign="top"><?php echo draw_checkbox("Q37a","全部吃完;2/3;1/2;1/4;完全沒吃",$Q37a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q38a","反抽無消化液;反抽有消化液;未灌食",$Q38a,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q37b","全部吃完;2/3;1/2;1/4;完全沒吃",$Q37b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q38b","反抽無消化液;反抽有消化液;未灌食",$Q38b,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q37c","全部吃完;2/3;1/2;1/4;完全沒吃",$Q37c,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q38c","反抽無消化液;反抽有消化液;未灌食",$Q38c,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">0100</td>
    <td valign="top"></td>
    <td valign="top"><?php echo draw_checkbox("Q39a","反抽無消化液;反抽有消化液;未灌食",$Q39a,"single"); ?></td>
    <td valign="top"></td>
    <td valign="top"><?php echo draw_checkbox("Q39b","反抽無消化液;反抽有消化液;未灌食",$Q39b,"single"); ?></td>
    <td valign="top"></td>
    <td valign="top"><?php echo draw_checkbox("Q39c","反抽無消化液;反抽有消化液;未灌食",$Q39c,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">0500</td>
    <td valign="top"></td>
    <td valign="top"><?php echo draw_checkbox("Q40a","反抽無消化液;反抽有消化液;未灌食",$Q40a,"single"); ?></td>
    <td valign="top"></td>
    <td valign="top"><?php echo draw_checkbox("Q40b","反抽無消化液;反抽有消化液;未灌食",$Q40b,"single"); ?></td>
    <td valign="top"></td>
    <td valign="top"><?php echo draw_checkbox("Q40c","反抽無消化液;反抽有消化液;未灌食",$Q40c,"single"); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform30" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>