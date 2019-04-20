<?php
include("DB.php");
include("function.php");
$date = mysql_escape_string(str_replace("/","",str_replace("-","",$_POST['date'])));
$db = new DB;
$db->query("SELECT * FROM `dailypatientno1` WHERE DATE_FORMAT(`date`,'%Y%m%d')='".$date."'");

//ALTER TABLE  `dailypatientno` ADD  `foleypat` INT( 4 ) NOT NULL AFTER  `outpat` , ADD  `nofoleypat` INT( 4 ) NOT NULL AFTER  `foleypat` ;

if ($db->num_rows()==0) {
	$db1 = new DB;
	$db1->query("INSERT INTO `dailypatientno1` VALUES (DATE_FORMAT('".$date."','%Y-%m-%d'), '".mysql_escape_string($_POST['newpat'])."', '".mysql_escape_string($_POST['no'])."', '".mysql_escape_string($_POST['outpat'])."', '".mysql_escape_string($_POST['foleypat'])."', '".mysql_escape_string($_POST['nofoleypat'])."', '".mysql_escape_string($_POST['hosppat'])."', '".mysql_escape_string($_POST['backpat'])."', '".mysql_escape_string($_POST['deadpat'])."', '".mysql_escape_string($_POST['Qfiller'])."')");
} else {
	echo "EXISTED";
}
?>