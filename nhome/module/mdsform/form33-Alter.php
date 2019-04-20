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
$sql = "SELECT * FROM `mdsform33` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form33" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section P</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Restraints</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:10px"> 
<tr>
<td class="part" colspan="3"><b>P0100. Physical Restraints</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
Physical restraints are any manual method or physical or mechanical device, material or equipment attached or adjacent to the resident's body that <br>the individual cannot remove easily which restricts freedom of movement or normal access to one's body
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="12" width="210">
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>Not used</b>
<li><b>Used less than daily</b>
<li><b>Used daily</b>
</ol>
</td>
</tr>
<tr>
<td colspan="2" bgcolor="white" width="648">
<b style="padding-left:31px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="part" width="70"></td>
<td class="part" width="578">
<b>Used in Bed</b>
</td>
</tr>	  
<tr>
<td class="content">
<input type="radio" name="QP0100A" value="0" <?php if($QP0100A=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100A" value="1" <?php if($QP0100A=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100A" value="2" <?php if($QP0100A=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li><b>Bed rail</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100B" value="0" <?php if($QP0100B=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100B" value="1" <?php if($QP0100B=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100B" value="2" <?php if($QP0100B=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="2"><b>Trunk restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100C" value="0" <?php if($QP0100C=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100C" value="1" <?php if($QP0100C=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100C" value="2" <?php if($QP0100C=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="3"><b>Limb restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100D" value="0" <?php if($QP0100D=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100D" value="1" <?php if($QP0100D=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100D" value="2" <?php if($QP0100D=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="4"><b>Other</b>
</ul>
</td>
</tr>
<tr>
<td class="part"></td>
<td class="part">
<b>Used in Chair or Out of Bed</b>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100E" value="0" <?php if($QP0100E=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100E" value="1" <?php if($QP0100E=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100E" value="2" <?php if($QP0100E=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="5"><b>Trunk restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100F" value="0" <?php if($QP0100F=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100F" value="1" <?php if($QP0100F=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100F" value="2" <?php if($QP0100F=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="6"><b>Limb restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100G" value="0" <?php if($QP0100G=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100G" value="1" <?php if($QP0100G=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100G" value="2" <?php if($QP0100G=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="7"><b>Chair prevents rising</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="radio" name="QP0100H" value="0" <?php if($QP0100H=="0") echo "checked";?>>0<br>
<input type="radio" name="QP0100H" value="1" <?php if($QP0100H=="1") echo "checked";?>>1<br>
<input type="radio" name="QP0100H" value="2" <?php if($QP0100H=="2") echo "checked";?>>2
</td>
<td>
<ul>
<li value="8"><b>Other</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b>Section Q</b></td>
<td class="section2" width="720"><b>Participation in Assessment and Goal Setting</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px"> 
<tr>
<td class="part" colspan="2"><b>Q0100. Participation in Assessment</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<ul>
<li><b>Resident participated in assessment</b>
</ul>
<ol start="0">
<li><input type="radio" name="QQ0100A" value="0" <?php if($QQ0100A=="0") echo "checked";?>><b>No</b>	
<li><input type="radio" name="QQ0100A" value="1" <?php if($QQ0100A=="1") echo "checked";?>><b>Yes</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Family or significant other participated in assessment</b>
</ul>
<ol start="0">
<li><input type="radio" name="QQ0100B" value="0" <?php if($QQ0100B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QQ0100B" value="1" <?php if($QQ0100B=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QQ0100B" value="9" <?php if($QQ0100B=="9") echo "checked";?>><b>Resident has no family or significant other</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	 
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>Guardian or legally authorized representative participated in assessment</b>
</ul>
<ol start="0">
<li><input type="radio" name="QQ0100C" value="0" <?php if($QQ0100C=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QQ0100C" value="1" <?php if($QQ0100C=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QQ0100C" value="9" <?php if($QQ0100C=="9") echo "checked";?>><b>Resident has no guardian or legally authorized representative</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	 
<tr>
<td class="part" colspan="2"><b>Q0300. Resident's Overall Expectation</b><br>Complete only if A0310E = 1</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Select one for resident's overall goal established during assessment process</b>
</ul>
<ol>
<li><input type="radio" name="QQ0300A" value="1" <?php if($QQ0300A=="1") echo "checked";?>>Expects to be <b>discharged to the community</b>
<li><input type="radio" name="QQ0300A" value="2" <?php if($QQ0300A=="2") echo "checked";?>>Expects to <b>remain in this facility</b>
<li><input type="radio" name="QQ0300A" value="3" <?php if($QQ0300A=="3") echo "checked";?>>Expects to be <b>discharged to another facility/institution</b>
<li value="9"><input type="radio" name="QQ0300A" value="9" <?php if($QQ0300A=="9") echo "checked";?>><b>Unknown or uncertain</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Indicate information source for Q0300A</b>
</ul>
<ol>
<li><input type="radio" name="QQ0300B" value="1" <?php if($QQ0300B=="1") echo "checked";?>><b>Resident</b>
<li><input type="radio" name="QQ0300B" value="2" <?php if($QQ0300B=="2") echo "checked";?>>If not resident, then <b>family or significant other</b>
<li><input type="radio" name="QQ0300B" value="3" <?php if($QQ0300B=="3") echo "checked";?>>If not resident, family, or significant other, then <b>guardian or legally authorized representative</b>
<li value="9"><input type="radio" name="QQ0300B" value="9" <?php if($QQ0300B=="9") echo "checked";?>><b>Unknown or uncertain</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>Q0400. Discharge Plan</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Is active discharge planning already occurring for the resident to return to the community?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QQ0400A" value="0" <?php if($QQ0400A=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QQ0400A" value="1" <?php if($QQ0400A=="1") echo "checked";?>><b>Yes &#8594; </b>Skip to Q0600, Referral
</ol>			  
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform33">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
