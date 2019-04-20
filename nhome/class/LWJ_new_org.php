<?php
include("DB2.php");
$db = new DB2;
$db->query("SELECT `OrgID` FROM `orginfo` WHERE `OrgID`='".mysql_escape_string($_POST['OrgID'])."'");
if($db->num_rows()>0){
	echo 'NO';
}else{
	$db2 = new DB2;
	$db2->query("INSERT INTO `orginfo` VALUES ('".mysql_escape_string($_POST['OrgID'])."','','','','','','','0000-00-00','tnoaunimewb9aenr-".substr($_POST['OrgID'],2,4)."','1','nhome','0')");
	$db3 = new DB2;
	$db3->query("INSERT INTO `system_setting` VALUES ('".mysql_escape_string($_POST['OrgID'])."','','','','','','','','','','','','','','','','','','','','','1','3','2','0','1','1','','','','','','','','','','','','','','','0','0','6','2','3','0','0','1','0','0','')");
	$db4 = new DB2;
	$db4->query("SELECT * FROM `permissionset` WHERE `OrgID`='MA9999' ORDER BY `Group` ASC");
	for($i=0;$i<$db4->num_rows();$i++){
		$r4 = $db4->fetch_assoc();
		$db5 = new DB2;
		$db5->query("INSERT INTO `permissionset` VALUES ('".mysql_escape_string($_POST['OrgID'])."','".$r4['Group']."','".$r4['PermissionSet']."','".$r4['DirectLink']."','')");
	}
	echo "OK";
}
?>