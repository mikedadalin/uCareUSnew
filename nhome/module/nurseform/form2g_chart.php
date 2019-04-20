<?php
session_start();
include("../../class/DB.php");
include("../../class/DB2.php");
include("../../class/error.php");
include("../../class/array.php");
include("../../class/function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>諾亞克護理資訊系統 U-ARK Nursing Information System</title>
<script type="text/javascript" src="../../js/flot/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-latest.pack.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.10.0.custom.js"></script>
<script type="text/javascript" src="../../js/custom-form-elements.js"></script>
<script type="text/javascript" src="../../js/flot/excanvas.js"></script>
<script type="text/javascript" src="../../js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="../../js/flot/jquery.flot.navigate.js"></script>
<script type="text/javascript" src="../../js/flot/jquery.flot.crosshair.js"></script>
<script type="text/javascript" src="../../js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../../js/flot/jquery.flot.categories.js"></script>
<script type="text/javascript" src="../../js/flot/jquery.flot.orderBars.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="../../js/jquery.tagsinput.js"></script>
<script type="text/javascript" src="../../js/jquery.validationEngine.js" charset="utf-8"></script>
<script type="text/javascript" src="../../js/jquery.validationEngine-zh_TW.js" charset="utf-8"></script>
<script type="text/javascript" src="../../js/jquery.caret.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/dataTables.jqueryui.js"></script>
<link type="text/css" rel="stylesheet" href="../../css/validationEngine.jquery.css"/>
<link type="text/css" rel="stylesheet" href="../../css/jquery.tagsinput.css">
<link type="text/css" rel="stylesheet" href="../../css/jquery-ui-1.10.0.custom.css">
<link type="text/css" rel="stylesheet" href="../../css/jquery.autocomplete.css" />
<link type="text/css" rel="stylesheet" href="../../css/style.css" />
<link type="text/css" rel="stylesheet" href="../../css/validationEngine.jquery.css" />
<link type="text/css" rel="stylesheet" href="../../css/dataTables.jqueryui.css" />
</head>
<body>
<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02g_3` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` ASC";
} else {
	$sql = "SELECT * FROM `nurseform02g_3` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`<='".mysql_escape_string($_GET['date'])."' ORDER BY `date` ASC";
}
$db2a = new DB;
$db2a->query($sql);
$arrMMSE = array();
for ($i=0;$i<$db2a->num_rows();$i++) {
	$r2a = $db2a->fetch_assoc();
	$RecordDate = formatdate($r2a['date']);
	$RecordDate = explode("/",$RecordDate);
	$second1970 = mktime("12","00","00",$RecordDate[1],$RecordDate[2],$RecordDate[0]);
	$second1970ms = $second1970 * 1000;
	$arrMMSE[number_format($second1970ms, 0, '.', '')] = $r2a['Qtotal'];
}
ksort($arrMMSE);
foreach ($arrMMSE as $k1=>$v1) { $mmseTotal .= "[".$k1.",".$v1."],"; }
$mmseTotal=substr($mmseTotal,0,strlen($mmseTotal)-1);
$mmseTotal = '['.$mmseTotal.']';
?>
<div id="mmsechart" style="width:800px;height:150px; margin-top:14px; margin-left:20px;"></div>
<script type="text/javascript">
$(function () {
	$.plot($("#mmsechart"), [
		{ label: "Pressure Sore/Ulcer Risk ",  data: <?php echo $mmseTotal; ?> }
	],
	{
		lines: { show: true },
		points: { show: true },
		xaxis: {
			mode: 'time', timeformat: "%y/%m/%d", axisLabelPadding: 10
		},
		yaxis: {  tickDecimals: 0, panRange: [-10, 10] },
		zoom: { interactive: false },
		pan: { interactive: false },
		grid: {
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
			'background-color': '#fff',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
	}
	var previousPoint = null;
	$("#mmsechart").bind("plothover", function (event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				$("#tooltip").remove();
				var x = item.datapoint[0].toFixed(0), y = item.datapoint[1].toFixed(0);
				var date = new Date();
				date.setTime(x);
				showTooltip(item.pageX, item.pageY, item.series.label + " " + y + "<br>" + date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCDate());
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;            
		}
	});
});
</script>
</body>
</html>