<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<script>
$(function() {
	var medicine = $("#medicine").val();
    $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 210,
		width: 480,
		modal: true,
		buttons: {
			"Add allergic drug": function() {
				$.ajax({
					url: "class/allergicmed.php",
					type: "POST",
					data: {"HospNo": $("#HospNo").val(), "drugName":$("#drugName").val() },
					success: function(data) {
						$( "#recordlist tbody" ).append( "<tr>" +
						"<td>" + data + "</td>" +  "</tr>" );
						$( "#dialog-form" ).dialog( "close" );
						alert("已經成功新增過敏藥物！");
					}
				});
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
function loadMedNames(id){
	var medicine= $("#"+id).val();
	var medList = "";
	$.ajax({
		url: 'class/med.php',
		type: "POST",
		async: false,
		data: { med: medicine}
	}).done(function(meds){
		medList = meds.split(',');
	});
	return medList;
}
function autocompleteMeds(id){
	var meds = loadMedNames(id);
	$("#"+id).autocomplete({ source: meds, minLength:3 });
}
</script>
<div id="dialog-form" title="Add allergic drug" class="dialog-form"> 
  <form>
  <fieldset>
    <table>
      <tr>
        <td class="title">Medication</td>
        <td><input type="text" name="drugName" id="drugName" value="" class="text ui-widget-content ui-corner-all" size="40" onkeyup="autocompleteMeds(this.id)" onclick="autocompleteMeds(this.id)"/></td>
      </tr>
    </table>
  </fieldset>
  </form>
</div>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save&url=<?php echo urlencode($_GET['url']); ?>">
<h3>Nursing assessment(Admission)</h3>
<table width="100%">
  <tr>
    <td width="80" class="title">Date of admission</td>
    <td><script> $(function() { $( "#inpatientinfo_indate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><p align="left"><input type="text" id="inpatientinfo_indate" name="inpatientinfo_indate" value="<?php if ($indate==NULL && $inpatientinfo_indate==NULL) { echo date('Y/m/d'); } else { echo $indate; } ?>" size="12" /><input type="text" name="Q4" id="Q4" size="2" value="<?php if ($Q4==NULL) { echo date(H); } else { echo $Q4; } ?>">:<input type="text" name="Q5" id="Q5" size="2" value="<?php if ($Q5==NULL) { echo date(i); } else { echo $Q5; } ?>"></p></td>
    <td width="80" class="title">Entered from</td>
    <td>
	<div class="formselect" style="display:inline;">
    <select name="Q6" id="Q6">
      <option></option>
      <option value="1" <?php if ($Q6==1) echo " selected"; ?>>Community</option>
      <option value="2" <?php if ($Q6==2) echo " selected"; ?>>Another nursing home or swing bed</option>
      <option value="3" <?php if ($Q6==3) echo " selected"; ?>>Acute hospital</option>
      <option value="4" <?php if ($Q6==4) echo " selected"; ?>>uCare</option>
      <option value="5" <?php if ($Q6==5) echo " selected"; ?>>Psychiatric hospital</option>
      <option value="6" <?php if ($Q6==6) echo " selected"; ?>>Inpatient rehabilitation facility</option>
      <option value="7" <?php if ($Q6==7) echo " selected"; ?>>ID/DD facility</option>
      <option value="8" <?php if ($Q6==8) echo " selected"; ?>>Hospice</option>
      <option value="9" <?php if ($Q6==9) echo " selected"; ?>>Long Term Care Hospital(LTCH)</option>
      <option value="10" <?php if ($Q6==10) echo " selected"; ?>>Other</option>
    </select>
    </div>
	</td>
  </tr>
  <tr>
    <td class="title">Admission method</td>
    <td><?php echo draw_option("Q7","On foot;wheelchair;In bed;Other","xs","multi",$Q7,true,2); ?> <input type="text" name="Q8" id="Q8" size="10" value="<?php echo $Q8; ?>"></td>
  <td class="title">Occupation</td>
    <td colspan="3"><input type="text" name="Q10" id="Q10" size="23" value="<?php echo $Q10; ?>" /><br>(Lifetime occupation(s) - put "/" between two occupations, max 23 letters)</td>
    <!--
    <td><?php echo draw_option("Q9","None;公;商;工;農;Other","s","multi",$Q9,false,5); ?> <input type="text" name="Q10" id="Q10" size="10" value="<?php echo $Q10; ?>"></td>
    -->
  </tr>
  <tr>
    <td class="title">Religion</td>
    <td><?php echo draw_option("Q11","None;Buddhism;Taoism;Christian;Catholicism;Islam;Other","sm","multi",$Q11,true,3); ?> <input type="text" name="Q12" id="Q12" size="14" value="<?php echo $Q12; ?>"></td>
    <td class="title">Education</td>
    <td><?php echo draw_option("Q14","Illiterate;Unofficial school;Elementary school;Middle school;High school;University;Grad School;Other","sl","single",$Q14,true,3); ?> <input type="text" name="Q14a" id="Q14a" size="14" value="<?php echo $Q14a; ?>"></td>
  </tr>
  <tr>
    <td class="title">Marital Status</td>
    <td><?php echo draw_option("Q15","Never;Married;Widowed;Separated;Divorced","sm","single",$Q15,true,3); ?>
    <td class="title">Medical insurance (payer)</td>
    <td><?php echo draw_option("Q17","Medicare/Medicaid;Self-paid;Private insurance;Other","l","multi",$Q17,true,2); ?> <input type="text" name="Q18" id="Q18" size="14" value="<?php echo $Q18; ?>"></td>
  </tr>
  <tr>
    <td class="title">Primary caregiver</td>
    <td colspan="3"><?php echo draw_option("Q19","None;Spouse;Son;Daughter in law;Daughter;Grandson;Relative;Friend;Personal aide;Other","xm","multi",$Q19,true,6); ?> <input type="text" name="Q20" id="Q20" size="14" value="<?php echo $Q20; ?>"></td>
  </tr>
  <tr>
    <td class="title">Major medical decision maker</td>
    <td colspan="3"><?php echo draw_option("Q114","Oneself;Spouse;Offspring;Other","m","multi",$Q114,false,2); ?> <input type="text" name="Q114a" id="Q114a" size="14" value="<?php echo $Q114a; ?>"></td>
  </tr>
  <tr>
    <td class="title">Special care project</td>
    <td colspan="3"><?php echo draw_option("Q115","Phlegm;Aspiration of sputum;Nasogastric tube;Catheter;Wound dressing;Emotional instability","l","multi",$Q115,true,3); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="80" rowspan="14" class="title">Health<br>cognitive<br>processing</td>
    <td class="title_s" width="80">Active Diagnoses in the last 7 days - Check all that apply</td>
    <td colspan="3"><?php echo draw_option("Q21","None;Diabetes;Hypertension;Stroke;Stroke(Left);Stroke(Right);Heart disease;Kidney disease;Liver disease;Dementia;Asthma;Parkinson's disease;Benign prostatic hyperplasia;Mental illness;Cancer;Other","xl","multi",$Q21,true,3); ?> <input type="text" name="Q22" id="Q22" size="14"  value="<?php echo $Q22; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Number of hospitalization(s)</td>
    <td colspan="3"><?php echo draw_option("Q23","None;Yes","s","multi",$Q23,true,6); ?><br> <input type="text" name="Q23a" id="Q23a" size="3"  value="<?php echo $Q23a; ?>" />time(s), caused by<?php echo draw_option("Q23c","Respiratory tract infection (RTI);Urinary tract infection(UTI);Unexplained fever;Gastrointestinal bleeding;Stroke;Poor blood glucose control;Cardiovascular disease;Asthma / COPD;Fracture;Other","xxl","multi",$Q23c,false,3); ?><input type="text" name="Q23b" id="Q23b" size="24"  value="<?php echo $Q23b; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Surgery/Major operation</td>
    <td colspan="3"><?php echo draw_option("Q24","None;Yes","s","multi",$Q24,true,6); ?> <input type="text" name="Q24a" id="Q24a" size="3"  value="<?php echo $Q24a; ?>" />time(s), caused by<input type="text" name="Q24b" id="Q24b" size="30"  value="<?php echo $Q24b; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Tobacco usage</td>
    <td colspan="3"><?php echo draw_option("Q28","None;Yes","s","single",$Q28,false,6); ?> Daily<input type="text" name="Q29" id="Q29" size="3" value="<?php echo $Q29; ?>" />pack(s),for<input type="text" name="Q30" id="Q30" size="3" value="<?php echo $Q30; ?>" />years,quit for<input type="text" name="Q30quit" id="Q30quit" size="3" value="<?php echo $Q30quit; ?>" />year(s)</td>
  </tr>
  <tr>
    <td class="title_s">Alcohol usage</td>
    <td colspan="3"><?php echo draw_option("Q31","No;Occasionally;Frequently;Daily","m","single",$Q31,false,6); ?> Totally<input type="text" name="Q32" id="Q32" size="3" value="<?php echo $Q32; ?>" /> <select name="Q33" id="Q33"><option value="1" <?php if($Q33==1) { echo "selected"; } ?>>Bottle(s)/day</option><option value="2" <?php if($Q33==2) { echo "selected"; } ?>>Cup(s)/day</option></select></td>
  </tr>
  <tr>
    <td class="title_s">Betel nut usage</td>
    <td colspan="3"><?php echo draw_option("Q117","No usage;occasionally;Frequently","m","single",$Q117,false,6); ?> <input type="text" name="Q117a" id="Q117a" size="3" value="<?php echo $Q117a; ?>" /> Pcs / day</td>
  </tr>
  <tr>
    <td class="title_s">Food allergy</td>
	<?php
	$sql = "SELECT `Q35_1`,`Q35_2`,`Q35a` FROM `socialform33` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
	$db3 = new DB;
	$db3->query($sql);
	$r3 = $db3->fetch_assoc();
	if ($db3->num_rows()>0) {
		foreach ($r3 as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${'socialform33_'.$arrAnswer[0]} = $arrAnswer[1];
					}
				} else {
					${'socialform33_'.$k} = $v;
				}
			}
		}
	}
	if($Q34==""){ $Q34 = $socialform33_Q35;}
	if($Q35==""){ $Q35 = $socialform33_Q35a;}
	?>
    <td colspan="3"><?php echo draw_option("Q34","None;Yes","s","single",$Q34,false,6); ?> <input type="text" name="Q35" id="Q35" size="60" value="<?php echo $Q35; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Drug allergy</td>
    <td colspan="3">
      <input type="button" id="newrecord" name="newrecord" value="Add allergic drug" onclick="openVerificationForm('#dialog-form');" /><br />
      <table width="100%" id="recordlist" class="tableinside">
        <tbody>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td class="title_s">Immunization (Vaccine)</td>
    <td colspan="3"><?php echo draw_option("Q113","None;Flu shot;Streptococcus pneumoniae","xl","multi",$Q113,false,6); ?> (Year: <input type="text" name="Q113a" id="Q113a" size="6" value="<?php echo $Q113a; ?>" /> )</td>
  </tr>
  <tr>
    <td rowspan="4" class="title_s">Current<br>medications</td>
    <td>Western medicine</td>
    <td colspan="2"><?php echo draw_option("Q38","None;Yes","s","multi",$Q38,false,6); ?></td>
  </tr>
  <tr>
    <td>Medication type</td>
    <td colspan="2"><?php echo draw_option("Q39","Diabetes;Hypertension;Heart disease;Arthritis;Gastrointestinal tract;Hyperlipidemia;Stroke;Respiratory tract;Analgesic/Antiphlogistic medication;Other","xxl","multi",$Q39,true,2); ?> <input type="text" name="Q40" id="Q40" size="24" value="<?php echo $Q40; ?>" /></td>
  </tr>
  <tr>
    <td>Chinese medicine</td>
    <td colspan="2"><?php echo draw_option("Q41","None;Yes","s","multi",$Q41,false,6); ?></td>
  </tr>
  <tr>
    <td>Medication type</td>
    <td colspan="2"><?php echo draw_option("Q42","Diabetes;Hypertension;Heart disease;Arthritis;Gastrointestinal tract;Hyperlipidemia;Stroke;Respiratory tract;Analgesic/Antiphlogistic medication;Other","xxl","multi",$Q42,true,2); ?> <input type="text" name="Q43" id="Q43" size="24" value="<?php echo $Q43; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Reason of admission (This time)</td>
    <td colspan="3"><input type="text" name="Q44" id="Q44" size="60" value="<?php echo $Q44; ?>" /></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Skin<br>condition</td>
    <td class="title_s">Skin</td>
    <td colspan="3"><?php echo draw_option("Q45","Normal;Pale;Jaundice;Pigmentation;Dehydration;Edema;Itchy;Abnormal nail;Sparse hair;Loss of hair;Skin allergy;Eczema;Fungal infection;Suspected scabies;Other","xm","multi",$Q45,true,5); ?> <input type="text" name="Q46" id="Q46" size="40" value="<?php echo $Q46; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Wound</td>
    <td><?php echo draw_option("Q47","None;Yes","s","multi",$Q47,false,6); ?></td>
    <!--<td colspan="2">程度：<?php echo draw_option("Q48","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","m","multi",$Q48,false,6); ?><br />大小：<input type="text" name="Q49" id="Q49" size="12" value="<?php echo $Q49; ?>" /> part(s):<input type="text" name="Q50" id="Q50" size="12" value="<?php echo $Q50; ?>" /></td>-->
    <td colspan="2">
	Part:
	<div class="formselect" style="display:inline;">
    <select name="Q48a" id="Q48a">
	  <?php if($tabsID==0){$Q48a=""; $Q48b=""; $Q48c=""; $Q48d=""; $Q49a=""; $Q49b=""; $Q49c=""; $Q49d=""; $Q50a=""; $Q50b=""; $Q50c=""; $Q50d="";} ; ?>
      <option></option>
      <option value="1" <?php if ($Q48a==1) echo " selected"; ?>>Forehead</option>
      <option value="2" <?php if ($Q48a==2) echo " selected"; ?>>Nose</option>
      <option value="3" <?php if ($Q48a==3) echo " selected"; ?>>Chin</option>
      <option value="4" <?php if ($Q48a==4) echo " selected"; ?>>Outer ear</option>
      <option value="5" <?php if ($Q48a==5) echo " selected"; ?>>Occipital</option>
      <option value="6" <?php if ($Q48a==6) echo " selected"; ?>>Breast</option>
      <option value="7" <?php if ($Q48a==7) echo " selected"; ?>>Chest</option>
      <option value="8" <?php if ($Q48a==8) echo " selected"; ?>>Rib cage</option>
      <option value="9" <?php if ($Q48a==9) echo " selected"; ?>>Costal arch</option>
      <option value="10" <?php if ($Q48a==10) echo " selected"; ?>>Scapula</option>
	  <option value="11" <?php if ($Q48a==11) echo " selected"; ?>>Humerus</option>
	  <option value="12" <?php if ($Q48a==12) echo " selected"; ?>>Elbow</option>
	  <option value="13" <?php if ($Q48a==13) echo " selected"; ?>>Abdomen</option>
	  <option value="14" <?php if ($Q48a==14) echo " selected"; ?>>Spine protruding spot</option>
	  <option value="15" <?php if ($Q48a==15) echo " selected"; ?>>Scrotum</option>
	  <option value="16" <?php if ($Q48a==16) echo " selected"; ?>>Perineum</option>
	  <option value="17" <?php if ($Q48a==17) echo " selected"; ?>>Sacral vertebrae</option>
	  <option value="18" <?php if ($Q48a==18) echo " selected"; ?>>Buttock</option>
	  <option value="19" <?php if ($Q48a==19) echo " selected"; ?>>Hip ridge</option>
	  <option value="20" <?php if ($Q48a==20) echo " selected"; ?>>Ischial tuberosity</option>
	  <option value="21" <?php if ($Q48a==21) echo " selected"; ?>>Front knee</option>
	  <option value="22" <?php if ($Q48a==22) echo " selected"; ?>>Medial knee</option>
	  <option value="23" <?php if ($Q48a==23) echo " selected"; ?>>Fibula</option>
	  <option value="24" <?php if ($Q48a==24) echo " selected"; ?>>Lateral ankle</option>
	  <option value="25" <?php if ($Q48a==25) echo " selected"; ?>>Inner ankle</option>
	  <option value="26" <?php if ($Q48a==26) echo " selected"; ?>>Heel</option>
	  <option value="27" <?php if ($Q48a==27) echo " selected"; ?>>Toe</option>
	  <option value="28" <?php if ($Q48a==28) echo " selected"; ?>>Plantar</option>
	  <option value="29" <?php if ($Q48a==29) echo " selected"; ?>>Intertrochanteric</option>
	  <option value="30" <?php if ($Q48a==30) echo " selected"; ?>>Other</option>
    </select>
    </div>
	Type:
	<div class="formselect" style="display:inline;">
    <select name="Q48b" id="Q48b">
      <option></option>
      <option value="1" <?php if ($Q48b==1) echo " selected"; ?>>General</option>
      <option value="2" <?php if ($Q48b==2) echo " selected"; ?>>Surgical wound</option>
      <option value="3" <?php if ($Q48b==3) echo " selected"; ?>>Ulcers</option>
      <option value="4" <?php if ($Q48b==4) echo " selected"; ?>>Diabetic foot ulcer</option>
      <option value="5" <?php if ($Q48b==5) echo " selected"; ?>>Skin tear</option>
      <option value="6" <?php if ($Q48b==6) echo " selected"; ?>>MASD</option>
      <option value="7" <?php if ($Q48b==7) echo " selected"; ?>>Burn</option>
    </select>
    </div>
	Generated date:<script> $(function() { $( "#Q48c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q48c" name="Q48c" value="<?php if ($Q48c==NULL) { echo formatdate($Q48c); } else { echo $Q48c; } ?>" size="8" /><!--<?php echo draw_option("Q48d","Unknow","s","single",$Q48d,false,0); ?>-->
	<br>
	Part:
	<div class="formselect" style="display:inline;">
    <select name="Q49a" id="Q49a">
      <option></option>
      <option value="1" <?php if ($Q49a==1) echo " selected"; ?>>Forehead</option>
      <option value="2" <?php if ($Q49a==2) echo " selected"; ?>>Nose</option>
      <option value="3" <?php if ($Q49a==3) echo " selected"; ?>>Chin</option>
      <option value="4" <?php if ($Q49a==4) echo " selected"; ?>>Outer ear</option>
      <option value="5" <?php if ($Q49a==5) echo " selected"; ?>>Occipital</option>
      <option value="6" <?php if ($Q49a==6) echo " selected"; ?>>Breast</option>
      <option value="7" <?php if ($Q49a==7) echo " selected"; ?>>Chest</option>
      <option value="8" <?php if ($Q49a==8) echo " selected"; ?>>Rib cage</option>
      <option value="9" <?php if ($Q49a==9) echo " selected"; ?>>Costal arch</option>
      <option value="10" <?php if ($Q49a==10) echo " selected"; ?>>Scapula</option>
	  <option value="11" <?php if ($Q49a==11) echo " selected"; ?>>Humerus</option>
	  <option value="12" <?php if ($Q49a==12) echo " selected"; ?>>Elbow</option>
	  <option value="13" <?php if ($Q49a==13) echo " selected"; ?>>Abdomen</option>
	  <option value="14" <?php if ($Q49a==14) echo " selected"; ?>>Spine protruding spot</option>
	  <option value="15" <?php if ($Q49a==15) echo " selected"; ?>>Scrotum</option>
	  <option value="16" <?php if ($Q49a==16) echo " selected"; ?>>Perineum</option>
	  <option value="17" <?php if ($Q49a==17) echo " selected"; ?>>Sacral vertebrae</option>
	  <option value="18" <?php if ($Q49a==18) echo " selected"; ?>>Buttock</option>
	  <option value="19" <?php if ($Q49a==19) echo " selected"; ?>>Hip ridge</option>
	  <option value="20" <?php if ($Q49a==20) echo " selected"; ?>>Ischial tuberosity</option>
	  <option value="21" <?php if ($Q49a==21) echo " selected"; ?>>Front knee</option>
	  <option value="22" <?php if ($Q49a==22) echo " selected"; ?>>Medial knee</option>
	  <option value="23" <?php if ($Q49a==23) echo " selected"; ?>>Fibula</option>
	  <option value="24" <?php if ($Q49a==24) echo " selected"; ?>>Lateral ankle</option>
	  <option value="25" <?php if ($Q49a==25) echo " selected"; ?>>Inner ankle</option>
	  <option value="26" <?php if ($Q49a==26) echo " selected"; ?>>Heel</option>
	  <option value="27" <?php if ($Q49a==27) echo " selected"; ?>>Toe</option>
	  <option value="28" <?php if ($Q49a==28) echo " selected"; ?>>Plantar</option>
	  <option value="29" <?php if ($Q49a==29) echo " selected"; ?>>Intertrochanteric</option>
	  <option value="30" <?php if ($Q49a==30) echo " selected"; ?>>Other</option>
    </select>
    </div>
	Type:
	<div class="formselect" style="display:inline;">
    <select name="Q49b" id="Q49b">
      <option></option>
      <option value="1" <?php if ($Q49b==1) echo " selected"; ?>>General</option>
      <option value="2" <?php if ($Q49b==2) echo " selected"; ?>>Surgical wound</option>
      <option value="3" <?php if ($Q49b==3) echo " selected"; ?>>Ulcers</option>
      <option value="4" <?php if ($Q49b==4) echo " selected"; ?>>Diabetic foot ulcer</option>
      <option value="5" <?php if ($Q49b==5) echo " selected"; ?>>Skin tear</option>
      <option value="6" <?php if ($Q49b==6) echo " selected"; ?>>MASD</option>
      <option value="7" <?php if ($Q49b==7) echo " selected"; ?>>Burn</option>
    </select>
    </div>
	Generated date:<script> $(function() { $( "#Q49c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q49c" name="Q49c" value="<?php if ($Q49c==NULL) { echo formatdate($Q49c); } else { echo $Q49c; } ?>" size="8" /><!--<?php echo draw_option("Q49d","Unknow","s","single",$Q49d,false,0); ?>-->
	<br>
	Part:
	<div class="formselect" style="display:inline;">
    <select name="Q50a" id="Q50a">
      <option></option>
      <option value="1" <?php if ($Q50a==1) echo " selected"; ?>>Forehead</option>
      <option value="2" <?php if ($Q50a==2) echo " selected"; ?>>Nose</option>
      <option value="3" <?php if ($Q50a==3) echo " selected"; ?>>Chin</option>
      <option value="4" <?php if ($Q50a==4) echo " selected"; ?>>Outer ear</option>
      <option value="5" <?php if ($Q50a==5) echo " selected"; ?>>Occipital</option>
      <option value="6" <?php if ($Q50a==6) echo " selected"; ?>>Breast</option>
      <option value="7" <?php if ($Q50a==7) echo " selected"; ?>>Chest</option>
      <option value="8" <?php if ($Q50a==8) echo " selected"; ?>>Rib cage</option>
      <option value="9" <?php if ($Q50a==9) echo " selected"; ?>>Costal arch</option>
      <option value="10" <?php if ($Q50a==10) echo " selected"; ?>>Scapula</option>
	  <option value="11" <?php if ($Q50a==11) echo " selected"; ?>>Humerus</option>
	  <option value="12" <?php if ($Q50a==12) echo " selected"; ?>>Elbow</option>
	  <option value="13" <?php if ($Q50a==13) echo " selected"; ?>>Abdomen</option>
	  <option value="14" <?php if ($Q50a==14) echo " selected"; ?>>Spine protruding spot</option>
	  <option value="15" <?php if ($Q50a==15) echo " selected"; ?>>Scrotum</option>
	  <option value="16" <?php if ($Q50a==16) echo " selected"; ?>>Perineum</option>
	  <option value="17" <?php if ($Q50a==17) echo " selected"; ?>>Sacral vertebrae</option>
	  <option value="18" <?php if ($Q50a==18) echo " selected"; ?>>Buttock</option>
	  <option value="19" <?php if ($Q50a==19) echo " selected"; ?>>Hip ridge</option>
	  <option value="20" <?php if ($Q50a==20) echo " selected"; ?>>Ischial tuberosity</option>
	  <option value="21" <?php if ($Q50a==21) echo " selected"; ?>>Front knee</option>
	  <option value="22" <?php if ($Q50a==22) echo " selected"; ?>>Medial knee</option>
	  <option value="23" <?php if ($Q50a==23) echo " selected"; ?>>Fibula</option>
	  <option value="24" <?php if ($Q50a==24) echo " selected"; ?>>Lateral ankle</option>
	  <option value="25" <?php if ($Q50a==25) echo " selected"; ?>>Inner ankle</option>
	  <option value="26" <?php if ($Q50a==26) echo " selected"; ?>>Heel</option>
	  <option value="27" <?php if ($Q50a==27) echo " selected"; ?>>Toe</option>
	  <option value="28" <?php if ($Q50a==28) echo " selected"; ?>>Plantar</option>
	  <option value="29" <?php if ($Q50a==29) echo " selected"; ?>>Intertrochanteric</option>
	  <option value="30" <?php if ($Q50a==30) echo " selected"; ?>>Other</option>
    </select>
    </div>
	Type:
	<div class="formselect" style="display:inline;">
    <select name="Q50b" id="Q50b">
      <option></option>
      <option value="1" <?php if ($Q50b==1) echo " selected"; ?>>General</option>
      <option value="2" <?php if ($Q50b==2) echo " selected"; ?>>Surgical wound</option>
      <option value="3" <?php if ($Q50b==3) echo " selected"; ?>>Ulcers</option>
      <option value="4" <?php if ($Q50b==4) echo " selected"; ?>>Diabetic foot ulcer</option>
      <option value="5" <?php if ($Q50b==5) echo " selected"; ?>>Skin tear</option>
      <option value="6" <?php if ($Q50b==6) echo " selected"; ?>>MASD</option>
      <option value="7" <?php if ($Q50b==7) echo " selected"; ?>>Burn</option>
    </select>
    </div>
	Generated date:<script> $(function() { $( "#Q50c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q50c" name="Q50c" value="<?php if ($Q50c==NULL) { echo formatdate($Q50c); } else { echo $Q50c; } ?>" size="8" /><!--<?php echo draw_option("Q50d","Unknow","s","single",$Q50d,false,0); ?>-->
	</td>
  </tr>
  <tr>
    <td class="title_s">Pressure ulcer(s)</td>

    <td><?php echo draw_option("Q51","None;Has","s","multi",$Q51,false,6); ?></td>

    <td colspan="2">
	Part:
	<div class="formselect" style="display:inline;">
    <select name="Q52a" id="Q52a">
	  <?php if($tabsID==0){$Q52a=""; $Q52b=""; $Q52c=""; $Q52d=""; $Q53a=""; $Q53b=""; $Q53c=""; $Q53d=""; $Q54a=""; $Q54b=""; $Q54c=""; $Q54d="";} ; ?>
      <option></option>
      <option value="1" <?php if ($Q52a==1) echo " selected"; ?>>Forehead</option>
      <option value="2" <?php if ($Q52a==2) echo " selected"; ?>>Nose</option>
      <option value="3" <?php if ($Q52a==3) echo " selected"; ?>>Chin</option>
      <option value="4" <?php if ($Q52a==4) echo " selected"; ?>>Outer ear</option>
      <option value="5" <?php if ($Q52a==5) echo " selected"; ?>>Occipital</option>
      <option value="6" <?php if ($Q52a==6) echo " selected"; ?>>Breast</option>
      <option value="7" <?php if ($Q52a==7) echo " selected"; ?>>Chest</option>
      <option value="8" <?php if ($Q52a==8) echo " selected"; ?>>Rib cage</option>
      <option value="9" <?php if ($Q52a==9) echo " selected"; ?>>Costal arch</option>
      <option value="10" <?php if ($Q52a==10) echo " selected"; ?>>Scapula</option>
	  <option value="11" <?php if ($Q52a==11) echo " selected"; ?>>Humerus</option>
	  <option value="12" <?php if ($Q52a==12) echo " selected"; ?>>Elbow</option>
	  <option value="13" <?php if ($Q52a==13) echo " selected"; ?>>Abdomen</option>
	  <option value="14" <?php if ($Q52a==14) echo " selected"; ?>>Spine protruding spot</option>
	  <option value="15" <?php if ($Q52a==15) echo " selected"; ?>>Scrotum</option>
	  <option value="16" <?php if ($Q52a==16) echo " selected"; ?>>Perineum</option>
	  <option value="17" <?php if ($Q52a==17) echo " selected"; ?>>Sacral vertebrae</option>
	  <option value="18" <?php if ($Q52a==18) echo " selected"; ?>>Buttock</option>
	  <option value="19" <?php if ($Q52a==19) echo " selected"; ?>>Hip ridge</option>
	  <option value="20" <?php if ($Q52a==20) echo " selected"; ?>>Ischial tuberosity</option>
	  <option value="21" <?php if ($Q52a==21) echo " selected"; ?>>Front knee</option>
	  <option value="22" <?php if ($Q52a==22) echo " selected"; ?>>Medial knee</option>
	  <option value="23" <?php if ($Q52a==23) echo " selected"; ?>>Fibula</option>
	  <option value="24" <?php if ($Q52a==24) echo " selected"; ?>>Lateral ankle</option>
	  <option value="25" <?php if ($Q52a==25) echo " selected"; ?>>Inner ankle</option>
	  <option value="26" <?php if ($Q52a==26) echo " selected"; ?>>Heel</option>
	  <option value="27" <?php if ($Q52a==27) echo " selected"; ?>>Toe</option>
	  <option value="28" <?php if ($Q52a==28) echo " selected"; ?>>Plantar</option>
	  <option value="29" <?php if ($Q52a==29) echo " selected"; ?>>Intertrochanteric</option>
	  <option value="30" <?php if ($Q52a==30) echo " selected"; ?>>Other</option>
    </select>
    </div>
	Stage:
	<div class="formselect" style="display:inline;">
    <select name="Q52b" id="Q52b">
      <option></option>
      <option value="1" <?php if ($Q52b==1) echo " selected"; ?>>Stage 1</option>
      <option value="2" <?php if ($Q52b==2) echo " selected"; ?>>Stage 2</option>
      <option value="3" <?php if ($Q52b==3) echo " selected"; ?>>Stage 3</option>
      <option value="4" <?php if ($Q52b==4) echo " selected"; ?>>Stage 4</option>
      <option value="5" <?php if ($Q52b==5) echo " selected"; ?>>Non-removable dressing</option>
      <option value="6" <?php if ($Q52b==6) echo " selected"; ?>>Slough and/or eschar</option>
      <option value="7" <?php if ($Q52b==7) echo " selected"; ?>>Deep tissue</option>
    </select>
    </div>
	Generated date:<script> $(function() { $( "#Q52c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q52c" name="Q52c" value="<?php if ($Q52c==NULL) { echo formatdate($Q52c); } else { echo $Q52c; } ?>" size="8" /><!--<?php echo draw_option("Q52d","Unknow","s","single",$Q52d,false,0); ?>-->
	<br>
	Part:
	<div class="formselect" style="display:inline;">
    <select name="Q53a" id="Q53a">
      <option></option>
      <option value="1" <?php if ($Q53a==1) echo " selected"; ?>>Forehead</option>
      <option value="2" <?php if ($Q53a==2) echo " selected"; ?>>Nose</option>
      <option value="3" <?php if ($Q53a==3) echo " selected"; ?>>Chin</option>
      <option value="4" <?php if ($Q53a==4) echo " selected"; ?>>Outer ear</option>
      <option value="5" <?php if ($Q53a==5) echo " selected"; ?>>Occipital</option>
      <option value="6" <?php if ($Q53a==6) echo " selected"; ?>>Breast</option>
      <option value="7" <?php if ($Q53a==7) echo " selected"; ?>>Chest</option>
      <option value="8" <?php if ($Q53a==8) echo " selected"; ?>>Rib cage</option>
      <option value="9" <?php if ($Q53a==9) echo " selected"; ?>>Costal arch</option>
      <option value="10" <?php if ($Q53a==10) echo " selected"; ?>>Scapula</option>
	  <option value="11" <?php if ($Q53a==11) echo " selected"; ?>>Humerus</option>
	  <option value="12" <?php if ($Q53a==12) echo " selected"; ?>>Elbow</option>
	  <option value="13" <?php if ($Q53a==13) echo " selected"; ?>>Abdomen</option>
	  <option value="14" <?php if ($Q53a==14) echo " selected"; ?>>Spine protruding spot</option>
	  <option value="15" <?php if ($Q53a==15) echo " selected"; ?>>Scrotum</option>
	  <option value="16" <?php if ($Q53a==16) echo " selected"; ?>>Perineum</option>
	  <option value="17" <?php if ($Q53a==17) echo " selected"; ?>>Sacral vertebrae</option>
	  <option value="18" <?php if ($Q53a==18) echo " selected"; ?>>Buttock</option>
	  <option value="19" <?php if ($Q53a==19) echo " selected"; ?>>Hip ridge</option>
	  <option value="20" <?php if ($Q53a==20) echo " selected"; ?>>Ischial tuberosity</option>
	  <option value="21" <?php if ($Q53a==21) echo " selected"; ?>>Front knee</option>
	  <option value="22" <?php if ($Q53a==22) echo " selected"; ?>>Medial knee</option>
	  <option value="23" <?php if ($Q53a==23) echo " selected"; ?>>Fibula</option>
	  <option value="24" <?php if ($Q53a==24) echo " selected"; ?>>Lateral ankle</option>
	  <option value="25" <?php if ($Q53a==25) echo " selected"; ?>>Inner ankle</option>
	  <option value="26" <?php if ($Q53a==26) echo " selected"; ?>>Heel</option>
	  <option value="27" <?php if ($Q53a==27) echo " selected"; ?>>Toe</option>
	  <option value="28" <?php if ($Q53a==28) echo " selected"; ?>>Plantar</option>
	  <option value="29" <?php if ($Q53a==29) echo " selected"; ?>>Intertrochanteric</option>
	  <option value="30" <?php if ($Q53a==30) echo " selected"; ?>>Other</option>
    </select>
    </div>
	Stage:
	<div class="formselect" style="display:inline;">
    <select name="Q53b" id="Q53b">
      <option></option>
      <option value="1" <?php if ($Q53b==1) echo " selected"; ?>>Stage 1</option>
      <option value="2" <?php if ($Q53b==2) echo " selected"; ?>>Stage 2</option>
      <option value="3" <?php if ($Q53b==3) echo " selected"; ?>>Stage 3</option>
      <option value="4" <?php if ($Q53b==4) echo " selected"; ?>>Stage 4</option>
      <option value="5" <?php if ($Q53b==5) echo " selected"; ?>>Non-removable dressing</option>
      <option value="6" <?php if ($Q53b==6) echo " selected"; ?>>Slough and/or eschar</option>
      <option value="7" <?php if ($Q53b==7) echo " selected"; ?>>Deep tissue</option>
    </select>
    </div>
	Generated date:<script> $(function() { $( "#Q53c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q53c" name="Q53c" value="<?php if ($Q53c==NULL) { echo formatdate($Q53c); } else { echo $Q53c; } ?>" size="8" /><!--<?php echo draw_option("Q53d","Unknow","s","single",$Q53d,false,0); ?>-->
	<br>
	Part:
	<div class="formselect" style="display:inline;">
    <select name="Q54a" id="Q54a">
      <option></option>
      <option value="1" <?php if ($Q54a==1) echo " selected"; ?>>Forehead</option>
      <option value="2" <?php if ($Q54a==2) echo " selected"; ?>>Nose</option>
      <option value="3" <?php if ($Q54a==3) echo " selected"; ?>>Chin</option>
      <option value="4" <?php if ($Q54a==4) echo " selected"; ?>>Outer ear</option>
      <option value="5" <?php if ($Q54a==5) echo " selected"; ?>>Occipital</option>
      <option value="6" <?php if ($Q54a==6) echo " selected"; ?>>Breast</option>
      <option value="7" <?php if ($Q54a==7) echo " selected"; ?>>Chest</option>
      <option value="8" <?php if ($Q54a==8) echo " selected"; ?>>Rib cage</option>
      <option value="9" <?php if ($Q54a==9) echo " selected"; ?>>Costal arch</option>
      <option value="10" <?php if ($Q54a==10) echo " selected"; ?>>Scapula</option>
	  <option value="11" <?php if ($Q54a==11) echo " selected"; ?>>Humerus</option>
	  <option value="12" <?php if ($Q54a==12) echo " selected"; ?>>Elbow</option>
	  <option value="13" <?php if ($Q54a==13) echo " selected"; ?>>Abdomen</option>
	  <option value="14" <?php if ($Q54a==14) echo " selected"; ?>>Spine protruding spot</option>
	  <option value="15" <?php if ($Q54a==15) echo " selected"; ?>>Scrotum</option>
	  <option value="16" <?php if ($Q54a==16) echo " selected"; ?>>Perineum</option>
	  <option value="17" <?php if ($Q54a==17) echo " selected"; ?>>Sacral vertebrae</option>
	  <option value="18" <?php if ($Q54a==18) echo " selected"; ?>>Buttock</option>
	  <option value="19" <?php if ($Q54a==19) echo " selected"; ?>>Hip ridge</option>
	  <option value="20" <?php if ($Q54a==20) echo " selected"; ?>>Ischial tuberosity</option>
	  <option value="21" <?php if ($Q54a==21) echo " selected"; ?>>Front knee</option>
	  <option value="22" <?php if ($Q54a==22) echo " selected"; ?>>Medial knee</option>
	  <option value="23" <?php if ($Q54a==23) echo " selected"; ?>>Fibula</option>
	  <option value="24" <?php if ($Q54a==24) echo " selected"; ?>>Lateral ankle</option>
	  <option value="25" <?php if ($Q54a==25) echo " selected"; ?>>Inner ankle</option>
	  <option value="26" <?php if ($Q54a==26) echo " selected"; ?>>Heel</option>
	  <option value="27" <?php if ($Q54a==27) echo " selected"; ?>>Toe</option>
	  <option value="28" <?php if ($Q54a==28) echo " selected"; ?>>Plantar</option>
	  <option value="29" <?php if ($Q54a==29) echo " selected"; ?>>Intertrochanteric</option>
	  <option value="30" <?php if ($Q54a==30) echo " selected"; ?>>Other</option>
    </select>
    </div>
	Stage:
	<div class="formselect" style="display:inline;">
    <select name="Q54b" id="Q54b">
      <option></option>
      <option value="1" <?php if ($Q54b==1) echo " selected"; ?>>Stage 1</option>
      <option value="2" <?php if ($Q54b==2) echo " selected"; ?>>Stage 2</option>
      <option value="3" <?php if ($Q54b==3) echo " selected"; ?>>Stage 3</option>
      <option value="4" <?php if ($Q54b==4) echo " selected"; ?>>Stage 4</option>
      <option value="5" <?php if ($Q54b==5) echo " selected"; ?>>Non-removable dressing</option>
      <option value="6" <?php if ($Q54b==6) echo " selected"; ?>>Slough and/or eschar</option>
      <option value="7" <?php if ($Q54b==7) echo " selected"; ?>>Deep tissue</option>
    </select>
    </div>
	Generated date:<script> $(function() { $( "#Q54c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q54c" name="Q54c" value="<?php if ($Q54c==NULL) { echo formatdate($Q54c); } else { echo $Q54c; } ?>" size="8" /><!--<?php echo draw_option("Q54d","Unknow","s","single",$Q54d,false,0); ?>-->
	</td>

  </tr>
  <tr>
    <td rowspan="11" class="title">Activity</td>
    <td class="title_s">Mobility</td>
    <td colspan="3"><?php echo draw_option("Q55","Normal;Decline","xs","multi",$Q55,false,0); ?></td>
  </tr>
  <tr>
    <td rowspan="4" class="title_s">Muscle<br /> strength</td>
    <td>Right hand</td>
    <td><?php echo draw_option("Q56","0;1;2;3;4;5","s","multi",$Q56,true,2); ?></td>
    <td rowspan="4"><p>0 = no muscle contraction &nbsp;<br />1+=&nbsp Muscle flicker, but no movement &nbsp;<br />2+= Movement possible, but not against gravity (test the joint in its horizontal plane) <br />3+= Movement possible against gravity, but not against resistance by the examiner <br />4+= Movement possible against some resistance by the examiner  <br />5+= Normal strength (able to aginst resistance by examiner)</p></td>
  </tr>
  <tr>
    <td>Left hand</td>
    <td><?php echo draw_option("Q57","0;1;2;3;4;5","s","multi",$Q57,true,2); ?></td>
  </tr>
  <tr>
    <td>Right leg</td>
    <td><?php echo draw_option("Q58","0;1;2;3;4;5","s","multi",$Q58,true,2); ?></td>
  </tr>
  <tr>
    <td>Left leg</td>
    <td><?php echo draw_option("Q59","0;1;2;3;4;5","s","multi",$Q59,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Gait</td>
    <td colspan="3"><?php echo draw_option("Q60","Steady;Unstable;Unable to stand;Involuntary movement;Other","xl","multi",$Q60,true,3); ?> <input type="text" name="Q61" id="Q61" size="6" value="<?php echo $Q61; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Joints condition</td>
    <td colspan="3"><?php echo draw_option("Q62","Normal;Weakness;Stiff;Contracture;Deformation;Paralysis;Semi-paralysis;Hemiplegia R / L;Amputation","xm","multi",$Q62,true,5); ?> part(s):<input type="text" name="Q63" id="Q63" size="6" value="<?php echo $Q63; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Assistive devices</td>
    <td colspan="3"><?php echo draw_option("Q64","None;Canes;Crutch;Brace;Walker;wheelchair;Prosthetic(s)","m","multi",$Q64,true,5); ?>: upper limb <?php echo draw_option("Q65","Left;Right","s","multi",$Q65,false,5); ?> Lower limb <?php echo draw_option("Q66","Left;Right","s","multi",$Q66,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Assistive devices</td>
    <td colspan="3">safety <?php echo draw_option("Q67","Good;Fair;Poor;Other","s","multi",$Q67,false,5); ?> <input type="text" name="Q68" id="Q68" size="6" value="<?php echo $Q68; ?>" /><br />Applicability <?php echo draw_option("Q69","Good;Fair;Poor;Other","s","multi",$Q69,false,5); ?> <input type="text" name="Q70" id="Q70" size="6" value="<?php echo $Q70; ?>" /> </td>
  </tr>
  <tr>
    <td class="title_s">Fall status</td>
    <td colspan="3"><?php echo draw_option("Q71","None;Often fall;Occasionally fall","xm","multi",$Q71,false,5); ?> occur in the past 1 year:<?php echo draw_option("Q72","None;Yes","s","multi",$Q72,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Resident injured by falling?</td>
    <td colspan="3"><?php echo draw_option("Q73","None;Yes","m","multi",$Q73,false,5); ?> injured part(s): <input type="text" name="Q74" id="Q74" size="6" value="<?php echo $Q74; ?>" /> fall occurred at:
<?php echo draw_option("Q75","Home;Facility;Other","xs","multi",$Q75,false,5); ?> <input type="text" name="Q76" id="Q76" size="12" value="<?php echo $Q76; ?>" /></td>
  </tr>
  <tr>
    <td rowspan="5" class="title">Sensation<br>condition</td>
    <td class="title_s">Vision</td>
    <td colspan="3"><?php echo draw_option("Q77","Adequate;Impaired;Moderately impaired;Highly impaired;Severely impaired","l","multi",$Q77,true,5); ?>
      <!--
      <input type="text" name="Q78" id="Q78" size="21" value="<?php echo $Q78; ?>" /></td>
      -->
  </tr>
  <tr>
    <td class="title_s">Corrective Lenses</td>
    <td colspan="3"><?php echo draw_option("Q79","No;Yes","s","multi",$Q79,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ability to hear</td>
    <td colspan="3"><?php echo draw_option("Q80","Adequate;Minimal difficulty;Moderate difficulty;Highly impaired","l","multi",$Q80,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Hearing Aid</td>
    <td colspan="3"><?php echo draw_option("Q81","No;Yes","s","multi",$Q81,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Preferred Language</td>
    <td colspan="3"><?php echo draw_option("Q82","English;Spanish;Chinese;French;German;Others","m","multi",$Q82,true,4); ?> <input type="text" name="Q83" id="Q83" size="21" value="<?php echo $Q83; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Leisure</td>
    <td colspan="4"><?php echo draw_option("Q84","None;TV;Music;Radio;Newspaper;Magazines,books;Painting;Calligraphy;Dance;Weave;Walk, jog;Chess;Gardening;Tea; Arrange flower;Pets;Poker,majong;Shopping;Other","xm","multi",$Q84,true,6); ?> <input type="text" name="Q85" id="Q85" size="21" value="<?php echo $Q85; ?>" /></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">Sleep</td>
    <td class="title_s">Daytime energy state</td>
    <td colspan="3"><?php echo draw_option("Q86","Good;Occasionally doze;Fatigue;Sleepy/somnolence;Other","l","multi",$Q86,true,3); ?> <input type="text" name="Q87" id="Q87" size="21" value="<?php echo $Q87; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Nap time</td>
    <td colspan="3"><?php echo draw_option("Q88","None;Yes","s","multi",$Q88,false,8); ?> Total napping hours:<input type="text" name="Q89" id="Q89" size="4" value="<?php echo $Q89; ?>" />hour(s)/day</td>
  </tr>
  <tr>
    <td class="title_s">Hypnotic agent</td>
    <td colspan="3"><?php echo draw_option("Q90","None;Yes;comply with medical advice;Self purchased","xl","multi",$Q90,true,2); ?><br />Name of the medicine:<input type="text" name="Q91" id="Q91" size="30"onkeyup="autocompleteMeds(this.id)" onclick="autocompleteMeds(this.id)" value="<?php echo $Q91; ?>" />　Dosage:<input type="text" name="Q92" id="Q92" size="30" value="<?php echo $Q92; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Sleep disorder(s)</td>
    <td colspan="3"><?php echo draw_option("Q93","None;Difficulty falling asleep;Easily awakened;Day/Night reversed;Nightmare;Orderless;Other","xl","multi",$Q93,true,3); ?></td>
  </tr>
  <tr>
    <td rowspan="4" class="title">Interpersonal</td>
    <td class="title_s">Interaction with people</td>
    <td colspan="3"><?php echo draw_option("Q94","Good;Normal;Poor;Anticipatory sadness;Violence;Other","l","multi",$Q94,true,4); ?> <input type="text" name="Q95" id="Q95" size="25" value="<?php echo $Q95; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Children</td>
    <td colspan="3">Male <?php echo draw_option("Q96","0;1;2;3;4;5;6;7;8;9","s","multi",$Q96,false,8); ?> <br />Female <?php echo draw_option("Q97","0;1;2;3;4;5;6;7;8;9","s","multi",$Q97,false,8); ?> </td>
  </tr>
  <tr>
    <td class="title_s">Reside</td>
    <td colspan="3"><?php echo draw_option("Q98","With spouse;With certain child;With different children;Alone;In nursing home;Other","xl","multi",$Q98,true,3); ?> <input type="text" name="Q99" id="Q99" size="30" value="<?php echo $Q99; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Economic sources</td>
    <td colspan="3"><?php echo draw_option("Q100","Resident own;Spouse;Children share the burden;Relative(s);Social security;Other","xl","multi",$Q100,true,3); ?> <input type="text" name="Q101" id="Q101" size="21" value="<?php echo $Q101; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Environment<br>introduction</td>
    <td colspan="4">
      <?php echo draw_checkbox("Q102","Introduction of staff (24 hours nurses/caregivers plus administrator, social workers,nutritionists and chefs...etc) has been done.;Introduction of roommate(s)/nearby resident(s) bas been done;Introduction to meal time, snack time, medication time, schedule of clinic revisit, bath time, guest time has been done;Introduction to service bell  (including in bathroom), bedding (bedside, tail, correct usage of bed rails), telephone has been done.;Introduction to dining room, bathroom, television, entertainment facilities, safe escape direction (safety door location) and safety equipment has been done.;Introduction to nursing station location, public bathrooms, toilets position;prohibition of indoor smoking has been done.;Inform the resident 'for physical discomfort, don't take unauthorized medication, inform the staff, we will ask the physician diagnosis and treatment and to assist transferring to hospital'.;Inform the resident 'if you feel discomfort with the service. Please feel free to inform us. We will improve quality'.",$Q102,"multi"); ?>
    </td>
  </tr>
  <tr>
    <td rowspan="4" class="title">Special<br /> considerations</td>
    <td class="title_s">Habits and customs</td>
    <td colspan="3"><input type="text" name="Q103" id="Q103" size="60" value="<?php echo $Q103; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Nutritional supplements</td>
    <td colspan="3"><input type="text" name="Q104" id="Q104" size="60" value="<?php echo $Q104; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Guest restrictions</td>
    <td colspan="3"><input type="text" name="Q105" id="Q105" size="60" value="<?php echo $Q105; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Other</td>
    <td colspan="3"><input type="text" name="Q106" id="Q106" size="60" value="<?php echo $Q106; ?>" /></td>
  </tr>
  <tr>
    <td rowspan="6" class="title">Other</td>
    <td colspan="4" class="title_s">Expectation to this facility</td>

  </tr>
  <tr>
    <td class="title_s">Resident</td>
    <td colspan="3"><input type="text" name="Q107" id="Q107" size="60" value="<?php echo $Q107; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Family</td>
    <td colspan="3"><input type="text" name="Q108" id="Q108" size="60" value="<?php echo $Q108; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Sources of information</td>
    <td colspan="3"><?php echo draw_option("Q109","Resident own;Family;Relative(s);Legal guardian;Social worker;Other","l","multi",$Q109,true,4); ?> <input type="text" name="Q110" id="Q110" size="30" value="<?php echo $Q110; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Information source to know this facility</td>
    <td colspan="3"><?php echo draw_option("Q111","Referral by healthcare agency ;Internet search;Referral by relatives/friends;Other","xl","multi",$Q111,true,3); ?> <input type="text" name="Q112" id="Q112" size="30" value="<?php echo $Q112; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Supplies <br>item/quantity</td>
    <td colspan="3"><textarea name="Q116" id="Q116" rows="10"><?php echo $Q116; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="5" class="title_s">Resident's Overall Expectation</td>
  </tr>
  <tr>
    <td class="title_s">During assessment process</td>
    <td colspan="4"><?php echo draw_option("Q118","Be discharged to the community;Remian in this facility;Be discharged to another facility;Unknown or uncertain","xxl","single",$Q118,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Information source</td>
    <td colspan="4"><?php echo draw_option("Q119","Resident;Family or significant other;Guardian or legally authorized representative;Unknown or uncertain","xxxl","single",$Q119,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="3">Is active discharge planning already occurring for the resident to return to the community?</td>
    <td colspan="2"><?php echo draw_option("Q120","No;Yes","s","single",$Q120,true,4); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02a" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
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