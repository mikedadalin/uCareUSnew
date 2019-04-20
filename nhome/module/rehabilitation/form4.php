<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `rehabilitationform04` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `rehabilitationform04` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Rehabilitation progress assessment</h3>
<center>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table border="0" width="100%">
  <tr>
    <td class="title">State of consciousness</td>
    <td><?php echo draw_option("Q1","Clear;Orderless;Somnolence;Stupor;Coma;Semi-coma;Other","m","multi",$Q1,true,5); ?><input type="text" id="Q1a" name="Q1a" value="<?php echo $Q1a; ?>"></td>
  </tr>
  <tr>
    <td class="title">Ability to communicate:</td>
    <td><?php echo draw_checkbox_nobr("Q2","Can understand",$Q2,"single"); ?><br><?php echo draw_option("Q3","Spoken language;Body expression;Nodding/shaking head;Blinking eye(s);Can't express;Other","xl","multi",$Q3,true,3); ?><input type="text" id="Q3a" name="Q1a" value="<?php echo $Q3a; ?>"><br>
    <?php echo draw_checkbox_nobr("Q4","Don't understand",$Q4,"single"); ?><?php echo draw_option("Q5","Can speak;Can't speak","m","multi",$Q5,false,2); ?>
    </td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td colspan="7" class="title">Physiology Assessment:</td>
    </tr>
  <tr>
    <td colspan="3" rowspan="3" class="title_s">Joint activity</td>
    <td class="title_s">Shoulder</td>
    <td width="240px"><?php echo draw_option("Q6","Normal;Limited (L);Limited (R)","xs","multi",$Q6,false,2); ?></td>
    <td class="title_s">Hip</td>
    <td width="240px"><?php echo draw_option("Q7","Normal;Limited (L);Limited (R)","xs","multi",$Q7,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Elbow</td>
    <td><?php echo draw_option("Q8","Normal;Limited (L);Limited (R)","xs","multi",$Q8,false,2); ?></td>
    <td class="title_s">Knee</td>
    <td><?php echo draw_option("Q9","Normal;Limited (L);Limited (R)","xs","multi",$Q9,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Wrist</td>
    <td><?php echo draw_option("Q10","Normal;Limited (L);Limited (R)","xs","multi",$Q10,false,2); ?></td>
    <td class="title_s">Ankle</td>
    <td><?php echo draw_option("Q11","Normal;Limited (L);Limited (R)","xs","multi",$Q11,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" class="title_s">Muscle tone</td>
    <td class="title_s">Head, neck</td>
    <td><?php echo draw_option("Q12","Normal;Low;Low","xs","multi",$Q12,false,2); ?></td>
    <td class="title_s">Torso</td>
    <td><?php echo draw_option("Q13","Normal;Low;Low","xs","multi",$Q13,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Upper limb</td>
    <td><?php echo draw_option("Q14","Normal;Low;Low","xs","multi",$Q14,false,2); ?></td>
    <td class="title_s">Lower limb</td>
    <td><?php echo draw_option("Q15","Normal;Low;Low","xs","multi",$Q15,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="8" class="title_s">Muscle strength </td>
    <td colspan="4"><?php echo draw_checkbox_nobr("Q16","Unassessable",$Q16,"single"); ?></td>
    </tr>
  <tr>
    <td class="title_s">Left shoulder</td>
    <td><?php echo draw_option("Q18","0;1;2;3;4;5","ss","single",$Q18,true,6); ?></td>
    <td class="title_s">Right shoulder</td>
    <td><?php echo draw_option("Q23","0;1;2;3;4;5","ss","single",$Q23,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left wrist</td>
    <td><?php echo draw_option("Q19","0;1;2;3;4;5","ss","single",$Q19,true,6); ?></td>
    <td class="title_s">Right wrist</td>
    <td><?php echo draw_option("Q24","0;1;2;3;4;5","ss","single",$Q24,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left elbow</td>
    <td><?php echo draw_option("Q20","0;1;2;3;4;5","ss","single",$Q20,true,6); ?></td>
    <td class="title_s">Right elbow</td>
    <td><?php echo draw_option("Q25","0;1;2;3;4;5","ss","single",$Q25,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left ankle</td>
    <td><?php echo draw_option("Q21","0;1;2;3;4;5","ss","single",$Q21,true,6); ?></td>
    <td class="title_s">Right ankle</td>
    <td><?php echo draw_option("Q26","0;1;2;3;4;5","ss","single",$Q26,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left knee</td>
    <td><?php echo draw_option("Q22","0;1;2;3;4;5","ss","single",$Q22,true,6); ?></td>
    <td class="title_s">Right knee</td>
    <td><?php echo draw_option("Q27","0;1;2;3;4;5","ss","single",$Q27,true,6); ?></td>
  </tr>
  <tr>
    <td class="title_s">Total score</td>
    <td>Left upper limb 
      <input type="text"  name="Qtotal1" id="Qtotal1" size="2" value="<?php echo $Qtotal1;?>" /><br>
      Left lower limb&nbsp;
      <input type="text" name="Qtotal2" id="Qtotal2" size="2" value="<?php echo $Qtotal2;?>" /></td>
    <td class="title_s">Total score</td>
    <td>Right upper limb 
      <input type="text" name="Qtotal3" id="Qtotal3" size="2" value="<?php echo $Qtotal3;?>" /><br>
      Right lower limb&nbsp;
      <input type="text" name="Qtotal4" id="Qtotal4" size="2" value="<?php echo $Qtotal4;?>" /></td>
  </tr>
  <tr>
    <td colspan="4" class="title_s">5-Good,4-Fair,3-Normal,2-Poor,1-Very Poor,0-None</td>
    </tr>   
  <tr>
    <td colspan="3" rowspan="3" class="title_s">Hand movements</td>
    <td colspan="4"><?php echo draw_checkbox_nobr("Q17","Unassessable",$Q17,"single"); ?></td>
    </tr>
  <tr>
    <td class="title_s">Left hand gripping</td>
    <td><?php echo draw_option("Q28","Good;Fair;Poor;Very poor","m","multi",$Q28,true,2); ?></td>
    <td class="title_s">Right hand gripping</td>
    <td><?php echo draw_option("Q29","Good;Fair;Poor;Very poor","m","multi",$Q29,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left hand finger movement</td>
    <td><?php echo draw_option("Q30","Good;Fair;Poor;Very poor","m","multi",$Q30,true,2); ?></td>
    <td class="title_s">Right hand finger movement</td>
    <td><?php echo draw_option("Q31","Good;Fair;Poor;Very poor","m","multi",$Q31,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="8" class="title_s">Function of motion</td>
    <td colspan="4"><?php echo draw_checkbox("Q32","Unassessable",$Q32,"single"); ?></td>
    </tr>
  <tr>
    <td class="title_s">Turning over</td>
    <td colspan="3"><?php echo draw_option("Q33","Complete independently;Laborious & time consuming;Totally dependent","xl","multi",$Q33,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Get up from bed</td>
    <td colspan="3"><?php echo draw_option("Q34","Complete independently;Laborious & time consuming;Totally dependent","xl","multi",$Q34,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Posture adjustment</td>
    <td colspan="3"><?php echo draw_option("Q35","Complete independently;Laborious & time consuming;Totally dependent","xl","multi",$Q35,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Sitting balance  </td>
    <td colspan="3"><?php echo draw_option("Q36","Remain stable without support;Need support to remain stable;Unstable even with support","xxl","multi",$Q36,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Stand up  </td>
    <td colspan="3"><?php echo draw_option("Q37","Stand up independently;Need assistance;Totally dependent","xl","multi",$Q37,false,2); ?></td>
  </tr>  
  <tr>
    <td class="title_s">Standing balance  </td>
    <td colspan="3"><?php echo draw_option("Q38","Remain stable without support;Need support to remain stable;Unstable even with support","xxl","multi",$Q38,false,2); ?></td>
  </tr>  
  <tr>
    <td class="title_s">Turn while standing  </td>
    <td colspan="3"><?php echo draw_option("Q39","No support needed;Support needed;Unable to complete","l","multi",$Q39,false,2); ?></td>
  </tr>  
  <tr>
    <td colspan="3" rowspan="10" class="title_s">Activities of daily living(ADL)</td>
    <td class="title_s">Personal hygiene</td>
    <td colspan="3"><?php echo draw_option("Q40","Independently;Need assistance","l","multi",$Q40,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Bathing</td>
    <td colspan="3"><?php echo draw_option("Q41","Independently;Need assistance","l","multi",$Q41,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Self-feeding</td>
    <td colspan="3"><?php echo draw_option("Q42","Independently;Need assistance;Totally dependent","l","multi",$Q42,false,2); ?></td>
  </tr>  
  <tr>
    <td class="title_s">Toileting</td>
    <td colspan="3"><?php echo draw_option("Q43","Independently;Need assistance;Totally dependent","l","multi",$Q43,false,2); ?></td>
  </tr> 
  <tr>
    <td class="title_s">Climbing stairs</td>
    <td colspan="3"><?php echo draw_option("Q44","Independently;Need assistance;Totally dependent","l","multi",$Q44,false,2); ?></td>
  </tr> 
  <tr>
    <td class="title_s">Dressing/Grooming</td>
    <td colspan="3"><?php echo draw_option("Q45","Independently;Need assistance;Totally dependent","l","multi",$Q45,false,2); ?></td>
  </tr> 
  <tr>
    <td class="title_s">Defecate control</td>
    <td colspan="3"><?php echo draw_option("Q46","Independently;Need assistance;Totally dependent","l","multi",$Q46,false,2); ?></td>
  </tr> 
  <tr>
    <td class="title_s">Urine control</td>
    <td colspan="3"><?php echo draw_option("Q47","Independently;Need assistance;Totally dependent","l","multi",$Q47,false,2); ?></td>
  </tr> 
  <tr>
    <td class="title_s">Transposing</td>
    <td colspan="3"><?php echo draw_option("Q48","Independently;Need assistance;Totally dependent","l","multi",$Q48,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ambulation</td>
    <td colspan="3"><?php echo draw_option("Q49","Independently;Need assistance;Totally dependent","l","multi",$Q49,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Functional assessment</td>
    <td colspan="4"><?php echo draw_checkbox("Q50","Activities freely, without any restrictions;Maintain light work ability, such as light housework, office work;Able to walk and self-care, but unable to engage in housework or office work; Beside sleeping time, more than half of the time can do activities.;Only maintain limited self-care;Except sleeping time, more than half of the time in bed or on seat;Completely restricted in bed or chair",$Q50,"multi"); ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="4" class="title_s">Assistive devices category</td>
    <td colspan="4"><?php echo draw_checkbox_nobr("Q51","Need;Need not",$Q51,"single"); ?></td>
    </tr>
  <tr>
    <td class="title_s">Assisted living</td>
    <td colspan="3"><?php echo draw_option("Q52","Canes/Walker;wheelchair;Dietary;Clothing;Cleaning and bathing","l","multi",$Q52,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Rehabilitation assistance</td>
    <td colspan="3"><?php echo draw_option("Q53","Electric wheelchair;Special wheelchair;Fluid pressure cushion / air cushion seat;Special back pad;Fluid pressure mattress / air bed;Bracket, splint and wrist brace","xxxl","multi",$Q53,true,2); ?></td>
  </tr>   
  <tr>
    <td class="title_s">Other</td>
    <td colspan="3"><input type="text" id="Q54" name="Q54" value="<?php echo $Q54; ?>" size="50" ></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="7" class="title_s">Emotion and <br>cognitive assessment</td>
    <td colspan="4"><?php echo draw_checkbox_nobr("Q55","Unassessable;No obvious abnormalities	",$Q55	,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Emotional Disorders</td>
    <td colspan="3"><?php echo draw_option("Q56","Emotional instability;Euphoria;Depression;Hypochondriasis;Frustration;Restlessness;Aggression","l","multi",$Q56,true,4); ?></td>
  </tr>  
  <tr>
    <td class="title_s">Cognitive disorders</td>
    <td colspan="3"><?php echo draw_option("Q57","Stubborn;Poor disease insight;Lack of judgment;Psychiatric orderless","l","multi",$Q57,false,5); ?></td>
  </tr> 
  <tr>
    <td class="title_s">Sensory impairment</td>
    <td colspan="3"><?php echo draw_option("Q58","Visual object agnosia;Visual integration agnosia;Visuospatial agnosia;Anosognosia","xl","multi",$Q58,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Proprioceptive dysfunction</td>
    <td colspan="3"><?php echo draw_option("Q59","Lost orientation (left/right);Can not identify body part(s)","xl","multi",$Q59,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Memory impairment</td>
    <td colspan="3"><?php echo draw_option("Q60","Amnesia;Lost orientation;Emptiness/apathy","xm","multi",$Q60,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Other impairment</td>
    <td colspan="3"><?php echo draw_option("Q61","Lack of motivation;Lack of energy;Absently;Attention deficits;Easily distracted;Lack of vigilance;Performance delayed","l","multi",$Q61,true,4); ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="5" class="title_s">Social interaction<br> or participation</td>
    <td colspan="4"><?php echo draw_checkbox_nobr("Q62","Unassessable",$Q62,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Interaction</td>
    <td colspan="3"><?php echo draw_option("Q63","3.Good interact ability;2.Only with certain people;1.Occasional interactions;0.No interaction","xl","single",$Q63,true,2); ?></td>
  </tr>   
  <tr>
    <td class="title_s">Communication</td>
    <td colspan="3"><?php echo draw_option("Q64","3.Active;2.Passive responses;1.No intention","l","single",$Q64,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Social participation</td>
    <td colspan="3"><?php echo draw_option("Q65","1.Rotate;1.Obey instructions;1.Approach people actively;0.Silence;0.Loner;0.Alienation","xl","multi",$Q65,true,3); ?></td>
  </tr>
  <tr>
    <td class="title_s">Total score</td>
    <td colspan="3"><input type="text" name="Qtotal5" id="Qtotal5" size="2" value="<?php echo $Qtotal5;?>" /> </td>
  </tr>  
  <!--<tr>
    <td colspan="3" class="title_s">Walking aids</td>
    <td colspan="4" ><?php echo draw_option("Q29","Need not;wheelchair;Special wheelchair;Walker;Canes;crutch","m","multi",$Q29,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="7" class="title">(3)Ability to communicate:</td>
  </tr> 
  <tr>
    <td colspan="3" class="title_s">Vision</td>
    <td colspan="4" ><?php echo draw_option("Q30","Normal(R);Blurred(R);Blind(R);Unassessable(R);Normal(L);Blurred(L);Blind(L);Unassessable(L)","m","multi",$Q30,true,4); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Hearing</td>
    <td colspan="4" ><?php echo draw_option("Q31","Normal(R);Impaired(R);Deaf(R);Unassessable(R);Normal(L);Impaired(L);Deaf(L);Unassessable(L)","m","multi",$Q31,true,4); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Speaking skill</td>
    <td colspan="4" ><?php echo draw_option("Q32","Good;Can express simple sentences;Can speak piecemeal words;Unable to speak;Unable to determine;Unassessable","l","multi",$Q32,true,3); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Comprehension</td>
    <td colspan="4" ><?php echo draw_option("Q33","Good;Understandable simple sentences;Understand piecemeal words;Unable to speak;Unable to determine;Unassessable","l","multi",$Q33,true,3); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Preferred Language</td>
    <td colspan="4" ><?php echo draw_option("Q34","English;Spanish;客家語;粵語;Other","m","multi",$Q34,false,2); ?><input type="text" id="Q34a" name="Q34a" value="<?php echo $Q34a; ?>"></td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Preliminary assessment result</td>
    <td colspan="4" ><?php echo draw_checkbox("Q35","Admission NOT approved because:<input type=\"text\" name=\"Q35a\" id=\"Q35a\" size=\"40\" value=\"".$Q35a."\" />;Admission approved",$Q35,"single"); ?><?php echo draw_checkbox_nobr("Q36","Individually exercise;Bedside exercise;Group activities/exercise",$Q36,"single"); ?></td>
  </tr>-->
</table>
<table width="100%" border="0">
  <tr>
    <td class="title">Short-term treatment goals:</td>
  </tr>
   <tr>
    <td ><?php echo draw_checkbox_2col("Q66","Range of motion, strengh and muscle pain treatment;Turn over;Transposition capability;Balance training;Improve posture control and adjustment;Walking and gait;Induce / suppress muscle tone;Hand skills training;Enhance cognitive ability;Raising motivation to do daily activities ;Appropriate response/feedback;Improve edema;Reduce pain;Familiar with assistive devices /health education;Appropriate placement / positioning skills;Encourage / promote social interaction and participate;Daily activity skill training;Other:<input type=\"text\" name=\"Q66a\" id=\"Q66a\" size=\"40\" value=\"".$Q66a."\" />",$Q66,"multi"); ?></td>
  </tr> 
  <tr>
    <td class="title">Long-term treatment goals:</td>
  </tr>
   <tr>
    <td ><?php echo draw_checkbox_2col("Q67","Increase muscle strength and endurance;Maintain/Improve joint mobility;Improve ability of transposition;Improve balance / reduce falls;Increase walking time / distance;Improve cardiorespiratory endurance;Improve hand motion function skills;Enhance alertness;Improve activity of daily living;Develop leisure activities / interests;Good interpersonal interaction and communication;Improve cognitive ability;Maintain good body posture;Improve metabolism / reduce edema;Other:<input type=\"text\" name=\"Q67a\" id=\"Q67a\" size=\"40\" value=\"".$Q67a."\" />",$Q67,"multi"); ?></td>
  </tr> 
  <tr>
    <td class="title">Treatment programs:</td>
  </tr>
   <tr>
    <td ><?php echo draw_checkbox_2col("Q68","Muscle strength and endurance training;Active / Passive joint movement and traction;Proprioception evoking;Joint mobilization;Transposition training;Balance training;Hand function training;Walking training;Assistive devices training;Tctivity of daily living training;Giving stimulus;Cardio training;Cognitive training;Massage;Apply hot/ice packs;Other:<input type=\"text\" name=\"Q68a\" id=\"Q68a\" size=\"40\" value=\"".$Q68a."\" />",$Q68,"multi"); ?></td>
  </tr>   
  </table>	
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>

<center>
  <div style="margin:30px auto;">
  <input type="hidden" name="formID" id="formID" value="rehabilitationform04" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
</div>
</center>
</form>
</center>
<?php
$url = explode('/',$_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
?>
<script>
$(document).ready(function () {
	<?php if($file=="index"){echo 'calcQtotal';}?>
//	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Qtotal1 = 0;
	var Qtotal2 = 0;
	var Qtotal3 = 0;
	var Qtotal4 = 0;
	var Qtotal5 = 0;
	for(var i=0;i<7;i++){
		if ($('#Q18_'+i).val()==1) { Qtotal1 += (i-1); }
		if ($('#Q19_'+i).val()==1) { Qtotal1 += (i-1); }		
		if ($('#Q20_'+i).val()==1) { Qtotal1 += (i-1); }		
		if ($('#Q21_'+i).val()==1) { Qtotal2 += (i-1); }		
		if ($('#Q22_'+i).val()==1) { Qtotal2 += (i-1); }		
		if ($('#Q23_'+i).val()==1) { Qtotal3 += (i-1); }		
		if ($('#Q24_'+i).val()==1) { Qtotal3 += (i-1); }		
		if ($('#Q25_'+i).val()==1) { Qtotal3 += (i-1); }		
		if ($('#Q26_'+i).val()==1) { Qtotal4 += (i-1); }		
		if ($('#Q27_'+i).val()==1) { Qtotal4 += (i-1); }		
	}
	$('#Qtotal1').val(Qtotal1);
	$('#Qtotal2').val(Qtotal2);	
	$('#Qtotal3').val(Qtotal3);
	$('#Qtotal4').val(Qtotal4);	
	
	if ($('#Q63_1').val()==1) { Qtotal5 += 3; }
	if ($('#Q63_2').val()==1) { Qtotal5 += 2; }
	if ($('#Q63_3').val()==1) { Qtotal5 += 1; }
	if ($('#Q64_1').val()==1) { Qtotal5 += 3; }
	if ($('#Q64_2').val()==1) { Qtotal5 += 2; }
	if ($('#Q64_3').val()==1) { Qtotal5 += 1; }	
	if ($('#Q65_1').val()==1) { Qtotal5 += 1; }
	if ($('#Q65_2').val()==1) { Qtotal5 += 1; }
	if ($('#Q65_3').val()==1) { Qtotal5 += 1; }	
	$('#Qtotal5').val(Qtotal5);	
}
</script>
