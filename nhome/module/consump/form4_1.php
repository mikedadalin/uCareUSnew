<table style="width:100px;"><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=consump&func=formview&id=3" style="font-size:14px;">Back to List</a></td></tr></table>
<h3>護理耗材庫存統計</h3>
<?php
$arrVar = array();
$db = new DB;
$db->query("SELECT * FROM `consump_pricing` ORDER BY `itemID` ASC");
for ($i=1;$i<=$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$arrVar[$i] = $r['itemID'];
}
$rowno = ceil(count($arrVar)/2);
?>
<table width="100%">
  <tr>
    <td class="title" width="19%">耗材名稱</td>
    <td class="title" width="10%">總務庫存</td>
    <td class="title" width="10%">護理部庫存</td>
    <td class="title" width="10%">已使用</td>
    <td class="title" width="1%" rowspan="<?php echo ($rowno+1); ?>">&nbsp;</td>
    <td class="title" width="19%">耗材名稱</td>
    <td class="title" width="10%">總務庫存</td>
    <td class="title" width="10%">護理部庫存</td>
    <td class="title" width="10%">已使用</td>
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
		if ($r1['itemSpec']!=NULL) { $msg1a = $r1['itemName'].' ('.$r1['itemSpec'].')'; } else { $msg1a = $r1['itemName']; }
		$db_pat_used1 = new DB;
		$db_pat_used1->query("SELECT SUM(`quantity`) FROM `consumpform03_1` WHERE `itemID`='".$arrVar[$no1]."'");
		$r_pat_used1 = $db_pat_used1->fetch_assoc();
		$usedquantity1 = $r_pat_used1['SUM(`quantity`)'];
		if ($usedquantity1=='') { $usedquantity1 = "0"; }
		$db_inall1 = new DB;
		$db_inall1->query("SELECT SUM(`quantity`) FROM `consumpform01` WHERE `itemID`='".$arrVar[$no1]."' GROUP BY `itemID`");
		$r_inall1 = $db_inall1->fetch_assoc();
		$inall1 = $r_inall1['SUM(`quantity`)'];
		if ($inall1=='') { $inall1 = "0"; }
		$db_innurse1 = new DB;
		$db_innurse1->query("SELECT SUM(`quantity`) FROM `consumpform02` WHERE `itemID`='".$arrVar[$no1]."' GROUP BY `itemID`");
		$r_innurse1 = $db_innurse1->fetch_assoc();
		$innurse1 = $r_innurse1['SUM(`quantity`)'];
		if ($innurse1=='') { $innurse1 = "0"; }
	}
	$db2 = new DB;
	$db2->query("SELECT * FROM `consump_pricing` WHERE `itemID`='".$arrVar[$no2]."'");
	$msg2 = "";
	$msg2a = "";
	$msg2b = "";
	if ($db2->num_rows()>0) {
		$r2 = $db2->fetch_assoc();
		if ($r2['itemSpec']!=NULL) { $msg2a = $r2['itemName'].' ('.$r2['itemSpec'].')'; } else { $msg2a = $r2['itemName']; }
		$db_pat_used2 = new DB;
		$db_pat_used2->query("SELECT SUM(`quantity`) FROM `consumpform03_1` WHERE `itemID`='".$arrVar[$no2]."'");
		$r_pat_used2 = $db_pat_used2->fetch_assoc();
		$usedquantity2 = $r_pat_used2['SUM(`quantity`)'];
		if ($usedquantity2=='') { $usedquantity2 = "0"; }
		$db_inall2 = new DB;
		$db_inall2->query("SELECT SUM(`quantity`) FROM `consumpform01` WHERE `itemID`='".$arrVar[$no2]."' GROUP BY `itemID`");
		$r_inall2 = $db_inall2->fetch_assoc();
		$inall2 = $r_inall2['SUM(`quantity`)'];
		if ($inall2=='') { $inall2 = "0"; }
		$db_innurse2 = new DB;
		$db_innurse2->query("SELECT SUM(`quantity`) FROM `consumpform02` WHERE `itemID`='".$arrVar[$no2]."' GROUP BY `itemID`");
		$r_innurse2 = $db_innurse2->fetch_assoc();
		$innurse2 = $r_innurse2['SUM(`quantity`)'];
		if ($innurse2=='') { $innurse2 = "0"; }
	}
	echo '
	<tr>
	  <td>'.$msg1a.'</td>
	  <td>'.($inall1-$innurse1).'</td>
	  <td>'.($innurse1-$usedquantity1).'</td>
	  <td>'.$usedquantity1.'</td>
	  <td>'.$msg2a.'</td>
	  <td>'.($inall2-$innurse2).'</td>
	  <td>'.($innurse2-$usedquantity2).'</td>
	  <td>'.$usedquantity2.'</td>
	</tr>
	'."\n";
	$no1+=2;
	$no2+=2;
}
?>
</table>