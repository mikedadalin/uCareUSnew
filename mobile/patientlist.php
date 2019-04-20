<ul data-role="listview" data-filter="true" data-inset="true" data-filter-placeholder="輸入床號搜尋Search Bed Number...">
<?php
$sql1 = "SELECT * FROM `inpatientinfo` ORDER BY `bed` ASC";
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	
	$db1 = new DB;
	$db1->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
	for ($j=0;$j<$db1->num_rows();$j++) {
		$r1 = $db1->fetch_assoc();
		$db2a = new DB;
		$db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
		$r2a = $db2a->fetch_assoc();
		$db2b = new DB;
		$db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
		$r2b = $db2b->fetch_assoc();
		$db2c = new DB;
		$db2c->query("SELECT * FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r2c = $db2c->fetch_assoc();
		if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
			echo '<li><a href="index.php?func=basicinfo&id='.$r['patientID'].'" data-role="button" data-icon="user">'.$r1['bed'].' '.$r2c['Name'].' '.$r2c['HospNo'].'</a></li>';
		}
	}
}
?>
</ul>