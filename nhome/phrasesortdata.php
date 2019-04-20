<?php
session_start();
?>
<body onUnload="opener.location.reload()">
<?php
include("class/DB.php");
$userID = $_SESSION['ncareID_lwj'];
$order = @$_GET['order'];
if (@$_GET['action']=="upper") {
	//向上upward
	$upID = $order-1;
} else {
	//向下downward
	$upID = $order+1;
}
$qupID = new DB;
$qupID->query("UPDATE `phrase` SET `order`='9999' WHERE `userID`='".$userID."' AND `order`='".$upID."'");
//echo "UPDATE `phrase` SET `order`='9999' WHERE `userID`='".$userID."' AND `order`='".$upID."'"; echo "<br>";
$updateitem = new DB;
$updateitem->query("UPDATE `phrase` SET `order`='".$upID."' WHERE `userID`='".$userID."' AND `order`='".$order."'");
//echo "UPDATE `phrase` SET `order`='".$upID."' WHERE `userID`='".$userID."' AND `order`='".$order."'"; echo "<br>";
$recover = new DB;
$recover->query("UPDATE `phrase` SET `order`='".$order."' WHERE `userID`='".$userID."' AND `order`='9999'");
//echo "UPDATE `phrase` SET `order`='".$order."' WHERE `userID`='".$userID."' AND `order`='9999'"; echo "<br>";

/*$checkall = new DB;
$checkall->query("SELECT `userID`, `order` FROM `phrase` WHERE `userID`='".$userID."' ORDER BY `order` ASC");
echo "SELECT `userID`, `order` FROM `phrase` WHERE `userID`='".$userID."' ORDER BY `order` ASC"; echo "<br>";
for ($i=1;$i<=$checkall->num_rows();$i++) {
	$olditem = $checkall->fetch_assoc();
	$newitem = new DB;
	$newitem->query("UPDATE `phrase` SET `order`='".$i."' WHERE `userID`='".$userID."' AND `order`='".$olditem['order']."'");
}*/
echo '<script> self.close() </script>';
?>
</body>
</html>