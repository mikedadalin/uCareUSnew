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
$sql = "SELECT * FROM `mdsform12` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page12_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page12_Qfiller_name .= $v;
		}else{}
	}
}
}
$page12_Qfiller_name = str_replace(';',', ', $page12_Qfiller_name);
?>
<body class="page12-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page12_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section E</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Behavior</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em">
<tr>
<td class="page12-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E0900. Wandering - Presence & Frequency</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page12-content" style="width:5.875em">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE0900; ?><?php if (substr($url[3],0,5)!="print"){ if($E0900_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page12-partwhite" style="width:50em"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<b style="padding-left:0.5em">Has the resident wandered?</b>
<ol class="page12-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Behavior not exhibited &#8594;</b> Skip to E1100, Change in Behavioral or Other Symptoms
<li><b>Behavior of this type occurred 1 to 3 days</b>
<li><b>Behavior of this type occurred 4 to 6 days,</b> but less than daily
<li><b>Behavior of this type occurred daily</b>
</ol>
</td>
</tr>
<!--------------------------------------------> 
<tr>
<td class="page12-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>E1000. Wandering - Impact</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page12-content" style="border-bottom-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE1000A; ?><?php if (substr($url[3],0,5)!="print"){ if($E1000A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page12-partwhite">
<ul class="page12-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Does the wandering place the resident at significant risk of getting to a potentially dangerous place</b><br>(e.g., stairs, outside of the facility)?
</ul>
<ol class="page12-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page12-content" style="border-top-style:hidden">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE1000B; ?><?php if (substr($url[3],0,5)!="print"){ if($E1000B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page12-partwhite">
<ul class="page12-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Does the wandering significantly intrude on the privacy or activities of others?
</ul>
<ol class="page12-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>No</b>
<li><b>Yes</b>
</ol>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page12-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em">
<b style="padding-left:0.3125em">E1100. Change in Behavior or Other Symptoms</b><br><a style="padding-left:0.3125em">Consider all of the symptoms assessed in items E0100 through E1000</a></div>
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page12-content">
<a style="font-family:serif">Enter Code</a>
<div style="padding-left:2.4em">
<table>
<tr>
<td class="answer"><?php echo $QE1100; ?><?php if (substr($url[3],0,5)!="print"){ if($E1100_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?></td>
</tr>
</table>
</div>
</td>
<td class="page12-partwhite"><div style="margin-top:0.1875em; margin-bottom:0.1875em">
<a style="padding-left:0.3125em">How does resident's current behavior status, care rejection, or wandering <b>compare to prior assessment </b><br><b style="padding-left:0.3125em">(OBRA or PPS)?</b></a>
<ol class="page12-ol" start="0" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Same</b>
<li><b>Improved</b>
<li><b>Worse</b>
<li><b>N/A</b> because no prior MDS assessment
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