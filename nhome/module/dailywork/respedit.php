<?php
$db0 = new DB;
$db0->query("SELECT * FROM `vitalsign_range` ORDER BY `itemID` ASC");
for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	${$r0['itemID'].'_low'} = $r0['keylow'];
	${$r0['itemID'].'_high'} = $r0['keyhigh'];
}

$qTime = str_replace('%20',' ',@$_GET['time']);

if (isset($_POST['savevs'])) {
	$PatientID = @$_GET['pid'];
	
	$loinc_8480 = $_POST['loinc_8480-6'];
	$loinc_8462 = $_POST['loinc_8462-4'];
	$loinc_8867 = $_POST['loinc_8867-4'];
	$loinc_2710 = $_POST['loinc_2710-2'];
	$loinc_14743 = $_POST['loinc_14743-9'];
	$loinc_150755 = $_POST['loinc_15075-5'];
	$loinc_8310 = $_POST['loinc_8310-5'];
	$loinc_9279 = $_POST['loinc_9279-1'];
	$loinc_460337 = $_POST['loinc_46033-7'];
	$loinc_188334 = $_POST['loinc_18833-4'];
	$loinc_391060 = $_POST['loinc_39106-0'];
	
	$date = $_POST['measuredate'];
	if (strlen($_POST['measuretime'])==3) {
		$time = "0".substr($_POST['measuretime'],0,1).":".substr($_POST['measuretime'],1,2);
	} else {
		$time = substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2);
	}
	
	$NewRecordedTime = $date." ".$time;
	
	if ($NewRecordedTime != $qTime) {
		$RecordedTime = $NewRecordedTime;
	} else {
		$RecordedTime = $qTime;
	}
	function checkvitalexist($pID, $loinc, $rTime, $value, $vid) {
		if ($vid=="") {
			$arrTime = explode(" ",$rTime);
			$date = date("Ymd",strtotime($arrTime[0]));
			$time = date("Hi",strtotime($arrTime[1]));
			$db0a = new DB;
			$db0a->query("INSERT INTO `vitalsign` (`PatientID`, `loinc_".$loinc."`, `date`, `time`, `Qfiller`) VALUES ('".$pID."', '".$value."', '".$date."', '".$time."', '".$_SESSION['ncareID_lwj']."')");
		} else {
			$db0a = new DB;
			$db0a->query("UPDATE `vitalsign` SET `loinc_".$loinc."`='".$value."', `date`='".$date."', `time`='".$time."' WHERE `VitalSignID`='".$vid."'");
		}
	}
	if ($loinc_8480!='') { checkvitalexist($PatientID, '8480_6', $RecordedTime, $loinc_8480, $_POST['VitalSignID']); }
	if ($loinc_8462!='') { checkvitalexist($PatientID, '8462_4', $RecordedTime, $loinc_8462, $_POST['VitalSignID']); }
	if ($loinc_8867!='') { checkvitalexist($PatientID, '8867_4', $RecordedTime, $loinc_8867, $_POST['VitalSignID']); }
	if ($loinc_2710!='') { checkvitalexist($PatientID, '2710_2', $RecordedTime, $loinc_2710, $_POST['VitalSignID']); }
	if ($loinc_14743!='') { checkvitalexist($PatientID, '14743_9', $RecordedTime, $loinc_14743, $_POST['VitalSignID']); }
	if ($loinc_150755!='') { checkvitalexist($PatientID, '15075_5', $RecordedTime, $loinc_150755, $_POST['VitalSignID']); }
	if ($loinc_8310!='') { checkvitalexist($PatientID, '8310_5', $RecordedTime, $loinc_8310, $_POST['VitalSignID']); }
	if ($loinc_9279!='') { checkvitalexist($PatientID, '9279_1', $RecordedTime, $loinc_9279, $_POST['VitalSignID']); }
	if ($loinc_460337!='') { checkvitalexist($PatientID, '46033_7', $RecordedTime, $loinc_460337, $_POST['VitalSignID']); }
	if ($loinc_188334!='') { checkvitalexist($PatientID, '18833_4', $RecordedTime, $loinc_188334, $_POST['VitalSignID']); }
	if ($loinc_391060!='') { checkvitalexist($PatientID, '39106_0', $RecordedTime, $loinc_391060, $_POST['VitalSignID']); }
	echo "<script>window.location.href = 'index.php?mod=dailywork&func=formview&pid=".$_GET['pid']."';</script>";
} elseif (isset($_POST['deletevs'])) {
	$PatientID = @$_GET['pid'];
	$db = new DB;
	$db->query("DELETE FROM `vitalsign` WHERE `VitalSignID`='".mysql_escape_string($_POST['VitalSignID'])."'");
	echo "<script>window.location.href = 'index.php?mod=dailywork&func=formview';</script>";
}

