<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT `Gender_1`,`Gender_2`,`height` FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
}
   /*===== 身高轉換 START =====*/
   $inch = $height;
   $feet = floor($inch/12);
   $inch = $inch%12;
   $heightfeet = $feet."'".$inch;
   /*===== 身高轉換 END =====*/
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform11` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform11` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
   /*===== 身高轉換 START =====*/
   $inch = $Q5;
   $feet = floor($inch/12);
   $inch = $inch%12;
   $Q5feet = $feet."'".$inch;
   /*===== 身高轉換 END =====*/

//入住表單欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform01_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform01_'.$k} = $v; } }  else { ${'nurseform01_'.$k} = $v; } } }

//護理表單2b欄位
$db4 = new DB;
$db4->query("SELECT * FROM `nurseform02b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r4 = $db4->fetch_assoc();
if ($db4->num_rows()>0) { foreach ($r4 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02b_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02b_'.$k} = $v; } }  else { ${'nurseform02b_'.$k} = $v; } } }

//護理表單2a欄位
$db5 = new DB;
$db5->query("SELECT * FROM `nurseform02a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r5 = $db5->fetch_assoc();
if ($db5->num_rows()>0) { foreach ($r5 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02a_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02a_'.$k} = $v; } }  else { ${'nurseform02a_'.$k} = $v; } } }

//護理表單2c欄位
$db6 = new DB;
$db6->query("SELECT * FROM `nurseform02c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r6 = $db6->fetch_assoc();
if ($db6->num_rows()>0) { foreach ($r6 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02c_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } 		} else { ${'nurseform02c_'.$k} = $v; } } else { ${'nurseform02c_'.$k} = $v; } } }
/* 原V
//Temperature
$db2a = new DB;
$db2a->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8310-5' ORDER BY `VitalSignID` DESC LIMIT 0,1");
$r2a = $db2a->fetch_assoc();
//Heartbeats
$db2b = new DB;
$db2b->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8867-4' ORDER BY `VitalSignID` DESC LIMIT 0,1");
$r2b = $db2b->fetch_assoc();
//Systolic BP
$db2c = new DB;
$db2c->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8480-6' ORDER BY `VitalSignID` DESC LIMIT 0,1");
$r2c = $db2c->fetch_assoc();
//Diastolic BP
$db2d = new DB;
$db2d->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8462-4' ORDER BY `VitalSignID` DESC LIMIT 0,1");
$r2d = $db2d->fetch_assoc();
//Blood glucose
$db2e = new DB;
$db2e->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='14743-9' ORDER BY `VitalSignID` DESC LIMIT 0,1");
$r2e = $db2e->fetch_assoc();
//Respiration
$db2f = new DB;
$db2f->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='9279-1' ORDER BY `VitalSignID` DESC LIMIT 0,1");
$r2f = $db2f->fetch_assoc();
//Body weight
$db2g = new DB;
$db2g->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' ORDER BY `VitalSignID` LIMIT 0,1");
$r2g = $db2g->fetch_assoc();
*/
// 新V START
//Temperature
$db2a = new DB;
$db2a->query("SELECT `loinc_8310_5` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8310_5`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
$r2a = $db2a->fetch_assoc();
//Heartbeats
$db2b = new DB;
$db2b->query("SELECT `loinc_8867_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8867_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
$r2b = $db2b->fetch_assoc();
//Systolic BP
$db2c = new DB;
$db2c->query("SELECT `loinc_8480_6` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8480_6`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
$r2c = $db2c->fetch_assoc();
//Diastolic BP
$db2d = new DB;
$db2d->query("SELECT `loinc_8462_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8462_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
$r2d = $db2d->fetch_assoc();
//Blood glucose
$db2e = new DB;
$db2e->query("SELECT `loinc_14743_9` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_14743_9`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
$r2e = $db2e->fetch_assoc();
//Respiration
$db2f = new DB;
$db2f->query("SELECT `loinc_9279_1` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_9279_1`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
$r2f = $db2f->fetch_assoc();
//Body weight
$db2g = new DB;
$db2g->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` ASC, `time` ASC LIMIT 0,1");
$r2g = $db2g->fetch_assoc();
// 新V END
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Admission initial assessment(72hrs)</h3>
<table width="100%">
  <tr>
    <td width="120" class="title">Full name</td>
    <td><?php echo $name; ?></td>
    <td width="120" class="title">Bed #</td>
    <td><?php echo $bedID; ?></td>
  </tr>
  <tr>
    <td class="title">Gender</td>
    <td><?php echo draw_option("patient_Gender","Male;Female","m","single",$Gender,false,5); ?></td>
    <td class="title">DOB</td>
    <td><script> $(function() { $( "#patient_Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="patient_Birth" id="patient_Birth" value="<?php echo $birth; ?>" size="12" ></td>
    </tr>
  <tr>
    <td class="title">Weight</td>

    <td><input type="text" name="Q4" id="Q4" value="<?php echo ($Q4!=NULL?$Q4:$r2g['Value']); ?>" size="4" >lbs</td>
    <td class="title">Height</td>
    <td><input type="text" name="Q5" id="Q5" value="<?php echo ($Q5!=NULL?$Q5feet:$heightfeet); ?>" size="4" ></td>

    </tr>
  <tr>
    <td class="title">Admission date</td>
    <td colspan="3"><script> $(function() { $( "#inpatientinfo_indate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><p align="left"><input type="text" id="inpatientinfo_indate" name="inpatientinfo_indate" value="<?php echo $indate; ?>" size="12" /></p></td>
    </tr>
  <tr>
    <td width="120" class="title" rowspan="4">Diagnosis</td>
    <td colspan="2">1. <input type="text" name="Qdiag1" id="Qdiag1" size="20" value="<?php echo $nurseform01_Qdiag1; ?>" /></td>
    <td colspan="3">5. <input type="text" name="Qdiag5" id="Qdiag5" size="20" value="<?php echo $nurseform01_Qdiag5; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2">2. <input type="text" name="Qdiag2" id="Qdiag2" size="20" value="<?php echo $nurseform01_Qdiag2; ?>" /></td>
    <td colspan="3">6. <input type="text" name="Qdiag6" id="Qdiag6" size="20" value="<?php echo $nurseform01_Qdiag6; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2">3. <input type="text" name="Qdiag3" id="Qdiag3" size="20" value="<?php echo $nurseform01_Qdiag3; ?>" /></td>
    <td colspan="3">7. <input type="text" name="Qdiag7" id="Qdiag7" size="20" value="<?php echo $nurseform01_Qdiag7; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2">4. <input type="text" name="Qdiag4" id="Qdiag4" size="20" value="<?php echo $nurseform01_Qdiag4; ?>" /></td>
    <td colspan="3">8. <input type="text" name="Qdiag8" id="Qdiag8" size="20" value="<?php echo $nurseform01_Qdiag8; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Vital Signs</td>
    <td colspan="3"><span class="title_s"> TPR </span> <input type="text" name="Q6" id="Q6" size="3" value="<?php if ($r2a['Value']==NULL) { echo $Q6; } else { echo $r2a['Value']; } ?>" /> / <input type="text" name="Q7" id="Q7" size="3" value="<?php if ($r2b['Value']==NULL) { echo $Q7; } else { echo  $r2b['Value']; } ?>" /> / <input type="text" name="Q7a" id="Q7a" size="3" value="<?php if ( $r2f['Value']==NULL) { echo $Q7a; } else { echo  $r2f['Value']; } ?>" />　　<span class="title_s"> BP </span><input type="text" name="Q8" id="Q8" size="3" value="<?php if ($r2c['Value']==NULL) { echo $Q8; } else { echo $r2c['Value']; } ?>" />/<input type="text" name="Q9" id="Q9" size="3" value="<?php if ($r2d['Value']==NULL) { echo $Q9; } else { echo $r2d['Value']; } ?>" />mmHg　　<span class="title_s"> Blood glucose </span> <input type="text" name="Q10" id="Q10" size="3" value="<?php if ($r2e['Value']==NULL) { echo $Q10; } else { echo $r2e['Value']; } ?>" />AC</td>
  </tr>
  <tr>
    <td class="title">Food intake</td>
    <td colspan="3"><?php echo draw_option("Q11","General/Crushed;Vegetarian;Semi-liquid;Liquid;Soft food","l","multi",$Q11,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Eating patterns</td>
    <td colspan="3"><?php echo draw_option("Q12","Self-feeding;Need assistant feeding;Tube feeding","xl","multi",$Q12,false,5); ?><br>Reason(s) :<input type="text" name="Q12a" id="Q12a" size="20" value="<?php echo $Q12a; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Respiratory status</td>
    <td colspan="3"><?php echo draw_checkbox("Q13","Self-breathing;Nasal tube;O2 <input type=\"text\" name=\"Q13a\" id=\"Q13a\" size=\"3\" value=\"".$Q12a."\"/>L/min",$Q13,"multi"); ?>Note(s):<input type="text" name="Q13b" id="Q13b" size="20" value="<?php echo $Q13b; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Cognitive status</td>
    <td colspan="3"><?php echo draw_option("Q14","Clear & aware;Orderless;Delirium;Somnolence;Stupor;vegetative being;Coma;Other","xm","multi",$nurseform02b_Q15,true,5); ?> <input type="text" id="Q16" name="Q16" size="30"  value="<?php echo $nurseform02b_Q16; ?>"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td rowspan="4" class="title" width="120">Sensory function</td>
    <td class="title_s" width="80">Vision</td>
    <td><?php echo draw_option("Q15","Normal;Myopia;Presbyopia;Blurred vision(R);Glaucoma(R);Cataract(R);Retinal detachment(R);Blind(R);Blurred vision(L);Glaucoma(L);Cataract(L);Retinal detachment(L);Blind(L);Other","xl","multi",$nurseform02a_Q77,true,3); ?>      <input type="text" name="Q15a" id="Q15a" size="21" value="<?php echo $nurseform02a_Q78; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Visual aids</td>
    <td><?php echo draw_option("Q16","None;Glasses (myopia);Glasses (hyperopia);Magnifier;Contact lenses;Prosthetic eye(R);Prosthetic eye(L)","l","multi",$nurseform02a_Q79,true,4); ?></td>
  </tr>
  <tr>
    <td class="title_s">Hearing</td>
    <td><?php echo draw_option("Q17","Normal;Tinnitus(R);Impaired(R);Deaf(R);Tinnitus(L);Impaired(L);Deaf(L)","m","multi",$nurseform02a_Q80,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s">Hearing aids</td>
    <td><?php echo draw_option("Q18","None;Hearing aids usage(R);Hearing aids usage(L)","l","multi",$nurseform02a_Q81,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Excretory function</td>
    <td colspan="2"><?php echo draw_option("Q19","Toilet or urinal (potty chair);Diapers;Catheter;Intermittent catheterization;Indwelling catheter;Other","xl","multi",$nurseform02b_Q35,true,4); ?> <input type="text" name="Q19a" id="Q19a" size="20" value="<?php echo $nurseform02b_Q36; ?>"></td>
  </tr>
  <tr>
    <td class="title">Defecation function</td>
    <td colspan="2"><?php echo draw_option("Q20","Normal defecation without medication;Stool softeners;Laxative;Enema;Digital removal of faeces(DRF);Colostomy;Other","xxxl","multi",$nurseform02b_Q42,true,2); ?> <input type="text" name="Q20a" id="Q20a" size="21" value="<?php echo $nurseform02b_Q42A; ?>"></td>
  </tr>
  <tr>
    <td class="title">Skin integrity</td>
    <td colspan="2"><?php echo draw_option("Q21","Normal;Pale;Jaundice;Pigmentation;Dehydration;Edema;Itchy;Abnormal nail;Sparse hair;Loss of hair;Skin allergy;Eczema;Fungal infection;Suspected scabies;Other","xm","multi",$nurseform02a_Q45,true,6); ?> <input type="text" name="Q21a" id="Q21a" size="40" value="<?php echo $nurseform02a_Q46; ?>" /></td>
  </tr>
  <tr>
    <td rowspan="6" class="title">Self-care ability (ADL)</td>
    <td class="title_s">Grooming</td>
    <td><input type="text" name="Q22a" id="Q22a" size="2" value="<?php echo $Q22a; ?>" /><?php if ($nurseform02c_Q3==1) { echo "Independent face/hair/teeth/shaving cleaning(implements provided)"; } elseif ($nurseform02c_Q3==2) { echo "Needs to help with personal care"; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Self-feeding</td>
    <td><input type="text" name="Q22b" id="Q22b" size="2" value="<?php echo $Q22b; ?>" /><?php if ($nurseform02c_Q1==1) { echo "Independent ( able to wear on/off if aids is needed)."; } elseif ($nurseform02c_Q1==2) { echo "Needs help cutting, spreading butter, etc., or requires modified diet"; } elseif ($nurseform02c_Q1==3) { echo "Unable (entirely depend on assistant to be fed). "; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Dressing</td>
    <td><input type="text" name="Q22c" id="Q22c" size="2" value="<?php echo $Q22c; ?>" /><?php if ($nurseform02c_Q8==1) { echo "Independent (including buttons, zips, laces, etc.)"; } elseif ($nurseform02c_Q8==2) { echo "Needs help but can do about half unaided"; } elseif ($nurseform02c_Q8==3) { echo "Dependent (Need help)."; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Bathing</td>
    <td><input type="text" name="Q22d" id="Q22d" size="2" value="<?php echo $Q22d; ?>" /><?php if ($nurseform02c_Q5==1) { echo "Independent (bath/ sponge bath or in shower)"; } elseif ($nurseform02c_Q5==2) { echo "Dependent (Need help)."; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Toileting</td>
    <td><input type="text" name="Q22e" id="Q22e" size="2" value="<?php echo $Q22e; ?>" /><?php if ($nurseform02c_Q4==1) { echo "Independent (on and off, dressing, wiping)"; } elseif ($nurseform02c_Q4==2) { echo "Needs some help, but can do something alone"; } elseif ($nurseform02c_Q4==3) { echo "Dependent (Need help)."; } ?></td>
  </tr>
  <tr>
    <td class="title_s">Mobile</td>
    <td><input type="text" name="Q22f" id="Q22f" size="2" value="<?php echo $Q22f; ?>" /><?php if ($nurseform02c_Q2==1) { echo "Independent (but may use any aid. for example, stick)"; } elseif ($nurseform02c_Q2==2) { echo "Walks with help of one person (verbal or physical) "; } elseif ($nurseform02c_Q2==3) { echo "Wheelchair independent, including corners"; } elseif ($nurseform02c_Q2==4) { echo "Immobile or < 50 yards (Fully depend on assistant)"; } ?></td>
  </tr>
  <tr>
    <td class="title">Based on the above observation</td>
    <td colspan="2"><textarea cols="80" rows="10" name="Q23" id="Q23"><?php echo $Q23; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform11" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
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