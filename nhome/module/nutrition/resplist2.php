<div class="content-query">
<table>
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Area search</b></center></td>
    <td align="left">
      <form action="index.php?mod=nutrition&func=resplist2&query=1" method="post">
      Area&nbsp;<select name="area">
      <?php
	  $qArea = new DB;
	  $qArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
	  for ($i=0;$i<$qArea->num_rows();$i++) {
		  $rArea = $qArea->fetch_assoc();
		  echo '<option value="'.$rArea['areaID'].'">'.$rArea['areaName'].'</option>'."\n";
	  }
	  ?>
      </select>&nbsp;
      <input type="submit" value="Search" /></form>
    </td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Resident search</b></center></td>
    <td align="left"><form action="index.php?mod=nutrition&func=resplist2&query=2" method="post">Social Security number&nbsp;<input name="IdNo" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNo" value="<?php echo $_POST['HospNo']; ?>" />&nbsp;<input type=submit value="Resident search" /><input type=button value="ID card search" /></form></td>
  </tr>
</table>
</div>
<div class="content-table">
<form action="module\nutrition\resplist2db.php" method="post">
<center><input type="submit" name="submit" value="Save" /></center>
<table>
<tr class="title">
  <td>Area</td>
  <td>Bed</td>
  <td>Full name</td>
  <td>Care ID#</td>
  <td>Gender</td>  
  <td>Age</td>
  <td>Body weight</td>
</tr>
<?php
if (@$_GET['query']==2) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNo` LIKE '%".mysql_escape_string($_POST['HospNo'])."%' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1) {
	//查詢區域
	$arrAreaBed = array();
	$db2 = new DB;
	$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_POST['area'])."'");
	for ($k=0;$k<$db2->num_rows();$k++) {
		$r2 = $db2->fetch_assoc();
		$arrAreaBed[$k] = $r2['bedID'];
	}
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
} else {
	$arrAreaBed = array();
	$db2 = new DB;
	$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='2'");
	for ($k=0;$k<$db2->num_rows();$k++) {
		$r2 = $db2->fetch_assoc();
		$arrAreaBed[$k] = $r2['bedID'];
	}
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
}
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
	for ($j=0;$j<$db1->num_rows();$j++) {
		$r1 = $db1->fetch_assoc();
		if (@$_GET['query']==1) {
			if (count($arrAreaBed)==0) {
			if (@$_GET['query']!=NULL) {
				echo '<script>alert("此區域尚未有住民入住");</script>'."\n";
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
		$db2c->query("SELECT `patientID`,`HospNo`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r2c = $db2c->fetch_assoc();
		if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
			echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':'').'>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.getPatientName($r2c['patientID']).'</td>
  <td>'.$r2c['HospNo'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td><input type="text" name="vs_188334_'.$r2c['HospNo'].'" id="vs_84806_'.$r2c['HospNo'].'" size="3">lbs</td>
</tr>
		'."\n";
		$n .= $r2c['HospNo'].';';
		}
	}
}
$n = substr($n,0,strlen($n)-1);
?>
</table>
<input type="hidden" name="totaln" value="<?php echo $n; ?>" />
<input type="hidden" name="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
<center><input type="submit" name="submit" value="Save" /></center>
</form>
</div>
<p>&nbsp;</p>