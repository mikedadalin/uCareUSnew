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
$sql = "SELECT * FROM `mdsform38` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:41px}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:5px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:2px}
ol {list-style:decimal; padding:0px; padding-left:38px; margin:0px}
ol.zero {list-style:decimal-leading-zero; padding-left:45px; margin:0px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form38" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section X</b></td>
<td class="section2" width="740"><b style="padding-left:5px">Correction Request</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
<tr>
<td class="part" colspan="2"><b>X0600. Type of Assessment.- Continued</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li value="4"><b>Is this a Swing Bed clinical change assessment?</b> Complete only if X0150 = 2
</ul>
<ol start="0">
<li><input type="radio" name="QX0600D" value="0" <?php if($QX0600D=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QX0600D" value="1" <?php if($QX0600D=="1") echo "checked";?>><b>Yes</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($X0600F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="6"><b>Entry/discharge reporting</b>
</ul>
<ol class="zero">
<li><input type="radio" name="QX0600F" value="01" <?php if($QX0600F=="01") echo "checked";?>><b>Entry</b> tracking record
<li value="10"><input type="radio" name="QX0600F" value="10" <?php if($QX0600F=="10") echo "checked";?>><b>Discharge</b> assessment-<b>return not anticipated</b>
<li value="11"><input type="radio" name="QX0600F" value="11" <?php if($QX0600F=="11") echo "checked";?>><b>Discharge</b> assessment-<b>return anticipated</b>
<li value="12"><input type="radio" name="QX0600F" value="12" <?php if($QX0600F=="12") echo "checked";?>><b>Death in facility</b> tracking record
<li value="99"><input type="radio" name="QX0600F" value="99" <?php if($QX0600F=="99") echo "checked";?>><b>None of the above</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0700. Date</b> on existing record to be modified/inactivated - <b>Complete one only</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td>
<ul>
<li><b>Assessment Reference Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0700A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - (A2300 on existing record to be modified/inactivated) - Complete only if X0600F = 99
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_1" value="<?php echo $QX0700A_1; ?>" onkeyup="if(this.value.length==1)document.form38.QX0700A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_2" value="<?php echo $QX0700A_2; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_1.focus();if(this.value.length==1)document.form38.QX0700A_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_3" value="<?php echo $QX0700A_3; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_2.focus();if(this.value.length==1)document.form38.QX0700A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_4" value="<?php echo $QX0700A_4; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_3.focus();if(this.value.length==1)document.form38.QX0700A_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_5" value="<?php echo $QX0700A_5; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_4.focus();if(this.value.length==1)document.form38.QX0700A_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_6" value="<?php echo $QX0700A_6; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_5.focus();if(this.value.length==1)document.form38.QX0700A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_7" value="<?php echo $QX0700A_7; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_6.focus();if(this.value.length==1)document.form38.QX0700A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700A_8" value="<?php echo $QX0700A_8; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700A_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td>
<ul>
<li value="2"><b>Discharge Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0700B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - (A2000 on existing record to be modified/inactivated) - Complete only if X0600F = 10, 11, or 12
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_1" value="<?php echo $QX0700B_1; ?>" onkeyup="if(this.value.length==1)document.form38.QX0700B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_2" value="<?php echo $QX0700B_2; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_1.focus();if(this.value.length==1)document.form38.QX0700B_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_3" value="<?php echo $QX0700B_3; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_2.focus();if(this.value.length==1)document.form38.QX0700B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_4" value="<?php echo $QX0700B_4; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_3.focus();if(this.value.length==1)document.form38.QX0700B_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_5" value="<?php echo $QX0700B_5; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_4.focus();if(this.value.length==1)document.form38.QX0700B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_6" value="<?php echo $QX0700B_6; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_5.focus();if(this.value.length==1)document.form38.QX0700B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_7" value="<?php echo $QX0700B_7; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_6.focus();if(this.value.length==1)document.form38.QX0700B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700B_8" value="<?php echo $QX0700B_8; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700B_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td>
<ul>
<li value="3"><b>Entry Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0700C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - (A1600 on existing record to be modified/inactivated) - Complete only if X0600F = 01
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_1" value="<?php echo $QX0700C_1; ?>" onkeyup="if(this.value.length==1)document.form38.QX0700C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_2" value="<?php echo $QX0700C_2; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_1.focus();if(this.value.length==1)document.form38.QX0700C_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_3" value="<?php echo $QX0700C_3; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_2.focus();if(this.value.length==1)document.form38.QX0700C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_4" value="<?php echo $QX0700C_4; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_3.focus();if(this.value.length==1)document.form38.QX0700C_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_5" value="<?php echo $QX0700C_5; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_4.focus();if(this.value.length==1)document.form38.QX0700C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_6" value="<?php echo $QX0700C_6; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_5.focus();if(this.value.length==1)document.form38.QX0700C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_7" value="<?php echo $QX0700C_7; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_6.focus();if(this.value.length==1)document.form38.QX0700C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0700C_8" value="<?php echo $QX0700C_8; ?>" onkeyup="if(this.value.length==0)document.form38.QX0700C_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>Correction Attestation Section</b>- Complete this section to explain and attest to the modification/inactivation request</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0800. Correction Number</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0800_1" value="<?php echo $QX0800_1; ?>" onkeyup="if(this.value.length==1)document.form38.QX0800_2.focus();"><?php if (substr($url[3],0,5)!="print"){ if($X08001_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QX0800_2" value="<?php echo $QX0800_2; ?>" onkeyup="if(this.value.length==0)document.form38.QX0800_1.focus();"><?php if (substr($url[3],0,5)!="print"){ if($X08002_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Enter the number of correction requests to modify/inactivate the existing record, including the present one</b></a>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X0900. Reasons for Modification</b><?php if (substr($url[3],0,5)!="print"){ if($X0900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>- Complete only if Type of Record is to modify a record in error (A0050 = 2)</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2"><b>&#8595; Check all that apply</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX0900A" value="X" <?php if($QX0900A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Transcription error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX0900B" value="X" <?php if($QX0900B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Data entry error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX0900C" value="X" <?php if($QX0900C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Software product error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX0900D" value="X" <?php if($QX0900D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Item coding error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX0900E" value="X" <?php if($QX0900E=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="5"><b>End of Therapy - Resumption (EOT-R) date</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX0900Z" value="X" <?php if($QX0900Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>Other error requiring modification</b>
<br>If "Other" checked, please specify:<?php if (substr($url[3],0,5)!="print"){ if($X0900Z_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> <input type="text" size="80" name="QX0900Ztext" value="<?php echo $QX0900Ztext; ?>">
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>X1050. Reasons for Inactivation</b><?php if (substr($url[3],0,5)!="print"){ if($X1050_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>- Complete only if Type of Record is to inactivate a record in error (A0050 = 3)</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2"><b>&#8595; Check all that apply</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX1050A" value="X" <?php if($QX1050A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Event did not occur</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QX1050Z" value="X" <?php if($QX1050Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>Other error requiring inactivation</b>
<br>If "Other" checked, please specify: <?php if (substr($url[3],0,5)!="print"){ if($X1050Z_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><input type="text" size="80" name="QX1050Ztext" value="<?php echo $QX1050Ztext; ?>">
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform38">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
