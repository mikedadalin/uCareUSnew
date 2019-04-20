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
$sql = "SELECT * FROM `mdsform11` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page11_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page11_Qfiller_name .= $v;
		}else{}
	}
}
}
$page11_Qfiller_name = str_replace(';',', ', $page11_Qfiller_name);
?>
<body class="page11-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page11_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section E</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Behavior</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0100. Potential Indicators of Psychosis</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page11-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all that apply</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QE0100A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite" style="width:50em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Hallucinations</b> (perceptual experiences in the absence of real external sensory stimuli)
</ul>	
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QE0100B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Delusions</b> (misconceptions or beliefs that are firmly held, contrary to reality)
</ul>	
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QE0100Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Behavioral Symptoms</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0200. Behavioral Symptom - Presence & Frequency</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page11-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1em">Note presence of symptoms and their frequency</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page11-partwhite" colspan="1" rowspan="6" style="width:21em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page11-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Behavior not exhibited</b>
<li><b>Behavior of this type occurred <br>1 to 3 days</b>
<li><b>Behavior of this type occurred <br>4 to 6 days,</b> but less than daily
<li><b>Behavior of this type occurred daily</b>
</ol>
</td>
<td class="page11-partwhite" colspan="2" style="width:34.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page11-content" style="border-bottom-style:hidden; width:3.875em">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0200A; ?><?php if (substr($url[3],0,5)!="print"){ if($E0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite" style="width:31em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Physical behavioral symptoms directed toward others</b> (e.g., <br>hitting, kicking, pushing, scratching, grabbing, abusing others <br>sexually)
</ul></div>
</td>
</tr>
<tr>
<td class="page11-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0200B; ?><?php if (substr($url[3],0,5)!="print"){ if($E0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Verbal behavioral symptoms directed toward others</b> (e.g., <br>threatening others, screaming at others, cursing at others)
</ul></div>
</td>
</tr>
<tr>
<td class="page11-content" style="border-top-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0200C; ?><?php if (substr($url[3],0,5)!="print"){ if($E0200C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Other behavioral symptoms not directed toward others</b> (e.g., <br>physical symptoms such as hitting or scratching self, pacing, <br>rummaging, public sexual acts, disrobing in public, throwing or <br>smearing food or bodily wastes, or verbal/vocal symptoms like <br>screaming, disruptive sounds)
</ul></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-top-style:hidden; width:55.875em">
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0300. Overall Presence of Behavioral Symptoms</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Were any behavioral symptoms in questions E0200 coded 1, 2, or 3?</b>
<ol class="page11-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No &#8594; </b>Skip to E0800, Rejection of Care
<li><b>Yes &#8594; </b>Considering all of E0200, Behavioral Symptoms, answer E0500 and E0600 below
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0500. Impact on Resident</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0500A; ?><?php if (substr($url[3],0,5)!="print"){ if($E0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Did any of the identified symptom(s):</b>
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Put the resident at significant risk for physical illness or injury?</b>
</ul>
<ol class="page11-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0500B; ?><?php if (substr($url[3],0,5)!="print"){ if($E0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Significantly interfere with the resident's care?</b>
</ul>
<ol class="page11-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0500C; ?><?php if (substr($url[3],0,5)!="print"){ if($E0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Significantly interfere with the resident's participation in activities or social interactions?</b>
</ul>
<ol class="page11-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0600. Impact on Others</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0600A; ?><?php if (substr($url[3],0,5)!="print"){ if($E0600A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Did any of the identified symptom(s):</b>
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Put others at significant risk for physical injury?</b>
</ul>
<ol class="page11-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0600B; ?><?php if (substr($url[3],0,5)!="print"){ if($E0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Significantly intrude on the privacy or activity of others?</b>
</ul>
<ol class="page11-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0600C; ?><?php if (substr($url[3],0,5)!="print"){ if($E0600C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page11-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Significantly disrupt care or living environment?</b>
</ul>
<ol class="page11-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page11-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0800. Rejection of Care - Presence & Frequency</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page11-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0800; ?><?php if (substr($url[3],0,5)!="print"){ if($E0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Did the resident reject evaluation or care</b> (e.g., bloodwork, taking medications, ADL assistance) <b style="padding-left:0.3125em">that is </b><br><b style="padding-left:0.3125em">necessary to achieve the resident's goals for health and well-being?</b> Do not include behaviors that have <br><a style="padding-left:0.3125em">already been addressed (e.g., by discussion or care planning with the resident or family), and/or determined </a><br><a style="padding-left:0.3125em">to be consistent with resident values, preferences, or goals.</a>
<ol class="page11-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Behavior not exhibited</b>
<li><b>Behavior of this type occurred 1 to 3 days</b>
<li><b>Behavior of this type occurred 4 to 6 days,</b> but less than daily
<li><b>Behavior of this type occurred daily</b>
</ol></div>
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