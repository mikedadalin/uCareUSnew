<?php
$dbShow = new DB;
$dbShow->query("SELECT `QA0050` FROM `mdsform01` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'");
if ($dbShow->num_rows()>0) {
	$rShow = $dbShow->fetch_assoc();
}
if($rShow['QA0050']!="3"){
echo '<table align="left"><tr><td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=28-Alter&date='.$_GET['date'].'\'" /></form></td></tr></table>';
include("form28.php");
echo '<p style="page-break-after:always"</p>';
}
?>