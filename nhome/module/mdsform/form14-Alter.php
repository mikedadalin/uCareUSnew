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
$sql = "SELECT * FROM `mdsform14` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:35px; margin:3px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form14" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section F</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Preferences for Customary Routine and Activities</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="10" style="margin-bottom:3px">
<tr>
<td class="part" colspan="2">
<b>F0700. Should the Staff Assessment of Daily and Activity Preferences be Conducted?</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($F0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ol start="0">
<li><input type="radio" name="QF0700" value="0" <?php if($QF0700=="0") echo "checked";?>><b>No</b> (because Interview for Daily and Activity Preferences (F0400 and F0500) was completed by resident or family/significant <br>other) &#8594; Skip to and complete G0110, Activities of Daily Living (ADL) Assistance
<li><input type="radio" name="QF0700" value="1" <?php if($QF0700=="1") echo "checked";?>><b>Yes</b> (because 3 or more items in Interview for Daily and Activity Preferences (F0400 and F0500) were not completed by resident <br>or family/significant other)) &#8594; Continue to F0800, Staff Assessment of Daily and Activity Preferences
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6">
<tr>
<td class="part" colspan="2">
<b>F0800. Staff Assessment of Daily and Activity Preferences</b><?php if (substr($url[3],0,5)!="print"){ if($F0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2">
Do not conduct if Interview for Daily and Activity Preferences (F0400-F0500) was completed
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="2">
<b>Resident Prefers:</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="2" style="padding-left:32px">
<b>&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70">
<input type="checkbox" name="QF0800A" value="X" <?php if($QF0800A=="X") echo "checked";?>>
</td>
<td width="790">
<ul>
<li><b>Choosing clothes to wear</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800B" value="X" <?php if($QF0800B=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="2"><b>Caring for personal belongings</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800C" value="X" <?php if($QF0800C=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="3"><b>Receiving tub bath</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800D" value="X" <?php if($QF0800D=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="4"><b>Receiving shower</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800E" value="X" <?php if($QF0800E=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="5"><b>Receiving bed bath</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800F" value="X" <?php if($QF0800F=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="6"><b>Receiving sponge bath</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800G" value="X" <?php if($QF0800G=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="7"><b>Snacks between meals</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800H" value="X" <?php if($QF0800H=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="8"><b>Staying up past 8:00 p.m.</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800I" value="X" <?php if($QF0800I=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="9"><b>Family or significant other involvement in care discussions</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800J" value="X" <?php if($QF0800J=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="10"><b>Use of phone in private</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800K" value="X" <?php if($QF0800K=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="11"><b>Place to lock personal belongings</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800L" value="X" <?php if($QF0800L=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="12"><b>Reading books, newspapers, or magazines</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800M" value="X" <?php if($QF0800M=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="13"><b>Listening to music</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800N" value="X" <?php if($QF0800N=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="14"><b>Being around animals such as pets</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800O" value="X" <?php if($QF0800O=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="15"><b>Keeping up with the news</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800P" value="X" <?php if($QF0800P=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="16"><b>Doing things with groups of people</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800Q" value="X" <?php if($QF0800Q=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="17"><b>Participating in favorite activities</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800R" value="X" <?php if($QF0800R=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="18"><b>Spending time away from the nursing home</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800S" value="X" <?php if($QF0800S=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="19"><b>Spending time outdoors</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800T" value="X" <?php if($QF0800T=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="20"><b>Participating in religious activities or practices</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<input type="checkbox" name="QF0800Z" value="X" <?php if($QF0800Z=="X") echo "checked";?>>
</td>
<td>
<ul>
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform14">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
