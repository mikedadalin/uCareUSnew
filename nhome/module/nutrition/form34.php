<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<h3>Blood glucose record</h3>
<?php
$basicinfo = '<div class="content-query" style="width:100%;">
<table align="center" style="width:100%;">
  <tr>
    <td class="title">Full name</td>
    <td>'.$name.'</td>
    <td class="title">DOB</td>
    <td>'.$birth.'</td>
    <td class="title">Admission date</td>
    <td>'.$indate.'</td>
  </tr>
</table>
</div>'."\n";
?>
<table style="width:100%;">
   <tr style="background-color:rgba(255,255,255,0)">
     <!--<td valign="middle"><h3><font color="#D80001">Blood glucose</font></h3></td>-->
     <td><?php echo $basicinfo; ?></td>
   </tr>
</table><br><center>
<div id="bgchart" style="width:90%; height:300px; background-color:rgba(0,0,0,0.5);"></div></center><br />
<table cellpadding="6px" style="width:100%;">
  <tr class="title">
    <td>Full name</td>
    <td>Type(s)</td>
    <td>Value(s)</td>
    <td>Measured time</td>
    <td>Uploaded time</td>
    <td>Filled by</td>
  </tr>
<?php
/* 原V
$arr14743 = array();
$arr15075 = array();
$db2 = new DB;
$db2->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND (`LoincCode`='15075-5' OR `LoincCode`='14743-9') AND `IsValid`='1' ORDER BY `RecordedTime` DESC LIMIT 0,50");
if ($db2->num_rows()>0) {
	for ($i=0;$i<$db2->num_rows();$i++) {
		$r2 = $db2->fetch_assoc();
		$RecordTime = explode(".",$r2['RecordedTime']);
		$UploadTime = explode(".",$r2['UploadedTime']);
		if ($i%2==0) { $bgcolor = ''; } else { $bgcolor = ''; }
		echo '
	  <tr class="'.$bgcolor.'" align="left">
        <td align="center"><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PersonID'].'">'.$name.'</a></td>
        <td align="center">'.$arrVital[$r2['LoincCode']].'</td>
        <td align="center">'.$r2['Value'].'</td>
        <td align="center">'.$RecordTime[0].'</td>
        <td align="center">'.$UploadTime[0].'</td>
        <td align="center">'.checkusername($r2['Qfiller']).'</td>
      </tr>
	    '."\n";
		$RecordDate = explode(" ",$RecordTime[0]);
		$arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
		$arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
		$second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],$arrRecordTime[2],$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
		$second1970ms = $second1970 * 1000;
		if ($r2['LoincCode']=='14743-9') {
			$arr14743[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
		} elseif ($r2['LoincCode']=='15075-5') {
			$arr15075[number_format($second1970ms, 0, '.', '')] = $r2['Value'];
		}
	}
	ksort($arr14743);
	ksort($arr15075);
	foreach ($arr14743 as $k1=>$v1) { $acbg .= "[".$k1.",".$v1."],"; }
	foreach ($arr15075 as $k2=>$v2) { $pcbg .= "[".$k2.",".$v2."],"; }
	$acbg=substr($acbg,0,strlen($acbg)-1);
	$acbg = '['.$acbg.']';
	$pcbg=substr($pcbg,0,strlen($pcbg)-1);
	$pcbg = '['.$pcbg.']';
} else {
	echo '
	<tr bgcolor="'.$bgcolor.'" align="left">
	  <td colspan="6">Currently no data</td>
	</tr>  '."\n";
}
*/
// 新V START
$arr14743 = array();
$arr15075 = array();
$db2 = new DB;
$db2->query("SELECT `PatientID`, `date`, `time`, `loinc_14743_9`, `loinc_15075_5`, `Qfiller` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND (`loinc_15075_5`!='' || `loinc_14743_9`!='') ORDER BY `date` DESC, `time` DESC LIMIT 0,50");
if ($db2->num_rows()>0) {
	for ($i=0;$i<$db2->num_rows();$i++) {
		$r2 = $db2->fetch_assoc();
		$RecordTime = date("Y-m-d",strtotime($r2['date']))." ".date("H:i",strtotime($r2['time']));
		$UploadTime = date("Y-m-d",strtotime($r2['date']))." ".date("H:i",strtotime($r2['time']));
		if ($i%2==0) { $bgcolor = ''; } else { $bgcolor = ''; }
		foreach ($r2 as $k=>$v) {
			$arrVitalsign = explode("_",$k);
			if ($arrVitalsign[0]=="loinc" && $v!="") {
				$LoincCode = $arrVitalsign[1]."-".$arrVitalsign[2];
				echo '
					<tr class="'.$bgcolor.'" align="left">
						<td align="center"><a href="index.php?mod=dailywork&func=formview&pid='.$r2['PatientID'].'">'.$name.'</a></td>
						<td align="center">'.$arrVital[$LoincCode].'</td>
						<td align="center">'.$v.'</td>
						<td align="center">'.$RecordTime.'</td>
						<td align="center">'.$UploadTime.'</td>
						<td align="center">'.checkusername($r2['Qfiller']).'</td>
					</tr>'."\n";
					
				$RecordDate = explode(" ",$RecordTime);
				$arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
				$arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
				$second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],"00",$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
				$second1970ms = $second1970 * 1000;
				if ($LoincCode=='14743-9') {
					$arr14743[number_format($second1970ms, 0, '.', '')] = $v;
				} elseif ($LoincCode=='15075-5') {
					$arr15075[number_format($second1970ms, 0, '.', '')] = $v;
				}
			}
		}
	}
	ksort($arr14743);
	ksort($arr15075);
	foreach ($arr14743 as $k1=>$v1) { $acbg .= "[".$k1.",".$v1."],"; }
	foreach ($arr15075 as $k2=>$v2) { $pcbg .= "[".$k2.",".$v2."],"; }
	$acbg=substr($acbg,0,strlen($acbg)-1);
	$acbg = '['.$acbg.']';
	$pcbg=substr($pcbg,0,strlen($pcbg)-1);
	$pcbg = '['.$pcbg.']';
} else {
	echo '
	<tr bgcolor="'.$bgcolor.'" align="left">
	  <td colspan="6">Currently no data</td>
	</tr>  '."\n";
}
// 新V END
?>
</table><br>
</div>
    <script type="text/javascript">
	$(function () {
		$.plot($("#bgchart"), [
			{ label: "AC Blood glucose",  data: <?php echo $acbg; ?> },
			{ label: "PC Blood glucose",  data: <?php echo $pcbg; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color':'#FFFFFF'
			},
			yaxis: { panRange: [-10, 10], 'color':'#FFFFFF' },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 80, to: 90 },color: "#FFE2CF"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" },
			legend: { position:"nw" }
		});
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#bgchart").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
					var date = new Date();
					date.setTime(x);
					showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate() + ' ' + date.getUTCHours() + ':' + date.getUTCMinutes() );
				}
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
		});
	});
    </script>
    <style>
	.legend table { width:100px; text-align:left; }
	.legend table tr td { background:#fff; opacity:0.85; }
	</style>