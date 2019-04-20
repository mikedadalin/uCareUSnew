<script>
function loadPatInfo(tab){
	var HospNo= $("#HospNo_"+tab).val();
	$.ajax({
		url: 'class/patinfo.php',
		type: "POST",
		async: false,
		data: { med: HospNo }
	}).done(function(meds){
		medList2 = meds.split(',');
		document.getElementById('Name_'+tab).value = medList2[0]+medList2[1]+medList2[2]+medList2[3];
		if (tab=="tab1") { if (medList2[4]!="0") { document.getElementById('indate').value = medList2[4].substr(0,4) + '/' + medList2[4].substr(4,2) + '/' + medList2[4].substr(6,2); } else { document.getElementById('indate').value =''; } }
		if (tab=="tab3") {
			document.getElementById('Gender_tab3').value = medList2[5];
			document.getElementById('Age_tab3').value = medList2[6];
			document.getElementById('Diag_tab3').value = medList2[7];
			document.getElementById('ADLtotal_tab3').value = medList2[8];
		}
	});
	return medList;
}
</script>
<h3>Infection record</h3>
<table width="100%" bgcolor="#ffffff">
  <tr>
    <td valign="top" bgcolor="#ffffff">
    <div id="tab4">
    <form><input type="button" value="Add infection record" id="newrecord4" onclick="openVerificationForm('#dialog-form4');" /></form>
