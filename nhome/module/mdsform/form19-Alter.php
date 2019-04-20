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
$sql = "SELECT * FROM `mdsform19` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td {padding-left:5px}
td.section {background-color:rgb(113,113,99); color:white; font-size:14px; padding-left:5px}
td.section2 {background-color:rgb(230,230,226); font-size:14px}
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center; padding-left:0px}
td.answer2 {background-color:rgb(221,228,255); border:1px solid black; width:10px; height:10px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; padding-left:0px; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:0px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
li.answer3 {margin-top:10px; margin-bottom:10px}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form19" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section I</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Active Diagnoses</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>Active Diagnoses in the last 7 days - Check all that apply</b><br>Diagnoses listed in parentheses are provided as examples and should not be considered as all-inclusive lists
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" width="70"></td>
<td class="part" width="800"><b>Neurological - Continued</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI4900" value="X" <?php if($QI4900=="X") echo "checked";?>>
</td>
<td>
<b>I4900. Hemiplegia or Hemiparesis</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5000" value="X" <?php if($QI5000=="X") echo "checked";?>>
</td>
<td>
<b>I5000. Paraplegia</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5100" value="X" <?php if($QI5100=="X") echo "checked";?>>
</td>
<td>
<b>I5100. Quadriplegia</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5200" value="X" <?php if($QI5200=="X") echo "checked";?>>
</td>
<td>
<b>I5200. Multiple Sclerosis (MS)</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5250" value="X" <?php if($QI5250=="X") echo "checked";?>>
</td>
<td>
<b>I5250. Huntington's Disease</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5300" value="X" <?php if($QI5300=="X") echo "checked";?>>
</td>
<td>
<b>I5300. Parkinson's Disease</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5350" value="X" <?php if($QI5350=="X") echo "checked";?>>
</td>
<td>
<b>I5350. Tourette's Syndrome</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5400" value="X" <?php if($QI5400=="X") echo "checked";?>>
</td>
<td>
<b>I5400. Seizure Disorder or Epilepsy</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5500" value="X" <?php if($QI5500=="X") echo "checked";?>>
</td>
<td>
<b>I5500. Traumatic Brain Injury (TBI)</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Nutritional</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5600" value="X" <?php if($QI5600=="X") echo "checked";?>>
</td>
<td>
<b>I5600. Malnutrition</b> (protein or calorie) or at risk for malnutrition
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Psychiatric/Mood Disorder</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5700" value="X" <?php if($QI5700=="X") echo "checked";?>>
</td>
<td>
<b>I5700. Anxiety Disorder</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5800" value="X" <?php if($QI5800=="X") echo "checked";?>>
</td>
<td>
<b>I5800. Depression</b> (other than bipolar)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5900" value="X" <?php if($QI5900=="X") echo "checked";?>>
</td>
<td>
<b>I5900. Manic Depression</b> (bipolar disease)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI5950" value="X" <?php if($QI5950=="X") echo "checked";?>>
</td>
<td>
<b>I5950. Psychotic Disorder</b> (other than schizophrenia)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI6000" value="X" <?php if($QI6000=="X") echo "checked";?>>
</td>
<td>
<b>I6000. Schizophrenia</b> (e.g., schizoaffective and schizophreniform disorders)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI6100" value="X" <?php if($QI6100=="X") echo "checked";?>>
</td>
<td>
<b>I6100. Post Traumatic Stress Disorder (PTSD)</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Pulmonary</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI6200" value="X" <?php if($QI6200=="X") echo "checked";?>>
</td>
<td>
<b>I6200. Asthma, Chronic Obstructive Pulmonary Disease (COPD), or Chronic Lung Disease</b> (e.g., chronic bronchitis and restrictive lung <br><a style="padding-left:38px">diseases such as asbestosis)</a>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI6300" value="X" <?php if($QI6300=="X") echo "checked";?>>
</td>
<td>
<b>I6300. Respiratory Failure</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Vision</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI6500" value="X" <?php if($QI6500=="X") echo "checked";?>>
</td>
<td>
<b>I6500. Cataracts, Glaucoma, or Macular Degeneration</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>None of Above</b></td>
</tr>	 
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QI7900" value="X" <?php if($QI7900=="X") echo "checked";?>>
</td>
<td>
<b>I7900. None of the above active diagnoses</b> within the last 7 days
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part"></td>
<td class="part"><b>Other</b></td>
</tr>	 
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td>
<b>I8000. Additional active diagnoses</b><br>Enter diagnosis on line and ICD code in boxes. Include the decimal for the code in the appropriate box.<br>
<ul>
<li class="answer3"><input type="text" size="50" name="QI8000Atext" value="<?php echo $QI8000Atext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_1" value="<?php echo $QI8000A_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_2" value="<?php echo $QI8000A_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_1.focus();if(this.value.length==1)document.form19.QI8000A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_3" value="<?php echo $QI8000A_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_2.focus();if(this.value.length==1)document.form19.QI8000A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_4" value="<?php echo $QI8000A_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_3.focus();if(this.value.length==1)document.form19.QI8000A_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_5" value="<?php echo $QI8000A_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_4.focus();if(this.value.length==1)document.form19.QI8000A_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_6" value="<?php echo $QI8000A_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_5.focus();if(this.value.length==1)document.form19.QI8000A_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_7" value="<?php echo $QI8000A_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_6.focus();if(this.value.length==1)document.form19.QI8000A_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000A_8" value="<?php echo $QI8000A_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000A_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Btext" value="<?php echo $QI8000Btext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_1" value="<?php echo $QI8000B_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_2" value="<?php echo $QI8000B_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_1.focus();if(this.value.length==1)document.form19.QI8000B_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_3" value="<?php echo $QI8000B_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_2.focus();if(this.value.length==1)document.form19.QI8000B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_4" value="<?php echo $QI8000B_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_3.focus();if(this.value.length==1)document.form19.QI8000B_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_5" value="<?php echo $QI8000B_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_4.focus();if(this.value.length==1)document.form19.QI8000B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_6" value="<?php echo $QI8000B_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_5.focus();if(this.value.length==1)document.form19.QI8000B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_7" value="<?php echo $QI8000B_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_6.focus();if(this.value.length==1)document.form19.QI8000B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000B_8" value="<?php echo $QI8000B_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000B_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Ctext" value="<?php echo $QI8000Ctext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_1" value="<?php echo $QI8000C_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000C_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_2" value="<?php echo $QI8000C_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_1.focus();if(this.value.length==1)document.form19.QI8000C_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_3" value="<?php echo $QI8000C_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_2.focus();if(this.value.length==1)document.form19.QI8000C_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_4" value="<?php echo $QI8000C_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_3.focus();if(this.value.length==1)document.form19.QI8000C_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_5" value="<?php echo $QI8000C_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_4.focus();if(this.value.length==1)document.form19.QI8000C_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_6" value="<?php echo $QI8000C_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_5.focus();if(this.value.length==1)document.form19.QI8000C_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_7" value="<?php echo $QI8000C_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_6.focus();if(this.value.length==1)document.form19.QI8000C_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000C_8" value="<?php echo $QI8000C_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000C_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Dtext" value="<?php echo $QI8000Dtext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_1" value="<?php echo $QI8000D_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000D_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_2" value="<?php echo $QI8000D_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_1.focus();if(this.value.length==1)document.form19.QI8000D_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_3" value="<?php echo $QI8000D_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_2.focus();if(this.value.length==1)document.form19.QI8000D_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_4" value="<?php echo $QI8000D_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_3.focus();if(this.value.length==1)document.form19.QI8000D_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_5" value="<?php echo $QI8000D_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_4.focus();if(this.value.length==1)document.form19.QI8000D_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_6" value="<?php echo $QI8000D_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_5.focus();if(this.value.length==1)document.form19.QI8000D_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_7" value="<?php echo $QI8000D_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_6.focus();if(this.value.length==1)document.form19.QI8000D_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000D_8" value="<?php echo $QI8000D_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000D_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Etext" value="<?php echo $QI8000Etext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_1" value="<?php echo $QI8000E_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000E_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_2" value="<?php echo $QI8000E_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_1.focus();if(this.value.length==1)document.form19.QI8000E_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_3" value="<?php echo $QI8000E_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_2.focus();if(this.value.length==1)document.form19.QI8000E_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_4" value="<?php echo $QI8000E_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_3.focus();if(this.value.length==1)document.form19.QI8000E_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_5" value="<?php echo $QI8000E_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_4.focus();if(this.value.length==1)document.form19.QI8000E_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_6" value="<?php echo $QI8000E_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_5.focus();if(this.value.length==1)document.form19.QI8000E_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_7" value="<?php echo $QI8000E_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_6.focus();if(this.value.length==1)document.form19.QI8000E_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000E_8" value="<?php echo $QI8000E_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000E_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Ftext" value="<?php echo $QI8000Ftext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_1" value="<?php echo $QI8000F_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000F_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_2" value="<?php echo $QI8000F_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_1.focus();if(this.value.length==1)document.form19.QI8000F_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_3" value="<?php echo $QI8000F_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_2.focus();if(this.value.length==1)document.form19.QI8000F_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_4" value="<?php echo $QI8000F_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_3.focus();if(this.value.length==1)document.form19.QI8000F_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_5" value="<?php echo $QI8000F_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_4.focus();if(this.value.length==1)document.form19.QI8000F_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_6" value="<?php echo $QI8000F_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_5.focus();if(this.value.length==1)document.form19.QI8000F_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_7" value="<?php echo $QI8000F_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_6.focus();if(this.value.length==1)document.form19.QI8000F_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000F_8" value="<?php echo $QI8000F_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000F_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Gtext" value="<?php echo $QI8000Gtext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_1" value="<?php echo $QI8000G_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000G_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_2" value="<?php echo $QI8000G_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_1.focus();if(this.value.length==1)document.form19.QI8000G_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_3" value="<?php echo $QI8000G_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_2.focus();if(this.value.length==1)document.form19.QI8000G_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_4" value="<?php echo $QI8000G_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_3.focus();if(this.value.length==1)document.form19.QI8000G_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_5" value="<?php echo $QI8000G_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_4.focus();if(this.value.length==1)document.form19.QI8000G_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_6" value="<?php echo $QI8000G_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_5.focus();if(this.value.length==1)document.form19.QI8000G_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_7" value="<?php echo $QI8000G_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_6.focus();if(this.value.length==1)document.form19.QI8000G_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000G_8" value="<?php echo $QI8000G_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000G_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Htext" value="<?php echo $QI8000Htext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_1" value="<?php echo $QI8000H_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000H_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_2" value="<?php echo $QI8000H_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_1.focus();if(this.value.length==1)document.form19.QI8000H_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_3" value="<?php echo $QI8000H_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_2.focus();if(this.value.length==1)document.form19.QI8000H_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_4" value="<?php echo $QI8000H_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_3.focus();if(this.value.length==1)document.form19.QI8000H_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_5" value="<?php echo $QI8000H_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_4.focus();if(this.value.length==1)document.form19.QI8000H_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_6" value="<?php echo $QI8000H_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_5.focus();if(this.value.length==1)document.form19.QI8000H_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_7" value="<?php echo $QI8000H_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_6.focus();if(this.value.length==1)document.form19.QI8000H_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000H_8" value="<?php echo $QI8000H_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000H_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Itext" value="<?php echo $QI8000Itext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_1" value="<?php echo $QI8000I_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000I_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_2" value="<?php echo $QI8000I_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_1.focus();if(this.value.length==1)document.form19.QI8000I_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_3" value="<?php echo $QI8000I_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_2.focus();if(this.value.length==1)document.form19.QI8000I_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_4" value="<?php echo $QI8000I_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_3.focus();if(this.value.length==1)document.form19.QI8000I_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_5" value="<?php echo $QI8000I_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_4.focus();if(this.value.length==1)document.form19.QI8000I_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_6" value="<?php echo $QI8000I_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_5.focus();if(this.value.length==1)document.form19.QI8000I_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_7" value="<?php echo $QI8000I_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_6.focus();if(this.value.length==1)document.form19.QI8000I_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000I_8" value="<?php echo $QI8000I_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000I_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000I_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<li class="answer3"><input type="text" size="50" name="QI8000Jtext" value="<?php echo $QI8000Jtext; ?>">
<table cellspacing="0" align="right">
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_1" value="<?php echo $QI8000J_1; ?>" onkeyup="if(this.value.length==1)document.form19.QI8000J_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_2" value="<?php echo $QI8000J_2; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_1.focus();if(this.value.length==1)document.form19.QI8000J_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_3" value="<?php echo $QI8000J_3; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_2.focus();if(this.value.length==1)document.form19.QI8000J_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_4" value="<?php echo $QI8000J_4; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_3.focus();if(this.value.length==1)document.form19.QI8000J_5.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_5" value="<?php echo $QI8000J_5; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_4.focus();if(this.value.length==1)document.form19.QI8000J_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_6" value="<?php echo $QI8000J_6; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_5.focus();if(this.value.length==1)document.form19.QI8000J_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_7" value="<?php echo $QI8000J_7; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_6.focus();if(this.value.length==1)document.form19.QI8000J_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QI8000J_8" value="<?php echo $QI8000J_8; ?>" onkeyup="if(this.value.length==0)document.form19.QI8000J_7.focus();"></td>
<td><?php if (substr($url[3],0,5)!="print"){ if($I8000J_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table><hr color="black" align="left" width="50%" size="1">
<ul>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform19">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
<form>
</body>
