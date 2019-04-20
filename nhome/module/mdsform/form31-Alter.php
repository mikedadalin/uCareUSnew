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
$sql = "SELECT * FROM `mdsform31` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
td.content {background-color:rgb(230,230,226); font-size:xx-small; padding-left:5px; width:226px}
td.content2 {background-color:rgb(230,230,226); text-align:center;}
a.content3 {padding-left:10px; margin:0px}
ul {list-style:upper-alpha; padding:0px; padding-left:20px; margin:0px}
ol {list-style:decimal; padding:0px; padding-left:40px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form31" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="220"><b style="padding-left:5px">Section O</b></td>
<td class="section2" width="820"><b style="padding-left:5px">Special Treatments, Procedures, and Programs</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1"> 
<tr>
<td class="part" colspan="3"><b>O0400. Therapies</b>- Continued</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td class="content" style="text-align:left" colspan="2">
<ul>
<li value="3"><b>Physical Therapy</b>	  
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C1_1" value="<?php echo $QO0400C1_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400C1_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C1_2" value="<?php echo $QO0400C1_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C1_1.focus();if(this.value.length==1)document.form31.QO0400C1_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C1_3" value="<?php echo $QO0400C1_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C1_2.focus();if(this.value.length==1)document.form31.QO0400C1_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C1_4" value="<?php echo $QO0400C1_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C1_3.focus();"></td>
</table>
</td>	
<td colspan="2">
<ol>
<li><b>Individual minutes</b> - record the total number of minutes this therapy was administered to the resident <b>individually</b> <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C2_1" value="<?php echo $QO0400C2_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400C2_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C2_2" value="<?php echo $QO0400C2_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C2_1.focus();if(this.value.length==1)document.form31.QO0400C2_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C2_3" value="<?php echo $QO0400C2_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C2_2.focus();if(this.value.length==1)document.form31.QO0400C2_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C2_4" value="<?php echo $QO0400C2_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C2_3.focus();"></td>
</table>
</td>	
<td colspan="2">
<ol>
<li value="2"><b>Concurrent minutes</b> - record the total number of minutes this therapy was administered to the resident <br><b>concurrently with one other resident</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400C3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3_1" value="<?php echo $QO0400C3_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400C3_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3_2" value="<?php echo $QO0400C3_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C3_1.focus();if(this.value.length==1)document.form31.QO0400C3_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3_3" value="<?php echo $QO0400C3_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C3_2.focus();if(this.value.length==1)document.form31.QO0400C3_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3_4" value="<?php echo $QO0400C3_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C3_3.focus();"></td>
</table>
</td>	
<td colspan="2">
<ol>
<li value="3"><b>Group minutes</b> - record the total number of minutes this therapy was administered to the resident as <b>part of a group <br>of residents</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td colspan="2">
<a class="content3"><b>If the sum of individual, concurrent, and group minutes is zero, &#8594;</b> skip to O0400C5, Therapy start date</a>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400C3A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3A_1" value="<?php echo $QO0400C3A_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400C3A_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3A_2" value="<?php echo $QO0400C3A_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C3A_1.focus();if(this.value.length==1)document.form31.QO0400C3A_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3A_3" value="<?php echo $QO0400C3A_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C3A_2.focus();if(this.value.length==1)document.form31.QO0400C3A_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C3A_4" value="<?php echo $QO0400C3A_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C3A_3.focus();"></td>
</table>
</td>	  
<td colspan="2">
<a style="padding-left:18px">3A.</a><b style="padding-left:6px">Co-treatment minutes</b> - record the total number of minutes this therapy was administered to the resident in <br><b style="padding-left:40px">co-treatment sessions</b> in the last 7 days
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="content">
Enter Number of Days<?php if (substr($url[3],0,5)!="print"){ if($O0400C4_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C4" value="<?php echo $QO0400CA; ?>"></td>
</table>
</td>
<td colspan="2">
<ol>
<li value="4"><b>Days</b> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td width="365">
<ol>
<li value="5"><b>Therapy start date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C5_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the most recent <br>therapy regimen (since the most recent entry) started
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_1" value="<?php echo $QO0400C5_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400C5_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_2" value="<?php echo $QO0400C5_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_1.focus();if(this.value.length==1)document.form31.QO0400C5_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_3" value="<?php echo $QO0400C5_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_2.focus();if(this.value.length==1)document.form31.QO0400C5_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_4" value="<?php echo $QO0400C5_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_3.focus();if(this.value.length==1)document.form31.QO0400C5_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_5" value="<?php echo $QO0400C5_5; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_4.focus();if(this.value.length==1)document.form31.QO0400C5_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_6" value="<?php echo $QO0400C5_6; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_5.focus();if(this.value.length==1)document.form31.QO0400C5_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_7" value="<?php echo $QO0400C5_7; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_6.focus();if(this.value.length==1)document.form31.QO0400C5_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C5_8" value="<?php echo $QO0400C5_8; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C5_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ol>
</td>
<td width="365">
<ol>
<li value="6"><b>Therapy end date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C6_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the most recent <br>therapy regimen (since the most recent entry) ended <br>- enter dashes if therapy is ongoing
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_1" value="<?php echo $QO0400C6_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400C6_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_2" value="<?php echo $QO0400C6_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_1.focus();if(this.value.length==1)document.form31.QO0400C6_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_3" value="<?php echo $QO0400C6_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_2.focus();if(this.value.length==1)document.form31.QO0400C6_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_4" value="<?php echo $QO0400C6_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_3.focus();if(this.value.length==1)document.form31.QO0400C6_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_5" value="<?php echo $QO0400C6_5; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_4.focus();if(this.value.length==1)document.form31.QO0400C6_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_6" value="<?php echo $QO0400C6_6; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_5.focus();if(this.value.length==1)document.form31.QO0400C6_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_7" value="<?php echo $QO0400C6_7; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_6.focus();if(this.value.length==1)document.form31.QO0400C6_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400C6_8" value="<?php echo $QO0400C6_8; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400C6_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" width="140"></td>
<td class="content" colspan="2" style="text-align:left" width="730">
<ul>
<li value="4"><b>Respiratory Therapy</b>	  
</ul>
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400D1_1" value="<?php echo $QO0400D1_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400D1_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400D1_2" value="<?php echo $QO0400D1_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400D1_1.focus();if(this.value.length==1)document.form31.QO0400D1_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400D1_3" value="<?php echo $QO0400D1_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400D1_2.focus();if(this.value.length==1)document.form31.QO0400D1_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400D1_4" value="<?php echo $QO0400D1_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400D1_3.focus();"></td>
</table>
</td>	  
<td colspan="2">
<ol>
<li><b>Total minutes</b> - record the total number of minutes this therapy was administered to the resident in the last 7 days.<br>If zero, &#8594; skip to O0400E, Psychological Therapy
</ol>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="content">
Enter Number of Days<?php if (substr($url[3],0,5)!="print"){ if($O0400D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400D2" value="<?php echo $QO0400D2; ?>"></td>
</table>
</td>	 
<td colspan="2">
<ol>
<li value="2"><b>Days</b> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td class="content" colspan="2" style="text-align:left">
<ul>
<li value="5"><b>Psychological Therapy</b> (by any licensed mental health professional)	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400E1_1" value="<?php echo $QO0400E1_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400E1_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400E1_2" value="<?php echo $QO0400E1_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400E1_1.focus();if(this.value.length==1)document.form31.QO0400E1_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400E1_3" value="<?php echo $QO0400E1_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400E1_2.focus();if(this.value.length==1)document.form31.QO0400E1_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400E1_4" value="<?php echo $QO0400E1_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400E1_3.focus();"></td>
</table>
</td>	  
<td colspan="2">
<ol>
<li><b>Total minutes</b> - record the total number of minutes this therapy was administered to the resident in the last 7 days<br>If zero, &#8594; skip to O0400F, Recreational Therapy
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Days<?php if (substr($url[3],0,5)!="print"){ if($O0400E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400E2" value="<?php echo $QO0400E2; ?>"></td>
</table>
</td>	 
<td colspan="2">
<ol>
<li value="2"><b>Days</b> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content"></td>
<td class="content" colspan="2" style="text-align:left">
<ul>
<li value="6"><b>Recreational Therapy</b> (includes recreational and music therapy)	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Minutes<?php if (substr($url[3],0,5)!="print"){ if($O0400F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400F1_1" value="<?php echo $QO0400F1_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0400F1_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400F1_2" value="<?php echo $QO0400F1_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400F1_1.focus();if(this.value.length==1)document.form31.QO0400F1_3.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400F1_3" value="<?php echo $QO0400F1_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400F1_2.focus();if(this.value.length==1)document.form31.QO0400F1_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400F1_4" value="<?php echo $QO0400F1_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0400F1_3.focus();"></td>
</table>
</td>	  
<td colspan="2">
<ol>
<li><b>Total minutes</b> - record the total number of minutes this therapy was administered to the resident in the last 7 days<br>If zero, &#8594; skip to O0420, Distinct Calendar Days of Therapy
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Days<?php if (substr($url[3],0,5)!="print"){ if($O0400F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0400F2" value="<?php echo $QO0400F2; ?>"></td>
</table>
</td>	 
<td colspan="2">
<ol>
<li value="2"><b>Days</b> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="part" colspan="3"><b>O0420. Distinct Calendar Days of Therapy</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content">
Enter Number of Days<?php if (substr($url[3],0,5)!="print"){ if($O0420_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0420" value="<?php echo $QO0420; ?>"></td>
</table>
</td>	 
<td colspan="2">
<b style="padding-left:20px">Record the number of calendar days that the resident received Speech-Language Pathology and Audiology Services, </b><br><b style="padding-left:20px">Occupational Therapy, or Physical Therapy for at least 15 minutes in the past 7 days.</b>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="2"><b>O0450. Resumption of Therapy</b> - Complete only if A0310C = 2 or 3 and A0310F = 99</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="content" align="center" valign="top" width="128" style="width:130px">
Enter Code
<table cellspacing="0" >
<td class="answer"><?php if (substr($url[3],0,5)!="print"){ if($O0450A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
</td>	 
<td colspan="2" width="858">
<ul>
<li><b>Has a previous rehabilitation therapy regimen (speech, occupational, and/or physical therapy) ended, as reported on this End of <br>Therapy OMRA, and has this regimen now resumed at exactly the same level for each discipline?</b>
</ul>
<ol start="0" style="padding-left:35px">
<li><input type="radio" name="QO0450A" value="0" <?php if($QO0450A=="0") echo "checked";?>><b>No &#8594 </b>Skip to O0500, Restorative Nursing Programs
<li><input type="radio" name="QO0450A" value="1" <?php if($QO0450A=="1") echo "checked";?>><b>Yes</b>
</ol>
<ul>
<li value="2"><b>Date on which therapy regimen resumed:</b><?php if (substr($url[3],0,5)!="print"){ if($O0450B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0"><br>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_1" value="<?php echo $QO0450B_1; ?>" onkeyup="if(this.value.length==1)document.form31.QO0450B_2.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_2" value="<?php echo $QO0450B_2; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_1.focus();if(this.value.length==1)document.form31.QO0450B_3.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_3" value="<?php echo $QO0450B_3; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_2.focus();if(this.value.length==1)document.form31.QO0450B_4.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_4" value="<?php echo $QO0450B_4; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_3.focus();if(this.value.length==1)document.form31.QO0450B_5.focus();"></td>
<td>-</td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_5" value="<?php echo $QO0450B_5; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_4.focus();if(this.value.length==1)document.form31.QO0450B_6.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_6" value="<?php echo $QO0450B_6; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_5.focus();if(this.value.length==1)document.form31.QO0450B_7.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_7" value="<?php echo $QO0450B_7; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_6.focus();if(this.value.length==1)document.form31.QO0450B_8.focus();"></td>
<td class="answer"><input type="text" size="1" maxlength="1" name="QO0450B_8" value="<?php echo $QO0450B_8; ?>" onkeyup="if(this.value.length==0)document.form31.QO0450B_7.focus();"></td>
</table>
<a style="padding-left:23px">Month</a><a style="padding-left:68px">Day</a><a style="padding-left:114px">Year</a>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform31">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
