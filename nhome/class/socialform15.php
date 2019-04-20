<?php
include("DB.php");
$formID = $_POST['formID'];
$timeH = mysql_escape_string($_POST['timeH']);
$timeI = mysql_escape_string($_POST['timeI']);

$db = new DB;
$strSQL = "INSERT INTO `".$formID."` ( ";
	foreach ($_POST as $k=>$v){
		if($k !="HospNo" && $k!="formID" && $k!="timeH" && $k!="timeI"){			
			$strSQL .= "`".$k."`,";
		}
	}
$strSQL .= ($timeH==""?"":" `time`, ")." `HospNo`) VALUES ( ";
	foreach ($_POST as $k=>$v){
		if($k !="HospNo" && $k!="formID" && $k!="timeH" && $k!="timeI"){
			if($k=="date"){$v=str_replace("/","",$v);}
			$strSQL .= "'".$v."',";
		}
	}
$strSQL .= ($timeH==""?"":"'".$timeH.":".$timeI.":00',")."' ".$_POST['HospNo']."')";
$db->query($strSQL);
//echo $strSQL;
?>