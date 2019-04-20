<?php
include("DB.php");
include("array.php");
include("function.php");
$db4 = new DB;
$db4->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `Qstartdate`<='".date('Y/m/d')."' AND (`Qenddate`>='".date('Y/m/d')."' OR `Qenddate`='')");
for ($j=0;$j<$db4->num_rows();$j++) {
	$r4 = $db4->fetch_assoc();
	$Qnursedescript3 .= ($j+1).'. '.$r4['Qmedicine'].' ('.$r4['Qdose'].$r4['Qdoseq'].') '.$r4['Qusage'].' ' .$r4['Qway'].' '.$r4['Qfreq']."\n";
}
echo $Qnursedescript3;