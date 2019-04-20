<?php
session_start();
include("DB2.php");

$ItemNo = $_POST['ItemNo'];

$sql = "SELECT * FROM `itemlist` WHERE `ItemNo`='".$ItemNo."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'";

$db = new DB2;
$db->query($sql);
$r = $db->fetch_assoc();

$result = $r['ItemName'].'||'.$r['ItemSpec'].'||'.$r['ItemLargeUnit'].'||'.$r['ItemLargeQty'].'||'.$r['ItemSmallUnit'].'||'.$r['ItemPrice'].'||'.$r['ItemBrand'];

echo $result;
?>