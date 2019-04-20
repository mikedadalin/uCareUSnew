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
$sql = "SELECT * FROM `mdsform19` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page19_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page19_Qfiller_name .= $v;
		}else{}
	}
}
}
$page19_Qfiller_name = str_replace(';',', ', $page19_Qfiller_name);
?>
<body class="page19-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page19_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section I</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Active Diagnoses</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page19-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Active Diagnoses in the last 7 days - Check all that apply</b><br><a>Diagnoses listed in parentheses are provided as examples and should not be considered as all-inclusive lists</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-bottom-style:hidden; width:4.875em"></td>
<td class="page19-part" style="width:51em"><b>Neurological - Continued</b></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI4900; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I4900. Hemiplegia or Hemiparesis</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5000; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5000. Paraplegia</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5100. Quadriplegia</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5200. Multiple Sclerosis (MS)</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5250; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5250. Huntington's Disease</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5300. Parkinson's Disease</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5350; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5350. Tourette's Syndrome</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5400; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5400. Seizure Disorder or Epilepsy</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5500; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5500. Traumatic Brain Injury (TBI)</b>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page19-part"><b>Nutritional</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5600; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5600. Malnutrition</b> (protein or calorie) or at risk for malnutrition
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page19-part"><b>Psychiatric/Mood Disorder</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5700; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5700. Anxiety Disorder</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5800; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5800. Depression</b> (other than bipolar)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5900; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5900. Manic Depression</b> (bipolar disease)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI5950; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I5950. Psychotic Disorder</b> (other than schizophrenia)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI6000; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I6000. Schizophrenia</b> (e.g., schizoaffective and schizophreniform disorders)
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI6100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I6100. Post Traumatic Stress Disorder (PTSD)</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page19-part"><b>Pulmonary</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI6200; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I6200. Asthma, Chronic Obstructive Pulmonary Disease (COPD), or Chronic Lung Disease</b> (e.g., chronic <br><a style="padding-left:3.4em">bronchitis and restrictive lung diseases such as asbestosis)</a>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI6300; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I6300. Respiratory Failure</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page19-part"><b>Vision</b></td>
</tr>	  
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI6500; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I6500. Cataracts, Glaucoma, or Macular Degeneration</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page19-part"><b>None of Above</b></td>
</tr>	 
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QI7900; ?></td>
</tr>
</table>
</div>
</td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I7900. None of the above active diagnoses</b> within the last 7 days
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page19-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page19-part"><b>Other</b></td>
</tr>	 
<!-------------------------------------------->
<tr> 
<td class="page19-content" style="border-top-style:hidden"></td>
<td class="page19-partwhite">
<b style="padding-left:0.3125em">I8000. Additional active diagnoses</b><br><a style="padding-left:0.3125em">Enter diagnosis on line and ICD code in boxes. Include the decimal for the code in the appropriate box.</a>  
<ul class="page19-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000A_1; ?></td>
<td class="answer"><?php echo $QI8000A_2; ?></td>
<td class="answer"><?php echo $QI8000A_3; ?></td>
<td class="answer"><?php echo $QI8000A_4; ?></td>
<td class="answer"><?php echo $QI8000A_5; ?></td>
<td class="answer"><?php echo $QI8000A_6; ?></td>
<td class="answer"><?php echo $QI8000A_7; ?></td>
<td class="answer"><?php echo $QI8000A_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000A_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Atext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000B_1; ?></td>
<td class="answer"><?php echo $QI8000B_2; ?></td>
<td class="answer"><?php echo $QI8000B_3; ?></td>
<td class="answer"><?php echo $QI8000B_4; ?></td>
<td class="answer"><?php echo $QI8000B_5; ?></td>
<td class="answer"><?php echo $QI8000B_6; ?></td>
<td class="answer"><?php echo $QI8000B_7; ?></td>
<td class="answer"><?php echo $QI8000B_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000B_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Btext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000C_1; ?></td>
<td class="answer"><?php echo $QI8000C_2; ?></td>
<td class="answer"><?php echo $QI8000C_3; ?></td>
<td class="answer"><?php echo $QI8000C_4; ?></td>
<td class="answer"><?php echo $QI8000C_5; ?></td>
<td class="answer"><?php echo $QI8000C_6; ?></td>
<td class="answer"><?php echo $QI8000C_7; ?></td>
<td class="answer"><?php echo $QI8000C_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000C_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Ctext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000D_1; ?></td>
<td class="answer"><?php echo $QI8000D_2; ?></td>
<td class="answer"><?php echo $QI8000D_3; ?></td>
<td class="answer"><?php echo $QI8000D_4; ?></td>
<td class="answer"><?php echo $QI8000D_5; ?></td>
<td class="answer"><?php echo $QI8000D_6; ?></td>
<td class="answer"><?php echo $QI8000D_7; ?></td>
<td class="answer"><?php echo $QI8000D_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000D_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Dtext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000E_1; ?></td>
<td class="answer"><?php echo $QI8000E_2; ?></td>
<td class="answer"><?php echo $QI8000E_3; ?></td>
<td class="answer"><?php echo $QI8000E_4; ?></td>
<td class="answer"><?php echo $QI8000E_5; ?></td>
<td class="answer"><?php echo $QI8000E_6; ?></td>
<td class="answer"><?php echo $QI8000E_7; ?></td>
<td class="answer"><?php echo $QI8000E_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000E_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Etext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000F_1; ?></td>
<td class="answer"><?php echo $QI8000F_2; ?></td>
<td class="answer"><?php echo $QI8000F_3; ?></td>
<td class="answer"><?php echo $QI8000F_4; ?></td>
<td class="answer"><?php echo $QI8000F_5; ?></td>
<td class="answer"><?php echo $QI8000F_6; ?></td>
<td class="answer"><?php echo $QI8000F_7; ?></td>
<td class="answer"><?php echo $QI8000F_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000F_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Ftext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000G_1; ?></td>
<td class="answer"><?php echo $QI8000G_2; ?></td>
<td class="answer"><?php echo $QI8000G_3; ?></td>
<td class="answer"><?php echo $QI8000G_4; ?></td>
<td class="answer"><?php echo $QI8000G_5; ?></td>
<td class="answer"><?php echo $QI8000G_6; ?></td>
<td class="answer"><?php echo $QI8000G_7; ?></td>
<td class="answer"><?php echo $QI8000G_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000G_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Gtext; ?><hr color="black" align="left" width="73%" size="1">		    
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000H_1; ?></td>
<td class="answer"><?php echo $QI8000H_2; ?></td>
<td class="answer"><?php echo $QI8000H_3; ?></td>
<td class="answer"><?php echo $QI8000H_4; ?></td>
<td class="answer"><?php echo $QI8000H_5; ?></td>
<td class="answer"><?php echo $QI8000H_6; ?></td>
<td class="answer"><?php echo $QI8000H_7; ?></td>
<td class="answer"><?php echo $QI8000H_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000H_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Htext; ?><hr color="black" align="left" width="73%" size="1">
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000I_1; ?></td>
<td class="answer"><?php echo $QI8000I_2; ?></td>
<td class="answer"><?php echo $QI8000I_3; ?></td>
<td class="answer"><?php echo $QI8000I_4; ?></td>
<td class="answer"><?php echo $QI8000I_5; ?></td>
<td class="answer"><?php echo $QI8000I_6; ?></td>
<td class="answer"><?php echo $QI8000I_7; ?></td>
<td class="answer"><?php echo $QI8000I_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000I_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Itext; ?><hr color="black" align="left" width="73%" size="1">
<table cellspacing="0" align="right">
<td class="answer"><?php echo $QI8000J_1; ?></td>
<td class="answer"><?php echo $QI8000J_2; ?></td>
<td class="answer"><?php echo $QI8000J_3; ?></td>
<td class="answer"><?php echo $QI8000J_4; ?></td>
<td class="answer"><?php echo $QI8000J_5; ?></td>
<td class="answer"><?php echo $QI8000J_6; ?></td>
<td class="answer"><?php echo $QI8000J_7; ?></td>
<td class="answer"><?php echo $QI8000J_8; ?></td>
<?php if (substr($url[3],0,5)!="print"){ if($I8000J_Red=="0"){echo '<td><b><a style="font-size:23px; color:red">&#8727</a></b></td>';} }?>
</table>
<li class="page19-li-answer"><?php echo $QI8000Jtext; ?><hr color="black" align="left" width="73%" size="1">
</ul>
</td>
</tr>	  
</table>
<!-------------------------------------------->
<a style="font-size:1em">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</a>
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