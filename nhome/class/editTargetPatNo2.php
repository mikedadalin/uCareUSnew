<?php
include("DB.php");
include("function.php");
$db1 = new DB;
$db1->query("UPDATE `dailypatientno1` SET `newpat`='".mysql_escape_string($_POST['editNewpat'])."', `no`='".mysql_escape_string($_POST['editNo'])."', `outpat`='".mysql_escape_string($_POST['editOutpat'])."', `foleypat`='".mysql_escape_string($_POST['editFoleypat'])."', `nofoleypat`='".mysql_escape_string($_POST['editNoFoleypat'])."', `hosppat`='".mysql_escape_string($_POST['editHosppat'])."', `backpat`='".mysql_escape_string($_POST['editBackpat'])."', `deadpat`='".mysql_escape_string($_POST['editDeadpat'])."', `Qfiller`='".mysql_escape_string($_POST['Qfiller'])."' WHERE `date`='".mysql_escape_string($_POST['editDate'])."'");
?>