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
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:18px;}
h3 { margin:4px; }
.drawformborder { border:solid 1px; border-collapse:collapse;}
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
</style>
</head>

<body>
<div style="width:<?php echo $width; ?>"><center><h3><?php echo $_SESSION['nOrgName_lwj']; ?> - Nursing document handover table</h3>Date:<?php echo formatdate($_GET['date']);?></center></div>

<table width="100%" class="drawformborder" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%"></td>
    <td width="13%">New admission</td>
    <td width="13%">Discharge (checked-out)</td>
    <td width="16%">Hospitalization number</td>
    <td width="16%">Returned from hospital</td>
    <td width="16%">Number of death</td>
    <td width="17%">Resident daily census</td>
  </tr>
  <?php
  $db0 = new DB;
  $db0->query("SELECT * FROM `dailypatientno` WHERE DATE_FORMAT(`date`,'%Y%m%d')='".mysql_escape_string($_GET['date'])."'");
  if ($db0->num_rows()>0) {
      $r0 = $db0->fetch_assoc();
     echo '
	 <tr>
     <td></td>
     <td align="center">'.$r0['newpat'].'</td>
     <td align="center">'.$r0['outpat'].'</td>
     <td align="center">'.$r0['hosppat'].'</td>
     <td align="center">'.$r0['backpat'].'</td>
     <td align="center">'.$r0['deadpat'].'</td>
     <td align="center">'.$r0['no'].'</td>
     '."\n";
  } else {
     echo '
     <td colspan="7">沒有資料</td>
     '."\n"; 
  }
  ?>
  </tr>
  <tr>
    <td colspan="3" width="33%">白天交班內容</td>
    <td colspan="2" width="33%">小夜交班內容</td>
    <td colspan="2" width="34%">大夜交班內容</td>
  </tr>
    <?php
	$db0 = new DB;
	$db0->query("SELECT * FROM `nurseform24` WHERE 1 AND `Q1`='0' AND `Q4`=0 AND `date`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC, `Q1`");
	$db1 = new DB;
	$db1->query("SELECT * FROM `nurseform24` WHERE 1 AND `Q1`='1' AND `Q4`=0 AND `date`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC, `Q1`");
	$db2 = new DB;
	$db2->query("SELECT * FROM `nurseform24` WHERE 1 AND `Q1`='2' AND `Q4`=0 AND `date`='".mysql_escape_string($_GET['date'])."' ORDER BY `date` DESC, `Q1`");
	$max = max(array($db0->num_rows(), $db1->num_rows(), $db2->num_rows()));
	if($max > 0){
		for($i=0;$i<$max;$i++){
			$r0 = $db0->fetch_assoc();
			$r1 = $db1->fetch_assoc();
			$r2 = $db2->fetch_assoc();
		echo '	
		<tr>
			<td colspan="3">'.$r0['Q2'].'</td>
			<td colspan="2">'.$r1['Q2'].'</td>
			<td colspan="2">'.$r2['Q2'].'</td>
		</tr>
		';
		}
	}
	?>
</table>
</body>
</html>