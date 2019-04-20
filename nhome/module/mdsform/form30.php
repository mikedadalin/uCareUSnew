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
$sql = "SELECT * FROM `mdsform30` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page30_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page30_Qfiller_name .= $v;
		}else{}
	}
}
}
$page30_Qfiller_name = str_replace(';',', ', $page30_Qfiller_name);
?>
<body class="page30-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page30_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section O</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Special Treatments, Procedures, and Programs</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page30-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0400. Therapies</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-bottom-style:hidden; width:9em"></td>
<td class="page30-content" colspan="2" style="text-align:left; width:46.875em">
<ul class="page30-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Speech-Language Pathology and Audiology Services</b>	  
</ul>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400A1_1; ?></td>
<td class="answer"><?php echo $QO0400A1_2; ?></td>
<td class="answer"><?php echo $QO0400A1_3; ?></td>
<td class="answer"><?php echo $QO0400A1_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page30-partwhite" colspan="2" style="border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Individual minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to <br>the resident <b>individually</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400A2_1; ?></td>
<td class="answer"><?php echo $QO0400A2_2; ?></td>
<td class="answer"><?php echo $QO0400A2_3; ?></td>
<td class="answer"><?php echo $QO0400A2_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Concurrent minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to <br>the resident <b>concurrently with one other resident</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400A3_1; ?></td>
<td class="answer"><?php echo $QO0400A3_2; ?></td>
<td class="answer"><?php echo $QO0400A3_3; ?></td>
<td class="answer"><?php echo $QO0400A3_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Group minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to the <br>resident as <b>part of a group of residents</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.4em; margin-bottom:1em">
<b style="padding-left:0.3125em">If the sum of individual, concurrent, and group minutes is zero, &#8594;</b> skip to O0400A5, <br><a style="padding-left:0.3125em">Therapy start date</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400A3A_1; ?></td>
<td class="answer"><?php echo $QO0400A3A_2; ?></td>
<td class="answer"><?php echo $QO0400A3A_3; ?></td>
<td class="answer"><?php echo $QO0400A3A_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<a>3A.</a><b style="padding-left:0.5em">Co-treatment minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A3A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered <br><a style="padding-left:2.1em">to the resident in </b>co-treatment sessions</b> in the last 7 days</a>
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400A4; ?></td>
</tr>
</table>
</div>
</td>	 
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Days</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A4_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page30-partwhite" style="border-top-style:hidden; border-right-style:hidden; width:23.4375em">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Therapy start date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A5_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the <br>most recent therapy regimen (since the <br>most recent entry) started
<div style="padding-left:0.6em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0400A5_1; ?></td>
<td class="answer"><?php echo $QO0400A5_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400A5_3; ?></td>
<td class="answer"><?php echo $QO0400A5_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400A5_5; ?></td>
<td class="answer"><?php echo $QO0400A5_6; ?></td>
<td class="answer"><?php echo $QO0400A5_7; ?></td>
<td class="answer"><?php echo $QO0400A5_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ol>
</td>
<td class="page30-partwhite" style="border-top-style:hidden; border-left-style:hidden; width:23.4375em">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Therapy end date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400A6_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the <br>most recent therapy regimen (since the <br>most recent entry) ended - enter dashes if <br>therapy is ongoing
<div style="padding-left:0.6em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0400A6_1; ?></td>
<td class="answer"><?php echo $QO0400A6_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400A6_3; ?></td>
<td class="answer"><?php echo $QO0400A6_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400A6_5; ?></td>
<td class="answer"><?php echo $QO0400A6_6; ?></td>
<td class="answer"><?php echo $QO0400A6_7; ?></td>
<td class="answer"><?php echo $QO0400A6_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
</td>
<td class="page30-content" style="text-align:left" colspan="2">
<ul class="page30-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Occupational Therapy</b>	  
</ul>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400B1_1; ?></td>
<td class="answer"><?php echo $QO0400B1_2; ?></td>
<td class="answer"><?php echo $QO0400B1_3; ?></td>
<td class="answer"><?php echo $QO0400B1_4; ?></td>
</tr>
</table>
</div>
</td>	
<td class="page30-partwhite" colspan="2" style="border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Individual minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to <br>the resident <b>individually</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->	
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400B2_1; ?></td>
<td class="answer"><?php echo $QO0400B2_2; ?></td>
<td class="answer"><?php echo $QO0400B2_3; ?></td>
<td class="answer"><?php echo $QO0400B2_4; ?></td>
</tr>
</table>
</div>
</td>	
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Concurrent minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to <br>the resident <b>concurrently with one other resident</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400B3_1; ?></td>
<td class="answer"><?php echo $QO0400B3_2; ?></td>
<td class="answer"><?php echo $QO0400B3_3; ?></td>
<td class="answer"><?php echo $QO0400B3_4; ?></td>
</tr>
</table>
</div>
</td>	
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Group minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered to the <br>resident as <b>part of a group of residents</b> in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.4em; margin-bottom:1em">
<b style="padding-left:0.3125em">If the sum of individual, concurrent, and group minutes is zero, &#8594;</b> skip to O0400B5, <br><a style="padding-left:0.3125em">Therapy start date</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Minutes</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400B3A_1; ?></td>
<td class="answer"><?php echo $QO0400B3A_2; ?></td>
<td class="answer"><?php echo $QO0400B3A_3; ?></td>
<td class="answer"><?php echo $QO0400B3A_4; ?></td>
</tr>
</table>
</div>
</td>	  
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="padding-left:0em">3A.</a><b style="padding-left:0.5em">Co-treatment minutes</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B3A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the total number of minutes this therapy was administered <br><a style="padding-left:2.1em">to the resident in <b>co-treatment sessions</b> in the last 7 days</a>
</td>
</tr>
<!-------------------------------------------->		
<tr> 
<td class="page30-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif; font-size:0.8em">Enter Number of Days</a>
<table cellspacing="0">
<td class="answer"><?php echo $QO0400B4; ?></td>
</tr>
</table>
</div>
</td>
<td class="page30-partwhite" colspan="2" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Days</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B4_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the <b>number of days</b> this therapy was administered for <b>at least 15 minutes</b> a day <br>in the last 7 days
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page30-content" style="border-top-style:hidden"></td>
<td class="page30-partwhite" style="border-top-style:hidden; border-right-style:hidden; width:23.4375em">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Therapy start date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B5_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the <br>most recent therapy regimen (since the <br>most recent entry) started
<div style="padding-left:0.6em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QO0400B5_1; ?></td>
<td class="answer"><?php echo $QO0400B5_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400B5_3; ?></td>
<td class="answer"><?php echo $QO0400B5_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400B5_5; ?></td>
<td class="answer"><?php echo $QO0400B5_6; ?></td>
<td class="answer"><?php echo $QO0400B5_7; ?></td>
<td class="answer"><?php echo $QO0400B5_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ol>
</td>
<td class="page30-partwhite" style="border-top-style:hidden; border-left-style:hidden; width:23.4375em">
<ol class="page30-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Therapy end date</b><?php if (substr($url[3],0,5)!="print"){ if($O0400B6_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?> - record the date the <br>most recent therapy regimen (since the <br>most recent entry) ended - enter dashes if <br>therapy is ongoing
<div style="padding-left:0.6em">
<table cellspacing="0">
</tr>
<td class="answer"><?php echo $QO0400B6_1; ?></td>
<td class="answer"><?php echo $QO0400B6_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400B6_3; ?></td>
<td class="answer"><?php echo $QO0400B6_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QO0400B6_5; ?></td>
<td class="answer"><?php echo $QO0400B6_6; ?></td>
<td class="answer"><?php echo $QO0400B6_7; ?></td>
<td class="answer"><?php echo $QO0400B6_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.3em">Day</a><a style="padding-left:2.3em">Year</a>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page30-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0400 continued on next page</b></div></td>
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