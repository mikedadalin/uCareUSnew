<table style="width:100px;"><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=consump&func=formview&id=3" style="font-size:14px;">Back to List</a></td></tr></table>
<h3>物品進貨單 (總務用)</h3>
<?php

if (@$_GET['action']=="save") {
	$date = str_replace("/","",$_POST['date']);
	foreach ($_POST as $k=>$v) {
		if (substr($k,0,4)=="item") {
			$itemarr = explode("_",$k);
			$itemID = $itemarr[1];
			if ($v!=0) {
				$db = new DB;
				$db->query("INSERT INTO `consumpform01` VALUES ('".$itemID."', '".$date."', '".$v."', '".$_SESSION['ncareID_lwj']."')");
			}
		}
	}
}

$arrVar = array();
$db = new DB;
$db->query("SELECT * FROM `consump_pricing` WHERE `cate`='0' ORDER BY `itemID` ASC");
for ($i=1;$i<=$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$arrVar[$i] = $r['itemID'];
}
$rowno = ceil(count($arrVar)/2);
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?mod=consump&func=formview&id=1&action=save">
<table width="100%">
  <tr>
    <td class="title" width="29%">耗材名稱</td>
    <td class="title" width="10%">Quantity</td>
    <td class="title" width="2%" rowspan="<?php echo ($rowno+1); ?>">&nbsp;</td>
    <td class="title" width="29%">耗材名稱</td>
    <td class="title" width="10%">Quantity</td>
  </tr>
<?php
$no1 = 1;
$no2 = 2;
for ($i=1;$i<=$rowno;$i++) {
	$db1 = new DB;
	$db1->query("SELECT * FROM `consump_pricing` WHERE `itemID`='".$arrVar[$no1]."'");
	if (@$_GET['date']!=NULL) {
		$db1a = new DB;
		$db1a->query("SELECT `quantity` FROM `consumpform01` WHERE `itemID`='".$arrVar[$no1]."' AND `date`='".mysql_escape_string($_GET['date'])."'");
		$r1a = $db1a->fetch_assoc();
	}
	$item1quan = $r1a['quantity']+0;
	$msg1 = "";
	$msg1a = "";
	$msg1b = "";
	if ($db1->num_rows()>0) {
		$r1 = $db1->fetch_assoc();
		if ($r1['itemSpec']!=NULL) { $msg1a = $r1['itemName'].' ('.$r1['itemSpec'].')'; } else { $msg1a = $r1['itemName']; }
		$msg1b = '<input type="text" name="item_'.$r1['itemID'].'" id="item_'.$r1['itemID'].'" size="2" value="'.$item1quan.'"> '.$r1['itemUnit'];
	}
	$db2 = new DB;
	$db2->query("SELECT * FROM `consump_pricing` WHERE `itemID`='".$arrVar[$no2]."'");
	if (@$_GET['date']!=NULL) {
		$db2a = new DB;
		$db2a->query("SELECT `quantity` FROM `consumpform01` WHERE `itemID`='".$arrVar[$no2]."' AND `date`='".mysql_escape_string($_GET['date'])."'");
		$r2a = $db2a->fetch_assoc();
	}
	$item2quan = $r2a['quantity']+0;
	$msg2 = "";
	$msg2a = "";
	$msg2b = "";
	if ($db2->num_rows()>0) {
		$r2 = $db2->fetch_assoc();
		if ($r2['itemSpec']!=NULL) { $msg2a = $r2['itemName'].' ('.$r2['itemSpec'].')'; } else { $msg2a = $r2['itemName']; }
		$msg2b = '<input type="text" name="item_'.$r2['itemID'].'" id="item_'.$r2['itemID'].'" size="2" value="'.$item2quan.'"> '.$r2['itemUnit'];
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
<table width="100%">
  <tr>
    <td align="left">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>