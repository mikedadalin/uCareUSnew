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
$sql = "SELECT * FROM `mdsform29` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); padding-left:0px; text-align:center}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:36px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form29" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section O</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Special Treatments, Procedures, and Programs</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3"><b>O0100. Special Treatments, Procedures, and Programs</b><?php if (substr($url[3],0,5)!="print"){ if($O0100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>Check all of the following treatments, procedures, and programs that were performed during the last <b>14 days</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td width="688" colspan="1" rowspan="3">
<ol style="padding-left:20px">
<li>
<b>While NOT a Resident</b><br>Performed <b>while NOT a resident</b> of this facility and within the <b>last 14 days.</b> Only check column 1 if <br>resident entered (admission or reentry) IN THE LAST 14 DAYS. If resident last entered 14 or more days <br>ago, leave column 1 blank
</li>
<li>
<b>While a Resident</b><br>Performed <b>while a resident</b> of this facility and within the <b>last 14 days</b>
</li>
</td>
</tr>
<tr>
<td class="content" width="90" valign="bottom" colspan="1">
<b>1. <br>While NOT a <br>Resident</b>
</td>
<td class="content" width="90" valign="bottom" colspan="1">
<b>2. <br>While a <br>Resident</b>
</td>
</tr>
<tr>
<td class="partwhite" width="180" valign="bottom" colspan="2">
<b>&#8595; Check all that apply &#8595;</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3"><b>Cancer Treatments</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li><b>Chemotherapy</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100A1" value="X" <?php if($QO0100A1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100A2" value="X" <?php if($QO0100A2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="2"><b>Radiation</b>	  
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100B1" value="X" <?php if($QO0100B1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100B2" value="X" <?php if($QO0100B2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3"><b>Respiratory Treatments</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="3"><b>Oxygen therapy</b>  
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100C1" value="X" <?php if($QO0100C1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100C2" value="X" <?php if($QO0100C2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="4"><b>Suctioning</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100D1" value="X" <?php if($QO0100D1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100D2" value="X" <?php if($QO0100D2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="5"><b>Tracheostomy care</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100E1" value="X" <?php if($QO0100E1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100E2" value="X" <?php if($QO0100E2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="6"><b>Ventilator or respirator</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100F1" value="X" <?php if($QO0100F1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100F2" value="X" <?php if($QO0100F2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="7"><b>BiPAP/CPAP</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100G1" value="X" <?php if($QO0100G1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100G2" value="X" <?php if($QO0100G2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3"><b>Other</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="8"><b>IV medications</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100H1" value="X" <?php if($QO0100H1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100H2" value="X" <?php if($QO0100H2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="9"><b>Transfusions</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100I1" value="X" <?php if($QO0100I1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100I2" value="X" <?php if($QO0100I2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="10"><b>Dialysis</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100J1" value="X" <?php if($QO0100J1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100J2" value="X" <?php if($QO0100J2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="11"><b>Hospice care</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100K1" value="X" <?php if($QO0100K1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100K2" value="X" <?php if($QO0100K2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="12"><b>Respite care</b>
</ul>
</td>	  
<td class="section">
</td>
<td class="content">
<input type="checkbox" name="QO0100L" value="X" <?php if($QO0100L=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="13"><b>Isolation or quarantine for active infectious disease </b>(does not include standard body/fluid <br>precautions)
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100M1" value="X" <?php if($QO0100M1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100M2" value="X" <?php if($QO0100M2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3"><b>None of the Above</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="26"><b>None of the above</b>	  
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QO0100Z1" value="X" <?php if($QO0100Z1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QO0100Z2" value="X" <?php if($QO0100Z2=="X") echo "checked";?>>
</td>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
<tr>
<td class="part" colspan="2"><b>O0250. Influenza Vaccine</b> - Refer to current version of RAI manual for current influenza vaccination season and reporting period</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($O0250A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li>Did the <b>resident receive the influenza vaccine in this facility</b> for this year's influenza vaccination season?
</ul>
<ol start="0">
<li><input type="radio" name="QO0250A" value="0" <?php if($QO0250A=="0") echo "checked";?>><b>No &#8594; </b>Skip to O0250C, If Influenza vaccine not received, state reason
<li><input type="radio" name="QO0250A" value="1" <?php if($QO0250A=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to O0250B, Date influenza vaccine received
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($O0250B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Date influenza vaccine received &#8594; </b>Complete date and skip to O0300A, Is the resident's Pneumococcal vaccination up to date?
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_1" value="<?php echo $QO0250B_1; ?>" onkeyup="if(this.value.length==1)document.form29.QO0250B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_2" value="<?php echo $QO0250B_2; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_1.focus();if(this.value.length==1)document.form29.QO0250B_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_3" value="<?php echo $QO0250B_3; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_2.focus();if(this.value.length==1)document.form29.QO0250B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_4" value="<?php echo $QO0250B_4; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_3.focus();if(this.value.length==1)document.form29.QO0250B_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_5" value="<?php echo $QO0250B_5; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_4.focus();if(this.value.length==1)document.form29.QO0250B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_6" value="<?php echo $QO0250B_6; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_5.focus();if(this.value.length==1)document.form29.QO0250B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_7" value="<?php echo $QO0250B_7; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_6.focus();if(this.value.length==1)document.form29.QO0250B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0250B_8" value="<?php echo $QO0250B_8; ?>" onkeyup="if(this.value.length==0)document.form29.QO0250B_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($O0250C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>If Influenza vaccine not received, state reason:</b>
</ul>
<ol>
<li><input type="radio" name="QO0250C" value="1" <?php if($QO0250C=="1") echo "checked";?>><b>Resident not in facility</b> during this year's influenza vaccination season
<li><input type="radio" name="QO0250C" value="2" <?php if($QO0250C=="2") echo "checked";?>><b>Received outside of this facility</b>
<li><input type="radio" name="QO0250C" value="3" <?php if($QO0250C=="3") echo "checked";?>><b>Not eligible</b> - medical contraindication
<li><input type="radio" name="QO0250C" value="4" <?php if($QO0250C=="4") echo "checked";?>><b>Offered and declined</b>
<li><input type="radio" name="QO0250C" value="5" <?php if($QO0250C=="5") echo "checked";?>><b>Not offered</b>
<li><input type="radio" name="QO0250C" value="6" <?php if($QO0250C=="6") echo "checked";?>><b>Inability to obtain influenza vaccine</b> due to a declared shortage
<li value="9"><input type="radio" name="QO0250C" value="9" <?php if($QO0250C=="9") echo "checked";?>><b>None of the above</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>O0300. Pneumococcal Vaccine</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($O0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Is the resident's Pneumococcal vaccination up to date?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QO0300A" value="0" <?php if($QO0300A=="0") echo "checked";?>><b>No &#8594; </b>Continue to O0300B, If Pneumococcal vaccine not received, state reason
<li><input type="radio" name="QO0300A" value="1" <?php if($QO0300A=="1") echo "checked";?>><b>Yes &#8594; </b>Skip to O0400, Therapies
</ol>		   
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($O0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>If Pneumococcal vaccine not received, state reason:</b>
</ul>
<ol>
<li><input type="radio" name="QO0300B" value="1" <?php if($QO0300B=="1") echo "checked";?>><b>Not eligible</b> - medical contraindication
<li><input type="radio" name="QO0300B" value="2" <?php if($QO0300B=="2") echo "checked";?>><b>Offered and declined</b>
<li><input type="radio" name="QO0300B" value="3" <?php if($QO0300B=="3") echo "checked";?>><b>Not offered</b>
</ol>		  
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform29">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
