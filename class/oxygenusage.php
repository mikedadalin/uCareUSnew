<?php
include("DB.php");
include("function.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$Qstartdate = str_replace("/","",$_POST['Qstartdate']);
$Qstarttime = $_POST['Qstarttime'];
$Qenddate = str_replace("/","",$_POST['Qenddate']);
$Qendtime = $_POST['Qendtime'];
$Qnewmat_1 = $_POST['Qnewmat_1'];
$Qnewmat_2 = $_POST['Qnewmat_2'];
if ($Qnewmat_1=='1') { $Qnewmat = '1'; $newText = "Yes"; } elseif ($Qnewmat_2 == '1') { $Qnewmat = '2'; $newText = "None"; } else { $Qnewmat = '0'; $newText = "---";  }//1->tyes,2->no,3->'---'
$usedday =calcperiodwithtime($Qstartdate,$Qstarttime,$Qenddate,$Qendtime);
$db = new DB;
$db->query("INSERT INTO `oxygenusage` VALUES ('".$HospNo."','".$Qstartdate."','".$Qstarttime."','".$Qenddate."','".$Qendtime."','".$usedday."','".$Qnewmat."', '".$_SESSION['ncareID_lwj']."')");

echo formatdate($Qstartdate).';'.substr($Qstarttime,0,2).':'.substr($Qendtime,2,2).';'.formatdate($Qenddate).';'.substr($Qendtime,0,2).':'.substr($Qendtime,2,2).';'.$usedday.';'.$newText;
?>