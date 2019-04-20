<?php
include("../lwj/lwj.php");
include("DB.php");
include("function.php");

$strModule = "patient";
$PID = mysql_escape_string($_POST['PID']);

$sql1 = "SELECT a.Name1, b.Discount1, b.Discount2, b.Fidno, a.patientID, a.Name2, a.Name3, a.Name4 FROM `".$strModule."` a left join patientdiscount b on a.".$strModule."ID=b.".$strModule."ID WHERE a.HospNo = '".getHospNoByHospNoDisplayNoType($PID)."' ";
$db = new DB;
$db->query($sql1);

if($db->num_rows()!=0){
	$rs = $db->fetch_assoc();
	/*== ¸Ñ START ==*/
	$LWJArray = array('Name1','Name2','Name3','Name4');
	$LWJdataArray = array($rs['Name1'],$rs['Name2'],$rs['Name3'],$rs['Name4']);
	for($i=0;$i<count($LWJdataArray);$i++){
	    $rssa = new lwj('../lwj/lwj');
	    $puepart = explode(" ",$LWJdataArray[$i]);
	    $puepartcount = count($puepart);
	    if($puepartcount>1){
            for($j=0;$j<$puepartcount;$j++){
                $prdpart = $rssa->privDecrypt($puepart[$j]);
                $rs[$LWJArray[$i]] = $rs[$LWJArray[$i]].$prdpart;
            }
	    }else{
		   $rs[$LWJArray[$i]] = $rssa->privDecrypt($LWJdataArray[$i]);
	    }
	}
	/*== ¸Ñ END ==*/
	if($rs['Name2']!="" || $rs['Name2']!=NULL){$rs['Name2'] = " ".$rs['Name2'];}
	if($rs['Name3']!="" || $rs['Name3']!=NULL){$rs['Name3'] = " ".$rs['Name3'];}
	if($rs['Name4']!="" || $rs['Name4']!=NULL){$rs['Name4'] = " ".$rs['Name4'];}
	$rs['Name1'] = $rs['Name1'].$rs['Name2'].$rs['Name3'].$rs['Name4'];
	echo $rs['Name1'].";".$rs['Fidno'].";".$rs['Discount1'].";".$rs['Discount2'].";".getBedID($rs['patientID']);
}
?>

