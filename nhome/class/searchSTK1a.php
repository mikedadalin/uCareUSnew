<?php
session_start();
include("DB.php");

$KIND = $_POST['KIND'];

$where = " WHERE ";
if ($KIND!='') { $where .= " a.`KIND_NO`='".$KIND."' AND "; }

$where = substr($where,0,strlen($where)-5);

if ($_SESSION['ncareLevel_lwj']==5 || $_POST['AREA']==1) {
	$sql = "SELECT * FROM `arkstockforapply` ".$where." AND `STOP_ID`='0' AND `STK_DISPLAY`>0 ORDER BY `STK_NO` ASC";
} else {
	$sql = "SELECT * FROM `arkstockforapply` ".$where." AND `STOP_ID`='0' AND `STK_DISPLAY` LIKE '".$_SESSION['ncareGroup_lwj']."' ORDER BY `STK_NO` ASC";
}

$sql = "SELECT a.ApplyItemID, a.STK_NAME, a.STK_UNIT, b.STK_SPK, b.STK_MODEL, a.STK_DISPLAY FROM `arkstockforapply` a inner join `arkstock` b on a.`STK_NO`=b.`STK_NO` WHERE  a.`KIND_NO`='".$KIND."' AND a.`STOP_ID`='0' AND a.`STK_DISPLAY`>0 ORDER BY a.`STK_NO` ASC";

$db = new DB;
$db->query($sql);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$arrSTK_DISPLAY = explode(";",$r['STK_DISPLAY']);
	if (in_array((int) $_SESSION['ncareGroup_lwj'], $arrSTK_DISPLAY)) {
		$result .= $r['ApplyItemID'].'||'.$r['STK_NAME'].'||'.$r['STK_SPK'].'||'.$r['STK_MODEL'].'||'.$r['STK_UNIT'].';';		
	}
}

echo $result;
?>