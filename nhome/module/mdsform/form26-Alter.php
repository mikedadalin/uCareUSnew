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
$sql = "SELECT * FROM `mdsform26` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
<form name="form26" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section M</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Skin Conditions</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>M0300. Current Number of Unhealed Pressure Ulcers at Each Stage</b> - Continued
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300E1" value="<?php echo $QM0300E1; ?>"></td>
</table>
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300E2" value="<?php echo $QM0300E2; ?>"></td>
</table>
</td>
<td width="794">
<ul>
<li value="5"><b>Unstageable - Non-removable dressing:</b> Known but not stageable due to non-removable dressing/device
</ul>
<ol>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of unstageable pressure ulcers due to non-removable dressing/device</b>- If 0 &#8594; Skip to M0300F, Unstageable:<br>Slough and/or eschar
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of <u>these</u> unstageable pressure ulcers that were present upon admission/entry or reentry</b>- enter how many were <br>noted at the time of admission/entry or reentry
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300F1" value="<?php echo $QM0300F1; ?>"></td>
</table>
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300F2" value="<?php echo $QM0300F2; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="6"><b>Unstageable - Slough and/or eschar:</b> Known but not stageable due to coverage of wound bed by slough and/or eschar
</ul>
<ol>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of unstageable pressure ulcers due to coverage of wound bed by slough and/or eschar</b>- If 0 &#8594; Skip to M0300G,<br>Unstageable: Deep tissue
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of <u>these</u> unstageable pressure ulcers that were present upon admission/entry or reentry</b>- enter how many were <br>noted at the time of admission/entry or reentry
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300G1" value="<?php echo $QM0300G1; ?>"></td>
</table>
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300G2" value="<?php echo $QM0300G2; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="7"><b>Unstageable - Deep tissue:</b> Suspected deep tissue injury in evolution
</ul>
<ol>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of unstageable pressure ulcers with suspected deep tissue injury in evolution</b>- If 0 <b>&#8594;</b> Skip to M0610, Dimension<br>of Unhealed Stage 3 or 4 Pressure Ulcers or Eschar
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of <u>these</u> unstageable pressure ulcers that were present upon admission/entry or reentry</b>- enter how many were <br>noted at the time of admission/entry or reentry
</ol>		  
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>M0610. Dimensions of Unhealed Stage 3 or 4 Pressure Ulcers or Eschar</b><br>Complete only if M0300C1, M0300D1 or M0300F1 is greater than 0
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
If the resident has one or more unhealed Stage 3 or 4 pressure ulcers or an unstageable pressure ulcer due to slough or eschar, identify the pressure<br>ulcer with the largest surface area (length x width) and record in centimeters:
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="150">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610A_1" value="<?php echo $QM0610A_1; ?>" onkeyup="if(this.value.length==1)document.form26.QM0610A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610A_2" value="<?php echo $QM0610A_2; ?>" onkeyup="if(this.value.length==0)document.form26.QM0610A_1.focus();if(this.value.length==1)document.form26.QM0610A_3.focus();"></td>
<td>.</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610A_3" value="<?php echo $QM0610A_3; ?>" onkeyup="if(this.value.length==0)document.form26.QM0610A_2.focus();"></td>
<td>cm</td>
</table>
</td>
<td width="715">
<ul>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0610A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Pressure ulcer length:</b> Longest length from head to toe		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610B_1" value="<?php echo $QM0610B_1; ?>" onkeyup="if(this.value.length==1)document.form26.QM0610B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610B_2" value="<?php echo $QM0610B_2; ?>" onkeyup="if(this.value.length==0)document.form26.QM0610B_1.focus();if(this.value.length==1)document.form26.QM0610B_3.focus();"></td>
<td>.</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610B_3" value="<?php echo $QM0610B_3; ?>" onkeyup="if(this.value.length==0)document.form26.QM0610B_2.focus();"></td>
<td>cm</td>
</table>
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($M0610B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Pressure ulcer width:</b> Widest width of the same pressure ulcer, side-to-side perpendicular (90-degree angle) to length		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610C_1" value="<?php echo $QM0610C_1; ?>" onkeyup="if(this.value.length==1)document.form26.QM0610C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610C_2" value="<?php echo $QM0610C_2; ?>" onkeyup="if(this.value.length==0)document.form26.QM0610C_1.focus();if(this.value.length==1)document.form26.QM0610C_3.focus();"></td>
<td>.</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0610C_3" value="<?php echo $QM0610C_3; ?>" onkeyup="if(this.value.length==0)document.form26.QM0610C_2.focus();"></td>
<td>cm</td>
</table>
</td>
<td>
<ul>
<li value="3"><?php if (substr($url[3],0,5)!="print"){ if($M0610C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Pressure ulcer depth:</b> Depth of the same pressure ulcer from the visible surface to the deepest area (if depth is unknown, <br>enter a dash in each box)		  
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>M0700. Most Severe Tissue Type for Any Pressure Ulcer</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
</table>
</td>
<td width="794">
<a class="content3">Select the best description of the most severe type of tissue present in any pressure ulcer bed</a>
<ol>
<li><input type="radio" name="QM0700" value="1" <?php if($QM0700=="1") echo "checked";?>><b>Epithelial tissue</b> - new skin growing in superficial ulcer. It can be light pink and shiny, even in persons with darkly pigmented skin
<li><input type="radio" name="QM0700" value="2" <?php if($QM0700=="2") echo "checked";?>><b>Granulation tissue</b> - pink or red tissue with shiny, moist, granular appearance
<li><input type="radio" name="QM0700" value="3" <?php if($QM0700=="3") echo "checked";?>><b>Slough</b> - yellow or white tissue that adheres to the ulcer bed in strings or thick clumps, or is mucinous
<li><input type="radio" name="QM0700" value="4" <?php if($QM0700=="4") echo "checked";?>><b>Eschar</b> - black, brown, or tan tissue that adheres firmly to the wound bed or ulcer edges, may be softer or harder than surrounding <br>skin
<li value="9"><input type="radio" name="QM0700" value="9" <?php if($QM0700=="9") echo "checked";?>><b>None of the Above</b>
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>M0800. Worsening in Pressure Ulcer Status Since Prior Assessment (OBRA or Scheduled PPS) or Last Admission/Entry or Reentry</b><br>Complete only if A0310E = 0
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
Indicate the number of current pressure ulcers that were <b>not present or were at a lesser stage</b> on prior assessment (OBRA or scheduled PPS) or last<br>entry. If no current pressure ulcer at a given stage, enter 0.
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0800A" value="<?php echo $QM0800A; ?>"></td>
</table>
</td>
<td>
<ul>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0800A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Stage 2</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0800B" value="<?php echo $QM0800B; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($M0800B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Stage 3</b>	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0800C" value="<?php echo $QM0800C; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="3"><?php if (substr($url[3],0,5)!="print"){ if($M0800C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Stage 4</b>	  
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform26">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
