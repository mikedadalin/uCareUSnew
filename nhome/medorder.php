<?php
session_start();
?>
<body onUnload="">
<?php
include("class/DB.php");
include("class/function.php");
$HospNo = @$_GET['HospNo'];
$order = @$_GET['order'];
if (@$_GET['action']=="upper") {
	//向上upward
	$upID = $order-1;
} else {
	//向下downward
	$upID = $order+1;
}
$qupID = new DB;
$qupID->query("UPDATE `nurseform17` SET `order`='9999' WHERE `HospNo`='".$HospNo."' AND `order`='".$upID."'");
//echo "UPDATE `phrase` SET `order`='9999' WHERE `userID`='".$userID."' AND `order`='".$upID."'"; echo "<br>";
$updateitem = new DB;
$updateitem->query("UPDATE `nurseform17` SET `order`='".$upID."' WHERE `HospNo`='".$HospNo."' AND `order`='".$order."'");
//echo "UPDATE `phrase` SET `order`='".$upID."' WHERE `userID`='".$userID."' AND `order`='".$order."'"; echo "<br>";
$recover = new DB;
$recover->query("UPDATE `nurseform17` SET `order`='".$order."' WHERE `HospNo`='".$HospNo."' AND `order`='9999'");
//echo "UPDATE `phrase` SET `order`='".$order."' WHERE `userID`='".$userID."' AND `order`='9999'"; echo "<br>";

/*$checkall = new DB;
$checkall->query("SELECT `userID`, `order` FROM `phrase` WHERE `userID`='".$userID."' ORDER BY `order` ASC");
echo "SELECT `userID`, `order` FROM `phrase` WHERE `userID`='".$userID."' ORDER BY `order` ASC"; echo "<br>";
for ($i=1;$i<=$checkall->num_rows();$i++) {
	$olditem = $checkall->fetch_assoc();
	$newitem = new DB;
	$newitem->query("UPDATE `phrase` SET `order`='".$i."' WHERE `userID`='".$userID."' AND `order`='".$olditem['order']."'");
}*/
echo '<script>opener.location.href = \'index.php?mod=nurseform&func=formview&pid='.getPID($HospNo).'&id=17\'; self.close() </script>';
?>
</body>
</html>