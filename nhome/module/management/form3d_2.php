<?php
$arrTargetType = array("", "Hospitalization", "Restraint", "Fall", "Infection", "Pressure ulcer(s)", "", "Nasogastric tube remove", "Catheter remove");
$qdate = mysql_escape_string($_GET['qdate']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 30px;">
<h3><?php echo $arrTargetType[$_GET['type']]; ?> cause analysis and improvement measures(Case-by-case analysis)</h3>
<?php
if (isset($_POST['save'])) {
	$date = $_POST['date'];
	$time = $_POST['timeH'].':'.$_POST['timeI'].':00';
	$location = $_POST['location'];
	$host = $_POST['host'];
	$member = $_POST['member'];

	$db = new DB;
	$db->query("INSERT INTO `sixtarget_meeting` VALUES ('', '".$date."','".$time."','".mysql_escape_string($_GET['type'])."','".$location."','".$host."','".$member."','".$_SESSION['ncareID_lwj']."')");
	$db0 = new DB;
	$db0->query("SELECT LAST_INSERT_ID();");
	$r0 = $db0->fetch_assoc();
	$meetingID = $r0['LAST_INSERT_ID()'];
	
	for ($i=1;$i<=$_POST['count'];$i++) {
		$tID = $_POST['tID_'.$i];
		$reason = mysql_escape_string($_POST['reason_'.$tID]);
		$suggestion = mysql_escape_string($_POST['suggestion_'.$tID]);
		$tracking = mysql_escape_string($_POST['tracking_'.$tID]);
		$db = new DB;
		$db->query("INSERT INTO `sixtarget_analysis` VALUES ('', '".$meetingID."','".$tID."','".$reason."','".$suggestion."','".$tracking."')");
	}
	
	echo '<script>window.location.href="index.php?mod=management&func=formview&id=3&view='.$_GET['type'].$sMonth.'"</script>';
}

$mID = mysql_escape_string($_GET['mID']);
$db = new DB;
$db->query("SELECT * FROM `sixtarget_meeting` WHERE `meetingID`='".$mID."'");
$r = $db->fetch_assoc();
?>
<form method="post">
<table>
  <tr>
    <td class="title" width="120" style="border-top-left-radius:10px;">Date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo ($r['date']=="" ? date(Y."/".m."/".d):$r['date']); ?>" size="12"></td>
    <td class="title" width="120">Time</td>
    <td style="border-top-right-radius:10px;">
    <select name="timeH" id="timeH">
          <option></option>
          <?php
		  for ($i2a=0;$i2a<=23;$i2a++) { 
		  	echo '<option value="'.(strlen($i2a)==1?'0':'').$i2a.'" '.(date(H)==$i2a?" selected":"").'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>';
		  }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" selected>00</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>
        </select></td>
  </tr>
  <tr>
    <td class="title">Location</td>
    <td colspan="3"><input type="text" name="location" id="location" value="<?php echo $r['location']; ?>" size="80"></td>
  </tr>
  <tr>
    <td class="title">Moderator</td>
    <td colspan="3"><input type="text" name="host" id="host" value="<?php echo $r['host']; ?>" size="80"></td>
  </tr>
  <tr>
    <td class="title">Attendance</td>
    <td colspan="3"><textarea name="member" id="member" cols="80" rows="6"><?php echo $r['member']; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr class="title">
    <td>Full name</td>
    <td>Cause reason analysis</td>
    <td>Improvements</td>
    <td>Follow up tracking</td>
  </tr>
  <?php
	  foreach ($_POST['targetList_'.$_GET['type']] as $k=>$v) {
		  $count++;
		  if ($_GET['type']==5 || $_GET['type']==8) {
			  $arrData = explode("-",$v);
			  $HospNo = $arrData[0];
		  } else {
			   $db1 = new DB;
			  $db1->query("SELECT `HospNo` FROM `sixtarget_part".$_GET['type']."` WHERE `targetID`='".$v."'");
			  $r1 = $db1->fetch_assoc();
			  $HospNo = $r1['HospNo'];
		  }
		 
		  echo '
	  <tr>
		<td class="title_s">'.getPatientName(getPID($HospNo)).'<input type="hidden" name="tID_'.$count.'" id="tID_'.$v.'" value="'.$v.'"></td>
		<td><textarea name="reason_'.$v.'" cols="36" rows="3"></textarea></td>
		<td><textarea name="suggestion_'.$v.'" cols="36" rows="3"></textarea></td>
		<td><textarea name="tracking_'.$v.'" cols="36" rows="3"></textarea></td>
	  </tr>
		  '."\n";
	  }
  ?>
  <tr>
    <td colspan="4" style="border-bottom-left-radius:10px; border-bottom-right-radius:10px;"><center><input type="hidden" name="count" id="count" value="<?php echo count($_POST['targetList_'.$_GET['type']]); ?>"><input type="submit" name="save" id="save" value="Save"></center></td>
  </tr>
</table>
</form>
</div>