<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$Q1_1 = mysql_escape_string($_POST['Q1_1']);
$Q1_2 = mysql_escape_string($_POST['Q1_2']);
$Q1_3 = mysql_escape_string($_POST['Q1_3']);
$Q1_4 = mysql_escape_string($_POST['Q1_4']);
$Q1_5 = mysql_escape_string($_POST['Q1_5']);
$Q1_6 = mysql_escape_string($_POST['Q1_6']);
$Q1_7 = mysql_escape_string($_POST['Q1_7']);
$Q2 = mysql_escape_string($_POST['Q2']);
$Q3 = mysql_escape_string($_POST['Q3']);
$Q4 = mysql_escape_string($_POST['Q4']);
$Q5 = mysql_escape_string($_POST['Q5']);
$Qfiller = mysql_escape_string($_POST['Qfiller']);

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