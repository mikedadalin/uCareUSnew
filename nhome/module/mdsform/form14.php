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
$sql = "SELECT * FROM `mdsform14` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page14_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page14_Qfiller_name .= $v;
		}else{}
	}
}
}
$page14_Qfiller_name = str_replace(';',', ', $page14_Qfiller_name);
?>
<body class="page14-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page14_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page14-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>F0700. Should the Staff Assessment of Daily and Activity Preferences be Conducted?</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page14-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QF0700; ?><?php if (substr($url[3],0,5)!="print"){ if($F0700_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page14-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b> (because Interview for Daily and Activity Preferences (F0400 and F0500) was completed by <br>resident or family/significant other) &#8594; Skip to and complete G0110, <br>Activities of Daily Living (ADL) Assistance
<li><b>Yes</b> (because 3 or more items in Interview for Daily and Activity Preferences (F0400 and F0500) <br>were not completed by resident or family/significant other)) &#8594; Continue to F0800, <br>Staff Assessment of Daily and Activity Preferences
</ol></div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em; border-width:0.3em">
<tr>
<td class="page14-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>F0800. Staff Assessment of Daily and Activity Preferences</b><?php if (substr($url[3],0,5)!="print"){ if($F0800_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page14-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">Do not conduct if Interview for Daily and Activity Preferences (F0400-F0500) was completed</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page14-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Resident Prefers:</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page14-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page14-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite" style="width:50em">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Choosing clothes to wear</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Caring for personal belongings</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Receiving tub bath</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Receiving shower</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Receiving bed bath</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800F; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Receiving sponge bath</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800G; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Snacks between meals</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800H; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Staying up past 8:00 p.m.</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800I; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b>Family or significant other involvement in care discussions</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800J; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="10"><b>Use of phone in private</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800K; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="11"><b>Place to lock personal belongings</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800L; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="12"><b>Reading books, newspapers, or magazines</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800M; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="13"><b>Listening to music</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800N; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="14"><b>Being around animals such as pets</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800O; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="15"><b>Keeping up with the news</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800P; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="16"><b>Doing things with groups of people</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800Q; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="17"><b>Participating in favorite activities</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800R; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="18"><b>Spending time away from the nursing home</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800S; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="19"><b>Spending time outdoors</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800T; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="20"><b>Participating in religious activities or practices</b>
</ul>
</td>
</tr>
<tr>
<td class="page14-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QF0800Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page14-partwhite">
<ul class="page14-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
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