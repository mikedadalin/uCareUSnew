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
$sql = "SELECT * FROM `mdsform08` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left; width:70px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:30px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form8" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section C</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Cognitive Patterns</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>C0600. Should the Staff Assessment for Mental Status (C0700 - C1000) be Conducted?</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ol start="0">
<li><input type="radio" name="QC0600" value="0" <?php if($QC0600=="0") echo "checked";?>><b>No</b> (resident was able to complete interview ) &#8594; Skip to C1300, Signs and Symptoms of Delirium
<li><input type="radio" name="QC0600" value="1" <?php if($QC0600=="1") echo "checked";?>><b>Yes</b> (resident was unable to complete interview) &#8594; Continue to C0700, Short-term Memory OK
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2"><b>Staff Assessment for Mental Status</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">Do not conduct if Brief Interview for Mental Status (C0200-C0500) was completed</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>C0700. Short-term Memory OK</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="784" style="padding-left:5px">
<b>Seems or appears to recall after 5 minutes</b>
<ol start="0" style="padding-left:33px">
<li><input type="radio" name="QC0700" value="0" <?php if($QC0700=="0") echo "checked";?>><b>Memory OK</b>
<li><input type="radio" name="QC0700" value="1" <?php if($QC0700=="1") echo "checked";?>><b>Memory problem</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>C0800. Long-term Memory OK</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Seems or appears to recall long past</b>
<ol start="0" style="padding-left:33px">
<li><input type="radio" name="QC0800" value="0" <?php if($QC0800=="0") echo "checked";?>><b>Memory OK</b>
<li><input type="radio" name="QC0800" value="1" <?php if($QC0800=="1") echo "checked";?>><b>Memory problem</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>C0900. Memory/Recall Ability</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2" style="padding-left:32px">
<b>&#8595; Check all that the resident was normally able to recall</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QC0900A" value="X" <?php if($QC0900A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Current season</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QC0900B" value="X" <?php if($QC0900B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Location of own room</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QC0900C" value="X" <?php if($QC0900C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Staff names and faces</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QC0900D" value="X" <?php if($QC0900D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>That he or she is in a nursing home</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QC0900Z" value="X" <?php if($QC0900Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b> were recalled
</ul>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>C1000. Cognitive Skills for Daily Decision Making</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C1000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Made decisions regarding tasks of daily life</b>
<ol start="0" style="padding-left:33px">
<li><input type="radio" name="QC1000" value="0" <?php if($QC1000=="0") echo "checked";?>><b>Independent</b> - decisions consistent/reasonable
<li><input type="radio" name="QC1000" value="1" <?php if($QC1000=="1") echo "checked";?>><b>Modified independence</b> - some difficulty in new situations only
<li><input type="radio" name="QC1000" value="2" <?php if($QC1000=="2") echo "checked";?>><b>Moderately impaired</b> - decisions poor; cues/supervision required
<li><input type="radio" name="QC1000" value="3" <?php if($QC1000=="3") echo "checked";?>><b>Severely impaired</b> - never/rarely made decisions
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3">
<b>Delirium</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3">
<b>C1300. Signs and Symptoms of Delirium (from CAMc)</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
<b>Code <b>after completing</b> Brief Interview for Mental Status or Staff Assessment, and reviewing medical record</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="6" width="190">
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>Behavior not present</b>
<li><b>Behavior continuously <br>present, does not <br>fluctuate</b>
<li><b>Behavior present, <br>fluctuates</b> (comes and <br>goes, changes in severity)
</ol>
</td>
</tr>
<tr>
<td colspan="2" width="660">
<b style="padding-left:29px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($C1300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QC1300A" value="0" <?php if($QC1300A=="0") echo "checked";?>>0<br>
<input type="radio" name="QC1300A" value="1" <?php if($QC1300A=="1") echo "checked";?>>1<br>
<input type="radio" name="QC1300A" value="2" <?php if($QC1300A=="2") echo "checked";?>>2
</td>
<td width="590">
<ul>
<li><b>Inattention</b> - Did the resident have difficulty focusing attention (easily distracted, out of touch or<br> difficulty following what was said)?
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($C1300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QC1300B" value="0" <?php if($QC1300B=="0") echo "checked";?>>0<br>
<input type="radio" name="QC1300B" value="1" <?php if($QC1300B=="1") echo "checked";?>>1<br>
<input type="radio" name="QC1300B" value="2" <?php if($QC1300B=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="2"><b>Disorganized thinking</b> - Was the resident's thinking disorganized or incoherent (rambling or irrelevant<br> conversation, unclear or illogical flow of ideas, or unpredictable switching from subject to subject)?
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($C1300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QC1300C" value="0" <?php if($QC1300C=="0") echo "checked";?>>0<br>
<input type="radio" name="QC1300C" value="1" <?php if($QC1300C=="1") echo "checked";?>>1<br>
<input type="radio" name="QC1300C" value="2" <?php if($QC1300C=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="3"><b>Altered level of consciousness</b> - Did the resident have altered level of consciousness (e.g., <b>vigilant</b> - <br>startled easily to any sound or touch; <b>lethargic</b> - repeatedly dozed off when being asked questions, but<br> responded to voice or touch; <b>stuporous</b> - very difficult to arouse and keep aroused for the interview;<br> <b>comatose</b> - could not be aroused)?
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($C1300D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QC1300D" value="0" <?php if($QC1300D=="0") echo "checked";?>>0<br>
<input type="radio" name="QC1300D" value="1" <?php if($QC1300D=="1") echo "checked";?>>1<br>
<input type="radio" name="QC1300D" value="2" <?php if($QC1300D=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="4"><b>Psychomotor retardation</b>- Did the resident have an unusually decreased level of activity such as<br> sluggishness, staring into space, staying in one position, moving very slowly?
</ul>
</td>
</tr>
</table>	  
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>C1600. Acute Onset Mental Status Change</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C1600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<b style="padding-left:3px">Is there evidence of an acute change in mental status</b> from the resident's baseline?
<ol start="0" style="padding-left:33px">
<li><input type="radio" name="QC1600" value="0" <?php if($QC1600=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QC1600" value="1" <?php if($QC1600=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->	 
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform08">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">Copyright c 1990 Annals of Internal Medicine. All rights reserved. Adapted with permission.<br>MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>