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
	$name = getPatientName($r['patientID']);
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
$dbintake = new DB;
$dbintake->query("SELECT * FROM `medintake` WHERE `HospNo`='".$HospNo."';");
if ($dbintake->num_rows()>0) {
	$rintake = $dbintake->fetch_assoc();
	foreach ($rintake as $kintake=>$vintake) {
		if (substr($kintake,0,1)=="Q") {
			$arrAnswer = explode("_",$kintake);
			if (count($arrAnswer)==2) {
				if ($vintake==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			}
		}
	}
}
if($dbno->num_rows()!=0){
for ($page=1;$page<=$pageno;$page++) {
	$startno = ($page-1)*$drugno;
	$rowno = $pageno*$drugno;
?>
<div style="width:1480px;"><center><?php echo $_SESSION['nOrgName_lwj'].'<font style="padding-left:20px; padding-right:10px;">'.substr($qdate,0,4).' '.getEnglishMonth(substr($qdate,4,2)).'</font>'; ?> Medication Record</center></div>
<table border="1" style="border-collapse:collapse;" width="1480">
  <tr id="backtr"  style="border:none;" height="20">
    <td class="title" width="68" style="border:none; font-size:12pt;">Bed #</td>
    <td width="80" style="border:none; font-size:12pt;"><?php echo $bed; ?></td>
    <td class="title" width="60" style="border:none; font-size:12pt;">Full name</td>
    <td width="100" style="border:none; font-size:12pt;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none; font-size:12pt;">Care ID#</td>
    <td width="80" style="border:none; font-size:12pt;"><?php echo $HospNo; ?></td>
    <td class="title" width="60" style="border:none; font-size:12pt;">DOB</td>
    <td width="160" style="border:none; font-size:12pt;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="90" style="border:none; font-size:12pt;">Admission date</td>
    <td width="80" style="border:none; font-size:12pt;"><?php echo $indate; ?></td>
    <td class="title" width="80" style="border:none; font-size:12pt;">Comment</td>
    <td width="80" style="border:none; font-size:12pt;"><?php echo draw_option("Qintake","Powdery;NG","s","multi",$Qintake,false,5); ?></td>
  </tr>
  <tr id="backtr"  style="border-top:1px solid #000;" height="20">
    <td class="title" style="border:none; font-size:12pt;">Allergic drug</td>
    <td style="border:none;" colspan="11">
	<?php
	$outputamed = '';
    $db_amed = new DB;
	$db_amed->query("SELECT * FROM `allergicmed` WHERE `HospNo`='".$HospNo."' Order By `drugID` ASC");
	for ($i=0;$i<$db_amed->num_rows();$i++) {
		if ($outputamed!="") { $outputamed.='、'; }
		$amed = $db_amed->fetch_assoc();
		$outputamed .= $amed['DrugName'];
    }
	echo $outputamed;
	?>
    </td>
  </tr>
</table>
<table border="1" style="border-collapse:collapse; text-align:center;" width="1480">
  <tr class="title" height="30">
    <td width="60" style="font-size:10pt;">Date<br>(Doctor)</td>
    <td width="100" style="font-size:10pt;">Medication<br>(Dose)</td>
    <td width="40" style="font-size:10pt;">Time</td>
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
    <td rowspan="'.$rowspan.'" style="font-size:10pt;">'.$r['Qstartdate'].'<br>~<br>'.$r['Qenddate'].'<br>('.$r['Qdoctor'].')</td>
    <td rowspan="'.$rowspan.'" style="font-size:10pt;">'.$r['Qmedicine'].'<br>('.$r['Qusage'].' '.$r['Qdose'].$r['Qdoseq'].')<br>'.$r['Qway'].', '.$r['Qfreq'].'</td>
    <td style="font-size:10pt;">'; if (count($time)>0 && $time[0]<=9) { echo $time[0].' am'; $needgive1=1;} else { echo '&nbsp;'; $needgive1=0;} $time1_24HR = $time[0]; echo '</td>'.drawmedcal($bgday,$r['Qmedday'],$needgive1,$i,$r['Qmedicine'],$time1_24HR,$HospNo,$qdate).'
  </tr>'."\n";
    if (count($time)<=4) {
		$time2 = '&nbsp;';
		$needgive2=0;
		$time3 = '&nbsp;';
		$needgive3=0;
		$time4 = '&nbsp;';
		$needgive4=0;
		for ($t1=0;$t1<count($time);$t1++) {
			if ($time[$t1]>9 && $time[$t1]<=13) { if ($time[$t1]>12) { $time2 = ($time[$t1]-12).' pm'; $needgive2=1;} elseif ($time[$t1]==12) { $time2 = '12 pm'; $needgive2=1;} else { $time2 = $time[$t1].' am'; $needgive2=1;} $time2_24HR = $time[$t1]; }
			elseif ($time[$t1]>13 && $time[$t1]<=18) { $time3 = ($time[$t1]-12).' pm'; $needgive3=1; $time3_24HR = $time[$t1];}
			elseif ($time[$t1]>18 && $time[$t1]<=23) { $time4 = ($time[$t1]-12).' pm'; $needgive4=1; $time4_24HR = $time[$t1];}
		}
		echo '
		<tr height="24"><td style="font-size:10pt;">'.$time2.'</td>'.drawmedcal($bgday,$r['Qmedday'],$needgive2,$i,$r['Qmedicine'],$time2_24HR,$HospNo,$qdate).'</tr>
		<tr height="24"><td style="font-size:10pt;">'.$time3.'</td>'.drawmedcal($bgday,$r['Qmedday'],$needgive3,$i,$r['Qmedicine'],$time3_24HR,$HospNo,$qdate).'</tr>
		<tr height="24"><td style="font-size:10pt;">'.$time4.'</td>'.drawmedcal($bgday,$r['Qmedday'],$needgive4,$i,$r['Qmedicine'],$time4_24HR,$HospNo,$qdate).'</tr>
		';
	} elseif (count($time)==0) {
		echo '<tr height="24"><td style="font-size:10pt;">&nbsp;</td>'.drawmedcal('','','','','','','',$qdate).'</tr>'."\n";
		echo '<tr height="24"><td style="font-size:10pt;">&nbsp;</td>'.drawmedcal('','','','','','','',$qdate).'</tr>'."\n";
		echo '<tr height="24"><td style="font-size:10pt;">&nbsp;</td>'.drawmedcal('','','','','','','',$qdate).'</tr>'."\n";
	} else {
		for ($t1=1;$t1<count($time);$t1++) {
			if ($time[$t1]>12) { $manytime = ($time[$t1]-12).' pm'; ${"needgive".$t1}=1;} elseif ($time[$t1]==12) { $manytime = '12 pm'; ${"needgive".$t1}=1;} else { $manytime = $time[$t1].' am'; ${"needgive".$t1}=1;}
			$manytime_24HR = $time[$t1];
			echo '<tr height="24" style="background-color:rgba(255,255,255,0.8);"><td style="font-size:10pt;">'.$manytime.'</td>'.drawmedcal($bgday,$r['Qmedday'], ${"needgive".$t1},$i,$r['Qmedicine'],$manytime_24HR,$HospNo,$qdate).'</tr>'."\n";
		}
	}
  }
  if ($pageno == $page && $db->num_rows()<$drugno) {
	  $addspaceno = $drugno - $db->num_rows();
	  for ($k=0;$k<$addspaceno;$k++) {
  ?>
  <tr height="24">
    <td rowspan="4">&nbsp;</td>
    <td rowspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate); ?>
  </tr>
  <tr height="24">
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate); ?>
  </tr>
  <tr height="24">
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate); ?>
  </tr>
  <tr height="24">
    <td>&nbsp;</td>
    <?php echo drawmedcal('','','','','','','',$qdate); ?>
  </tr>
  <?php
	  }
  }
  ?>
</table>
<?php
	if ($pageno==$page) {
		echo '<p><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　Shortage of drug -A　Pause medication - Hold　Other-＊ (Noted in Nursing records)</font></p>';
	} else {
		echo '<p style="page-break-after: always;"><font size="2">Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　Shortage of drug -A　Pause medication - Hold　Other-＊ (Noted in Nursing records)</font></p>';
	}
}
}else{
	echo 'no data';
}
?>
</body>
</html>