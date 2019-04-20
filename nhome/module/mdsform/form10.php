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
$sql = "SELECT * FROM `mdsform10` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page10_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page10_Qfiller_name .= $v;
		}else{}
	}
}
}
$page10_Qfiller_name = str_replace(';',', ', $page10_Qfiller_name);
?>
<body class="page10-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page10_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section D</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Mood</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em; border-width:0.3em">
<tr>
<td class="page10-part" colspan="5"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>D0500. Staff Assessment of Resident Mood (PHQ-9-OV*)</b><br><a>Do not conduct if Resident Mood Interview (D0200-D0300) was completed</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="5"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:1em">Over the last 2 weeks, did the resident have any of the following problems or behaviors?</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="5" style="border-bottom-style:hidden;"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">If symptom is present, enter 1 (yes) in column 1, Symptom Presence.</a><br>
<a style="padding-left:0.3125em">Then move to column 2, Symptom Frequency, and indicate symptom frequency.</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="2" rowspan="2" style="border-top-style:hidden; border-right-style:hidden; width:22.0625em">
<ol class="page10-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Symptom Presence</b>
<ol class="page10-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b> enter 0 in column 2)
<li><b>Yes</b> (enter 0-3 in column 2)
</ol>
</ol>
</td>
<td class="page10-partwhite" colspan="1" rowspan="2" style="border-top-style:hidden; border-left-style:hidden; width:22.0625em">
<ol class="page10-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Symptom Frequency</b>
<ol class="page10-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Never or 1 day</b>
<li><b>2-6 days</b> (several days)
<li><b>7-11 days</b> (half or more of the days)
<li><b>12-14 days</b> (nearly every day)
</ol>
</ol>
</td>
<td class="page10-part2" colspan="1" rowspan="1" style="width:5.875em">
<b>1.<br>Symptom <br>Presence</b>
</td>
<td class="page10-part2" colspan="1" rowspan="1" style="width:5.875em">
<b>2.<br>Symptom <br>Frequency</b>
</td>
<tr>
<td class="page10-partwhite2" colspan="2" rowspan="1" style="width:11.75em">
<b style="font-size:0.8em">&#8595; Enter Scores in Boxes &#8595;</b>
</td>
</tr>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b style="font-style:italic"><b>Little interest or pleasure in doing things</b>
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500A1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500A2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b style="font-style:italic"><b>Feeling or appearing down, depressed, or hopeless</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500B1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500B2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b style="font-style:italic"><b>Trouble falling or staying asleep, or sleeping too much</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500C1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500C2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b style="font-style:italic"><b>Feeling tired or having little energy</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500D1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500D2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b style="font-style:italic"><b>Poor appetite or overeating</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500E1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500E2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b style="font-style:italic"><b>Indicating that s/he feels bad about self, is a failure, or has let self or family down</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500F1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500F2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b style="font-style:italic"><b>Trouble concentrating on things, such as reading the newspaper or watching television</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500G1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500G2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b style="font-style:italic"><b>Moving or speaking so slowly that other people have noticed. <br>Or the opposite - being so fidgety or restless that s/he has been moving around <br>a lot more than usual</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500H1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500H1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500H2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500H2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b style="font-style:italic"><b>States that life isn't worth living, wishes for death, or attempts to harm self</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500I1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500I1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500I2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500I2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-partwhite" colspan="3">
<ul class="page10-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="10"><b style="font-style:italic"><b>Being short-tempered, easily annoyed</b>  
</ul>			
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500J1; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500J1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-content">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0500J2; ?><?php if (substr($url[3],0,5)!="print"){ if($D0500J2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-part" colspan="5"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>D0600. Total Severity Score</b></div>
</td>
</tr>
<tr>
<td class="page10-content" colspan="1" style="width:5.875em">
<a style="font-family:serif">Enter Score</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QD0600_1; ?><?php if (substr($url[3],0,5)!="print"){ if($D06001_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QD0600_2; ?><?php if (substr($url[3],0,5)!="print"){ if($D06002_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td colspan="4"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Add scores for all frequency responses in Column 2,</b> Symptom Frequency. <br><a style="padding-left:0.3125em">Total score must be between 00 and 30.</a></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page10-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>D0650. Safety Notification</b> - Complete only if D0500I1 = 1 indicating possibility of resident self harm</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page10-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QD0650; ?><?php if (substr($url[3],0,5)!="print"){ if($D0650_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page10-partwhite" style="width:50em">
<b style="padding-left:0.3125em">Was responsible staff or provider informed that there is a potential for resident self harm?</br>
<ol class="page10-ol" start="0" style="padding-left:3em">
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->	
<p style="font-size:1em">* Copyright c Pfizer Inc. All rights reserved.<br>MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
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