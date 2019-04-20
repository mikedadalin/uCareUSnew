<?php
function array_kshift(&$arr) {
  list($k) = array_keys($arr);
  $r  = array($k=>$arr[$k]);
  unset($arr[$k]);
  return $r;
}

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
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
foreach ($arrVital as $k=>$v) {
	${'arrVital'.$k} = array();
}
if (@$_GET['date']=="--Select month--") {
	$qdate = date(Ym);
} else {
	$qdate = $_GET['date'];
}

$arrVital = array();

for ($qDay=1;$qDay<=date('t', strtotime($qdate.'01'));$qDay++) {
	if ($qDay<10) { $qDay = '0'.$qDay; }
	$db = new DB;
	$db->query("SELECT * FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `date` = '".$qdate.$qDay."' ORDER BY `date` ASC,`time` ASC");
	if ($db->num_rows()==0) {
		$arrVital[$qDay.';'] = "";
	} else {
		for ($i=0;$i<$db->num_rows();$i++) {
			$r = $db->fetch_assoc();
			$day = (int) substr($r['date'],6,2);
			$time = substr($r['time'],0,2).":".substr($r['time'],2,2);
			foreach($r as $k=>$v){
				$arrVitalsign = explode("_",$k);
				if ($arrVitalsign[0]=="loinc" && $v!="") {
					$LoincCode = $arrVitalsign[1]."-".$arrVitalsign[2];
					$VitalName = 'arrVital'.$LoincCode;
					$arrVital[$day.';'.$time][$LoincCode] = $v;
				}
			}
			$arrVital[$day.';'.$time]['Qfiller'] = checkusername($r['Qfiller']);
		}
	}
}
foreach ($arrVital as $k=>$v) {
	$count++;
}

$ItemNo = 33;

$pn = ceil($count/($ItemNo*2));
for ($i1=0;$i1<$pn;$i1++) {
	if ($i1>0) {
		echo '<p style="page-break-before:always;">&nbsp;</p><center><h3>'.$_SESSION['nOrgName_lwj'].'</h3></center>';
	}
?>
<div class="content-query">
<table border="1" style="border-collapse:collapse;" width="1050">
  <tr id="backtr"  style="border:none;" height="40">
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title" width="60" style="border:none;">Full name</td>
    <td width="80" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none;">DOB</td>
    <td width="240" style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="80" style="border:none;">Admission date</td>
    <td width="*" style="border:none;"><?php echo $indate; ?></td>
  </tr>
</table>
</div>
<h3>Daily vital signs record- 
<?php
if (@$_GET['date']=="--Select month--") {
	echo date(Y).'/'.date(m);
} else {
	echo substr(@$_GET['date'],0,4).' '.getEnglishMonth(substr(@$_GET['date'],4,2));
}
?></h3>
<table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
  <tr>
    <td valign="top">
      <table border="1" style="border-collapse:collapse; text-align:center;" >
        <tr class="title" height="40">
          <td width="30" nowrap>Date</td>
          <td width="45" nowrap>Time</td>
          <td width="40" nowrap>Temperature</td>
          <td width="40" nowrap>Heartbeat/Pulse</td>
          <td width="40" nowrap>Respiration</td>
          <td width="70" nowrap>Blood pressure</td>
          <td width="40" nowrap>SpO2</td>
          <td width="50" nowrap>Pain</td>
          <td width="40" nowrap>AC<br />Blood glucose</td>
          <td width="40" nowrap>PC<br />Blood glucose</td>
          <td width="60" nowrap>Signature</td>
        </tr>
        <?php
		$countno = 0;
		while($countno<$ItemNo) {
			$arr1 = array_kshift($arrVital);
			foreach ($arr1 as $ka=>$va) {
				$arrDate = explode(";",$ka);
				echo '
		<tr height="40">
          <td nowrap>'.$arrDate[0].'</td>
          <td nowrap>'.$arrDate[1].'</td>';
		  if(is_array($va)){
		  echo '
          <td nowrap>'.$va['8310-5'].'</td>
          <td nowrap>'.$va['8867-4'].'</td>
          <td nowrap>'.$va['9279-1'].'</td>
          <td nowrap>'.$va['8480-6'].'/'.$va['8462-4'].'</td>
          <td nowrap>'.$va['2710-2'].'</td>
          <td nowrap>'.$va['46033-7'].'</td>
          <td nowrap>'.$va['14743-9'].'</td>
          <td nowrap>'.$va['15075-5'].'</td>
          <td nowrap><font size="2" color="#CCC">'.$va['Qfiller'].'</font></td>
        </tr>'."\n";
		  }else{
		  echo '
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap>&nbsp</td>
          <td nowrap><font size="2" color="#CCC">&nbsp</font></td>
        </tr>'."\n";
		  }
			}
			$countno++;
		}
		?>
        </table>
    </td>
    <td valign="top">
      <table border="1" style="border-collapse:collapse; text-align:center;" >
        <tr class="title" height="40">
          <td width="30" nowrap>Date</td>
          <td width="45" nowrap>Time</td>
          <td width="40" nowrap>Temperature</td>
          <td width="40" nowrap>Heartbeat/Pulse</td>
          <td width="40" nowrap>Respiration</td>
          <td width="70" nowrap>Blood pressure</td>
          <td width="40" nowrap>SpO2</td>
          <td width="50" nowrap>Pain</td>
          <td width="40" nowrap>AC<br />Blood glucose</td>
          <td width="40" nowrap>PC<br />Blood glucose</td>
          <td width="60" nowrap>Signature</td>
        </tr>
        <?php
		while($countno<($ItemNo*2)) {
			$arr1 = array_kshift($arrVital);
			foreach ($arr1 as $ka=>$va) {
				$arrDate = explode(";",$ka);
				echo '
		<tr height="40">
          <td nowrap>'.$arrDate[0].'</td>
          <td nowrap>'.$arrDate[1].'</td>
          <td nowrap>'.$va['8310-5'].'</td>
          <td nowrap>'.$va['8867-4'].'</td>
          <td nowrap>'.$va['9279-1'].'</td>
          <td nowrap>'.$va['8480-6'].'/'.$va['8462-4'].'</td>
          <td nowrap>'.$va['2710-2'].'</td>
          <td nowrap>'.$va['46033-7'].'</td>
          <td nowrap>'.$va['14743-9'].'</td>
          <td nowrap>'.$va['15075-5'].'</td>
          <td nowrap><font size="2" color="#CCC">'.$va['Qfiller'].'</font></td>
        </tr>
				'."\n";
			}
			$countno++;
		}
		?>
        </table>
    </td>
  </tr>
</table>
<?php
}
?>