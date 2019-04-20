<?php
$link = explode("nhome/",$_SERVER['REQUEST_URI']);
$urlPID = 'pid='.$_GET['pid'];
$urlNID = 'nID='.$_GET['nID'];
$urlSCHEDULEID = 'scheduleID='.$_GET['scheduleID'];
$link = str_replace($urlPID,'pid={PID}',$link[1]);
$link = str_replace($urlNID,'nID={NID}',$link);
$link = str_replace($urlSCHEDULEID,'scheduleID={SCHEDULEID}',$link);

$dbserNo = new DB2;
$dbserNo->query("SELECT `serNo` FROM `user_permission` WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `level`='1'");
for($i=0;$i<$dbserNo->num_rows();$i++){
	$rserNo = $dbserNo->fetch_assoc();
	$allow_serNo .= $rserNo['serNo'].";";
}

$dbPermissionSet = new DB2;
$dbPermissionSet->query("SELECT `PermissionSet` FROM `permissionset` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `Group`='".$_SESSION['ncareGroup_lwj']."'");
$rPermissionSet = $dbPermissionSet->fetch_assoc();
$allow_PermissionSet = $rPermissionSet['PermissionSet'];
	
$db777 = new DB2;
$db777->query("SELECT `serNo` FROM `permission_item` WHERE `link`='".$link."'");
if($db777->num_rows()>0){
	$r777 = $db777->fetch_assoc();
	$Array_serNo = explode(";",$allow_serNo);
	if(!in_array($r777['serNo'],$Array_serNo)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}

if($_GET['mod']=="dailywork"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("2",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['mod']=="inputoutput"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("3",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['mod']=="consump"){
	if($_GET['func']=="formlist"){
		$Array_PermissionSet = explode(";",$allow_PermissionSet);
		if(!in_array("8",$Array_PermissionSet)){
			echo "<script type='text/javascript'>";
			echo 'window.location.href="index.php?func=home"';
			echo "</script>";
		}
	}
}elseif($_GET['mod']=="humanresource"){
	if ($_GET['id']==NULL){
		$Array_PermissionSet = explode(";",$allow_PermissionSet);
		if(!in_array("9",$Array_PermissionSet)){
			echo "<script type='text/javascript'>";
			echo 'window.location.href="index.php?func=home"';
			echo "</script>";
		}
	}
}elseif($_GET['mod']=="management"){
	if ($_GET['id']==NULL){
		$Array_PermissionSet = explode(";",$allow_PermissionSet);
		if(!in_array("10",$Array_PermissionSet)){
			echo "<script type='text/javascript'>";
			echo 'window.location.href="index.php?func=home"';
			echo "</script>";
		}
	}elseif($_GET['id']=="3"){
		$Array_PermissionSet = explode(";",$allow_PermissionSet);
		if(!in_array("11",$Array_PermissionSet)){
			echo "<script type='text/javascript'>";
			echo 'window.location.href="index.php?func=home"';
			echo "</script>";
		}
	}else{}
}elseif($_GET['func']=="careworklist"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("12",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['func']=="medlist"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("7",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['func']=="NurseRounds"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("1",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['func']=="nutritionlist"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("6",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['func']=="patientlist"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("1",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['func']=="rehabilitationlist"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("5",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}elseif($_GET['func']=="sociallist"){
	$Array_PermissionSet = explode(";",$allow_PermissionSet);
	if(!in_array("4",$Array_PermissionSet)){
		echo "<script type='text/javascript'>";
		echo 'window.location.href="index.php?func=home"';
		echo "</script>";
	}
}else{}
?>