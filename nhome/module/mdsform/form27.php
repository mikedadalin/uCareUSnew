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
$sql = "SELECT * FROM `mdsform27` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page27_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page27_Qfiller_name .= $v;
		}else{}
	}
}
}
$page27_Qfiller_name = str_replace(';',', ', $page27_Qfiller_name);
?>
<body class="page27-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page27_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
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
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page27-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b>M0900. Healed Pressure Ulcers</b><br><a>Complete only if A0310E = 0</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-bottom-style:hidden; width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QM0900A; ?><?php if (substr($url[3],0,5)!="print"){ if($M0900A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Were pressure ulcers present on the prior assessment (OBRA or scheduled PPS)?</b>
</ul>
<ol class="page27-ol" start="0">
<li><b>No &#8594; </b>Skip to M1030, Number of Venous and Arterial Ulcers
<li><b>Yes &#8594; </b>Continue to M0900B, Stage 2
</ol></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
</td>
<td class="page27-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">Indicate the number of pressure ulcers that were noted on the prior assessment (OBRA or scheduled PPS) </a><br><a style="padding-left:0.3125em">that have completely closed (resurfaced with epithelium). If no healed pressure ulcer at a given stage since </a><br><a style="padding-left:0.3125em">the prior assessment (OBRA or scheduled PPS), enter 0.</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QM0900B; ?><?php if (substr($url[3],0,5)!="print"){ if($M0900B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Stage 2</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QM0900C; ?><?php if (substr($url[3],0,5)!="print"){ if($M0900C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Stage 3</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QM0900D; ?><?php if (substr($url[3],0,5)!="print"){ if($M0900D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div></div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Stage 4</b>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page27-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>M1030. Number of Venous and Arterial Ulcers</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="font-family:serif">Enter Number</a>
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer"><?php echo $QM1030; ?></td>
</tr>
</table>
</div></div>
</td>
<td class="page27-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Enter the total number of venous and arterial ulcers present</b></div>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page27-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>M1040. Other Ulcers, Wounds and Skin Problems</div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page27-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all that apply</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-bottom-style:hidden">
</td>
<td class="page27-content2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Foot Problems</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Infection of the foot</b> (e.g., cellulitis, purulent drainage)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Diabetic foot ulcer(s)</b>		
</ul>			
</td>
</tr>
<!-------------------------------------------->	  
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Other open lesion(s) on the foot</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
</td>
<td class="page27-content2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">Other Problems</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Open lesion(s) other than ulcers, rashes, cuts</b> (e.g., cancer lesion)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Surgical wound(s)</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040F; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Burn(s) (second or third degree)</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040G; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Skin tear(s)</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040H; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Moisture Associated Skin Damage (MASD)</b>	(i.e. incontinence (IAD), perspiration, drainage)  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
</td>
<td class="page27-content2"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.3125em">None of the Above</b></a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1040Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b> were present		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page27-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>M1200. Skin and Ulcer Treatments</div></td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page27-partwhite" colspan="2"><div style="margin-top:0.1875em; margin-bottom:0.1875em"><b style="padding-left:2.7em">&#8595; Check all that apply</div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200A; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Pressure reducing device for chair</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200B; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Pressure reducing device for bed</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200C; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Turning/repositioning program</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200D; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Nutrition or hydration intervention</b> to manage skin problems		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200E; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Pressure ulcer care</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200F; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="6"><b>Surgical wound care</b>		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200G; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="7"><b>Application of nonsurgical dressings</b> (with or without topical medications) other than to feet		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200H; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="8"><b>Applications of ointments/medications</b> other than to feet		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden; border-bottom-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200I; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="9"><b>Application of dressings to feet</b> (with or without topical medications)		  
</ul>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page27-content" style="border-top-style:hidden">
<div style="padding-left:2.5em">
<table>
<tr>
<td class="answer2"><?php echo $QM1200Z; ?></td>
</tr>
</table>
</div>
</td>
<td class="page27-partwhite">
<ul class="page27-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="26"><b>None of the above</b> were provided		  
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