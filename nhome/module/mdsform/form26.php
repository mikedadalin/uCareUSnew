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
$sql = "SELECT * FROM `mdsform26` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page26_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page26_Qfiller_name .= $v;
		}else{}
	}
}
}
$page26_Qfiller_name = str_replace(';',', ', $page26_Qfiller_name);
?>
<body class="page26-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page26_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section M</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Skin Conditions</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page26-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0300. Current Number of Unhealed Pressure Ulcers at Each Stage</b> - Continued</div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-bottom-style:hidden; width:5.875em"></td>
<td class="page26-partwhite" style="border-bottom-style:hidden; width:50em">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Unstageable - Non-removable dressing:</b> Known but not stageable due to non-removable dressing/device
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300E1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300E1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of unstageable pressure ulcers due to non-removable dressing/device</b>- If 0 &#8594; Skip to <br>M0300F, Unstageable:Slough and/or eschar
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300E2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300E2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="border-top-style:hidden">
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Number of <u>these</u> unstageable pressure ulcers that were present upon admission/entry or <br>reentry</b>- enter how many were noted at the time of admission/entry or reentry
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page26-partwhite" style="border-bottom-style:hidden">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Unstageable - Slough and/or eschar:</b> Known but not stageable due to coverage of wound bed by slough <br>and/or eschar
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300F1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300F1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of unstageable pressure ulcers due to coverage of wound bed by slough and/or eschar</b>- <br>If 0 &#8594; Skip to M0300G,Unstageable: Deep tissue
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300F2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300F2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="border-top-style:hidden">
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Number of <u>these</u> unstageable pressure ulcers that were present upon admission/entry or <br>reentry</b>- enter how many were noted at the time of admission/entry or reentry
</ol>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page26-partwhite" style="border-bottom-style:hidden">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Unstageable - Deep tissue:</b> Suspected deep tissue injury in evolution
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300G1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300G1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="border-top-style:hidden; border-bottom-style:hidden">
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Number of unstageable pressure ulcers with suspected deep tissue injury in evolution</b>- If 0 <b>&#8594;</b><br>Skip to M0610, Dimensionof Unhealed Stage 3 or 4 Pressure Ulcers or Eschar
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0300G2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0300G2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="border-top-style:hidden">
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Number of <u>these</u> unstageable pressure ulcers that were present upon admission/entry or <br>reentry</b>- enter how many were noted at the time of admission/entry or reentry
</ol>		  
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="border-bottom-style:hidden; width:55.875em">
<tr>
<td class="page26-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0610. Dimensions of Unhealed Stage 3 or 4 Pressure Ulcers or Eschar</b><br><a>Complete only if M0300C1, M0300D1 or M0300F1 is greater than 0</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">If the resident has one or more unhealed Stage 3 or 4 pressure ulcers or an unstageable pressure ulcer due to slough </a><br><a style="padding-left:1em">or eschar, identify the pressureulcer with the largest surface area (length x width) and record in centimeters:</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="border-bottom-style:hidden; width:6.875em">
<div style="padding-left:1em">
<table>
<tr>
<td class="answer"><?php echo $QM0610A_1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610A1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QM0610A_2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610A2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td>.</td>
<td class="answer"><?php echo $QM0610A_3; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610A3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td>cm</td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite" style="width:49em">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Pressure ulcer length:</b> Longest length from head to toe		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:1em">
<table>
<tr>
<td class="answer"><?php echo $QM0610B_1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610B1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QM0610B_2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610B2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td>.</td>
<td class="answer"><?php echo $QM0610B_3; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610B3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td>cm</td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Pressure ulcer width:</b> Widest width of the same pressure ulcer, side-to-side perpendicular <br>(90-degree angle) to length		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="border-top-style:hidden">
<div style="padding-left:1em">
<table>
<tr>
<td class="answer"><?php echo $QM0610C_1; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610C1_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td class="answer"><?php echo $QM0610C_2; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610C2_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td>.</td>
<td class="answer"><?php echo $QM0610C_3; ?><?php if (substr($url[3],0,5)!="print"){ if($M0610C3_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
<td>cm</td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Pressure ulcer depth:</b> Depth of the same pressure ulcer from the visible surface to the <br>deepest area (if depth is unknown, enter a dash in each box)		  
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page26-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0700. Most Severe Tissue Type for Any Pressure Ulcer</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0700; ?></td>
</tr>
</table>
</div>
</td>
<td style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Select the best description of the most severe type of tissue present in any pressure ulcer bed</a>
<ol class="page26-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Epithelial tissue</b> - new skin growing in superficial ulcer. It can be light pink and shiny, even in persons <br>with darkly pigmented skin
<li><b>Granulation tissue</b> - pink or red tissue with shiny, moist, granular appearance
<li><b>Slough</b> - yellow or white tissue that adheres to the ulcer bed in strings or thick clumps, or is mucinous
<li><b>Eschar</b> - black, brown, or tan tissue that adheres firmly to the wound bed or ulcer edges, may be <br>softer or harder than surrounding skin
<li value="9"><b>None of the Above</b>
</ol></div>		  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0800. Worsening in Pressure Ulcer Status Since Prior Assessment (OBRA or Scheduled PPS) or Last </b><br><b style="padding-left:3.7em">Admission/Entry or Reentry</b><br><a>Complete only if A0310E = 0</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page26-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:1em">Indicate the number of current pressure ulcers that were <b>not present or were at a lesser stage</b> on prior assessment <br><a style="padding-left:1em">(OBRA or scheduled PPS) or last entry. If no current pressure ulcer at a given stage, enter 0.</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0800A; ?><?php if (substr($url[3],0,5)!="print"){ if($M0800A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Stage 2</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0800B; ?><?php if (substr($url[3],0,5)!="print"){ if($M0800B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Stage 3</b>	  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page26-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QM0800C; ?><?php if (substr($url[3],0,5)!="print"){ if($M0800C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page26-partwhite">
<ul class="page26-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Stage 4</b>	  
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