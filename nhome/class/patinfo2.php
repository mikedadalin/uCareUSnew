<?php
include("DB.php");
include("function.php");
include("../lwj/lwj.php");
if ($_POST['med']!="") {
	$sql = "SELECT `patientID`, `Name1`, `Name2`, `Name3`, `Name4`, `Gender_1`, `Gender_2`, `Birth` FROM `patient` WHERE `HospNo` = '".mysql_escape_string($_POST['med'])."'";
} elseif ($_POST['Namevar']!="") {
	$sql = "SELECT `patientID`, `Name1`, `Name2`, `Name3`, `Name4`, `Gender_1`, `Gender_2`, `Birth` FROM `patient` WHERE `Name1` LIKE '".mysql_escape_string($_POST['Namevar'])."%'";
} elseif ($_POST['BedIDvar']!="") {
	$sql = "SELECT t2.`patientID`, t2.`Name1`, t2.`Name2`, t2.`Name3`, t2.`Name4`, t2.`Gender_1`, t2.`Gender_2`, `Birth` FROM `inpatientinfo` as t1, `patient` as t2 WHERE t1.`bed`='".mysql_escape_string($_POST['BedIDvar'])."' AND t1.`patientID`=t2.`patientID`";
}else{
	echo "NORECORD";
	die();
}

$db = new DB;
$db->query($sql);
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	if ($r['Gender_1']==1) { $sex = 'Male'; } elseif ($r['Gender_2']==1) { $sex = 'Female'; } else { $sex = ''; }
	$age = round(calcagenum($r['Birth']));
	if ($age<=65) { $agegroup = 'A'; }
	elseif ($age>65 && $age<75) { $agegroup = 'B'; }
	elseif ($age>=75 && $age<85) { $agegroup = 'C'; }
	elseif ($age>=85 && $age<95) { $agegroup = 'D'; }
	elseif ($age>94) { $agegroup = 'E'; }
	$db1 = new DB;
	$db1->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID` = '".mysql_escape_string($r['patientID'])."'");
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo` = '".getHospNo(mysql_escape_string($r['patientID']))."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($i=1;$i<=8;$i++) {
		if ($r2['Qdiag'.$i]!='') { if ($diag!='') { $diag .= '、'; } $diag .= $r2['Qdiag'.$i]; }
	}
	$db3 = new DB;
	$db3->query("SELECT `Qtotal` FROM `nurseform02c` WHERE `HospNo` = '".getHospNo(mysql_escape_string($r['patientID']))."' ORDER BY `date` DESC LIMIT 0,1");
	$r3 = $db3->fetch_assoc();
	$db4 = new DB;
	$db4->query("SELECT `lastoutdate` FROM `sixtarget_part1` WHERE `HospNo` = '".getHospNo(mysql_escape_string($r['patientID']))."' ORDER BY `outdate` DESC LIMIT 0,1");
	if ($db4->num_rows()>0) { $r4 = $db4->fetch_assoc(); }
	//0姓名,1入住日期,2性別,3年齡代碼,4診斷,5ADL分數,6護字號,7床號,8上次出院日期
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r['Name1'],$r['Name2'],$r['Name3'],$r['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('../lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $r[$LWJArray[$i]] = $r[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $r[$LWJArray[$i]] = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($r['Name2']!="" || $r['Name2']!=NULL){$r['Name2'] = " ".$r['Name2'];}
    if($r['Name3']!="" || $r['Name3']!=NULL){$r['Name3'] = " ".$r['Name3'];}
    if($r['Name4']!="" || $r['Name4']!=NULL){$r['Name4'] = " ".$r['Name4'];}	
	$r['Name'] = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	echo $r['Name']."|".$r1['indate']."|".$sex."|".$agegroup."|".$diag."|".$r3['Qtotal'].'|'.getHospNoDisplayByPID($r['patientID']).'|'.getBedID($r['patientID']).'|'.$r4['lastoutdate'];
} else {
	echo "NORECORD";
}
?>

