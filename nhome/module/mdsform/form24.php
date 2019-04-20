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
$sql = "SELECT * FROM `mdsform24` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page24_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page24_Qfiller_name .= $v;
		}else{}
	}
}
}
$page24_Qfiller_name = str_replace(';',', ', $page24_Qfiller_name);
?>
<body class="page24-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page24_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section K</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Swallowing/Nutritional Status</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.75em; width:55.875em">
<tr>
<td class="page24-part" colspan="4"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>K0710. Percent Intake by Artificial Route</b><?php if (substr($url[3],0,5)!="print"){ if($K0710_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - Complete K0710 only if Column 1 and/or Column 2 are checked for <br><a>K0510A and/or K0510B</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-partwhite" colspan="1" rowspan="2" style="width:38.25em">
<ol class="page24-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>While NOT a Resident</b><br>Performed <b>while NOT a resident</b> of this facility and within the <b>last 7 </b><br><b>days.</b> Only enter a code in column 1 if resident entered (admission or <br>reentry) IN THE LAST 7 DAYS. If resident last entered 7 or more days <br>ago, leave column 1 blank
</li>
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>While a Resident</b><br>Performed <b>while a resident</b> of this facility and within the <b>last 7 days</b>
</li>
<li style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>During Entire 7 Days</b><br>Performed during the entire <b>last 7 days</b>
</li>
</ol>
</td>
<td class="page24-content" colspan="1" style="width:5.875em">
<b>1. <br>While NOT a <br>Resident</b>
</td>
<td class="page24-content" colspan="1" style="width:5.875em">
<b>2. <br>While a <br>Resident</b>
</td>
<td class="page24-content" colspan="1" style="width:5.875em">
<b>3. <br>During Entire <br>7 Days</b>
</td>
</tr>
<tr>
<td class="page24-partwhite" colspan="3" style="text-align:center; width:17.625em">
<b>&#8595; Enter Codes &#8595;</b>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Proportion of total calories the resident received through parenteral or tube feeding</b>
</ul>
<ol class="page24-ol" style="margin-top:0.1875em; margin-bottom:0.1875em; padding-left:3.4em">
<li><b>25% or less</b>
<li><b>26-50%</b>
<li><b>51% or more</b>
</ol>
</td>	  
<td class="page24-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QK0710A1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QK0710A2; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QK0710A3; ?></td>
</tr>
</table>
</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Average fluid intake per day by IV or tube feeding</b>
</ul>
<ol class="page24-ol" style="margin-top:0.1875em; margin-bottom:0.1875em; padding-left:3.4em">
<li><b>500 cc/day or less</b>
<li><b>501 cc/day or more</b>
</ol>
</td>	  
<td class="page24-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QK0710B1; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QK0710B2; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-content">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QK0710B3; ?></td>
</tr>
</table>
</div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0"  align="center"style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section L</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Oral/Dental Status</b></div></td>
</tr>
</table>		
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page24-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>L0200. Dental</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page24-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite" style="width:50em">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Broken or loosely fitting full or partial denture</b>(chipped, cracked, uncleanable, or loose)		
</ul>
</td>
</tr>
<!-------------------------------------------->  
<tr> 
<td class="page24-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>No natural teeth or tooth fragment(s)</b>(edentulous)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Abnormal mouth tissue</b>(ulcers, masses, oral lesions, including under denture or partial if one is worn)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Obvious or likely cavity or broken natural teeth</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Inflamed or bleeding gums or loose natural teeth</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200F; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Mouth or facial pain, discomfort or difficulty with chewing</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200G; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Unable to examine</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page24-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QL0200Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page24-partwhite">
<ul class="page24-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above were present</b>		
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