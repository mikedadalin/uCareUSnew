<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<?php
$db2 = new DB;
$db2->query("SELECT `GroupID` FROM `shift_group` WHERE `GroupLeader`='".$_SESSION['ncareID_lwj']."' AND `GroupID`='".mysql_escape_string($_GET['group'])."'");
if ($db2->num_rows()==0) {
	if ($_SESSION['ncareID_lwj']!="Mor3Geneki6nge08" && $_SESSION['ncareID_lwj']!="Lejla05Mirzada12Asmira01") {
	echo '
	<script>
	alert(\'Insufficient permissions\');
	</script>
	'."\n";
	}
}
if (isset($_POST['saveshift'])) {
	foreach ($_POST as $k=>$v) {
		$area = "";
		$shift = "";
		if ($k!='saveshift') {
			$arrVariable = explode("_",$k);
			//employer_1_9_area_20140512
			$group = $arrVariable[1];
			if ($group==1) { $table = "employer"; $fieldname = "EmpID"; } elseif ($group==2) { $table = "foreignemployer"; $fieldname = "foreignID"; }
			$personID = $arrVariable[2];
			$date = $arrVariable[4];
			if ($arrVariable[3] == "area") { $area = mysql_escape_string($v); } elseif ($arrVariable[3] == "shift") { $shift = mysql_escape_string($v); }
			if ($area!="" || $shift!="") {
					$dbc = new DB;
					$dbc->query("SELECT * FROM `".$table."_shift` WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
					if ($dbc->num_rows()==0) {
						$dbn = new DB;
						$dbn->query("INSERT INTO `".$table."_shift` VALUES ('".$personID."', '".$date."', '', '');");
					}
			}
			if ($arrVariable[3] == "area") {
				if ($area!="" || $shift!="") {
					$dbu = new DB;
					$dbu->query("UPDATE `".$table."_shift` SET `area`='".$area."'  WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
				}
			} elseif ($arrVariable[3] == "shift") {
				$dbu = new DB;
				$dbu->query("UPDATE `".$table."_shift` SET `shift`='".$shift."'  WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
			}
		}
	}
}
?>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Shift scheduling</a></li>
    <li><a href="#tabs-2">Location setting of duty list</a></li>
  </ul>
  <div id="tabs-1">
<?php
if (@$_GET['date']==NULL) {
	$getdate = date("Y-m-d");
	$arrDates = getdays($getdate);
} else {
	$getdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2).'-'.substr(@$_GET['date'],6,2);
	$arrDates = getdays($getdate);
}

$d = new DateTime($arrDates[0]);
$dlw = new DateTime($arrDates[0]);
$dnw = new DateTime($arrDates[0]);

$d->modify("+0 day"); $d1 = $d->format('Y/m/d'); $sd1 = $d->format('m/d'); $td1 = $d->format('Ymd');
$d->modify('+1 day'); $d2 =  $d->format('Y/m/d'); $sd2 = $d->format('m/d'); $td2 = $d->format('Ymd');
$d->modify('+1 day'); $d3 =  $d->format('Y/m/d'); $sd3 = $d->format('m/d'); $td3 = $d->format('Ymd');
$d->modify('+1 day'); $d4 =  $d->format('Y/m/d'); $sd4 = $d->format('m/d'); $td4 = $d->format('Ymd');
$d->modify('+1 day'); $d5 =  $d->format('Y/m/d'); $sd5 = $d->format('m/d'); $td5 = $d->format('Ymd');
$d->modify('+1 day'); $d6 =  $d->format('Y/m/d'); $sd6 = $d->format('m/d'); $td6 = $d->format('Ymd');
$d->modify('+1 day'); $d7 =  $d->format('Y/m/d'); $sd7 = $d->format('m/d'); $td7 = $d->format('Ymd');

$dlw->modify('-7 day'); $lastweek = $dlw->format('Ymd');
$dnw->modify('+7 day'); $nextweek = $dnw->format('Ymd');

$db_area = new DB;
$db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
$arrArea = array();
for ($i=0;$i<$db_area->num_rows();$i++) {
	$r_area = $db_area->fetch_assoc();
	$arrArea[$r_area['areaID']] = $r_area['areaName'];
}

//$arrShift = array("A"=>"D", "B"=>"8-12", "C"=>"8-13", "D"=>"8-17", "E"=>"E", "F"=>"N", "G"=>"OFF", "H"=>"off", "I"=>"ALL", "J"=>"L", "K"=>"C+H", "L"=>"CHEF", "M"=>"KH", "L"=>"N");
$dbShift = new DB;
$dbShift->query("SELECT * FROM `shift` ORDER BY `shiftid`");
$arrShift = array();
for ($i=0;$i<$dbShift->num_rows();$i++) {
	$r_shift = $dbShift->fetch_assoc();
	$arrShift[$r_shift['shiftid']] = $r_shift['name'];
}
?>
<h3>Weekly shift duty list (<?php echo $d1; ?> ~ <?php echo $d7; ?>)</h3>
<?php
$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group`");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}
?>
<form action="index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>" method="post">
<table style="width:100%;" class="nurseform-table">
  <tr class="title">
    <td colspan="8"><input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $lastweek; ?>'" value="Previous Week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>'" value="Back to This Week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $nextweek; ?>'" value="Next Week"></td>
  </tr>
  <tr class="title">
    <td>&nbsp;</td>
    <td <?php if (date('Y/m/d')==$d1) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd1; ?><br>(Mon)</td>
    <td <?php if (date('Y/m/d')==$d2) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd2; ?><br>(Tue)</td>
    <td <?php if (date('Y/m/d')==$d3) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd3; ?><br>(Wed)</td>
    <td <?php if (date('Y/m/d')==$d4) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd4; ?><br>(Thu)</td>
    <td <?php if (date('Y/m/d')==$d5) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd5; ?><br>(Fri)</td>
    <td <?php if (date('Y/m/d')==$d6) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd6; ?><br>(Sat)</td>
    <td <?php if (date('Y/m/d')==$d7) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd7; ?><br>(Sun)</td>
  </tr>
  <?php
  if (@$_GET['group']==NULL) {
	  $sql1 = "SELECT * FROM `shift_member` WHERE `available`='1'";
  } else {
	  $sql1 = "SELECT * FROM `shift_member` WHERE `available`='1' AND `GroupID`='".mysql_escape_string($_GET['group'])."'";
  }
  $db1 = new DB;
  $db1->query($sql1);
  $arrEmpName = array();
  for ($i=0;$i<$db1->num_rows();$i++) {
	  $r1 = $db1->fetch_assoc();
	  if ($r1['EmpGroup']==1) { $table = "employer"; $NameColName = "Name"; $IDColName = "EmpID"; $table_shift = "employer_shift"; } elseif ($r1['EmpGroup']==2) { $table = "foreignemployer"; $NameColName = "cNickname"; $IDColName = "foreignID"; $table_shift = "foreignemployer_shift"; }
	  $db1a = new DB;
	  $db1a->query("SELECT `".$NameColName."` FROM `".$table."` WHERE `".$IDColName."`='".$r1['EmpID']."'");
	  $r1a = $db1a->fetch_assoc();
	  $arrEmpName[$r1[$IDColName]] = $r1a[$NameColName];
	  $db2a = new DB;
	  $db2a->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td1."'");
	  $r2a = $db2a->fetch_assoc();
	  $db2b = new DB;
	  $db2b->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td2."'");
	  $r2b = $db2b->fetch_assoc();
	  $db2c = new DB;
	  $db2c->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td3."'");
	  $r2c = $db2c->fetch_assoc();
	  $db2d = new DB;
	  $db2d->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td4."'");
	  $r2d = $db2d->fetch_assoc();
	  $db2e = new DB;
	  $db2e->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td5."'");
	  $r2e = $db2e->fetch_assoc();
	  $db2f = new DB;
	  $db2f->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td6."'");
	  $r2f = $db2f->fetch_assoc();
	  $db2g = new DB;
	  $db2g->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1['EmpID']."' AND `date`='".$td7."'");
	  $r2g = $db2g->fetch_assoc();
	  $error = 0;
	  echo '
  <tr>
    <td class="title_s" width="60" height="200">'.$r1a[$NameColName].'</td>
	<td '; if (date('Y/m/d')==$d1) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" }); })</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'" value="'.$r2a['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td1.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2a['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d2) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'" value="'.$r2b['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td2.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2b['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d3) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'" value="'.$r2c['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td3.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2c['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d4) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'" value="'.$r2d['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td4.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2d['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d5) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'" value="'.$r2e['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td5.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2e['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d6) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'" value="'.$r2f['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td6.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2f['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d7) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'" value="'.$r2g['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td7.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2g['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
  </tr>
	  '."\n";
  }
  ?>
  <tr class="title">
    <td colspan="8"><input type="submit" name="saveshift" value="Save"></td>
  </tr>
</table>
</form>
  </div>
  <div id="tabs-2">
  <iframe src="shiftarea_grid.php" frameborder="0" width="920" height="640"></iframe>
  </div>
</div>
