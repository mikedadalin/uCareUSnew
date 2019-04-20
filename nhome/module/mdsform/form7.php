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
$sql = "SELECT * FROM `mdsform07` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page7_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page7_Qfiller_name .= $v;
		}else{}
	}
}
}
$page7_Qfiller_name = str_replace(';',', ', $page7_Qfiller_name);
?>
<body class="page7-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page7_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section C</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Cognitive Patterns</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em; border-width:0.5em">  
<tr>
<td class="page7-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">C0100. Should Brief Interview for Mental Status (C0200-C0500) be Conducted?</b>
<br><a style="padding-left:0.3125em">Attempt to conduct interview with all residents</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page7-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0100; ?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite" style="width:50em">
<ol class="page7-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b> (resident is rarely/never understood) &#8594; Skip to and complete C0700-C1000, Staff Assessment for Mental Status
<li><b>Yes &#8594;</b> Continue to C0200, Repetition of Three Words
</ol>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em; border-width:0.3em">
<tr>
<td class="page7-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Brief Interview for Mental Status (BIMS)</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page7-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>C0200. Repetition of Three Words</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page7-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0200; ?><?php if (substr($url[3],0,5)!="print"){ if($C0200_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page5-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: &#8243;I am going to say three words for you to remember. Please repeat the words after I have said </a><br><a style="padding-left:0.3125em">all three.</a><br>
<a style="padding-left:0.3125em">The words are:<b> sock, blue, and bed.</b> Now tell me the three words.&#8243;</a><br>
<b style="padding-left:0.3125em">Number of words repeated after first attempt</b>
<ol class="page7-ol" start="0">
<li><b>None</b>
<li><b>One</b>
<li><b>Two</b>
<li><b>Three</b>
</ol>
<a style="padding-left:0.3125em">After the resident's first attempt, repeat the words using cues ("sock, something to wear; blue, a color; bed, a </a><br><a style="padding-left:0.3125em">pieceof furniture"). You may repeat the words up to two more times.</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page7-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>C0300. Temporal Orientation</b> (orientation to year, month, and day)</div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page7-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0300A; ?><?php if (substr($url[3],0,5)!="print"){ if($C0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: "Please tell me what year it is right now."</a>
<ul class="page7-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Able to report correct year</b>
</ul>
<ol class="page7-ol" start="0">
<li><b>Missed by > 5 years</b> or no answer
<li><b>Missed by 2-5 years</b>
<li><b>Missed by 1 year</b>
<li><b>Correct</b>
</ol></div>
</td>
</tr>
<tr>
<td class="page7-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0300B; ?><?php if (substr($url[3],0,5)!="print"){ if($C0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: "What month are we in right now?"</a>
<ul class="page7-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Able to report correct month</b>
</ul>
<ol class="page7-ol" start="0">
<li><b>Missed by > 1 month</b> or no answer
<li><b>Missed by 6 days to 1 month</b>
<li><b>Accurate within 5 days</b>
</ol></div>
</td>
</tr>
<tr>
<td class="page7-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0300C; ?><?php if (substr($url[3],0,5)!="print"){ if($C0300C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: "What day of the week is today?"</a>
<ul class="page7-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Able to report correct day of the week</b>
</ul>
<ol class="page7-ol" start="0">
<li><b>Incorrect</b> or no answer
<li><b>Correct</b>
</ol></div>
</td>		
</tr>
<!-------------------------------------------->
<tr>
<td class="page7-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">C0400. Recall</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page7-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0400A; ?><?php if (substr($url[3],0,5)!="print"){ if($C0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Ask resident: "Let's go back to an earlier question. What were those three words that I asked you to repeat?"</a><br>
<a style="padding-left:0.3125em">If unable to remember a word, give cue (something to wear; a color; a piece of furniture) for that word.</a>
<ul class="page7-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Able to recall "sock"</b>
</ul>
<ol class="page7-ol" start="0">
<li><b>No</b> - could not recall
<li><b>Yes, after cueing</b> ("something to wear")
<li><b>Yes, no cue required</b>
</ol></div>
</td>
</tr>
<tr>
<td class="page7-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0400B; ?><?php if (substr($url[3],0,5)!="print"){ if($C0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page7-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Able to recall "blue"</b>
</ul>
<ol class="page7-ol" start="0">
<li><b>No</b> - could not recall
<li><b>Yes, after cueing</b> ("a color")
<li><b>Yes, no cue required</b>
</ol></div>
</td>
</tr>
<tr>
<td class="page7-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QC0400C; ?><?php if (substr($url[3],0,5)!="print"){ if($C0400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page7-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Able to recall "bed"</b>
</ul>
<ol class="page7-ol" start="0">
<li><b>No</b> - could not recall
<li><b>Yes, after cueing</b> ("a piece of furniture")
<li><b>Yes, no cue required</b>
</ol></div>
</td>		
</tr>
<!-------------------------------------------->  
<tr>
<td class="page7-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">C0500. Summary Score</b></div>
</td>
</tr>
<tr>
<td class="page7-content">
<a style="font-family:serif">Enter Score</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QC0500_1; ?><?php if (substr($url[3],0,5)!="print"){ if($C05001_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QC0500_2; ?><?php if (substr($url[3],0,5)!="print"){ if($C05002_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page7-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Add scores</b> for questions C0200-C0400 and fill in total score (00-15)<br>
<b style="padding-left:0.3125em">Enter 99 if the resident was unable to complete the interview</b>
</td></div>
</tr>
<!-------------------------------------------->	  
</table>
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