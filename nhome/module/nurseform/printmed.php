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
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<script>alert('請記得以「橫向」列印！');</script>
<center><?php echo substr(@$_GET['date'],0,4).' Year '.substr(@$_GET['date'],4,2); ?> 月給藥紀錄單</center><br />
<div class="content-query">
<table border="1" style="border-collapse:collapse;" width="1309">
  <tr id="backtr"  style="border:none;" height="40">
    <?php if (@$_GET['id']!=NULL) { echo '<td align="center" bgcolor="#ffffff" width="40" id="backbtn"  style="border:none;"><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'"><img src="Images/back_button.png"></a></td>'; } ?>
    <td class="title" width="60" style="border:none;">Full name</td>
    <td width="80" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="60" style="border:none;">DOB</td>
    <td width="180" style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
    <td class="title" width="80" style="border:none;">Admission date</td>
    <td width="80" style="border:none;"><?php echo $indate; ?></td>
  </tr>
</table>
</div>
<table border="1" style="border-collapse:collapse; text-align:center;" width="1309">
  <tr class="title" height="30">
    <td>Start</td>
    <td>Ends</td>
    <td>Medication (Dose)</td>
    <td width="48">Time</td>
    <?php
	echo drawmedcalwithtext();
	?>
  </tr>
  <?php
  $db = new DB;
  $db->query("SELECT * FROM `nurseform17` WHERE `HospNo`='".$HospNo."' AND `Qstartdate` LIKE '".substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2)."/%'");
  for ($i=0;$i<$db->num_rows();$i++) {
	  $bgday = "";
	  $r = $db->fetch_assoc();
	  $time = explode(';',$r['Qmedtime']);
	  $rowspan = count($time);
	  $startday = substr($r['Qstartdate'],8,2);
	  $endday = substr($r['Qenddate'],8,2);
	  for ($starti=$startday;$starti<=$endday;$starti++) {
		  $bgday .= $starti.';';
	  }
	  echo '
  <tr height="24">
	<td rowspan="'.$rowspan.'">'.substr($r['Qstartdate'],5,5).'</td>
    <td rowspan="'.$rowspan.'">'.substr($r['Qenddate'],5,5).'</td>
    <td rowspan="'.$rowspan.'">'.$r['Qmedicine'].'<br>('.$r['Qdose'].$r['Qdoseq'].') '.$r['Qway'].', '.$r['Qfreq'].'</td>
    <td>'.$time[0].'</td>'.drawmedcal($bgday,$r['Qmedday']).'
  </tr>'."\n";
    for ($t1=1;$t1<count($time);$t1++) {
		echo '
  <tr height="24">
    <td>'.$time[$t1].'</td>'.drawmedcal($bgday,$r['Qmedday']).'
  </tr>'."\n";
	}
  }
  ?>
  <tr height="20">

    <td colspan="3" rowspan="6" class="title">Nursing staff signature</td>
    <td  class="title">Day shift</td>

    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title"><font size="1">不良反應</font></td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title">Night shift</td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title"><font size="1">不良反應</font></td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title">Graveyard shift</td>
    <?php echo drawmedcal('',''); ?>
  </tr>
  <tr height="20">
    <td  class="title"><font size="1">不良反應</font></td>
    <?php echo drawmedcal('',''); ?>
  </tr>
</table><br>
Abbreviation: Not through mouth-NPO　Refuse - Ref　Outgoing - Out　睡眠 - Slp　Shortage of drug -A　不良反應 - O/X　Other-＊ (Noted in Nursing records)