<?php
if($_GET['round']=="1" || $_GET['round']=="4"){
	$formID = mysql_escape_string($_POST['Round1formID']);
}elseif($_GET['round']=="2" || $_GET['round']=="5"){
	$formID = mysql_escape_string($_POST['Round2formID']);
}elseif($_GET['round']=="3" || $_GET['round']=="6"){
	$formID = mysql_escape_string($_POST['Round3formID']);
}else{
	$formID = mysql_escape_string($_POST['formID']);
}
$HospNo = mysql_escape_string($_POST['HospNo']);
$pID = getPID($HospNo);
$nID = mysql_escape_string($_POST['nID']);
$action = mysql_escape_string($_POST['action']);
if ($action == "new") {
	//Add new data
	$db1a = new DB;
	if($formID=="nurseform02n"){
		$db1a->query("INSERT INTO `".$formID."` (`nID`, `no`, `HospNo`, `Qfiller`) VALUES ('', '".mysql_escape_string($_POST['no'])."', '".$HospNo."', '".$_SESSION['ncareID_lwj']."')");
	}else{
		$db1a->query("INSERT INTO `".$formID."` (`nID`, `HospNo`, `Qfiller`) VALUES ('', '".$HospNo."', '".$_SESSION['ncareID_lwj']."')");
	}
	$db1b = new DB;
	$db1b->query("SELECT LAST_INSERT_ID();");
	$r1b = $db1b->fetch_assoc();
	$nID = $r1b['LAST_INSERT_ID()'];
	foreach ($_POST as $k=>$v) {
		//個別表單資料
		if (substr($k,0,1)=="Q" || $k=="date" || $k=="time" || $k=="dateRound1" || $k=="dateRound2" || $k=="timeRound2") {
			if ($k=="dateRound1" || $k=="dateRound2") { $k="date"; }
			if ($k=="timeRound2") { $k="time"; }
			if ($k=="date") { $v = str_replace('/','',$v); }
			if ($k=="date") { $v = str_replace('_','',$v); }
			if ($k=="Q2Round1" || $k=="Q2Round2") { $k = "Q2"; }
			if ($k=="Q1_round4") { $k = "Q1"; }
			$db1c = new DB;
			if($formID=="nurseform02n"){
				$db1c->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `no`='".mysql_escape_string($_POST['no'])."' AND `nID`='".$nID."'");
			}else{
				$db1c->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `nID`='".$nID."'");
			}
		}
	}
	
	if ($formID=="nurseform05") {
		if ($_POST['writeToNurseform24']==1) {
			$db1e = new DB;
			$db1e->query("INSERT INTO `nurseform24` (`nID`, `HospNo`, `date`, `Q1`, `Q2`, `Qfiller`) VALUES ('', '".$HospNo."', '".str_replace("/","",$_POST['date'])."', '".mysql_escape_string($_POST['writeForm24Type'])."', '".mysql_escape_string($_POST['Qcontent'])."', '".$_SESSION['ncareID_lwj']."' )");
		}
		if ($_POST['writeToNurseform24Round2']==1) {
			$db1e = new DB;
			$db1e->query("INSERT INTO `nurseform24` (`nID`, `HospNo`, `date`, `Q1`, `Q2`, `Qfiller`) VALUES ('', '".$HospNo."', '".str_replace("/","",$_POST['date'])."', '".mysql_escape_string($_POST['writeForm24TypeRound2'])."', '".mysql_escape_string($_POST['QcontentRound2'])."', '".$_SESSION['ncareID_lwj']."' )");
		}
	}
	
} elseif ($action == "edit") {
	//編輯資料
	foreach ($_POST as $k=>$v) {
		//個別表單資料
		if (substr($k,0,1)=="Q" || $k=="date" || $k=="time") {
			if ($k=="date") { $v = str_replace('/','',$v); }
			if ($k=="date") { $v = str_replace('_','',$v); }
			$db2a = new DB;
			$db2a->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `nID`='".$nID."'");
		}
	}
	
	if ($formID=="nurseform05") {
		if ($_POST['writeToNurseform24']==1) {
			$db1e = new DB;
			$db1e->query("INSERT INTO `nurseform24` (`nID`, `HospNo`, `date`, `Q1`, `Q2`, `Qfiller`) VALUES ('', '".$HospNo."', '".str_replace("/","",$_POST['date'])."', '".mysql_escape_string($_POST['writeForm24Type'])."', '".mysql_escape_string($_POST['Qcontent'])."', '".$_SESSION['ncareID_lwj']."' )");
		}
		if ($_POST['writeToNurseform24Round2']==1) {
			$db1e = new DB;
			$db1e->query("INSERT INTO `nurseform24` (`nID`, `HospNo`, `date`, `Q1`, `Q2`, `Qfiller`) VALUES ('', '".$HospNo."', '".str_replace("/","",$_POST['date'])."', '".mysql_escape_string($_POST['writeForm24TypeRound2'])."', '".mysql_escape_string($_POST['QcontentRound2'])."', '".$_SESSION['ncareID_lwj']."' )");
		}
	}
	
} elseif ($action == "delete") {
	//刪除資料
	$db3a = new DB;
	$db3a->query("DELETE FROM `".$formID."` WHERE `nID`='".$nID."'");
}
if ($_GET['url']!="") {
	echo "<script>location.replace('".urldecode($_GET['url'])."')</script>";
} elseif($formID=="nurseform02n"){
	echo '<script>window.location.href=\'index.php?mod=nurseform&func=formview&pid='.$pID.'&id=2n\';</script>';	
} elseif($_GET['round']=="1" || $_GET['round']=="2" || $_GET['round']=="3"){
	echo '<script>window.location.href=\'index.php?func=NurseRounds&pid='.$pID.'\';</script>';
} elseif($_GET['round']=="4" || $_GET['round']=="5" || $_GET['round']=="6"){
	echo '<script>window.location.href=\''.$_SESSION['preURL'].'\';</script>';
} else {
	echo "<script>history.go(-2)</script>";
}
?>