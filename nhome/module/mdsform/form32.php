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
$sql = "SELECT * FROM `mdsform32` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page32_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page32_Qfiller_name .= $v;
		}else{}
	}
}
}
$page32_Qfiller_name = str_replace(';',', ', $page32_Qfiller_name);
?>
<body class="page32-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page32_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<td class="page32-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0500. Restorative Nursing Programs</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page32-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">Record the <b>number of days</b> each of the following restorative programs was performed (for at least 15 minutes a day) </a><br><a style="padding-left:1em">in the last 7 calendar days (enter 0 if none or less than 15 minutes daily)</a></div>
</td>
</tr>
<!--------------------------------------------> 
<tr> 
<td class="page32-partwhite" style="text-align:center; width:5.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>Number <br>of Days</b></div>
</td>
<td class="page32-content" style="text-align:left" style="width:50em">
<b style="padding-left:0.3125em">Technique</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500A; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Range of motion (passive)</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500B; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Range of motion (active)</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500C; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Splint or brace assistance</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-partwhite" style="text-align:center"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>Number <br>of Days</b></div>
</td>
<td class="page32-content" style="text-align:left">
<b style="padding-left:0.3125em">Training and Skill Practice In:</b>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500D; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Bed mobility</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500E; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Transfer</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500F; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500F_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Walking</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500G; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500G_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Dressing and/or grooming</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500H; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500H_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Eating and/or swallowing</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500I; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500I_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b>Amputation/prostheses care</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2" style="border-top-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QO0500J; ?><?php if (substr($url[3],0,5)!="print"){ if($O0500J_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page32-partwhite">
<ul class="page32-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="10"><b>Communication</b>
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page32-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0600. Physician Examinations</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page32-content2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QO0600_1; ?><?php if (substr($url[3],0,5)!="print"){ if($O06001_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QO0600_2; ?><?php if (substr($url[3],0,5)!="print"){ if($O06002_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page32-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Over the last 14 days, <b>on how many days did the physician (or authorized assistant or practitioner) </b><br><b style="padding-left:0.3125em">examine the resident?</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page32-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>O0700. Physician Orders</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page32-content2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Days</a>
<div style="padding-left:1.75em">
<table>
<tr>
<td class="answer"><?php echo $QO0700_1; ?><?php if (substr($url[3],0,5)!="print"){ if($O07001_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QO0700_2; ?><?php if (substr($url[3],0,5)!="print"){ if($O07002_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page32-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Over the last 14 days, <b>on how many days did the physician (or authorized assistant or practitioner) </b><br><b style="padding-left:0.3125em">change the resident's orders?</b></a></div>
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