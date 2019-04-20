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
$sql = "SELECT * FROM `mdsform04` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page4_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page4_Qfiller_name .= $v;
		}else{}
	}
}
}
$page4_Qfiller_name = str_replace(';',', ', $page4_Qfiller_name);
?>
<body class="page4-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page4_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A1550. Conditions Related to ID/DD Status</b><?php if (substr($url[3],0,5)!="print"){ if($A1550_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br><a style="padding-left:0.3125em">If the resident is 22 years of age or older, complete only if A0310A = 01</a>
<br><a style="padding-left:0.3125em">If the resident is 21 years of age or younger, complete only if A0310A = 01, 03, 04, or 05</a></div>
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="page4-partwhite" colspan="2">
<div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all conditions that are related to ID/DD status</b> that were manifested before age 22, and are likely to <br><a style="padding-left:3.5em">continue indefinitely</a></div>
</td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="page4-content" style="border-bottom-style:hidden; width:5.875em"></td>
<td class="page4-content2" style="width:50em">
<b style="padding-left:0.3125em">ID/DD With Organic Condition</b>
</td>
</tr>
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1550A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ul class="page4-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Down syndrome</b>
</ul>
</td>
</tr>
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1550B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ul class="page4-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Autism</b>
</ul>
</td>
</tr>
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1550C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ul class="page4-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Epilepsy</b>
</ul>
</td>
</tr>
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1550D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ul class="page4-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Other organic condition related to ID/DD</b>
</ul>
</td>
</tr>
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page4-content2">
<b style="padding-left:0.3125em">ID/DD Without Organic Condition</b>
</td>
</tr>	  
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1550E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ul class="page4-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>ID/DD with no organic condition</b>
</ul>
</td>
</tr>
<tr>
<td class="page4-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page4-content2">
<b style="padding-left:0.3125em">No ID/DD</b>
</td>
</tr>	  
<tr>
<td class="page4-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1550Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ul class="page4-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------------------------------------->	 
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" border="3" style="margin-bottom:0.1875em; width:55.875em; border-width:0.3em"> 
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">Most Recent Admission/Entry or Reentry into this Facility</b></div>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A1600. Entry Date</b><?php if (substr($url[3],0,5)!="print"){ if($A1600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page4-content" style="width:5.875em"></td>
<td style="width:50em">
<div style="padding-left:2em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA1600_1; ?></td>
<td class="answer"><?php echo $QA1600_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA1600_3; ?></td>
<td class="answer"><?php echo $QA1600_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA1600_5; ?></td>
<td class="answer"><?php echo $QA1600_6; ?></td>
<td class="answer"><?php echo $QA1600_7; ?></td>
<td class="answer"><?php echo $QA1600_8; ?></td>
</table>
</div>
<a style="padding-left:1.65em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
</td>
</tr>
<!------------------------------------------------------------------------->	  
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A1700. Type of Entry</b></div>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page4-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA1700; ?><?php if (substr($url[3],0,5)!="print"){ if($A1700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ol class="page4-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Admission</b>
<li><b>Reentry</b>
</ol>  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A1800. Entered From</b><?php if (substr($url[3],0,5)!="print"){ if($A1800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page4-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:1.75em">
<table>
<tr>
<?php
switch($QA1800)
{
case "01":
$A1800a = "0";
$A1800b = "1";
break;
case "02":
$A1800a = "0";
$A1800b = "2";
break;
case "03":
$A1800a = "0";
$A1800b = "3";
break;
case "04":
$A1800a = "0";
$A1800b = "4";
break;
case "05":
$A1800a = "0";
$A1800b = "5";
break;
case "06":
$A1800a = "0";
$A1800b = "6";
break;
case "07":
$A1800a = "0";
$A1800b = "7";
break;
case "09":
$A1800a = "0";
$A1800b = "9";
break;
case "99":
$A1800a = "9";
$A1800b = "9";
}
?>
<td class="answer"><?php echo $A1800a; ?></td>
<td class="answer"><?php echo $A1800b; ?></td>
</tr>
</table>
</div>
</td>
<td class="page4-partwhite">
<ol class="page4-ol-zero" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Community</b> (private home/apt., board/care, assisted living, group home)
<li><b>Another nursing home or swing bed</b>
<li><b>Acute hospital</b>
<li><b>Psychiatric hospital</b>
<li><b>Inpatient rehabilitation facility</b>
<li><b>ID/DD facility</b>
<li><b>Hospice</b>
<li value="09"><b>Long Term Care Hospital</b> (LTCH)
<li value="99"><b>Other</b>
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A1900. Admission Date (Date this episode of care in this facility began)</b><?php if (substr($url[3],0,5)!="print"){ if($A1900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page4-content" style="width:5.875em"></td>
<td style="width:50em">
<div style="padding-left:2em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA1900_1; ?></td>
<td class="answer"><?php echo $QA1900_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA1900_3; ?></td>
<td class="answer"><?php echo $QA1900_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA1900_5; ?></td>
<td class="answer"><?php echo $QA1900_6; ?></td>
<td class="answer"><?php echo $QA1900_7; ?></td>
<td class="answer"><?php echo $QA1900_8; ?></td>
</table>
</div>
<a style="padding-left:1.65em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="page4-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A2000. Discharge Date</b><?php if (substr($url[3],0,5)!="print"){ if($A2000_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br><a style="padding-left:0.3125em">Complete only if A0310F = 10, 11, or 12</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page4-content"></td>
<td class="page4-partwhite">
<div style="padding-left:2em; margin:0.1875em">
<table cellspacing="0">
<td class="answer"><?php echo $QA2000_1; ?></td>
<td class="answer"><?php echo $QA2000_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2000_3; ?></td>
<td class="answer"><?php echo $QA2000_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QA2000_5; ?></td>
<td class="answer"><?php echo $QA2000_6; ?></td>
<td class="answer"><?php echo $QA2000_7; ?></td>
<td class="answer"><?php echo $QA2000_8; ?></td>
</table>
</div>
<a style="padding-left:1.65em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.3em">Year</a>
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