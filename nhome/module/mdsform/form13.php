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
$sql = "SELECT * FROM `mdsform13` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page13_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page13_Qfiller_name .= $v;
		}else{}
	}
}
}
$page13_Qfiller_name = str_replace(';',', ', $page13_Qfiller_name);
?>
<body class="page13-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page13_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section F</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Preferences for Customary Routine and Activities</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em; border-width:0.5em">
<tr>
<td class="page13-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>F0300. Should Interview for Daily and Activity Preferences be Conducted?</b>- Attempt to interview all residents able <br><a style="padding-left:3.5em">to communicate.</a><br><a>If resident is unable to complete, attempt to complete interview with family member or significant other</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page13-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0300; ?><?php if (substr($url[3],0,5)!="print"){ if($F0300_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page12-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page13-ol" start="0">
<li><b>No</b>(resident is rarely/never understood and family/significant other not available) &#8594; Skip to and <br>complete F0800, Staff Assessment of Daily and Activity Preferences
<li><b>Yes &#8594;</b> Continue to F0400, Interview for Daily Preferences
</ol></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em; border-width:0.3em">
<tr>
<td class="page13-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>F0400. Interview for Daily Preferences</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page13-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">Show resident the response options and say: <b>"While you are in this facility..."</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page13-partwhite" colspan="1" rowspan="9" style="width:19em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page13-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Very important</b>
<li><b>Somewhat important</b>
<li><b>Not very important</b>
<li><b>Not important at all</b>
<li><b>Important, but can't do or no <br>choice</b>
<li value="9"><b>No response or non-responsive</b>
</ol></div>
</td>
<td class="page13-partwhite" colspan="2" style="width:36.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page13-content" style="border-bottom-style:hidden; width:3.875em">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400A; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page12-partwhite" style="width:33em">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>how important is it to you to <b>choose what clothes to wear?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400B; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2">how important is it to you to <b>take care of your personal belongings or things?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400C; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3">how important is it to you to <b>choose between a tub bath, shower, <br>bed bath, or sponge bath?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400D; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4">how important is it to you to <b>have snacks available between meals?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400E; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5">how important is it to you to <b>choose your own bedtime?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400F; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6">how important is it to you to <b>have your family or a close friend <br>involved in discussions about your care?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400G; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7">how important is it to you to <b>be able to use the phone in private?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0400H; ?><?php if (substr($url[3],0,5)!="print"){ if($F0400H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8">how important is it to you to <b>have a place to lock your things to <br>keep them safe?</b>
</ul>
</td>
</tr>
<!-------------------------------------------->	  
<tr>
<td class="page13-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>F0500. Interview for Activity Preferences</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page13-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">Show resident the response options and say: <b>"While you are in this facility..."</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page13-partwhite" colspan="1" rowspan="9"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page13-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Very important</b>
<li><b>Somewhat important</b>
<li><b>Not very important</b>
<li><b>Not important at all</b>
<li><b>Important, but can't do or no <br>choice</b>
<li value="9"><b>No response or non-responsive</b>
</ol></div>
</td>
<td class="page13-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:1.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page13-content" style="border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500A; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>how important is it to you to <b>have books, newspapers, and <br>magazines to read?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500B; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2">how important is it to you to <b>listen to music you like?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500C; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3">how important is it to you to <b>be around animals such as pets?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500D; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4">how important is it to you to <b>keep up with the news?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500E; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5">how important is it to you to <b>do things with groups of people?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500F; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6">how important is it to you to <b>do your favorite activities?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500G; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7">how important is it to you to <b>go outside to get fresh air when the <br>weather is good?</b>
</ul>
</td>
</tr>
<tr>
<td class="page13-content" style="border-top-style:hidden">
<div style="padding-left:1.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0500H; ?><?php if (substr($url[3],0,5)!="print"){ if($F0500H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite">
<ul class="page13-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8">how important is it to you to <b>participate in religious services or <br>practices?</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page13-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>F0600. Daily and Activity Preferences Primary Respondent</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page13-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0600; ?><?php if (substr($url[3],0,5)!="print"){ if($F0600_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page13-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Indicate primary respondent</b> for Daily and Activity Preferences (F0400 and F0500)
<ol class="page13-ol" class="page13-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Resident</b>
<li><b>Family or significant other</b> (close friend or other representative)
<li value="9"><b>Interview could not be completed</b> by resident or family/significant other ("No response" to 3 or more <br>items")
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