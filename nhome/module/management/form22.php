<?php
$arrAreaList = array();
$arrAreaPatientList = array();
$db = new DB;
$db->query("SELECT * FROM `areainfo`");
for ($i1=0;$i1<$db->num_rows();$i1++) {
	$r = $db->fetch_assoc();
	$db1a = new DB;
	$db1a->query("SELECT * FROM `bedinfo` WHERE `Area`='".$r['areaID']."'");
	array_push($arrAreaList, $r['areaID']);
	$arrAreaPatientList[$r['areaID']] = array();
	for ($i2=0;$i2<$db1a->num_rows();$i2++) {
		$r1a = $db1a->fetch_assoc();
		$db1b = new DB;
		$db1b->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r1a['bedID']."'");
		$r1b = $db1b->fetch_assoc();
		if ($r1b['patientID']!="") {
			array_push($arrAreaPatientList[$r['areaID']], $r1b['patientID']);
		}
	}
}

foreach ($arrAreaList as $k1=>$v1) {
	$AreaPatientList = $arrAreaPatientList[$v1];
	foreach ($AreaPatientList as $k2=>$v2) {
		$db2a = new DB;
		// 原V $db2a->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".$v2."' AND `LoincCode`='18833-4' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		// 新V START
		$db2a->query("SELECT `loinc_18833_4` AS `Value` FROM `vitalsign` WHERE `PatientID`='".$v2."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
		// 新V END
		$db2b = new DB;
		$db2b->query("SELECT `height` FROM `patient` WHERE `patientID`='".$v2."'");
		$bmi = 0;
		if ($db2a->num_rows()>0 && $db2b->num_rows()>0) {
			$r2a = $db2a->fetch_assoc();
			$r2b = $db2b->fetch_assoc();
			if ($r2b['height']!="" && $r2b['height']!="0") {
				$height = $r2b['height'];
				$bmi = $r2a['Value']/($height*$height)*703;
				$count1[$v1]++;
				$arrADLscore[$v1] += $bmi;
			}
		}
	}
	if ($count1[$v1]!="") {
		$arrAvgADLScore[$v1] = round($arrADLscore[$v1]/$count1[$v1],1);
	}
}

?>
<h3>Residents' BMI statistic</h3>
<style>
#adlchart table {
	width: auto;
}
#adlchart table tr {
	background:none;
}
</style>
<br />
<center><div id="adlchart" style="width:900px;height:400px; background-color:rgba(0,0,0,0.5);"></div></center>
<table style="margin-top:70px; width:100%;">
	<tr class="title">
		<td>Item(s)</td>
		<?php
		foreach ($arrAreaList as $k1=>$v1) {
			$db3a = new DB;
			$db3a->query("SELECT * FROM `areainfo` WHERE `areaID`='".$v1."'");
			$r3a = $db3a->fetch_assoc();
			$AreaLabel .= "[".$k1.",'".$r3a['areaName']."'],"; 
			echo '<td>'.$r3a['areaName'].'</td>';
			$ADLscore = $arrAvgADLScore[$v1];
			if ($ADLscore == "") { $ADLscore = 0; }
			$ADLchart .= "[".$k1.",".$ADLscore."],";
		}
		$ADLchart=substr($ADLchart,0,strlen($ADLchart)-1);
		$ADLchart = '['.$ADLchart.']';
		$AreaLabel=substr($AreaLabel,0,strlen($AreaLabel)-1);
		$AreaLabel = '['.$AreaLabel.']';
		?>
	</tr>
	<tr>
		<td class="title_s">BMI</td>
		<?php
		foreach ($arrAreaList as $k1=>$v1) {
			echo '<td><center>'.$arrAvgADLScore[$v1].'</center></td>';
		}
		?>
	</tr>
</table>
<br />
<script type="text/javascript">
$(document).ready(function () {
	var data = [
	{ label: "BMI", data: <?php echo $ADLchart; ?>, bars: {fillColor: "#89A54E"}, color: "#89A54E" }];
	var options = {
		xaxis: { mode: null, ticks: <?php echo $AreaLabel; ?>, tickLength: 0, axisLabel: "Floor/area", axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 15, 'color':'#FFFFFF',},
		yaxis: { 'color':'#FFFFFF',},
	//yaxis: { axisLabel: "No of builds", tickDecimals: 0, axisLabelUseCanvas: true, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif", axisLabelPadding: 5},
	grid: { hoverable: true, clickable: false, borderWidth: 1 },
	//legend: { labelBoxBorderColor: "none", position: "right" },
	series: { shadowSize: 1, bars: { show: true, barWidth: 0.6, order: 1 } }
};

$.plot($("#adlchart"), data, options);

});
</script>