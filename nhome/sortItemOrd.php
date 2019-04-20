<?php
include("class/DB2.php");
$db1= new DB2;
$db1->query("SELECT DISTINCT `subcateID` FROM `permission_item` ORDER BY `subcateID`");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	$db2 = new DB2;
	$db2->query("SELECT * FROM `permission_item` WHERE `subcateID`='".$r1['subcateID']."' ORDER BY `serNo`");
	for ($i2=0;$i2<$db2->num_rows();$i2++) {
		$r2 = $db2->fetch_assoc();
		$db3 = new DB2;
		$db3->query("UPDATE `permission_item` SET `ord`='".($i2+1)."' WHERE `serNo`='".$r2['serNo']."'");
	}
}
?>