<?php
include("DB.php");
include("array.php");
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$time = $_POST['time'];
$Q2 = $_POST['Q2'];
$Qcontent = htmlspecialchars(strip_tags($_POST['Qcontent']), ENT_QUOTES);
$Qjiaoban = $_POST['Qjiaoban'];
$Qfiller = $_POST['Qfiller'];
$db0 = new DB;
$db0->query("SELECT * FROM `nurseform05` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `time`='".$time."' AND `Q2`='".$Q2."' AND `Qfiller`='".$Qfiller."'");
if ($db0->num_rows()==0) {
	if ($Qcontent!='') {
		$db = new DB;
		$db->query("INSERT INTO `nurseform05` VALUES ('".$HospNo."','".$date."','".$time."','".$Q2."','".$Qcontent."','".$Qjiaoban."','".$Qfiller."')");
	}
} else {
	$r0 = $db0->fetch_assoc();
	if ($r0['Qcontent']!=$Qcontent) {
		$db = new DB;
		$db->query("UPDATE `nurseform05` SET `Q2`='".$Q2."', `Qcontent`='".$Qcontent."' WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `time`='".$time."' AND `Q2`='".$Q2."' AND `Qfiller`='".$Qfiller."'");
	}
}
$Q2 = (int) $Q2;
echo $arrNursediag[$Q2];
?>