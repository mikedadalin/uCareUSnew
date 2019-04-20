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
$sql = "SELECT * FROM `mdsform37` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== ¸Ñ START ==*/
	$LWJArray = array('QX0200A_1','QX0200A_2','QX0200A_3','QX0200A_4','QX0200A_5','QX0200A_6','QX0200A_7','QX0200A_8','QX0200A_9','QX0200A_10','QX0200A_11','QX0200A_12','QX0200C_1','QX0200C_2','QX0200C_3','QX0200C_4','QX0200C_5','QX0200C_6','QX0200C_7','QX0200C_8','QX0200C_9','QX0200C_10','QX0200C_11','QX0200C_12','QX0200C_13','QX0200C_14','QX0200C_15','QX0200C_16','QX0200C_17','QX0200C_18','QX0500_1','QX0500_2','QX0500_3','QX0500_4','QX0500_5','QX0500_6','QX0500_7','QX0500_8','QX0500_9');
	$LWJdataArray = array($QX0200A_1,$QX0200A_2,$QX0200A_3,$QX0200A_4,$QX0200A_5,$QX0200A_6,$QX0200A_7,$QX0200A_8,$QX0200A_9,$QX0200A_10,$QX0200A_11,$QX0200A_12,$QX0200C_1,$QX0200C_2,$QX0200C_3,$QX0200C_4,$QX0200C_5,$QX0200C_6,$QX0200C_7,$QX0200C_8,$QX0200C_9,$QX0200C_10,$QX0200C_11,$QX0200C_12,$QX0200C_13,$QX0200C_14,$QX0200C_15,$QX0200C_16,$QX0200C_17,$QX0200C_18,$QX0500_1,$QX0500_2,$QX0500_3,$QX0500_4,$QX0500_5,$QX0500_6,$QX0500_7,$QX0500_8,$QX0500_9);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                ${$LWJArray[$i]} = ${$LWJArray[$i]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$i]} = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== ¸Ñ END ==*/
