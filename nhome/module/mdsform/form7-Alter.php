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
$sql = "SELECT * FROM `mdsform07` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.content2 {background-color:rgb(230,230,226); text-align:left; width:70px}
ul {list-style:upper-alpha; padding:0px; padding-left:19px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:30px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>
<body>
<form name="form7" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section C</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Cognitive Patterns</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>C0100. Should Brief Interview for Mental Status (C0200-C0500) be Conducted?</b>
<br>Attempt to conduct interview with all residents
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ol start="0" style="padding-left:40px">
<li><input type="radio" name="QC0100" value="0" <?php if($QC0100=="0") echo "checked";?>><b>No</b> (resident is rarely/never understood) &#8594; Skip to and complete C0700-C1000, Staff Assessment for Mental Status
<li><input type="radio" name="QC0100" value="1" <?php if($QC0100=="1") echo "checked";?>><b>Yes &#8594;</b> Continue to C0200, Repetition of Three Words
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6">
<tr>
<td class="part" colspan="2"><b>Brief Interview for Mental Status (BIMS)</b></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>C0200. Repetition of Three Words</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"></td>
</table>
</td>
<td width="766" style="padding-left:5px">
Ask resident: &#8243;I am going to say three words for you to remember. Please repeat the words after I have said all three.<br>
The words are:<b> sock, blue, and bed.</b> Now tell me the three words.&#8243;<br>
<b>Number of words repeated after first attempt</b>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0200" value="0" <?php if($QC0200=="0") echo "checked";?>><b>None</b>
<li><input type="radio" name="QC0200" value="1" <?php if($QC0200=="1") echo "checked";?>><b>One</b>
<li><input type="radio" name="QC0200" value="2" <?php if($QC0200=="2") echo "checked";?>><b>Two</b>
<li><input type="radio" name="QC0200" value="3" <?php if($QC0200=="3") echo "checked";?>><b>Three</b>
</ol>
After the resident's first attempt, repeat the words using cues ("sock, something to wear; blue, a color; bed, a piece<br> of furniture"). You may repeat the words up to two more times.
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2"><b>C0300. Temporal Orientation</b> (orientation to year, month, and day)</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
Ask resident: "Please tell me what year it is right now."<br>
<ul>
<li><b>Able to report correct year</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0300A" value="0" <?php if($QC0300A=="0") echo "checked";?>><b>Missed by > 5 years</b> or no answer
<li><input type="radio" name="QC0300A" value="1" <?php if($QC0300A=="1") echo "checked";?>><b>Missed by 2-5 years</b>
<li><input type="radio" name="QC0300A" value="2" <?php if($QC0300A=="2") echo "checked";?>><b>Missed by 1 year</b>
<li><input type="radio" name="QC0300A" value="3" <?php if($QC0300A=="3") echo "checked";?>><b>Correct</b>
</ol>
</td>
</tr>
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
Ask resident: "What month are we in right now?"<br>
<ul>
<li value="2"><b>Able to report correct month</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0300B" value="0" <?php if($QC0300B=="0") echo "checked";?>><b>Missed by > 1 month</b> or no answer
<li><input type="radio" name="QC0300B" value="1" <?php if($QC0300B=="1") echo "checked";?>><b>Missed by 6 days to 1 month</b>
<li><input type="radio" name="QC0300B" value="2" <?php if($QC0300B=="2") echo "checked";?>><b>Accurate within 5 days</b>
</ol>
</td>
</tr>
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
Ask resident: "What day of the week is today?"<br>
<ul>
<li value="3"><b>Able to report correct day of the week</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0300C" value="0" <?php if($QC0300C=="0") echo "checked";?>><b>Incorrect</b> or no answer
<li><input type="radio" name="QC0300C" value="1" <?php if($QC0300C=="1") echo "checked";?>><b>Correct</b>
</ol>
</td>		
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>C0400. Recall</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
Ask resident: "Let's go back to an earlier question. What were those three words that I asked you to repeat?"<br>
If unable to remember a word, give cue (something to wear; a color; a piece of furniture) for that word.<br>
<ul>
<li><b>Able to recall "sock"</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0400A" value="0" <?php if($QC0400A=="0") echo "checked";?>><b>No</b> - could not recall
<li><input type="radio" name="QC0400A" value="1" <?php if($QC0400A=="1") echo "checked";?>><b>Yes, after cueing</b> ("something to wear")
<li><input type="radio" name="QC0400A" value="2" <?php if($QC0400A=="2") echo "checked";?>><b>Yes, no cue required</b>
</ol>
</td>
</tr>
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<ul>
<li value="2"><b>Able to recall "blue"</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0400B" value="0" <?php if($QC0400B=="0") echo "checked";?>><b>No</b> - could not recall
<li><input type="radio" name="QC0400B" value="1" <?php if($QC0400B=="1") echo "checked";?>><b>Yes, after cueing</b> ("a color")
<li><input type="radio" name="QC0400B" value="2" <?php if($QC0400B=="2") echo "checked";?>><b>Yes, no cue required</b>
</ol>
</td>
</tr>
<tr>
<td class="content" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($C0400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td style="padding-left:5px">
<ul>
<li value="3"><b>Able to recall "bed"</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QC0400C" value="0" <?php if($QC0400C=="0") echo "checked";?>><b>No</b> - could not recall
<li><input type="radio" name="QC0400C" value="1" <?php if($QC0400C=="1") echo "checked";?>><b>Yes, after cueing</b> ("a piece of furniture")
<li><input type="radio" name="QC0400C" value="2" <?php if($QC0400C=="2") echo "checked";?>><b>Yes, no cue required</b>
</ol>
</td>		
</tr>
<!-------------------------------------------->  
<tr>
<td class="part" colspan="2">
<b>C0500. Summary Score</b><?php if (substr($url[3],0,5)!="print"){ if($C0500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<tr>
<td class="content" valign="top">
<p align="center" style="margin:0px">Enter Score</p>
<table align="center" cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QC0500_1" value="<?php echo $QC0500_1; ?>" onkeyup="if(this.value.length==1)document.form7.QC0500_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QC0500_2" value="<?php echo $QC0500_2; ?>" onkeyup="if(this.value.length==0)document.form7.QC0500_1.focus();"></td>
</table>
</td>
<td style="padding-left:5px">
<b>Add scores</b> for questions C0200-C0400 and fill in total score (00-15)<br>
<b>Enter 99 if the resident was unable to complete the interview</b>
</td>
</tr>
<!-------------------------------------------->	  
</table>
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform07">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>