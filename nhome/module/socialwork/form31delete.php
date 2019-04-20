<?php
$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4` FROM `nurseform01` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=4;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
if (isset($_POST['submit_delete'])) {
	$db1 = new DB;
	$db1->query("DELETE FROM `socialform31` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `time`='".mysql_escape_string($_POST['time'])."'");
	echo '<script>window.location.href=\'index.php?mod=socialwork&func=formview&pid='.getPID($_POST['HospNo']).'&id=31\';</script>';
}
?>
<div class="content-query">
<table align="center">
  <tr>
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff"><a href="index.php?mod=socialwork&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title">Full name</td>
    <td><?php echo $name; ?></td>
    <td class="title">DOB</td>
    <td><?php echo $birth.' ('.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title">Admission date</td>
    <td><?php echo $indate; ?></td>
    <td class="title">Diagnosis</td>
    <td><?php echo $diagMsg; ?></td>
  </tr>
</table>
</div>
<table border="0" style="text-align:left; padding-left:20px;">
  <tr>
    <td>
    <h3>Confirm deletion of this data?</h3>
    <?php
	$db3 = new DB;
	$db3->query("SELECT * FROM `socialform31` WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."' AND `time`='".mysql_escape_string($_GET['time'])."'");
	$r3 = $db3->fetch_assoc();
	?>
    <div class="content-query">
    <table width="100%">
      <tr>
        <td class="title" width="120">Date</td>
        <td><?php echo formatdate(@$_GET['date']).' '.@$_GET['time']; ?></td>
      </tr>
      <tr>
        <td class="title">Reason for notification</td>
        <td><?php echo $r3['Q2'].'# '.$arrNursediag[$r3['Q2']]; ?></td>
      </tr>
      <tr>
        <td class="title">Notification results</td>
        <td><?php echo $r3['Qcontent']; ?></td>
      </tr>
    </table>
    <form action="index.php?mod=socialwork&func=form31delete" method="post">
    <input type="hidden" id="formID" name="formID" value="socialform31">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $HospNo; ?>">
    <input type="hidden" id="date" name="date" value="<?php echo @$_GET['date']; ?>">
    <input type="hidden" id="time" name="time" value="<?php echo @$_GET['time']; ?>">
    <input type="submit" name="submit_delete" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>