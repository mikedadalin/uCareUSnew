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
<link type="text/css" rel="stylesheet" href="css/printstyle.css" />
<script>
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);$("textarea").css("border","none");$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("option:selected").each(function(){var $this=$(this);var id=$(this).parent().attr('id');if($this.length){var selText=$this.text();$('#'+id).replaceWith(''+selText+'')}})});
$(function(){
	window.print();
});
</script>
<style>
body { padding:0; margin:0; }
</style>
</head>

<body>
<?php
if (@$_GET['date']=="--Select month--") {
	$qdate = date(Ym);
} else {
	$qdate = @$_GET['date'];
}
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID')];
	$bed = $r1['bed'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<script>alert('請記得以「橫向」列印！');</script>
<?php
$drugno = 6;
$dbno = new DB;
$dbno->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND (`Qstartdate` < '".substr($qdate,0,4).'/'.substr($qdate,4,2)."/31' AND (`Qenddate` > '".substr($qdate,0,4).'/'.substr($qdate,4,2)."/01' OR `Qenddate`=''))");
$pageno = ceil($dbno->num_rows()/$drugno);
for ($page=1;$page<=$pageno;$page++) {
	$startno = ($page-1)*$drugno;
	$rowno = $pageno*$drugno;
?>
<div style="width:1480px;"><center><?php echo $_SESSION['nOrgName_lwj'].' '.substr($qdate,0,4).' Year '.substr($qdate,4,2); ?> 月給藥紀錄單</center></div>
<table border="1" style="border-collapse:collapse; font-size:10pt;" width="1480">
  <tr id="backtr"  style="border:none;" height="20">
    <td class="title" width="60" style="border:none;">Bed #</td>
    <td width="80" style="border:none;"><?php echo $bed; ?></td>
    <td class="title" width="60" style="border:none;">Full name</td>
    <td width="80" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none;">Care ID#</td>
    <td width="80" style="border:none;"><?php echo $HospNo; ?></td>
    <td class="title" width="60" style="border:none;">DOB</td>
    <td width="180" style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="80" style="border:none;">Admission date</td>
    <td width="80" style="border:none;"><?php echo $indate; ?></td>
  </tr>
</table>
<table border="1" style="border-collapse:collapse; text-align:center;" width="1480">
  <tr class="title" height="30">
    <td width="30">Start</td>
    <td width="30">Ends</td>
    <td width="200">Medication (Dose)</td>
    <td width="62">Time</td>
    <?php
	echo drawmedcalwithtext();
	?>
  </tr>
  <?php
  $db = new DB;
  $db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND (`Qstartdate` < '".substr($qdate,0,4).'/'.substr($qdate,4,2)."/31' AND (`Qenddate` > '".substr($qdate,0,4).'/'.substr($qdate,4,2)."/01' OR `Qenddate`='')) LIMIT ".$startno.",".$rowno);
  if ($page == $pageno) { $stopno = $db->num_rows(); } else { $stopno = $drugno; }
  for ($i=0;$i<$stopno;$i++) {
	  $bgday = "";
	  $r = $db->fetch_assoc();
	  $time = explode(';',$r['Qmedtime']);
	  $time2 = array_pop($time);
	  if (count($time)<=4) { $rowspan=4; } else { $rowspan = count($time); }
	  $pstartday = str_replace('/','',substr($r['Qstartdate'],0,7));
	  $pendday = str_replace('/','',substr($r['Qenddate'],0,7));
	  if ($pstartday<$qdate) {
		  $startday = 1;
	  } else {
		  $startday = substr($r['Qstartdate'],8,2);
	  }
	  if ($qdate < str_replace('/','',substr($r['Qenddate'],0,7))) {
		  $endday = date('t',strtotime(formatdate($qdate.'01')));
	  } elseif ($r['Qenddate']=="") {
		  $endday = date('t',strtotime(formatdate($qdate.'01')));
	  } else {
		  $endday = substr($r['Qenddate'],8,2);
	  }
	  for ($starti=$startday;$starti<=$endday;$starti++) {
		  $bgday .= $starti.';';
	  }
	  $showstartday = formatdate($qdate.$startday).'<br>('.$r['Qstartdate'].')';
	  if ($r['Qenddate']=='') {
		  $showendday = formatdate($qdate.$endday).'<br>(------)';
	  } else {
		  $showendday = formatdate($qdate.$endday).'<br>('.$r['Qenddate'].')';
	  }
	  echo '
  <tr height="24">
	<td rowspan="'.$rowspan.'">&nbsp;</td>
    <td rowspan="'.$rowspan.'">&nbsp;</td>
    <td rowspan="'.$rowspan.'">'.$r['Qmedicine'].'<br>('.$r['Qusage'].' '.$r['Qdose'].$r['Qdoseq'].') '.$r['Qway'].', '.$r['Qfreq'].'</td>
    <td>'; if (count($time)>0 && $time[0]<=9) { echo $time[0].' am'; } else { echo '&nbsp;'; } echo '</td>'.drawmedcal($bgday,$r['Qmedday']).'
  </tr>'."\n";
    if (count($time)<=4) {
		$time2 = '&nbsp;';
		$time3 = '&nbsp;';
		$time4 = '&nbsp;';
		for ($t1=0;$t1<count($time);$t1++) {
			if ($time[$t1]>9 && $time[$t1]<=13) { if ($time[$t1]>12) { $time2 = ($time[$t1]-12).' pm'; } elseif ($time[$t1]==12) { $time2 = '12 pm'; } else { $time2 = $time[$t1].' am'; } }
			elseif ($time[$t1]>13 && $time[$t1]<=18) { $time3 = ($time[$t1]-12).' pm'; }
			elseif ($time[$t1]>18 && $time[$t1]<=23) { $time4 = ($time[$t1]-12).' pm'; }
		}
		echo '
		<tr height="24"><td>'.$time2.'</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>
		<tr height="24"><td>'.$time3.'</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>
		<tr height="24"><td>'.$time4.'</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>
		';
	} elseif (count($time)==0) {
		echo '<tr height="24"><td>&nbsp;</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>'."\n";
		echo '<tr height="24"><td>&nbsp;</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>'."\n";
		echo '<tr height="24"><td>&nbsp;</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>'."\n";
	} else {
		for ($t1=0;$t1<count($time);$t1++) {
			echo '<tr height="24"><td>'.$time[$t1].'</td>'.drawmedcal($bgday,$r['Qmedday']).'</tr>'."\n";
		}
	}
  	/*$spaceno = 5-count($time);
	if ($spaceno>0) {
		for ($t2=0;$t2<$spaceno;$t2++) {
			echo '
  <tr height="24">
    <td>&nbsp;</td>'.drawmedcal('','').'
  </tr>'."\n";
		}
	}*/
  }
  if ($pageno == $page && $db->num_rows()<$drugno) {
	  $addspaceno = $drugno - $db->num_rows();
	  for ($k=0;$k<$addspaceno;$k++) {
  ?>
  <tr height="24">
	<td rowspan="4">&nbsp;</td>
    <td rowspan="4">&nbsp;</td>
    <td rowspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="24">
    <td>&nbsp;</td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="24">
    <td>&nbsp;</td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="24">
    <td>&nbsp;</td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <?php
	  }
  }
  ?>
  <tr height="20">
    <td colspan="3" rowspan="6" class="title">Nursing staff signature</td>
    <td  class="title">Day shift</td>
    <?php echo drawmedcal_br('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title"><font size="2">不良反應</font></td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title">Night shift</td>
    <?php echo drawmedcal_br('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title"><font size="2">不良反應</font></td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title">Graveyard shift</td>
    <?php echo drawmedcal_br('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title"><font size="2">不良反應</font></td>
    <?php echo drawmedcal('',''); ?>
  </tr>
</table>
<?php
	if ($pageno==$page) {
		echo '<p><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　睡眠 - Slp　Shortage of drug -A　不良反應 - O/X　Other-＊ (Noted in Nursing records)</font></p>';
	} else {
		echo '<p style="page-break-after: always;"><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　睡眠 - Slp　Shortage of drug -A　不良反應 - O/X　Other-＊ (Noted in Nursing records)</font></p>';
	}
}
?>
</body>
</html>