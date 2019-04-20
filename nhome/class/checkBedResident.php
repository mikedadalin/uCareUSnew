<?php
include("DB.php");
include("../lwj/lwj.php");
$bed = $_POST['bed'];

$db = new DB;
$db->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$bed."'");

if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT `Name1`,`Name2`,`Name3`,`Name4`,`HospNo` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
	$r2 = $db2->fetch_assoc();
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($r2['Name1'],$r2['Name2'],$r2['Name3'],$r2['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('../lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                $r2[$LWJArray[$i]] = $r2[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $r2[$LWJArray[$i]] = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($r2['Name2']!="" || $r2['Name2']!=NULL){$r2['Name2'] = " ".$r2['Name2'];}
    if($r2['Name3']!="" || $r2['Name3']!=NULL){$r2['Name3'] = " ".$r2['Name3'];}
    if($r2['Name4']!="" || $r2['Name4']!=NULL){$r2['Name4'] = " ".$r2['Name4'];}
	$name = $r2['Name1'].$r2['Name2'].$r2['Name3'].$r2['Name4'];
	$data = $name.";".$r2['HospNo'];
	echo $data;
} else {
	echo "NoResident";
}
?>