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
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:14pt;}
sup { font-size:13pt; }
.drawformborder { border:solid 1px; border-collapse:collapse; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; }
.title { font-weight:bold; }
</style>
</head>

<body>
<?php
if (@$_GET['date']==NULL) {
	$getdate = date("Y-m-d");
	$arrDates = getdays($getdate);
} else {
	$getdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2).'-'.substr(@$_GET['date'],6,2);
	$arrDates = getdays($getdate);
}

$d = new DateTime($arrDates[0]);
$dlw = new DateTime($arrDates[0]);
$dnw = new DateTime($arrDates[0]);

$d->modify("+0 day"); $d1 = $d->format('Y/m/d'); $sd1 = $d->format('m/d'); $td1 = $d->format('Ymd');
$d->modify('+1 day'); $d2 =  $d->format('Y/m/d'); $sd2 = $d->format('m/d'); $td2 = $d->format('Ymd');
$d->modify('+1 day'); $d3 =  $d->format('Y/m/d'); $sd3 = $d->format('m/d'); $td3 = $d->format('Ymd');
$d->modify('+1 day'); $d4 =  $d->format('Y/m/d'); $sd4 = $d->format('m/d'); $td4 = $d->format('Ymd');
$d->modify('+1 day'); $d5 =  $d->format('Y/m/d'); $sd5 = $d->format('m/d'); $td5 = $d->format('Ymd');
$d->modify('+1 day'); $d6 =  $d->format('Y/m/d'); $sd6 = $d->format('m/d'); $td6 = $d->format('Ymd');
$d->modify('+1 day'); $d7 =  $d->format('Y/m/d'); $sd7 = $d->format('m/d'); $td7 = $d->format('Ymd');

$dlw->modify('-7 day'); $lastweek = $dlw->format('Ymd');
$dnw->modify('+7 day'); $nextweek = $dnw->format('Ymd');

$db_area = new DB;
$db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
$arrArea = array();
for ($i=0;$i<$db_area->num_rows();$i++) {
	$r_area = $db_area->fetch_assoc();
	$arrArea[$r_area['areaID']] = $r_area['areaName'];
}