$arrqTime = explode(" ",$qTime);
$qTime_date = date("Ymd",strtotime($arrqTime[0]));
$qTime_time = date("Hi",strtotime($arrqTime[1]));
$db = new DB;
$db->query("SELECT * FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `date`='".$qTime_date."' AND `time`='".$qTime_time."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach($r as $k=>$v){
		$arrVitalsign = explode("_",$k);
		if ($arrVitalsign[0]=="loinc" && $v!="") {
			$LoincCode = $arrVitalsign[1]."-".$arrVitalsign[2];
			if ($LoincCode=='8480-6') { $loinc_8480 = $v; }
			if ($LoincCode=='8462-4') { $loinc_8462 = $v; }
			if ($LoincCode=='8867-4') { $loinc_8867 = $v; }
			if ($LoincCode=='2710-2') { $loinc_2710 = $v; }
			if ($LoincCode=='14743-9') { $loinc_14743 = $v; }
			if ($LoincCode=='15075-5') { $loinc_150755 = $v; }
			if ($LoincCode=='8310-5') { $loinc_8310 = $v; }
			if ($LoincCode=='9279-1') { $loinc_9279 = $v; }
			if ($LoincCode=='46033-7') { $loinc_460337 = $v; }
			if ($LoincCode=='18833-4') { $loinc_188334 = $v; }
			if ($LoincCode=='39106-0') { $loinc_391060 = $v; }
		}
		$VitalSignID = $r['VitalSignID'];
	}
}


