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
$sql = "SELECT * FROM `mdsform23` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page23_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page23_Qfiller_name .= $v;
		}else{}
	}
}
}
$page23_Qfiller_name = str_replace(';',', ', $page23_Qfiller_name);
?>
<body class="page23-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page23_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section K</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Swallowing/Nutritional Status</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page23-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>K0100. Swallowing Disorder</b><br><a>Signs and symptoms of possible swallowing disorder</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0100A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite" style="width:50em">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Loss of liquids/solids from mouth when eating or drinking</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0100B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Holding food in mouth/cheeks or residual food in mouth after meals</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0100C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Coughing or choking during meals or when swallowing medications</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0100D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Complaints of difficulty or pain with swallowing</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0100Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>K0200. Height and Weight</b>- While measuring, if the number is X.1 - X.4 round down; X.5 or greater round up</div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content2" style="border-bottom-style:hidden">
<table cellspacing="0">
<td class="answer"><?php echo $QK0200A_1; ?><?php if (substr($url[3],0,5)!="print"){ if($K0200A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QK0200A_2; ?><?php if (substr($url[3],0,5)!="print"){ if($K0200A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
inches
</td>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Height</b> (in inches). Record most recent height measure since the most recent admission/entry or reentry
</ul>			 
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content2" style="border-top-style:hidden">
<table cellspacing="0">
<td class="answer"><?php echo $QK0200B_1; ?><?php if (substr($url[3],0,5)!="print"){ if($K0200B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QK0200B_2; ?><?php if (substr($url[3],0,5)!="print"){ if($K0200B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QK0200B_3; ?><?php if (substr($url[3],0,5)!="print"){ if($K0200B3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</table>
pounds
</td>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Weight</b>(in pounds). Base weight on most recent measure in last 30 days; measure weight consistently, <br>according to standard facility practice (e.g., in a.m. after voiding, before meal, with shoes off, etc.)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>K0300. Weight Loss</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QK0300; ?><?php if (substr($url[3],0,5)!="print"){ if($K0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Loss of 5% or more in the last month or loss of 10% or more in last 6 months</b>
<ol class="page23-ol" start="0" style="padding-left:3em">
<li><b>No</b> or unknown
<li><b>Yes, on</b> physician-prescribed weight-loss regimen
<li><b>Yes, not on</b> physician-prescribed weight-loss regimen
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>K0310. Weight Gain</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page23-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QK0310; ?><?php if (substr($url[3],0,5)!="print"){ if($K0310_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page23-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Gain of 5% or more in the last month or gain of 10% or more in last 6 months</b>
<ol class="page23-ol" start="0" style="padding-left:3em">
<li><b>No</b> or unknown
<li><b>Yes, on</b> physician-prescribed weight-gain regimen
<li><b>Yes, not on</b> physician-prescribed weight-gain regimen
</ol></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page23-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>K0510. Nutritional Approaches</b><?php if (substr($url[3],0,5)!="print"){ if($K0510_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?><br><a>Check all of the following nutritional approaches that were performed during the last <b>7 days</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td colspan="1" rowspan="2" style="width:44.125em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page23-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>While NOT a Resident</b><br>Performed while NOT a resident of this facility and within the last 7 days. Only check <br>column 1 if resident entered (admission or reentry) IN THE LAST 7 DAYS. If resident <br>last entered 7 or more days ago, leave column 1 blank
</li>
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>While a Resident</b><br>Performed while a resident of this facility and within the last 7 days
</li></div>
</td>
<td class="page23-content" valign="bottom" colspan="1" style="width:5.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>1. <br>While NOT a <br>Resident</b></div>
</td>
<td class="page23-content"valign="bottom" colspan="1" style="width:5.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>2. <br>While a <br>Resident</b></div>
</td>
</tr>
<tr>
<td class="page23-partwhite" colspan="2" valign="bottom" style="text-align:center; width:11.75em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>&#8595; Check all that apply &#8595;</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Parenteral/IV feeding</b>
</ul>
</td>	  
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510A1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510A2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Feeding tube</b>	- nasogastric or abdominal (PEG)
</ul>
</td>	  
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510B1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510B2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Mechanically altered diet</b> - require change in texture of food or liquids (e.g., pureed <br>food, thickened liquids)
</ul>
</td>	  
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510C1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510C2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Therapeutic diet</b> (e.g., low salt, diabetic, low cholesterol)
</ul>
</td>	  
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510D1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510D2; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page23-partwhite">
<ul class="page23-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>
</ul>
</td>	  
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510Z1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page23-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QK0510Z2; ?></td>
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