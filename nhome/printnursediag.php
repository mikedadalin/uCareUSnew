<?php
session_start();
include("lwj/lwj.php");
include("class/DB.php");
include("class/DB2.php");
include("class/error.php");
include("class/array.php");
include("class/functionforprint.php");
if ($_SESSION['ncareID_lwj']==NULL) {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
}
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
<link type="text/css" rel="stylesheet" href="css/printstyle.css" />
<script>
$(document).ready(function () {
    $("form :input").attr("readonly", true);
    $("textarea").css("border", "none");
    $("#submit").hide();
    $("input[type=button]").hide();
    $("input[type=text]").each(function() {
		var e = $(this).val();
		$(this).replaceWith(e);
	});
    $("input[type=submit]").hide();
    $("button[type=button]").hide();
    $("input[type=image]").hide();
    $("#backbtn").hide();
    $("#printbtn").hide();
	$("input[id^='Qfiller_']").clone().attr('type','text').insertAfter("input[id^='Qfiller_']").prev().remove();
	$(".nurseform-table").css("width", "970px").css("border", "none");
	$(".content-query").css("width", "970px");
	$("h3").css("padding", "0px").css("margin", "0px").css("font-size", "12pt");
	$(".nurseform-table table").css("width", "960px");
	$( "form:last" ).css("display", "none");
    $("option:selected").each(function () {
        var $this = $(this);
        var id = $(this).parent().attr('id');
        if ($this.length) {
            var selText = $this.text();
            $('#' + id).replaceWith('' + selText + '')
        }
    })
});
</script>
</head>

<body>
<div style="width:1000px"><center><h3><?php echo $_SESSION['nOrgName_lwj']; ?></h3></center></div>
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
		if (@$_GET['mod']==NULL) {
			if (@$_GET['func']==NULL) { include('home.php'); } else { include(@$_GET['func'].'.php'); }
		} else {
			include('module/'.@$_GET['mod'].'/'.@$_GET['func'].'.php');
		}
	}
	?>
    </div>
    </td>
  </tr>
</table>
</body>
</html>