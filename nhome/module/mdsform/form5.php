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
$sql = "SELECT * FROM `mdsform05` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page5_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page5_Qfiller_name .= $v;
		}else{}
	}
}
}
$page5_Qfiller_name = str_replace(';',', ', $page5_Qfiller_name);
?>
<body class="page5-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page5_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page5-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A2100. Discharge Status</b><?php if (substr($url[3],0,5)!="print"){ if($A2100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br><a>Complete only if A0310F = 10, 11, or 12</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QA2100)
{
case "01":
$A2100a = "0";
$A2100b = "1";
break;
case "02":
$A2100a = "0";
$A2100b = "2";
break;
case "03":
$A2100a = "0";
$A2100b = "3";
break;
case "04":
$A2100a = "0";
$A2100b = "4";
break;
case "05":
$A2100a = "0";
$A2100b = "5";
break;
case "06":
$A2100a = "0";
$A2100b = "6";
break;
case "07":
$A2100a = "0";
$A2100b = "7";
break;
case "08":
$A2100a = "0";
$A2100b = "8";
break;
case "99":
$A2100a = "9";
$A2100b = "9";
}
?>
<td class="answer"><?php echo $A2100a; ?></td>
<td class="answer"><?php echo $A2100b; ?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite" style="width:50em">
<ol class="page5-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Community</b> (private home/apt., board/care, assisted living, group home)
<li><b>Another nursing home or swing bed</b>
<li><b>Acute hospital</b>
<li><b>Psychiatric hospital</b>
<li><b>Inpatient rehabilitation facility</b>
<li><b>ID/DD facility</b>
<li><b>Hospice</b>
<li><b>Deceased</b>
<li><b>Long Term Care Hospital </b>(LTCH)
<li value="99"><b>Other</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A2200. Previous Assessment Reference Date for Significant Correction</b><?php if (substr($url[3],0,5)!="print"){ if($A2200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br><a style="padding-left:0.3125em">Complete only if A0310A = 05 or 06</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-content"></td>
<td class="page5-partwhite">
<div style="padding-left:2em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA2200_1; ?></td>
<td class="answer"><?php echo $QA2200_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2200_3; ?></td>
<td class="answer"><?php echo $QA2200_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2200_5; ?></td>
<td class="answer"><?php echo $QA2200_6; ?></td>
<td class="answer"><?php echo $QA2200_7; ?></td>
<td class="answer"><?php echo $QA2200_8; ?></td>
</table>
</div>
<a style="padding-left:1.65em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A2300. Assessment Reference Date</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-content"></td>
<td class="page5-partwhite">
<b style="padding-left:0.3125em">Observation end date:</b>
<div style="padding-left:2em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA2300_1; ?></td>
<td class="answer"><?php echo $QA2300_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2300_3; ?></td>
<td class="answer"><?php echo $QA2300_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2300_5; ?></td>
<td class="answer"><?php echo $QA2300_6; ?></td>
<td class="answer"><?php echo $QA2300_7; ?></td>
<td class="answer"><?php echo $QA2300_8; ?></td>
</table>
</div>
<a style="padding-left:1.65em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A2400. Medicare Stay</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page5-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA2400A; ?><?php if (substr($url[3],0,5)!="print"){ if($A2400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite">
<ul class="page5-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Has the resident had a Medicare-covered stay since the most recent entry?</b>
<ol class="page5-ol" start="0">
<li><b>No &#8594;</b>Skip to B0100, Comatose
<li><b>Yes &#8594;</b>Continue to A2400B, Start date of most recent Medicare stay
</ol>
<br>
<li><b>Start date of most recent Medicare stay:</b><?php if (substr($url[3],0,5)!="print"){ if($A2400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<div style="padding-left:0.4em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA2400B_1; ?></td>
<td class="answer"><?php echo $QA2400B_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2400B_3; ?></td>
<td class="answer"><?php echo $QA2400B_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2400B_5; ?></td>
<td class="answer"><?php echo $QA2400B_6; ?></td>
<td class="answer"><?php echo $QA2400B_7; ?></td>
<td class="answer"><?php echo $QA2400B_8; ?></td>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
<li><b>End date of most recent Medicare stay</b> - Enter dashes if stay is ongoing:
<div style="padding-left:0.4em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA2400C_1; ?></td>
<td class="answer"><?php echo $QA2400C_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2400C_3; ?></td>
<td class="answer"><?php echo $QA2400C_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2400C_5; ?></td>
<td class="answer"><?php echo $QA2400C_6; ?></td>
<td class="answer"><?php echo $QA2400C_7; ?></td>
<td class="answer"><?php echo $QA2400C_8; ?></td>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
</ul>
</td>
</tr>
<!---------------------------------------------->
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