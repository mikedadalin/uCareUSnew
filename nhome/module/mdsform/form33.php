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
$sql = "SELECT * FROM `mdsform33` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page33_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page33_Qfiller_name .= $v;
		}else{}
	}
}
}
$page33_Qfiller_name = str_replace(';',', ', $page33_Qfiller_name);
?>
<body class="page33-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page33_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section P</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Restraints</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:1em; width:55.875em"> 
<tr>
<td class="page33-part" colspan="3"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>P0100. Physical Restraints</b></div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page33-partwhite" colspan="3"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Physical restraints are any manual method or physical or mechanical device, material or equipment attached or </a><br><a style="padding-left:0.3125em">adjacent to the resident's body that the individual cannot remove easily which restricts freedom of movement or normal </a><br><a style="padding-left:0.3125em">access to one's body</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page33-partwhite" colspan="1" rowspan="11" style="width:20em">
<b style="padding-left:0.3125em">Coding:</b>
<ol class="page33-ol" start="0">
<li><b>Not used</b>
<li><b>Used less than daily</b>
<li><b>Used daily</b>
</ol>
</td>
<td class="page33-partwhite" colspan="2" style="width:35.875em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:2.7em">&#8595; Enter Codes in Boxes</b></div>
</td>
</tr>
<tr>
<td class="page33-content" style="border-bottom-style:hidden; width:5.875em"></td>
<td class="page33-part" style="width:30em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>Used in Bed</b></div>
</td>
</tr>	  
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Bed rail</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Trunk restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Limb restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Other</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-part" style="border-top-style:hidden; border-bottom-style:hidden"></td>
<td class="page33-part"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b>Used in Chair or Out of Bed</b></div>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Trunk restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100F; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Limb restraint</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100G; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Chair prevents rising</b>
</ul>
</td>
</tr>
<tr>
<td class="page33-content" style="border-top-style:hidden">
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QP0100H; ?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Other</b>
</ul>
</td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section Q</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Participation in Assessment and Goal Setting</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page33-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0100. Participation in Assessment</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page33-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QQ0100A; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Resident participated in assessment</b>
</ul>
<ol class="page33-ol" start="0">
<li><b>No</b>	
<li><b>Yes</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="page33-content" style="border-top-style:hidden; border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QQ0100B; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Family or significant other participated in assessment</b>
</ul>
<ol class="page33-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Resident has no family or significant other</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->	 
<tr> 
<td class="page33-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QQ0100C; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Guardian or legally authorized representative participated in assessment</b>
</ul>
<ol class="page33-ol" start="0">
<li><b>No</b>
<li><b>Yes</b>
<li value="9"><b>Resident has no guardian or legally authorized representative</b>
</ol></div>
</td>
</tr>
<!-------------------------------------------->	 
<tr>
<td class="page33-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0300. Resident's Overall Expectation</b><br><a>Complete only if A0310E = 1</a></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page33-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QQ0300A; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0300A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Select one for resident's overall goal established during assessment process</b>
</ul>
<ol class="page33-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li>Expects to be <b>discharged to the community</b>
<li>Expects to <b>remain in this facility</b>
<li>Expects to be <b>discharged to another facility/institution</b>
<li value="9"><b>Unknown or uncertain</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page33-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QQ0300B; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0300B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Indicate information source for Q0300A</b>
</ul>
<ol class="page33-ol" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Resident</b>
<li>If not resident, then <b>family or significant other</b>
<li>If not resident, family, or significant other, then <b>guardian or legally authorized representative</b>
<li value="9"><b>Unknown or uncertain</b>
</ol>			  
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page33-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>Q0400. Discharge Plan</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page33-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QQ0400A; ?><?php if (substr($url[3],0,5)!="print"){ if($Q0400A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page33-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page33-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Is active discharge planning already occurring for the resident to return to the community?</b>
</ul>
<ol class="page33-ol" start="0">
<li><b>No</b>
<li><b>Yes &#8594; </b>Skip to Q0600, Referral
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