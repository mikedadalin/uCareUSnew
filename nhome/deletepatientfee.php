<?php
$db = new DB;
$db->query("DELETE FROM `staticfee` WHERE `HospNo`='".getHospNo(@$_GET['pid'])."' AND `feeID`='".mysql_escape_string($_GET['feeID'])."'");
echo '<script>alert(\'Delete completed\'); window.location.href=\'index.php?func=editpatientfee&pid='.@$_GET['pid'].'\'</script>'."\n";
?>