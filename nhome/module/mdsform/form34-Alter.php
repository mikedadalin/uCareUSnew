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
$sql = "SELECT * FROM `mdsform34` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:5px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form34" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section Q</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Participation in Assessment and Goal Setting</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center"  cellpadding="0" cellspacing="0"  border="1">
<tr>
<td class="part" colspan="2"><b>Q0490. Resident's Preference to Avoid Being Asked Question Q0500B</b><br>Complete only if A0310A = 02, 06, or 99</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0490_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<b style="padding-left:5px">Does the resident's clinical record document a request that this question be asked only on comprehensive assessments?</b>
<ol start="0">
<li><input type="radio" name="QQ0490" value="0" <?php if($QQ0490=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QQ0490" value="1" <?php if($QQ0490=="1") echo "checked";?>><b>Yes &#8594; </b>Skip to Q0600, Referral
<li value="8"><input type="radio" name="QQ0490" value="8" <?php if($QQ0490=="8") echo "checked";?>><b>Information not available</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>Q0500. Return to Community</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Ask the resident</b> (or family or significant other or guardian or legally authorized representative if resident is unable to understand or <br>respond): <b>"Do you want to talk to someone about the possibility of leaving this facility and returning to live and <br>receive services in the community?"</b>
</ul>
<ol start="0">
<li><input type="radio" name="QQ0500B" value="0" <?php if($QQ0500B=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QQ0500B" value="1" <?php if($QQ0500B=="1") echo "checked";?>><b>Yes</b>
<li value="9"><input type="radio" name="QQ0500B" value="9" <?php if($QQ0500B=="9") echo "checked";?>><b>Unknown or uncertain</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>Q0550. Resident's Preference to Avoid Being Asked Question Q0500B Again</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0550A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li><b>Does the resident</b> (or family or significant other or guardian or legally authorized representative if resident is unable to understand or <br>respond) <b>want to be asked about returning to the community on <u>all</u> assessments?</b> (Rather than only on comprehensive <br>assessments.)
</ul>
<ol start="0">
<li><input type="radio" name="QQ0550A" value="0" <?php if($QQ0550A=="0") echo "checked";?>><b>No</b> - then document in resident's clinical record and ask again only on the next comprehensive assessment
<li><input type="radio" name="QQ0550A" value="1" <?php if($QQ0550A=="1") echo "checked";?>><b>Yes</b>
<li value="8"><input type="radio" name="QQ0550A" value="8" <?php if($QQ0550A=="8") echo "checked";?>><b>Information not available</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0550B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<ul>
<li value="2"><b>Indicate information source for Q0550A</b>
</ul>
<ol>
<li><input type="radio" name="QQ0550B" value="1" <?php if($QQ0550B=="1") echo "checked";?>><b>Resident</b>
<li><input type="radio" name="QQ0550B" value="2" <?php if($QQ0550B=="2") echo "checked";?>>If not resident, then <b>family or significant other</b>
<li><input type="radio" name="QQ0550B" value="3" <?php if($QQ0550B=="3") echo "checked";?>>If not resident, family or significant other, then guardian <b>or legally authorized representative</b>
<li value="8"><input type="radio" name="QQ0550B" value="8" <?php if($QQ0550B=="8") echo "checked";?>><b>No information source available</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	 
<tr>
<td class="part" colspan="2"><b>Q0600. Referral</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($Q0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td>
<b style="padding-left:5px">Has a referral been made to the Local Contact Agency?</b> (Document reasons in resident's clinical record)
<ol start="0">
<li><input type="radio" name="QQ0600" value="0" <?php if($QQ0600=="0") echo "checked";?>><b>No</b> - referral not needed
<li><input type="radio" name="QQ0600" value="1" <?php if($QQ0600=="1") echo "checked";?>><b>No</b> - referral is or may be needed (For more information see Appendix C, Care Area Assessment Resources #20) 
<li><input type="radio" name="QQ0600" value="2" <?php if($QQ0600=="2") echo "checked";?>><b>Yes</b> - referral made
</ol>			  
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform34">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
