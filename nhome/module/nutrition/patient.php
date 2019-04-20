<?php
$db = new DB;
$db->query("SELECT `patientID`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `patientID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
}
$basicinfo = '<div class="content-query" style="width:510px;">
<table align="center" style="width:510px;">
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
<table width="100%" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
  <tr>
    <td width="150" rowspan="2" valign="top"><div style="background-color:rgba(150,150,150,0.8); padding-top:10px;"><?php include("ResidentCol.php"); ?></div></td>
    <td valign="top">
    <table width="100%">
      <tr>
        <td valign="middle" width="300"><h3 align="center">Body Weight</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <div id="bweightchart" style="width:720px;height:300px; margin-left:20px; background-color:rgba(0,0,0,0.5);"></div><br /><br />
    <table cellpadding="6px" width="100%">
      <tr bgcolor="#f54d5d" style="color:#ffffff;">
        <td>Full name</td>
        <td>Type(s)</td>
        <td>Value(s)</td>
        <td>Weight change</td>
        <td>Measured time</td>
        <td>Uploaded time</td>
        <td>Filled by</td>
      </tr>
      <?php
      $arr188334 = array();
	  $db2 = new DB;
	  $db2->query("SELECT `PatientID`, `date`, `time`, `loinc_18833_4`, `Qfiller` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` ASC, `time` ASC LIMIT 0,30");
	  if ($db2->num_rows()>0) {
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = date("Y-m-d",strtotime($r2['date']))." ".date("H:i",strtotime($r2['time']));
		  $UploadTime = date("Y-m-d",strtotime($r2['date']))." ".date("H:i",strtotime($r2['time']));
		  if ($i%2==0) { $bgcolor = '#feeced'; } else { $bgcolor = '#ffffff'; }
		  foreach ($r2 as $k=>$v) {
		      $arrVitalsign = explode("_",$k);
			  if ($arrVitalsign[0]=="loinc" && $v!="") {
				  $LoincCode = $arrVitalsign[1]."-".$arrVitalsign[2];
				  if ($oldweight=="") {
				      $weightchange = "---";
				  } else {
				      $weightchange = round((($v-$oldweight)/$oldweight)*100,2).' %';
				  }
				  echo '
				      <tr bgcolor="'.$bgcolor.'" align="left">
				          <td><a href="index.php?mod=dailywork&func=patient&pid='.$r2['PatientID'].'" style="color:#5daeb1;">'.$name.'</a></td>
				          <td>'.$arrVital[$LoincCode].'</td>
				          <td>'.$v.'</td>
				          <td>'.$weightchange.'</td>
				          <td>'.$RecordTime.'</td>
				          <td>'.$UploadTime.'</td>
				          <td>'.checkusername($r2['Qfiller']).'</td>
				      </tr>'."\n";
				  $oldweight = $v;
				  $RecordDate = explode(" ",$RecordTime);
				  $arrRecordTime = explode(":",$RecordDate[1]); // 0:Hour 1:Minute 2:Second
				  $arrRecordDate = explode("-",$RecordDate[0]); // 0:Year 1:Month 2:Date
				  $second1970 = mktime($arrRecordTime[0],$arrRecordTime[1],"00",$arrRecordDate[1],$arrRecordDate[2],$arrRecordDate[0]);
				  $second1970ms = $second1970 * 1000;
				  $arr188334[number_format($second1970ms, 0, '.', '')] = $v;
			  }
		  }
	  }
	  ksort($arr188334);
	  foreach ($arr188334 as $k1=>$v1) { $bweight .= "[".$k1.",".$v1."],"; }
	  $bweight=substr($bweight,0,strlen($bweight)-1);
	  $bweight = '['.$bweight.']';
	  } else {
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left">
        <td colspan="7">Currently no data</td>
      </tr>  
		  '."\n";
	  }
	  ?>
    </table>
    <script type="text/javascript">
	$(function () {
		$.plot($("#bweightchart"), [
			{ label: "Body weight",  data: <?php echo $bweight; ?> }
		],
		{
            lines: { show: true },
            points: { show: true },
            xaxis: {
				mode: 'time',
				panRange: [-10, 10],
				'color':'#FFFFFF',
			},
			yaxis: { panRange: [-10, 10], 'color':'#FFFFFF', },
			zoom: { interactive: false },
			pan: { interactive: false },
			grid: {
				markings: [
				  {yaxis: { from: 12, to: 20 },color: "#FFE2CF"}
				],
				hoverable: true
			},
			crosshair: { mode: "x" }
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
		$("#bweightchart").bind("plothover", function (event, pos, item) {
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
    </td>
  </tr>
</table>