<?php
include("../lwj/lwj.php");
include("DB.php");
include("function.php");
$med = $_POST['med'];
$db = new DB;
$db->query("SELECT `patientID`, `Name1`, `Name2`, `Name3`, `Name4`, `Gender_1`, `Gender_2`, `Birth` FROM `patient` WHERE `HospNo` = '".mysql_escape_string($med)."'");
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
if($r['Name2']!="" || $r['Name2']!=NULL){
	$r['Name2'] = " ".$r['Name2'];
}
if($r['Name3']!="" || $r['Name3']!=NULL){
	$r['Name3'] = " ".$r['Name3'];
}
if($r['Name4']!="" || $r['Name4']!=NULL){
	$r['Name4'] = " ".$r['Name4'];
}
echo $r['Name1'].",".$r['Name2'].",".$r['Name3'].",".$r['Name4'].",".$r1['indate'].",".$sex.",".$agegroup.",".$diag.",".$r3['Qtotal'];
//echo substr($result,0,(strlen($result)-1));
?>

