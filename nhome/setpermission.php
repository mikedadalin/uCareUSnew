<?php
$db1 = new DB2;
$db1->query("SELECT * FROM `userinfo`");
for ($i1=0;$i1<$db1->num_rows();$i1++) {
	$r1 = $db1->fetch_assoc();
	$db1b1 = new DB2;
	$db1b1->query("SELECT * FROM `permissionset` WHERE `OrgID`='".$r1['OrgID']."'");
	$strDB = 'a.`OrgID`=b.`OrgID`';
	$db1b = new DB2;
	$db1b->query("SELECT b.`PermissionSet` FROM `userinfo` a INNER JOIN `permissionset` b ON a.`group`=b.`Group` AND ".$strDB." WHERE a.`userID`='".$r1['userID']."'");
	$r1b = $db1b->fetch_assoc();
	$arrPerSet = explode(';',$r1b['PermissionSet']);
	foreach ($arrPerSet as $k=>$v) {
		$db1c = new DB2;
		$db1c->query("SELECT a.Name as `perName`, b.`name` as `subcateName`, c.`serNo`, c.icon, c.name as `itemname` FROM `permission2` a INNER JOIN `permission_subcate` b ON b.`cateID`=a.`PermissionID` INNER JOIN `permission_item` c ON c.`subcateID`=b.`subcateID` WHERE a.`PermissionID`='".$v."' ORDER BY a.`order`, b.`subcateID`, c.`subcateID`");
		for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
			$r1c = $db1c->fetch_assoc();
			//$arrPerList[$r1c['serNo']] = 1;
			$db1d = new DB2;
			$db1d->query("INSERT INTO `user_permission` VALUES ('".$r1['userID']."', '".$r1c['serNo']."', '1');");
		}
	}
}
?>