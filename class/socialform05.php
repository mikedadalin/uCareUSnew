<?php
include("DB.php");
include("array.php");
include("function.php");

foreach($_POST as $k=>$v){
	$_POST[$k] = mysql_escape_string($v);
}
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Q1_1 = $_POST['Q1_1'];
$Q1_2 = $_POST['Q1_2'];
$Q1_3 = $_POST['Q1_3'];
$Q1_4 = $_POST['Q1_4'];
$Q1_5 = $_POST['Q1_5'];
$Q1_6 = $_POST['Q1_6'];
$Q1_7 = $_POST['Q1_7'];
$Q2 = $_POST['Q2'];
$Q3 = $_POST['Q3'];
$Q4 = $_POST['Q4'];
$Q5 = $_POST['Q5'];
$Qfiller = $_POST['Qfiller'];

$db = new DB;
$db->query("INSERT INTO `socialform05` VALUES ('".$HospNo."','".$date."', '".$Q1_1."', '".$Q1_2."', '".$Q1_3."', '".$Q1_4."', '".$Q1_5."', '".$Q1_6."', '".$Q1_7."', '".$Q2."', '".$Q3."', '".$Q4."', '".$Q5."', '".$Qfiller."')");

for ($i=1;$i<=7;$i++) {
	$txt = "Q1_".$i;
	$var = ${$txt};
	if ($var == 1) {
		$ans = explode("_",$txt);
		$Q1 = $ans[1];
	}
}
echo formatdate($date).";".$arrSocialform05_Q1[$Q1].";".$Q2;
?>