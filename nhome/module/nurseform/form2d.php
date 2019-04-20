<?php
$pid = (int) @$_GET['pid'];
$dbchk = new DB;
$chkSQL = "SELECT CASE WHEN (`Q14_1` + `Q14_2` + `Q14_3`)>=1 THEN '1' WHEN `Q14_4`='1' THEN '2' WHEN (`Q14_5`+`Q14_6`+`Q14_7`+`Q14_8`)>=1 THEN '3' WHEN (`Q14_1` + `Q14_2` + `Q14_3` + `Q14_4` + `Q14_5`+`Q14_6`+`Q14_7`+`Q14_8`)=0 THEN '0' END AS `Q14`, `date` FROM  `nurseform02a` WHERE  `HospNo` ='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1";
$dbchk->query($chkSQL);
$chk = $dbchk->fetch_assoc();
if($chk['Q14']==0 && @$_GET['date']==$chk['date']){
	echo "<script>if (confirm('建議先填寫教育程度，是否前往基本資料頁面填寫？填寫完畢後系統會自動回到本頁。')) { window.location.href='index.php?mod=nurseform&func=formview&pid=".$pid."&id=2a&url=".urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."'; }</script>";
}
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02d` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02d` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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

if ($_GET['date']=="") {
	$sql02h = "SELECT * FROM `nurseform02h` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ".($_GET['date']!=""?" AND `date`<='".mysql_escape_string($_GET['date'])."'":"")." ORDER BY `date` DESC LIMIT 0,1";
	$db3 = new DB;
	$db3->query($sql02h);
	for ($m=1;$m<=32;$m++) {
		${'QMMSE'.$m} = "";
	}
	if ($db3->num_rows()>0) {
		$r3 = $db3->fetch_assoc();
		foreach ($r3 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${str_replace("Q","QMMSE",$arrAnswer[0])} .= $arrAnswer[1].';';
					}
				} else {
					${str_replace("Q","QMMSE",$k)} = $v;
				}
			}  else {
				${str_replace("Q","QMMSE",$k)} = $v;
			}
		}
	}
}
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Emotion/cognition assessment</h3>
<iframe src="module/nurseform/form2d_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170" class="printcol"></iframe>
<?php
$rowspan=18;
?>
<table width="100%">
  <tr>
    <!-- 18 43 -->
    <td width="40" rowspan="<?php echo $rowspan; ?>" class="title">Cognition</td>
    <td width="80" class="title_s">Short-term Memory OK</td>
    <td width="250">Seems or appears to recall after 5 minutes</td>
    <td colspan="6"><?php echo draw_option("Q1","Memory OK;Memory problem","l","single",$Q1,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Long-term Memory OK</td>
    <td>Seems or appears to recall long past</td>
    <td colspan="6"><?php echo draw_option("Q2","Memory OK;Memory problem","l","single",$Q2,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Identify people</td>
    <td>Proper Identify the person's face to get along daily</td>
    <td colspan="6"><?php echo draw_option("Q3","Completely able;Often able;Occasionally able;Completely unable;Able to recognize but not speak out","xxl","single",$Q3,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Identify time</td>
    <td>Correctly identify current time such as morning, noon or night</td>
    <td colspan="6"><?php echo draw_option("Q4","Completely able;Often able;Occasionally able;Completely unable;Able to recognize but not speak out","xxl","single",$Q4,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Identify location</td>
    <td>Properly identify current location, position</td>
    <td colspan="6"><?php echo draw_option("Q5","Completely able;Often able;Occasionally able;Completely unable;Able to recognize but not speak out","xxl","single",$Q5,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Cognitive Skills</td>
    <td>Daily Decision Making</td>
    <td colspan="6"><?php echo draw_option("Q6","Independent;Modified independence;Moderately impaired;Severely impaired","xl","single",$Q6,true,2); ?><br><br />
    <font color="#000">
    Modified independence - some difficulty in new situations only<br />
    Moderately impaired - decisions poor; cues/supervision required<br />
    Severely impaired - never/rarely made decisions</font>
    </td>
  </tr>
  <!--SPMSQ--start-->
  <tr>
    <td rowspan="12" class="title_s">SPMSQ</td>

    <td colspan="6"><?php echo draw_checkbox("Q7","Unassessable",$Q7,"single"); ?></td>
  </tr>
  <tr>
    <td>1. Current year, month, date, time?</td>
    <td colspan="6"><?php echo draw_option("Q8","Correct;Incorrect","m","single",$Q8,false,3); ?></td>
  </tr>
  <tr>
    <td>2. What day of the week is it today?</td>
    <td colspan="6"><?php echo draw_option("Q9","Correct;Incorrect","m","single",$Q9,false,3); ?></td>
  </tr>
  <tr>
    <td>3.  Where you at right now?</td>
    <td colspan="6"><?php echo draw_option("Q10","Correct;Incorrect","m","single",$Q10,false,3); ?></td>
  </tr>
  <tr>
    <td>4. What's your home phone number or address?</td>
    <td colspan="6"><?php echo draw_option("Q11","Correct;Incorrect","m","single",$Q11,false,3); ?></td>
  </tr>
  <tr>
    <td>5. How old are you?</td>
    <td colspan="6"><?php echo draw_option("Q12","Correct;Incorrect","m","single",$Q12,false,3); ?></td>
  </tr>
  <tr>
    <td>6. Your date & year of birth?</td>
    <td colspan="6"><?php echo draw_option("Q13","Correct;Incorrect","m","single",$Q13,false,3); ?></td>
  </tr>
  <tr>
    <td>7. Who is the President now?</td>
    <td colspan="6"><?php echo draw_option("Q14","Correct;Incorrect","m","single",$Q14,false,3); ?></td>
  </tr>
  <tr>
    <td>8. Who is the former president?</td>
    <td colspan="6"><?php echo draw_option("Q15","Correct;Incorrect","m","single",$Q15,false,3); ?></td>
  </tr>
  <tr>
    <td>9. What's your mother's maiden last name?</td>
    <td colspan="6"><?php echo draw_option("Q16","Correct;Incorrect","m","single",$Q16,false,3); ?></td>
  </tr>
  <tr>
    <td>10. 20-3 = ?   -3 = ?  -3 = ? -3 = ? -3 = ?</td>
    <td colspan="6"><?php echo draw_option("Q17","Correct;Incorrect","m","single",$Q17,false,3); ?></td>
  </tr>
  <tr>
    <td>Total score</td>
    <td width="80"><center><h3><span id="total"><?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?></span><input type="hidden" name="Qtotal" id="Qtotal" value="<?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?>" /></h3></center></td>
    <td width="220px">
    <input type="hidden" id="eduLevel" value="<?php echo $chk['Q14']; ?>">
    <span id="spmsqmsg"><?php 
    	$edu = $chk['Q14'];
		if ($edu = '') { $edu = 0; }
		switch ($edu) {
			case 1:
				if ($Qtotal>=7) { echo 'Mental function intact'; $style = "none"; }
				elseif ($Qtotal>=5) { echo 'Mild mental deficiency'; $style = "none"; }
				elseif ($Qtotal>=2) { echo 'Moderate mental deficiency'; $style = "block"; }
				else { echo 'Severe mental deficiency'; $style = "block"; }
			break;
			case 2:
				if ($Qtotal>=8) { echo 'Mental function intact'; $style = "none"; }
				elseif ($Qtotal>=6) { echo 'Mild mental deficiency'; $style = "none"; }
				elseif ($Qtotal>=3) { echo 'Moderate mental deficiency'; $style = "block"; }
				else { echo 'Severe mental deficiency'; $style = "block"; }
			break;
			case 3:
				if ($Qtotal>=9) { echo 'Mental function intact'; $style = "none"; }
				elseif ($Qtotal>=7) { echo 'Mild mental deficiency'; $style = "none"; }
				elseif ($Qtotal>=4) { echo 'Moderate mental deficiency'; $style = "block"; }
				else { echo 'Severe mental deficiency'; $style = "block"; }
			break;
			case 0:
				echo '<font color="#f00">Missing level of education, unable to process the decision.</font>';
				$style = "block";
			break;
		}
		?>
    </span>
    </td>
    <td width="160" colspan="4"><div id="divQ7a" style="display:<?php echo $style; ?>;"><?php echo draw_checkbox("Q7a","Whether referral?",$Q7a,"single"); ?></div></td>
  </tr>
  <!--SPMSQ--finish-->
  <tr>
    <td rowspan="7" class="title">Perception and <br />communication<br /></td>
    <td colspan="2">Hearing</td>
    <td colspan="6"><?php echo draw_option("Q19","Adequate;Minimal difficulty;Moderate difficulty;Highly impaired","l","single",$Q19,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">Hearing Aid</td>
    <td colspan="6"><?php echo draw_option("Q18","No;Yes","m","single",$Q18,false,3); ?></td>
  </tr>
  <tr>
    <td colspan="2">Speech Clarity</td>
    <td colspan="6"><?php echo draw_option("Q20","Speech Clarity;Unclear speech;No speech","l","single",$Q20,true,3); ?></td>
  </tr>
  <tr>
    <td colspan="2">Makes Self Understood</td>
    <td colspan="6"><?php echo draw_option("Q21","Understood;Usually understood;Sometimes understood;Rarely/never understood","xl","single",$Q21,true,2); ?> </td>
  </tr>
  <tr>
    <td colspan="2">Ability To Understand Others</td>
    <td colspan="6"><?php echo draw_option("Q22","Understands;Usually understands;Sometimes understands;Rarely/never understands","xl","single",$Q22,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">Vision</td>
    <td colspan="6"><?php echo draw_option("Q23","Adequate;Impaired;Moderately impaired;Highly impaired;Severely impaired","l","single",$Q23,true,3); ?></td>
  </tr><tr>
    <td colspan="2">Corrective Lenses</td>
    <td colspan="6"><?php echo draw_option("Q41","No;Yes","m","single",$Q41,false,3); ?></td>
  </tr>
  <!--MDS D200 table-->
  <tr>
    <td rowspan="14" class="title">PHQ-9©</td>
    <td colspan="2" class="title_s">&nbsp;</td>
    <td colspan="3" class="title_s">Symptom Presence<br>(Column 1)</td>
    <td colspan="3" class="title_s">Symptom Frequency<br>(Column 2)</td>
  </tr>
  <tr>
    <td colspan="2">Should Resident Mood Interview be Conducted?</td>
    <td colspan="6"><?php echo draw_option("Q42","No;Yes","m","single",$Q42,false,3); ?>&nbsp;&nbsp;&nbsp;(If entry "NO", please skip to PHQ-9-OV*)</td>
  </tr>
  <tr>
    <td colspan="2">Say to resident: <br><b>"Over the last 2 weeks, have you been bothered <br>by any of the following problems?"</b></td>
    <td colspan="3">&nbsp;&nbsp;&nbsp;1. No&nbsp;&nbsp;&nbsp;(enter 0 in column 2)<br>&nbsp;&nbsp;&nbsp;2. Yes&nbsp;&nbsp;&nbsp;(enter 0-3 in column 2)<br>&nbsp;&nbsp;&nbsp;3. No response&nbsp;&nbsp;&nbsp;(leave column 2 blank)</td>
    <td colspan="3">Say to resident: <br><b>"About how often have you been <br>bothered by this?"</b></td>
  </tr>
  <tr>
    <td colspan="2">A. Little interest or pleasure in doing things</td>
    <td colspan="3"><?php echo draw_option("Q43","No;Yes;No response","m","single",$Q43,true,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q24","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q24,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">B. Feeling down, depressed, or hopeless</td>
    <td colspan="3"><?php echo draw_option("Q44","No;Yes;No response","m","single",$Q44,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q25","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q25,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">C. Trouble falling or staying asleep, or sleeping too much</td>
    <td colspan="3"><?php echo draw_option("Q45","No;Yes;No response","m","single",$Q45,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q26","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q26,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">D. Feeling tired or having little energy</td>
    <td colspan="3"><?php echo draw_option("Q46","No;Yes;No response","m","single",$Q46,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q27","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q27,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">E. Poor appetite or overeating</td>
    <td colspan="3"><?php echo draw_option("Q47","No;Yes;No response","m","single",$Q47,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q28","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q28,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">F. Feeling bad about yourself - or that you are a failure or have let yourself or your family down</td>
    <td colspan="3"><?php echo draw_option("Q48","No;Yes;No response","m","single",$Q48,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q29","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q29,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">G. Trouble concentrating on things, such as reading the newspaper or watching television</td>
    <td colspan="3"><?php echo draw_option("Q49","No;Yes;No response","m","single",$Q49,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q30","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q30,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">H. Moving or speaking so slowly that other people could have noticed. Or the opposite - being so fidgety or restless that you have been moving around a lot more than usual</td>
    <td colspan="3"><?php echo draw_option("Q50","No;Yes;No response","m","single",$Q50,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q31","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q31,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">I. Thoughts that you would be better off dead, or of hurting yourself in some way</td>
    <td colspan="3"><?php echo draw_option("Q51","No;Yes;No response","m","single",$Q51,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q32","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q32,true,2); ?></td>
  </tr>
  
  <!--MDS D300 table  總分問題-->
  <tr>
    <td colspan="2">Add scores for all frequency responses in Column 2</td>
    <td colspan="3"><input type="text" name="Q53" id="Q53" size="3" value="<?php echo $Q53; ?>"></td>
     <td colspan="3">&nbsp;</td>
  </tr>
  <!--MDS D350 table-->
  <tr>
    <td colspan="2">Was responsible staff or provider informed that there is a potential for resident self harm?</td>
    <td colspan="3"><?php echo draw_option("Q52","No;Yes","m","single",$Q52,false,3); ?></td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <!--MDS D500 table-->
  <tr>
    <td rowspan="14" class="title">PHQ-9-OV*</td>
    <td colspan="2" class="title_s">&nbsp;</td>
    <td colspan="3" class="title_s">Symptom Presence<br>(Column 1)</td>
    <td colspan="3" class="title_s">Symptom Frequency<br>(Column 2)</td>
  </tr>
  <tr>
    <td colspan="2"><b>Do not conduct if PHQ-9© was completed</b></td>
    <td colspan="3">&nbsp;&nbsp;&nbsp;1. No&nbsp;&nbsp;&nbsp;(enter 0 in column 2)<br>&nbsp;&nbsp;&nbsp;2. Yes&nbsp;&nbsp;&nbsp;(enter 0-3 in column 2)</td>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="2">A. Little interest or pleasure in doing things</td>
    <td colspan="3"><?php echo draw_option("Q54","No;Yes","m","single",$Q54,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q55","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q55,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">B. Feeling or appearing down, depressed, or hopeless</td>
    <td colspan="3"><?php echo draw_option("Q56","No;Yes","m","single",$Q56,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q57","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q57,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">C. Trouble falling or staying asleep, or sleeping too much</td>
    <td colspan="3"><?php echo draw_option("Q58","No;Yes","m","single",$Q58,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q59","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q59,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">D. Feeling tired or having little energy</td>
    <td colspan="3"><?php echo draw_option("Q60","No;Yes","m","single",$Q60,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q61","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q61,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">E. Poor appetite or overeating</td>
    <td colspan="3"><?php echo draw_option("Q62","No;Yes","m","single",$Q62,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q63","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q63,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">F. Indicating that s/he feels bad about self, is a failure, or has let self or family down</td>
    <td colspan="3"><?php echo draw_option("Q64","No;Yes","m","single",$Q64,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q65","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q65,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">G. Trouble concentrating on things, such as reading the newspaper or watching television</td>
    <td colspan="3"><?php echo draw_option("Q66","No;Yes","m","single",$Q66,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q67","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q67,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">H. Moving or speaking so slowly that other people could have noticed. Or the opposite - being so fidgety or restless that you have been moving around a lot more than usual</td>
    <td colspan="3"><?php echo draw_option("Q68","No;Yes","m","single",$Q68,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q69","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q69,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">I. States that life isn't worth living, wishes for death, or attempts to harm self</td>
    <td colspan="3"><?php echo draw_option("Q70","No;Yes","m","single",$Q70,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q71","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q71,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2">J. Being short-tempered, easily annoyed</td>
    <td colspan="3"><?php echo draw_option("Q72","No;Yes","m","single",$Q72,false,3); ?></td>
    <td colspan="3"><?php echo draw_option("Q73","Never or 1 day;2-6 days;7-11 days;12-14 days","xm","single",$Q73,true,2); ?></td>
  </tr>
  <!--MDS D600 table  總分問題-->
  <tr>
    <td colspan="2">Add scores for all frequency responses in Column 2</td>
    <td colspan="3"><input type="text" name="Q75" id="Q75" size="3" value="<?php echo $Q75;?>"></td>
     <td colspan="3">&nbsp;</td>
  </tr>
  <!--MDS D650 table-->
  <tr>
    <td colspan="2">Was responsible staff or provider informed that there is a potential for resident self harm?</td>
    <td colspan="3"><?php echo draw_option("Q74","No;Yes","m","single",$Q74,false,3); ?></td>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02d" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
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
<script>
$(document).ready(function () {
	//calc2dscore();
	for (i=8;i<=17;i++) {
		$("[id*='btn_Q"+i+"']").click(function() {
			calc2dscore();
		});
	}
})
function calc2dscore() {
	var totalscore=0;
	for (i=8;i<=17;i++) {
		var id1 = "Q"+i.toString()+"_1";
		var answer1 = document.getElementById(id1).value;
		totalscore += parseInt(answer1);
	}
	document.getElementById('Qtotal').value = totalscore;
	document.getElementById('total').innerHTML = totalscore;
	var edu = '<?php echo $chk['Q14']; ?>';
	if (edu=='') { edu = '0'; }
	switch (edu) {
		case '1':
			if (totalscore>=7) { document.getElementById('spmsqmsg').innerHTML = 'Mental function intact'; document.getElementById('divQ7a').style.display = "none"; }
			else if (totalscore>=5) { document.getElementById('spmsqmsg').innerHTML = 'Mild mental deficiency'; document.getElementById('divQ7a').style.display = "none"; }
			else if (totalscore>=2) { document.getElementById('spmsqmsg').innerHTML = 'Moderate mental deficiency'; document.getElementById('divQ7a').style.display = "block"; }
			else { document.getElementById('spmsqmsg').innerHTML = 'Severe mental deficiency'; document.getElementById('divQ7a').style.display = "block"; }
		break;
		case '2':
			if (totalscore>=8) { document.getElementById('spmsqmsg').innerHTML = 'Mental function intact'; document.getElementById('divQ7a').style.display = "none"; }
			else if (totalscore>=6) { document.getElementById('spmsqmsg').innerHTML = 'Mild mental deficiency'; document.getElementById('divQ7a').style.display = "none"; }
			else if (totalscore>=3) { document.getElementById('spmsqmsg').innerHTML = 'Moderate mental deficiency'; document.getElementById('divQ7a').style.display = "block"; }
			else { document.getElementById('spmsqmsg').innerHTML = 'Severe mental deficiency'; document.getElementById('divQ7a').style.display = "block"; }
		break;
		case '3':
			if (totalscore>=9) { document.getElementById('spmsqmsg').innerHTML = 'Mental function intact'; document.getElementById('divQ7a').style.display = "none"; }
			else if (totalscore>=7) { document.getElementById('spmsqmsg').innerHTML = 'Mild mental deficiency'; document.getElementById('divQ7a').style.display = "none"; }
			else if (totalscore>=4) { document.getElementById('spmsqmsg').innerHTML = 'Moderate mental deficiency'; document.getElementById('divQ7a').style.display = "block"; }
			else { document.getElementById('spmsqmsg').innerHTML = 'Severe mental deficiency'; document.getElementById('divQ7a').style.display = "block"; }
		break;
		case '0':
			document.getElementById('spmsqmsg').innerHTML = '<font color="#f00">Missing level of education, unable to process the judgement.</font>';
		break;
	}
}
</script>

<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
?>
<script>
$(document).ready(function () {
	<?php if ($file=="index") { echo '
	calcQMMSEtotal();
	$("[id*=\'btn_QMMSE\']").click(function() {
		calcQMMSEtotal();
	});
	'; }
	?>
})
function calcQMMSEtotal() {
	var Qtotal = 0;
	var Q1=0;
	var Q2=0;
	var Q3=0;
	var Q4=0;
	var Q5=0;
	var Q6=0;
	var Q10=0;
	var arri={'25':'7','26':'8','30':'9','31':'11' };
	for (i=1;i<=31;i++) {
		if (i!=14) { if ($('#QMMSE'+i+'_2').val()==1) { Qtotal += 1; } }
		if(i >= 1 && i <= 5){
			if ($('#QMMSE'+i+'_2').val()==1) { Q1 += 1;}
			$("#QMMSEscore1").val(Q1);
		}
		if(i >= 6 && i <= 10){
			if ($('#QMMSE'+i+'_2').val()==1) { Q2 += 1;}
			$("#QMMSEscore2").val(Q2);
		}
		if(i >= 11 && i <= 13){
			if ($('#QMMSE'+i+'_2').val()==1) { Q3 += 1;}
			$("#QMMSEscore3").val(Q3);
		}
		if(i >= 15 && i <= 19){
			if ($('#QMMSE'+i+'_2').val()==1) { Q4 += 1;}
			$("#QMMSEscore4").val(Q4);
		}
		if(i >= 20 && i <= 22){
			if ($('#QMMSE'+i+'_2').val()==1) { Q5 += 1;}
			$("#QMMSEscore5").val(Q5);
		}
		if(i >= 23 && i <= 24){
			if ($('#QMMSE'+i+'_2').val()==1) { Q6 += 1;}
			$("#QMMSEscore6").val(Q6);
		}
		if(i == 25 || i == 26 || i == 30 || i == 31){
			if ($('#QMMSE'+i+'_2').val()==1) { $("#QMMSEscore"+arri[i]).val(1); }else{ $("#QMMSEscore"+arri[i]).val(0); }
		}
		if(i >= 27 && i <= 29){
			if ($('#QMMSE'+i+'_2').val()==1) { Q10 += 1;}
			$("#QMMSEscore10").val(Q10);
		}
	}
	$('#QMMSE32').val(Qtotal);
}
</script>
<script>
$(document).ready(function () {
	<?php if ($file=="index") { echo '
	PHQ9Qtotal();
	$("[id*=\'btn_Q\']").click(function() {
		PHQ9Qtotal();
	});
	'; }
	?>
})
function PHQ9Qtotal() {
	var QPHQ9total = 0;
	var QPHQ9OVtotal = 0;
	for (i=24;i<74;i++) {
		if (i < 33){
		    if ($('#Q'+i+'_2').val()==1) { QPHQ9total += 1;}
		    if ($('#Q'+i+'_3').val()==1) { QPHQ9total += 2;}
		    if ($('#Q'+i+'_4').val()==1) { QPHQ9total += 3;}
		}
		if (i >= 55 && (i%2)==1){
			if ($('#Q'+i+'_2').val()==1) { QPHQ9OVtotal += 1;}
			if ($('#Q'+i+'_3').val()==1) { QPHQ9OVtotal += 2;}
			if ($('#Q'+i+'_4').val()==1) { QPHQ9OVtotal += 3;}
		}
	}
	$('#Q53').val(QPHQ9total);
	$('#Q75').val(QPHQ9OVtotal);
}
</script>