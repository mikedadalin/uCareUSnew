<?php
if (isset($_POST['submit'])) {
	foreach ($_POST['HospNo'] as $k1=>$v1) {
		$patientlist .= $v1.';';
	}
	$patientlist = substr($patientlist,0,strlen($patientlist)-1);
	$db1 = new DB;
	$db1->query("UPDATE `opdinfo` SET `date`='".mysql_escape_string($_POST['date']).' '.$_POST['dateT'].":00', `department`='".mysql_escape_string($_POST['department'])."', `doctor`='".mysql_escape_string($_POST['doctor'])."', `patient`='".$patientlist."', `cUser`='".$_SESSION['ncareID_lwj']."', `cDate`='".date('Y-m-d H:i:s')."' WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."'");
	echo '<script>alert(\'已儲存名單！\');window.location.href=\'index.php?mod=management&func=formview&id=26\'</script>'."\n";
} elseif (isset($_POST['delete'])) {
	echo '
	<script>
	if (confirm(\'確認刪除資料？\')) {
		window.location.href=\'index.php?mod=management&func=formview&id=26c&action=delete&opdID='.$_GET['opdID'].'\';
	} else {
		window.location.href=\'index.php?mod=management&func=formview&id=26c&opdID='.$_GET['opdID'].'\';
	}
	</script>
	'."\n";
} elseif ($_GET['action']=="delete") {
	$db1 = new DB;
	$db1->query("DELETE FROM `opdinfo` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."'");
	$db2 = new DB;
	$db2->query("DELETE FROM `opddata` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."'");
	echo '<script>alert(\'已刪除資料！\');window.location.href=\'index.php?mod=management&func=formview&id=26\'</script>'."\n";
}
?>

<div>
	<form method="POST">
		<table class="content-query" style="text-align:left;">
			<tr>
				<td class="title" style="font-size:18px;">診間資訊</td>
			</tr>
			<tr>
				<td>
					<?php
					$db1 = new DB;
					$db1->query("SELECT *, DATE_FORMAT(`date`, '%Y-%m-%d') as `dateF`, DATE_FORMAT(`date`, '%H:%i') as `dateT` FROM `opdinfo` WHERE `opdID`='".mysql_real_escape_string(@$_GET['opdID'])."' ORDER BY `date` DESC");
					$r1 = $db1->fetch_assoc();
					$arrSelectedList = explode(';',$r1['patient']);
					$arrSelectedList = array_filter($arrSelectedList);
					?>
					<table class="nurseform-table">
						<tr>
							<td class="title" width="120">Date</td><td width="240">
							<script>
							$(function() {
								$('#date').datetimepicker({ format:'Y-m-d', timepicker: false });
							});
							</script>
							<input type="text" name="date" id="date" value="<?php echo $r1['dateF']; ?>" size="8">
							<input type="text" name="dateT" id="dateT" value="<?php echo $r1['dateT']; ?>" size="5"></td>
							<td class="title" width="120" style="padding:5px;">Visit Companion (Staff)</td><td><?php echo checkusername($r1['follower']); ?></td>
						</tr>
						<tr>
							<td class="title">Division</td>
							<td><input type="text" name="department" id="department" value="<?php echo $r1['department']; ?>" size="8"></td>
							<td class="title" style="padding:5px;">Physician</td>
							<td><input type="text" name="doctor" id="doctor" value="<?php echo $r1['doctor']; ?>" size="8"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="title" style="font-size:18px;">Select Resident(s)</td>
			</tr>
			<tr>
				<td style="padding:20px 5px 5px 5px;">
					<input type="button" name="all" onclick="checkall('HospNo[]')" value="Select all" /> <input type="button" name="all" onclick="uncheckall('HospNo[]')" value="全部取消" />
					<?php
					$arrHospNo = array();
					$db2a = new DB;
					$db2a->query("SELECT * FROM `areainfo`");
					for ($i2a=0;$i2a<$db2a->num_rows();$i2a++) {
						$r2a = $db2a->fetch_assoc();
						$arrHospNo[$r2a['areaName']] = array();
						$db2b = new DB;
						$db2b->query("SELECT a.`patientID` FROM `inpatientinfo` a, `bedinfo` b WHERE (a.`bed` = b.`bedID` AND b.`Area`='".$r2a['areaID']."') ORDER BY a.`bed` ASC");
						for ($i2b=0;$i2b<$db2b->num_rows();$i2b++) {
							$r2b = $db2b->fetch_assoc();
							$arrHospNo[$r2a['areaName']][$i2b] = $r2b['patientID'];
						}
					}
					foreach ($arrHospNo as $k1=>$v1) {
						if (count($arrHospNo[$k1])>0) {
							echo '<h3>'.$k1.'</h3>';
							$count1 = 0;
							foreach ($arrHospNo[$k1] as $k2=>$v2) {
								if ($count1>0 && $count1%5==0) { echo '<br>'; }
								echo '<div style="width:220px; display:inline-block;"><input type="checkbox" name="HospNo[]" value="'.getHospNo($v2).'" class="validate[minCheckbox[1]] checkbox" '.(in_array(getHospNo($v2),$arrSelectedList)?"checked":"").'>'.getHospNoDisplayByHospNo(getHospNo($v2)).' '.getPatientName($v2).' </div>';
								$count1++;
							}
						}
					}
					?>
				</td>
			</tr>
			<tr>
				<td class="title"><input type="submit" name="submit" value="Save" /> <input type="submit" name="delete" value="刪除本診資料" style="color:#f33548; border:1px solid #f33548;"/></td>
			</tr>
		</table>
	</form>
</div>

<script>
function checkall(cName) {
	var checkboxs = document.getElementsByName(cName);
	for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = true;}
}
function uncheckall(cName) { 
	var checkboxs = document.getElementsByName(cName); 
	for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = false;} 
}
</script>