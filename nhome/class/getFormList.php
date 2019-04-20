<?php
include("DB2.php");

$cateID = $_POST['cateID'];
if($cateID!=""){
	$db = new DB2;
	$db->query("SELECT `subcateID` FROM `permission_subcate` WHERE `cateID`='".$cateID."'");
	for($i=0;$i<$db->num_rows();$i++){
		$r = $db->fetch_assoc();
		$db2 = new DB2;
		$db2->query("SELECT `serNo`,`name` FROM `permission_item` WHERE `subcateID`='".$r['subcateID']."' ORDER BY `ord` ASC");
		for($i2=0;$i2<$db2->num_rows();$i2++){
			$r2 = $db2->fetch_assoc();
			if ($out!="") { $out .= ';'; }
			$out .= $r2['serNo'].":".$r2['name'];
		}
	}
	echo $out;
}else{
	echo 'no';
}
?>