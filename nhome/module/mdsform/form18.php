<?php
if($_GET['date']!=NULL){
  if($_GET['date']=='Select dates to edit information or new record'){
    $db = new DB;
    $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
    $r = $db->fetch_assoc();
    $r['date'] = str_replace('-','',$r['date']);
    ?>
    <script>
    document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
    </script>
    <?php
  }
?>
<?php
$sql = "SELECT * FROM `mdsform18` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}

$Qfiller = explode("&",$Qfiller);
for($i=0;$i<count($Qfiller);$i++){
$sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$Qfiller[$i]."'";
$db2 = new DB2;
$db2->query($sql);
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		if((count($Qfiller)-$i)>2){
			$page18_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page18_Qfiller_name .= $v;
		}else{}
	}
}
}
$page18_Qfiller_name = str_replace(';',', ', $page18_Qfiller_name);
?>
<body class="page18-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page18_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section I</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Active Diagnoses</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page18-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Active Diagnoses in the last 7 days - Check all that apply</b><br><a>Diagnoses listed in parentheses are provided as examples and should not be considered as all-inclusive lists</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-bottom-style:hidden; width:4.875em"></td>
<td class="page18-part" style="width:51em"><b>Cancer</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0100. Cancer</b> (with or without metastasis)
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Heart/Circulation</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0200. Anemia</b> (e.g., aplastic, iron deficiency, pernicious, and sickle cell)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0300. Atrial Fibrillation or Other Dysrhythmias</b> (e.g., bradycardias and tachycardias)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0400; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0400. Coronary Artery Disease (CAD)</b> (e.g., angina, myocardial infarction, and atherosclerotic heart <br><a style="padding-left:3.4em">disease (ASHD))</a>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0500; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0500. Deep Venous Thrombosis (DVT), Pulmonary Embolus (PE), or Pulmonary Thrombo-Embolism </b><br><b style="padding-left:3.4em">(PTE)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0600; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0600. Heart Failure</b> (e.g., congestive heart failure (CHF) and pulmonary edema)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0700; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0700. Hypertension</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0800; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0800. Orthostatic Hypotension</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI0900; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I0900. Peripheral Vascular Disease (PVD) or Peripheral Arterial Disease (PAD)</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Gastrointestinal</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1100. Cirrhosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1200. Gastroesophageal Reflux Disease (GERD) or Ulcer</b> (e.g., esophageal, gastric, and peptic ulcers)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1300. Ulcerative Colitis, Crohn's Disease, or Inflammatory Bowel Disease</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Genitourinary</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1400; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1400. Benign Prostatic Hyperplasia (BPH)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1500; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1500. Renal Insufficiency, Renal Failure, or End-Stage Renal Disease (ESRD)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1550; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1550. Neurogenic Bladder</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1650; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1650. Obstructive Uropathy</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Infections</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI1700; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I1700. Multidrug-Resistant Organism (MDRO)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2000; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2000. Pneumonia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2100. Septicemia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2200. Tuberculosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2300. Urinary Tract Infection (UTI) (LAST 30 DAYS)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2400; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2400. Viral Hepatitis</b> (e.g., Hepatitis A, B, C, D, and E)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2500; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2500. Wound Infection</b> (other than foot)
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Metabolic</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI2900; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I2900. Diabetes Mellitus (DM)</b> (e.g., diabetic retinopathy, nephropathy, and neuropathy)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3100. Hyponatremia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3200. Hyperkalemia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3300. Hyperlipidemia</b> (e.g., hypercholesterolemia)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3400; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3400. Thyroid Disorder</b> (e.g., hypothyroidism, hyperthyroidism, and Hashimoto's thyroiditis)
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Musculoskeletal</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3700; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3700. Arthritis</b> (e.g., degenerative joint disease (DJD), osteoarthritis, and rheumatoid arthritis (RA))
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3800; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3800. Osteoporosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI3900; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I3900. Hip Fracture</b> - any hip fracture that has a relationship to current status, treatments, monitoring (e.g., <br><a style="padding-left:3.4em">sub-capital fractures, and fractures of the trochanter and femoral neck)</a>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4000; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I4000. Other Fracture</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page18-part"><b>Neurological</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I4200. Alzheimer's Disease</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I4300. Aphasia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4400; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I4400. Cerebral Palsy</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4500; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I4500. Cerebrovascular Accident (CVA), Transient Ischemic Attack (TIA), or Stroke</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page18-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4800; ?></td>
</tr>
</table>
</div>
</td>
<td class="page18-partwhite">
<b style="padding-left:0.3125em">I4800. Non-Alzheimer's Dementia</b> (e.g. Lewy body dementia, vascular or multi-infarct dementia; mixed <br><a style="padding-left:3.4em">dementia; frontotemporal dementia such as Pick's disease; and dementia related to stroke, </a><br><a style="padding-left:3.4em">Parkinson's or Creutzfeldt-Jakob diseases)</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page18-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Neurological Diagnoses continued on next page</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<p style="font-size:1em">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</body>
<?php
  }else{
	$db = new DB;
	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		$r['date'] = str_replace('-','',$r['date']);
		?>
		<script>
        document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
        </script>
		<?php
	}else{
	  echo '
	  <div>
	    <table>
	      <tr>
	        <td>
		      Not have any record.
		    </td>
		  </tr>
		  <tr>
			<td>
		      Please click the button to preduce MDS.
		    </td>
	      </tr>
	    </table>
	  </div>
	  ';		
	}
  }
?>