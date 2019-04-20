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
$sql = "SELECT * FROM `mdsform21` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page21_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page21_Qfiller_name .= $v;
		}else{}
	}
}
}
$page21_Qfiller_name = str_replace(';',', ', $page21_Qfiller_name);
?>
<body class="page21-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page21_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section J</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Health Conditions</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" border="10" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J0700. Should the Staff Assessment for Pain be Conducted?</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QJ0700; ?><?php if (substr($url[3],0,5)!="print"){ if($J0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page21-ol" start="0">
<li><b>No</b> (J0400 = 1 thru 4) &#8594; Skip to J1100, Shortness of Breath (dyspnea)
<li><b>Yes</b> (J0400 = 9) &#8594; Continue to J0800, Indicators of Pain or Possible Pain
</ol></div>
</td>
</tr>
</table>  
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Staff Assessment for Pain</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J0800. Indicators of Pain or Possible Pain</b> in the last 5 days<?php if (substr($url[3],0,5)!="print"){ if($J0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ0800A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite" style="width:50em">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Non-verbal sounds</b> (e.g., crying, whining, gasping, moaning, or groaning)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ0800B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Vocal complaints of pain</b> (e.g., that hurts, ouch, stop)
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ0800C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Facial expressions</b> (e.g., grimaces, winces, wrinkled forehead, furrowed brow, clenched teeth or jaw)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ0800D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Protective body movements or postures</b> (e.g., bracing, guarding, rubbing or massaging a body <br>part/area, clutching or holding a body part during movement)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ0800Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of these signs observed or documented &#8594; </b>If checked, skip to J1100, Shortness of Breath <br>(dyspnea)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J0850. Frequency of Indicator of Pain or Possible Pain</b> in the last 5 days</div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ0850; ?><?php if (substr($url[3],0,5)!="print"){ if($J0850_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Frequency with which resident complains or shows evidence of pain or possible pain</a>
<ol class="page21-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Indicators of pain</b> or possible pain observed <b>1 to 2 days</b>
<li><b>Indicators of pain</b> or possible pain observed <b>3 to 4 days</b>
<li><b>Indicators of pain</b> or possible pain observed <b>daily</b>
</ol></div>			
</td>
</tr>	
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Other Health Conditions</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1100. Shortness of Breath (dyspnea)</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1100A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite" style="width:50em">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Shortness of breath</b> or trouble breathing <b>with exertion</b> (e.g., walking, bathing, transferring)			
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1100B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Shortness of breath</b> or trouble breathing <b>when sitting at rest</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1100C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Shortness of breath</b> or trouble breathing <b>when lying flat</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1100Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>
</ul>
</td>
<!-------------------------------------------->
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1300. Current Tobacco Use</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1300; ?><?php if (substr($url[3],0,5)!="print"){ if($J1300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Tobacco use</b>
<ol class="page21-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1400. Prognosis</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QJ1400; ?><?php if (substr($url[3],0,5)!="print"){ if($J1400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Does the resident have a condition or chronic disease that may result in a <b>life expectancy of less than 6 </b><br><b style="padding-left:0.3125em">months?</b> (Requires physician documentation)</a>
<ol class="page21-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>J1550. Problem Conditions</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page21-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1550A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Fever</b>
</ul>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1550B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Vomiting</b>
</ul>		
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1550C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Dehydrated</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1550D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Internal bleeding</b>
</ul>	
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page21-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QJ1550Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page21-partwhite">
<ul class="page21-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>
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