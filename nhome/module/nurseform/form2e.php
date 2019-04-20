<?php
$tmp_Birth = str_replace("/","",$birth);
$age = calcagenum($tmp_Birth);
if ($age>=65) { $over65 = 2; } else { $over65 = 1; }
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02e` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02e` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Fall Risk Assessment</h3>
<table width="100%">
  <tr>
    <td width="40" rowspan="14" class="title">Fall Risk<br />Assessment</td>
    <td class="title_s">Age</td>
    <td><?php echo draw_option("Q1","Less than 65;Equal/more than 65","l","single",$over65,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Fall history</td>
    <td><?php echo draw_option("Q2","None;Yes","m","single",$Q2,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Mobility</td>
    <td><?php echo draw_checkbox("Q3","No mobility challenge, no other person or aids needed.;Mobility challenge, need other person or aids.",$Q3,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">State of consciousness</td>
    <td><?php echo draw_option("Q4","Clear and oriented;Where,when,who confused;Where,when,who confused but bedfast","xxxl","single",$Q4,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Behavior</td>
    <td><?php echo draw_option("Q5","Normal;Restless or depressed","l","single",$Q5,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Nocturia</td>
    <td><?php echo draw_option("Q6","None;Yes;Severe disability (bedfast)","xl","single",$Q6,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Night blind</td>
    <td><?php echo draw_option("Q7","None;Has;Severe disability (bedfast)","xl","single",$Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Gait stability</td>
    <td><?php echo draw_option("Q8","Gait steady & balance;Gait not steady;Gait not steady with bedfast","xl","single",$Q8,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Medication</td>
    <td><?php echo draw_checkbox_2col("Q9","Antihistamine;Antihypertensive;Sedative-hypnotic;Muscle relaxants;Laxative;Diuretics;Antidepressant;Hypoglycemic",$Q9,"multi"); ?><br>
    From the medication above. Please list the current usage.<br>
    <?php echo draw_checkbox_nobr("Q13","Not using above medication(s);using above medication(s) with bedfast condition;Using 2 or more kinds of medication above",$Q13,"multi"); ?>Medication:<input type="text" name="Q13a" value="<?php echo $Q13a;?>">
    </td>
  </tr>
  <tr>
    <td class="title_s">New admission</td>
    <td><?php echo draw_checkbox_nobr("Q10","No;Yes;New admission with bedfast",$Q10,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Clothing (including shoes)</td>
    <td><?php echo draw_checkbox("Q11","Clothes and shoes size are fit and antiskid.;Dress is slacks and shoes are slippery.;Has inappropriate dress and shoes size, but on bedfast condition.",$Q11,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Environmental familiar object(s)</td>
    <td><?php echo draw_checkbox("Q12","Place on healthy side or familiar position.;Object been moved or relocated.;Object been moved or relocated due to the bedfast condition",$Q12,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s">Total score</td>
    <td><input type="text" name="Qtotal" id="Qtotal" value="<?php echo $Qtotal; ?>" readonly size="3"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>

    <ol style="margin-left:20px;" align="left">
    	<li>Compete this assessment durinng admission by the nurse on duty. </li>
        <li>Total score >=4 points expressed tendency to fall. According to resident status assessed by nurses develop fall prevention care plan. State high falling risk considerations to the bedside.</li>
		<li>Monthly assessment should be done by primary nurse.</li>
    </ol>

<center><input type="hidden" name="formID" id="formID" value="nurseform02e" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>

<script>
$(document).ready(function () {
	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Total = 0;
	if ($('#Q1_2').val()==1) { Total+=1; }
	if ($('#Q2_2').val()==1) { Total+=5; }
	if ($('#Q3_2').val()==1) { Total+=1; }
	if ($('#Q4_2').val()==1) { Total+=1; }
	if ($('#Q5_2').val()==1) { Total+=1; }
	if ($('#Q6_2').val()==1) { Total+=1; }
	if ($('#Q7_2').val()==1) { Total+=1; }
	if ($('#Q8_2').val()==1) { Total+=1; }
	if ($('#Q10_2').val()==1) { Total+=1; }
	if ($('#Q11_2').val()==1) { Total+=1; }
	if ($('#Q12_2').val()==1) { Total+=1; }
	if ($('#Q13_3').val()==1) { Total+=2; }
	var count = 0;
	for (var i=1;i<=8;i++) {
		if ($('#Q9_'+i).val()==1) { count++; }
	}
	if (count>=2) { Total+=2; }
	if (Total>=4) { $('#Qtotal').css("background", "#E87F81").css("color", "#FFFFFF"); } else { $('#Qtotal').css("background", "#FFFFFF").css("color", "#000"); }
	$('#Qtotal').val(Total);
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