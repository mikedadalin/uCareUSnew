<?php
include("DB.php");
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
$meal6 = str_replace(';','<br>',$_POST['meal6']);
$meal6 = str_replace('；','<br>',$meal6);
if ($_POST['meal7']!="") {
	$meal7 = str_replace(';',';',$_POST['meal7']);
	$meal7 = str_replace('；',';',$meal7);
	$meal7 = explode(";", $meal7);
} else {
	$meal7 = "";
}
$memo = str_replace(';','<br>',$_POST['memo']);
$memo = str_replace('；','<br>',$memo);

$db = new DB;
$db->query("SELECT * FROM `foodmenu` WHERE `date`='".$date[0].$month.$day."'");
if ($db->num_rows()==0) {
	$db1 = new DB;
	$db1->query("INSERT INTO `foodmenu` VALUES ('".$date[0].$month.$day."', '".$meal1."', '".$meal2."', '".$meal3."', '".$meal4."', '".$meal5."', '".$meal6."', '".$memo."', '', '".mysql_escape_string($_POST['Qfiller'])."')");
} else {
	$db1 = new DB;
	$db1->query("UPDATE `foodmenu` SET `meal1`='".$meal1."', `meal2`='".$meal2."', `meal3`='".$meal3."', `meal4`='".$meal4."', `meal5`='".$meal5."', `meal6`='".$meal6."', `memo`='".$memo."', `exchanger`='".mysql_escape_string($_POST['Qfiller'])."' WHERE `date`='".$date[0].$month.$day."';");
}

if ($meal7=="") {
	$db = new DB;
	$db->query("DELETE FROM `happymeal` WHERE `date`='".mysql_escape_string($_POST['date'])."'");
} else {
	for ($i=0;$i<count($meal7);$i++) {
		$db = new DB;
		$db->query("SELECT * FROM `happymeal` WHERE `date`='".mysql_escape_string($_POST['date'])."' AND `title`='".$meal7[$i]."'");
		if ($db->num_rows()==0) {
			$db1 = new DB;
			$db1->query("INSERT INTO `happymeal` VALUES ('', '".mysql_escape_string($_POST['date'])."', '".$meal7[$i]."', '', '0')");
		} else {
			$r = $db->fetch_assoc();
			$db1 = new DB;
			$db1->query("UPDATE `happymeal` SET `title`='".$meal7[$i]."' WHERE `mID`='".$r['mID']."';");
		}
	}
}
?>