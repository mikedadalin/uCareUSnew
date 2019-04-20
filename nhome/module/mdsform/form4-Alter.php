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
$sql = "SELECT * FROM `mdsform04` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px}
td.answer2 {background-color:rgb(255,255,255); border:1px solid black; width:10px; height:10px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:32px}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left; padding-left:5px}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:34px; margin:0px}
ol.zero {list-style:decimal-leading-zero; padding-left:40px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form4" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section A</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Identification Information</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>A1550. Conditions Related to ID/DD Status</b><?php if (substr($url[3],0,5)!="print"){ if($A1550_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br>If the resident is 22 years of age or older, complete only if A0310A = 01
<br>If the resident is 21 years of age or younger, complete only if A0310A = 01, 03, 04, or 05
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="partwhite" colspan="2">
<b>&#8595; Check all conditions that are related to ID/DD status</b> that were manifested before age 22, and are likely to continue indefinitely
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="content" width="70"></td>
<td class="content2" width="794">
<b>ID/DD With Organic Condition</b>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="checkbox" name="QA1550A" value="X" <?php if($QA1550A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Down syndrome</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="checkbox" name="QA1550B" value="X" <?php if($QA1550B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Autism</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="checkbox" name="QA1550C" value="X" <?php if($QA1550C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Epilepsy</b>
</ul>
</td>
</tr>
<tr>
<td class="content" valign="top">
<input type="checkbox" name="QA1550D" value="X" <?php if($QA1550D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Other organic condition related to ID/DD</b>
</ul>
</td>
</tr>
<tr>
<td class="content"></td>
<td class="content2">
<b>ID/DD Without Organic Condition</b>
</td>
</tr>	  
<tr>
<td class="content" valign="top">
<input type="checkbox" name="QA1550E" value="X" <?php if($QA1550E=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="5"><b>ID/DD with no organic condition</b>
</ul>
</td>
</tr>
<tr>
<td class="content"></td>
<td class="content2">
<b>No ID/DD</b>
</td>
</tr>	  
<tr>
<td class="content" valign="top">
<input type="checkbox" name="QA1550Z" value="X" <?php if($QA1550Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="3">	
<tr>
<td class="part" colspan="2">
<b>Most Recent Admission/Entry or Reentry into this Facility</b>
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="part" colspan="2">
<b>A1600. Entry Date</b><?php if (substr($url[3],0,5)!="print"){ if($A1600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="content" width="70"></td>
<td width="796">
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_1" value="<?php echo $QA1600_1; ?>" onkeyup="if(this.value.length==1)document.form4.QA1600_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_2" value="<?php echo $QA1600_2; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_1.focus();if(this.value.length==1)document.form4.QA1600_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_3" value="<?php echo $QA1600_3; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_2.focus();if(this.value.length==1)document.form4.QA1600_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_4" value="<?php echo $QA1600_4; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_3.focus();if(this.value.length==1)document.form4.QA1600_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_5" value="<?php echo $QA1600_5; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_4.focus();if(this.value.length==1)document.form4.QA1600_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_6" value="<?php echo $QA1600_6; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_5.focus();if(this.value.length==1)document.form4.QA1600_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_7" value="<?php echo $QA1600_7; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_6.focus();if(this.value.length==1)document.form4.QA1600_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1600_8" value="<?php echo $QA1600_8; ?>" onkeyup="if(this.value.length==0)document.form4.QA1600_7.focus();"></td>
</table>
<a style="padding-left:47px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!------------------------------------------------------------------------->	  
<tr>
<td class="part" colspan="2">
<b>A1700. Type of Entry</b>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A1700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ol>
<li><input type="radio" name="QA1700" value="1" <?php if($QA1700=="1") echo "checked";?>><b>Admission</b>
<li><input type="radio" name="QA1700" value="2" <?php if($QA1700=="2") echo "checked";?>><b>Reentry</b>
</ol>  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>A1800. Entered From</b><?php if (substr($url[3],0,5)!="print"){ if($A1800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
<td class="answer"></td>
</table>
</td>
<td>
<ol class="zero">
<li><input type="radio" name="QA1800" value="01" <?php if($QA1800=="01") echo "checked";?>><b>Community</b> (private home/apt., board/care, assisted living, group home)
<li><input type="radio" name="QA1800" value="02" <?php if($QA1800=="02") echo "checked";?>><b>Another nursing home or swing bed</b>
<li><input type="radio" name="QA1800" value="03" <?php if($QA1800=="03") echo "checked";?>><b>Acute hospital</b>
<li><input type="radio" name="QA1800" value="04" <?php if($QA1800=="04") echo "checked";?>><b>Psychiatric hospital</b>
<li><input type="radio" name="QA1800" value="05" <?php if($QA1800=="05") echo "checked";?>><b>Inpatient rehabilitation facility</b>
<li><input type="radio" name="QA1800" value="06" <?php if($QA1800=="06") echo "checked";?>><b>ID/DD facility</b>
<li><input type="radio" name="QA1800" value="07" <?php if($QA1800=="07") echo "checked";?>><b>Hospice</b>
<li value="09"><input type="radio" name="QA1800" value="09" <?php if($QA1800=="09") echo "checked";?>><b>Long Term Care Hospital</b> (LTCH)
<li value="99"><input type="radio" name="QA1800" value="99" <?php if($QA1800=="99") echo "checked";?>><b>Other</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>A1900. Admission Date (Date this episode of care in this facility began)</b><?php if (substr($url[3],0,5)!="print"){ if($A1900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70"></td>
<td width="800">
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_1" value="<?php echo $QA1900_1; ?>" onkeyup="if(this.value.length==1)document.form4.QA1900_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_2" value="<?php echo $QA1900_2; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_1.focus();if(this.value.length==1)document.form4.QA1900_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_3" value="<?php echo $QA1900_3; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_2.focus();if(this.value.length==1)document.form4.QA1900_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_4" value="<?php echo $QA1900_4; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_3.focus();if(this.value.length==1)document.form4.QA1900_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_5" value="<?php echo $QA1900_5; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_4.focus();if(this.value.length==1)document.form4.QA1900_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_6" value="<?php echo $QA1900_6; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_5.focus();if(this.value.length==1)document.form4.QA1900_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_7" value="<?php echo $QA1900_7; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_6.focus();if(this.value.length==1)document.form4.QA1900_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA1900_8" value="<?php echo $QA1900_8; ?>" onkeyup="if(this.value.length==0)document.form4.QA1900_7.focus();"></td>
</table>
<a style="padding-left:47px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>A2000. Discharge Date</b><?php if (substr($url[3],0,5)!="print"){ if($A2000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br>Complete only if A0310F = 10, 11, or 12
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content"></td>
<td>
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_1" value="<?php echo $QA2000_1; ?>" onkeyup="if(this.value.length==1)document.form4.QA2000_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_2" value="<?php echo $QA2000_2; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_1.focus();if(this.value.length==1)document.form4.QA2000_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_3" value="<?php echo $QA2000_3; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_2.focus();if(this.value.length==1)document.form4.QA2000_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_4" value="<?php echo $QA2000_4; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_3.focus();if(this.value.length==1)document.form4.QA2000_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_5" value="<?php echo $QA2000_5; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_4.focus();if(this.value.length==1)document.form4.QA2000_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_6" value="<?php echo $QA2000_6; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_5.focus();if(this.value.length==1)document.form4.QA2000_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_7" value="<?php echo $QA2000_7; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_6.focus();if(this.value.length==1)document.form4.QA2000_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2000_8" value="<?php echo $QA2000_8; ?>" onkeyup="if(this.value.length==0)document.form4.QA2000_7.focus();"></td>
</table>
<a style="padding-left:47px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!---------------------------------------------->
</table>
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform04">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>