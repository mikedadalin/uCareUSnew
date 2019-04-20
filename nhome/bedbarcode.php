<img src="class\barcode.php?barcode=200001&width=230&height=80" border="1" style="margin-top:20px;" >
<?php
$db = new DB;
$db->query("SELECT `bed` FROM `inpatientinfo` ORDER BY `bed` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$pre = "";
	$bedID = $r['bed'];
	for ($j=strlen($r['bed']);$j<=5;$j++) {
		$pre .= "0";
	}
	$pre = $pre.$bedID;
	echo '<img src="class\barcode.php?barcode='.$pre.'&width=230&height=80" border="1" style="margin-top:20px;" >';
}
?>