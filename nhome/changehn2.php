	<div class="nurseform-table">
<?php
$oldHospNo = mysql_escape_string($_GET['oldHN']);
$newHospNo = mysql_escape_string($_GET['newHN']);
$db0 = new DB;
$db0->query("SELECT `patientID`,`Birth` FROM `patient` WHERE `HospNo`='".$newHospNo."'");
if ($db0->num_rows()>0) {
	$r0 = $db0->fetch_assoc();
	echo '<form method="post" action="index.php?func=changehn2&oldHN='.$oldHospNo.'&newHN='.$newHospNo.'&override=1">
	<table width="100%">
	  <tr class="title">
	    <td colspan="2">請確認是否覆寫下列住民資料？Pleas confirm overwriting listed resident info!?</td>
	  </tr>
	  <tr>
	    <td class="title_s" width="120">Full name</td>
		<td>'.getPatientName($r0['patientID']).'</td>
	  </tr>
	  <tr>
	    <td class="title_s">Birth date</td>
		<td>'.formatdate($r0['Birth']).'</td>
	  </tr>
	  <tr class="title">
	    <td colspan="2"><input type="submit" value="Confirm"> <input type="button" value="Cancel" onclick="window.location.href=\'index.php?func=patientlist\'"></td>
	  </tr>
	</table>
	</form>';
}
if ($db0->num_rows()==0 || @$_GET['override']==1) {
	echo '如果出現任何錯誤訊息，請記下操作的護字號及錯誤訊息，並立即與我們聯絡處理，謝謝！If any error message appears, please record the Care ID# your manipulating and contact us immediately!';
	$arrExludeDB = array('arkord', 'arkordinfo');
	$db = new DB;
	$db->query("SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('HospNo','PS_NO') AND TABLE_SCHEMA='".$_SESSION['ncareDBno_lwj']."';");
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		if (in_array($r['TABLE_NAME'],$arrExludeDB)) { $fieldname = 'PS_NO'; } else { $fieldname = 'HospNo'; }
		if ($r['TABLE_NAME']!="nurseform17" && $r['TABLE_NAME']!="patient") {
			$db1 = new DB;
			$db1->query("UPDATE `".$r['TABLE_NAME']."` SET `".$fieldname."`='999999' WHERE `".$fieldname."`='".$oldHospNo."'");
			$db2 = new DB;
			$db2->query("UPDATE `".$r['TABLE_NAME']."` SET `".$fieldname."`='".$newHospNo."' WHERE `".$fieldname."`='999999'");
		} elseif ($r['TABLE_NAME']=="nurseform17") {
			$db1 = new DB;
			$db1->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$oldHospNo."' ORDER BY `order` ASC");
			$oldMedOrder = $db1->num_rows();
			$db2 = new DB;
			$db2->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$newHospNo."' ORDER BY `order` ASC");
			$newMedOrder = $db2->num_rows();
			for ($i1=1;$i1<=$oldMedOrder;$i1++) {
				$r1 = $db1->fetch_assoc();
				$newOrder = $i1 + $newMedOrder;
				$db2a = new DB;
				$db2a->query("UPDATE `nurseform17` SET `HospNo` = '".$newHospNo."', `order`='".$newOrder."' WHERE `HospNo`='".$oldHospNo."' AND `order`='".$r1['order']."'");
			}
		} elseif ($r['TABLE_NAME']=="patient") {
			//oldHospNo = 000725 / newHospNo = 000721
			//oldPID    = 133    / newPID    = 97
			$db1 = new DB;
			$db1->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".$oldHospNo."'");
			for ($i1=0;$i1<$db1->num_rows();$i1++) {
				$r1 = $db1->fetch_assoc();
				$oldPID = $r1['patientID'];
				$db2 = new DB;
				$db2->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".$newHospNo."'");
				$r2 = $db2->fetch_assoc();
				if ($r2['patientID']!="") { $newPID = $r2['patientID']; } else { $newPID = $r1['patientID']; }
				$db1a = new DB;
				// 原V $db1a->query("UPDATE `vitalsigns` SET `PersonID`='".$newPID."' WHERE `PersonID`='".$r1['patientID']."'");
				// 新V START
				$db1a->query("UPDATE `vitalsign` SET `PatientID`='".$newPID."' WHERE `PatientID`='".$r1['patientID']."'");
				// 新V END
				$db1b = new DB;
				$db1b->query("UPDATE `iostatus` SET `PersonID`='".$newPID."' WHERE `PersonID`='".$r1['patientID']."'");
				$db1b = new DB;
				$db1b->query("UPDATE `labpatient` SET `patientID`='".$newPID."' WHERE `patientID`='".$r1['patientID']."'");
				$db1c = new DB;
				$db1c->query("SELECT `indate` FROM `closedcase` WHERE `patientID`='".$r1['patientID']."'");
				$r1c = $db1c->fetch_assoc();
				$indate = $r1c['indate'];
				//$db1d = new DB;
				//$db1d->query("DELETE FROM `closedcase` WHERE `patientID`='".$r1['patientID']."'");
				//$db1f = new DB;
				//$db1f->query("DELETE FROM `closedcase` WHERE `patientID`='".$newPID."'");
				if ($oldPID != $newPID) {
					$db1d = new DB;
					$db1d->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$newPID."'");
					if ($db1d->num_rows()>0) {
						$db1e = new DB;
						$db1e->query("DELETE FROM `closedcase` WHERE `patientID`='".$newPID."'");
					}
				}
			}
			if ($oldPID != $newPID) {
				$db3 = new DB;
				$db3->query("DELETE FROM `patient` WHERE `patientID`='".$newPID."'");
				$db3a = new DB;
				$db3a->query("UPDATE `patient` SET `patientID`='".$newPID."', `HospNo`='".$newHospNo."' WHERE `patientID`='".$oldPID."'");
			} else {
				$db3a = new DB;
				$db3a->query("UPDATE `patient` SET `patientID`='".$newPID."', `HospNo`='".$newHospNo."' WHERE `patientID`='".$oldPID."'");
			}
			if ($oldPID != $newPID) {
				$db3b = new DB;
				$db3b->query("DELETE FROM `inpatientinfo` WHERE `patientID`='".$newPID."'");
				$db3c = new DB;
				$db3c->query("UPDATE `inpatientinfo` SET `patientID`='".$newPID."' WHERE `patientID`='".$oldPID."'");
			} else {
				$db3c = new DB;
				$db3c->query("UPDATE `inpatientinfo` SET `patientID`='".$newPID."' WHERE `patientID`='".$oldPID."'");
			}
		}
	}
	if ($oldMedOrder>0) { echo '<script>alert(\'用藥紀錄有異動，請重新確認藥物名單！Drug Record been modified,please re-confirm the drug list\');</script>'; }
	echo '<script>alert(\'護字號變更完畢，請重新確認該長輩所有資料！Care ID# modify complete,please re-check all info of the subject\');</script>';
	echo '<script>window.location.href=\'index.php?func=patientlist\'</script>';
}
?>
</div>