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
$sql = "SELECT * FROM `mdsform38` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page38_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page38_Qfiller_name .= $v;
		}else{}
	}
}
}
$page38_Qfiller_name = str_replace(';',', ', $page38_Qfiller_name);
?>
<body class="page38-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page38_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page38-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0600. Type of Assessment.- Continued</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QX0600D; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite" style="width:50em">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Is this a Swing Bed clinical change assessment?</b> Complete only if X0150 = 2
</ul>
<ol class="page38-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QX0600F)
{
case "01":
$X0600Fa = "0";
$X0600Fb = "1";
break;
case "10":
$X0600Fa = "1";
$X0600Fb = "0";
break;
case "11":
$X0600Fa = "1";
$X0600Fb = "1";
break;
case "12":
$X0600Fa = "1";
$X0600Fb = "2";
break;
case "99":
$X0600Fa = "9";
$X0600Fb = "9";
}
?>
<td class="answer"><?php echo $X0600Fa; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $X0600Fb; ?><?php if (substr($url[3],0,5)!="print"){ if($X0600F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Entry/discharge reporting</b>
</ul>
<ol class="page38-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Entry</b> tracking record
<li value="10"><b>Discharge</b> assessment-<b>return not anticipated</b>
<li value="11"><b>Discharge</b> assessment-<b>return anticipated</b>
<li value="12"><b>Death in facility</b> tracking record
<li value="99"><b>None of the above</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0700. Date</b> on existing record to be modified/inactivated - <b>Complete one only</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-bottom-style:hidden"></td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Assessment Reference Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0700A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - (A2300 on existing record to be modified/inactivated) - <br>Complete only if X0600F = 99
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QX0700A_1; ?></td>
<td class="answer"><?php echo $QX0700A_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0700A_3; ?></td>
<td class="answer"><?php echo $QX0700A_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0700A_5; ?></td>
<td class="answer"><?php echo $QX0700A_6; ?></td>
<td class="answer"><?php echo $QX0700A_7; ?></td>
<td class="answer"><?php echo $QX0700A_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</ul>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Discharge Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0700B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - (A2000 on existing record to be modified/inactivated) - <br>Complete only if X0600F = 10, 11, or 12
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QX0700B_1; ?></td>
<td class="answer"><?php echo $QX0700B_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0700B_3; ?></td>
<td class="answer"><?php echo $QX0700B_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0700B_5; ?></td>
<td class="answer"><?php echo $QX0700B_6; ?></td>
<td class="answer"><?php echo $QX0700B_7; ?></td>
<td class="answer"><?php echo $QX0700B_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</ul>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden"></td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Entry Date</b><?php if (substr($url[3],0,5)!="print"){ if($X0700C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - (A1600 on existing record to be modified/inactivated) - Complete only if X0600F = 01
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QX0700C_1; ?></td>
<td class="answer"><?php echo $QX0700C_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0700C_3; ?></td>
<td class="answer"><?php echo $QX0700C_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX0700C_5; ?></td>
<td class="answer"><?php echo $QX0700C_6; ?></td>
<td class="answer"><?php echo $QX0700C_7; ?></td>
<td class="answer"><?php echo $QX0700C_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</ul>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Correction Attestation Section</b>- Complete this section to explain and attest to the modification/inactivation request</div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0800. Correction Number</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QX0800_1; ?><?php if (substr($url[3],0,5)!="print"){ if($X08001_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QX0800_2; ?><?php if (substr($url[3],0,5)!="print"){ if($X08002_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page38-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Enter the number of correction requests to modify/inactivate the existing record, including the present </b><b style="padding-left:0.3125em">one</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X0900. Reasons for Modification</b><?php if (substr($url[3],0,5)!="print"){ if($X0900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>- Complete only if Type of Record is to modify a record in error (A0050 = 2)</div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all that apply</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX0900A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Transcription error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX0900B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Data entry error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX0900C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Software product error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX0900D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Item coding error</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX0900E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>End of Therapy - Resumption (EOT-R) date</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX0900Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>Other error requiring modification</b>
<table cellspacing="0">
<tr>
<td>If "Other" checked, please specify:</td>
<td class="page38-section2">&nbsp;<?php echo $QX0900Ztext; ?><?php if (substr($url[3],0,5)!="print"){ if($X0900Z_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><hr color="black" align="left" width="100%" size="1"></td>
</tr>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X1050. Reasons for Inactivation</b><?php if (substr($url[3],0,5)!="print"){ if($X1050_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>- Complete only if Type of Record is to inactivate a record in error (A0050 = 3)</div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page38-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all that apply</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX1050A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Event did not occur</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page38-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QX1050Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page38-partwhite">
<ul class="page38-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>Other error requiring inactivation</b>
<table cellspacing="0">
<tr>
<td>If "Other" checked, please specify:</td>
<td class="page38-section2">&nbsp;<?php echo $QX1050Ztext; ?><?php if (substr($url[3],0,5)!="print"){ if($X1050Z_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><hr color="black" align="left" width="100%" size="1"></td>
</tr>
</table>
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