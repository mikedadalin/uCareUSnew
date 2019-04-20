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
$sql = "SELECT * FROM `mdsform10` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.part2 {background-color:rgb(230,230,226); text-align:center}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.partwhite2 {background-color:rgb(255,255,255); text-align:left; padding-left:5px}
td.partwhite3 {background-color:rgb(255,255,255); text-align:left}
td.partwhite4 {background-color:rgb(255,255,255); text-align:center}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:30px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form10" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section D</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Mood</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6">
<tr>
<td class="part" colspan="4">
<b>D0500. Staff Assessment of Resident Mood (PHQ-9-OV*)</b><br>Do not conduct if Resident Mood Interview (D0200-D0300) was completed
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="4"><b>Over the last 2 weeks, did the resident have any of the following problems or behaviors?</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite2" colspan="4">
If symptom is present, enter 1 (yes) in column 1, Symptom Presence.<br>
Then move to column 2, Symptom Frequency, and indicate symptom frequency.
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="1" rowspan="2" width="303">
<ol style="padding-left:20px">
<li><b>Symptom Presence</b>
<ol start="0">
<li><b>No</b> enter 0 in column 2)
<li><b>Yes</b> (enter 0-3 in column 2)
</ol>
</ol>
</td>
<td class="partwhite3" colspan="1" rowspan="2" width="303">
<ol style="padding-left:20px">
<li value="2"><b>Symptom Frequency</b>
<ol start="0">
<li><b>Never or 1 day</b>
<li><b>2-6 days</b> (several days)
<li><b>7-11 days</b> (half or more of the days)
<li><b>12-14 days</b> (nearly every day)
</ol>
</ol>
</td>
<td class="part2" colspan="1" rowspan="1" width="125">
<b>1.<br>Symptom <br>Presence</b>
</td>
<td class="part2" colspan="1" rowspan="1" width="125">
<b>2.<br>Symptom <br>Frequency</b>
</td>
<tr>
<td class="partwhite4" colspan="2" rowspan="1" width="250">
<b>&#8595; Enter Scores in Boxes &#8595;</b>
</td>
</tr>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2" width="320">
<ul>
<li><b style="font-style:italic"><b>Little interest or pleasure in doing things</b>
</ul>			
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0500A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500A1" value="0" <?php if($QD0500A1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500A1" value="1" <?php if($QD0500A1=="1") echo "checked";?>>1
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0500A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500A2" value="0" <?php if($QD0500A2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500A2" value="1" <?php if($QD0500A2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500A2" value="2" <?php if($QD0500A2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500A2" value="3" <?php if($QD0500A2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="2"><b style="font-style:italic"><b>Feeling or appearing down, depressed, or hopeless</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500B1" value="0" <?php if($QD0500B1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500B1" value="1" <?php if($QD0500B1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500B2" value="0" <?php if($QD0500B2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500B2" value="1" <?php if($QD0500B2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500B2" value="2" <?php if($QD0500B2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500B2" value="3" <?php if($QD0500B2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="3"><b style="font-style:italic"><b>Trouble falling or staying asleep, or sleeping too much</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500C1" value="0" <?php if($QD0500C1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500C1" value="1" <?php if($QD0500C1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500C2" value="0" <?php if($QD0500C2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500C2" value="1" <?php if($QD0500C2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500C2" value="2" <?php if($QD0500C2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500C2" value="3" <?php if($QD0500C2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="4"><b style="font-style:italic"><b>Feeling tired or having little energy</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500D1" value="0" <?php if($QD0500D1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500D1" value="1" <?php if($QD0500D1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500D2" value="0" <?php if($QD0500D2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500D2" value="1" <?php if($QD0500D2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500D2" value="2" <?php if($QD0500D2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500D2" value="3" <?php if($QD0500D2=="3") echo "checked";?>>3
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="5"><b style="font-style:italic"><b>Poor appetite or overeating</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500E1" value="0" <?php if($QD0500E1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500E1" value="1" <?php if($QD0500E1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500E2" value="0" <?php if($QD0500E2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500E2" value="1" <?php if($QD0500E2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500E2" value="2" <?php if($QD0500E2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500E2" value="3" <?php if($QD0500E2=="3") echo "checked";?>>3
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="6"><b style="font-style:italic"><b>Indicating that s/he feels bad about self, is a failure, or has let self or family down</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500F1" value="0" <?php if($QD0500F1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500F1" value="1" <?php if($QD0500F1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500F2" value="0" <?php if($QD0500F2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500F2" value="1" <?php if($QD0500F2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500F2" value="2" <?php if($QD0500F2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500F2" value="3" <?php if($QD0500F2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="7"><b style="font-style:italic"><b>Trouble concentrating on things, such as reading the newspaper or watching television</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500G1" value="0" <?php if($QD0500G1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500G1" value="1" <?php if($QD0500G1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500G2" value="0" <?php if($QD0500G2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500G2" value="1" <?php if($QD0500G2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500G2" value="2" <?php if($QD0500G2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500G2" value="3" <?php if($QD0500G2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="8"><b style="font-style:italic"><b>Moving or speaking so slowly that other people have noticed. Or the opposite - being so fidgety <br>or restless that s/he has been moving around a lot more than usual</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500H1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500H1" value="0" <?php if($QD0500H1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500H1" value="1" <?php if($QD0500H1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500H2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500H2" value="0" <?php if($QD0500H2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500H2" value="1" <?php if($QD0500H2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500H2" value="2" <?php if($QD0500H2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500H2" value="3" <?php if($QD0500H2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="9"><b style="font-style:italic"><b>States that life isn't worth living, wishes for death, or attempts to harm self</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500I1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500I1" value="0" <?php if($QD0500I1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500I1" value="1" <?php if($QD0500I1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500I2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500I2" value="0" <?php if($QD0500I2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500I2" value="1" <?php if($QD0500I2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500I2" value="2" <?php if($QD0500I2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500I2" value="3" <?php if($QD0500I2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2">
<ul>
<li value="10"><b style="font-style:italic"><b>Being short-tempered, easily annoyed</b>  
</ul>			
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500J1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500J1" value="0" <?php if($QD0500J1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500J1" value="1" <?php if($QD0500J1=="1") echo "checked";?>>1
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($D0500J2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0500J2" value="0" <?php if($QD0500J2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0500J2" value="1" <?php if($QD0500J2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0500J2" value="2" <?php if($QD0500J2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0500J2" value="3" <?php if($QD0500J2=="3") echo "checked";?>>3
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6" style="margin-bottom:3px">
<tr>
<td class="part" style="padding-left:5px" colspan="2">
<b>D0600. Total Severity Score</b><?php if (substr($url[3],0,5)!="print"){ if($D0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<tr>
<td class="content" width="70" valign="top">
<p align="center" style="margin:0px">Enter Score</p>
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QD0600_1" value="<?php echo $QD0600_1; ?>" onkeyup="if(this.value.length==1)document.form10.QD0600_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QD0600_2" value="<?php echo $QD0600_2; ?>" onkeyup="if(this.value.length==0)document.form10.QD0600_1.focus();"></td>
</table>
</td>
<td width="766" style="padding-left:5px">
<b>Add scores for all frequency responses in Column 2,</b> Symptom Frequency. Total score must be between 00 and 30.
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>D0650. Safety Notification</b> - Complete only if D0500I1 = 1 indicating possibility of resident self harm
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($D0650_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="794" style="padding-left:5px">
<b>Was responsible staff or provider informed that there is a potential for resident self harm?</br>
<ol start="0">
<li><input type="radio" name="QD0650" value="0" <?php if($QD0650=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QD0650" value="1" <?php if($QD0650=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform10">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">* Copyright c Pfizer Inc. All rights reserved.<br>MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
