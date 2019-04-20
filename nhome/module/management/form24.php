<?php
/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 60;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }

if (@$_GET['date']==NULL) {
	$year = date(Y); $month = date(m);
} else {
	$year = substr(@$_GET['date'],0,4); $month = substr(@$_GET['date'],4,2);
	$pageString = 'date='.@$_GET['date'];
}
for ($i=0;$i<=5;$i++) {
	${'last'.$i.'month'} = $month-$i;
	if (${'last'.$i.'month'}<=0) {
		${'last'.$i.'year'} = $year-1;
		${'last'.$i.'month'} += 12;
	} else {
		${'last'.$i.'year'} = $year;
	}
	if (strlen(${'last'.$i.'month'})==1) { ${'last'.$i.'month'} = "0".${'last'.$i.'month'}; }
	${'last'.$i.'month'} = ${'last'.$i.'year'}.${'last'.$i.'month'};
}
?>

<h3>Residents' weight statistics (<?php echo $last5month.' ~ '.$last0month; ?>)</h3>
<div align="right">
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
		window.open('index.php?mod=management&func=formview&pid=&id=24&date='+selectedmonth, '_self' );
	}
	</script>
</div>
<table cellpadding="7" style="width:100%;">
	<tr class="title">
		<td rowspan="2" width="70">Bed #</td>
		<td rowspan="2">Full Name</td>
		<td rowspan="2">Height</td>
		<td colspan="2"><?php echo $last5month; ?></td>
		<td colspan="2"><?php echo $last4month; ?></td>
		<td colspan="2"><?php echo $last3month; ?></td>
		<td colspan="2"><?php echo $last2month; ?></td>
		<td colspan="2"><?php echo $last1month; ?></td>
		<td colspan="2"><?php echo $last0month; ?></td>
	</tr>
	<tr class="title">
		<td>Body Weight</td>
		<td>BMI</td>
		<td>Body Weight</td>
		<td>BMI</td>
		<td>Body Weight</td>
		<td>BMI</td>
		<td>Body Weight</td>
		<td>BMI</td>
		<td>Body Weight</td>
		<td>BMI</td>
		<td>Body Weight</td>
		<td>BMI</td>
	</tr>
	<?php
	$arrPersonID = array();
	$db2 = new DB;
	// 原V $db2->query("SELECT DISTINCT `PersonID` FROM `vitalsigns` WHERE `LoincCode`='18833-4' AND `IsValid`='1'");
	// 新V START
	$db2->query("SELECT DISTINCT `PatientID` FROM `vitalsign` WHERE `loinc_18833_4`!=''");
	// 新V END

	for ($i0=0;$i0<$db2->num_rows();$i0++) {
		$r2 = $db2->fetch_assoc();
		/* 原V
		$BedID = getBedID($r2['PersonID']);
		if ($BedID!="") { $arrPersonID[$BedID] = $r2['PersonID']; }
		*/
		// 新V START
		$BedID = getBedID($r2['PatientID']);
		if ($BedID!="") { $arrPersonID[$BedID] = $r2['PatientID']; }
		// 新V END
	}
	ksort($arrPersonID);
	$arrPersonID = array_values($arrPersonID);
	$startloop = ($pn-1)*$ps;
	$endloop = $pn*$ps;

// 總頁次及總筆數
	$totalRecord = count($arrPersonID);
	if($totalRecord < $ps){
		$totalPage = 1;	
	}else{
		if($totalRecord % $ps <> 0){
			$totalPage = ceil($totalRecord / $ps);		
		}else{
			$totalPage = $totalRecord / $ps;
		}
	}

	if ($endloop>count($arrPersonID)) { $endloop = count($arrPersonID); }
