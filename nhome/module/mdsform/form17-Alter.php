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
$sql = "SELECT * FROM `mdsform17` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:5px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form17" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section H</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Bladder and Bowel</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>H0100. Appliances</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2" style="padding-left:32px"><b>&#8595; Check all that apply</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QH0100A" value="X" <?php if($QH0100A=="X") echo "checked";?>>
</td>
<td width="800">
<ul>
<li><b>Indwelling catheter</b> (including suprapubic catheter and nephrostomy tube)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QH0100B" value="X" <?php if($QH0100B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>External catheter</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QH0100C" value="X" <?php if($QH0100C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Ostomy</b> (including urostomy, ileostomy, and colostomy)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QH0100D" value="X" <?php if($QH0100D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Intermittent catheterization</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QH0100Z" value="X" <?php if($QH0100Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>H0200. Urinary Toileting Program</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Has a trial of a toileting program (e.g., scheduled toileting, prompted voiding, or bladder training)</b> been attempted on <br>admission/reentry or since urinary incontinence was noted in this facility?
</ul>
<ol start="0">
<li><input type="radio" name="QH0200A" value="0" <?php if($QH0200A=="0") echo "checked";?>><b>No &#8594; </b>Skip to H0300, Urinary Continence
<li><input type="radio" name="QH0200A" value="1" <?php if($QH0200A=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to H0200B, Response
<li value="9"><input type="radio" name="QH0200A" value="9" <?php if($QH0200A=="9") echo "checked";?>><b>Unable to determine &#8594; </b>Skip to H0200C, Current toileting program or trial
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Response</b> - What was the resident's response to the trial program?
</ul>
<ol start="0">
<li><input type="radio" name="QH0200B" value="0" <?php if($QH0200B=="0") echo "checked";?>><b>No improvement</b>
<li><input type="radio" name="QH0200B" value="1" <?php if($QH0200B=="1") echo "checked";?>><b>Decreased wetness</b>
<li><input type="radio" name="QH0200B" value="2" <?php if($QH0200B=="2") echo "checked";?>><b>Completely dry</b> (continent)
<li value="9"><input type="radio" name="QH0200B" value="9" <?php if($QH0200B=="9") echo "checked";?>><b>Unable to determine</b> or trial in progress
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0200C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>Current toileting program or trial</b> - Is a toileting program (e.g., scheduled toileting, prompted voiding, or bladder training) currently <br>being used to manage the resident's urinary continence?
</ul>
<ol start="0">
<li><input type="radio" name="QH0200C" value="0" <?php if($QH0200C=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QH0200C" value="1" <?php if($QH0200C=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>H0300. Urinary Continence</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Urinary continence</b> - Select the one category that best describes the resident</a>
<ol start="0">
<li><input type="radio" name="QH0300" value="0" <?php if($QH0300=="0") echo "checked";?>><b>Always continent</b>
<li><input type="radio" name="QH0300" value="1" <?php if($QH0300=="1") echo "checked";?>><b>Occasionally incontinent</b> (less than 7 episodes of incontinence)
<li><input type="radio" name="QH0300" value="2" <?php if($QH0300=="2") echo "checked";?>><b>Frequently incontinent</b> (7 or more episodes of urinary incontinence, but at least one episode of continent voiding)
<li><input type="radio" name="QH0300" value="3" <?php if($QH0300=="3") echo "checked";?>><b>Always incontinent</b> (no episodes of continent voiding)
<li value="9"><input type="radio" name="QH0300" value="9" <?php if($QH0300=="9") echo "checked";?>><b>Not rated,</b> resident had a catheter (indwelling, condom), urinary ostomy, or no urine output for the entire 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>H0400. Bowel Continence</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Bowel continence</b> - Select the one category that best describes the resident</a>
<ol start="0">
<li><input type="radio" name="QH0400" value="0" <?php if($QH0400=="0") echo "checked";?>><b>Always continent</b>
<li><input type="radio" name="QH0400" value="1" <?php if($QH0400=="1") echo "checked";?>><b>Occasionally incontinent</b> (one episode of bowel incontinence)
<li><input type="radio" name="QH0400" value="2" <?php if($QH0400=="2") echo "checked";?>><b>Frequently incontinent</b> (2 or more episodes of bowel incontinence, but at least one continent bowel movement)
<li><input type="radio" name="QH0400" value="3" <?php if($QH0400=="3") echo "checked";?>><b>Always incontinent</b> (no episodes of continent bowel movements)
<li value="9"><input type="radio" name="QH0400" value="9" <?php if($QH0400=="9") echo "checked";?>><b>Not rated,</b> resident had an ostomy or did not have a bowel movement for the entire 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>H0500. Bowel Toileting Program</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Is a toileting program currently being used to manage the resident's bowel continence?</b></a>
<ol start="0">
<li><input type="radio" name="QH0500" value="0" <?php if($QH0500=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QH0500" value="1" <?php if($QH0500=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="part" colspan="2">
<b>H0600. Bowel Patterns</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($H0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Constipation present?</b></a>
<ol start="0">
<li><input type="radio" name="QH0600" value="0" <?php if($QH0600=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QH0600" value="1" <?php if($QH0600=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform17">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
