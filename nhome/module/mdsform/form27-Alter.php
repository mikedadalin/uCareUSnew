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
$sql = "SELECT * FROM `mdsform27` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.content2 {background-color:rgb(230,230,226); text-align:left; padding-left:5px}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form27" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section M</b></td>
<td class="section2" width="716"><b style="padding-left:5px">Skin Conditions</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>M0900. Healed Pressure Ulcers</b><br>Complete only if A0310E = 0
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($M0900A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="794">
<ul>
<li><b>Were pressure ulcers present on the prior assessment (OBRA or scheduled PPS)?</b>
</ul>
<ol start="0">
<li><input type="radio" name="QM0900A" value="0" <?php if($QM0900A=="0") echo "checked";?>><b>No &#8594; </b>Skip to M1030, Number of Venous and Arterial Ulcers
<li><input type="radio" name="QM0900A" value="1" <?php if($QM0900A=="1") echo "checked";?>><b>Yes &#8594; </b>Continue to M0900B, Stage 2
</ol>		  
</td>
</tr>

<!-------------------------------------------->
<tr> 
<td class="content">
</td>
<td style="padding-left:5px">
Indicate the number of pressure ulcers that were noted on the prior assessment (OBRA or scheduled PPS) that have completely closed <br>(resurfaced with epithelium). If no healed pressure ulcer at a given stage since the prior assessment (OBRA or scheduled PPS), enter 0.
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0900B" value="<?php echo $QM0900B; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="2"><?php if (substr($url[3],0,5)!="print"){ if($M0900B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Stage 2</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0900C" value="<?php echo $QM0900C; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="3"><?php if (substr($url[3],0,5)!="print"){ if($M0900C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Stage 3</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM0900D" value="<?php echo $QM0900D; ?>"></td>
</table>
</td>
<td>
<ul>
<li value="4"><?php if (substr($url[3],0,5)!="print"){ if($M0900D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><b>Stage 4</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>M1030. Number of Venous and Arterial Ulcers</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QM1030" value="<?php echo $QM1030; ?>"></td>
</table>
</td>
<td>
<b style="padding-left:5px">Enter the total number of venous and arterial ulcers present</b>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>M1040. Other Ulcers, Wounds and Skin Problems</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2"><b>&#8595; Check all that apply</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
</td>
<td class="content2">
<b>Foot Problems</b></a>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040A" value="X" <?php if($QM1040A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Infection of the foot</b> (e.g., cellulitis, purulent drainage)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040B" value="X" <?php if($QM1040B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Diabetic foot ulcer(s)</b>		
</ul>			
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="content">
<input type="checkbox" name="QM1040C" value="X" <?php if($QM1040C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Other open lesion(s) on the foot</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
</td>
<td class="content2">
<b>Other Problems</b></a>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040D" value="X" <?php if($QM1040D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Open lesion(s) other than ulcers, rashes, cuts</b> (e.g., cancer lesion)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040E" value="X" <?php if($QM1040E=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="5"><b>Surgical wound(s)</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040F" value="X" <?php if($QM1040F=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="6"><b>Burn(s) (second or third degree)</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040G" value="X" <?php if($QM1040G=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="7"><b>Skin tear(s)</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040H" value="X" <?php if($QM1040H=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="8"><b>Moisture Associated Skin Damage (MASD)</b>	(i.e. incontinence (IAD), perspiration, drainage)  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
</td>
<td class="content2">
<b>None of the Above</b></a>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1040Z" value="X" <?php if($QM1040Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b> were present		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>M1200. Skin and Ulcer Treatments</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2"><b>&#8595; Check all that apply</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200A" value="X" <?php if($QM1200A=="X") echo "checked";?>>
</td>
<td>
<ul>
<li><b>Pressure reducing device for chair</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200B" value="X" <?php if($QM1200B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Pressure reducing device for bed</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200C" value="X" <?php if($QM1200C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Turning/repositioning program</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200D" value="X" <?php if($QM1200D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Nutrition or hydration intervention</b> to manage skin problems		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200E" value="X" <?php if($QM1200E=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="5"><b>Pressure ulcer care</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200F" value="X" <?php if($QM1200F=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="6"><b>Surgical wound care</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200G" value="X" <?php if($QM1200G=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="7"><b>Application of nonsurgical dressings</b> (with or without topical medications) other than to feet		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200H" value="X" <?php if($QM1200H=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="8"><b>Applications of ointments/medications</b> other than to feet		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200I" value="X" <?php if($QM1200I=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="9"><b>Application of dressings to feet</b> (with or without topical medications)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QM1200Z" value="X" <?php if($QM1200Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b> were provided		  
</ul>
</td>
</tr>  
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform27">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
