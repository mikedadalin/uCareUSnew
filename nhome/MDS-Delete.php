<?php
$HospNo = getHospNo(mysql_escape_string($_GET['pid']));
$db4 = new DB;
$db4->query("SELECT `no` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'");
$r4 = $db4->fetch_assoc();
for($i=1;$i<44;$i++){
  if (strlen((int)$i)==1) {
    $formID = '0'.$i;
  }else{
    $formID = $i;
  }
  $tablename= 'mdsform'.$formID;
  $db2 = new DB;
  $db2->query("DELETE FROM `".$tablename."` WHERE `no`='".$r4['no']."'");
}
  $db3 = new DB;
  $db3->query("DELETE FROM `mdsform99` WHERE `no`='".$r4['no']."'");
?>
<?php
  $db = new DB;
  $db->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
  if($db->num_rows()>0){
    $r = $db->fetch_assoc();
    $r['date'] = str_replace('-','',$r['date']);
	?>
	<script>
	alert("Successfully deleted data.\n( MDS: <?php echo formatdate_Ymd_Slash($_GET['date']);?> )")
	document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=99&date=<?php echo $r['date']; ?>";
	</script>
	<?php
  }else{
	?>
	<script>
	alert("Successfully deleted data.\n( MDS: <?php echo formatdate_Ymd_Slash($_GET['date']);?> )")
	document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=99";
	</script>
	<?php
  }
?>