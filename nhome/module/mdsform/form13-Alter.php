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
$sql = "SELECT * FROM `mdsform13` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
a.content3 {padding-left:3px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:22px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:30px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form13" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
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
<b>F0300. Should Interview for Daily and Activity Preferences be Conducted?</b>- Attempt to interview all residents able to communicate.<br>If resident is unable to complete, attempt to complete interview with family member or significant other
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content" width="70" valign="top">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($F0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="782">
<ol start="0">
<li><input type="radio" name="QF0300" value="0" <?php if($QF0300=="0") echo "checked";?>><b>No</b>(resident is rarely/never understood and family/significant other not available) &#8594; Skip to and complete F0800, Staff<br>Assessment of Daily and Activity Preferences
<li><input type="radio" name="QF0300" value="1" <?php if($QF0300=="1") echo "checked";?>><b>Yes &#8594;</b> Continue to F0400, Interview for Daily Preferences
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="6" style="margin-bottom:3px">
<tr>
<td class="part" colspan="3">
<b>F0400. Interview for Daily Preferences</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
Show resident the response options and say: <b>"While you are in this facility..."</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="10" valign="top" width="200">
<b style="padding-left:5px">Coding:</b>
<ol style="padding-left:33px">
<li><b>Very important</b>
<li><b>Somewhat important</b>
<li><b>Not very important</b>
<li><b>Not important at all</b>
<li><b>Important, but can't do or no choice</b>
<li value="9"><b>No response or non-responsive</b>
</ol>
</td>
</tr>
<tr>
<td colspan="2" width="600">
<b style="padding-left:30px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content" width="70">
<?php if (substr($url[3],0,5)!="print"){ if($F0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400A" value="1" <?php if($QF0400A=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400A" value="2" <?php if($QF0400A=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400A" value="3" <?php if($QF0400A=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400A" value="4" <?php if($QF0400A=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400A" value="5" <?php if($QF0400A=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400A" value="9" <?php if($QF0400A=="9") echo "checked";?>>9
</td>
<td width="530">
<ul>
<li>how important is it to you to <b>choose what clothes to wear?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400B" value="1" <?php if($QF0400B=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400B" value="2" <?php if($QF0400B=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400B" value="3" <?php if($QF0400B=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400B" value="4" <?php if($QF0400B=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400B" value="5" <?php if($QF0400B=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400B" value="9" <?php if($QF0400B=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="2">how important is it to you to <b>take care of your personal belongings or things?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400C" value="1" <?php if($QF0400C=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400C" value="2" <?php if($QF0400C=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400C" value="3" <?php if($QF0400C=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400C" value="4" <?php if($QF0400C=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400C" value="5" <?php if($QF0400C=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400C" value="9" <?php if($QF0400C=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="3">how important is it to you to <b>choose between a tub bath, shower, bed bath, or sponge bath?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400D" value="1" <?php if($QF0400D=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400D" value="2" <?php if($QF0400D=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400D" value="3" <?php if($QF0400D=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400D" value="4" <?php if($QF0400D=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400D" value="5" <?php if($QF0400D=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400D" value="9" <?php if($QF0400D=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="4">how important is it to you to <b>have snacks available between meals?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400E" value="1" <?php if($QF0400E=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400E" value="2" <?php if($QF0400E=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400E" value="3" <?php if($QF0400E=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400E" value="4" <?php if($QF0400E=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400E" value="5" <?php if($QF0400E=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400E" value="9" <?php if($QF0400E=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="5">how important is it to you to <b>choose your own bedtime?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400F" value="1" <?php if($QF0400F=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400F" value="2" <?php if($QF0400F=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400F" value="3" <?php if($QF0400F=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400F" value="4" <?php if($QF0400F=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400F" value="5" <?php if($QF0400F=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400F" value="9" <?php if($QF0400F=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="6">how important is it to you to <b>have your family or a close friend involved in <br>discussions about your care?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400G" value="1" <?php if($QF0400G=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400G" value="2" <?php if($QF0400G=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400G" value="3" <?php if($QF0400G=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400G" value="4" <?php if($QF0400G=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400G" value="5" <?php if($QF0400G=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400G" value="9" <?php if($QF0400G=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="7">how important is it to you to <b>be able to use the phone in private?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0400H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0400H" value="1" <?php if($QF0400H=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0400H" value="2" <?php if($QF0400H=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0400H" value="3" <?php if($QF0400H=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0400H" value="4" <?php if($QF0400H=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0400H" value="5" <?php if($QF0400H=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0400H" value="9" <?php if($QF0400H=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="8">how important is it to you to <b>have a place to lock your things to keep them safe?</b>
</ul>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="part" colspan="3">
<b>F0500. Interview for Activity Preferences</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
Show resident the response options and say: <b>"While you are in this facility..."</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="10" valign="top">
<b style="padding-left:5px">Coding:</b>
<ol style="padding-left:33px">
<li><b>Very important</b>
<li><b>Somewhat important</b>
<li><b>Not very important</b>
<li><b>Not important at all</b>
<li><b>Important, but can't do or no choice</b>
<li value="9"><b>No response or non-responsive</b>
</ol>
</td>
</tr>
<tr>
<td colspan="2">
<b style="padding-left:30px">&#8595; Enter Codes in Boxes</b>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500A" value="1" <?php if($QF0500A=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500A" value="2" <?php if($QF0500A=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500A" value="3" <?php if($QF0500A=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500A" value="4" <?php if($QF0500A=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500A" value="5" <?php if($QF0500A=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500A" value="9" <?php if($QF0500A=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li>how important is it to you to <b>have books, newspapers, and magazines to read?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500B" value="1" <?php if($QF0500B=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500B" value="2" <?php if($QF0500B=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500B" value="3" <?php if($QF0500B=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500B" value="4" <?php if($QF0500B=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500B" value="5" <?php if($QF0500B=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500B" value="9" <?php if($QF0500B=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="2">how important is it to you to <b>listen to music you like?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500C" value="1" <?php if($QF0500C=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500C" value="2" <?php if($QF0500C=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500C" value="3" <?php if($QF0500C=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500C" value="4" <?php if($QF0500C=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500C" value="5" <?php if($QF0500C=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500C" value="9" <?php if($QF0500C=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="3">how important is it to you to <b>be around animals such as pets?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500D" value="1" <?php if($QF0500D=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500D" value="2" <?php if($QF0500D=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500D" value="3" <?php if($QF0500D=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500D" value="4" <?php if($QF0500D=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500D" value="5" <?php if($QF0500D=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500D" value="9" <?php if($QF0500D=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="4">how important is it to you to <b>keep up with the news?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500E" value="1" <?php if($QF0500E=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500E" value="2" <?php if($QF0500E=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500E" value="3" <?php if($QF0500E=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500E" value="4" <?php if($QF0500E=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500E" value="5" <?php if($QF0500E=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500E" value="9" <?php if($QF0500E=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="5">how important is it to you to <b>do things with groups of people?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500F" value="1" <?php if($QF0500F=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500F" value="2" <?php if($QF0500F=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500F" value="3" <?php if($QF0500F=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500F" value="4" <?php if($QF0500F=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500F" value="5" <?php if($QF0500F=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500F" value="9" <?php if($QF0500F=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="6">how important is it to you to <b>do your favorite activities?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500G" value="1" <?php if($QF0500G=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500G" value="2" <?php if($QF0500G=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500G" value="3" <?php if($QF0500G=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500G" value="4" <?php if($QF0500G=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500G" value="5" <?php if($QF0500G=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500G" value="9" <?php if($QF0500G=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="7">how important is it to you to <b>go outside to get fresh air when the weather is good?</b>
</ul>
</td>
</tr>
<tr>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($F0500H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QF0500H" value="1" <?php if($QF0500H=="1") echo "checked";?>>1<br>
<input type="radio" name="QF0500H" value="2" <?php if($QF0500H=="2") echo "checked";?>>2<br>
<input type="radio" name="QF0500H" value="3" <?php if($QF0500H=="3") echo "checked";?>>3<br>
<input type="radio" name="QF0500H" value="4" <?php if($QF0500H=="4") echo "checked";?>>4<br>
<input type="radio" name="QF0500H" value="5" <?php if($QF0500H=="5") echo "checked";?>>5<br>
<input type="radio" name="QF0500H" value="9" <?php if($QF0500H=="9") echo "checked";?>>9
</td>
<td>
<ul>
<li value="8">how important is it to you to <b>participate in religious services or practices?</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>F0600. Daily and Activity Preferences Primary Respondent</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="70">
Enter Code
<table align="center" cellspacing="0">
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($F0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>
<td width="800">
<a class="content3">Indicate primary respondent</b> for Daily and Activity Preferences (F0400 and F0500)
<ol>
<li><input type="radio" name="QF0600" value="1" <?php if($QF0600=="1") echo "checked";?>><b>Resident</b>
<li><input type="radio" name="QF0600" value="2" <?php if($QF0600=="2") echo "checked";?>><b>Family or significant other</b> (close friend or other representative)
<li value="9"><input type="radio" name="QF0600" value="9" <?php if($QF0600=="9") echo "checked";?>><b>Interview could not be completed</b> by resident or family/significant other ("No response" to 3 or more items")
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform13">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
