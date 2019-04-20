<?php
if (@$_GET['date']==NULL) {
	$d = new DateTime();
	$dlw = new DateTime();
	$dnw = new DateTime();
} else {
	$getdate = str_replace("/","-",formatdate(@$_GET['date']));
	$d = new DateTime($getdate);
	$dlw = new DateTime($getdate);
	$dnw = new DateTime($getdate);
}

$weekday = $d->format('w');
$diff = ($weekday == 0 ? 6 : $weekday) - 1; // Monday=0, Sunday=6
$d->modify("-$diff day"); $d1 = $d->format('Y/m/d'); $sd1 = $d->format('m/d'); $td1 = $d->format('Ymd');
$d->modify('+1 day'); $d2 =  $d->format('Y/m/d'); $sd2 = $d->format('m/d'); $td2 = $d->format('Ymd');
$d->modify('+1 day'); $d3 =  $d->format('Y/m/d'); $sd3 = $d->format('m/d'); $td3 = $d->format('Ymd');
$d->modify('+1 day'); $d4 =  $d->format('Y/m/d'); $sd4 = $d->format('m/d'); $td4 = $d->format('Ymd');
$d->modify('+1 day'); $d5 =  $d->format('Y/m/d'); $sd5 = $d->format('m/d'); $td5 = $d->format('Ymd');
$d->modify('+1 day'); $d6 =  $d->format('Y/m/d'); $sd6 = $d->format('m/d'); $td6 = $d->format('Ymd');
$d->modify('+1 day'); $d7 =  $d->format('Y/m/d'); $sd7 = $d->format('m/d'); $td7 = $d->format('Ymd');

$dlw->modify('-7 day'); $lastweek = $dlw->format('Ymd');
$dnw->modify('+7 day'); $nextweek = $dnw->format('Ymd');

$db_area = new DB;
$db_area->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
$arrArea = array();
for ($i=0;$i<$db_area->num_rows();$i++) {
	$r_area = $db_area->fetch_assoc();
	$arrArea[$r_area['areaID']] = $r_area['areaName'];
}

$arrShift = array("A"=>"D", "B"=>"8-17", "C"=>"N", "D"=>"OFF", "E"=>"C+H", "F"=>"CHEF", "G"=>"KH", "H"=>"K");

$db1 = new DB;
$db1->query("SELECT * FROM `foreignemployer` WHERE `position` LIKE '%照服%' ORDER BY `foreignID` ASC");
$arrForeignName = array();
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$ForeignID = (int) $r1['foreignID'];
	$arrForeignName[$ForeignID] = $r1['cNickname'].' '.$r1['eNickname'];
}

$db1 = new DB;
$db1->query("SELECT * FROM `employer` WHERE `Position` LIKE '%照服%' OR `Position` LIKE '%護佐%' OR `Position` LIKE '%護士%' OR `Position` LIKE '%Nursing%' ORDER BY `EmpID` ASC");
$arrEmpName = array();
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$arrEmpName[$r1['EmpID']] = $r1['Name'];
}
?>
<div class="nurseform-table">
<h3>Weekly shift duty list (<?php echo $d1; ?> ~ <?php echo $d7; ?>)</h3>
<table width="100%">
  <tr class="title">
    <td colspan="8"><input type="button" onclick="window.location.href='index.php?func=schedulelist&date=<?php echo $lastweek; ?>#tabs-2'" value="previous week"> <input type="button" onclick="window.location.href='index.php?func=schedulelist'" value="Back to this week"> <input type="button" onclick="window.location.href='index.php?func=schedulelist&date=<?php echo $nextweek; ?>#tabs-2'" value="Next week"></td>
  </tr>
