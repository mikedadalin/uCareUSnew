<?php
$arrAreaList = array();
$arrAreaPatientList = array();
$db = new DB;
$db->query("SELECT * FROM `areainfo`");
for ($i1=0;$i1<$db->num_rows();$i1++) {
	$r = $db->fetch_assoc();
	$db1a = new DB;
	$db1a->query("SELECT * FROM `bedinfo` WHERE `Area`='".$r['areaID']."'");
	array_push($arrAreaList, $r['areaID']);
	$arrAreaPatientList[$r['areaID']] = array();
	for ($i2=0;$i2<$db1a->num_rows();$i2++) {
		$r1a = $db1a->fetch_assoc();
		$db1b = new DB;
		$db1b->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$r1a['bedID']."'");
		$r1b = $db1b->fetch_assoc();
		if ($r1b['patientID']!="") {
			array_push($arrAreaPatientList[$r['areaID']], $r1b['patientID']);
		}
	}
}
?>
<div class="patlistbtnlist printcol">
    <div class="patlistbtn"><a href="print.php?mod=management&func=formview&id=21&view=1" target="_blank"><i class="fa fa-print fa-2x"></i><br>Print</a></div>
</div>
<h3><?php echo date(Y).' Year '.date(m).'th Month '; ?>Residents name list</h3>
<table width="100%" id="form21table">
  <thead>
  <tr class="title">
    <td>Resident name</td>
    <td>Gender</td>
    <td>DOB</td>
    <td>Age</td>
    <td>Social Security number</td>
  </tr>
  </thead>
<?php
foreach ($arrAreaList as $k1=>$v1) {
    $AreaPatientList = $arrAreaPatientList[$v1];
    foreach ($AreaPatientList as $k2=>$v2) {
        //$v1 區域ID
        //$v2 PID
        $pInfo = getPatientInfo($v2);
        echo '
  <tr>
    <td>'.$pInfo['Name'].'</td>
    <td>'.checkgender($v2).'</td>
    <td>'.formatdate($pInfo['Birth'], 2).'</td>
    <td>'.calcagenum($pInfo['Birth']).'</td>
    <td>'.$pInfo['IdNo'].'</td>
  </tr>
        '."\n";
    }
}
?>
</table>