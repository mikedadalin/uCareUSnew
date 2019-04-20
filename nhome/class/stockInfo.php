<?php
include("DB.php");
include("function.php");

$strModule = "stockinfo";
$PID = mysql_escape_string($_POST['PID']);

$sql1 = "SELECT * FROM `".$strModule."` WHERE 1=1 And stockinfoID = '".$PID."'";
$db = new DB;
$db->query($sql1);

if($db->num_rows()==0){
	echo "";
}else{
	$rs = $db->fetch_assoc();
	echo $rs['Title'];
}
?>