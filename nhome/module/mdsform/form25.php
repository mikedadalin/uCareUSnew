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
$sql = "SELECT * FROM `mdsform25` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page25_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page25_Qfiller_name .= $v;
		}else{}
	}
}
}
$page25_Qfiller_name = str_replace(';',', ', $page25_Qfiller_name);
?>
<body class="page25-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page25_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section M</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Skin Conditions</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.1875em; width:55.875em; border-width:0.5em">
<tr>
<td class="page25-part" style="text-align:center">
<div style="margin-top:0.2em; margin-bottom:0.2em">
<b>Report based on highest stage of existing ulcer(s) at its worst; do not "reverse" stage</b>
</div>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page25-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0100. Determination of Pressure Ulcer Risk</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Check all that apply</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content" style="border-bottom-style:hidden; width:5.875em">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM0100A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="width:50em">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Resident has a stage 1 or greater, a scar over bony prominence, or a non-removable dressing/device</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM0100B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Formal assessment instrument/tool</b>(e.g., Braden, Norton, or other)		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM0100C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Clinical assessment</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM0100Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b>		
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0150. Risk of Pressure Ulcers</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0150; ?><?php if (substr($url[3],0,5)!="print"){ if($M0150_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Is this resident at risk of developing pressure ulcers?</b>
<ol class="page25-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0210. Unhealed Pressure Ulcer(s)</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0210; ?><?php if (substr($url[3],0,5)!="print"){ if($M0210_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Does this resident have one or more unhealed pressure ulcer(s) at Stage 1 or higher?</b>
<ol class="page25-ol" start="0">
<li><b>No &#8594; </b>Skip to M0900, Healed Pressure Ulcers
<li><b>Yes &#8594; </b>Continue to M0300, Current Number of Unhealed Pressure Ulcers at Each Stage
</ol></div>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0300. Current Number of Unhealed Pressure Ulcers at Each Stage</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300A; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of Stage 1 pressure ulcers</b><br><b>Stage 1:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. <br>Darkly pigmented skin may not have a visible blanching; in dark skin tones only it may appear with <br>persistent blue or purple hues			
</ul></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page25-partwhite" style="border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Stage 2:</b> Partial thickness loss of dermis presenting as a shallow open ulcer with a red or pink wound <br>bed, without slough. May also present as an intact or open/ruptured blister
</ul></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300B1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of Stage 2 pressure ulcers</b>- If 0 &#8594; Skip to M0300C, Stage 3
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300B2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Number of <u>these</u> Stage 2 pressure ulcers that were present upon admission/entry or reentry</b>- <br>enter how many were noted at the time of admission/entry or reentry
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page25-partwhite" style="border-top-style:hidden">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Date of oldest Stage 2 pressure ulcer</b><?php if (substr($url[3],0,5)!="print"){ if($M0300B3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>- Enter dashes if date is unknown:<br>
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QM0300B3_1; ?></td>
<td class="answer"><?php echo $QM0300B3_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QM0300B3_3; ?></td>
<td class="answer"><?php echo $QM0300B3_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QM0300B3_5; ?></td>
<td class="answer"><?php echo $QM0300B3_6; ?></td>
<td class="answer"><?php echo $QM0300B3_7; ?></td>
<td class="answer"><?php echo $QM0300B3_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
</li>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page25-partwhite" style="border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Stage 3:</b> Full thickness tissue loss. Subcutaneous fat may be visible but bone, tendon or muscle is not <br>exposed. Slough may be present but does not obscure the depth of tissue loss. May include undermining <br>and tunneling
</ul></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300C1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of Stage 3 pressure ulcers</b>- If 0 &#8594; Skip to M0300D, Stage 4
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300C2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="border-top-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Number of <u>these</u> Stage 3 pressure ulcers that were present upon admission/entry or reentry</b>- <br>enter how many were noted at the time of admission/entry or reentry
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page25-partwhite" style="border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page25-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Stage 4:</b> Full thickness tissue loss with exposed bone, tendon or muscle. Slough or eschar may be <br>present on some parts of the wound bed. Often includes undermining and tunneling
</ul></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300D1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300D1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of Stage 4 pressure ulcers</b>- If 0 &#8594; Skip to M0300E, Unstageable: Non-removable dressing
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300D2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300D2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page25-partwhite" style="border-top-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ol class="page25-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Number of <u>these</u> Stage 4 pressure ulcers that were present upon admission/entry or reentry</b> - <br>enter how many were noted at the time of admission/entry or reentry
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page25-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0300 continued on next page</b></div>
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