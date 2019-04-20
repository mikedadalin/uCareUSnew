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
$sql = "SELECT * FROM `mdsform28` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.content4 {background-color:rgb(255,255,255); text-align:left; padding-left:10px; padding-top:10px; padding-bottom:10px}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form28" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section N</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Medications</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>N0300. Injections</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0300" value="<?php echo $QN0300; ?>"></td>
</table>
</td>
<td class="content4" width="790">
<?php if (substr($url[3],0,5)!="print"){ if($N0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<b>Record the number of days that injections of any type</b> were received during the last 7 days or since admission/entry or reentry if less<br>than 7 days. If 0 &#8594; Skip to N0410, Medications Received
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>N0350. Insulin</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0350A" value="<?php echo $QN0350A; ?>"></td>
</table>
</td>
<td>
<ul>
<li><?php if (substr($url[3],0,5)!="print"){ if($N0350A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b><br>';} }?><b>Insulin injections - Record the number of days that insulin injections</b> were received during the last 7 days or since <br>admission/entryor reentry if less than 7 days		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0350B" value="<?php echo $QN0350B; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($N0350B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b><br>';} }?><b>Orders for insulin - Record the number of days the physician (or authorized assistant or practitioner) changed the resident's <br>insulin orders</b> during the last 7 days or since admission/entry or reentry if less than 7 days		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>N0410. Medications Received</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2"><b>Indicate the number of DAYS the resident received the following medications during the last 7 days or since admission/entry or reentry if less<br>than 7 days.</b> Enter "0" if medication was not received by the resident during the last 7 days</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410A" value="<?php echo $QN0410A; ?>"></td>
</table>
</td>
<td>
<ul>
<li><?php if (substr($url[3],0,5)!="print"){ if($N0410A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Antipsychotic</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410B" value="<?php echo $QN0410B; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($N0410B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Antianxiety</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410C" value="<?php echo $QN0410C; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="3"><?php if (substr($url[3],0,5)!="print"){ if($N0410C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Antidepressant</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410D" value="<?php echo $QN0410D; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="4"><?php if (substr($url[3],0,5)!="print"){ if($N0410D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Hypnotic</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410E" value="<?php echo $QN0410E; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="5"><?php if (substr($url[3],0,5)!="print"){ if($N0410E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Anticoagulant</b> (warfarin, heparin, or low-molecular weight heparin)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410F" value="<?php echo $QN0410F; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="6"><?php if (substr($url[3],0,5)!="print"){ if($N0410F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Antibiotic</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QN0410G" value="<?php echo $QN0410G; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="7"><?php if (substr($url[3],0,5)!="print"){ if($N0410G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Diuretic</b>		  
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform28">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
