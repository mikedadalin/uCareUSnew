<?php
if (@$_GET['date']==NULL) {
	$year = date(Y); $month = date(m);
} else {
	$year = substr(@$_GET['date'],0,4); $month = substr(@$_GET['date'],4,2);
}
for ($i=0;$i<=11;$i++) {
	${'last'.$i.'month'} = $month-$i;
	if (${'last'.$i.'month'}<=0) {
		${'last'.$i.'year'} = $year-1;
		${'last'.$i.'month'} += 12;
	} else {
		${'last'.$i.'year'} = $year;
	}
	if (strlen(${'last'.$i.'month'})==1) { ${'last'.$i.'month'} = "0".${'last'.$i.'month'}; }
	// 原V ${'last'.$i.'month'} = ${'last'.$i.'year'}.'-'.${'last'.$i.'month'};
	// 新V START
	${'last'.$i.'month'} = ${'last'.$i.'year'}.${'last'.$i.'month'};
	// 新V END
}
?>

<h3>Weight record (<?php echo $last11month.' ~ '.$last0month; ?>)</h3>
<table width="100%">
  <tr>
    <td style="background:#ffffff;" align="right">
    <select id="selmonth" onchange="showdate()">
			<option>--Select month--</option>
			<?php
			for ($i=date(m);$i>=(date(m)-12);$i--) {
				$month = $i;
				$year = date(Y);
				if ($i<1) {
					$month = 12+$i;
					$year = date(Y)-1;
				}
				if (strlen($month)==1) {
					$month = "0".$month;
				}
				echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
			}
			?>
		</select>
		<script>
		function showdate() {
			var selectedmonth = document.getElementById('selmonth').value;
			window.open('index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid'];?>&id=3_6&date='+selectedmonth, '_self' );
		}
		</script>
        </td>
  </tr>
</table>
<table cellpadding="6px" width="100%">
  <tr class="title">
    <td>&nbsp;</td>
    <td><?php echo $last11month; ?></td>
    <td><?php echo $last10month; ?></td>
    <td><?php echo $last9month; ?></td>
    <td><?php echo $last8month; ?></td>
    <td><?php echo $last7month; ?></td>
    <td><?php echo $last6month; ?></td>
    <td><?php echo $last5month; ?></td>
    <td><?php echo $last4month; ?></td>
    <td><?php echo $last3month; ?></td>
    <td><?php echo $last2month; ?></td>
    <td><?php echo $last1month; ?></td>
    <td><?php echo $last0month; ?></td>
  </tr>
