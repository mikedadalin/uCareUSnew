<?php
session_start();
include("lwj/lwj.php");
include("class/DB.php");
include("class/DB2.php");
include("class/error.php");
include("class/array.php");
include("class/functionforprint.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="Images/mainLogo.png"></link>
<title>U-ARK America UCare System</title>
<script type="text/javascript" src="js/flot/jquery.js"></script>
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.0.custom.js"></script>
<script type="text/javascript" src="js/custom-form-elements.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="js/flot/excanvas.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.navigate.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.crosshair.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.categories.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.symbol.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="js/jquery.tagsinput.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.validationEngine-zh_TW.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.caret.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.jqueryui.js"></script>
<script type="text/javascript" src="js/lightbox.min.js"></script>
<!--<script type="text/javascript" src='js/jCalendar/lib/jquery.min.js'></script>-->
<script type="text/javascript" src='js/jCalendar/lib/moment.min.js'></script>
<script type="text/javascript" src='js/jCalendar/fullcalendar.js'></script>
<script type="text/javascript" src='js/jCalendar/zh-tw.js'></script>
<script type="text/javascript" src="knobKnob/transform.js"></script>
<script type="text/javascript" src="knobKnob/knobKnob.jquery.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
<link type="text/css" rel="stylesheet" href="css/printstyle.css" />
<link type="text/css" rel="stylesheet" href="css/validationEngine.jquery.css"/>
<link type="text/css" rel="stylesheet" href="css/jquery.tagsinput.css">
<link type="text/css" rel="stylesheet" href="css/jquery.autocomplete.css" />
<link type="text/css" rel="stylesheet" href="css/validationEngine.jquery.css" />
<link type="text/css" rel="stylesheet" href="css/dataTables.jqueryui.css" />
<link type="text/css" rel="stylesheet" href="css/lightbox.css">
<link type="text/css" rel="stylesheet" href="knobKnob/knobKnob.css" />
<link type="text/css" rel='stylesheet' href='css/fullcalendar.css' />
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
<link type="text/css" rel='stylesheet' href='lib/fawesome/css/font-awesome.min.css' />
<link type="text/css" rel='stylesheet' href='css/jquery.datetimepicker.css' />
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);
//$("textarea").replaceWith($("textarea").html());
$("textarea").each(function(){
	var content = $(this).html();
	$(this).replaceWith(content.replace(/\n/g,"<br>"));
});
$("input[type=text]").each(function(){
	var content = $(this).val();
	$(this).replaceWith(content.replace(/\n/g,"<br>"));
});
$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("#printbtn2").hide();$("option:selected").each(function(){var e=$(this);var t=$(this).parent().attr("id");if(e.length){var n=e.text();$("#"+t).replaceWith(""+n+"")}})})
</script>
</head>

<body>

<?php
if (@$_GET['func']=='printmed') {
	$width = '1309px';
} elseif (@$_GET['mod']=='management' && @$_GET['func']=='formview' && @$_GET['id']==3) {
	$width = '100%';
} else {
	$width = '1050px';
}
?>
<div style="width:<?php echo $width; ?>"><center><h3><?php echo $_SESSION['nOrgName_lwj']; ?></h3></center></div>
<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" style="border:none;">
    <div id="printarea"  class="printarea">
<?php
if ($_SESSION['ncareID_lwj']==NULL && @$_GET['func']!="loginprocess") {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
} else {
	include('Language_ResidentTitle.php');
	if (@$_GET['mod']==NULL) {
		if (@$_GET['func']==NULL) { include('home.php'); } else { include(@$_GET['func'].'.php'); }
	} else {
		if (is_file('print/'.@$_GET['mod'].'/form'.@$_GET['id'].'.php')) {
			echo '<style>* { font-family: "Times New Roman", "標楷體" !important; font-size: 12pt !important;  }</style>';
				include('print/'.@$_GET['mod'].'/'.@$_GET['func'].'.php');
		} else {
			if($_GET['mod']=='mdsform'){
		    ?>
			<link type="text/css" rel="stylesheet" href="css/MDS-CSS2.css">
		    <link type="text/css" rel="stylesheet" href="css/MDS-CSS.css">
			<SCRIPT LANGUAGE='JavaScript'>
            <!--// 自動列印: 會彈出印表機交談視窗
            function printPage() {
               window.print();
            }
            //-->
            </SCRIPT>
		    <?php
			echo '<div onLoad="printPage()">';
			include('module/'.@$_GET['mod'].'/form'.@$_GET['id'].'.php');
			echo '</div>';
			}else{
			include('module/'.@$_GET['mod'].'/'.@$_GET['func'].'.php');
			}
		}
	}
	$arrDelayPrintPreview = array("nurseform1a", "socialwork1a_2");
	if (in_array(@$_GET['mod'].@$_GET['id'], $arrDelayPrintPreview)) {
		echo '
		<script>
		$(function () {
			setTimeout(function(){
			  window.print();
			}, 1500);
		});
		</script>';
	} else {
		echo '
		<script>
		$(function () {
			window.print();
		});
		</script>';
	}
}
?>
    </div>
    </td>
  </tr>
</table>
</body>
</html>