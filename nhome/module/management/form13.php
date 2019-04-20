<center>
	<div style="width:100%;">
		<h3>Permission settings</h3>
		<?php
		if (isset($_POST['submit'])) {
			array_pop($_POST);
			$db0a0 = new DB2;
			$db0a0->query("UPDATE `user_permission` SET `level`='0' WHERE `userID`='".mysql_escape_string($_GET['uID'])."'");
			foreach ($_POST as $k1=>$v1) {
				$serNo = str_replace('pserNo_','',$k1);
				$db0a = new DB2;
				$db0a->query("SELECT * FROM `user_permission` WHERE `userID`='".mysql_escape_string($_GET['uID'])."' AND `serNo`='".$serNo."'");
				if ($db0a->num_rows()>0) {
					$db0b = new DB2;
					$db0b->query("UPDATE `user_permission` SET `level`='".$v1."' WHERE `userID`='".mysql_escape_string($_GET['uID'])."' AND `serNo`='".$serNo."'");
				} else {
					$db0c = new DB2;
					$db0c->query("INSERT INTO `user_permission` VALUES ('".mysql_escape_string($_GET['uID'])."', '".$serNo."', '".$v1."')");
				}
			}
			echo '
			<script>
			$(function() {
				var $dialog = $(\'<div title="UCare message" class="dialog-form"><table width="100%"><tr><td class="title">Save successfully</td></tr></table></div>\').dialog({
					buttons: [{
						text: "Confirm",
						click: function(){ $dialog.remove(); }
					}]
				});
});
</script>';
}
$db1 = new DB2;
$db1->query("SELECT a.Name as `perName`, b.`name` as `subcateName`, c.`serNo`, c.icon, c.name as `itemname` FROM `permission2` a INNER JOIN `permission_subcate` b ON b.`cateID`=a.`PermissionID` INNER JOIN `permission_item` c ON c.`subcateID`=b.`subcateID` WHERE a.`orgType`='nhome'");
$arrItemList = array();
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$arrItemList[$r1['perName']][$r1['subcateName']][$r1['serNo']] = $r1['icon'].';'.$r1['itemname'];
}
$db1a = new DB2;
$db1a->query("SELECT * FROM `user_permission` WHERE `userID`='".mysql_escape_string($_GET['uID'])."'");
$arrPerList = array();
if ($db1a->num_rows()>0) {
	for ($i1a=0;$i1a<$db1a->num_rows();$i1a++) {
		$r1a = $db1a->fetch_assoc();
		$arrPerList[$r1a['serNo']] = $r1a['level'];
	}
} else {
	//還沒設定，預帶組別該有的權限
	$db1b1 = new DB2;
	$db1b1->query("SELECT * FROM `permissionset` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	$strDB = 'a.`OrgID`=b.`OrgID`';
	$db1b = new DB2;
	$db1b->query("SELECT b.`PermissionSet` FROM `userinfo` a INNER JOIN `permissionset` b ON a.`group`=b.`Group` AND ".$strDB." WHERE a.`userID`='".mysql_escape_string($_GET['uID'])."'");
	$r1b = $db1b->fetch_assoc();
	$arrPerSet = explode(';',$r1b['PermissionSet']);
	foreach ($arrPerSet as $k=>$v) {
		$db1c = new DB2;
		$db1c->query("SELECT a.Name as `perName`, b.`name` as `subcateName`, c.`serNo`, c.icon, c.name as `itemname` FROM `permission2` a INNER JOIN `permission_subcate` b ON b.`cateID`=a.`PermissionID` INNER JOIN `permission_item` c ON c.`subcateID`=b.`subcateID` WHERE a.`PermissionID`='".$v."' ORDER BY a.`order`, b.`subcateID`, c.`subcateID`");
		for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
			$r1c = $db1c->fetch_assoc();
			$arrPerList[$r1c['serNo']] = 1;
		}
	}
}
?>
<form><font style="font-weight:bolder;">Select account: </font><select name="userID" id="userID" onchange="window.location.href='index.php?mod=management&func=formview&id=13&uID='+$(this).val()">
	<option></option>
	<?php
	$db2 = new DB2;
	if($_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){
		$db2->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `active`='1'");
	}else{
		$db2->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `active`='1' AND `userID`!='Lejla05Mirzada12Asmira01'");
	}
	for ($i2=0;$i2<$db2->num_rows();$i2++) {
		$r2 = $db2->fetch_assoc();
		echo '<option value="'.$r2['userID'].'" '.($r2['userID']==$_GET['uID']?" selected":"").'>'.$r2['name'].'</option>'."\n";
	}
	?>
</select>
</form>
<?php if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08"  || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){?>
<br><form><a style="font-weight:bolder;">Select resident account: </a><select name="userID" id="userID" onchange="window.location.href='index.php?mod=management&func=formview&id=13&uID='+$(this).val()">
<option></option>
<?php
$db2 = new DB2;
$db2->query("SELECT * FROM `userinfo_resident` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' and `active`='1'");
for ($i2=0;$i2<$db2->num_rows();$i2++) {
	$r2 = $db2->fetch_assoc();
	$db3 = new DB;
	$db3->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".substr($r2['userID'],8,6)."'");
	$r3 = $db3->fetch_assoc();
	$Name = getPatientName($r3['patientID']);
	echo '<option value="'.$r2['userID'].'" '.($r2['userID']==$_GET['uID']?" selected":"").'>'.$Name.'</option>'."\n";
}
?>
</select>
</form>
<?php }?>
<?php if ($_GET['uID']!="") { ?>
<table width="100%">
	<tr>
		<td class="title" width="120">Account</td>
		<td>
			<?php
			if(substr($_GET['uID'],0,8)=="resident"){
				$HospNo = explode("resident",$_GET['uID']);
				echo getPatientName(getPID($HospNo[1])).' '.checkuserposition_resident($_GET['uID']);
			}else{
				echo checkusername($_GET['uID']).' '.checkuserposition($_GET['uID']);
			}
			?>
		</td>
	</tr>
</table>
<form method="post">
	<table width="100%">
		<?php
		foreach ($arrItemList as $k1=>$v1) {
			echo '
			<tr class="title">
			<td>'.$k1.'</td>
			</tr>
			<tr>
			<td>'."\n";
			foreach ($v1 as $k2=>$v2) {
				if ($k2!="") {
					$k2Array = explode(";",$k2);
					echo '<div style="width:100%; display:block;float:left; width:100%;"><h3>'.$k2Array[$_SESSION['LanguangNumber_lwj']]."</h3></div>\n";
				}
				foreach ($v2 as $k3=>$v3) {
					$arrItemIcon = explode(';',$v3);
					echo '<div style="float:left; width:24%; padding-right:2px; display:inline-block;"><input type="checkbox" name="pserNo_'.$k3.'" id="pserNo_'.$k3.'" value="1" '.($arrPerList[$k3]==1?"checked":"").'> <label for="pserNo_'.$k3.'"> <i class="fa fa-'.$arrItemIcon[0].'"></i> '.$arrItemIcon[1].'</label></div>';
				}
			}
			echo '
			</td>
			</tr>'."\n";
		}
		?>
		<tr>
			<td><center><input type="submit" name="submit" value="Save"></center></td>
		</tr>
	</table>
</form>
<?php } ?>
</div>
</center>
