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
$sql = "SELECT * FROM `mdsform06` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
ul {list-style:upper-alpha; padding:0px; padding-left:19px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:30px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form6" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:5px">
<tr>
<td width="854" style="background-color:rgb(230,230,226); text-align:center"><b>Look back period for all items is 7 days unless another time frame is indicated</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section B</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Hearing, Speech, and Vision</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>B0100. Comatose</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
</table>
</td>
<td width="794" style="padding-left:5px">
<b>Persistent vegetative state/no discernible consciousness</b>
<ol start="0">
<li><input type="radio" name="QB0100" value="0" <?php if($QB0100=="0") echo "checked";?>><b>No &#8594;</b>Continue to B0200, Hearing
<li><input type="radio" name="QB0100" value="1" <?php if($QB0100=="1") echo "checked";?>><b>Yes &#8594;</b>Skip to G0110, Activities of Daily Living (ADL) Assistance
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>B0200. Hearing</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B0200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Ability to hear</b> (with hearing aid or hearing appliances if normally used)
<ol start="0">
<li><input type="radio" name="QB0200" value="0" <?php if($QB0200=="0") echo "checked";?>><b>Adequate</b>- no difficulty in normal conversation, social interaction, listening to TV
<li><input type="radio" name="QB0200" value="1" <?php if($QB0200=="1") echo "checked";?>><b>Minimal difficulty</b>- difficulty in some environments (e.g., when person speaks softly or setting is noisy
<li><input type="radio" name="QB0200" value="2" <?php if($QB0200=="2") echo "checked";?>><b>Moderate difficulty</b>- speaker has to increase volume and speak distinctly
<li><input type="radio" name="QB0200" value="3" <?php if($QB0200=="3") echo "checked";?>><b>Highly impaired</b>- absence of useful hearing
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>B0300. Hearing Aid</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Hearing aid or other hearing appliance used</b> in completing B0200, Hearing
<ol start="0">
<li><input type="radio" name="QB0300" value="0" <?php if($QB0300=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QB0300" value="1" <?php if($QB0300=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>B0600. Speech Clarity</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">  
<b>Select best description of speech pattern</b>
<ol start="0">
<li><input type="radio" name="QB0600" value="0" <?php if($QB0600=="0") echo "checked";?>><b>Clear speech</b>- distinct intelligible words
<li><input type="radio" name="QB0600" value="1" <?php if($QB0600=="1") echo "checked";?>><b>Unclear speech</b>- slurred or mumbled words
<li><input type="radio" name="QB0600" value="2" <?php if($QB0600=="2") echo "checked";?>><b>No speech</b>- absence of spoken words
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>B0700. Makes Self Understood</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">  
<b>Ability to express ideas and wants,</b>consider both verbal and non-verbal expression
<ol start="0">
<li><input type="radio" name="QB0700" value="0" <?php if($QB0700=="0") echo "checked";?>><b>Understood</b>
<li><input type="radio" name="QB0700" value="1" <?php if($QB0700=="1") echo "checked";?>><b>Usually understood</b>- difficulty communicating some words or finishing thoughts but is able if prompted or given time
<li><input type="radio" name="QB0700" value="2" <?php if($QB0700=="2") echo "checked";?>><b>Sometimes understood</b>- ability is limited to making concrete requests
<li><input type="radio" name="QB0700" value="3" <?php if($QB0700=="3") echo "checked";?>><b>Rarely/never understood</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>B0800. Ability To Understand Others</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">  
<b>Understanding verbal content, however able</b> (with hearing aid or device if used)
<ol start="0">
<li><input type="radio" name="QB0800" value="0" <?php if($QB0800=="0") echo "checked";?>><b>Understands</b>- clear comprehension
<li><input type="radio" name="QB0800" value="1" <?php if($QB0800=="1") echo "checked";?>><b>Usually understands</b>- misses some part/intent of message but comprehends most conversation
<li><input type="radio" name="QB0800" value="2" <?php if($QB0800=="2") echo "checked";?>><b>Sometimes understands</b>- responds adequately to simple, direct communication only
<li><input type="radio" name="QB0800" value="3" <?php if($QB0800=="3") echo "checked";?>><b>Rarely/never understands</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>B1000. Vision</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B1000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Ability to see in adequate light</b> (with glasses or other visual appliances)
<ol start="0">
<li><input type="radio" name="QB1000" value="0" <?php if($QB1000=="0") echo "checked";?>><b>Adequate</b> - sees fine detail, including regular print in newspapers/books
<li><input type="radio" name="QB1000" value="1" <?php if($QB1000=="1") echo "checked";?>><b>Impaired</b> - sees large print, but not regular print in newspapers/books
<li><input type="radio" name="QB1000" value="2" <?php if($QB1000=="2") echo "checked";?>><b>Moderately impaired</b> - limited vision; not able to see newspaper headlines but can identify objects
<li><input type="radio" name="QB1000" value="3" <?php if($QB1000=="3") echo "checked";?>><b>Highly impaired</b> - object identification in question, but eyes appear to follow objects
<li><input type="radio" name="QB1000" value="4" <?php if($QB1000=="4") echo "checked";?>><b>Severely impaired</b> - no vision or sees only light, colors or shapes; eyes do not appear to follow objects
</ol>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="part" colspan="2">
<b>B1200. Corrective Lenses.</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($B1200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<b>Corrective lenses (contacts, glasses, or magnifying glass) used</b> in completing B1000, Vision
<ol start="0">
<li><input type="radio" name="QB1200" value="0" <?php if($QB1200=="0") echo "checked";?>><b>No</b>
<li><input type="radio" name="QB1200" value="1" <?php if($QB1200=="1") echo "checked";?>><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->	  
</table>
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform06">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>