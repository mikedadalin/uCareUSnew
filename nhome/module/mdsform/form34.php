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
$sql = "SELECT * FROM `mdsform34` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page34_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page34_Qfiller_name .= $v;
		}else{}
	}
}
}
$page34_Qfiller_name = str_replace(';',', ', $page34_Qfiller_name);
?>
<body class="page34-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page34_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section Q</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Participation in Assessment and Goal Setting</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page34-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0490. Resident's Preference to Avoid Being Asked Question Q0500B</b><br><a>Complete only if A0310A = 02, 06, or 99</a></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page34-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QQ0490; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0490_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page34-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Does the resident's clinical record document a request that this question be asked only on </b><br><b style="padding-left:0.3125em">comprehensive assessments?</b>
<ol class="page34-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b>
<li><b>Yes &#8594; </b>Skip to Q0600, Referral
<li value="8"><b>Information not available</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page34-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0500. Return to Community</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page34-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QQ0500B; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page34-partwhite">
<ul class="page34-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Ask the resident</b> (or family or significant other or guardian or legally authorized representative if resident is unable to understand or respond): <b>"Do you want to talk to someone about the possibility of leaving this facility and returning to live and receive services in the community?"</b>
</ul>
<ol class="page34-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Unknown or uncertain</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->	
<tr>
<td class="page34-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0550. Resident's Preference to Avoid Being Asked Question Q0500B Again</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page34-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QQ0550A; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0550A=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page34-partwhite">
<ul class="page34-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Does the resident</b> (or family or significant other or guardian or legally authorized representative if resident <br>is unable to understand or respond) <b>want to be asked about returning to the community on <u>all</u> <br>assessments?</b> (Rather than only on comprehensive assessments.)
</ul>
<ol class="page34-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b> - then document in resident's clinical record and ask again only on the next comprehensive <br>assessment
<li><b>Yes</b>
<li value="8"><b>Information not available</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page34-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QQ0550B; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0550B=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page34-partwhite">
<ul class="page34-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Indicate information source for Q0550A</b>
</ul>
<ol class="page34-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Resident</b>
<li>If not resident, then <b>family or significant other</b>
<li>If not resident, family or significant other, then guardian <b>or legally authorized representative</b>
<li value="8"><b>No information source available</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->  
<tr>
<td class="page34-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0600. Referral</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page34-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QQ0600; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page34-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Has a referral been made to the Local Contact Agency?</b> (Document reasons in resident's clinical record)
<ol class="page34-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b> - referral not needed
<li><b>No</b> - referral is or may be needed (For more information see Appendix C, Care Area Assessment <br>Resources #20) 
<li><b>Yes</b> - referral made
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