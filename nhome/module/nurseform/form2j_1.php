<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02j` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Pain assessment and rehabilitation, social working notification form</h3>
<table width="100%">
  <tr>
    <td class="title" width="120"><p>Date</p></td>
    <td width="220"><script> $(function() { $( "#Q1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q1" name="Q1" size="10" value="<?php if ($Q1==NULL) { echo date(Y."/".m."/".d); } else { echo $Q1; } ?>" /></td>
    <td class="title" width="120"><p>Time </p></td>
    <td colspan="3"><input type="text" name="Q2" id="Q2" value="<?php if ($Q2==NULL) { echo date(H); } else { echo $Q2; } ?>" size="3" >:<input type="text" name="Q3" id="Q3" value="<?php if ($Q3==NULL) { echo date(i); } else { echo $Q3; } ?>" size="3" ></td>
  </tr>
  <?php
  if (substr($url[3],0,5)!="print"){
  ?>
  <tr>
    <td class="title" colspan="3"><p>Should Pain Assessment Interview be Conducted?</p></td>
    <td colspan="3"><?php echo draw_option("Q39","YES;NO","s","single",$Q39,false,0); ?> If select "No", please skip to <b>Objective assessment for resident who can't express</td>
  </tr>
  <?php }?>
  <tr class="title"><td colspan="6">Subjective expression of resident</td></tr>
  <tr>
    <td class="title"><p>Consciousness</p></td>
    <td colspan="5"><?php echo draw_option("Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","l","single",$Q4,false,0); ?><br />(Glasgow coma scale:E <input type="text" name="Q5_a" id="Q5_a" size="1" value="<?php echo $Q5_a; ?>" /> M <input type="text" name="Q5_b" id="Q5_b" size="1" value="<?php echo $Q5_b; ?>" /> V <input type="text" name="Q5_c" id="Q5_c" size="1" value="<?php echo $Q5_c; ?>" />)</td>
  </tr>
  <tr>
    <td class="title"><p>Cognition</p></td>
    <td><?php echo draw_option("Q6","Clear;Dementia","m","single",$Q6,false,0); ?></td>
    <td class="title"><p>Observation</p></td>
    <td colspan="3"><?php echo draw_option("Q7","Chief complaint;Behavior observed","xl","single",$Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">Start time</td>
    <td colspan="5"><script> $(function() { $( "#Q8").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q8" name="Q8" value="<?php if ($Q8==NULL) { echo date(Y."/".m."/".d); } else { echo $Q8; } ?>" /><input type="text" name="Q9" id="Q9" value="<?php if ($Q9==NULL) { echo date(H); } else { echo $Q9; } ?>" size="3" >:<input type="text" name="Q10" id="Q10" value="<?php if ($Q10==NULL) { echo date(i); } else { echo $Q10; } ?>" size="3" ></td>
  </tr>
  <tr>
    <td class="title"><p>Pain Presence</p></td>
    <td colspan="5"><b>&nbsp;Ask resideng: "Have you had pain or hurting at any time in the last 5 days?"</b><br /><?php echo draw_option("Q34","No;Yes;Unable to answer","xl","multi",$Q34,true,5); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Pain Frequency</p></td>
    <td colspan="5"><b>&nbsp;Ask resideng: "How much of the time have you experienced pain or hurting over the last 5 days?"</b><br /><?php echo draw_option("Q35","Almost constantly;Frequently;Occasionally;Rarely;Unable to answer","xl","multi",$Q35,true,5); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Duration</p></td>
    <td colspan="5"><?php echo draw_option("Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","xxxl","multi",$Q11,true,2); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Pain Effect on Function</p></td>
    <td colspan="5"><b>&nbsp;Ask resident: "Over the past 5 days, has pain made it hard for you to sleep at night?"</b><br /><?php echo draw_option("Q19","No;Yes;Unable to answer","xl","multi",$Q19,true,6); ?>
                    <br><b>&nbsp;Ask resident: "Over the past 5 days, have you limited your day-to-day activities because of pain?"</b><br /><?php echo draw_option("Q32","No;Yes;Unable to answer","xl","multi",$Q32,true,6); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Response to pain</p></td>
    <td colspan="5"><?php echo draw_option("Q38","Avoid pressing;Frown;Afraid to move;Moan;Lean;Other","l","multi",$Q38,true,4); ?>：<input type="text" name="Q38a" id="Q38a" value="<?php echo $Q38a; ?>" size="20" ></td>
  </tr>
  <tr>
    <td class="title"><p>Pain location</p></td>
    <td colspan="5"><input type="text" name="Q13" id="Q13" value="<?php echo $Q13; ?>" size="20" ></td>
  </tr>
  <tr>
    <td class="title"><p>inflammation</p></td>
    <td colspan="5">&nbsp;Appearance <?php echo draw_option("Q14","Reddish;Swollen;Heat;Pain","xs","multi",$Q14,false,5); ?>：<input type="text" name="Q14a" id="Q14a" value="<?php echo $Q14a; ?>" size="20" ></td>
  </tr>
  <tr>
    <td class="title"><p>Pain Intensity</p></td>
    <td colspan="5"><img src="Images/nurseform02b_pain01.png" height="66%" width="66%" /><br /><?php echo draw_option("Q15","0;1;2;3;4;5;6;7;8;9;10;99","s","single",$Q15,false,5); ?><br />(Enter 99 if unable to answer, and complete the questions below)<br><br><b>&nbsp;Ask resident: "Please rate the intensity of your worst pain over the last 5 days." <br />&nbsp;(Show resident verbal scale)</b><br /><?php echo draw_checkbox_nobr("Q37","Mild;Moderate;Severe;Very severe, horrible;Unable to answer",$Q37,"single"); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Pain characteristic</p></td>
    <td colspan="5"><?php echo draw_option("Q16","Soreness;Throbbing;Stinging;Dull pain;Searing pain;Indescribable;Can't express","xm","multi",$Q16,true,5); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Aggravating factors</p></td>
    <td colspan="5"><?php echo draw_option("Q17","Movement;Touch;Pressing;Cough;Other","m","multi",$Q17,true,6); ?>：<input type="text" name="Q17a" id="Q17a" value="<?php echo $Q17a; ?>" size="20" ></td>
  </tr>
  <tr>
    <td class="title"><p>Alleviating factors</p></td>
    <td colspan="5"><?php echo draw_option("Q18","Fixed;Not touch;Icing;Other","m","multi",$Q18,true,6); ?>：<input type="text" name="Q18a" id="Q18a" value="<?php echo $Q18a; ?>" size="20" ></td>
  </tr>
  <tr>
    <td class="title"><p>Pain Management</p></td>
    <td colspan="5"><b>&nbsp;Revceived schedule pain medication regimen</b><input type="text" name="Q22" id="Q22" value="<?php echo $Q22; ?>" size="70" > <?php echo draw_option("Q30","No;Yes","m","multi",$Q30,true,6); ?>
      <br /><b>&nbsp;Received PRN pain medications OR was offered and declined</b><br /><?php echo draw_option("Q31","No;Yes","m","multi",$Q31,true,6); ?>
      <br /><b>&nbsp;Received schedule analgesic</b><br /><?php echo draw_option("Q36","No;Yes","m","multi",$Q36,true,6); ?>
      <br /><b>&nbsp;Received non-medication intervention for pain</b><br><?php echo draw_option("Q23","No;Yes","m","multi",$Q23,true,6); ?>
	</td>
  </tr>
  <tr>
    <td class="title"><p>Revised care plan</p></td>
    <td colspan="5"><?php echo draw_option("Q24","YES;NO","s","single",$Q24,false,0); ?></td>
  </tr> 
  <tr class="title"><td colspan="6">Objective assessment for resident who can't express</td></tr>
  <?php
  if (substr($url[3],0,5)!="print"){
  ?>
  <tr>
    <td class="title"><p>Indicators of Pain or Possible Pain in the last 5 days</p></td>
    <td colspan="5"><?php echo draw_checkbox("Q12","<b>Non-verbal sounds</b><br>(e.g., crying, whining, gasping, moaning, or groaning);<b>Vocal complaints of pain</b><br>(e.g., that hurts, ouch, stop);<b>Facial expressions</b><br>(e.g., grimaces, winces, wrinkled forehead, furrowed brow, clenched teeth or jaw);<b>Protective body movements or postures</b><br>(e.g., bracing, guarding, rubbing or massaging a body part/area, clutching or holding abody part during movement);<b>None of these signs observed or documented</b>",$Q12,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Frequency of Indicator of Pain or Possible Pain in the last 5 days</p></td>
    <td colspan="5"><br>&nbsp;&nbsp;<b>Frequency with which resident complains or shows evidence of pain or possible pain</b><br /><?php echo draw_checkbox("Q33","Indicators of pain or possible pain observed 1 to 2 days;Indicators of pain or possible pain observed 3 to 4 days;Indicators of pain or possible pain observed daily",$Q33,"single"); ?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="title"><p>Reassuring method</p></td>
    <td colspan="5"><?php echo draw_checkbox_nobr("Q25","Muscle relaxed without appease;Tight and stiff muscle but able to be appeased <br>;Tight and stiff muscle, unable to be appeased",$Q25,"single"); ?></td>
  </tr>
  <tr>
    <td class="title"><p>Facial expression</p></td>
    <td colspan="5"><?php echo draw_checkbox_nobr("Q26","Relax;Frowning or shock-like;Painful expression",$Q26,"single"); ?></td>
  </tr> 
  <tr>
    <td class="title"><p>Physical activity</p></td>
    <td colspan="5"><?php echo draw_checkbox_nobr("Q27","Relax;Restless;Struggling",$Q27,"single"); ?></td>
  </tr> 
  <tr>
    <td class="title"><p>Moan / cry</p></td>
    <td colspan="5"><?php echo draw_checkbox_nobr("Q28","None;Occasionally;Continuous",$Q28,"single"); ?></td>
  </tr> 
  <tr>
    <td class="title"><p>Respiration</p></td>
    <td colspan="5"><?php echo draw_checkbox_nobr("Q29","Normal & smooth;Occasionally fast or laborious;Continuously fast or laborious",$Q29,"single"); ?></td>
  </tr> 
  <tr>
    <td class="title"><p>Total score</p></td>
    <td colspan="5"><input type="text" name="Qtotal" id="Qtotal" size="2" value="<?php echo $Qtotal; ?>" readonly /></td>
  </tr> 
  <tr>
    <td class="title"><p>Notify physiotherapist</p></td>
    <td><?php echo draw_option("Q20","Notify;Do Not notify","xm","multi",$Q20,true,6); ?></td>
    <td class="title"><p>Notify social worker</p></td>
    <td><?php echo draw_option("Q21","Notify;Do Not notify","xm","multi",$Q21,true,6); ?></td>
    <td class="title"><p>Filled by</p></td>
    <td width="80"><center><?php echo checkusername($_SESSION['ncareID_lwj']); ?></center></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="button" value="Today" onclick="inputdate('date');" /><?php }?></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02j" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?></center>
</form><br><br>
<script>
$(document).ready(function () {
	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Qtotal = 0;
	for(var i=25;i<30;i++){
		if ($('#Q'+i+'_2').val()==1) { Qtotal += 1; }
		if ($('#Q'+i+'_3').val()==1) { Qtotal += 2; }
	}
	$('#Qtotal').val(Qtotal);	
}	
</script>