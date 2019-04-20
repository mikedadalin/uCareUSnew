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
$sql = "SELECT * FROM `mdsform02` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== ¸Ñ START ==*/
	$LWJArray = array('QA0500A_1','QA0500A_2','QA0500A_3','QA0500A_4','QA0500A_5','QA0500A_6','QA0500A_7','QA0500A_8','QA0500A_9','QA0500A_10','QA0500A_11','QA0500A_12','QA0500B','QA0500C_1','QA0500C_2','QA0500C_3','QA0500C_4','QA0500C_5','QA0500C_6','QA0500C_7','QA0500C_8','QA0500C_9','QA0500C_10','QA0500C_11','QA0500C_12','QA0500C_13','QA0500C_14','QA0500C_15','QA0500C_16','QA0500C_17','QA0500C_18','QA0500D_1','QA0500D_2','QA0500D_3','QA0600A_1','QA0600A_2','QA0600A_3','QA0600A_4','QA0600A_5','QA0600A_6','QA0600A_7','QA0600A_8','QA0600A_9','QA0600B_1','QA0600B_2','QA0600B_3','QA0600B_4','QA0600B_5','QA0600B_6','QA0600B_7','QA0600B_8','QA0600B_9','QA0600B_10','QA0600B_11','QA0600B_12','QA0700_1','QA0700_2','QA0700_3','QA0700_4','QA0700_5','QA0700_6','QA0700_7','QA0700_8','QA0700_9','QA0700_10','QA0700_11','QA0700_12');
	$LWJdataArray = array($QA0500A_1,$QA0500A_2,$QA0500A_3,$QA0500A_4,$QA0500A_5,$QA0500A_6,$QA0500A_7,$QA0500A_8,$QA0500A_9,$QA0500A_10,$QA0500A_11,$QA0500A_12,$QA0500B,$QA0500C_1,$QA0500C_2,$QA0500C_3,$QA0500C_4,$QA0500C_5,$QA0500C_6,$QA0500C_7,$QA0500C_8,$QA0500C_9,$QA0500C_10,$QA0500C_11,$QA0500C_12,$QA0500C_13,$QA0500C_14,$QA0500C_15,$QA0500C_16,$QA0500C_17,$QA0500C_18,$QA0500D_1,$QA0500D_2,$QA0500D_3,$QA0600A_1,$QA0600A_2,$QA0600A_3,$QA0600A_4,$QA0600A_5,$QA0600A_6,$QA0600A_7,$QA0600A_8,$QA0600A_9,$QA0600B_1,$QA0600B_2,$QA0600B_3,$QA0600B_4,$QA0600B_5,$QA0600B_6,$QA0600B_7,$QA0600B_8,$QA0600B_9,$QA0600B_10,$QA0600B_11,$QA0600B_12,$QA0700_1,$QA0700_2,$QA0700_3,$QA0700_4,$QA0700_5,$QA0700_6,$QA0700_7,$QA0700_8,$QA0700_9,$QA0700_10,$QA0700_11,$QA0700_12);
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
			$page2_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page2_Qfiller_name .= $v;
		}else{}
	}
}
}
$page2_Qfiller_name = str_replace(';',', ', $page2_Qfiller_name);
?>
<body class="page2-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page2_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section A</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Identification Information</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0310. Type of Assessment - Continued.</b></div></td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="page2-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA0310E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" style="width:50em" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Is this assessment the first assessment</b> (OBRA, PPS, or Discharge) <b>since the most recent admission?</b>
</ul>
<ol class="page2-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">		    
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QA0310F)
{
case "01":
$A0310Fa = "0";
$A0310Fb = "1";
break;
case "10":
$A0310Fa = "1";
$A0310Fb = "0";
break;
case "11":
$A0310Fa = "1";
$A0310Fb = "1";
break;
case "12":
$A0310Fa = "1";
$A0310Fb = "2";
break;
case "99":
$A0310Fa = "9";
$A0310Fb = "9";
}
?>
<td class="answer"><?php echo $A0310Fa; ?></td>
<td class="answer"><?php echo $A0310Fb; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Entry/discharge reporting</b>
</ul>
<ol class="page2-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Entry</b> record
<li value="10"><b>Discharge</b> assessment-<b>return not anticipated</b>
<li value="11"><b>Discharge</b> assessment-<b>return anticipated</b>
<li value="12"><b>Death in facility</b> record
<li value="99"><b>Not entry/discharge</b> record		 
</ol>		  
</td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="page2-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA0310G; ?><?php if (substr($url[3],0,5)!="print"){ if($A0310G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Type of discharge</b> - Complete only if A0310F = 10 or 11
</ul>
<ol class="page2-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">		    
<li><b>Planned</b>
<li><b>Unplanned</b>
</ol>
</td>
</tr>
<!----------------------------------------------------->
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0410. Unit Certification or Licensure Designation</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page2-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA0410; ?><?php if (substr($url[3],0,5)!="print"){ if($A0410_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ol class="page2-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Unit is neither Medicare nor Medicaid certified and MDS data is not required by the State</b>
<li><b>Unit is neither Medicare nor Medicaid certified but MDS data is required by the State</b>
<li><b>Unit is Medicare and/or Medicaid certified</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td  class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0500. Legal Name of Resident</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page2-content" style="border-bottom-style:hidden"></td>
<td>
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>First name:</b><?php if (substr($url[3],0,5)!="print"){ if($A0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA0500A_1; ?></td>
<td class="answer"><?php echo $QA0500A_2; ?></td>
<td class="answer"><?php echo $QA0500A_3; ?></td>
<td class="answer"><?php echo $QA0500A_4; ?></td>
<td class="answer"><?php echo $QA0500A_5; ?></td>
<td class="answer"><?php echo $QA0500A_6; ?></td>
<td class="answer"><?php echo $QA0500A_7; ?></td>
<td class="answer"><?php echo $QA0500A_8; ?></td>
<td class="answer"><?php echo $QA0500A_9; ?></td>
<td class="answer"><?php echo $QA0500A_10; ?></td>
<td class="answer"><?php echo $QA0500A_11; ?></td>
<td class="answer"><?php echo $QA0500A_12; ?></td>
</table>
</ul>
</td>
<td>
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2" style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Middle initial:</b>
<table cellspacing="0">
<td class="answer"><?php echo $QA0500B; ?></td>
</table>
</ul>
</td>
</tr>
<tr>
<td class="page2-content" style="border-top-style:hidden"></td>
<td>
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3" style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Last name:</b><?php if (substr($url[3],0,5)!="print"){ if($A0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA0500C_1; ?></td>
<td class="answer"><?php echo $QA0500C_2; ?></td>
<td class="answer"><?php echo $QA0500C_3; ?></td>
<td class="answer"><?php echo $QA0500C_4; ?></td>
<td class="answer"><?php echo $QA0500C_5; ?></td>
<td class="answer"><?php echo $QA0500C_6; ?></td>
<td class="answer"><?php echo $QA0500C_7; ?></td>
<td class="answer"><?php echo $QA0500C_8; ?></td>
<td class="answer"><?php echo $QA0500C_9; ?></td>
<td class="answer"><?php echo $QA0500C_10; ?></td>
<td class="answer"><?php echo $QA0500C_11; ?></td>
<td class="answer"><?php echo $QA0500C_12; ?></td>
<td class="answer"><?php echo $QA0500C_13; ?></td>
<td class="answer"><?php echo $QA0500C_14; ?></td>
<td class="answer"><?php echo $QA0500C_15; ?></td>
<td class="answer"><?php echo $QA0500C_16; ?></td>
<td class="answer"><?php echo $QA0500C_17; ?></td>
<td class="answer"><?php echo $QA0500C_18; ?></td>
</table>
</ul>
</td>
<td>
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4" style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Suffix:</b></dt>
<table cellspacing="0">
<td class="answer"><?php echo $QA0500D_1; ?></td>
<td class="answer"><?php echo $QA0500D_2; ?></td>
<td class="answer"><?php echo $QA0500D_3; ?></td>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0600. Social Security and Medicare Numbers</b></div></td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="page2-content"></td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Social Security Number:</b><?php if (substr($url[3],0,5)!="print"){ if($A0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA0600A_1; ?></td>
<td class="answer"><?php echo $QA0600A_2; ?></td>
<td class="answer"><?php echo $QA0600A_3; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA0600A_4; ?></td>
<td class="answer"><?php echo $QA0600A_5; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA0600A_6; ?></td>
<td class="answer"><?php echo $QA0600A_7; ?></td>
<td class="answer"><?php echo $QA0600A_8; ?></td>
<td class="answer"><?php echo $QA0600A_9; ?></td>
</table>
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Medicare number (or comparable railroad insurance number):</b><?php if (substr($url[3],0,5)!="print"){ if($A0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA0600B_1; ?></td>
<td class="answer"><?php echo $QA0600B_2; ?></td>
<td class="answer"><?php echo $QA0600B_3; ?></td>
<td class="answer"><?php echo $QA0600B_4; ?></td>
<td class="answer"><?php echo $QA0600B_5; ?></td>
<td class="answer"><?php echo $QA0600B_6; ?></td>
<td class="answer"><?php echo $QA0600B_7; ?></td>
<td class="answer"><?php echo $QA0600B_8; ?></td>
<td class="answer"><?php echo $QA0600B_9; ?></td>
<td class="answer"><?php echo $QA0600B_10; ?></td>
<td class="answer"><?php echo $QA0600B_11; ?></td>
<td class="answer"><?php echo $QA0600B_12; ?></td>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0700. Medicaid Number</b>- Enter "+" if pending, "N" if not a Medicaid recipient<?php if (substr($url[3],0,5)!="print"){ if($A0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div></td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page2-content"></td>
<td class="page2-partwhite" colspan="2">
<div style="padding-left:1.5em; margin:0.5em">
<table>
<tr>
<td class="answer"><?php echo $QA0700_1; ?></td>
<td class="answer"><?php echo $QA0700_2; ?></td>
<td class="answer"><?php echo $QA0700_3; ?></td>
<td class="answer"><?php echo $QA0700_4; ?></td>
<td class="answer"><?php echo $QA0700_5; ?></td>
<td class="answer"><?php echo $QA0700_6; ?></td>
<td class="answer"><?php echo $QA0700_7; ?></td>
<td class="answer"><?php echo $QA0700_8; ?></td>
<td class="answer"><?php echo $QA0700_9; ?></td>
<td class="answer"><?php echo $QA0700_10; ?></td>
<td class="answer"><?php echo $QA0700_11; ?></td>
<td class="answer"><?php echo $QA0700_12; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0800. Gender</b></div></td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page2-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA0800; ?><?php if (substr($url[3],0,5)!="print"){ if($A0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ol class="page2-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Male</b>
<li><b>Female</b>
</ol>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A0900. Birth Date</b><?php if (substr($url[3],0,5)!="print"){ if($A0900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div></td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page2-content"></td>
<td class="page2-partwhite" colspan="2">
<div style="padding-left:2em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA0900_1; ?></td>
<td class="answer"><?php echo $QA0900_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA0900_3; ?></td>
<td class="answer"><?php echo $QA0900_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA0900_5; ?></td>
<td class="answer"><?php echo $QA0900_6; ?></td>
<td class="answer"><?php echo $QA0900_7; ?></td>
<td class="answer"><?php echo $QA0900_8; ?></td>
</table>
</div>
<a style="padding-left:1.65em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page2-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A1000. Race/Ethnicity</b><?php if (substr($url[3],0,5)!="print"){ if($A1000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div></td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="page2-partwhite" colspan="3"><b style="padding-left:2.7em">&#8595; Check all that apply</b></td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="page2-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<?php
switch($QA1000)
{
case "A":
$A1000A = "X";
break;
case "B":
$A1000B = "X";
break;
case "C":
$A1000C = "X";
break;
case "D":
$A1000D = "X";
break;
case "E":
$A1000E = "X";
break;
case "F":
$A1000F = "X";
}
?>
<td class="answer2"><?php echo $A1000A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>American Indian or Alaska Native</b>
</ul>
</td>
</tr>
<tr>
<td class="page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $A1000B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Asian</b>
</ul>
</td>
</tr>
<tr>
<td class="page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $A1000C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Black or African American</b>
</ul>
</td>
</tr>
<tr>
<td class="page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $A1000D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Hispanic or Latino</b>
</ul>
</td>
</tr>
<tr>
<td class="page2-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $A1000E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Native Hawaiian or Other Pacific Islander</b>
</ul>
</td>
</tr>
<tr>
<td class="page2-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $A1000F; ?></td>
</tr>
</table>
</div>
</td>
<td class="page2-partwhite" colspan="2">
<ul class="page2-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>White</b>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->		
</table>
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