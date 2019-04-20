<?php
$db0 = new DB2;
$db0->query("UPDATE `userinfo` SET `OrgID`='".mysql_escape_string($_GET['newOID'])."' WHERE `userID`='".$_SESSION['ncareID_lwj']."'");
$db = new DB2;
$db->query("SELECT * FROM `userinfo` WHERE `userID`='".mysql_escape_string($_SESSION['ncareID_lwj'])."'");
$r = $db->fetch_assoc();
$db1 = new DB2;
$db1->query("SELECT `Name`, `ShortName`, `DBname`, `status`, `OrgType` FROM `orginfo` WHERE `OrgID`='".mysql_escape_string($_GET['newOID'])."'");
$r1 = $db1->fetch_assoc();
$db2= new DB2;
$db2->query("SELECT * FROM `system_setting` WHERE `OrgID`='".mysql_escape_string($_GET['newOID'])."'");
$r2 = $db2->fetch_assoc();

$_SESSION['ncareID_lwj'] = $r['userID'];
$_SESSION['nOrgID_lwj'] = $r['OrgID'];
$_SESSION['nOrgType_lwj'] = $r1['OrgType'];
$_SESSION['ncareName_lwj'] = $r['name'];
$_SESSION['ncarePos_lwj'] = $r['position'];
$_SESSION['ncareLevel_lwj'] = $r['level'];
$_SESSION['ncareGroup_lwj'] = $r['group'];
$_SESSION['ncareDBno_lwj'] = $r1['DBname'];
$_SESSION['nOrgName_lwj'] = $r1['Name'];
$_SESSION['nOrgSName_lwj'] = $r1['ShortName'];
$_SESSION['ncareOrgStatus_lwj'] = $r1['status']; //0:停用;1:正常;2:評鑑模式

$_SESSION['ncareContactPersonNo_lwj'] = $r2['ContactPersonNo'];
$_SESSION['ncareInsulinImage_lwj'] = $r2['InsulinImage'];
$_SESSION['ncareglucoseRecord_lwj'] = $r2['glucoseRecord'];
$_SESSION['ncaremedFormat_lwj'] = $r2['medFormat'];
$_SESSION['ncareReceiptFormat_lwj'] = $r2['receiptFormat'];
$_SESSION['ncarecSTKdate_lwj'] = $r2['cSTKdate'];

?>
<script>window.location.href='http://<?php echo urldecode($_GET['fURL']); ?>';</script>

