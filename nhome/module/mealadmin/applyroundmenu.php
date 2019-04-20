<?php
$month = @$_GET['month'];
$year = @$_GET['year'];
$week = @$_GET['week'];
if (strlen($month)==1) { $month = '0'.$month; }
$weeks = weekcount($year.$month.monthlastday($month,$year));
$monthdays = date(t,strtotime($year.'-'.$month.'-01'));

$arrDayinfo = array();

for ($i=1;$i<=$monthdays;$i++) {
	$wday = date(w,strtotime($year.'-'.$month.'-'.$i));
	if (strlen($i)==1) { $day = '0'.$i; } else { $day = $i; }
	$weekno = weekcount($year.$month.$day);
	$arrDayinfo[$weekno][$wday] = $day;
}
for ($j=0;$j<=6;$j++) {
	$dateno = $arrDayinfo[$week][$j];
	if ($dateno == NULL || $dateno == 0 || $dateno == '') {
		//
	} else {
		$date = $year.$month.$dateno;
		$db = new DB;
		$db->query("SELECT * FROM `roundmenu` WHERE `setID`='".mysql_escape_string($_GET['mealID'])."' AND `day`='".$arrDay[$j]."'");
		$r = $db->fetch_assoc(); //菜色資料
		$db2 = new DB;
		$db2->query("SELECT * FROM `foodmenu` WHERE `date`='".$date."'");
		if ($db2->num_rows()==0) {
			$db2a = new DB;
			$db2a->query("INSERT INTO `foodmenu` VALUES ('".$date."', '".$r['meal1']."', '".$r['meal2']."', '".$r['meal3']."', '".$r['meal4']."', '".$r['meal5']."', '".$r['meal6']."', '', '', '".$_SESSION['ncareID_lwj']."')");
		} else {
			$db2b = new DB;
			$db2b->query("UPDATE `foodmenu` SET `meal1`='".$r['meal1']."', `meal2`='".$r['meal2']."',`meal3`='".$r['meal3']."',`meal4`='".$r['meal4']."',`meal5`='".$r['meal5']."',`meal6`='".$r['meal6']."', `exchanger`='".$_SESSION['ncareID_lwj']."' WHERE `date`='".$date."'");
		}
	}
}
echo '<script>alert(\'已經成功套用循環菜單\'); window.location.href=\'index.php?mod=mealadmin&func=foodmenu\'</script>'."\n";
?>