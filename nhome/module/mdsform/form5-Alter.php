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
$sql = "SELECT * FROM `mdsform05` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:16px; margin:0px}
ol.zero {list-style:decimal-leading-zero; padding-left:45px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form5" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
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
<b>A2100. Discharge Status</b><?php if (substr($url[3],0,5)!="print"){ if($A2100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br>Complete only if A0310F = 10, 11, or 12
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
<td class="answer"></td>
</table>
</td>
<td width="800">
<ol class="zero">
<li><input type="radio" name="QA2100" value="01" <?php if($QA2100=="01") echo "checked";?>><b>Community</b> (private home/apt., board/care, assisted living, group home)
<li><input type="radio" name="QA2100" value="02" <?php if($QA2100=="02") echo "checked";?>><b>Another nursing home or swing bed</b>
<li><input type="radio" name="QA2100" value="03" <?php if($QA2100=="03") echo "checked";?>><b>Acute hospital</b>
<li><input type="radio" name="QA2100" value="04" <?php if($QA2100=="04") echo "checked";?>><b>Psychiatric hospital</b>
<li><input type="radio" name="QA2100" value="05" <?php if($QA2100=="05") echo "checked";?>><b>Inpatient rehabilitation facility</b>
<li><input type="radio" name="QA2100" value="06" <?php if($QA2100=="06") echo "checked";?>><b>ID/DD facility</b>
<li><input type="radio" name="QA2100" value="07" <?php if($QA2100=="07") echo "checked";?>><b>Hospice</b>
<li><input type="radio" name="QA2100" value="08" <?php if($QA2100=="08") echo "checked";?>><b>Deceased</b>
<li><input type="radio" name="QA2100" value="09" <?php if($QA2100=="09") echo "checked";?>><b>Long Term Care Hospital </b>(LTCH)
<li value="99"><input type="radio" name="QA2100" value="99" <?php if($QA2100=="99") echo "checked";?>><b>Other</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>A2200. Previous Assessment Reference Date for Significant Correction</b><?php if (substr($url[3],0,5)!="print"){ if($A2200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br>Complete only if A0310A = 05 or 06
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content"></td>
<td>
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_1" value="<?php echo $QA2200_1; ?>" onkeyup="if(this.value.length==1)document.form5.QA2200_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_2" value="<?php echo $QA2200_2; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_1.focus();if(this.value.length==1)document.form5.QA2200_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_3" value="<?php echo $QA2200_3; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_2.focus();if(this.value.length==1)document.form5.QA2200_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_4" value="<?php echo $QA2200_4; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_3.focus();if(this.value.length==1)document.form5.QA2200_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_5" value="<?php echo $QA2200_5; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_4.focus();if(this.value.length==1)document.form5.QA2200_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_6" value="<?php echo $QA2200_6; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_5.focus();if(this.value.length==1)document.form5.QA2200_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_7" value="<?php echo $QA2200_7; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_6.focus();if(this.value.length==1)document.form5.QA2200_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2200_8" value="<?php echo $QA2200_8; ?>" onkeyup="if(this.value.length==0)document.form5.QA2200_7.focus();"></td>
</table>
<a style="padding-left:47px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>A2300. Assessment Reference Date</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content"></td>
<td>
<b style="padding-left:5px">Observation end date:</b><br>
<table cellspacing="0" style="padding-left:20px; margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_1" value="<?php echo $QA2300_1; ?>" onkeyup="if(this.value.length==1)document.form5.QA2300_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_2" value="<?php echo $QA2300_2; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_1.focus();if(this.value.length==1)document.form5.QA2300_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_3" value="<?php echo $QA2300_3; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_2.focus();if(this.value.length==1)document.form5.QA2300_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_4" value="<?php echo $QA2300_4; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_3.focus();if(this.value.length==1)document.form5.QA2300_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_5" value="<?php echo $QA2300_5; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_4.focus();if(this.value.length==1)document.form5.QA2300_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_6" value="<?php echo $QA2300_6; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_5.focus();if(this.value.length==1)document.form5.QA2300_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_7" value="<?php echo $QA2300_7; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_6.focus();if(this.value.length==1)document.form5.QA2300_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2300_8" value="<?php echo $QA2300_8; ?>" onkeyup="if(this.value.length==0)document.form5.QA2300_7.focus();"></td>
</table>
<a style="padding-left:47px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>A2400. Medicare Stay</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($A2400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Has the resident had a Medicare-covered stay since the most recent entry?</b>
<ol start="0">
<li><input type="radio" name="QA2400A" value="0" <?php if($QA2400A=="0") echo "checked";?>><b>No &#8594;</b>Skip to B0100, Comatose
<li><input type="radio" name="QA2400A" value="1" <?php if($QA2400A=="1") echo "checked";?>><b>Yes &#8594;</b>Continue to A2400B, Start date of most recent Medicare stay
</ol>
<br>
<li><b>Start date of most recent Medicare stay:</b><?php if (substr($url[3],0,5)!="print"){ if($A2400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0" style="margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_1" value="<?php echo $QA2400B_1; ?>" onkeyup="if(this.value.length==1)document.form5.QA2400B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_2" value="<?php echo $QA2400B_2; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_1.focus();if(this.value.length==1)document.form5.QA2400B_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_3" value="<?php echo $QA2400B_3; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_2.focus();if(this.value.length==1)document.form5.QA2400B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_4" value="<?php echo $QA2400B_4; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_3.focus();if(this.value.length==1)document.form5.QA2400B_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_5" value="<?php echo $QA2400B_5; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_4.focus();if(this.value.length==1)document.form5.QA2400B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_6" value="<?php echo $QA2400B_6; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_5.focus();if(this.value.length==1)document.form5.QA2400B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_7" value="<?php echo $QA2400B_7; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_6.focus();if(this.value.length==1)document.form5.QA2400B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400B_8" value="<?php echo $QA2400B_8; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400B_7.focus();"></td>
</table>
<a style="padding-left:27px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
<li><b>End date of most recent Medicare stay</b> - Enter dashes if stay is ongoing:<?php if (substr($url[3],0,5)!="print"){ if($A2400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<table cellspacing="0" style="margin:3px">
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_1" value="<?php echo $QA2400C_1; ?>" onkeyup="if(this.value.length==1)document.form5.QA2400C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_2" value="<?php echo $QA2400C_2; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_1.focus();if(this.value.length==1)document.form5.QA2400C_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_3" value="<?php echo $QA2400C_3; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_2.focus();if(this.value.length==1)document.form5.QA2400C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_4" value="<?php echo $QA2400C_4; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_3.focus();if(this.value.length==1)document.form5.QA2400C_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_5" value="<?php echo $QA2400C_5; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_4.focus();if(this.value.length==1)document.form5.QA2400C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_6" value="<?php echo $QA2400C_6; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_5.focus();if(this.value.length==1)document.form5.QA2400C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_7" value="<?php echo $QA2400C_7; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_6.focus();if(this.value.length==1)document.form5.QA2400C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QA2400C_8" value="<?php echo $QA2400C_8; ?>" onkeyup="if(this.value.length==0)document.form5.QA2400C_7.focus();"></td>
</table>
<a style="padding-left:27px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>
</td>
</tr>
<!-------------------------------------------->	    
</table>
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform05">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>