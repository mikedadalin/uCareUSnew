<?php
$db = new DB;
$db->query("DELETE FROM `monthlyfee` WHERE `HospNo`='".getHospNo(@$_GET['pid'])."' AND `date`='".mysql_escape_string($_GET['date'])."' AND `feeID`='".mysql_escape_string($_GET['feeID'])."'");
echo '<script>alert(\'Delete completed\'); window.location.href=\'index.php?func=editmonthlyfee&pid='.@$_GET['pid'].'\'</script>'."\n";
?>