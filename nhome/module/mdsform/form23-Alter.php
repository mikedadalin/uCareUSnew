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
$sql = "SELECT * FROM `mdsform23` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.content4 {background-color:rgb(230,230,226); font-size:xx-small; padding:3px; text-align:left}
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
<form name="form23" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section K</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Swallowing/Nutritional Status</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>K0100. Swallowing Disorder</b><br> Signs and symptoms of possible swallowing disorder
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
<b style="padding-left:32px">&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
<input type="checkbox" name="QK0100A" value="X" <?php if($QK0100A=="X") echo "checked";?>>
</td>
<td width="800">
<ul>
<li><b>Loss of liquids/solids from mouth when eating or drinking</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QK0100B" value="X" <?php if($QK0100B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Holding food in mouth/cheeks or residual food in mouth after meals</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QK0100C" value="X" <?php if($QK0100C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Coughing or choking during meals or when swallowing medications</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QK0100D" value="X" <?php if($QK0100D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Complaints of difficulty or pain with swallowing</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QK0100Z" value="X" <?php if($QK0100Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b>		
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>K0200. Height and Weight</b>- While measuring, if the number is X.1 - X.4 round down; X.5 or greater round up
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content4" width="110">
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QK0200A_1" value="<?php echo $QK0200A_1; ?>" onkeyup="if(this.value.length==1)document.form23.QK0200A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QK0200A_2" value="<?php echo $QK0200A_2; ?>" onkeyup="if(this.value.length==0)document.form23.QK0200A_1.focus();"></td>
</table>
inches
</td>
<td width="730">
<ul>
<li><b>Height</b><?php if (substr($url[3],0,5)!="print"){ if($K0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (in inches). Record most recent height measure since the most recent admission/entry or reentry
</ul>			 
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content4">
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QK0200B_1" value="<?php echo $QK0200B_1; ?>" onkeyup="if(this.value.length==1)document.form23.QK0200B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QK0200B_2" value="<?php echo $QK0200B_2; ?>" onkeyup="if(this.value.length==0)document.form23.QK0200B_1.focus();if(this.value.length==1)document.form23.QK0200B_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QK0200B_3" value="<?php echo $QK0200B_3; ?>" onkeyup="if(this.value.length==0)document.form23.QK0200B_2.focus();"></td>
</table>
pounds
</td>
<td>
<ul>
<li value="2"><b>Weight</b><?php if (substr($url[3],0,5)!="print"){ if($K0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b><br>';} }?> (in pounds). Base weight on most recent measure in last 30 days; measure weight consistently, according to standard <br>facility practice (e.g., in a.m. after voiding, before meal, with shoes off, etc.)		
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>K0300. Weight Loss</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($K0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<a class="content3"><b>Loss of 5% or more in the last month or loss of 10% or more in last 6 months</b></a>
<ol start="0">
<li><input type="radio" name="QK0300" value="0" <?php if($QK0300=="0") echo "checked";?>><b>No</b> or unknown
<li><input type="radio" name="QK0300" value="1" <?php if($QK0300=="1") echo "checked";?>><b>Yes, on</b> physician-prescribed weight-loss regimen
<li><input type="radio" name="QK0300" value="2" <?php if($QK0300=="2") echo "checked";?>><b>Yes, not on</b> physician-prescribed weight-loss regimen
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>K0310. Weight Gain</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($K0310_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<a class="content3"><b>Gain of 5% or more in the last month or gain of 10% or more in last 6 months</b></a>
<ol start="0">
<li><input type="radio" name="QK0310" value="0" <?php if($QK0310=="0") echo "checked";?>><b>No</b> or unknown
<li><input type="radio" name="QK0310" value="1" <?php if($QK0310=="1") echo "checked";?>><b>Yes, on</b> physician-prescribed weight-gain regimen
<li><input type="radio" name="QK0310" value="2" <?php if($QK0310=="2") echo "checked";?>><b>Yes, not on</b> physician-prescribed weight-gain regimen
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3">
<b>K0510. Nutritional Approaches</b><?php if (substr($url[3],0,5)!="print"){ if($K0510_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>Check all of the following nutritional approaches that were performed during the last <b>7 days</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td width="688" colspan="1" rowspan="3">
<ol style="padding-left:20px">
<li>
<b>While NOT a Resident</b><br>Performed while NOT a resident of this facility and within the last 7 days. Only check column 1 if <br>resident entered (admission or reentry) IN THE LAST 7 DAYS. If resident last entered 7 or more days <br>ago, leave column 1 blank
</li>
<li>
<b>While a Resident</b><br>Performed while a resident of this facility and within the last 7 days
</li>
</td>
</tr>
<tr>
<td class="content" width="90" valign="bottom" colspan="1">
<b>1. <br>While NOT a <br>Resident</b>
</td>
<td class="content" width="90" valign="bottom" colspan="1">
<b>2. <br>While a <br>Resident</b>
</td>
</tr>
<tr>
<td class="partwhite" width="180" valign="bottom" style="text-align:center" colspan="2">
<b>&#8595; Check all that apply &#8595;</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li><b>Parenteral/IV feeding</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QK0510A1" value="X" <?php if($QK0510A1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QK0510A2" value="X" <?php if($QK0510A2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="2"><b>Feeding tube</b>	- nasogastric or abdominal (PEG)
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QK0510B1" value="X" <?php if($QK0510B1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QK0510B2" value="X" <?php if($QK0510B2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="3"><b>Mechanically altered diet</b> - require change in texture of food or liquids (e.g., pureed food, <br>thickened liquids)
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QK0510C1" value="X" <?php if($QK0510C1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QK0510C2" value="X" <?php if($QK0510C2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="4"><b>Therapeutic diet</b> (e.g., low salt, diabetic, low cholesterol)
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QK0510D1" value="X" <?php if($QK0510D1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QK0510D2" value="X" <?php if($QK0510D2=="X") echo "checked";?>>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="26"><b>None of the above</b>
</ul>
</td>	  
<td class="content">
<input type="checkbox" name="QK0510Z1" value="X" <?php if($QK0510Z1=="X") echo "checked";?>>
</td>
<td class="content">
<input type="checkbox" name="QK0510Z2" value="X" <?php if($QK0510Z2=="X") echo "checked";?>>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform23">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
