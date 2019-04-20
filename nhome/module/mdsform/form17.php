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
$sql = "SELECT * FROM `mdsform17` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page17_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page17_Qfiller_name .= $v;
		}else{}
	}
}
}
$page17_Qfiller_name = str_replace(';',', ', $page17_Qfiller_name);
?>
<body class="page17-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page17_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section H</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Bladder and Bowel</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page17-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>H0100. Appliances</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page17-partwhite" colspan="2" style="padding-left:2.7em"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b>&#8595; Check all that apply</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QH0100A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite" style="width:50em">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Indwelling catheter</b> (including suprapubic catheter and nephrostomy tube)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QH0100B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>External catheter</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QH0100C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Ostomy</b> (including urostomy, ileostomy, and colostomy)
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QH0100D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Intermittent catheterization</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QH0100Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>
</ul>
</td>
</tr>	  
<!-------------------------------------------->
<tr>
<td class="page17-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>H0200. Urinary Toileting Program</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0200A; ?><?php if (substr($url[3],0,5)!="print"){ if($H0200A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Has a trial of a toileting program (e.g., scheduled toileting, prompted voiding, or bladder training)</b> <br>been attempted on admission/reentry or since urinary incontinence was noted in this facility?
</ul>
<ol class="page17-ol" start="0">
<li><b>No &#8594; </b>Skip to H0300, Urinary Continence
<li><b>Yes &#8594; </b>Continue to H0200B, Response
<li value="9"><b>Unable to determine &#8594; </b>Skip to H0200C, Current toileting program or trial
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0200B; ?><?php if (substr($url[3],0,5)!="print"){ if($H0200B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Response</b> - What was the resident's response to the trial program?
</ul>
<ol class="page17-ol" start="0">
<li><b>No improvement</b>
<li><b>Decreased wetness</b>
<li><b>Completely dry</b> (continent)
<li value="9"><b>Unable to determine</b> or trial in progress
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0200C; ?><?php if (substr($url[3],0,5)!="print"){ if($H0200C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page17-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Current toileting program or trial</b> - Is a toileting program (e.g., scheduled toileting, prompted voiding, or <br>bladder training) currently being used to manage the resident's urinary continence?
</ul>
<ol class="page17-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page17-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>H0300. Urinary Continence</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0300; ?><?php if (substr($url[3],0,5)!="print"){ if($H0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Urinary continence</b> - Select the one category that best describes the resident
<ol class="page17-ol" start="0">
<li><b>Always continent</b>
<li><b>Occasionally incontinent</b> (less than 7 episodes of incontinence)
<li><b>Frequently incontinent</b> (7 or more episodes of urinary incontinence, but at least one episode of <br>continent voiding)
<li><b>Always incontinent</b> (no episodes of continent voiding)
<li value="9"><b>Not rated,</b> resident had a catheter (indwelling, condom), urinary ostomy, or no urine output for the <br>entire 7 days
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page17-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>H0400. Bowel Continence</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0400; ?><?php if (substr($url[3],0,5)!="print"){ if($H0400_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Bowel continence</b> - Select the one category that best describes the resident
<ol class="page17-ol" start="0">
<li><b>Always continent</b>
<li><b>Occasionally incontinent</b> (one episode of bowel incontinence)
<li><b>Frequently incontinent</b> (2 or more episodes of bowel incontinence, but at least one continent <br>bowel movement)
<li><b>Always incontinent</b> (no episodes of continent bowel movements)
<li value="9"><b>Not rated,</b> resident had an ostomy or did not have a bowel movement for the entire 7 days
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page17-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>H0500. Bowel Toileting Program</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0500; ?><?php if (substr($url[3],0,5)!="print"){ if($H0500_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Is a toileting program currently being used to manage the resident's bowel continence?</b>
<ol class="page17-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="page17-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>H0600. Bowel Patterns</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page17-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QH0600; ?><?php if (substr($url[3],0,5)!="print"){ if($H0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page17-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Constipation present?</b>
<ol class="page17-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
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