<?php
session_start();
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
<!--<link type="text/css" rel="stylesheet" href="css/printstyle.css" />-->
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);$("textarea").css("border","none");$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("option:selected").each(function(){var $this=$(this);var id=$(this).parent().attr('id');if($this.length){var selText=$this.text();$('#'+id).replaceWith(''+selText+'')}})});
$(function() {
	window.print();
});
</script>
<style>
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:14px;}
h3 { margin:4px; }
.drawformborder { border:solid 1px; border-collapse:collapse;}
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
</style>
</head>
<body>
<div style="width:<?php echo $width; ?>"><center><h3><?php echo $_SESSION['nOrgName_lwj']; ?> - Feedback Form</h3>Date：<?php echo formatdate($_GET['date']);?></center></div>
<table width="100%" class="drawformborder" cellpadding="0" cellspacing="0" style="text-align:center">
  <tr>
    <!--<td width="7%">Date</td>-->
	<td width="15%">Name</td>
    <td width="27%">Subject</td>
    <td width="48%">Content</td>
    <td width="10%">URL</td>
  </tr>
    <?php
	$db = new DB;
	$db->query("SELECT * FROM `feedback` WHERE `Status`='1' AND `date`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC");
	if($db->num_rows() > 0){
		for($i=0;$i<$db->num_rows();$i++){
			$r = $db->fetch_assoc();
			$URL = explode("nhome/",$r['URL']);
		echo '	
		<tr>';
			//<td>'.formatdate($r['date']).'</td>
		echo '	
			<td>'.$r['Name'].'</td>
			<td>'.$r['Subject'].'</td>
			<td>'.$r['Content'].'</td>
			<td>'.$URL[1].'</td>
		</tr>
		';
		}
	}
	?>
</table>
</body>
</html>