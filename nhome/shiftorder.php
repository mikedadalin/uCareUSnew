<?php
session_start();
?>
<body>
<?php
include("class/DB.php");
include("class/function.php");
$EmpID = @$_GET['EmpID'];
$EmpGroup = @$_GET['EmpGroup'];
$GroupID = @$_GET['GroupID'];
$order = @$_GET['order'];
if (@$_GET['action']=="upper") {
	//向上upward
	$upID = $order-1;
} else {
	//向下downward
	$upID = $order+1;
}
$qupID = new DB;
$qupID->query("UPDATE `shift_member` SET `order`='9999' WHERE `EmpID`='".$EmpID."' AND `EmpGroup`='".$EmpGroup."'");

$updateitem = new DB;
$updateitem->query("UPDATE `shift_member` SET `order`='".$order."' WHERE `GroupID`='".$GroupID."' AND `order`='".$upID."'");

$recover = new DB;
$recover->query("UPDATE `shift_member` SET `order`='".$upID."' WHERE `GroupID`='".$GroupID."' AND `order`='9999'");

echo '<script>opener.location = \'index.php?mod=humanresource&func=formview&id=6&group='.$GroupID.'#tabs-4\'; opener.location.reload(); self.close(); </script>';
?>
</body>
</html>