<script>
$(function() {
    $( "#dialog-form4" ).dialog({
		autoOpen: <?php echo ($_GET['autoOpen']==''?'false':$_GET['autoOpen']); ?>,
		height: 680,
		width: 940,
		modal: true,
		buttons: {
			"Add record": function() {
			    //document.getElementById('Qcontent').value = document.getElementById('QcontentHTML').innerHTML;
				$.ajax({
					url: "class/sixtarget_part4.php",
					type: "POST",
					data: { 'HospNo': $('#HospNo_tab4').val(), 'Name': $('#Name_tab4').val(), 'date': $('#date_tab4').val(), 'InfectType': $('#InfectType').val(), 'Q1_A_1_1': $('#Q1_A_1_1').val(), 'Q1_A_1_2': $('#Q1_A_1_2').val(), 'Q1_A_1_3': $('#Q1_A_1_3').val(), 'Q1_A_1_4': $('#Q1_A_1_4').val(), 'Q1_A_1_5': $('#Q1_A_1_5').val(), 'Q1_A_2_1': $('#Q1_A_2_1').val(), 'Q1_A_2_2': $('#Q1_A_2_2').val(), 'Q1_A_2_3': $('#Q1_A_2_3').val(), 'Q1_A_2_4': $('#Q1_A_2_4').val(), 'Q1_A_2_4_date': $('#Q1_A_2_4_date').val(), 'Q1_date': $('#Q1_date').val(), 'Q1_B_1': $('#Q1_B_1').val(), 'Q1_B_2': $('#Q1_B_2').val(), 'Q1_B_3': $('#Q1_B_3').val(), 'Q1_B_4': $('#Q1_B_4').val(), 'Q1_B_5': $('#Q1_B_5').val(), 'Q1_B_6': $('#Q1_B_6').val(), 'Q1_B_7': $('#Q1_B_7').val(), 'Q1_B_8': $('#Q1_B_8').val(), 'Q1_C_1': $('#Q1_C_1').val(), 'Q1_C_2': $('#Q1_C_2').val(), 'Q1_C_3': $('#Q1_C_3').val(), 'Q1_C_4': $('#Q1_C_4').val(), 'Q1_memo': $('#Q1_memo').val(), 'Q2_A_1_1': $('#Q2_A_1_1').val(), 'Q2_A_1_2': $('#Q2_A_1_2').val(), 'Q2_A_1_3': $('#Q2_A_1_3').val(), 'Q2_A_1_4': $('#Q2_A_1_4').val(), 'Q2_A_1_5': $('#Q2_A_1_5').val(), 'Q2_A_2_1': $('#Q2_A_2_1').val(), 'Q2_A_2_2': $('#Q2_A_2_2').val(), 'Q2_A_2_3': $('#Q2_A_2_3').val(), 'Q2_A_2_4': $('#Q2_A_2_4').val(), 'Q2_A_2_5': $('#Q2_A_2_5').val(), 'Q2_A_2_6': $('#Q2_A_2_6').val(), 'Q2_A_3_1': $('#Q2_A_3_1').val(), 'Q2_A_3_2': $('#Q2_A_3_2').val(), 'Q2_A_3_3': $('#Q2_A_3_3').val(), 'Q2_A_3_4': $('#Q2_A_3_4').val(), 'Q2_A_3_5': $('#Q2_A_3_5').val(), 'Q2_A_3_6': $('#Q2_A_3_6').val(), 'Q2_A_3_7': $('#Q2_A_3_7').val(), 'Q2_A_3_8': $('#Q2_A_3_8').val(), 'Q2_A_3_9': $('#Q2_A_3_9').val(), 'Q2_B_1': $('#Q2_B_1').val(), 'Q2_B_2': $('#Q2_B_2').val(), 'Q2_B_3': $('#Q2_B_3').val(), 'Q2_B_4': $('#Q2_B_4').val(), 'Q2_B_5': $('#Q2_B_5').val(), 'Q2_B_6': $('#Q2_B_6').val(), 'Q2_B_7': $('#Q2_B_7').val(), 'Q2_B_8': $('#Q2_B_8').val(), 'Q2_B_9': $('#Q2_B_9').val(), 'Q2_B_10': $('#Q2_B_10').val(), 'Q2_B_11': $('#Q2_B_11').val(), 'Q2_C_1': $('#Q2_C_1').val(), 'Q2_C_2': $('#Q2_C_2').val(), 'Q2_memo': $('#Q2_memo').val(), 'Q3_A_1_1': $('#Q3_A_1_1').val(), 'Q3_A_1_2': $('#Q3_A_1_2').val(), 'Q3_A_1_3': $('#Q3_A_1_3').val(), 'Q3_A_1_4': $('#Q3_A_1_4').val(), 'Q3_A_1_5': $('#Q3_A_1_5').val(), 'Q3_A_1_6': $('#Q3_A_1_6').val(), 'Q3_A_1_7': $('#Q3_A_1_7').val(), 'Q3_A_1_8': $('#Q3_A_1_8').val(), 'Q3_A_2_1': $('#Q3_A_2_1').val(), 'Q3_A_2_2': $('#Q3_A_2_2').val(), 'Q3_A_2_3': $('#Q3_A_2_3').val(), 'Q3_date': $('#Q3_date').val(), 'Q3_B_1': $('#Q3_B_1').val(), 'Q3_B_2': $('#Q3_B_2').val(), 'Q3_B_3': $('#Q3_B_3').val(), 'Q3_B_4': $('#Q3_B_4').val(), 'Q3_B_5': $('#Q3_B_5').val(), 'Q3_B_6': $('#Q3_B_6').val(), 'Q3_B_7': $('#Q3_B_7').val(), 'Q3_B_8': $('#Q3_B_8').val(), 'Q3_B_9': $('#Q3_B_9').val(), 'Q3_B_10': $('#Q3_B_10').val(), 'Q3_B_11': $('#Q3_B_11').val(), 'Q3_C_1': $('#Q3_C_1').val(), 'Q3_C_2': $('#Q3_C_2').val(), 'Q3_memo': $('#Q3_memo').val(), 'Q4_A_1': $('#Q4_A_1').val(), 'Q4_A_2': $('#Q4_A_2').val(), 'Q4_A_3': $('#Q4_A_3').val(), 'Q4_A_4': $('#Q4_A_4').val(), 'Q4_A_5': $('#Q4_A_5').val(), 'Q4_A_6': $('#Q4_A_6').val(), 'Q4_date': $('#Q4_date').val(), 'Q4_B_1': $('#Q4_B_1').val(), 'Q4_B_2': $('#Q4_B_2').val(), 'Q4_B_3': $('#Q4_B_3').val(), 'Q4_B_4': $('#Q4_B_4').val(), 'Q4_B_5': $('#Q4_B_5').val(), 'Q4_B_6': $('#Q4_B_6').val(), 'Q4_B_7': $('#Q4_B_7').val(), 'Q4_C_1': $('#Q4_C_1').val(), 'Q4_memo': $('#Q4_memo').val(), 'Q5_A_1_1': $('#Q5_A_1_1').val(), 'Q5_A_1_2': $('#Q5_A_1_2').val(), 'Q5_A_2_1': $('#Q5_A_2_1').val(), 'Q5_A_2_2': $('#Q5_A_2_2').val(), 'Q5_date': $('#Q5_date').val(), 'Q5_B_1': $('#Q5_B_1').val(), 'Q5_B_2': $('#Q5_B_2').val(), 'Q5_B_3': $('#Q5_B_3').val(), 'Q5_C_1': $('#Q5_C_1').val(), 'Q5_memo': $('#Q5_memo').val(), 'Q6_A_1_1': $('#Q6_A_1_1').val(), 'Q6_A_1_2': $('#Q6_A_1_2').val(), 'Q6_memo': $('#Q6_memo').val(), 'Q7_A_3_1': $('#Q7_A_3_1').val(), 'Q7_A_3_2': $('#Q7_A_3_2').val(), 'Q7_A_3_3': $('#Q7_A_3_3').val(), 'Q7_A_3_4': $('#Q7_A_3_4').val(), 'Q7_A_3_5': $('#Q7_A_3_5').val(), 'Q7_A_3_6': $('#Q7_A_3_6').val(), 'Q7_A_3_7': $('#Q7_A_3_7').val(), 'Q7_A_3_8': $('#Q7_A_3_8').val(), 'Q7_A_3_9': $('#Q7_A_3_9').val(), 'Q7_B_1': $('#Q7_B_1').val(), 'Q7_B_2': $('#Q7_B_2').val(), 'Q7_B_3': $('#Q7_B_3').val(), 'Q7_B_4': $('#Q7_B_4').val(), 'Q7_B_5': $('#Q7_B_5').val(), 'Q7_B_6': $('#Q7_B_6').val(), 'Q7_B_7': $('#Q7_B_7').val(), 'Q7_B_8': $('#Q7_B_8').val(), 'Q7_B_9': $('#Q7_B_9').val(), 'Q7_B_10': $('#Q7_B_10').val(), 'Q7_B_11': $('#Q7_B_11').val(), 'Q7_C_1': $('#Q7_C_1').val(), 'Q7_C_2': $('#Q7_C_2').val(), 'Q7_memo': $('#Q7_memo').val(), 'Qfiller': $('#Qfiller').val(), "transform": "1" },
					success: function(data) {
						$( "#dialog-form4" ).dialog( "close" );
						alert("Add record sucessfully!");
						window.location.reload();
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form4" ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="dialog-form4" title="Infection record log" class="dialog-form"> 
<script>
function changepart4ques(indexno) {
	for (var i=1;i<=5;i++) {
		document.getElementById('quesdiv'+i).style.display = "none";
	}
	document.getElementById('quesdiv'+indexno).style.display = "block";
}
</script>
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Care ID#</td>
        <td width="90"><input type="text" size="8" value="<?php echo getHospNoDisplayByPID($_GET['pid']); ?>" readonly><input type="hidden" name="HospNo" id="HospNo_tab4" value="<?php echo $HospNo; ?>">
        <td class="title">Full name</td>
        <td width="90"><input type="text" name="Name" id="Name_tab4" readonly  size="16"></td>
        <td class="title">Date</td>
        <td width="160"><script> $(function() { $( "#date_tab4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date_tab4" id="date_tab4" value="<?php echo date(Y."/".m."/".d); ?>" size="10"></td>
        <td class="title">Type of infection</td>
        <td>
        <select name="InfectType" id="InfectType" onchange="changepart4ques(this.selectedIndex);">
          <option></option>
          <option value="1">Urinary tract infection(UTI)</option>
          <option value="2">Respiratory tract infection (RTI)</option>
          <option value="3">Skin infection</option>
          <option value="4">Gastrointestinal infections</option>
          <option value="5">Ear, eye, nose and mouth infection </option>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="8">
        <div id="quesdiv1" style="display:none;">
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
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q1_B","Monitor temperature changes QID;Monitor urine test results;Monitor antibiotic treatment results;Increased water intake to 2000.c.c(68 fl oz) /day;Empty the bladder as much as possible - such as Q2H toileting, intermittent catheterization;Teach and assist in maintaining the vulva clean and hygiene;Correct indwelling catheter care;Replace the catheter",$Q1_B,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q1_C","Clear urine and improvement in odor;Normal body temperature;Continue to track;Mental or functional improvement",$Q1_C,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q1_memo" id="Q1_memo" size="80"></td>
          </tr>
        </table>
        </div>
        <div id="quesdiv2" style="display:none;">
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
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q2_B","Monitoring vital sign changes QID;Monitoring results of medication;Raising the headboard 30 degree when lying;Turning over and chest percussion Q2H;Nebulization therapy to improve coughing/suction efficiency;Adequate water intake;Enhance oral care;Evaluate the ability to chew and swallow;Nutritional support to enhance immunity;Oxygen therapy;Postural drainage",$Q2_B,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q2_C","Symptoms improved;Hospitalization",$Q2_C,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q2_memo" id="Q2_memo" size="80"></td>
          </tr>
        </table>
        </div>
        <div id="quesdiv3" style="display:none;">
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
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q3_B","Intermittent icing 20 minutes/time QID;Raising wounded limb;Maintaining clean skin;Moisturizing the dried skin;Wound assessment and dressing medication;Prevention of oppression on abnormal skin;Turn over Q2H;monitoring results of medication treatment;Adequate nutrition;Applying air bed and air cushion;Checking hemoglobin, albumin",$Q3_B,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q3_C","Skin recovered;Hospitalization",$Q3_C,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q3_memo" id="Q3_memo" size="80"></td>
          </tr>
        </table>
        </div>
        <div id="quesdiv4" style="display:none;">
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
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q4_B","Adequate water intake;Maintaining electrolyte balanced;Review resident's medication;Close observation of the skin status at buttocks;Monitoring results of medication;Monitoring changes in body weight;Light diet",$Q4_B,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q4_C","The number of loose stools is reduced",$Q4_C,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q4_memo" id="Q4_memo" size="80"></td>
          </tr>
        </table>
        </div>
        <div id="quesdiv5" style="display:none;">
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
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Care measures</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q5_B","Keep the affected area clean;Contact isolation;monitoring results of medication treatment",$Q5_B,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Improvement tracking</font></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo draw_checkbox("Q5_C","Secretions decrease",$Q5_C,"multi"); ?></td>
          </tr>
          <tr>
            <td bgcolor="#6699CC" colspan="2" height="30"><font color="#ffffff">Note(s):</font><input type="text" name="Q5_memo" id="Q5_memo" size="80"></td>
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
    </table>
  </fieldset>
  </form>
</div>
    <div id="tab4_part1">
    <table class="content-query" style="font-size:8pt; font-weight:normal;">
      <tr class="title">
      <td class="printcol">View</td>
      <td>Care ID#</td>
      <td>Full name</td>
      <td>Date</td>
      <td>Type of infection</td>
      <td>Infection status</td>
      <td class="printcol">Print</td>
      </tr>
    <?php
	$dbp1_4 = new DB;
	$dbp1_4->query("SELECT * FROM  `sixtarget_part4` WHERE `HospNo`='".$HospNo."'");
	if ($dbp1_4->num_rows()==0) {
	?>
      <tr>
        <td colspan="7"><center>-------Yet no data of this month-------</center></td>
      </tr>
    <?php
  } else {
  for ($p1_i4=0;$p1_i4<$dbp1_4->num_rows();$p1_i4++) {
      $rp1_4 =$dbp1_4->fetch_assoc();
	/*== 解 START ==*/
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$rp1_4['Name']);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $rp1_4['Name'] = $rp1_4['Name'].$prdpart;
            }
	    }else{
		   $rp1_4['Name'] = $rsa->privDecrypt($rp1_4['Name']);
	    }
	/*== 解 END ==*/
      $InfectType = '';
      $InfectType2 = '';
      $InfectType_a = 0;
      $InfectType_b = 0;
      $InfectType_c = 0;
      $InfectType_d = 0;
      if ($rp1_4['InfectType']==1) {
          $InfectType2 .= 'Urinary tract infection(UTI)';
          if ($rp1_4['Q1_A_1_1']==1 || $rp1_4['Q1_A_1_2']==1 || $rp1_4['Q1_A_1_3']==1 || $rp1_4['Q1_A_1_4']==1 || $rp1_4['Q1_A_1_5']==1) { $InfectType .= "No usage of catheter"; }
          if ($rp1_4['Q1_A_2_1']==1 || $rp1_4['Q1_A_2_2']==1 || $rp1_4['Q1_A_2_3']==1 || $rp1_4['Q1_A_2_4']==1) { $InfectType .= "Usage of catheter"; }
      } elseif ($rp1_4['InfectType']==2) {
          $InfectType2 .= 'Respiratory tract infection (RTI)';
          if ($rp1_4['Q2_A_1_1']==1 || $rp1_4['Q2_A_1_2']==1 || $rp1_4['Q2_A_1_3']==1 || $rp1_4['Q2_A_1_4']==1 || $rp1_4['Q2_A_1_5']==1) {
			  if ($rp1_4['Q2_A_1_1']==1) { $InfectType_a++; }
			  if ($rp1_4['Q2_A_1_2']==1) { $InfectType_a++; }
			  if ($rp1_4['Q2_A_1_3']==1) { $InfectType_a++; }
			  if ($rp1_4['Q2_A_1_4']==1) { $InfectType_a++; }
			  if ($rp1_4['Q2_A_1_5']==1) { $InfectType_a++; }
			  if ($InfectType_a>=2) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Common cold"; }
		  }
          if ($rp1_4['Q2_A_2_1']==1 || $rp1_4['Q2_A_2_2']==1 || $rp1_4['Q2_A_2_3']==1 || $rp1_4['Q2_A_2_4']==1 || $rp1_4['Q2_A_2_5']==1 || $rp1_4['Q2_A_2_6']==1) {
			  if ($rp1_4['Q2_A_2_1']==1) { $InfectType_b++; }
			  if ($rp1_4['Q2_A_2_2']==1) { $InfectType_b++; }
			  if ($rp1_4['Q2_A_2_3']==1) { $InfectType_b++; }
			  if ($rp1_4['Q2_A_2_4']==1) { $InfectType_b++; }
			  if ($rp1_4['Q2_A_2_5']==1) { $InfectType_b++; }
			  if ($rp1_4['Q2_A_2_6']==1) { $InfectType_b++; }
			  if ($InfectType_b>=3) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Influenza"; }
		  }
          if ($rp1_4['Q2_A_3_1']==1 || $rp1_4['Q2_A_3_2']==1 || $rp1_4['Q2_A_3_3']==1 || $rp1_4['Q2_A_3_4']==1 || $rp1_4['Q2_A_3_5']==1 || $rp1_4['Q2_A_3_6']==1 || $rp1_4['Q2_A_3_7']==1 || $rp1_4['Q2_A_3_8']==1 || $rp1_4['Q2_A_3_9']==1) {
			  if ($rp1_4['Q2_A_3_1']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_2']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_3']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_4']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_5']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_6']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_7']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_8']==1) { $InfectType_c++; }
			  if ($rp1_4['Q2_A_3_9']==1) { $InfectType_c++; }
			  if ($InfectType_c>=3) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Lower respiratory tract infection"; }
		  }
      } elseif ($rp1_4['InfectType']==3) {
          $InfectType2 .= 'Skin infection';
          if ($rp1_4['Q3_A_1_1']==1 || $rp1_4['Q3_A_1_2']==1 || $rp1_4['Q3_A_1_3']==1 || $rp1_4['Q3_A_1_4']==1 || $rp1_4['Q3_A_1_5']==1 || $rp1_4['Q3_A_1_6']==1 || $rp1_4['Q3_A_1_7']==1 || $rp1_4['Q3_A_1_8']==1) { $InfectType .= "Cellulitis, pressure sores, wound infection"; }
          if ($rp1_4['Q3_A_2_1']==1 || $rp1_4['Q3_A_2_2']==1 || $rp1_4['Q3_A_2_3']==1) { $InfectType .= "Other skin infection"; }
      } elseif ($rp1_4['InfectType']==4) {
          $InfectType2 .= 'Gastrointestinal infections';
      } elseif ($rp1_4['InfectType']==5) {
          $InfectType2 .= 'Ear, eye, nose and mouth infection ';
          if ($rp1_4['Q5_A_1_1']==1 || $rp1_4['Q5_A_1_2']==1) { $InfectType .= "Conjunctivitis"; }
          if ($rp1_4['Q5_A_2_1']==1 || $rp1_4['Q5_A_2_2']==1) { $InfectType .= "Ear infection"; }
      } elseif ($rp1_4['InfectType']==6) {
          $InfectType2 .= 'Scabies';
      } elseif ($rp1_4['InfectType']==7) {
          $InfectType2 .= 'Respiratory tract infection (RTI)';
		  if ($rp1_4['Q7_A_3_1']==1 || $rp1_4['Q7_A_3_2']==1 || $rp1_4['Q7_A_3_3']==1 || $rp1_4['Q7_A_3_4']==1 || $rp1_4['Q7_A_3_5']==1 || $rp1_4['Q7_A_3_6']==1 || $rp1_4['Q7_A_3_7']==1 || $rp1_4['Q7_A_3_8']==1 || $rp1_4['Q7_A_3_9']==1) {
			  if ($rp1_4['Q7_A_3_1']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_2']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_3']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_4']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_5']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_6']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_7']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_8']==1) { $InfectType_d++; }
			  if ($rp1_4['Q7_A_3_9']==1) { $InfectType_d++; }
			  if ($InfectType_d>=3) { if ($InfectType!="") { $InfectType .= "、"; } $InfectType .= "Lower respiratory tract infection"; }
		  }
	  }
  ?>
    <tr>
      <td class="printcol"><center><a href="index.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_4&date=<?php echo str_replace("/","",$rp1_4['date']); ?>&tID=<?php echo $rp1_4['targetID']; ?>"><img src="Images/folder.png" width="24" /></a></center></td>
      <td><center><?php echo getHospNoDisplayByPID(@$_GET['pid']); ?></center></td>
      <td><center><?php echo $rp1_4['Name']; ?></center></td>
      <td><center><?php echo $rp1_4['date']; ?></center></td>
      <td><center><?php echo $InfectType2; ?></center></td>
      <td><center><?php echo $InfectType; ?></center></td>
      <td class="printcol"><center><a href="print.php?mod=management&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3b_4&date=<?php echo str_replace("/","",$rp1_4['date']); ?>&tID=<?php echo $rp1_4['targetID']; ?>"><img src="Images/print.png" height="24" /></a></center></td>
    </tr>
    <?php
	}
	}
	?>
    </table>
    </div>
    </td>
  </tr>
</table><br><br>
<script>
$(document).ready( function () {
	//$('#HospNo_tab4').val('<?php echo $HospNo; ?>');
	loadPatInfo('tab4');
});
</script>