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
$sql = "SELECT * FROM `mdsform29` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page29_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page29_Qfiller_name .= $v;
		}else{}
	}
}
}
$page29_Qfiller_name = str_replace(';',', ', $page29_Qfiller_name);
?>
<body class="page29-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page29_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page29-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0100. Special Treatments, Procedures, and Programs</b><?php if (substr($url[3],0,5)!="print"){ if($O0100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br><a>Check all of the following treatments, procedures, and programs that were performed during the last <b>14 days</b></a></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page29-partwhite2" colspan="1" rowspan="2" style="width:44.125em">
<ol class="page29-ol">
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>While NOT a Resident</b><br>Performed <b>while NOT a resident</b> of this facility and within the <b>last 14 days.</b> Only check <br>column 1 if resident entered (admission or reentry) IN THE LAST 14 DAYS. If resident last <br>entered 14 or more days ago, leave column 1 blank
</li>
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>While a Resident</b><br>Performed <b>while a resident</b> of this facility and within the <b>last 14 days</b>
</li>
</ol>
</td>
<td class="page29-content" colspan="1" style="width:5.875em">
<b>1. <br>While NOT a <br>Resident</b>
</td>
<td class="page29-content" colspan="1" style="width:5.875em">
<b>2. <br>While a <br>Resident</b>
</td>
</tr>
<tr>
<td class="page29-partwhite" colspan="2" style="width:11.75em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>&#8595; Check all that apply &#8595;</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Cancer Treatments</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Chemotherapy</b>
</ul>
</td>	  
<td class="page29-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100A1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100A2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Radiation</b>	  
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100B1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100B2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Respiratory Treatments</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Oxygen therapy</b>  
</ul>
</td>	  
<td class="page29-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100C1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100C2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Suctioning</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100D1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100D2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Tracheostomy care</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100E1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100E2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Ventilator or respirator</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100F1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100F2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>BiPAP/CPAP</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100G1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100G2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Other</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>IV medications</b>
</ul>
</td>	  
<td class="page29-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100H1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100H2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b>Transfusions</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100I1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100I2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="10"><b>Dialysis</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100J1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100J2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="11"><b>Hospice care</b>
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100K1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100K2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="12"><b>Respite care</b>
</ul>
</td>	  
<td class="page29-section2" style="border-top-style:hidden; border-bottom-style:hidden">
</td>
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100L; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="13"><b>Isolation or quarantine for active infectious disease </b>(does not include standard <br>body/fluid precautions)
</ul>
</td>	  
<td class="page29-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100M1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100M2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>None of the Above</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>	  
</ul>
</td>	  
<td class="page29-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100Z1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page29-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QO0100Z2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page29-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0250. Influenza Vaccine</b> - Refer to current version of RAI manual for current influenza vaccination season and <br><a style="padding-left:3.6em">reporting period</a></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page29-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0250A; ?><?php if (substr($url[3],0,5)!="print"){ if($O0250A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td style="width:50em">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Did the <b>resident receive the influenza vaccine in this facility</b> for this year's influenza vaccination season?
</ul>
<ol class="page29-ol" start="0" style="padding-left:3.4em">
<li><b>No &#8594; </b>Skip to O0250C, If Influenza vaccine not received, state reason
<li><b>Yes &#8594; </b>Continue to O0250B, Date influenza vaccine received
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page29-content" style="border-top-style:hidden; border-bottom-style:hidden">
</td>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Date influenza vaccine received<?php if (substr($url[3],0,5)!="print"){ if($O0250B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> &#8594; </b>Complete date and skip to O0300A, Is the resident's Pneumococcal <br>vaccination up to date?
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0250B_1; ?></td>
<td class="answer"><?php echo $QO0250B_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0250B_3; ?></td>
<td class="answer"><?php echo $QO0250B_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0250B_5; ?></td>
<td class="answer"><?php echo $QO0250B_6; ?></td>
<td class="answer"><?php echo $QO0250B_7; ?></td>
<td class="answer"><?php echo $QO0250B_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page29-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0250C; ?><?php if (substr($url[3],0,5)!="print"){ if($O0250C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>If Influenza vaccine not received, state reason:</b>
</ul>
<ol class="page29-ol" style="margin-top:0.1875em; margin-bottom:0.1875em; padding-left:3.4em">
<li><b>Resident not in facility</b> during this year's influenza vaccination season
<li><b>Received outside of this facility</b>
<li><b>Not eligible</b> - medical contraindication
<li><b>Offered and declined</b>
<li><b>Not offered</b>
<li><b>Inability to obtain influenza vaccine</b> due to a declared shortage
<li value="9"><b>None of the above</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page29-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0300. Pneumococcal Vaccine</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page29-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0300A; ?><?php if (substr($url[3],0,5)!="print"){ if($O0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Is the resident's Pneumococcal vaccination up to date?</b>
</ul>
<ol class="page29-ol" start="0" style="padding-left:3.4em">
<li><b>No &#8594; </b>Continue to O0300B, If Pneumococcal vaccine not received, state reason
<li><b>Yes &#8594; </b>Skip to O0400, Therapies
</ol>		   
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page29-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0300B; ?><?php if (substr($url[3],0,5)!="print"){ if($O0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page29-partwhite2">
<ul class="page29-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>If Pneumococcal vaccine not received, state reason:</b>
</ul>
<ol class="page29-ol" style="margin-top:0.1875em; margin-bottom:0.1875em; padding-left:3.4em">
<li><b>Not eligible</b> - medical contraindication
<li><b>Offered and declined</b>
<li><b>Not offered</b>
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