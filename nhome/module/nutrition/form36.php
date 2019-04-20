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
	$sql = "SELECT * FROM `socialform36` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform36` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Mini nutritional assessment(MNA)</h3>
<center><iframe src="module/nutrition/form36_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170"></iframe></center>
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
    <td class="title">Knee height</td>
    <td><input type="text" name="Q3a" id="Q3a" value="<?php echo $Q3a; ?>" size="4" >cm</td>
    <td class="title">Hipline</td>
    <td colspan="3"><input type="text" name="Q3b" id="Q3b" value="<?php echo $Q3b; ?>" size="4" >cm</td>
  </tr>
</table>
<table width="100%">
	<tr class="title">
        <td colspan="2">MNA screening</td>
        <td width="40">Score</td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">1. Has food intake declined over the past 3 months due to loss of appetite, digestive problems, chewing or swallowing difficulties??</font><br><?php echo draw_checkbox_nobr("Q4","0 point = Severe decrease in food intake;1 point = Moderate decrease in food intake <br>;2 points = No decrease in food intake",$Q4,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore1" id="Qscore1" value="<?php echo $Qscore1;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">2. Weight loss during the last 3 month</font><br><?php echo draw_checkbox_nobr("Q5","0 point = Weight loss greater than 3 kg(6.6 lbs) ;1 point = Not know <br>;2 points =  Weight loss between 1 and 3 kg(2.2 and 6.6 lbs);3 points = No weight loss ",$Q5,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore2" id="Qscore2" value="<?php echo $Qscore2;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">3. Mobility</font><br><?php echo draw_checkbox_nobr("Q6","0 point = Bed or chair bound ;1 point =  Able to get out of bed / chair but does not go out ;2 points = Goes out ",$Q6,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore3" id="Qscore3" value="<?php echo $Qscore3;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">4. Has suffered psychological stress or acute disease in the past 3 months? </font><br><?php echo draw_checkbox_nobr("Q7","0 point = Yes;2 points = None",$Q7,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore4" id="Qscore4" value="<?php echo $Qscore4;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">5. Neuropsychological problems </font><br><?php echo draw_checkbox_nobr("Q8","0 point = Severe dementia or depression ;1 point = Mild dementia;2 points = No psychological problems ",$Q8,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore5" id="Qscore5" value="<?php echo $Qscore5;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">6.  Body Mass Index(BMI) Body weight(Kilogram) /Height(meters)<sup>2</sup></font><br><?php echo draw_checkbox_nobr("Q9","0 point = BMI < 19;1 point = 19 ≦ BMI < 21;2 points = 21 ≦ BMI < 23;3 points = BMI ≧ 23",$Q9,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore6" id="Qscore6" value="<?php echo $Qscore6;?>" size="1" readonly></td>
    </tr>
	<tr class="title">
        <td colspan="2">General assessment</td>
        <td width="40">Score</td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">7. Live independently (Not in nursing facility or hospital)</font><br><?php echo draw_checkbox_nobr("Q10","0 point = None;1 point = Yes",$Q10,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore7" id="Qscore7" value="<?php echo $Qscore7;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">8. Need to take 3 or more prescribed medication daily</font><br><?php echo draw_checkbox_nobr("Q11","0 point = Yes;1 point = None",$Q11,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore8" id="Qscore8" value="<?php echo $Qscore8;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">9. Pressure ulcer(s) or skin ulcer occur</font><br><?php echo draw_checkbox_nobr("Q12","0 point = Yes;1 point = None",$Q12,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore9" id="Qscore9" value="<?php echo $Qscore9;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">10. Finish the full meal(s) daily</font><br><?php echo draw_checkbox_nobr("Q13","0 point = 1 meal;1 point = 2 meals;2 points = 3 meals",$Q13,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore10" id="Qscore10" value="<?php echo $Qscore10;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">11. Protein intake</font><br>
        <ul style="list-style-type: none;">
        	<li>At least 1 dairy product daily(Milk, cheese, yogurt)　<?php echo draw_option("Q14","Yes;No","s","single",$Q14,false,5); ?></li>
            <li>Weekly intake of two or more beans and eggs &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("Q15","Yes;No","s","single",$Q15,false,5); ?></li>
            <li>Daily intake meat (chicken,fish,duck,pork...etc)　&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo draw_option("Q16","Yes;No","s","single",$Q16,false,5); ?></li>
        </ul>
        0.0 point = 0 or 1 'Yes'、0.5 point = 2 'Yes、1.0 point = 3 'Yes'
        </td>
        <td align="center"><input type="text" name="Qscore11" id="Qscore11" value="<?php echo $Qscore11;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">12. Daily intake 2 or more kinds of vegetables</font><br><?php echo draw_checkbox_nobr("Q17","0 point = None;1 point = Yes",$Q17,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore12" id="Qscore12" value="<?php echo $Qscore12;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">13. Fluid intake per day(Including water, juice, coffee, tea, milk...etc) (Unit: 240 c.c. cup)</font><br><?php echo draw_checkbox_nobr("Q18","0.0 point = less than 3 cups;0.5 point = 3 ~ 5 cups
;1.0 point = 5 cups or more",$Q18,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore13" id="Qscore13" value="<?php echo $Qscore13;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">14. Dietary method</font><br><?php echo draw_checkbox_nobr("Q19","0 point = Unable to perform self-feeding without assistance;1 point = Mild difficulty when self-feeding <br>;2 points = Self feeding without assistance",$Q19,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore14" id="Qscore14" value="<?php echo $Qscore14;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">15. Self conciousness of the nutrition intake status?</font><br><?php echo draw_checkbox_nobr("Q20","0 point = Feel he/she have poor nutrition;1 point = Not clear or fair nutrition;2 points = No nutritional problem(s)",$Q20,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore15" id="Qscore15" value="<?php echo $Qscore15;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">16. Compare with other people the same age, how would they think of their state of health?</font><br><?php echo draw_checkbox_nobr("Q21","0.0 point = Worse than people in the same age;0.5 point = Not know <br>;1.0 point = Average;2.0 points = Better than people the same age",$Q21,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore16" id="Qscore16" value="<?php echo $Qscore16;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">17. Mid-Upper Arm Circumference (MUAC)：<input type="text" id="Q22a" name="Q22a" value="<?php echo $Q22a;?>" size="5"> Cm</font><br><?php echo draw_checkbox_nobr("Q22","0.0 point = MAC < 21;0.5分 = MAC 21 ~ 21.9;1.0 point = MAC ≧ 22",$Q22,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore17" id="Qscore17" value="<?php echo $Qscore17;?>" size="1" readonly></td>
    </tr>
    <tr>
        <td colspan="2"><font style="font-weight:bolder;">18. Calf circumference (CC)：<input type="text" id="Q23a" name="Q23a" value="<?php echo $Q22a;?>" size="5"> Cm</font><br><?php echo draw_checkbox_nobr("Q23","0 point = C.C. < 31;1 point = C.C. ≧ 31",$Q23,"single"); ?></td>
        <td align="center"><input type="text" name="Qscore18" id="Qscore18" value="<?php echo $Qscore18;?>" size="1" readonly></td>
    </tr>
	<tr class="title">
        <td>MNA total score (Out of 30 points)</td>
        <td width="240"><span id="Qresult"></span></td>
        <td width="40"><input type="text" name="Qtotal" id="Qtotal" value="<?php echo $Qtotal;?>" size="1" readonly></td>
    </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform36" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button  style="margin-top:20px;" type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button  style="margin-top:20px;" type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br>
<script>
$(document).ready(function () {
	$("[id*='btn_Q']").click(function() {
		calcTotal($(this).attr('id'), 18);
	});
})
function calcTotal(btnid, totalno) {
	for (var i=1;i<=totalno;i++) {
		if ($('#Q'+i+'total').val()=="") { $('#Q'+i+'total').val(0); }
	}
	if (btnid) {
		var btn = btnid.replace("btn_Q", "");
		var arrBtn = btn.split("_");
		var arrScoreType = {'1':'0;1;2', '2':'0;1;2;3', '3':'0;2', '4':'0;1', '5':'0;0.5;1', '6':'0;0.5;1;2'};
		var arrScore = {'4':'1', '5':'2', '6':'1', '7':'3', '8':'1', '9':'2', '10':'4', '11':'4', '12':'4', '13':'2', '17':'4', '18':'5', '19':'1', '20':'1', '21':'6', '22':'5', '23':'4'};
		var arrQscore = {'4':'1', '5':'2', '6':'3', '7':'4', '8':'5', '9':'6', '10':'7', '11':'8', '12':'9', '13':'10', '14':'11', '15':'11', '16':'11', '17':'12', '18':'13', '19':'14', '20':'15', '21':'16', '22':'17', '23':'18' };
		if (arrBtn[0]=="14" || arrBtn[0]=="15" || arrBtn[0]=="16") {
			var count = 0;
			if ($('#Q14_1').val()==1) { count++; }
			if ($('#Q15_1').val()==1) { count++; }
			if ($('#Q16_1').val()==1) { count++; }
			switch (count) {
				case 0:
				    $('#Qscore11').val('0');
					break;
				case 1:
				    $('#Qscore11').val('0');
					break;
				case 2:
				    $('#Qscore11').val('0.5');
					break;
				case 3:
				    $('#Qscore11').val('1');
					break;
			}
		} else {
			var arrSubtotal = arrScoreType[arrScore[arrBtn[0]]].split(';');
			$('#Qscore'+ arrQscore[arrBtn[0]]).val(arrSubtotal[(arrBtn[1]-1)]);
		}
	}
	var Qtotal = 0;
	for (var i=1;i<=totalno;i++ ) {
		if ($('#Qscore'+i).val()!="") {
			Qtotal += parseFloat($('#Qscore'+i).val());
		}
	}
	$('#Qtotal').val(Qtotal);
	if (Qtotal>=23.5) { $('#Qresult').html("MNA  ＞23.5 Good nutrition"); }
	else if (Qtotal>=17) { $('#Qresult').html("MNA  17~23.5 Malnutrition risk"); }
	else if (Qtotal>0){ $('#Qresult').html("MNA  <17 Malnutrition"); }
}
</script>