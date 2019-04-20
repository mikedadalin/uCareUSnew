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
echo date("Y",strtotime($r1['date'])).'&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['nOrgName_lwj'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Division: '.$r1['department'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Physician: '.$r1['doctor'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Registered list';
?>
<table width="100%" class="drawformborder" style="border-collapse:collapse; font-size:10pt;">
<!--width="100%" class="drawformborder" -->
  <thead>
  <tr>
    <td width="45">Bed #</td>
    <td width="55">Full name</td>
    <td width="65">DOB</td>
    <td width="70">身份證號</td>
    <td width="40">類別</td>
    <td width="60">殘障手冊</td>
    <td width="65">Disability</td>
    <td width="55">Medical record number</td>
    <td>12月</td>
    <td>1月</td>
    <td>2月</td>
    <td>3月</td>
    <td>4月</td>
    <td>5月</td>
    <td>6月</td>
    <td>7月</td>
    <td>8月</td>
    <td>9月</td>
    <td>10月</td>
    <td>11月</td>
    <td>12月</td>
  </tr>
  <?php
  foreach ($arrSelectedList as $k=>$v) {
	  $pid = getPID($v);
	  $db1a = new DB;
	  $db1a->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".$v."' ORDER BY `date` DESC LIMIT 0,1");
	  $r1a = $db1a->fetch_assoc();
	  $queryYear = date("Y",strtotime($r1['date']));
	  $queryYearPrev = $queryYear - 1;
	  $db1b = new DB;
	  $db1b->query("SELECT DAY(`date`) AS DAY FROM `opdinfo` WHERE `date` LIKE '".$queryYearPrev."-12-%' AND `department`='".$r1['department']."' AND `patient` LIKE '%".$v."%'");
	  $arrDate = array();
	  for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		  $r1b = $db1b->fetch_assoc();
		  $arrDate[$queryYearPrev.'12'] .= $r1b['DAY'].';';
	  }
	  $arrDate[$queryYearPrev.'12'] = str_replace(';','、',substr($arrDate[$queryYearPrev.'12'],0,strlen($arrDate[$queryYearPrev.'12'])-1));
	  for ($i1c=1;$i1c<=12;$i1c++) {
		  if (strlen($i1c)==1) { $queryMonth = "0".$i1c; } else { $queryMonth = $i1c; }
		  $db1c = new DB;
		  $db1c->query("SELECT DAY(`date`) AS DAY FROM `opdinfo` WHERE `date` LIKE '".$queryYear."-".$queryMonth."-%' AND `department`='".$r1['department']."' AND `patient` LIKE '%".$v."%'");
		  for ($i1c1=0;$i1c1<$db1c->num_rows();$i1c1++) {
			  $r1c = $db1c->fetch_assoc();
			  $arrDate[$queryYear.$queryMonth] .= $r1c['DAY'].';';
		  }
		  $arrDate[$queryYear.$queryMonth] = str_replace(';','、',substr($arrDate[$queryYear.$queryMonth],0,strlen($arrDate[$queryYear.$queryMonth])-1));
	  }
    $db2 = new DB;
    $db2->query("SELECT `Name1`,`Name2`,`Name3`,`Name4`,`IdNo`,`MedicalRecordNumber` FROM `patient` WHERE `patientID`='".$pid."'");
	$r2 = $db2->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4','IdNo','MedicalRecordNumber');
	$LWJdataArray = array($r2['Name1'],$r2['Name2'],$r2['Name3'],$r2['Name4'],$r2['IdNo'],$r2['MedicalRecordNumber']);
	for($z=0;$z<count($LWJdataArray);$z++){
	    $rsa = new lwj('../../lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$z]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($m=0;$m<$puepartcount;$m++){
                $prdpart = $rsa->privDecrypt($puepart[$m]);
                $r2[$LWJArray[$z]] = $r2[$LWJArray[$z]].$prdpart;
            }
	    }else{
		   $r2[$LWJArray[$z]] = $rsa->privDecrypt($LWJdataArray[$z]);
	    }
	}
	/*== 解 END ==*/
	if($r2['Name2']!="" || $r2['Name2']!=NULL){$r2['Name2'] = " ".$r2['Name2'];}
    if($r2['Name3']!="" || $r2['Name3']!=NULL){$r2['Name3'] = " ".$r2['Name3'];}
    if($r2['Name4']!="" || $r2['Name4']!=NULL){$r2['Name4'] = " ".$r2['Name4'];}
	$r2['Name'] = $r2['Name1'].$r2['Name2'].$r2['Name3'].$r2['Name4'];
	  echo '
  <tr>
    <td>'.getBedID($pid).'</td>
    <td>'.$r2['Name'].'</td>
    <td>'.formatdate(getPatientBOD($pid)).'</td>
    <td>'.$r2['IdNo'].'</td>
    <td>'.($r1a['Qdisable_1']==1?"殘":"").' '.($r1a['QillnessName']!=""?"重":"").'</td>
    <td>'.$r1a['Qdisableexpiry'].'</td>
    <td>'.$r1a['QillnessName'].'</td>
    <td>'.$r2['MedicalRecordNumber'].'</td>
    <td>'.$arrDate[$queryYearPrev.'12'].'</td>';
	for ($i1d=1;$i1d<=12;$i1d++) {
		if (strlen($i1d)==1) { $queryMonth = "0".$i1d; } else { $queryMonth = $i1d; }
		echo '<td>'.$arrDate[$queryYear.$queryMonth].'</td>'."\n";
	}
    echo '
  </tr>'."\n"; 
  }
  ?>
  </thead>
</table>
</body>
</html>