<?php
$dbShow = new DB;
$dbShow->query("SELECT `QA0050` FROM `mdsform01` WHERE `HospNo`='".$HospNo."' AND `date`='".formatdate_Ymd_Dash(@$_GET['date'])."'");
if ($dbShow->num_rows()>0) {
	$rShow = $dbShow->fetch_assoc();
}
echo '<table align="left"><tr><td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=1-Alter&date='.$_GET['date'].'\'" /></form></td></tr></table>';
include("form1.php");
echo '<p style="page-break-after:always"</p>';
if($rShow['QA0050']!="3"){
echo '<table align="left"><tr><td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=2-Alter&date='.$_GET['date'].'\'" /></form></td></tr></table>';
include("form2.php");
echo '<p style="page-break-after:always"</p>';
echo '<table align="left"><tr><td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=3-Alter&date='.$_GET['date'].'\'" /></form></td></tr></table>';
include("form3.php");
echo '<p style="page-break-after:always"</p>';
echo '<table align="left"><tr><td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=4-Alter&date='.$_GET['date'].'\'" /></form></td></tr></table>';
include("form4.php");
echo '<p style="page-break-after:always"</p>';
echo '<table align="left"><tr><td><form><input type="button" value="Edit" onclick="location.href=\'index.php?mod=mdsform&func=formview&pid='.$_GET['pid'].'&id=5-Alter&date='.$_GET['date'].'\'" /></form></td></tr></table>';
include("form5.php");
echo '<p style="page-break-after:always"</p>';
}
?>