</table>
  <?php
  foreach ($arrArea as $areaID => $areaName) {
	  echo '<h3>'.$areaName.'</h3>';
  ?>
<table width="100%">
  <tr class="title">
    <td><?php echo $sd1; ?> (一)</td>
    <td><?php echo $sd2; ?> (二)</td>
    <td><?php echo $sd3; ?> (三)</td>
    <td><?php echo $sd4; ?> (四)</td>
    <td><?php echo $sd5; ?> (五)</td>
    <td><?php echo $sd6; ?> (六)</td>
    <td><?php echo $sd7; ?> (日)</td>
  </tr>
  <tr>
  <?php
  $db3a = new DB;
  $db3a->query("SELECT * FROM `employer_shift` WHERE `date`='".$td1."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3a = array();
  for ($i=0;$i<$db3a->num_rows();$i++) { $r3a = $db3a->fetch_assoc(); $arrDB3a[$r3a['shift']][] = $r3a['EmpID']; }
  $db4a = new DB;
  $db4a->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td1."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4a = array();
  for ($i=0;$i<$db4a->num_rows();$i++) { $r4a = $db4a->fetch_assoc(); $arrDB4a[$r4a['shift']][] = $r4a['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
        <td valign="middle" class="title_s" width="30"><b><?php echo $value; ?></b></td>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3a[$key])>0) { foreach ($arrDB3a[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4a['A'])>0) { foreach ($arrDB4a[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  <?php
  $db3b = new DB;
  $db3b->query("SELECT * FROM `employer_shift` WHERE `date`='".$td2."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3b = array();
  for ($i=0;$i<$db3b->num_rows();$i++) { $r3b = $db3b->fetch_assoc(); $arrDB3b[$r3b['shift']][] = $r3b['EmpID']; }
  $db4b = new DB;
  $db4b->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td2."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4b = array();
  for ($i=0;$i<$db4b->num_rows();$i++) { $r4b = $db4b->fetch_assoc(); $arrDB4b[$r4b['shift']][] = $r4b['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3b[$key])>0) { foreach ($arrDB3b[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4b['A'])>0) { foreach ($arrDB4b[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  <?php
  $db3c = new DB;
  $db3c->query("SELECT * FROM `employer_shift` WHERE `date`='".$td3."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3c = array();
  for ($i=0;$i<$db3c->num_rows();$i++) { $r3c = $db3c->fetch_assoc(); $arrDB3c[$r3c['shift']][] = $r3c['EmpID']; }
  $db4c = new DB;
  $db4c->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td3."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4c = array();
  for ($i=0;$i<$db4c->num_rows();$i++) { $r4c = $db4c->fetch_assoc(); $arrDB4c[$r4c['shift']][] = $r4c['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3c[$key])>0) { foreach ($arrDB3c[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4c['A'])>0) { foreach ($arrDB4c[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  <?php
  $db3d = new DB;
  $db3d->query("SELECT * FROM `employer_shift` WHERE `date`='".$td4."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3d = array();
  for ($i=0;$i<$db3d->num_rows();$i++) { $r3d = $db3d->fetch_assoc(); $arrDB3d[$r3d['shift']][] = $r3d['EmpID']; }
  $db4d = new DB;
  $db4d->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td4."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4d = array();
  for ($i=0;$i<$db4d->num_rows();$i++) { $r4d = $db4d->fetch_assoc(); $arrDB4d[$r4d['shift']][] = $r4d['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3d[$key])>0) { foreach ($arrDB3d[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4d['A'])>0) { foreach ($arrDB4d[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  <?php
  $db3e = new DB;
  $db3e->query("SELECT * FROM `employer_shift` WHERE `date`='".$td5."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3e = array();
  for ($i=0;$i<$db3e->num_rows();$i++) { $r3e = $db3e->fetch_assoc(); $arrDB3e[$r3e['shift']][] = $r3e['EmpID']; }
  $db4e = new DB;
  $db4e->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td5."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4e = array();
  for ($i=0;$i<$db4e->num_rows();$i++) { $r4e = $db4e->fetch_assoc(); $arrDB4e[$r4e['shift']][] = $r4e['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3e[$key])>0) { foreach ($arrDB3e[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4e['A'])>0) { foreach ($arrDB4e[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  <?php
  $db3f = new DB;
  $db3f->query("SELECT * FROM `employer_shift` WHERE `date`='".$td6."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3f = array();
  for ($i=0;$i<$db3f->num_rows();$i++) { $r3f = $db3f->fetch_assoc(); $arrDB3f[$r3f['shift']][] = $r3f['EmpID']; }
  $db4f = new DB;
  $db4f->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td6."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4f = array();
  for ($i=0;$i<$db4f->num_rows();$i++) { $r4f = $db4f->fetch_assoc(); $arrDB4f[$r4f['shift']][] = $r4f['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3f[$key])>0) { foreach ($arrDB3f[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4f['A'])>0) { foreach ($arrDB4f[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  <?php
  $db3g = new DB;
  $db3g->query("SELECT * FROM `employer_shift` WHERE `date`='".$td7."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB3g = array();
  for ($i=0;$i<$db3g->num_rows();$i++) { $r3g = $db3g->fetch_assoc(); $arrDB3g[$r3g['shift']][] = $r3g['EmpID']; }
  $db4g = new DB;
  $db4g->query("SELECT * FROM `foreignemployer_shift` WHERE `date`='".$td7."' AND `area`='".$areaID."' ORDER BY `shift` ASC");
  $arrDB4g = array();
  for ($i=0;$i<$db4g->num_rows();$i++) { $r4g = $db4g->fetch_assoc(); $arrDB4g[$r4g['shift']][] = $r4g['foreignID']; }
  ?>
    <td>
    <table style="width:130px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D") {
	  ?>
      <tr>
		<td valign="middle" bgcolor="#ffffff"><?php if (count($arrDB3g[$key])>0) { foreach ($arrDB3g[$key] as $k1=>$v1) { echo $arrEmpName[$v1]."<br>\n"; } } ?><?php if (count($arrDB4g['A'])>0) { foreach ($arrDB4g[$key] as $k1=>$v1) { echo $arrForeignName[$v1]."<br>\n"; } } ?></td>
      </tr>
      <?php
		  }
	  }
	  ?>
    </table>
    </td>
  </tr>
</table>
  <?php
  }
  ?>