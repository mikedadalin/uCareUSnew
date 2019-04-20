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
$sql = "SELECT * FROM `mdsform24` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
<form name="form24" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section K</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Swallowing/Nutritional Status</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:10px">
<tr>
<td class="part" colspan="4">
<b>K0710. Percent Intake by Artificial Route</b><?php if (substr($url[3],0,5)!="print"){ if($K0710_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - Complete K0710 only if Column 1 and/or Column 2 are checked for K0510A and/or K0510B
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td width="596" colspan="1" rowspan="3">
<ol style="padding-left:20px">
<li>
<b>While NOT a Resident</b><br>Performed <b>while NOT a resident</b> of this facility and within the <b>last 7 days.</b> Only enter a <br>code in column 1 if resident entered (admission or reentry) IN THE LAST 7 DAYS. If <br>resident last entered 7 or more days ago, leave column 1 blank
</li>
<li>
<b>While a Resident</b><br>Performed <b>while a resident</b> of this facility and within the <b>last 7 days</b>
</li>
<li>
<b>During Entire 7 Days</b><br>Performed during the entire <b>last 7 days</b>
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
<td class="content" width="90" valign="bottom" colspan="1">
<b>3. <br>During Entire <br>7 Days</b>
</td>
</tr>
<tr>
<td class="partwhite" width="243" colspan="3">
<b style="padding-left:61px">&#8595; Enter Codes &#8595;</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li><b>Proportion of total calories the resident received through parenteral or tube feeding</b>
</ul>
<ol>
<li><b>25% or less</b>
<li><b>26-50%</b>
<li><b>51% or more</b>
</ol>
</td>	  
<td class="content">
<input type="radio" name="QK0710A1" value="1" <?php if($QK0710A1=="1") echo "checked";?>>1<br>
<input type="radio" name="QK0710A1" value="2" <?php if($QK0710A1=="2") echo "checked";?>>2<br>
<input type="radio" name="QK0710A1" value="3" <?php if($QK0710A1=="3") echo "checked";?>>3<br>
</td>
<td class="content">
<input type="radio" name="QK0710A2" value="1" <?php if($QK0710A2=="1") echo "checked";?>>1<br>
<input type="radio" name="QK0710A2" value="2" <?php if($QK0710A2=="2") echo "checked";?>>2<br>
<input type="radio" name="QK0710A2" value="3" <?php if($QK0710A2=="3") echo "checked";?>>3<br>
</td>
<td class="content">
<input type="radio" name="QK0710A3" value="1" <?php if($QK0710A3=="1") echo "checked";?>>1<br>
<input type="radio" name="QK0710A3" value="2" <?php if($QK0710A3=="2") echo "checked";?>>2<br>
<input type="radio" name="QK0710A3" value="3" <?php if($QK0710A3=="3") echo "checked";?>>3<br>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="2"><b>Average fluid intake per day by IV or tube feeding</b>
</ul>
<ol>
<li><b>500 cc/day or less</b>
<li><b>501 cc/day or more</b>
</ol>
</td>	  
<td class="content">
<input type="radio" name="QK0710B1" value="1" <?php if($QK0710B1=="1") echo "checked";?>>1<br>
<input type="radio" name="QK0710B1" value="2" <?php if($QK0710B1=="2") echo "checked";?>>2<br>
</td>
<td class="content">
<input type="radio" name="QK0710B2" value="1" <?php if($QK0710B2=="1") echo "checked";?>>1<br>
<input type="radio" name="QK0710B2" value="2" <?php if($QK0710B2=="2") echo "checked";?>>2<br>
</td>
<td class="content">
<input type="radio" name="QK0710B3" value="1" <?php if($QK0710B3=="1") echo "checked";?>>1<br>
<input type="radio" name="QK0710B3" value="2" <?php if($QK0710B3=="2") echo "checked";?>>2<br>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center"  cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b>Section L</b></td>
<td class="section2" width="720"><b>Oral/Dental Status</b></font></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2">
<b>L0200. Dental</b>
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
<input type="checkbox" name="QL0200A" value="X" <?php if($QL0200A=="X") echo "checked";?>>
</td>
<td width="800">
<ul>
<li><b>Broken or loosely fitting full or partial denture</b>(chipped, cracked, uncleanable, or loose)		
</ul>
</td>
</tr>
<!-------------------------------------------->  
<tr> 
<td class="content">
<input type="checkbox" name="QL0200B" value="X" <?php if($QL0200B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>No natural teeth or tooth fragment(s)</b>(edentulous)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QL0200C" value="X" <?php if($QL0200C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Abnormal mouth tissue</b>(ulcers, masses, oral lesions, including under denture or partial if one is worn)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QL0200D" value="X" <?php if($QL0200D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Obvious or likely cavity or broken natural teeth</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QL0200E" value="X" <?php if($QL0200E=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="5"><b>Inflamed or bleeding gums or loose natural teeth</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QL0200F" value="X" <?php if($QL0200F=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="6"><b>Mouth or facial pain, discomfort or difficulty with chewing</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QL0200G" value="X" <?php if($QL0200G=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="7"><b>Unable to examine</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
<input type="checkbox" name="QL0200Z" value="X" <?php if($QL0200Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above were present</b>		
</ul>
</td>
</tr>
</table>	
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform24">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
