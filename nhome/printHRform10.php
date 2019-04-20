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
</script>
<style>
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:10pt;}
.drawformborder { border:solid 1px; border-collapse:collapse; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
.title { font-weight:bold; }
</style>
</head>

<body>
<?php
$EmpID = (int) @$_GET['EmpID'];
$db5a = new DB;
$db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."';");
$r5a = $db5a->fetch_assoc();
$Name = $r5a['Name'];
$Position = $r5a['Position'];
$Position2 = $r5a['Position2'];

?>
<table width="800" style="border:none;">
  <tr>
    <td><center><font size="5"><b><?php echo $_SESSION['nOrgName_lwj']; ?></b></font></center></td>
  </tr>
  <tr>
    <td>&nbsp;<br /><center><font size="5"><b>Transfer list</b></font></center></td>
  </tr>
</table>
<table width="800" class="drawformborder" cellpadding="0" cellspacing="0" style="font-size:12pt;">
	<tr>
    	<td width="120" class="title">Unit</td>
        <td width="120">&nbsp;</td>
        <td width="120" class="title">Title</td>
        <td width="120"><?php echo $Position;?></td>
        <td width="120" class="title">Full name</td>
        <td width="120"><?php echo $Name;?></td>
    </tr>
</table>
<br />
<table width="800" class="drawformborder" cellpadding="0" cellspacing="0" style="font-size:12pt;">
<tr class="title">
  <td>Handover item</td>
  <td>Quantity of handover</td>
  <td>Contents</td>
  <td>Not yet progressed focus</td>
  <td>Handover personnel</td>
  <td>Handover supervised by</td>
  <td>Handover date</td>
</tr>
<?php
if ($_GET['EmpID']!="") {
	$EmpID = (int) @$_GET['EmpID'];
} else {
	$EmpID = "";
}

$sql1 = "SELECT * FROM `humanresource10` WHERE `EmpID`='".$EmpID."'";
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	echo '
<tr>
  <td>'.$title.'</td>
  <td>'.$qty.'</td>
  <td>'.str_replace("\n","<br>",$content1).'</td>
  <td>'.$content2.'</td>
  <td>'.getEmployerName($handover).'</td>
  <td>'.getEmployerName($Qfiller).'</td>
  <td>'.$date.'</td>
</tr>'."\n";
}
?>
<tr>
  <td colspan="7"><ol><li>工作交接完整始離職</li><li>公物毀損或不見視情況須賠償其原來價格</li><li>若有交接不清楚或未完成事項或活動用物教材交代不清時，申請人須無條件配合工作單位的詢問，以協助尋找</li></ol></td>
</tr>
</table>
&nbsp;<br />
<span style="line-height:30px; font-size:12pt;">院長：　　　　　　　　　副院長：　　　　　　　　　秘書：　　　　　　　　　人事單位：</span>
</body>
</html>