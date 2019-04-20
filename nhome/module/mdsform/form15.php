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
$sql = "SELECT * FROM `mdsform15` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page15_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page15_Qfiller_name .= $v;
		}else{}
	}
}
}
$page15_Qfiller_name = str_replace(';',', ', $page15_Qfiller_name);
?>
<body class="page15-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page15_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section G</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Functional Status</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page15-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>G0110. Activities of Daily Living (ADL) Assistance</b><br><a>Refer to the ADL flow chart in the RAI manual to facilitate accurate coding</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Instructions for Rule of 3</b>
<ul class="page15-ul-square">
<li>When an activity occurs three times at any one given level, code that level.
<li>When an activity occurs three times at multiple levels, code the most dependent, exceptions are total dependence <br>(4), activity must require full assist every time, and activity did not occur (8), activity must not have occurred at all. <br>Example, three times extensive assistance (3) and three times limited assistance (2), code extensive assistance (3).
<li>When an activity occurs at various levels, but not three times at any given level, apply the following:
<ul class="page15-ul-circle">
<li>When there is a combination of full staff performance, and extensive assistance, code extensive assistance.
<li>When there is a combination of full staff performance, weight bearing assistance and/or non-weight bearing assistance code limited assistance (2).
</ul>
</ul>
<b style="padding-left:0.3125em">If none of the above are met, code supervision.</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-content2" colspan="1" style="border-right-style:hidden; border-bottom-style:hidden; width:35.625em">
<ol class="page15-ol" style="margin-top:0.1875em; margin-bottom:0.1875em;">
<li><b>ADL Self-Performance</b><br>Code for <b>resident's performance</b> over all shifts - not including setup. <br>If the ADL activity occurred 3 or more times at various levels of <br>assistance, code the most dependent - except for total dependence, <br>which requires full staff performance every time
</ol> 
</td>
<td class="page15-content2" colspan="2" style="border-left-style:hidden; border-bottom-style:hidden; width:20.25em">
<ol class="page15-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>ADL Support Provided</b><br>Code for <b>most support provided </b>over <br>all shifts; code regardless of resident's <br>self-performance classification
</ol>
</td>
</tr>
<tr>
<td class="page15-content2" colspan="1" rowspan="3" style="border-top-style:hidden; border-right-style:hidden;"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page15-ol" start="0" style="padding-left:3em; margin-top:0.1875em; margin-bottom:0.1875em">
<u><b>Activity Occurred 3 or More Times</b></u>
<li><b>Independent</b> - no help or staff oversight at any time
<li><b>Supervision</b> - oversight, encouragement or cueing
<li><b>Limited assistance</b> - resident highly involved in activity; staff provide <br>guided maneuvering of limbs or other non-weight-bearing assistance
<li><b>Extensive assistance</b> - resident involved in activity, staff provide <br>weight-bearing support
<li><b>Total dependence</b> - full staff performance every time during entire 7-day period
<br><u><b>Activity Occurred 2 or Fewer Times</b></u>
<li value="7"><b>Activity occurred only once or twice</b> - activity did occur but only once or twice
<li><b>Activity did not occur</b> - activity (or any part of the ADL) was not <br>performed by resident or staff at all over the entire 7-day period
</ol></div>
</td>
<td class="page15-content2" colspan="2" style="border-top-style:hidden; border-left-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page15-ol" start="0" style="padding-left:3em; margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b> setup or physical help from staff
<li><b>Setup</b> help only
<li><b>One</b> person physical assist
<li><b>Two+</b> persons physical assist
<li value="8">ADL activity itself <b>did not occur</b> or <br>family and/or non-facility staff <br>provided care 100% of the time for <br>that activity over the entire 7-day <br>period
</ol></div>
</td>
</tr>
<tr>
<td class="page15-content" colspan="1" style="width:10.125em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>1.<br>Self-Performance</b></div>
</td>
<td class="page15-content" colspan="1" style="width:10.125em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>2.<br>Support</b></div>
</td>
</tr>
<tr>
<td class="page15-partwhite2" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>&#8595; Enter Codes in Boxes &#8595;</b></div>
</td>
</tr>  
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Bed mobility</b> - how resident moves to and from lying position, turns <br>side to side, and positions body while in bed or alternate sleep furniture  
</ul>
</td>
<td class="page15-content" style="border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110A1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110A2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Transfer</b> - how resident moves between surfaces including to or from: <br>bed, chair, wheelchair, standing position (<b>excludes</b> to/from bath/toilet)  
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110B1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110B2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Walk in room</b> - how resident walks between locations in his/her room
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110C1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110C2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Walk in corridor</b> - how resident walks in corridor on unit  
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110D1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110D2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Locomotion on unit</b> - how resident moves between locations in his/her <br>room and adjacent corridor on same floor. If in wheelchair, self-sufficiency <br>once in chair  
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110E1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110E2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Locomotion off unit</b> - how resident moves to and returns from off-unit <br>locations (e.g., areas set aside for dining, activities or treatments). <b>If <br>facility has only one floor,</b> how resident moves to and from distant <br>areas on the floor. If in wheelchair, self-sufficiency once in chair  
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110F1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110F2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Dressing</b> - how resident puts on, fastens and takes off all items of <br>clothing, including donning/removing a prosthesis or TED hose. <br>Dressing includes putting on and changing pajamas and housedresses
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110G1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110G2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Eating</b> - how resident eats and drinks, regardless of skill. Do not <br>include eating/drinking during medication pass. Includes intake of <br>nourishment by other means (e.g., tube feeding, total parenteral <br>nutrition, IV fluids administered for nutrition or hydration)  
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110H1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110H1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110H2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110H2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b>Toilet use</b> - how resident uses the toilet room, commode, bedpan, or <br>urinal; transfers on/off toilet; cleanses self after elimination; changes pad; <br>manages ostomy or catheter; and adjusts clothes. <br>Do not include emptying of bedpan, urinal, bedside commode, <br>catheter bag or ostomy bag
</ul>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110I1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110I1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110I2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110I2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page15-partwhite">
<ul class="page15-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="10"><b>Personal hygiene</b> - how resident maintains personal hygiene, <br>including combing hair, brushing teeth, shaving, applying makeup, <br>washing/drying face and hands (<b>excludes</b> baths and showers)
</ul>
</td>
<td class="page15-content" style="border-top-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110J1; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110J1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page15-content" style="border-top-style:hidden">
<div style="padding-left:4.525em">
<table>
<tr>
<td class="answer"><?php echo $QG0110J2; ?><?php if (substr($url[3],0,5)!="print"){ if($G0110J2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
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