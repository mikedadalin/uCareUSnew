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
$sql = "SELECT * FROM `mdsform40` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page40_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page40_Qfiller_name .= $v;
		}else{}
	}
}
}
$page40_Qfiller_name = str_replace(';',', ', $page40_Qfiller_name);
?>
<body class="page40-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page40_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page40-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0100. Medicare Part A Billing</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page40-content" style="border-bottom-style:hidden; width:5.875em"></td> 
<td class="page40-partwhite" style="border-bottom-style:hidden; width:50em">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Medicare Part A HIPPS code</b><?php if (substr($url[3],0,5)!="print"){ if($Z0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (RUG group followed by assessment type indicator):
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0100A_1; ?></td>
<td class="answer"><?php echo $QZ0100A_2; ?></td>
<td class="answer"><?php echo $QZ0100A_3; ?></td>
<td class="answer"><?php echo $QZ0100A_4; ?></td>
<td class="answer"><?php echo $QZ0100A_5; ?></td>
<td class="answer"><?php echo $QZ0100A_6; ?></td>
<td class="answer"><?php echo $QZ0100A_7; ?></td>
</tr>
</table>
</ul>
</td>
</tr> 
<!-------------------------------------------->	 
<tr>
<td class="page40-content" style="border-top-style:hidden; border-bottom-style:hidden"></td> 
<td class="page40-partwhite" style="border-top-style:hidden; border-bottom-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">		
<li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0100B_1; ?></td>
<td class="answer"><?php echo $QZ0100B_2; ?></td>
<td class="answer"><?php echo $QZ0100B_3; ?></td>
<td class="answer"><?php echo $QZ0100B_4; ?></td>
<td class="answer"><?php echo $QZ0100B_5; ?></td>
<td class="answer"><?php echo $QZ0100B_6; ?></td>
<td class="answer"><?php echo $QZ0100B_7; ?></td>
<td class="answer"><?php echo $QZ0100B_8; ?></td>
<td class="answer"><?php echo $QZ0100B_9; ?></td>
<td class="answer"><?php echo $QZ0100B_10; ?></td>
</tr>
</table>	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page40-content" width="70" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QZ0100C; ?><?php if (substr($url[3],0,5)!="print"){ if($Z0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td> 
<td class="page40-partwhite" style="border-top-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">		
<li value="3"><b>Is this a Medicare Short Stay assessment?</b>
</ul>
<ol class="page40-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page40-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0150. Medicare Part A Non-Therapy Billing</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-content" rowspan="3"></td>
</tr>
<tr>
<td class="page40-partwhite" style="border-bottom-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Medicare Part A non-therapy HIPPS code</b><?php if (substr($url[3],0,5)!="print"){ if($Z0150A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> (RUG group followed by assessment type indicator):
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0150A_1; ?></td>
<td class="answer"><?php echo $QZ0150A_2; ?></td>
<td class="answer"><?php echo $QZ0150A_3; ?></td>
<td class="answer"><?php echo $QZ0150A_4; ?></td>
<td class="answer"><?php echo $QZ0150A_5; ?></td>
<td class="answer"><?php echo $QZ0150A_6; ?></td>
<td class="answer"><?php echo $QZ0150A_7; ?></td>
</tr>
</table>
</ul>
</td>
</tr> 
<!-------------------------------------------->	 
<tr> 
<td class="page40-partwhite" style="border-top-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0150B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0150B_1; ?></td>
<td class="answer"><?php echo $QZ0150B_2; ?></td>
<td class="answer"><?php echo $QZ0150B_3; ?></td>
<td class="answer"><?php echo $QZ0150B_4; ?></td>
<td class="answer"><?php echo $QZ0150B_5; ?></td>
<td class="answer"><?php echo $QZ0150B_6; ?></td>
<td class="answer"><?php echo $QZ0150B_7; ?></td>
<td class="answer"><?php echo $QZ0150B_8; ?></td>
<td class="answer"><?php echo $QZ0150B_9; ?></td>
<td class="answer"><?php echo $QZ0150B_10; ?></td>
</tr>
</table>
</ul>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page40-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0200. State Medicaid Billing (if required by the state)</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-content" rowspan="3"></td>
</tr>
<tr>
<td class="page40-partwhite" style="border-bottom-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>RUG Case Mix group:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0200A_1; ?></td>
<td class="answer"><?php echo $QZ0200A_2; ?></td>
<td class="answer"><?php echo $QZ0200A_3; ?></td>
<td class="answer"><?php echo $QZ0200A_4; ?></td>
<td class="answer"><?php echo $QZ0200A_5; ?></td>
<td class="answer"><?php echo $QZ0200A_6; ?></td>
<td class="answer"><?php echo $QZ0200A_7; ?></td>
<td class="answer"><?php echo $QZ0200A_8; ?></td>
<td class="answer"><?php echo $QZ0200A_9; ?></td>
<td class="answer"><?php echo $QZ0200A_10; ?></td>
</tr>
</table>
</ul>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-partwhite" style="border-top-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0200B_1; ?></td>
<td class="answer"><?php echo $QZ0200B_2; ?></td>
<td class="answer"><?php echo $QZ0200B_3; ?></td>
<td class="answer"><?php echo $QZ0200B_4; ?></td>
<td class="answer"><?php echo $QZ0200B_5; ?></td>
<td class="answer"><?php echo $QZ0200B_6; ?></td>
<td class="answer"><?php echo $QZ0200B_7; ?></td>
<td class="answer"><?php echo $QZ0200B_8; ?></td>
<td class="answer"><?php echo $QZ0200B_9; ?></td>
<td class="answer"><?php echo $QZ0200B_10; ?></td>
</tr>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page40-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0250. Alternate State Medicaid Billing (if required by the state)</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-content" rowspan="3"></td>
</tr>
<tr>
<td class="page40-partwhite" style="border-bottom-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>RUG Case Mix group:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0250A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0250A_1; ?></td>
<td class="answer"><?php echo $QZ0250A_2; ?></td>
<td class="answer"><?php echo $QZ0250A_3; ?></td>
<td class="answer"><?php echo $QZ0250A_4; ?></td>
<td class="answer"><?php echo $QZ0250A_5; ?></td>
<td class="answer"><?php echo $QZ0250A_6; ?></td>
<td class="answer"><?php echo $QZ0250A_7; ?></td>
<td class="answer"><?php echo $QZ0250A_8; ?></td>
<td class="answer"><?php echo $QZ0250A_9; ?></td>
<td class="answer"><?php echo $QZ0250A_10; ?></td>
</tr>
</table>
</ul>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-partwhite" style="border-top-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>RUG version code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0250B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0250B_1; ?></td>
<td class="answer"><?php echo $QZ0250B_2; ?></td>
<td class="answer"><?php echo $QZ0250B_3; ?></td>
<td class="answer"><?php echo $QZ0250B_4; ?></td>
<td class="answer"><?php echo $QZ0250B_5; ?></td>
<td class="answer"><?php echo $QZ0250B_6; ?></td>
<td class="answer"><?php echo $QZ0250B_7; ?></td>
<td class="answer"><?php echo $QZ0250B_8; ?></td>
<td class="answer"><?php echo $QZ0250B_9; ?></td>
<td class="answer"><?php echo $QZ0250B_10; ?></td>
</tr>
</table>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page40-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Z0300. Insurance Billing</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-content" rowspan="3"></td>
</tr>
<tr>
<td class="page40-partwhite" style="border-bottom-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>RUG billing code:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0300A_1; ?></td>
<td class="answer"><?php echo $QZ0300A_2; ?></td>
<td class="answer"><?php echo $QZ0300A_3; ?></td>
<td class="answer"><?php echo $QZ0300A_4; ?></td>
<td class="answer"><?php echo $QZ0300A_5; ?></td>
<td class="answer"><?php echo $QZ0300A_6; ?></td>
<td class="answer"><?php echo $QZ0300A_7; ?></td>
<td class="answer"><?php echo $QZ0300A_8; ?></td>
<td class="answer"><?php echo $QZ0300A_9; ?></td>
<td class="answer"><?php echo $QZ0300A_10; ?></td>
</tr>
</table>
</ul>		  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page40-partwhite" style="border-top-style:hidden">
<ul class="page40-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>RUG billing version:</b><?php if (substr($url[3],0,5)!="print"){ if($Z0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QZ0300B_1; ?></td>
<td class="answer"><?php echo $QZ0300B_2; ?></td>
<td class="answer"><?php echo $QZ0300B_3; ?></td>
<td class="answer"><?php echo $QZ0300B_4; ?></td>
<td class="answer"><?php echo $QZ0300B_5; ?></td>
<td class="answer"><?php echo $QZ0300B_6; ?></td>
<td class="answer"><?php echo $QZ0300B_7; ?></td>
<td class="answer"><?php echo $QZ0300B_8; ?></td>
<td class="answer"><?php echo $QZ0300B_9; ?></td>
<td class="answer"><?php echo $QZ0300B_10; ?></td>
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