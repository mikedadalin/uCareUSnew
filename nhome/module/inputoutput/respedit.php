<?php
$qTime = str_replace('%20',' ',@$_GET['time']).'.0000000';

if (isset($_POST['savevs'])) {
	$PersonID = @$_GET['pid'];
	
	$input = $_POST['input'];
	$output = $_POST['output'];
	$output1 = $_POST['output1'];
	$output2 = $_POST['output2'];
	$output3 = $_POST['output3'];
	$output = $_POST['output'];
	$iostatus = $_POST['IOstatus'];
	
	$qTime2 = substr(str_replace('%20',' ',@$_GET['time']),0,19);
	$NewRecordedTime = str_replace("/","-",$_POST['measuredate'])." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2);
	
	if ($NewRecordedTime != $qTime2) {
		$RecordedTime = str_replace("/","-",$_POST['measuredate'])." ".substr($_POST['measuretime'],0,2).":".substr($_POST['measuretime'],2,2).date(":".s.".0000000");
	} else {
		$RecordedTime = $qTime;
	}
	
	$IOID = $_POST['IOID'];
	
	if ($input !='') {
		$db1 = new DB;
		$db1->query("UPDATE `iostatus` SET `input`='".$input."', `output`='".$output."', `output1`='".$output1."', `output2`='".$output2."', `output3`='".$output3."', `iostatus`='".$iostatus."', `RecordedTime`='".$RecordedTime."' WHERE `IOID`='".$IOID."'");
	}
	echo "<script>window.location.href = 'index.php?mod=inputoutput&func=formview';</script>";
}

$db2 = new DB;
$db2->query("SELECT * FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime`='".$qTime."'");
$r2 = $db2->fetch_assoc();


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
echo '<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom:10px; width:510px;">
<div class="content-query" style="width:100%;">
<table align="center" style="width:510px;">
<tr>
<td class="title">Full name</td>
<td class="title">DOB</td>
<td class="title">Admission date</td>
</tr>
<tr>
<td>'.$name.'</td>
<td>'.$birth.'</td>
<td>'.$indate.'</td>
</tr>
</table>
</div>
</div>'."\n";
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px; margin-bottom: 10px; width:510px;">
  <div class="content-table">
    <form method="post" action="index.php?mod=inputoutput&func=respedit&pid=<?php echo @$_GET['pid']; ?>&time=<?php echo @$_GET['time']; ?>">
      <div class="nurseform-table">
        <table style="width:520px; text-align:left;">
          <tr>
            <td class="title" width="150" style="padding:5px;">Measure date/time</td>
            <td width="400"><script> $(function() { $( "#measuredate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="measuredate" id="measuredate" value="<?php echo substr($qTime,0,10); ?>" size="12" > <input type="text" name="measuretime" id="measuretime" value="<?php echo str_replace(':','',substr($qTime,11,5)); ?>" size="4" > <font size="2">(Format:HHmm)</font><input type="hidden" name="IOID" id="IOID" value="<?php echo $r2['IOID']; ?>"></td>
          </tr>
          <tr>
            <td class="title" style="padding:5px;">Total daily intake<br />I (Intake)</td>
            <td><input type="text" name="input" id="input" size="4" value="<?php echo $r2['input']; ?>"></td>
          </tr>
          <tr>
            <td class="title" style="padding:5px;">Total daily output<br />O (Output)</td>
            <td><input type="text" name="output" id="output" size="4" value="<?php echo $r2['output']; ?>"></td>
          </tr>
          <tr>
            <td class="title" style="padding:5px;">1. Stool<br />(STOOL)</td>
            <td><input type="text" name="output1" id="output1" size="4" value="<?php echo $r2['output1']; ?>"></td>
          </tr>
          <tr>
            <td class="title" style="padding:5px;">2. Number of other drainage tube<br />(Drain)</td>
            <td><input type="text" name="output2" id="output2" size="4" value="<?php echo $r2['output2']; ?>"></td>
          </tr>
          <tr>
            <td class="title" style="padding:5px;">3. Other<br />(Other)</td>
            <td><input type="text" name="output3" id="output3" size="4" value="<?php echo $r2['output3']; ?>"></td>
          </tr>
          <tr>
            <td class="title" style="padding:5px;">I-O=Daily<br />Positive and negative status</td>
            <td><input type="text" name="IOstatus" id="IOstatus" size="4" value="<?php echo $r2['iostatus']; ?>"></td>
          </tr>
          <tr>
            <td colspan="2"><center><input type="submit" name="savevs" id="savevs" value="Modify I/O value" /></center></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>
<p>&nbsp;</p>