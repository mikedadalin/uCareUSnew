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
$sql = "SELECT * FROM `mdsform28` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page28_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page28_Qfiller_name .= $v;
		}else{}
	}
}
}
$page28_Qfiller_name = str_replace(';',', ', $page28_Qfiller_name);
?>
<body class="page28-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page28_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section N</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Medications</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page28-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>N0300. Injections</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="width:5.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0300; ?><?php if (substr($url[3],0,5)!="print"){ if($N0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Record the number of days that injections of any type</b> were received during the last 7 days or since <br><a style="padding-left:0.3125em">admission/entry or reentry if less than 7 days. If 0 &#8594; Skip to N0410, Medications Received</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page28-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>N0350. Insulin</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0350A; ?><?php if (substr($url[3],0,5)!="print"){ if($N0350A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Insulin injections - Record the number of days that insulin injections</b> were received during the last 7 <br>days or since admission/entry or reentry if less than 7 days	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0350B; ?><?php if (substr($url[3],0,5)!="print"){ if($N0350B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Orders for insulin - Record the number of days the physician (or authorized assistant or <br>practitioner) changed the resident's insulin orders</b> during the last 7 days or since admission/entry or <br>reentry if less than 7 days
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page28-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>N0410. Medications Received</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page28-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:1em">Indicate the number of DAYS the resident received the following medications during the last 7 days or since </b><br><b style="padding-left:1em">admission/entry or reentry if less than 7 days.</b> Enter "0" if medication was not received by the resident during the last </b><b style="padding-left:1em">7 days</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410A; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Antipsychotic</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410B; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Antianxiety</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410C; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Antidepressant</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410D; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Hypnotic</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410E; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Anticoagulant</b> (warfarin, heparin, or low-molecular weight heparin)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410F; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Antibiotic</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page28-content" style="border-top-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QN0410G; ?><?php if (substr($url[3],0,5)!="print"){ if($N0410G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page28-partwhite">
<ul class="page28-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Diuretic</b>		  
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