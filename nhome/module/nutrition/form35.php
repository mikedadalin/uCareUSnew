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
	$sql = "SELECT * FROM `socialform35` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform35` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Preliminary nutrition assessment(72hr)</h3>
<table width="100%">
  <tr>
    <td class="title" width="100">Full name</td>
    <td width="240"><?php echo $name; ?></td>
    <td width="100" class="title">Gender/Age</td>
    <td colspan="3" width="240"><?php echo checkgender($_GET['pid']); ?> / <input type="text" name="Q1" id="Q1" size="3" value="<?php if ($Q1==NULL) { echo calcagenum($Birth); } else { echo $Q1; } ?>" />Years old</td>
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
</table>
<table width="100%">
	<tr>
    	<td class="title" rowspan="8">Food intake</td>
        <td class="title_s">(1)	Food intake status</td>
        <td><?php echo draw_checkbox_2col("Q4","General/Crushed;Vegetarian;Fully-liquid diet;Semi-liquid diet;Tube feeding or intravenous injection;Other(s):<input type=\"text\" id=\"Q4a\" name=\"Q4a\" size=\"20\" value=\"".$Q4a."\">",$Q4,"single"); ?></td>
    </tr>
	<tr>
        <td class="title_s">(2)	Dietary status</td>
        <td><?php echo draw_checkbox_2col("Q5","Self feeding without assistance;Mild difficulty when self-feeding;Unable to perform self-feeding without assistance",$Q5,"single"); ?></td>
    </tr>
	<tr>
        <td rowspan="4" class="title_s">(3)	Food intake<br>(compared to supply)</td>
        <td>Breakfast &nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_checkbox_nobr("Q6","≧4/4;3/4;2/4;≦1/4",$Q6,"single"); ?></td>
    </tr>
	<tr>
	    <td>Lunch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_checkbox_nobr("Q7","≧4/4;3/4;2/4;≦1/4",$Q7,"single"); ?></td>
	</tr>
	<tr>
	    <td>Dinner &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_checkbox_nobr("Q8","≧4/4;3/4;2/4;≦1/4",$Q8,"single"); ?></td>
	</tr>
	<tr>
	    <td>Refreshment<?php echo draw_checkbox_nobr("Q9","≧4/4;3/4;2/4;≦1/4",$Q9,"single"); ?></td>
	</tr>
	<tr>
        <td rowspan="2" class="title_s">(4)	Special food preferences</td>
        <td>Dislike:<input type="text" id="Q10" name="Q10" size="50" value="<?php echo $Q10; ?>"></td>
    </tr>
	<tr>
        <td>Food allergies:<input type="text" id="Q11" name="Q11" size="50" value="<?php echo $Q11; ?>"></td>
	</tr>
	<tr>
    	<td class="title">Gastrointestinal symptoms<br> (More than two weeks)</td>
        <td colspan="2"><?php echo draw_checkbox_nobr("Q12","None;Chewing difficulty;Dysphagia;Nausea;Vomiting;Diarrhea;Anorexia;Hematochezia",$Q12,"single"); ?></td>
    </tr>
	<tr>

    	<td class="title">Functional assessment</td>
        <td colspan="2"><?php echo draw_checkbox_nobr("Q13","No dysfunction;Can walk;wheelchair;Bedfast",$Q13,"single"); ?><br>(Based on Karnofsky scale：0 means no dysfunction;1-2 means can walk;3 apply wheelchair;4 means bedfast)</td>
    </tr>
	<tr>
        <td rowspan="4" class="title">Physiological tests</td>
        <td class="title_s">Subcutaneous fat reduction<br>(Shoulders, triceps, chest, hands)</td>
        <td><?php echo draw_option("Q14","0=Normal;1+=Mild;2+=Moderate;3+=Severe","m","single",$Q14,false,5); ?></td>
    </tr>
	<tr>
        <td class="title_s">Weak muscles<br>(Quadriceps, deltoid)<br>Lower extremity edema</td>
	    <td><?php echo draw_option("Q15","0=Normal;1+=Mild;2+=Moderate;3+=Severe","m","single",$Q15,false,5); ?></td>
	</tr>
	<tr>
        <td class="title_s">Ascites</td>
	    <td><?php echo draw_option("Q16","0=Normal;1+=Mild;2+=Moderate;3+=Severe","m","single",$Q16,false,5); ?></td>
	</tr>
	<tr>

        <td class="title_s">Pressure ulcer(s)</td>
	    <td><?php echo draw_option("Q17","0=Normal;1+=Mild;2+=Moderate;3+=Severe","m","single",$Q17,false,5); ?> <input type="text" name="Q17a" id="Q17a" value="<?php echo $Q17a; ?>" size="5">Stage</td>

	</tr>
	<tr>
	    <td class="title">Comprehensive subjective assessment</td>
	    <td colspan="2"><?php echo draw_option("Q18","A=Adequate nutrition;B=Undernutrition;C=Severe undernutrition","xxl","single",$Q18,false,5); ?></td>
	    </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform35" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br>