<?php
/*$db1 = new DB;
$db1->query("SELECT * FROM `nurseform13` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['no'])."'");
if ($db1->num_rows()==0) {
	$db2 = new DB;
	$db2->query("INSERT INTO `nurseform13` (`HospNo`, `date`, `no`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '');");
	$db1a = new DB;
	$db1a->query("SELECT LAST_INSERT_ID()");
	$r1a = $db1a->fetch_assoc();
	$theno = $r1a['LAST_INSERT_ID()'];
} else {
	$theno = $_POST['no'];
	$r1b = $db1->fetch_assoc();
}
foreach ($_POST as $k=>$v) {
	$k = str_replace("edit","",$k);
	$k = str_replace("view","",$k);
	$k = str_replace("new","",$k);
	if (substr($k,0,1)=="Q") {
		$db3 = new DB;
		$db3->query("UPDATE `nurseform13` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
	}
}
$db3 = new DB;
$db3->query("UPDATE `nurseform13` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");

echo '<script>history.go(-1);</script>';*/
$date = $_POST['date'];
switch ($_POST['act']) {
	case "Add record":
		$db2 = new DB;
		$db2->query("INSERT INTO `nurseform13` (`HospNo`, `date`, `no`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '');");
		$db1a = new DB;
		$db1a->query("SELECT LAST_INSERT_ID()");
		$r1a = $db1a->fetch_assoc();
		$theno = $r1a['LAST_INSERT_ID()'];
		$_POST['Qfiller'] = $_SESSION['ncareID_lwj'];
	break;
	case "完成編輯":
		$theno = $_POST['no'];
		$_POST['Qfiller'] = $_SESSION['ncareID_lwj'];
	break;
	case "另存新紀錄":
		$db2 = new DB;
		$db2->query("INSERT INTO `nurseform13` (`HospNo`, `date`, `no`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '');");
		$db1a = new DB;
		$db1a->query("SELECT LAST_INSERT_ID()");
		$r1a = $db1a->fetch_assoc();
		$theno = $r1a['LAST_INSERT_ID()'];
		$_POST['Qfiller'] = $_SESSION['ncareID_lwj'];
	break;
}
foreach ($_POST as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$db3 = new DB;
		$db3->query("UPDATE `nurseform13` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
	}
}
//print_r($_POST);
echo '<script>location.href="index.php?mod=nurseform&func=formview&pid='.getPID($_POST['HospNo']).'&id=13"</script>';
?>