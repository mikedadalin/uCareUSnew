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
$sql = "SELECT * FROM `mdsform06` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page6_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page6_Qfiller_name .= $v;
		}else{}
	}
}
}
$page6_Qfiller_name = str_replace(';',', ', $page6_Qfiller_name);
?>
<body class="page6-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page6_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.5em; width:55.875em; border-width:0.6em">
<tr>
<td style="background-color:rgb(230,230,226); text-align:center"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Look back period for all items is 7 days unless another time frame is indicated</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section B</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Hearing, Speech, and Vision</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>B0100. Comatose</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB0100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite" style="width:50em">
<b style="padding-left:0.3125em">Persistent vegetative state/no discernible consciousness</b>
<ol class="page6-ol" start="0">
<li><b>No &#8594;</b>Continue to B0200, Hearing
<li><b>Yes &#8594;</b>Skip to G0110, Activities of Daily Living (ADL) Assistance
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B0200. Hearing</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB0200; ?><?php if (substr($url[3],0,5)!="print"){ if($B0200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">
<b style="padding-left:0.3125em">Ability to hear</b> (with hearing aid or hearing appliances if normally used)
<ol class="page6-ol" start="0">
<li><b>Adequate</b>- no difficulty in normal conversation, social interaction, listening to TV
<li><b>Minimal difficulty</b>- difficulty in some environments (e.g., when person speaks softly or setting is noisy
<li><b>Moderate difficulty</b>- speaker has to increase volume and speak distinctly
<li><b>Highly impaired</b>- absence of useful hearing
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B0300. Hearing Aid</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB0300; ?><?php if (substr($url[3],0,5)!="print"){ if($B0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">
<b style="padding-left:0.3125em">Hearing aid or other hearing appliance used</b> in completing B0200, Hearing
<ol class="page6-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B0600. Speech Clarity</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB0600; ?><?php if (substr($url[3],0,5)!="print"){ if($_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">  
<b style="padding-left:0.3125em">Select best description of speech pattern</b>
<ol class="page6-ol" start="0">
<li><b>Clear speech</b>- distinct intelligible words
<li><b>Unclear speech</b>- slurred or mumbled words
<li><b>No speech</b>- absence of spoken words
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B0700. Makes Self Understood</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB0700; ?><?php if (substr($url[3],0,5)!="print"){ if($B0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">  
<b style="padding-left:0.3125em">Ability to express ideas and wants,</b>consider both verbal and non-verbal expression
<ol class="page6-ol" start="0">
<li><b>Understood</b>
<li><b>Usually understood</b>- difficulty communicating some words or finishing thoughts but is able if prompted or given time
<li><b>Sometimes understood</b>- ability is limited to making concrete requests
<li><b>Rarely/never understood</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B0800. Ability To Understand Others</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB0800; ?><?php if (substr($url[3],0,5)!="print"){ if($B0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">  
<b style="padding-left:0.3125em">Understanding verbal content, however able</b> (with hearing aid or device if used)
<ol class="page6-ol" start="0">
<li><b>Understands</b>- clear comprehension
<li><b>Usually understands</b>- misses some part/intent of message but comprehends most conversation
<li><b>Sometimes understands</b>- responds adequately to simple, direct communication only
<li><b>Rarely/never understands</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B1000. Vision</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB1000; ?><?php if (substr($url[3],0,5)!="print"){ if($B1000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">
<b style="padding-left:0.3125em">Ability to see in adequate light</b> (with glasses or other visual appliances)
<ol class="page6-ol" start="0">
<li><b>Adequate</b> - sees fine detail, including regular print in newspapers/books
<li><b>Impaired</b> - sees large print, but not regular print in newspapers/books
<li><b>Moderately impaired</b> - limited vision; not able to see newspaper headlines but can identify objects
<li><b>Highly impaired</b> - object identification in question, but eyes appear to follow objects
<li><b>Severely impaired</b> - no vision or sees only light, colors or shapes; eyes do not appear to follow objects
</ol>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="page6-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">B1200. Corrective Lenses.</b></div>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page6-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QB1200; ?><?php if (substr($url[3],0,5)!="print"){ if($B1200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page6-partwhite">
<b style="padding-left:0.3125em">Corrective lenses (contacts, glasses, or magnifying glass) used</b> in completing B1000, Vision
<ol class="page6-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->	  	  
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