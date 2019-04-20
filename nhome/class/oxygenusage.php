<?php
include("DB.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$Qstartdate = str_replace("/","",$_POST['Qstartdate']);
$Qstarttime = $_POST['Qstarttime'];
$Qenddate = str_replace("/","",$_POST['Qenddate']);
$Qendtime = $_POST['Qendtime'];
$Qnewmat_1 = $_POST['Qnewmat_1'];
$Qnewmat_2 = $_POST['Qnewmat_2'];
if ($Qnewmat_1=='1') { $Qnewmat = '1'; $newText = "是yes"; } elseif ($Qnewmat_2 == '1') { $Qnewmat = '2'; $newText = "否no"; } else { $Qnewmat = '0'; $newText = "---";  }
$usedday =calcperiodwithtime($Qstartdate,$Qstarttime,$Qenddate,$Qendtime);
$db = new DB;
$db->query("INSERT INTO `oxygenusage` VALUES ('".$HospNo."','".$Qstartdate."','".$Qstarttime."','".$Qenddate."','".$Qendtime."','".$usedday."','".$Qnewmat."', '".$_SESSION['ncareID_lwj']."')");

echo formatdate($Qstartdate).';'.substr($Qstarttime,0,2).':'.substr($Qendtime,2,2).';'.formatdate($Qenddate).';'.substr($Qendtime,0,2).':'.substr($Qendtime,2,2).';'.$usedday.';'.$newText;
?>