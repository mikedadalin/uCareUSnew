<?php
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
?>
<style>
body {font-family:sans-serif; line-height:15px; font-size:9px}
table.bordercolor {border-color:rgb(113,113,99); background-color:rgb(255,255,255);}
td {padding-left:5px}
td.section {background-color:rgb(113,113,99); color:white; font-size:14px; padding-left:5px}
td.section2 {background-color:rgb(230,230,226); font-size:14px}
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center}
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-smalltd; padding-left:0px; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:0px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form18" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section I</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Active Diagnoses</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>Active Diagnoses in the last 7 days - Check all that apply</b><br>Diagnoses listed in parentheses are provided as examples and should not be considered as all-inclusive lists
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" width="70"></td>
<td class="part" width="800"><b>Cancer</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0100" value="X" <?php if($QI0100=="X") echo "checked";?>>
</td>
<td>
<b>I0100. Cancer</b> (with or without metastasis)
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Heart/Circulation</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0200" value="X" <?php if($QI0200=="X") echo "checked";?>>
</td>
<td>
<b>I0200. Anemia</b> (e.g., aplastic, iron deficiency, pernicious, and sickle cell)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0300" value="X" <?php if($QI0300=="X") echo "checked";?>>
</td>
<td>
<b>I0300. Atrial Fibrillation or Other Dysrhythmias</b> (e.g., bradycardias and tachycardias)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0400" value="X" <?php if($QI0400=="X") echo "checked";?>>
</td>
<td>
<b>I0400. Coronary Artery Disease (CAD)</b> (e.g., angina, myocardial infarction, and atherosclerotic heart disease (ASHD))
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0500" value="X" <?php if($QI0500=="X") echo "checked";?>>
</td>
<td>
<b>I0500. Deep Venous Thrombosis (DVT), Pulmonary Embolus (PE), or Pulmonary Thrombo-Embolism (PTE)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0600" value="X" <?php if($QI0600=="X") echo "checked";?>>
</td>
<td>
<b>I0600. Heart Failure</b> (e.g., congestive heart failure (CHF) and pulmonary edema)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0700" value="X" <?php if($QI0700=="X") echo "checked";?>>
</td>
<td>
<b>I0700. Hypertension</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0800" value="X" <?php if($QI0800=="X") echo "checked";?>>
</td>
<td>
<b>I0800. Orthostatic Hypotension</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI0900" value="X" <?php if($QI0900=="X") echo "checked";?>>
</td>
<td>
<b>I0900. Peripheral Vascular Disease (PVD) or Peripheral Arterial Disease (PAD)</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Gastrointestinal</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1100" value="X" <?php if($QI1100=="X") echo "checked";?>>
</td>
<td>
<b>I1100. Cirrhosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1200" value="X" <?php if($QI1200=="X") echo "checked";?>>
</td>
<td>
<b>I1200. Gastroesophageal Reflux Disease (GERD) or Ulcer</b> (e.g., esophageal, gastric, and peptic ulcers)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1300" value="X" <?php if($QI1300=="X") echo "checked";?>>
</td>
<td>
<b>I1300. Ulcerative Colitis, Crohn's Disease, or Inflammatory Bowel Disease</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Genitourinary</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1400" value="X" <?php if($QI1400=="X") echo "checked";?>>
</td>
<td>
<b>I1400. Benign Prostatic Hyperplasia (BPH)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1500" value="X" <?php if($QI1500=="X") echo "checked";?>>
</td>
<td>
<b>I1500. Renal Insufficiency, Renal Failure, or End-Stage Renal Disease (ESRD)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1550" value="X" <?php if($QI1550=="X") echo "checked";?>>
</td>
<td>
<b>I1550. Neurogenic Bladder</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1650" value="X" <?php if($QI1650=="X") echo "checked";?>>
</td>
<td>
<b>I1650. Obstructive Uropathy</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Infections</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI1700" value="X" <?php if($QI1700=="X") echo "checked";?>>
</td>
<td>
<b>I1700. Multidrug-Resistant Organism (MDRO)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2000" value="X" <?php if($QI2000=="X") echo "checked";?>>
</td>
<td>
<b>I2000. Pneumonia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2100" value="X" <?php if($QI2100=="X") echo "checked";?>>
</td>
<td>
<b>I2100. Septicemia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2200" value="X" <?php if($QI2200=="X") echo "checked";?>>
</td>
<td>
<b>I2200. Tuberculosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2300" value="X" <?php if($QI2300=="X") echo "checked";?>>
</td>
<td>
<b>I2300. Urinary Tract Infection (UTI) (LAST 30 DAYS)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2400" value="X" <?php if($QI2400=="X") echo "checked";?>>
</td>
<td>
<b>I2400. Viral Hepatitis</b> (e.g., Hepatitis A, B, C, D, and E)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2500" value="X" <?php if($QI2500=="X") echo "checked";?>>
</td>
<td>
<b>I2500. Wound Infection</b> (other than foot)
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Metabolic</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI2900" value="X" <?php if($QI2900=="X") echo "checked";?>>
</td>
<td>
<b>I2900. Diabetes Mellitus (DM)</b> (e.g., diabetic retinopathy, nephropathy, and neuropathy)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3100" value="X" <?php if($QI3100=="X") echo "checked";?>>
</td>
<td>
<b>I3100. Hyponatremia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3200" value="X" <?php if($QI3200=="X") echo "checked";?>>
</td>
<td>
<b>I3200. Hyperkalemia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3300" value="X" <?php if($QI3300=="X") echo "checked";?>>
</td>
<td>
<b>I3300. Hyperlipidemia</b> (e.g., hypercholesterolemia)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3400" value="X" <?php if($QI3400=="X") echo "checked";?>>
</td>
<td>
<b>I3400. Thyroid Disorder</b> (e.g., hypothyroidism, hyperthyroidism, and Hashimoto's thyroiditis)
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Musculoskeletal</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3700" value="X" <?php if($QI3700=="X") echo "checked";?>>
</td>
<td>
<b>I3700. Arthritis</b> (e.g., degenerative joint disease (DJD), osteoarthritis, and rheumatoid arthritis (RA))
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3800" value="X" <?php if($QI3800=="X") echo "checked";?>>
</td>
<td>
<b>I3800. Osteoporosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI3900" value="X" <?php if($QI3900=="X") echo "checked";?>>
</td>
<td>
<b>I3900. Hip Fracture</b> - any hip fracture that has a relationship to current status, treatments, monitoring (e.g., sub-capital fractures, and <br><a style="padding-left:38px">fractures of the trochanter and femoral neck)</a>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4000" value="X" <?php if($QI4000=="X") echo "checked";?>>
</td>
<td>
<b>I4000. Other Fracture</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Neurological</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4200" value="X" <?php if($QI4200=="X") echo "checked";?>>
</td>
<td>
<b>I4200. Alzheimer's Disease</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4300" value="X" <?php if($QI4300=="X") echo "checked";?>>
</td>
<td>
<b>I4300. Aphasia</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4400" value="X" <?php if($QI4400=="X") echo "checked";?>>
</td>
<td>
<b>I4400. Cerebral Palsy</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4500" value="X" <?php if($QI4500=="X") echo "checked";?>>
</td>
<td>
<b>I4500. Cerebrovascular Accident (CVA), Transient Ischemic Attack (TIA), or Stroke</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4800" value="X" <?php if($QI4800=="X") echo "checked";?>>
</td>
<td>
<b>I4800. Non-Alzheimer's Dementia</b> (e.g. Lewy body dementia, vascular or multi-infarct dementia; mixed dementia; frontotemporal dementia <br><a style="padding-left:38px">such as Pick's disease; and dementia related to stroke, Parkinson's or Creutzfeldt-Jakob diseases)</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>Neurological Diagnoses continued on next page</b></td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform18">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
