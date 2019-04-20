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
$sql = "SELECT * FROM `mdsform21` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
<form name="form21" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section J</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Health Conditions</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>J0700. Should the Staff Assessment for Pain be Conducted?</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ol start="0">
<li><input type="radio" name="QJ0700" value="0" <?php if($QJ0700=="0") echo "checked";?>><b>No</b> (J0400 = 1 thru 4) &#8594; Skip to J1100, Shortness of Breath (dyspnea)
<li><input type="radio" name="QJ0700" value="1" <?php if($QJ0700=="1") echo "checked";?>><b>Yes</b> (J0400 = 9) &#8594; Continue to J0800, Indicators of Pain or Possible Pain
</ol>			
</td>
</tr>
</table>  
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>Staff Assessment for Pain</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J0800. Indicators of Pain or Possible Pain</b> in the last 5 days<?php if (substr($url[3],0,5)!="print"){ if($J0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
<b style="padding-left:27px">&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QJ0800A" value="X" <?php if($QJ0800A=="X") echo "checked";?>>
</td>
<td width="790">
<ul>
<li><b>Non-verbal sounds</b> (e.g., crying, whining, gasping, moaning, or groaning)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ0800B" value="X" <?php if($QJ0800B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Vocal complaints of pain</b> (e.g., that hurts, ouch, stop)
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ0800C" value="X" <?php if($QJ0800C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Facial expressions</b> (e.g., grimaces, winces, wrinkled forehead, furrowed brow, clenched teeth or jaw)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ0800D" value="X" <?php if($QJ0800D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Protective body movements or postures</b> (e.g., bracing, guarding, rubbing or massaging a body part/area, clutching or holding a <br>body part during movement)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ0800Z" value="X" <?php if($QJ0800Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of these signs observed or documented &#8594; </b>If checked, skip to J1100, Shortness of Breath (dyspnea)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J0850. Frequency of Indicator of Pain or Possible Pain</b> in the last 5 days
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J0850_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3">Frequency with which resident complains or shows evidence of pain or possible pain</a>
<ol>
<li><input type="radio" name="QJ0850" value="1" <?php if($QJ0850=="1") echo "checked";?>><b>Indicators of pain</b> or possible pain observed <b>1 to 2 days</b>
<li><input type="radio" name="QJ0850" value="2" <?php if($QJ0850=="2") echo "checked";?>><b>Indicators of pain</b> or possible pain observed <b>3 to 4 days</b>
<li><input type="radio" name="QJ0850" value="3" <?php if($QJ0850=="3") echo "checked";?>><b>Indicators of pain</b> or possible pain observed <b>daily</b>
</ol>			
</td>
</tr>	
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>Other Health Conditions</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J1100. Shortness of Breath (dyspnea)</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
<b style="padding-left:27px">&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QJ1100A" value="X" <?php if($QJ1100A=="X") echo "checked";?>>
</td>
<td width="800">
<ul>
<li><b>Shortness of breath</b> or trouble breathing <b>with exertion</b> (e.g., walking, bathing, transferring)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ1100B" value="X" <?php if($QJ1100B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Shortness of breath</b> or trouble breathing <b>when sitting at rest</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ1100C" value="X" <?php if($QJ1100C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Shortness of breath</b> or trouble breathing <b>when lying flat</b>		
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
<input type="checkbox" name="QJ1100Z" value="X" <?php if($QJ1100Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b>		
</td>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J1300. Current Tobacco Use</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J1300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Tobacco use</b></a>
<ol start="0">
<li><input type="radio" name="QJ1300" value="0" <?php if($QJ1300=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ1300" value="1" <?php if($QJ1300=="1") echo "checked";?>><b>Yes</b>
</ol>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J1400. Prognosis</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($J1400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3">Does the resident have a condition or chronic disease that may result in a <b>life expectancy of less than 6 months?</b> (Requires physician <br><a style="padding-left:5px">documentation)</a></a>
<ol start="0">
<li><input type="radio" name="QJ1400" value="0" <?php if($QJ1400=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QJ1400" value="1" <?php if($QJ1400=="1") echo "checked";?>><b>Yes</b>
</ol>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>J1550. Problem Conditions</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
<b style="padding-left:27px">&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QJ1550A" value="X" <?php if($QJ1550A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Fever</b>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QJ1550B" value="X" <?php if($QJ1550B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Vomiting</b>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QJ1550C" value="X" <?php if($QJ1550C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Dehydrated</b>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QJ1550D" value="X" <?php if($QJ1550D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Internal bleeding</b>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QJ1550Z" value="X" <?php if($QJ1550Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b>			
</td>
</tr>
</table>	
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform21">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
