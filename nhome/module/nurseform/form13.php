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
   $height = $feet."'".$inch;
   /*===== 身高轉換 END =====*/
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform13` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$arrVar1 = explode("_",$_GET['date']);
	$sql = "SELECT * FROM `nurseform13` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($arrVar1[0])."' AND `no`='".$arrVar1[1]."'";
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

if ($_GET['date']!="") {
	// 原V $strQry = " AND DATE_FORMAT(`RecordedTime`, '%Y%m%d') <= '".$_GET['date']."'";
	// 新V START
	$strQry = " AND DATE_FORMAT(`date`, '%Y%m%d') <= '".mysql_escape_string($_GET['date'])."'";
	// 新V END
}

//Temperature
$db2a = new DB;
// 原V $db2a->query("SELECT `RecordedTime`, `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8310-5' ".$strQry." ORDER BY `RecordedTime` DESC LIMIT 0,14");
// 新V START
$db2a->query("SELECT `loinc_8310_5` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8310_5`!='' ".$strQry." ORDER BY `date` DESC, `time` DESC LIMIT 0,14");
// 新V END
$Temp = array();
for ($i=0;$i<$db2a->num_rows();$i++) {
	$r2a = $db2a->fetch_assoc();
	$Temp[$i] = $r2a['Value'];
}
//Heartbeats
$db2b = new DB;
// 原V $db2b->query("SELECT `RecordedTime`, `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8867-4' ".$strQry." ORDER BY `RecordedTime` DESC LIMIT 0,14");
// 新V START
$db2b->query("SELECT `loinc_8867_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8867_4`!='' ".$strQry." ORDER BY `date` DESC, `time` DESC LIMIT 0,14");
// 新V END
$Pulse = array();
for ($i=0;$i<$db2b->num_rows();$i++) {
	$r2b = $db2b->fetch_assoc();
	$Pulse[$i] = $r2b['Value'];
}
//Systolic BP
$db2c = new DB;
// 原V $db2c->query("SELECT `Value`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8480-6' ".$strQry." ORDER BY `RecordedTime` DESC LIMIT 0,14");
// 新V START
$db2c->query("SELECT `loinc_8480_6` AS `Value`,`date`,`time` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8480_6`!='' ".$strQry." ORDER BY `date` DESC, `time` DESC LIMIT 0,14");
// 新V END
$Systolic = array();
$datearray = array();
for ($i=0;$i<$db2c->num_rows();$i++) {
	$r2c = $db2c->fetch_assoc();
	$Systolic[$i] = $r2c['Value'];
	// 原V $datearray[$i] = substr($r2c['RecordedTime'],0,10).'<br>'.substr($r2c['RecordedTime'],11,5);
	// 新V START
	$datearray[$i] = substr($r2c['date'],0,4).'-'.substr($r2c['date'],4,2).'-'.substr($r2c['date'],6,2).'<br>'.substr($r2c['time'],0,2).":".substr($r2c['time'],2,2);
	// 新V END
}
//Diastolic BP
$db2d = new DB;
// 原V $db2d->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='8462-4' ".$strQry." ORDER BY `RecordedTime` DESC LIMIT 0,14");
// 新V START
$db2d->query("SELECT `loinc_8462_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_8462_4`!='' ".$strQry." ORDER BY `date` DESC, `time` DESC LIMIT 0,14");
// 新V END
$Diastolic = array();
for ($i=0;$i<$db2d->num_rows();$i++) {
	$r2d = $db2d->fetch_assoc();
	$Diastolic[$i] = $r2d['Value'];
}
//Blood glucose
$db2e = new DB;
// 原V $db2e->query("SELECT `Value`, `LoincCode`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND (`LoincCode`='14743-9' OR `LoincCode`='15075-5') ".$strQry." ORDER BY `RecordedTime` DESC LIMIT 0,14");
// 新V START
$db2e->query("SELECT `loinc_14743_9`,`loinc_15075_5`,`date`,`time` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND (`loinc_14743_9`!='' || `loinc_15075_5`!='') ".$strQry." ORDER BY `date` DESC, `time` DESC LIMIT 0,14");
// 新V END
$AC = array();
$ACdate = array();
$ACtype = array();
$i2=0;
for ($i=0;$i<$db2e->num_rows();$i++) {
	$r2e = $db2e->fetch_assoc();
	foreach($r2e as $k=>$v){
		$arrVitalsign = explode("_",$k);
		if ($arrVitalsign[0]=="loinc" && $v!="") {
			 $LoincCode = $arrVitalsign[1]."-".$arrVitalsign[2];
			 $AC[$i2] = $v;
			 $ACdate[$i2] = substr($r2e['date'],0,4).'-'.substr($r2e['date'],4,2).'-'.substr($r2e['date'],6,2).'<br>'.substr($r2e['time'],0,2).":".substr($r2e['time'],2,2);
			 if ($LoincCode=="14743-9") { $ACtype[$i2] = 'AC'; } else { $ACtype[$i2] = 'PC'; }
			 $i2++;
		}
	}
}
//Respiration
$db2f = new DB;
// 原V $db2f->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='9279-1' ".$strQry." ORDER BY `RecordedTime` DESC LIMIT 0,14");
// 新V START
$db2f->query("SELECT `loinc_9279_1` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_9279_1`!='' ".$strQry." ORDER BY `date` DESC, `time` DESC LIMIT 0,14");
// 新V END
$Resp = array();
for ($i=0;$i<$db2f->num_rows();$i++) {
	$r2f = $db2f->fetch_assoc();
	$Resp[$i] = $r2f['Value'];
}

