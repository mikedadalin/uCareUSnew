<?php
$formID = mysql_escape_string($_POST['formID']);
$HospNo = mysql_escape_string($_POST['HospNo']);
$db = new DB;
$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".$HospNo."'");
$r = $db->fetch_assoc();
$pID = $r['patientID'];

if (@$_GET['action']==NULL) {
	$output = 'CREATE TABLE `'.$formID.'` (`HospNo` varchar(12), `date` varchar(8), ';
	foreach ($_POST as $k=>$v) {
		if (substr($k,0,1)=="Q") { $output .= '`'.$k."` text, "; }
	}
	$output = substr($output,0,strlen($output)-2);
	$output .= ", `Qfiller` text) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = MYISAM;<br>ALTER TABLE  `".$formID."` ADD PRIMARY KEY (  `HospNo` ,  `date` ) ;<br>";
	echo $output;
	echo '<a onclick="window.history.go(-2)">BACK</a>';
} elseif (@$_GET['action']=="show") {
	foreach ($_POST as $k=>$v) {
		//個別表單資料 Individual form information
		if (substr($k,0,1)=="Q" || $k=="date") {
			if ($k=="date") { $v = str_replace('/','',$v); }
			if ($k=="date") { $v = str_replace('_','',$v); }
			echo "UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."' AND `date`='".mysql_escape_string($_POST['date'])."'<br>";
		}
	}
	echo '<a onclick="window.history.go(-2)">BACK</a>';
} elseif (@$_GET['action']=="save") {
	if ($_POST['date']==NULL) {
		$filldate = date(Ymd);
		$db1 = new DB;
		$db1->query("SELECT * FROM `".$formID."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
	} else {
		if(substr($formID,0,7)=="mdsform"){
			$filldate = str_replace('/','-',$_POST['date']);
		}else{
			$filldate = str_replace('/','',$_POST['date']);
		}
		$db1 = new DB;
		$db1->query("SELECT * FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
	}
	if ($db1->num_rows()==0) {
		//New record
		echo "New record";
		$db2a = new DB;
		$db2a->query("INSERT INTO `".$formID."` (`HospNo`, `date`,`Qfiller`) VALUES ('".$HospNo."', '".$filldate."','".$_SESSION['ncareID_lwj']."');");
			if ($formID=="nurseform02a"){
				if ($_POST['Q48a']!="" && $_POST['Q48b']!=""){
				    $db4 = new DB;
				    $db4->query("SELECT `no` FROM `nurseform02n` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
				    $r4 = $db4->fetch_assoc();
				    if ($db4->num_rows()>0) {
    				    $newon = $r4['no'];
				    }else{
					    $newon = 1;
				    }
					if ($db4->num_rows()>0) {
						$newon = $newon+1;
					}
					$_POST['Q48e'] = $newon;
				    $db = new DB;
				    $db->query("SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['Q48e'])."'");
				    if ($db->num_rows()==0) {
					    $db1 = new DB;
					    $db1->query("INSERT INTO `nurseform02n` (`HospNo`, `date`, `no`, `nID`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['Q48e'])."', '');");
					}
				    $theno = $_POST['Q48e'];
				    $db3 = new DB;
					$Q1tablename= "Q1_".$_POST['Q48a'];
					$Qtypetablename= "Qtype_".$_POST['Q48b'];
				    $db3->query("UPDATE `nurseform02n` SET `".$Q1tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3->query("UPDATE `nurseform02n` SET `".$Qtypetablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					if ($_POST['Q48d_1']!=1){
						$db3->query("UPDATE `nurseform02n` SET `Q2`='".mysql_escape_string($_POST['Q48c'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					}
					$db3->query("UPDATE `nurseform02n` SET `Q14_2`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3 = new DB;
				    $db3->query("UPDATE `nurseform02n` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");					
				}
				if ($_POST['Q49a']!="" && $_POST['Q49b']!=""){
				    $db4 = new DB;
				    $db4->query("SELECT `no` FROM `nurseform02n` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
				    $r4 = $db4->fetch_assoc();
				    if ($db4->num_rows()>0) {
    				    $newon = $r4['no'];
				    }else{
					    $newon = 1;
				    }
					if ($db4->num_rows()>0) {
						$newon = $newon+1;
					}
					$_POST['Q49e'] = $newon;
				    $db = new DB;
				    $db->query("SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['Q49e'])."'");
				    if ($db->num_rows()==0) {
					    $db1 = new DB;
					    $db1->query("INSERT INTO `nurseform02n` (`HospNo`, `date`, `no`, `nID`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['Q49e'])."', '');");
					}
				    $theno = $_POST['Q49e'];
				    $db3 = new DB;
					$Q1tablename= "Q1_".$_POST['Q49a'];
					$Qtypetablename= "Qtype_".$_POST['Q49b'];
				    $db3->query("UPDATE `nurseform02n` SET `".$Q1tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3->query("UPDATE `nurseform02n` SET `".$Qtypetablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					if ($_POST['Q49d_1']!=1){
						$db3->query("UPDATE `nurseform02n` SET `Q2`='".mysql_escape_string($_POST['Q49c'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					}
					$db3->query("UPDATE `nurseform02n` SET `Q14_2`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3 = new DB;
				    $db3->query("UPDATE `nurseform02n` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");					
				}
				if ($_POST['Q50a']!="" && $_POST['Q50b']!=""){
				    $db4 = new DB;
				    $db4->query("SELECT `no` FROM `nurseform02n` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
				    $r4 = $db4->fetch_assoc();
				    if ($db4->num_rows()>0) {
    				    $newon = $r4['no'];
				    }else{
					    $newon = 1;
				    }
					if ($db4->num_rows()>0) {
						$newon = $newon+1;
					}
					$_POST['Q50e'] = $newon;
				    $db = new DB;
				    $db->query("SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['Q50e'])."'");
				    if ($db->num_rows()==0) {
					    $db1 = new DB;
					    $db1->query("INSERT INTO `nurseform02n` (`HospNo`, `date`, `no`, `nID`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['Q50e'])."', '');");
					}
				    $theno = $_POST['Q50e'];
				    $db3 = new DB;
					$Q1tablename= "Q1_".$_POST['Q50a'];
					$Qtypetablename= "Qtype_".$_POST['Q50b'];
				    $db3->query("UPDATE `nurseform02n` SET `".$Q1tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3->query("UPDATE `nurseform02n` SET `".$Qtypetablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					if ($_POST['Q50d_1']!=1){
						$db3->query("UPDATE `nurseform02n` SET `Q2`='".mysql_escape_string($_POST['Q50c'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					}
					$db3->query("UPDATE `nurseform02n` SET `Q14_2`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3 = new DB;
				    $db3->query("UPDATE `nurseform02n` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");					
				}
				/*===========================*/
				if ($_POST['Q52a']!="" && $_POST['Q52b']!=""){
				    $db4 = new DB;
				    $db4->query("SELECT `no` FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
				    $r4 = $db4->fetch_assoc();
				    if ($db4->num_rows()>0) {
    				    $newon = $r4['no'];
				    }else{
					    $newon = 1;
				    }
					if ($db4->num_rows()>0) {
						$newon = $newon+1;
					}
					$_POST['Q52e'] = $newon;
				    $db = new DB;
				    $db->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['Q52e'])."'");
				    if ($db->num_rows()==0) {
					    $db1 = new DB;
					    $db1->query("INSERT INTO `nurseform02g_2` (`HospNo`, `date`, `no`, `ReportID`, `CheckInRecord`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['Q52e'])."', '', '0');");
					}
				    $theno = $_POST['Q52e'];
				    $db3 = new DB;
					$Q2tablename= "Q2_".$_POST['Q52a'];
					$Q4tablename= "Q4_".$_POST['Q52b'];
				    $db3->query("UPDATE `nurseform02g_2` SET `".$Q2tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3->query("UPDATE `nurseform02g_2` SET `".$Q4tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					if ($_POST['Q52d_1']!=1){
						$db3->query("UPDATE `nurseform02g_2` SET `Q7`='".mysql_escape_string($_POST['Q52c'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					}
					$db3->query("UPDATE `nurseform02g_2` SET `Q3_2`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3 = new DB;
				    $db3->query("UPDATE `nurseform02g_2` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");					
				}
				if ($_POST['Q53a']!="" && $_POST['Q53b']!=""){
				    $db4 = new DB;
				    $db4->query("SELECT `no` FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
				    $r4 = $db4->fetch_assoc();
				    if ($db4->num_rows()>0) {
    				    $newon = $r4['no'];
				    }else{
					    $newon = 1;
				    }
					if ($db4->num_rows()>0) {
						$newon = $newon+1;
					}
					$_POST['Q53e'] = $newon;
				    $db = new DB;
				    $db->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['Q53e'])."'");
				    if ($db->num_rows()==0) {
					    $db1 = new DB;
					    $db1->query("INSERT INTO `nurseform02g_2` (`HospNo`, `date`, `no`, `ReportID`, `CheckInRecord`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['Q53e'])."', '', '0');");
					}
				    $theno = $_POST['Q53e'];
				    $db3 = new DB;
					$Q2tablename= "Q2_".$_POST['Q53a'];
					$Q4tablename= "Q4_".$_POST['Q53b'];
				    $db3->query("UPDATE `nurseform02g_2` SET `".$Q2tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3->query("UPDATE `nurseform02g_2` SET `".$Q4tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					if ($_POST['Q53d_1']!=1){
						$db3->query("UPDATE `nurseform02g_2` SET `Q7`='".mysql_escape_string($_POST['Q53c'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					}
					$db3->query("UPDATE `nurseform02g_2` SET `Q3_2`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3 = new DB;
				    $db3->query("UPDATE `nurseform02g_2` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");					
				}
				if ($_POST['Q54a']!="" && $_POST['Q54b']!=""){
				    $db4 = new DB;
				    $db4->query("SELECT `no` FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' ORDER BY `no` DESC");
				    $r4 = $db4->fetch_assoc();
				    if ($db4->num_rows()>0) {
    				    $newon = $r4['no'];
				    }else{
					    $newon = 1;
				    }
					if ($db4->num_rows()>0) {
						$newon = $newon+1;
					}
					$_POST['Q54e'] = $newon;
				    $db = new DB;
				    $db->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['Q54e'])."'");
				    if ($db->num_rows()==0) {
					    $db1 = new DB;
					    $db1->query("INSERT INTO `nurseform02g_2` (`HospNo`, `date`, `no`, `ReportID`, `CheckInRecord`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['Q54e'])."', '', '0');");
					}
				    $theno = $_POST['Q54e'];
				    $db3 = new DB;
					$Q2tablename= "Q2_".$_POST['Q54a'];
					$Q4tablename= "Q4_".$_POST['Q54b'];
				    $db3->query("UPDATE `nurseform02g_2` SET `".$Q2tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3->query("UPDATE `nurseform02g_2` SET `".$Q4tablename."`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					if ($_POST['Q54d_1']!=1){
						$db3->query("UPDATE `nurseform02g_2` SET `Q7`='".mysql_escape_string($_POST['Q54c'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
					}
					$db3->query("UPDATE `nurseform02g_2` SET `Q3_2`='1' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
				    $db3 = new DB;
				    $db3->query("UPDATE `nurseform02g_2` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");					
				}
			}
		foreach ($_POST as $k=>$v) {
			if($k!="SelectQmedtime" && $k!="SelectQmedday"){
			$dbO1 = new DB2;
			$dbO1->query("SELECT * FROM `formoptions` WHERE `tablename`='".$formID."' AND `qname`='".$k."'");
			if ($dbO1->num_rows()==0) {
				$dbO2 = new DB2;
				$dbO2->query("INSERT INTO `formoptions` VALUES ('".$formID."', '".$k."', '');");
			}
			if (substr($k,0,1)=="Q" || $k=="date") {
				if ($k=="date") {
					$v = str_replace('/','',$v);
					$v = str_replace('_','',$v);
				}
				if($formID=="socialform32" || $formID=="socialform33" || $formID=="socialform35" || $formID=="socialform36"){
					if ($k=="Q2") {
						$height = explode("'",$v);
						$v = (int)$height[0]*12+(int)$height[1];
					}
				}
				if($formID=="socialform21_1"){
					if ($k=="Q1") {
					    /*== 加 START ==*/
	  					$rsa = new lwj('lwj/lwj');
	  					$part = ceil(strlen($v)/117);
	  					if($part>1){
        					$datapart = str_split($v, 117);
        					for($i=0;$i<$part;$i++){
	      					$puepart = $rsa->pubEncrypt($datapart[$i]);
	      					$v = $v.$puepart." ";
        					}
	  					}else{
		  					$v = $rsa->pubEncrypt($v);
	  					}
					    /*== 加 END ==*/
					}
				}
				if($formID=="nurseform11"){
					if ($k=="Q5") {
						$height = explode("'",$v);
						$v = (int)$height[0]*12+(int)$height[1];
					}
				}
				if($formID=="nurseform01"){
					if ($k=="QContactPerson1Name" || $k=="QContactPerson1Company" || $k=="QContactPerson1Tel1" || $k=="QContactPerson1Tel2" || $k=="QContactPerson1Tel3" || $k=="QContactPerson1Address" || $k=="QContactPerson1Email" || $k=="QContactPerson2Name" || $k=="QContactPerson2Company" || $k=="QContactPerson2Tel1" || $k=="QContactPerson2Tel2" || $k=="QContactPerson2Tel3" || $k=="QContactPerson2Address" || $k=="QContactPerson2Email" || $k=="QContactPerson3Name" || $k=="QContactPerson3Company" || $k=="QContactPerson3Tel1" || $k=="QContactPerson3Tel2" || $k=="QContactPerson3Tel3" || $k=="QContactPerson3Address" || $k=="QContactPerson3Email" || $k=="QContactPerson4Name" || $k=="QContactPerson4Company" || $k=="QContactPerson4Tel1" || $k=="QContactPerson4Tel2" || $k=="QContactPerson4Tel3" || $k=="QContactPerson4Address" || $k=="QContactPerson4Email") {
					    /*== 加 START ==*/
	  					$rsa = new lwj('lwj/lwj');
	  					$part = ceil(strlen($v)/117);
	  					if($part>1){
        					$datapart = str_split($v, 117);
        					for($i=0;$i<$part;$i++){
	      					$puepart = $rsa->pubEncrypt($datapart[$i]);
	      					$v = $v.$puepart." ";
        					}
	  					}else{
		  					$v = $rsa->pubEncrypt($v);
	  					}
					    /*== 加 END ==*/
					}
				}
				if($formID=="nurseform01a"){
					if ($k=="Qphone0" || $k=="Qmail0" || $k=="Qphone1" || $k=="Qmail1" || $k=="Qphone2" || $k=="Qmail2" || $k=="Qphone3" || $k=="Qmail3" || $k=="Qphone4" || $k=="Qmail4" || $k=="Qphone5" || $k=="Qmail5" || $k=="Qphone6" || $k=="Qmail6" || $k=="Qphone7" || $k=="Qmail7" || $k=="Qphone8" || $k=="Qmail8" || $k=="Qphone9" || $k=="Qmail9" || $k=="Qphone10" || $k=="Qmail10" || $k=="Qphone11" || $k=="Qmail11" || $k=="Qphone12" || $k=="Qmail12" || $k=="Qphone13" || $k=="Qmail13" || $k=="Qphone14" || $k=="Qmail14" || $k=="Qphone15" || $k=="Qmail15" || $k=="Qphone16" || $k=="Qmail16" || $k=="Qphone17" || $k=="Qmail17") {
					    if($v!=""){
						   /*== 加 START ==*/
	  					   $rsa = new lwj('lwj/lwj');
	  					   $part = ceil(strlen($v)/117);
	  					   if($part>1){
        					   $datapart = str_split($v, 117);
        					   for($i=0;$i<$part;$i++){
	      					      $puepart = $rsa->pubEncrypt($datapart[$i]);
	      					      $v = $v.$puepart." ";
        					   }
	  					   }else{
		  					   $v = $rsa->pubEncrypt($v);
	  					   }
					       /*== 加 END ==*/							
						}
					}
				}
				//個別表單資料
				$db2b = new DB;
				$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
			} else {
				//共同欄位 Joint table
				if ($k!="formID" && $k!="HospNo") {
					$arrTableField = explode("_",$k);
					if (count($arrTableField)==3) { $fieldname = $arrTableField[1].'_'.$arrTableField[2]; } else { $fieldname = $arrTableField[1]; }
					if ($arrTableField[1]=="Gender") { $arrTableField[1]= "Gender_".$arrTableField[2]; }
					if ($arrTableField[1]=="height") {
						$height = explode("'",$v);
						$v = (int)$height[0]*12+(int)$height[1];
					}
					if ($arrTableField[1]=="Birth" || $arrTableField[1]=="indate" || $arrTableField[1]=="outdate" || $arrTableField[1]=="MedicareStartDate" || $arrTableField[1]=="MedicareEndDate") {
						$v = str_replace('/','',$v);
						$v = str_replace('_','',$v);
					}
					if ($arrTableField[1]=="Name1" || $arrTableField[1]=="Name2" || $arrTableField[1]=="Name3" || $arrTableField[1]=="Name4" || $arrTableField[1]=="IdNo" || $arrTableField[1]=="MedicalRecordNumber" || $arrTableField[1]=="Nickname" || $arrTableField[1]=="MedicareNumber" || $arrTableField[1]=="MedicaidNumber" || $arrTableField[1]=="Postcode" || $arrTableField[1]=="Address" || $arrTableField[1]=="Address2" || $arrTableField[1]=="Address3" || $arrTableField[1]=="Address4" || $arrTableField[1]=="Address5") {
					    /*== 加 START ==*/
	  					$rsa = new lwj('lwj/lwj');
	  					$part = ceil(strlen($v)/117);
	  					if($part>1){
        					$datapart = str_split($v, 117);
        					for($i=0;$i<$part;$i++){
	      					$puepart = $rsa->pubEncrypt($datapart[$i]);
	      					$v = $v.$puepart." ";
        					}
	  					}else{
		  					$v = $rsa->pubEncrypt($v);
	  					}
					    /*== 加 END ==*/
					}
					if (substr($arrTableField[0],0,9)=="nurseform") {
						$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
					} elseif (substr($arrTableField[0],0,10)=="socialform") {
						$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
					} else {
						$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `patientID`='".$pID."'";
					}
					$db2b = new DB;
					$db2b->query($commonsql);
				}
			}
			}
		}
	} else {
		$r1 = $db1->fetch_assoc();
		$daylastfill = calcperiod($r1['date'],$filldate);
		if ($arrFormFreq[$formID]==99 || $arrFormFreq[$formID] == -1 || $r1['date']==$filldate) {
			//更新原本紀錄 (無需定期更新資料) update original record(no need to update annually)
			echo "Update original record (Do NOT need for regular updates)";
			if ($r1['Qfiller']!="" && $r1['Qfiller']!=$_SESSION['ncareID_lwj'] && $_SESSION['ncareLevel_lwj']<4) {
				echo '<script>alert("Insufficient permissions! Please notify the original input personnel to modify or select other dates to save as a new data!");history.go(-1);</script>';
			} else {
                include('MDS-Checkbox.php'); /*Checkbox數據更新*/
				foreach ($_POST as $k=>$v) {
					if($k!="SelectQmedtime" && $k!="SelectQmedday"){
						$dbO1 = new DB2;
						$dbO1->query("SELECT * FROM `formoptions` WHERE `tablename`='".$formID."' AND `qname`='".$k."'");
						if ($dbO1->num_rows()==0) {
							$dbO2 = new DB2;
							$dbO2->query("INSERT INTO `formoptions` VALUES ('".$formID."', '".$k."', '');");
						}
						//個別表單資料
						if (substr($k,0,1)=="Q" || $k=="date") {
							if ($k=="date") {
								if(substr($formID,0,7)=="mdsform"){
									$v = str_replace('/','-',$v);
								}else{
									$v = str_replace('/','',$v);
									$v = str_replace('_','',$v);
								}
							}
							if($formID=="socialform32" || $formID=="socialform33" || $formID=="socialform35" || $formID=="socialform36"){
								if ($k=="Q2") {
									$height = explode("'",$v);
									$v = (int)$height[0]*12+(int)$height[1];
								}
							}
							if($formID=="nurseform11"){
								if ($k=="Q5") {
									$height = explode("'",$v);
									$v = (int)$height[0]*12+(int)$height[1];
								}
							}
							if($formID=="nurseform01"){
								if ($k=="QContactPerson1Name" || $k=="QContactPerson1Company" || $k=="QContactPerson1Tel1" || $k=="QContactPerson1Tel2" || $k=="QContactPerson1Tel3" || $k=="QContactPerson1Address" || $k=="QContactPerson1Email" || $k=="QContactPerson2Name" || $k=="QContactPerson2Company" || $k=="QContactPerson2Tel1" || $k=="QContactPerson2Tel2" || $k=="QContactPerson2Tel3" || $k=="QContactPerson2Address" || $k=="QContactPerson2Email" || $k=="QContactPerson3Name" || $k=="QContactPerson3Company" || $k=="QContactPerson3Tel1" || $k=="QContactPerson3Tel2" || $k=="QContactPerson3Tel3" || $k=="QContactPerson3Address" || $k=="QContactPerson3Email" || $k=="QContactPerson4Name" || $k=="QContactPerson4Company" || $k=="QContactPerson4Tel1" || $k=="QContactPerson4Tel2" || $k=="QContactPerson4Tel3" || $k=="QContactPerson4Address" || $k=="QContactPerson4Email") {
									/*== 加 START ==*/
									$rsa = new lwj('lwj/lwj');
									$part = ceil(strlen($v)/117);
									if($part>1){
										$datapart = str_split($v, 117);
										for($i=0;$i<$part;$i++){
											$puepart = $rsa->pubEncrypt($datapart[$i]);
											$v = $v.$puepart." ";
										}
									}else{
										$v = $rsa->pubEncrypt($v);
									}
									/*== 加 END ==*/
								}
							}
							if($formID=="nurseform01a"){
								if ($k=="Qphone0" || $k=="Qmail0" || $k=="Qphone1" || $k=="Qmail1" || $k=="Qphone2" || $k=="Qmail2" || $k=="Qphone3" || $k=="Qmail3" || $k=="Qphone4" || $k=="Qmail4" || $k=="Qphone5" || $k=="Qmail5" || $k=="Qphone6" || $k=="Qmail6" || $k=="Qphone7" || $k=="Qmail7" || $k=="Qphone8" || $k=="Qmail8" || $k=="Qphone9" || $k=="Qmail9" || $k=="Qphone10" || $k=="Qmail10" || $k=="Qphone11" || $k=="Qmail11" || $k=="Qphone12" || $k=="Qmail12" || $k=="Qphone13" || $k=="Qmail13" || $k=="Qphone14" || $k=="Qmail14" || $k=="Qphone15" || $k=="Qmail15" || $k=="Qphone16" || $k=="Qmail16" || $k=="Qphone17" || $k=="Qmail17") {
									if($v!=""){
									/*== 加 START ==*/
									$rsa = new lwj('lwj/lwj');
									$part = ceil(strlen($v)/117);
									if($part>1){
										$datapart = str_split($v, 117);
										for($i=0;$i<$part;$i++){
											$puepart = $rsa->pubEncrypt($datapart[$i]);
											$v = $v.$puepart." ";
										}
									}else{
										$v = $rsa->pubEncrypt($v);
									}
									/*== 加 END ==*/
									}
								}
							}
							if($formID=="mdsform02"){
								if ($k=="QA0500A_1" || $k=="QA0500A_2" || $k=="QA0500A_3" || $k=="QA0500A_4" || $k=="QA0500A_5" || $k=="QA0500A_6" || $k=="QA0500A_7" || $k=="QA0500A_8" || $k=="QA0500A_9" || $k=="QA0500A_10" || $k=="QA0500A_11" || $k=="QA0500A_12" || $k=="QA0500B" || $k=="QA0500C_1" || $k=="QA0500C_2" || $k=="QA0500C_3" || $k=="QA0500C_4" || $k=="QA0500C_5" || $k=="QA0500C_6" || $k=="QA0500C_7" || $k=="QA0500C_8" || $k=="QA0500C_9" || $k=="QA0500C_10" || $k=="QA0500C_11" || $k=="QA0500C_12" || $k=="QA0500C_13" || $k=="QA0500C_14" || $k=="QA0500C_15" || $k=="QA0500C_16" || $k=="QA0500C_17" || $k=="QA0500C_18" || $k=="QA0500D_1" || $k=="QA0500D_2" || $k=="QA0500D_3" || $k=="QA0600A_1" || $k=="QA0600A_2" || $k=="QA0600A_3" || $k=="QA0600A_4" || $k=="QA0600A_5" || $k=="QA0600A_6" || $k=="QA0600A_7" || $k=="QA0600A_8" || $k=="QA0600A_9" || $k=="QA0600B_1" || $k=="QA0600B_2" || $k=="QA0600B_3" || $k=="QA0600B_4" || $k=="QA0600B_5" || $k=="QA0600B_6" || $k=="QA0600B_7" || $k=="QA0600B_8" || $k=="QA0600B_9" || $k=="QA0600B_10" || $k=="QA0600B_11" || $k=="QA0600B_12" || $k=="QA0700_1" || $k=="QA0700_2" || $k=="QA0700_3" || $k=="QA0700_4" || $k=="QA0700_5" || $k=="QA0700_6" || $k=="QA0700_7" || $k=="QA0700_8" || $k=="QA0700_9" || $k=="QA0700_10" || $k=="QA0700_11" || $k=="QA0700_12") {
									/*== 加 START ==*/
									$rsa = new lwj('lwj/lwj');
									$part = ceil(strlen($v)/117);
									if($part>1){
										$datapart = str_split($v, 117);
										for($z=0;$z<$part;$z++){
											$puepart = $rsa->pubEncrypt($datapart[$z]);
											$v = $v.$puepart." ";
										}
									}else{
										$v = $rsa->pubEncrypt($v);
									}
									/*== 加 END ==*/
								}
							}
							if($formID=="mdsform03"){
								if ($k=="QA1300A_1" || $k=="QA1300A_2" || $k=="QA1300A_3" || $k=="QA1300A_4" || $k=="QA1300A_5" || $k=="QA1300A_6" || $k=="QA1300A_7" || $k=="QA1300A_8" || $k=="QA1300A_9" || $k=="QA1300A_10" || $k=="QA1300A_11" || $k=="QA1300A_12") {
									/*== 加 START ==*/
									$rsa = new lwj('lwj/lwj');
									$part = ceil(strlen($v)/117);
									if($part>1){
										$datapart = str_split($v, 117);
										for($z=0;$z<$part;$z++){
											$puepart = $rsa->pubEncrypt($datapart[$z]);
											$v = $v.$puepart." ";
										}
									}else{
										$v = $rsa->pubEncrypt($v);
									}
									/*== 加 END ==*/
								}
							}
							if($formID=="mdsform37"){
								if ($k=="QX0200A_1" || $k=="QX0200A_2" || $k=="QX0200A_3" || $k=="QX0200A_4" || $k=="QX0200A_5" || $k=="QX0200A_6" || $k=="QX0200A_7" || $k=="QX0200A_8" || $k=="QX0200A_9" || $k=="QX0200A_10" || $k=="QX0200A_11" || $k=="QX0200A_12" || $k=="QX0200C_1" || $k=="QX0200C_2" || $k=="QX0200C_3" || $k=="QX0200C_4" || $k=="QX0200C_5" || $k=="QX0200C_6" || $k=="QX0200C_7" || $k=="QX0200C_8" || $k=="QX0200C_9" || $k=="QX0200C_10" || $k=="QX0200C_11" || $k=="QX0200C_12" || $k=="QX0200C_13" || $k=="QX0200C_14" || $k=="QX0200C_15" || $k=="QX0200C_16" || $k=="QX0200C_17" || $k=="QX0200C_18" || $k=="QX0500_1" || $k=="QX0500_2" || $k=="QX0500_3" || $k=="QX0500_4" || $k=="QX0500_5" || $k=="QX0500_6" || $k=="QX0500_7" || $k=="QX0500_8" || $k=="QX0500_9") {
									/*== 加 START ==*/
									$rsa = new lwj('lwj/lwj');
									$part = ceil(strlen($v)/117);
									if($part>1){
										$datapart = str_split($v, 117);
										for($z=0;$z<$part;$z++){
											$puepart = $rsa->pubEncrypt($datapart[$z]);
											$v = $v.$puepart." ";
										}
									}else{
										$v = $rsa->pubEncrypt($v);
									}
									/*== 加 END ==*/
								}
							}
							$db2b = new DB;
							$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."' AND `date`='".$r1['date']."'");
						} else {
							//共同欄位 Joint table
							if ($k!="formID" && $k!="HospNo") {
								$arrTableField = explode("_",$k);
								if (count($arrTableField)==3) { $fieldname = $arrTableField[1].'_'.$arrTableField[2]; } else { $fieldname = $arrTableField[1]; }
								if ($arrTableField[1]=="Gender") { $arrTableField[1]= "Gender_".$arrTableField[2]; }
								if ($arrTableField[1]=="height") {
									$height = explode("'",$v);
									$v = (int)$height[0]*12+(int)$height[1];
								}
								if ($arrTableField[1]=="Birth" || $arrTableField[1]=="indate" || $arrTableField[1]=="outdate" || $arrTableField[1]=="MedicareStartDate" || $arrTableField[1]=="MedicareEndDate") {
									$v = str_replace('/','',$v);
									$v = str_replace('_','',$v);
								}
								if ($arrTableField[1]=="Name1" || $arrTableField[1]=="Name2" || $arrTableField[1]=="Name3" || $arrTableField[1]=="Name4" || $arrTableField[1]=="IdNo" || $arrTableField[1]=="MedicalRecordNumber" || $arrTableField[1]=="Nickname" || $arrTableField[1]=="MedicareNumber" || $arrTableField[1]=="MedicaidNumber" || $arrTableField[1]=="Postcode" || $arrTableField[1]=="Address" || $arrTableField[1]=="Address2" || $arrTableField[1]=="Address3" || $arrTableField[1]=="Address4" || $arrTableField[1]=="Address5") {
									/*== 加 START ==*/
									$rsa = new lwj('lwj/lwj');
									$part = ceil(strlen($v)/117);
									if($part>1){
										$datapart = str_split($v, 117);
										for($i=0;$i<$part;$i++){
											$puepart = $rsa->pubEncrypt($datapart[$i]);
											$v = $v.$puepart." ";
										}
									}else{
										$v = $rsa->pubEncrypt($v);
									}
									/*== 加 END ==*/
								}
								if (substr($arrTableField[0],0,9)=="nurseform") {
									$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
								} elseif (substr($arrTableField[0],0,10)=="socialform") {
									$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
								} else {
									$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `patientID`='".$pID."'";
								}
								$db2b = new DB;
								$db2b->query($commonsql);
							}
						}
					}
				}
			}
		} elseif ($daylastfill>=$arrFormFreq[$_POST['formID']]) {
			//比對過日期，新紀錄 confirmed date,new record
			echo "比對過日期，新紀錄confirmed date,new record";
			$db2a = new DB;
			$db2a->query("INSERT INTO `".$formID."` (`HospNo`, `date`,`Qfiller`) VALUES ('".$HospNo."', '".$filldate."','".$_SESSION['ncareID_lwj']."');");
			foreach ($_POST as $k=>$v) {
				
				$dbO1 = new DB2;
				$dbO1->query("SELECT * FROM `formoptions` WHERE `tablename`='".$formID."' AND `qname`='".$k."'");
				if ($dbO1->num_rows()==0) {
					$dbO2 = new DB2;
					$dbO2->query("INSERT INTO `formoptions` VALUES ('".$formID."', '".$k."', '');");
				}
				
				//個別表單資料
				if (substr($k,0,1)=="Q" || $k=="date") {
					if ($k=="date") {
						$v = str_replace('/','',$v);
						$v = str_replace('_','',$v);
					}
					if($formID=="socialform32" || $formID=="socialform33" || $formID=="socialform35" || $formID=="socialform36"){
						if ($k=="Q2") {
							$height = explode("'",$v);
							$v = (int)$height[0]*12+(int)$height[1];
						}
					}
					if($formID=="nurseform11"){
						if ($k=="Q5") {
							$height = explode("'",$v);
							$v = (int)$height[0]*12+(int)$height[1];
						}
					}
					$db2b = new DB;
					$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
				} else {
					//共同欄位  Joint table
					if ($k!="formID" && $k!="HospNo") {
						$arrTableField = explode("_",$k);
						if (count($arrTableField)==3) { $fieldname = $arrTableField[1].'_'.$arrTableField[2]; } else { $fieldname = $arrTableField[1]; }
						if ($arrTableField[1]=="Gender") { $arrTableField[1]= "Gender_".$arrTableField[2]; }
						if ($arrTableField[1]=="Birth" || $arrTableField[1]=="indate" || $arrTableField[1]=="outdate") {
							$v = str_replace('/','',$v);
							$v = str_replace('_','',$v);
						}
					    if ($arrTableField[1]=="height") {
							$height = explode("'",$v);
							$v = (int)$height[0]*12+(int)$height[1];
						}
						if (substr($arrTableField[0],0,9)=="nurseform") {
							$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
						} elseif (substr($arrTableField[0],0,10)=="socialform") {
							$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
						} else {
							$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `patientID`='".$pID."'";
						}
						$db2b = new DB;
						$db2b->query($commonsql);
					}
				}
			}
		} else {
			//更新原本紀錄  update original record
			echo "更新原本紀錄update original record";
			if ($r1['Qfiller']!="" && $r1['Qfiller']!=$_SESSION['ncareID_lwj'] && $_SESSION['ncareLevel_lwj']<4) {
				echo '<script>alert("Insufficient permissions! Please notify the original input personnel to modify or select other dates to save as a new data!");history.go(-1);</script>';
			} else {
				foreach ($_POST as $k=>$v) {
					
					$dbO1 = new DB2;
					$dbO1->query("SELECT * FROM `formoptions` WHERE `tablename`='".$formID."' AND `qname`='".$k."'");
					if ($dbO1->num_rows()==0) {
						$dbO2 = new DB2;
						$dbO2->query("INSERT INTO `formoptions` VALUES ('".$formID."', '".$k."', '');");
					}
					
					//個別表單資料
					if (substr($k,0,1)=="Q" || $k=="date") {
						if ($k=="date") {
							$v = str_replace('/','',$v);
							$v = str_replace('_','',$v);
						}
						if($formID=="socialform32" || $formID=="socialform33" || $formID=="socialform35" || $formID=="socialform36"){
							if ($k=="Q2") {
								$height = explode("'",$v);
								$v = (int)$height[0]*12+(int)$height[1];
							}
						}
						if($formID=="nurseform11"){
							if ($k=="Q5") {
								$height = explode("'",$v);
								$v = (int)$height[0]*12+(int)$height[1];
							}
						}
						$db2b = new DB;
						$db2b->query("UPDATE `".$formID."` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."' AND `date`='".$r1['date']."'");
					} else {
						//共同欄位 Joint table
						if ($k!="formID" && $k!="HospNo") {
							$arrTableField = explode("_",$k);
							if (count($arrTableField)==3) { $fieldname = $arrTableField[1].'_'.$arrTableField[2]; } else { $fieldname = $arrTableField[1]; }
							if ($arrTableField[0]=="familystructure") {
								//家族圖
							} else {
								if ($arrTableField[1]=="Gender") { $arrTableField[1]= "Gender_".$arrTableField[2]; }
								if ($arrTableField[1]=="Birth"|| $arrTableField[1]=="indate" || $arrTableField[1]=="outdate") {
									$v = str_replace('/','',$v);
									$v = str_replace('_','',$v);
								}
								if (substr($arrTableField[0],0,9)=="nurseform") {
									$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
								} elseif (substr($arrTableField[0],0,10)=="socialform") {
									$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `HospNo`='".$HospNo."'";
								} else {
									$commonsql = "UPDATE `".$arrTableField[0]."` SET `".$fieldname."`='".mysql_escape_string($v)."' WHERE `patientID`='".$pID."'";
								}
								$db2b = new DB;
								$db2b->query($commonsql);
							}
						}
					}
				}
			}
		}
	}
	if ($_GET['url']!="" && $_GET['url']!=NULL) {
		echo "<script>location.replace('".urldecode($_GET['url'])."')</script>";
	} else {
		if(isset($_SESSION['GNO'])){
			$GNO_Change = 0;
			$kGF3 = 'Gname_'.$_SESSION['GNO'];
			$arr_Gname3 = explode("_",$_SESSION[$kGF3]);
			$_SESSION[$kGF3] = $arr_Gname3[0].'_'.$arr_Gname3[1].'_1';
			for($iGF=1;$iGF<11;$iGF++){
				$kGF = 'Glink_'.$iGF;
				if(isset($_SESSION[$kGF])){
					$kGF2 = 'Gname_'.$iGF;
					$arr_Gname2 = explode("_",$_SESSION[$kGF2]);
					if($arr_Gname2[2]=="0" && $GNO_Change==0){
						$_SESSION['GNO'] = $iGF;
						$GNO_Change = 1;
						?><script>window.location.href="<? echo $_SESSION[$kGF];?>"</script><?
					}
				}
			}
			if($GNO_Change==0){
				if(isset($_SESSION['G_mod']) && isset($_SESSION['G_func']) && isset($_SESSION['G_pid'])){
					$GENDurl = '<script>index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'&pid='.$_SESSION['G_pid'].'</script>';
				}elseif(isset($_SESSION['G_mod']) && isset($_SESSION['G_func'])){
					$GENDurl = '<script>index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'</script>';
				}else{
					$GENDurl = '<script>history.go(-2)</script>';
				}
				for($iGF=1;$iGF<11;$iGF++){
					$kGF = 'Glink_'.$iGF;
					$kGF2 = 'Gname_'.$iGF;
					unset($_SESSION[$kGF]);
					unset($_SESSION[$kGF2]);
				}
				unset($_SESSION['GNO']);
				unset($_SESSION['GListName']);
				unset($_SESSION['G_Temp_Link']);
				unset($_SESSION['G_GNOnumber']);
				unset($_SESSION['G_mod']);
				unset($_SESSION['G_func']);
				unset($_SESSION['G_pid']);

				echo $GENDurl;
			}
		}else{
			echo "<script>history.go(-2)</script>";
		}
		//按照填寫順序進入表單   連續性表單
		/*
		$db4 = new DB;
		$db4->query("SELECT * FROM `formgrouporder` WHERE `userGroup`='".$_SESSION['ncareGroup_lwj']."'");
		if ($db4->num_rows()==0) {
			echo "<script>history.go(-2)</script>";
		} else {
			$r4 = $db4->fetch_assoc();
			$db4a = new DB;
			$db4a->query("SELECT `order` FROM `formorder` WHERE `groupID`='".$r4['formGroup']."' AND `formID`='".mysql_escape_string($_POST['formID'])."'");
			if ($db4a->num_rows()>0) {
				$r4a = $db4a->fetch_assoc();
				$db4b = new DB;
				$db4b->query("SELECT `formID` FROM `formorder` WHERE `groupID`='".$r4['formGroup']."' AND `order` > '".$r4a['order']."' ORDER BY `order` ASC LIMIT 0,1");
				if ($db4b->num_rows()==0) {
					echo "<script>history.go(-2)</script>";
				} else {
					$r4b = $db4b->fetch_assoc();
					$db4c = new DB;
					$db4c->query("SELECT * FROM `formremind` WHERE `formID`='".$r4b['formID']."'");
					$r4c = $db4c->fetch_assoc();
					echo "<script>window.location.href='".str_replace('{PID}',getPID($_POST['HospNo']),$r4c['formLink'])."&newDate=".str_replace("/","",$_POST['date'])."';</script>";
				}
			} else {
				echo "<script>history.go(-2)</script>";
			}
		}
		*/
	}
} elseif (@$_GET['action']=="delete") {
	if ($_POST['formID'] == "nurseform17") {
		$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `drugID`='".mysql_escape_string($_POST['drugID'])."'";
	} elseif (@$_GET['targetID']!="") {
		//print_r($_POST);
		if ($_POST['formID']=='sixtarget_part7') {
			//鼻胃管移除訓練主單刪除
			$db3a = new DB;
			$db3a->query("DELETE FROM `alldetail` WHERE `parentName`='".mysql_escape_string($_POST['formID'])."' AND `parentID`='".mysql_escape_string($_GET['targetID'])."'");
			$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `targetID`='".mysql_escape_string($_GET['targetID'])."'";
		} elseif ($_POST['formID']=='careform07') {
			//尿管移除訓練主單刪除
			$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `nID`='".mysql_escape_string($_GET['targetID'])."'";
		} else {
			$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `targetID`='".mysql_escape_string($_GET['targetID'])."'";
		}
	} elseif (substr($_POST['formID'],0,9)=='nursediag') {
		$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."'";
		//刪除評值內容
		$tmp_diagNo = str_replace('nursediag','',$_POST['formID']);
		$db5 = new DB;
		$db5->query("DELETE FROM `nursediagassess` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `diagno`='".$tmp_diagNo."'");
	} else {
		$sql3 = "DELETE FROM `".$_POST['formID']."` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".mysql_escape_string($_POST['date'])."'";
	}
	$db3 = new DB;
	$db3->query($sql3);
	if ($_GET['url']!="") {
		echo "<script>location.replace('".urldecode($_GET['url'])."')</script>";
	} else {
		echo "<script>history.go(-2)</script>";
	}
}
?>