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
$sql = "SELECT * FROM `mdsform39` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'";
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
			$page39_Qfiller_name .= $v.';';
		}elseif((count($Qfiller)-$i)==2){
			$page39_Qfiller_name .= $v;
		}else{}
	}
}
}
$page39_Qfiller_name = str_replace(';',', ', $page39_Qfiller_name);
?>
<body class="page39-body">
	<table cellspacing="0" align="center" style="width:55.875em; margin-top:1em; margin-bottom:1em">
	  <tr>
	    <td style="border:hidden">Resident:</td>
	    <td class="sectiontop1"><b><?php echo $name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Identifier:</td>
	    <td class="sectiontop2"><b><?php echo $page39_Qfiller_name; ?></b><hr color="black" align="left" width="100%" size="1"></td>
	    <td style="border:hidden">Date:</td>                             
	    <td class="sectiontop3"><b><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php echo formatdate_Ymd_Slash($date); ?></b><hr color="black" align="left" width="100%" size="1"></td>
	  </tr>
	</table>
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:0.4em">
<tr>
<td class="section" style="width:10.125em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Section X</b></div></td>
<td class="section" style="width:45.54em"><div style="margin-top:0.2em; margin-bottom:0.2em"><b style="padding-left:0.3125em">Correction Request</b></div></td>
</tr>
</table>
<!-------------------------------------------->
<table class="bordercolor" cellpadding="0" cellspacing="0" align="center" style="width:55.875em"> 
<tr>
<td class="page39-part" colspan="2"><div style="margin-top:0.2em; margin-bottom:0.2em"><b>X1100. RN Assessment Coordinator Attestation of Completion</b></div></td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page39-content" rowspan="6" style="width:5.875em"></td>
<td class="page39-partwhite" style="width:50em">
<ul class="page39-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li><b>Attesting individual's first name:</b><?php if (substr($url[3],0,5)!="print"){ if($X1100A_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<div style="margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QX1100A_1; ?></td>
<td class="answer"><?php echo $QX1100A_2; ?></td>
<td class="answer"><?php echo $QX1100A_3; ?></td>
<td class="answer"><?php echo $QX1100A_4; ?></td>
<td class="answer"><?php echo $QX1100A_5; ?></td>
<td class="answer"><?php echo $QX1100A_6; ?></td>
<td class="answer"><?php echo $QX1100A_7; ?></td>
<td class="answer"><?php echo $QX1100A_8; ?></td>
<td class="answer"><?php echo $QX1100A_9; ?></td>
<td class="answer"><?php echo $QX1100A_10; ?></td>
<td class="answer"><?php echo $QX1100A_11; ?></td>
<td class="answer"><?php echo $QX1100A_12; ?></td>
</tr>
</table>
</div>
</ul>
</td>
</tr> 
<!-------------------------------------------->	 
<tr> 
<td class="page39-partwhite"> 
<ul class="page39-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="2"><b>Attesting individual's last name:</b><?php if (substr($url[3],0,5)!="print"){ if($X1100B_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<div style="margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QX1100B_1; ?></td>
<td class="answer"><?php echo $QX1100B_2; ?></td>
<td class="answer"><?php echo $QX1100B_3; ?></td>
<td class="answer"><?php echo $QX1100B_4; ?></td>
<td class="answer"><?php echo $QX1100B_5; ?></td>
<td class="answer"><?php echo $QX1100B_6; ?></td>
<td class="answer"><?php echo $QX1100B_7; ?></td>
<td class="answer"><?php echo $QX1100B_8; ?></td>
<td class="answer"><?php echo $QX1100B_9; ?></td>
<td class="answer"><?php echo $QX1100B_10; ?></td>
<td class="answer"><?php echo $QX1100B_11; ?></td>
<td class="answer"><?php echo $QX1100B_12; ?></td>
<td class="answer"><?php echo $QX1100B_13; ?></td>
<td class="answer"><?php echo $QX1100B_14; ?></td>
<td class="answer"><?php echo $QX1100B_15; ?></td>
<td class="answer"><?php echo $QX1100B_16; ?></td>
<td class="answer"><?php echo $QX1100B_17; ?></td>
<td class="answer"><?php echo $QX1100B_18; ?></td>
</tr>
</table>
</div>
</ul>			
</td>
</tr>
<!-------------------------------------------->
<tr> 
<td class="page39-partwhite"> 
<ul class="page39-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="3"><b>Attesting individual's title:</b><?php if (substr($url[3],0,5)!="print"){ if($X1100C_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</ul><br><?php echo $QX1100C; ?>
</td>
</tr>
<!-------------------------------------------->
<tr>
<td class="page39-partwhite">
<ul class="page39-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="4"><b>Signature</b><?php if (substr($url[3],0,5)!="print"){ if($X1100D_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
</ul><br><?php echo $QX1100D; ?>
</td>
</tr>
<!-------------------------------------------->
<tr> 	  
<td class="page39-partwhite">
<ul class="page39-ul" style="margin-top:0.1875em; margin-bottom:0.1875em">
<li value="5"><b>Attestation date</b><?php if (substr($url[3],0,5)!="print"){ if($X1100E_Red=="0"){echo '<b><a style="font-size:23px; color:red">&#8727</a></b>';} }?>
<div style="padding-left:0.6em; margin-top:0.1875em; margin-bottom:0.1875em">
<table cellspacing="0">
<tr>
<td class="answer"><?php echo $QX1100E_1; ?></td>
<td class="answer"><?php echo $QX1100E_2; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX1100E_3; ?></td>
<td class="answer"><?php echo $QX1100E_4; ?></td>
<td>&nbsp-&nbsp</td>
<td class="answer"><?php echo $QX1100E_5; ?></td>
<td class="answer"><?php echo $QX1100E_6; ?></td>
<td class="answer"><?php echo $QX1100E_7; ?></td>
<td class="answer"><?php echo $QX1100E_8; ?></td>
</tr>
</table>
</div>
<a style="padding-left:0em">Month</a><a style="padding-left:1.2em">Day</a><a style="padding-left:2.4em">Year</a>
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