?>
<form id="nurseform13" method="post" onSubmit="return checkForm()" action="index.php?mod=nurseform&func=nurseform13save">
<?php
$formID = "nurseform13";
$db_fname = new DB2;
$db_fname->query("SELECT * FROM `formnamealias` WHERE `formID`='".$formID."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
if ($db_fname->num_rows()==0) {
	$formName = "Clinic revisit record";
} else {
	$rFname = $db_fname->fetch_assoc();
	$formName = $rFname['formName'];
}
?>
<h3><?php echo $formName; ?></h3>
  <?php
  //檢查欄位是否存在
  $dbNumFields = new DB;
  $dbNumFields->query("SELECT * FROM `nurseform13` LIMIT 0,1");
  $rNumFields = $dbNumFields->num_fields();
  $field_array = array();
  for ($i=0;$i<$rNumFields;$i++) {
	  $dbFieldName = new DB;
	  $dbFieldName->query("SELECT * FROM `nurseform13` LIMIT 0,1");
	  $rFieldName = $dbFieldName->field_name($i);
	  if (substr($rFieldName,0,6)=="Qhosp_") { $field_array[$i] = $rFieldName; }
  }
  if (count($field_array)<21) {
	  if (!in_array('Qhosp_21',$field_array)) {
		  $dbU1 = new DB;
		  $dbU1->query('ALTER TABLE  `nurseform13` CHANGE  `Qhosp_'.count($field_array).'`  `Qhosp_21` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');
		  $movedCol = count($field_array);
	  }
	  for ($i=$movedCol;$i<=20;$i++) {
		  $dbU2 = new DB;
		  $dbU2->query('ALTER TABLE  `nurseform13` ADD  `Qhosp_'.$i.'` TEXT NOT NULL AFTER  `Qhosp_'.($i-1).'` ;');
	  }
  }
  //讀取系統設定
  $HospTxt = "";
  $dbHosp = new DB2;
  $dbHosp->query("SELECT * FROM system_setting WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
  $rHosp = $dbHosp->fetch_assoc();
  for ($i1=1;$i1<=20;$i1++) {
	  if ($rHosp['Hosp'.$i1]!="") { $HospTxt .= $rHosp['Hosp'.$i1].';'; }
  }
  $HospTxt .= "Other";
  ?>
<table width="100%">
  <tr>
    <td width="80" class="title">Resident name</td>
    <td width="160"><?php echo $name; ?></td>
    <td width="80" class="title">Gender</td>
    <td width="160"><?php echo draw_option("patient_Gender","Male;Female","m","single",$Gender,false,5); ?></td>
    <td width="80" class="title">DOB</td>
    <td><script> $(function() { $( "#patient_Birth").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="patient_Birth" id="patient_Birth" value="<?php echo $birth; ?>" size="12" ></td>
  </tr>
  <tr>
    <td class="title">Admission category</td>
    <td colspan="5"><?php if ($QillnessType==NULL) { $QillnessType = $nurseform01_QillnessType; } echo draw_option("QillnessType","General;Veteran;Middle-low income;Low-income;Other","l","multi",$QillnessType,true,4); ?> <input type="text" name="QillnessTypeOther" id="nurseform01_QillnessTypeOther" value="<?php echo $nurseform01_QillnessTypeOther; ?>" size="24"></td>
  </tr>
</table>
<table width="100%">
  <tr>
      <td colspan="6" class="title">Clinic visiting records</td>
  </tr>
  <tr>
      <td width="80" class="title">Hospital</td>
      <td colspan="5"><?php echo draw_option("Qhosp",$HospTxt,"l","multi",$Qhosp,true,5); ?> <input type="text" name="Qhospother" id="Qhospother" size="24" value="<?php echo $Qhospother; ?>"></td>
</tr>
  <tr>
      <td width="80" class="title">Physician</td>
      <td width="200"><input type="text" name="Qdoctor" id="Qdoctor" value="<?php echo $Qdoctor; ?>" size="10"></td>
      <td width="80" class="title">Clinic</td>
      <td width="200"><input type="text" name="Qroom" id="Qroom" value="<?php echo $Qroom; ?>" size="10"></td>
      <td width="80" class="title">Date</td>
      <td><script> $(function() { $( "#Qhospdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><span style="text-align: left;"><input type="text" id="Qhospdate" name="Qhospdate" value="<?php echo ($Qhospdate!=""?$Qhospdate:date("Y/m/d")); ?>" size="12" /></span></td>
</tr>
  <tr>
    <td class="title">Division</td>
    <td><input type="text" name="QDepartment" id="QDepartment" value="<?php echo $QDepartment; ?>" size="10"></td>
    <td class="title">Clinical appoitment #</td>
    <td colspan="3"><input type="text" name="Qqueueno" id="Qqueueno" value="<?php echo $Qqueueno; ?>" size="10"></td>
    </tr>
  <tr>
    <td class="title">Height</td>
    <td><?php echo $height; ?></td>
    <td class="title">Body weight</td>
    <td colspan="3">
    <?php
	$db3a = new DB;
	/* 原V
	$db3a->query("SELECT `Value`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".@$_GET['pid']."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	$r3a = $db3a->fetch_assoc();
	echo $r3a['Value'].' lbs ('.substr($r3a['RecordedTime'],0,10).')';
	*/
	// 新V START
	$db3a->query("SELECT `loinc_18833_4` AS `Value`, `date` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	$r3a = $db3a->fetch_assoc();
	echo $r3a['Value'].' lbs ('.date("Y-m-d",strtotime($r3a['date'])).')';
	// 新V END
	?>
    </td>
    </tr>
</table>
<table width="100%">
<tr>
    <td rowspan="2" class="title" width="80">Vital Signs<br>(TPR/BP)</td>
    <td class="title_s" width="80">Date</td>
    <?php
    for ($i=0;$i<7;$i++) {
        echo '
    <td>'.$datearray[$i].'</td>'."\n";
    }
    ?>
</tr>
<tr>
    <td  class="title_s">Value(s)</td>
    <?php
    for ($i=0;$i<7;$i++) {
        echo '<td><span class="title_s">&nbsp;T&nbsp;</span> ';
        if ($Temp[$i]==NULL) { echo '　　'; } else { echo $Temp[$i]; }
        echo '<br><span class="title_s">&nbsp;P&nbsp;</span> ';
        if ($Pulse[$i]==NULL) { echo '　　'; } else { echo $Pulse[$i]; }
        echo '<br><span class="title_s">&nbsp;R&nbsp;</span> ';
        if ($Resp[$i]==NULL) { echo '　　'; } else { echo $Resp[$i]; }
        echo '<br><span class="title_s">&nbsp;BP&nbsp;</span> ';
        if ($Systolic[$i]==NULL) { echo '　　'; } else { echo $Systolic[$i]; }
        if ($Diastolic[$i]==NULL) { echo '/　　'; } else { echo '/'.$Diastolic[$i]; }
        echo ' </td>'."\n";
    }
    ?>
</tr>
<tr>
    <td rowspan="2" class="title">Blood glucose</td>
    <td class="title_s">Time</td>
    <?php
    for ($i=0;$i<7;$i++) {
        echo '
    <td>'.$ACdate[$i].'</td>'."\n";
    }
    ?>
</tr>
<tr>
    <td  class="title_s">Value(s)</td>
    <?php
    for ($i=0;$i<7;$i++) {
        echo '<td>'.$ACtype[$i].' ';
        if ($AC[$i]==NULL) { echo '　　 mg/dl'; } else { echo $AC[$i].' mg/dl'; }
        echo ' </td>'."\n";
    }
    ?>
</tr>
<tr>
    <td class="title">Health history</td>
    <td class="title_s">Past medical history</td>
    <td colspan="7"><?php if ($Qdiseasehistory==NULL) { $Qdiseasehistory = $nurseform02a_Q21; } echo draw_option("Qdiseasehistory","None;Diabetes;Hypertension;Stroke;Stroke(Left);Stroke(Right);Heart disease;Kidney disease;Liver disease;Parkinson's disease;Benign prostatic hyperplasia;Mental illness;Cancer;Dementia;Other","xl","multi",$Qdiseasehistory,true,3); ?><input type="text" name="Qdiseasehistoryother" id="Qdiseasehistoryother" value="<?php echo $nurseform02a_Q22; ?>" size="42"></td>
</tr>
<tr>
    <td class="title" rowspan="2">Mental Status</td>
    <td class="title_s">Daytime energy state</td>
    <td colspan="7"><?php if ($Qdaymental==NULL) { $Qdaymental = $nurseform02a_Q86; } echo draw_option("Qdaymental","Good;Occasionally doze;Fatigue;Sleepy/somnolence;Other","l","multi",$Qdaymental,true,4); ?><input type="text" name="Qdaymentalother" id="Qdaymentalother" value="<?php echo $nurseform02a_Q87; ?>" size="12"></td>
</tr>
<tr>
    <td class="title_s">Sleep disorder(s)</td>
    <td colspan="7"><?php if ($Qsleep==NULL) { $Qsleep = $nurseform02a_Q93; } echo draw_option("Qsleep","None;Difficulty falling asleep;Easily awakened;Day/Night reversed;Nightmare;Orderless;Other","xl","multi",$Qsleep,true,3); ?><input type="text" name="Qsleepother" id="Qsleepother" value="<?php echo $Qsleepother; ?>" size="39"></td>
</tr>
<tr>
    <td class="title" rowspan="6">Dietary status</td>
    <td class="title_s">Nutrition pathway</td>
    <td colspan="7"><?php if ($Qnutritionway==NULL) { $Qnutritionway = $nurseform02b_Q22; } echo draw_option("Qnutritionway","Oral;Nasogastric tube;Gastrostomy;Other","xm","multi",$Qnutritionway,true,7); ?><input type="text" name="Qnutritionwayother" id="Qnutritionwayother" value="<?php echo $nurseform02b_Q23; ?>" size="12"></td>
</tr>
<tr>
    <td class="title_s">Eating patterns</td>
    <td colspan="7"><?php if ($Qeatway==NULL) { $Qeatway = $nurseform02b_Q24; } echo draw_option("Qeatway","General;Meat only;Vegetarian;Soft food;Crushed;Mushy;Self-made liquid;Liquid  formula","xm","multi",$Qeatway,true,5); ?> <input type="text" id="Qeatwaykcal" name="Qeatwaykcal" size="5"  value="<?php echo $nurseform02b_Q24a; ?>">kcal/d</td>
</tr>
<tr>
    <td class="title_s">Appetite</td>
    <td colspan="7"><?php echo draw_option("Qapetite","Good;Normal;Fair;Poor;Unassessable","m","multi",$Qapetite,true,5); ?></td>
</tr>
<tr>
    <td class="title_s">Oral pain</td>
    <td colspan="7"><?php if ($Qmouthpain==NULL) { $Qmouthpain = $nurseform02b_Q26; } echo draw_option("Qmouthpain","None;Has;Unassessable","m","multi",$Qmouthpain,false,0); ?></td>
</tr>
<tr>
    <td class="title_s">Dental status</td>
    <td colspan="7"><?php if ($Qteeth==NULL) { $Qteeth = $nurseform02b_Q29; } echo draw_option("Qteeth","Not affect mastication;Affect mastication;Not by oral intake","xl","multi",$Qteeth,false,0); ?></td>
</tr>
<tr>
    <td class="title_s">Swallowing ability</td>
    <td colspan="7"><?php if ($Qswallow==NULL) { $Qswallow = $nurseform02b_Q30; } echo draw_option("Qswallow","Smooth and no cough;Occasionally bucking (1~3times/day);Frequently bucking (>3times/day);Unable to swallow;Unassessable","xxl","multi",$Qswallow,true,3); ?></td>
</tr>
<tr>
    <td class="title" rowspan="4">Excretion status</td>
    <td class="title_s">Urination</td>
    <?php
     if ($nurseform02b_Q34==2) { $nurseform02b_Q33 .= '3;'; }
    ?>
    <td colspan="7"><?php if ($Q33==NULL) { $Q33 = $nurseform02b_Q33; } echo draw_option("Q33","Clear;Turbid;Sediments;Other","m","multi",$Q33,false,0); ?><input type="text" name="Q33a" id="Q33a" value="<?php echo $Q33a; ?>" size="12"></td>
</tr>
<tr>
    <td class="title_s">Urination treatment</td>
    <td colspan="7"><?php if ($Q35==NULL) { $Q35 = $nurseform02b_Q35; } echo draw_option("Q35","Toilet or urinal (potty chair);Diapers;Catheter;Intermittent catheterization;Indwelling catheter;Other","xl","multi",$Q35,true,3); ?> <input type="text" name="Q36" id="Q36" size="46" value="<?php echo $nurseform02b_Q36; ?>"></td>
</tr>
<tr>
    <td class="title_s">Defecation</td>
    <td colspan="7"><?php echo draw_option("Q37","Normal;Hard stool;Loose stool;Diarrhea;Other","m","multi",$Q37,true,5); ?></td>
</tr>
<tr>
    <td class="title_s">Defecation treatment</td>
    <td colspan="7"><?php if ($Q42==NULL) { $Q42 = $nurseform02b_Q42; } echo draw_option("Q42","Normal defecation without medication;Stool softeners;Laxative;Enema;Digital removal of faeces(DRF);Colostomy;Other","xxxl","multi",$Q42,true,2); ?> <input type="text" name="Q42A" id="Q42A" size="21" value="<?php echo $nurseform02b_Q42A; ?>"></td>
</tr>
<tr>
    <td class="title" rowspan="2">Pipeline replacement</td>
    <td class="title_s">NG</td>
    <td colspan="7"><?php echo draw_option("QNGchange","None;Yes","s","multi",$QNGchange,false,0); ?>，<?php echo draw_option("QNGmaterial","General;Silicone","xs","multi",$QNGmaterial,false,0); ?> Caliber:<input type="text" name="QNGdiameter" id="QNGdiameter" value="<?php echo $QNGdiameter; ?>" size="12">Fr　Date of latest replacement:<script> $(function() { $( "#QNGdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QNGdate" id="QNGdate" value="<?php echo $QNGdate; ?>" size="12"></td>
</tr>
<tr>
    <td class="title_s">Foley</td>
    <td colspan="7"><?php echo draw_option("QFoleychange","None;Yes","s","multi",$QFoleychange,false,0); ?>，<?php echo draw_option("QFoleymaterial","General;Silicone","xs","multi",$QFoleymaterial,false,0); ?> Caliber:<input type="text" name="QFoleydiameter" id="QFoleydiameter" value="<?php echo $QFoleydiameter; ?>" size="12">Fr　Date of latest replacement:<script> $(function() { $( "#QFoleydate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="QFoleydate" id="QFoleydate" value="<?php echo $QFoleydate; ?>" size="12"></td>
</tr>
<tr>
    <td class="title" rowspan="2">Wound description</td>
    <td class="title_s">Wound</td>
    <td colspan="7"><?php if ($Q47==NULL) { $Q47 = $nurseform02a_Q47; } echo draw_option("Q47","None;Yes","s","multi",$Q47,false,6); ?> Severity <?php if ($Q48==NULL) { $Q48 = $nurseform02a_Q48; } echo draw_option("Q48","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","l","multi",$Q48,false,6); ?><br>Size:<input type="text" name="Q49" id="Q49" size="6" value="<?php if ($Q49==NULL) { $Q49 = $nurseform02a_Q49; } echo $Q49; ?>" /> Body part:<input type="text" name="Q50" id="Q50" size="20" value="<?php if ($Q50==NULL) { $Q50 = $nurseform02a_Q50; } echo $Q50; ?>" /></td>
</tr>
<tr>
    <td class="title_s">Pressure ulcer(s)</td>
    <td colspan="7"><?php if ($Q51==NULL) { $Q51 = $nurseform02a_Q51; } echo draw_option("Q51","None;Yes","s","multi",$Q51,false,6); ?> Severity <?php if ($Q52==NULL) { $Q52 = $nurseform02a_Q52; } echo draw_option("Q52","Reddish;Epidermis;Subcutaneous tissue;Muscle and bone","l","multi",$Q52,false,6); ?> <br>Size:<input type="text" name="Q53" id="Q53" size="6" value="<?php if ($Q53==NULL) { $Q53 = $nurseform02a_Q53; } echo $nurseform02a_Q53; ?>" /> Body part:<input type="text" name="Q54" id="Q54" size="20" value="<?php if ($Q54==NULL) { $Q54 = $nurseform02a_Q54; } echo $Q54; ?>" /></td>
</tr>
<tr>
    <td class="title" colspan="2">Clinic revisiting reason</td>
    <td colspan="7"><?php echo draw_option("Qreason","Regularly revisit;Other","xm","multi",$Qreason,false,5); ?>：<input type="text" name="Qreasonother" id="Qreasonother" value="<?php echo $Qreasonother; ?>" size="49"></td>
</tr>
<tr>
    <td class="title" colspan="2">Care overview</td>
    <td colspan="7">
    <select id="nurseform05txt" style="width:600px; overflow:hidden;" class="printcol">
    <?php
	$db2 = new DB;
	$db2->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`>='".str_replace("/","",calcdayafterday(date(Ymd),-7))."' ORDER BY `date` DESC, `nID`");
	if ($db2->num_rows()>0) {
		for ($i4=0;$i4<$db2->num_rows();$i4++) {
			$r2 = $db2->fetch_assoc();
			echo '<option value="'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).' '.$r2['Qcontent'].'">'.formatdate($r2['date']).' '.substr($r2['time'],0,2).':'.substr($r2['time'],2,2).' '.$r2['Qcontent'].'</option>';
		}
	}
	?>
    </select>
    &nbsp;<input type="button" value="Substitute" onclick="addtotextarea('Qnursedescript2', $('#nurseform05txt').val())" /><br>
    <textarea name="Qnursedescript2" id="Qnursedescript2" cols="80" rows="6"><?php echo $Qnursedescript2; ?></textarea></td>
</tr>
<tr>
    <td class="title" colspan="2">Current medication</td>
    <td colspan="7">
    <textarea name="Qnursedescript3" id="Qnursedescript3" cols="80" rows="6"><?php echo $Qnursedescript3; ?></textarea>
    <input type="button" value="Sync with current medication info" onclick="refreshMedRecord()" class="printcol"></td>
</tr>
<tr height="240">
    <td class="title" colspan="2" >Professional advice of physician  <?php if ($arrVar1[0]!="" && $arrVar1[1]!="") { ?>
    <input type="image" id="fillDocSuggest_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" style="border:none; background: none;" src="Images/edit_icon.png">
	<?php } ?></td>
    <td colspan="7">
    <div id="docSugTxt_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" style="padding:4px;"><?php echo str_replace("\n","<br>",$Qdoctorsuggestion); ?></div>
    </td>
</tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
<input type="hidden" name="formID" id="formID" value="nurseform13" />
<input type="hidden" name="no" id="no" value="<?php echo $r1['no'];?>" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
<?php if ($_GET['date']=="") { ?>
<input type="hidden" id="act" name="act" value="Add record" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<?php } else { ?>
<input type="submit" id="act" name="act" value="完成編輯"/>
<input type="submit" id="act" name="act" value="另存新紀錄"/>
<?php } ?>
</center>
</form>
<script>
$(function() {
    $( "#dialog-change_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" ).dialog({
		autoOpen: false,
		height: 370,
		width: 620,
		modal: true,
		buttons: {
			"存檔": function() {
				$.ajax({
					url: "class/edit.php",
					type: "POST",
					data: {"formID": 'nurseform13', "Qdoctorsuggestion":$('#Qdoctorsuggestion_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>').val(), "colID":'', "autoID": '', "where": "`HospNo`='<?php echo $HospNo; ?>' AND `date`='<?php echo $arrVar1[0]; ?>' AND `no`='<?php echo $arrVar1[1]; ?>'"},
					success: function(data) {
						$( "#dialog-change_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" ).dialog( "close" );
						$('#docSugTxt_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>').html($('#Qdoctorsuggestion_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>').val().replace(/\n/g, "<br />"));
						alert("Save successfully");
						if ($('#writeToNR_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>').attr('checked')=="checked") {
							$.ajax({
								url: "class/writeToNR.php",
								type: "POST",
								data: {"Qcontent": $('#Qdoctorsuggestion_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>').val(), "HospNo": '<?php echo $HospNo; ?>', "date": '<?php echo $arrVar1[0]; ?>', "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>'},
								success: function(data) {
									
								}
							});
						}
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-change_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" ).dialog( "close" );
				//document.location.reload(true);
			}
		}
	});
});
$(function () {
	$('#fillDocSuggest_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>').click(function() {
		$( "#dialog-change_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" ).dialog( "open" );
		return false;
	});
});
</script>
<div id="dialog-change_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" title="填寫醫師專業意見" class="dialog-form">
	<form>
	<fieldset>
		<table>
          <tr>
            <td>
            <textarea name="Qdoctorsuggestion" id="Qdoctorsuggestion_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" cols="80" rows="10"><?php echo $Qdoctorsuggestion; ?></textarea><br>
            <input type="checkbox" id="writeToNR_<?php echo $arrVar1[0]; ?>_<?php echo $arrVar1[1]; ?>" value="1"> 拋轉至「護理紀錄」
            </td>
          </tr>
        </table>
    </fieldset>
	</form>
</div><br><br>
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
<script>
function refreshMedRecord () {
	$.ajax({
		url: "class/nurseform13.php",
		type: "POST",
		data: {"HospNo": '<?php echo $HospNo; ?>' },
		success: function(data) {
			$('#Qnursedescript3').val(data);
		}
	});
}
function addtotextarea(field, text) {
	var pos = $('#'+field).caret();
	document.getElementById(field).value = document.getElementById(field).value;
	var txt = document.getElementById(field).value;
	var txt_part_1 = txt.substring(0, pos);
	var txt_part_2 = txt.substring(pos, txt.length);
	document.getElementById(field).value = txt_part_1+text+txt_part_2;
	$('#'+field).caret(pos+text.length);
}
</script>