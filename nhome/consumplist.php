<div class="content-query">
<table>
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Area search</b></center></td>
    <td align="left">
      <form action="index.php?func=patientlist&query=1" method="post">
      Section&nbsp;<select name="area">
      <?php
	  $qArea = new DB;
	  $qArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
	  for ($i=0;$i<$qArea->num_rows();$i++) {
		  $rArea = $qArea->fetch_assoc();
		  echo '<option value="'.$rArea['areaID'].'"';
		  if ($_POST['area']==$rArea['areaID']) { echo " selected"; }
		  echo '>'.$rArea['areaName'].'</option>'."\n";
	  }
	  ?>
      </select>&nbsp;
      <input type="submit" value="Search" /> <?php if (@$_GET['query']==1) { echo '<input type="button" value="清除搜尋結果Clear Search Results" onclick="window.location.href = \'index.php?func=patientlist\'" />'."\n"; } ?></form>
    </td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Patient search</b></center></td>
    <td align="left"><form action="index.php?func=patientlist&query=2" method="post" style="display:inline;">SSN#&nbsp;<input name="IdNo" size="8" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNo" value="<?php echo $_POST['HospNo']; ?>" size="6" />&nbsp;<input type=submit value="Patient search" /><!--<input type=button value="Insurance ID card reading search" />--></form><form style="display:inline;"><input type=button value="Search closed case resident"  onclick="window.location.href='index.php?func=patientlist&query=3'" /></form> <?php if (@$_GET['query']==2) { echo '<input type="button" value="Clear search results" onclick="window.location.href = \'index.php?func=patientlist\'" />'."\n"; } ?></td>
  </tr>
</table>
</div>
<div class="content-table">
<table>
<?php
if (@$_GET['query']==3) {
	$sql1 = "SELECT `patientID` FROM `closedcase` ORDER BY `outdate` DESC";
} elseif (@$_GET['query']==2) {
	//身份證查詢 SSNID search
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNo` LIKE '%".mysql_escape_string($_POST['HospNo'])."%' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1) {
	//查詢區域 section search
	$arrAreaBed = array();
	$db2 = new DB;
	$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_POST['area'])."'");
	for ($k=0;$k<$db2->num_rows();$k++) {
		$r2 = $db2->fetch_assoc();
		$arrAreaBed[$k] = $r2['bedID'];
	}
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
} else {
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
}
$db = new DB;
$db->query($sql1);
	echo '
<tr class="title">
  <td>Section</td>
  <td>Bed No.</td>
  <td>Full Name</td>
  <td>Care ID#</td>
  <td>Gender</td>  
  <td>Age</td>
  <td>Check-in date</td>
  <td>Apply material</td>
</tr>
	'."\n";
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
	for ($j=0;$j<$db1->num_rows();$j++) {
		$r1 = $db1->fetch_assoc();
		if (@$_GET['query']==1) {
			if (count($arrAreaBed)==0) {
				if (@$_GET['query']!=NULL) {
					echo '<script>alert("此區域尚未有住民入住 The section has yet no resident");</script>'."\n";
					break 2;
				}
			}
		}
		$db2a = new DB;
		$db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
		$r2a = $db2a->fetch_assoc();
		$db2b = new DB;
		$db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
		$r2b = $db2b->fetch_assoc();
		$db2c = new DB;
		$db2c->query("SELECT `HospNo`,`Birth` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r2c = $db2c->fetch_assoc();
		if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
			echo '
<tr>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.getPatientName($r['patientID']).'</td>
  <td>'.$r2c['HospNo'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
  <td><center><form><input type="button" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=3&pid='.$r['patientID'].'&query='.@$_GET['query'].'\'" value="Apply item"></form></center></td>'."\n";
		}
	}
}
?>
</table>
</div>
<p>&nbsp;</p>