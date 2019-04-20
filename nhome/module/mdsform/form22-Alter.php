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
$sql = "SELECT * FROM `mdsform22` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form22" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section J</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Health Conditions</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>J1700. Fall History on Admission</b><br>Complete only if A0310A = 01 or A0310E = 1
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J1700A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li>Did the resident have a fall any time in the <b>last month</b> prior to admission/entry or reentry?
</ul>
<ol start="0">
<li><input type="radio" name="QJ1700A" value="0" <?php if($QJ1700A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ1700A" value="1" <?php if($QJ1700A=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QJ1700A" value="9" <?php if($QJ1700A=="9") echo "checked";?>><b>Unable to determine</b>
</ol>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J1700B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2">Did the resident have a fall any time in the <b>last 2-6 months</b> prior to admission/entry or reentry?
</ul>
<ol start="0">
<li><input type="radio" name="QJ1700B" value="0" <?php if($QJ1700B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ1700B" value="1" <?php if($QJ1700B=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QJ1700B" value="9" <?php if($QJ1700B=="9") echo "checked";?>><b>Unable to determine</b>
</ol>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J1700C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3">Did the resident have any <b>fracture related to a fall in the 6 months</b> prior to admission/entry or reentry?
</ul>
<ol start="0">
<li><input type="radio" name="QJ1700C" value="0" <?php if($QJ1700C=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ1700C" value="1" <?php if($QJ1700C=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QJ1700C" value="9" <?php if($QJ1700C=="9") echo "checked";?>><b>Unable to determine</b>
</ol>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J1800. Any Falls Since Admission/Entry or Reentry or Prior Assessment (OBRA or Scheduled PPS),</b> whichever is more recent
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J1800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3">Has the resident <b>had any falls since admission/entry or reentry or the prior assessment </b>(OBRA or Scheduled PPS), whichever is more recent?</a>
<ol start="0">
<li><input type="radio" name="QJ1800" value="0" <?php if($QJ1800=="0") echo "checked";?>><b>No &#8594; </b>Skip to K0100, Swallowing Disorder
<li><input type="radio" name="QJ1800" value="1" <?php if($QJ1800=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to J1900, Number of Falls Since Admission/Entry or Reentry or Prior Assessment (OBRA or Scheduled PPS)
</ol>			
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3">
<b>J1900. Number of Falls Since Admission or Prior Assessment (OBRA, PPS, or Discharge),</b> whichever is more recent
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="5" width="210">
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>None</b>
<li><b>One</b>
<li><b>Two or more</b>
</ol>
</td>
</tr>
<tr>
<td colspan="2" bgcolor="white" width="660">
<b style="padding-left:29px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($J1900A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QJ1900A" value="0" <?php if($QJ1900A=="0") echo "checked";?>>0<br>
<input type="radio" name="QJ1900A" value="1" <?php if($QJ1900A=="1") echo "checked";?>>1<br>
<input type="radio" name="QJ1900A" value="2" <?php if($QJ1900A=="2") echo "checked";?>>2
</td>
<td width="588">
<ul>
<li><b>No injury</b> - no evidence of any injury is noted on physical assessment by the nurse or primary <br>care clinician; no complaints of pain or injury by the resident; no change in the resident's <br>behavior is noted after the fall
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($J1900B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QJ1900B" value="0" <?php if($QJ1900B=="0") echo "checked";?>>0<br>
<input type="radio" name="QJ1900B" value="1" <?php if($QJ1900B=="1") echo "checked";?>>1<br>
<input type="radio" name="QJ1900B" value="2" <?php if($QJ1900B=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="2"><b>Injury (except major)</b> - skin tears, abrasions, lacerations, superficial bruises, hematomas and <br>sprains; or any fall-related injury that causes the resident to complain of pain
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($J1900C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QJ1900C" value="0" <?php if($QJ1900C=="0") echo "checked";?>>0<br>
<input type="radio" name="QJ1900C" value="1" <?php if($QJ1900C=="1") echo "checked";?>>1<br>
<input type="radio" name="QJ1900C" value="2" <?php if($QJ1900C=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="3"><b>Major injury</b> - bone fractures, joint dislocations, closed head injuries with altered <br>consciousness, subdural hematoma
</ul>
</td>
</tr>
</table>		
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform22">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>