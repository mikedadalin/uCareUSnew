<?php
$db = new DB;
$db->query("SELECT `patientID`,`Birth`,`HospNo` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=4;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div class="content-query">
<table align="center">
  <tr>
    <td align="center" bgcolor="#ffffff"><a href="index.php?mod=socialwork&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=19"><img src="Images/back_button.png"></a></td>
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
$db3->query("SELECT * FROM `socialform19` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'");
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
        <td>個案問題</td>
        <td>診斷分析</td>
        <td>處遇計畫</td>
        <td>Execution</td>
        <td>評估與結案</td>
      </tr>
      <tr>
        <td><?php echo $r3['date']; ?></td>
        <td><?php echo $r3['Q1']; ?></td>
        <td><?php echo $r3['Q2']; ?></td>
        <td><?php echo $r3['Q3']; ?></td>
        <td><?php echo $r3['Q4']; ?></td>
        <td><?php echo $r3['Q5']; ?></td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
</table>
    <form action="index.php?func=databaseAI" method="post">
    <input type="hidden" id="formID" name="formID" value="socialform19">
    <input type="hidden" id="nID" name="nID" value="<?php echo $_GET['nID']; ?>">
    <input type="hidden" id="action" name="action" value="delete">
    <input type="submit" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>