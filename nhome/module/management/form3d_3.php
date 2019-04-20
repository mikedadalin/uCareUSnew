<?php
$mID = mysql_escape_string($_GET['mID']);
$arrTargetType = array("", "Hospitalization", "約束", "跌倒", "Infection", "Pressure ulcer(s)", "", "Nasogastric tube remove", "Catheter remove");
$qdate = mysql_escape_string($_GET['qdate']);
$sMonth = ($qdate == "" ? "" : "&qdate=".$qdate);
?>
<h3><?php echo $arrTargetType[$_GET['type']]; ?>原因分析與改善措施(Case-by-case analysis)</h3>

<?php
echo '<a href="print.php?'.$_SERVER['QUERY_STRING'].'" target="_blank" class="printcol"><img src="Images/print.png" border="0"></a>';
if (isset($_POST['save'])) {
	$db = new DB;
	$strSQL = "UPDATE `sixtarget_meeting` SET `date`= '".mysql_escape_string($_POST['date'])."', ";
	$strSQL .="`time`='".mysql_escape_string($_POST['timeH']).':'.$_POST['timeI'].':00'."', ";
	$strSQL .="`location`='".mysql_escape_string($_POST['location'])."', `host`='".mysql_escape_string($_POST['host'])."', ";
	$strSQL .="`member`='".mysql_escape_string($_POST['member'])."' WHERE `meetingID`='".$mID."'";
	$db->query($strSQL);
	foreach ($_POST as $k=>$v) {
		$arrAnalysis = explode("_",$k);
		if (count($arrAnalysis)==2) {
			$db1 = new DB;
			$db1->query("UPDATE `sixtarget_analysis` SET `".$arrAnalysis[0]."`='".$v."' WHERE `analysisID`='".$arrAnalysis[1]."'");
		}
	}	
	echo '<script>window.location.href="index.php?mod=management&func=formview&id=3d_1&type='.$_GET['type'].$sMonth.'"</script>';
}

$db = new DB;
$db->query("SELECT * FROM `sixtarget_meeting` WHERE `meetingID`='".$mID."'");
$r = $db->fetch_assoc();
?>
<form method="post">
<table width="100%">
  <tr>
    <td class="title" width="120">Date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo ($r['date']==""?date("Y/m/d"):str_replace("-","/",$r['date'])); ?>" size="12"></td>
    <td class="title" width="120">Time</td>
    <td>
    <select name="timeH" id="timeH">
          <option></option>
          <?php
  		  $H = substr($r['time'],0,2);
		  $S = substr($r['time'],3,2);
		  for ($i2a=0;$i2a<=23;$i2a++) { 
		    $select = (($H==""?date(H):$H)==$i2a?" selected":"");	
		  	echo '<option value="'.(strlen($i2a)==1?'0':'').$i2a.'" '.$select.'>'.(strlen($i2a)==1?'0':'').$i2a.'</option>'; 
		  }
		  ?>
        </select>：<select name="timeI" id="timeI">
          <option></option>
          <option value="00" <?php echo (($S==""?"00":$S)=="00"?" selected":"");?>>00</option>
          <option value="15" <?php echo (($S==""?"00":$S)=="15"?" selected":"");?>>15</option>
          <option value="30" <?php echo (($S==""?"00":$S)=="30"?" selected":"");?>>30</option>
          <option value="45" <?php echo (($S==""?"00":$S)=="45"?" selected":"");?>>45</option>
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
    <td colspan="3"><textarea name="member" id="member" rows="8"><?php echo $r['member']; ?></textarea></td>
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
	$db1 = new DB;
	$db1->query("SELECT * FROM `sixtarget_analysis` WHERE `meetingID`='".$r['meetingID']."'");
	if($db1->num_rows() > 0){
		for($i1=0;$i1<$db1->num_rows();$i1++){
			$r1 = $db1->fetch_assoc();
			if ($r['targetType']==5 || $r['targetType']==8) {
				$arrData = explode("-",$r1['targetID']);
				$HospNo = $arrData[0];
			} else {
				$db1a = new DB;
				$db1a->query("SELECT `HospNo` FROM `sixtarget_part".$r['targetType']."` WHERE `targetID`='".$r1['targetID']."'");
				$r1a = $db1a->fetch_assoc();
				$HospNo = $r1a['HospNo'];
			}
	  echo '
	  <tr>
		<td class="title_s">'.getPatientName(getPID($HospNo)).'</td>
		<td><textarea name="reason_'.$r1['analysisID'].'" id="reason_'.$r1['analysisID'].'" cols="36" rows="3">'.$r1['reason'].'</textarea></td>
		<td><textarea name="suggestion_'.$r1['analysisID'].'" id="suggestion_'.$r1['analysisID'].'" cols="36" rows="3">'.$r1['suggestion'].'</textarea></td>
		<td><textarea name="tracking_'.$r1['analysisID'].'" id="tracking_'.$r1['analysisID'].'" cols="36" rows="3">'.$r1['tracking'].'</textarea></td>
	  </tr>
	  '."\n";
		}
	}
  ?>
  <tr class="printcol">
    <td colspan="4"><center><input type="button" onClick="window.location.href='index.php?mod=management&func=formview&type=<?php echo $_GET['type'];?>&id=3d_1<?php echo $sMonth;?>';" value="回<?php echo $arrTargetType[$_GET['type']]; ?>逐案分析列表" /><input type="submit" name="save" id="save" value="Save"></center></td>
  </tr>
</table>
</form>