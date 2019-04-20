<?php
if($_GET['date']!=NULL){
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

$Qfiller = explode("&",$Qfiller);
for($i=0;$i<count($Qfiller);$i++){
$sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$Qfiller[$i]."'";
$db2 = new DB2;
$db2->query($sql);
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		if((count($Qfiller)-$i)>2){
			$page31_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page31_Qfiller_name .= $v;
		}else{}
	}
}
}
$page31_Qfiller_name = str_replace(';',', ', $page31_Qfiller_name);
?>
<body class="page31-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page31_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section O</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Special Treatments, Procedures, and Programs</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em"> 
<tr>
<td class="page31-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0400. Therapies</b>- Continued</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-bottom-style:hidden; width:9em"></td>
<td class="page31-content" colspan="2" style="width:46.875em">
<ul class="page31-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Physical Therapy</b>
</ul>  
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400C1_1; ?></td>
<td class="answer"><?php echo $QO0400C1_2; ?></td>
<td class="answer"><?php echo $QO0400C1_3; ?></td>
<td class="answer"><?php echo $QO0400C1_4; ?></td>
</tr>
</table>
</div>
</td>	
<td class="page31-partwhite" colspan="2" style="border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Individual minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to <br>the resident <b>individually</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400C2_1; ?></td>
<td class="answer"><?php echo $QO0400C2_2; ?></td>
<td class="answer"><?php echo $QO0400C2_3; ?></td>
<td class="answer"><?php echo $QO0400C2_4; ?></td>
</tr>
</table>
</div>
</td>	
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Concurrent minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to <br>the resident <b>concurrently with one other resident</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400C3_1; ?></td>
<td class="answer"><?php echo $QO0400C3_2; ?></td>
<td class="answer"><?php echo $QO0400C3_3; ?></td>
<td class="answer"><?php echo $QO0400C3_4; ?></td>
</tr>
</table>
</div>
</td>	
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Group minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to the <br>resident as <b>part of a group of residents</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.4em; margin-bottom:1em">
<b style="padding-left:0.3125em">If the sum of individual, concurrent, and group minutes is zero, &#8594;</b> skip to O0400C5, <br><a style="padding-left:0.3125em">Therapy start date</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400C3A_1; ?></td>
<td class="answer"><?php echo $QO0400C3A_2; ?></td>
<td class="answer"><?php echo $QO0400C3A_3; ?></td>
<td class="answer"><?php echo $QO0400C3A_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<a>3A.</a><b style="padding-left:0.5em">Co-treatment minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C3A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered <br><a style="padding-left:2.1em">to the resident in <b>co-treatment sessions</b> in the last 7 days</a>
</td>
</tr>
<!-------------------------------------------->			
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400C4; ?></td>
</tr>
</table>
</div>
</td>
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Days</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C4_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page31-partwhite" style="border-top-style:hidden; border-right-style:hidden; width:23.4375em">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Therapy start date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C5_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the <br>most recent therapy regimen (since the <br>most recent entry) started
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0400C5_1; ?></td>
<td class="answer"><?php echo $QO0400C5_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400C5_3; ?></td>
<td class="answer"><?php echo $QO0400C5_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400C5_5; ?></td>
<td class="answer"><?php echo $QO0400C5_6; ?></td>
<td class="answer"><?php echo $QO0400C5_7; ?></td>
<td class="answer"><?php echo $QO0400C5_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ol>
</td>
<td class="page31-partwhite" style="border-top-style:hidden; border-left-style:hidden; width:23.4375em">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Therapy end date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400C6_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the <br>most recent therapy regimen (since the <br>most recent entry) ended - enter dashes <br>if therapy is ongoing
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0400C6_1; ?></td>
<td class="answer"><?php echo $QO0400C6_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400C6_3; ?></td>
<td class="answer"><?php echo $QO0400C6_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400C6_5; ?></td>
<td class="answer"><?php echo $QO0400C6_6; ?></td>
<td class="answer"><?php echo $QO0400C6_7; ?></td>
<td class="answer"><?php echo $QO0400C6_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page31-content" colspan="2" style="text-align:left">
<ul class="page31-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Respiratory Therapy</b>	  
</ul>
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400D1_1; ?></td>
<td class="answer"><?php echo $QO0400D1_2; ?></td>
<td class="answer"><?php echo $QO0400D1_3; ?></td>
<td class="answer"><?php echo $QO0400D1_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page31-partwhite" colspan="2" style="border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Total minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to the resident <br>in the last 7 days.<br>If zero, &#8594; skip to O0400E, Psychological Therapy
</ol>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400D2; ?></td>
</tr>
</table>
</div>
</td>	 
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Days</b><?php if (substr($url[3],0,5)!="print"){ if($O0400D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page31-content" colspan="2" style="text-align:left">
<ul class="page31-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Psychological Therapy</b> (by any licensed mental health professional)	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400E1_1; ?></td>
<td class="answer"><?php echo $QO0400E1_2; ?></td>
<td class="answer"><?php echo $QO0400E1_3; ?></td>
<td class="answer"><?php echo $QO0400E1_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page31-partwhite" colspan="2" style="border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Total minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to the resident <br>in the last 7 days.<br>If zero, &#8594; skip to O0400F, Recreational Therapy
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400E2; ?></td>
</tr>
</table>
</div>
</td>	 
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Days</b><?php if (substr($url[3],0,5)!="print"){ if($O0400E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page31-content" colspan="2" style="text-align:left">
<ul class="page31-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Recreational Therapy</b> (includes recreational and music therapy)	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400F1_1; ?></td>
<td class="answer"><?php echo $QO0400F1_2; ?></td>
<td class="answer"><?php echo $QO0400F1_3; ?></td>
<td class="answer"><?php echo $QO0400F1_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page31-partwhite" colspan="2" style="border-bottom-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Total minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to the resident <br>in the last 7 days.<br>If zero, &#8594; skip to O0420, Distinct Calendar Days of Therapy
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" style="border-top-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400F2; ?></td>
</tr>
</table>
</div>
</td>	 
<td class="page31-partwhite" colspan="2" style="border-top-style:hidden">
<ol class="page31-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Days</b><?php if (substr($url[3],0,5)!="print"){ if($O0400F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="page31-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0420. Distinct Calendar Days of Therapy</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0420; ?><?php if (substr($url[3],0,5)!="print"){ if($O0420_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>	 
<td class="page31-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:20px">Record the number of calendar days that the resident received Speech-Language </b><br><b style="padding-left:20px">Pathology and Audiology Services, Occupational Therapy, or Physical Therapy for at </b><br><b style="padding-left:20px">least 15 minutes in the past 7 days.</b></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page31-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0450. Resumption of Therapy</b> - Complete only if A0310C = 2 or 3 and A0310F = 99</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page31-content" align="center" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<table cellspacing="0" >
<td class="answer"><?php echo $QO0450A; ?><?php if (substr($url[3],0,5)!="print"){ if($O0450A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>	 
<td class="page31-partwhite" colspan="2" style="width:50em">
<ul class="page31-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Has a previous rehabilitation therapy regimen (speech, occupational, and/or physical therapy) <br>ended, as reported on this End of Therapy OMRA, and has this regimen now resumed at exactly the same level for each discipline?</b>
</ul>
<ol class="page31-ol" start="0" style="padding-left:3.4em">
<li><b>No &#8594 </b>Skip to O0500, Restorative Nursing Programs
<li><b>Yes</b>
</ol>
<ul class="page31-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Date on which therapy regimen resumed:<?php if (substr($url[3],0,5)!="print"){ if($O0450B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></b>
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0450B_1; ?></td>
<td class="answer"><?php echo $QO0450B_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0450B_3; ?></td>
<td class="answer"><?php echo $QO0450B_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0450B_5; ?></td>
<td class="answer"><?php echo $QO0450B_6; ?></td>
<td class="answer"><?php echo $QO0450B_7; ?></td>
<td class="answer"><?php echo $QO0450B_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<a style="font-size:10px; line-height:13px">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</a>
</body>
<?php
  }else{
	$db = new DB;
	$db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
	if($db->num_rows()>0){
		$r = $db->fetch_assoc();
		$r['date'] = str_replace('-','',$r['date']);
		?>
		<script>
        document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $_GET['id']; ?>&date=<?php echo $r['date'];?>";
        </script>
		<?php
	}else{
	  echo '
	  <div>
	    <table>
	      <tr>
	        <td>
		      Not have any record.
		    </td>
		  </tr>
		  <tr>
			<td>
		      Please click the button to preduce MDS.
		    </td>
	      </tr>
	    </table>
	  </div>
	  ';		
	}
  }
?>