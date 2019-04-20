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
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
?>
<div class="content-query">
<table border="1" style="border-collapse:collapse;" width="100%">
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
<?php
foreach ($arrVital as $k=>$v) {
	${'arrVital'.$k} = array();
}
if (@$_GET['date']=="--Select month--") {
	$qdate = date(Y).'-'.date(m);
} else {
	$qdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2);
}
?>
<h3>I/O daily record - 
<?php
if (@$_GET['date']=="--Select month--") {
	echo date(Y).' '.getEnglishMonth(date(m));
} else {
	echo substr(@$_GET['date'],0,4).' '.getEnglishMonth(substr(@$_GET['date'],4,2));
}
?></h3>
<!--$db = new DB;
$db->query("SELECT * FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate."%' ORDER BY `RecordedTime` DESC");-->
<table border="0" cellpadding="0" cellspacing="0" style="border:0px;" width="100%">
  <tr>
    <td valign="top">Date</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		echo '<td>'.$i.'</td>'."\n";
	}
	?>
  </tr>
  <tr>
    <td class="title">Total daily intake<br />I (Intake)</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		if (strlen($i)==1) { $i2 = '0'.$i; } else { $i2=$i; }
		$db = new DB;
		$db->query("SELECT `input` FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate.'-'.$i2."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			echo '<td>'.$r['input'].'</td>'."\n";
		} else {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
  </tr>
  <tr>
    <td class="title">Total daily output<br />O (Output)</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		if (strlen($i)==1) { $i2 = '0'.$i; } else { $i2=$i; }
		$db = new DB;
		$db->query("SELECT `output` FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate.'-'.$i2."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			echo '<td>'.$r['output'].'</td>'."\n";
		} else {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
  </tr>
  <tr>
    <td class="title">1. Stool<br />(STOOL)</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		if (strlen($i)==1) { $i2 = '0'.$i; } else { $i2=$i; }
		$db = new DB;
		$db->query("SELECT `output1` FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate.'-'.$i2."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			echo '<td>'.$r['output1'].'</td>'."\n";
		} else {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
  </tr>
  <tr>
    <td class="title">2. Number of other drainage tube<br />(Drain)</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		if (strlen($i)==1) { $i2 = '0'.$i; } else { $i2=$i; }
		$db = new DB;
		$db->query("SELECT `output2` FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate.'-'.$i2."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			echo '<td>'.$r['output2'].'</td>'."\n";
		} else {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
  </tr>
  <tr>
    <td class="title">3. Other<br />(Other)</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		if (strlen($i)==1) { $i2 = '0'.$i; } else { $i2=$i; }
		$db = new DB;
		$db->query("SELECT `output3` FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate.'-'.$i2."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			echo '<td>'.$r['output3'].'</td>'."\n";
		} else {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
  </tr>
  <tr>
    <td class="title">I-O = Daily<br />Positive and negative status</td>
    <?php
	for ($i=1;$i<=date(t,strtotime(substr(@$_GET['date'],0,4).'/'.substr(@$_GET['date'],4,2).'/01'));$i++) {
		if (strlen($i)==1) { $i2 = '0'.$i; } else { $i2=$i; }
		$db = new DB;
		$db->query("SELECT `iostatus` FROM `iostatus` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `RecordedTime` LIKE '".$qdate.'-'.$i2."%' ORDER BY `RecordedTime` DESC LIMIT 0,1");
		if ($db->num_rows()>0) {
			$r = $db->fetch_assoc();
			echo '<td>'.$r['iostatus'].'</td>'."\n";
		} else {
			echo '<td>&nbsp;</td>';
		}
	}
	?>
  </tr>
</table>