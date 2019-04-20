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
<!--<link type="text/css" rel="stylesheet" href="css/printstyle.css" />-->
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);$("textarea").css("border","none");$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("option:selected").each(function(){var $this=$(this);var id=$(this).parent().attr('id');if($this.length){var selText=$this.text();$('#'+id).replaceWith(''+selText+'')}})});
</script>
<style>
table { border-right:1px solid; border-bottom:1px solid; }
table td { border-top:1px solid; border-left:1px solid; padding:0; }
</style>
</head>

<body>
<?php
$year = substr($_GET['date'],0,4);
$month = substr($_GET['date'],4,2);
$arrCateName = array();
$arrActName = array();
$db1a = new DB;
$db1a->query("SELECT DISTINCT `cateName` FROM `socialform08_act`");
for ($i1a=1;$i1a<=$db1a->num_rows();$i1a++) {
	$r1a = $db1a->fetch_assoc();
	$arrCateName[$i1a] = $r1a['cateName'];
	$db1b = new DB;
	$db1b->query("SELECT * FROM `socialform08_act` WHERE `cateName`='".$r1a['cateName']."'");
	for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		$r1b = $db1b->fetch_assoc();
		$arrActName[$i1a][$r1b['actID']] = $r1b['actName'];
	}
}
$arrPatient = array();
$db1c = new DB;
$db1c->query("SELECT * FROM `socialform08` WHERE `date`>='".$year.$month."01' AND `date`<='".$year.$month."31'");
for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
	$r1c = $db1c->fetch_assoc();
	$HospNo = explode(";",$r1c['HospNo']);
	foreach ($HospNo as $k1c=>$v1c) {
		if (!in_array($v1c,$arrPatient)) {
			array_push($arrPatient, $v1c);
		}
	}
}
if ($db1c->num_rows()==0) { echo '未有此月份資料no data for this month yet'; }
for ($i1d=0;$i1d<count($arrPatient);$i1d++) {
?>
<table cellspacing="0" cellpadding="0" width="100%" align="center">
  <tr>
    <td colspan="2" align="center" height="24" valign="middle"><font size="3"><?php echo $_SESSION['nOrgName_lwj']; ?> - 住民個別活動紀錄表resident individual activity record</font></td>
  </tr>
  <tr height="24">
    <td style="border-right:none; border-top:none; padding-left:20px;">care ID#：<?php echo $arrPatient[$i1d]; ?> 床號bed number：<?php echo getBedID(getPID($arrPatient[$i1d])); ?> Full name：<?php echo getPatientName(getPID($arrPatient[$i1d])); ?></td>
    <td style="border-left:none; border-top:none; padding-right:20px;" width="200" align="right"><?php echo $year.' year '.$month.'  month '; ?></td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%" align="center" style="page-break-after:always;">
  <tr height="24">
    <td colspan="2">項目item</td>
    <?php echo drawsocialform08calwithtext(); ?>
  </tr>
  <?php
  foreach ($arrCateName as $k1=>$v1) {
  ?>
  <?php
      $count = 0;
	  foreach ($arrActName[$k1] as $k2=>$v2) {
  ?>
  <tr height="20">
    <?php if ($count==0) { ?><td width="22" align="center" rowspan="<?php echo count($arrActName[$k1])+2; ?>" style="word-break:break-all;"><?php echo $v1; ?></td><?php } ?>
    <td width="100"><?php echo $v2; ?></td>
    <?php
	echo drawsocialform08cal('1',$arrPatient[$i1d],$k2);
	$count++;
	?>
  </tr>
  <?php
	  }
  ?>
  <tr height="20">
    <td>&nbsp;</td>
    <?php echo drawsocialform08cal('0','',''); ?>
  </tr>
  <tr height="20">
    <td>&nbsp;</td>
    <?php echo drawsocialform08cal('0','',''); ?>
  </tr>
  <?php
  }
  ?>
</table>
<?php
}
?>
</body>
</html>