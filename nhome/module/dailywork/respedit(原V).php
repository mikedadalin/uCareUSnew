<?php
$db0 = new DB;
$db0->query("SELECT * FROM `vitalsign_range` ORDER BY `itemID` ASC");
for ($i=0;$i<$db0->num_rows();$i++) {
	$r0 = $db0->fetch_assoc();
	${$r0['itemID'].'_low'} = $r0['keylow'];
	${$r0['itemID'].'_high'} = $r0['keyhigh'];
}

$qTime = str_replace('%20',' ',@$_GET['time']).'.0000000';

if (isset($_POST['savevs'])) {
	$PersonID = @$_GET['pid'];
	
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
	
	$qTime2 = substr(str_replace('%20',' ',@$_GET['time']),0,19);
	$date = str_replace("/","-",$_POST['measuredate']);
	$arrDate = explode("-",$date);
	if (strlen($arrDate[1])==1) { $arrDate[1] = "0".$arrDate[1]; }
	if (strlen($arrDate[2])==1) { $arrDate[2] = "0".$arrDate[2]; }
	$date = $arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
	if (strlen($_POST['measuretime'])==3) {
		$time = "0".substr($_POST['measuretime'],0,1).":".substr($_POST['measuretime'],1,2);
	} else {
		$time = substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2);
	}
	
	$NewRecordedTime = $date." ".$time;
	
	if ($NewRecordedTime != $qTime2) {
		$RecordedTime = $date." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2).date(":".s.".0000000");
	} else {
		$RecordedTime = $qTime;
	}
	function checkvitalexist($pID, $loinc, $rTime, $value, $vid) {
		if ($vid=="") {
			$db0a = new DB;
			$db0a->query("INSERT INTO `vitalsigns` (`PersonID`, `LoincCode`, `TimeFlag`, `RecordedTime`, `UploadedTime`, `Value`, `IsValid`, `Qfiller`) VALUES ('".$pID."', '".$loinc."', DATE_FORMAT('".$rTime."', '%Y%m'), '".$rTime."', '".$rTime."', '".$value."', '1', '".$_SESSION['ncareID_lwj']."')");
		} else {
			$db0a = new DB;
			$db0a->query("UPDATE `vitalsigns` SET `Value`='".$value."' WHERE `VitalSignID`='".$vid."'");
		}
	}
	if ($loinc_8480!='') { checkvitalexist($PersonID, '8480-6', $RecordedTime, $loinc_8480, $_POST['vid_8480-6']); }
	if ($loinc_8462!='') { checkvitalexist($PersonID, '8462-4', $RecordedTime, $loinc_8462, $_POST['vid_8462-4']); }
	if ($loinc_8867!='') { checkvitalexist($PersonID, '8867-4', $RecordedTime, $loinc_8867, $_POST['vid_8867-4']); }
	if ($loinc_2710!='') { checkvitalexist($PersonID, '2710-2', $RecordedTime, $loinc_2710, $_POST['vid_2710-2']); }
	if ($loinc_14743!='') { checkvitalexist($PersonID, '14743-9', $RecordedTime, $loinc_14743, $_POST['vid_14743-9']); }
	if ($loinc_150755!='') { checkvitalexist($PersonID, '15075-5', $RecordedTime, $loinc_150755, $_POST['vid_15075-5']); }
	if ($loinc_8310!='') { checkvitalexist($PersonID, '8310-5', $RecordedTime, $loinc_8310, $_POST['vid_8310-5']); }
	if ($loinc_9279!='') { checkvitalexist($PersonID, '9279-1', $RecordedTime, $loinc_9279, $_POST['vid_9279-1']); }
	if ($loinc_460337!='') { checkvitalexist($PersonID, '46033-7', $RecordedTime, $loinc_460337, $_POST['vid_46033-7']); }
	if ($loinc_188334!='') { checkvitalexist($PersonID, '18833-4', $RecordedTime, $loinc_188334, $_POST['vid_18833-4']); }
	if ($loinc_391060!='') { checkvitalexist($PersonID, '39106-0', $RecordedTime, $loinc_391060, $_POST['vid_39106-0']); }
	//echo $RecordedTime;
	echo "<script>window.location.href = 'index.php?mod=dailywork&func=formview&pid=".$_GET['pid']."';</script>";
} elseif (isset($_POST['deletevs'])) {
	$PersonID = @$_GET['pid'];
	
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
	
	$qTime2 = substr(str_replace('%20',' ',@$_GET['time']),0,19);
	$NewRecordedTime = str_replace("/","-",$_POST['measuredate'])." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2);
	
	if ($NewRecordedTime != $qTime2) {
		$RecordedTime = str_replace("/","-",$_POST['measuredate'])." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2).date(":".s.".0000000");
	} else {
		$RecordedTime = $qTime;
	}
	
	if ($_POST['vid_8480-6']!='') { $db1 = new DB; $db1->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_8480-6'])."'"); }
	if ($_POST['vid_8462-4']!='') { $db2 = new DB; $db2->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_8462-4'])."'"); }
	if ($_POST['vid_8867-4']!='') { $db3 = new DB; $db3->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_8867-4'])."'"); }
	if ($_POST['vid_2710-2']!='') { $db4 = new DB; $db4->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_2710-2'])."'"); }
	if ($_POST['vid_14743-9']!='') { $db5 = new DB; $db5->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_14743-9'])."'"); }
	if ($_POST['vid_15075-5']!='') { $db5a = new DB; $db5a->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_15075-5'])."'"); }
	if ($_POST['vid_8310-5']!='') { $db6 = new DB; $db6->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_8310-5'])."'"); }
	if ($_POST['vid_9279-1']!='') { $db7 = new DB; $db7->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_9279-1'])."'"); }
	if ($_POST['vid_46033-7']!='') { $db8 = new DB; $db8->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_46033-7'])."'"); }
	if ($_POST['vid_18833-4']!='') { $db9 = new DB; $db9->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_18833-4'])."'"); }
	if ($_POST['vid_39106-0']!='') { $db10 = new DB; $db10->query("DELETE FROM `vitalsigns` WHERE `VitalSignID`='".mysql_escape_string($_POST['vid_39106-0'])."'"); }

	echo "<script>window.location.href = 'index.php?mod=dailywork&func=formview';</script>";
}

$db = new DB;
$db->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime`='".$qTime."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	if ($r['LoincCode']=='8480-6') { $loinc_8480 = $r['Value']; $vid_8480 = $r['VitalSignID']; }
	if ($r['LoincCode']=='8462-4') { $loinc_8462 = $r['Value']; $vid_8462 = $r['VitalSignID']; }
	if ($r['LoincCode']=='8867-4') { $loinc_8867 = $r['Value']; $vid_8867 = $r['VitalSignID']; }
	if ($r['LoincCode']=='2710-2') { $loinc_2710 = $r['Value']; $vid_2710 = $r['VitalSignID']; }
	if ($r['LoincCode']=='14743-9') { $loinc_14743 = $r['Value']; $vid_14743 = $r['VitalSignID']; }
	if ($r['LoincCode']=='15075-5') { $loinc_150755 = $r['Value']; $vid_150755 = $r['VitalSignID']; }
	if ($r['LoincCode']=='8310-5') { $loinc_8310 = $r['Value']; $vid_8310 = $r['VitalSignID']; }
	if ($r['LoincCode']=='9279-1') { $loinc_9279 = $r['Value']; $vid_9279 = $r['VitalSignID']; }
	if ($r['LoincCode']=='46033-7') { $loinc_460337 = $r['Value']; $vid_460337 = $r['VitalSignID']; }
	if ($r['LoincCode']=='18833-4') { $loinc_188334 = $r['Value']; $vid_188334 = $r['VitalSignID']; }
	if ($r['LoincCode']=='39106-0') { $loinc_391060 = $r['Value']; $vid_391060 = $r['VitalSignID']; }
}


$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."' ORDER BY `patientID` ASC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT * FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $r[$LWJArray[$i]] = $r[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$i]] = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
	if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
	if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}
	$name = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
}
?>
<div class="content-table">
<form method="post" action="index.php?mod=dailywork&func=respedit&pid=<?php echo @$_GET['pid']; ?>&time=<?php echo @$_GET['time']; ?>">
    <div class="nurseform-table">
    <table style="width:520px;">
      <tr>
        <td class="title">Full name</td>
        <td><?php echo $name;?></td>
        <td class="title">DOB</td>
        <td><?php echo $birth;?></td>
        <td class="title">Admission date</td>
        <td><?php echo $indate;?></td>
      </tr>
	</table>
    <table style="width:520px;">
      <tr>
        <td class="title" width="120">Measure date/time</td>
        <td width="400"><script> $(function() { $( "#measuredate").datetimepicker({format:'Y-m-d', timepicker: false, mask: true}); }); </script><input type="text" name="measuredate" id="measuredate" value="<?php echo substr($qTime,0,10); ?>" size="12" > <input type="text" name="measuretime" id="measuretime" value="<?php echo str_replace(':','',substr($qTime,11,5)); ?>" size="4" > <font size="2">(Format:HHmm)</font></td>
      </tr>
      <tr>
        <td class="title">Body temperature (T)</td>
        <td><input type="text" name="loinc_8310-5" id="loinc_8310-5" size="4" value="<?php echo $loinc_8310; ?>" class="validate[min[<?php echo $vs83105_low; ?>],max[<?php echo $vs83105_high; ?>]]">&deg;C<input type="hidden" name="vid_8310-5" id="vid_8310-5" value="<?php echo $vid_8310; ?>"></td>
      </tr>
      <tr>
        <td class="title">Heartbeat (Pulse)</td>
        <td><input type="text" name="loinc_8867-4" id="loinc_8867-4" size="4" value="<?php echo $loinc_8867; ?>" class="validate[min[<?php echo $vs88674_low; ?>],max[<?php echo $vs88674_high; ?>]]">times/minute<input type="hidden" name="vid_8867-4" id="vid_8867-4" value="<?php echo $vid_8867; ?>"></td>
      </tr>
      <tr>
        <td class="title">Respiratory (R)</td>
        <td><input type="text" name="loinc_9279-1" id="loinc_9279-1" size="4" value="<?php echo $loinc_9279; ?>" class="validate[min[<?php echo $vs92791_low; ?>],max[<?php echo $vs92791_high; ?>]]">times/minute<input type="hidden" name="vid_9279-1" id="vid_9279-1" value="<?php echo $vid_9279; ?>"></td>
      </tr>
      <tr>
        <td class="title" width="120">Blood pressure (BP)</td>
        <td width="400"><input type="text" name="loinc_8480-6" id="loinc_8480-6" size="4" value="<?php echo $loinc_8480; ?>" class="validate[min[<?php echo $vs84806_low; ?>],max[<?php echo $vs84806_high; ?>]]">/<input type="text" name="loinc_8462-4" id="loinc_8462-4" size="4" value="<?php echo $loinc_8462; ?>" class="validate[min[<?php echo $vs84624_low; ?>],max[<?php echo $vs84624_high; ?>]]">mmHg <input type="hidden" name="vid_8480-6" id="vid_8480-6" value="<?php echo $vid_8480; ?>"><input type="hidden" name="vid_8462-4" id="vid_8462-4" value="<?php echo $vid_8462; ?>"></td>
      </tr>
      <tr>
        <td class="title">SpO2 (O2)</td>
        <td><input type="text" name="loinc_2710-2" id="loinc_2710-2" size="4" value="<?php echo $loinc_2710; ?>" class="validate[min[<?php echo $vs27102_low; ?>],max[<?php echo $vs27102_high; ?>]]">%<input type="hidden" name="vid_2710-2" id="vid_2710-2" value="<?php echo $vid_2710; ?>"></td>
      </tr>
      <tr>
        <td class="title">Pain scale</td>
        <td><input type="text" name="loinc_46033-7" id="loinc_46033-7" size="4" value="<?php echo $loinc_460337; ?>" class="validate[min[<?php echo $vs460337_low; ?>],max[<?php echo $vs460337_high; ?>]]">Score<input type="hidden" name="vid_46033-7" id="vid_46033-7" value="<?php echo $vid_460337; ?>"></td>
      </tr>
      <tr>
        <td class="title">AC Blood glucose</td>
        <td><input type="text" name="loinc_14743-9" id="loinc_14743-9" size="4" value="<?php echo $loinc_14743; ?>" class="validate[min[<?php echo $vs14743_low; ?>],max[<?php echo $vs14743_high; ?>]]">mg/dl<input type="hidden" name="vid_14743-9" id="vid_14743-9" value="<?php echo $vid_14743; ?>"></td>
      </tr>
      <tr>
        <td class="title">PC Blood glucose</td>
        <td><input type="text" name="loinc_15075-5" id="loinc_15075-5" size="4" value="<?php echo $loinc_150755; ?>" class="validate[min[<?php echo $vs150755_low; ?>],max[<?php echo $vs150755_high; ?>]]">mg/dl<input type="hidden" name="vid_15075-5" id="vid_15075-5" value="<?php echo $vid_150755; ?>"></td>
      </tr>
      <tr>
        <td class="title">
        Axillary temperature
        </td>
        <td><input type="text" name="loinc_39106-0" id="loinc_39106-0" size="4" value="<?php echo $loinc_391060; ?>" class="validate[min[<?php echo $vs391060_low; ?>],max[<?php echo $vs391060_high; ?>]]">
        &deg;F
        <input type="hidden" name="vid_39106-0" id="vid_39106-0" value="<?php echo $vid_391060; ?>"></td>
      </tr>
      <tr>
        <td class="title">Weight</td>
        <td><input type="text" name="loinc_18833-4" id="loinc_18833-4" size="4" value="<?php echo $loinc_188334; ?>" class="validate[min[<?php echo $vs188334_low; ?>],max[<?php echo $vs188334_high; ?>]]">lbs<input type="hidden" name="vid_18833-4" id="vid_18833-4" value="<?php echo $vid_188334; ?>"></td>
      </tr>
      <tr>
        <td colspan="2"><center><input type="submit" name="savevs" id="savevs" value="Modify vital sign" /> <input type="submit" name="deletevs" id="deletevs" value="Delete this record" onclick="if (confirm('Confirm deletation?')) { return true; } else { return false; }" /></center></td>
      </tr>
    </table>
    </div>
</form>
</div>
<p>&nbsp;</p>