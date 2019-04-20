<?php
$HospNo = mysql_escape_string($_POST['HospNo']);
$Qintake_1 = mysql_escape_string($_POST['Qintake_1']);
$Qintake_2 = mysql_escape_string($_POST['Qintake_2']);
$db = new DB;
$db->query("SELECT * FROM `medintake` WHERE `HospNo`='".$HospNo."';");
if ($db->num_rows()==0) {
	$db0 = new DB;
	$db0->query("INSERT INTO `medintake` (`HospNo`) VALUES ('".$HospNo."');");
}
$db1 = new DB;
$db1->query("UPDATE `medintake` SET `Qintake_1`='".$Qintake_1."', `Qintake_2`='".$Qintake_2."' WHERE `HospNo`='".$HospNo."'");
if($_GET['round']=="3"){ ?>
<script>window.location.href='index.php?func=NurseRounds&pid=<?php echo getPID($HospNo); ?>';</script>
<?php }else{ ?>
<script>window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo getPID($HospNo); ?>&id=17';</script>
<?php } ?>