<?php
$arrPersonID = array();
$db2 = new DB;
// 原V $db2->query("SELECT DISTINCT `PersonID` FROM `vitalsigns` WHERE `LoincCode`='18833-4' AND `IsValid`='1' AND `PersonID`='".mysql_escape_string($_GET['pid'])."'");
// 新V START
$db2->query("SELECT DISTINCT `PatientID` FROM `vitalsign` WHERE `loinc_18833_4`!='' AND `PatientID`='".mysql_escape_string($_GET['pid'])."'");
// 新V END
for ($i0=0;$i0<$db2->num_rows();$i0++) {
	/* 原V
	$r2 = $db2->fetch_assoc();
	$BedID = getBedID($r2['PersonID']);
	if ($BedID!="") { $arrPersonID[$BedID] = $r2['PersonID']; }
	*/
	// 新V START
	$r2 = $db2->fetch_assoc();
	if ($bedID!="") { $arrPersonID[$bedID] = $r2['PatientID']; }
	// 新V END
}
ksort($arrPersonID);
foreach ($arrPersonID as $k=>$v) {
	$r2 = $db2->fetch_assoc();
	
	$db2c = new DB;
	$db2c->query("SELECT `height` FROM `patient` WHERE `patientID`='".$v."'");
	$r2c = $db2c->fetch_assoc();
	$BMI = "";
	$height = "";
	if ($r2c['height']!="") {
		$height = $r2c['height'];
		$heightsq = $height*$height;
	}
	
	for ($i1=0;$i1<=11;$i1++) {
		${'last'.$i1.'monthBW'} = "";
		${'last'.$i1.'monthBMI'} = "";
		
		$db2a = new DB;
		// 原V $db2a->query("SELECT `Value`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".$v."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` LIKE '".${'last'.$i1.'month'}."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		// 新V START
		$db2a->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".$v."' AND `loinc_18833_4`!='' AND `date` LIKE '".${'last'.$i1.'month'}."%' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
		// 新V END
		$r2a = $db2a->fetch_assoc();
		if ($r2a['Value']!="") { ${'last'.$i1.'monthBW'} = $r2a['Value']; } else { ${'last'.$i1.'monthBW'} = "---"; }
		if ($r2a['Value']!="" && $heightsq>0) { ${'last'.$i1.'monthBMI'} = round($r2a['Value']/$heightsq*703,1); } else { ${'last'.$i1.'monthBMI'} = "---"; }
		
		if (${'last'.($i1).'monthBW'}!="---" && ${'last'.($i1-1).'monthBW'}!="---" && ${'last'.($i1-1).'monthBW'}!="0") {
			if (($i1-1)==(-1)){
				${'last'.$i1.'weightchange'} = "---";
			}else{
				${'last'.$i1.'weightchange'} = round(((${'last'.($i1-1).'monthBW'}-${'last'.$i1.'monthBW'})/${'last'.($i1).'monthBW'})*100, 2).'%';
			}
		} else {
			${'last'.$i1.'weightchange'} = "---";
		}
	}
	
	
	echo '
<tr bgcolor="'.$bgcolor.'" align="left">
  <td align="center" class="title_s">Body weight(lbs)</td>
  <td align="center">'.$last11monthBW.'</td>
  <td align="center">'.$last10monthBW.'</td>
  <td align="center">'.$last9monthBW.'</td>
  <td align="center">'.$last8monthBW.'</td>
  <td align="center">'.$last7monthBW.'</td>
  <td align="center">'.$last6monthBW.'</td>
  <td align="center">'.$last5monthBW.'</td>
  <td align="center">'.$last4monthBW.'</td>
  <td align="center">'.$last3monthBW.'</td>
  <td align="center">'.$last2monthBW.'</td>
  <td align="center">'.$last1monthBW.'</td>
  <td align="center">'.$last0monthBW.'</td>
</tr>
<tr bgcolor="'.$bgcolor.'" align="left">
  <td align="center" class="title_s">BMI</td>
  <td align="center">'.$last11monthBMI.'</td>
  <td align="center">'.$last10monthBMI.'</td>
  <td align="center">'.$last9monthBMI.'</td>
  <td align="center">'.$last8monthBMI.'</td>
  <td align="center">'.$last7monthBMI.'</td>
  <td align="center">'.$last6monthBMI.'</td>
  <td align="center">'.$last5monthBMI.'</td>
  <td align="center">'.$last4monthBMI.'</td>
  <td align="center">'.$last3monthBMI.'</td>
  <td align="center">'.$last2monthBMI.'</td>
  <td align="center">'.$last1monthBMI.'</td>
  <td align="center">'.$last0monthBMI.'</td>
</tr>
<tr bgcolor="'.$bgcolor.'" align="left">
  <td align="center" class="title_s">% Change</td>
  <td align="center">---</td>
  <td align="center">'.$last11weightchange.'</td>
  <td align="center">'.$last10weightchange.'</td>
  <td align="center">'.$last9weightchange.'</td>
  <td align="center">'.$last8weightchange.'</td>
  <td align="center">'.$last7weightchange.'</td>
  <td align="center">'.$last6weightchange.'</td>
  <td align="center">'.$last5weightchange.'</td>
  <td align="center">'.$last4weightchange.'</td>
  <td align="center">'.$last3weightchange.'</td>
  <td align="center">'.$last2weightchange.'</td>
  <td align="center">'.$last1weightchange.'</td>
</tr>'."\n";
}
?>
</table><br><br>