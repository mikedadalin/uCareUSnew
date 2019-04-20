<?php
session_start();
include("class/DB.php");
include("class/DB2.php");
include("class/error.php");
include("class/array.php");
include("class/functionforprint.php");
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
if(navigator.appName.indexOf("Internet Explorer")!=-1)document.onmousedown=noSourceExplorer;function noSourceExplorer(){if(event.button==2|event.button==3){}}function NoRightClick(evnt){if(navigator.appName.toUpperCase().match(/NETSCAPE/)!=null){if(evnt.which==3){return false}}else if(event.button==2){}}document.onmousedown=NoRightClick;$(document).ready(function(){$("form :input").attr("readonly",true);
//$("textarea").replaceWith($("textarea").html());
$("textarea").each(function(){
	var content = $(this).html();
	$(this).replaceWith(content.replace(/\n/g,"<br>"));
});
$("#submit").hide();$("input[type=button]").hide();$("input[type=image]").hide();$("#backbtn").hide();$("#printbtn").hide();$("option:selected").each(function(){var e=$(this);var t=$(this).parent().attr("id");if(e.length){var n=e.text();$("#"+t).replaceWith(""+n+"")}})})
</script>
</head>

<body>

<?php
if (@$_GET['func']=='printmed') {
	$width = '1309px';
} else {
	$width = '909px';
}
if ($_SESSION['ncareID_lwj']==NULL && @$_GET['func']!="loginprocess") {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
} else {
	
//模組名稱module name
$strModule = "firmstock";
$subModule = "firmstockinfo";
$type = $_GET['type'];//"SP";
$typeName = "Shippment";
if($_GET['FirmDiv'] <> ""){
	$fid = str_pad($_GET['FirmDiv'],6,'0',STR_PAD_LEFT);
	$strQry.= " AND a.firmID='".$fid."'";
}
//Date
if($_GET["date1"]!=""){
	$strQry .= " AND a.STK_Date >= '".mysql_escape_string($_GET["date1"])."'";
}
if($_GET["date2"]!=""){
	$strQry .= " AND a.STK_Date <= '".mysql_escape_string($_GET["date2"])."'";
}
?>

<center>  
    
<?php 
$db = new DB;
$dbCount = new DB;
$str = "SELECT distinct(b.STK_NO) FROM `".$strModule."` a inner join `".$subModule."` b on";
$str .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
$str .= "WHERE a.`type`='".$type."' ".$strQry." AND a.IsStatus <> 'D'";
$str .=" and left(a.firmID,4)<>'Area' order by b.STK_NO";
//$str = "select distinct(STK_NO) from arkstock where STK_KIND1='1' AND STK_KIND2='1' ";
$db->query($str);

if($db->num_rows() > 0){
	$page = 28;
	$pageSize = ceil($db->num_rows() / $page);
	$temp = array();
	//$bigtemp = array();
	for ($i1=1;$i1<=$pageSize;$i1++) {
		$db2 = new DB;
		$db2->query($str." LIMIT ".($i1-1)*$page.",".$page);
		for ($i2=0;$i2<$db2->num_rows();$i2++) {		
			$r= $db2->fetch_assoc();
			$temp[$i1][$i2] = $r['STK_NO'];
		}		
	}//end for
}//end if

$db1 = new DB;
$str1 = "SELECT distinct(a.firmID) hospID FROM `".$strModule."` a inner join `".$subModule."` b on";
$str1 .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
$str1 .= "WHERE a.`type`='".$type."' ".$strQry." AND a.IsStatus <> 'D'";
$str1 .=" and left(a.firmID,4)<>'Area' ";
//$str1 = "select distinct(patientID) hospID from inpatientinfo";

$arrPatient = array();
$db1->query($str1);
if($db->num_rows() > 0){
  for ($i1=0;$i1<$db1->num_rows();$i1++) {			
	$r1= $db1->fetch_assoc();		
	$arrPatient[$i1] = $r1['hospID'];//getHospNo($r1['hospID']);//
  }
}
$patientno = 28;
$patientSize = ceil(count($arrPatient) / $patientno);
for ($j=1;$j<=$patientSize;$j++) {
	for ($i0=1;$i0<=count($temp);$i0++) {
		echo '
	<h5>'.$_SESSION['nOrgName_lwj'].'</h5>
	<h5>院民耗材統計表consumables statistics</h5>
	<h5> since&nbsp;'; if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } echo 'Ends </h5>
	<div id="printarea"  class="printarea">
	<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="noborder2">
	  <tr>
		<td align="center" width="3%" class="bLineB0">編號serial number</td>
		<td align="center" width="7%" class="bLineB0">Full name</td>
		<td align="center" width="5%" class="bLineB0">Bed number</td>';
		foreach ($temp[$i0] as $k=>$v) {
			//echo '<td align="center" width="3%" valign="top" class="'.($patientstart==((($j-1)*$patientno)+$patientno)-1?'bLineB1 bLineB2':'bLineB1').($k==count($temp[$i0])-1?' bLineB3':'').'">'.STK_NAME_s($v).'</td>';
			echo '<td align="center" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">'.STK_NAME_s($v).'</td>';
		}
		echo '
	  </tr>';
		for ($patientstart = ($j-1)*$patientno; $patientstart < (($j-1)*$patientno)+$patientno; $patientstart++) {
		$v1 = $arrPatient[$patientstart];
			if((int)$v1==0 && getPatientName(getPID($v1))==""){
				echo "";
			}else{
				echo '
			  <tr>
				<td class="bLineB1">'.(int)$v1.'</td>
				<td class="bLineB1">'.getPatientName(getPID($v1)).'</td>
				<td class="bLineB1">'.getBedID(getPID($v1)).'</td>';
				foreach ($temp[$i0] as $k=>$v) {
					echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'">'.getSTK_NUM($_GET['date1'], $_GET['date2'], $v, $v1, 1, 1).'</td>';
				}
				echo '
			  </tr>';
			}  
		}


	  if($j==$patientSize){
		echo '
		  <tr>
			<td class="bLineB1">總計total</td>
			<td class="bLineB1"></td>
			<td class="bLineB1"></td>';
			foreach ($temp[$i0] as $k=>$v) {
					echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'">'.getSTK_NUM($_GET['date1'], $_GET['date2'], $v, $v1, 1, 2).'</td>';
			}
			echo '
		  </tr>';
	  }  

	echo '
	</table>
	</div>';
	  if(($j == $patientSize) && ($i0 == count($temp))){
		  echo "";
	  }else{
		  echo '<p style="page-break-after:always;"></p>';		  
	  }
	}//end 
}//end
?><!--here-->

</center>
<?php
}//end if
?>

</body>
</html>