$Qfiller = explode("&",$Qfiller);
for($i=0;$i<count($Qfiller);$i++){
$sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$Qfiller[$i]."'";
$db2 = new DB2;
$db2->query($sql);
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		if((count($Qfiller)-$i)>2){
			$page37_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page37_Qfiller_name .= $v;
		}else{}
	}
}
}
$page37_Qfiller_name = str_replace(';',', ', $page37_Qfiller_name);
?>
<body class="page37-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page37_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section X</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Correction Request</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Complete Section X only if A0050 = 2 or 3</b><br><b>Identification of Record to be Modified/Inactivated</b> - The following items identify the existing assessment record that is <br><a>in error. In this section, reproduce the information EXACTLY as it appeared on the existing erroneous record, even if the </a><br><a>information is incorrect.This information is necessary to locate the existing record in the National MDS Database.</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0150. Type of Provider</b> (A0200 on existing record to be modified/inactivated)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QX0150; ?><?php if (substr($url[3],0,5)!="print"){ if($X0150_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page37-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Type of provider</b>
<ol class="page37-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Nursing home (SNF/NF)</b>
<li><b>Swing Bed</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0200. Name of Resident</b> (A0500 on existing record to be modified/inactivated)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content"></td>
<td class="page37-partwhite">
<ul class="page37-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>First name:</b><?php if (substr($url[3],0,5)!="print"){ if($X0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QX0200A_1; ?></td>
<td class="answer"><?php echo $QX0200A_2; ?></td>
<td class="answer"><?php echo $QX0200A_3; ?></td>
<td class="answer"><?php echo $QX0200A_4; ?></td>
<td class="answer"><?php echo $QX0200A_5; ?></td>
<td class="answer"><?php echo $QX0200A_6; ?></td>
<td class="answer"><?php echo $QX0200A_7; ?></td>
<td class="answer"><?php echo $QX0200A_8; ?></td>
<td class="answer"><?php echo $QX0200A_9; ?></td>
<td class="answer"><?php echo $QX0200A_10; ?></td>
<td class="answer"><?php echo $QX0200A_11; ?></td>
<td class="answer"><?php echo $QX0200A_12; ?></td>
</tr>
</table>
</div>
</ul>
<ul class="page37-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Last name:</b><?php if (substr($url[3],0,5)!="print"){ if($X0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QX0200C_1; ?></td>
<td class="answer"><?php echo $QX0200C_2; ?></td>
<td class="answer"><?php echo $QX0200C_3; ?></td>
<td class="answer"><?php echo $QX0200C_4; ?></td>
<td class="answer"><?php echo $QX0200C_5; ?></td>
<td class="answer"><?php echo $QX0200C_6; ?></td>
<td class="answer"><?php echo $QX0200C_7; ?></td>
<td class="answer"><?php echo $QX0200C_8; ?></td>
<td class="answer"><?php echo $QX0200C_9; ?></td>
<td class="answer"><?php echo $QX0200C_10; ?></td>
<td class="answer"><?php echo $QX0200C_11; ?></td>
<td class="answer"><?php echo $QX0200C_12; ?></td>
<td class="answer"><?php echo $QX0200C_13; ?></td>
<td class="answer"><?php echo $QX0200C_14; ?></td>
<td class="answer"><?php echo $QX0200C_15; ?></td>
<td class="answer"><?php echo $QX0200C_16; ?></td>
<td class="answer"><?php echo $QX0200C_17; ?></td>
<td class="answer"><?php echo $QX0200C_18; ?></td>
</tr>
</table>
</div>	
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0300. Gender </b>(A0800 on existing record to be modified/inactivated)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QX0300; ?><?php if (substr($url[3],0,5)!="print"){ if($X0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page37-partwhite">
<ol class="page37-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Male</b>	
<li><b>Female</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0400. Birth Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (A0900 on existing record to be modified/inactivated)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content"></td>
<td class="page37-partwhite">
<div style="padding-left:2em; margin-top:0.5em; margin-bottom:0.2em">
<table cellspacing="0" style="margin:0.1875em">
<tr>
<td class="answer"><?php echo $QX0400_1; ?></td>
<td class="answer"><?php echo $QX0400_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0400_3; ?></td>
<td class="answer"><?php echo $QX0400_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0400_5; ?></td>
<td class="answer"><?php echo $QX0400_6; ?></td>
<td class="answer"><?php echo $QX0400_7; ?></td>
<td class="answer"><?php echo $QX0400_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:1.6em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0500. Social Security Number</b><?php if (substr($url[3],0,5)!="print"){ if($X0500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (A0600A on existing record to be modified/inactivated)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content"></td>
<td class="page37-partwhite">
<div style="padding-left:2em; margin-top:0.5em; margin-bottom:0.5em">
<table cellspacing="0" style="margin:3px">
<tr>
<td class="answer"><?php echo $QX0500_1; ?></td>
<td class="answer"><?php echo $QX0500_2; ?></td>
<td class="answer"><?php echo $QX0500_3; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0500_4; ?></td>
<td class="answer"><?php echo $QX0500_5; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0500_6; ?></td>
<td class="answer"><?php echo $QX0500_7; ?></td>
<td class="answer"><?php echo $QX0500_8; ?></td>
<td class="answer"><?php echo $QX0500_9; ?></td>
</tr>
</table>
</div>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0600. Type of Assessment</b> (A0310 on existing record to be modified/inactivated)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QX0600A)
{
case "01":
$X0600Aa = "0";
$X0600Ab = "1";
break;
case "02":
$X0600Aa = "0";
$X0600Ab = "2";
break;
case "03":
$X0600Aa = "0";
$X0600Ab = "3";
break;
case "04":
$X0600Aa = "0";
$X0600Ab = "4";
break;
case "05":
$X0600Aa = "0";
$X0600Ab = "5";
break;
case "06":
$X0600Aa = "0";
$X0600Ab = "6";
break;
case "99":
$X0600Aa = "9";
$X0600Ab = "9";
}
?>
<td class="answer"><?php echo $X0600Aa; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $X0600Ab; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page37-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page37-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Federal OBRA Reason for Assessment</b>
</ul>
<ol class="page37-ol-zero" style="padding-left:4em">
<li><b>Admission</b> assessment (required by day 14)
<li><b>Quarterly</b> review assessment
<li><b>Annual</b> assessment
<li><b>Significant change in status</b> assessment
<li><b>Significant correction</b> to <b>prior comprehensive</b> assessment
<li><b>Significant correction</b> to <b>prior quarterly</b> assessment</b>
<li value="99"><b>None of the above</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page37-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QX0600B)
{
case "01":
$X0600Ba = "0";
$X0600Bb = "1";
break;
case "02":
$X0600Ba = "0";
$X0600Bb = "2";
break;
case "03":
$X0600Ba = "0";
$X0600Bb = "3";
break;
case "04":
$X0600Ba = "0";
$X0600Bb = "4";
break;
case "05":
$X0600Ba = "0";
$X0600Bb = "5";
break;
case "07":
$X0600Ba = "0";
$X0600Bb = "7";
break;
case "99":
$X0600Ba = "9";
$X0600Bb = "9";
}
?>
<td class="answer"><?php echo $X0600Ba; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $X0600Bb; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page37-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page37-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>PPS Assessment</b>
</ul>
<ol class="page37-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<b><u>PPS</u> <u>Scheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
<dd style="padding-left:2em">
<li><b>5-day</b> scheduled assessment
<li><b>14-day</b> scheduled assessment
<li><b>30-day</b> scheduled assessment
<li><b>60-day</b> scheduled assessment
<li><b>90-day</b> scheduled assessment
</dd>
<b><u>PPS</u> <u>Unscheduled</u> <u>Assessments</u> <u>for</u> <u>a</u> <u>Medicare</u> <u>Part</u> <u>A</u> <u>Stay</u></b>
<dd style="padding-left:2em">
<li value="7"><b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant <br>correction assessment)
</dd>
<b><u>Not</u> <u>PPS</u> <u>Assessment</u></b>
<dd style="padding-left:2em">
<li value="99"><b>None of the above</b>
</dd>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page37-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QX0600C; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page37-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page37-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>PPS Other Medicare Required Assessment - OMRA</b>
</ul>
<ol class="page37-ol" start="0">
<li><b>No</b>	
<li><b>Start of therapy</b> assessment
<li><b>End of therapy</b> assessment
<li><b>Both Start and End of therapy</b> assessment
<li><b>Change of therapy</b> assessment
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page37-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0600 continued on next page</b></div></td>
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