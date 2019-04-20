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
$sql = "SELECT * FROM `mdsform35` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:2px}
ol {list-style:decimal; padding:0px; padding-left:43px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form35" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section V</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Care Area Assessment (CAA) Summary</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
<tr>
<td class="part" colspan="2"><b>V0100. Items From the Most Recent Prior OBRA or Scheduled PPS Assessment</b><br>Complete only if A0310E = 0 and if the following is true for the <b>prior assessment</b>: A0310A = 01- 06 or A0310B = 01- 06</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($V0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($V0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ul>
<li><b>Prior Assessment Federal OBRA Reason for Assessment</b>(A0310A value from prior assessment)
</ul>
<ol class="zero">
<li><input type="radio" name="QV0100A" value="01" <?php if($QV0100A=="01") echo "checked";?>><b>Admission</b> assessment (required by day 14)
<li><input type="radio" name="QV0100A" value="02" <?php if($QV0100A=="02") echo "checked";?>><b>Quarterly</b> review assessment
<li><input type="radio" name="QV0100A" value="03" <?php if($QV0100A=="03") echo "checked";?>><b>Annual</b> assessment
<li><input type="radio" name="QV0100A" value="04" <?php if($QV0100A=="04") echo "checked";?>><b>Significant change in status</b> assessment
<li><input type="radio" name="QV0100A" value="05" <?php if($QV0100A=="05") echo "checked";?>><b>Significant correction</b> to <b>prior comprehensive</b> assessment
<li><input type="radio" name="QV0100A" value="06" <?php if($QV0100A=="06") echo "checked";?>><b>Significant correction</b> to <b>prior quarterly</b> assessment
<li value="99"><input type="radio" name="QV0100A" value="99" <?php if($QV0100A=="99") echo "checked";?>>None of the above
</ol>			  
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($V0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($V0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Prior Assessment PPS Reason for Assessment</b> (A0310B value from prior assessment)
</ul>
<ol class="zero">
<li><input type="radio" name="QV0100B" value="01" <?php if($QV0100B=="01") echo "checked";?>><b>5-day</b> scheduled assessment
<li><input type="radio" name="QV0100B" value="02" <?php if($QV0100B=="02") echo "checked";?>><b>14-day</b> scheduled assessment
<li><input type="radio" name="QV0100B" value="03" <?php if($QV0100B=="03") echo "checked";?>><b>30-day</b> scheduled assessment
<li><input type="radio" name="QV0100B" value="04" <?php if($QV0100B=="04") echo "checked";?>><b>60-day</b> scheduled assessment
<li><input type="radio" name="QV0100B" value="05" <?php if($QV0100B=="05") echo "checked";?>><b>90-day</b> scheduled assessment
<li><input type="radio" name="QV0100B" value="06" <?php if($QV0100B=="06") echo "checked";?>><b>Readmission/return</b> assessment
<li><input type="radio" name="QV0100B" value="07" <?php if($QV0100B=="07") echo "checked";?>><b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant correction assessment)
<li value="99"><input type="radio" name="QV0100B" value="99" <?php if($QV0100B=="99") echo "checked";?>>None of the above
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td>
<ul>
<li value="3"><b>Prior Assessment Reference Date</b><?php if (substr($url[3],0,5)!="print"){ if($V0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (A2300 value from prior assessment)
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_1" value="<?php echo $QV0100C_1; ?>" onkeyup="if(this.value.length==1)document.form35.QV0100C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_2" value="<?php echo $QV0100C_2; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_1.focus();if(this.value.length==1)document.form35.QV0100C_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_3" value="<?php echo $QV0100C_3; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_2.focus();if(this.value.length==1)document.form35.QV0100C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_4" value="<?php echo $QV0100C_4; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_3.focus();if(this.value.length==1)document.form35.QV0100C_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_5" value="<?php echo $QV0100C_5; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_4.focus();if(this.value.length==1)document.form35.QV0100C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_6" value="<?php echo $QV0100C_6; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_5.focus();if(this.value.length==1)document.form35.QV0100C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_7" value="<?php echo $QV0100C_7; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_6.focus();if(this.value.length==1)document.form35.QV0100C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100C_8" value="<?php echo $QV0100C_8; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100C_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Score
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100D_1" value="<?php echo $QV0100D_1; ?>" onkeyup="if(this.value.length==1)document.form35.QV0100D_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100D_2" value="<?php echo $QV0100D_2; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100D_1.focus();"></td>
</table>
</td>
<td>
<ul>
<li value="4"><?php if (substr($url[3],0,5)!="print"){ if($V0100D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Prior Assessment Brief Interview for Mental Status (BIMS) Summary Score</b> (C0500 value from prior assessment)			  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Score
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100E_1" value="<?php echo $QV0100E_1; ?>" onkeyup="if(this.value.length==1)document.form35.QV0100E_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100E_2" value="<?php echo $QV0100E_2; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100E_1.focus();"></td>
</table>
</td>
<td>
<ul>
<li value="5"><?php if (substr($url[3],0,5)!="print"){ if($V0100EF_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Prior Assessment Resident Mood Interview (PHQ-9c) Total Severity Score</b> (D0300 value from prior assessment)			  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Score
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100F_1" value="<?php echo $QV0100F_1; ?>" onkeyup="if(this.value.length==1)document.form35.QV0100F_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QV0100F_2" value="<?php echo $QV0100F_2; ?>" onkeyup="if(this.value.length==0)document.form35.QV0100F_1.focus();"></td>
</table>
</td>
<td>
<ul>
<li value="6"><?php if (substr($url[3],0,5)!="print"){ if($V0100EF_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Prior Assessment Staff Assessment of Resident Mood (PHQ-9-OV) Total Severity Score</b> (D0600 value from prior assessment)
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform35">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
