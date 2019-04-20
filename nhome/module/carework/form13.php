<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `careform13` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `careform13` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<div style="background-color:rgba(255,255,255,0.8); border-radius:10px; padding:10px 0px 30px 0px; width:100%; margin-bottom:40px;">
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3 style="width:92%;">Preferences for Customary Routine and Activities</h3>

<div style="width:92%; margin:0 auto;">
<table cellpadding="5" style="width:100%">  
  <tr>
    <td width="240" class="title"><p>Should Interview for Daily and Activity Preferences be Conducted?</p></td>
    <td colspan="5" style="padding-top:20px; text-align:left;"><?php echo draw_option("Q1","No;Yes","m","single",$Q1,false,0); ?>
    	<br /><br />If yes, continue to Interview for Daily Preferences; otherwise, skip to and complete Staff Assessment of Daily and Activity Preferences<br />&nbsp</td>
  </tr>
  <tr>
    <td class="title"><p>Should the Staff Assessment of Daily and Activity Preferences be Conducted?</p></td>
    <td colspan="5" style="padding-top:20px; text-align:left;"><?php echo draw_option("Q2","No;Yes","m","single",$Q2,false,0); ?>
    	<br /><br />If 3 or more items in Interview for Daily and Activity Preferences were not completed by resident or family/significant other, continue to Staff Assessment of Daily and Activity Preferences<br />&nbsp</td>
  </tr>
</table>
<table cellpadding="7" style="width:100%; text-align:left;">
  <tr>
  	<td colspan="3" class="title" width="50%">Interview for Daily and Activity Preferences</td>
  	<td colspan="3" class="title">Staff Assessment of Daily and Activity Preferences</td>
  </tr>
  <tr>
  	<td colspan="3"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coding:
              <ul>
                <li>(1) Very important</li>
                <li>(2) Somewhat important</li>
                <li>(3) Not very important</li>
                <li>(4) Not important at all</li>
                <li>(5) Important, but can't do or no choice</li>
                <li>(9) No response or non-responsive</li>
              </ul></p>
    </td>
  	<td colspan="3" align="center"><p>Do not conduct if interview for Daily and Activity Preferences was completed</p>
  					<p>Resident Prefers - Check all that apply</p></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q3" id="Q3" size="2" value="<?php echo $Q3; ?>" /> How important is it to you to choose what clothes to wear?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q21","Choosing clothes to wear",$Q21,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q4" id="Q4" size="2" value="<?php echo $Q4; ?>" /> How important is it to you to take care of your personal belongings or things?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q22","Caring for personal belongings",$Q22,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q5" id="Q5" size="2" value="<?php echo $Q5; ?>" /> How important is it to you to choose between a tub bath, shower, bed bath, or sponge bath?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q23","Receiving tub bath;Receiving shower;Receiving bed bath; Receiving sponge bath",$Q23,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q6" id="Q6" size="2" value="<?php echo $Q6; ?>" /> How important is it to you to have snacks available between meals?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q24","Snacks between meals",$Q24,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q7" id="Q7" size="2" value="<?php echo $Q7; ?>" /> How important is it to you to choose your own bedtime?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q25","Staying up past 8:00 p.m.",$Q25,"multi"); ?></td>
  </tr>
    <tr>
  	<td colspan="3"><input type="text" name="Q8" id="Q8" size="2" value="<?php echo $Q8; ?>" /> How important is it to you to have your family or a close friend involved in discussions about your care?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q26","Family or significant other involvement in care discussions",$Q26,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q9" id="Q9" size="2" value="<?php echo $Q9; ?>" /> How important is it to you to be able to use the phone in private?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q27","Use of phone in private",$Q27,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q10" id="Q10" size="2" value="<?php echo $Q10; ?>" /> How important is it to you to have a place to lock your things to keep them safe?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q28","Place to lock personal belongings",$Q28,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q11" id="Q11" size="2" value="<?php echo $Q11; ?>" /> How important is it to you to have books, newspapers, and magazines to read?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q29","Reading books, newspapers, or magazines",$Q29,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q12" id="Q12" size="2" value="<?php echo $Q12; ?>" /> How important is it to you to listen to music you like?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q30","Listening to music",$Q30,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q13" id="Q13" size="2" value="<?php echo $Q13; ?>" /> How important is it to you to be around animals such as pets?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q31","Being around animals such as pets",$Q31,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q14" id="Q14" size="2" value="<?php echo $Q14; ?>" /> How important is it to you to keep up with the news?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q32","Keeping up with the news",$Q32,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q15" id="Q15" size="2" value="<?php echo $Q15; ?>" /> How important is it to you to do things with groups of people?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q33","Doing things with groups of people",$Q33,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q16" id="Q16" size="2" value="<?php echo $Q16; ?>" /> How important is it to you to do your favorite activities?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q34","Participating in favorite activities",$Q34,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q17" id="Q17" size="2" value="<?php echo $Q17; ?>" /> How important is it to you to go outside to get fresh air when the weather is good?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q35","Spending time away from the nursing home;Spending time outdoors",$Q35,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><input type="text" name="Q18" id="Q18" size="2" value="<?php echo $Q18; ?>" /> How important is it to you to participate in religious services or practives?</td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q36","Participating in religious activities or practices",$Q36,"multi"); ?></td>
  </tr>
  <tr>
  	<td colspan="3"><p><input type="text" name="Q19" id="Q19" size="2" value="<?php echo $Q19; ?>" /> Indicate primary respondent for Daily and Activity Preferences 
  		<ul>
  			<li>(1) Resident </li>
  			<li>(2) Family or significant other</li>
  			<li>(9) Interview could not be completed by resident or family/significant other</li>
  		</ul></p></td>
  	<td colspan="3"><?php echo draw_checkbox_2col("Q20","None of the above",$Q20,"multi"); ?></td>
  </tr>
</table>  
<table cellpadding="7" style="width:100%">
  <tr>
    <td align="left" width="50%">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><div style="margin:20px 0 10px 0;"><input type="hidden" name="formID" id="formID" value="careform13" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></div></center>

</div>

</form>
</div>