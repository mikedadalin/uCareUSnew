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
$sql = "SELECT * FROM `mdsform16` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.partwhite5 {background-color:rgb(255,255,255); text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form16" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="155"><b style="padding-left:5px">Section G</b></td>
<td class="section2" width="725"><b style="padding-left:5px">Functional Status</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>G0120. Bathing</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2"><b>How resident takes full-body bath/shower, sponge bath, and transfers in/out of tub/shower (<b>excludes</b> washing of back and hair). Code for <b>most <br>dependent</b> in self-performance and support</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($G0120A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li><b>Self-performance</b>
</ul>
<ol start="0">
<li><input type="radio" name="QG0120A" value="0" <?php if($QG0120A=="0") echo "checked";?>><b>Independent</b> - no help provided
<li><input type="radio" name="QG0120A" value="1" <?php if($QG0120A=="1") echo "checked";?>><b>Supervision</b> - oversight help only
<li><input type="radio" name="QG0120A" value="2" <?php if($QG0120A=="2") echo "checked";?>><b>Physical help limited to transfer only</b>
<li><input type="radio" name="QG0120A" value="3" <?php if($QG0120A=="3") echo "checked";?>><b>Physical help in part of bathing activity</b>
<li><input type="radio" name="QG0120A" value="4" <?php if($QG0120A=="4") echo "checked";?>><b>Total dependence</b>
<li value="8"><input type="radio" name="QG0120A" value="8" <?php if($QG0120A=="8") echo "checked";?>><b>Activity itself did not occur</b> or family and/or non-facility staff provided care 100% of the time for that activity over the entire 7-day period
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($G0120B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Support provided</b>
</ul>
<ol start="0">
<li><input type="radio" name="QG0120B" value="0" <?php if($QG0120B=="0") echo "checked";?>><b>No</b> setup or physical help from staff
<li><input type="radio" name="QG0120B" value="1" <?php if($QG0120B=="1") echo "checked";?>><b>Setup</b> help only
<li><input type="radio" name="QG0120B" value="2" <?php if($QG0120B=="2") echo "checked";?>><b>One</b> person physical assist
<li><input type="radio" name="QG0120B" value="3" <?php if($QG0120B=="3") echo "checked";?>><b>Two+</b> persons physical assist
<li value="8"><input type="radio" name="QG0120B" value="8" <?php if($QG0120B=="8") echo "checked";?>>ADL activity itself <b>did not occur</b> or family and/or non-facility staff provided care 100% of the time for that activity over the entire 7-day period
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3"><b>G0300. Balance During Transitions and Walking</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
After observing the resident, <b>code the following walking and transition items for most dependent</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="7" width="408">
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>Steady at all times</b>
<li><b>Not steady, but <u>able</u> to stabilize without staff <br>assistance</b>
<li><b>Not steady, <u>only</u> <u>able</u> to stabilize with staff <br>assistance.</b>
<li value="8"><b>Activity did not occur</b>
</ol>
</td>
</tr>
<tr>
<td class="partwhite5" colspan="2" width="470">
<b style="padding-left:29px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($G0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0300A" value="0" <?php if($QG0300A=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0300A" value="1" <?php if($QG0300A=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0300A" value="2" <?php if($QG0300A=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0300A" value="8" <?php if($QG0300A=="8") echo "checked";?>>8
</td>
<td width="400">
<ul>
<li><b>Moving from seated to standing position</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0300B" value="0" <?php if($QG0300B=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0300B" value="1" <?php if($QG0300B=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0300B" value="2" <?php if($QG0300B=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0300B" value="8" <?php if($QG0300B=="8") echo "checked";?>>8
</td>
<td>
<ul>
<li value="2"><b>Walking</b> (with assistive device if used)
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0300C" value="0" <?php if($QG0300C=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0300C" value="1" <?php if($QG0300C=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0300C" value="2" <?php if($QG0300C=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0300C" value="8" <?php if($QG0300C=="8") echo "checked";?>>8
</td>
<td>
<ul>
<li value="3"><b>Turning around</b> and facing the opposite direction while walking
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0300D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0300D" value="0" <?php if($QG0300D=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0300D" value="1" <?php if($QG0300D=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0300D" value="2" <?php if($QG0300D=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0300D" value="8" <?php if($QG0300D=="8") echo "checked";?>>8
</td>
<td>
<ul>
<li value="4"><b>Moving on and off toilet</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0300E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0300E" value="0" <?php if($QG0300E=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0300E" value="1" <?php if($QG0300E=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0300E" value="2" <?php if($QG0300E=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0300E" value="8" <?php if($QG0300E=="8") echo "checked";?>>8
</td>
<td>
<ul>
<li value="5"><b>Surface-to-surface transfer</b> (transfer between bed and chair or <br>wheelchair)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3"><b>G0400. Functional Limitation in Range of Motion</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
<b>Code for limitation</b> that interfered with daily functions or placed resident at risk of injury
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="4">
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>No impairment</b>
<li><b>Impairment on one side</b>
<li><b>Impairment on both sides</b>
</ol>
</td>
</tr>
<tr>
<td class="partwhite5" colspan="2">
<b style="padding-left:29px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0400A" value="0" <?php if($QG0400A=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0400A" value="1" <?php if($QG0400A=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0400A" value="2" <?php if($QG0400A=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li><b>Upper extremity</b> (shoulder, elbow, wrist,hand)
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0400B" value="0" <?php if($QG0400B=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0400B" value="1" <?php if($QG0400B=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0400B" value="2" <?php if($QG0400B=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="2"><b>Lower extremity</b> (hip, knee, ankle, foot)
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>G0600. Mobility Devices</b><?php if (substr($url[3],0,5)!="print"){ if($G0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2" style="padding-left:32px"><b>&#8595; Check all that were normally used</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QG0600A" value="X" <?php if($QG0600A=="X") echo "checked";?>>
</td>
<td width="810">
<ul>
<li><b>Cane/crutch</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QG0600B" value="X" <?php if($QG0600B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Walker</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QG0600C" value="X" <?php if($QG0600C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Wheelchair</b> (manual or electric)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QG0600D" value="X" <?php if($QG0600D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Limb prosthesis</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QG0600Z" value="X" <?php if($QG0600Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b> were used
</ul>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>G0900. Functional Rehabilitation Potential</b><br>Complete only if A0310A = 01
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($G0900A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li><b>Resident believes he or she is capable of increased independence</b> in at least some ADLs
</ul>
<ol start="0">
<li><input type="radio" name="QG0900A" value="0" <?php if($QG0900A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QG0900A" value="1" <?php if($QG0900A=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QG0900A" value="9" <?php if($QG0900A=="9") echo "checked";?>><b>Unable to determine</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($G0900B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Direct care staff believe resident is capable of increased independence</b> in at least some ADLs
</ul>
<ol start="0">
<li><input type="radio" name="QG0900B" value="0" <?php if($QG0900B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QG0900B" value="1" <?php if($QG0900B=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform16">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
