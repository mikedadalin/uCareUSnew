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
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:18px;}
.drawformborder { border:solid 1px; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
</style>
</head>

<body>
<?php 
$arrDateNo = explode(";",$_POST['arrDate']);
?>
<center><font size="4"><?php echo $_SESSION['nOrgName_lwj']; ?> <?php echo substr($arrDateNo[3],0,4); ?> year <?php echo (int) substr($arrDateNo[3],5,2); ?> month meal menu </font></center>
<table class="drawformborder" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60" align="center">Cycle</td>
    <td width="180" align="center">Breakfast</td>
    <td width="80" align="center">Morning refreshment</td>
    <td width="180" align="center">Lunch</td>
    <td width="80" align="center">Afternoon refreshment</td>
    <td width="180" align="center">Dinner</td>
    <td width="80" align="center">Night refreshment</td>
    <td width="80" align="center">Memo</td>
  </tr>
<?php
$arrNutritionName = array();
for ($i=0;$i<7;$i++) {
	$db = new DB;
	$db->query("SELECT * FROM `foodmenu` WHERE `date`='".mysql_escape_string(str_replace("-","",$arrDateNo[$i]))."'");
	$r = $db->fetch_assoc();
	
	$arrDateFormat = explode("-",$arrDateNo[$i]);
	$date = $arrDateFormat[1].'/'.$arrDateFormat[2].'<br>('.$arrPHPDay[date(D,strtotime($arrDateNo[$i]))].')';
	
	if (!in_array($r['Qfiller'],$arrNutritionName)) { $arrNutritionName[$r['Qfiller']] = checkusername($r['Qfiller']); }
	
	$db1 = new DB;
	$db1->query("SELECT * FROM `happymeal` WHERE `date`='".$arrDateNo[$i]."'");
	if ($db1->num_rows()>0) {
		$meal7 = 'Happy meal<br>';
	}
	for ($i1=0;$i1<$db1->num_rows();$i1++) {
		$r1 = $db1->fetch_assoc();
		if ($meal7!="Happy meal<br>") { $meal7 .= '<br>'; }
		$meal7 .= $r1['title'];
	}
	echo '
	<tr height="120">
	  <td align="center">'.$date.'</td>
	  <td valign="top" align="center">'.str_replace('Happy meal',$meal7,$r['meal1']).'</td>
	  <td valign="top" align="center">'.str_replace('Happy meal',$meal7,$r['meal2']).'</td>
	  <td valign="top" align="center">'.str_replace('Happy meal',$meal7,$r['meal3']).'</td>
	  <td valign="top" align="center">'.str_replace('Happy meal',$meal7,$r['meal4']).'</td>
	  <td valign="top" align="center">'.str_replace('Happy meal',$meal7,$r['meal5']).'</td>
	  <td valign="top" align="center">'.str_replace('Happy meal',$meal7,$r['meal6']).'</td>
	  <td valign="top" align="center">'.$r['memo'].'</td>
	</tr>'."\n";
}
?>
</table>
<?php
echo 'Filled by staff：'."\n";
$Nname = "";
foreach ($arrNutritionName as $k=>$v) {
	if ($Nname!="") { $Nname .= "、"; }
	$Nname .= $v;
}
echo $Nname;
?>

</body>
</html>