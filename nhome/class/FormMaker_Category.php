<?php
include("DB.php");
$db6D = new DB;
$db6D->query("SELECT `CategoryID` FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
$r6D = $db6D->fetch_assoc();
if($r6D['CategoryID']!=$_POST['CategoryID']){
	$db = new DB;
	$db->query("UPDATE `formmaker_list` SET `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."' WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
	$db2 = new DB;
	$db2->query("SELECT * FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
	$r2 = $db2->fetch_assoc();
	$db3 = new DB;
	$db3->query("SELECT * FROM `formmaker_category` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."'");
	$r3 = $db3->fetch_assoc();
	$db5 = new DB;
	$db5->query("SELECT `Show_Order` FROM `formmaker_order` WHERE `CategoryID`='".$r3['CategoryID']."' ORDER BY `Show_Order` DESC LIMIT 0,1");
	if($db5->num_rows()>0){
		$r5 = $db5->fetch_assoc();
		if($r5['Show_Order']!=''){
			$order = $r5['Show_Order']+1;
		}else{
			$order = 1;
		}
	}else{
		$order = 1;
	}
	$db6 = new DB;
	$db6->query("UPDATE `formmaker_order` SET `CategoryID`='".$r3['CategoryID']."',`CategoryName`='".$r3['CategoryName']."',`Show_Order`='".$order."' WHERE `formID`='".$r2['formID']."'");	
}
echo "OK";
?>