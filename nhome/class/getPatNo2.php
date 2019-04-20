<?php
include("DB.php");
include("function.php");
$date = mysql_escape_string($_POST['date']);

$db1 = new DB;
$db1->query("SELECT * FROM `dailypatientno1` WHERE `date`='".$date."'");
$r1 = $db1->fetch_assoc();

//echo $date.':'.$NewpatientNo.':'.$InpatientNo.':'.$OutpatientNo.':'.$countFoley.':'.$HospPatient.':'.$BackPatient.':'.$DeadPatient.':'.$dayBefore;
echo $r1['newpat'].':'.$r1['outpat'].':'.$r1['foleypat'].':'.$r1['nofoleypat'].':'.$r1['hosppat'].':'.$r1['backpat'].':'.$r1['deadpat'].':'.$r1['no'].':'.$r1['Qfiller'];
?>