$db = new DB;
$db->query("SELECT `patientID`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `patientID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
}
?>
<div class="moduleNoTab">
<form method="post" action="index.php?mod=dailywork&func=respedit&pid=<?php echo @$_GET['pid']; ?>&time=<?php echo @$_GET['time']; ?>">
    <div class="nurseform-table">
    <table>
      <tr>
        <td class="title">Full name</td>
        <td><?php echo $name;?></td>
        <td class="title">DOB</td>
        <td><?php echo $birth;?></td>
        <td class="title">Admission date</td>
        <td><?php echo $indate;?></td>
      </tr>
	</table>
    <table>
      <tr>
	    <input type="hidden" name="VitalSignID" id="VitalSignID" value="<?php echo $VitalSignID; ?>">
        <td class="title" width="120">Measure date/time</td>
        <td width="400" align="left"><script> $(function() { $( "#measuredate").datetimepicker({format:'Y-m-d', timepicker: false, mask: true}); }); </script><input type="text" name="measuredate" id="measuredate" value="<?php echo substr($qTime,0,10); ?>" size="12" > <input type="text" name="measuretime" id="measuretime" value="<?php echo str_replace(':','',substr($qTime,11,5)); ?>" size="4" > <font size="2">(Format:HHmm)</font></td>
      </tr>
      <tr>
        <td class="title">Body temperature (T)</td>
        <td align="left"><input type="text" name="loinc_8310-5" id="loinc_8310-5" size="4" value="<?php echo $loinc_8310; ?>" class="validate[min[<?php echo $vs83105_low; ?>],max[<?php echo $vs83105_high; ?>]]">&deg;C</td>
      </tr>
      <tr>
        <td class="title">Heartbeat (Pulse)</td>
        <td align="left"><input type="text" name="loinc_8867-4" id="loinc_8867-4" size="4" value="<?php echo $loinc_8867; ?>" class="validate[min[<?php echo $vs88674_low; ?>],max[<?php echo $vs88674_high; ?>]]">times/minute</td>
      </tr>
      <tr>
        <td class="title">Respiratory (R)</td>
        <td align="left"><input type="text" name="loinc_9279-1" id="loinc_9279-1" size="4" value="<?php echo $loinc_9279; ?>" class="validate[min[<?php echo $vs92791_low; ?>],max[<?php echo $vs92791_high; ?>]]">times/minute</td>
      </tr>
      <tr>
        <td class="title" width="120">Blood pressure (BP)</td>
        <td width="400" align="left"><input type="text" name="loinc_8480-6" id="loinc_8480-6" size="4" value="<?php echo $loinc_8480; ?>" class="validate[min[<?php echo $vs84806_low; ?>],max[<?php echo $vs84806_high; ?>]]">/<input type="text" name="loinc_8462-4" id="loinc_8462-4" size="4" value="<?php echo $loinc_8462; ?>" class="validate[min[<?php echo $vs84624_low; ?>],max[<?php echo $vs84624_high; ?>]]">mmHg </td>
      </tr>
      <tr>
        <td class="title">SpO2 (O2)</td>
        <td align="left"><input type="text" name="loinc_2710-2" id="loinc_2710-2" size="4" value="<?php echo $loinc_2710; ?>" class="validate[min[<?php echo $vs27102_low; ?>],max[<?php echo $vs27102_high; ?>]]">%</td>
      </tr>
      <tr>
        <td class="title">Pain scale</td>
        <td align="left"><input type="text" name="loinc_46033-7" id="loinc_46033-7" size="4" value="<?php echo $loinc_460337; ?>" class="validate[min[<?php echo $vs460337_low; ?>],max[<?php echo $vs460337_high; ?>]]">Score</td>
      </tr>
      <tr>
        <td class="title">AC Blood glucose</td>
        <td align="left"><input type="text" name="loinc_14743-9" id="loinc_14743-9" size="4" value="<?php echo $loinc_14743; ?>" class="validate[min[<?php echo $vs14743_low; ?>],max[<?php echo $vs14743_high; ?>]]">mg/dl</td>
      </tr>
      <tr>
        <td class="title">PC Blood glucose</td>
        <td align="left"><input type="text" name="loinc_15075-5" id="loinc_15075-5" size="4" value="<?php echo $loinc_150755; ?>" class="validate[min[<?php echo $vs150755_low; ?>],max[<?php echo $vs150755_high; ?>]]">mg/dl</td>
      </tr>
      <tr>
        <td class="title">
        Axillary temperature
        </td>
        <td align="left"><input type="text" name="loinc_39106-0" id="loinc_39106-0" size="4" value="<?php echo $loinc_391060; ?>" class="validate[min[<?php echo $vs391060_low; ?>],max[<?php echo $vs391060_high; ?>]]">
        &deg;F
        </td>
      </tr>
      <tr>
        <td class="title">Weight</td>
        <td align="left"><input type="text" name="loinc_18833-4" id="loinc_18833-4" size="4" value="<?php echo $loinc_188334; ?>" class="validate[min[<?php echo $vs188334_low; ?>],max[<?php echo $vs188334_high; ?>]]">lbs</td>
      </tr>
      <tr>
        <td colspan="2"><center><input type="submit" name="savevs" id="savevs" value="Modify vital sign" /> <input type="submit" name="deletevs" id="deletevs" value="Delete this record" onclick="if (confirm('Confirm deletation?')) { return true; } else { return false; }" /></center></td>
      </tr>
    </table>
    </div>
</form>
</div>