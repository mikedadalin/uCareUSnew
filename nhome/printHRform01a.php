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
body { padding:0; margin:0; font-family: "Times New Roman", "標楷體"; font-size:11pt;}
.drawformborder { border:solid 1px; }
.drawformborder tr { border:solid 1px; }
.drawformborder td { border:solid 1px; padding:6px; }
</style>
</head>

<body>
<?php
$sql = "SELECT * FROM `employer` WHERE `EmpID`='".mysql_escape_string($_GET['empid'])."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q" || substr($k,0,6)=="Gender") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
	/*== 解 START ==*/
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$IdNo);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                $IdNo = $IdNo.$prdpart;
            }
	    }else{
		   $IdNo = $rsa->privDecrypt($IdNo);
	    }
	/*== 解 END ==*/
$db2 = new DB2;
$db2->query("SELECT * FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
$r2 = $db2->fetch_assoc();
$newNo = $r2['HRFormNo']+1;
$HRFormNo = str_replace('{N}',$newNo,$r2['HRFormNo1']);
$db3 = new DB2;
$db3->query("UPDATE `system_setting` SET `HRFormNo`='".$newNo."' WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
?>
<table width="800" style="border:none;">
  <tr>
    <td><center><font size="6"><b>離 職 證 明 書staff leaving certificate</b></font></center></td>
  </tr>
  <tr>
    <td>&nbsp;<br /><p align="right"><?php echo $HRFormNo; ?></p></td>
  </tr>
</table>
<table width="800" class="drawformborder" cellpadding="0" cellspacing="0" style="font-size:14pt;">
  <tr height="80">
    <td width="120" align="center">Full name</td>
    <td align="center"><?php echo $Name; ?></td>
    <td width="120" align="center">出生年月日birth date</td>
    <td align="center">民國year <?php $dob = explode("/",$Birth); echo $dob[0]-1911; ?> 年year <?php echo $dob[1]; ?> 月month <?php echo $dob[2]; ?> 日date</td>
  </tr>
  <tr height="80">
    <td width="120" align="center">身份證字號SSID</td>
    <td align="center"><?php echo $IdNo; ?></td>
    <td width="120" align="center">性 別gender</td>
    <td colspan="2" align="center"><?php echo option_result("Gender","Male;Female","s","single",$Gender,false,5); ?></td>
  </tr>
  <tr height="80">
    <td width="120" align="center">服務單位serve unit</td>
    <td align="center"><?php echo $r2['orgTitle']; ?></td>
    <td width="120" align="center">職 稱job title</td>
    <td colspan="2" align="center"><?php echo $Position; ?></td>
  </tr>
  <tr>
    <td width="120" align="center"><br />任職起appointment start<br />迄時間appointment end<br />&nbsp;</td>
    <td colspan="3">
    <?php
	if ($Startdate3!=NULL && $Enddate3!=NULL) {
		$startdate = explode("/",$Startdate3);
		$enddate = explode("/",$Enddate3);
		echo 'since '.($startdate[0]-1911).' 年year '.$startdate[1].' 月month '.$startdate[2].' date日至until '.($enddate[0]-1911).' 年year '.$enddate[1].' 月month '.$enddate[2].' date日止';
	} elseif ($Startdate2!=NULL && $Enddate2!=NULL) {
		$startdate = explode("/",$Startdate2);
		$enddate = explode("/",$Enddate2);
		echo 'since '.($startdate[0]-1911).' 年year '.$startdate[1].' 月month '.$startdate[2].' date日至until '.($enddate[0]-1911).' 年year '.$enddate[1].' 月month '.$enddate[2].' date日止';
	} elseif ($Startdate1!=NULL && $Enddate1!=NULL) {
		$startdate = explode("/",$Startdate1);
		$enddate = explode("/",$Enddate1);
		echo 'since '.($startdate[0]-1911).' 年year '.$startdate[1].' 月month '.$startdate[2].' date日至until '.($enddate[0]-1911).' 年year '.$enddate[1].' 月month '.$enddate[2].' date日止';
	}
	?>
    </td>
  </tr>
</table>
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
<span style="line-height:30px; font-size:16pt;">證明機構certificate coperation: <?php echo $r2['orgTitle']; ?><br />
負責人person in charge:<?php echo $r2['orgPerson']; ?><br />
機構地址institution address:新北市深坑區昇高里王軍寮九號<br />
電話institution phone number: <?php echo $r2['orgAddress']; ?><br />
機構登記或立案字號institution public serial number:<?php echo $r2['orgGovNo']; ?></span><br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
&nbsp;<br />
<div style="width:800px; font-size:18pt;">
  <center>中　　華　　民　　國　A.D.　<?php echo date(Y)-1911; ?>　　年year　　<?php echo date(m); ?>　　月month　　<?php echo date(d); ?>　　日date</center>
</div>
<div style="width:800px;">
  <center>(加蓋關防或機構印章，如有不實，願負法律責任institution seal to bear legal responsibility)</center>
</div>