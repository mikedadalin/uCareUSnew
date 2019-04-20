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
$sql = "SELECT * FROM `mdsform16` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page16_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page16_Qfiller_name .= $v;
		}else{}
	}
}
}
$page16_Qfiller_name = str_replace(';',', ', $page16_Qfiller_name);
?>
<body class="page16-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page16_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section G</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Functional Status</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page16-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>G0120. Bathing</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:1em">How resident takes full-body bath/shower, sponge bath, and transfers in/out of tub/shower (<b>excludes</b> washing of <br><a style="padding-left:1em">back and hair). Code for </a><b>most dependent</b> in self-performance and support</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0120A; ?><?php if (substr($url[3],0,5)!="print"){ if($G0120A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page11-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Self-performance</b>
</ul>
<ol class="page16-ol" start="0">
<li><b>Independent</b> - no help provided
<li><b>Supervision</b> - oversight help only
<li><b>Physical help limited to transfer only</b>
<li><b>Physical help in part of bathing activity</b>
<li><b>Total dependence</b>
<li value="8"><b>Activity itself did not occur</b> or family and/or non-facility staff provided care 100% of the time for that <br>activity over the entire 7-day period
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0120B; ?><?php if (substr($url[3],0,5)!="print"){ if($G0120B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Support provided</b><br>(Bathing support codes are as defined in item <b>G0110 column 2, ADL Support Provided,</b> above)
</ul></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page16-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>G0300. Balance During Transitions and Walking</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">After observing the resident, <b>code the following walking and transition items for most dependent</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-partwhite" colspan="1" rowspan="6" style="width:21em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page16-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Steady at all times</b>
<li><b>Not steady, but <u>able</u> to stabilize <br>without staff assistance</b>
<li><b>Not steady, <u>only</u> <u>able</u> to stabilize <br>with staff assistance.</b>
<li value="8"><b>Activity did not occur</b>
</ol></div>
</td>
<td class="page16-partwhite" colspan="2" style="width:34.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page16-content" style="border-bottom-style:hidden; width:3.875em">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0300A; ?><?php if (substr($url[3],0,5)!="print"){ if($G0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite" style="width:31em">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Moving from seated to standing position</b>
</ul>
</td>
</tr>
<tr>
<td class="page16-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0300B; ?><?php if (substr($url[3],0,5)!="print"){ if($G0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Walking</b> (with assistive device if used)
</ul>
</td>
</tr>
<tr>
<td class="page16-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0300C; ?><?php if (substr($url[3],0,5)!="print"){ if($G0300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Turning around</b> and facing the opposite direction while walking
</ul>
</td>
</tr>
<tr>
<td class="page16-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0300D; ?><?php if (substr($url[3],0,5)!="print"){ if($G0300D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Moving on and off toilet</b>
</ul>
</td>
</tr>
<tr>
<td class="page16-content" style="border-top-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0300E; ?><?php if (substr($url[3],0,5)!="print"){ if($G0300E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Surface-to-surface transfer</b> (transfer between bed and chair or wheelchair)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>G0400. Functional Limitation in Range of Motion</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1em">Code for limitation</b> that interfered with daily functions or placed resident at risk of injury</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-partwhite" colspan="1" rowspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page16-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No impairment</b>
<li><b>Impairment on one side</b>
<li><b>Impairment on both sides</b>
</ol></div>
</td>
<td class="page16-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page16-content" style="border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0400A; ?><?php if (substr($url[3],0,5)!="print"){ if($G0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Upper extremity</b> (shoulder, elbow, wrist,hand)
</ul>
</td>
</tr>
<tr>
<td class="page16-content" style="border-top-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0400B; ?><?php if (substr($url[3],0,5)!="print"){ if($G0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Lower extremity</b> (hip, knee, ankle, foot)
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page16-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>G0600. Mobility Devices</b><?php if (substr($url[3],0,5)!="print"){ if($G0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page16-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all that were normally used</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QG0600A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite" style="width:50em">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Cane/crutch</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QG0600B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Walker</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QG0600C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Wheelchair</b> (manual or electric)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QG0600D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Limb prosthesis</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QG0600Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b> were used
</ul>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page16-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">G0900. Functional Rehabilitation Potential</b><br><a style="padding-left:0.3125em">Complete only if A0310A = 01</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0900A; ?><?php if (substr($url[3],0,5)!="print"){ if($G0900A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Resident believes he or she is capable of increased independence</b> in at least some ADLs
</ul>
<ol class="page16-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unable to determine</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page16-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QG0900B; ?><?php if (substr($url[3],0,5)!="print"){ if($G0900B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page16-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page16-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Direct care staff believe resident is capable of increased independence</b> in at least some ADLs
</ul>
<ol class="page16-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
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