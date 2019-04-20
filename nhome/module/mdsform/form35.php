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
$sql = "SELECT * FROM `mdsform35` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page35_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page35_Qfiller_name .= $v;
		}else{}
	}
}
}
$page35_Qfiller_name = str_replace(';',', ', $page35_Qfiller_name);
?>
<body class="page35-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page35_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section V</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Care Area Assessment (CAA) Summary</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page35-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>V0100. Items From the Most Recent Prior OBRA or Scheduled PPS Assessment</b><br><a>Complete only if A0310E = 0 and if the following is true for the <b>prior assessment</b>: A0310A = 01- 06 or A0310B = 01- 06</a></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page35-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QV0100A)
{
case "01":
$V0100Aa = "0";
$V0100Ab = "1";
break;
case "02":
$V0100Aa = "0";
$V0100Ab = "2";
break;
case "03":
$V0100Aa = "0";
$V0100Ab = "3";
break;
case "04":
$V0100Aa = "0";
$V0100Ab = "4";
break;
case "05":
$V0100Aa = "0";
$V0100Ab = "5";
break;
case "06":
$V0100Aa = "0";
$V0100Ab = "6";
break;
case "99":
$V0100Aa = "9";
$V0100Ab = "9";
}
?>
<td class="answer"><?php echo $V0100Aa; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $V0100Ab; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page35-partwhite" style="width:50em">
<ul class="page35-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Prior Assessment Federal OBRA Reason for Assessment</b>(A0310A value from prior assessment)
</ul>
<ol class="page35-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Admission</b> assessment (required by day 14)
<li><b>Quarterly</b> review assessment
<li><b>Annual</b> assessment
<li><b>Significant change in status</b> assessment
<li><b>Significant correction</b> to <b>prior comprehensive</b> assessment
<li><b>Significant correction</b> to <b>prior quarterly</b> assessment
<li value="99">None of the above
</ol>
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="page35-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QV0100B)
{
case "01":
$V0100Ba = "0";
$V0100Bb = "1";
break;
case "02":
$V0100Ba = "0";
$V0100Bb = "2";
break;
case "03":
$V0100Ba = "0";
$V0100Bb = "3";
break;
case "04":
$V0100Ba = "0";
$V0100Bb = "4";
break;
case "05":
$V0100Ba = "0";
$V0100Bb = "5";
break;
case "06":
$V0100Ba = "0";
$V0100Bb = "6";
break;
case "07":
$V0100Ba = "0";
$V0100Bb = "7";
break;
case "99":
$V0100Ba = "9";
$V0100Bb = "9";
}
?>
<td class="answer"><?php echo $V0100Ba; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $V0100Bb; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page35-partwhite">
<ul class="page35-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Prior Assessment PPS Reason for Assessment</b> (A0310B value from prior assessment)
</ul>
<ol class="page35-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>5-day</b> scheduled assessment
<li><b>14-day</b> scheduled assessment
<li><b>30-day</b> scheduled assessment
<li><b>60-day</b> scheduled assessment
<li><b>90-day</b> scheduled assessment
<li><b>Readmission/return</b> assessment
<li><b>Unscheduled assessment used for PPS</b> (OMRA, significant or clinical change, or significant <br>correction assessment)
<li value="99">None of the above
</ol>	  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page35-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page35-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page35-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Prior Assessment Reference Date</b><?php if (substr($url[3],0,5)!="print"){ if($V0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (A2300 value from prior assessment)
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QV0100C_1; ?></td>
<td class="answer"><?php echo $QV0100C_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QV0100C_3; ?></td>
<td class="answer"><?php echo $QV0100C_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QV0100C_5; ?></td>
<td class="answer"><?php echo $QV0100C_6; ?></td>
<td class="answer"><?php echo $QV0100C_7; ?></td>
<td class="answer"><?php echo $QV0100C_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ul></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page35-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Score</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QV0100D_1; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QV0100D_2; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page35-partwhite">
<ul class="page35-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Prior Assessment Brief Interview for Mental Status (BIMS) Summary Score</b> (C0500 value from prior <br>assessment)			  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page35-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Score</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QV0100E_1; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100EF_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QV0100E_2; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100EF_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page35-partwhite">
<ul class="page35-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Prior Assessment Resident Mood Interview (PHQ-9c) Total Severity Score</b> (D0300 value from prior <br>assessment)			  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page35-content" style="border-top-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Score</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QV0100F_1; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100EF_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QV0100F_2; ?><?php if (substr($url[3],0,5)!="print"){ if($V0100EF_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page35-partwhite">
<ul class="page35-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Prior Assessment Staff Assessment of Resident Mood (PHQ-9-OV) Total Severity Score</b> (D0600 value from prior assessment)
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