//foreach ($arrPersonID as $k=>$v) {
	for ($i2=$startloop;$i2<$endloop;$i2++) {
		$db2c = new DB;
		$db2c->query("SELECT `height` FROM `patient` WHERE `patientID`='".$arrPersonID[$i2]."'");
		$r2c = $db2c->fetch_assoc();
		$BMI = "";
		$height = "";
		if ($r2c['height']!="") {
			$height = $r2c['height'];
			$heightsq = $height*$height;
		}
		
		for ($i1=0;$i1<=5;$i1++) {
			${'last'.$i1.'monthBW'} = "";
			${'last'.$i1.'monthBMI'} = "";
		}
		$db2a = new DB;
		// 原V $db2a->query("SELECT `Value`, `TimeFlag` FROM `vitalsigns` WHERE `PersonID`='".$arrPersonID[$i2]."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND (`TimeFlag` = '".$last5month."' OR `TimeFlag` = '".$last4month."' OR `TimeFlag` = '".$last3month."' OR `TimeFlag` = '".$last2month."' OR `TimeFlag` = '".$last1month."' OR `TimeFlag` = '".$last0month."') ORDER BY `RecordedTime` DESC");
		// 新V START
		$db2a->query("SELECT `loinc_18833_4` AS `Value`, `date` FROM `vitalsign` WHERE `PatientID`='".$arrPersonID[$i2]."' AND `loinc_18833_4`!='' AND (DATE_FORMAT(`date`, '%Y%m') = '".$last5month."' OR DATE_FORMAT(`date`, '%Y%m') = '".$last4month."' OR DATE_FORMAT(`date`, '%Y%m') = '".$last3month."' OR DATE_FORMAT(`date`, '%Y%m') = '".$last2month."' OR DATE_FORMAT(`date`, '%Y%m') = '".$last1month."' OR DATE_FORMAT(`date`, '%Y%m') = '".$last0month."') ORDER BY `date` DESC, `time` DESC");
		// 新V END
		for ($i1=0;$i1<$db2a->num_rows();$i1++) {
			$r2a = $db2a->fetch_assoc();
			// 原V $TimeFlag = $r2a['TimeFlag'];
			// 新V START
			$TimeFlag = date("Ym",strtotime($r2a['date']));
			// 新V END
			switch ($TimeFlag) {
				case $last5month:
				if ($last5monthBW=="") {
					$last5monthBW = $r2a['Value'];
					if ($heightsq!="") { $last5monthBMI = $r2a['Value']/$heightsq*703; $last5monthBMI = round($last5monthBMI,1); }
				}
				break;
				case $last4month:
				if ($last4monthBW=="") {
					$last4monthBW = $r2a['Value'];
					if ($heightsq!="") { $last4monthBMI = $r2a['Value']/$heightsq*703; $last4monthBMI = round($last4monthBMI,1); }
				}
				break;
				case $last3month:
				if ($last3monthBW=="") {
					$last3monthBW = $r2a['Value'];
					if ($heightsq!="") { $last3monthBMI = $r2a['Value']/$heightsq*703; $last3monthBMI = round($last3monthBMI,1); }
				}
				break;
				case $last2month:
				if ($last2monthBW=="") {
					$last2monthBW = $r2a['Value'];
					if ($heightsq!="") { $last2monthBMI = $r2a['Value']/$heightsq*703; $last2monthBMI = round($last2monthBMI,1); }
				}
				break;
				case $last1month:
				if ($last1monthBW=="") {
					$last1monthBW = $r2a['Value'];
					if ($heightsq!="") { $last1monthBMI = $r2a['Value']/$heightsq*703; $last1monthBMI = round($last1monthBMI,1); }
				}
				break;
				case $last0month:
				if ($last0monthBW=="") {
					$last0monthBW = $r2a['Value'];
					if ($heightsq!="") { $last0monthBMI = $r2a['Value']/$heightsq*703; $last0monthBMI = round($last0monthBMI,1); }
				}
				break;
			}
		}
		
		echo '
		<tr bgcolor="'.$bgcolor.'" align="left">
		<td align="center">'.getBedID($arrPersonID[$i2]).'</td>
		<td align="center"><a href="index.php?mod=dailywork&func=formview&pid='.$arrPersonID[$i2].'">'.getPatientName($arrPersonID[$i2]).'</a></td>
		<td align="center">'; 
		if ($height!="") {
			$inch = $r2c['height'];
			$feet = floor($inch/12);
			$inch = $inch%12;
			$height = $feet."'".$inch;
			echo $height;
		}
		echo '</td>
		<td align="center">'.$last5monthBW.'</td>
		<td align="center">'.$last5monthBMI.'</td>
		<td align="center">'.$last4monthBW.'</td>
		<td align="center">'.$last4monthBMI.'</td>
		<td align="center">'.$last3monthBW.'</td>
		<td align="center">'.$last3monthBMI.'</td>
		<td align="center">'.$last2monthBW.'</td>
		<td align="center">'.$last2monthBMI.'</td>
		<td align="center">'.$last1monthBW.'</td>
		<td align="center">'.$last1monthBMI.'</td>
		<td align="center">'.$last0monthBW.'</td>
		<td align="center">'.$last0monthBMI.'</td>
		</tr>'."\n";
	}
	?>
</table>
<!--page Start-->
<table style="border-collapse: collapse; width:100%;" cellpadding="5">
	<tr>
		<td align="center" class="title page">
			<?php
			changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=management&func=formview&pid=&id=24");
			?>
		</td>
	</tr>
</table>
<!--page End-->