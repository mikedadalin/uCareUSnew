<?php

$qdate = $_POST['month'];
unset($_POST['month']);

$tablename = $_POST['tbname'];
unset($_POST['tbname']);

if (isset($_POST['resetstat'])) {
	
	unset($_POST['resetstat']);
	$db1 = new DB;
	$db1->query("DELETE FROM `sixtarget_".$tablename."_stat` WHERE `month`='".$qdate."'");
	$reset = 1;
	
	foreach ($_POST as $k=>$v) {
		$arrVarname = explode("_",$k);
	}
	
} else {

	$db1 = new DB;
	$db1->query("SELECT * FROM `sixtarget_".$tablename."_stat` WHERE `month`='".$qdate."'");
	if ($db1->num_rows()==0) {
		//新增資料add data
		$db1a = new DB;
		$db1a->query("INSERT INTO `sixtarget_".$tablename."_stat` (`month`, `savedate`, `Qfiller`) VALUES ('".$qdate."', '".date(Ymd)."', '".$_SESSION['ncareID_lwj']."')");
	} else {
		//更新修改日期與人員資料update modify date and staff info
		$db1a = new DB;
		$db1a->query("UPDATE `sixtarget_".$tablename."_stat` SET `savedate`='".date(Ymd)."', `Qfiller`='".$_SESSION['ncareID_lwj']."' WHERE `month`='".$qdate."'");
	}
	
	foreach ($_POST as $k=>$v) {
		$arrVarname = explode("_",$k);
		$Variable = $arrVarname[2];
		$Value = $v;
		$db2 = new DB;
		$db2->query("UPDATE `sixtarget_".$tablename."_stat` SET `".$Variable."`='".$Value."' WHERE `month`='".$qdate."'");
	}
	
}

$returnpage = str_replace("stat","",$arrVarname[1]);
echo "<script>window.location.href='index.php?mod=management&func=formview&id=3&view=".$returnpage."&part=2&qdate=".$qdate."&reset=".$reset."'</script>";

?>