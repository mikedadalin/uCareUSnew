<?php
$form = "socialform06a_".@$_GET['time'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `".$form."` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `".$form."` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>New resident adaptation assessment - over 2 week</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%" align="center">
  <tr>
    <td rowspan="3" class="title" width="80">Physiological</td>
    <td class="title_s" width="120">Insomnia</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q1","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q1,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Poor appetite</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q2","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q2,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Digestive problems</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q3","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q3,false,6); ?></td>
  </tr>
  <tr>
    <td rowspan="7" class="title">Psychology</td>
    <td class="title_s">Fear</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q4","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q4,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Anxiety</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q5","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q5,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Lonely & <br> helpless</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q6","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q6,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Despair or<br>depression</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q7","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q7,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Sense of<br>abandonment</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q8","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q8,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Anger</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q9","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q9,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Homesickness</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q10","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q10,false,6); ?></td>
  </tr>
  <tr>
    <td rowspan="9" class="title">Behavior</td>
    <td class="title_s">Cry/weep</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q11","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q11,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Looking for<br> family</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q12","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q12,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Want to<br>return home</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q13","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q13,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Tantrum</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q14","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q14,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Refused to<br> be served</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q15","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q15,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Remain silent</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q16","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q16,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Antifeeding</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q17","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q17,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Suicide</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q18","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q18,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Exploratory behavior</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q19","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q19,false,6); ?></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">Interpersonal<br> interaction</td>
    <td class="title_s">With staff</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q20","Active;Fair;Passive;Loner;Resist;Unassessable","l","single",$Q20,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">With roommates</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q21","Active;Fair;Passive;Loner;Resist;Unassessable","l","single",$Q21,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">With roommates</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q22","Active;Fair;Passive;Loner;Resist;Unassessable","l","single",$Q22,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">With relatives</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q23","Active;Fair;Passive;Loner;Resist;Unassessable","l","single",$Q23,true,3); ?></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Environment</td>
    <td class="title_s">Room</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q24","Know;Not know;Unassessable","l","single",$Q24,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Public areas</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q25","Know;Not know;Unassessable","l","single",$Q25,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Equipment</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q26","Know;Not know;Unassessable","l","single",$Q26,false,6); ?></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">Lifestyle</td>
    <td class="title_s">Wake time</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q27","Know;Not know;Unassessable","l","single",$Q27,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Meal times</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q28","Know;Not know;Unassessable","l","single",$Q28,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Activity time</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q29","Know;Not know;Unassessable","l","single",$Q29,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Sleep time</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q30","Know;Not know;Unassessable","l","single",$Q30,false,6); ?></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">Families respond</td>
    <td class="title_s">Resident's quality of<br> life improvement</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q36","Good;Fair;Poor;Unassessable","l","single",$Q36,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Residents will take the initiative<br> to tell the families about<br> the lifestyle in this facility</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q37","Good;Fair;Poor;Unassessable","l","single",$Q37,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Changes in mood <br>after the admission</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q38","Good;Fair;Poor;Unassessable","l","single",$Q38,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Center's services<br> meets the expectation<br> before admission</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q39","Good;Fair;Poor;Unassessable","l","single",$Q39,false,6); ?></td>
  </tr>
  <tr>
    <td rowspan="2" class="title">Other</td>
    <td class="title_s"><input type="text" name="Q31" id="Q31" value="<?php echo $Q31; ?>" size="12"></td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q31a","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q31a,false,6); ?></td>
  </tr>
  <tr>
    <td class="title_s"><input type="text" name="Q32" id="Q32" value="<?php echo $Q32; ?>" size="12"></td>
    <td colspan="2" style="text-align:left;"><?php echo draw_option("Q32a","(-)Not occured;(△)Improving;(＋)Occured","l","single",$Q32a,false,6); ?></td>
  </tr>
  <tr>
    <td class="title"colspan="2">Assessment results</td>
    <td colspan="2" style="text-align:left;"><?php echo draw_checkbox("Q33","No adaptation issues,apply general casework service mode.;Adaptation issues occured. Apply special services mode.",$Q33,"single"); ?></td>
  </tr>
</table>
<script>
$( document ).ready(function() {
    checkQ32();
});
$('#btn_Q33_2').bind('click', function () {
	checkQ32();
});
$('#btn_Q33_1').bind('click', function () {
	checkQ32();
});
function checkQ32() {
	if ($('#Q33_2').val()=="1") {
		$('#specialcase').css('display','block');
	} else {
		$('#specialcase').css('display','none');
	}
}
</script>
<div id="specialcase" style="display:none;">
<h3>Resident's counseling and treatment program</h3>
<table width="100%">
  <tr>
    <td class="title">Treatment plan</td>
  </tr>
  <tr>
    <td><?php echo draw_checkbox("Q34","Held meeting with the resident's family and relatives.;Social worker psychological counsel;Encourage participation in group activities;Request staff for more support and care;Ask family member: <input type=\"text\" name=\"Q34a\" id=\"Q34a\" value=\"".$Q34a."\" size=\"12\"> to assist caring;Ask resident <input type=\"text\" name=\"Q34b\" id=\"Q34b\" value=\"".$Q34b."\" size=\"12\"> to assist caring;Ask volunteer <input type=\"text\" name=\"Q34c\" id=\"Q34c\" value=\"".$Q34c."\" size=\"12\"> to assist caring;Other(s):<input type=\"text\" name=\"Q34d\" id=\"Q34d\" value=\"".$Q34d."\" size=\"24\">",$Q34,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Outcomes/result assessment and records</td>
  </tr>
  <tr>
    <td><textarea name="Q35" id="Q35" cols="60" rows="6" ><?php echo $Q35; ?></textarea></td>
  </tr>
</table>
</div>
<a style="color:rgb(238,203,53); font-size:18px; font-weight:bold;">Filled date：</a><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="button" value="Today" onclick="inputdate('date');" /><?php }?>
<center><input type="hidden" name="formID" id="formID" value="<?php echo $form; ?>" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?></center>
</form><br><br>