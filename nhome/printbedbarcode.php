<?php
if ($_SESSION['ncareID_lwj']==NULL) {
	$QR_URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$QR_URL = str_replace("&","_TWNo1_",$QR_URL);
	echo "<script>alert('Please log in again!'); window.location.href='logout.php?QR_URL=".$QR_URL."';</script>"; 
}
?>
<table border="1" style="border-collapse:collapse;" align="center">
	<tr>
      <td>儀器Instrument<br /><img src="class\barcode.php?barcode=200001&width=230&height=80" border="0" ></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?php
	$db = new DB;
	$db->query("SELECT `patientID`, `bed` FROM `inpatientinfo` ORDER BY `bed` ASC");
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$db1 = new DB;
		$db1->query("SELECT `Name` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r1 = $db1->fetch_assoc();
		$Name = $r1['Name'];
		if (strlen($Name)==12) {
			$Name = substr($Name,0,3).'○○'.substr($Name,strlen($Name)-3,3);
		} elseif (strlen($Name)==9) {
			$Name = substr($Name,0,3).'○'.substr($Name,strlen($Name)-3,3);
		} elseif (strlen($Name)==6) {
			$Name = substr($Name,0,3).'○';
		}
		$pre = "";
		$bedID = $r['bed'];
		for ($j=strlen($r['bed']);$j<=5;$j++) {
			$pre .= "0";
		}
		$pre = $pre.$bedID;
		if ($i%4==0) {
			echo '<tr>';
		}
		echo '<td>'.$Name.'<br /><img src="class\barcode.php?barcode='.$pre.'&width=230&height=80" border="0"></td>';
		if ($i%4==3) {
			echo '</tr>';
		}
	}
?>
</table>
