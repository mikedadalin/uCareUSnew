<?php
include("DB.php");
include("function.php");

$strModule = "firm";
$PID = mysql_escape_string($_POST['PID']);

$sql1 = "SELECT * FROM `".$strModule."` WHERE IsStop_1=1 And ".$strModule."ID = '".$PID."'";
$db = new DB;
$db->query($sql1);

if($db->num_rows()!=0){
	$rs = $db->fetch_assoc();
	echo $rs['Title'].";".$rs['Fidno'].";".$rs['Discount'];
}
?>