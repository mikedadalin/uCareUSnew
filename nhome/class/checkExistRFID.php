<?php
include("DB.php");
$cardno = mysql_escape_string($_POST['cardno']);
$db = new DB;
$db->query("SELECT * FROM `employer` WHERE `rfidno`='".$cardno."'");

$db1 = new DB;
$db1->query("SELECT * FROM `foreignemployer` WHERE `rfidno`='".$cardno."'");

if ($db->num_rows()==0 && $db1->num_rows()==0) {
	echo "OK:";
} else {
	if ($db->num_rows()>0) {
		$r = $db->fetch_assoc();
		$name = $r['Name'];
	} elseif ($db1->num_rows()>0) {
		$r1 = $db->fetch_assoc();
		$name = $r1['cNickname'];
	}
	echo "EXISTED:".$name;
}
//echo $STKNO;
?>