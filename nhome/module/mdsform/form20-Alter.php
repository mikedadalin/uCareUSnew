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
$sql = "SELECT * FROM `mdsform20` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
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
<form name="form20" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section J</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Health Conditions</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>J0100. Pain Management</b> - Complete for all residents, regardless of current pain level
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">At any time in the last 5 days, has the resident:</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li><b>Received scheduled pain medication regimen?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QJ0100A" value="0" <?php if($QJ0100A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ0100A" value="1" <?php if($QJ0100A=="1") echo "checked";?>><b>Yes</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Received PRN pain medications OR was offered and declined?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QJ0100B" value="0" <?php if($QJ0100B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ0100B" value="1" <?php if($QJ0100B=="1") echo "checked";?>><b>Yes</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>Received non-medication intervention for pain?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QJ0100C" value="0" <?php if($QJ0100C=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ0100C" value="1" <?php if($QJ0100C=="1") echo "checked";?>><b>Yes</b>
</ol>			
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>J0200. Should Pain Assessment Interview be Conducted?</b><br>Attempt to conduct interview with all residents. If resident is comatose, skip to J1100, Shortness of Breath (dyspnea)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ol start="0">
<li><input type="radio" name="QJ0200" value="0" <?php if($QJ0200=="0") echo "checked";?>><b>No</b> (resident is rarely/never understood)<b> &#8594; </b>Skip to and complete J0800, Indicators of Pain or Possible Pain
<li><input type="radio" name="QJ0200" value="1" <?php if($QJ0200=="1") echo "checked";?>><b>Yes &#8594; </b> Continue to J0300, Pain Presence
</ol>			
</td>
</tr>
</table>	  
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6">
<tr>
<td class="part" colspan="2">
<b>Pain Assessment Interview</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J0300. Pain Presence</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="772">
<a class="content3">Ask resident: <b>"Have you had pain or hurting at any time</b> in the last 5 days?"</a>
<ol start="0">
<li><input type="radio" name="QJ0300" value="0" <?php if($QJ0300=="0") echo "checked";?>><b>No &#8594; </b>Skip to J1100, Shortness of Breath
<li><input type="radio" name="QJ0300" value="1" <?php if($QJ0300=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to J0400, Pain Frequency
<li value="9"><input type="radio" name="QJ0300" value="9" <?php if($QJ0300=="9") echo "checked";?>><b>Unable to answer &#8594; </b>Skip to J0800, Indicators of Pain or Possible Pain
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>J0400. Pain Frequency</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3">Ask resident: <b>"How much of the time have you experienced pain or hurting</b> over the last 5 days?"</a>
<ol>
<li><input type="radio" name="QJ0400" value="1" <?php if($QJ0400=="1") echo "checked";?>><b>Almost constantly</b>
<li><input type="radio" name="QJ0400" value="2" <?php if($QJ0400=="2") echo "checked";?>><b>Frequently</b>
<li><input type="radio" name="QJ0400" value="3" <?php if($QJ0400=="3") echo "checked";?>><b>Occasionally</b>
<li><input type="radio" name="QJ0400" value="4" <?php if($QJ0400=="4") echo "checked";?>><b>Rarely</b>
<li value="9"><input type="radio" name="QJ0400" value="9" <?php if($QJ0400=="9") echo "checked";?>><b>Unable to answer</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>J0500. Pain Effect on Function</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li>Ask resident: "Over the past 5 days, <b>has pain made it hard for you to sleep at night?"</b>
</ul>
<ol start="0">
<li><input type="radio" name="QJ0500A" value="0" <?php if($QJ0500A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ0500A" value="1" <?php if($QJ0500A=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QJ0500A" value="9" <?php if($QJ0500A=="9") echo "checked";?>><b>Unable to answer</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2">Ask resident: "Over the past 5 days, <b>have you limited your day-to-day activities because of pain?"</b>
</ul>
<ol start="0">
<li><input type="radio" name="QJ0500B" value="0" <?php if($QJ0500B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ0500B" value="1" <?php if($QJ0500B=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QJ0500B" value="9" <?php if($QJ0500B=="9") echo "checked";?>><b>Unable to answer</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>J0600. Pain Intensity</b> - Administer <b>ONLY ONE</b> of the following pain intensity questions (A or B)</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Rating
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QJ0600A_1" value="<?php echo $QJ0600A_1; ?>" onkeyup="if(this.value.length==1)document.form20.QJ0600A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QJ0600A_2" value="<?php echo $QJ0600A_2; ?>" onkeyup="if(this.value.length==0)document.form20.QJ0600A_1.focus();"></td>
</table>
</td>
<td>
<ul>
<li><b>Numeric Rating Scale (00-10)</b><?php if (substr($url[3],0,5)!="print"){ if($J0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
Ask resident: "Please rate your worst pain over the last 5 days on a zero to ten scale, with zero being no pain and ten<br> as the worst pain you can imagine." (Show resident 00 -10 pain scale) <br><b>Enter two-digit response. Enter 99 if unable to answer.</b>
</ul>		  
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Verbal Descriptor Scale</b><br>Ask resident: "Please rate the intensity of your worst pain over the last 5 days." (Show resident verbal scale)
</ul>
<ol>
<li><input type="radio" name="QJ0600B" value="1" <?php if($QJ0600B=="1") echo "checked";?>><b>Mild</b>
<li><input type="radio" name="QJ0600B" value="2" <?php if($QJ0600B=="2") echo "checked";?>><b>Moderate</b>
<li><input type="radio" name="QJ0600B" value="3" <?php if($QJ0600B=="3") echo "checked";?>><b>Severe</b>
<li><input type="radio" name="QJ0600B" value="4" <?php if($QJ0600B=="4") echo "checked";?>><b>Very severe, horrible</b>
<li value="9"><input type="radio" name="QJ0600B" value="9" <?php if($QJ0600B=="9") echo "checked";?>><b>Unable to answer</b>
</ol>	  
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform20">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
