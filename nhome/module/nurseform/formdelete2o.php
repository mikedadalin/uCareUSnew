<?php
$db1 = new DB;
$db1->query("SELECT * FROM `nurseform02o` WHERE `targetID`='".mysql_escape_string($_GET['tID'])."'");
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
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=delete&targetID=<?php echo $targetID; ?>">
<h3>感染風險評估單</h3>
<table>
  <tr>
    <td width="40">Date</td>
    <td><script> $(function() { $( "#date_tab4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date_tab4" id="date_tab4" value="<?php echo date(Y."/".m."/".d); ?>" size="10"></td>
  </tr>
  <tr>
    <td colspan="6">
    <div id="quesdiv1">
    <h3>Urinary tract infection(UTI)</h3>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1) Not on foley (at least 3)<br /><?php echo draw_checkbox("Q1_A_1","1. Temperature ≥38ºC(100ºF) or feeling chills;2. Urethral burning sensation, urinary frequency or urgently;3. bladder area or lower back pain;4. Urine characteristic changes;5. Worsening mental or physical function",$Q1_A_1,"multi"); ?></td>
        <td valign="top">(2)Is on foley (at least 2)<br /><?php echo draw_checkbox("Q1_A_2","1. Temperature ≥38ºC(100ºF) or feeling chills;2. Bladder area or lower back pain;3. The changing status of urine (such as urine becomes turbid , malodorous, or has blood in the urine, etc.);4. Worsening mental or physical function",$Q1_A_2,"multi"); ?><br />Date of last catheter replacement:<script> $(function() { $( "#Q1_A_2_4_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1_A_2_4_date" id="Q1_A_2_4_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q1_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1_date" id="Q1_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
    </table>
    </div>
    <div id="quesdiv2">
    <h3>Respiratory tract infection (RTI)</h3>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1) The common cold syndrome (at least 2)<br /><?php echo draw_checkbox("Q2_A_1","1. Runny nose or sneezing;2. Stuffy nose;3. Sore throat, hoarse, or difficulty swallowing;4. Dry cough;5. Swollen glands in the neck or allergies",$Q2_A_1,"multi"); ?><font size="2">Note: not necessarily having a fever, but the symptoms must be newly created.</font></td>
        <td valign="top">(2) Influenza (at least 3)<br /><?php echo draw_checkbox("Q2_A_2","1. Chills;2. New generated headache or eye pain symptom;3. Muscle pain;4. Physical discomfort or loss of appetite;5. Sore throat;6. Cough newly created or worsening",$Q1_A_2,"multi"); ?><font size="2">Note: This diagnosis must be at epidemic season (late fall to early spring each year)</font></td>
      </tr>
      <tr>
        <td colspan="2">(3) Other lower respiratory tract infections - tracheitis and bronchitis (at least 3 categories)<br /><?php echo draw_checkbox("Q2_A_3","1. Newly generated cough;2. Body temperature higher than 38ºC (100ºF);3. Produce sputum;4. Sternocostal pain;5. New breath sounds found in chest physical examination (e.g. rales rhonchi wheezing bronchial-breathing);6. With one of the following changes in the state of dyspnea;　　a. Newly appeared shortness of breath;　　b. Respiratory> 25 time/minute;　　c. Worsening mental or physical function",$Q2_A_3,"multi"); ?></td>
      </tr>
    </table>
    </div>
    <div id="quesdiv3">
    <h3>Skin infection</h3>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1)Cellulitis, pressure sores, wound infection (at least one)<br /><?php echo draw_checkbox("Q3_A_1","1. Pus;2. At least 4 symptoms;　　a. Fever;　　b. Reddish;　　c. Swollen;　　d. Tenderness pain;　　e. Worsening mental or physical function;　　f. Serous secretion",$Q3_A_1,"multi"); ?></td>
        <td valign="top">(2)Other skin infections<br /><?php echo draw_checkbox("Q3_A_2","1. Blisters;2. Papules;3. Itchy skin",$Q3_A_2,"multi"); ?></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q3_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q3_date" id="Q3_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
    </table>
    </div>
    <div id="quesdiv4">
    <h3>Gastrointestinal infections</h3>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td colspan="2">At least 1<br /><?php echo draw_checkbox("Q4_A","1. Having diarrhea two or more times per day;2. Vomiting two or more times per day;3. At least 1 following symptom;　　a. Vomiting;　　b. Abdominal pain;　　c. Diarrhea",$Q4_A,"multi"); ?></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q4_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q4_date" id="Q4_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
    </table>
    </div>
    <div id="quesdiv5">
    <h3>Ear, eye, nose and mouth infection </h3>
    <table width="820" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Symptoms</font></td>
      </tr>
      <tr>
        <td valign="top">(1)Conjunctivitis (match 1)<br /><?php echo draw_checkbox("Q5_A_1","1. Pus appear in one or both eyes within 24 hours;2. New conjunctival redness (whether or itching sensation) for at least 24 hours",$Q5_A_1,"multi"); ?></td>
        <td valign="top">(2)Ear Infection (match 1)<br /><?php echo draw_checkbox("Q5_A_2","1. Physician's diagnosis;2. New secretions in 1 ear or both ears",$Q5_A_2,"multi"); ?></td>
      </tr>
      <tr>
        <td colspan="2">Visit outpatient clinic when suspected infection：<script> $(function() { $( "#Q5_date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q5_date" id="Q5_date" value="<?php echo date(Y."/".m."/".d); ?>"></td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="8">
    <input type="hidden" name="Qfiller" id="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>">
    </td>
  </tr>
  <tr>
    <td class="title" colspan="2"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="6"><input type="hidden" name="formID" id="formID" value="nurseform02o" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
</table>
</form>