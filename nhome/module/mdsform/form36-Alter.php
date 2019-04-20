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
$sql = "SELECT * FROM `mdsform36` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.section {background-color:rgb(113,113,99); color:white; font-size:14px; padding-left:5px}
td.section2 {background-color:rgb(230,230,226); font-size:14px}
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center}
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:5px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:10px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:17px; margin:2px}
ol.zero {list-style:decimal-leading-zero; padding-left:23px; margin:2px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form36" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section V</b></td>
<td class="section2" width="768"><b style="padding-left:5px">Care Area Assessment (CAA) Summary</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
<tr>
<td class="part" colspan="4"><b>V0200. CAAs and Care Planning</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="4" width="870">
<ol>
<li>Check column A if Care Area is triggered.
<li>For each triggered Care Area, indicate whether a new care plan, care plan revision, or continuation of current care plan is necessary to address <br>the problem(s) identified in your assessment of the care area. The <u>Care Planning Decision</u> column must be completed within 7 days of <br>completing the RAI (MDS and CAA(s)). Check column B if the triggered care area is addressed in the care plan.
<li>Indicate in the <u>Location and Date of CAA Documentation</u> column where information related to the CAA can be found. CAA documentation <br>should include information on the complicating factors, risks, and any referrals for this resident for this care area.
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="4"><ul><li><b>CAA Results</b></ul></td>
</tr>
<!-------------------------------------------->
<tr> 
<td width="345" colspan="1" align="center" rowspan="2">
<b>Care Area</b>			  
</td>	  
<td class="content" width="90" valign="top" align="center" colspan="1">
<p align="center"><b>A. <br>Care Area <br>Triggered</b></p>
</td>
<td class="content" width="90" valign="top" align="center" colspan="1">
<p align="center"><b>B. <br>Care Planning <br>Decision</b></p>
</td>
<td width="345" colspan="1" align="center" rowspan="2">
<b>Location and Date of <br>CAA documentation</b>			  
</td>
</tr>
<tr>
<td width="180" colspan="2" align="center">
<b>&#8595; Check all that apply &#8595;</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li><b>Delirium</b>
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A01A" value="X" <?php if($QV0200A01A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A01B" value="X" <?php if($QV0200A01B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A01" value="<?php echo $QV0200A01; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="2"><b>Cognitive Loss/Dementia</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A02A" value="X" <?php if($QV0200A02A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A02B" value="X" <?php if($QV0200A02B=="X") echo "checked";?>>
</td>
<td>	
<input type="text" size="51" name="QV0200A02" value="<?php echo $QV0200A02; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="3"><b>Visual Function</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A03A" value="X" <?php if($QV0200A03A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A03B" value="X" <?php if($QV0200A03B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A03" value="<?php echo $QV0200A03; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="4"><b>Communication</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A04A" value="X" <?php if($QV0200A04A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A04B" value="X" <?php if($QV0200A04B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A04" value="<?php echo $QV0200A04; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="5"><b>ADL Functional/Rehabilitation Potential</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A05A" value="X" <?php if($QV0200A05A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A05B" value="X" <?php if($QV0200A05B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A05" value="<?php echo $QV0200A05; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="6"><b>Urinary Incontinence and Indwelling <br>Catheter</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A06A" value="X" <?php if($QV0200A06A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A06B" value="X" <?php if($QV0200A06B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A06" value="<?php echo $QV0200A06; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="7"><b>Psychosocial Well-Being</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A07A" value="X" <?php if($QV0200A07A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A07B" value="X" <?php if($QV0200A07B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A07" value="<?php echo $QV0200A07; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="8"><b>Mood State</b>			 
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A08A" value="X" <?php if($QV0200A08A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A08B" value="X" <?php if($QV0200A08B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A08" value="<?php echo $QV0200A08; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="9"><b>Behavioral Symptoms</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A09A" value="X" <?php if($QV0200A09A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A09B" value="X" <?php if($QV0200A09B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A09" value="<?php echo $QV0200A09; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="10"><b>Activities</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A10A" value="X" <?php if($QV0200A10A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A10B" value="X" <?php if($QV0200A10B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A10" value="<?php echo $QV0200A10; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="11"><b>Falls</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A11A" value="X" <?php if($QV0200A11A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A11B" value="X" <?php if($QV0200A11B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A11" value="<?php echo $QV0200A11; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="12"><b>Nutritional Status</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A12A" value="X" <?php if($QV0200A12A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A12B" value="X" <?php if($QV0200A12B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A12" value="<?php echo $QV0200A12; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="13"><b>Feeding Tube</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A13A" value="X" <?php if($QV0200A13A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A13B" value="X" <?php if($QV0200A13B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A13" value="<?php echo $QV0200A13; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="14"><b>Dehydration/Fluid Maintenance</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A14A" value="X" <?php if($QV0200A14A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A14B" value="X" <?php if($QV0200A14B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A14" value="<?php echo $QV0200A14; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="15"><b>Dental Care</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A15A" value="X" <?php if($QV0200A15A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A15B" value="X" <?php if($QV0200A15B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A15" value="<?php echo $QV0200A15; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="16"><b>Pressure Ulcer</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A16A" value="X" <?php if($QV0200A16A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A16B" value="X" <?php if($QV0200A16B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A16" value="<?php echo $QV0200A16; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="17"><b>Psychotropic Drug Use</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A17A" value="X" <?php if($QV0200A17A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A17B" value="X" <?php if($QV0200A17B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A17" value="<?php echo $QV0200A17; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="18"><b>Physical Restraints</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A18A" value="X" <?php if($QV0200A18A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A18B" value="X" <?php if($QV0200A18B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A18" value="<?php echo $QV0200A18; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="19"><b>Pain</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A19A" value="X" <?php if($QV0200A19A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A19B" value="X" <?php if($QV0200A19B=="X") echo "checked";?>>
</td>
<td>
<input type="text" size="51" name="QV0200A19" value="<?php echo $QV0200A19; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td>
<ol class="zero">
<li value="20"><b>Return to Community Referral</b>			  
</ol>
</td>	
<td class="content">
<input type="checkbox" name="QV0200A20A" value="X" <?php if($QV0200A20A=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QV0200A20B" value="X" <?php if($QV0200A20B=="X") echo "checked";?>>
</td>
<td>	
<input type="text" size="51" name="QV0200A20" value="<?php echo $QV0200A20; ?>">		
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="4"><ul><li value="2"><b>Signature of RN Coordinator for CAA Process and Date Signed</b></ul></td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="3" valign="top">
<ol style="padding-left:30px"><li><b>Signature</b></ol>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" size="24" name="QV0200Btext" value="<?php echo $QV0200Btext; ?>">
</td>
<td class="partwhite" colspan="1">
<ol><li value="2"><b>Date</b>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_1" value="<?php echo $QV0200B_1; ?>" onkeyup="if(this.value.length==1)document.form36.QV0200B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_2" value="<?php echo $QV0200B_2; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_1.focus();if(this.value.length==1)document.form36.QV0200B_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_3" value="<?php echo $QV0200B_3; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_2.focus();if(this.value.length==1)document.form36.QV0200B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_4" value="<?php echo $QV0200B_4; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_3.focus();if(this.value.length==1)document.form36.QV0200B_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_5" value="<?php echo $QV0200B_5; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_4.focus();if(this.value.length==1)document.form36.QV0200B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_6" value="<?php echo $QV0200B_6; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_5.focus();if(this.value.length==1)document.form36.QV0200B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_7" value="<?php echo $QV0200B_7; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_6.focus();if(this.value.length==1)document.form36.QV0200B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200B_8" value="<?php echo $QV0200B_8; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200B_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="4"><ul><li value="3"><b>Signature of Person Completing Care Plan and Date Signed</b></ul></td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="3" valign="top">
<ol style="padding-left:30px"><li><b>Signature</b></ol>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" size="24" name="QV0200Ctext" value="<?php echo $QV0200Ctext; ?>">
</td>
<td class="partwhite" colspan="1">
<ol><li value="2"><b>Date</b>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_1" value="<?php echo $QV0200C_1; ?>" onkeyup="if(this.value.length==1)document.form36.QV0200C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_2" value="<?php echo $QV0200C_2; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_1.focus();if(this.value.length==1)document.form36.QV0200C_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_3" value="<?php echo $QV0200C_3; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_2.focus();if(this.value.length==1)document.form36.QV0200C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_4" value="<?php echo $QV0200C_4; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_3.focus();if(this.value.length==1)document.form36.QV0200C_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_5" value="<?php echo $QV0200C_5; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_4.focus();if(this.value.length==1)document.form36.QV0200C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_6" value="<?php echo $QV0200C_6; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_5.focus();if(this.value.length==1)document.form36.QV0200C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_7" value="<?php echo $QV0200C_7; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_6.focus();if(this.value.length==1)document.form36.QV0200C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0200C_8" value="<?php echo $QV0200C_8; ?>" onkeyup="if(this.value.length==0)document.form36.QV0200C_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ol>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform36">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
