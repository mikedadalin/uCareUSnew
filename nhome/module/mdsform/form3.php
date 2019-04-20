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
$sql = "SELECT * FROM `mdsform03` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== ¸Ñ START ==*/
	$LWJArray = array('QA1300A_1','QA1300A_2','QA1300A_3','QA1300A_4','QA1300A_5','QA1300A_6','QA1300A_7','QA1300A_8','QA1300A_9','QA1300A_10','QA1300A_11','QA1300A_12');
	$LWJdataArray = array($QA1300A_1,$QA1300A_2,$QA1300A_3,$QA1300A_4,$QA1300A_5,$QA1300A_6,$QA1300A_7,$QA1300A_8,$QA1300A_9,$QA1300A_10,$QA1300A_11,$QA1300A_12);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                ${$LWJArray[$i]} = ${$LWJArray[$i]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$i]} = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== ¸Ñ END ==*/
$Qfiller = explode("&",$Qfiller);
for($i=0;$i<count($Qfiller);$i++){
$sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$Qfiller[$i]."'";
$db2 = new DB2;
$db2->query($sql);
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		if((count($Qfiller)-$i)>2){
			$page3_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page3_Qfiller_name .= $v;
		}else{}
	}
}
}
$page3_Qfiller_name = str_replace(';',', ', $page3_Qfiller_name);
?>
<body class="page3-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page3_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page3-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A1100. Language</b></div></td>
</tr>
<!-------------------------------------------------------------------------->	
<tr>
<td class="page3-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA1100A; ?><?php if (substr($url[3],0,5)!="print"){ if($A1100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page3-partwhite">
<ul class="page3-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Does the resident need or want an interpreter to communicate with a doctor or health care staff?</b>
<ol class="page3-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No &#8594; </b>Skip to A1200, Marital Status
<li><b>Yes &#8594; </b>Specify in A1100B, Preferred language
<li value="9"><b>Unable to determine &#8594; </b>Skip to A1200, Marital Status
</ol>
<li><b>Preferred language:</b><?php if (substr($url[3],0,5)!="print"){ if($A1100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<td class="answer"><?php echo $QA1100B_1; ?></td>
<td class="answer"><?php echo $QA1100B_2; ?></td>
<td class="answer"><?php echo $QA1100B_3; ?></td>
<td class="answer"><?php echo $QA1100B_4; ?></td>
<td class="answer"><?php echo $QA1100B_5; ?></td>
<td class="answer"><?php echo $QA1100B_6; ?></td>
<td class="answer"><?php echo $QA1100B_7; ?></td>
<td class="answer"><?php echo $QA1100B_8; ?></td>
<td class="answer"><?php echo $QA1100B_9; ?></td>
<td class="answer"><?php echo $QA1100B_10; ?></td>
<td class="answer"><?php echo $QA1100B_11; ?></td>
<td class="answer"><?php echo $QA1100B_12; ?></td>
<td class="answer"><?php echo $QA1100B_13; ?></td>
<td class="answer"><?php echo $QA1100B_14; ?></td>
<td class="answer"><?php echo $QA1100B_15; ?></td>
</table>
</ul>
</td>
</tr>	
<!-------------------------------------------------------------------------->
<tr>
<td class="page3-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A1200. Marital Status</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page3-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA1200; ?><?php if (substr($url[3],0,5)!="print"){ if($A1200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page3-partwhite">
<ol class="page3-ol" style="margin-top:0.1875em; margin-bottom:0.1875em; padding-left:3.3em">
<li><b>Never married</b>
<li><b>Married</b>
<li><b>Widowed</b>
<li><b>Separated</b>
<li><b>Divorced</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page3-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>A1300. Optional Resident Items</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page3-content"></td>
<td class="page3-partwhite">
<ul class="page3-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Medical record number:</b><?php if (substr($url[3],0,5)!="print"){ if($A1300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA1300A_1; ?></td>
<td class="answer"><?php echo $QA1300A_2; ?></td>
<td class="answer"><?php echo $QA1300A_3; ?></td>
<td class="answer"><?php echo $QA1300A_4; ?></td>
<td class="answer"><?php echo $QA1300A_5; ?></td>
<td class="answer"><?php echo $QA1300A_6; ?></td>
<td class="answer"><?php echo $QA1300A_7; ?></td>
<td class="answer"><?php echo $QA1300A_8; ?></td>
<td class="answer"><?php echo $QA1300A_9; ?></td>
<td class="answer"><?php echo $QA1300A_10; ?></td>
<td class="answer"><?php echo $QA1300A_11; ?></td>
<td class="answer"><?php echo $QA1300A_12; ?></td>
</table>
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Room number:</b><?php if (substr($url[3],0,5)!="print"){ if($A1300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA1300B_1; ?></td>
<td class="answer"><?php echo $QA1300B_2; ?></td>
<td class="answer"><?php echo $QA1300B_3; ?></td>
<td class="answer"><?php echo $QA1300B_4; ?></td>
<td class="answer"><?php echo $QA1300B_5; ?></td>
<td class="answer"><?php echo $QA1300B_6; ?></td>
<td class="answer"><?php echo $QA1300B_7; ?></td>
<td class="answer"><?php echo $QA1300B_8; ?></td>
<td class="answer"><?php echo $QA1300B_9; ?></td>
<td class="answer"><?php echo $QA1300B_10; ?></td>
</table>
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Name by which resident prefers to be addressed:</b><?php if (substr($url[3],0,5)!="print"){ if($A1300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA1300C_1; ?></td>
<td class="answer"><?php echo $QA1300C_2; ?></td>
<td class="answer"><?php echo $QA1300C_3; ?></td>
<td class="answer"><?php echo $QA1300C_4; ?></td>
<td class="answer"><?php echo $QA1300C_5; ?></td>
<td class="answer"><?php echo $QA1300C_6; ?></td>
<td class="answer"><?php echo $QA1300C_7; ?></td>
<td class="answer"><?php echo $QA1300C_8; ?></td>
<td class="answer"><?php echo $QA1300C_9; ?></td>
<td class="answer"><?php echo $QA1300C_10; ?></td>
<td class="answer"><?php echo $QA1300C_11; ?></td>
<td class="answer"><?php echo $QA1300C_12; ?></td>
<td class="answer"><?php echo $QA1300C_13; ?></td>
<td class="answer"><?php echo $QA1300C_14; ?></td>
<td class="answer"><?php echo $QA1300C_15; ?></td>
<td class="answer"><?php echo $QA1300C_16; ?></td>
<td class="answer"><?php echo $QA1300C_17; ?></td>
<td class="answer"><?php echo $QA1300C_18; ?></td>
<td class="answer"><?php echo $QA1300C_19; ?></td>
<td class="answer"><?php echo $QA1300C_20; ?></td>
<td class="answer"><?php echo $QA1300C_21; ?></td>
<td class="answer"><?php echo $QA1300C_22; ?></td>
<td class="answer"><?php echo $QA1300C_23; ?></td>
</table>
<li style="margin-top:0.1875em; margin-bottom:0.1875em"><b>Lifetime occupation(s)</b>- put "/" between two occupations:<?php if (substr($url[3],0,5)!="print"){ if($A1300D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<td class="answer"><?php echo $QA1300D_1; ?></td>
<td class="answer"><?php echo $QA1300D_2; ?></td>
<td class="answer"><?php echo $QA1300D_3; ?></td>
<td class="answer"><?php echo $QA1300D_4; ?></td>
<td class="answer"><?php echo $QA1300D_5; ?></td>
<td class="answer"><?php echo $QA1300D_6; ?></td>
<td class="answer"><?php echo $QA1300D_7; ?></td>
<td class="answer"><?php echo $QA1300D_8; ?></td>
<td class="answer"><?php echo $QA1300D_9; ?></td>
<td class="answer"><?php echo $QA1300D_10; ?></td>
<td class="answer"><?php echo $QA1300D_11; ?></td>
<td class="answer"><?php echo $QA1300D_12; ?></td>
<td class="answer"><?php echo $QA1300D_13; ?></td>
<td class="answer"><?php echo $QA1300D_14; ?></td>
<td class="answer"><?php echo $QA1300D_15; ?></td>
<td class="answer"><?php echo $QA1300D_16; ?></td>
<td class="answer"><?php echo $QA1300D_17; ?></td>
<td class="answer"><?php echo $QA1300D_18; ?></td>
<td class="answer"><?php echo $QA1300D_19; ?></td>
<td class="answer"><?php echo $QA1300D_20; ?></td>
<td class="answer"><?php echo $QA1300D_21; ?></td>
<td class="answer"><?php echo $QA1300D_22; ?></td>
<td class="answer"><?php echo $QA1300D_23; ?></td>
</table>
</ul>			  
</td>
</tr> 
<!-------------------------------------------------------------------------->	  
<tr>
<td class="page3-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A1500. Preadmission Screening and Resident Review (PASRR)</b>
<br><a style="padding-left:0.3125em">Complete only if A0310A = 01, 03, 04, or 05</a></div>
</td>
</tr>
<!--------------------------------------------------------------------------> 
<tr>
<td class="page3-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QA1500; ?><?php if (substr($url[3],0,5)!="print"){ if($A1500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page3-partwhite">
<b style="padding-left:0.3125em">Is the resident currently considered by the state level II PASRR process to have serious mental illness </b><br><b style="padding-left:0.3125em"> and/or intellectual disability("mental retardation" in federal regulation) or a related condition?</b>
<ol class="page3-ol" start="0" style="padding-left:3em">
<li><b>No &#8594; </b>Skip to A1550, Conditions Related to ID/DD Status
<li><b>Yes &#8594; </b>Continue to A1510, Level II Preadmission Screening and Resident Review (PASRR) Conditions.
<li value="9"><b>Not a Medicaid certified unit &#8594; </b>Skip to A1550, Conditions Related to ID/DD Status
</ol>	  
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page3-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">A1510. Level II Preadmission Screening and Resident Review (PASRR) Conditions</b><?php if (substr($url[3],0,5)!="print"){ if($A1510_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<br><a style="padding-left:0.3125em">Complete only if A0310A = 01, 03, 04, or 05</a></div>
</td>
</tr>
<!-------------------------------------------------------------------------->	  
<tr>
<td class="page3-partwhite" colspan="2">
<b style="padding-left:2.7em">&#8595; Check all that apply</b>
</td>
</tr>
<!-------------------------------------------------------------------------->
<tr>
<td class="page3-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1510A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page3-partwhite">
<ul class="page3-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Serious mental illness</b>
</ul>
</td>
</tr>
<tr>
<td class="page3-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1510B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page3-partwhite">
<ul class="page3-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Intellectual Disability ("mental retardation" in federal regulation)</b>
</ul>
</td>
</tr>
<tr>
<td class="page3-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QA1510C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page3-partwhite">
<ul class="page3-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Other related conditions</b>
</ul>
</td>
</tr>
<!-------------------------------------------------------------------------->	  
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