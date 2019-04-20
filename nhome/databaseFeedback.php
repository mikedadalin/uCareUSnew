<?php
if($_POST['formID']=="feedback_resident"){
	$formID = mysql_escape_string($_POST['formID']);
	$nID = mysql_escape_string($_POST['nID']);
	$Subject = mysql_escape_string($_POST['Subject']);
	$Content = mysql_escape_string($_POST['Content']);
	$Responses = mysql_escape_string($_POST['Responses']);
	$action = mysql_escape_string($_POST['action']);
	if ($action == "new") {
		//新增資料
		$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
		$db = new DB;
		$db->query("INSERT INTO `".$formID."` (`nID`, `HospNo`, `date`, `Subject`, `Content`, `Responses`, `ResponsesStatus`, `Status`, `Qfiller`) VALUES ('', '".$HospNo."', '".date(Ymd)."', '".$Subject."', '".$Content."', '', '0', '1', '".$_SESSION['ncareID_lwj']."')");
	}elseif($action == "view"){
		//回應
		$db = new DB;
		$db->query("UPDATE `".$formID."` SET `Responses`='".$Responses."', `ResponsesStatus`='1' WHERE `nID`='".$nID."'");
	}
}else{
	$formID = mysql_escape_string($_POST['formID']);
	$nID = mysql_escape_string($_POST['nID']);
	$Name = mysql_escape_string($_POST['Name']);
	$Subject = mysql_escape_string($_POST['Subject']);
	$URL = mysql_escape_string($_POST['URL']);
	$Content = mysql_escape_string($_POST['Content']);
	$Responses = mysql_escape_string($_POST['Responses']);
	$action = mysql_escape_string($_POST['action']);
	if ($action == "new") {
		//新增資料
		$db = new DB;
		$db->query("INSERT INTO `".$formID."` (`nID`, `date`, `Name`, `Subject`, `URL`, `Content`, `Responses`, `ResponsesStatus`, `Status`, `Qfiller`) VALUES ('', '".date(Ymd)."', '".$Name."', '".$Subject."', '".$URL."', '".$Content."', '', '0', '1', '".$_SESSION['ncareID_lwj']."')");
	}elseif($action == "view"){
		//回應
		$db = new DB;
		$db->query("UPDATE `".$formID."` SET `Responses`='".$Responses."', `ResponsesStatus`='1' WHERE `nID`='".$nID."'");
	}
}

echo '<script>window.location.href=\'index.php?func=Feedbacklist\';</script>';	
?>