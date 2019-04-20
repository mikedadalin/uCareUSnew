<?php
session_start();
include("lwj/lwj.php");
include("class/DB.php");
include("class/DB2.php");
include("class/error.php");
include("class/array.php");
include("class/functionforprint.php");
if ($_SESSION['ncareID_lwj']==NULL && @$_GET['func']!="loginprocess") {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
} else {
	
	if ($_GET['out']=='xls') {
		//輸出excel
		
		//模組名稱
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
		
		$db = new DB;
		$dbCount = new DB;
		$str = "SELECT distinct(b.STK_NO) FROM `".$strModule."` a inner join `".$subModule."` b on";
		$str .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
		$str .= "WHERE a.`type`='".$type."' ".$strQry." AND a.IsStatus <> 'D'";
		$str .=" and left(a.firmID,4)<>'Area' order by b.STK_NO";
		//$str = "select distinct(STK_NO) from arkstock where STK_KIND1='1' AND STK_KIND2='1' ";
		$db->query($str);
		
		if($db->num_rows() > 0){
			$temp = array();
			for ($i2=0;$i2<$db->num_rows();$i2++) {		
				$r= $db->fetch_assoc();
				$temp[$i2] = $r['STK_NO'];
			}
		}//end if
		
		$db1 = new DB;
		$str1 = "SELECT distinct(a.firmID) hospID FROM `".$strModule."` a inner join `".$subModule."` b on";
		$str1 .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
		$str1 .= "WHERE a.`type`='".$type."' ".$strQry." AND a.IsStatus <> 'D'";
		$str1 .=" and left(a.firmID,4)<>'Area' ";
		//$str1 = "select distinct(patientID) hospID from inpatientinfo";
		
		$arrPatient = array();
		$arrPatient2 = array();
		$db1->query($str1);
		if($db->num_rows() > 0){
		  for ($i1=0;$i1<$db1->num_rows();$i1++) {			
			$r1= $db1->fetch_assoc();
			$db1a = new DB;
			$db1a->query("SELECT `QillnessType_1`, `QillnessType_2`, `QillnessType_3`, `QillnessType_4` FROM `nurseform01` WHERE `HospNo`='".$r1['hospID']."' ORDER BY DATE DESC LIMIT 0,1");
			$r1a = $db1a->fetch_assoc();
			if ($r1a['QillnessType_3']==1 || $r1a['QillnessType_4']==1) {
				array_push($arrPatient2,$r1['hospID']);
			} else {
				array_push($arrPatient,$r1['hospID']);
			}
		  }
		}
		
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Asia/Taipei');
			
		/** Include PHPExcel */
		require_once dirname(__FILE__) . '/lib/PHPExcel.php';
		
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("u-Ark")
									 ->setLastModifiedBy("u-Ark")
									 ->setTitle("報表產出")
									 ->setSubject("報表產出")
									 ->setDescription("報表產出");
		
		// 自費院民耗材數量統計表
		$arraySheet1 = array(array('ID #', 'Full name', 'Bed #'));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet1[0], STK_NAME_s($v));
		}
		
		$count1=1;
		foreach ($arrPatient as $k1=>$v1) {
			array_push($arraySheet1, array($v1, getPatientName(getPID($v1)), getBedID(getPID($v1))));
			foreach ($temp as $k2=>$v2) {
				array_push($arraySheet1[$count1],getSTK_NUM($_GET['date1'], $_GET['date2'], $v2, $v1, 1, 1));
			}
			$count1++;
		}
		array_push($arraySheet1, array('', '', 'Totally '));
		$colID = 'D';
		foreach ($temp as $k2=>$v2) {
			array_push($arraySheet1[$count1], ('=SUM('.$colID.'2:'.$colID.$count1.')'));
			$colID++;
		}
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Self-paid-Quantity');
		foreach ($arraySheet1 as $k1=>$v1) {
			$colID = 'A';
			foreach ($v1 as $k2=>$v2) {
				$objPHPExcel->getActiveSheet()->setCellValue($colID.($k1+1), $v2);
				$colID++;
			}
		}
		
		// 公費院民耗材數量統計表
		$arraySheet2 = array(array('ID #', 'Full name', 'Bed #'));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet2[0], STK_NAME_s($v));
		}
		
		$count2=1;
		foreach ($arrPatient2 as $k1=>$v1) {
			array_push($arraySheet2, array($v1, getPatientName(getPID($v1)), getBedID(getPID($v1))));
			foreach ($temp as $k2=>$v2) {
				array_push($arraySheet2[$count2],getSTK_NUM($_GET['date1'], $_GET['date2'], $v2, $v1, 1, 1));
			}
			$count2++;
		}
		array_push($arraySheet2, array('', '', 'Totally '));
		$colID = 'D';
		foreach ($temp as $k2=>$v2) {
			array_push($arraySheet2[$count2], ('=SUM('.$colID.'2:'.$colID.$count2.')'));
			$colID++;
		}
		$objPHPExcel->createSheet(NULL, 1);
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()->setTitle('公費-Quantity');
		foreach ($arraySheet2 as $k1=>$v1) {
			$colID = 'A';
			foreach ($v1 as $k2=>$v2) {
				$objPHPExcel->getActiveSheet()->setCellValue($colID.($k1+1), $v2);
				$colID++;
			}
		}
		
		// 自費院民耗材金額統計表
		$arraySheet1 = array(array('ID #', 'Full name', 'Bed #'));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet1[0], STK_NAME_s($v));
		}
		array_push($arraySheet1[0], '應收金額');
		$count1=1;
		foreach ($arrPatient as $k1=>$v1) {
			array_push($arraySheet1, array($v1, getPatientName(getPID($v1)), getBedID(getPID($v1))));
			$colID='C';
			foreach ($temp as $k2=>$v2) {
				array_push($arraySheet1[$count1],(getSTK_PRC($_GET['date1'], $_GET['date2'], $v2, $v1, 1, 1)));
				$colID++;
			}
			array_push($arraySheet1[$count1],'=SUM(D'.($count1+1).':'.$colID.($count1+1).')');
			$count1++;
		}
		array_push($arraySheet1, array('自費住民金額小計','',''));
		$colID = 'D';
		foreach ($temp as $k2=>$v2) {
			array_push($arraySheet1[$count1], ('=SUM('.$colID.'2:'.$colID.$count1.')'));
			$colID++;
		}
		$objPHPExcel->createSheet(NULL, 2);
		$objPHPExcel->setActiveSheetIndex(2);
		$objPHPExcel->getActiveSheet()->setTitle('Self-paid-Amount of fee');
		$objPHPExcel->getActiveSheet()
			->mergeCells('A'.count($arraySheet1).':C'.count($arraySheet1))
			->getStyle('A'.count($arraySheet1).':C'.count($arraySheet1))
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		foreach ($arraySheet1 as $k1=>$v1) {
			$colID = 'A';
			foreach ($v1 as $k2=>$v2) {
				$objPHPExcel->getActiveSheet()->setCellValue($colID.($k1+1), $v2);
				$colID++;
			}
		}
		
		// 公費院民耗材金額統計表
		$arraySheet2 = array(array('ID #', 'Full name', 'Bed #'));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet2[0], STK_NAME_s($v));
		}
		array_push($arraySheet2[0], '應收金額');
		
		$count2=1;
		foreach ($arrPatient2 as $k1=>$v1) {
			array_push($arraySheet2, array($v1, getPatientName(getPID($v1)), getBedID(getPID($v1))));
			$colID = 'C';
			foreach ($temp as $k2=>$v2) {
				array_push($arraySheet2[$count2],(getSTK_PRC($_GET['date1'], $_GET['date2'], $v2, $v1, 1, 1)));
				$colID++;
			}
			array_push($arraySheet2[$count2],'=SUM(D'.($count2+1).':'.$colID.($count2+1).')');
			$count2++;
		}
		array_push($arraySheet2, array('公費住民金額小計','',''));
		$colID = 'D';
		foreach ($temp as $k2=>$v2) {
			array_push($arraySheet2[$count2], ('=SUM('.$colID.'2:'.$colID.$count2.')'));
			$colID++;
		}
		$objPHPExcel->createSheet(NULL, 3);
		$objPHPExcel->setActiveSheetIndex(3);
		$objPHPExcel->getActiveSheet()->setTitle('公費-Amount of fee');
		$objPHPExcel->getActiveSheet()
			->mergeCells('A'.count($arraySheet2).':C'.count($arraySheet2))
			->getStyle('A'.count($arraySheet2).':C'.count($arraySheet2))
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		foreach ($arraySheet2 as $k1=>$v1) {
			$colID = 'A';
			foreach ($v1 as $k2=>$v2) {
				$objPHPExcel->getActiveSheet()->setCellValue($colID.($k1+1), $v2);
				$colID++;
			}
		}
		
		// 院民耗材統計表
		$arraySheet3 = array(array(''));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet3[0], STK_NAME_s($v));
		}
		array_push($arraySheet3[0], '合計');
		
		array_push($arraySheet3, array('Sale price'));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet3[1], OUT_PRC($v));
		}
		array_push($arraySheet3[1], '---');
		
		array_push($arraySheet3, array('平均進價'));
		foreach ($temp as $k=>$v) {
			array_push($arraySheet3[2], AVG_IN_PRC($v));
		}
		array_push($arraySheet3[2], '---');
		
		array_push($arraySheet3, array('自費院民數量小計'));
		$colID = 'C';
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID++;
			$colID2++;
			array_push($arraySheet3[3], "=SUM('Self-paid-Quantity'!".$colID."2:".$colID.(count($arrPatient)+1).")");
		}
		array_push($arraySheet3[3], '=SUM(B4:'.$colID2.'4)');
		
		array_push($arraySheet3, array('公費院民數量小計'));
		$colID = 'C';
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID++;
			$colID2++;
			array_push($arraySheet3[4], "=SUM('公費-Quantity'!".$colID."2:".$colID.(count($arrPatient2)+1).")");
		}
		array_push($arraySheet3[4], '=SUM(B5:'.$colID2.'5)');
		
		array_push($arraySheet3, array('全院數量總計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[5], "=SUM(".$colID2."4:".$colID2."5)");
		}
		array_push($arraySheet3[5], '=SUM(B6:'.$colID2.'6)');
		
		array_push($arraySheet3, array('自費院民應收金額小計'));
		$colID = 'C';
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID++;
			$colID2++;
			array_push($arraySheet3[6], "=SUM('Self-paid-Amount of fee'!".$colID."2:".$colID.(count($arrPatient)+1).")");
		}
		array_push($arraySheet3[6], '=SUM(B7:'.$colID2.'7)');
		
		array_push($arraySheet3, array('公費院民應收金額小計'));
		$colID = 'C';
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID++;
			$colID2++;
			array_push($arraySheet3[7], "=SUM('公費-Amount of fee'!".$colID."2:".$colID.(count($arrPatient2)+1).")");
		}
		array_push($arraySheet3[7], '=SUM(B8:'.$colID2.'8)');
		
		array_push($arraySheet3, array('全院應收金額總計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[8], "=SUM(".$colID2."7:".$colID2."8)");
		}
		array_push($arraySheet3[8], '=SUM(B9:'.$colID2.'9)');
		
		array_push($arraySheet3, array('自費院民成本小計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[9], "=".$colID2."3*".$colID2."4");
		}
		array_push($arraySheet3[9], '=SUM(B10:'.$colID2.'10)');
		
		array_push($arraySheet3, array('公費院民成本小計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[10], "=".$colID2."3*".$colID2."5");
		}
		array_push($arraySheet3[10], '=SUM(B11:'.$colID2.'11)');
		
		array_push($arraySheet3, array('全院成本總計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[11], "=SUM(".$colID2."10:".$colID2."11)");
		}
		array_push($arraySheet3[11], '=SUM(B12:'.$colID2.'12)');
		
		array_push($arraySheet3, array('自費院民利潤小計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[12], "=".$colID2."7-".$colID2."10");
		}
		array_push($arraySheet3[12], '=SUM(B13:'.$colID2.'13)');
		
		array_push($arraySheet3, array('公費院民利潤小計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[13], "=".$colID2."8-".$colID2."11");
		}
		array_push($arraySheet3[13], '=SUM(B14:'.$colID2.'14)');
		
		array_push($arraySheet3, array('全院利潤總計'));
		$colID2 = 'A';
		foreach ($temp as $k=>$v) {
			$colID2++;
			array_push($arraySheet3[14], "=SUM(".$colID2."13:".$colID2."14)");
		}
		$colID2++;
		array_push($arraySheet3[14], '=SUM('.$colID2.'13:'.$colID2.'14)');
		
		$objPHPExcel->createSheet(NULL, 4);
		$objPHPExcel->setActiveSheetIndex(4);
		$objPHPExcel->getActiveSheet()->setTitle('Resident supply spending statistic');
		foreach ($arraySheet3 as $k1=>$v1) {
			$colID = 'A';
			foreach ($v1 as $k2=>$v2) {
				$objPHPExcel->getActiveSheet()->setCellValue($colID.($k1+1), $v2);
				$colID++;
			}
		}
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="院民耗材統計表_'.gmdate("YmdHis").'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	} else {
		//Print
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
	<center>
	<?php
	if (@$_GET['func']=='printmed') {
		$width = '1309px';
	} else {
		$width = '909px';
	}
	//模組名稱
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
	
	$db = new DB;
	$dbCount = new DB;
	$str = "SELECT distinct(b.STK_NO) FROM `".$strModule."` a inner join `".$subModule."` b on";
	$str .=" a.type=b.type and a.STK_Date=b.STK_Date and a.firmStockID=b.firmStockID inner join `arkstock` c on b.STK_NO=c.STK_NO ";
	$str .= "WHERE a.`type`='".$type."' ".$strQry." AND a.IsStatus <> 'D'";
	$str .=" and left(a.firmID,4)<>'Area' order by b.STK_NO";
	//$str = "select distinct(STK_NO) from arkstock where STK_KIND1='1' AND STK_KIND2='1' ";
	$db->query($str);
	
	if($db->num_rows() > 0){
		$page = 20;
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
	$arrPatient2 = array();
	$db1->query($str1);
	if($db->num_rows() > 0){
	  for ($i1=0;$i1<$db1->num_rows();$i1++) {			
		$r1= $db1->fetch_assoc();
		$db1a = new DB;
		$db1a->query("SELECT `QillnessType_1`, `QillnessType_2`, `QillnessType_3`, `QillnessType_4` FROM `nurseform01` WHERE `HospNo`='".$r1['hospID']."' ORDER BY DATE DESC LIMIT 0,1");
		$r1a = $db1a->fetch_assoc();
		if ($r1a['QillnessType_3']==1 || $r1a['QillnessType_4']==1) {
			array_push($arrPatient2,$r1['hospID']);
		} else {
			array_push($arrPatient,$r1['hospID']);
		}
	  }
	}
	///////////////////////////////////自費住民數量////////////////////////////////////////////
	$patientno = 28;
	$patientSize = ceil(count($arrPatient) / $patientno);
	for ($j=1;$j<=$patientSize;$j++) {
		for ($i0=1;$i0<=count($temp);$i0++) {
			echo '
		<h5>'.$_SESSION['nOrgName_lwj'].'</h5>
		<h5>自費院民耗材數量統計表</h5>
		<h5>  Since &nbsp;'; if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } echo 'Ends </h5>
		<div id="printarea"  class="printarea">
		<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="noborder2">
		  <tr>
			<td align="center" width="3%" class="bLineB0">ID #</td>
			<td align="center" width="7%" class="bLineB0">Full name</td>
			<td align="center" width="5%" class="bLineB0">Bed #</td>';
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
						$tmpSTKNUM = getSTK_NUM($_GET['date1'], $_GET['date2'], $v, $v1, 1, 1);
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'">'.$tmpSTKNUM.'</td>';
						${'sum_num_self_'.$v} += $tmpSTKNUM;
					}
					echo '
				  </tr>';
				}  
			}
			
			
		  if($j==$patientSize){
			echo '
			  <tr>
				<td align="right" class="bLineB1" colspan="3" nowrap="nowrap">自費院民數量小計</td>';
				foreach ($temp[$i0] as $k=>$v) {
					echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">'.${'sum_num_self_'.$v}.'</td>';
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
	
	///////////////////////////////////公費住民數量統計////////////////////////////////////////////
	$patientno = 28;
	$patientSize = ceil(count($arrPatient2) / $patientno);
	for ($j=1;$j<=$patientSize;$j++) {
		for ($i0=1;$i0<=count($temp);$i0++) {
			echo '<p style="page-break-after:always;"></p>';
			echo '
		<h5>'.$_SESSION['nOrgName_lwj'].'</h5>
		<h5>公費院民耗材數量統計表</h5>
		<h5>  Since &nbsp;'; if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } echo 'Ends </h5>
		<div id="printarea"  class="printarea">
		<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="noborder2">
		  <tr>
			<td align="center" width="3%" class="bLineB0">ID #</td>
			<td align="center" width="7%" class="bLineB0">Full name</td>
			<td align="center" width="5%" class="bLineB0">Bed #</td>';
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">'.STK_NAME_s($v).'</td>';
			}
			echo '
		  </tr>';
		  
			for ($patientstart = ($j-1)*$patientno; $patientstart < (($j-1)*$patientno)+$patientno; $patientstart++) {
			$v1 = $arrPatient2[$patientstart];
				if((int)$v1==0 && getPatientName(getPID($v1))==""){
					echo "";
				}else{
					echo '
				  <tr>
					<td class="bLineB1">'.(int)$v1.'</td>
					<td class="bLineB1">'.getPatientName(getPID($v1)).'</td>
					<td class="bLineB1">'.getBedID(getPID($v1)).'</td>';
					foreach ($temp[$i0] as $k=>$v) {
						$tmpSTKNUM = getSTK_NUM($_GET['date1'], $_GET['date2'], $v, $v1, 1, 1);
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'">'.$tmpSTKNUM.'</td>';
						${'sum_num_pub_'.$v} += $tmpSTKNUM;
					}
					echo '
				  </tr>';
				}  
			}
			
			
		  if($j==$patientSize){
			echo '
			  <tr>
				<td align="right" class="bLineB1" colspan="3" nowrap="nowrap">公費院民數量小計</td>';
				foreach ($temp[$i0] as $k=>$v) {
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">'.${'sum_num_pub_'.$v}.'</td>';
				}
				echo '
			  </tr>';
		  }  
	
		echo '
		</table>
		</div>';
	   }//end
	}//end
	
	echo '<p style="page-break-after:always;"></p>';
	///////////////////////////////////自費住民金額////////////////////////////////////////////
	$patientno = 28;
	$patientSize = ceil(count($arrPatient) / $patientno);
	for ($j=1;$j<=$patientSize;$j++) {
		for ($i0=1;$i0<=count($temp);$i0++) {
			echo '
		<h5>'.$_SESSION['nOrgName_lwj'].'</h5>
		<h5>自費院民耗材金額統計表</h5>
		<h5>  Since &nbsp;'; if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } echo 'Ends </h5>
		<div id="printarea"  class="printarea">
		<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="noborder2">
		  <tr>
			<td align="center" width="3%" class="bLineB0">ID #</td>
			<td align="center" width="7%" class="bLineB0">Full name</td>
			<td align="center" width="5%" class="bLineB0">Bed #</td>';
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">'.STK_NAME_s($v).'</td>';
			}
			if ($j==$patientSize && $i0==count($temp)) {
				echo '<td align="center" bgcolor="#CCCCCC" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">應收金額</td>';
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
						$tmpSTKPRC = getSTK_PRC($_GET['date1'], $_GET['date2'], $v, $v1, 1, 1);
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.$tmpSTKPRC.'</td>';
						${'sum_prc_self_'.$v} += $tmpSTKPRC;
						${'sum_prc_self_'.$v1} += $tmpSTKPRC;
					}
					if ($j==$patientSize && $i0==count($temp)) {
						echo '<td align="center" bgcolor="#EEEEEE" class="bLineB1 '.($i0==count($temp)?' bLineB11':'').'" nowrap="nowrap">$'.${'sum_prc_self_'.$v1}.'</td>';
					}
					echo '
				  </tr>';
				}  
			}
			
			
		  if($j==$patientSize){
			echo '
			  <tr>
				<td align="right" class="bLineB1" colspan="3" nowrap="nowrap">自費院民金額小計</td>';
				foreach ($temp[$i0] as $k=>$v) {
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'"  nowrap="nowrap">$'.${'sum_prc_self_'.$v}.'</td>';
						$sum_prctot_self += ${'sum_prc_self_'.$v};
				}
				if ($i0==count($temp)) {
					echo '<td align="center" bgcolor="#EEEEEE" class="bLineB1 bLineB11" nowrap="nowrap">$'.$sum_prctot_self.'</td>';
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
	
	///////////////////////////////////公費住民金額統計////////////////////////////////////////////
	$patientno = 28;
	$patientSize = ceil(count($arrPatient2) / $patientno);
	for ($j=1;$j<=$patientSize;$j++) {
		for ($i0=1;$i0<=count($temp);$i0++) {
			echo '<p style="page-break-after:always;"></p>';
			echo '
		<h5>'.$_SESSION['nOrgName_lwj'].'</h5>
		<h5>公費院民耗材金額統計表</h5>
		<h5>  Since &nbsp;'; if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } echo 'Ends </h5>
		<div id="printarea"  class="printarea">
		<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="noborder2">
		  <tr>
			<td align="center" width="3%" class="bLineB0">ID #</td>
			<td align="center" width="7%" class="bLineB0">Full name</td>
			<td align="center" width="5%" class="bLineB0">Bed #</td>';
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">'.STK_NAME_s($v).'</td>';
			}
			if ($j==$patientSize && $i0==count($temp)) {
				echo '<td align="center" bgcolor="#CCCCCC" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">應收金額</td>';
			}
			echo '
		  </tr>';
		  
			for ($patientstart = ($j-1)*$patientno; $patientstart < (($j-1)*$patientno)+$patientno; $patientstart++) {
			$v1 = $arrPatient2[$patientstart];
				if((int)$v1==0 && getPatientName(getPID($v1))==""){
					echo "";
				}else{
					echo '
				  <tr>
					<td class="bLineB1">'.(int)$v1.'</td>
					<td class="bLineB1">'.getPatientName(getPID($v1)).'</td>
					<td class="bLineB1">'.getBedID(getPID($v1)).'</td>';
					foreach ($temp[$i0] as $k=>$v) {
						$tmpSTKPRC = getSTK_PRC($_GET['date1'], $_GET['date2'], $v, $v1, 1, 1);
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.$tmpSTKPRC.'</td>';
						${'sum_prc_pub_'.$v} += $tmpSTKPRC;
						${'sum_prc_self_'.$v1} += $tmpSTKPRC;
					}
					if ($j==$patientSize && $i0==count($temp)) {
						echo '<td align="center" bgcolor="#EEEEEE" class="bLineB1 '.($i0==count($temp)?' bLineB11':'').'" nowrap="nowrap">$'.${'sum_prc_self_'.$v1}.'</td>';
					}
					echo '
				  </tr>';
				}  
			}
			
			
		  if($j==$patientSize){
			echo '
			  <tr>
				<td align="right" class="bLineB1" colspan="3" nowrap="nowrap">公費院民金額小計</td>';
				foreach ($temp[$i0] as $k=>$v) {
						echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.${'sum_prc_pub_'.$v}.'</td>';
						$sum_prctot_pub += ${'sum_prc_pub_'.$v};
				}
				if ($i0==count($temp)) {
					echo '<td align="center" bgcolor="#EEEEEE" class="bLineB1 bLineB11" nowrap="nowrap">$'.$sum_prctot_pub.'</td>';
				}
				echo '
			  </tr>';
		  }  
	
		echo '
		</table>
		</div>';
	   }//end
	}//end
	for ($i0=1;$i0<=count($temp);$i0++) {
		echo '<p style="page-break-after:always;"></p>';
	echo '
	<h5>'.$_SESSION['nOrgName_lwj'].'</h5>
	  <h5>Resident supply spending statistic</h5>
	  <h5>  Since &nbsp;'; if (@$_GET['date1']=="") { echo date("Y/m/d"); } else { echo @$_GET['date1']; } ?> ~ <?php if (@$_GET['date2']=="") { echo date("Y/m/d"); } else { echo @$_GET['date2']; } echo 'Ends </h5>
	  <div id="printarea"  class="printarea">
		<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="noborder2">
		  <tr>
			<td align="center" width="15%" class="bLineB0">&nbsp;</td>';
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" width="3%" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'">'.STK_NAME_s($v).'</td>';
			}
			echo '
			<td align="center" valign="top" class="bLineB0 bLineB01" width="5%">合計金額</td>
		  </tr>
		  <tr>
			<td align="right" class="bLineB0">Sale price</td>';
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" valign="top" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB01':'').'" nowrap="nowrap">$'.OUT_PRC($v).'</td>';
			}
		  echo '
			<td align="center" valign="top" class="bLineB0 bLineB01">---</td>
		  </tr>
		  <tr>
			<td align="right" class="bLineB1">平均進價</td>';
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" valign="top" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB01':'').'" nowrap="nowrap">$'.AVG_IN_PRC($v).'</td>';
			}
		  echo '
			<td align="center" valign="top" class="bLineB1 bLineB01">---</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB0" nowrap="nowrap">自費院民數量小計</td>';
			$sum1a = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">'.${'sum_num_self_'.$v}.'</td>';
				$sum1a += ${'sum_num_self_'.$v};
			}
			echo '
			<td align="center" valign="top" class="bLineB0 bLineB11">'.$sum1a.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB1" nowrap="nowrap">公費院民數量小計</td>';
			$sum2a = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">'.${'sum_num_pub_'.$v}.'</td>';
				$sum2a += ${'sum_num_pub_'.$v};
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11">'.$sum2a.'</td>
		  </tr>
		  <tr>
			<td align="right" class="bLineB1" nowrap="nowrap">全院數量總計</td>';
			$sum_tot = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">'.(${'sum_num_self_'.$v}+${'sum_num_pub_'.$v}).'</td>';
				$sum_tot += (${'sum_num_self_'.$v}+${'sum_num_pub_'.$v});
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11">'.$sum_tot.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB0" nowrap="nowrap">自費院民應收金額小計</td>';
			$sp1 = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.${'sum_prc_self_'.$v}.'</td>';
				$sp1 += ${'sum_prc_self_'.$v};
			}
			echo '
			<td align="center" valign="top" class="bLineB0 bLineB11" nowrap="nowrap">$'.$sp1.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB1" nowrap="nowrap">公費院民應收金額小計</td>';
			$sp2 = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.${'sum_prc_pub_'.$v}.'</td>';
				$sp2 += ${'sum_prc_pub_'.$v};
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11" nowrap="nowrap">$'.$sp2.'</td>
		  </tr>
		  <tr>
			<td align="right" class="bLineB1" nowrap="nowrap">全院應收金額總計</td>';
			$sp_tot = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(${'sum_prc_self_'.$v}+${'sum_prc_pub_'.$v}).'</td>';
				$sp_tot += (${'sum_prc_self_'.$v}+${'sum_prc_pub_'.$v});
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11" nowrap="nowrap">$'.$sp_tot.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB0" nowrap="nowrap">自費院民成本小計</td>';
			$cost1 = 0;
			foreach ($temp[$i0] as $k=>$v) {
				${'cost_self_'.$v} = (${'sum_num_self_'.$v}*AVG_IN_PRC($v));
				echo '<td align="center" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(substr($v,0,1)==3?"0":${'cost_self_'.$v}).'</td>';
				if (substr($v,0,1)!=3) { $cost1 += ${'cost_self_'.$v}; }
			}
			echo '
			<td align="center" valign="top" class="bLineB0 bLineB11">$'.$cost1.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB1" nowrap="nowrap">公費院民成本小計</td>';
			$cost2 = 0;
			foreach ($temp[$i0] as $k=>$v) {
				${'cost_pub_'.$v} = (${'sum_num_pub_'.$v}*AVG_IN_PRC($v));
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(substr($v,0,1)==3?"0":${'cost_pub_'.$v}).'</td>';
				if (substr($v,0,1)!=3) { $cost2 += ${'cost_pub_'.$v}; }
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11" nowrap="nowrap">$'.$cost2.'</td>
		  </tr>
		  <tr>
			<td align="right" class="bLineB1" nowrap="nowrap">全院成本總計</td>';
			$cost_tot = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(substr($v,0,1)==3?"0":(${'cost_self_'.$v}+${'cost_pub_'.$v})).'</td>';
				if (substr($v,0,1)!=3) { $cost_tot += (${'cost_self_'.$v}+${'cost_pub_'.$v}); }
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11" nowrap="nowrap">$'.$cost_tot.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB0" nowrap="nowrap">自費院民利潤小計</td>';
			$pf1 = 0;
			foreach ($temp[$i0] as $k=>$v) {
				${'profit_self_'.$v} = ${'sum_prc_self_'.$v} - ${'cost_self_'.$v};
				echo '<td align="center" class="bLineB0 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(substr($v,0,1)==3?"0":${'profit_self_'.$v}).'</td>';
				if (substr($v,0,1)!=3) { $pf1 += ${'profit_self_'.$v}; }
			}
			echo '
			<td align="center" valign="top" class="bLineB0 bLineB11" nowrap="nowrap">$'.$pf1.'</td>
		  </tr>
		  <tr>
			<td align="left" class="bLineB1" nowrap="nowrap">公費院民利潤小計</td>';
			$pf2 = 0;
			foreach ($temp[$i0] as $k=>$v) {
				${'profit_pub_'.$v} = ${'sum_prc_pub_'.$v} - ${'cost_pub_'.$v};
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(substr($v,0,1)==3?"0":${'profit_pub_'.$v}).'</td>';
				if (substr($v,0,1)!=3) { $pf2 += ${'profit_pub_'.$v}; }
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11" nowrap="nowrap">$'.$pf2.'</td>
		  </tr>
		  <tr>
			<td align="right" class="bLineB1" nowrap="nowrap">全院利潤總計</td>';
			$pf_tot = 0;
			foreach ($temp[$i0] as $k=>$v) {
				echo '<td align="center" class="bLineB1 '.($k==count($temp[$i0])-1?' bLineB11':'').'" nowrap="nowrap">$'.(substr($v,0,1)==3?"0":(${'profit_self_'.$v}+${'profit_pub_'.$v})).'</td>';
				if (substr($v,0,1)!=3) { $pf_tot += (${'profit_self_'.$v}+${'profit_pub_'.$v}); }
			}
			echo '
			<td align="center" valign="top" class="bLineB1 bLineB11" nowrap="nowrap">$'.$pf_tot.'</td>
		  </tr>
		</table>
	  </div>';
	}
	?><!--here-->
	
	</center>	
	</body>
	</html>
	<?php
	}
}
?>