<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform11d` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform11d` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<center>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Resident's activity demand assessment</h3>
<body>
<table width="100%" border="0">
  <tr>
  	<td class="title" colspan="6">1. Mini–mental state examination : MMSE Out of 30 points</td>
  </tr>
<?php
if ($_GET['date']=="") {
	$dbMMSE = new DB;
	$dbMMSE->query("SELECT 
	(Q1_2 + Q2_2 + Q3_2 + Q4_2 + Q5_2 + Q6_2 + Q7_2 + Q8_2 + Q9_2 + Q10_2) A1,
	(Q11_2 + Q12_2 + Q13_2 + Q15_2 + Q16_2 + Q17_2 + Q18_2 + Q19_2) A2,
	(Q20_2 + Q21_2 + Q22_2) A3,
	(Q23_2 + Q24_2 + Q25_2 + Q26_2 + Q30_2) A4,
	(Q27_2 + Q28_2 + Q29_2) A5, 
	(Q31_2 ) A6, 
	(Q32) 
	FROM  `nurseform02h` 
	WHERE  `HospNo` ='".mysql_escape_string($HospNo)."'
	ORDER BY  `date` DESC 
	LIMIT 0 , 1");
	$MMSE = $dbMMSE->fetch_assoc();
	$Q1 = $MMSE['A1'];
	$Q2 = $MMSE['A2'];
	$Q3 = $MMSE['A3'];
	$Q4 = $MMSE['A4'];
	$Q5 = $MMSE['A5'];
	$Q6 = $MMSE['A6'];
	$Qtotal = $MMSE['Q32'];
}
?>  <!--https://en.wikipedia.org/wiki/Mini%E2%80%93mental_state_examination-->
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">1）定向感Orientation</td>
    <td><input type="text" id="Q1" name="Q1" size="5" value="<?php echo $Q1; ?>"/>(Out of 10 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">2）注意力Attention</td>
    <td><input type="text" id="Q2" name="Q2" size="5" value="<?php echo $Q2; ?>"/>(Out of 8 points)</td>
	<td class="title_s" style="text-align:left;width:150px;">3）記憶力Recall</td>
    <td><input type="text" id="Q3" name="Q3" size="5" value="<?php echo $Q3; ?>"/>(Out of 3 points)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">4）語言理解力Language comprehension</td>
    <td><input type="text" id="Q4" name="Q4" size="5" value="<?php echo $Q4; ?>"/>(Out of 5 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">5）口語理解及執行力Oral comprehension and execution</td>
    <td><input type="text" id="Q5" name="Q5" size="5" value="<?php echo $Q5; ?>"/>(Out of 3 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">6）建構力Construction</td>
    <td><input type="text" id="Q6" name="Q6" size="5" value="<?php echo $Q6; ?>"/>(Out of 1 point)</td>
  </tr>
  <tr>
    <td colspan="6" >Preliminary assessment scores:
    <span id="total"><?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?></span>
    <input type="hidden" name="Qtotal" id="Qtotal" value="<?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?>" />Score
    </td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
  	<td class="title" colspan="6">2. Activities of Daily Living: ADL Out of 100 points</td>
  </tr>
<?php
if ($_GET['date']=="") {
	$dbADL = new DB;
	$dbADL->query("SELECT 
	(IF( Q1_1 =  '1',  '10',  '0' ) + IF( Q1_2 =  '1',  '5',  '0' ))A7,
	(IF( Q2_1 =  '1',  '15',  '0' ) + IF( Q2_2 =  '1',  '10',  '0' ) + + IF( Q2_3 =  '1',  '5',  '0' ))A8,
	(IF( Q3_1 =  '1',  '5',  '0' ))A9, 
	(IF( Q8_1 =  '1',  '10',  '0' ) + IF( Q8_2 =  '1',  '5',  '0' ))A10, 
	(IF( Q6_1 =  '1',  '15',  '0' ) + IF( Q6_2 =  '1',  '10',  '0' ) + + IF( Q6_3 =  '1',  '5',  '0' ))A11, 
	(IF( Q7_1 =  '1',  '10',  '0' ) + IF( Q7_2 =  '1',  '5',  '0' ))A12, 
	(IF( Q4_1 =  '1',  '10',  '0' ) + IF( Q4_2 =  '1',  '5',  '0' ))A13, 
	(IF( Q5_1 =  '1',  '5',  '0' ))A14, 
	(IF( Q9_1 =  '1',  '10',  '0' ) + IF( Q9_2 =  '1',  '5',  '0' ))A15, 
	(IF( Q10_1 =  '1',  '10',  '0' ) + IF( Q10_2 =  '1',  '5',  '0' ))A16, Qtotal
	FROM  `nurseform02c` 
	WHERE  `HospNo` ='".mysql_escape_string($HospNo)."'
	ORDER BY  `date` DESC 
	LIMIT 0 , 1");
	$ADL = $dbADL->fetch_assoc();
	$Q7 =  $ADL['A7'];
	$Q8 =  $ADL['A8'];
	$Q9 =  $ADL['A9'];
	$Q10 = $ADL['A10'];
	$Q11 = $ADL['A11'];
	$Q12 = $ADL['A12'];
	$Q13 = $ADL['A13'];
	$Q14 = $ADL['A14'];
	$Q15 = $ADL['A15'];
	$Q16 = $ADL['A16'];
	$Qtotal1 = $ADL['Qtotal'];
	$Q17 = "";
	$Q18 = "";
}
?>  
  
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">1) FEEDING</td>
    <td><input type="text" id="Q7" name="Q7" size="5" value="<?php echo $Q7; ?>"/>(Out of 10 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">2）TRANSFERS </td>
    <td><input type="text" id="Q8" name="Q8" size="5" value="<?php echo $Q8; ?>"/>(Out of 15 points)</td>
	<td class="title_s" style="text-align:left;width:150px;">3）GROOMING</td>
    <td><input type="text" id="Q9" name="Q9" size="5" value="<?php echo $Q9; ?>"/>(Out of 5 points)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">4）DRESSING</td>
    <td><input type="text" id="Q10" name="Q10" size="5" value="<?php echo $Q10; ?>"/>(Out of 10 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">5）MOBILITY </td>
    <td><input type="text" id="Q11" name="Q11" size="5" value="<?php echo $Q11; ?>"/>(Out of 15 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">6）STAIRS</td>
    <td><input type="text" id="Q12" name="Q12" size="5" value="<?php echo $Q12; ?>"/>(Out of 10 points)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">7）TOILET</td>
    <td><input type="text" id="Q13" name="Q13" size="5" value="<?php echo $Q13; ?>"/>(Out of 10 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">8）BATHING</td>
    <td><input type="text" id="Q14" name="Q14" size="5" value="<?php echo $Q14; ?>"/>(Out of 5 points)</td>
    <td class="title_s" style="text-align:left;width:150px;">9）BOWELS</td>
    <td><input type="text" id="Q15" name="Q15" size="5" value="<?php echo $Q15; ?>"/>(Out of 10 points)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">10）BLADDER</td>
    <td><input type="text" id="Q16" name="Q16" size="5" value="<?php echo $Q16; ?>"/>(Out of 10 points)</td>
    <td colspan="4">Preliminary assessment scores: <span id="total1"><?php if ($Qtotal1==NULL) { echo "0"; } else { echo  $Qtotal1; } ?></span>
      <input type="hidden" name="Qtotal1" id="Qtotal1" value="<?php if ($Qtotal1==NULL) { echo "0"; } else { echo  $Qtotal1; } ?>" />Score</td>
  </tr>
  <tr>
    <td class="title_s" style="width:150px;">Physical disabilities</td>
    <td colspan="2"><input type="text" id="Q17" name="Q17" value="<?php echo $Q17; ?>"/></td>
    <td class="title_s" style="width:150px;">Use assistive device</td>
    <td colspan="2"><input type="text" id="Q18" name="Q18" value="<?php echo $Q18; ?>"/></td>
  </tr>
  <tr>
  	<td colspan="6">Note: 0 point entirely dependent；20-51 points considerable assistance；52-79 points medium assistance；80-99 points little assistance</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td colspan="7" class="title">3. Recent 3 years MMSE and ADL assessment compare</td>
  </tr>
  <tr>
    <td class="title_s" width="150">Date</td>
    <?php
	$arrYear = array();
	$arrMMSE3 = array();
	$arrMMSE12 = array();
	$arrADL3 = array();
	$arrADL12 = array();
	for ($i=date(Y);$i>(date(Y)-3);$i--) {
		$yy ++;
		if ($_GET['date']=="") {
			${'Q'.(31+$yy)} = $i;		
			
			//MMSE 3&12	
			$dbMMSE1 = new DB;
			$dbMMSE1->query("SELECT Q32 FROM `nurseform02h` WHERE  `HospNo` ='".mysql_escape_string($HospNo)."' AND left(`date`,4)= '".${'Q'.(31+$yy)}."'  AND `date` >= '".${'Q'.(31+$yy)}."0101' AND `date` <= '".${'Q'.(31+$yy)}."0630' ORDER BY `date` DESC LIMIT 0 , 1");
			$MMSE1 = $dbMMSE1->fetch_assoc();
			if ($dbMMSE1->num_rows()>0) {$MMSE3m = $MMSE1['Q32'];}else{$MMSE3m = 0;}
			
			$dbMMSE2 = new DB;
			$dbMMSE2->query("SELECT Q32 FROM `nurseform02h` WHERE  `HospNo` ='".mysql_escape_string($HospNo)."' AND left(`date`,4)= '".${'Q'.(31+$yy)}."' AND `date` >= '".${'Q'.(31+$yy)}."0701' AND `date` <= '".${'Q'.(31+$yy)}."1231' ORDER BY `date` DESC LIMIT 0 , 1");
			$MMSE2 = $dbMMSE2->fetch_assoc();
			if ($dbMMSE2->num_rows()>0) {$MMSE12m = $MMSE2['Q32'];}else{$MMSE12m = 0;}		
			
			//ADL 3&12
			$dbADL1 = new DB;
			$dbADL1->query("SELECT Qtotal FROM `nurseform02c` WHERE  `HospNo` ='".mysql_escape_string($HospNo)."' AND left(`date`,4)= '".${'Q'.(31+$yy)}."'  AND `date` >= '".${'Q'.(31+$yy)}."0101' AND `date` <= '".${'Q'.(31+$yy)}."0630' ORDER BY `date` DESC LIMIT 0 , 1");
			$ADL1 = $dbADL1->fetch_assoc();
			if ($dbADL1->num_rows()>0) {$ADL3m = $ADL1['Qtotal'];}else{$ADL3m = 0;}

			$dbADL2 = new DB;
			$dbADL2->query("SELECT Qtotal FROM `nurseform02c` WHERE  `HospNo` ='".mysql_escape_string($HospNo)."' AND left(`date`,4)= '".${'Q'.(31+$yy)}."'  AND `date` >= '".${'Q'.(31+$yy)}."0701' AND `date` <= '".${'Q'.(31+$yy)}."1231' ORDER BY `date` DESC LIMIT 0 , 1");
			$ADL2 = $dbADL2->fetch_assoc();
			if ($dbADL2->num_rows()>0) {$ADL12m = $ADL2['Qtotal'];}else{$ADL12m = 0;}
			
		}		
		array_push($arrMMSE3,$MMSE3m);
		array_push($arrMMSE12,$MMSE12m);
		array_push($arrADL3,$ADL3m);
		array_push($arrADL12,$ADL12m);
		//MMSE
	?>
    <td class="title_s" colspan="2"><input type="text" id="Q<?php echo 31+$yy;?>" name="Q<?php echo 31+$yy;?>" value="<?php echo ${'Q'.(31+$yy)}; ?>" size="5"/>Year</td>
    <?php
	}
    ?>
  </tr>
  <tr>
    <td class="title_s" width="150">Item(s)</td>
    <td width="120">3th month</td>
    <td width="120">12th month</td>
    <td width="120">3th month</td>
    <td width="120">12th month</td>
    <td width="120">3th month</td>
    <td width="120">12th month</td>
  </tr>
  <?php 
  if ($_GET['date']=="") {
	  $Q35 = $arrMMSE3[0];
	  $Q37 = $arrMMSE3[1];
	  $Q39 = $arrMMSE3[2];
	  $Q36 = $arrMMSE12[0];
	  $Q38 = $arrMMSE12[1];
	  $Q40 = $arrMMSE12[2];
	  $Q41 = $arrADL3[0];
	  $Q43 = $arrADL3[1];
	  $Q45 = $arrADL3[2];
	  $Q42 = $arrADL12[0];
	  $Q44 = $arrADL12[1];
	  $Q46 = $arrADL12[2];
	  $Qfiller1 = "";
	  $Qfiller2 = "";
	  $Qfiller3 = "";
	  $Qfiller4 = "";
	  $Qfiller5 = "";
	  $Qfiller6 = "";
  }
  ?>
  <tr>
    <td class="title_s" width="150">MMSE</td>
    <td><input type="text" id="Q35" name="Q35" value="<?php echo $Q35; ?>" size="5"/></td>
    <td><input type="text" id="Q36" name="Q36" value="<?php echo $Q36; ?>" size="5"/></td>
    <td><input type="text" id="Q37" name="Q37" value="<?php echo $Q37; ?>" size="5"/></td>
    <td><input type="text" id="Q38" name="Q38" value="<?php echo $Q38; ?>" size="5"/></td>
    <td><input type="text" id="Q39" name="Q39" value="<?php echo $Q39; ?>" size="5"/></td>
    <td><input type="text" id="Q40" name="Q40" value="<?php echo $Q40; ?>" size="5"/></td>
  </tr>
  <tr>
    <td class="title_s">ADL</td>
    <td><input type="text" id="Q41" name="Q41" value="<?php echo $Q41; ?>" size="5"/></td>
    <td><input type="text" id="Q42" name="Q42" value="<?php echo $Q42; ?>" size="5"/></td>
    <td><input type="text" id="Q43" name="Q43" value="<?php echo $Q43; ?>" size="5"/></td>
    <td><input type="text" id="Q44" name="Q44" value="<?php echo $Q44; ?>" size="5"/></td>
    <td><input type="text" id="Q45" name="Q45" value="<?php echo $Q45; ?>" size="5"/></td>
    <td><input type="text" id="Q46" name="Q46" value="<?php echo $Q46; ?>" size="5"/></td>
  </tr>
  <tr>
    <td class="title_s" width="150">Primary responsible nurse</td>
    <td><input type="text" id="Qfiller1" name="Qfiller1" value="<?php echo $Qfiller1; ?>" size="5"/></td>
    <td><input type="text" id="Qfiller2" name="Qfiller2" value="<?php echo $Qfiller2; ?>" size="5"/></td>
    <td><input type="text" id="Qfiller3" name="Qfiller3" value="<?php echo $Qfiller3; ?>" size="5"/></td>
    <td><input type="text" id="Qfiller4" name="Qfiller4" value="<?php echo $Qfiller4; ?>" size="5"/></td>
    <td><input type="text" id="Qfiller5" name="Qfiller5" value="<?php echo $Qfiller5; ?>" size="5"/></td>
    <td><input type="text" id="Qfiller6" name="Qfiller6" value="<?php echo $Qfiller6; ?>" size="5"/></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
  	<td class="title" colspan="6">4. Problematic behavior and abnormal emotions </td>
  </tr>
  <?php 
  if ($_GET['date']=="") {
	  $EMOdb = new DB;
	  $EMOdb->query("SELECT `QNO`, `Qtotal` FROM `careform11b` WHERE `HospNo` ='".mysql_escape_string($HospNo)."' ORDER BY  `date` DESC LIMIT 0 , 14");
	  if($EMOdb->num_rows() > 0 ){
		for($i1=0;$i1<$EMOdb->num_rows();$i1++){
			$EMO = $EMOdb->fetch_assoc();
			${'Q'.($EMO['QNO']+18)} = $EMO['Qtotal'];
		}
  	  } else {
		  for($i1=19;$i1<=32;$i1++){
			${'Q'.$i1} = '0';
		}
	  }
  }
  ?>  
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">1）Sleep disorder(s)</td>
    <td><input type="text" id="Q19" name="Q19" size="5" value="<?php echo $Q19; ?>"/>Time(s)</td>
    <td class="title_s" style="text-align:left;width:150px;">2) Repeat same action</td>
    <td><input type="text" id="Q20" name="Q20" size="5" value="<?php echo $Q20; ?>"/>Time(s)</td>
	<td class="title_s" style="text-align:left;width:150px;">3) Repeat same language</td>
    <td><input type="text" id="Q21" name="Q21" size="5" value="<?php echo $Q21; ?>"/>Time(s)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">4）Stool On Pants/Remove Diaper</td>
    <td><input type="text" id="Q22" name="Q22" size="5" value="<?php echo $Q22; ?>"/>Time(s)</td>
    <td class="title_s" style="text-align:left;width:150px;">5） Physical aggression</td>
    <td><input type="text" id="Q23" name="Q23" size="5" value="<?php echo $Q23; ?>"/>Time(s)</td>
	<td class="title_s" style="text-align:left;width:150px;">6）Cursing at others</td>
    <td><input type="text" id="Q24" name="Q24" size="5" value="<?php echo $Q24; ?>"/>Time(s)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">7）Irritability</td>
    <td><input type="text" id="Q25" name="Q25" size="5" value="<?php echo $Q25; ?>"/>Time(s)</td>
    <td class="title_s" style="text-align:left;width:150px;">8）Complain</td>
    <td><input type="text" id="Q26" name="Q26" size="5" value="<?php echo $Q26; ?>"/>Time(s)</td>
	<td class="title_s" style="text-align:left;width:150px;">9）Uncooperative</td>
    <td><input type="text" id="Q27" name="Q27" size="5" value="<?php echo $Q27; ?>"/>Time(s)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">10）Worry</td>
    <td><input type="text" id="Q28" name="Q28" size="5" value="<?php echo $Q28; ?>"/>Time(s)</td>
    <td class="title_s" style="text-align:left;width:150px;">11）Hallucinations, Delusions</td>
    <td><input type="text" id="Q29" name="Q29" size="5" value="<?php echo $Q29; ?>"/>Time(s)</td>
	<td class="title_s" style="text-align:left;width:150px;">12）Refuse to eat</td>
    <td><input type="text" id="Q30" name="Q30" size="5" value="<?php echo $Q30; ?>"/>Time(s)</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;width:150px;">13）Wandering</td>
    <td><input type="text" id="Q31" name="Q31" size="5" value="<?php echo $Q31; ?>"/>Time(s)</td>
    <td class="title_s" style="text-align:left;width:150px;">14）Improper sexual behavior</td>
    <td colspan="3"><input type="text" id="Q32" name="Q32" size="5" value="<?php echo $Q32; ?>"/>Time(s)</td>
  </tr>
</table>
<?php 
$arrayQ = array("","Sleep disorder(s)","Repeat same action","Repeat same language","Stool on pants/Remove diaper","Physical aggression","Cursing at others","Irritability","Complain","Uncooperative","Worry","Hallucinations, Delusions","Refuse to eat","Wandering","Improper sexual behavior");
$arrEMO3 = array();
$arrEMO12 = array();
?>
<table width="100%" border="0">
  <tr>
    <td colspan="7" class="title">5. Recent 3 years occurance of problematic behavior and abnormal emotions compare(Assess only the resident who participated assistive treatment activity)</td>
  </tr>
  <tr>
    <td class="title_s" width="150">Date</td>
	<?php 
	  for ($i=date(Y);$i>(date(Y)-3);$i--) {
		  $yy ++;
		  if ($_GET['date']=="") {
			  ${'Q'.(46+$yy)} = $i;		
			  
		  }
	  array_push($arrYear, ${'Q'.(46+$yy)});
	?>    
    <td class="title_s" colspan="2"><input type="text" id="Q<?php echo 46+$yy;?>" name="Q<?php echo 46+$yy;?>" value="<?php echo ${'Q'.(46+$yy)}; ?>" size="5"/>Year</td>
    <?php }	?>
  </tr>
  <tr>
    <td class="title_s" width="150">Behavior</td>
    <td width="120">3th month</td>
    <td width="120">12th month</td>
    <td width="120">3th month</td>
    <td width="120">12th month</td>
    <td width="120">3th month</td>
    <td width="120">12th month</td>
  </tr>
  <?php 
  	for ($j=1;$j<count($arrayQ);$j++){
    ${'arrEMO3'.$j} = array();
	${'arrEMO12'.$j} = array();	
	  if ($_GET['date']=="") {	
	  	$db3 = new DB;
		$db3->query("SELECT `HospNo` FROM `socialform11c` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
		if ($db3->num_rows()>0) {
			for ($j1=0;$j1<count($arrYear);$j1++){
			  //3m		  
			  $EMOdb1 = new DB;
			  $EMOdb1->query("SELECT `QNO`, `Qtotal` FROM `careform11b` WHERE `HospNo` ='".mysql_escape_string($HospNo)."'  AND left(`date`,4)= '".$arrYear[$j1]."'  AND `date` >= '".$arrYear[$j1]."0101' AND `date` <= '".$arrYear[$j1]."0630' AND `QNO`= '".$j."' ORDER BY  `date` DESC LIMIT 0 , 1");
			  $EMO1 = $EMOdb1->fetch_assoc();
			  if ($EMOdb1->num_rows()>0) {$EMO3m = $EMO1['Qtotal'];$EMO3mQ = $EMO1['QNO'];}else{$EMO3m = 0;$EMO3mQ=$j;}
			  //12m
			  $EMOdb2 = new DB;
			  $EMOdb2->query("SELECT `QNO`, `Qtotal` FROM `careform11b` WHERE `HospNo` ='".mysql_escape_string($HospNo)."'  AND left(`date`,4)= '".$arrYear[$j1]."'  AND `date` >= '".$arrYear[$j1]."0701' AND `date` <= '".$arrYear[$j1]."1231' AND `QNO`= '".$j."' ORDER BY  `date` DESC LIMIT 0 , 1");
			  $EMO2 = $EMOdb2->fetch_assoc();
			  if ($EMOdb2->num_rows()>0) {$EMO12m = $EMO2['Qtotal'];$EMO12mQ=$EMO2['QNO'];}else{$EMO12m = 0;$EMO12mQ=$j;}		  		  
			  array_push(${'arrEMO3'.$j},$EMO3m);
			  array_push(${'arrEMO12'.$j},$EMO12m);
			}
		}
		${'Q'.($j+49)} = ${'arrEMO3'.$j}[0];
		${'Q'.($j+49+count($arrayQ)-1)} = ${'arrEMO12'.$j}[0];
		${'Q'.($j+49+count($arrayQ)*2-2)} = ${'arrEMO3'.$j}[1];
		${'Q'.($j+49+count($arrayQ)*3-3)} = ${'arrEMO12'.$j}[1];
		${'Q'.($j+49+count($arrayQ)*4-4)} = ${'arrEMO3'.$j}[2];
		${'Q'.($j+49+count($arrayQ)*5-5)} = ${'arrEMO12'.$j}[2];
	  }
  ?>
  <tr>
    <td class="title_s"><?php echo $arrayQ[$j]; ?></td>
    <td><input type="text" id="Q<?php echo 49+$j;?>" name="Q<?php echo 49+$j;?>" value="<?php echo ${'Q'.(49+$j)};?>" size="5"/></td>
    <td><input type="text" id="Q<?php echo 49+($j+count($arrayQ)-1);?>" name="Q<?php echo 49+($j+count($arrayQ)-1);?>" value="<?php echo ${'Q'.(49+$j+count($arrayQ)-1)};?>" size="5"/></td>
    <td><input type="text" id="Q<?php echo 49+($j+count($arrayQ)*2-2);?>" name="Q<?php echo 49+($j+count($arrayQ)*2-2);?>" value="<?php echo ${'Q'.(49+$j+count($arrayQ)*2-2)};?>" size="5"/></td>
    <td><input type="text" id="Q<?php echo 49+($j+count($arrayQ)*3-3);?>" name="Q<?php echo 49+($j+count($arrayQ)*3-3);?>" value="<?php echo ${'Q'.(49+$j+count($arrayQ)*3-3)};?>" size="5"/></td>
    <td><input type="text" id="Q<?php echo 49+($j+count($arrayQ)*4-4);?>" name="Q<?php echo 49+($j+count($arrayQ)*4-4);?>" value="<?php echo ${'Q'.(49+$j+count($arrayQ)*4-4)};?>" size="5"/></td>
    <td><input type="text" id="Q<?php echo 49+($j+count($arrayQ)*5-5);?>" name="Q<?php echo 49+($j+count($arrayQ)*5-5);?>" value="<?php echo ${'Q'.(49+$j+count($arrayQ)*5-5)};?>" size="5"/></td>
  </tr>
  <?php }?>
</table>
<table width="100%" border="0">
  <tr>
    <td colspan="2" class="title">6. Participated in activities</td>
  </tr>
  <tr>
    <?php
	for ($i2=0;$i2<count($arrYear);$i2++) {
		$dbACT = new DB;
		$dbACT->query("SELECT * FROM `socialform08` a inner join `socialform08_act` b on a.actID=b.actID WHERE a.`HospNo` like '%".mysql_escape_string($HospNo)."%' AND LEFT(a.`date`,4) = '".$arrYear[$i2]."' ORDER BY b.actID ");
		for ($i2a=0;$i2a<$dbACT->num_rows();$i2a++) {
			$rACT = $dbACT->fetch_assoc();
			if($rACT['actID']!=${'Qa'.(135+$i2*2)}){
				if (${'Q'.(135+$i2*2)}!="") { ${'Q'.(135+$i2*2)} .= '、'; }
				${'Q'.(135+$i2*2)} .= $rACT['cateName'].'-'.$rACT['actName'];
			}
			${'Qa'.(135+$i2*2)} = $rACT['actID'];
		}
	}
	?>
    <td width="180"><input type="text" id="Q134" name="Q134" value="<?php echo $Q134==""?$arrYear[0]:$Q134; ?>" size="5"/>Year annual participation:</td>
    <td><textarea name="Q135" id="Q135"><?php echo $Q135;?></textarea></td>
  </tr>
  <tr>
    <td width="180"><input type="text" id="Q136" name="Q136" value="<?php echo $Q136==""?$arrYear[1]:$Q136;?>" size="5"/>Year annual participation:</td>
    <td><textarea name="Q137" id="Q137"><?php echo $Q137;?></textarea></td>
  </tr>
  <tr>
    <td width="180"><input type="text" id="Q138" name="Q138" value="<?php echo $Q138==""?$arrYear[2]:$Q138;?>" size="5"/>Year annual participation:</td>
    <td><textarea name="Q139" id="Q139"><?php echo $Q139;?></textarea></td>
  </tr>
</table>




<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onClick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform11d" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form></center><br><br>

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