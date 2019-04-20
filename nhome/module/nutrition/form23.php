<?php
if (@$_GET['date']==NULL) {
	$thismonth = date("Ym");
	$lastmonth = date(m)-1;
	if ($lastmonth == 0) { $lastyear = date(Y)-1; $lastmonth = 12; } else { $lastyear = date(Y); }
	if (strlen($lastmonth)==1) { $lastmonth = '0'.$lastmonth; }
	$lastmonth = $lastyear.$lastmonth;
} else {
	$thismonth = substr(@$_GET['date'],0,4).substr(@$_GET['date'],4,2);
	$lastmonth = substr(@$_GET['date'],4,2)-1;
	if ($lastmonth == 0) { $lastyear = substr(@$_GET['date'],0,4)-1; $lastmonth = 12; } else { $lastyear = substr(@$_GET['date'],0,4); }
	if (strlen($lastmonth)==1) { $lastmonth = '0'.$lastmonth; }
	$lastmonth = $lastyear.$lastmonth;
}
?>
<div class="moduleNoTab">
	<h3 style="line-height:35px;">Statistical Report For Residents Have Weight Change<br>Greater Than 5% (<?php echo $thismonth; ?>)</h3>
	<div style="float:right;"><form><input type="button" id="btn_show" value="Display only greater than 5%" onclick="$('[class^=notshow5percent]').hide(); $('#btn_notshow').show(); $('#btn_show').hide();" /><input type="button" id="btn_notshow" value="Display all records" onclick="$('[class^=notshow5percent]').show(); $('#btn_show').show(); $('#btn_notshow').hide();" style="display:none;" /></form></div>
	<div style="float:left;">
		<select id="selmonth" onchange="showdate()" style="position:relative; bottom:-7px;">
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
			window.open('index.php?mod=management&func=formview&pid=&id=23&date='+selectedmonth, '_self' );
		}
		</script>
	</div>
	<table cellpadding="6px" width="100%">
		<tr class="title">
			<td>Bed #</td>
			<td>Full name</td>
			<td>Height</td>
			<td>Weight of previous month</td>
			<td>Weight of current month</td>
			<td>Current BMI</td>
			<td>Weight change (%)</td>
			<td>Included in the indicator</td>
		</tr>
		<?php
		$arrPersonID = array();
		/* 原V
		$db2 = new DB;
		$db2->query("SELECT DISTINCT `PersonID` FROM `vitalsigns` WHERE `LoincCode`='18833-4' AND `IsValid`='1'");
		for ($i0=0;$i0<$db2->num_rows();$i0++) {
			$r2 = $db2->fetch_assoc();
			$BedID = getBedID($r2['PersonID']);
			if ($BedID!="") { $arrPersonID[$BedID] = $r2['PersonID']; }
		}
		*/
		// 新V START
		$db2 = new DB;
		$db2->query("SELECT DISTINCT `PatientID` FROM `vitalsign` WHERE `loinc_18833_4`!=''");
		for ($i0=0;$i0<$db2->num_rows();$i0++) {
			$r2 = $db2->fetch_assoc();
			$BedID = getBedID($r2['PatientID']);
			if ($BedID!="") { $arrPersonID[$BedID] = $r2['PatientID']; }
		}
		// 新V END
		ksort($arrPersonID);
		$arrPersonID = array_values($arrPersonID);
		for ($i2=0;$i2<count($arrPersonID);$i2++) {
			$bwchange = "";
			/* 原V
			$db2a = new DB;
			$db2a->query("SELECT `Value`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".$arrPersonID[$i2]."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND DATE_FORMAT(`RecordedTime`, '%Y%m') = '".$thismonth."' ORDER BY `RecordedTime` DESC LIMIT 0,1");
			$r2a = $db2a->fetch_assoc();

			$db2b = new DB;
			$db2b->query("SELECT `Value`, `RecordedTime` FROM `vitalsigns` WHERE `PersonID`='".$arrPersonID[$i2]."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND DATE_FORMAT(`RecordedTime`, '%Y%m') = '".$lastmonth."' ORDER BY `RecordedTime` DESC LIMIT 0,1");
			$r2b = $db2b->fetch_assoc();

			$thismonthbw = $r2a['Value'];
			$thismonthtime = substr($r2a['RecordedTime'],0,10);
			$lastmonthbw = $r2b['Value'];
			$lastmonthtime = substr($r2b['RecordedTime'],0,10);
			*/
			// 新V START
			$db2a = new DB;
			$db2a->query("SELECT `loinc_18833_4` AS `Value`, `date` FROM `vitalsign` WHERE `PatientID`='".$arrPersonID[$i2]."' AND `loinc_18833_4`!='' AND DATE_FORMAT(`date`, '%Y%m') = '".$thismonth."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
			$r2a = $db2a->fetch_assoc();

			$db2b = new DB;
			$db2b->query("SELECT `loinc_18833_4` AS `Value`, `date` FROM `vitalsign` WHERE `PatientID`='".$arrPersonID[$i2]."' AND `loinc_18833_4`!='' AND DATE_FORMAT(`date`, '%Y%m') = '".$lastmonth."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
			$r2b = $db2b->fetch_assoc();

			$thismonthbw = $r2a['Value'];
			$thismonthtime = date("Y-m-d",strtotime($r2a['date']));
			$lastmonthbw = $r2b['Value'];
			$lastmonthtime = date("Y-m-d",strtotime($r2b['date']));
			// 新V END
			
			if ($thismonthbw!="" && $lastmonthbw!="") {
				if ($lastmonthbw==0) {
					$bwchange = '---';
				} elseif ($thismonthbw==0) {
					$bwchange = '---';
				} else {
					$bwchange = round((($thismonthbw-$lastmonthbw)/$lastmonthbw)*100,2);
				}
			}
			

			$db2c = new DB;
			$db2c->query("SELECT `height` FROM `patient` WHERE `patientID`='".$arrPersonID[$i2]."'");
			$r2c = $db2c->fetch_assoc();
			$BMI = "";
			$height = "";
			if ($r2c['height']!="" && $r2c['height']!=0) {
				$height = $r2c['height'];
				$BMI = $thismonthbw/($height*$height)*703;
				$BMI = round($BMI,1);
			}
			if ($BMI==0) { $BMI = ""; }
			$indate = getTitle('inpatientinfo','indate',$arrPersonID[$i2],'patientID','');
			$datediff = calcperiod($indate,@$_GET['date']);
			echo '
			<tr bgcolor="'.$bgcolor.'" align="left" id="row'.$arrPersonID[$i2].'">
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
			<td align="center">'.($lastmonthbw!=""?$lastmonthbw.' lbs<br>('.$lastmonthtime.')':"").'</td>
			<td align="center">'.($thismonthbw!=""?$thismonthbw.' lbs<br>('.$thismonthtime.')':"").'</td>
			<td align="center">'.$BMI.'</td>
			<td align="center">';
			if ($bwchange!="---") {
				if (abs($bwchange)>=5) {
					echo '<script>$("#row'.$arrPersonID[$i2].'").attr("class","show5percent");</script><font color="red">';
				} else {
					echo '<script>$("#row'.$arrPersonID[$i2].'").attr("class","notshow5percent");</script>';
				}
				echo $bwchange;
				if (abs($bwchange)>=5) {
					echo '</font>';
				} echo ' %';
			} echo '</td>
			<td align="center">'; if (abs($bwchange)>=5 && abs($datediff)>30) { echo '<form><input type="hidden" id="sDate_'.$arrPersonID[$i2].'" value="'.$thismonth.'"><input type="hidden" id="bwchange_'.$arrPersonID[$i2].'" value="'.$bwchange.'"><input type="button" value="Included in the indicator" id="addrow_'.$arrPersonID[$i2].'"></form>'; } echo '</td>
			</tr>'."\n";
		}
		?>
	</table>
</div>
<script>
$('input:button[id^="addrow_"]').click(function() {
	var arrID = $(this).attr('id');
	arrID = arrID.split('_');
	var PID = arrID[1];
	$.ajax({
		url: 'class/sixtarget_part6.php',
		type: "POST",
		data: {"PID": PID, "sDate":$("#sDate_"+PID).val(), "bwchange":$("#bwchange_"+PID).val(), "Qfiller":'<?php echo $_SESSION['ncareID_lwj']; ?>' },
		success: function(data) {
			alert(data);
		}
	});
});
</script>