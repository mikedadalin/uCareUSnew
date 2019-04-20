<script type="text/javascript" src="js/LWJ_tabs.js"></script>
<div class="content-query">
<table>
  <tr class="title">
    <td colspan="2">Filter condition</td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Area search</b></center></td>
    <td align="left">
      <form action="index.php?mod=consump&func=formview&id=17&query=1" method="post">
      Area&nbsp;<select name="area">
      <?php
	  $qArea = new DB;
	  $qArea->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
	  for ($i=0;$i<$qArea->num_rows();$i++) {
		  $rArea = $qArea->fetch_assoc();
		  echo '<option value="'.$rArea['areaID'].'">'.$rArea['areaName'].'</option>'."\n";
	  }
	  ?>
      </select>&nbsp;
      <input type="submit" value="Search" /></form>
    </td>
  </tr>
  <tr>
    <td width="120" class="title"><center><b>Resident search</b></center></td>
    <td align="left"><form action="index.php?mod=consump&func=formview&id=17&query=2" method="post">Social Security number&nbsp;<input name="IdNo" value="<?php echo $_POST['IdNo']; ?>" />&nbsp;or Care ID#&nbsp;<input name="HospNoDisplay" value="<?php echo $_POST['HospNoDisplay']; ?>" />&nbsp;<input type=submit value="Resident search" /></form></td>
  </tr>
</table>
</div>
<div id="tabs" style="width:100%;">
	<ul>
      <li><a href="#type1">General residents</a></li>
      <li><a href="#type2">Discharged residents</a></li>
    </ul>
    <div id="type1" class="content-table" style="padding:20px 0px 20px 0px; font-size:11pt;">
<table>
<tr class="title">
  <td width="80">Area</td>
  <td width="80">Bed</td>
  <td>Full name</td>
  <td>Care ID#</td>
  <td>Gender</td>  
  <td>Age</td>
  <td>Admission date</td>
  <td>Function</td>
</tr>
<?php
$myMonth = date("m", mktime(0,0,0,date(m),1,date(Y)));
$myYear = date("Y", mktime(0,0,0,date(m),1,date(Y)))-1911;

if (@$_GET['query']==2) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNoDisplay']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNoDisplay` LIKE '%".mysql_escape_string($_POST['HospNoDisplay'])."%' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1) {
	//查詢區域
	$arrAreaBed = array();
	$db2 = new DB;
	$db2->query("SELECT `bedID` FROM `bedinfo` WHERE `Area`='".mysql_escape_string($_POST['area'])."'");
	for ($k=0;$k<$db2->num_rows();$k++) {
		$r2 = $db2->fetch_assoc();
		$arrAreaBed[$k] = $r2['bedID'];
	}
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
} else {
	$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
}
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
	for ($j=0;$j<$db1->num_rows();$j++) {
		$r1 = $db1->fetch_assoc();
		if (@$_GET['query']==1) {
			if (count($arrAreaBed)==0) {
			if (@$_GET['query']!=NULL) {
				echo '<script>alert("此區域尚未有住民入住");</script>'."\n";
				break 2;
			}
			}
		}
		$db2a = new DB;
		$db2a->query("SELECT `Area` FROM `bedinfo` WHERE `bedID`='".$r1['bed']."'");
		$r2a = $db2a->fetch_assoc();
		$db2b = new DB;
		$db2b->query("SELECT `areaName` FROM `areainfo` WHERE `areaID`='".$r2a['Area']."'");
		$r2b = $db2b->fetch_assoc();
		$db2c = new DB;
		$db2c->query("SELECT `patientID`,`HospNoDisplay`,`instat`,`Birth` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
		$r2c = $db2c->fetch_assoc();
		if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
			echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.getPatientName($r2c['patientID']).'</td>
  <td>'.$r2c['HospNoDisplay'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
  <td><form>
  <input type="button" value="Setting" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_1&pid='.$r['patientID'].'\';">';
  $db4 = new DB;
  $db4->query("SELECT * FROM `feecreate` WHERE HospNo='".getHospNo($r['patientID'])."' AND (`status`='N' OR `status`='Y') AND `date1`='".($myYear+1911).$myMonth."'");
  if($db4->num_rows() > 0){	
  	$r4=$db4->fetch_assoc();
	if($r4['status']=="Y"){
  		echo '<input type="button" value="Settle">';
	}else{
	    echo '<input type="button" value="Reverse the entry"  style="background-color:#FFFF66;color:#666;cursor:pointer;" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_3&pid='.$r['patientID'].'\';">';
	}
  }else{
	echo '<input type="button" value="Billing"  style="background-color:#FF9999;color:#FFF;cursor:pointer;" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_2&pid='.$r['patientID'].'\';">';
  }
  echo '<input type="button" value="Payment record" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_3&pid='.$r['patientID'].'\';"><input type="button" value="Late payment" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_6&pid='.$r['patientID'].'\';"></form></td>
</tr>
		'."\n";
		}
	}
}
?>
</table>
</div>
    <div id="type2" class="content-table" style="padding:20px 0px 20px 0px; font-size:11pt;">
    <table>
    <tr class="title">
      <td>Full name</td>
      <td>Care ID#</td>
      <td>Gender</td> 
      <td>Admission date</td>
      <td>Discharged date</td>
      <td>Function</td>
    </tr>
    <?php
    $sql1 = "SELECT * FROM `closedcase` ORDER BY `feeclear` ASC, `outdate` DESC";
    $db = new DB;
    $db->query($sql1);
    for ($i=0;$i<$db->num_rows();$i++) {
        $r = $db->fetch_assoc();
        foreach ($r as $k=>$v) {
            $arrPatientInfo = explode("_",$k);
            if (count($arrPatientInfo)==2) {
                if ($v==1) {
                    ${$arrPatientInfo[0]} = $arrPatientInfo[1];
                }
            } else {
                ${$k} = $v;
            }
		}
		$db3 = new DB;
		$db3->query("SELECT * FROM `feecreate` WHERE `HospNo`='".getHospNo($r['patientID'])."' ORDER BY `receiptID` DESC LIMIT 0,1");
		$r3 = $db3->fetch_assoc();
		echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r2c['instat']==0?' style="display:none;"':"").'>
  <td>'.getPatientName($r['patientID']).'</td>
  <td>'.getHospNoDisplayByPID($r['patientID']).'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.formatdate($r['indate']).'</td>
  <td>'.formatdate($r['outdate']).'</td>
  <td><form>';
  if($r['feeclear']=='1' && $r3['status']=='Y'){
	  echo '<input type="button" value="Settle">';
  } elseif($r['feeclear']=='0' && $r3['status']=='N'){
	  echo '<input type="button" value="Reverse the entry"  style="background-color:#FFFF66;color:#666;cursor:pointer;" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_3&pid='.$r['patientID'].'\';">';
  } else {
	  echo '<input type="button" value="Discharged & settlement"  style="background-color:#FF9999;color:#FFF;cursor:pointer;" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_5&reID='.$r3['receiptID'].'&pid='.$r['patientID'].'\';">';
  }
  echo '<input type="button" value="Payment record" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_3&pid='.$r['patientID'].'\';"><input type="button" value="Late payment" name="setting" onclick="window.location.href=\'index.php?mod=consump&func=formview&id=17_6&pid='.$r['patientID'].'\';">';
  echo '</form></td>
	</tr>'."\n";
	
    }
    ?>
    </table>
    </div>
</div>