<div class="content-table" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 10px;">
<table>
  <tr>
    <td class="title" colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Area search</b></center></td>
    <td align="left" style="padding-left:5px;">
      <form action="index.php?mod=inputoutput&func=resplist2&query=1" method="post">
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
    <td align="left" style="padding-left:5px;"><form action="index.php?mod=inputoutput&func=resplist2&query=2" method="post">Social Security number&nbsp;<input name="IdNo" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNo" value="<?php echo $_POST['HospNo']; ?>" />&nbsp;<input type=submit value="Resident search" /><input type=button value="ID card search" /></form></td>
  </tr>
</table>
</div>
<div class="content-table" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<form action="module\inputoutput\resplist2db.php" method="post">
<table>
<tr>
  <td colspan="2" class="title">Date</td>
  <td colspan="2" style="padding-left:5px;"><script> $(function() { $( "#Qdate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Qdate" id="Qdate" size="12" value="<?php echo date('Y/m/d'); ?>" class="validate[required,custom[date]]" tabindex="1"></td>
  <td class="title">Time</td>
  <td colspan="4" style="padding-left:5px;"><select name="Qtime" id="Qtime" class="validate[required]" tabindex="2"><option></option><?php for ($i2a=0;$i2a<=23;$i2a++) { echo '<option value="'.$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; } ?></select></td>
</tr>
<tr class="title">
  <td>Area</td>
  <td>Bed</td>
  <td>Full name</td>
  <td>Total daily intake<br />I (Intake)</td>
  <td>Total daily output<br />O (Output)</td>
  <td>1. Stool<br />(STOOL)</td>
  <td>2. Number of other drainage tube<br />(Drain)</td>
  <td>3. Other<br />(Other)</td>
  <td>I-O=Daily<br />Positive and negative status</td>
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
	//查詢區域
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
$count=3;
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
		$db2c->query("SELECT `patientID`,`HospNo`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r2c = $db2c->fetch_assoc();
		if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
			echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
  <td align="center" style="padding-left:5px; padding-right:5px;">'.$r2b['areaName'].'</td>
  <td align="center">'.$r1['bed'].'</td>
  <td style="padding-left:5px;">'.getPatientName($r2c['patientID']).'</td>
  <td align="center"><input type="text" name="input_'.$r2c['HospNo'].'" id="input_'.$r2c['HospNo'].'" size="3" onblur="IO(\''.$r2c['HospNo'].'\');"></td>
  <td align="center"><input type="text" name="output_'.$r2c['HospNo'].'" id="output_'.$r2c['HospNo'].'" size="3" onblur="IO(\''.$r2c['HospNo'].'\');"></td>
  <td align="center"><input type="text" name="output1_'.$r2c['HospNo'].'" id="output1_'.$r2c['HospNo'].'" size="3"></td>
  <td align="center"><input type="text" name="output2_'.$r2c['HospNo'].'" id="output2_'.$r2c['HospNo'].'" size="3"></td>
  <td align="center"><input type="text" name="output3_'.$r2c['HospNo'].'" id="output3_'.$r2c['HospNo'].'" size="3"></td>
  <td align="center"><input type="text" name="IO_'.$r2c['HospNo'].'" id="IO_'.$r2c['HospNo'].'" size="3"></td>
</tr>
		'."\n";
		$n .= $r2c['HospNo'].';';
		}
	}
}
$n = substr($n,0,strlen($n)-1);
?>
</table>
<div style="margin-top:30px;">
<input type="hidden" name="totaln" value="<?php echo $n; ?>" />
<input type="hidden" name="Qfiller" value="<?php echo $_SESSION['ncareID_lwj']; ?>" />
<center><input type="submit" name="submit" value="Save" /></center>
</div>
</form>
</div>
<p>&nbsp;</p>
<script>
function IO(HospNo){
	var I = document.getElementById("input_"+ HospNo).value;
	var O = document.getElementById("output_"+ HospNo).value;
	
	if (!isNaN(I) && !isNaN(O)) {
		document.getElementById("IO_"+ HospNo).value = I - O;
	}
}
</script>