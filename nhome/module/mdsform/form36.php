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
$sql = "SELECT * FROM `mdsform36` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page36_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page36_Qfiller_name .= $v;
		}else{}
	}
}
}
$page36_Qfiller_name = str_replace(';',', ', $page36_Qfiller_name);
?>
<body class="page36-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page36_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section V</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Care Area Assessment (CAA) Summary</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page36-part" colspan="4"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>V0200. CAAs and Care Planning</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page36-partwhite" colspan="4">
<ol class="page36-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Check column A if Care Area is triggered.
<li>For each triggered Care Area, indicate whether a new care plan, care plan revision, or continuation of current care <br>plan is necessary to address the problem(s) identified in your assessment of the care area. The <u>Care Planning <br>Decision</u> column must be completed within 7 days of completing the RAI (MDS and CAA(s)). Check column B if the <br>triggered care area is addressed in the care plan.
<li>Indicate in the <u>Location and Date of CAA Documentation</u> column where information related to the CAA can be found. <br>CAA documentation should include information on the complicating factors, risks, and any referrals for this resident <br>for this care area.
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page36-part" colspan="4" style="padding-left:10px"><ul class="page36-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li><b>CAA Results</b></ul></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite" colspan="1" align="center" rowspan="2" style="width:22.0625em">
<table>
<tr><td>&nbsp </td></tr>
<tr><td>&nbsp </td></tr>
<tr><td>&nbsp </td></tr>
<tr>
<td>
<b style="padding-left:8.6em">Care Area</b>			  
</td>
</tr>
</table>
</td>	  
<td class="page36-content" align="center" colspan="1" style="width:5.875em">
<p align="center"><b>A. <br>Care Area <br>Triggered</b></p>
</td>
<td class="page36-content" align="center" colspan="1" style="width:5.875em">
<p align="center"><b>B. <br>Care Planning <br>Decision</b></p>
</td>
<td class="page36-partwhite" colspan="1" align="center" rowspan="2" style="width:22.0625em">
<table>
<tr><td>&nbsp </td></tr>
<tr><td>&nbsp </td></tr>
<tr><td>&nbsp </td></tr>
<tr>
<td>
<b style="padding-left:6em">Location and Date of </b><br><b style="padding-left:6em">CAA documentation</b>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="page36-partwhite" colspan="2" align="center">
<b>&#8595; Check all that apply &#8595;</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Delirium</b>
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A01A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A01B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A01; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Cognitive Loss/Dementia</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A02A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A02B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A02; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Visual Function</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A03A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A03B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A03; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Communication</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A04A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A04B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">	
<a style="padding-left:0.3125em"><?php echo $QV0200A04; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>ADL Functional/Rehabilitation Potential</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A05A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A05B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A05; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Urinary Incontinence and Indwelling <br>Catheter</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A06A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A06B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A06; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Psychosocial Well-Being</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A07A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A07B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A07; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Mood State</b>			 
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A08A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A08B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A08; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b>Behavioral Symptoms</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A09A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A09B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A09; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="10"><b>Activities</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A10A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A10B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A10; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="11"><b>Falls</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A11A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A11B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A11; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="12"><b>Nutritional Status</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A12A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A12B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A12; ?></a>	
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="13"><b>Feeding Tube</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A13A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A13B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A13; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="14"><b>Dehydration/Fluid Maintenance</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A14A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A14B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A14; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="15"><b>Dental Care</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A15A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A15B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A15; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="16"><b>Pressure Ulcer</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A16A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A16B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A16; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="17"><b>Psychotropic Drug Use</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A17A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A17B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A17; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="18"><b>Physical Restraints</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A18A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A18B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">		 
<a style="padding-left:0.3125em"><?php echo $QV0200A18; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="19"><b>Pain</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A19A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A19B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">	
<a style="padding-left:0.3125em"><?php echo $QV0200A19; ?></a>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page36-partwhite">
<ol class="page36-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="20"><b>Return to Community Referral</b>			  
</ol>
</td>	
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A20A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QV0200A20B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page36-partwhite">
<a style="padding-left:0.3125em"><?php echo $QV0200A20; ?></a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page36-part" colspan="4" style="padding-left:10px"><ul class="page36-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="2"><b>Signature of RN Coordinator for CAA Process and Date Signed</b></ul></td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="3" style="border-right-style:hidden">
<ol class="page36-ol" style="padding-left:30px"><li><b>Signature</b></ol>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a style="font-size:25px"><?php echo $QV0200Btext; ?></a>
</td>
<td colspan="1" style="border-left-style:hidden">
<ol class="page36-ol" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="2"><b>Date</b>
<div style="padding-left:0.6em" style="margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QV0200B_1; ?></td>
<td class="answer"><?php echo $QV0200B_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QV0200B_3; ?></td>
<td class="answer"><?php echo $QV0200B_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QV0200B_5; ?></td>
<td class="answer"><?php echo $QV0200B_6; ?></td>
<td class="answer"><?php echo $QV0200B_7; ?></td>
<td class="answer"><?php echo $QV0200B_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page36-part" colspan="4" style="padding-left:10px"><ul class="page36-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="3"><b>Signature of Person Completing Care Plan and Date Signed</b></ul></td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="3" style="border-right-style:hidden">
<ol class="page36-ol" style="padding-left:30px"><li><b>Signature</b></ol>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a style="font-size:25px"><?php echo $QV0200Ctext; ?></a>
</td>
<td colspan="1" style="border-left-style:hidden">
<ol class="page36-ol" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="2"><b>Date</b>
<div style="padding-left:0.6em" style="margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QV0200C_1; ?></td>
<td class="answer"><?php echo $QV0200C_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QV0200C_3; ?></td>
<td class="answer"><?php echo $QV0200C_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QV0200C_5; ?></td>
<td class="answer"><?php echo $QV0200C_6; ?></td>
<td class="answer"><?php echo $QV0200C_7; ?></td>
<td class="answer"><?php echo $QV0200C_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</ol>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<p style="font-size:1em">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
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