//$arrShift = array("A"=>"D", "B"=>"8-12", "C"=>"8-13", "D"=>"8-17", "E"=>"E", "F"=>"N", "G"=>"OFF", "H"=>"off", "I"=>"ALL", "J"=>"L", "K"=>"C+H", "L"=>"CHEF", "M"=>"KH", "L"=>"N");
$dbShift = new DB;
$dbShift->query("SELECT * FROM `shift` ORDER BY `shiftid`");
$arrShift = array();
for ($i=0;$i<$dbShift->num_rows();$i++) {
	$r_shift = $dbShift->fetch_assoc();
	$arrShift[$r_shift['shiftid']] = $r_shift['name'];
}
?>
<div style="width:100%" align="center">
<h3 style="margin:0px;">Weekly shift duty list (<?php echo $d1; ?> ~ <?php echo $d7; ?>)</h3>
<?php
$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group` ORDER BY `order` ASC");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}
?>
<table style="width:920px;" class="drawformborder">
  <tr class="title">
    <td>&nbsp;</td>
    <td align="center"><?php echo $sd1; ?> (一)Mon</td>
    <td align="center"><?php echo $sd2; ?> (二)Tues</td>
    <td align="center"><?php echo $sd3; ?> (三)Wed</td>
    <td align="center"><?php echo $sd4; ?> (四)Thur</td>
    <td align="center"><?php echo $sd5; ?> (五)Fri</td>
    <td align="center"><?php echo $sd6; ?> (六)Sat</td>
    <td align="center"><?php echo $sd7; ?> (日)Sun</td>
  </tr>
  <tr>
  <?php
  for ($i3=1;$i3<=7;$i3++) {
	  $db3a = new DB;
	  $db3a->query("SELECT * FROM `shift_memo` WHERE `date`='".${'td'.$i3}."'");
	  $r3a = $db3a->fetch_assoc();
	  ${'memo_'.$r3a['date']} = $r3a['text'];
  }
  if($_GET['lof']==1 || $_GET['lof']==""){
  ?>
    <td>Note item</td>
    <td><?php echo ${'memo_'.$td1}; ?></td>
    <td><?php echo ${'memo_'.$td2}; ?></td>
    <td><?php echo ${'memo_'.$td3}; ?></td>
    <td><?php echo ${'memo_'.$td4}; ?></td>
    <td><?php echo ${'memo_'.$td5}; ?></td>
    <td><?php echo ${'memo_'.$td6}; ?></td>
    <td><?php echo ${'memo_'.$td7}; ?></td>
  </tr>
  <?php
  }
  foreach ($arrGroupName as $k=>$v) {
	  if($_GET['lof']==1 || $_GET['lof']==""){
		  $sql1 = "SELECT * FROM `shift_member` WHERE `available`='1' AND `GroupID`='".$k."' ORDER BY `order` ASC";
	  } else {
		  $sql1 = "SELECT * FROM  `shift_member` WHERE (`EmpID` IN (SELECT DISTINCT  `foreignID` FROM  `foreignemployer_shift2` WHERE `date` BETWEEN '".$td1."' AND '".$td7."') ";
		  $sql1 .=" OR `EmpID` IN (SELECT DISTINCT `EmpID` FROM `employer_shift2` WHERE `date` BETWEEN '".$td1."' AND '".$td7."')) ";
		  $sql1 .=" AND GroupID = '".$k."' ORDER BY  `EmpGroup` ,  `GroupID` ,  `order` ";
	  }	  
	  $db1 = new DB;
	  $db1->query($sql1);
	  //$arrEmpName = array();
	  for ($i=0;$i<$db1->num_rows();$i++) {
		  $r1 = $db1->fetch_assoc();
		  if ($r1['EmpGroup']==1) {
			  $table = "employer";
			  $NameColName = "Name";
			  $IDColName = "EmpID";
			  $IDColName2 = "EmpID";
			  $table_shift = "employer_shift".$_GET['lof'];
			  $db1a = new DB;
			  $db1a->query("SELECT `".$NameColName."` FROM `".$table."` WHERE `".$IDColName."`='".$r1['EmpID']."'");
			  $r1a = $db1a->fetch_assoc();
			  //$arrEmpName[$r1[$IDColName]] = $r1a[$NameColName];
			  $EmpName = $r1a[$NameColName];
		  } elseif ($r1['EmpGroup']==2) {
			  $table = "foreignemployer";
			  $NameColName = "cNickname";
			  $IDColName = "foreignID";
			  $IDColName2 = "EmpID";
			  $table_shift = "foreignemployer_shift".$_GET['lof'];
			  $db1a = new DB;
			  $db1a->query("SELECT `".$NameColName."`, `eNickname` FROM `".$table."` WHERE `".$IDColName."`='".$r1['EmpID']."'");
			  $r1a = $db1a->fetch_assoc();
			  //$arrEmpName[$r1[$IDColName]] = $r1a[$NameColName].' '.$r1a['eNickname'];
			  $EmpName = $r1a[$NameColName].' '.$r1a['eNickname'];
		  }
		  $db2a = new DB;
		  $db2a->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td1."'");
		  $r2a = $db2a->fetch_assoc();
		  $db2b = new DB;
		  $db2b->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td2."'");
		  $r2b = $db2b->fetch_assoc();
		  $db2c = new DB;
		  $db2c->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td3."'");
		  $r2c = $db2c->fetch_assoc();
		  $db2d = new DB;
		  $db2d->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td4."'");
		  $r2d = $db2d->fetch_assoc();
		  $db2e = new DB;
		  $db2e->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td5."'");
		  $r2e = $db2e->fetch_assoc();
		  $db2f = new DB;
		  $db2f->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td6."'");
		  $r2f = $db2f->fetch_assoc();
		  $db2g = new DB;
		  $db2g->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td7."'");
		  $r2g = $db2g->fetch_assoc();
		  $error = 0;
		  echo '
	  <tr height="38">
		<td class="title_s" width="140" style="font-size:13pt;">'.$EmpName.'</td>
		<td align="center">'.$arrShift[$r2a['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2a['area']))).'</sup></td>
		<td align="center">'.$arrShift[$r2b['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2b['area']))).'</sup></td>
		<td align="center">'.$arrShift[$r2c['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2c['area']))).'</sup></td>
		<td align="center">'.$arrShift[$r2d['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2d['area']))).'</sup></td>
		<td align="center">'.$arrShift[$r2e['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2e['area']))).'</sup></td>
		<td align="center">'.$arrShift[$r2f['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2f['area']))).'</sup></td>
		<td align="center">'.$arrShift[$r2g['shift']].' <sup>'.str_replace(',',',',str_replace('樓floor','',str_replace('棟block','',$r2g['area']))).'</sup></td>
	  </tr>'."\n";
	  //echo $k.':'.$i.'<br>';
		  if ($k==5 && $i==($db1->num_rows()-1)) {
	  ?>
	  </table>the<?php echo ceil($count/32); ?>th page<div style="page-break-before:always;">&nbsp;<div><table style="width:920px;" class="drawformborder">
	  <tr class="title">
		<td>&nbsp;</td>
		<td align="center"><?php echo $sd1; ?> (Mon)</td>
		<td align="center"><?php echo $sd2; ?> (Tues)</td>
		<td align="center"><?php echo $sd3; ?> (Wed)</td>
		<td align="center"><?php echo $sd4; ?> (Thurs)</td>
		<td align="center"><?php echo $sd5; ?> (Fri)</td>
		<td align="center"><?php echo $sd6; ?> (Sat)</td>
		<td align="center"><?php echo $sd7; ?> (Sun)</td>
	  </tr>
      <?php if($_GET['lof']==1){?>
      <tr>
        <td>Note item</td>
        <td><?php echo ${'memo_'.$td1}; ?></td>
        <td><?php echo ${'memo_'.$td2}; ?></td>
        <td><?php echo ${'memo_'.$td3}; ?></td>
        <td><?php echo ${'memo_'.$td4}; ?></td>
        <td><?php echo ${'memo_'.$td5}; ?></td>
        <td><?php echo ${'memo_'.$td6}; ?></td>
        <td><?php echo ${'memo_'.$td7}; ?></td>
      </tr>
	  <?php }}
	  $count++;
	  }
  }
  ?>
</table>
第the<?php echo ceil($count/32); ?>th page
</div>
</body>
</html>