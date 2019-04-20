<?php
//$HospNo = getHospNo(@$_GET['pid']);
//$date = mysql_escape_string(formatdate(@$_GET['date']));

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part4` WHERE `targetID`='".mysql_escape_string($_GET['tID'])."'");
$r1 = $db1->fetch_assoc();

foreach ($r1 as $k=>$v) {
	$arrPatientInfo = explode("_",$k);
	if (count($arrPatientInfo)>1) {
		$varname = "";
		for ($i=0;$i<(count($arrPatientInfo)-1);$i++) {
			if ($v==1) {
				if ($varname!="") { $varname .= '_'; }
				$varname .= $arrPatientInfo[$i];
			}
		}
		//echo $varname.'<br>';
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=delete&targetID=<?php echo $targetID; ?>">
<h3>Infection record</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table width="100%">
  <tr>
    <td width="120" class="title">Care ID#</td>
    <td><?php echo getHospNoDisplayByPID(getPID($HospNo)); ?></td>
    <td width="120" class="title">Resident name</td>
    <td><?php echo $Name; ?></td>
    <td width="120" class="title">Date</td>
    <td><?php echo $date; ?></td>
    <td width="120" class="title">感染類別</td>
    <td>
	<?php
	if ($InfectType==1) {
		echo 'Urinary tract infection(UTI)';
	} elseif ($InfectType==2) {
		echo 'Respiratory tract infection (RTI)';
	} elseif ($InfectType==3) {
		echo 'Skin infection';
	} elseif ($InfectType==4) {
		echo 'Gastrointestinal infections';
	} elseif ($InfectType==5) {
		echo 'Ear, eye, nose and mouth infection ';
	}
	?>
    </td>
  </tr>
  <tr>
    <td colspan="8">
    <?php if ($InfectType==1) { ?>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1) Not on foley (at least 3)<br /><?php echo draw_checkbox("Q1_A_1","1. Temperature ≥38ºC(100ºF) or feeling chills;2. Urethral burning sensation, urinary frequency or urgently;3. bladder area or lower back pain;4. Urine characteristic changes;5. Worsening mental or physical function",$Q1_A_1,"multi"); ?></td>
        <td valign="top">(2)Is on foley (at least 2)<br /><?php echo draw_checkbox("Q1_A_2","1. Temperature ≥38ºC(100ºF) or feeling chills;2. Bladder area or lower back pain;3. The changing status of urine (such as urine becomes turbid , malodorous, or has blood in the urine, etc.);4. Worsening mental or physical function",$Q1_A_2,"multi"); ?><br />Date of last catheter replacement:<script> $(function() { $( "#Q1_A_2_4_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1_A_2_4_date" id="Q1_A_2_4_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q1_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1_date" id="Q1_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q1_B","Monitor temperature changes QID;Monitor urine test results;Monitor antibiotic treatment results;Increased water intake to 2000.c.c(68 fl oz) /day;Empty the bladder as much as possible - such as Q2H toileting, intermittent catheterization;Teach and assist in maintaining the vulva clean and hygiene;Correct indwelling catheter care;Replace the catheter",$Q1_B,"multi"); ?></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q1_C","Clear urine and improvement in odor;Normal body temperature;Continue to track;Mental or functional improvement",$Q1_C,"multi"); ?></td>
      </tr>
      </table>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" height="30" class="title_s">Comment</td><td><input type="text" name="Q1_memo" id="Q1_memo" size="80"></td>
      </tr>
      <tr>
        <td width="120" height="30" class="title_s">Filled by</td><td><?php echo checkusername($Qfiller); ?></td>
      </tr>
    </table>
    <?php
	} elseif ($InfectType==2) {
	?>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1) The common cold syndrome (at least 2)<br /><?php echo draw_checkbox("Q2_A_1","1. Runny nose or sneezing;2. Stuffy nose;3. Sore throat, hoarse, or difficulty swallowing;4. Dry cough;5. Swollen glands in the neck or allergies",$Q2_A_1,"multi"); ?><font size="2">Note: not necessarily having a fever, but the symptoms must be newly created.</font></td>
        <td valign="top">(2) Influenza (at least 3)<br /><?php echo draw_checkbox("Q2_A_2","1. Chills;2. New generated headache or eye pain symptom;3. Muscle pain;4. Physical discomfort or loss of appetite;5. Sore throat;6. Cough newly created or worsening",$Q1_A_2,"multi"); ?><font size="2">Note: This diagnosis must be at epidemic season (late fall to early spring each year)</font></td>
      </tr>
      <tr>
        <td colspan="2">(3) Other lower respiratory tract infections - tracheitis and bronchitis (at least 3 categories)<br /><?php echo draw_checkbox("Q2_A_3","1. Newly generated cough;2. Body temperature higher than 38ºC (100ºF);3. Produce sputum;4. Sternocostal pain;5. New breath sounds found in chest physical examination (e.g. rales rhonchi wheezing bronchial-breathing);6. With one of the following changes in the state of dyspnea;　　a. Newly appeared shortness of breath;　　b. Respiratory> 25 time/minute;　　c. Worsening mental or physical function",$Q2_A_3,"multi"); ?></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q2_B","Monitoring vital sign changes QID;Monitoring results of medication;Raising the headboard 30 degree when lying;Turning over and chest percussion Q2H;Nebulization therapy to improve coughing/suction efficiency;Adequate water intake;Enhance oral care;Evaluate the ability to chew and swallow;Nutritional support to enhance immunity;Oxygen therapy;Postural drainage",$Q2_B,"multi"); ?></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q2_C","Symptoms improved;Hospitalization",$Q2_C,"multi"); ?></td>
      </tr>
    </table>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" height="30" class="title_s">Comment</td><td><input type="text" name="Q2_memo" id="Q2_memo" size="80"></td>
      </tr>
      <tr>
        <td width="120" height="30" class="title_s">Filled by</td><td><?php echo checkusername($Qfiller); ?></td>
      </tr>
    </table>
    <?php
	} elseif ($InfectType==3) {
	?>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1)Cellulitis, pressure sores, wound infection (at least one)<br /><?php echo draw_checkbox("Q3_A_1","1. Pus;2. At least 4 symptoms;　　a. Fever;　　b. Reddish;　　c. Swollen;　　d. Tenderness pain;　　e. Worsening mental or physical function;　　f. Serous secretion",$Q3_A_1,"multi"); ?></td>
        <td valign="top">(2)Other skin infections<br /><?php echo draw_checkbox("Q3_A_2","1. Blisters;2. Papules;3. Itchy skin",$Q3_A_2,"multi"); ?></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q3_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q3_date" id="Q3_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q3_B","Intermittent icing 20 minutes/time QID;Raising wounded limb;Maintaining clean skin;Moisturizing the dried skin;Wound assessment and dressing medication;Prevention of oppression on abnormal skin;Turn over Q2H;monitoring results of medication treatment;Adequate nutrition;Applying air bed and air cushion;Checking hemoglobin, albumin",$Q3_B,"multi"); ?></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q3_C","Skin recovered;Hospitalization",$Q3_C,"multi"); ?></td>
      </tr>
    </table>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" height="30" class="title_s">Comment</td><td><input type="text" name="Q3_memo" id="Q3_memo" size="80"></td>
      </tr>
      <tr>
        <td width="120" height="30" class="title_s">Filled by</td><td><?php echo checkusername($Qfiller); ?></td>
      </tr>
    </table>
    <?php
	} elseif ($InfectType==4) {
	?>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td colspan="2">At least 1<br /><?php echo draw_checkbox("Q4_A","1. Having diarrhea two or more times per day;2. Vomiting two or more times per day;3. At least 1 following symptom;　　a. Vomiting;　　b. Abdominal pain;　　c. Diarrhea",$Q4_A,"multi"); ?></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q4_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q4_date" id="Q4_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q4_B","Adequate water intake;Maintaining electrolyte balanced;Review resident's medication;Close observation of the skin status at buttocks;Monitoring results of medication;Monitoring changes in body weight;Light diet",$Q4_B,"multi"); ?></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q4_C","The number of loose stools is reduced",$Q4_C,"multi"); ?></td>
      </tr>
    </table>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" height="30" class="title_s">Comment</td><td><input type="text" name="Q4_memo" id="Q4_memo" size="80"></td>
      </tr>
      <tr>
        <td width="120" height="30" class="title_s">Filled by</td><td><?php echo checkusername($Qfiller); ?></td>
      </tr>
    </table>
    <?php
	} elseif ($InfectType==5) {
	?>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1)Conjunctivitis (match 1)<br /><?php echo draw_checkbox("Q5_A_1","1. Pus appear in one or both eyes within 24 hours;2. New conjunctival redness (whether or itching sensation) for at least 24 hours",$Q5_A_1,"multi"); ?></td>
        <td valign="top">(2)Ear Infection (match 1)<br /><?php echo draw_checkbox("Q5_A_2","1. Physician's diagnosis;2. New secretions in 1 ear or both ears",$Q5_A_2,"multi"); ?></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q5_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q5_date" id="Q5_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q5_B","Keep the affected area clean;Contact isolation;monitoring results of medication treatment",$Q5_B,"multi"); ?></td>
      </tr>
      <tr>
        <td class="title_s" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo draw_checkbox("Q5_C","Secretions decrease",$Q5_C,"multi"); ?></td>
      </tr>
    </table>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" height="30" class="title_s">Comment</td><td><input type="text" name="Q5_memo" id="Q5_memo" size="80"></td>
      </tr>
      <tr>
        <td width="120" height="30" class="title_s">Filled by</td><td><?php echo checkusername($Qfiller); ?></td>
      </tr>
    </table>
    <?php
	}
	?>
    </td>
  </tr>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="7"><input type="hidden" name="formID" id="formID" value="sixtarget_part4" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
</table>
</form>