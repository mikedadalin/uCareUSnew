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
<div style="width:100%" align="center">
<?php 
if ($_GET['date']=="--Select month--") { $_GET['date']=date("Ym"); }
$date1=substr($_GET['date'],0,4);
$date2=substr($_GET['date'],4,2);
$dateT=lastday($date2, $date1);
?>
<h3 style="margin:0px;">月值班表 (<?php echo $date1.' Year '. $date2.' Month'; ?>)</h3>
<?php

//$arrShift = array("A"=>"D", "B"=>"8-12", "C"=>"8-13", "D"=>"8-17", "E"=>"E", "F"=>"N", "G"=>"OFF", "H"=>"off", "I"=>"ALL", "J"=>"L", "K"=>"C+H", "L"=>"CHEF", "M"=>"KH", "L"=>"N");
$dbShift = new DB;
$dbShift->query("SELECT * FROM `shift` ORDER BY `shiftid`");
$arrShift = array();
for ($i=0;$i<$dbShift->num_rows();$i++) {
	$r_shift = $dbShift->fetch_assoc();
	$arrShift[$r_shift['shiftid']] = $r_shift['name'];
}

$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group` ORDER BY `order` ASC");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}
?>
<table style="width:100%;" class="drawformborder">
  <tr class="title">
    <td>&nbsp;</td>
    <?php for ($i=1;$i<=$dateT;$i++){?>
    <td align="center" width="3%" ><?php echo $i; ?></td>
    <?php }?>
  </tr>
  <!--<tr>
    <td>備註事項</td>
  <?php
  for ($i=1;$i<=$dateT;$i++){
	  $date3 = $i;
	  if (strlen($date3)==1) { $date3 = "0".$date3; }
	  $db3a = new DB;
	  $db3a->query("SELECT * FROM `shift_memo` WHERE `date`='".$date1.$date2.$date3."'");
	  $r3a = $db3a->fetch_assoc();
	  echo "<td>" . $r3a['text'] .  "</td>";
  }
  ?>
  </tr>-->
  <?php
  foreach ($arrGroupName as $k=>$v) {
	  if($_GET['lof']==1 || $_GET['lof']==""){
	  	$sql1 = "SELECT * FROM `shift_member` WHERE `available`='1' AND `GroupID`='".$k."' ORDER BY `order` ASC";
	  }else{
		  $sql1 = "SELECT * FROM  `shift_member` WHERE (`EmpID` IN (SELECT DISTINCT  `foreignID` FROM  `foreignemployer_shift2` WHERE LEFT(`date`,6) = '".$date1.$date2."') ";
		  $sql1 .=" OR `EmpID` IN (SELECT DISTINCT `EmpID` FROM `employer_shift2` WHERE LEFT(`date`,6) = '".$date1.$date2."')) ";
		  $sql1 .=" AND GroupID = '".$k."' ORDER BY  `EmpGroup` ,  `GroupID` ,  `order` ";
	  }
	  $db1 = new DB;
	  $db1->query($sql1);
	  //$arrEmpName = array();
	  for ($i=0;$i<$db1->num_rows();$i++) {
		  if ($i==0) { $count2 += $db1->num_rows(); }
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
		  echo '
	  <tr height="38">
		<td class="title_s" style="font-size:10pt;">'.$EmpName.'</td>';
		for ($i1=1;$i1<=$dateT;$i1++) {
			$date3 = $i1;
			if (strlen($date3)==1) { $date3 = "0".$date3; }
			$db2a = new DB;
			$db2a->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$date1.$date2.$date3."'");
			$r2a = $db2a->fetch_assoc();
			echo '<td align="center">'.$arrShift[$r2a['shift']].'</td>';
		}
	  echo '</tr>'."\n";
	  $count++;
	  if ($count%15==0) {
		  $page++;
		  echo '
		  </table>
		  The '.$page.'頁	
		  <div style="page-break-before:always;">&nbsp;<div><table style="width:920px;" class="drawformborder">
		  <table style="width:100%;" class="drawformborder">
			  <tr class="title">
				<td>&nbsp;</td>';
				for ($i2=1;$i2<=$dateT;$i2++){
				echo '<td align="center" width="3%">'.$i2.'</td>';
				}
			  echo '</tr>';
			  /*echo '<tr>
				<td>備註事項</td>';
			  for ($i3=1;$i3<=$dateT;$i3++){
				  $date3 = $i3;
				  if (strlen($date3)==1) { $date3 = "0".$date3; }
				  $db3a = new DB;
				  $db3a->query("SELECT * FROM `shift_memo` WHERE `date`='".$date1.$date2.$date3."'");
				  $r3a = $db3a->fetch_assoc();
				  echo "<td>" . $r3a['text'] .  "</td>";
			  }
			  echo '</tr>'."\n";*/
	  }
	}
  }
$page++;
echo '
</table>
The '.$page.'頁';
?>
</div>
</body>
</html>