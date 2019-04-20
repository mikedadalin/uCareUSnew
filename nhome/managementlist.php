<div id="typeTab">
  <ul>
    <li><a href="#typeTab-1">General admission</a></li>
    <li><a href="#typeTab-2">Swing bed</a></li>
    <li><a href="#typeTab-3">Respite care</a></li>
    <li><a href="#typeTab-5">Public funded care</a></li>
    <li><a href="#typeTab-6">Urgent care</a></li>
    <li class="golink"><a href="#typeTab-4">Multi-disciplinary care conferences</a></li>
  </ul>
<div id="typeTab-1" style="padding:20px 0px; font-size:12pt;">
<div class="content-table">
<table id="recordtable1">
<?php
if (@$_GET['query']==3 && $_GET['type']==1) {
	$sql1 = "SELECT `patientID` FROM `closedcase` ORDER BY `outdate` DESC";
} elseif (@$_GET['query']==2 && $_GET['type']==1) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' AND `type`='1' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNoDisplay']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNoDisplay` LIKE '%".mysql_escape_string($_POST['HospNoDisplay'])."%' AND `type`='1' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1 && $_GET['type']==1) {
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
echo '<thead>';
if (@$_GET['query']==3 && $_GET['type']==1) {
	echo '	
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
</tr>
	'."\n";
} else {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Area(location)</th>
  <th>Bed #</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
  <th>Admission date</th>
</tr>
	'."\n";
}
echo '</thead>';
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$name = getPatientName($r['patientID']);
	if (@$_GET['query']==3 && $_GET['type']==1) {
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='1' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			$db4 = new DB;
			$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
			if ($db4->num_rows()==0) {
				echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$name.'</td>
  <td>'.$r1['HospNoDisplay'].'</td>
  <td>'.checkgender($r1['patientID']).'</td>  
  <td>'.calcage($r1['Birth']).'</td>
</tr>'."\n";
			}
		}
	} else {
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='1' ORDER BY a.`patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			if (@$_GET['query']==1 && $_GET['type']==1) {
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
			$db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='1'");
			$r2c = $db2c->fetch_assoc();
			$db2d = new DB;
			$db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0, 1");
			$r2d = $db2d->fetch_assoc();
			if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				echo '
<tr';
if ($_SESSION['ncareOrgStatus_lwj']==2) {
	if ($r2c['instat']==0) { echo ' style="display:none;"'; }
}
echo '>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.$name.'</td>
  <td>'.$r2c['HospNoDisplay'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
</tr>'."\n";
			}
		}
	}
}
?>
</table>
</div>
</div>
<div id="typeTab-2" style="padding:20px 0px; font-size:12pt;">
<div class="content-table">
<table id="recordtable2">
<?php
if (@$_GET['query']==3 && $_GET['type']==2) {
	$sql1 = "SELECT `patientID` FROM `closedcase` ORDER BY `outdate` DESC";
} elseif (@$_GET['query']==2 && $_GET['type']==2) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' AND `type`='2' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNoDisplay']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNoDisplay` LIKE '%".mysql_escape_string($_POST['HospNoDisplay'])."%' AND `type`='2' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1 && $_GET['type']==2) {
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
echo '<thead>';
if (@$_GET['query']==3 && $_GET['type']==2) {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
</tr>
	'."\n";
} else {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Area(location)</th>
  <th>Bed #</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
  <th>Admission date</th>
</tr>
	'."\n";
}
echo '</thead>';
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$name = getPatientName($r['patientID']);
	if (@$_GET['query']==3 && $_GET['type']==2) {
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='2' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			$db4 = new DB;
			$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
			if ($db4->num_rows()==0) {
				echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$name.'</td>
  <td>'.$r1['HospNoDisplay'].'</td>
  <td>'.checkgender($r1['patientID']).'</td>  
  <td>'.calcage($r1['Birth']).'</td>
</tr>'."\n";
			}
		}
	} else {
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='2' ORDER BY a.`patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			if (@$_GET['query']==1 && $_GET['type']==2) {
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
			$db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='2'");
			$r2c = $db2c->fetch_assoc();
			$db2d = new DB;
			$db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0, 1");
			$r2d = $db2d->fetch_assoc();
			if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {						
				echo '
<tr';
if ($_SESSION['ncareOrgStatus_lwj']==2) {
	if ($r2c['instat']==0) { echo ' style="display:none;"'; }
}
echo '>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.$name.'</td>
  <td>'.$r2c['HospNoDisplay'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
</tr>'."\n";
			}
		}
	}
}
?>
</table>
</div>
</div>
<div id="typeTab-3" style="padding:20px 0px; font-size:12pt;">
<div class="content-table">
<table id="recordtable3">
<?php
if (@$_GET['query']==3 && $_GET['type']==3) {
	$sql1 = "SELECT `patientID` FROM `closedcase` ORDER BY `outdate` DESC";
} elseif (@$_GET['query']==2 && $_GET['type']==3) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' AND `type`='3' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNoDisplay']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNoDisplay` LIKE '%".mysql_escape_string($_POST['HospNoDisplay'])."%' AND `type`='3' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1 && $_GET['type']==3) {
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
echo '<thead>';
if (@$_GET['query']==3 && $_GET['type']==3) {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
</tr>
	'."\n";
} else {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Area(location)</th>
  <th>Bed #</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
  <th>Admission date</th>
</tr>
	'."\n";
}
echo '</thead>';
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$name = getPatientName($r['patientID']);
	if (@$_GET['query']==3 && $_GET['type']==3) {
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='3' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			$db4 = new DB;
			$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
			if ($db4->num_rows()==0) {
				echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$name.'</td>
  <td>'.$r1['HospNoDisplay'].'</td>
  <td>'.checkgender($r1['patientID']).'</td>  
  <td>'.calcage($r1['Birth']).'</td>
</tr>'."\n";
			}
		}
	} else {
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='3' ORDER BY a.`patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			if (@$_GET['query']==1 && $_GET['type']==3) {
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
			$db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='3'");
			$r2c = $db2c->fetch_assoc();
			$db2d = new DB;
			$db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0, 1");
			$r2d = $db2d->fetch_assoc();
			if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {			
				echo '
<tr';
if ($_SESSION['ncareOrgStatus_lwj']==2) {
	if ($r2c['instat']==0) { echo ' style="display:none;"'; }
}
echo '>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.$name.'</td>
  <td>'.$r2c['HospNoDisplay'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
</tr>'."\n";
			}
		}
	}
}
?>
</table>
</div>
</div>
<div id="typeTab-5" style="padding:20px 0px; font-size:12pt;">
<div class="content-table">
<table id="recordtable5">
<?php
if (@$_GET['query']==3 && $_GET['type']==3) {
	$sql1 = "SELECT `patientID` FROM `closedcase` ORDER BY `outdate` DESC";
} elseif (@$_GET['query']==2 && $_GET['type']==3) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' AND `type`='4' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNoDisplay']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNoDisplay` LIKE '%".mysql_escape_string($_POST['HospNoDisplay'])."%' AND `type`='4' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1 && $_GET['type']==3) {
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
echo '<thead>';
if (@$_GET['query']==3 && $_GET['type']==3) {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
</tr>
	'."\n";
} else {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Area(location)</th>
  <th>Bed #</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
  <th>Admission date</th>
</tr>
	'."\n";
}
echo '</thead>';
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$name = getPatientName($r['patientID']);
	if (@$_GET['query']==3 && $_GET['type']==3) {
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='4' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			$db4 = new DB;
			$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
			if ($db4->num_rows()==0) {	
				echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$name.'</td>
  <td>'.$r1['HospNoDisplay'].'</td>
  <td>'.checkgender($r1['patientID']).'</td>  
  <td>'.calcage($r1['Birth']).'</td>
</tr>'."\n";
			}
		}
	} else {
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='4' ORDER BY a.`patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			if (@$_GET['query']==1 && $_GET['type']==3) {
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
			$db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='4'");
			$r2c = $db2c->fetch_assoc();
			$db2d = new DB;
			$db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0, 1");
			$r2d = $db2d->fetch_assoc();
			if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				echo '
<tr';
if ($_SESSION['ncareOrgStatus_lwj']==2) {
	if ($r2c['instat']==0) { echo ' style="display:none;"'; }
}
echo '>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.$name.'</td>
  <td>'.$r2c['HospNoDisplay'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
</tr>'."\n";
			}
		}
	}
}
?>
</table>
</div>
</div>
<div id="typeTab-6" style="padding:20px 0px; font-size:12pt;">
<div class="content-table">
<table id="recordtable6">
<?php
if (@$_GET['query']==3 && $_GET['type']==3) {
	$sql1 = "SELECT `patientID` FROM `closedcase` ORDER BY `outdate` DESC";
} elseif (@$_GET['query']==2 && $_GET['type']==3) {
	//身份證查詢
	if ($_POST['IdNo']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `IdNo` LIKE '%".mysql_escape_string($_POST['IdNo'])."%' AND `type`='5' ORDER BY `patientID` DESC";
	} elseif ($_POST['HospNoDisplay']!=NULL) {
		$sql1 = "SELECT `patientID` FROM `patient` WHERE `HospNoDisplay` LIKE '%".mysql_escape_string($_POST['HospNoDisplay'])."%' AND `type`='5' ORDER BY `patientID` DESC";
	} else {
		$sql1 = "SELECT `patientID` FROM `inpatientinfo` ORDER BY `bed` ASC";
	}
} elseif (@$_GET['query']==1 && $_GET['type']==3) {
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
echo '<thead>';
if (@$_GET['query']==3 && $_GET['type']==3) {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
</tr>
	'."\n";
} else {
	echo '
<tr class="title">
  <th width="60">&nbsp;</th>
  <th>Area(location)</th>
  <th>Bed #</th>
  <th>Full name</th>
  <th>Care ID#</th>
  <th>Gender</th>  
  <th>Age</th>
  <th>Admission date</th>
</tr>
	'."\n";
}
echo '</thead>';
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$name = getPatientName($r['patientID']);
	if (@$_GET['query']==3 && $_GET['type']==3) {
		$db1 = new DB;
		$db1->query("SELECT `patientID`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='5' ORDER BY `patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			$db4 = new DB;
			$db4->query("SELECT `patientID` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."'");
			if ($db4->num_rows()==0) {
				echo '
<tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r1['instat']==0?' style="display:none;"':"").'>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$name.'</td>
  <td>'.$r1['HospNoDisplay'].'</td>
  <td>'.checkgender($r1['patientID']).'</td>  
  <td>'.calcage($r1['Birth']).'</td>
</tr>'."\n";
			}
		}
	} else {
		$db1 = new DB;
		$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` a INNER JOIN `patient` b ON a.patientID = b.patientID WHERE a.`patientID`='".$r['patientID']."' AND b.`type`='5' ORDER BY a.`patientID` DESC LIMIT 0,1");
		for ($j=0;$j<$db1->num_rows();$j++) {
			$r1 = $db1->fetch_assoc();
			if (@$_GET['query']==1 && $_GET['type']==3) {
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
			$db2c->query("SELECT `patientID`,`HospNo`,`HospNoDisplay`,`Birth`,`instat` FROM `patient` WHERE `patientID`='".$r['patientID']."' AND `type`='5'");
			$r2c = $db2c->fetch_assoc();
			$db2d = new DB;
			$db2d->query("SELECT * FROM `socialform04` WHERE `HospNo`='".$r2c['HospNo']."' ORDER BY `date` DESC LIMIT 0, 1");
			$r2d = $db2d->fetch_assoc();
			if (count($arrAreaBed)==0 || in_array($r1['bed'],$arrAreaBed)) {
				echo '
<tr';
if ($_SESSION['ncareOrgStatus_lwj']==2) {
	if ($r2c['instat']==0) { echo ' style="display:none;"'; }
}
echo '>
  <td><center><a href="index.php?mod=management&func=formview&id=9_2&pid='.$r['patientID'].'" title="Select['.$name.']"><img src="Images/newqa.gif" height="28"></a></center></td>
  <td>'.$r2b['areaName'].'</td>
  <td>'.$r1['bed'].'</td>
  <td>'.$name.'</td>
  <td>'.$r2c['HospNoDisplay'].'</td>
  <td>'.checkgender($r['patientID']).'</td>  
  <td>'.calcage($r2c['Birth']).'</td>
  <td>'.formatdate($r1['indate']).'</td>
</tr>'."\n";
			}
		}
	}
}
?>
</table>
</div>
</div>
</div>
<p>&nbsp;</p>
<script>
$(function(){
	$('#typeTab').tabs();
	$('li.golink a').click(function(){
		location.href='index.php?mod=management&func=formview&id=9_1';
	})
	$('#recordtable1').dataTable();
	$('#recordtable2').dataTable();
	$('#recordtable3').dataTable();
	$('#recordtable5').dataTable();	
	$('#recordtable6').dataTable();	
})
</script>