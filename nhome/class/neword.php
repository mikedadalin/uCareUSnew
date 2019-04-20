<?php
include("DB.php");
include("function.php");
include("../lwj/lwj.php");

$PID = mysql_escape_string($_POST['PID']);
$ORDUSER = mysql_escape_string($_POST['ORDUSER']);
$BedID = getBedID($PID);
$HospNo = getHospNo($PID);
//$PName = getPatientName($PID);
$db2 = new DB;
$db2->query("SELECT `Name1`,`Name2`,`Name3`,`Name4` FROM `patient` WHERE `patientID`='".$PID."'");
if ($db2->num_rows()>0) {
	$r2 = $db2->fetch_assoc();
	foreach ($r2 as $k=>$v) {
		${$k} = $v;
	}
}
	/*== 解 START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($Name1,$Name2,$Name3,$Name4);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rsa = new lwj('../lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rsa->privDecrypt($puepart[$j]);
                ${$LWJArray[$i]} = ${$LWJArray[$i]}.$prdpart;
            }
	    }else{
		   ${$LWJArray[$i]} = $rsa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== 解 END ==*/
	if($Name2!="" || $Name2!=NULL){$Name2 = " ".$Name2;}
	if($Name3!="" || $Name3!=NULL){$Name3 = " ".$Name3;}
	if($Name4!="" || $Name4!=NULL){$Name4 = " ".$Name4;}
	$PName = $Name1.$Name2.$Name3.$Name4;
	/*== 加 START ==*/
	$rsa = new lwj('../lwj/lwj');
	$part = ceil(strlen($PName)/117);
	if($part>1){
		$datapart = str_split($PName, 117);
	    for($i=0;$i<$part;$i++){
	    	$puepart = $rsa->pubEncrypt($datapart[$i]);
	    	$PName = $PName.$puepart." ";
    	}
	}else{
	    $PName = $rsa->pubEncrypt($PName);
	}
	/*== 加 END ==*/
	
$dbc1 = new DB;
$dbc1->query("SELECT * FROM `arkordinfo` WHERE `PS_NO`='".$HospNo."' AND `ORD_USER`='".$ORDUSER."' ORDER BY `ORD_SEQ` DESC LIMIT 0,1");
if ($dbc1->num_rows()==0) {
	$db = new DB;
	$db->query("INSERT INTO `arkordinfo` (`ORD_DATE`, `PS_NO`, `PS_NAME`, `BED_NO`, `ORD_USER`) VALUES ('".date('Y-m-d H:i:s')."', '".$HospNo."', '".$PName."', '".$BedID."', '".$ORDUSER."')");
	$db1 = new DB;
	$db1->query("SELECT `ORD_SEQ` FROM `arkordinfo` WHERE `PS_NO`='".$HospNo."' AND `ORD_USER`='".$ORDUSER."' ORDER BY `ORD_DATE` DESC LIMIT 0,1");
	$r1 = $db1->fetch_assoc();
	echo $r1['ORD_SEQ'];
} else {
	$rc1 = $dbc1->fetch_assoc();
	$dbc2 = new DB;
	$dbc2->query("SELECT * FROM `arkord` WHERE `ORD_SEQ`='".$rc1['ORD_SEQ']."'");
	if ($dbc2->num_rows()>0) {
		$db = new DB;
		$db->query("INSERT INTO `arkordinfo` (`ORD_DATE`, `PS_NO`, `PS_NAME`, `BED_NO`, `ORD_USER`) VALUES ('".date('Y-m-d H:i:s')."', '".$HospNo."', '".$PName."', '".$BedID."', '".$ORDUSER."')");
		$db1 = new DB;
		$db1->query("SELECT `ORD_SEQ` FROM `arkordinfo` WHERE `ORD_USER`='".$ORDUSER."' ORDER BY `ORD_DATE` DESC LIMIT 0,1");
		$r1 = $db1->fetch_assoc();
		echo $r1['ORD_SEQ'];
	} else {
		$db1 = new DB;
		$db1->query("UPDATE `arkordinfo` SET `ORD_DATE`='".date('Y-m-d H:i:s')."' WHERE `ORD_SEQ`='".$rc1['ORD_SEQ']."'");
		echo $rc1['ORD_SEQ'];
	}
}
?>

