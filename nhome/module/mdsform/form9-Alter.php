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
$sql = "SELECT * FROM `mdsform09` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
<form name="form9" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section D</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Mood</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="8" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>D0100. Should Resident Mood Interview be Conducted?</b> - Attempt to conduct interview with all residents
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($D0100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="786">
<ol start="0">
<li><input type="radio" name="QD0100" value="0" <?php if($QD0100=="0") echo "checked";?>><b>No</b> (resident is rarely/never understood) &#8594; Skip to and complete D0500-D0600, Staff Assessment of Resident Mood <br>(PHQ-9-OV)
<li><input type="radio" name="QD0100" value="1" <?php if($QD0100=="1") echo "checked";?>><b>Yes &#8594;</b> Continue to D0200, Resident Mood Interview (PHQ-9c)
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="4" style="margin-bottom:3px">
<tr>
<td class="part" colspan="5"><b>D0200. Resident Mood Interview (PHQ-9c)</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="5"><b>Say to resident: "Over the last 2 weeks, have you been bothered by any of the following problems?"</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite2" colspan="5">
If symptom is present, enter 1 (yes) in column 1, Symptom Presence.<br>
If yes in column 1, then ask the resident: "About how often have you been bothered by this?"<br>
Read and show the resident a card with the symptom frequency choices. Indicate response in column 2, Symptom Frequency.
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="2" rowspan="2" width="70">
<ol style="padding-left:20px">  
<li><b>Symptom Presence</b>
<ol start="0">
<li><b>No</b> (enter 0 in column 2)
<li><b>Yes</b> (enter 0-3 in column 2)
<li value="9"><b>No response</b> (leave column 2 blank)
</ol>
</ol>
</td>
<td class="partwhite3" colspan="1" rowspan="2" width="340">
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
<td class="partwhite3" colspan="3" width="320">
<ul>
<li><b style="font-style:italic">Little interest or pleasure in doing things</b>  
<ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200A1" value="0" <?php if($QD0200A1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200A1" value="1" <?php if($QD0200A1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200A1" value="9" <?php if($QD0200A1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200A2" value="0" <?php if($QD0200A2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200A2" value="1" <?php if($QD0200A2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200A2" value="2" <?php if($QD0200A2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200A2" value="3" <?php if($QD0200A2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="2"><b style="font-style:italic">Feeling down, depressed, or hopeless</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200B1" value="0" <?php if($QD0200B1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200B1" value="1" <?php if($QD0200B1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200B1" value="9" <?php if($QD0200B1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200B2" value="0" <?php if($QD0200B2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200B2" value="1" <?php if($QD0200B2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200B2" value="2" <?php if($QD0200B2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200B2" value="3" <?php if($QD0200B2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="3"><b style="font-style:italic">Trouble falling or staying asleep, or sleeping too much</b> 
</ul>			
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200C1" value="0" <?php if($QD0200C1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200C1" value="1" <?php if($QD0200C1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200C1" value="9" <?php if($QD0200C1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200C2" value="0" <?php if($QD0200C2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200C2" value="1" <?php if($QD0200C2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200C2" value="2" <?php if($QD0200C2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200C2" value="3" <?php if($QD0200C2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="4"><b style="font-style:italic">Feeling tired or having little energy</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200D1" value="0" <?php if($QD0200D1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200D1" value="1" <?php if($QD0200D1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200D1" value="9" <?php if($QD0200D1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200D2" value="0" <?php if($QD0200D2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200D2" value="1" <?php if($QD0200D2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200D2" value="2" <?php if($QD0200D2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200D2" value="3" <?php if($QD0200D2=="3") echo "checked";?>>3
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="5"><b style="font-style:italic">Poor appetite or overeating</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200E1" value="0" <?php if($QD0200E1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200E1" value="1" <?php if($QD0200E1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200E1" value="9" <?php if($QD0200E1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200E2" value="0" <?php if($QD0200E2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200E2" value="1" <?php if($QD0200E2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200E2" value="2" <?php if($QD0200E2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200E2" value="3" <?php if($QD0200E2=="3") echo "checked";?>>3
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="6"><b style="font-style:italic">Feeling bad about yourself - or that you are a failure or have let yourself or your family<br> down</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200F1" value="0" <?php if($QD0200F1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200F1" value="1" <?php if($QD0200F1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200F1" value="9" <?php if($QD0200F1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200F2" value="0" <?php if($QD0200F2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200F2" value="1" <?php if($QD0200F2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200F2" value="2" <?php if($QD0200F2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200F2" value="3" <?php if($QD0200F2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="7"><b style="font-style:italic">Trouble concentrating on things, such as reading the newspaper or watching television</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200G1" value="0" <?php if($QD0200G1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200G1" value="1" <?php if($QD0200G1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200G1" value="9" <?php if($QD0200G1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200G2" value="0" <?php if($QD0200G2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200G2" value="1" <?php if($QD0200G2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200G2" value="2" <?php if($QD0200G2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200G2" value="3" <?php if($QD0200G2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="8"><b style="font-style:italic">Moving or speaking so slowly that other people could have noticed. Or the opposite - <br>being so fidgety or restless that you have been moving around a lot more than usual</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200H1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200H1" value="0" <?php if($QD0200H1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200H1" value="1" <?php if($QD0200H1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200H1" value="9" <?php if($QD0200H1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200H2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200H2" value="0" <?php if($QD0200H2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200H2" value="1" <?php if($QD0200H2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200H2" value="2" <?php if($QD0200H2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200H2" value="3" <?php if($QD0200H2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite3" colspan="3">
<ul>
<li value="9"><b style="font-style:italic">Thoughts that you would be better off dead, or of hurting yourself in some way</b>  
</ul>
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200I1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200I1" value="0" <?php if($QD0200I1=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200I1" value="1" <?php if($QD0200I1=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200I1" value="9" <?php if($QD0200I1=="9") echo "checked";?>>9
</td>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($D0200I2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QD0200I2" value="0" <?php if($QD0200I2=="0") echo "checked";?>>0<br>
<input type="radio" name="QD0200I2" value="1" <?php if($QD0200I2=="1") echo "checked";?>>1<br>
<input type="radio" name="QD0200I2" value="2" <?php if($QD0200I2=="2") echo "checked";?>>2<br>
<input type="radio" name="QD0200I2" value="3" <?php if($QD0200I2=="3") echo "checked";?>>3
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" style="padding-left:5px" colspan="5">
<b>D0300. Total Severity Score</b><?php if (substr($url[3],0,5)!="print"){ if($D0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<tr>
<td class="content" colspan="1" width="70" valign="top">
<p align="center" style="margin:0px">Enter Score</p>
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QD0300_1" value="<?php echo $QD0300_1; ?>" onkeyup="if(this.value.length==1)document.form9.QD0300_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QD0300_2" value="<?php echo $QD0300_2; ?>" onkeyup="if(this.value.length==0)document.form9.QD0300_1.focus();"></td>
</table>
</td>
<td width="740" colspan="4" style="padding-left:5px">
<b>Add scores for all frequency responses in Column 2,</b> Symptom Frequency. Total score must be between 00 and 27. <br>Enter 99 if unable to complete interview (i.e., Symptom Frequency is blank for 3 or more items).
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>D0350. Safety Notification</b> - Complete only if D0200I1 = 1 indicating possibility of resident self harm
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($D0350_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="794" style="padding-left:5px">
<b>Was responsible staff or provider informed that there is a potential for resident self harm?</br>
<ol start="0">
<li><input type="radio" name="QD0350" value="0" <?php if($QD0350=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QD0350" value="1" <?php if($QD0350=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform09">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">Copyright c Pfizer Inc. All rights reserved. Reproduced with permission.<br>MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
