<?php
session_start();
include('class/DB.php');
include('class/DB2.php');
include('class/function.php');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Taipei');
	
/** Include PHPExcel */
require_once dirname(__FILE__) . '/lib/PHPExcel.php';

$arrTables = array();
$arrFiles = array();
$db1 = new DB;
$db1->query("SHOW TABLES");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	foreach ($r1 as $k1=>$v1) {
		$tmp = $v1;
	}
	array_push($arrTables, $tmp);
}

//$vt			table name
//$r2f			column name
//$arrTables	table name array
//$arrColumn	column name array

$uploaddir = 'tmp/'.$_SESSION['nOrgID_lwj'].'/';
if (!file_exists($uploaddir)) { mkdir($uploaddir, 0777); }

$arrNoExport = array("alldetail","consump_pricing","consumpform03_1","consumpform01","consumpform02","dailyform06","deletelog","drug","familystructure","feesetting_bak","formremind","monthlyfee","nurseform06","oxygenusage","pInfoLog","pat_idphoto","service_cate","service_item","service_maintenance","socialform31","staticfee","stock","training_form");

foreach ($arrTables as $kt=>$vt) {
	if (!in_array($vt, $arrNoExport)) {
		$db = new DB2;
		$db->query("SELECT * FROM `formtable` WHERE `tablename`='".$vt."'");
		if ($db->num_rows()==0) {
			$db0 = new DB2;
			$db0->query("INSERT INTO `formtable` VALUES ('".$vt."', '');");
		} else {
			$r = $db->fetch_assoc();
			$tmpVt = $r['formname'];
		}
		
		if ($tmpVt!="") { $vtname = $tmpVt; } else { $vtname = $vt; }
		
		$outfile = 'tmp/'.$_SESSION['nOrgID_lwj'].'/'.$vtname.'.csv';
		
		if (is_file($outfile)) { unlink($outfile); }
		$f = fopen($outfile, 'w');
		
		$db = new DB2;
		$db->query("SELECT * FROM `formtable` WHERE `tablename`='".$vt."'");
		if ($db->num_rows()==0) {
			$db0 = new DB2;
			$db0->query("INSERT INTO `formtable` VALUES ('".$vt."', '');");
		}
		
		$db2 = new DB;
		$db2->query("SELECT * FROM `".$vt."`");
		$numFields = $db2->num_fields();
		$arrColumn[$vt] = array();
		for ($i2=0;$i2<$numFields;$i2++) {
			$r2f = $db2->field_name($i2);
			array_push($arrColumn[$vt], $r2f);
		}
		
		fputcsv($f, $arrColumn[$vt]);
		
		for ($i3=0;$i3<$db2->num_rows();$i3++) {
			$r2 = $db2->fetch_assoc();
			fputcsv($f, $r2);
		}
		array_push($arrFiles, $outfile);
		fclose($f);
	}
}

$zipname = './tmp/'.$_SESSION['nOrgID_lwj'].'_backup_'.date(Ymd).'.zip';
$zip = new ZipArchive();
$zip->open($zipname, ZipArchive::CREATE);
foreach ($arrFiles as $file) {
	$zip->addFile($file);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);

foreach ($arrFiles as $file) {
	//unlink($file);
}

//unlink($zipname);
?>

