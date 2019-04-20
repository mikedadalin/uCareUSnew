<?php
$Name1 = $_POST['Name1'];
$Name2 = $_POST['Name2'];
$Name3 = $_POST['Name3'];
$Name4 = $_POST['Name4'];
if($Name2!="" || $Name2!=NULL){$Name2 = " ".$Name2;}
if($Name3!="" || $Name3!=NULL){$Name3 = " ".$Name3;}
if($Name4!="" || $Name4!=NULL){$Name4 = " ".$Name4;}
$Name = $Name1.$Name2.$Name3.$Name4;
$IdentityCardNumber = $_POST['IdentityCardNumber'];
$_POST['MedicareStartDate'] = str_replace('/','',$_POST['MedicareStartDate']);
$MedicareStartDate = str_replace('_','',$_POST['MedicareStartDate']);
$_POST['MedicareEndDate'] = str_replace('/','',$_POST['MedicareEndDate']);
$MedicareEndDate = str_replace('_','',$_POST['MedicareEndDate']);
$Nickname = $_POST['Nickname'];
$MedicalRecordNumber = $_POST['MedicalRecordNumber'];
$MedicareNumber = $_POST['MedicareNumber'];
$MedicaidNumber = $_POST['MedicaidNumber'];
if ($_POST['Sex_1']=="1") { $Sex_1 = '1'; $Sex_2 = '0'; } else { $Sex_1 = '0'; $Sex_2 = '1'; }
if ($_POST['BirthInput'] != NULL) {
	$birth = explode('/',$_POST['BirthInput']);
	$Byear = $birth[0];
	$Bmonth = $birth[1]; if (strlen($Bmonth)==1) { $Bmonth = "0".$Bmonth; }
	$Bday = $birth[2]; if (strlen($Bday)==1) { $Bday = "0".$Bday; }
	$birth = $Byear.$Bmonth.$Bday;
}

$db = new DB;
$db->query("SELECT `HospNo` FROM `patient` ORDER BY `HospNo` DESC LIMIT 0,1");
$r = $db->fetch_assoc();
$newHospNo = ((int)$r['HospNo']) + 1;

$HospNoDisplay = $_POST['HospNoDisplay'];
if ($_POST['type_1']==1) { $type = 1; } elseif ($_POST['type_2']==1) { $type = 2; } elseif ($_POST['type_3']==1) { $type = 3; } elseif ($_POST['type_4']==1) { $type = 4; } elseif ($_POST['type_5']==1) { $type = 5; } else { $type = 1; }

/*== ¥[ START ==*/
$LWJArray = array('Name','Name1','Name2','Name3','Name4','IdentityCardNumber','MedicalRecordNumber','Nickname','MedicareNumber','MedicaidNumber');
$LWJdataArray = array($Name,$Name1,$Name2,$Name3,$Name4,$IdentityCardNumber,$MedicalRecordNumber,$Nickname,$MedicareNumber,$MedicaidNumber);
for($i=0;$i<count($LWJdataArray);$i++){
	$rsa = new lwj('lwj/lwj');
	$part = ceil(strlen($LWJdataArray[$i])/117);
	if($part>1){
		$datapart = str_split($LWJdataArray[$i], 117);
		for($j=0;$j<$part;$j++){
			$puepart = $rsa->pubEncrypt($datapart[$j]);
			${$LWJArray[$i]} = ${$LWJArray[$i]}.$puepart." ";
		}
	}else{
		${$LWJArray[$i]} = $rsa->pubEncrypt($LWJdataArray[$i]);
	}
}
/*== ¥[ END ==*/
$db1 = new DB;
$db1->query("INSERT INTO `patient` VALUES ('','".$newHospNo."', '".$type."', '".$HospNoDisplay."', '".mysql_escape_string($Name1)."', '".mysql_escape_string($Name2)."', '".mysql_escape_string($Name3)."', '".mysql_escape_string($Name4)."', '".$Sex_1."','".$Sex_2."', '".mysql_escape_string($IdentityCardNumber)."', '".$birth."','','','1','','','','','','','','','','','".mysql_escape_string($_POST['Race'])."','".mysql_escape_string($_POST['QInterpreter_1'])."','".mysql_escape_string($_POST['QInterpreter_2'])."','".mysql_escape_string($_POST['QInterpreter_3'])."','".mysql_escape_string($_POST['Language'])."','".$MedicalRecordNumber."','".$Nickname."','".$MedicareNumber."','".mysql_escape_string($_POST['QMedicareCovered_1'])."','".mysql_escape_string($_POST['QMedicareCovered_2'])."','".$MedicareStartDate."','".$MedicareEndDate."','".$MedicaidNumber."','".mysql_escape_string($_POST['QMedicaidStatus_1'])."','".mysql_escape_string($_POST['QMedicaidStatus_2'])."')");
$db1a = new DB;
$db1a->query("SELECT LAST_INSERT_ID()");
$r1a = $db1a->fetch_assoc();
$db2d = new DB;
$db2d->query("INSERT INTO `inpatientinfo` VALUES ('".$r1a['LAST_INSERT_ID()']."', '".mysql_escape_string($_POST['bed'])."', '".date(Ymd)."')");
$db2c = new DB;
$db2c->query("SELECT * FROM `bedinfo` WHERE `bedID`='".mysql_escape_string($_POST['bed'])."'");
if ($db2c->num_rows()==0) {
	$db2a = new DB;
	$db2a->query("INSERT INTO `bedinfo` VALUES ('".mysql_escape_string($_POST['bed'])."', '".mysql_escape_string($_POST['Area'])."', '36000', '0000')");
}
$db2b = new DB;
$db2b->query("INSERT INTO `patientdiscount` (`patientID`) VALUES ('".$r1a['LAST_INSERT_ID()']."')");
$pid = getPID($newHospNo);
$uID = "resident".$newHospNo.$_SESSION['nOrgID_lwj'];
$pd = md5($_POST['IdentityCardNumber']);
$db66 = new DB2;
$db66->query("INSERT INTO `userinfo_resident` VALUES ('".$uID."', '".$_SESSION['nOrgID_lwj']."', '".$pid."', 'Resident', '', '".$pd."', '66', '5', '1', '');");
$serNoArray = array('1','4','7','8','11','14','16','25','26','27','28','29','30','31','32','33','34','36','38','39','40','41','49','50','51','52','53','58','61','62','63','68','70','72','120','121','135');
for($i=0;$i<count($serNoArray);$i++){
	$db0c = new DB2;
	$db0c->query("INSERT INTO `user_permission` VALUES ('".$uID."', '".$serNoArray[$i]."', '1')");
}
echo '<script>window.location.href = "index.php?mod=nurseform&func=formview&pid='.$r1a['LAST_INSERT_ID()'].'&id=1"</script>';
?>