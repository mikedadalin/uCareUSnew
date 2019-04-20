<?php
session_start();
include("../../lwj/lwj.php");
include("../../class/DB.php");
include("../../class/DB2.php");
include("../../class/error.php");
include("../../class/array.php");
include("../../class/functionforprint.php");
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
<link rel="shortcut icon" href="../../Images/mainLogo.png"></link>
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
</script>
<style>
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:18px;}
.drawformborder { border:solid 1px; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
</style>
</head>

<body>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `opdinfo` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."' ORDER BY `date` DESC");
$r1 = $db1->fetch_assoc();
$arrSelectedList = explode(';',$r1['patient']);
echo $_SESSION['nOrgName_lwj'].'<br>'.date("Y",strtotime($r1['date'])).' '.getEnglishMonth(date("m",strtotime($r1['date']))).' Clinic Visiting Records '.$r1['department'];
?>
<table width="100%" class="drawformborder" style="border-collapse:collapse; font-size:11pt;">
  <thead>
  <tr style="border-left:3px solid; border-top:3px solid;">
    <td width="70">#</td>
    <td width="70">Bed#</td>
    <td width="70">Name</td>
    <td width="70">Age</td>
    <td width="110">病史</td>
    <td width="160">治療</td>
    <td width="40">熱量</td>
    <td width="40">Body weight</td>
    <td width="40">BMI</td>
    <td>Date</td>
    <td>早AC</td>
    <td>早PC</td>
    <td>午AC</td>
    <td>午PC</td>
    <td>晚AC</td>
    <td>晚PC</td>
  </tr>
  <?php
  $count = 1;
  foreach ($arrSelectedList as $k=>$v) {
	  
	  $db1a = new DB;
	  $db1a->query("SELECT * FROM `opddata` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."' AND `HospNo`='".$v."' ORDER BY `row` ASC");
	  
	  for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		  $r1a = $db1a->fetch_assoc();
		  $arrData = explode('||',$r1a['data']);
		  foreach ($arrData as $k1=>$v1) {
			  $arrData[$k1] = str_replace('//','',$v1);
		  }
		  echo '
	  <tr'.($i1a==0?' style="border-top:3px solid;"':"").'>
		<td style="border-left:3px solid;">'.$arrData[0].'</td>
		<td>'.$arrData[1].'</td>
		<td>'.$arrData[2].'</td>
		<td>'.$arrData[3].'</td>
		<td>'.$arrData[4].'</td>
		<td>'.$arrData[5].'</td>
		<td>'.$arrData[6].'</td>
		<td>'.$arrData[7].'</td>
		<td>'.$arrData[8].'</td>
		<td>'.$arrData[9].'</td>
		<td>'.$arrData[10].'</td>
		<td>'.$arrData[11].'</td>
		<td>'.$arrData[12].'</td>
		<td>'.$arrData[13].'</td>
		<td>'.$arrData[14].'</td>
		<td style="border-right:3px solid;">'.$arrData[15].'</td>
	  </tr>'."\n";
	  }
	  echo '
	  <tr style="border-bottom:3px solid;">
	    <td style="border-left:3px solid;">Note</td>
		<td style="border-right:3px solid;" colspan="15" height="60">&nbsp;</td>
	  </tr>
	  '."\n";
  }
  ?>
  </thead>
</table>
</body>
</html>