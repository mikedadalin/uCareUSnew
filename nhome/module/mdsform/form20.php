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
$sql = "SELECT * FROM `mdsform20` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page20_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page20_Qfiller_name .= $v;
		}else{}
	}
}
}
$page20_Qfiller_name = str_replace(';',', ', $page20_Qfiller_name);
?>
<body class="page20-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page20_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section J</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Health Conditions</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J0100. Pain Management</b> - Complete for all residents, regardless of current pain level</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page20-partwhite" colspan="2"><a style="padding-left:1em">At any time in the last 5 days, has the resident:</a></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0100A; ?><?php if (substr($url[3],0,5)!="print"){ if($J0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite" style="width:50em">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Received scheduled pain medication regimen?</b>
</ul>
<ol class="page20-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0100B; ?><?php if (substr($url[3],0,5)!="print"){ if($J0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Received PRN pain medications OR was offered and declined?</b>
</ul>
<ol class="page20-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>			
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0100C; ?><?php if (substr($url[3],0,5)!="print"){ if($J0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Received non-medication intervention for pain?</b>
</ul>
<ol class="page20-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>			
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J0200. Should Pain Assessment Interview be Conducted?</b><br><a style="padding-left:0.3125em">Attempt to conduct interview with all residents. If resident is comatose, skip to J1100, Shortness of Breath (dyspnea)</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0200; ?><?php if (substr($url[3],0,5)!="print"){ if($J0200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page20-ol" start="0">
<li><b>No</b> (resident is rarely/never understood)<b> &#8594; </b>Skip to and complete J0800, Indicators of Pain or <br>Possible Pain
<li><b>Yes &#8594; </b> Continue to J0300, Pain Presence
</ol></div>
</td>
</tr>
</table>	  
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Pain Assessment Interview</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J0300. Pain Presence</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0300; ?><?php if (substr($url[3],0,5)!="print"){ if($J0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: <b>"Have you had pain or hurting at any time</b> in the last 5 days?"</a>
<ol class="page20-ol" start="0">
<li><b>No &#8594; </b>Skip to J1100, Shortness of Breath
<li><b>Yes &#8594; </b>Continue to J0400, Pain Frequency
<li value="9"><b>Unable to answer &#8594; </b>Skip to J0800, Indicators of Pain or Possible Pain
</ol></div>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>J0400. Pain Frequency</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page20-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0400; ?><?php if (substr($url[3],0,5)!="print"){ if($J0400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: <b>"How much of the time have you experienced pain or hurting</b> over the last 5 days?"</a>
<ol class="page20-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Almost constantly</b>
<li><b>Frequently</b>
<li><b>Occasionally</b>
<li><b>Rarely</b>
<li value="9"><b>Unable to answer</b>
</ol></div>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>J0500. Pain Effect on Function</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0500A; ?><?php if (substr($url[3],0,5)!="print"){ if($J0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Ask resident: "Over the past 5 days, <b>has pain made it hard for you to sleep at night?"</b>
</ul>
<ol class="page20-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unable to answer</b>
</ol></div>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0500B; ?><?php if (substr($url[3],0,5)!="print"){ if($J0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2">Ask resident: "Over the past 5 days, <b>have you limited your day-to-day activities because of pain?"</b>
</ul>
<ol class="page20-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unable to answer</b>
</ol></div>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page20-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>J0600. Pain Intensity</b> - Administer <b>ONLY ONE</b> of the following pain intensity questions (A or B)</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Rating</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QJ0600A_1; ?><?php if (substr($url[3],0,5)!="print"){ if($J0600A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QJ0600A_2; ?><?php if (substr($url[3],0,5)!="print"){ if($J0600A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Numeric Rating Scale (00-10)</b><br>
Ask resident: "Please rate your worst pain over the last 5 days on a zero to ten scale, with zero being no <br>pain and ten as the worst pain you can imagine." (Show resident 00 -10 pain scale) <br><b>Enter two-digit response. Enter 99 if unable to answer.</b>
</ul>		  
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page20-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0600B; ?><?php if (substr($url[3],0,5)!="print"){ if($J0600B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page20-partwhite">
<ul class="page20-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Verbal Descriptor Scale</b><br>Ask resident: "Please rate the intensity of your worst pain over the last 5 days." (Show resident verbal scale)
</ul>
<ol class="page20-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Mild</b>
<li><b>Moderate</b>
<li><b>Severe</b>
<li><b>Very severe, horrible</b>
<li value="9"><b>Unable to answer</b>
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