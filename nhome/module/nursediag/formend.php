<?php
$db3 = new DB;
$db3->query("UPDATE `nursediag".@$_GET['id']."` SET `Q2`='".date("Y/m/d")."', `Qrater_end`='".$_SESSION['ncareID_lwj']."' WHERE `HospNo`='".getHospNo($_GET['pid'])."' AND `date`='".mysql_escape_string($_GET['date'])."'");
?>
<script>window.location.href='index.php?mod=nursediag&func=formview&pid=<?php echo $_GET['pid']; ?>&id=0';</script>