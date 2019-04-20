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
    <td align="center" bgcolor="#ffffff"><a href="index.php?mod=nurseform&func=formview&pid=<?php echo mysql_escape_string($_GET['pid']); ?>&id=16"><img src="Images/back_button.png"></a></td>
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
$db3->query("SELECT * FROM `nurseform16` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'");
$r3 = $db3->fetch_assoc();
?>
<table border="0" style="text-align:left; padding-left:20px;">
  <tr>
    <td>
    <h3>Confirm deletion of this data?</h3>
    <div class="content-query">
    <table width="100%">
      <tr class="title">
        <td>Appointment/visit date</td>
        <td>Visiting hospital</td>
        <td>Medical reasons</td>
        <td>Clinic classification (Emergency / Outpatient)</td>
        <td>Medical treatment</td>
      </tr>
      <?php
foreach ($r3 as $k=>$v) { $arrPatientInfo = explode("_",$k); if (count($arrPatientInfo)==2) { if ($v==1) { ${$arrPatientInfo[0]} .= $arrPatientInfo[1].';'; } } else { ${$k} = $v; } }
	$Q2 = explode(';',$Q2);
	$Q4 = explode(';',$Q4);
	echo '
  <tr>
    <td>'.$Q1.'</td>
    <td>';
	for ($i=1;$i<=20;$i++) {
		if (in_array($i, $Q2)) {
			$db2 = new DB2;
			$db2->query("SELECT `Hosp".$i."` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
			$r2 = $db2->fetch_assoc();
			if ($Hosp!="") { $Hosp .= '、'; }
			$Hosp .= $r2['Hosp'.$i];
		}
	}
	
	//$Hosp = substr($Hosp,0,strlen($Hosp)-6);
	echo $Hosp.'
	</td>
    <td>'.$Q3.'</td>
    <td>';
	$Emg = "";
	foreach ($Q4 as $k1=>$v1) { if ($v1!="") $Emg .= $arrForm16_Q4[$v1].'、'; };
	$Emg = substr($Emg,0,strlen($Emg)-3);
	echo $Emg.'</td>
    <td>'.$Q5.'</td>
  </tr>
</table>'."\n";
	?>
    <form action="index.php?func=databaseAI" method="post">
    <input type="hidden" id="formID" name="formID" value="nurseform16">
    <input type="hidden" id="nID" name="nID" value="<?php echo $_GET['nID']; ?>">
    <input type="hidden" id="action" name="action" value="delete">
    <input type="submit" value="Confirm deletation"> 
    </form>
    </div>
    </td>
  </tr>
</table>