<?php
include("DB.php");
include("function.php");
include("../lwj/lwj.php");

$Area = $_POST['Area'];

$db = new DB;
$db->query("SELECT * FROM `bedinfo` a LEFT JOIN `inpatientinfo` b ON a.`bedID` = b.`bed` WHERE a.`Area`='".$Area."' AND (b.patientID IS NOT NULL AND b.patientID!='')");

if ($db->num_rows()>0) {
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();

		$db2 = new DB;
		$db2->query("SELECT `Name1`,`Name2`,`Name3`,`Name4` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
			$r2 = $db2->fetch_assoc();
			/*== ¸Ñ START ==*/
			$LWJArray = array('Name1','Name2','Name3','Name4');
			$LWJdataArray = array($r2['Name1'],$r2['Name2'],$r2['Name3'],$r2['Name4']);
			for($z=0;$z<count($LWJdataArray);$z++){
	    		$r2sa = new lwj('../lwj/lwj');
	    		$puepart = explode(" ",$LWJdataArray[$z]);
	    		$puepartcount = count($puepart);
	    		if($puepartcount>1){
            		for($j=0;$j<$puepartcount;$j++){
                		$prdpart = $r2sa->privDecrypt($puepart[$j]);
                		$r2[$LWJArray[$z]] = $r2[$LWJArray[$z]].$prdpart;
            		}
	    		}else{
		   			$r2[$LWJArray[$z]] = $r2sa->privDecrypt($LWJdataArray[$z]);
			    }
			}
			/*== ¸Ñ END ==*/
			if($r2['Name2']!="" || $r2['Name2']!=NULL){$r2['Name2'] = " ".$r2['Name2'];}
    		if($r2['Name3']!="" || $r2['Name3']!=NULL){$r2['Name3'] = " ".$r2['Name3'];}
    		if($r2['Name4']!="" || $r2['Name4']!=NULL){$r2['Name4'] = " ".$r2['Name4'];}
			$r2['Name'] = $r2['Name1'].$r2['Name2'].$r2['Name3'].$r2['Name4'];
	
		if ($out!="") { $out .= ';'; }
		$out .= $r['bedID'].':'.$r['bedID'].' '.$r2['Name'].' ('.getHospNoDisplayByPID($r['patientID']).')';
	}
	echo $out;
} else {
	echo "nobed";
}
?>

