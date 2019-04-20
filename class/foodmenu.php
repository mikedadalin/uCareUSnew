<?php
include("DB.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$date = explode('/',$_POST['date']);
if (strlen($date[1])==1) { $month = '0'.$date[1]; } else { $month = $date[1]; }
if (strlen($date[2])==1) { $day = '0'.$date[2]; } else { $day = $date[2]; }

$meal1 = str_replace(';','<br>',$_POST['meal1']);
$meal1 = str_replace('；','<br>',$meal1);
$meal2 = str_replace(';','<br>',$_POST['meal2']);
$meal2 = str_replace('；','<br>',$meal2);
$meal3 = str_replace(';','<br>',$_POST['meal3']);
$meal3 = str_replace('；','<br>',$meal3);
$meal4 = str_replace(';','<br>',$_POST['meal4']);
$meal4 = str_replace('；','<br>',$meal4);
$meal5 = str_replace(';','<br>',$_POST['meal5']);
$meal5 = str_replace('；','<br>',$meal5);


$db = new DB;
$db->query("SELECT * FROM `foodmenu` WHERE `date`='".$date[0].$month.$day."'");
if ($db->num_rows()==0) {
	$db1 = new DB;
	$db1->query("INSERT INTO `foodmenu` VALUES ('".$date[0].$month.$day."', '".$meal1."', '".$meal2."', '".$meal3."', '".$meal4."', '".$meal5."')");
} else {
	$db1 = new DB;
	$db1->query("UPDATE `foodmenu` SET `meal1`='".$meal1."', `meal2`='".$meal2."', `meal3`='".$meal3."', `meal4`='".$meal4."', `meal5`='".$meal5."' WHERE `date`='".$date[0].$month.$day."';");
}
?>