<?php
include("DB.php");
include("function.php");

$strModule = "feecreate";
$PID = mysql_escape_string(getHospNoByHospNoDisplayNoType($_POST['PID']));
$date = mysql_escape_string($_POST['date1']);
$sql1 = "SELECT * FROM `".$strModule."` WHERE HospNo = '".$PID."' AND `date1`='".$date."' AND `status` != 'D'";
$db = new DB;
$db->query($sql1);
if($db->num_rows() >0){
	echo '1;'."該月已產生過費用";
}else{
	echo '0;';
}
?>