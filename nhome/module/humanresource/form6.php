<script>
$(function() {
	<?php if (@$_GET['view']==NULL) { ?>
		$( "#tabs" ).tabs();
	<?php } else { ?>
		$( "#tabs" ).tabs({ active: <?php echo (@$_GET['view']); ?> });
	<?php } ?>
    <?php if (@$_GET['group']==NULL) { ?>
		$( "#tabs2" ).tabs();
	<?php } else { ?>
		$( "#tabs2" ).tabs({ active: <?php echo (@$_GET['group']-1); ?> });
	<?php } ?>
});
</script>
<?php
if (isset($_POST['saveshift'])) {
	
	foreach ($_POST as $k=>$v) {
		$area = "";
		$shift = "";
		if ($k!='searchmonth1' && $k!='saveshift' && substr($k,0,4)!="memo") {
			$arrVariable = explode("_",$k);
			//print_r($arrVariable);
			//employer_1_9_area_20140512
			$group = $arrVariable[1];
			if ($group==1) { $table = "employer"; $fieldname = "EmpID"; } elseif ($group==2) { $table = "foreignemployer"; $fieldname = "foreignID"; }
			$personID = $arrVariable[2];
			$date = $arrVariable[4];
			if ($arrVariable[3] == "area") { $area = $v; } elseif ($arrVariable[3] == "shift") { $shift = $v; }
			if ($area!="" || $shift!="") {
					$dbc = new DB;
					//echo "SELECT * FROM `".$table."_shift` WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'";
					$dbc->query("SELECT * FROM `".$table."_shift` WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
					if ($dbc->num_rows()==0) {
						$dbn = new DB;
						$dbn->query("INSERT INTO `".$table."_shift` VALUES ('".$personID."', '".$date."', '', '');");
					}
			}
			$dbc1 = new DB;
			$dbc1->query("SELECT * FROM `".$table."_shift` WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
			if ($arrVariable[3] == "area") {
				if ($area!="" || $shift!="" || $dbc1->num_rows()>0) {
					$dbu = new DB;
					$dbu->query("UPDATE `".$table."_shift` SET `area`='".$area."'  WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
				}
			} elseif ($arrVariable[3] == "shift") {
				$dbu = new DB;
				$dbu->query("UPDATE `".$table."_shift` SET `shift`='".$shift."'  WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
			}
		} elseif (substr($k,0,4)=="memo") {
			$arrVariable = explode("_",$k);
			$db3b = new DB;
			$db3b->query("SELECT * FROM `shift_memo` WHERE `date`='".$arrVariable[1]."'");
			if ($db3b->num_rows()==0) {
				if ($v!="") {
					$db3b = new DB;
					$db3b->query("INSERT INTO `shift_memo` VALUES ('".$arrVariable[1]."', '".$v."');");
				}
			} else {
				$db3b = new DB;
				$db3b->query("UPDATE `shift_memo` SET `text`='".$v."' WHERE `date`='".$arrVariable[1]."'");
			}
		}
	}
} elseif (isset($_POST['saveshift2'])) {
	foreach ($_POST as $k=>$v) {
		$area = "";
		$shift = "";
		if ($k!='searchmonth2' && $k!='saveshift2' && substr($k,0,4)!="memo") {
			$arrVariable = explode("_",$k);
			//employer_1_9_area_20140512
			$group = $arrVariable[1];
			if ($_GET['group']==1) { $table = "employer"; $fieldname = "EmpID"; } elseif ($_GET['group']==2) { $table = "foreignemployer"; $fieldname = "foreignID"; }
			$personID = $arrVariable[2];
			$date = $arrVariable[4];
			if ($arrVariable[3] == "area") { $area = $v; } elseif ($arrVariable[3] == "shift") { $shift = $v; }
			if ($area!="" || $shift!="") {
					$dbc = new DB;
					$dbc->query("SELECT * FROM `".$table."_shift2` WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
					if ($dbc->num_rows()==0) {
						$dbn = new DB;
						$dbn->query("INSERT INTO `".$table."_shift2` VALUES ('".$personID."', '".$date."', '', '');");
					}
			}
			$dbc1 = new DB;
			$dbc1->query("SELECT * FROM `".$table."_shift2` WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
			if ($arrVariable[3] == "area") {
				if ($area!="" || $shift!="" || $dbc1->num_rows()>0) {
					$dbu = new DB;
					$dbu->query("UPDATE `".$table."_shift2` SET `area`='".$area."'  WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
				}
			} elseif ($arrVariable[3] == "shift") {
				$dbu = new DB;
				$dbu->query("UPDATE `".$table."_shift2` SET `shift`='".$shift."'  WHERE `".$fieldname."`='".$personID."' AND `date`='".$date."'");
			}
		}
	}
}
?>
<div id="tabs" style="width:100%;" align="center">
  <ul>
    <li><a href="#tabs-1">Shift scheduling</a></li>
    <!--<li><a href="#tabs-2">樓層周班表</a></li>-->
    <li><a href="#tabs-3">Location setting of duty list</a></li>
    <li><a href="#tabs-4">Name list setting</a></li>
    <li><a href="#tabs-5">Shuttle location setup</a></li>
    <li><a href="#tabs-6">Group setting</a></li>
	<li><a href="#tabs-7">Primary duty nurse setting</a></li>
    <li><a href="#tabs-8">Shift duration setting</a></li>
    <?php if ($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01") { ?><li><a href="#tabs-9">Transferred shift schedule</a></li><?php } ?>
  </ul>
  <div id="tabs-1">
<?php
if (@$_GET['date']==NULL) {
	$getdate = date("Y-m-d");
	$arrDates = getdays($getdate);
} else {
	$getdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2).'-'.substr(@$_GET['date'],6,2);
	$arrDates = getdays($getdate);
}

$d = new DateTime($arrDates[0]);
$dlw = new DateTime($arrDates[0]);
$dnw = new DateTime($arrDates[0]);

$d->modify("+0 day"); $d1 = $d->format('Y/m/d'); $sd1 = $d->format('m/d'); $td1 = $d->format('Ymd');
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

//$arrShift = array("A"=>"D", "B"=>"8-12", "C"=>"8-13", "D"=>"8-17", "E"=>"E", "F"=>"N", "G"=>"OFF", "H"=>"off", "I"=>"ALL", "J"=>"L", "K"=>"C+H", "L"=>"CHEF", "M"=>"KH", "L"=>"N");
$dbShift = new DB;
$dbShift->query("SELECT * FROM `shift` ORDER BY `shiftid`");
$arrShift = array();
for ($i=0;$i<$dbShift->num_rows();$i++) {
	$r_shift = $dbShift->fetch_assoc();
	$arrShift[$r_shift['shiftid']] = $r_shift['name'];
}
?>
<h3>Weekly shift duty list (<?php echo $d1; ?> ~ <?php echo $d7; ?>)</h3>
<div align="right"><form>
<select id="selmonth">
    <option>--Select month--</option>
    <?php
    for ($i=date(m);$i>=(date(m)-5);$i--) {
        $month = $i;
        $year = date(Y);
        if ($i<1) {
            $month = 12+$i;
            $year = date(Y)-1;
        }
        if (strlen($month)==1) {
            $month = "0".$month;
        }
        echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
    }
    ?>
</select><input type="button" onclick="window.open('printshift1.php?date='+document.getElementById('selmonth').value)" value="Print monthly schedule">
<input type="button" onclick="window.open('printshifttraffic.php?date=<?php echo @$_GET['date']; ?>')" value="Print Shuttle vehicle schedule"> <input type="button" onclick="window.open('printshift.php?date=<?php echo @$_GET['date']; ?>')" value="Print weekly schedule"></form></div>
<div align="left" style="margin:10px auto;">
<?php
$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group` ORDER BY `GroupID` ASC");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}
?>
Select group:
<script>
function onchangeviewgroup(groupid) {
	window.location.href='index.php?mod=humanresource&func=formview&id=6&group='+groupid+'&date=<?php echo $_GET['date']; ?>';
}
</script>
<select onchange="onchangeviewgroup(this.options.selectedIndex)">
  <option></option>
  <?php
  foreach ($arrGroupName as $k3=>$v3) {
	  echo '<option value="'.$k3.'"';
	  if ($k3==@$_GET['group']) { echo ' selected'; }
	  echo '>'.$v3.'</option>';
  }
  ?>
</select>
</div>
<form action="index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo @$_GET['date']; ?>" method="post">
<table style="width:100%">
  <tr class="title">
    <td>Date</td>
	<td colspan="3"><script>$(function() { $('#searchmonth1').datepicker(); });</script><input type="text" size="10" name="searchmonth1" id="searchmonth1" value="<?php echo ($_GET['date']==""?date("Y/m/d"):formatdate($_GET['date'])); ?>"><input type="button" value="Search" onclick="window.location.href='<?php echo "index.php?mod=humanresource&func=formview&id=6&group=".$_GET['group']."&view=0&date="; ?>' + $('#searchmonth1').val().replace('/','').replace('/','')"></td>
    <td colspan="5"><input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $lastweek; ?>'" value="Previous week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>'" value="Back to current week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $nextweek; ?>'" value="Next week"></td>
  </tr>
  <tr class="title">
    <td>&nbsp;</td>
    <td <?php if (date('Y/m/d')==$d1) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd1; ?><br>(Mon)</td>
    <td <?php if (date('Y/m/d')==$d2) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd2; ?><br>(Tue)</td>
    <td <?php if (date('Y/m/d')==$d3) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd3; ?><br>(Wed)</td>
    <td <?php if (date('Y/m/d')==$d4) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd4; ?><br>(Thu)</td>
    <td <?php if (date('Y/m/d')==$d5) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd5; ?><br>(Fri)</td>
    <td <?php if (date('Y/m/d')==$d6) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd6; ?><br>(Sat)</td>
    <td <?php if (date('Y/m/d')==$d7) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd7; ?><br>(Sun)</td>
  </tr>
  <tr>
  <?php
  for ($i3=1;$i3<=7;$i3++) {
	  $db3a = new DB;
	  $db3a->query("SELECT * FROM `shift_memo` WHERE `date`='".${'td'.$i3}."'");
	  $r3a = $db3a->fetch_assoc();
	  ${'memo_'.$r3a['date']} = $r3a['text'];
  }
  ?>
    <td class="title">Comment<br />Item</td>
    <td <?php if (date('Y/m/d')==$d1) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td1; ?>" id="memo_<?php echo $td1; ?>" size="10" value="<?php echo ${'memo_'.$td1}; ?>" /></td>
    <td <?php if (date('Y/m/d')==$d2) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td2; ?>" id="memo_<?php echo $td2; ?>" size="10" value="<?php echo ${'memo_'.$td2}; ?>" /></td>
    <td <?php if (date('Y/m/d')==$d3) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td3; ?>" id="memo_<?php echo $td3; ?>" size="10" value="<?php echo ${'memo_'.$td3}; ?>" /></td>
    <td <?php if (date('Y/m/d')==$d4) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td4; ?>" id="memo_<?php echo $td4; ?>" size="10" value="<?php echo ${'memo_'.$td4}; ?>" /></td>
    <td <?php if (date('Y/m/d')==$d5) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td5; ?>" id="memo_<?php echo $td5; ?>" size="10" value="<?php echo ${'memo_'.$td5}; ?>" /></td>
    <td <?php if (date('Y/m/d')==$d6) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td6; ?>" id="memo_<?php echo $td6; ?>" size="10" value="<?php echo ${'memo_'.$td6}; ?>" /></td>
    <td <?php if (date('Y/m/d')==$d7) { echo 'bgcolor="#CCCCCC"'; } ?>><input type="text" name="memo_<?php echo $td7; ?>" id="memo_<?php echo $td7; ?>" size="10" value="<?php echo ${'memo_'.$td7}; ?>" /></td>
  </tr>
  <?php
  if (@$_GET['group']==NULL) {
	  $sql1 = "SELECT * FROM `shift_member` WHERE `available`='1' ORDER BY `GroupID` ASC, `order` ASC";
  } else {
	  $sql1 = "SELECT * FROM `shift_member` WHERE `available`='1' AND `GroupID`='".mysql_escape_string($_GET['group'])."' ORDER BY `order` ASC";
  }
  $db1 = new DB;
  $db1->query($sql1);
  $arrEmpName = array();
  for ($i=0;$i<$db1->num_rows();$i++) {
	  $r1 = $db1->fetch_assoc();
	  if ($r1['EmpGroup']==1) { $table = "employer"; $NameColName = "Name"; $IDColName = "EmpID"; $IDColName2 = "EmpID"; $table_shift = "employer_shift"; } elseif ($r1['EmpGroup']==2) { $table = "foreignemployer"; $NameColName = "cNickname"; $IDColName = "foreignID"; $IDColName2 = "EmpID"; $table_shift = "foreignemployer_shift"; }
	  $db1a = new DB;
	  $db1a->query("SELECT `".$NameColName."` FROM `".$table."` WHERE `".$IDColName."`='".$r1['EmpID']."'");
	  $r1a = $db1a->fetch_assoc();
	  $arrEmpName[$r1[$IDColName]] = $r1a[$NameColName];
	  $db2a = new DB;
	  $db2a->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td1."'");
	  $r2a = $db2a->fetch_assoc();
	  $db2b = new DB;
	  $db2b->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td2."'");
	  $r2b = $db2b->fetch_assoc();
	  $db2c = new DB;
	  $db2c->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td3."'");
	  $r2c = $db2c->fetch_assoc();
	  $db2d = new DB;
	  $db2d->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td4."'");
	  $r2d = $db2d->fetch_assoc();
	  $db2e = new DB;
	  $db2e->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td5."'");
	  $r2e = $db2e->fetch_assoc();
	  $db2f = new DB;
	  $db2f->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td6."'");
	  $r2f = $db2f->fetch_assoc();
	  $db2g = new DB;
	  $db2g->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td7."'");
	  $r2g = $db2g->fetch_assoc();
	  $error = 0;
	  //echo "SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td1."'<br>";
	  echo '
  <tr>
    <td class="title_s" width="60" height="200">'.$r1a[$NameColName].'</td>
	<td '; if (date('Y/m/d')==$d1) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" }); })</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'" value="'.$r2a['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td1.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2a['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d2) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'" value="'.$r2b['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td2.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2b['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d3) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'" value="'.$r2c['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td3.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2c['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d4) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'" value="'.$r2d['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td4.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2d['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d5) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'" value="'.$r2e['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td5.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2e['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d6) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'" value="'.$r2f['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td6.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2f['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	
	<td '; if (date('Y/m/d')==$d7) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'" id="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'" value="'.$r2g['area'].'" /><select name="employer_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td7.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2g['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
  </tr>
	  '."\n";
  }
  ?>
  <tr class="title">
    <td colspan="8"><input type="submit" name="saveshift" value="Save"><?php if ($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01") { ?><input type="submit" name="saveshift2" value="Transfer" onclick="if (confirm('轉出資料會覆蓋已儲存同時間點的排班資料，確定執行？')) { return true; } else { return false; }"><?php } ?></td>
  </tr>
</table>
</form>
  </div>
  <?php /*?><div id="tabs-2">
<table style="width:920px;">
<tr class="title">
    <td colspan="8"><input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $lastweek; ?>#tabs-2'" value="Previous week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>#tabs-2'" value="Back to current week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $nextweek; ?>#tabs-2'" value="Next week"></td>
  </tr>
</table>
  <?php
  foreach ($arrArea as $areaID => $areaName) {
	  echo '<h3>'.$areaName.'</h3>';
  ?>
<table style="width:920px;">
  <tr class="title">
    <td><?php echo $sd1; ?> (Mon)</td>
    <td><?php echo $sd2; ?> (Tue)</td>
    <td><?php echo $sd3; ?> (Wed)</td>
    <td><?php echo $sd4; ?> (Thu)</td>
    <td><?php echo $sd5; ?> (Fri)</td>
    <td><?php echo $sd6; ?> (Sat)</td>
    <td><?php echo $sd7; ?> (Sun)</td>
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
    <table style="width:125px; font-size:10pt;">
      <?php
	  foreach ($arrShift as $key=>$value) {
		  if ($key=="A" || $key=="B" || $key=="C" || $key=="D" || $key=="E") {
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
  </div><?php */?>
  <div id="tabs-3">
  <iframe src="shiftarea_grid.php" frameborder="0" width="920" height="640"></iframe>
  </div>
  <div id="tabs-4">
<?php
if (isset($_POST['save_shift_member'])) {
	foreach ($_POST as $k4=>$v4) {
		if ($k4!="save_shift_member" && substr($k4,0,9)!="available" && substr($k4,0,7)!="traffic") {
			$arrVar = explode("_",$k4);
			$EmpGroup = $arrVar[1];
			$EmpID = $arrVar[2];
			$db5d0 = new DB;
			$db5d0->query("SELECT `order` FROM `shift_member` WHERE `GroupID`='".$v4."' AND `order`!=777 AND `order`!=9999 ORDER BY `order` DESC LIMIT 0,1");
			$r5d0 = $db5d0->fetch_assoc();
			$newEmpOrder = $r5d0['order']+1;
			$db5d = new DB;
			$db5d->query("UPDATE `shift_member` SET `GroupID`='".$v4."', `order`='".$newEmpOrder."' WHERE `EmpID`='".mysql_escape_string($EmpID)."' AND `EmpGroup`='".$EmpGroup."'");
		} elseif ( substr($k4,0,9)=="available" ) {
			$arrVar2 = explode("_",$k4);
			$EmpGroup2 = $arrVar2[1];
			$EmpID2 = $arrVar2[2];
			$db5k = new DB;
			$db5k->query("SELECT `GroupID` FROM `shift_member` WHERE `EmpID`='".mysql_escape_string($EmpID2)."' AND `EmpGroup`='".$EmpGroup2."'");
			$r5k = $db5k->fetch_assoc();
			$GroupID = $r5k['GroupID'];
			if ($v4=="" || $v4==0) {
				$db5g = new DB;
				$db5g->query("UPDATE `shift_member` SET `available`='0', `order`='777' WHERE `EmpID`='".mysql_escape_string($EmpID2)."' AND `EmpGroup`='".$EmpGroup2."'");
				//重新編號排序
				$db5h = new DB;
				$db5h->query("SELECT * FROM `shift_member` WHERE `GroupID`='".$GroupID."' AND `order`!=777 AND `order`!=9999 ORDER BY `order` ASC");
				for ($i1=0;$i1<$db5h->num_rows();$i1++) {
					$r5h = $db5h->fetch_assoc();
					$db5i = new DB;
					$db5i->query("UPDATE `shift_member` SET `order`='".($i1+1)."' WHERE `EmpID`='".$r5h['EmpID']."' AND `EmpGroup`='".$r5h['EmpGroup']."'");
				}
				$db5l = new DB;
				$db5l->query("ALTER TABLE `shift_member` ORDER BY `GroupID`, `order`");
			} else {
				$db5g = new DB;
				$db5g->query("SELECT `order` FROM `shift_member` WHERE `EmpID`='".mysql_escape_string($EmpID2)."' AND `EmpGroup`='".$EmpGroup2."'");
				$r5g=$db5g->fetch_assoc();
				//if ($r5g['order']==777) {
					//復職重新進入排序
					$db5h = new DB;
					$db5h->query("SELECT `order` FROM `shift_member` WHERE `GroupID`='".$GroupID."' AND `order`!=777 AND `order`!=9999 ORDER BY `order` DESC LIMIT 0,1");
					$r5h = $db5h->fetch_assoc();
					$newOrder = $r5h['order']+1;
					$db5i = new DB;
					$db5i->query("UPDATE `shift_member` SET `available`='1', `order`='".$newOrder."' WHERE `EmpID`='".mysql_escape_string($EmpID2)."' AND `EmpGroup`='".$EmpGroup2."'");
				//}
				$db5l = new DB;
				$db5l->query("ALTER TABLE `shift_member` ORDER BY `GroupID`, `order`");
			}
		} elseif ( substr($k4,0,7)=="traffic" ) {
			$arrVar = explode("_",$k4);
			$EmpGroup = $arrVar[1];
			$EmpID = $arrVar[2];
			$db5e = new DB;
			$db5e->query("UPDATE `shift_member` SET `traffic`='".$v4."' WHERE `EmpID`='".mysql_escape_string($EmpID)."' AND `EmpGroup`='".$EmpGroup."'");
		}
	}
	//print_r($_POST);
}
/*$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group`");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}*/
?>
<h3>Name list for shift duty</h3>
<div id="tabs2" style="width:956px;">
  <ul>
    <?php
	foreach ($arrGroupName as $k5=>$v5) {
		echo '<li><a href="#tab_group_'.$k5.'">'.$v5.'</a></li>'."\n";
	}
	?>
  </ul>
<?php
$db5f = new DB;
$db5f->query("SELECT DISTINCT `GroupID` FROM `shift_member` ORDER BY `GroupID` ASC");
for ($i0=0;$i0<$db5f->num_rows();$i0++) {
	$r5f = $db5f->fetch_assoc();
	$db5 = new DB;
	$db5->query("SELECT * FROM `shift_member` WHERE `GroupID`='".mysql_escape_string($r5f['GroupID'])."' ORDER BY `GroupID` ASC, `order` ASC");
	$db5_0 = new DB;
	$db5_0->query("SELECT * FROM `shift_member` WHERE `GroupID`='".mysql_escape_string($r5f['GroupID'])."' AND `available`='1' ORDER BY `GroupID` ASC, `order` ASC");
	$available_n = $db5_0->num_rows();
	echo '
	<div id="tab_group_'.$r5f['GroupID'].'">';
?>
	<form action="index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>#tabs-4" method="post">
	<table style="width:920px;">
	  <tr class="title">
		<td width="120">Display order</td>
		<td>Staff name</td>
		<td>Shift group</td>
		<td>Serving</td>
        <td>Shuttle</td>
	  </tr>
	  <?php
	  for ($i=0;$i<$db5->num_rows();$i++) {
		  $r5 = $db5->fetch_assoc();
		  if ($r5['EmpGroup']==1) {
			  $db5a = new DB;
			  $db5a->query("SELECT * FROM `employer` WHERE `EmpID`='".$r5['EmpID']."';");
			  $r5a = $db5a->fetch_assoc();
			  $Name = $r5a['Name'];
		  } else {
			  $db5b = new DB;
			  $db5b->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".$r5['EmpID']."'");
			  $r5b = $db5b->fetch_assoc();
			  $Name = $r5b['cNickname'];
		  }
		  
		  echo '
	  <tr class="Group_'.$r5['EmpGroup'].'">
		<td><center>';
		  if ($i!=0 && $r5['available']=="1") { echo '<a href="shiftorder.php?EmpGroup='.$r5['EmpGroup'].'&EmpID='.$r5['EmpID'].'&GroupID='.$r5['GroupID'].'&action=upper&order='.$r5['order'].'" target="_blank"><img src="Images/upper.png" width="55" height="16" border"0" /></a>'; }
		  if ($i!=($available_n-1) && $r5['available']=="1") { echo '<a href="shiftorder.php?EmpGroup='.$r5['EmpGroup'].'&EmpID='.$r5['EmpID'].'&GroupID='.$r5['GroupID'].'&action=lower&order='.$r5['order'].'" target="_blank"><img src="Images/lower.png" width="55" height="16" border"0" /></a>'; }
		echo '
		</center></td>
		<td align="center">'.$Name.'</td>
		<td align="center">
		  <select name="GroupID_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'" id="GroupID_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'">
			<option></option>';
			foreach ($arrGroupName as $k3=>$v3) {
				echo '<option value="'.$k3.'"';
				if ($k3==$r5['GroupID']) { echo ' selected'; }
				echo '>'.$v3.'</option>';
			}
		  echo '
		  </select>
		</td>
		<td align="center"><input type="checkbox" id="checkbox_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'" value="1" onclick="changeavailable(\''.$r5['EmpGroup'].'\',\''.$r5['EmpID'].'\')"';
		if ($r5['available']==1) { echo ' checked'; }
		echo '> Serving
		<input type="hidden" name="available_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'" id="available_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'" value="'.$r5['available'].'">
		</td>
		<td align="center">';
		$db6 = new DB;
		$db6->query("SELECT * FROM `shift_traffic` ORDER BY `trafficID` ASC");
		for ($i2=1;$i2<=$db6->num_rows();$i2++) {
			$r6 = $db6->fetch_assoc();
			echo '<input type="radio" id="traffic_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'" name="traffic_'.$r5['EmpGroup'].'_'.$r5['EmpID'].'" value="'.$r6['trafficID'].'" '.($r5['traffic']==$r6['trafficID']?"checked":"").'> '.$r6['Name'].' ';
		}
		echo '</td>
	  </tr>
		  '."\n";
	  }
	  ?>
	  <tr>
		<td colspan="6" align="center"><input type="submit" name="save_shift_member" value="Save" /></td>
	  </tr>
	</table>
	</form>
    </div>
<?php
}
?>
</div>
<script>
function changeavailable(EmpGroup, EmpID) {
	var available = document.getElementById('checkbox_'+EmpGroup+'_'+EmpID).checked;
	if (available) {
		document.getElementById('available_'+EmpGroup+'_'+EmpID).value = '1';
	} else {
		document.getElementById('available_'+EmpGroup+'_'+EmpID).value = '0';
	}
}
</script>
  </div>
  <div id="tabs-5">
  <iframe src="shifttraffic_grid.php" frameborder="0" width="920" height="640"></iframe>
  </div>
  <div id="tabs-6">
  <iframe src="shiftgroup_grid.php" frameborder="0" width="920" height="640"></iframe>
  </div>
  <div id="tabs-7">
  <iframe src="shiftprimary_duty_nurse_grid.php" frameborder="0" width="920" height="640"></iframe>
  </div>
  <div id="tabs-8">
  <iframe src="shift_grid.php" frameborder="0" width="920" height="640"></iframe>
  </div> 
  <?php if ($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01") { ?>
  <div id="tabs-9">
  <?php
if (@$_GET['date']==NULL) {
	$getdate = date("Y-m-d");
	$arrDates = getdays($getdate);
} else {
	$getdate = substr(@$_GET['date'],0,4).'-'.substr(@$_GET['date'],4,2).'-'.substr(@$_GET['date'],6,2);
	$arrDates = getdays($getdate);
}

$d = new DateTime($arrDates[0]);
$dlw = new DateTime($arrDates[0]);
$dnw = new DateTime($arrDates[0]);

$d->modify("+0 day"); $d1 = $d->format('Y/m/d'); $sd1 = $d->format('m/d'); $td1 = $d->format('Ymd');
$d->modify('+1 day'); $d2 =  $d->format('Y/m/d'); $sd2 = $d->format('m/d'); $td2 = $d->format('Ymd');
$d->modify('+1 day'); $d3 =  $d->format('Y/m/d'); $sd3 = $d->format('m/d'); $td3 = $d->format('Ymd');
$d->modify('+1 day'); $d4 =  $d->format('Y/m/d'); $sd4 = $d->format('m/d'); $td4 = $d->format('Ymd');
$d->modify('+1 day'); $d5 =  $d->format('Y/m/d'); $sd5 = $d->format('m/d'); $td5 = $d->format('Ymd');
$d->modify('+1 day'); $d6 =  $d->format('Y/m/d'); $sd6 = $d->format('m/d'); $td6 = $d->format('Ymd');
$d->modify('+1 day'); $d7 =  $d->format('Y/m/d'); $sd7 = $d->format('m/d'); $td7 = $d->format('Ymd');

$dlw->modify('-7 day'); $lastweek = $dlw->format('Ymd');
$dnw->modify('+7 day'); $nextweek = $dnw->format('Ymd');
?>
<h3>Weekly shift duty list (<?php echo $d1; ?> ~ <?php echo $d7; ?>)</h3>
<div align="center"><form>
<select id="selmonth2">
    <option>--Select month--</option>
    <?php
    for ($i=date(m);$i>=(date(m)-5);$i--) {
        $month = $i;
        $year = date(Y);
        if ($i<1) {
            $month = 12+$i;
            $year = date(Y)-1;
        }
        if (strlen($month)==1) {
            $month = "0".$month;
        }
        echo '<option value="'.$year.$month.'">'.$year.'-'.$month.'</option>'."\n";
    }
    ?>
</select><input type="button" onclick="window.open('printshift1.php?lof=2&date='+document.getElementById('selmonth2').value)" value="Print monthly schedule"> <input type="button" onclick="window.open('printshift.php?lof=2&date=<?php echo @$_GET['date']; ?>')" value="Print weekly schedule"></form></div>
<div style="margin:10px auto;">
<?php
$arrGroupName = array();
$db5c = new DB;
$db5c->query("SELECT * FROM `shift_group` ORDER BY `GroupID` ASC");
for ($i=0;$i<$db5c->num_rows();$i++) {
	$r5c = $db5c->fetch_assoc();
	$arrGroupName[$r5c['GroupID']] = $r5c['GroupName'];
}
?>
Select group:
<script>
function onchangeviewgroup(groupid) {
	window.location.href='index.php?mod=humanresource&func=formview&id=6&group='+groupid+'&date=<?php echo $_GET['date']; ?>';
}
</script>
<select onchange="onchangeviewgroup(this.options.selectedIndex)">
  <option></option>
  <?php
  foreach ($arrGroupName as $k3=>$v3) {
	  echo '<option value="'.$k3.'"';
	  if ($k3==@$_GET['group']) { echo ' selected'; }
	  echo '>'.$v3.'</option>';
  }
  ?>
</select>
</div>
<form action="index.php?mod=humanresource&func=formview&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo @$_GET['date']; ?>" method="post">
<table style="width:920px;">
  <tr class="title">
    <td>Date</td>
	<td colspan="3"><script>$(function() { $('#searchmonth2').datepicker(); });</script><input type="text" size="10" name="searchmonth2" id="searchmonth2" value="<?php echo ($_GET['date']==""?date("Y/m/d"):formatdate($_GET['date'])); ?>"><input type="button" value="Search" onclick="window.location.href='<?php echo "index.php?mod=humanresource&func=formview&id=6&group=".$_GET['group']."&view=6&date="; ?>' + $('#searchmonth2').val().replace('/','').replace('/','')"></td>
    <td colspan="4"><input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&view=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $lastweek; ?>'" value="Previous week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=6&view=6&group=<?php echo @$_GET['group']; ?>'" value="Back to current week"> <input type="button" onclick="window.location.href='index.php?mod=humanresource&func=formview&view=6&id=6&group=<?php echo @$_GET['group']; ?>&date=<?php echo $nextweek; ?>'" value="Next week"></td>
  </tr>
  <tr class="title">
    <td>&nbsp;</td>
    <td <?php if (date('Y/m/d')==$d1) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd1; ?><br>(Mon)</td>
    <td <?php if (date('Y/m/d')==$d2) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd2; ?><br>(Tue)</td>
    <td <?php if (date('Y/m/d')==$d3) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd3; ?><br>(Wed)</td>
    <td <?php if (date('Y/m/d')==$d4) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd4; ?><br>(Thu)</td>
    <td <?php if (date('Y/m/d')==$d5) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd5; ?><br>(Fri)</td>
    <td <?php if (date('Y/m/d')==$d6) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd6; ?><br>(Sat)</td>
    <td <?php if (date('Y/m/d')==$d7) { echo 'bgcolor="#C90000"'; } ?>><?php echo $sd7; ?><br>(Sun)</td>
  </tr>
  <?php	  
  if (@$_GET['group']==NULL) {
	  $sql1 = "SELECT * FROM  `shift_member` WHERE (`EmpID` IN (SELECT DISTINCT  `foreignID` FROM  `foreignemployer_shift2` WHERE `date` BETWEEN '".$td1."' AND '".$td7."') ";
	  $sql1 .=" OR `EmpID` IN (SELECT DISTINCT `EmpID` FROM `employer_shift2` WHERE `date` BETWEEN '".$td1."' AND '".$td7."')) ";
	  $sql1 .=" AND GroupID = '1' ORDER BY  `EmpGroup` ,  `GroupID` ,  `order` ";
  } else {
	  $sql1 = "SELECT * FROM  `shift_member` WHERE (`EmpID` IN (SELECT DISTINCT  `foreignID` FROM  `foreignemployer_shift2` WHERE `date` BETWEEN '".$td1."' AND '".$td7."') ";
	  $sql1 .=" OR `EmpID` IN (SELECT DISTINCT `EmpID` FROM `employer_shift2` WHERE `date` BETWEEN '".$td1."' AND '".$td7."')) ";
	  $sql1 .=" AND GroupID = '".mysql_escape_string($_GET['group'])."' ORDER BY  `EmpGroup` ,  `GroupID` ,  `order` ";
  }
  //echo $sql1."<br>";
  $db1 = new DB;
  $db1->query($sql1);
  $arrEmpName = array();
  if ($db1->num_rows()==0) {
	  echo '<td colspan="8" align="center" bgcolor="#FFFFFF">No scheduling data for this date range</td>';
  } else {
	  for ($i=0;$i<$db1->num_rows();$i++) {
		  $r1 = $db1->fetch_assoc();
		  if ($r1['EmpGroup']==1) { $table = "employer"; $NameColName = "Name"; $IDColName = "EmpID"; $IDColName2 = "EmpID"; $table_shift = "employer_shift2"; } elseif ($r1['EmpGroup']==2) { $table = "foreignemployer"; $NameColName = "cNickname"; $IDColName = "foreignID"; $IDColName2 = "EmpID"; $table_shift = "foreignemployer_shift2"; }
		  $db1a = new DB;
		  $db1a->query("SELECT `".$NameColName."` FROM `".$table."` WHERE `".$IDColName."`='".$r1['EmpID']."'");
		  $r1a = $db1a->fetch_assoc();
		  $arrEmpName[$r1[$IDColName]] = $r1a[$NameColName];
		  $db2a = new DB;
		  $db2a->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td1."'");
		  $r2a = $db2a->fetch_assoc();
		  $db2b = new DB;
		  $db2b->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td2."'");
		  $r2b = $db2b->fetch_assoc();
		  $db2c = new DB;
		  $db2c->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td3."'");
		  $r2c = $db2c->fetch_assoc();
		  $db2d = new DB;
		  $db2d->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td4."'");
		  $r2d = $db2d->fetch_assoc();
		  $db2e = new DB;
		  $db2e->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td5."'");
		  $r2e = $db2e->fetch_assoc();
		  $db2f = new DB;
		  $db2f->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td6."'");
		  $r2f = $db2f->fetch_assoc();
		  $db2g = new DB;
		  $db2g->query("SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td7."'");
		  $r2g = $db2g->fetch_assoc();
		  $error = 0;
		  //echo "SELECT * FROM `".$table_shift."` WHERE `".$IDColName."`='".$r1[$IDColName2]."' AND `date`='".$td1."'<br>";
		  echo '
	  <tr>
		<td class="title_s" width="60" height="200">'.$r1a[$NameColName].'</td>
		<td '; if (date('Y/m/d')==$d1) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" }); })</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td1.'" value="'.$r2a['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td1.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2a['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
		
		<td '; if (date('Y/m/d')==$d2) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td2.'" value="'.$r2b['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td2.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2b['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
		
		<td '; if (date('Y/m/d')==$d3) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td3.'" value="'.$r2c['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td3.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2c['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
		
		<td '; if (date('Y/m/d')==$d4) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td4.'" value="'.$r2d['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td4.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2d['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
		
		<td '; if (date('Y/m/d')==$d5) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td5.'" value="'.$r2e['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td5.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2e['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
		
		<td '; if (date('Y/m/d')==$d6) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td6.'" value="'.$r2f['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td6.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2f['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
		
		<td '; if (date('Y/m/d')==$d7) { echo 'bgcolor="#CCCCCC"'; } echo '><script>$(function() { $("#employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'").tagsInput({"defaultText":"", autocomplete_url: "class/shiftareainfo.php" });})</script><input type="text" name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'" id="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_area_'.$td7.'" value="'.$r2g['area'].'" /><select name="employer2_'.$r1['EmpGroup'].'_'.$r1['EmpID'].'_shift_'.$td7.'"><option></option>'; foreach ($arrShift as $k2=>$v2) { echo '<option value="'.$k2.'" '; if ($r2g['shift']==$k2) { echo 'selected'; } echo '>'.$v2.'</option>'."\n"; } echo '</select></td>
	  </tr>
		  '."\n";
	  }
  }
  ?>
  <tr class="title">
    <td colspan="8"><input type="submit" name="saveshift2" value="Save"></td>
  </tr>
</table>
</form>
  </div>
  <?php } ?>
</div>
<br>