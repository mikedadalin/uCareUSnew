<?php
$formID = mysql_escape_string($_POST['formID']);
$EmpID =(int) mysql_escape_string($_POST['EmpID']);
$EmpGroup = mysql_escape_string($_POST['EmpGroup']);

$db = new DB;
if($EmpGroup ==1){
	$strSQL = "SELECT * FROM `employer` WHERE `EmpID`='".$EmpID."'";
}else{
	$strSQL = "SELECT * FROM `foreignemployer` WHERE `foreignID`='".$EmpID."'";
}
$db->query($strSQL);
$r = $db->fetch_assoc();

if($EmpGroup ==1){
	$EmpID = $r['EmpID'];
}else{
	$EmpID = $r['foreignID'];
}

if (@$_GET['action']==NULL) {
	$output = 'CREATE TABLE `'.$formID.'` (`EmpID` varchar(12), `EmpGroup` varchar(12), `date` varchar(8), ';
	foreach ($_POST as $k=>$v) {
		if (substr($k,0,1)=="Q") { $output .= '`'.$k."` text, "; }
	}
	$output = substr($output,0,strlen($output)-2);
	$output .= ", `Qfiller` text) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = MYISAM;<br>ALTER TABLE  `".$formID."` ADD PRIMARY KEY (  `HospNo` ,  `date` ) ;<br>";
	echo $output;
	echo '<a onclick="window.history.go(-2)">BACK</a>';
} elseif (@$_GET['action']=="show") {
	foreach ($_POST as $k=>$v) {
		//個別表單資料
		if (substr($k,0,1)=="Q" || $k=="date") {
			if ($k=="date") { $v = str_replace('/','',$v); }
			echo "UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_POST['date'])."'<br>";
		}
	}
	echo '<a onclick="window.history.go(-2)">BACK</a>';
} elseif (@$_GET['action']=="save") {
	if ($_POST['date']==NULL) {
		$filldate = date(Ymd);
		$db1 = new DB;
		$db1->query("SELECT * FROM `".$formID."` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' ORDER BY `date` DESC LIMIT 0,1");
	} else {
		$filldate = str_replace('/','',$_POST['date']);
		$db1 = new DB;
		$db1->query("SELECT * FROM `".$formID."` WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `date`='".$filldate."'");
	}
	if ($db1->num_rows()==0) {
		//New record
		echo "New record";
		$db2a = new DB;
		$db2a->query("INSERT INTO `".$formID."` (`EmpID`, `EmpGroup`, `date`,`Qfiller`) VALUES ('".$EmpID."', '".$EmpGroup."', '".$filldate."','".$_SESSION['ncareID_lwj']."');");
		foreach ($_POST as $k=>$v) {
			if (substr($k,0,1)=="Q" || $k=="date") {
				if ($k=="date") { $v = str_replace('/','',$v); }
				//個別表單資料
				$db2b = new DB;
				$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `date`='".$filldate."'");
			} 
		}
	} else {
		$r1 = $db1->fetch_assoc();
		$daylastfill = calcperiod($r1['date'],$filldate);
		if ($arrFormFreq[$formID]==99 || $arrFormFreq[$formID] == -1 || $r1['date']==$filldate) {
			//更新原本紀錄 (無需定期更新資料)
			echo "Update original record (Do NOT need for regular updates)";
			if ($r1['Qfiller']!="" && $r1['Qfiller'] != $_SESSION['ncareID_lwj'] && $_SESSION['ncareLevel_lwj']<5) {
				echo '<script>alert("Insufficient permissions! Please notify the original input personnel to modify or select other dates to save as a new data!");history.go(-1);</script>';
			} else {
				foreach ($_POST as $k=>$v) {
					//個別表單資料
					if (substr($k,0,1)=="Q" || $k=="date") {
						if ($k=="date") { $v = str_replace('/','',$v); }
						$db2b = new DB;
						$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `date`='".$r1['date']."'");
					}
				}
			}
		} elseif ($daylastfill>=$arrFormFreq[$_POST['formID']]) {
			//比對過日期，新紀錄
			echo "比對過日期，新紀錄";
			$db2a = new DB;
			$db2a->query("INSERT INTO `".$formID."` (`EmpID`,, `EmpGroup`, `date`,`Qfiller`) VALUES ('".$EmpID."', '".$EmpGroup."', '".$filldate."','".$_SESSION['ncareID_lwj']."');");
			foreach ($_POST as $k=>$v) {
				//個別表單資料
				if (substr($k,0,1)=="Q" || $k=="date") {
					if ($k=="date") { $v = str_replace('/','',$v); }
					$db2b = new DB;
					$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `date`='".$filldate."'");
				}
			}
		} else {
			//更新原本紀錄
			echo "更新原本紀錄";
			if ($r1['Qfiller']!="" && $r1['Qfiller'] != $_SESSION['ncareID_lwj'] && $_SESSION['ncareLevel_lwj']<5) {
				echo '<script>alert("Insufficient permissions! Please notify the original input personnel to modify or select other dates to save as a new data!");history.go(-1);</script>';
			} else {
				foreach ($_POST as $k=>$v) {
					//個別表單資料
					if (substr($k,0,1)=="Q" || $k=="date") {
						if ($k=="date") { $v = str_replace('/','',$v); }
						$db2b = new DB;
						$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."' AND `date`='".$r1['date']."'");
					}
				}
			}
		}
	}
	echo "<script>history.go(-2)</script>";
} elseif (@$_GET['action']=="delete") {
	$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `EmpID`='".mysql_escape_string($_POST['EmpID'])."' and `EmpGroup`='".mysql_escape_string($_POST['EmpGroup'])."' AND `date`='".mysql_escape_string($_POST['date'])."'";
	$db3 = new DB;
	$db3->query($sql3);
	echo "<script>history.go(-2)</script>";
}
?>

