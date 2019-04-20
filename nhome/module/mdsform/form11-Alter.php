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
$sql = "SELECT * FROM `mdsform11` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.part2 {background-color:rgb(230,230,226); text-align:center}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.partwhite2 {background-color:rgb(255,255,255); text-align:left; padding-left:5px}
td.partwhite3 {background-color:rgb(255,255,255); text-align:left}
td.partwhite4 {background-color:rgb(255,255,255); text-align:center}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:37px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form11" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section E</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Behavior</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>E0100. Potential Indicators of Psychosis</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2" style="padding-left:32px"><b>&#8595; Check all that apply</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QE0100A" value="X" <?php if($QE0100A=="X") echo "checked";?>>
</td>
<td width="800">
<ul style="padding-left:20px">
<li><b>Hallucinations</b> (perceptual experiences in the absence of real external sensory stimuli)
</ul>	
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QE0100B" value="X" <?php if($QE0100B=="X") echo "checked";?>>
</td>
<td>
<ul style="padding-left:20px">
<li value="2"><b>Delusions</b> (misconceptions or beliefs that are firmly held, contrary to reality)
</ul>	
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QE0100Z" value="X" <?php if($QE0100Z=="X") echo "checked";?>>
</td>
<td>
<ul style="padding-left:20px">
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>Behavioral Symptoms</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>E0200. Behavioral Symptom - Presence & Frequency</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="partwhite" colspan="3">
<b>Note presence of symptoms and their frequency</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="6" width="260">
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>Behavior not exhibited</b>
<li><b>Behavior of this type occurred 1 to 3 days</b>
<li><b>Behavior of this type occurred 4 to 6 days,</b><br> but less than daily
<li><b>Behavior of this type occurred daily</b>
</ol>
</td>
</tr>
<tr>
<td colspan="2" width="610">
<b style="padding-left:32px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($E0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QE0200A" value="0" <?php if($QE0200A=="0") echo "checked";?>>0<br>
<input type="radio" name="QE0200A" value="1" <?php if($QE0200A=="1") echo "checked";?>>1<br>
<input type="radio" name="QE0200A" value="2" <?php if($QE0200A=="2") echo "checked";?>>2<br>
<input type="radio" name="QE0200A" value="3" <?php if($QE0200A=="3") echo "checked";?>>3
</td>
<td width="460">
<ul style="padding-left:20px">
<li>Physical behavioral symptoms directed toward others</b> (e.g., hitting, <br>kicking, pushing, scratching, grabbing, abusing others sexually)
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($E0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QE0200B" value="0" <?php if($QE0200B=="0") echo "checked";?>>0<br>
<input type="radio" name="QE0200B" value="1" <?php if($QE0200B=="1") echo "checked";?>>1<br>
<input type="radio" name="QE0200B" value="2" <?php if($QE0200B=="2") echo "checked";?>>2<br>
<input type="radio" name="QE0200B" value="3" <?php if($QE0200B=="3") echo "checked";?>>3
</td>
<td>
<ul style="padding-left:20px">
<li value="2"><b>Verbal behavioral symptoms directed toward others</b> (e.g., threatening <br>others, screaming at others, cursing at others)
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($E0200C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QE0200C" value="0" <?php if($QE0200C=="0") echo "checked";?>>0<br>
<input type="radio" name="QE0200C" value="1" <?php if($QE0200C=="1") echo "checked";?>>1<br>
<input type="radio" name="QE0200C" value="2" <?php if($QE0200C=="2") echo "checked";?>>2<br>
<input type="radio" name="QE0200C" value="3" <?php if($QE0200C=="3") echo "checked";?>>3
</td>
<td>
<ul style="padding-left:20px">
<li value="3"><b>Other behavioral symptoms not directed toward others</b> (e.g., physical <br>symptoms such as hitting or scratching self, pacing, rummaging, public <br>sexual acts, disrobing in public, throwing or smearing food or bodily wastes, <br>or verbal/vocal symptoms like screaming, disruptive sounds)
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>E0300. Overall Presence of Behavioral Symptoms</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
</table>
</td>
<td width="800">
<b style="padding-left:5px">Were any behavioral symptoms in questions E0200 coded 1, 2, or 3?</b>
<ol start="0">
<li><input type="radio" name="QE0300" value="0" <?php if($QE0300=="0") echo "checked";?>><b>No &#8594; </b>Skip to E0800, Rejection of Care
<li><input type="radio" name="QE0300" value="1" <?php if($QE0300=="1") echo "checked";?>><b>Yes &#8594; </b>Considering all of E0200, Behavioral Symptoms, answer E0500 and E0600 below
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>E0500. Impact on Resident</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<b style="padding-left:5px">Did any of the identified symptom(s):</b>
<ul>
<li><b>Put the resident at significant risk for physical illness or injury?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QE0500A" value="0" <?php if($QE0500A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE0500A" value="1" <?php if($QE0500A=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Significantly interfere with the resident's care?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QE0500B" value="0" <?php if($QE0500B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE0500B" value="1" <?php if($QE0500B=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>Significantly interfere with the resident's participation in activities or social interactions?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QE0500C" value="0" <?php if($QE0500C=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE0500C" value="1" <?php if($QE0500C=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>E0600. Impact on Others</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<b style="padding-left:5px">Did any of the identified symptom(s):</b>
<ul>
<li><b>Put others at significant risk for physical injury?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QE0600A" value="0" <?php if($QE0600A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE0600A" value="1" <?php if($QE0600A=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Significantly intrude on the privacy or activity of others?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QE0600B" value="0" <?php if($QE0600B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE0600B" value="1" <?php if($QE0600B=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0600C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>Significantly disrupt care or living environment?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QE0600C" value="0" <?php if($QE0600C=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QE0600C" value="1" <?php if($QE0600C=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>E0800. Rejection of Care - Presence & Frequency</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($E0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Did the resident reject evaluation or care</b> (e.g., bloodwork, taking medications, ADL assistance) <b>that is necessary to achieve the <br>resident's goals for health and well-being?</b> Do not include behaviors that have already been addressed (e.g., by discussion or care <br>planning with the resident or family), and/or determined to be consistent with resident values, preferences, or goals.
<ol start="0">
<li><input type="radio" name="QE0800" value="0" <?php if($QE0800=="0") echo "checked";?>><b>Behavior not exhibited</b>
<li><input type="radio" name="QE0800" value="1" <?php if($QE0800=="1") echo "checked";?>><b>Behavior of this type occurred 1 to 3 days</b>
<li><input type="radio" name="QE0800" value="2" <?php if($QE0800=="2") echo "checked";?>><b>Behavior of this type occurred 4 to 6 days,</b> but less than daily
<li><input type="radio" name="QE0800" value="3" <?php if($QE0800=="3") echo "checked";?>><b>Behavior of this type occurred daily</b>
</ol>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform11">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
