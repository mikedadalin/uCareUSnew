<?php
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
?>
<style>
body {font-family:sans-serif; line-height:15px; font-size:9px}
table.bordercolor {border-color:rgb(113,113,99); background-color:rgb(255,255,255);}
td.section {background-color:rgb(113,113,99); color:white; font-size:14px; padding-left:5px}
td.section2 {background-color:rgb(230,230,226); font-size:14px}
td.answer {background-color:rgb(221,228,255); border:1px solid black; width:20px; height:20px; text-align:center}
td.part {background-color:rgb(230,230,226); height:20px; text-align:left; padding-left:5px}
td.partwhite {background-color:rgb(255,255,255); height:20px; text-align:left; padding-left:5px}
td.partwhite4 {background-color:rgb(255,255,255); text-align:center}
td.content {background-color:rgb(230,230,226); text-align:center; font-size:xx-small; width:70px}
td.content2 {background-color:rgb(230,230,226); text-align:left}
td.content3 {background-color:rgb(255,255,255); text-align:left}
td.content4 {background-color:rgb(230,230,226); text-align:center}
ul {list-style:upper-alpha; padding:0px; padding-left:17px; margin:3px}
ul.square {list-style:square; padding:0px; padding-left:13px; margin:3px}
ul.circle {list-style:circle; padding:0px; padding-left:13px; margin:3px}
ol {list-style:decimal; padding:0px; padding-left:30px; margin:0px}
ol.zero {list-style:decimal-leading-zero}
td.sectiontop1 {border:0px solid black; width:300px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop2 {border:0px solid black; width:150px; text-align:left; margin:0px; padding-left:10px}
td.sectiontop3 {border:0px solid black; width:100px; text-align:left; margin:0px; padding-left:10px}
</style>

<body>
<form name="form15" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table cellspacing="0" align="center" style="font-size:16px"><tr><td>Resident:</td><td class="sectiontop1"><font size="3"><b><?php echo $name; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Identifier:</td><td class="sectiontop2"><font size="3"><b><?php echo $_SESSION['ncareName_lwj']; ?></b></font><hr color="black" align="left" width="100%" size="1"></td><td>Date:</td><td class="sectiontop3"><font size="3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script></font><input type="text" size="18" name="date" id="date" value="<?php echo formatdate_Ymd_Slash($date);?>"></b></font><hr color="black" align="left" width="100%" size="1"></td></tr></table>
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1" style="margin-bottom:3px">
<tr>
<td class="section2" width="150"><b style="padding-left:5px">Section G</b></td>
<td class="section2" width="720"><b style="padding-left:5px">Functional Status</b></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" align="center" cellpadding="0" cellspacing="0" border="1">
<tr>
<td class="part" colspan="3">
<b>G0110. Activities of Daily Living (ADL) Assistance</b><br>Refer to the ADL flow chart in the RAI manual to facilitate accurate coding
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="partwhite" colspan="3">
<b>Instructions for Rule of 3</b>
<ul class="square">
<li>When an activity occurs three times at any one given level, code that level.</li>
<li>When an activity occurs three times at multiple levels, code the most dependent, exceptions are total dependence (4), activity must require full assist <br>every time, and activity did not occur (8), activity must not have occurred at all. Example, three times extensive assistance (3) and three times limited <br>assistance (2), code extensive assistance (3).</li>
<li>When an activity occurs at various levels, but not three times at any given level, apply the following:</li>
<ul class="circle">
<li>When there is a combination of full staff performance, and extensive assistance, code extensive assistance.</li>
<li>When there is a combination of full staff performance, weight bearing assistance and/or non-weight bearing assistance code limited assistance (2).</li>
</ul>
</ul>
<b>If none of the above are met, code supervision.</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="content3" colspan="1" rowspan="4" width="568">
<ol style="padding-left:20px; margin:3px">
<li><b>ADL Self-Performance</b><br>Code for <b>resident's performance</b> over all shifts - not including setup. If the ADL activity <br>occurred 3 or more times at various levels of assistance, code the most dependent - except for <br>total dependence, which requires full staff performance every time
</ol> 
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<u><b>Activity Occurred 3 or More Times</b></u>
<li><b>Independent</b> - no help or staff oversight at any time
<li><b>Supervision</b> - oversight, encouragement or cueing
<li><b>Limited assistance</b> - resident highly involved in activity; staff provide guided maneuvering <br>of limbs or other non-weight-bearing assistance
<li><b>Extensive assistance</b> - resident involved in activity, staff provide weight-bearing support
<li><b>Total dependence</b> - full staff performance every time during entire 7-day period
<br><u><b>Activity Occurred 2 or Fewer Times</b></u>
<li value="7"><b>Activity occurred only once or twice</b> - activity did occur but only once or twice
<li><b>Activity did not occur</b> - activity (or any part of the ADL) was not performed by resident or <br>staff at all over the entire 7-day period
</ol>
</td>
</tr>
<tr>
<td  class="content3" colspan="2" rowspan="1" width="300">
<ol style="padding-left:20px">
<li value="2"><b>ADL Support Provided</b><br>Code for <b>most support provided </b>over all <br>shifts; code regardless of resident's self-<br>performance classification
</ol>
<b style="padding-left:5px">Coding:</b>
<ol start="0" style="padding-left:33px">
<li><b>No</b> setup or physical help from staff
<li><b>Setup</b> help only
<li><b>One</b> person physical assist
<li><b>Two+</b> persons physical assist
<li value="8">ADL activity itself <b>did not occur</b> or family <br>and/or non-facility staff provided care <br>100% of the time for that activity over the <br>entire 7-day period
</ol>
</td>
</tr>
<tr>
<td class="content4" colspan="1" rowspan="1" width="150">
<b>1.<br>Self-Performance</b>
</td>
<td class="content4" colspan="1" rowspan="1" width="150">
<b>2.<br>Support</b>
</td>
</tr>
<tr>
<td class="partwhite4" colspan="2" rowspan="1" width="300">
<b>&#8595; Enter Codes in Boxes &#8595;</b>
</td>
</tr>  
<!-------------------------------------------->
<tr>
<td>
<ul>
<li><b>Bed mobility</b> - how resident moves to and from lying position, turns side to side, and <br>positions body while in bed or alternate sleep furniture  
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110A1" value="0" <?php if($QG0110A1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110A1" value="1" <?php if($QG0110A1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110A1" value="2" <?php if($QG0110A1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110A1" value="3" <?php if($QG0110A1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110A1" value="4" <?php if($QG0110A1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110A1" value="7" <?php if($QG0110A1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110A1" value="8" <?php if($QG0110A1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110A2" value="0" <?php if($QG0110A2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110A2" value="1" <?php if($QG0110A2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110A2" value="2" <?php if($QG0110A2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110A2" value="3" <?php if($QG0110A2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110A2" value="8" <?php if($QG0110A2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="2"><b>Transfer</b> - how resident moves between surfaces including to or from: bed, chair, wheelchair, <br>standing position (<b>excludes</b> to/from bath/toilet)  
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110B1" value="0" <?php if($QG0110B1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110B1" value="1" <?php if($QG0110B1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110B1" value="2" <?php if($QG0110B1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110B1" value="3" <?php if($QG0110B1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110B1" value="4" <?php if($QG0110B1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110B1" value="7" <?php if($QG0110B1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110B1" value="8" <?php if($QG0110B1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110B2" value="0" <?php if($QG0110B2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110B2" value="1" <?php if($QG0110B2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110B2" value="2" <?php if($QG0110B2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110B2" value="3" <?php if($QG0110B2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110B2" value="8" <?php if($QG0110B2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="3"><b>Walk in room</b> - how resident walks between locations in his/her room
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110C1" value="0" <?php if($QG0110C1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110C1" value="1" <?php if($QG0110C1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110C1" value="2" <?php if($QG0110C1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110C1" value="3" <?php if($QG0110C1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110C1" value="4" <?php if($QG0110C1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110C1" value="7" <?php if($QG0110C1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110C1" value="8" <?php if($QG0110C1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110C2" value="0" <?php if($QG0110C2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110C2" value="1" <?php if($QG0110C2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110C2" value="2" <?php if($QG0110C2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110C2" value="3" <?php if($QG0110C2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110C2" value="8" <?php if($QG0110C2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="4"><b>Walk in corridor</b> - how resident walks in corridor on unit  
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110D1" value="0" <?php if($QG0110D1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110D1" value="1" <?php if($QG0110D1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110D1" value="2" <?php if($QG0110D1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110D1" value="3" <?php if($QG0110D1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110D1" value="4" <?php if($QG0110D1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110D1" value="7" <?php if($QG0110D1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110D1" value="8" <?php if($QG0110D1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110D2" value="0" <?php if($QG0110D2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110D2" value="1" <?php if($QG0110D2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110D2" value="2" <?php if($QG0110D2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110D2" value="3" <?php if($QG0110D2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110D2" value="8" <?php if($QG0110D2=="8") echo "checked";?>>8
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="5"><b>Locomotion on unit</b> - how resident moves between locations in his/her room and adjacent <br>corridor on same floor. If in wheelchair, self-sufficiency once in chair  
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110E1" value="0" <?php if($QG0110E1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110E1" value="1" <?php if($QG0110E1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110E1" value="2" <?php if($QG0110E1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110E1" value="3" <?php if($QG0110E1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110E1" value="4" <?php if($QG0110E1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110E1" value="7" <?php if($QG0110E1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110E1" value="8" <?php if($QG0110E1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110E2" value="0" <?php if($QG0110E2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110E2" value="1" <?php if($QG0110E2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110E2" value="2" <?php if($QG0110E2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110E2" value="3" <?php if($QG0110E2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110E2" value="8" <?php if($QG0110E2=="8") echo "checked";?>>8
</td>
</tr>	
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="6"><b>Locomotion off unit</b> - how resident moves to and returns from off-unit locations (e.g., areas <br>set aside for dining, activities or treatments). <b>If facility has only one floor,</b> how resident <br>moves to and from distant areas on the floor. If in wheelchair, self-sufficiency once in chair  
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110F1" value="0" <?php if($QG0110F1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110F1" value="1" <?php if($QG0110F1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110F1" value="2" <?php if($QG0110F1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110F1" value="3" <?php if($QG0110F1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110F1" value="4" <?php if($QG0110F1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110F1" value="7" <?php if($QG0110F1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110F1" value="8" <?php if($QG0110F1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110F2" value="0" <?php if($QG0110F2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110F2" value="1" <?php if($QG0110F2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110F2" value="2" <?php if($QG0110F2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110F2" value="3" <?php if($QG0110F2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110F2" value="8" <?php if($QG0110F2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="7"><b>Dressing</b> - how resident puts on, fastens and takes off all items of clothing, including <br>donning/removing a prosthesis or TED hose. Dressing includes putting on and changing <br>pajamas and housedresses
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110G1" value="0" <?php if($QG0110G1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110G1" value="1" <?php if($QG0110G1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110G1" value="2" <?php if($QG0110G1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110G1" value="3" <?php if($QG0110G1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110G1" value="4" <?php if($QG0110G1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110G1" value="7" <?php if($QG0110G1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110G1" value="8" <?php if($QG0110G1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110G2" value="0" <?php if($QG0110G2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110G2" value="1" <?php if($QG0110G2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110G2" value="2" <?php if($QG0110G2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110G2" value="3" <?php if($QG0110G2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110G2" value="8" <?php if($QG0110G2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="8"><b>Eating</b> - how resident eats and drinks, regardless of skill. Do not include eating/drinking <br>during medication pass. Includes intake of nourishment by other means (e.g., tube feeding, <br>total parenteral nutrition, IV fluids administered for nutrition or hydration)  
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110H1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110H1" value="0" <?php if($QG0110H1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110H1" value="1" <?php if($QG0110H1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110H1" value="2" <?php if($QG0110H1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110H1" value="3" <?php if($QG0110H1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110H1" value="4" <?php if($QG0110H1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110H1" value="7" <?php if($QG0110H1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110H1" value="8" <?php if($QG0110H1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110H2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110H2" value="0" <?php if($QG0110H2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110H2" value="1" <?php if($QG0110H2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110H2" value="2" <?php if($QG0110H2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110H2" value="3" <?php if($QG0110H2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110H2" value="8" <?php if($QG0110H2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="9"><b>Toilet use - how resident uses the toilet room, commode, bedpan, or urinal; transfers on/off <br>toilet; cleanses self after elimination; changes pad; manages ostomy or catheter; and adjusts <br>clothes. Do not include emptying of bedpan, urinal, bedside commode, catheter bag or <br>ostomy bag
</ul>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110I1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110I1" value="0" <?php if($QG0110I1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110I1" value="1" <?php if($QG0110I1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110I1" value="2" <?php if($QG0110I1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110I1" value="3" <?php if($QG0110I1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110I1" value="4" <?php if($QG0110I1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110I1" value="7" <?php if($QG0110I1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110I1" value="8" <?php if($QG0110I1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110I2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110I2" value="0" <?php if($QG0110I2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110I2" value="1" <?php if($QG0110I2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110I2" value="2" <?php if($QG0110I2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110I2" value="3" <?php if($QG0110I2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110I2" value="8" <?php if($QG0110I2=="8") echo "checked";?>>8
</td>
</tr>
<!-------------------------------------------->
<tr>
<td>
<ul>
<li value="10"><b>Personal hygiene</b> - how resident maintains personal hygiene, including combing hair,<br> brushing teeth, shaving, applying makeup, washing/drying face and hands (<b>excludes</b> baths<br> and showers)
</ul>
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110J1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110J1" value="0" <?php if($QG0110J1=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110J1" value="1" <?php if($QG0110J1=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110J1" value="2" <?php if($QG0110J1=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110J1" value="3" <?php if($QG0110J1=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110J1" value="4" <?php if($QG0110J1=="4") echo "checked";?>>4<br>
<input type="radio" name="QG0110J1" value="7" <?php if($QG0110J1=="7") echo "checked";?>>7<br>
<input type="radio" name="QG0110J1" value="8" <?php if($QG0110J1=="8") echo "checked";?>>8
</td>
<td class="content">
<?php if (substr($url[3],0,5)!="print"){ if($G0110J2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br>
<input type="radio" name="QG0110J2" value="0" <?php if($QG0110J2=="0") echo "checked";?>>0<br>
<input type="radio" name="QG0110J2" value="1" <?php if($QG0110J2=="1") echo "checked";?>>1<br>
<input type="radio" name="QG0110J2" value="2" <?php if($QG0110J2=="2") echo "checked";?>>2<br>
<input type="radio" name="QG0110J2" value="3" <?php if($QG0110J2=="3") echo "checked";?>>3<br>
<input type="radio" name="QG0110J2" value="8" <?php if($QG0110J2=="8") echo "checked";?>>8
</td>
</tr>
</table>
<!-------------------------------------------->	
<p align="center">
<input type="hidden" name="formID" id="formID" value="mdsform15">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>">
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<input type="reset" value="Reset"></p>
<p style="font-size:10px; color:black">MDS 3.0 Nursing Home Comprehensive (NC) Version 1.12.0 Effective 10/01/2014</p>
</form>
</body>
