<?php
include("DB.php");

$table = mysql_escape_string($_POST['table']);
$autoID = mysql_escape_string($_POST['autoID']);
$stopcolID = mysql_escape_string($_POST['colID']);
$colID = mysql_escape_string($_POST['ID']);
$stopType = mysql_escape_string($_POST['type']); //1:Y;N ||| 2:1;0 ||| 3:1;2

$db0 = new DB;
$db0->query("SELECT `".$stopcolID."` FROM `".$table."` WHERE `".$autoID."`='".$colID."'");
$r0 = $db0->fetch_assoc();

$stopID = $r0[$stopcolID];

if ($table=="arkstock") {
	if ($stopID=="N") {
		$db1 = new DB;
		$db1->query("UPDATE `arkstockforapply` SET `STOP_ID`='1' WHERE `STK_NO`='".$colID."'");
	}
}

if ($stopType==1) {
	if ($stopID=="Y") { $cStopID = "N"; $img = "star_full"; } elseif ($stopID=="N") { $cStopID="Y"; $img = "star_empty"; }
} elseif ($stopType==2) {
	if ($stopID==1) { $cStopID = 0; $img = "star_full"; } elseif ($stopID==0) { $cStopID=1; $img = "star_empty"; }
} elseif ($stopType==4) {
	if ($stopID==1) { $cStopID = 0; $img = "star_empty"; } elseif ($stopID==0) { $cStopID=1; $img = "star_full"; }
} elseif ($stopType==3) {
	if ($stopID==1) { $cStopID = 2; $img = "star_empty"; } elseif ($stopID==2 || $stopID==0) { $cStopID=1; $img = "star_full"; }
}

$db = new DB;
$db->query("UPDATE `".$table."` SET `".$stopcolID."`='".$cStopID."' WHERE `".$autoID."`='".$colID."'");
//echo "UPDATE `".$table."` SET `".$stopcolID."`='".$cStopID."' WHERE `".$autoID."`='".$colID."'";
echo $img;
?>