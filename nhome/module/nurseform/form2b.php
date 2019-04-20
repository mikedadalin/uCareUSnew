<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02b` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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

	  /*=== Body weight START ===*/
	  $db3 = new DB;
	  // 原V $db3->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	  // 新V START
	  $db3->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
	  if ($db3->num_rows()>0) {
		  $r3 = $db3->fetch_assoc();
		  $weight = $r3['Value'];
		  $weight = str_split($weight);
		  if(count($weight)==2){
			  $turnweight = $weight;
			  $weight[0] =0;
			  $weight[1] = $turnweight[0];
			  $weight[2] = $turnweight[1];
		  }
		  $NowWeight = $weight[0].$weight[1].$weight[2];
	  }
	  /*=== Body weight END ===*/
	  /*=== 一個月前日期 START ===*/
	  $NowDatePart = str_split(date(Ymd),2);	  
	  $lastMonth = $NowDatePart[2]-1;
	  $lastMonthYear = $NowDatePart[1];
	  if($lastMonth==0){
		  $lastMonth = 12;
		  $lastMonthYear = $lastMonthYear-1;
	  }
	  $lastMonthPart = str_split($lastMonth);
	  if(count($lastMonthPart)==1){
		  $lastMonth = "0".$lastMonth;
	  }
	  // 原V $lastMonthDate = $NowDatePart[0].$lastMonthYear."-".$lastMonth."-".$NowDatePart[3];
	  // 新V START
	  $lastMonthDate = $NowDatePart[0].$lastMonthYear.$lastMonth.$NowDatePart[3];
	  // 新V END
	  /*=== 一個月前日期 END ===*/
	  /*=== 三個月前日期 START ===*/
	  $lastThreeMonth = $NowDatePart[2]-3;
	  $lastThreeMonthYear = $NowDatePart[1];
	  if($lastThreeMonth<=0){
		  $lastThreeMonth = 12+$lastThreeMonth;
		  $lastThreeMonthYear = $lastThreeMonthYear-1;
	  }
	  $lastThreeMonthPart = str_split($lastThreeMonth);
	  if(count($lastThreeMonthPart)==1){
		  $lastThreeMonth = "0".$lastThreeMonth;
	  }
	  // 原V $lastThreeMonthDate = $NowDatePart[0].$lastThreeMonthYear."-".$lastThreeMonth."-".$NowDatePart[3];
      // 新V START
	  $lastThreeMonthDate = $NowDatePart[0].$lastThreeMonthYear.$lastThreeMonth.$NowDatePart[3];
	  // 新V END
	  /*=== 三個月前日期 END ===*/
	  /*=== 六個月前日期 START ===*/
	  $lastSixMonth = $NowDatePart[2]-6;
	  $lastSixMonthYear = $NowDatePart[1];
	  if($lastSixMonth<=0){
		  $lastSixMonth = 12+$lastSixMonth;
		  $lastSixMonthYear = $lastSixMonthYear-1;
	  }
	  $lastSixMonthPart = str_split($lastSixMonth);
	  if(count($lastSixMonthPart)==1){
		  $lastSixMonth = "0".$lastSixMonth;
	  }
	  // 原V $lastSixMonthDate = $NowDatePart[0].$lastSixMonthYear."-".$lastSixMonth."-".$NowDatePart[3];
	  // 新V START
	  $lastSixMonthDate = $NowDatePart[0].$lastSixMonthYear.$lastSixMonth.$NowDatePart[3];
	  // 新V END
      /*=== 六個月前日期 END ===*/
	  /*=== 一個月前體重 START ===*/
	  $db4 = new DB;
	  // 原V $db4->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` >= '".$lastMonthDate."' ORDER BY `RecordedTime` ASC LIMIT 0,1");
	  // 新V START
	  $db4->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' AND `date` >= '".$lastMonthDate."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
	  if ($db4->num_rows()>0) {
		  $r4 = $db4->fetch_assoc();
		  $lastMonthWeight = $r4['Value'];
		  $lastMonthWeight = str_split($lastMonthWeight);
		  if(count($lastMonthWeight)==2){
			  $turnlastMonthWeight = $lastMonthWeight;
			  $lastMonthWeight[0] =0;
			  $lastMonthWeight[1] = $turnlastMonthWeight[0];
			  $lastMonthWeight[2] = $turnlastMonthWeight[1];
		  }
		  $lastMonthWeight = $lastMonthWeight[0].$lastMonthWeight[1].$lastMonthWeight[2];
		  $lastMonthWeightchange = round(((($NowWeight)-$lastMonthWeight)/$lastMonthWeight)*100,2);
	  }
	  /*=== 一個月前體重 END ===*/
	  /*=== 三個月前體重 START ===*/
	  $db3 = new DB;
	  // 原V $db3->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` >= '".$lastThreeMonthDate."' ORDER BY `RecordedTime` ASC LIMIT 0,1");
	  // 新V START
	  $db3->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' AND `date` >= '".$lastThreeMonthDate."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
	  if ($db3->num_rows()>0) {
		  $r3 = $db3->fetch_assoc();
		  $lastThreeMonthWeight = $r3['Value'];
		  $lastThreeMonthWeight = str_split($lastThreeMonthWeight);
		  if(count($lastThreeMonthWeight)==2){
			  $turnlastThreeMonthWeight = $lastThreeMonthWeight;
			  $lastThreeMonthWeight[0] =0;
			  $lastThreeMonthWeight[1] = $turnlastThreeMonthWeight[0];
			  $lastThreeMonthWeight[2] = $turnlastThreeMonthWeight[1];
		  }
		  $lastThreeMonthWeight = $lastThreeMonthWeight[0].$lastThreeMonthWeight[1].$lastThreeMonthWeight[2];
		  $lastThreeMonthWeightchange = round(((($NowWeight)-$lastThreeMonthWeight)/$lastThreeMonthWeight)*100,2);
	  }
	  /*=== 三個月前體重 END ===*/
	  /*=== 六個月前體重 START ===*/
	  $db3 = new DB;
	  // 原V $db3->query("SELECT `Value` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` >= '".$lastSixMonthDate."' ORDER BY `RecordedTime` ASC LIMIT 0,1");
	  // 新V START
	  $db3->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' AND `date` >= '".$lastSixMonthDate."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
	  if ($db3->num_rows()>0) {
		  $r3 = $db3->fetch_assoc();
		  $lastSixMonthWeight = $r3['Value'];
		  $lastSixMonthWeight = str_split($lastSixMonthWeight);
		  if(count($lastSixMonthWeight)==2){
			  $turnlastSixMonthWeight = $lastSixMonthWeight;
			  $lastSixMonthWeight[0] =0;
			  $lastSixMonthWeight[1] = $turnlastSixMonthWeight[0];
			  $lastSixMonthWeight[2] = $turnlastSixMonthWeight[1];
		  }
		  $lastSixMonthWeight = $lastSixMonthWeight[0].$lastSixMonthWeight[1].$lastSixMonthWeight[2];
		  $lastSixMonthWeightchange = round(((($NowWeight)-$lastSixMonthWeight)/$lastSixMonthWeight)*100,2);
	  }
	  /*=== 六個月前體重 END ===*/
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Resident's health assessment</h3>
<table width="100%">
  <tr>
    <td colspan="3" class="title">Record date</td>
    <td class="title" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="60" rowspan="11" class="title">Cardiopulmonary<br>function</td>
    <td colspan="2" class="title_s" width="140">Heart rhythm</td>
    <td colspan="3"><?php echo draw_option("Q1","Normal rhythm;Arrhythmia","xm","multi",$Q1,false,0); ?><input type="text" name="Q3" id="Q3" size="3" value="<?php echo $Q3; ?>" >times/minute</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Respiratory patterns</td>
    <td colspan="3"><?php echo draw_option("Q2","Normal;Gasping;Mouth breathing;Need oxygen supply;Other","l","multi",$Q2,true,3); ?> <input type="text" name="Q2a" id="Q2a" size="6"  value="<?php echo $Q2a; ?>" >times/minute</td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Breathing sound</td>
    <td colspan="3"><?php echo draw_option("Q4","N: Normal;S: small sound;No sound;Ra: rales;Rh: rhonchi;W: wheezing; O:Other","xm","multi",$Q4,true,4); ?> <input type="text" name="Q5" id="Q5"  value="<?php echo $Q5; ?>" size="20" ></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Shortness of Breath</td>
    <td colspan="3"><?php echo draw_option("Q68","Exertion;Sitting at rest;Lying flat","l","multi",$Q68,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" class="title_s">Sputum</td>
    <td colspan="3"><?php echo draw_option("Q6","Self cough;Sputum suction;None","xm","multi",$Q6,false,4); ?> <input type="text" name="Q7" id="Q7" size="20"  value="<?php echo $Q7; ?>" ></td>
  </tr>
  <tr>
    <td width="120" colspan="3">Amount <input type="text" name="Q8" id="Q8" size="8"  value="<?php echo $Q8; ?>" > 
    Characteristics 
      <input type="text" name="Q9" id="Q9" size="8"  value="<?php echo $Q9; ?>"> Color <input type="text" name="Q10" id="Q10" size="8"  value="<?php echo $Q10; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Tobacco Use</td>
    <td colspan="3"><?php echo draw_option("Q69","No;Yes","l","single",$Q69,false,0); ?></td>
  </tr>
  <tr>
    <td rowspan="4" class="title_s" width="60">Limb edema</td>
    <td class="title_s" width="40">Right hand</td>
    <td colspan="3"><?php echo draw_option("Q11","-;+;++;+++;++++;+++++","m","multi",$Q11,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left hand</td>
    <td colspan="3"><?php echo draw_option("Q12","-;+;++;+++;++++;+++++","m","multi",$Q12,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Right leg</td>
    <td colspan="3"><?php echo draw_option("Q13","-;+;++;+++;++++;+++++","m","multi",$Q13,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Left leg</td>
    <td colspan="3"><?php echo draw_option("Q14","-;+;++;+++;++++;+++++","m","multi",$Q14,false,0); ?></td>
    </tr>
  <tr>
    <td rowspan="6" class="title">State of <br>consciousness</td>
    <td colspan="2" class="title_s">Consciousness (appearance)</td>
    <td colspan="3">
	  <?php echo draw_option("Q15","Clear & aware;Orderless;Delirium;Somnolence;Stupor;vegetative being;Coma;Other","xm","multi",$Q15,true,5); ?> <input type="text" id="Q16" name="Q16" size="30"  value="<?php echo $Q16; ?>"><br>
	  <b>Did the resident have altered level of consciousness?</b><br>
	  (e.g., vigilant - startled easily to any sound or touch; lethargic - repeatedly dozed off when being asked questions, <br>but responded to voice or touch; stuporous - very difficult to arouse and keep aroused for the interview; <br>comatose - could not be aroused)<br>
	  <?php echo draw_checkbox("Q85","Behavior not present;Behavior continuously present, does not fluctuate;Behavior present, fluctuates (comes and goes, changes in severity)",$Q85,"single"); ?>
	</td>
  </tr>
  <tr>
    <td rowspan="3" class="title_s">GCS : EMV</td>
    <td class="title_s">E</td>
    <td colspan="3"><?php echo draw_option("Q17","1;2;3;4","s","single",$Q17,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">M</td>
    <td colspan="3"><?php echo draw_option("Q18","1;2;3;4;5;6","s","single",$Q18,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">V</td>
    <td colspan="3"><?php echo draw_option("Q19","1;2;3;4;5;T;E;A","s","single",$Q19,false,0); ?></td>
    </tr>
  <tr>
    <td rowspan="2" class="title_s">Eye reaction to light
    <td class="title_s">Left eye</td>
    <td colspan="3"><?php echo draw_option("Q20","Normal;Dilate;Trace;Cata;Prosthetic eye","xm","multi",$Q20,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Right eye</td>
    <td colspan="3"><?php echo draw_option("Q21","Normal;Dilate;Trace;Cata;Prosthetic eye","xm","multi",$Q21,false,0); ?></td>
    </tr>
  <tr>
    <td rowspan="16" class="title">Nutritional status <br>and water intake</td>
    <td colspan="2" class="title_s">Nutritional pathway</td>
    <td colspan="3"><?php echo draw_option("Q22","Oral;Nasogastric tube;Gastrostomy;Parenteral/IV feeding;Other","l","multi",$Q22,true,3); ?> <input type="text" id="Q23" name="Q23" size="30"  value="<?php echo $Q23; ?>"></td>
    </tr>
  <tr>
    <td colspan="2" class="title_s">Eating patterns</td>
    <td colspan="3"><?php echo draw_option("Q24","General;Meat only;Vegetarian;Soft food;Crushed;Mushy;Self-made liquid;Liquid  formula","xm","multi",$Q24,true,5); ?><input type="text" id="Q24a" name="Q24a" size="6"  value="<?php echo $Q24a; ?>">kcal/d</td>
    </tr>
  <tr>
    <td colspan="2" class="title_s">Skin</td>
    <td colspan="3"><?php echo draw_option("Q25","Intact;Defects","m","multi",$Q25,false,0); ?></td>
    </tr>
  <tr>
    <td colspan="2" class="title_s">Mouth</td>
    <td colspan="3"><?php echo draw_option("Q26","Normal;Pain;Discomfort;Difficulty with chewing;Unable to determine","xl","multi",$Q26,true,3); ?></td>
    </tr>
  <tr>
    <td colspan="2" class="title_s">Mouth tissue</td>
    <td colspan="3"><?php echo draw_option("Q27","Reddish pink;Pale;Redness/erythema;Submucosal bleeding;Ulcers;Masses;Oral lesions;Unable to determine","l","multi",$Q27,true,4); ?></td>
    </tr>
  <tr>
    <td colspan="2" class="title_s">Gums</td>
    <td colspan="3"><?php echo draw_option("Q28","Normal;Mild inflammation;Moderate inflammation;Severe inflammation;bleeding;Unable to determine","xl","multi",$Q28,true,3); ?></td>
  </tr>
  <tr>
    <td rowspan="3" colspan="1" class="title_s">Teeth</td>
	<td colspan="1" class="title_s">Status</td>
    <td colspan="3"><?php echo draw_option("Q29","Not affect mastication;Affect mastication;Not by oral intake","xl","multi",$Q29,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="1" class="title_s">Natural teeth</td>
    <td colspan="3"><?php echo draw_option("Q75","Normal;Loose;Cavity;Broken;No natural teeth;Tooth fragment;Edentulous;Unable to determine","l","multi",$Q75,true,4); ?></td>
  </tr>
  <tr>
    <td colspan="1" class="title_s">Denture</td>
    <td colspan="3"><?php echo draw_option("Q76","Normal;Chipped;Cracked;Uncleanable;Loose;Unable to determine","l","multi",$Q76,true,3); ?></td>
  </tr>
  <tr>
    <td rowspan="5" colspan="1" class="title_s">Swallow</td>
    <td colspan="2" class="title_s">Swallowing ability</td>
	<td colspan="2"><?php echo draw_option("Q30","Unable;Able","l","single",$Q30,true,3); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Loss of liquids/solids from mouth when eating or drinking</td>
    <td colspan="2"><?php echo draw_option("Q71","No;Yes","l","single",$Q71,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Holding food in mouth/cheeks or residual food in mouth after meals</td>
    <td colspan="2"><?php echo draw_option("Q72","No;Yes","l","single",$Q72,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Coughing or choking during meals or when swallowing medications</td>
    <td colspan="2"><?php echo draw_option("Q73","No;Yes","l","single",$Q73,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Complaints of difficulty or pain with swallowing</td>
    <td colspan="2"><?php echo draw_option("Q74","No;Yes","l","single",$Q74,false,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Weight change</td>
    <td colspan="3">
	&nbsp;&nbsp;
	<b>Last month:</b>&nbsp;<input type="text" name="Q31" id="Q31" size="10" value="<?php if($tabsID==0){echo $lastMonthWeightchange;}else{echo $Q31;} ?>"><b>%</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>Last 3 month:</b>&nbsp;<input type="text" name="Q31a" id="Q31a" size="10" value="<?php if($tabsID==0){echo $lastThreeMonthWeightchange;}else{echo $Q31a;} ?>"><b>%</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>Last 6 month:</b>&nbsp;<input type="text" name="Q31b" id="Q31b" size="10" value="<?php if($tabsID==0){echo $lastSixMonthWeightchange;}else{echo $Q31b;} ?>"><b>%</b>
	</td>
  </tr>
  <tr>
    <td colspan="3" class="title_s">Physician-prescribed weight management regimen</td>
	<td colspan="2"><?php echo draw_option("Q79","None;Weight-loss;Weight-gain","m","single",$Q79,false,2); ?></td>
  </tr>
  <tr>
    <td rowspan="18" class="title">Excretory<br />function</td>
    <td rowspan="3" class="title_s" colspan="2">Urinary Toileting Program</td>
    <td class="title_s" colspan="1">Has a trial of a toileting program</td>
	<td colspan="2"><?php echo draw_option("Q61","No;Yes;Unable to determine","l","single",$Q61,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Response</td>
    <td colspan="2"><?php echo draw_option("Q62","No improvement;Decreased wetness;Completely dry;Unable to determine or trial in progress","xxxl","single",$Q62,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Is a toileting program currently being used to manage the resident's urinary continence?</td>
    <td colspan="2"><?php echo draw_option("Q63","No;Yes","s","single",$Q63,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="2" rowspan="2">Urinary Continence</td>
	<td colspan="3"><ol><li>Always continent<li>Occasionally incontinent (less than 7 episodes of incontinence)<li>Occasionally incontinent (less than 7 episodes of incontinence)<li>Always incontinent (no episodes of continent voiding)<li>Not rated, resident had a catheter (indwelling, condom), urinary ostomy, or no urine output for the entire 7 days</ol></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Select the one category that best describes the resident</td>
	<td colspan="2"><?php echo draw_option("Q64","1;2;3;4;5","s","single",$Q64,false,5); ?></td>
  </tr>
  <tr>
    <td rowspan="3" class="title_s">Urinary symptoms</td>
    <td class="title_s">Color</td>
    <td colspan="3">
    <select name="Q32a" id="Q32a">
      <option></option>
      <option value="1" <?php if ($Q32a==1) echo " selected"; ?>>Light yellow</option>
      <option value="3" <?php if ($Q32a==2) echo " selected"; ?>>Intense yellow</option>
      <option value="2" <?php if ($Q32a==3) echo " selected"; ?>>Brown</option>
      <option value="3" <?php if ($Q32a==4) echo " selected"; ?>>Hematuria</option>
      <option value="7" <?php if ($Q32a==5) echo " selected"; ?>>Other</option>
    </select>，<input type="text" name="Q32" id="Q32" size="10" value="<?php echo $Q32; ?>">	
    </td>
  </tr>
  <tr>
    <td class="title_s">Clear</td>
    <td colspan="3"><?php echo draw_option("Q33","Clear;Turbid","m","multi",$Q33,false,0); ?></td>
  </tr>
  <tr>
    <td class="title_s">Sediments</td>
    <td colspan="3"><?php echo draw_option("Q34","Has;None","m","multi",$Q34,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Urination treatment</td>
    <td colspan="3"><?php echo draw_option("Q35","Toilet or urinal (potty chair);Diapers;Catheter;Intermittent catheterization;Indwelling catheter;External catheter;Other","xxl","multi",$Q35,true,2); ?> <input type="text" name="Q36" id="Q36" size="46" value="<?php echo $Q36; ?>"></td>
  </tr>
  <tr>
    <td class="title_s" colspan="2" rowspan="1">Bowel Toileting Program</td>
    <td class="title_s" colspan="1">Is a toileting program currently being used to manage the resident's bowel continence?</td>
	<td colspan="2"><?php echo draw_option("Q65","No;Yes","m","single",$Q65,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="2" rowspan="2">Bowel Continence</td>
	<td colspan="3"><ol><li>Always continent<li>Occasionally incontinent (one episode of bowel incontinence)<li>Frequently incontinent (2 or more episodes of bowel incontinence, but at least one continent bowel movement)<li>Always incontinent (no episodes of continent bowel movements)<li>Not rated, resident had an ostomy or did not have a bowel movement for the entire 7 days</ol></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Select the one category that best describes the resident</td>
	<td colspan="2"><?php echo draw_option("Q66","1;2;3;4;5","s","single",$Q66,false,5); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Abdominal sounds</td>
    <td colspan="3"><?php echo draw_option("Q37","Normal(3~6 times/minute);Too slow (less than 2 times/minute);None(0 time/minute);Overspeed (more than 7 times/minute)","xxxl","multi",$Q37,true,2); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Flatulence </td>
    <td colspan="3"><?php echo draw_option("Q38","None;Yes","s","multi",$Q38,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Constipation</td>
    <td colspan="3"><?php echo draw_option("Q67","No;Yes","m","single",$Q67,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Lump(s)</td>
    <td colspan="3"><?php echo draw_option("Q39","None;Yes","s","multi",$Q39,false,0); ?> Note:<input type="text" name="Q40" id="Q40" size="46" value="<?php echo $Q40; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s" width="120">Stool color</td>
    <td width="200">
    <select name="Q41a" id="Q41a">
      <option></option>
      <option value="1" <?php if ($Q41a==1) echo " selected"; ?>>Yellow</option>
      <option value="2" <?php if ($Q41a==2) echo " selected"; ?>>Brown</option>
      <option value="3" <?php if ($Q41a==3) echo " selected"; ?>>Tan</option>
      <option value="4" <?php if ($Q41a==4) echo " selected"; ?>>Black</option>
      <option value="5" <?php if ($Q41a==5) echo " selected"; ?>>Gray</option>
      <option value="6" <?php if ($Q41a==6) echo " selected"; ?>>Dark green</option>
      <option value="7" <?php if ($Q41a==7) echo " selected"; ?>>Other</option>
    </select>，<input type="text" name="Q41" id="Q41" size="10" value="<?php echo $Q41; ?>"></td>
    <td width="120" class="title_s">Stool shape</td>
    <td><select name="Q41b" id="Q41b">
      <option></option>
      <option value="1" <?php if ($Q41b==1) echo " selected"; ?>>Soft</option>
      <option value="2" <?php if ($Q41b==2) echo " selected"; ?>>Hard</option>
      <option value="3" <?php if ($Q41b==3) echo " selected"; ?>>Loose</option>
      <option value="4" <?php if ($Q41b==4) echo " selected"; ?>>watery</option>
      <option value="5" <?php if ($Q41b==5) echo " selected"; ?>>Other</option>
    </select>，<input type="text" name="Q41c" id="Q41c" size="10" value="<?php echo $Q41c; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Defecation treatment</td>
    <td colspan="3"><?php echo draw_option("Q42","Normal defecation without medication;Stool softeners;Laxative;Enema;Digital removal of faeces(DRF);Ostomy;Other","xxxl","multi",$Q42,true,2); ?> <input type="text" name="Q42A" id="Q42A" size="21" value="<?php echo $Q42A; ?>"></td>
    </tr>
  <tr>
    <td rowspan="4" class="title">Symptoms in<br /> past 1 week</td>
    <td colspan="2" class="title_s">Frequency of pain</td>
    <td colspan="3"><?php echo draw_option("Q43","None;Less than daily;Pain daily;Unable to assess","xm","multi",$Q43,false,0); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Scale and body part/location of pain</td>
    <td valign="top" colspan="3">Resident subjective judgment or facial expression
	<table style="width:720px;">
      <tr class="title">
        <td width="20">&nbsp;</td>
        <td width="100">Body part</td>
        <td width="600">Pain scale</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><img src="Images/nurseform02b_pain01.png" height="60%" width="95%"/></td>
      </tr>
      <tr>
        <td>1.</td>
        <td><input type="text" name="Q44a" id="Q44a" size="6" value="<?php echo $Q44a; ?>"></td>
        <td><?php echo draw_option("Q44b","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q44b,false,0); ?></td>
      </tr>
      <tr>
        <td>2.</td>
        <td><input type="text" name="Q44c" id="Q44c" size="6" value="<?php echo $Q44c; ?>"></td>
        <td><?php echo draw_option("Q44d","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q44d,false,0); ?></td>
      </tr>
      <tr>
        <td>3.</td>
        <td><input type="text" name="Q44e" id="Q44e" size="6" value="<?php echo $Q44e; ?>"></td>
        <td><?php echo draw_option("Q44f","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q44f,false,0); ?></td>
      </tr>
      <tr>
        <td>4.</td>
        <td><input type="text" name="Q44g" id="Q44g" size="6" value="<?php echo $Q44g; ?>"></td>
        <td><?php echo draw_option("Q44h","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q44h,false,0); ?></td>
      </tr>
      <tr>
        <td>5.</td>
        <td><input type="text" name="Q44i" id="Q44i" size="6" value="<?php echo $Q44i; ?>"></td>
        <td><?php echo draw_option("Q44j","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q44j,false,0); ?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="title_s">Accidental injury</td>
    <td colspan="3">Characteristic:<input type="text" name="Q45" id="Q45" size="60" value="<?php echo $Q45; ?>"><br>part(s):<input type="text" name="Q46" id="Q46" size="60" value="<?php echo $Q46; ?>"></td>
    </tr>
  <tr>
    <td colspan="2" class="title_s">Abnormal conditions</td>
    <td colspan="3"><?php echo draw_option("Q47","None;Vomiting;Internal bleeding;Pleural sense of suffocation;Dizziness;Hallucination;Delusions;Fever;Dehydrated;Other","xl","multi",$Q47,true,3); ?> <input type="text" name="Q48" id="Q48" size="30" value="<?php echo $Q48; ?>"></td>
  </tr>
  <tr>
    <td rowspan="1" class="title">Prognosis</td>
    <td colspan="4" class="title_s">Does the resident have a condition or chronic disease that may result in a <br>life expectancy of less than 6 months? (Requires physician documentation)</td>
    <td colspan="1"><?php echo draw_option("Q70","No;Yes","m","single",$Q70,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" rowspan="13">Limb movement</td>
    <td class="title_s" colspan="2">Joint activity</td>
    <td width="270">
        <table style="width:100%;">
   	      <tr style="height:86px;">
	        <td valign="bottom">
              Right upper limb
              <select name="Q50b" id="Q50b">
		        <option value=""></option>
                <option value="0" <?php if ($Q50b=="0") { echo " selected"; } ?>>0 (Rigid)</option>
                <option value="1" <?php if ($Q50b=="1") { echo " selected"; } ?>>1</option>
                <option value="2" <?php if ($Q50b=="2") { echo " selected"; } ?>>2</option>
                <option value="3" <?php if ($Q50b=="3") { echo " selected"; } ?>>3 (Contracture)</option>
                <option value="4" <?php if ($Q50b=="4") { echo " selected"; } ?>>4</option>
                <option value="5" <?php if ($Q50b=="5") { echo " selected"; } ?>>5</option>
                <option value="6" <?php if ($Q50b=="6") { echo " selected"; } ?>>6 (Normal)</option>
		      </select>
		    </td>
	        <td rowspan="2"><center><img src="module/nurseform/img/pic1.png" width="140" border="0"></center></td>
	        <td valign="bottom">
            Left upper limb
            <select name="Q50a" id="Q50a">
              <option value=""></option>
              <option value="0" <?php if ($Q50a=="0") { echo " selected"; } ?>>0 (Rigid)</option>
              <option value="1" <?php if ($Q50a=="1") { echo " selected"; } ?>>1</option>
              <option value="2" <?php if ($Q50a=="2") { echo " selected"; } ?>>2</option>
              <option value="3" <?php if ($Q50a=="3") { echo " selected"; } ?>>3 (Contracture)</option>
              <option value="4" <?php if ($Q50a=="4") { echo " selected"; } ?>>4</option>
              <option value="5" <?php if ($Q50a=="5") { echo " selected"; } ?>>5</option>
              <option value="6" <?php if ($Q50a=="6") { echo " selected"; } ?>>6 (Normal)</option>
            </select>
		    </td>
	      </tr>
	      <tr>
	        <td valign="bottom">
              Right lower limb
              <select name="Q50d" id="Q50d">
			    <option value=""></option>
                <option value="0" <?php if ($Q50d=="0") { echo " selected"; } ?>>0 (Rigid)</option>
                <option value="1" <?php if ($Q50d=="1") { echo " selected"; } ?>>1</option>
                <option value="2" <?php if ($Q50d=="2") { echo " selected"; } ?>>2</option>
                <option value="3" <?php if ($Q50d=="3") { echo " selected"; } ?>>3 (Contracture)</option>
                <option value="4" <?php if ($Q50d=="4") { echo " selected"; } ?>>4</option>
                <option value="5" <?php if ($Q50d=="5") { echo " selected"; } ?>>5</option>
                <option value="6" <?php if ($Q50d=="6") { echo " selected"; } ?>>6 (Normal)</option>
			  </select>
			</td>
            <td valign="bottom">
              Left lower limb
              <select name="Q50c" id="Q50c">
			  <option value=""></option>
              <option value="0" <?php if ($Q50c=="0") { echo " selected"; } ?>>0 (Rigid)</option>
              <option value="1" <?php if ($Q50c=="1") { echo " selected"; } ?>>1</option>
              <option value="2" <?php if ($Q50c=="2") { echo " selected"; } ?>>2</option>
              <option value="3" <?php if ($Q50c=="3") { echo " selected"; } ?>>3 (Contracture)</option>
              <option value="4" <?php if ($Q50c=="4") { echo " selected"; } ?>>4</option>
              <option value="5" <?php if ($Q50c=="5") { echo " selected"; } ?>>5</option>
              <option value="6" <?php if ($Q50c=="6") { echo " selected"; } ?>>6 (Normal)</option>
			  </select>
		    </td>
	      </tr>
        </table>	
    </td>
    <td class="title_s">Muscle strength</td>
    <td>
        <table style="width:100%;">
 	      <tr style="height:86px;">
	        <td valign="bottom" width="50">Right upper limb<select name="Q51b" id="Q51b"><option value=""></option><option value="0" <?php if ($Q51b=="0") { echo " selected"; } ?>>0</option><option value="1" <?php if ($Q51b=="1") { echo " selected"; } ?>>1</option><option value="2" <?php if ($Q51b=="2") { echo " selected"; } ?>>2</option><option value="3" <?php if ($Q51b=="3") { echo " selected"; } ?>>3</option><option value="4" <?php if ($Q51b=="4") { echo " selected"; } ?>>4</option><option value="5" <?php if ($Q51b=="5") { echo " selected"; } ?>>5</option></select></td>
	        <td rowspan="2"><center><img src="module/nurseform/img/pic1.png" width="140" border="0"></center></td>
	        <td valign="bottom" width="50">Left upper limb<select name="Q51a" id="Q51a"><option value=""></option><option value="0" <?php if ($Q51a=="0") { echo " selected"; } ?>>0</option><option value="1" <?php if ($Q51a=="1") { echo " selected"; } ?>>1</option><option value="2" <?php if ($Q51a=="2") { echo " selected"; } ?>>2</option><option value="3" <?php if ($Q51a=="3") { echo " selected"; } ?>>3</option><option value="4" <?php if ($Q51a=="4") { echo " selected"; } ?>>4</option><option value="5" <?php if ($Q51a=="5") { echo " selected"; } ?>>5</option></select></td>
	      </tr>
	      <tr>
	        <td valign="bottom">Right lower limb<select name="Q51d" id="Q51d"><option value=""></option><option value="0" <?php if ($Q51d=="0") { echo " selected"; } ?>>0</option><option value="1" <?php if ($Q51d=="1") { echo " selected"; } ?>>1</option><option value="2" <?php if ($Q51d=="2") { echo " selected"; } ?>>2</option><option value="3" <?php if ($Q51d=="3") { echo " selected"; } ?>>3</option><option value="4" <?php if ($Q51d=="4") { echo " selected"; } ?>>4</option><option value="5" <?php if ($Q51d=="5") { echo " selected"; } ?>>5</option></select></td>
	        <td valign="bottom">Left lower limb<select name="Q51c" id="Q51c"><option value=""></option><option value="0" <?php if ($Q51c=="0") { echo " selected"; } ?>>0</option><option value="1" <?php if ($Q51c=="1") { echo " selected"; } ?>>1</option><option value="2" <?php if ($Q51c=="2") { echo " selected"; } ?>>2</option><option value="3" <?php if ($Q51c=="3") { echo " selected"; } ?>>3</option><option value="4" <?php if ($Q51c=="4") { echo " selected"; } ?>>4</option><option value="5" <?php if ($Q51c=="5") { echo " selected"; } ?>>5</option></select></td>
	      </tr>
        </table>	
    </td>
  </tr>
  <tr>
    <td class="title_s" colspan="2" rowspan="3">Functional Limitation in Range of Motion</td>
	<td colspan="3"><ol><li>No impairment<li>Impairment on one side<li>Impairment on both sides</ol></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Upper extremity (shoulder, elbow, wrist, hand)</td>
	<td colspan="2"><?php echo draw_option("Q77","1;2;3","m","single",$Q77,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Lower extremity (hip, knee, ankle, foot)</td>
	<td colspan="2"><?php echo draw_option("Q78","1;2;3","m","single",$Q78,false,5); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="2" rowspan="8">Balance</td>
	<td colspan="3"><ol><li>Steady at all times<li>Not steady, but able to stabilize without staff assistance<li>Not steady, only able to stabilize with staff assistance<li>Activity did not occur</ol></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Sit</td>
	<td colspan="2"><?php echo draw_option("Q52","1;2;3;4","m","single",$Q52,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Stand</td>
	<td colspan="2"><?php echo draw_option("Q53","1;2;3;4","m","single",$Q53,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Moving from seated to standing position</td>
	<td colspan="2"><?php echo draw_option("Q54","1;2;3;4","m","single",$Q54,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Walking <br>(with assistive device if used)</td>
	<td colspan="2"><?php echo draw_option("Q56","1;2;3;4","m","single",$Q56,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Turning around and facing the opposite direction while walking</td>
	<td colspan="2"><?php echo draw_option("Q57","1;2;3;4","m","single",$Q57,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Moving on and off toilet</td>
	<td colspan="2"><?php echo draw_option("Q58","1;2;3;4","m","single",$Q58,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="1">Surface-to-surface transfer <br>(transfer between bed and chair or wheelchair)</td>
	<td colspan="2"><?php echo draw_option("Q59","1;2;3;4","m","single",$Q59,true,2); ?></td>
  </tr>
  <tr>
    <td class="title_s" colspan="2">Mobility Devices</td>
	<td colspan="3"><?php echo draw_option("Q60","Cane/crutch;Walker;Wheelchair;Limb prosthesis;None","xm","multi",$Q60,false,5); ?></td>
  </tr>
  <tr>
    <td class="title" >nursing</td>
    <td class="title_s" colspan="2">Implementation</td>
    <td colspan="3"><?php echo draw_option("Q55","Steam inhalation;Postural drainage;airway suctioning;Wound care","l","multi",$Q55,false,5); ?><br>Note:<input type="text" name="Q55a" id="Q55a" size="60" value="<?php echo $Q55a; ?>"></td>
   </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" width="350">Resident's preference to avoid being asked if he/she wants to return to community on comprehensive assessments</td>
    <td><?php echo draw_option("Q80","No;Yes;Information not available","xl","single",$Q80,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Resident wants to talk to someone about returning to community</td>
    <td><?php echo draw_option("Q81","No;Yes;Unknown or uncertain","xl","single",$Q81,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Resident's preference to avoid being asked if he/she wants to return to community on all assessments</td>
    <td><?php echo draw_option("Q82","No;Yes;Information not available","xl","single",$Q82,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Indicate information source for the question above</td>
    <td><?php echo draw_checkbox_2col("Q83","Resident;Family or significant other;Guardian or legally authorized representative;No information source available",$Q83,single); ?></td>
  </tr>
  <tr>
    <td class="title">Has a referral been made to the Local Contact Agency</td>
    <td><?php echo draw_option("Q84","No (not needed);No (is or may be needed);Yes","xl","single",$Q84,false,5); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>

  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02b" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<br><br>
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