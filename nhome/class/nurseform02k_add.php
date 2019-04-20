<?php
session_start();
include("DB.php");
include("DB2.php");
include("array.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$newdate = str_replace("/","",$_POST['newdate']);
$status = $_POST['status'];
$PipelineNo = $_POST['PipelineNo'];
$strSQL = " AND `HospNo`='".$HospNo."' AND `date`='".$date."' AND `PipelineNo`='".$PipelineNo."' ";
$db = new DB;
$db->query("SELECT * FROM `nurseform02k` WHERE 1 ".$strSQL."");
if($db->num_rows()>0){
	$rs = $db->fetch_assoc();
	//update status
	$db1 = new DB;
	$db1->query("UPDATE `nurseform02k` SET `Q5`='".$status."' WHERE 1 ".$strSQL."");
	
	//insert next
	if ($status==1) {
		$db3 = new DB;
		$db3->query("SELECT `No` FROM `nurseform02k` WHERE `PipelineNo`='".$PipelineNo."' ORDER BY `No` DESC LIMIT 0,1");
		$r3 = $db3->fetch_assoc();
		$db2 = new DB;
		$db2->query("INSERT INTO `nurseform02k` VALUES ('".$HospNo."','".$newdate."','".$rs['Q1']."','".$rs['Q2']."','".$rs['Q3']."','".$rs['Q4']."','0','".$PipelineNo."','".($r3['No']+1)."','".$_SESSION['ncareID_lwj']."')");
		$dbs = new DB2;
		$dbs->query("SELECT `foleyrecord` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
		$rS = $dbs->fetch_assoc();
		if ($rS['foleyrecord']==1) {
			//管路更換填寫至護理紀錄
			$dbN = new DB;
			$dbN->query("INSERT INTO `nurseform05` VALUES ('', '".$HospNo."', '".$newdate."', '".date(Hi)."', 'Pipeline replacement', '住民<管路>到期, 居家護理師協助更換, 無不適狀況', '', '".$_SESSION['ncareID_lwj']."')");
		}
		echo "1OK";
	} else {
		echo "2OK";
	}
}
?>