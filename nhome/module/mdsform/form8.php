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
$sql = "SELECT * FROM `mdsform08` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page8_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page8_Qfiller_name .= $v;
		}else{}
	}
}
}
$page8_Qfiller_name = str_replace(';',', ', $page8_Qfiller_name);
?>
<body class="page8-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page8_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section C</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Cognitive Patterns</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>C0600. Should the Staff Assessment for Mental Status (C0700 - C1000) be Conducted?</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0600; ?><?php if (substr($url[3],0,5)!="print"){ if($C0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite" style="width:50em">
<ol class="page8-ol" start="0">
<li><b>No</b> (resident was able to complete interview ) &#8594; Skip to C1300, Signs and Symptoms of Delirium
<li><b>Yes</b> (resident was unable to complete interview) &#8594; Continue to C0700, Short-term Memory OK
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Staff Assessment for Mental Status</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-partwhite" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><a style="padding-left:1em">Do not conduct if Brief Interview for Mental Status (C0200-C0500) was completed</a></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>C0700. Short-term Memory OK</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page8-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0700; ?><?php if (substr($url[3],0,5)!="print"){ if($C0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite" style="width:50em">
<b style="padding-left:0.3125em">Seems or appears to recall after 5 minutes</b>
<ol class="page8-ol" start="0">
<li><b>Memory OK</b>
<li><b>Memory problem</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>C0800. Long-term Memory OK</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0800; ?><?php if (substr($url[3],0,5)!="print"){ if($C0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<b style="padding-left:0.3125em">Seems or appears to recall long past</b>
<ol class="page8-ol" start="0">
<li><b>Memory OK</b>
<li><b>Memory problem</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>C0900. Memory/Recall Ability</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-partwhite" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:2.7em">&#8595; Check all that the resident was normally able to recall</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QC0900A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Current season</b>
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QC0900B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Location of own room</b>
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QC0900C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Staff names and faces</b>
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QC0900D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>That he or she is in a nursing home</b>
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QC0900Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b> were recalled
</ul>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>C1000. Cognitive Skills for Daily Decision Making</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC1000; ?><?php if (substr($url[3],0,5)!="print"){ if($C1000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<b style="padding-left:0.3125em">Made decisions regarding tasks of daily life</b>
<ol class="page8-ol" start="0">
<li><b>Independent</b> - decisions consistent/reasonable
<li><b>Modified independence</b> - some difficulty in new situations only
<li><b>Moderately impaired</b> - decisions poor; cues/supervision required
<li><b>Severely impaired</b> - never/rarely made decisions
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page8-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Delirium</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>C1300. Signs and Symptoms of Delirium (from CAMc)</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-partwhite" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:1em">Code <b>after completing</b> Brief Interview for Mental Status or Staff Assessment, and reviewing medical record</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-partwhite" colspan="1" rowspan="6" style="width:14.625em">
<div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page8-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Behavior not present</b>
<li><b>Behavior continuously <br>present, does not <br>fluctuate</b>
<li><b>Behavior present, <br>fluctuates</b> (comes and <br>goes, changes in severity)
</ol>
</div>
</td>
<td class="page8-partwhite" colspan="2" style="width:41.25em"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:2.8em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page8-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC1300A; ?><?php if (substr($url[3],0,5)!="print"){ if($C1300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite" style="width:35.375em">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Inattention</b> - Did the resident have difficulty focusing attention (easily <br>distracted, out of touch or difficulty following what was said)?
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC1300B; ?><?php if (substr($url[3],0,5)!="print"){ if($C1300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Disorganized thinking</b> - Was the resident's thinking disorganized or <br>incoherent (rambling or irrelevant conversation, unclear or illogical flow of <br>ideas, or unpredictable switching from subject to subject)?
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC1300C; ?><?php if (substr($url[3],0,5)!="print"){ if($C1300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td style="border:0.0625em solid black">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Altered level of consciousness</b> - Did the resident have altered level of <br>consciousness (e.g., <b>vigilant</b> - startled easily to any sound or touch; <br><b>lethargic</b> - repeatedly dozed off when being asked questions, but <br>responded to voice or touch; <b>stuporous</b> - very difficult to arouse and keep <br>aroused for the interview; <b>comatose</b> - could not be aroused)?
</ul>
</td>
</tr>
<tr>
<td class="page8-content" style="border-top-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC1300D; ?><?php if (substr($url[3],0,5)!="print"){ if($C1300D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page8-partwhite">
<ul class="page8-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Psychomotor retardation</b>- Did the resident have an unusually decreased <br>level of activity such as sluggishness, staring into space, staying in one <br>position, moving very slowly?
</ul>
</td>
</tr>
</table>	  
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page8-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">C1600. Acute Onset Mental Status Change</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page8-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC1600; ?><?php if (substr($url[3],0,5)!="print"){ if($C1600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite" style="width:50em">
<b style="padding-left:0.3125em">Is there evidence of an acute change in mental status</b> from the resident's baseline?
<ol class="page8-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->	  
<a style="font-size:1em">Copyright c 1990 Annals of Internal Medicine. All rights reserved. Adapted with permission.<br>MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</a>
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