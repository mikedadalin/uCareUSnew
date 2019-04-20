<?php
include("DB.php");
include("function.php");
$date = mysql_escape_string(str_replace("/","",str_replace("-","",$_POST['date'])));
$dayBefore = calcdayafterday($date, -1);

//新入住人數
$dbstat2a = new DB;
$dbstat2a->query("SELECT * FROM `inpatientinfo` WHERE `indate`='".$date."'");
$dbstat2b = new DB;
$dbstat2b->query("SELECT * FROM `general_io` WHERE `indate`='".$date."'");
$NewpatientNo = $dbstat2a->num_rows() + $dbstat2b->num_rows();

//退住人數
$dbstat3 = new DB;
$dbstat3->query("SELECT * FROM `closedcase` WHERE `outdate`='".$date."'");
$OutpatientNo = $dbstat3->num_rows();

//目前在院人數
/*$dbstat1 = new DB;
$dbstat1->query("SELECT * FROM `dailypatientno` WHERE DATE_FORMAT(`date`, '%Y%m%d')='".(str_replace("/","",$dayBefore))."'");
if ($dbstat1->num_rows()==0) {
	$dbstat1 = new DB;
	$dbstat1->query("SELECT * FROM `inpatientinfo` WHERE `indate`<='".$date."'");
	$InpatientNo = $dbstat1->num_rows();
} else {
	$rstat1 = $dbstat1->fetch_assoc();
	$InpatientNo = $rstat1['no'] + $NewpatientNo - $OutpatientNo;
}*/
$dbstat1 = new DB;
$dbstat1->query("SELECT * FROM `inpatientinfo` WHERE `indate`<='".$date."'");
$InpatientNo = $dbstat1->num_rows();

//使用尿管人數
$countFoley = 0;
$dPeriod = str_replace("/","",calcdayafterday($date, -30));
$dbstat3 = new DB;
$dbstat3->query("SELECT * FROM `nurseform02k` WHERE (`Q1`='1' OR `Q1`='2') AND `date`>='".$dPeriod."' AND `date`<='".$date."'");
for ($i3=0;$i3<$dbstat3->num_rows();$i3++) {
	$r3 = $dbstat3->fetch_assoc();
	if (str_replace("/","",calcdayafterday($r3['date'],$r3['Q4']))>$date) {
		$countFoley++;
	}
}

//轉住院人數
$dbstat4 = new DB;
$dbstat4->query("SELECT * FROM `general_io` WHERE `outdate`='".$date."' AND `reason_4`='1'");
$HospPatient = $dbstat4->num_rows();

//返回機構人數
$dbstat5 = new DB;
$dbstat5->query("SELECT * FROM `general_io` WHERE `indate`='".$date."' AND `reason_4`='1'");
$BackPatient = $dbstat5->num_rows();

//死亡人數
$dbstat6 = new DB;
$dbstat6->query("SELECT * FROM `closedcase` WHERE `outdate`='".$date."' AND `reason`='4'");
$DeadPatient = $dbstat6->num_rows();

echo $date.':'.$NewpatientNo.':'.$InpatientNo.':'.$OutpatientNo.':'.$countFoley.':'.$HospPatient.':'.$BackPatient.':'.$DeadPatient.':'.$dayBefore;
?>