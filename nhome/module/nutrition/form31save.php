<?php
$HospNo = $_POST['HospNo'];
$date = str_replace("/","",$_POST['date']);
$newtime = $_POST['newtime'];
$oldtime = $_POST['oldtime'];
$Q2 = $_POST['Q2'];
$Qcontent = $_POST['Qcontent'];
$Qfiller = $_POST['Qfiller'];
if ($newtime!=$oldtime) {
	$db = new DB;
	$db->query("INSERT INTO `socialform31` VALUES ('".$HospNo."', '".$date."', '".$newtime."', '".$Q2."', '".$Qcontent."', '".$Qfiller."')");
	$db1 = new DB;
	$db1->query("DELETE FROM `socialform31` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `time`='".$oldtime."'");	
} elseif ($newtime==$oldtime) {
	$db = new DB;
	$db->query("UPDATE `socialform31` SET `Qcontent`='".$Qcontent."' WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `time`='".$newtime."'");
}
echo '
<script>
window.location.href=\'index.php?mod=nutrition&func=formview&pid='.getPID($HospNo).'&id=31\';
</script>
';
?>