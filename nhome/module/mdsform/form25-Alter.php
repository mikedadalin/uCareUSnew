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
$sql = "SELECT * FROM `mdsform25` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:32px}
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
<form name="form25" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section M</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Skin Conditions</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:3px">
<tr>
<td class="part" style="text-align:center" width="844">
<b>Report based on highest stage of existing ulcer(s) at its worst; do not "reverse" stage</b>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>M0100. Determination of Pressure Ulcer Risk</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
<b>&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QM0100A" value="X" <?php if($QM0100A=="X") echo "checked";?>>
</td>
<td width="794">
<ul>
<li><b>Resident has a stage 1 or greater, a scar over bony prominence, or a non-removable dressing/device</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM0100B" value="X" <?php if($QM0100B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Formal assessment instrument/tool</b>(e.g., Braden, Norton, or other)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM0100C" value="X" <?php if($QM0100C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Clinical assessment</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM0100Z" value="X" <?php if($QM0100Z=="X") echo "checked";?>>
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
<b>M0150. Risk of Pressure Ulcers</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($M0150_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Is this resident at risk of developing pressure ulcers?</b></a>
<ol start="0">
<li><input type="radio" name="QM0150" value="0" <?php if($QM0150=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QM0150" value="1" <?php if($QM0150=="1") echo "checked";?>><b>Yes</b>
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>M0210. Unhealed Pressure Ulcer(s)</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($M0210_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Does this resident have one or more unhealed pressure ulcer(s) at Stage 1 or higher?</b></a>
<ol start="0">
<li><input type="radio" name="QM0210" value="0" <?php if($QM0210=="0") echo "checked";?>><b>No &#8594; </b>Skip to M0900, Healed Pressure Ulcers
<li><input type="radio" name="QM0210" value="1" <?php if($QM0210=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to M0300, Current Number of Unhealed Pressure Ulcers at Each Stage
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>M0300. Current Number of Unhealed Pressure Ulcers at Each Stage</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300A" value="<?php echo $QM0300A; ?>"></td>
</table>
</td>
<td>
<ul>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of Stage 1 pressure ulcers</b><br><b>Stage 1:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. Darkly pigmented skin may not <br>have a visible blanching; in dark skin tones only it may appear with persistent blue or purple hues			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B1" value="<?php echo $QM0300B1; ?>"></td>
</table>
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B2" value="<?php echo $QM0300B2; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Stage 2:</b> Partial thickness loss of dermis presenting as a shallow open ulcer with a red or pink wound bed, without slough. May also <br>present as an intact or open/ruptured blister
</ul>
<ol>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of Stage 2 pressure ulcers</b>- If 0 &#8594; Skip to M0300C, Stage 3
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of <u>these</u> Stage 2 pressure ulcers that were present upon admission/entry or reentry</b>- enter how many were noted at <br>the time of admission/entry or reentry
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300B3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Date of oldest Stage 2 pressure ulcer</b>- Enter dashes if date is unknown:<br>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_1" value="<?php echo $QM0300B3_1; ?>" onkeyup="if(this.value.length==1)document.form25.QM0300B3_2.focus();">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_2" value="<?php echo $QM0300B3_2; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_1.focus();if(this.value.length==1)document.form25.QM0300B3_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_3" value="<?php echo $QM0300B3_3; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_2.focus();if(this.value.length==1)document.form25.QM0300B3_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_4" value="<?php echo $QM0300B3_4; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_3.focus();if(this.value.length==1)document.form25.QM0300B3_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_5" value="<?php echo $QM0300B3_5; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_4.focus();if(this.value.length==1)document.form25.QM0300B3_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_6" value="<?php echo $QM0300B3_6; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_5.focus();if(this.value.length==1)document.form25.QM0300B3_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_7" value="<?php echo $QM0300B3_7; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_6.focus();if(this.value.length==1)document.form25.QM0300B3_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300B3_8" value="<?php echo $QM0300B3_8; ?>" onkeyup="if(this.value.length==0)document.form25.QM0300B3_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</li>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300C1" value="<?php echo $QM0300C1; ?>"></td>
</table>
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300C2" value="<?php echo $QM0300C2; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="3"><b>Stage 3:</b> Full thickness tissue loss. Subcutaneous fat may be visible but bone, tendon or muscle is not exposed. Slough may be <br>present but does not obscure the depth of tissue loss. May include undermining and tunneling
</ul>
<ol>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of Stage 3 pressure ulcers</b>- If 0 &#8594; Skip to M0300D, Stage 4
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of <u>these</u> Stage 3 pressure ulcers that were present upon admission/entry or reentry</b>- enter how many were noted at <br>the time of admission/entry or reentry
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300D1" value="<?php echo $QM0300D1; ?>"></td>
</table>
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0300D2" value="<?php echo $QM0300D2; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="4"><b>Stage 4:</b> Full thickness tissue loss with exposed bone, tendon or muscle. Slough or eschar may be present on some parts of the <br>wound bed. Often includes undermining and tunneling
</ul>
<ol>
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of Stage 4 pressure ulcers</b>- If 0 &#8594; Skip to M0300E, Unstageable: Non-removable dressing
<li><?php if (substr($url[3],0,5)!="print"){ if($M0300D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Number of <u>these</u> Stage 4 pressure ulcers that were present upon admission/entry or reentry</b> - enter how many were noted at <br>the time of admission/entry or reentry
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>M0300 continued on next page</b>
</td>
</tr>	  
</table>	
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform25">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
