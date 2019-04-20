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

<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
	<h3>Weight Statistics (<?php echo $last5month.' ~ '.$last0month; ?>)</h3>
	<div align="left"><form><input type="button" onclick="window.location.href='index.php?mod=dailywork&func=resplist2_weight'" value="Input weight"></form></div>
	<table style="width:100%;">
		<tr>
			<td style="background:#ffffff;" align="left">
				Warning level(s): 6 months change &ge;&plusmn; 10%；3 months change &ge;&plusmn; 7.5%；2 months change &ge;&plusmn; 5%
			</td>
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
					window.open('index.php?mod=nutrition&func=formview&pid=&id=24&date='+selectedmonth, '_self' );
				}
				</script>
			</td>
		</tr>
	</table>
	<table id="form24tab" cellpadding="6px" width="100%">
		<thead>
			<tr class="title">
				<th rowspan="2">Resident</th>
				<th rowspan="2">Height</th>
				<th><?php echo $last5month; ?></th>
				<th><?php echo $last4month; ?></th>
				<th><?php echo $last3month; ?></th>
				<th><?php echo $last2month; ?></th>
				<th><?php echo $last1month; ?></th>
				<th><?php echo $last0month; ?></th>
				<th rowspan="2">6 months<br>Weight change</th>
				<th rowspan="2">3 months<br>Weight change</th>
				<th rowspan="2">Recent 2 months<br>Weight change</th>
			</tr>
			<tr class="title">
				<th>Body weight<br>(BMI)</th>
				<th>Body weight<br>(BMI)</th>
				<th>Body weight<br>(BMI)</th>
				<th>Body weight<br>(BMI)</th>
				<th>Body weight<br>(BMI)</th>
				<th>Body weight<br>(BMI)</th>
			</tr>
		</thead>
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
/*$startloop = ($pn-1)*$ps;
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

if ($endloop>count($arrPersonID)) { $endloop = count($arrPersonID); }*/
foreach ($arrPersonID as $k=>$v) {
//for ($i2=$startloop;$i2<$endloop;$i2++) {
	$db2c = new DB;
	$db2c->query("SELECT `height`, `instat` FROM `patient` WHERE `patientID`='".$v."'");
	$r2c = $db2c->fetch_assoc();
	$BMI = "";
	$height = "";
	$indate = getTitle('inpatientinfo','indate',$v,'patientID','');
	if ($r2c['height']!="") {
		$height = $r2c['height'];
		$heightsq = $height*$height;
	}
	
	for ($i1=0;$i1<=5;$i1++) {
		${'last'.$i1.'monthBW'} = "";
		${'last'.$i1.'monthBMI'} = "";
	}
	
	$db2a = new DB;
	// 原V $db2a->query("SELECT `Value`, `TimeFlag` FROM `vitalsigns` WHERE `PersonID`='".$v."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND (`TimeFlag` = '".$last5month."' OR `TimeFlag` = '".$last4month."' OR `TimeFlag` = '".$last3month."' OR `TimeFlag` = '".$last2month."' OR `TimeFlag` = '".$last1month."' OR `TimeFlag` = '".$last0month."') ORDER BY `RecordedTime` DESC");
	// 新V START
	$db2a->query("SELECT `loinc_18833_4` AS `Value`, `date` FROM `vitalsign` WHERE `PatientID`='".$v."' AND `loinc_18833_4`!='' AND (`date` LIKE '".$last5month."%' OR `date` LIKE '".$last4month."%' OR `date` LIKE '".$last3month."%' OR `date` LIKE '".$last2month."%' OR `date` LIKE '".$last1month."%' OR `date` LIKE '".$last0month."%') ORDER BY `date` DESC, `time` DESC");
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
	
	if ($r2c['height']!="") {
		$inch = $r2c['height'];
		$feet = floor($inch/12);
		$inch = $inch%12;
		$height = $feet."'".$inch;
	}
	if ($last5monthBW==0){ $last5monthBW ="";}else{ $last5monthBW = $last5monthBW;}
	if ($last4monthBW==0){ $last4monthBW ="";}else{ $last4monthBW = $last4monthBW;}
	if ($last3monthBW==0){ $last3monthBW ="";}else{ $last3monthBW = $last3monthBW;}
	if ($last2monthBW==0){ $last2monthBW ="";}else{ $last2monthBW = $last2monthBW;}
	if ($last1monthBW==0){ $last1monthBW ="";}else{ $last1monthBW = $last1monthBW;}
	if ($last0monthBW==0){ $last0monthBW ="";}else{ $last0monthBW = $last0monthBW;}
	echo '
	<tr bgcolor="'.$bgcolor.'" align="left"'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':'').'>
	<td>'.getBedID($v).'<br>'.getPatientName($v).'</td>
	<td align="center">'.($r2c['height']!=""?$height:"<center><form><input type=\"button\" name=\"keyHeight_".$v."\"  id=\"keyHeight_".$v."\" value=\"+\"></form></center>").'</td>
	<td align="center">'.$last5monthBW.($last5monthBMI!=""?'<br>('.$last5monthBMI.')':($indate<=$last5month.'31'?"<center><form><input type=\"button\" name=\"keyBW_".$v."_".$last5month."\"  id=\"keyBW_".$v."_".$last5month."\" value=\"+\"></form></center>":"---")).'</td>
	<td align="center">'.$last4monthBW.($last4monthBMI!=""?'<br>('.$last4monthBMI.')':($indate<=$last4month.'31'?"<center><form><input type=\"button\" name=\"keyBW_".$v."_".$last4month."\"  id=\"keyBW_".$v."_".$last4month."\" value=\"+\"></form></center>":"---")).'</td>
	<td align="center">'.$last3monthBW.($last3monthBMI!=""?'<br>('.$last3monthBMI.')':($indate<=$last3month.'31'?"<center><form><input type=\"button\" name=\"keyBW_".$v."_".$last3month."\"  id=\"keyBW_".$v."_".$last3month."\" value=\"+\"></form></center>":"---")).'</td>
	<td align="center">'.$last2monthBW.($last2monthBMI!=""?'<br>('.$last2monthBMI.')':($indate<=$last2month.'31'?"<center><form><input type=\"button\" name=\"keyBW_".$v."_".$last2month."\"  id=\"keyBW_".$v."_".$last2month."\" value=\"+\"></form></center>":"---")).'</td>
	<td align="center">'.$last1monthBW.($last1monthBMI!=""?'<br>('.$last1monthBMI.')':($indate<=$last1month.'31'?"<center><form><input type=\"button\" name=\"keyBW_".$v."_".$last1month."\"  id=\"keyBW_".$v."_".$last1month."\" value=\"+\"></form></center>":"---")).'</td>
	<td align="center">'.$last0monthBW.($last0monthBMI!=""?'<br>('.$last0monthBMI.')':($indate<=$last0month.'31'?"<center><form><input type=\"button\" name=\"keyBW_".$v."_".$last0month."\"  id=\"keyBW_".$v."_".$last0month."\" value=\"+\"></form></center>":"---")).'</td>
	<td align="center">'.($last5monthBW>0 && $last0monthBW!=""?(round((($last0monthBW-$last5monthBW)/$last5monthBW)*100,2)).' %':"").'</td>
	<td align="center">'.($last3monthBW>0 && $last0monthBW!=""?(round((($last0monthBW-$last3monthBW)/$last3monthBW)*100,2)).' %':"").'</td>
	<td align="center">'.($last1monthBW>0 && $last0monthBW!=""?(round((($last0monthBW-$last1monthBW)/$last1monthBW)*100,2)).' %':"").'</td>
	</tr>'."\n";
}
?>
</table>
</div>
<!--page Start
<table width="100%" style="border-collapse: collapse;" cellpadding="5" bordercolor="#f7bbc3" border="1">
  <tr>
    <td align="center" class="title page">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=nutrition&func=formview&pid=&id=24");
    ?>
    </td>
  </tr>
