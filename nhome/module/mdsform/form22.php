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
$sql = "SELECT * FROM `mdsform22` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page22_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page22_Qfiller_name .= $v;
		}else{}
	}
}
}
$page22_Qfiller_name = str_replace(';',', ', $page22_Qfiller_name);
?>
<body class="page22-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page22_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section J</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Health Conditions</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page22-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1700. Fall History on Admission</b><br><a>Complete only if A0310A = 01 or A0310E = 1</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page22-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1700A; ?><?php if (substr($url[3],0,5)!="print"){ if($J1700A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page22-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Did the resident have a fall any time in the <b>last month</b> prior to admission/entry or reentry?
</ul>
<ol class="page22-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unable to determine</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page22-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1700B; ?><?php if (substr($url[3],0,5)!="print"){ if($J1700B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page22-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2">Did the resident have a fall any time in the <b>last 2-6 months</b> prior to admission/entry or reentry?
</ul>
<ol class="page22-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unable to determine</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page22-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1700C; ?><?php if (substr($url[3],0,5)!="print"){ if($J1700C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page22-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3">Did the resident have any <b>fracture related to a fall in the 6 months</b> prior to admission/entry or reentry?
</ul>
<ol class="page22-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unable to determine</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page22-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1800. Any Falls Since Admission/Entry or Reentry or Prior Assessment (OBRA or Scheduled PPS),</b> whichever is <br><a style="padding-left:3.4em">more recent</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page22-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1800; ?><?php if (substr($url[3],0,5)!="print"){ if($J1800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Has the resident <b>had any falls since admission/entry or reentry or the prior assessment </b>(OBRA or </a><br><a style="padding-left:0.3125em">Scheduled PPS), whichever is more recent?</a>
<ol class="page22-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No &#8594; </b>Skip to K0100, Swallowing Disorder
<li><b>Yes &#8594; </b>Continue to J1900, Number of Falls Since Admission/Entry or Reentry or Prior Assessment <br>(OBRA or Scheduled PPS)
</ol></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page22-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1900. Number of Falls Since Admission or Prior Assessment (OBRA, PPS, or Discharge),</b> whichever is more <br><a style="padding-left:3.4em">recent</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td colspan="1" rowspan="4" style="width:13.125em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page22-ol" start="0">
<li><b>None</b>
<li><b>One</b>
<li><b>Two or more</b>
</ol></div>
</td>
<td class="page22-partwhite" colspan="2" style="width:42.75em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page22-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1900A; ?><?php if (substr($url[3],0,5)!="print"){ if($J1900A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite" style="width:36.875em">
<ul class="page22-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No injury</b> - no evidence of any injury is noted on physical assessment by <br>the nurse or primary care clinician; no complaints of pain or injury by the <br>resident; no change in the resident's behavior is noted after the fall
</ul>
</td>
</tr>
<tr>
<td class="page22-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1900B; ?><?php if (substr($url[3],0,5)!="print"){ if($J1900B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite">
<ul class="page22-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Injury (except major)</b> - skin tears, abrasions, lacerations, superficial <br>bruises, hematomas and sprains; or any fall-related injury that causes the <br>resident to complain of pain
</ul>
</td>
</tr>
<tr>
<td class="page22-content" style="border-top-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1900C; ?><?php if (substr($url[3],0,5)!="print"){ if($J1900C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page22-partwhite">
<ul class="page22-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Major injury</b> - bone fractures, joint dislocations, closed head injuries with <br>altered consciousness, subdural hematoma
</ul>
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