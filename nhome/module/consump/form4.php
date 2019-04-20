<table style="width:100px;"><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=consump&func=formview&id=3" style="font-size:14px;">Back to List</a></td></tr></table>
<h3>護理耗材計價表</h3>
<table border="0" style="width:100%">
	<tr>
		<td>
		<div style="float:left;"><form><input type="button" value="庫存情況" onclick="window.location.href='index.php?mod=consump&func=formview&id=4_1'"></form></div>
		<div style="float:right;"><form><input type="button" name="newitem" value="新增耗材"></form></div>
		</td>
	</tr>
</table>
<?php
$arrVar = array();
$db = new DB;
$db->query("SELECT * FROM `consump_pricing` WHERE `cate`='0' ORDER BY `itemID` ASC");
for ($i=1;$i<=$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$arrVar[$i] = $r['itemID'];
}
$rowno = ceil(count($arrVar)/2);
?>
<table style="width:100%;">
  <tr>
    <td class="title" width="29%">耗材名稱</td>
    <td class="title" width="10%">計價</td>
    <td class="title" width="2%" rowspan="<?php echo ($rowno+1); ?>">&nbsp;</td>
    <td class="title" width="29%">耗材名稱</td>
    <td class="title" width="10%">計價</td>
  </tr>
<?php
$no1 = 1;
$no2 = 2;
for ($i=1;$i<=$rowno;$i++) {
	$db1 = new DB;
	$db1->query("SELECT * FROM `consump_pricing` WHERE `itemID`='".$arrVar[$no1]."'");
	$msg1 = "";
	$msg1a = "";
	$msg1b = "";
	if ($db1->num_rows()>0) {
		$r1 = $db1->fetch_assoc();
		$msg1 = '<center><img src="Images/edit_icon.png" /></center>';
		if ($r1['itemSpec']!=NULL) { $msg1a = $r1['itemName'].' ('.$r1['itemSpec'].')'; } else { $msg1a = $r1['itemName']; }
		$msg1b = $r1['itemPrice'].'/'.$r1['itemUnit'];
	}
	$db2 = new DB;
	$db2->query("SELECT * FROM `consump_pricing` WHERE `itemID`='".$arrVar[$no2]."'");
	$msg2 = "";
	$msg2a = "";
	$msg2b = "";
	if ($db2->num_rows()>0) {
		$r2 = $db2->fetch_assoc();
		$msg2 = '<center><img src="Images/edit_icon.png" /></center>';
		if ($r2['itemSpec']!=NULL) { $msg2a = $r2['itemName'].' ('.$r2['itemSpec'].')'; } else { $msg2a = $r2['itemName']; }
		$msg2b = $r2['itemPrice'].'/'.$r2['itemUnit'];
	}
	echo '
	<tr>
	  <td>'.$msg1a.'</td>
	  <td>'.$msg1b.'</td>
	  <td>'.$msg2a.'</td>
	  <td>'.$msg2b.'</td>
	</tr>
	'."\n";
	$no1+=2;
	$no2+=2;
}
?>
</table>