</table>
<!--page End-->
<script>
$(function () {
	$('#form24tab').dataTable({
		'paging':false,
		"aoColumnDefs": [{
			"aTargets":[8],
			"fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
				if(Math.abs(parseFloat(sData)) > "10") {
					$(nTd).css('background-color', '#FFD2D2').css('color', 'red'); // You can use hex code as well
				}
			},                   
		},{
			"aTargets":[9],
			"fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
				if(Math.abs(parseFloat(sData)) > "7.5") {
					$(nTd).css('background-color', '#FFD2D2').css('color', 'red'); // You can use hex code as well
				}
			},                   
		},{
			"aTargets":[10],
			"fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
				if(Math.abs(parseFloat(sData)) > "5") {
					$(nTd).css('background-color', '#FFD2D2').css('color', 'red'); // You can use hex code as well
				}
			},                   
		}]
	});
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 250,
		width: 400,
		modal: true,
		buttons: {
			"Add": function() {
				$.ajax({
					url: "class/nutrition24.php",
					type: "POST",
					data: { "PID": $("#PID").val(), "date": $("#date").val(), "BWvalue": $("#BWvalue").val(), "Qfiller": '<?php echo $_SESSION['ncareID_lwj']; ?>' },
					success: function(data) {
						if (data=="OK") {
							$( "#dialog-form" ).dialog( "close" );
							alert("Success！");
							window.location.reload();
						}
					}
				});
			},
			"Cancel": function() {
				$( "#dialog-form" ).dialog( "close" );
			}
		}
	});
	$( ":input[id^='keyBW_']" ).button().click(function() {
		var id = $(this).attr('id');
		var arrID = id.split('_'); //0:keyBW 1:PID 2:date
		var year = arrID[2].substr(0,4);
		var month = arrID[2].substr(4,2);
		var lastday = daysInMonth(month, year);
		$("#date").val(year+'/'+month+'/01 00:00');
		$( "#date" ).datetimepicker({
			format: 'Y/m/d H:i',
			startDate: year+'/'+month+'/01',
			minDate: year+'/'+month+'/01',
			maxDate: year+'/'+month+'/'+lastday,
			mask: true
		});
		$("#PID").val(arrID[1]);
		openVerificationForm('#dialog-form');
	});
	$( ":input[id^='keyHeight_']" ).button().click(function() {
		var id = $(this).attr('id');
		var arrID = id.split('_'); //0:keyHeight 1:PID
		window.open('index.php?mod=nurseform&func=formview&id=1&pid='+arrID[1]);
	});
});
function daysInMonth(iMonth, iYear) {
	return new Date(iYear, iMonth, 0).getDate();
}
</script>
<div id="dialog-form" title="Body weight" class="dialog-form"> 
	<form>
		<fieldset>
			<table>
				<tr>
					<td class="title">Date</td>
					<td><input type="text" name="date" id="date" size="20"> </td>
				</tr>
				<tr>
					<td class="title">Body weight</td>
					<td><input type="text" name="BWvalue" id="BWvalue" size="20" > lbs<input type="hidden" name="PID" id="PID" /></td>
				</tr>
			</table>
		</fieldset>
	</form>
</div>