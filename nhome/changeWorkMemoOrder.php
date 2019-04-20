<?php
$action = mysql_escape_string($_GET['action']);
$Order = mysql_escape_string($_GET['order']);
$MemoID = mysql_escape_string($_GET['MemoID']);
if($action=="UP"){
	$preOrder = $Order-1;
	$db = new DB;
	$db->query("UPDATE `workmemolist` SET `order`='".$Order."' WHERE `order`='".$preOrder."'");
	$db2 = new DB;
	$db2->query("UPDATE `workmemolist` SET `order`='".$preOrder."' WHERE `MemoID`='".$MemoID."'");
	echo "<script>history.go(-1)</script>";
}
if($action=="DOWN"){
	$nextOrder = $Order+1;
	$db = new DB;
	$db->query("UPDATE `workmemolist` SET `order`='".$Order."' WHERE `order`='".$nextOrder."'");
	$db2 = new DB;
	$db2->query("UPDATE `workmemolist` SET `order`='".$nextOrder."' WHERE `MemoID`='".$MemoID."'");
	echo "<script>history.go(-1)</script>";
}
?>