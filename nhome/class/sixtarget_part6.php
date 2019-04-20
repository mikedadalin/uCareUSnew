<?php
include("DB.php");
include("array.php");
include("function.php");
include("../lwj/lwj.php");
$HospNo = getHospNo($_POST['PID']);
$sDate = mysql_escape_string($_POST['sDate']);
$bwchange = mysql_escape_string($_POST['bwchange']);
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `HospNo`='".$HospNo."'");
$r = $db->fetch_assoc();
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
	$name = $r['Name1'].$r['Name2'].$r['Name3'].$r['Name4'];
	/*== 加 START ==*/
	$rsa = new lwj('../lwj/lwj');
	$part = ceil(strlen($name)/117);
	if($part>1){
       $datapart = str_split($name, 117);
       for($i=0;$i<$part;$i++){
	      	$puepart = $rsa->pubEncrypt($datapart[$i]);
	      	$name = $name.$puepart." ";
       }
	}else{
		$name = $rsa->pubEncrypt($name);
	}
	/*== 加 END ==*/
$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part6` WHERE `HospNo`='".$HospNo."' AND `measuredate`='".$sDate."'");
if ($db1->num_rows()>0) {
	echo "Data already exist in the indicator";
} else {
	$db2 = new DB;
	$db2->query("INSERT INTO `sixtarget_part6` (`targetID`, `HospNo`, `Name`, `measuredate`, `weight`, `Qfiller`) VALUES ('', '".$HospNo."', '".$name."', '".$sDate."', '".$bwchange."', '".mysql_real_escape_string($_POST['Qfiller'])."')");
	echo "Included in the indicator";
}
?>