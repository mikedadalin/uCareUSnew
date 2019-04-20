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
$sql = "SELECT * FROM `mdsform32` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.content {background-color:rgb(230,230,226); font-size:xx-small; padding-left:5px; width:60px}
td.content2 {background-color:rgb(230,230,226); text-align:center;}
a.content3 {padding-left:5px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form32" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="140"><b style="padding-left:5px">Section O</b></td>
<td class="section2" width="700"><b style="padding-left:5px">Special Treatments, Procedures, and Programs</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>O0500. Restorative Nursing Programs</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
Record the <b>number of days</b> each of the following restorative programs was performed (for at least 15 minutes a day) in the last 7 calendar days <br>(enter 0 if none or less than 15 minutes daily)
</td>
</tr>
<!--------------------------------------------> 
<tr> 
<td class="partwhite" style="text-align:center" width="70">
<b>Number <br>of Days</b>
</td>
<td class="content" style="text-align:left" width="776">
<b>Technique</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500A" value="<?php echo $QO0500A; ?>"></td>
</table>
</td>
<td>
<ul>
<li><?php if (substr($url[3],0,5)!="print"){ if($O0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Range of motion (passive)</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500B" value="<?php echo $QO0500B; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($O0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Range of motion (active)</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500C" value="<?php echo $QO0500C; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="3"><?php if (substr($url[3],0,5)!="print"){ if($O0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Splint or brace assistance</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="partwhite" style="text-align:center">
<b>Number <br>of Days</b>
</td>
<td class="content" style="text-align:left">
<b>Training and Skill Practice In:</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500D" value="<?php echo $QO0500D; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="4"><?php if (substr($url[3],0,5)!="print"){ if($O0500D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Bed mobility</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500E" value="<?php echo $QO0500E; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="5"><?php if (substr($url[3],0,5)!="print"){ if($O0500E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Transfer</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500F" value="<?php echo $QO0500F; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="6"><?php if (substr($url[3],0,5)!="print"){ if($O0500F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Walking</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500G" value="<?php echo $QO0500G; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="7"><?php if (substr($url[3],0,5)!="print"){ if($O0500G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Dressing and/or grooming</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500H" value="<?php echo $QO0500H; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="8"><?php if (substr($url[3],0,5)!="print"){ if($O0500H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Eating and/or swallowing</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500I" value="<?php echo $QO0500I; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="9"><?php if (substr($url[3],0,5)!="print"){ if($O0500I_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Amputation/prostheses care</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0500J" value="<?php echo $QO0500J; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="10"><?php if (substr($url[3],0,5)!="print"){ if($O0500J_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Communication</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>O0600. Physician Examinations</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0600_1" value="<?php echo $QO0600_1; ?>" onkeyup="if(this.value.length==1)document.form32.QO0600_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0600_2" value="<?php echo $QO0600_2; ?>" onkeyup="if(this.value.length==0)document.form32.QO0600_1.focus();"></td>
</table>
</td>
<td>
<a class="content3"><?php if (substr($url[3],0,5)!="print"){ if($O0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>Over the last 14 days, <b>on how many days did the physician (or authorized assistant or practitioner) examine the resident?</b></a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>O0700. Physician Orders</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content2">
Enter Days
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0700_1" value="<?php echo $QO0700_1; ?>" onkeyup="if(this.value.length==1)document.form32.QO0700_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0700_2" value="<?php echo $QO0700_2; ?>" onkeyup="if(this.value.length==0)document.form32.QO0700_1.focus();"></td>
</table>
</td>
<td>
<a class="content3"><?php if (substr($url[3],0,5)!="print"){ if($O0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>Over the last 14 days, <b>on how many days did the physician (or authorized assistant or practitioner) change the resident's orders?</b></a>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform32">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
