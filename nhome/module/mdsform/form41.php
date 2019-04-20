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
$sql = "SELECT * FROM `mdsform41` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page41_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page41_Qfiller_name .= $v;
		}else{}
	}
}
}
$page41_Qfiller_name = str_replace(';',', ', $page41_Qfiller_name);
?>
<body class="page41-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page41_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section Z</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Assessment Administration</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page41-part" colspan="5"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0400. Signature of Persons Completing the Assessment or Entry/Death Reporting</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page41-content" width="20" rowspan="15"></td>
</tr>
<tr>
<td class="page41-partwhite" width="844" colspan="4"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">I certify that the accompanying information accurately reflects resident assessment information for this resident and </a><br><a style="padding-left:0.3125em">that I collected or coordinated collection of this information on the dates specified. To the best of my knowledge, this </a><br><a style="padding-left:0.3125em">information was collected in accordance with applicable Medicare and Medicaid requirements. I understand that this </a><br><a style="padding-left:0.3125em">information is used as a basis for ensuring that residents receive appropriate and quality care, and as a basis for </a><br><a style="padding-left:0.3125em">payment from federal funds. I further understand that payment of such federal funds and continued participation in the </a><br><a style="padding-left:0.3125em">government-funded health care programs is conditioned on the accuracy and truthfulness of this information, and that </a><br><a style="padding-left:0.3125em">I may be personally subject to or may subject my organization to substantial criminal, civil, and/or administrative </a><br><a style="padding-left:0.3125em">penalties for submitting false information. I also certify that I am authorized to submit this information by this facility on </a><br><a style="padding-left:0.3125em">its behalf.</a></div>
</td>
</tr> 
<!-------------------------------------------->	 
<tr> 
<td class="page41-partwhite" width="294" align="center">
<div style="padding-left:6.5em">
<table>
<tr><td>&nbsp </td></tr>
<tr>
<td>
<b>Signature</b>
</td>
</tr>
<tr><td>&nbsp </td></tr>
</table>
</div>
</td>
<td class="page41-partwhite" width="200" align="center">
<div style="padding-left:5em">
<table>
<tr><td>&nbsp </td></tr>
<tr>
<td>
<b>Title</b>
</td>
</tr>
<tr><td>&nbsp </td></tr>
</table>
</div>
</td>
<td class="page41-partwhite" width="200" align="center">
<div style="padding-left:4em">
<table>
<tr><td>&nbsp </td></tr>
<tr>
<td>
<b>Sections</b>
</td>
</tr>
<tr><td>&nbsp </td></tr>
</table>
</div>
</td>
<td class="page41-partwhite" style="width:10.125em" align="center">
<div style="padding-left:3em">
<table>
<tr><td>&nbsp </td></tr>
<tr>
<td>
<b>Date Section <br>Completed</b>
</td>
</tr>
<tr><td>&nbsp </td></tr>
</table>
</div>
</td>
</tr> 
<!-------------------------------------------->
<tr>
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li><?php echo $QZ0400A; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400A1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400A2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400A3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="2"><?php echo $QZ0400B; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400B1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400B2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400B3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="3"><?php echo $QZ0400C; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400C1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400C2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400C3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="4"><?php echo $QZ0400D; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400D1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400D2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400D3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="5"><?php echo $QZ0400E; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400E1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400E2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400E3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="6"><?php echo $QZ0400F; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400F1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400F2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400F3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="7"><?php echo $QZ0400G; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400G1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400G2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400G3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="8"><?php echo $QZ0400H; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400H1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400H2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400H3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="9"><?php echo $QZ0400I; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400I1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400I_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400I2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400I3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="10"><?php echo $QZ0400J; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400J1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400J_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400J2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400J3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="11"><?php echo $QZ0400K; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400K1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400K_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400K2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400K3; ?></td>
</tr> 
<!-------------------------------------------->
<tr> 
<td class="page41-partwhite" align="left">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="12"><?php echo $QZ0400L; ?></ul>
</td>
<td class="page41-partwhite" style="text-align:center; padding-left:0.3125em"><?php echo $QZ0400L1; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0400L_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400L2; ?></td>
<td class="page41-partwhite" style="text-align:center"><?php echo $QZ0400L3; ?></td>
</tr> 
<!-------------------------------------------->
<tr>
<td class="page41-part" colspan="5"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0500. Signature of RN Assessment Coordinator Verifying Assessment Completion</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page41-content"></td>
<td align="left" colspan="2" style="border-right-style:hidden">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li><b>Signature:</b></ul>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a style="font-size:25px"><?php echo $QZ0500A; ?></a>
</td>
<td align="left" colspan="2" style="border-left-style:hidden">
<ul class="page41-ul" style="margin-top:0.1875em; margin-bottom:0.1875em"><li value="2"><b>Date RN Assessment Coordinator signed <br>assessment as complete:</b>
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0500B_1; ?></td>
<td class="answer"><?php echo $QZ0500B_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QZ0500B_3; ?></td>
<td class="answer"><?php echo $QZ0500B_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QZ0500B_5; ?></td>
<td class="answer"><?php echo $QZ0500B_6; ?></td>
<td class="answer"><?php echo $QZ0500B_7; ?></td>
<td class="answer"><?php echo $QZ0500B_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</ul>
</td>
</tr> 
</table>
<!-------------------------------------------->
<p style="font-size:0.8em; padding-left:15px"><b>Legal Notice Regarding MDS 3.0</b> - Copyright 2011 United States of America and InterRAI. This work may be freely <br>used and distributed solely within the United States. Portions of the MDS 3.0 are under separate copyright protections; <br>Pfizer Inc. holds the copyright for the PHQ-9 and the Annals of Internal Medicine holds the copyright for the CAM. Both <br>Pfizer Inc. and the Annals of Internal Medicine have granted permission to freely use these instruments in association <br>with the MDS 3.0.</p>
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