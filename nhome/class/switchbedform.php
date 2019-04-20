<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$patientID = getPID($HospNo);
$bedID = strtoupper($_POST['NewBed']);
$areaID = $_POST['BedArea'];

//先找新床位的原本住民
$db0 = new DB;
$db0->query("SELECT b.`patientID` FROM  `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$areaID."' AND a.`bedID`='".$bedID."'");
$r0 = $db0->fetch_assoc();
$newBedPID = $r0['patientID'];
//echo "SELECT b.`patientID` FROM  `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$areaID."' AND a.`bedID`='".$bedID."';".$newBedPID.';';

//暫時的床號
$tmpBedID = date(mdHis);
//echo $tmpBedID.';';

//把新床位的住民移至暫時床號
$db1 = new DB;
$db1->query("UPDATE `inpatientinfo` SET `bed`='".$tmpBedID."' WHERE `patientID`='".$newBedPID."'");
//echo "UPDATE `inpatientinfo` SET `bedID`='".$tmpBedID."' WHERE `patientID`='".$newBedPID."';";

//找出要移至新床位的住民原本床位及樓層
$oldBedID = getBedID($patientID);
$oldBedArea = getPatientArea($patientID);
//echo $oldBedID.';';

//把user選擇的住民移到新床位
$db2 = new DB;
$db2->query("UPDATE `inpatientinfo` SET `bed`='".$bedID."' WHERE `patientID`='".$patientID."'");
//echo "UPDATE `inpatientinfo` SET `bedID`='".$bedID."' WHERE `patientID`='".$patientID."';";

//把暫時床位的住民移到空出來的床位
$db3 = new DB;
$db3->query("UPDATE `inpatientinfo` SET `bed`='".$oldBedID."' WHERE `patientID`='".$newBedPID."' AND `bed`='".$tmpBedID."'");
//echo "UPDATE `inpatientinfo` SET `bedID`='".$oldBedID."' WHERE `patientID`='".$newBedPID."' AND `bedID`='".$tmpBedID."';";

echo "OK";
?>