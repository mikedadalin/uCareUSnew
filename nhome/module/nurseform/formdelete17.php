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
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=4;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div class="content-query">
<table align="center">
  <tr>
    <td align="center" bgcolor="#ffffff"><a href="index.php?mod=nurseform&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=17"><img src="Images/back_button.png"></a></td>
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

<?php
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform17` WHERE `drugID`='".mysql_escape_string($_GET['dID'])."' AND `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_GET['date'])."'");
$r3 = $db3->fetch_assoc();
?>
<table border="0" style="text-align:left; padding-left:20px;">
  <tr>
    <td>
    <h3>Confirm deletion of this data?</h3>
    <div class="content-query">
    <table width="100%">
      <tr class="title">
        <td>Date</td>
        <td>Time</td>
        <td>Medication</td>
        <td>Dose</td>
        <td>Frequency</td>
        <td>Pathway</td>
      </tr>
      <?php
      foreach ($r3 as $k=>$v) { ${$k} = $v; }
	  echo '
  <tr>
    <td>'.$Qstartdate.'~'.$Qenddate.' ('.calcperiod(str_replace('/','',$Qstartdate),str_replace('/','',$Qenddate)).'Day(s))</td>
	<td>---</td>
    <td>'.$Qmedicine.'</td>
    <td>'.$Qdose.$Qdoseq.'</td>
    <td>'.$Qfreq.'</td>
    <td>'.$Qway.'</td>
  </tr>
</table>'."\n";
	?>
    <form action="index.php?func=database&action=delete" method="post">
    <input type="hidden" id="formID" name="formID" value="nurseform17">
    <input type="hidden" id="HospNo" name="HospNo" value="<?php echo $HospNo; ?>">
    <input type="hidden" id="date" name="date" value="<?php echo $r3['date']; ?>">
    <input type="hidden" id="drugID" name="drugID" value="<?php echo @$_GET['dID']; ?>">
    <input type="submit" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>