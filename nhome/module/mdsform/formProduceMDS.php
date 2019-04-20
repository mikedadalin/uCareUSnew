<?php
	  $PU = $_POST['PU'];
	  $A0050 = $_POST['A0050'];
	  $A0200 = $_POST['A0200'];
	  $A0310A = $_POST['A0310A'];
	  $A0310B = $_POST['A0310B'];
	  $A0310C = $_POST['A0310C'];
	  $A0310D = $_POST['A0310D'];
	  $A0310F = $_POST['A0310F'];
	  $A2200 = $_POST['A2200'];
	  $M0700 = $_POST['M0700'];
	  $Q0100A = $_POST['Q0100A'];
	  $Q0100B = $_POST['Q0100B'];
	  $Q0100C = $_POST['Q0100C'];
	  if($_POST['X1050_1']=="1"){
		  $X1050A="X";
	  }
	  if($_POST['X1050_2']=="1"){
		  $X1050Z="X";
	  }
	  $X1050Ztext = $_POST['X1050Ztext'];
	  if($_POST['X0900_1']=="1"){
		  $X0900A="X";
	  }
	  if($_POST['X0900_2']=="1"){
		  $X0900B="X";
	  }
	  if($_POST['X0900_3']=="1"){
		  $X0900C="X";
	  }
	  if($_POST['X0900_4']=="1"){
		  $X0900D="X";
	  }
	  if($_POST['X0900_5']=="1"){
		  $X0900E="X";
	  }
	  if($_POST['X0900_6']=="1"){
		  $X0900Z="X";
	  }
	  $X0900Ztext = $_POST['X0900Ztext'];
	  
	  if($A0050=="3"){
		  $OlderMDSdate = $_POST['InactivateDate'];
	  }else{
		  $OlderMDSdate = $_POST['A2200'];
	  }
$pID = $_GET['pid'];

	/*============= 刪除同一日期 MDS START =============*/
	    $ddfilldate = date("Y-m-d");
		$db29 = new DB;
		$db29->query("SELECT `no` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$ddfilldate."'");
	    
	    if ($db29->num_rows()>0) {
			$r29 = $db29->fetch_assoc();
			for($dd=1;$dd<44;$dd++){
  				if (strlen((int)$dd)==1) {
    				$DeleteformID = '0'.$dd;
  				}else{
    				$DeleteformID = $dd;
  				}
  			$Deletetablename = 'mdsform'.$DeleteformID;
  			$sql = "DELETE FROM `".$Deletetablename."` WHERE `no`='".$r29['no']."'";
			mysql_query($sql);
			}
		$sql = "DELETE FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$ddfilldate."'";
		mysql_query($sql);
        }
		
	    /*---- 取前次MDS日期 後續都用$r30['date']來判斷 ----*/
		$db30 = new DB;
 	    $db30->query("SELECT `date` FROM `mdsform01` WHERE `HospNo`='".$HospNo."' AND `date`<'".date("Y-m-d")."' AND `QA0050`!='3' ORDER BY `date` DESC LIMIT 0,1");
 	    if($db30->num_rows()>0){
			$r30 = $db30->fetch_assoc();
	    }
	/*============= 刪除同一日期 MDS END =============*/
	/*============================ 資料擷取 START ============================*/
	  $TableName1 = array("patient","inpatientinfo");
	  for($t=0;$t<count($TableName1);$t++){
	  $sql = "SELECT * FROM `".$TableName1[$t]."` WHERE `patientID`='".mysql_escape_string($pID)."'";
      $db1 = new DB;
      $db1->query($sql);
      $r1 = $db1->fetch_assoc();
      if ($db1->num_rows()>0) {
      	foreach ($r1 as $k=>$v) {
      		if (substr($k,0,1)=="Q") {
      			$arrAnswer = explode("_",$k);
      			if (count($arrAnswer)==2) {
      				if ($v==1) {
      					${$TableName1[$t]."_".$arrAnswer[0]} .= $arrAnswer[1].';';
      				}
      			} else {
      				${$TableName1[$t]."_".$k} = $v;
      			}
      		}  else {
      			${$TableName1[$t]."_".$k} = $v;
      		}
      	}
      }
	  }
	  /*== 解 START ==*/
	  $LWJArray = array('patient_Name1','patient_Name2','patient_Name3','patient_Name4','patient_IdNo','patient_MedicalRecordNumber','patient_Nickname','patient_MedicareNumber','patient_MedicaidNumber');
	  $LWJdataArray = array($patient_Name1,$patient_Name2,$patient_Name3,$patient_Name4,$patient_IdNo,$patient_MedicalRecordNumber,$patient_Nickname,$patient_MedicareNumber,$patient_MedicaidNumber);
	  for($z=0;$z<count($LWJdataArray);$z++){
	      $rsa = new lwj('lwj/lwj');
	      $puepart = explode(" ",$LWJdataArray[$z]);
	      $puepartcount = count($puepart);
	      if($puepartcount>1){
              for($m=0;$m<$puepartcount;$m++){
                  $prdpart = $rsa->privDecrypt($puepart[$m]);
                  ${$LWJArray[$z]} = ${$LWJArray[$z]}.$prdpart;
              }
	      }else{
		     ${$LWJArray[$z]} = $rsa->privDecrypt($LWJdataArray[$z]);
	      }
	  }
	  /*== 解 END ==*/
	  $TableName2 = array("nurseform18");
	  for($t=0;$t<count($TableName2);$t++){
	  $sql = "SELECT * FROM `".$TableName2[$t]."` WHERE `HospNo`='".$HospNo."'";
      $db1 = new DB;
      $db1->query($sql);
      $r1 = $db1->fetch_assoc();
      if ($db1->num_rows()>0) {
      	foreach ($r1 as $k=>$v) {
      		if (substr($k,0,1)=="Q") {
      			$arrAnswer = explode("_",$k);
      			if (count($arrAnswer)==2) {
      				if ($v==1) {
      					${$TableName2[$t]."_".$arrAnswer[0]} .= $arrAnswer[1].';';
      				}
      			} else {
      				${$TableName2[$t]."_".$k} = $v;
      			}
      		}  else {
      			${$TableName2[$t]."_".$k} = $v;
      		}
      	}
      }
	  }
	  $TableName3 = array("nurseform01","nurseform02a","nurseform02b","nurseform02c","nurseform02d","nurseform02g","nurseform02g_1","nurseform02g_2","nurseform02g_3","nurseform02h","nurseform02j","nurseform12","nurseform17","socialform02","socialform07","socialform21_1","socialform32","socialform33","careform13","nurseform41");
	  for($t=0;$t<count($TableName3);$t++){
	  $sql = "SELECT * FROM `".$TableName3[$t]."` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC";
      $db1 = new DB;
      $db1->query($sql);
      $r1 = $db1->fetch_assoc();
      if ($db1->num_rows()>0) {
      	foreach ($r1 as $k=>$v) {
      		if (substr($k,0,1)=="Q") {
      			$arrAnswer = explode("_",$k);
      			if (count($arrAnswer)==2) {
      				if ($v==1) {
      					${$TableName3[$t]."_".$arrAnswer[0]} .= $arrAnswer[1].';';
      				}
      			} else {
      				${$TableName3[$t]."_".$k} = $v;
      			}
      		}  else {
      			${$TableName3[$t]."_".$k} = $v;
      		}
      	}
      }
	  }
	  $TableName4 = array("system_setting");
	  for($t=0;$t<count($TableName4);$t++){
	  $sql = "SELECT * FROM `".$TableName4[$t]."` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'";
      $db1 = new DB2;
      $db1->query($sql);
      $r1 = $db1->fetch_assoc();
      if ($db1->num_rows()>0) {
      	foreach ($r1 as $k=>$v) {
      		if (substr($k,0,1)=="Q") {
      			$arrAnswer = explode("_",$k);
      			if (count($arrAnswer)==2) {
      				if ($v==1) {
      					${$TableName4[$t]."_".$arrAnswer[0]} .= $arrAnswer[1].';';
      				}
      			} else {
      				${$TableName4[$t]."_".$k} = $v;
      			}
      		}  else {
      			${$TableName4[$t]."_".$k} = $v;
      		}
      	}
      }
	  }
	  $TableName5 = array("closedcase");
	  for($t=0;$t<count($TableName5);$t++){
	  $sql = "SELECT * FROM `".$TableName5[$t]."` WHERE `patientID`='".mysql_escape_string($pID)."' ORDER BY `outdate` DESC LIMIT 0,1";
      $db22 = new DB;
      $db22->query($sql);
      $r22 = $db22->fetch_assoc();
      if ($db22->num_rows()>0) {
      	foreach ($r22 as $k=>$v) {
      		if (substr($k,0,1)=="Q") {
      			$arrAnswer = explode("_",$k);
      			if (count($arrAnswer)==2) {
      				if ($v==1) {
      					${$TableName5[$t]."_".$arrAnswer[0]} .= $arrAnswer[1].';';
      				}
      			} else {
      				${$TableName5[$t]."_".$k} = $v;
      			}
      		}  else {
      			${$TableName5[$t]."_".$k} = $v;
      		}
      	}
      }
	  }
	/*============================ 資料擷取 END ============================*/
    /*============================ 資料判斷 START ============================*/	
  for($j=1;$j<45;$j++){
    if (strlen((int)$j)==1) {
	  $formID = '0'.$j;
	}else{
	  $formID = $j;
	}
	
    if($j==1){  /*=============== 1 ===============*/
      
      $QA0050 = $A0050;  /* OK 判斷跳題 A0100、A0100、X0150 */
	  if($A0050!="3"){
	  $NPI = str_split($system_setting_NPI);
	  $CCN = str_split($system_setting_CCN);
	  $SPN = str_split($system_setting_SPN);
      $QA0100A_1 = $NPI[0];
      $QA0100A_2 = $NPI[1];
      $QA0100A_3 = $NPI[2];
      $QA0100A_4 = $NPI[3];
      $QA0100A_5 = $NPI[4];
      $QA0100A_6 = $NPI[5];
      $QA0100A_7 = $NPI[6];
      $QA0100A_8 = $NPI[7];
      $QA0100A_9 = $NPI[8];
      $QA0100A_10 = $NPI[9];
      $QA0100B_1 = $CCN[0];
      $QA0100B_2 = $CCN[1];
      $QA0100B_3 = $CCN[2];
      $QA0100B_4 = $CCN[3];
      $QA0100B_5 = $CCN[4];
      $QA0100B_6 = $CCN[5];
      $QA0100B_7 = $CCN[6];
      $QA0100B_8 = $CCN[7];
      $QA0100B_9 = $CCN[8];
      $QA0100B_10 = $CCN[9];
      $QA0100B_11 = $CCN[10];
      $QA0100B_12 = $CCN[11];
      $QA0100C_1 = $SPN[0];
      $QA0100C_2 = $SPN[1];
      $QA0100C_3 = $SPN[2];
      $QA0100C_4 = $SPN[3];
      $QA0100C_5 = $SPN[4];
      $QA0100C_6 = $SPN[5];
      $QA0100C_7 = $SPN[6];
      $QA0100C_8 = $SPN[7];
      $QA0100C_9 = $SPN[8];
      $QA0100C_10 = $SPN[9];
      $QA0100C_11 = $SPN[10];
      $QA0100C_12 = $SPN[11];
      $QA0100C_13 = $SPN[12];
      $QA0100C_14 = $SPN[13];
      $QA0100C_15 = $SPN[14];
      $QA0200 = $A0200;
      $QA0310A = $A0310A;
      $QA0310B = $A0310B;
      $QA0310C = $A0310C;
      $QA0310D = $A0310D;  /*  OK  Complete only if A0200 = 2 */
	  }
	  $page1Qfiller = array($_SESSION['ncareID_lwj']);
	  $page1Qfiller = array_unique($page1Qfiller);
	  sort($page1Qfiller);
	  for($i=0;$i<count($page1Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page1Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page1QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page1QfillerFilter = explode(";",$page1QfillerFilter);
	  $page1QfillerFilter = array_unique($page1QfillerFilter);
	  $page1Qfiller = array_diff($page1QfillerFilter, array(null,'null','',' '));
	  sort($page1Qfiller);
	  for($i=0;$i<count($page1Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page1Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
      $k = array("QA0050","QA0100A_1","QA0100A_2","QA0100A_3","QA0100A_4","QA0100A_5","QA0100A_6","QA0100A_7","QA0100A_8","QA0100A_9","QA0100A_10","QA0100B_1","QA0100B_2","QA0100B_3","QA0100B_4","QA0100B_5","QA0100B_6","QA0100B_7","QA0100B_8","QA0100B_9","QA0100B_10","QA0100B_11","QA0100B_12","QA0100C_1","QA0100C_2","QA0100C_3","QA0100C_4","QA0100C_5","QA0100C_6","QA0100C_7","QA0100C_8","QA0100C_9","QA0100C_10","QA0100C_11","QA0100C_12","QA0100C_13","QA0100C_14","QA0100C_15","QA0200","QA0310A","QA0310B","QA0310C","QA0310D");
      $v = array($QA0050,$QA0100A_1,$QA0100A_2,$QA0100A_3,$QA0100A_4,$QA0100A_5,$QA0100A_6,$QA0100A_7,$QA0100A_8,$QA0100A_9,$QA0100A_10,$QA0100B_1,$QA0100B_2,$QA0100B_3,$QA0100B_4,$QA0100B_5,$QA0100B_6,$QA0100B_7,$QA0100B_8,$QA0100B_9,$QA0100B_10,$QA0100B_11,$QA0100B_12,$QA0100C_1,$QA0100C_2,$QA0100C_3,$QA0100C_4,$QA0100C_5,$QA0100C_6,$QA0100C_7,$QA0100C_8,$QA0100C_9,$QA0100C_10,$QA0100C_11,$QA0100C_12,$QA0100C_13,$QA0100C_14,$QA0100C_15,$QA0200,$QA0310A,$QA0310B,$QA0310C,$QA0310D);
	
	}elseif($j==2){  /*=============== 2 ===============*/
      
	  if($A0050!="3"){
	  /*=== 判斷是否為最近一次入住第一次評估 START ===*/
 	  $db10 = new DB;
 	  $db10->query("SELECT `date` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
	  if($db10->num_rows()>0){
		  $r10 = $db10->fetch_assoc();
		  $db11 = new DB;
		  $db11->query("SELECT `outdate` FROM `closedcase` WHERE `patientID`='".$pID."' ORDER BY `outdate` DESC LIMIT 0,1");  
		  if($db11->num_rows()>0){
			  $r11 = $db11->fetch_assoc();
			  $db12 = new DB;
			  $db12->query("SELECT `indate` FROM `inpatientinfo` WHERE `patientID`='".$pID."'");
			  if($db12->num_rows()>0){
				  $r12 = $db12->fetch_assoc();
				  if(formatdate_Ymd($r10['date'])>$r12['indate']){
					  $A0310E ="0";
				  }else{
					  $A0310E ="1";
				  }
			  }else{
				  $A0310E ="0";
			  }
		  }else{
			  $A0310E ="0";
		  }
	  }else{
		  $A0310E ="1";
	  }
	  /*=== 判斷是否為最近一次入住第一次評估 END ===*/
	  $QA0310E = $A0310E;
	  $QA0310F = $A0310F;
	  if($A0310F=="10" || $A0310F=="11"){
	  $QA0310G = $closedcase_Qclosetype;  /* OK  Complete only if A0310F = 10 or 11 */
	  }
	  $QA0410 = $system_setting_Licensure;
	  $Name1 = str_split($patient_Name1);
	  $QA0500A_1 = $Name1[0];
	  $QA0500A_2 = $Name1[1];
	  $QA0500A_3 = $Name1[2];
	  $QA0500A_4 = $Name1[3];
	  $QA0500A_5 = $Name1[4];
	  $QA0500A_6 = $Name1[5];
	  $QA0500A_7 = $Name1[6];
	  $QA0500A_8 = $Name1[7];
	  $QA0500A_9 = $Name1[8];
	  $QA0500A_10 = $Name1[9];
	  $QA0500A_11 = $Name1[10];
	  $QA0500A_12 = $Name1[11];
	  $Name2 = str_split($patient_Name2);
	  $QA0500B = $Name2[0];
	  $Name3 = str_split($patient_Name3);
	  $QA0500C_1 = $Name3[0];
	  $QA0500C_2 = $Name3[1];
	  $QA0500C_3 = $Name3[2];
	  $QA0500C_4 = $Name3[3];
	  $QA0500C_5 = $Name3[4];
	  $QA0500C_6 = $Name3[5];
	  $QA0500C_7 = $Name3[6];
	  $QA0500C_8 = $Name3[7];
	  $QA0500C_9 = $Name3[8];
	  $QA0500C_10 = $Name3[9];
	  $QA0500C_11 = $Name3[10];
	  $QA0500C_12 = $Name3[11];
	  $QA0500C_13 = $Name3[12];
	  $QA0500C_14 = $Name3[13];
	  $QA0500C_15 = $Name3[14];
	  $QA0500C_16 = $Name3[15];
	  $QA0500C_17 = $Name3[16];
	  $QA0500C_18 = $Name3[17];
	  $Name4 = str_split($patient_Name4);
	  $QA0500D_1 = $Name4[0];
	  $QA0500D_2 = $Name4[1];
	  $QA0500D_3 = $Name4[2];
	  $IdNo = str_split($patient_IdNo);
	  $QA0600A_1 = $IdNo[0];
	  $QA0600A_2 = $IdNo[1];
	  $QA0600A_3 = $IdNo[2];
	  $QA0600A_4 = $IdNo[3];
	  $QA0600A_5 = $IdNo[4];
	  $QA0600A_6 = $IdNo[5];
	  $QA0600A_7 = $IdNo[6];
	  $QA0600A_8 = $IdNo[7];
	  $QA0600A_9 = $IdNo[8];
	  $MedicareNumber = str_split($patient_MedicareNumber);
	  $QA0600B_1 = $MedicareNumber[0];
	  $QA0600B_2 = $MedicareNumber[1];
	  $QA0600B_3 = $MedicareNumber[2];
	  $QA0600B_4 = $MedicareNumber[3];
	  $QA0600B_5 = $MedicareNumber[4];
	  $QA0600B_6 = $MedicareNumber[5];
	  $QA0600B_7 = $MedicareNumber[6];
	  $QA0600B_8 = $MedicareNumber[7];
	  $QA0600B_9 = $MedicareNumber[8];
	  $QA0600B_10 = $MedicareNumber[9];
	  $QA0600B_11 = $MedicareNumber[10];
	  $QA0600B_12 = $MedicareNumber[11];
	  if($patient_QMedicaidStatus=="1;"){$MedicaidNumber[0]="+";}elseif($patient_QMedicaidStatus=="2;"){$MedicaidNumber[0]="N";}else{$MedicaidNumber = str_split($patient_MedicaidNumber);}
	  $QA0700_1 = $MedicaidNumber[0];
	  $QA0700_2 = $MedicaidNumber[1];
	  $QA0700_3 = $MedicaidNumber[2];
	  $QA0700_4 = $MedicaidNumber[3];
	  $QA0700_5 = $MedicaidNumber[4];
	  $QA0700_6 = $MedicaidNumber[5];
	  $QA0700_7 = $MedicaidNumber[6];
	  $QA0700_8 = $MedicaidNumber[7];
	  $QA0700_9 = $MedicaidNumber[8];
	  $QA0700_10 = $MedicaidNumber[9];
	  $QA0700_11 = $MedicaidNumber[10];
	  $QA0700_12 = $MedicaidNumber[11];
	  if ($patient_Gender_1=="1"){$A0800="1";}elseif($patient_Gender_2=="1"){$A0800="2";}else{$A0800="";}
	  $QA0800 = $A0800;
	  $Birth = str_split($patient_Birth);
	  $QA0900_1 = $Birth[4];
	  $QA0900_2 = $Birth[5];
	  $QA0900_3 = $Birth[6];
	  $QA0900_4 = $Birth[7];
	  $QA0900_5 = $Birth[0];
	  $QA0900_6 = $Birth[1];
	  $QA0900_7 = $Birth[2];
	  $QA0900_8 = $Birth[3];
	  $QA1000 = $patient_Race;
	  $page2Qfiller = array($_SESSION['ncareID_lwj']);
	  $page2Qfiller = array_unique($page2Qfiller);
	  sort($page2Qfiller);
	  for($i=0;$i<count($page2Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page2Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page2QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page2QfillerFilter = explode(";",$page2QfillerFilter);
	  $page2QfillerFilter = array_unique($page2QfillerFilter);
	  $page2Qfiller = array_diff($page2QfillerFilter, array(null,'null','',' '));
	  sort($page2Qfiller);
	  for($i=0;$i<count($page2Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page2Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
      $k = array("QA0310E","QA0310F","QA0310G","QA0410","QA0500A_1","QA0500A_2","QA0500A_3","QA0500A_4","QA0500A_5","QA0500A_6","QA0500A_7","QA0500A_8","QA0500A_9","QA0500A_10","QA0500A_11","QA0500A_12","QA0500B","QA0500C_1","QA0500C_2","QA0500C_3","QA0500C_4","QA0500C_5","QA0500C_6","QA0500C_7","QA0500C_8","QA0500C_9","QA0500C_10","QA0500C_11","QA0500C_12","QA0500C_13","QA0500C_14","QA0500C_15","QA0500C_16","QA0500C_17","QA0500C_18","QA0500D_1","QA0500D_2","QA0500D_3","QA0600A_1","QA0600A_2","QA0600A_3","QA0600A_4","QA0600A_5","QA0600A_6","QA0600A_7","QA0600A_8","QA0600A_9","QA0600B_1","QA0600B_2","QA0600B_3","QA0600B_4","QA0600B_5","QA0600B_6","QA0600B_7","QA0600B_8","QA0600B_9","QA0600B_10","QA0600B_11","QA0600B_12","QA0700_1","QA0700_2","QA0700_3","QA0700_4","QA0700_5","QA0700_6","QA0700_7","QA0700_8","QA0700_9","QA0700_10","QA0700_11","QA0700_12","QA0800","QA0900_1","QA0900_2","QA0900_3","QA0900_4","QA0900_5","QA0900_6","QA0900_7","QA0900_8","QA1000");
	  $v = array($QA0310E,$QA0310F,$QA0310G,$QA0410,$QA0500A_1,$QA0500A_2,$QA0500A_3,$QA0500A_4,$QA0500A_5,$QA0500A_6,$QA0500A_7,$QA0500A_8,$QA0500A_9,$QA0500A_10,$QA0500A_11,$QA0500A_12,$QA0500B,$QA0500C_1,$QA0500C_2,$QA0500C_3,$QA0500C_4,$QA0500C_5,$QA0500C_6,$QA0500C_7,$QA0500C_8,$QA0500C_9,$QA0500C_10,$QA0500C_11,$QA0500C_12,$QA0500C_13,$QA0500C_14,$QA0500C_15,$QA0500C_16,$QA0500C_17,$QA0500C_18,$QA0500D_1,$QA0500D_2,$QA0500D_3,$QA0600A_1,$QA0600A_2,$QA0600A_3,$QA0600A_4,$QA0600A_5,$QA0600A_6,$QA0600A_7,$QA0600A_8,$QA0600A_9,$QA0600B_1,$QA0600B_2,$QA0600B_3,$QA0600B_4,$QA0600B_5,$QA0600B_6,$QA0600B_7,$QA0600B_8,$QA0600B_9,$QA0600B_10,$QA0600B_11,$QA0600B_12,$QA0700_1,$QA0700_2,$QA0700_3,$QA0700_4,$QA0700_5,$QA0700_6,$QA0700_7,$QA0700_8,$QA0700_9,$QA0700_10,$QA0700_11,$QA0700_12,$QA0800,$QA0900_1,$QA0900_2,$QA0900_3,$QA0900_4,$QA0900_5,$QA0900_6,$QA0900_7,$QA0900_8,$QA1000);
	
	}elseif($j==3){  /*=============== 3 ===============*/
	  
	  if($A0050!="3"){
      if($patient_QInterpreter=="1;"){$A1100A="0";}elseif($patient_QInterpreter=="2;"){$A1100A="1";}elseif($patient_QInterpreter=="3;"){$A1100A="9";}else{$A1100A="";} /* OK 判斷跳題 A1200、A1100B、A1200 */
      $QA1100A = $A1100A;
	  if($A1100A=="1"){
	  $Language = str_split($patient_Language);
	  $QA1100B_1 = $Language[0];
	  $QA1100B_2 = $Language[1];
	  $QA1100B_3 = $Language[2];
	  $QA1100B_4 = $Language[3];
	  $QA1100B_5 = $Language[4];
	  $QA1100B_6 = $Language[5];
	  $QA1100B_7 = $Language[6];
	  $QA1100B_8 = $Language[7];
	  $QA1100B_9 = $Language[8];
	  $QA1100B_10 = $Language[9];
	  $QA1100B_11 = $Language[10];
	  $QA1100B_12 = $Language[11];
	  $QA1100B_13 = $Language[12];
	  $QA1100B_14 = $Language[13];
	  $QA1100B_15 = $Language[14];
	  }
	  if($nurseform02a_Q15=="1;"){$A1200 ="1";}elseif($nurseform02a_Q15=="2;"){$A1200 ="2";}elseif($nurseform02a_Q15=="3;"){$A1200 ="3";}elseif($nurseform02a_Q15=="4;"){$A1200 ="4";}elseif($nurseform02a_Q15=="5;"){$A1200 ="5";}else{$A1200 ="";}
	  $QA1200 = $A1200;
	  $MedicalRecordNumber = str_split($patient_MedicalRecordNumber);
	  $QA1300A_1 = $MedicalRecordNumber[0];
	  $QA1300A_2 = $MedicalRecordNumber[1];
	  $QA1300A_3 = $MedicalRecordNumber[2];
	  $QA1300A_4 = $MedicalRecordNumber[3];
	  $QA1300A_5 = $MedicalRecordNumber[4];
	  $QA1300A_6 = $MedicalRecordNumber[5];
	  $QA1300A_7 = $MedicalRecordNumber[6];
	  $QA1300A_8 = $MedicalRecordNumber[7];
	  $QA1300A_9 = $MedicalRecordNumber[8];
	  $QA1300A_10 = $MedicalRecordNumber[9];
	  $QA1300A_11 = $MedicalRecordNumber[10];
	  $QA1300A_12 = $MedicalRecordNumber[11];
	  $bedID = str_split($inpatientinfo_bed);
	  $QA1300B_1 = $bedID[0];
	  $QA1300B_2 = $bedID[1];
	  $QA1300B_3 = $bedID[2];
	  $QA1300B_4 = $bedID[3];
	  $QA1300B_5 = $bedID[4];
	  $QA1300B_6 = $bedID[5];
	  $QA1300B_7 = $bedID[6];
	  $QA1300B_8 = $bedID[7];
	  $QA1300B_9 = $bedID[8];
	  $QA1300B_10 = $bedID[9];
	  $Nickname = str_split($patient_Nickname);
	  $QA1300C_1 = $Nickname[0];
	  $QA1300C_2 = $Nickname[1];
	  $QA1300C_3 = $Nickname[2];
	  $QA1300C_4 = $Nickname[3];
	  $QA1300C_5 = $Nickname[4];
	  $QA1300C_6 = $Nickname[5];
	  $QA1300C_7 = $Nickname[6];
	  $QA1300C_8 = $Nickname[7];
	  $QA1300C_9 = $Nickname[8];
	  $QA1300C_10 = $Nickname[9];
	  $QA1300C_11 = $Nickname[10];
	  $QA1300C_12 = $Nickname[11];
	  $QA1300C_13 = $Nickname[12];
	  $QA1300C_14 = $Nickname[13];
	  $QA1300C_15 = $Nickname[14];
	  $QA1300C_16 = $Nickname[15];
	  $QA1300C_17 = $Nickname[16];
	  $QA1300C_18 = $Nickname[17];
	  $QA1300C_19 = $Nickname[18];
	  $QA1300C_20 = $Nickname[19];
	  $QA1300C_21 = $Nickname[20];
	  $QA1300C_22 = $Nickname[21];
	  $QA1300C_23 = $Nickname[22];
	  $lifetimeOccupation = str_split($nurseform02a_Q10);
	  $QA1300D_1 = $lifetimeOccupation[0];
	  $QA1300D_2 = $lifetimeOccupation[1];
	  $QA1300D_3 = $lifetimeOccupation[2];
	  $QA1300D_4 = $lifetimeOccupation[3];
	  $QA1300D_5 = $lifetimeOccupation[4];
	  $QA1300D_6 = $lifetimeOccupation[5];
	  $QA1300D_7 = $lifetimeOccupation[6];
	  $QA1300D_8 = $lifetimeOccupation[7];
	  $QA1300D_9 = $lifetimeOccupation[8];
	  $QA1300D_10 = $lifetimeOccupation[9];
	  $QA1300D_11 = $lifetimeOccupation[10];
	  $QA1300D_12 = $lifetimeOccupation[11];
	  $QA1300D_13 = $lifetimeOccupation[12];
	  $QA1300D_14 = $lifetimeOccupation[13];
	  $QA1300D_15 = $lifetimeOccupation[14];
	  $QA1300D_16 = $lifetimeOccupation[15];
	  $QA1300D_17 = $lifetimeOccupation[16];
	  $QA1300D_18 = $lifetimeOccupation[17];
	  $QA1300D_19 = $lifetimeOccupation[18];
	  $QA1300D_20 = $lifetimeOccupation[19];
	  $QA1300D_21 = $lifetimeOccupation[20];
	  $QA1300D_22 = $lifetimeOccupation[21];
	  $QA1300D_23 = $lifetimeOccupation[22];
	  if($A0310A=="01" || $A0310A=="03" || $A0310A=="04" || $A0310A=="05"){
	  $QA1500 ='';  /* OK Complete only if A0310A = 01, 03, 04, or 05 判斷跳題 A1550、A1510、A1550 */
	  /* OK A1510 Complete only if A0310A = 01, 03, 04, or 05 */
	  if($QA1500=="1"){
	  $QA1510A ='';
	  $QA1510B ='';
	  $QA1510C ='';
	  }
	  }
	  $page3Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02a_Qfiller);
	  $page3Qfiller = array_unique($page3Qfiller);
	  sort($page3Qfiller);
	  for($i=0;$i<count($page3Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page3Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page3QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page3QfillerFilter = explode(";",$page3QfillerFilter);
	  $page3QfillerFilter = array_unique($page3QfillerFilter);
	  $page3Qfiller = array_diff($page3QfillerFilter, array(null,'null','',' '));
	  sort($page3Qfiller);
	  for($i=0;$i<count($page3Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page3Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QA1100A","QA1100B_1","QA1100B_2","QA1100B_3","QA1100B_4","QA1100B_5","QA1100B_6","QA1100B_7","QA1100B_8","QA1100B_9","QA1100B_10","QA1100B_11","QA1100B_12","QA1100B_13","QA1100B_14","QA1100B_15","QA1200","QA1300A_1","QA1300A_2","QA1300A_3","QA1300A_4","QA1300A_5","QA1300A_6","QA1300A_7","QA1300A_8","QA1300A_9","QA1300A_10","QA1300A_11","QA1300A_12","QA1300B_1","QA1300B_2","QA1300B_3","QA1300B_4","QA1300B_5","QA1300B_6","QA1300B_7","QA1300B_8","QA1300B_9","QA1300B_10","QA1300C_1","QA1300C_2","QA1300C_3","QA1300C_4","QA1300C_5","QA1300C_6","QA1300C_7","QA1300C_8","QA1300C_9","QA1300C_10","QA1300C_11","QA1300C_12","QA1300C_13","QA1300C_14","QA1300C_15","QA1300C_16","QA1300C_17","QA1300C_18","QA1300C_19","QA1300C_20","QA1300C_21","QA1300C_22","QA1300C_23","QA1300D_1","QA1300D_2","QA1300D_3","QA1300D_4","QA1300D_5","QA1300D_6","QA1300D_7","QA1300D_8","QA1300D_9","QA1300D_10","QA1300D_11","QA1300D_12","QA1300D_13","QA1300D_14","QA1300D_15","QA1300D_16","QA1300D_17","QA1300D_18","QA1300D_19","QA1300D_20","QA1300D_21","QA1300D_22","QA1300D_23","QA1500","QA1510A","QA1510B","QA1510C");
	  $v = array($QA1100A,$QA1100B_1,$QA1100B_2,$QA1100B_3,$QA1100B_4,$QA1100B_5,$QA1100B_6,$QA1100B_7,$QA1100B_8,$QA1100B_9,$QA1100B_10,$QA1100B_11,$QA1100B_12,$QA1100B_13,$QA1100B_14,$QA1100B_15,$QA1200,$QA1300A_1,$QA1300A_2,$QA1300A_3,$QA1300A_4,$QA1300A_5,$QA1300A_6,$QA1300A_7,$QA1300A_8,$QA1300A_9,$QA1300A_10,$QA1300A_11,$QA1300A_12,$QA1300B_1,$QA1300B_2,$QA1300B_3,$QA1300B_4,$QA1300B_5,$QA1300B_6,$QA1300B_7,$QA1300B_8,$QA1300B_9,$QA1300B_10,$QA1300C_1,$QA1300C_2,$QA1300C_3,$QA1300C_4,$QA1300C_5,$QA1300C_6,$QA1300C_7,$QA1300C_8,$QA1300C_9,$QA1300C_10,$QA1300C_11,$QA1300C_12,$QA1300C_13,$QA1300C_14,$QA1300C_15,$QA1300C_16,$QA1300C_17,$QA1300C_18,$QA1300C_19,$QA1300C_20,$QA1300C_21,$QA1300C_22,$QA1300C_23,$QA1300D_1,$QA1300D_2,$QA1300D_3,$QA1300D_4,$QA1300D_5,$QA1300D_6,$QA1300D_7,$QA1300D_8,$QA1300D_9,$QA1300D_10,$QA1300D_11,$QA1300D_12,$QA1300D_13,$QA1300D_14,$QA1300D_15,$QA1300D_16,$QA1300D_17,$QA1300D_18,$QA1300D_19,$QA1300D_20,$QA1300D_21,$QA1300D_22,$QA1300D_23,$QA1500,$QA1510A,$QA1510B,$QA1510C);
	
	}elseif($j==4){  /*=============== 4 ===============*/
	
	  if($A0050!="3"){
      /*
	   A1550
	    If the resident is 22 years of age or older, complete only if A0310A = 01
	    If the resident is 21 years of age or younger, complete only if A0310A = 01, 03, 04, or 05
	  */
	  $age = calcage($patient_Birth);
	  $age = explode("y",$age);
	  if($age[0]>=22){
		  if($A0310A=="01"){
			  $ShowA1550="1";
		  }else{
			  $ShowA1550="0";
		  }
	  }else{
		  if($A0310A=="01" || $A0310A=="03" || $A0310A=="04" || $A0310A=="05"){
			  $ShowA1550="1";
		  }else{
			  $ShowA1550="0";
		  }
	  }
	  if($ShowA1550=="1"){
	  $QA1550A ='';
	  $QA1550B ='';
	  $QA1550C ='';
	  $QA1550D ='';
	  $QA1550E ='';
	  $QA1550Z ='';
	  }
	  if($inpatientinfo_indate!=""){
		  $indate = str_split($inpatientinfo_indate);
	  }else{
		  $indate = str_split($closedcase_indate);
	  }
	  $QA1600_1 = $indate[4];
	  $QA1600_2 = $indate[5];
	  $QA1600_3 = $indate[6];
	  $QA1600_4 = $indate[7];
	  $QA1600_5 = $indate[0];
	  $QA1600_6 = $indate[1];
	  $QA1600_7 = $indate[2];
	  $QA1600_8 = $indate[3];
      /*== 重新入住判斷式 START ==*/
      $db23 = new DB;
      $db23->query("SELECT * FROM `closedcase` WHERE `patientID`='".mysql_escape_string($pID)."' ORDER BY `outdate` DESC");
      $A1700="1";
	  if ($db23->num_rows()>0) {
		for($i=0;$i<$db23->num_rows();$i++){
			$r23 = $db23->fetch_assoc();
			if($r23['outdate']<$inpatientinfo_indate){
				$A1700="2";
			}
		}
      }
	  /*== 重新入住判斷式 END ==*/
	  $QA1700 = $A1700;
	  if($nurseform02a_Q6=="1"){$A1800 ="01";}elseif($nurseform02a_Q6=="2"){$A1800 ="02";}elseif($nurseform02a_Q6=="3"){$A1800 ="03";}elseif($nurseform02a_Q6=="5"){$A1800 ="04";}elseif($nurseform02a_Q6=="6"){$A1800 ="05";}elseif($nurseform02a_Q6=="7"){$A1800 ="06";}elseif($nurseform02a_Q6=="8"){$A1800 ="07";}elseif($nurseform02a_Q6=="9"){$A1800 ="09";}elseif($nurseform02a_Q6=="10"){$A1800 ="99";}else{$A1800 ="";}
	  $QA1800 = $A1800;
	  $QA1900_1 = $indate[4];
	  $QA1900_2 = $indate[5];
	  $QA1900_3 = $indate[6];
	  $QA1900_4 = $indate[7];
	  $QA1900_5 = $indate[0];
	  $QA1900_6 = $indate[1];
	  $QA1900_7 = $indate[2];
	  $QA1900_8 = $indate[3];
	  if($A0310F=="10" || $A0310F=="11" || $A0310F=="12"){
	  $outdate = str_split($closedcase_outdate);
	  $QA2000_1 = $outdate[4];
	  $QA2000_2 = $outdate[5];
	  $QA2000_3 = $outdate[6];
	  $QA2000_4 = $outdate[7];
	  $QA2000_5 = $outdate[0];
	  $QA2000_6 = $outdate[1];
	  $QA2000_7 = $outdate[2];
	  $QA2000_8 = $outdate[3];
	  }
	  $page4Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02a_Qfiller);
	  $page4Qfiller = array_unique($page4Qfiller);
	  sort($page4Qfiller);
	  for($i=0;$i<count($page4Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page4Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page4QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page4QfillerFilter = explode(";",$page4QfillerFilter);
	  $page4QfillerFilter = array_unique($page4QfillerFilter);
	  $page4Qfiller = array_diff($page4QfillerFilter, array(null,'null','',' '));
	  sort($page4Qfiller);
	  for($i=0;$i<count($page4Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page4Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QA1550A","QA1550B","QA1550C","QA1550D","QA1550E","QA1550Z","QA1600_1","QA1600_2","QA1600_3","QA1600_4","QA1600_5","QA1600_6","QA1600_7","QA1600_8","QA1700","QA1800","QA1900_1","QA1900_2","QA1900_3","QA1900_4","QA1900_5","QA1900_6","QA1900_7","QA1900_8","QA2000_1","QA2000_2","QA2000_3","QA2000_4","QA2000_5","QA2000_6","QA2000_7","QA2000_8");
	  $v = array($QA1550A,$QA1550B,$QA1550C,$QA1550D,$QA1550E,$QA1550Z,$QA1600_1,$QA1600_2,$QA1600_3,$QA1600_4,$QA1600_5,$QA1600_6,$QA1600_7,$QA1600_8,$QA1700,$QA1800,$QA1900_1,$QA1900_2,$QA1900_3,$QA1900_4,$QA1900_5,$QA1900_6,$QA1900_7,$QA1900_8,$QA2000_1,$QA2000_2,$QA2000_3,$QA2000_4,$QA2000_5,$QA2000_6,$QA2000_7,$QA2000_8);
	
	}elseif($j==5){  /*=============== 5 ===============*/
      
	  if($A0050!="3"){
	  if($A0310F=="10" || $A0310F=="11" || $A0310F=="12"){/* OK Complete only if A0310F = 10, 11, or 12 */
	  if(strlen($closedcase_reason)==1){$A2100 = "0".$closedcase_reason;}else{$A2100 = $closedcase_reason;}
 	  $QA2100 = $A2100;  
	  }
	  if($A0310A=="05" || $A0310A=="06"){/* OK A2200 Complete only if A0310A = 05 or 06 */
	  $A2200 = str_split($A2200);
	  $QA2200_1 = $A2200[4];
	  $QA2200_2 = $A2200[5];
	  $QA2200_3 = $A2200[6];
	  $QA2200_4 = $A2200[7];
	  $QA2200_5 = $A2200[0];
	  $QA2200_6 = $A2200[1];
	  $QA2200_7 = $A2200[2];
	  $QA2200_8 = $A2200[3];
	  }
	  $A2300 = str_split(date(Ymd));
	  $QA2300_1 = $A2300[4];
	  $QA2300_2 = $A2300[5];
	  $QA2300_3 = $A2300[6];
	  $QA2300_4 = $A2300[7];
	  $QA2300_5 = $A2300[0];
	  $QA2300_6 = $A2300[1];
	  $QA2300_7 = $A2300[2];
	  $QA2300_8 = $A2300[3];
	  if($patient_QMedicareCovered=="2;"){$A2400A="1";}else{$A2400A="0";}
	  $QA2400A = $A2400A;  /* OK 判斷跳題 B0100、A2400B */
	  if($A2400A=="1"){
	  $A2400B = str_split($patient_MedicareStartDate);
	  $QA2400B_1 = $A2400B[4];
	  $QA2400B_2 = $A2400B[5];
	  $QA2400B_3 = $A2400B[6];
	  $QA2400B_4 = $A2400B[7];
	  $QA2400B_5 = $A2400B[0];
	  $QA2400B_6 = $A2400B[1];
	  $QA2400B_7 = $A2400B[2];
	  $QA2400B_8 = $A2400B[3];
	  if((int)date(Ymd)<=(int)$patient_MedicareEndDate){
		  $A2400C = str_split($patient_MedicareEndDate);
	  }else{
		  $A2400C = array("-","-","-","-","-","-","-","-");
	  }
	  $QA2400C_1 = $A2400C[4];
	  $QA2400C_2 = $A2400C[5];
	  $QA2400C_3 = $A2400C[6];
	  $QA2400C_4 = $A2400C[7];
	  $QA2400C_5 = $A2400C[0];
	  $QA2400C_6 = $A2400C[1];
	  $QA2400C_7 = $A2400C[2];
	  $QA2400C_8 = $A2400C[3];
	  }
	  $page5Qfiller = array($_SESSION['ncareID_lwj']);
	  $page5Qfiller = array_unique($page5Qfiller);
	  sort($page5Qfiller);
	  for($i=0;$i<count($page5Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page5Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page5QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page5QfillerFilter = explode(";",$page5QfillerFilter);
	  $page5QfillerFilter = array_unique($page5QfillerFilter);
	  $page5Qfiller = array_diff($page5QfillerFilter, array(null,'null','',' '));
	  sort($page5Qfiller);
	  for($i=0;$i<count($page5Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page5Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QA2100","QA2200_1","QA2200_2","QA2200_3","QA2200_4","QA2200_5","QA2200_6","QA2200_7","QA2200_8","QA2300_1","QA2300_2","QA2300_3","QA2300_4","QA2300_5","QA2300_6","QA2300_7","QA2300_8","QA2400A","QA2400B_1","QA2400B_2","QA2400B_3","QA2400B_4","QA2400B_5","QA2400B_6","QA2400B_7","QA2400B_8","QA2400C_1","QA2400C_2","QA2400C_3","QA2400C_4","QA2400C_5","QA2400C_6","QA2400C_7","QA2400C_8");
	  $v = array($QA2100,$QA2200_1,$QA2200_2,$QA2200_3,$QA2200_4,$QA2200_5,$QA2200_6,$QA2200_7,$QA2200_8,$QA2300_1,$QA2300_2,$QA2300_3,$QA2300_4,$QA2300_5,$QA2300_6,$QA2300_7,$QA2300_8,$QA2400A,$QA2400B_1,$QA2400B_2,$QA2400B_3,$QA2400B_4,$QA2400B_5,$QA2400B_6,$QA2400B_7,$QA2400B_8,$QA2400C_1,$QA2400C_2,$QA2400C_3,$QA2400C_4,$QA2400C_5,$QA2400C_6,$QA2400C_7,$QA2400C_8);
	
	}elseif($j==6){  /*=============== 6 ===============*/
	  
	  if($A0050!="3"){
	  $Comatose = explode(";",$nurseform02b_Q15);
	  if (in_array("5", $Comatose) || in_array("6", $Comatose) || in_array("7", $Comatose)) {$B0100 ="1";}else{$B0100 ="0";};
	  $QB0100 = $B0100;  /* OK 判斷跳題 B0200、G0110 */
	  if($B0100!="1"){
	  if ($nurseform02d_Q19=="1;"){$B0200="0";}elseif ($nurseform02d_Q18=="2;"){$B0200="1";}elseif ($nurseform02d_Q18=="3;"){$B0200="2";}elseif ($nurseform02d_Q18=="4;"){$B0200="3";}else{$B0200="";}
	  $QB0200 = $B0200;
	  if($B0200!=""){ if($nurseform02d_Q18=="1;"){$B0300="0";}elseif ($nurseform02d_Q18=="2;"){$B0300="1";}else{$B0300="";} }else{$B0300="";}
	  $QB0300 = $B0300;
	  if ($nurseform02d_Q20=="1;"){$B0600 ="0";}elseif($nurseform02d_Q20=="2;"){$B0600 ="1";}elseif($nurseform02d_Q20=="3;"){$B0600 ="2";}else{$B0600 ="";}	  
	  $QB0600 = $B0600;
	  if ($nurseform02d_Q21=="1;"){$B0700="0";}elseif ($nurseform02d_Q21=="2;"){$B0700="1";}elseif ($nurseform02d_Q21=="3;"){$B0700="2";}elseif ($nurseform02d_Q21=="4;"){$B0700="3";}else{$B0700="";}
	  $QB0700 = $B0700;
	  if ($nurseform02d_Q22=="1;"){$B0800="0";}elseif ($nurseform02d_Q22=="2;"){$B0800="1";}elseif ($nurseform02d_Q22=="3;"){$B0800="2";}elseif ($nurseform02d_Q22=="4;"){$B0800="3";}else{$B0800="";}
	  $QB0800 = $B0800;
	  if($nurseform02a_Q77=="1;"){$B1000 ="0";}elseif($nurseform02a_Q77=="2;"){$B1000 ="1";}elseif($nurseform02a_Q77=="3;"){$B1000 ="2";}elseif($nurseform02a_Q77=="4;"){$B1000 ="3";}elseif($nurseform02a_Q77=="5;"){$B1000 ="4";}else{$B1000 ="";}
	  $QB1000 = $B1000;
	  if($B1000!=""){ if($nurseform02a_Q79=="1;"){$B1200 ="0";}elseif($nurseform02a_Q79=="2;"){$B1200 ="1";}else{$B1200 ="";} }else{$B1200="";}
	  $QB1200 = $B1200; 
	  }
	  if($B0100!="1"){
		  $page6Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller,$nurseform02d_Qfiller,$nurseform02a_Qfiller);
	      $page6Qfiller = array_unique($page6Qfiller);
		  sort($page6Qfiller);
	  for($i=0;$i<count($page6Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page6Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page6QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page6QfillerFilter = explode(";",$page6QfillerFilter);
	  $page6QfillerFilter = array_unique($page6QfillerFilter);
	  $page6Qfiller = array_diff($page6QfillerFilter, array(null,'null','',' '));
	  sort($page6Qfiller);
	      for($i=0;$i<count($page6Qfiller);$i++){
		      ${"database_page".$j."Qfiller"} .= $page6Qfiller[$i].'&';
		      $database_Qfiller = ${"database_page".$j."Qfiller"};
	      }
	  }else{
		  $page6Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller);
		  $page6Qfiller = array_unique($page6Qfiller);
		  sort($page6Qfiller);
	  for($i=0;$i<count($page6Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page6Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page6QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page6QfillerFilter = explode(";",$page6QfillerFilter);
	  $page6QfillerFilter = array_unique($page6QfillerFilter);
	  $page6Qfiller = array_diff($page6QfillerFilter, array(null,'null','',' '));
	  sort($page6Qfiller);
	      for($i=0;$i<count($page6Qfiller);$i++){
		      ${"database_page".$j."Qfiller"} .= $page6Qfiller[$i].'&';
		      $database_Qfiller = ${"database_page".$j."Qfiller"};
	      }
	  }
	  }
	  $k = array("QB0100","QB0200","QB0300","QB0600","QB0700","QB0800","QB1000","QB1200");
	  $v = array($QB0100,$QB0200,$QB0300,$QB0600,$QB0700,$QB0800,$QB1000,$QB1200);
	
	}elseif($j==7){  /*=============== 7 ===============*/

 	  if($A0050!="3"){
	  if($B0100!="1"){
	  if($nurseform02h_Q34=="1;"){$C0100="0";}elseif($nurseform02h_Q34=="2;"){$C0100="1";}else{$C0100="";}
	  $QC0100 = $C0100;  /* OK 判斷跳題 C0700-C1000、C0200 */
	  if($C0100!="0"){
	  $C0200 =0;
	  if($nurseform02h_Q11=="2;"){$C0200++;}
	  if($nurseform02h_Q12=="2;"){$C0200++;}
	  if($nurseform02h_Q13=="2;"){$C0200++;}
	  $QC0200 = $C0200;
	  if($nurseform02h_Q1a=="1;"){$C0300A="0";}elseif($nurseform02h_Q1a=="2;"){$C0300A="1";}elseif($nurseform02h_Q1a=="3;"){$C0300A="2";}elseif($nurseform02h_Q1=="2;"){$C0300A="3";}else{$C0300A="";}
	  $QC0300A = $C0300A;
	  if($nurseform02h_Q5a=="1;"){$C0300B="0";}elseif($nurseform02h_Q5a=="2;"){$C0300B="1";}elseif($nurseform02h_Q5a=="3;"){$C0300B="2";}elseif($nurseform02h_Q5=="2;"){$C0300A="2";}else{$C0300B="";}
	  $QC0300B = $C0300B;
	  if($nurseform02h_Q4=="1;"){$C0300C="0";}elseif($nurseform02h_Q4=="2;"){$C0300C="1";}else{$C0300C="";}
	  $QC0300C = $C0300C;
	  if($nurseform02h_Q20a=="1;"){$C0400A="1";}elseif($nurseform02h_Q20a=="2;"){$C0400A="2";}elseif($nurseform02h_Q20=="1;"){$C0400A="0";}else{$C0400A="";}
	  $QC0400A = $C0400A;
	  if($nurseform02h_Q21a=="1;"){$C0400B="1";}elseif($nurseform02h_Q21a=="2;"){$C0400B="2";}elseif($nurseform02h_Q21=="1;"){$C0400B="0";}else{$C0400B="";}
	  $QC0400B = $C0400B;
	  if($nurseform02h_Q22a=="1;"){$C0400C="1";}elseif($nurseform02h_Q22a=="2;"){$C0400C="2";}elseif($nurseform02h_Q22=="1;"){$C0400C="0";}else{$C0400C="";}
	  $QC0400C = $C0400C;
	  /* 分數加總 
	    C0500
	    Add scores for questions C0200-C0400 and fill in total score (00-15).
	    Enter 99 if the resident was unable to complete the interview
	  */
	  $C0500 = $C0200+$C0300A+$C0300B+$C0300C+$C0400A+$C0400B+$C0400C;
	  $C0500 = str_split($C0500);
	  if(count($C0500)==1){
		  $C0500[1] = $C0500[0];
		  $C0500[0] = 0;
	  }
	  $QC0500_1 = $C0500[0];
	  $QC0500_2 = $C0500[1];
	  }
	  $page9Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02h_Qfiller);
	  $page9Qfiller = array_unique($page9Qfiller);
	  sort($page9Qfiller);
	  for($i=0;$i<count($page9Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page9Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page9QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page9QfillerFilter = explode(";",$page9QfillerFilter);
	  $page9QfillerFilter = array_unique($page9QfillerFilter);
	  $page9Qfiller = array_diff($page9QfillerFilter, array(null,'null','',' '));
	  sort($page9Qfiller);
	  for($i=0;$i<count($page9Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page9Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  $k = array("QC0100","QC0200","QC0300A","QC0300B","QC0300C","QC0400A","QC0400B","QC0400C","QC0500_1","QC0500_2");
	  $v = array($QC0100,$QC0200,$QC0300A,$QC0300B,$QC0300C,$QC0400A,$QC0400B,$QC0400C,$QC0500_1,$QC0500_2);
	
	}elseif($j==8){  /*=============== 8 ===============*/

 	  if($A0050!="3"){
	  if($B0100!="1"){
	  if($C0100!="0"){
	  if($C0100=="0"){$C0600="1";}elseif($C0100=="1"){$C0600="0";}
	  $QC0600 = $C0600;  /* OK 判斷跳題(同C0100) C1300、C0700 */
	  }
	  if($C0600!="0"){
	  if($nurseform02d_Q1=="1;"){$C0700="0";}elseif($nurseform02d_Q1=="2;"){$C0700="1";}else{$C0700="";}
	  $QC0700 = $C0700;
	  if($nurseform02d_Q2=="1;"){$C0800="0";}elseif($nurseform02d_Q2=="2;"){$C0800="1";}else{$C0800="";}
	  $QC0800 = $C0800;
	  if($nurseform02h_Q2=="2;"){$C0900A="X";}else{$C0900A="";}
	  $QC0900A = $C0900A;
	  if($nurseform02h_Q10=="2;"){$C0900B="X";}else{$C0900B="";}
	  $QC0900B = $C0900B;
	  if($nurseform02h_Q33=="2;"){$C0900C="X";}else{$C0900C="";}
	  $QC0900C = $C0900C;
	  if($nurseform02h_Q6=="2;"){$C0900D="X";}else{$C0900D="";}
	  $QC0900D = $C0900D;
	  if($C0900A=="" && $C0900B=="" && $C0900C=="" && $C0900D==""){$C0900Z="X";}else{$C0900Z="";}
	  $QC0900Z = $C0900Z;
	  if($nurseform02d_Q6=="1;"){$C1000="0";}elseif($nurseform02d_Q6=="2;"){$C1000="1";}elseif($nurseform02d_Q6=="3;"){$C1000="2";}elseif($nurseform02d_Q6=="4;"){$C1000="3";}else{$C1000="";}
	  $QC1000 = $C1000;
	  if($socialform07_Q40=="2;"){
	    if($socialform07_Q53=="1;"){$C1300A="1";}elseif($socialform07_Q53=="2;"){$C1300A="2";}else{$C1300A="";}
	  }else{
		  $C1300A="0";
	  }
	  $Q41array = explode(";",$socialform07_Q41);
	  if(in_array("6", $Q41array)){
		  if($socialform07_Q50=="1;"){$C1300B="1";}elseif($socialform07_Q50=="2;"){$C1300B="2";}else{$C1300B="";}
	  }else{
		  $C1300B="0";
	  }
	  if($nurseform02b_Q85=="1;"){$C1300C="0";}elseif($nurseform02b_Q85=="2;"){$C1300C="1";}elseif($nurseform02b_Q85=="3;"){$C1300C="1";}else{$C1300C="";}
	  if($socialform07_Q52=="1;"){$C1300D="0";}elseif($socialform07_Q52=="2;"){$C1300D="1";}elseif($socialform07_Q52=="3;"){$C1300D="2";}else{$C1300D="";}
	  $QC1300A = $C1300A;
	  $QC1300B = $C1300B;
	  $QC1300C = $C1300C;
	  $QC1300D = $C1300D;
	  $page8Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02d_Qfiller,$nurseform02h_Qfiller,$socialform07_Qfiller);
	  $page8Qfiller = array_unique($page8Qfiller);
	  sort($page8Qfiller);
	  for($i=0;$i<count($page8Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page8Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page8QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page8QfillerFilter = explode(";",$page8QfillerFilter);
	  $page8QfillerFilter = array_unique($page8QfillerFilter);
	  $page8Qfiller = array_diff($page8QfillerFilter, array(null,'null','',' '));
	  sort($page8Qfiller);
	  for($i=0;$i<count($page8Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page8Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  if($socialform07_Q60=="1;"){$C1600="0";}elseif($socialform07_Q60=="2;"){$C1600="1";}else{}
	  $QC1600 = $C1600;
	  }
	  }
	  $k = array("QC0600","QC0700","QC0800","QC0900A","QC0900B","QC0900C","QC0900D","QC0900Z","QC1000","QC1300A","QC1300B","QC1300C","QC1300D","QC1600");
	  $v = array($QC0600,$QC0700,$QC0800,$QC0900A,$QC0900B,$QC0900C,$QC0900D,$QC0900Z,$QC1000,$QC1300A,$QC1300B,$QC1300C,$QC1300D,$QC1600);
	
	}elseif($j==9){  /*=============== 9 ===============*/
      
 	  if($A0050!="3"){
	  if($B0100!="1"){
	  if($nurseform02d_Q42=="1;"){$D0100="0";}elseif($nurseform02d_Q42=="2;"){$D0100="1";}else{$D0100="";}
	  $QD0100 = $D0100;  /* OK 判斷跳題 D0500-D0600、D0200 */
	  if($D0100=="1"){
 	  if($nurseform02d_Q43=="1;"){$D0200A1 ="0";}elseif($nurseform02d_Q43=="2;"){$D0200A1 ="1";}elseif($nurseform02d_Q43=="3;"){$D0200A1 ="9";}else{$D0200A1 ="";}
	  $QD0200A1 = $D0200A1;
	  if($nurseform02d_Q43=="1;"){$D0200A2="0";}elseif($nurseform02d_Q43=="2;"){ if($nurseform02d_Q24=="1;"){$D0200A2="0";}elseif($nurseform02d_Q24=="2;"){$D0200A2="1";}elseif($nurseform02d_Q24=="3;"){$D0200A2="2";}elseif($nurseform02d_Q24=="4;"){$D0200A2="3";}else{$D0200A2="";} }elseif($nurseform02d_Q43=="3;"){$D0200A2="";}else{$D0200A2="";}
	  $QD0200A2 = $D0200A2;
	  if($nurseform02d_Q44=="1;"){$D0200B1 ="0";}elseif($nurseform02d_Q44=="2;"){$D0200B1 ="1";}elseif($nurseform02d_Q44=="3;"){$D0200B1 ="9";}else{$D0200B1 ="";}
	  $QD0200B1 = $D0200B1;
	  if($nurseform02d_Q44=="1;"){$D0200B2="0";}elseif($nurseform02d_Q44=="2;"){ if($nurseform02d_Q25=="1;"){$D0200B2="0";}elseif($nurseform02d_Q25=="2;"){$D0200B2="1";}elseif($nurseform02d_Q25=="3;"){$D0200B2="2";}elseif($nurseform02d_Q25=="4;"){$D0200B2="3";}else{$D0200B2="";} }elseif($nurseform02d_Q44=="3;"){$D0200B2="";}else{$D0200B2="";}  
	  $QD0200B2 = $D0200B2;
	  if($nurseform02d_Q45=="1;"){$D0200C1 ="0";}elseif($nurseform02d_Q45=="2;"){$D0200C1 ="1";}elseif($nurseform02d_Q45=="3;"){$D0200C1 ="9";}else{$D0200C1 ="";}
	  $QD0200C1 = $D0200C1;
	  if($nurseform02d_Q45=="1;"){$D0200C2="0";}elseif($nurseform02d_Q45=="2;"){ if($nurseform02d_Q26=="1;"){$D0200C2="0";}elseif($nurseform02d_Q26=="2;"){$D0200C2="1";}elseif($nurseform02d_Q26=="3;"){$D0200C2="2";}elseif($nurseform02d_Q26=="4;"){$D0200C2="3";}else{$D0200C2="";} }elseif($nurseform02d_Q45=="3;"){$D0200C2="";}else{$D0200C2="";}
	  $QD0200C2 = $D0200C2;
	  if($nurseform02d_Q46=="1;"){$D0200D1 ="0";}elseif($nurseform02d_Q46=="2;"){$D0200D1 ="1";}elseif($nurseform02d_Q46=="3;"){$D0200D1 ="9";}else{$D0200D1 ="";}
	  $QD0200D1 = $D0200D1;
	  if($nurseform02d_Q46=="1;"){$D0200D2="0";}elseif($nurseform02d_Q46=="2;"){ if($nurseform02d_Q27=="1;"){$D0200D2="0";}elseif($nurseform02d_Q27=="2;"){$D0200D2="1";}elseif($nurseform02d_Q27=="3;"){$D0200D2="2";}elseif($nurseform02d_Q27=="4;"){$D0200D2="3";}else{$D0200D2="";} }elseif($nurseform02d_Q46=="3;"){$D0200D2="";}else{$D0200D2="";}
	  $QD0200D2 = $D0200D2;
	  if($nurseform02d_Q47=="1;"){$D0200E1 ="0";}elseif($nurseform02d_Q47=="2;"){$D0200E1 ="1";}elseif($nurseform02d_Q47=="3;"){$D0200E1 ="9";}else{$D0200E1 ="";}
	  $QD0200E1 = $D0200E1;
	  if($nurseform02d_Q47=="1;"){$D0200E2="0";}elseif($nurseform02d_Q47=="2;"){ if($nurseform02d_Q28=="1;"){$D0200E2="0";}elseif($nurseform02d_Q28=="2;"){$D0200E2="1";}elseif($nurseform02d_Q28=="3;"){$D0200E2="2";}elseif($nurseform02d_Q28=="4;"){$D0200E2="3";}else{$D0200E2="";} }elseif($nurseform02d_Q47=="3;"){$D0200E2="";}else{$D0200E2="";}
	  $QD0200E2 = $D0200E2;
	  if($nurseform02d_Q48=="1;"){$D0200F1 ="0";}elseif($nurseform02d_Q48=="2;"){$D0200F1 ="1";}elseif($nurseform02d_Q48=="3;"){$D0200F1 ="9";}else{$D0200F1 ="";}
	  $QD0200F1 = $D0200F1;
	  if($nurseform02d_Q48=="1;"){$D0200F2="0";}elseif($nurseform02d_Q48=="2;"){ if($nurseform02d_Q29=="1;"){$D0200F2="0";}elseif($nurseform02d_Q29=="2;"){$D0200F2="1";}elseif($nurseform02d_Q29=="3;"){$D0200F2="2";}elseif($nurseform02d_Q29=="4;"){$D0200F2="3";}else{$D0200F2="";} }elseif($nurseform02d_Q48=="3;"){$D0200F2="";}else{$D0200F2="";}
	  $QD0200F2 = $D0200F2;
	  if($nurseform02d_Q49=="1;"){$D0200G1 ="0";}elseif($nurseform02d_Q49=="2;"){$D0200G1 ="1";}elseif($nurseform02d_Q49=="3;"){$D0200G1 ="9";}else{$D0200G1 ="";}
	  $QD0200G1 = $D0200G1;
	  if($nurseform02d_Q49=="1;"){$D0200G2="0";}elseif($nurseform02d_Q49=="2;"){ if($nurseform02d_Q30=="1;"){$D0200G2="0";}elseif($nurseform02d_Q30=="2;"){$D0200G2="1";}elseif($nurseform02d_Q30=="3;"){$D0200G2="2";}elseif($nurseform02d_Q30=="4;"){$D0200G2="3";}else{$D0200G2="";} }elseif($nurseform02d_Q49=="3;"){$D0200G2="";}else{$D0200G2="";}
	  $QD0200G2 = $D0200G2;
	  if($nurseform02d_Q50=="1;"){$D0200H1 ="0";}elseif($nurseform02d_Q50=="2;"){$D0200H1 ="1";}elseif($nurseform02d_Q50=="3;"){$D0200H1 ="9";}else{$D0200H1 ="";}
	  $QD0200H1 = $D0200H1;
	  if($nurseform02d_Q50=="1;"){$D0200H2="0";}elseif($nurseform02d_Q50=="2;"){ if($nurseform02d_Q31=="1;"){$D0200H2="0";}elseif($nurseform02d_Q31=="2;"){$D0200H2="1";}elseif($nurseform02d_Q31=="3;"){$D0200H2="2";}elseif($nurseform02d_Q31=="4;"){$D0200H2="3";}else{$D0200H2="";} }elseif($nurseform02d_Q50=="3;"){$D0200H2="";}else{$D0200H2="";}
	  $QD0200H2 = $D0200H2;
	  if($nurseform02d_Q51=="1;"){$D0200I1 ="0";}elseif($nurseform02d_Q51=="2;"){$D0200I1 ="1";}elseif($nurseform02d_Q51=="3;"){$D0200I1 ="9";}else{$D0200I1 ="";}
	  $QD0200I1 = $D0200I1;
	  if($nurseform02d_Q51=="1;"){$D0200I2="0";}elseif($nurseform02d_Q51=="2;"){ if($nurseform02d_Q32=="1;"){$D0200I2="0";}elseif($nurseform02d_Q32=="2;"){$D0200I2="1";}elseif($nurseform02d_Q32=="3;"){$D0200I2="2";}elseif($nurseform02d_Q32=="4;"){$D0200I2="3";}else{$D0200I2="";} }elseif($nurseform02d_Q51=="3;"){$D0200I2="";}else{$D0200I2="";}
	  $QD0200I2 = $D0200I2;
	  /* 分數加總 
	    D0300
	    Add scores for all frequency responses in Column 2, Symptom Frequency. Total score must be between 00 and 27
		Enter 99 if unable to complete interview (i.e., Symptom Frequency is blank for 3 or more items)
	  */
	  $D0200NullNumber=0;
	  $D0200array = array($D0200A2,$D0200B2,$D0200C2,$D0200D2,$D0200E2,$D0200F2,$D0200G2,$D0200H2,$D0200I2);
	  for($i=0;$i<9;$i++){
		  if($D0200array[$i]==""){
			  $D0200NullNumber++;
		  }
	  }
      if($D0200NullNumber>=3){
		  $D0300[0]="9";
		  $D0300[1]="9";
	  }else{
		  $D0300 = $D0200A2+$D0200B2+$D0200C2+$D0200D2+$D0200E2+$D0200F2+$D0200G2+$D0200H2+$D0200I2;
		  $D0300 = str_split($D0300);
		  if(count($D0300)==1){
			  $D0300[1] = $D0300[0];
			  $D0300[0] = 0;
	      }		  
	  }
	  $QD0300_1 = $D0300[0];
	  $QD0300_2 = $D0300[1];
	  if($D0200I1=="1"){
	  if($nurseform02d_Q52=="1;"){$D0350="0";}elseif($nurseform02d_Q52=="2;"){$D0350="1";}else{$D0350="";}
	  $QD0350 = $D0350;  /* Complete only if D0200I1 = 1 indicating possibility of resident self harm */
	  }
	  }
	  $page9Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02d_Qfiller);
	  $page9Qfiller = array_unique($page9Qfiller);
	  sort($page9Qfiller);
	  for($i=0;$i<count($page9Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page9Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page9QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page9QfillerFilter = explode(";",$page9QfillerFilter);
	  $page9QfillerFilter = array_unique($page9QfillerFilter);
	  $page9Qfiller = array_diff($page9QfillerFilter, array(null,'null','',' '));
	  sort($page9Qfiller);
	  for($i=0;$i<count($page9Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page9Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  $k = array("QD0100","QD0200A1","QD0200A2","QD0200B1","QD0200B2","QD0200C1","QD0200C2","QD0200D1","QD0200D2","QD0200E1","QD0200E2","QD0200F1","QD0200F2","QD0200G1","QD0200G2","QD0200H1","QD0200H2","QD0200I1","QD0200I2","QD0300_1","QD0300_2","QD0350");
	  $v = array($QD0100,$QD0200A1,$QD0200A2,$QD0200B1,$QD0200B2,$QD0200C1,$QD0200C2,$QD0200D1,$QD0200D2,$QD0200E1,$QD0200E2,$QD0200F1,$QD0200F2,$QD0200G1,$QD0200G2,$QD0200H1,$QD0200H2,$QD0200I1,$QD0200I2,$QD0300_1,$QD0300_2,$QD0350);
	
	}elseif($j==10){  /*=============== 10 ===============*/
      
	  if($A0050!="3"){
	  if($B0100!="1"){
	  if($D0100=="0"){
	  /* 如果D0200-D0300 有填寫，D0500-D0600就不用寫 */
	  if($nurseform02d_Q54=="1;"){$D0500A1="0";}elseif($nurseform02d_Q54=="2;"){$D0500A1="1";}else{$D0500A1="";}
 	  $QD0500A1 = $D0500A1;
	  if($nurseform02d_Q54=="1;"){$D0500A2="0";}elseif($nurseform02d_Q54=="2;"){ if($nurseform02d_Q55=="1;"){$D0500A2="0";}elseif($nurseform02d_Q55=="2;"){$D0500A2="1";}elseif($nurseform02d_Q55=="3;"){$D0500A2="2";}elseif($nurseform02d_Q55=="4;"){$D0500A2="3";}else{$D0500A2="";} }else{$D0500A2="";}
	  $QD0500A2 = $D0500A2;
	  if($nurseform02d_Q56=="1;"){$D0500B1="0";}elseif($nurseform02d_Q56=="2;"){$D0500B1="1";}else{$D0500B1="";}
	  $QD0500B1 = $D0500B1;
	  if($nurseform02d_Q56=="1;"){$D0500B2="0";}elseif($nurseform02d_Q56=="2;"){ if($nurseform02d_Q57=="1;"){$D0500B2="0";}elseif($nurseform02d_Q57=="2;"){$D0500B2="1";}elseif($nurseform02d_Q57=="3;"){$D0500B2="2";}elseif($nurseform02d_Q57=="4;"){$D0500B2="3";}else{$D0500B2="";} }else{$D0500B2="";}
	  $QD0500B2 = $D0500B2;
	  if($nurseform02d_Q58=="1;"){$D0500C1="0";}elseif($nurseform02d_Q58=="2;"){$D0500C1="1";}else{$D0500C1="";}
	  $QD0500C1 = $D0500C1;
	  if($nurseform02d_Q58=="1;"){$D0500C2="0";}elseif($nurseform02d_Q58=="2;"){ if($nurseform02d_Q59=="1;"){$D0500C2="0";}elseif($nurseform02d_Q59=="2;"){$D0500C2="1";}elseif($nurseform02d_Q59=="3;"){$D0500C2="2";}elseif($nurseform02d_Q59=="4;"){$D0500C2="3";}else{$D0500C2="";} }else{$D0500C2="";}
	  $QD0500C2 = $D0500C2;
	  if($nurseform02d_Q60=="1;"){$D0500D1="0";}elseif($nurseform02d_Q60=="2;"){$D0500D1="1";}else{$D0500D1="";}
	  $QD0500D1 = $D0500D1;
	  if($nurseform02d_Q60=="1;"){$D0500D2="0";}elseif($nurseform02d_Q60=="2;"){ if($nurseform02d_Q61=="1;"){$D0500D2="0";}elseif($nurseform02d_Q61=="2;"){$D0500D2="1";}elseif($nurseform02d_Q61=="3;"){$D0500D2="2";}elseif($nurseform02d_Q61=="4;"){$D0500D2="3";}else{$D0500D2="";} }else{$D0500D2="";}
	  $QD0500D2 = $D0500D2;
	  if($nurseform02d_Q62=="1;"){$D0500E1="0";}elseif($nurseform02d_Q62=="2;"){$D0500E1="1";}else{$D0500E1="";}
	  $QD0500E1 = $D0500E1;
	  if($nurseform02d_Q62=="1;"){$D0500E2="0";}elseif($nurseform02d_Q62=="2;"){ if($nurseform02d_Q63=="1;"){$D0500E2="0";}elseif($nurseform02d_Q63=="2;"){$D0500E2="1";}elseif($nurseform02d_Q63=="3;"){$D0500E2="2";}elseif($nurseform02d_Q63=="4;"){$D0500E2="3";}else{$D0500E2="";} }else{$D0500E2="";}
	  $QD0500E2 = $D0500E2;
	  if($nurseform02d_Q64=="1;"){$D0500F1="0";}elseif($nurseform02d_Q64=="2;"){$D0500F1="1";}else{$D0500F1="";}
	  $QD0500F1 = $D0500F1;
	  if($nurseform02d_Q64=="1;"){$D0500F2="0";}elseif($nurseform02d_Q64=="2;"){ if($nurseform02d_Q65=="1;"){$D0500F2="0";}elseif($nurseform02d_Q65=="2;"){$D0500F2="1";}elseif($nurseform02d_Q65=="3;"){$D0500F2="2";}elseif($nurseform02d_Q65=="4;"){$D0500F2="3";}else{$D0500F2="";} }else{$D0500F2="";}
	  $QD0500F2 = $D0500F2;
	  if($nurseform02d_Q66=="1;"){$D0500G1="0";}elseif($nurseform02d_Q66=="2;"){$D0500G1="1";}else{$D0500G1="";}
	  $QD0500G1 = $D0500G1;
	  if($nurseform02d_Q66=="1;"){$D0500G2="0";}elseif($nurseform02d_Q66=="2;"){ if($nurseform02d_Q67=="1;"){$D0500G2="0";}elseif($nurseform02d_Q67=="2;"){$D0500G2="1";}elseif($nurseform02d_Q67=="3;"){$D0500G2="2";}elseif($nurseform02d_Q67=="4;"){$D0500G2="3";}else{$D0500G2="";} }else{$D0500G2="";}
	  $QD0500G2 = $D0500G2;
	  if($nurseform02d_Q68=="1;"){$D0500H1="0";}elseif($nurseform02d_Q68=="2;"){$D0500H1="1";}else{$D0500H1="";}
	  $QD0500H1 = $D0500H1;
	  if($nurseform02d_Q68=="1;"){$D0500H2="0";}elseif($nurseform02d_Q68=="2;"){ if($nurseform02d_Q69=="1;"){$D0500H2="0";}elseif($nurseform02d_Q69=="2;"){$D0500H2="1";}elseif($nurseform02d_Q69=="3;"){$D0500H2="2";}elseif($nurseform02d_Q69=="4;"){$D0500H2="3";}else{$D0500H2="";} }else{$D0500H2="";}
	  $QD0500H2 = $D0500H2;
	  if($nurseform02d_Q70=="1;"){$D0500I1="0";}elseif($nurseform02d_Q70=="2;"){$D0500I1="1";}else{$D0500I1="";}
	  $QD0500I1 = $D0500I1;
	  if($nurseform02d_Q70=="1;"){$D0500I2="0";}elseif($nurseform02d_Q70=="2;"){ if($nurseform02d_Q71=="1;"){$D0500I2="0";}elseif($nurseform02d_Q71=="2;"){$D0500I2="1";}elseif($nurseform02d_Q71=="3;"){$D0500I2="2";}elseif($nurseform02d_Q71=="4;"){$D0500I2="3";}else{$D0500I2="";} }else{$D0500I2="";}
	  $QD0500I2 = $D0500I2;
	  if($nurseform02d_Q72=="1;"){$D0500J1="0";}elseif($nurseform02d_Q72=="2;"){$D0500J1="1";}else{$D0500J1="";}
	  $QD0500J1 = $D0500J1;
	  if($nurseform02d_Q74=="1;"){$D0500J2="0";}elseif($nurseform02d_Q74=="2;"){ if($nurseform02d_Q73=="1;"){$D0500J2="0";}elseif($nurseform02d_Q73=="2;"){$D0500J2="1";}elseif($nurseform02d_Q73=="3;"){$D0500J2="2";}elseif($nurseform02d_Q73=="4;"){$D0500J2="3";}else{$D0500J2="";} }else{$D0500J2="";}
	  $QD0500J2 = $D0500J2;
	  /* 分數加總 
	    D0600
	    Add scores for all frequency responses in Column 2, Symptom Frequency. Total score must be between 00 and 30
	  */
	  $D0500 = $D0500A2+$D0500B2+$D0500C2+$D0500D2+$D0500E2+$D0500F2+$D0500G2+$D0500H2+$D0500I2+$D0500J2;
	  $D0500 = str_split($D0500);
	  if(count($D0500)==1){
		 $D0500[1] = $D0500[0];
		 $D0500[0] = 0;
	  }
	  $QD0600_1 = $D0500[0];
	  $QD0600_2 = $D0500[1];
	  if($D0500I1=="1"){
	  if($nurseform02d_Q74=="1;"){$D0650="0";}elseif($nurseform02d_Q74=="2;"){$D0650="1";}else{$D0650="";}
	  $QD0650 = $D0650; /* Complete only if D0500I1 = 1 indicating possibility of resident self harm */
	  }
	  $page10Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02d_Qfiller);
	  $page10Qfiller = array_unique($page10Qfiller);
	  sort($page10Qfiller);
	  for($i=0;$i<count($page10Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page10Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page10QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page10QfillerFilter = explode(";",$page10QfillerFilter);
	  $page10QfillerFilter = array_unique($page10QfillerFilter);
	  $page10Qfiller = array_diff($page10QfillerFilter, array(null,'null','',' '));
	  sort($page10Qfiller);
	  for($i=0;$i<count($page10Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page10Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  }
	  $k = array("QD0500A1","QD0500A2","QD0500B1","QD0500B2","QD0500C1","QD0500C2","QD0500D1","QD0500D2","QD0500E1","QD0500E2","QD0500F1","QD0500F2","QD0500G1","QD0500G2","QD0500H1","QD0500H2","QD0500I1","QD0500I2","QD0500J1","QD0500J2","QD0600_1","QD0600_2","QD0650");
	  $v = array($QD0500A1,$QD0500A2,$QD0500B1,$QD0500B2,$QD0500C1,$QD0500C2,$QD0500D1,$QD0500D2,$QD0500E1,$QD0500E2,$QD0500F1,$QD0500F2,$QD0500G1,$QD0500G2,$QD0500H1,$QD0500H2,$QD0500I1,$QD0500I2,$QD0500J1,$QD0500J2,$QD0600_1,$QD0600_2,$QD0650);
	
	}elseif($j==11){  /*=============== 11 ===============*/

	  if($A0050!="3"){
	  if($B0100!="1"){
	  $E0100 = explode(";",$socialform07_Q41);
	  if (in_array("7", $E0100)) {$E0100A ="X";}else{$E0100A ="";};
	  if (in_array("2", $E0100)) {$E0100B ="X";}else{$E0100B ="";};
	  if ($E0100A=="" && $E0100B=="") {$E0100Z ="X";}else{$E0100Z ="";};
 	  $QE0100A = $E0100A;
	  $QE0100B = $E0100B;
	  $QE0100Z = $E0100Z;
	  $E0200 = explode(";", $socialform07_Q38);
	  $E0200A=0;
	  $E0200B=0;
	  $E0200C=0;
	  if (in_array("8", $E0200)){
	  	if($socialform07_Q51g=="1;") {$E0200A="1";}elseif($socialform07_Q51g=="2;") {$E0200A="2";}elseif($socialform07_Q51g=="3;"){$E0200A="3";}else{$E0200A="";}
	  }
	  if (in_array("9", $E0200)){
	  	if($socialform07_Q51h=="1;") {$E0200B="1";}elseif($socialform07_Q51h=="2;") {$E0200B="2";}elseif($socialform07_Q51h=="3;"){$E0200B="3";}else{$E0200B="";}
	  }
	  if (in_array("2", $E0200) || in_array("3", $E0200) || in_array("4", $E0200) || in_array("5", $E0200) || in_array("6", $E0200) || in_array("7", $E0200)){
	  	if($socialform07_Q51a=="3;" || $socialform07_Q51b=="3;" || $socialform07_Q51c=="3;" || $socialform07_Q51d=="3;" || $socialform07_Q51e=="3;" || $socialform07_Q51f=="3;"){
			$E0200C="3";
		}elseif($socialform07_Q51a=="2;" || $socialform07_Q51b=="2;" || $socialform07_Q51c=="2;" || $socialform07_Q51d=="2;" || $socialform07_Q51e=="2;" || $socialform07_Q51f=="2;"){
			$E0200C="2";
		}elseif($socialform07_Q51a=="1;" || $socialform07_Q51b=="1;" || $socialform07_Q51c=="1;" || $socialform07_Q51d=="1;" || $socialform07_Q51e=="1;" || $socialform07_Q51f=="1;"){
			$E0200C="1";
		}else{
			$E0200C="";
		}
	  }
	  $QE0200A = $E0200A;
	  $QE0200B = $E0200B;
	  $QE0200C = $E0200C;
	  /* OK 判斷跳題 E0800、E0500~ E0600 */
	  if($E0200A=="1"||$E0200A=="2"||$E0200A=="3"||$E0200B=="1"||$E0200B=="2"||$E0200B=="3"||$E0200C=="1"||$E0200C=="2"||$E0200C=="3") {
	  	$E0300 ="1";
	  }else{
		$E0300 ="0";
	  }
	  $QE0300 = $E0300;
	  if($E0300=="1"){
	  if($socialform07_Q54=="1;"){$E0500A="0";}elseif($socialform07_Q54=="2;"){$E0500A="1";}else{$E0500A="";}
	  if($socialform07_Q55=="1;"){$E0500B="0";}elseif($socialform07_Q55=="2;"){$E0500B="1";}else{$E0500B="";}
	  if($socialform07_Q56=="1;"){$E0500C="0";}elseif($socialform07_Q56=="2;"){$E0500C="1";}else{$E0500C="";}
	  if($socialform07_Q57=="1;"){$E0600A="0";}elseif($socialform07_Q57=="2;"){$E0600A="1";}else{$E0600A="";}
	  if($socialform07_Q58=="1;"){$E0600B="0";}elseif($socialform07_Q58=="2;"){$E0600B="1";}else{$E0600B="";}
	  if($socialform07_Q59=="1;"){$E0600C="0";}elseif($socialform07_Q59=="2;"){$E0600C="1";}else{$E0600C="";}
	  $QE0500A = $E0500A;
	  $QE0500B = $E0500B;
	  $QE0500C = $E0500C;
	  $QE0600A = $E0600A;
	  $QE0600B = $E0600B;
	  $QE0600C = $E0600C;
	  }
	  if($socialform07_Q61=="1;"){$E0800="0";}elseif($socialform07_Q61=="2;"){$E0800="1";}elseif($socialform07_Q61=="3;"){$E0800="2";}elseif($socialform07_Q61=="4;"){$E0800="3";}else{$E0800="";}
	  $QE0800 = $E0800;
	  $page11Qfiller = array($_SESSION['ncareID_lwj'],$socialform07_Qfiller);
	  $page11Qfiller = array_unique($page11Qfiller);
	  sort($page11Qfiller);
	  for($i=0;$i<count($page11Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page11Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page11QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page11QfillerFilter = explode(";",$page11QfillerFilter);
	  $page11QfillerFilter = array_unique($page11QfillerFilter);
	  $page11Qfiller = array_diff($page11QfillerFilter, array(null,'null','',' '));
	  sort($page11Qfiller);
	  for($i=0;$i<count($page11Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page11Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
      }
	  }
	  $k = array("QE0100A","QE0100B","QE0100Z","QE0200A","QE0200B","QE0200C","QE0300","QE0500A","QE0500B","QE0500C","QE0600A","QE0600B","QE0600C","QE0800");
	  $v = array($QE0100A,$QE0100B,$QE0100Z,$QE0200A,$QE0200B,$QE0200C,$QE0300,$QE0500A,$QE0500B,$QE0500C,$QE0600A,$QE0600B,$QE0600C,$QE0800);
	
	}elseif($j==12){  /*=============== 12 ===============*/

 	  if($A0050!="3"){
	  if($B0100!="1"){
	  $E0900=0;
	  if (in_array("5", $E0200)){
	  	if($socialform07_Q51d=="1;") {$E0900="1";}elseif($socialform07_Q51d=="2;") {$E0900="2";}elseif($socialform07_Q51d=="3;"){$E0900="3";}else{$E0900="";}
	  }
	  $QE0900 = $E0900;  /* OK 判斷跳題 E1100 */
	  if($QE0900!="0"){
	  if($socialform07_Q62=="1;") {$E1000A="0";}elseif($socialform07_Q62=="2;") {$E1000A="1";}else{$E1000A="";}
	  if($socialform07_Q63=="1;") {$E1000B="0";}elseif($socialform07_Q63=="2;") {$E1000B="1";}else{$E1000B="";}
	  $QE1000A = $E1000A;
	  $QE1000B = $E1000B;
	  }
	  $db32 = new DB;
 	  $db32->query("SELECT * FROM `mdsform11` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."'");
 	  if($db32->num_rows()>0){
		  $r32 = $db32->fetch_assoc();
	  }
	  $db33 = new DB;
 	  $db33->query("SELECT * FROM `mdsform12` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."'");
 	  if($db33->num_rows()>0){
		  $r33 = $db33->fetch_assoc();
	  }
	  $E1100=0;
	  $E1100 = $E1100+($E0200A+$E0200B+$E0200C+$E0800+$E0900)-($r32['QE0200A']+$r32['QE0200B']+$r32['QE0200C']+$r32['QE0800']+$r33['QE0900']);
	  if($r30['date']==""){$E1100="3";}elseif($E1100==0){$E1100="0";}elseif($E1100<0){$E1100="1";}elseif($E1100>0){$E1100="2";}else{$E1100="";}
	  $QE1100 = $E1100;  /*判斷行為是否有改變 Consider all of the symptoms assessed in items E0100 through E1000 */
	  $page12Qfiller = array($_SESSION['ncareID_lwj']);
	  $page12Qfiller = array_unique($page12Qfiller);
	  sort($page12Qfiller);
	  for($i=0;$i<count($page12Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page12Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page12QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page12QfillerFilter = explode(";",$page12QfillerFilter);
	  $page12QfillerFilter = array_unique($page12QfillerFilter);
	  $page12Qfiller = array_diff($page12QfillerFilter, array(null,'null','',' '));
	  sort($page12Qfiller);
	  for($i=0;$i<count($page12Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page12Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  $k = array("QE0900","QE1000A","QE1000B","QE1100");
	  $v = array($QE0900,$QE1000A,$QE1000B,$QE1100);
	
	}elseif($j==13){  /*=============== 13 ===============*/  

	  if($A0050!="3"){
	  if($B0100!="1"){
	  /* OK 判斷跳題 F0800、F0400 */
	  if($careform13_Q1=="1;"){
	  	$F0300="0";
	  }elseif($careform13_Q1=="2;"){
	  	$F0300="1";
	  }else{
		$F0300="";
	  }
	  $QF0300 = $F0300;
	  if($F0300=="1"){
	  	if($careform13_Q3=="1"||$careform13_Q3=="2"||$careform13_Q3=="3"||$careform13_Q3=="4"||$careform13_Q3=="5"||$careform13_Q3=="9") {$F0400A = $careform13_Q3;}
	  	if($careform13_Q4=="1"||$careform13_Q4=="2"||$careform13_Q4=="3"||$careform13_Q4=="4"||$careform13_Q4=="5"||$careform13_Q4=="9") {$F0400B = $careform13_Q4;}
	  	if($careform13_Q5=="1"||$careform13_Q5=="2"||$careform13_Q5=="3"||$careform13_Q5=="4"||$careform13_Q5=="5"||$careform13_Q5=="9") {$F0400C = $careform13_Q5;}
	  	if($careform13_Q6=="1"||$careform13_Q6=="2"||$careform13_Q6=="3"||$careform13_Q6=="4"||$careform13_Q6=="5"||$careform13_Q6=="9") {$F0400D = $careform13_Q6;}
	  	if($careform13_Q7=="1"||$careform13_Q7=="2"||$careform13_Q7=="3"||$careform13_Q7=="4"||$careform13_Q7=="5"||$careform13_Q7=="9") {$F0400E = $careform13_Q7;}
	  	if($careform13_Q8=="1"||$careform13_Q8=="2"||$careform13_Q8=="3"||$careform13_Q8=="4"||$careform13_Q8=="5"||$careform13_Q8=="9") {$F0400F = $careform13_Q8;}
	  	if($careform13_Q9=="1"||$careform13_Q9=="2"||$careform13_Q9=="3"||$careform13_Q9=="4"||$careform13_Q9=="5"||$careform13_Q9=="9") {$F0400G = $careform13_Q9;}
	  	if($careform13_Q10=="1"||$careform13_Q10=="2"||$careform13_Q10=="3"||$careform13_Q10=="4"||$careform13_Q10=="5"||$careform13_Q10=="9") {$F0400H = $careform13_Q10;}
	  	if($careform13_Q11=="1"||$careform13_Q11=="2"||$careform13_Q11=="3"||$careform13_Q11=="4"||$careform13_Q11=="5"||$careform13_Q11=="9") {$F0500A = $careform13_Q11;}
	  	if($careform13_Q12=="1"||$careform13_Q12=="2"||$careform13_Q12=="3"||$careform13_Q12=="4"||$careform13_Q12=="5"||$careform13_Q12=="9") {$F0500B = $careform13_Q12;}
	  	if($careform13_Q13=="1"||$careform13_Q13=="2"||$careform13_Q13=="3"||$careform13_Q13=="4"||$careform13_Q13=="5"||$careform13_Q13=="9") {$F0500C = $careform13_Q13;}
	  	if($careform13_Q14=="1"||$careform13_Q14=="2"||$careform13_Q14=="3"||$careform13_Q14=="4"||$careform13_Q14=="5"||$careform13_Q14=="9") {$F0500D = $careform13_Q14;}
	  	if($careform13_Q15=="1"||$careform13_Q15=="2"||$careform13_Q15=="3"||$careform13_Q15=="4"||$careform13_Q15=="5"||$careform13_Q15=="9") {$F0500E = $careform13_Q15;}
	  	if($careform13_Q16=="1"||$careform13_Q16=="2"||$careform13_Q16=="3"||$careform13_Q16=="4"||$careform13_Q16=="5"||$careform13_Q16=="9") {$F0500F = $careform13_Q16;}
	  	if($careform13_Q17=="1"||$careform13_Q17=="2"||$careform13_Q17=="3"||$careform13_Q17=="4"||$careform13_Q17=="5"||$careform13_Q17=="9") {$F0500G = $careform13_Q17;}
	  	if($careform13_Q18=="1"||$careform13_Q18=="2"||$careform13_Q18=="3"||$careform13_Q18=="4"||$careform13_Q18=="5"||$careform13_Q18=="9") {$F0500H = $careform13_Q18;}
	  	if($careform13_Q19=="1"||$careform13_Q19=="2"||$careform13_Q19=="9") {$F0600 = $careform13_Q19;}	  
 	  $QF0400A = $F0400A;
	  $QF0400B = $F0400B;
	  $QF0400C = $F0400C;
	  $QF0400D = $F0400D;
	  $QF0400E = $F0400E;
	  $QF0400F = $F0400F;
	  $QF0400G = $F0400G;
	  $QF0400H = $F0400H;
	  $QF0500A = $F0500A;
	  $QF0500B = $F0500B;
	  $QF0500C = $F0500C;
	  $QF0500D = $F0500D;
	  $QF0500E = $F0500E;
	  $QF0500F = $F0500F;
	  $QF0500G = $F0500G;
	  $QF0500H = $F0500H;
	  $QF0600 = $F0600;
	  }
	  $page13Qfiller = array($_SESSION['ncareID_lwj'],$careform13_Qfiller);
	  $page13Qfiller = array_unique($page13Qfiller);
	  sort($page13Qfiller);
	  for($i=0;$i<count($page13Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page13Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page13QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page13QfillerFilter = explode(";",$page13QfillerFilter);
	  $page13QfillerFilter = array_unique($page13QfillerFilter);
	  $page13Qfiller = array_diff($page13QfillerFilter, array(null,'null','',' '));
	  sort($page13Qfiller);
	  for($i=0;$i<count($page13Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page13Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  $k = array("QF0300","QF0400A","QF0400B","QF0400C","QF0400D","QF0400E","QF0400F","QF0400G","QF0400H","QF0500A","QF0500B","QF0500C","QF0500D","QF0500E","QF0500F","QF0500G","QF0500H","QF0600");
	  $v = array($QF0300,$QF0400A,$QF0400B,$QF0400C,$QF0400D,$QF0400E,$QF0400F,$QF0400G,$QF0400H,$QF0500A,$QF0500B,$QF0500C,$QF0500D,$QF0500E,$QF0500F,$QF0500G,$QF0500H,$QF0600);
	
	}elseif($j==14){  /*=============== 14 ===============*/ 
	  
	  if($A0050!="3"){
	  if($B0100!="1"){
	  /* OK 判斷跳題 G0110、F0800(如果F0400 and F0500，3題以上 無法回答，則要填寫F0800) */
 	  /* Do not conduct if Interview for Daily and Activity Preferences (F0400-F0500) was completed */
 	  if($F0300=="1"){
	  if($careform13_Q2=="1;"){
 	  	$F0700="0";
	  }elseif($careform13_Q2=="2;"){
		$F0700="1";
	  }else{
		$F0700="";
	  }
	  }
      if($F0700=="1" || $F0300=="0"){
 	  	if($careform13_Q21=="1;"){$F0800A ="X";}else{$F0800A ="";}
	  	if($careform13_Q22=="1;"){$F0800B ="X";}else{$F0800B ="";}
	  	$receivingBath = explode(";",$careform13_Q23);
	  	if (in_array("1", $receivingBath)) {$F0800C ="X";}else{$F0800C ="";};
	  	if (in_array("2", $receivingBath)) {$F0800D ="X";}else{$F0800D ="";};
	  	if (in_array("3", $receivingBath)) {$F0800E ="X";}else{$F0800E ="";};
	  	if (in_array("4", $receivingBath)) {$F0800F ="X";}else{$F0800F ="";};
	  	if($careform13_Q24=="1;"){$F0800G ="X";}else{$F0800G ="";}
	  	if($careform13_Q25=="1;"){$F0800H ="X";}else{$F0800H ="";}
	  	if($careform13_Q26=="1;"){$F0800I ="X";}else{$F0800I ="";}
	  	if($careform13_Q27=="1;"){$F0800J ="X";}else{$F0800J ="";}
	  	if($careform13_Q28=="1;"){$F0800K ="X";}else{$F0800K ="";}
	  	if($careform13_Q29=="1;"){$F0800L ="X";}else{$F0800L ="";}
	  	if($careform13_Q30=="1;"){$F0800M ="X";}else{$F0800M ="";}
	  	if($careform13_Q31=="1;"){$F0800N ="X";}else{$F0800N ="";}
	  	if($careform13_Q32=="1;"){$F0800O ="X";}else{$F0800O ="";}
	  	if($careform13_Q33=="1;"){$F0800P ="X";}else{$F0800P ="";}
	  	if($careform13_Q34=="1;"){$F0800Q ="X";}else{$F0800Q ="";}
	  	$spendingTime = explode(";",$careform13_Q35);
	  	if (in_array("1", $spendingTime)) {$F0800R ="X";}else{$F0800R ="";};
	  	if (in_array("2", $spendingTime)) {$F0800S ="X";}else{$F0800S ="";};
	  	if($careform13_Q36=="1;"){$F0800T ="X";}else{$F0800T ="";}
	  	if($careform13_Q20=="1;"){$F0800Z ="X";}else{$F0800Z ="";}	  
 	  $QF0700 = $F0700;  
	  $QF0800A = $F0800A;
	  $QF0800B = $F0800B;
	  $QF0800C = $F0800C;
	  $QF0800D = $F0800D;
	  $QF0800E = $F0800E;
	  $QF0800F = $F0800F;
	  $QF0800G = $F0800G;
	  $QF0800H = $F0800H;
	  $QF0800I = $F0800I;
	  $QF0800J = $F0800J;
	  $QF0800K = $F0800K;
	  $QF0800L = $F0800L;
	  $QF0800M = $F0800M;
	  $QF0800N = $F0800N;
	  $QF0800O = $F0800O;
	  $QF0800P = $F0800P;
	  $QF0800Q = $F0800Q;
	  $QF0800R = $F0800R;
	  $QF0800S = $F0800S;
	  $QF0800T = $F0800T;
	  $QF0800Z = $F0800Z;
	  }
	  $page14Qfiller = array($_SESSION['ncareID_lwj'],$careform13_Qfiller);
	  $page14Qfiller = array_unique($page14Qfiller);
	  sort($page14Qfiller);
	  for($i=0;$i<count($page14Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page14Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page14QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page14QfillerFilter = explode(";",$page14QfillerFilter);
	  $page14QfillerFilter = array_unique($page14QfillerFilter);
	  $page14Qfiller = array_diff($page14QfillerFilter, array(null,'null','',' '));
	  sort($page14Qfiller);
	  for($i=0;$i<count($page14Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page14Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  $k = array("QF0700","QF0800A","QF0800B","QF0800C","QF0800D","QF0800E","QF0800F","QF0800G","QF0800H","QF0800I","QF0800J","QF0800K","QF0800L","QF0800M","QF0800N","QF0800O","QF0800P","QF0800Q","QF0800R","QF0800S","QF0800T","QF0800Z");
	  $v = array($QF0700,$QF0800A,$QF0800B,$QF0800C,$QF0800D,$QF0800E,$QF0800F,$QF0800G,$QF0800H,$QF0800I,$QF0800J,$QF0800K,$QF0800L,$QF0800M,$QF0800N,$QF0800O,$QF0800P,$QF0800Q,$QF0800R,$QF0800S,$QF0800T,$QF0800Z);
	
	}elseif($j==15){  /*=============== 15 ===============*/

	  if($A0050!="3"){
	  if($nurseform41_Q1=="1;"){$G0110A1 ="0";}elseif($nurseform41_Q1=="2;"){$G0110A1 ="1";}elseif($nurseform41_Q1=="3;"){$G0110A1 ="2";}elseif($nurseform41_Q1=="4;"){$G0110A1 ="3";}elseif($nurseform41_Q1=="5;"){$G0110A1 ="4";}elseif($nurseform41_Q1=="6;"){$G0110A1 ="7";}elseif($nurseform41_Q1=="7;"){$G0110A1 ="8";}else{$G0110A1 ="";}
 	  if($nurseform41_Q3=="1;"){$G0110B1 ="0";}elseif($nurseform41_Q3=="2;"){$G0110B1 ="1";}elseif($nurseform41_Q3=="3;"){$G0110B1 ="2";}elseif($nurseform41_Q3=="4;"){$G0110B1 ="3";}elseif($nurseform41_Q3=="5;"){$G0110B1 ="4";}elseif($nurseform41_Q3=="6;"){$G0110B1 ="7";}elseif($nurseform41_Q3=="7;"){$G0110B1 ="8";}else{$G0110B1 ="";}
 	  if($nurseform41_Q5=="1;"){$G0110C1 ="0";}elseif($nurseform41_Q5=="2;"){$G0110C1 ="1";}elseif($nurseform41_Q5=="3;"){$G0110C1 ="2";}elseif($nurseform41_Q5=="4;"){$G0110C1 ="3";}elseif($nurseform41_Q5=="5;"){$G0110C1 ="4";}elseif($nurseform41_Q5=="6;"){$G0110C1 ="7";}elseif($nurseform41_Q5=="7;"){$G0110C1 ="8";}else{$G0110C1 ="";}
 	  if($nurseform41_Q7=="1;"){$G0110D1 ="0";}elseif($nurseform41_Q7=="2;"){$G0110D1 ="1";}elseif($nurseform41_Q7=="3;"){$G0110D1 ="2";}elseif($nurseform41_Q7=="4;"){$G0110D1 ="3";}elseif($nurseform41_Q7=="5;"){$G0110D1 ="4";}elseif($nurseform41_Q7=="6;"){$G0110D1 ="7";}elseif($nurseform41_Q7=="7;"){$G0110D1 ="8";}else{$G0110D1 ="";}
 	  if($nurseform41_Q9=="1;"){$G0110E1 ="0";}elseif($nurseform41_Q9=="2;"){$G0110E1 ="1";}elseif($nurseform41_Q9=="3;"){$G0110E1 ="2";}elseif($nurseform41_Q9=="4;"){$G0110E1 ="3";}elseif($nurseform41_Q9=="5;"){$G0110E1 ="4";}elseif($nurseform41_Q9=="6;"){$G0110E1 ="7";}elseif($nurseform41_Q9=="7;"){$G0110E1 ="8";}else{$G0110E1 ="";}
 	  if($nurseform41_Q11=="1;"){$G0110F1 ="0";}elseif($nurseform41_Q11=="2;"){$G0110F1 ="1";}elseif($nurseform41_Q11=="3;"){$G0110F1 ="2";}elseif($nurseform41_Q11=="4;"){$G0110F1 ="3";}elseif($nurseform41_Q11=="5;"){$G0110F1 ="4";}elseif($nurseform41_Q11=="6;"){$G0110F1 ="7";}elseif($nurseform41_Q11=="7;"){$G0110F1 ="8";}else{$G0110F1 ="";}
 	  if($nurseform41_Q13=="1;"){$G0110G1 ="0";}elseif($nurseform41_Q13=="2;"){$G0110G1 ="1";}elseif($nurseform41_Q13=="3;"){$G0110G1 ="2";}elseif($nurseform41_Q13=="4;"){$G0110G1 ="3";}elseif($nurseform41_Q13=="5;"){$G0110G1 ="4";}elseif($nurseform41_Q13=="6;"){$G0110G1 ="7";}elseif($nurseform41_Q13=="7;"){$G0110G1 ="8";}else{$G0110G1 ="";}
 	  if($nurseform41_Q15=="1;"){$G0110H1 ="0";}elseif($nurseform41_Q15=="2;"){$G0110H1 ="1";}elseif($nurseform41_Q15=="3;"){$G0110H1 ="2";}elseif($nurseform41_Q15=="4;"){$G0110H1 ="3";}elseif($nurseform41_Q15=="5;"){$G0110H1 ="4";}elseif($nurseform41_Q15=="6;"){$G0110H1 ="7";}elseif($nurseform41_Q15=="7;"){$G0110H1 ="8";}else{$G0110H1 ="";}
 	  if($nurseform41_Q17=="1;"){$G0110I1 ="0";}elseif($nurseform41_Q17=="2;"){$G0110I1 ="1";}elseif($nurseform41_Q17=="3;"){$G0110I1 ="2";}elseif($nurseform41_Q17=="4;"){$G0110I1 ="3";}elseif($nurseform41_Q17=="5;"){$G0110I1 ="4";}elseif($nurseform41_Q17=="6;"){$G0110I1 ="7";}elseif($nurseform41_Q17=="7;"){$G0110I1 ="8";}else{$G0110I1 ="";}
 	  if($nurseform41_Q19=="1;"){$G0110J1 ="0";}elseif($nurseform41_Q19=="2;"){$G0110J1 ="1";}elseif($nurseform41_Q19=="3;"){$G0110J1 ="2";}elseif($nurseform41_Q19=="4;"){$G0110J1 ="3";}elseif($nurseform41_Q19=="5;"){$G0110J1 ="4";}elseif($nurseform41_Q19=="6;"){$G0110J1 ="7";}elseif($nurseform41_Q19=="7;"){$G0110J1 ="8";}else{$G0110J1 ="";}
 	  if($nurseform41_Q2=="1;"){$G0110A2 ="0";}elseif($nurseform41_Q2=="2;"){$G0110A2 ="1";}elseif($nurseform41_Q2=="3;"){$G0110A2 ="2";}elseif($nurseform41_Q2=="4;"){$G0110A2 ="3";}elseif($nurseform41_Q2=="5;"){$G0110A2 ="8";}else{$G0110A2 ="";}
 	  if($nurseform41_Q4=="1;"){$G0110B2 ="0";}elseif($nurseform41_Q4=="2;"){$G0110B2 ="1";}elseif($nurseform41_Q4=="3;"){$G0110B2 ="2";}elseif($nurseform41_Q4=="4;"){$G0110B2 ="3";}elseif($nurseform41_Q4=="5;"){$G0110B2 ="8";}else{$G0110B2 ="";}
 	  if($nurseform41_Q6=="1;"){$G0110C2 ="0";}elseif($nurseform41_Q6=="2;"){$G0110C2 ="1";}elseif($nurseform41_Q6=="3;"){$G0110C2 ="2";}elseif($nurseform41_Q6=="4;"){$G0110C2 ="3";}elseif($nurseform41_Q6=="5;"){$G0110C2 ="8";}else{$G0110C2 ="";}
 	  if($nurseform41_Q8=="1;"){$G0110D2 ="0";}elseif($nurseform41_Q8=="2;"){$G0110D2 ="1";}elseif($nurseform41_Q8=="3;"){$G0110D2 ="2";}elseif($nurseform41_Q8=="4;"){$G0110D2 ="3";}elseif($nurseform41_Q8=="5;"){$G0110D2 ="8";}else{$G0110D2 ="";}
 	  if($nurseform41_Q10=="1;"){$G0110E2 ="0";}elseif($nurseform41_Q10=="2;"){$G0110E2 ="1";}elseif($nurseform41_Q10=="3;"){$G0110E2 ="2";}elseif($nurseform41_Q10=="4;"){$G0110E2 ="3";}elseif($nurseform41_Q10=="5;"){$G0110E2 ="8";}else{$G0110E2 ="";}
 	  if($nurseform41_Q12=="1;"){$G0110F2 ="0";}elseif($nurseform41_Q12=="2;"){$G0110F2 ="1";}elseif($nurseform41_Q12=="3;"){$G0110F2 ="2";}elseif($nurseform41_Q12=="4;"){$G0110F2 ="3";}elseif($nurseform41_Q12=="5;"){$G0110F2 ="8";}else{$G0110F2 ="";}
 	  if($nurseform41_Q14=="1;"){$G0110G2 ="0";}elseif($nurseform41_Q14=="2;"){$G0110G2 ="1";}elseif($nurseform41_Q14=="3;"){$G0110G2 ="2";}elseif($nurseform41_Q14=="4;"){$G0110G2 ="3";}elseif($nurseform41_Q14=="5;"){$G0110G2 ="8";}else{$G0110G2 ="";}
 	  if($nurseform41_Q16=="1;"){$G0110H2 ="0";}elseif($nurseform41_Q16=="2;"){$G0110H2 ="1";}elseif($nurseform41_Q16=="3;"){$G0110H2 ="2";}elseif($nurseform41_Q16=="4;"){$G0110H2 ="3";}elseif($nurseform41_Q16=="5;"){$G0110H2 ="8";}else{$G0110H2 ="";}
 	  if($nurseform41_Q18=="1;"){$G0110I2 ="0";}elseif($nurseform41_Q18=="2;"){$G0110I2 ="1";}elseif($nurseform41_Q18=="3;"){$G0110I2 ="2";}elseif($nurseform41_Q18=="4;"){$G0110I2 ="3";}elseif($nurseform41_Q18=="5;"){$G0110I2 ="8";}else{$G0110I2 ="";}
 	  if($nurseform41_Q20=="1;"){$G0110J2 ="0";}elseif($nurseform41_Q20=="2;"){$G0110J2 ="1";}elseif($nurseform41_Q20=="3;"){$G0110J2 ="2";}elseif($nurseform41_Q20=="4;"){$G0110J2 ="3";}elseif($nurseform41_Q20=="5;"){$G0110J2 ="8";}else{$G0110J2 ="";}
 	  $QG0110A1 = $G0110A1;
	  $QG0110A2 = $G0110A2;
	  $QG0110B1 = $G0110B1;
	  $QG0110B2 = $G0110B2;
	  $QG0110C1 = $G0110C1;
	  $QG0110C2 = $G0110C2;
	  $QG0110D1 = $G0110D1;
	  $QG0110D2 = $G0110D2;
	  $QG0110E1 = $G0110E1;
	  $QG0110E2 = $G0110E2;
	  $QG0110F1 = $G0110F1;
	  $QG0110F2 = $G0110F2;
	  $QG0110G1 = $G0110G1;
	  $QG0110G2 = $G0110G2;
	  $QG0110H1 = $G0110H1;
	  $QG0110H2 = $G0110H2;
	  $QG0110I1 = $G0110I1;
	  $QG0110I2 = $G0110I2;
	  $QG0110J1 = $G0110J1;
	  $QG0110J2 = $G0110J2;
	  $page15Qfiller = array($_SESSION['ncareID_lwj'],$nurseform41_Qfiller);
	  $page15Qfiller = array_unique($page15Qfiller);
	  sort($page15Qfiller);
	  for($i=0;$i<count($page15Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page15Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page15QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page15QfillerFilter = explode(";",$page15QfillerFilter);
	  $page15QfillerFilter = array_unique($page15QfillerFilter);
	  $page15Qfiller = array_diff($page15QfillerFilter, array(null,'null','',' '));
	  sort($page15Qfiller);
	  for($i=0;$i<count($page15Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page15Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QG0110A1","QG0110A2","QG0110B1","QG0110B2","QG0110C1","QG0110C2","QG0110D1","QG0110D2","QG0110E1","QG0110E2","QG0110F1","QG0110F2","QG0110G1","QG0110G2","QG0110H1","QG0110H2","QG0110I1","QG0110I2","QG0110J1","QG0110J2");
	  $v = array($QG0110A1,$QG0110A2,$QG0110B1,$QG0110B2,$QG0110C1,$QG0110C2,$QG0110D1,$QG0110D2,$QG0110E1,$QG0110E2,$QG0110F1,$QG0110F2,$QG0110G1,$QG0110G2,$QG0110H1,$QG0110H2,$QG0110I1,$QG0110I2,$QG0110J1,$QG0110J2);
	
	}elseif($j==16){  /*=============== 16 ===============*/

	  if($A0050!="3"){
	  if($nurseform41_Q21=="1;"){$G0120A ="0";}elseif($nurseform41_Q21=="2;"){$G0120A ="1";}elseif($nurseform41_Q21=="3;"){$G0120A ="2";}elseif($nurseform41_Q21=="4;"){$G0120A ="3";}elseif($nurseform41_Q21=="5;"){$G0120A ="4";}elseif($nurseform41_Q21=="6;"){$G0120A ="8";}else{$G0120A ="";}
	  if($nurseform41_Q22=="1;"){$G0120B ="0";}elseif($nurseform41_Q22=="2;"){$G0120B ="1";}elseif($nurseform41_Q22=="3;"){$G0120B ="2";}elseif($nurseform41_Q22=="4;"){$G0120B ="3";}elseif($nurseform41_Q22=="5;"){$G0120B ="8";}else{$G0120B ="";}
 	  $QG0120A = $G0120A;
	  $QG0120B = $G0120B;
	  if($nurseform02b_Q54=="1;"){$G0300A ="0";}elseif($nurseform02b_Q54=="2;"){$G0300A ="1";}elseif($nurseform02b_Q54=="3;"){$G0300A ="2";}elseif($nurseform02b_Q54=="4;"){$G0300A ="8";}else{$G0300A ="";}
      if($nurseform02b_Q56=="1;"){$G0300B ="0";}elseif($nurseform02b_Q56=="2;"){$G0300B ="1";}elseif($nurseform02b_Q56=="3;"){$G0300B ="2";}elseif($nurseform02b_Q56=="4;"){$G0300B ="8";}else{$G0300B ="";}
	  if($nurseform02b_Q57=="1;"){$G0300C ="0";}elseif($nurseform02b_Q57=="2;"){$G0300C ="1";}elseif($nurseform02b_Q57=="3;"){$G0300C ="2";}elseif($nurseform02b_Q57=="4;"){$G0300C ="8";}else{$G0300C ="";}
	  if($nurseform02b_Q58=="1;"){$G0300D ="0";}elseif($nurseform02b_Q58=="2;"){$G0300D ="1";}elseif($nurseform02b_Q58=="3;"){$G0300D ="2";}elseif($nurseform02b_Q58=="4;"){$G0300D ="8";}else{$G0300D ="";}
	  if($nurseform02b_Q59=="1;"){$G0300E ="0";}elseif($nurseform02b_Q59=="2;"){$G0300E ="1";}elseif($nurseform02b_Q59=="3;"){$G0300E ="2";}elseif($nurseform02b_Q59=="4;"){$G0300E ="8";}else{$G0300E ="";}
	  $QG0300A = $G0300A;
	  $QG0300B = $G0300B;
	  $QG0300C = $G0300C;
	  $QG0300D = $G0300D;
	  $QG0300E = $G0300E;
	  if($nurseform02b_Q77=="1;"){$G0400A ="0";}elseif($nurseform02b_Q77=="2;"){$G0400A ="1";}elseif($nurseform02b_Q77=="3;"){$G0400A ="2";}else{$G0400A ="";}
	  if($nurseform02b_Q78=="1;"){$G0400B ="0";}elseif($nurseform02b_Q78=="2;"){$G0400B ="1";}elseif($nurseform02b_Q78=="3;"){$G0400B ="2";}else{$G0400B ="";}
	  $QG0400A = $G0400A;
	  $QG0400B = $G0400B;
	  $G0600 = explode(";",$nurseform02b_Q60);
	  if (in_array("1",$G0600)) {$G0600A ="X";}else{$G0600A ="";}
	  if (in_array("2",$G0600)) {$G0600B ="X";}else{$G0600B ="";}
	  if (in_array("3",$G0600)) {$G0600C ="X";}else{$G0600C ="";}
	  if (in_array("4",$G0600)) {$G0600D ="X";}else{$G0600D ="";}
	  if (in_array("5",$G0600)) {$G0600Z ="X";}else{$G0600Z ="";}
	  $QG0600A = $G0600A;
	  $QG0600B = $G0600B;
	  $QG0600C = $G0600C;
	  $QG0600D = $G0600D;
	  $QG0600Z = $G0600Z;
	  /* QG0900 Complete only if A0310A = 01 */
	  if($A0310A=="01"){
	  	if($nurseform41_Q23=="1;"){$G0900A ="0";}elseif($nurseform41_Q23=="2;"){$G0900A ="1";}elseif($nurseform41_Q23=="3;"){$G0900A ="9";}else{$G0900A ="";}
	  	if($nurseform41_Q24=="1;"){$G0900B ="0";}elseif($nurseform41_Q24=="2;"){$G0900B ="1";}else{$G0900B ="";}
	  $QG0900A = $G0900A;
	  $QG0900B = $G0900B;
	  }
	  $page16Qfiller = array($_SESSION['ncareID_lwj'],$nurseform41_Qfiller,$nurseform02b_Qfiller);
	  $page16Qfiller = array_unique($page16Qfiller);
	  sort($page16Qfiller);
	  for($i=0;$i<count($page16Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page16Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page16QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page16QfillerFilter = explode(";",$page16QfillerFilter);
	  $page16QfillerFilter = array_unique($page16QfillerFilter);
	  $page16Qfiller = array_diff($page16QfillerFilter, array(null,'null','',' '));
	  sort($page16Qfiller);
	  for($i=0;$i<count($page16Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page16Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QG0120A","QG0120B","QG0300A","QG0300B","QG0300C","QG0300D","QG0300E","QG0400A","QG0400B","QG0600A","QG0600B","QG0600C","QG0600D","QG0600Z","QG0900A","QG0900B");
	  $v = array($QG0120A,$QG0120B,$QG0300A,$QG0300B,$QG0300C,$QG0300D,$QG0300E,$QG0400A,$QG0400B,$QG0600A,$QG0600B,$QG0600C,$QG0600D,$QG0600Z,$QG0900A,$QG0900B);
	
	}elseif($j==17){  /*=============== 17 ===============*/  

	  if($A0050!="3"){
	  $H0100 = explode(";",$nurseform02b_Q35);
	  if (in_array("5",$H0100)) {$H0100A ="X";}else{$H0100A ="";}
	  if (in_array("6",$H0100)) {$H0100B ="X";}else{$H0100B ="";}
	  if (in_array("4",$H0100)) {$H0100D ="X";}else{$H0100D ="";}
	  $QH0100A = $H0100A;
	  $QH0100B = $H0100B;
	  $QH0100D = $H0100D;
	  $H0100 = explode(";",$nurseform02b_Q42);
	  if (in_array("6",$H0100)) {$H0100C ="X";}else{$H0100C ="";}
	  $QH0100C = $H0100C;
	  if ($H0100A=="" && $H0100B=="" && $H0100C=="" && $H0100D==""){$H0100Z="X";}else{$H0100Z="";}
	  $QH0100Z = $H0100Z;
	  if($nurseform02b_Q61=="1;"){$H0200A ="0";}elseif($nurseform02b_Q61=="2;"){$H0200A ="1";}elseif($nurseform02b_Q61=="3;"){$H0200A ="9";}else{$H0200A ="";} /* OK 判斷跳題 H0300、H0200B、H0200C */
	  $QH0200A = $H0200A;
	  if($H0200A=="1"){
	  if($nurseform02b_Q62=="1;"){$H0200B ="0";}elseif($nurseform02b_Q62=="2;"){$H0200B ="1";}elseif($nurseform02b_Q62=="3;"){$H0200B ="2";}elseif($nurseform02b_Q62=="4;"){$H0200B ="9";}else{$H0200B ="";}
	  if($nurseform02b_Q63=="1;"){$H0200C ="0";}elseif($nurseform02b_Q63=="2;"){$H0200C ="1";}else{$H0200C ="";}	  	  
	  $QH0200B = $H0200B;
	  $QH0200C = $H0200C;
	  }
	  if($H0200A=="9"){
	  if($nurseform02b_Q63=="1;"){$H0200C ="0";}elseif($nurseform02b_Q63=="2;"){$H0200C ="1";}else{$H0200C ="";}
	  $QH0200C = $H0200C;
	  }
	  if($nurseform02b_Q64=="1;"){$H0300 ="0";}elseif($nurseform02b_Q64=="2;"){$H0300 ="1";}elseif($nurseform02b_Q64=="3;"){$H0300 ="2";}elseif($nurseform02b_Q64=="4;"){$H0300 ="3";}elseif($nurseform02b_Q64=="5;"){$H0300 ="9";}else{$H0300 ="";}
	  if($nurseform02b_Q66=="1;"){$H0400 ="0";}elseif($nurseform02b_Q66=="2;"){$H0400 ="1";}elseif($nurseform02b_Q66=="3;"){$H0400 ="2";}elseif($nurseform02b_Q66=="4;"){$H0400 ="3";}elseif($nurseform02b_Q66=="5;"){$H0400 ="9";}else{$H0400 ="";}
	  if($nurseform02b_Q65=="1;"){$H0500 ="0";}elseif($nurseform02b_Q65=="2;"){$H0500 ="1";}else{$H0500 ="";}	  
	  if($nurseform02b_Q67=="1;"){$H0600 ="0";}elseif($nurseform02b_Q67=="2;"){$H0600 ="1";}else{$H0600 ="";}	  
	  $QH0300 = $H0300;
	  $QH0400 = $H0400;
	  $QH0500 = $H0500;
	  $QH0600 = $H0600;
	  $page17Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller);
	  $page17Qfiller = array_unique($page17Qfiller);
	  sort($page17Qfiller);
	  for($i=0;$i<count($page17Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page17Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page17QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page17QfillerFilter = explode(";",$page17QfillerFilter);
	  $page17QfillerFilter = array_unique($page17QfillerFilter);
	  $page17Qfiller = array_diff($page17QfillerFilter, array(null,'null','',' '));
	  sort($page17Qfiller);
	  for($i=0;$i<count($page17Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page17Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QH0100A","QH0100B","QH0100C","QH0100D","QH0100Z","QH0200A","QH0200B","QH0200C","QH0300","QH0400","QH0500","QH0600");
	  $v = array($QH0100A,$QH0100B,$QH0100C,$QH0100D,$QH0100Z,$QH0200A,$QH0200B,$QH0200C,$QH0300,$QH0400,$QH0500,$QH0600);
	
	}elseif($j==18){  /*=============== 18 ===============*/

 	  if($A0050!="3"){
	  $QI0100 ='';
	  $QI0200 ='';
	  $QI0300 ='';
	  $QI0400 ='';
	  $QI0500 ='';
	  $QI0600 ='';
	  $QI0700 ='';
	  $QI0800 ='';
	  $QI0900 ='';
	  $QI1100 ='';
	  $QI1200 ='';
	  $QI1300 ='';
	  $QI1400 ='';
	  $QI1500 ='';
	  $QI1550 ='';
	  $QI1650 ='';
	  $QI1700 ='';
	  $QI2000 ='';
	  $QI2100 ='';
	  $QI2200 ='';
	  $QI2300 ='';
	  $QI2400 ='';
	  $QI2500 ='';
	  $QI2900 ='';
	  $QI3100 ='';
	  $QI3200 ='';
	  $QI3300 ='';
	  $QI3400 ='';
	  $QI3700 ='';
	  $QI3800 ='';
	  $QI3900 ='';
	  $QI4000 ='';
	  $QI4200 ='';
	  $QI4300 ='';
	  $QI4400 ='';
	  $QI4500 ='';
	  $QI4800 ='';
	  $page18Qfiller = array($_SESSION['ncareID_lwj']);
	  $page18Qfiller = array_unique($page18Qfiller);
	  sort($page18Qfiller);
	  for($i=0;$i<count($page18Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page18Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page18QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page18QfillerFilter = explode(";",$page18QfillerFilter);
	  $page18QfillerFilter = array_unique($page18QfillerFilter);
	  $page18Qfiller = array_diff($page18QfillerFilter, array(null,'null','',' '));
	  sort($page18Qfiller);
	  for($i=0;$i<count($page18Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page18Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QI0100","QI0200","QI0300","QI0400","QI0500","QI0600","QI0700","QI0800","QI0900","QI1100","QI1200","QI1300","QI1400","QI1500","QI1550","QI1650","QI1700","QI2000","QI2100","QI2200","QI2300","QI2400","QI2500","QI2900","QI3100","QI3200","QI3300","QI3400","QI3700","QI3800","QI3900","QI4000","QI4200","QI4300","QI4400","QI4500","QI4800");
	  $v = array($QI0100,$QI0200,$QI0300,$QI0400,$QI0500,$QI0600,$QI0700,$QI0800,$QI0900,$QI1100,$QI1200,$QI1300,$QI1400,$QI1500,$QI1550,$QI1650,$QI1700,$QI2000,$QI2100,$QI2200,$QI2300,$QI2400,$QI2500,$QI2900,$QI3100,$QI3200,$QI3300,$QI3400,$QI3700,$QI3800,$QI3900,$QI4000,$QI4200,$QI4300,$QI4400,$QI4500,$QI4800);
	
	}elseif($j==19){  /*=============== 19 ===============*/

 	  if($A0050!="3"){
	  $QI4900 ='';
	  $QI5000 ='';
	  $QI5100 ='';
	  $QI5200 ='';
	  $QI5250 ='';
	  $QI5300 ='';
	  $QI5350 ='';
	  $QI5400 ='';
	  $QI5500 ='';
	  $QI5600 ='';
	  $QI5700 ='';
	  $QI5800 ='';
	  $QI5900 ='';
	  $QI5950 ='';
	  $QI6000 ='';
	  $QI6100 ='';
	  $QI6200 ='';
	  $QI6300 ='';
	  $QI6500 ='';
	  $QI7900 ='';
	  $QI8000Atext ='';
	  $QI8000A_1 ='';
	  $QI8000A_2 ='';
	  $QI8000A_3 ='';
	  $QI8000A_4 ='';
	  $QI8000A_5 ='';
	  $QI8000A_6 ='';
	  $QI8000A_7 ='';
	  $QI8000A_8 ='';
	  $QI8000Btext ='';
	  $QI8000B_1 ='';
	  $QI8000B_2 ='';
	  $QI8000B_3 ='';
	  $QI8000B_4 ='';
	  $QI8000B_5 ='';
	  $QI8000B_6 ='';
	  $QI8000B_7 ='';
	  $QI8000B_8 ='';
	  $QI8000Ctext ='';
	  $QI8000C_1 ='';
	  $QI8000C_2 ='';
	  $QI8000C_3 ='';
	  $QI8000C_4 ='';
	  $QI8000C_5 ='';
	  $QI8000C_6 ='';
	  $QI8000C_7 ='';
	  $QI8000C_8 ='';
	  $QI8000Dtext ='';
	  $QI8000D_1 ='';
	  $QI8000D_2 ='';
	  $QI8000D_3 ='';
	  $QI8000D_4 ='';
	  $QI8000D_5 ='';
	  $QI8000D_6 ='';
	  $QI8000D_7 ='';
	  $QI8000D_8 ='';
	  $QI8000Etext ='';
	  $QI8000E_1 ='';
	  $QI8000E_2 ='';
	  $QI8000E_3 ='';
	  $QI8000E_4 ='';
	  $QI8000E_5 ='';
	  $QI8000E_6 ='';
	  $QI8000E_7 ='';
	  $QI8000E_8 ='';
	  $QI8000Ftext ='';
	  $QI8000F_1 ='';
	  $QI8000F_2 ='';
	  $QI8000F_3 ='';
	  $QI8000F_4 ='';
	  $QI8000F_5 ='';
	  $QI8000F_6 ='';
	  $QI8000F_7 ='';
	  $QI8000F_8 ='';
	  $QI8000Gtext ='';
	  $QI8000G_1 ='';
	  $QI8000G_2 ='';
	  $QI8000G_3 ='';
	  $QI8000G_4 ='';
	  $QI8000G_5 ='';
	  $QI8000G_6 ='';
	  $QI8000G_7 ='';
	  $QI8000G_8 ='';
	  $QI8000Htext ='';
	  $QI8000H_1 ='';
	  $QI8000H_2 ='';
	  $QI8000H_3 ='';
	  $QI8000H_4 ='';
	  $QI8000H_5 ='';
	  $QI8000H_6 ='';
	  $QI8000H_7 ='';
	  $QI8000H_8 ='';
	  $QI8000Itext ='';
	  $QI8000I_1 ='';
	  $QI8000I_2 ='';
	  $QI8000I_3 ='';
	  $QI8000I_4 ='';
	  $QI8000I_5 ='';
	  $QI8000I_6 ='';
	  $QI8000I_7 ='';
	  $QI8000I_8 ='';
	  $QI8000Jtext ='';
	  $QI8000J_1 ='';
	  $QI8000J_2 ='';
	  $QI8000J_3 ='';
	  $QI8000J_4 ='';
	  $QI8000J_5 ='';
	  $QI8000J_6 ='';
	  $QI8000J_7 ='';
	  $QI8000J_8 ='';
	  $page19Qfiller = array($_SESSION['ncareID_lwj']);
	  $page19Qfiller = array_unique($page19Qfiller);
	  sort($page19Qfiller);
	  for($i=0;$i<count($page19Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page19Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page19QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page19QfillerFilter = explode(";",$page19QfillerFilter);
	  $page19QfillerFilter = array_unique($page19QfillerFilter);
	  $page19Qfiller = array_diff($page19QfillerFilter, array(null,'null','',' '));
	  sort($page19Qfiller);
	  for($i=0;$i<count($page19Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page19Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QI4900","QI5000","QI5100","QI5200","QI5250","QI5300","QI5350","QI5400","QI5500","QI5600","QI5700","QI5800","QI5900","QI5950","QI6000","QI6100","QI6200","QI6300","QI6500","QI7900","QI8000Atext","QI8000A_1","QI8000A_2","QI8000A_3","QI8000A_4","QI8000A_5","QI8000A_6","QI8000A_7","QI8000A_8","QI8000Btext","QI8000B_1","QI8000B_2","QI8000B_3","QI8000B_4","QI8000B_5","QI8000B_6","QI8000B_7","QI8000B_8","QI8000Ctext","QI8000C_1","QI8000C_2","QI8000C_3","QI8000C_4","QI8000C_5","QI8000C_6","QI8000C_7","QI8000C_8","QI8000Dtext","QI8000D_1","QI8000D_2","QI8000D_3","QI8000D_4","QI8000D_5","QI8000D_6","QI8000D_7","QI8000D_8","QI8000Etext","QI8000E_1","QI8000E_2","QI8000E_3","QI8000E_4","QI8000E_5","QI8000E_6","QI8000E_7","QI8000E_8","QI8000Ftext","QI8000F_1","QI8000F_2","QI8000F_3","QI8000F_4","QI8000F_5","QI8000F_6","QI8000F_7","QI8000F_8","QI8000Gtext","QI8000G_1","QI8000G_2","QI8000G_3","QI8000G_4","QI8000G_5","QI8000G_6","QI8000G_7","QI8000G_8","QI8000Htext","QI8000H_1","QI8000H_2","QI8000H_3","QI8000H_4","QI8000H_5","QI8000H_6","QI8000H_7","QI8000H_8","QI8000Itext","QI8000I_1","QI8000I_2","QI8000I_3","QI8000I_4","QI8000I_5","QI8000I_6","QI8000I_7","QI8000I_8","QI8000Jtext","QI8000J_1","QI8000J_2","QI8000J_3","QI8000J_4","QI8000J_5","QI8000J_6","QI8000J_7","QI8000J_8");
	  $v = array($QI4900,$QI5000,$QI5100,$QI5200,$QI5250,$QI5300,$QI5350,$QI5400,$QI5500,$QI5600,$QI5700,$QI5800,$QI5900,$QI5950,$QI6000,$QI6100,$QI6200,$QI6300,$QI6500,$QI7900,$QI8000Atext,$QI8000A_1,$QI8000A_2,$QI8000A_3,$QI8000A_4,$QI8000A_5,$QI8000A_6,$QI8000A_7,$QI8000A_8,$QI8000Btext,$QI8000B_1,$QI8000B_2,$QI8000B_3,$QI8000B_4,$QI8000B_5,$QI8000B_6,$QI8000B_7,$QI8000B_8,$QI8000Ctext,$QI8000C_1,$QI8000C_2,$QI8000C_3,$QI8000C_4,$QI8000C_5,$QI8000C_6,$QI8000C_7,$QI8000C_8,$QI8000Dtext,$QI8000D_1,$QI8000D_2,$QI8000D_3,$QI8000D_4,$QI8000D_5,$QI8000D_6,$QI8000D_7,$QI8000D_8,$QI8000Etext,$QI8000E_1,$QI8000E_2,$QI8000E_3,$QI8000E_4,$QI8000E_5,$QI8000E_6,$QI8000E_7,$QI8000E_8,$QI8000Ftext,$QI8000F_1,$QI8000F_2,$QI8000F_3,$QI8000F_4,$QI8000F_5,$QI8000F_6,$QI8000F_7,$QI8000F_8,$QI8000Gtext,$QI8000G_1,$QI8000G_2,$QI8000G_3,$QI8000G_4,$QI8000G_5,$QI8000G_6,$QI8000G_7,$QI8000G_8,$QI8000Htext,$QI8000H_1,$QI8000H_2,$QI8000H_3,$QI8000H_4,$QI8000H_5,$QI8000H_6,$QI8000H_7,$QI8000H_8,$QI8000Itext,$QI8000I_1,$QI8000I_2,$QI8000I_3,$QI8000I_4,$QI8000I_5,$QI8000I_6,$QI8000I_7,$QI8000I_8,$QI8000Jtext,$QI8000J_1,$QI8000J_2,$QI8000J_3,$QI8000J_4,$QI8000J_5,$QI8000J_6,$QI8000J_7,$QI8000J_8);
	
	}elseif($j==20){  /*=============== 20 ===============*/

	  if($A0050!="3"){
	  if($nurseform02j_Q30=="1;"){$J0100A ="0";}elseif($nurseform02j_Q30=="2;"){$J0100A ="1";}else{$J0100A ="";}
	  if($nurseform02j_Q31=="1;"){$J0100B ="0";}elseif($nurseform02j_Q31=="2;"){$J0100B ="1";}else{$J0100B ="";}
	  if($nurseform02j_Q23=="1;"){$J0100C ="0";}elseif($nurseform02j_Q23=="2;"){$J0100C ="1";}else{$J0100C ="";}
 	  $QJ0100A = $J0100A;
	  $QJ0100B = $J0100B;
	  $QJ0100C = $J0100C;
	  if($nurseform02j_Q4!="5;"){ /* OK 判斷跳題 如果病患昏迷, skip to J1100 */
	  if($nurseform02j_Q39=="1;"){$J0200 ="1";}elseif($nurseform02j_Q39=="2;"){$J0200 ="0";}else{$J0200 ="";}
	  $QJ0200 = $J0200;  /* OK 判斷跳題 J0800、J0300 */
	  if($QJ0200=="1"){
	  if($nurseform02j_Q34=="1;"){$J0300="0";}elseif($nurseform02j_Q34=="2;"){$J0300="1";}elseif($nurseform02j_Q34=="3;"){$J0300="9";}else{$J0300="";}
	  $QJ0300 = $J0300;  /* OK 判斷跳題 J1100、J0400、J0800 */
	  if($J0300=="1"){
	  if($nurseform02j_Q35=="1;"){$J0400 ="1";}elseif($nurseform02j_Q35=="2;"){$J0400 ="2";}elseif($nurseform02j_Q35=="3;"){$J0400 ="3";}elseif($nurseform02j_Q35=="4;"){$J0400 ="4";}elseif($nurseform02j_Q35=="5;"){$J0400 ="9";}else{$J0400 ="";}
	  $QJ0400 = $J0400;
	  if($nurseform02j_Q19=="1;"){$J0500A ="0";}elseif($nurseform02j_Q19=="2;"){$J0500A ="1";}elseif($nurseform02j_Q19=="3;"){$J0500A ="9";}else{$J0500A ="";}
	  $QJ0500A = $J0500A;
	  if($nurseform02j_Q32=="1;"){$J0500B ="0";}elseif($nurseform02j_Q32=="2;"){$J0500B ="1";}elseif($nurseform02j_Q32=="3;"){$J0500B ="9";}else{$J0500B ="";}
	  $QJ0500B = $J0500B;
	  if($nurseform02j_Q15=="1;"){$J0600A1=0;$J0600A2=0;}elseif($nurseform02j_Q15=="2;"){$J0600A1=0;$J0600A2=1;}elseif($nurseform02j_Q15=="3;"){$J0600A1=0;$J0600A2=2;}elseif($nurseform02j_Q15=="4;"){$J0600A1=0;$J0600A2=3;}elseif($nurseform02j_Q15=="5;"){$J0600A1=0;$J0600A2=4;}elseif($nurseform02j_Q15=="6;"){$J0600A1=0;$J0600A2=5;}elseif($nurseform02j_Q15=="7;"){$J0600A1=0;$J0600A2=6;}elseif($nurseform02j_Q15=="8;"){$J0600A1=0;$J0600A2=7;}elseif($nurseform02j_Q15=="9;"){$J0600A1=0;$J0600A2=8;}elseif($nurseform02j_Q15=="10;"){$J0600A1=0;$J0600A2=9;}elseif($nurseform02j_Q15=="11;"){$J0600A1=1;$J0600A2=0;}elseif($nurseform02j_Q15=="12;"){$J0600A1=9;$J0600A2=9;}else{$J0600A1="";$J0600A2="";}
	  $QJ0600A_1 = $J0600A1;  /* J0600A、J0600B擇一填寫 */
	  $QJ0600A_2 = $J0600A2;  /* J0600A、J0600B擇一填寫 */
	  if($J0600A1=="9" && $J0600A2=="9"){
	  if($nurseform02j_Q37=="1;"){$J0600B="1";}elseif($nurseform02j_Q37=="2;"){$J0600B="2";}elseif($nurseform02j_Q37=="3;"){$J0600B="3";}elseif($nurseform02j_Q37=="4;"){$J0600B="4";}elseif($nurseform02j_Q37=="5;"){$J0600B="9";}else{$J0600B="";}
	  $QJ0600B = $J0600B;  /* J0600A、J0600B擇一填寫 */
	  }
	  }
	  }
	  }
	  $page20Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02j_Qfiller);
	  $page20Qfiller = array_unique($page20Qfiller);
	  sort($page20Qfiller);
	  for($i=0;$i<count($page20Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page20Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page20QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page20QfillerFilter = explode(";",$page20QfillerFilter);
	  $page20QfillerFilter = array_unique($page20QfillerFilter);
	  $page20Qfiller = array_diff($page20QfillerFilter, array(null,'null','',' '));
	  sort($page20Qfiller);
	  for($i=0;$i<count($page20Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page20Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QJ0100A","QJ0100B","QJ0100C","QJ0200","QJ0300","QJ0400","QJ0500A","QJ0500B","QJ0600A_1","QJ0600A_2","QJ0600B");
	  $v = array($QJ0100A,$QJ0100B,$QJ0100C,$QJ0200,$QJ0300,$QJ0400,$QJ0500A,$QJ0500B,$QJ0600A_1,$QJ0600A_2,$QJ0600B);
	
	}elseif($j==21){  /*=============== 21 ===============*/
	
 	  if($A0050!="3"){
	  if($nurseform02j_Q4!="5;"){ /* OK 判斷跳題 如果病患昏迷, skip to J1100 */
	  if($QJ0200=="1"){
	  if($J0300=="1"){
	  if ($J0400=="1" || $J0400=="2" || $J0400=="3" || $J0400=="4"){$J0700="0";}elseif($J0400=="9"){$J0700="1";}else{$J0700="";}
	  $QJ0700 = $J0700;  /* OK 判斷跳題 J1100 (J0400 = 1 thru 4)、J0800 (J0400 = 9) */
 	  }
	  }
	  if($J0300!="0"){
	  if($J0700!="0"){/* OK 判斷跳題 J1100 */
	  $painIndicators = explode(";",$nurseform02j_Q12);
	  if (in_array("1",$painIndicators)) {$J0800A ="X";}else{$J0800A ="";}
	  if (in_array("2",$painIndicators)) {$J0800B ="X";}else{$J0800B ="";}
	  if (in_array("3",$painIndicators)) {$J0800C ="X";}else{$J0800C ="";}
	  if (in_array("4",$painIndicators)) {$J0800D ="X";}else{$J0800D ="";}
	  if (in_array("5",$painIndicators)) {$J0800Z ="X";}else{$J0800Z ="";}
	  $QJ0800A = $J0800A;
	  $QJ0800B = $J0800B;
	  $QJ0800C = $J0800C;
	  $QJ0800D = $J0800D;
	  $QJ0800Z = $J0800Z; /* OK 判斷跳題*/
	  if($J0800Z!="X"){
	  if ($nurseform02j_Q33=="1;"){$J0850="1";}elseif($nurseform02j_Q33=="2;"){$J0850="2";}elseif($nurseform02j_Q33=="3;"){$J0850="3";}else{$J0850="";}
	  $QJ0850 = $J0850;
	  }
	  }
	  }
	  }
	  $J1100 = explode(";",$nurseform02b_Q68);
	  if (in_array("1",$J1100)) {$J1100A ="X";}else{$J1100A ="";}
	  if (in_array("2",$J1100)) {$J1100B ="X";}else{$J1100B ="";}
	  if (in_array("3",$J1100)) {$J1100C ="X";}else{$J1100C ="";}
	  if ($J1100A=="" && $J1100B=="" && $J1100C=="") {$J1100Z ="X";}else{$J1100Z ="";}
	  $QJ1100A = $J1100A;
	  $QJ1100B = $J1100B;
	  $QJ1100C = $J1100C;
	  $QJ1100Z = $J1100Z;	  
	  if ($nurseform02b_Q69=="1;") {$J1300="0";}elseif($nurseform02b_Q69=="2;"){$J1300="1";}else{$J1300="";}	  
	  if ($nurseform02b_Q70=="1;") {$J1400="0";}elseif($nurseform02b_Q70=="2;"){$J1400="1";}else{$J1400="";}
	  $QJ1300 = $J1300;
	  $QJ1400 = $J1400;
	  $J1550 = explode(";",$nurseform02b_Q47);
	  if (in_array("8",$J1550)) {$J1550A ="X";}else{$J1550A ="";}
	  if (in_array("2",$J1550)) {$J1550B ="X";}else{$J1550B ="";}
	  if (in_array("9",$J1550)) {$J1550C ="X";}else{$J1550C ="";}
	  if (in_array("3",$J1550)) {$J1550D ="X";}else{$J1550D ="";}
	  if ($J1550A=="" && $J1550B=="" && $J1550C=="" && $J1550D==""){$J1550Z ="X";}else{$J1550Z ="";}
	  $QJ1550A = $J1550A;
	  $QJ1550B = $J1550B;
	  $QJ1550C = $J1550C;
	  $QJ1550D = $J1550D;
	  $QJ1550Z = $J1550Z;
	  if($nurseform02j_Q4!="5;" && $J0300!="0" && $J0700!="0"){
		  $page21Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller,$nurseform02j_Qfiller);
		  $page21Qfiller = array_unique($page21Qfiller);
		  sort($page21Qfiller);
	  for($i=0;$i<count($page21Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page21Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page21QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page21QfillerFilter = explode(";",$page21QfillerFilter);
	  $page21QfillerFilter = array_unique($page21QfillerFilter);
	  $page21Qfiller = array_diff($page21QfillerFilter, array(null,'null','',' '));
	  sort($page21Qfiller);
	      for($i=0;$i<count($page21Qfiller);$i++){
		      ${"database_page".$j."Qfiller"} .= $page21Qfiller[$i].'&';
		      $database_Qfiller = ${"database_page".$j."Qfiller"};
	      }
	  }else{
		  $page21Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller);
		  $page21Qfiller = array_unique($page21Qfiller);
		  sort($page21Qfiller);
	  for($i=0;$i<count($page21Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page21Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page21QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page21QfillerFilter = explode(";",$page21QfillerFilter);
	  $page21QfillerFilter = array_unique($page21QfillerFilter);
	  $page21Qfiller = array_diff($page21QfillerFilter, array(null,'null','',' '));
	  sort($page21Qfiller);
	      for($i=0;$i<count($page21Qfiller);$i++){
		      ${"database_page".$j."Qfiller"} .= $page21Qfiller[$i].'&';
		      $database_Qfiller = ${"database_page".$j."Qfiller"};
	      }
	  }
	  }
	  $k = array("QJ0700","QJ0800A","QJ0800B","QJ0800C","QJ0800D","QJ0800Z","QJ0850","QJ1100A","QJ1100B","QJ1100C","QJ1100Z","QJ1300","QJ1400","QJ1550A","QJ1550B","QJ1550C","QJ1550D","QJ1550Z");
	  $v = array($QJ0700,$QJ0800A,$QJ0800B,$QJ0800C,$QJ0800D,$QJ0800Z,$QJ0850,$QJ1100A,$QJ1100B,$QJ1100C,$QJ1100Z,$QJ1300,$QJ1400,$QJ1550A,$QJ1550B,$QJ1550C,$QJ1550D,$QJ1550Z);
	
	}elseif($j==22){  /*=============== 22 ===============*/
      
      if($A0050!="3"){
	  /*========= 跌倒判斷式 START =========*/
	  $db1 = new DB;
	  $db1->query("SELECT * FROM `sixtarget_part3` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC");
		$lastOneMonthFallSum =0;
		$last6MonthFallSum =0;
		$FallSum =0;
		$J1900A =0;
		$J1900B =0;
		$J1900C =0;
		$J1700C =0;
		$sixtarget_part3_Qfiller="";
		for ($i=0;$i<$db1->num_rows();$i++) {
	  	  $r1 = $db1->fetch_assoc();
	  	  foreach ($r1 as $k=>$v) {
	  		  if (substr($k,0,1)=="Q") {
	  			  $arrAnswer = explode("_",$k);
	  			  if (count($arrAnswer)==2) {
	  				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
	  			  } else {
	  				  ${$k} = $v;
	  			  }
	  		  }  else { ${$k} = $v; }
	  	  }
		  $date = str_replace('/','',$date);
		  $datepart = str_split(date(Ymd),2);
		  /*一個月內跌倒次數*/
		  $lastOneMonth = $datepart[2]-1;
		  if($lastOneMonth==0){$lastOneMonthYear = $datepart[1]-1; $lastOneMonth =12;}else{$lastOneMonthYear = $datepart[1];}
		  if(count($lastOneMonth)==1){$lastOneMonth = "0".$lastOneMonth;}
		  $lastOneMonthDate = $datepart[0].$lastOneMonthYear.$lastOneMonth.$datepart[3];
		  if($date>=$lastOneMonthDate){
			  $lastOneMonthFallSum++;
		  }
		  /*二~六個月內跌倒次數*/
	      $last6Month = $datepart[2]-6;
		  if($last6Month<=0){$last6MonthYear = $datepart[1]-1; $last6Month =12+$last6Month;}else{$last6MonthYear = $datepart[1];}
          if(count($last6Month)==1){$last6Month = "0".$last6Month;}
		  $last6MonthDate = $datepart[0].$last6MonthYear.$last6Month.$datepart[3];
		  if( $lastOneMonthDate>$date && $date>=$last6MonthDate){
			  $last6MonthFallSum++;
		  }
		  if($date>=$last6MonthDate){
			 $sixtarget_part3_Qfiller .= $Qfiller.";";
		  /*六個月內骨折次數*/
		    if($Fracture_2=="1"){
			  $J1700C++;
		    }
		  }
		  /*跌倒總次數*/
		  $FallSum++;
		  /*受傷程度*/
		  if($injurlv_1=="1"){
			  $J1900A++;
		  }elseif($injurlv_2=="1" || $injurlv_3=="1"){
			  $J1900B++;
		  }elseif($injurlv_4=="1"){
			  $J1900C++;
		  }else{}		  
	 	}
		$Qfiller ="";
		if($lastOneMonthFallSum==0){$J1700A=0;}else{$J1700A=1;}
		if($last6MonthFallSum==0){$J1700B=0;}else{$J1700B=1;}
		if($FallSum==0){$J1800=0;}else{$J1800=1;}
		if($J1900A>=2){$J1900A=2;}
		if($J1900B>=2){$J1900B=2;}
		if($J1900C>=2){$J1900C=2;}
		if($J1700C>0){$J1700C=1;}
      /*========= 跌倒判斷式 END =========*/
	  	  
	  if($A0310A=="01" || $A0310E=="1"){ /* OK J1700 Complete only if A0310A = 01 or A0310E = 1 */	  
 	  $QJ1700A = $J1700A;
	  $QJ1700B = $J1700B;
	  $QJ1700C = $J1700C;
	  }
	  $QJ1800 = $J1800;  /* OK 判斷跳題 K0100、J1900 */
	  if($J1800!="0"){
	  $QJ1900A = $J1900A;
	  $QJ1900B = $J1900B;
	  $QJ1900C = $J1900C;
	  }
	  $sixtarget_part3_Qfiller = explode(";",$sixtarget_part3_Qfiller);
	  if (count($sixtarget_part3_Qfiller)==1) {
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0]);
	  }elseif(count($sixtarget_part3_Qfiller)==2){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1]);
	  }elseif(count($sixtarget_part3_Qfiller)==3){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2]);
	  }elseif(count($sixtarget_part3_Qfiller)==4){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3]);
	  }elseif(count($sixtarget_part3_Qfiller)==5){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3],$sixtarget_part3_Qfiller[4]);
	  }elseif(count($sixtarget_part3_Qfiller)==6){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3],$sixtarget_part3_Qfiller[4],$sixtarget_part3_Qfiller[5]);
	  }elseif(count($sixtarget_part3_Qfiller)==7){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3],$sixtarget_part3_Qfiller[4],$sixtarget_part3_Qfiller[5],$sixtarget_part3_Qfiller[6]);
	  }elseif(count($sixtarget_part3_Qfiller)==8){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3],$sixtarget_part3_Qfiller[4],$sixtarget_part3_Qfiller[5],$sixtarget_part3_Qfiller[6],$sixtarget_part3_Qfiller[7]);
	  }elseif(count($sixtarget_part3_Qfiller)==9){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3],$sixtarget_part3_Qfiller[4],$sixtarget_part3_Qfiller[5],$sixtarget_part3_Qfiller[6],$sixtarget_part3_Qfiller[7],$sixtarget_part3_Qfiller[8]);
	  }elseif(count($sixtarget_part3_Qfiller)==10){
		  $page22Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part3_Qfiller[0],$sixtarget_part3_Qfiller[1],$sixtarget_part3_Qfiller[2],$sixtarget_part3_Qfiller[3],$sixtarget_part3_Qfiller[4],$sixtarget_part3_Qfiller[5],$sixtarget_part3_Qfiller[6],$sixtarget_part3_Qfiller[7],$sixtarget_part3_Qfiller[8],$sixtarget_part3_Qfiller[9]);
	  }else{
		  $page22Qfiller = array($_SESSION['ncareID_lwj']);
	  }
	  $page22Qfiller = array_unique($page22Qfiller);
	  sort($page22Qfiller);
	  for($i=0;$i<count($page22Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page22Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page22QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page22QfillerFilter = explode(";",$page22QfillerFilter);
	  $page22QfillerFilter = array_unique($page22QfillerFilter);
	  $page22Qfiller = array_diff($page22QfillerFilter, array(null,'null','',' '));
	  sort($page22Qfiller);
	  for($i=0;$i<count($page22Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page22Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QJ1700A","QJ1700B","QJ1700C","QJ1800","QJ1900A","QJ1900B","QJ1900C");
	  $v = array($QJ1700A,$QJ1700B,$QJ1700C,$QJ1800,$QJ1900A,$QJ1900B,$QJ1900C);
	
	}elseif($j==23){  /*=============== 23 ===============*/
      
	  if($A0050!="3"){
	  if ($nurseform02b_Q71=="2;"){$K0100A="X";}else{$K0100A="";}
	  if ($nurseform02b_Q72=="2;"){$K0100B="X";}else{$K0100B="";}
	  if ($nurseform02b_Q73=="2;"){$K0100C="X";}else{$K0100C="";}
	  if ($nurseform02b_Q74=="2;"){$K0100D="X";}else{$K0100D="";}
	  if ($K0100A=="" && $K0100B=="" && $K0100C=="" && $K0100D==""){$K0100Z ="X";}else{$K0100Z ="";}
	  $QK0100A = $K0100A;
	  $QK0100B = $K0100B;
	  $QK0100C = $K0100C;
	  $QK0100D = $K0100D;
	  $QK0100Z = $K0100Z;
	  /*=== 身高 START ===*/
	  if($patient_height!="" && $patient_height!=NULL){
	      $inch = str_split($patient_height);
	  }else{
		  $inch[0] ="";
		  $inch[1] ="";
	  }
	  /*=== 身高 END ===*/
	  $QK0200A_1 = $inch[0];
	  $QK0200A_2 = $inch[1];
	  /*=== 一個月前日期 START ===*/
	  $NowDatePart = str_split(date(Ymd),2);
	  $lastMonth = $NowDatePart[2]-1;
	  $lastMonthYear = $NowDatePart[1];
	  if($lastMonth==0){
		  $lastMonth = 12;
		  $lastMonthYear = $lastMonthYear-1;
	  }
	  $lastMonthPart = str_split($lastMonth);
	  if(count($lastMonthPart)==1){
		  $lastMonth = "0".$lastMonth;
	  }
	  $lastMonthDate = $NowDatePart[0].$lastMonthYear.$lastMonth.$NowDatePart[3];
	  /*=== 一個月前日期 END ===*/
	  /*=== 六個月前日期 START ===*/
	  $lastSixMonth = $NowDatePart[2]-6;
	  $lastSixMonthYear = $NowDatePart[1];
	  if($lastSixMonth<=0){
		  $lastSixMonth = 12+$lastSixMonth;
		  $lastSixMonthYear = $lastSixMonthYear-1;
	  }
	  $lastSixMonthPart = str_split($lastSixMonth);
	  if(count($lastSixMonthPart)==1){
		  $lastSixMonth = "0".$lastSixMonth;
	  }
	  $lastSixMonthDate = $NowDatePart[0].$lastSixMonthYear.$lastSixMonth.$NowDatePart[3];
      /*=== 六個月前日期 END ===*/
	  /*=== 體重 START ===*/
	  $db3 = new DB;
	  // 原V $db3->query("SELECT `Value`,`Qfiller` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` >= '".$lastMonthDate."' ORDER BY `RecordedTime` DESC LIMIT 0,1");
	  // 新V START
	  $db3->query("SELECT `loinc_18833_4` AS `Value`,`Qfiller` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
	  if ($db3->num_rows()>0) {
		  $r3 = $db3->fetch_assoc();
		  $weight = $r3['Value'];
		  $weight = str_split($weight);
		  if(count($weight)==2){
			  $turnweight = $weight;
			  $weight[0] =0;
			  $weight[1] = $turnweight[0];
			  $weight[2] = $turnweight[1];
		  }
		  $NowWeight = $weight[0].$weight[1].$weight[2];
		  $vitalsigns_Qfiller1 = $r3['Qfiller'];
	  }else{
		  $weight = array("","","");
		  $NowWeight ="NoValue";
	  }
	  /*=== 體重 END ===*/
	  if($NowWeight!="NoValue"){
	  /*=== 一個月前體重 START ===*/
	  $db4 = new DB;
	  // 原V $db4->query("SELECT `Value`,`Qfiller` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` >= '".$lastMonthDate."' ORDER BY `RecordedTime` ASC LIMIT 0,1");
	  // 新V START
	  $db4->query("SELECT `loinc_18833_4` AS `Value`,`Qfiller` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' AND `date` < '".$lastMonthDate."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
		  $r4 = $db4->fetch_assoc();
		  $lastMonthWeight = $r4['Value'];
		  $vitalsigns_Qfiller2 = $r4['Qfiller'];
		  $lastMonthWeight = str_split($lastMonthWeight);
		  if(count($lastMonthWeight)==2){
			  $turnlastMonthWeight = $lastMonthWeight;
			  $lastMonthWeight[0] =0;
			  $lastMonthWeight[1] = $turnlastMonthWeight[0];
			  $lastMonthWeight[2] = $turnlastMonthWeight[1];
		  }
		  $lastMonthWeight = $lastMonthWeight[0].$lastMonthWeight[1].$lastMonthWeight[2];
		  $lastMonthWeightchange = @round(((($NowWeight)-$lastMonthWeight)/$lastMonthWeight)*100,2).' %';
	  /*=== 一個月前體重 END ===*/
	  /*=== 六個月前體重 START ===*/
	  $db3 = new DB;
	  // 原V $db3->query("SELECT `Value`,`Qfiller` FROM `vitalsigns` WHERE `PersonID`='".mysql_escape_string($_GET['pid'])."' AND `LoincCode`='18833-4' AND `IsValid`='1' AND `RecordedTime` >= '".$lastSixMonthDate."' ORDER BY `RecordedTime` ASC LIMIT 0,1");
	  // 新V START
	  $db3->query("SELECT `loinc_18833_4` AS `Value`,`Qfiller` FROM `vitalsign` WHERE `PatientID`='".mysql_escape_string($_GET['pid'])."' AND `loinc_18833_4`!='' AND `date` < '".$lastSixMonthDate."' ORDER BY `date` DESC, `time` DESC LIMIT 0,1");
	  // 新V END
		  $r3 = $db3->fetch_assoc();
		  $vitalsigns_Qfiller3 = $r3['Qfiller'];
		  $lastSixMonthWeight = $r3['Value'];
		  $lastSixMonthWeight = str_split($lastSixMonthWeight);
		  if(count($lastSixMonthWeight)==2){
			  $turnlastSixMonthWeight = $lastSixMonthWeight;
			  $lastSixMonthWeight[0] =0;
			  $lastSixMonthWeight[1] = $turnlastSixMonthWeight[0];
			  $lastSixMonthWeight[2] = $turnlastSixMonthWeight[1];
		  }
		  $lastSixMonthWeight = $lastSixMonthWeight[0].$lastSixMonthWeight[1].$lastSixMonthWeight[2];
		  $lastSixMonthWeightchange = @round(((($NowWeight)-$lastSixMonthWeight)/$lastSixMonthWeight)*100,2).' %';
	  /*=== 六個月前體重 END ===*/
	  /*=== Weight change% START ===*/
	    if($lastMonthWeightchange<=(-5) || $lastSixMonthWeightchange<=(-10)){
		    if($nurseform02b_Q79=="2;"){
			    $K0300 = "1";
		    }else{
			    $K0300 = "2";
		    }
	    }else{
		    $K0300 = "0";
	    }
	    if($lastMonthWeightchange>=5 || $lastSixMonthWeightchange>=10){
		    if($nurseform02b_Q79=="3;"){
			    $K0310 = "1";
		    }else{
			    $K0310 = "2";
		    }
	    }else{
		    $K0310 = "0";
	    }	  
	  }else{
		  $K0300 ="";
		  $K0310 ="";
	  }
	  /*=== Weight change% END ===*/
	  $QK0200B_1 = $weight[0];
	  $QK0200B_2 = $weight[1];
	  $QK0200B_3 = $weight[2];
	  $QK0300 = $K0300;
	  $QK0310 = $K0310;
	  
	  /*========= 入住是否滿7天 START =========*/
	  $now = str_split(date(Ymd),2);
	  $indate = str_split($inpatientinfo_indate,2);
	  if(($now[1]-$indate[1])==0){/*=== 同年 ===*/
		  if(($now[2]-$indate[2])==0){/*=== 同月 ===*/
			  if(($now[3]-$indate[3])<7){
				  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
				  if(in_array("4",$nurseform02bQ22)){$K0510A1="X";}else{$K0510A1="";}
				  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B1="X";}else{$K0510B1="";}
				  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
				  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C1="X";}else{$K0510C1="";}
				  $socialform33Q34 = explode(";",$socialform33_Q34);
				  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D1="X";}else{$K0510D1="";}
				  if($K0510A1=="" && $K0510B1=="" && $K0510C1=="" && $K0510D1==""){$K0510Z1="X";}else{$K0510Z1="";}
				  $K0510A2="";
				  $K0510B2="";
				  $K0510C2="";
				  $K0510D2="";
				  $K0510Z2="";
			  }else{
				  $K0510A1="";
				  $K0510B1="";
				  $K0510C1="";
				  $K0510D1="";
				  $K0510Z1="";
				  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
				  if(in_array("4",$nurseform02bQ22)){$K0510A2="X";}else{$K0510A2="";}
				  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B2="X";}else{$K0510B2="";}
				  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
				  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C2="X";}else{$K0510C2="";}
				  $socialform33Q34 = explode(";",$socialform33_Q34);
				  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D2="X";}else{$K0510D2="";}
				  if($K0510A2=="" && $K0510B2=="" && $K0510C2=="" && $K0510D2==""){$K0510Z2="X";}else{$K0510Z2="";}
			  }
		  }elseif(($now[2]-$indate[2])==1){/*=== 差一個月 ===*/
			  if($indate[2]=="11"){
				  $duringdate = $indate[3]+30+1;
	  		}elseif($indate[2]=="10"){
				  $duringdate = $indate[3]+31+1;
			  }elseif($indate[2]=="09"){
				  $duringdate = $indate[3]+30+1;
			  }elseif($indate[2]=="08"){
				  $duringdate = $indate[3]+31+1;
			  }elseif($indate[2]=="07"){
				  $duringdate = $indate[3]+31+1;
			  }elseif($indate[2]=="06"){
				  $duringdate = $indate[3]+30+1;
			  }elseif($indate[2]=="05"){
				  $duringdate = $indate[3]+31+1;
			  }elseif($indate[2]=="04"){
				  $duringdate = $indate[3]+30+1;
			  }elseif($indate[2]=="03"){
				  $duringdate = $indate[3]+31+1;
			  }elseif($indate[2]=="02"){
				  $duringdate = $indate[3]+28+1;
			  }else{
				  $duringdate = $indate[3]+31+1;
			  }
	  		
	  		if(($duringdate-$indate[3])<7){
				  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
				  if(in_array("4",$nurseform02bQ22)){$K0510A1="X";}else{$K0510A1="";}
				  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B1="X";}else{$K0510B1="";}
				  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
				  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C1="X";}else{$K0510C1="";}
				  $socialform33Q34 = explode(";",$socialform33_Q34);
				  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D1="X";}else{$K0510D1="";}
				  if($K0510A1=="" && $K0510B1=="" && $K0510C1=="" && $K0510D1==""){$K0510Z1="X";}else{$K0510Z1="";}
				  $K0510A2="";
				  $K0510B2="";
				  $K0510C2="";
				  $K0510D2="";
				  $K0510Z2="";
			  }else{
				  $K0510A1="";
				  $K0510B1="";
				  $K0510C1="";
				  $K0510D1="";
				  $K0510Z1="";
				  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
				  if(in_array("4",$nurseform02bQ22)){$K0510A2="X";}else{$K0510A2="";}
	  			  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B2="X";}else{$K0510B2="";}
				  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
				  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C2="X";}else{$K0510C2="";}
				  $socialform33Q34 = explode(";",$socialform33_Q34);
				  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D2="X";}else{$K0510D2="";}
				  if($K0510A2=="" && $K0510B2=="" && $K0510C2=="" && $K0510D2==""){$K0510Z2="X";}else{$K0510Z2="";}
			  }
		  }else{/*=== 差兩個月以上 ===*/
			  $K0510A1="";
			  $K0510B1="";
			  $K0510C1="";
			  $K0510D1="";
			  $K0510Z1="";
			  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
	  		  if(in_array("4",$nurseform02bQ22)){$K0510A2="X";}else{$K0510A2="";}
	  		  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B2="X";}else{$K0510B2="";}
	  		  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
	  		  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C2="X";}else{$K0510C2="";}
	  		  $socialform33Q34 = explode(";",$socialform33_Q34);
	  		  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D2="X";}else{$K0510D2="";}
	  		  if($K0510A2=="" && $K0510B2=="" && $K0510C2=="" && $K0510D2==""){$K0510Z2="X";}else{$K0510Z2="";}
		  }
	  }elseif(($now[1]-$indate[1])==1){/*=== 差一年 ===*/
		  if(($now[2]+12-$indate[2])==1){/*=== 差一個月 ===*/
			  $duringdate = $indate[3]+31+1;
			  if(($duringdate-$indate[3])<7){
				  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
				  if(in_array("4",$nurseform02bQ22)){$K0510A1="X";}else{$K0510A1="";}
				  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B1="X";}else{$K0510B1="";}
				  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
				  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C1="X";}else{$K0510C1="";}
				  $socialform33Q34 = explode(";",$socialform33_Q34);
				  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D1="X";}else{$K0510D1="";}
				  if($K0510A1=="" && $K0510B1=="" && $K0510C1=="" && $K0510D1==""){$K0510Z1="X";}else{$K0510Z1="";}
				  $K0510A2="";
				  $K0510B2="";
				  $K0510C2="";
				  $K0510D2="";
				  $K0510Z2="";
			  }else{
				  $K0510A1="";
				  $K0510B1="";
				  $K0510C1="";
				  $K0510D1="";
				  $K0510Z1="";
				  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
				  if(in_array("4",$nurseform02bQ22)){$K0510A2="X";}else{$K0510A2="";}
				  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B2="X";}else{$K0510B2="";}
				  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
				  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C2="X";}else{$K0510C2="";}
				  $socialform33Q34 = explode(";",$socialform33_Q34);
				  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D2="X";}else{$K0510D2="";}
				  if($K0510A2=="" && $K0510B2=="" && $K0510C2=="" && $K0510D2==""){$K0510Z2="X";}else{$K0510Z2="";}
	  		}
		  }else{/*=== 差兩個月以上 ===*/
			  $K0510A1="";
			  $K0510B1="";
			  $K0510C1="";
			  $K0510D1="";
			  $K0510Z1="";
			  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
			  if(in_array("4",$nurseform02bQ22)){$K0510A2="X";}else{$K0510A2="";}
			  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B2="X";}else{$K0510B2="";}
			  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
			  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C2="X";}else{$K0510C2="";}
			  $socialform33Q34 = explode(";",$socialform33_Q34);
			  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D2="X";}else{$K0510D2="";}
			  if($K0510A2=="" && $K0510B2=="" && $K0510C2=="" && $K0510D2==""){$K0510Z2="X";}else{$K0510Z2="";}
		  }
	  }else{/*=== 差兩年以上 ===*/
		  $K0510A1="";
		  $K0510B1="";
		  $K0510C1="";
		  $K0510D1="";
	  	  $K0510Z1="";
		  $nurseform02bQ22 = explode(";",$nurseform02b_Q22);
	  	  if(in_array("4",$nurseform02bQ22)){$K0510A2="X";}else{$K0510A2="";}
		  if(in_array("2",$nurseform02bQ22) || in_array("3",$nurseform02bQ22)){$K0510B2="X";}else{$K0510B2="";}
		  $nurseform02bQ24 = explode(";",$nurseform02b_Q24);
	  	  if(in_array("5",$nurseform02bQ24) || in_array("6",$nurseform02bQ24) || in_array("7",$nurseform02bQ24) || in_array("8",$nurseform02bQ24)){$K0510C2="X";}else{$K0510C2="";}
		  $socialform33Q34 = explode(";",$socialform33_Q34);
		  if(in_array("1",$socialform33Q34) || in_array("2",$socialform33Q34) || in_array("3",$socialform33Q34)){$K0510D2="X";}else{$K0510D2="";}
		  if($K0510A2=="" && $K0510B2=="" && $K0510C2=="" && $K0510D2==""){$K0510Z2="X";}else{$K0510Z2="";}
	  }
	  /*========= 入住是否滿7天 END =========*/
	  $QK0510A1 = $K0510A1;
	  $QK0510A2 = $K0510A2;
	  $QK0510B1 = $K0510B1;
	  $QK0510B2 = $K0510B2;
	  $QK0510C1 = $K0510C1;
	  $QK0510C2 = $K0510C2;
	  $QK0510D1 = $K0510D1;
	  $QK0510D2 = $K0510D2;
	  $QK0510Z1 = $K0510Z1;
	  $QK0510Z2 = $K0510Z2;
	  $page23Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller,$socialform33_Qfiller,$vitalsigns_Qfiller1,$vitalsigns_Qfiller2,$vitalsigns_Qfiller3);
	  $page23Qfiller = array_unique($page23Qfiller);
	  sort($page23Qfiller);
	  for($i=0;$i<count($page23Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page23Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page23QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page23QfillerFilter = explode(";",$page23QfillerFilter);
	  $page23QfillerFilter = array_unique($page23QfillerFilter);
	  $page23Qfiller = array_diff($page23QfillerFilter, array(null,'null','',' '));
	  sort($page23Qfiller);
	  for($i=0;$i<count($page23Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page23Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QK0100A","QK0100B","QK0100C","QK0100D","QK0100Z","QK0200A_1","QK0200A_2","QK0200B_1","QK0200B_2","QK0200B_3","QK0300","QK0310","QK0510A1","QK0510A2","QK0510B1","QK0510B2","QK0510C1","QK0510C2","QK0510D1","QK0510D2","QK0510Z1","QK0510Z2");
	  $v = array($QK0100A,$QK0100B,$QK0100C,$QK0100D,$QK0100Z,$QK0200A_1,$QK0200A_2,$QK0200B_1,$QK0200B_2,$QK0200B_3,$QK0300,$QK0310,$QK0510A1,$QK0510A2,$QK0510B1,$QK0510B2,$QK0510C1,$QK0510C2,$QK0510D1,$QK0510D2,$QK0510Z1,$QK0510Z2);
	
	}elseif($j==24){  /*=============== 24 ===============*/
	  if($A0050!="3"){
	  if($K0510A1=="X" || $K0510A2=="X" || $K0510B1=="X" || $K0510B2=="X"){ /* OK K0710 Complete K0710 only if Column 1 and/or Column 2 are checked for K0510A and/or K0510B */
	  if($socialform32_Q21=="1;"){$K0710A1="1";}elseif($socialform32_Q21=="2;"){$K0710A1="2";}elseif($socialform32_Q21=="3;"){$K0710A1="3";}else{$K0710A1="";}
	  if($socialform32_Q22=="1;"){$K0710A2="1";}elseif($socialform32_Q22=="2;"){$K0710A2="2";}elseif($socialform32_Q22=="3;"){$K0710A2="3";}else{$K0710A2="";}
	  if($socialform32_Q23=="1;"){$K0710A3="1";}elseif($socialform32_Q23=="2;"){$K0710A3="2";}elseif($socialform32_Q23=="3;"){$K0710A3="3";}else{$K0710A3="";}
	  if($socialform32_Q24=="1;"){$K0710B1="1";}elseif($socialform32_Q24=="2;"){$K0710B1="2";}else{$K0710B1="";}
	  if($socialform32_Q25=="1;"){$K0710B2="1";}elseif($socialform32_Q25=="2;"){$K0710B2="2";}else{$K0710B2="";}
	  if($socialform32_Q26=="1;"){$K0710B3="1";}elseif($socialform32_Q26=="2;"){$K0710B3="2";}else{$K0710B3="";}
	  $QK0710A1 = $K0710A1;
	  $QK0710A2 = $K0710A2;
	  $QK0710A3 = $K0710A3;
	  $QK0710B1 = $K0710B1;
	  $QK0710B2 = $K0710B2;
	  $QK0710B3 = $K0710B3;
	  }
	  $L0200A = explode(";",$nurseform02b_Q76);
	  $L0200B = explode(";",$nurseform02b_Q75);
	  $L0200C = explode(";",$nurseform02b_Q27);
	  $L0200D = explode(";",$nurseform02b_Q75);
	  $L0200E = explode(";",$nurseform02b_Q28);
	  $L0200F = explode(";",$nurseform02b_Q26);
/*A*/ if (in_array("2",$L0200A) || in_array("3",$L0200A) || in_array("4",$L0200A) || in_array("5",$L0200A)){$QL0200A="X";}else{$QL0200A="";}	  
/*B*/ if (in_array("5",$L0200B) || in_array("6",$L0200B) || in_array("7",$L0200B)){$QL0200B="X";}else{$QL0200B="";}	  
/*C*/ if (in_array("5",$L0200C) || in_array("6",$L0200C) || in_array("7",$L0200C)){$QL0200C="X";}else{$QL0200C="";}	  
/*D*/ if (in_array("3",$L0200D) || in_array("4",$L0200D)){$QL0200D="X";}else{$QL0200D="";}	  
/*E*/ if (in_array("2",$L0200E) || in_array("3",$L0200E) || in_array("4",$L0200E) || in_array("5",$L0200E) || in_array("2",$L0200B)){$QL0200E="X";}else{$QL0200E="";}	  
/*F*/ if (in_array("2",$L0200F) || in_array("3",$L0200F) || in_array("4",$L0200F)){$QL0200F="X";}else{$QL0200F="";}
/*G*/ if (in_array("5",$L0200F) && in_array("8",$L0200C) && in_array("6",$L0200E) && in_array("8",$L0200B) && in_array("6",$L0200A)){$QL0200G ="X";}else{$QL0200G ="";}
/*Z*/ if ($QL0200A=="" && $QL0200B=="" && $QL0200C=="" && $QL0200D=="" && $QL0200E=="" && $QL0200F=="" && $QL0200G==""){$QL0200Z ="X";}else{$QL0200Z ="";}
	  $page24Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02b_Qfiller);
	  $page24Qfiller = array_unique($page24Qfiller);
	  sort($page24Qfiller);
	  for($i=0;$i<count($page24Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page24Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page24QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page24QfillerFilter = explode(";",$page24QfillerFilter);
	  $page24QfillerFilter = array_unique($page24QfillerFilter);
	  $page24Qfiller = array_diff($page24QfillerFilter, array(null,'null','',' '));
	  sort($page24Qfiller);
	  for($i=0;$i<count($page24Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page24Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QK0710A1","QK0710A2","QK0710A3","QK0710B1","QK0710B2","QK0710B3","QL0200A","QL0200B","QL0200C","QL0200D","QL0200E","QL0200F","QL0200G","QL0200Z");
	  $v = array($QK0710A1,$QK0710A2,$QK0710A3,$QK0710B1,$QK0710B2,$QK0710B3,$QL0200A,$QL0200B,$QL0200C,$QL0200D,$QL0200E,$QL0200F,$QL0200G,$QL0200Z);
	
	}elseif($j==25){  /*=============== 25 ===============*/
	  
	  if($A0050!="3"){
	  if($nurseform02g_2_date!="" || $nurseform02g_2_date!=NULL){$M0100A="X";}else{$M0100A="";}
      if($nurseform02g_3_date!="" || $nurseform02g_3_date!=NULL){$M0100B="X";}else{$M0100B="";}
	  if($nurseform02g_1_date!="" || $nurseform02g_1_date!=NULL){$M0100C="X";}else{$M0100C="";}
 	  if($M0100A=="" && $M0100B=="" && $M0100C==""){$M0100Z="X";}else{$M0100Z="";}
	  $QM0100A = $M0100A;
	  $QM0100B = $M0100B;
	  $QM0100C = $M0100C;
	  $QM0100Z = $M0100Z;
	  $Qtotal = (int)$nurseform02g_3_Qtotal;
	  if($Qtotal>=16){$QM0150="0";}elseif($Qtotal<16){$QM0150="1";}else{$QM0150="";}
	  
	  /*========= 壓瘡判斷式 START =========*/
	  $db1 = new DB;
	  $db1->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date` IN (SELECT MAX(`date`) FROM `nurseform02g_2` GROUP BY `no`) AND `ReportID` IN (SELECT MAX(`ReportID`) FROM `nurseform02g_2` GROUP BY `no`) ORDER BY `no` ASC");
	    $M0210 =0;
		$M0300A =0;
		$M0300B1 =0;
		$M0300C1 =0;
		$M0300D1 =0;
		$M0300E1 =0;
		$M0300F1 =0;
		$M0300G1 =0;
		$M0300B2 =0;
		$M0300C2 =0;
		$M0300D2 =0;
		$M0300E2 =0;
		$M0300F2 =0;
		$M0300G2 =0;
		$M0610A =0;
		$M0610B =0;
		$M0610C =0;
		$OlderStageTwoDate =0;
		$Area =0;
		$M0800A =0;
		$M0800B =0;
		$M0800C =0;
		$M0900A =0;
		$M0900B =0;
		$M0900C =0;
		$M0900D =0;
		$nurseform02g_2_Qfiller="";
		for ($i=0;$i<$db1->num_rows();$i++) {
	  	  $r1 = $db1->fetch_assoc();
	  	  foreach ($r1 as $k=>$v) {
	  		  if (substr($k,0,1)=="Q") {
	  			  $arrAnswer = explode("_",$k);
	  			  if (count($arrAnswer)==2) {
	  				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
	  			  } else {
	  				  ${$k} = $v;
	  			  }
	  		  }  else { ${$k} = $v; }
	  	  }
		  $nurseform02g_2_Qfiller .= $Qfiller.";";
		  /*未癒合總數*/
		  if ($Q3=="2;"){$M0210++;}
		  /*各階段未癒合數量*/
		  if ($Q3=="2;" && $Q4=="1;"){$M0300A++;}
		  if ($Q3=="2;" && $Q4=="2;"){$M0300B1++;}
		  if ($Q3=="2;" && $Q4=="3;"){$M0300C1++;}
		  if ($Q3=="2;" && $Q4=="4;"){$M0300D1++;}
		  if ($Q3=="2;" && $Q4=="5;"){$M0300E1++;}
		  if ($Q3=="2;" && $Q4=="6;"){$M0300F1++;}
		  if ($Q3=="2;" && $Q4=="7;"){$M0300G1++;}
		  /*最早的第2階段產生日期*/
		  if ($Q3=="2;" && $Q4=="2;"){
			  $Q7 = str_replace('/','',$Q7);
			  if($Q7>$OlderStageTwoDate){
				  $OlderStageTwoDate = $Q7;
			  }
		  }
		  /*入院時紀錄且未癒合數量 CheckInRecord  0:入院時紀錄  1:入院後記錄  */
		  if ($Q3=="2;" && $Q4=="2;" && $CheckInRecord=="0"){$M0300B2++;}
		  if ($Q3=="2;" && $Q4=="3;" && $CheckInRecord=="0"){$M0300C2++;}
		  if ($Q3=="2;" && $Q4=="4;" && $CheckInRecord=="0"){$M0300D2++;}
		  if ($Q3=="2;" && $Q4=="5;" && $CheckInRecord=="0"){$M0300E2++;}
		  if ($Q3=="2;" && $Q4=="6;" && $CheckInRecord=="0"){$M0300F2++;}
		  if ($Q3=="2;" && $Q4=="7;" && $CheckInRecord=="0"){$M0300G2++;}
		  /*第3、4階段未癒合之傷口大小*/
		  if ($Q3=="2;"){
			  if($Q4=="3;" || $Q4=="4;"){
				  $NewArea = (int)$Q9*(int)$Q10;
				  if ($Area<$NewArea){
					  $Area = $NewArea;
					  $M0610A = $Q9;
					  $M0610B = $Q10;
					  $M0610C = $Q11;
				  }
			  }
		  }
		  /*=== 惡化的壓瘡數量 ===*/
		  /* !!!!!!!!!   如果是新產生的壓瘡也要列入計算?   !!!!!!!!!*/
		  /*-- Stage 2 --*/
		  if ($Q3=="2;" && $Q4=="2;"){ /* 比對上一次 MDS 的同一個壓瘡 */
			  $db5 = new DB;
			  $db5->query("SELECT `date` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
			  if($db5->num_rows()>0){ /* 取得上一次 MDS 評估日期 */
				 $r5 = $db5->fetch_assoc();
			     $db6 = new DB;
			     $db6->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `date`<='".formatdate_Ymd($r5['date'])."' ORDER BY `date` DESC LIMIT 0,1");
				 if($db6->num_rows()>0){/* 比對上一次 MDS 的壓瘡Stage */
					$r6 = $db6->fetch_assoc();
	  	            foreach ($r6 as $k=>$v) {
	  		           if (substr($k,0,1)=="Q") {
	  			           $arrAnswer = explode("_",$k);
	  			           if (count($arrAnswer)==2) {
	  				          if ($v==1) { ${"r6_".$arrAnswer[0]} = $arrAnswer[1]; }
	  			           } else {
	  				          ${"r6_".$k} = $v;
	  			           }
	  		           }  else { ${"r6_".$k} = $v; }
	  	            }
					$r1_Q4 = str_replace(';','',$Q4);
				    if($r6_Q4<$r1_Q4){
					   $M0800A++;
					}
				 }else{  /* 新產生壓瘡 */
					$M0800A++;
				 }
			  }else{ /* 第一次 MDS 評估 */
				 $db6 = new DB;
				 $db6->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `CheckInRecord`='0' ORDER BY `date` ASC LIMIT 0,1");
				 if($db6->num_rows()>0){
				    $r6 = $db6->fetch_assoc();
	  	            foreach ($r6 as $k=>$v) {
	  		           if (substr($k,0,1)=="Q") {
	  			           $arrAnswer = explode("_",$k);
	  			           if (count($arrAnswer)==2) {
	  				          if ($v==1) { ${"r6_".$arrAnswer[0]} = $arrAnswer[1]; }
	  			           } else {
	  				          ${"r6_".$k} = $v;
	  			           }
	  		           }  else { ${"r6_".$k} = $v; }
	  	            }
					$r1_Q4 = str_replace(';','',$Q4);
					if($r6_Q4<$r1_Q4){ /* 比對入院時紀錄的壓瘡Stage */
					   $M0800A++;
				    }
				 }else{  /* 新產生壓瘡 */
				    $M0800A++;
				 }
			  }
		  }
		  /*-- Stage 3 --*/
		  if ($Q3=="2;" && $Q4=="3;"){ /* 比對上一次 MDS 的同一個壓瘡 */
			  $db5 = new DB;
			  $db5->query("SELECT `date` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
			  if($db5->num_rows()>0){ /* 取得上一次 MDS 評估日期 */
				 $r5 = $db5->fetch_assoc();
			     $db6 = new DB;
			     $db6->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `date`<='".formatdate_Ymd($r5['date'])."' ORDER BY `date` DESC LIMIT 0,1");
				 if($db6->num_rows()>0){/* 比對上一次 MDS 的壓瘡Stage */
					$r6 = $db6->fetch_assoc();
	  	            foreach ($r6 as $k=>$v) {
	  		           if (substr($k,0,1)=="Q") {
	  			           $arrAnswer = explode("_",$k);
	  			           if (count($arrAnswer)==2) {
	  				          if ($v==1) { ${"r6_".$arrAnswer[0]} = $arrAnswer[1]; }
	  			           } else {
	  				          ${"r6_".$k} = $v;
	  			           }
	  		           }  else { ${"r6_".$k} = $v; }
	  	            }
					$r1_Q4 = str_replace(';','',$Q4);
				    if($r6_Q4<$r1_Q4){
					   $M0800B++;
					}
				 }else{  /* 新產生壓瘡 */
					$M0800B++;
				 }
			  }else{ /* 第一次 MDS 評估 */
				 $db6 = new DB;
				 $db6->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `CheckInRecord`='0' ORDER BY `date` ASC LIMIT 0,1");
				 if($db6->num_rows()>0){
				    $r6 = $db6->fetch_assoc();
	  	            foreach ($r6 as $k=>$v) {
	  		           if (substr($k,0,1)=="Q") {
	  			           $arrAnswer = explode("_",$k);
	  			           if (count($arrAnswer)==2) {
	  				          if ($v==1) { ${"r6_".$arrAnswer[0]} = $arrAnswer[1]; }
	  			           } else {
	  				          ${"r6_".$k} = $v;
	  			           }
	  		           }  else { ${"r6_".$k} = $v; }
	  	            }
					$r1_Q4 = str_replace(';','',$Q4);
					if($r6_Q4<$r1_Q4){ /* 比對入院時紀錄的壓瘡Stage */
					   $M0800B++;
				    }
				 }else{  /* 新產生壓瘡 */
				    $M0800B++;
				 }
			  }
		  }
		  /*-- Stage 4 --*/
		  if ($Q3=="2;" && $Q4=="4;"){ /* 比對上一次 MDS 的同一個壓瘡 */
			  $db5 = new DB;
			  $db5->query("SELECT `date` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
			  if($db5->num_rows()>0){ /* 取得上一次 MDS 評估日期 */
				 $r5 = $db5->fetch_assoc();
			     $db6 = new DB;
			     $db6->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `date`<='".formatdate_Ymd($r5['date'])."' ORDER BY `date` DESC LIMIT 0,1");
				 if($db6->num_rows()>0){/* 比對上一次 MDS 的壓瘡Stage */
					$r6 = $db6->fetch_assoc();
	  	            foreach ($r6 as $k=>$v) {
	  		           if (substr($k,0,1)=="Q") {
	  			           $arrAnswer = explode("_",$k);
	  			           if (count($arrAnswer)==2) {
	  				          if ($v==1) { ${"r6_".$arrAnswer[0]} = $arrAnswer[1]; }
	  			           } else {
	  				          ${"r6_".$k} = $v;
	  			           }
	  		           }  else { ${"r6_".$k} = $v; }
	  	            }
					$r1_Q4 = str_replace(';','',$Q4);
				    if($r6_Q4<$r1_Q4){
					   $M0800C++;
					}
				 }else{  /* 新產生壓瘡 */
					$M0800C++;
				 }
			  }else{ /* 第一次 MDS 評估 */
				 $db6 = new DB;
				 $db6->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `CheckInRecord`='0' ORDER BY `date` ASC LIMIT 0,1");
				 if($db6->num_rows()>0){
				    $r6 = $db6->fetch_assoc();
	  	            foreach ($r6 as $k=>$v) {
	  		           if (substr($k,0,1)=="Q") {
	  			           $arrAnswer = explode("_",$k);
	  			           if (count($arrAnswer)==2) {
	  				          if ($v==1) { ${"r6_".$arrAnswer[0]} = $arrAnswer[1]; }
	  			           } else {
	  				          ${"r6_".$k} = $v;
	  			           }
	  		           }  else { ${"r6_".$k} = $v; }
	  	            }
					$r1_Q4 = str_replace(';','',$Q4);
					if($r6_Q4<$r1_Q4){ /* 比對入院時紀錄的壓瘡Stage */
					   $M0800C++;
				    }
				 }else{  /* 新產生壓瘡 */
				    $M0800C++;
				 }
			  }
		  }
		  /*=== 惡化的壓瘡數量 END ===*/
		  /*=== 癒合的壓瘡數量 START ===*/
		  $db7 = new DB;
		  $db7->query("SELECT `QM0210` FROM `mdsform25` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
		  if($db7->num_rows()>0){
			 $r7 = $db7->fetch_assoc();
			 if($r7['QM0210']=="1"){
				$M0900A="1";
			    if($Q3=="1;"){
				   $db8 = new DB;
				   $db8->query("SELECT `date` FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
				   if($db8->num_rows()>0){
					  $r8 = $db8->fetch_assoc();
					  $db9 = new DB;
					  $db9->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `no`='".$no."' AND `date`>'".formatdate_Ymd($r8['date'])."' ORDER BY `date` DESC LIMIT 0,1");
					  if($db9->num_rows()>0){
						 $r9 = $db9->fetch_assoc();
						 if($r9['Q3_1']=="1" && $r9['Q4_2']=="1"){
							$M0900B++;
						 }elseif($r9['Q3_1']=="1" && $r9['Q4_3']=="1"){
							$M0900C++;
						 }elseif($r9['Q3_1']=="1" && $r9['Q4_4']=="1"){
							$M0900D++;
						 }else{}
					  }
				   }
			    }
			 }else{
				 $M0900B="";
				 $M0900C="";
				 $M0900D="";
			 }
		  }else{
			  $M0900B="";
			  $M0900C="";
			  $M0900D="";
		  }
		  /*=== 癒合的壓瘡數量 END ===*/
		  $Q3="";$Q4="";$Q7="";$Q9="";$Q10="";$Q11="";$r5="";$r6_Q4="";$r7="";$r8="";$r9="";
		}
		/* 是否有未癒合壓瘡 */
		if($M0210>0){$M0210="1";}
		/*最早的第2階段產生日期*/
		$OlderStageTwoDate = str_split($OlderStageTwoDate);
		/*長*/
		$M0610A = explode(".",$M0610A);
		if(count($M0610A[0])==1){
			$M0610A[0] = "0".$M0610A[0];
		}
		if(count($M0610A[1])==""){
			$M0610A[1] = 0;
		}
		$M0610A12 = str_split($M0610A[0]);
		$M0610A1 = $M0610A12[0];
		$M0610A2 = $M0610A12[1];
		$M0610A3 = str_split($M0610A[1]);
		$M0610A3 = $M0610A3[0];
		/*寬*/
		$M0610B = explode(".",$M0610B);
		if(count($M0610B[0])==1){
			$M0610B[0] = "0".$M0610B[0];
		}
		if(count($M0610B[1])==""){
			$M0610B[1] = 0;
		}
		$M0610B12 = str_split($M0610B[0]);
		$M0610B1 = $M0610B12[0];
		$M0610B2 = $M0610B12[1];
		$M0610B3 = str_split($M0610B[1]);
		$M0610B3 = $M0610B3[0];
		/*高*/
		$M0610C = explode(".",$M0610C);
		if(count($M0610C[0])==1){
			$M0610C[0] = "0".$M0610C[0];
		}
		if(count($M0610C[1])==""){
			$M0610C[1] = 0;
		}
		$M0610C12 = str_split($M0610C[0]);
		$M0610C1 = $M0610C12[0];
		$M0610C2 = $M0610C12[1];
		$M0610C3 = str_split($M0610C[1]);
		$M0610C3 = $M0610C3[0];
		
		$Q29array = explode(";",$Q29);
		if (in_array("1",$Q29array)){$M1200A_2g_2="X";}else{$M1200A_2g_2="";}
		if (in_array("2",$Q29array)){$M1200B_2g_2="X";}else{$M1200B_2g_2="";}
		if (in_array("3",$Q29array)){$M1200C_2g_2="X";}else{$M1200C_2g_2="";}
		if (in_array("4",$Q29array)){$M1200D_2g_2="X";}else{$M1200D_2g_2="";}
		if (in_array("5",$Q29array)){$M1200E_2g_2="X";}else{$M1200E_2g_2="";}
		if (in_array("6",$Q29array)){$M1200F_2g_2="X";}else{$M1200F_2g_2="";}
		if (in_array("7",$Q29array)){$M1200G_2g_2="X";}else{$M1200G_2g_2="";}
		if (in_array("8",$Q29array)){$M1200H_2g_2="X";}else{$M1200H_2g_2="";}
		if (in_array("9",$Q29array)){$M1200I_2g_2="X";}else{$M1200I_2g_2="";}
		if ($M1200A_2g_2=="" && $M1200B_2g_2=="" && $M1200C_2g_2=="" && $M1200D_2g_2=="" && $M1200E_2g_2=="" && $M1200F_2g_2=="" && $M1200G_2g_2=="" && $M1200H_2g_2=="" && $M1200I_2g_2==""){$M1200Z_2g_2=="X";}else{$M1200Z_2g_2=="";}
	  /*========= 壓瘡判斷式 END =========*/
	  $QM0210 = $M0210;  /* OK 判斷跳題 M0900、M0300 */
	  if($M0210!="0"){
	  $QM0300A = $M0300A;
	  $QM0300B1 = $M0300B1;  /* OK 判斷跳題 (If 0) M0300C */
	  if($M0300B1!="0"){
	  $QM0300B2 = $M0300B2;
	  $QM0300B3_1 = $OlderStageTwoDate[4];
	  $QM0300B3_2 = $OlderStageTwoDate[5];
	  $QM0300B3_3 = $OlderStageTwoDate[6];
	  $QM0300B3_4 = $OlderStageTwoDate[7];
	  $QM0300B3_5 = $OlderStageTwoDate[0];
	  $QM0300B3_6 = $OlderStageTwoDate[1];
	  $QM0300B3_7 = $OlderStageTwoDate[2];
	  $QM0300B3_8 = $OlderStageTwoDate[3];
	  }
	  $QM0300C1 = $M0300C1;  /* OK 判斷跳題 (If 0) M0300D */
	  if($M0300C1!="0"){
	  $QM0300C2 = $M0300C2;
	  }
	  $QM0300D1 = $M0300D1;  /* OK 判斷跳題 (If 0) M0300E */
	  if($M0300D1!="0"){
	  $QM0300D2 = $M0300D2;
	  }
	  }
	  $nurseform02g_2_Qfiller = explode(";",$nurseform02g_2_Qfiller);
	  if (count($nurseform02g_2_Qfiller)==1) {
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0]);
	  }elseif(count($nurseform02g_2_Qfiller)==2){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1]);
	  }elseif(count($nurseform02g_2_Qfiller)==3){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2]);
	  }elseif(count($nurseform02g_2_Qfiller)==4){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3]);
	  }elseif(count($nurseform02g_2_Qfiller)==5){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4]);
	  }elseif(count($nurseform02g_2_Qfiller)==6){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5]);
	  }elseif(count($nurseform02g_2_Qfiller)==7){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5],$nurseform02g_2_Qfiller[6]);
	  }elseif(count($nurseform02g_2_Qfiller)==8){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5],$nurseform02g_2_Qfiller[6],$nurseform02g_2_Qfiller[7]);
	  }elseif(count($nurseform02g_2_Qfiller)==9){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5],$nurseform02g_2_Qfiller[6],$nurseform02g_2_Qfiller[7],$nurseform02g_2_Qfiller[8]);
	  }elseif(count($nurseform02g_2_Qfiller)==10){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5],$nurseform02g_2_Qfiller[6],$nurseform02g_2_Qfiller[7],$nurseform02g_2_Qfiller[8],$nurseform02g_2_Qfiller[9]);
	  }elseif(count($nurseform02g_2_Qfiller)==11){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5],$nurseform02g_2_Qfiller[6],$nurseform02g_2_Qfiller[7],$nurseform02g_2_Qfiller[8],$nurseform02g_2_Qfiller[9],$nurseform02g_2_Qfiller[10]);
	  }elseif(count($nurseform02g_2_Qfiller)==12){
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller[0],$nurseform02g_2_Qfiller[1],$nurseform02g_2_Qfiller[2],$nurseform02g_2_Qfiller[3],$nurseform02g_2_Qfiller[4],$nurseform02g_2_Qfiller[5],$nurseform02g_2_Qfiller[6],$nurseform02g_2_Qfiller[7],$nurseform02g_2_Qfiller[8],$nurseform02g_2_Qfiller[9],$nurseform02g_2_Qfiller[10],$nurseform02g_2_Qfiller[11]);
	  }else{
		  $page25Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02g_1_Qfiller,$nurseform02g_3_Qfiller,$nurseform02g_2_Qfiller);
	  }
	  $page25Qfiller = array_unique($page25Qfiller);
	  sort($page25Qfiller);
	  for($i=0;$i<count($page25Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page25Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page25QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page25QfillerFilter = explode(";",$page25QfillerFilter);
	  $page25QfillerFilter = array_unique($page25QfillerFilter);
	  $page25Qfiller = array_diff($page25QfillerFilter, array(null,'null','',' '));
	  sort($page25Qfiller);
	  for($i=0;$i<count($page25Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page25Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QM0100A","QM0100B","QM0100C","QM0100Z","QM0150","QM0210","QM0300A","QM0300B1","QM0300B2","QM0300B3_1","QM0300B3_2","QM0300B3_3","QM0300B3_4","QM0300B3_5","QM0300B3_6","QM0300B3_7","QM0300B3_8","QM0300C1","QM0300C2","QM0300D1","QM0300D2");
	  $v = array($QM0100A,$QM0100B,$QM0100C,$QM0100Z,$QM0150,$QM0210,$QM0300A,$QM0300B1,$QM0300B2,$QM0300B3_1,$QM0300B3_2,$QM0300B3_3,$QM0300B3_4,$QM0300B3_5,$QM0300B3_6,$QM0300B3_7,$QM0300B3_8,$QM0300C1,$QM0300C2,$QM0300D1,$QM0300D2);
	
	}elseif($j==26){  /*=============== 26 ===============*/

 	  if($A0050!="3"){
	  if($M0210!="0"){
	  $QM0300E1 = $M0300E1;  /* OK 判斷跳題 (If 0) M0300F */
	  if($M0300E1!="0"){
	  $QM0300E2 = $M0300E2;
	  }
	  $QM0300F1 = $M0300F1;  /* OK 判斷跳題 (If 0) M0300G */
	  if($M0300F1!="0"){
	  $QM0300F2 = $M0300F2;
	  }
	  $QM0300G1 = $M0300G1;  /* OK 判斷跳題 (If 0) M0610 */
	  if($M0300G1!="0"){
	  $QM0300G2 = $M0300G2;
	  }
	  if($M0300C1>0 || $M0300D1>0 || $M0300F1>0){/* OK M0610 Complete only if M0300C1, M0300D1 or M0300F1 is greater than 0 */
	  $QM0610A_1 = $M0610A1;
	  $QM0610A_2 = $M0610A2;
	  $QM0610A_3 = $M0610A3;
	  $QM0610B_1 = $M0610B1;
	  $QM0610B_2 = $M0610B2;
	  $QM0610B_3 = $M0610B3;
	  $QM0610C_1 = $M0610C1;
	  $QM0610C_2 = $M0610C2;
	  $QM0610C_3 = $M0610C3;
	  }
	  $QM0700 = $M0700;
	  if($A0310E=="0"){ /* OK M0800 Complete only if A0310E = 0 */	  
	  $QM0800A = $M0800A;
	  $QM0800B = $M0800B;
	  $QM0800C = $M0800C;
	  }
	  $page26Qfiller = $page25Qfiller;
	  }
	  }
	  $k = array("QM0300E1","QM0300E2","QM0300F1","QM0300F2","QM0300G1","QM0300G2","QM0610A_1","QM0610A_2","QM0610A_3","QM0610B_1","QM0610B_2","QM0610B_3","QM0610C_1","QM0610C_2","QM0610C_3","QM0700","QM0800A","QM0800B","QM0800C");
	  $v = array($QM0300E1,$QM0300E2,$QM0300F1,$QM0300F2,$QM0300G1,$QM0300G2,$QM0610A_1,$QM0610A_2,$QM0610A_3,$QM0610B_1,$QM0610B_2,$QM0610B_3,$QM0610C_1,$QM0610C_2,$QM0610C_3,$QM0700,$QM0800A,$QM0800B,$QM0800C);
	
	}elseif($j==27){  /*=============== 27 ===============*/
      
	  if($A0050!="3"){
	  if($A0310E=="0"){ /* OK M0900 Complete only if A0310E = 0 */ 
 	  $QM0900A = $M0900A;  /* OK 判斷跳題 M1030、M0900B */
	  if($M0900A!="0"){
	  $QM0900B = $M0900B;
	  $QM0900C = $M0900C;
	  $QM0900D = $M0900D;
	  }
	  }
	  /*========= 傷口判斷式 START =========*/
	  $db1 = new DB;
	  $db1->query("SELECT * FROM `nurseform02n` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date` IN (SELECT MAX(`date`) FROM `nurseform02n` GROUP BY `no`) AND `nID` IN (SELECT MAX(`nID`) FROM `nurseform02n` GROUP BY `no`) ORDER BY `no` ASC");
	  $M1030=0;
	  $M1040B="";
	  $M1040E="";
	  $M1040F="";
	  $M1040G="";
	  $M1040H="";
	  $nurseform02n_Qfiller="";
	  $Qfiller="";
		for ($i=0;$i<$db1->num_rows();$i++) {
	  	  $r1 = $db1->fetch_assoc();
	  	  foreach ($r1 as $k=>$v) {
	  		  if (substr($k,0,1)=="Q") {
	  			  $arrAnswer = explode("_",$k);
	  			  if (count($arrAnswer)==2) {
	  				  if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; }
	  			  } else {
	  				  ${$k} = $v;
	  			  }
	  		  }  else { ${$k} = $v; }
	  	  }
		  $nurseform02n_Qfiller .= $Qfiller.';';
		  if ($Q14=="2;" && $Qtype=="3;"){
			  $Q10array = explode(";",$Q10);
			  if (in_array("19",$Q10array) || in_array("20",$Q10array)){
				  $M1030++;
			  }
		  }
          if ($Q14=="2;" && $Qtype=="4;"){$M1040B="X";}
		  if ($Q14=="2;" && $Qtype=="2;"){$M1040E="X";}
		  if ($Q14=="2;" && $Qtype=="7;"){
			  $Q10array = explode(";",$Q10);
			  if (in_array("16",$Q10array) || in_array("17",$Q10array)){
				  $M1040F="X";
			  }
		  }
		  if ($Q14=="2;" && $Qtype=="5;"){$M1040G="X";}
		  if ($Q14=="2;" && $Qtype=="6;"){$M1040H="X";}
		  $Q14="";$Qtype="";$Q10="";
	    }
		if ($M1040A=="" && $M1040B=="" && $M1040C=="" && $M1040D=="" && $M1040E=="" && $M1040F=="" && $M1040G=="" && $M1040H==""){$M1040Z=="X";}else{$M1040Z=="";}
		$Q16array = explode(";",$Q16);
		if (in_array("1",$Q16array)){$M1200A_2n="X";}else{$M1200A_2n="";}
		if (in_array("2",$Q16array)){$M1200B_2n="X";}else{$M1200B_2n="";}
		if (in_array("3",$Q16array)){$M1200C_2n="X";}else{$M1200C_2n="";}
		if (in_array("4",$Q16array)){$M1200D_2n="X";}else{$M1200D_2n="";}
		if (in_array("6",$Q16array)){$M1200F_2n="X";}else{$M1200F_2n="";}
		if (in_array("7",$Q16array)){$M1200G_2n="X";}else{$M1200G_2n="";}
		if (in_array("8",$Q16array)){$M1200H_2n="X";}else{$M1200H_2n="";}
		if (in_array("9",$Q16array)){$M1200I_2n="X";}else{$M1200I_2n="";}
		if ($M1200A_2n=="" && $M1200B_2n=="" && $M1200C_2n=="" && $M1200D_2n=="" && $M1200E_2n=="" && $M1200F_2n=="" && $M1200G_2n=="" && $M1200H_2n=="" && $M1200I_2n==""){$M1200Z_2n=="X";}else{$M1200Z_2n=="";}
	  /*========= 傷口判斷式 END =========*/
	  /*========= 壓瘡、傷口 護理處置判斷式 START =========*/
        if ($M1200A_2g_2=="X" || $M1200A_2n=="X"){$M1200A="X";}else{$M1200A="";}
		if ($M1200B_2g_2=="X" || $M1200B_2n=="X"){$M1200B="X";}else{$M1200B="";}
		if ($M1200C_2g_2=="X" || $M1200C_2n=="X"){$M1200C="X";}else{$M1200C="";}
		if ($M1200D_2g_2=="X" || $M1200D_2n=="X"){$M1200D="X";}else{$M1200D="";}
		if ($M1200E_2g_2=="X"){$M1200E="X";}else{$M1200E="";}
		if ($M1200F_2g_2=="X" || $M1200F_2n=="X"){$M1200F="X";}else{$M1200F="";}
		if ($M1200G_2g_2=="X" || $M1200G_2n=="X"){$M1200G="X";}else{$M1200G="";}
		if ($M1200H_2g_2=="X" || $M1200H_2n=="X"){$M1200H="X";}else{$M1200H="";}
		if ($M1200I_2g_2=="X" || $M1200I_2n=="X"){$M1200I="X";}else{$M1200I="";}
        if ($M1200Z_2g_2=="X" && $M1200Z_2n=="X"){$M1200Z="X";}else{$M1200Z="";}
	  /*========= 壓瘡、傷口 護理處置判斷式 END =========*/
	  $QM1030 = $M1030;
	  $QM1040A ='';
	  $QM1040B = $M1040B;
	  $QM1040C ='';
	  $QM1040D ='';
	  $QM1040E = $M1040E;
	  $QM1040F = $M1040F;
	  $QM1040G = $M1040G;
	  $QM1040H = $M1040H;
	  $QM1040Z = $M1040Z;
	  $QM1200A = $M1200A;/*護理*/
	  $QM1200B = $M1200B;
	  $QM1200C = $M1200C;
	  $QM1200D = $M1200D;
	  $QM1200E = $M1200E;
	  $QM1200F = $M1200F;
	  $QM1200G = $M1200G;
	  $QM1200H = $M1200H;
	  $QM1200I = $M1200I;
	  $QM1200Z = $M1200Z;
	  
	  $nurseform02n_Qfiller = explode(";",$nurseform02n_Qfiller);
	  if (count($nurseform02n_Qfiller)==1) {
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0]);
	  }elseif(count($nurseform02n_Qfiller)==2){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1]);
	  }elseif(count($nurseform02n_Qfiller)==3){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2]);
	  }elseif(count($nurseform02n_Qfiller)==4){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3]);
	  }elseif(count($nurseform02n_Qfiller)==5){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4]);
	  }elseif(count($nurseform02n_Qfiller)==6){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5]);
	  }elseif(count($nurseform02n_Qfiller)==7){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5],$nurseform02n_Qfiller[6]);
	  }elseif(count($nurseform02n_Qfiller)==8){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5],$nurseform02n_Qfiller[6],$nurseform02n_Qfiller[7]);
	  }elseif(count($nurseform02n_Qfiller)==9){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5],$nurseform02n_Qfiller[6],$nurseform02n_Qfiller[7],$nurseform02n_Qfiller[8]);
	  }elseif(count($nurseform02n_Qfiller)==10){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5],$nurseform02n_Qfiller[6],$nurseform02n_Qfiller[7],$nurseform02n_Qfiller[8],$nurseform02n_Qfiller[9]);
	  }elseif(count($nurseform02n_Qfiller)==11){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5],$nurseform02n_Qfiller[6],$nurseform02n_Qfiller[7],$nurseform02n_Qfiller[8],$nurseform02n_Qfiller[9],$nurseform02n_Qfiller[10]);
	  }elseif(count($nurseform02n_Qfiller)==12){
		  $page27Qfiller = array($_SESSION['ncareID_lwj'],$nurseform02n_Qfiller[0],$nurseform02n_Qfiller[1],$nurseform02n_Qfiller[2],$nurseform02n_Qfiller[3],$nurseform02n_Qfiller[4],$nurseform02n_Qfiller[5],$nurseform02n_Qfiller[6],$nurseform02n_Qfiller[7],$nurseform02n_Qfiller[8],$nurseform02n_Qfiller[9],$nurseform02n_Qfiller[10],$nurseform02n_Qfiller[11]);
	  }else{
		  $page27Qfiller = array($_SESSION['ncareID_lwj']);
	  }
	  $page27Qfiller = array_unique($page27Qfiller);
	  sort($page27Qfiller);
	  for($i=0;$i<count($page27Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page27Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page27QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page27QfillerFilter = explode(";",$page27QfillerFilter);
	  $page27QfillerFilter = array_unique($page27QfillerFilter);
	  $page27Qfiller = array_diff($page27QfillerFilter, array(null,'null','',' '));
	  sort($page27Qfiller);
	  for($i=0;$i<count($page27Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page27Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QM0900A","QM0900B","QM0900C","QM0900D","QM1030","QM1040A","QM1040B","QM1040C","QM1040D","QM1040E","QM1040F","QM1040G","QM1040H","QM1040Z","QM1200A","QM1200B","QM1200C","QM1200D","QM1200E","QM1200F","QM1200G","QM1200H","QM1200I","QM1200Z");
	  $v = array($QM0900A,$QM0900B,$QM0900C,$QM0900D,$QM1030,$QM1040A,$QM1040B,$QM1040C,$QM1040D,$QM1040E,$QM1040F,$QM1040G,$QM1040H,$QM1040Z,$QM1200A,$QM1200B,$QM1200C,$QM1200D,$QM1200E,$QM1200F,$QM1200G,$QM1200H,$QM1200I,$QM1200Z);
	
	}elseif($j==28){  /*=============== 28 ===============*/

 	  if($A0050!="3"){
      /*=== 藥物注射判斷 START ===*/
	  $db33 = new DB;
	  $db33->query("SELECT * FROM `nurseform17a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `QMedicationRecordType`='1' AND `QUseDate`>'".(date(Ymd)-7)."' ORDER BY `QUseDate` DESC");
	  $oldMedQwayDate=0;
	  $oldMedQwayDate1=0;
	  $oldMedQwayDate2=0;
	  $oldMedQwayDate3=0;
	  $oldMedQwayDate4=0;
	  $oldMedQwayDate5=0;
	  $oldMedQwayDate6=0;
	  $oldMedQwayDate7=0;
	  $N0410A=0;
	  $N0410B=0;
	  $N0410C=0;
	  $N0410D=0;
	  $N0410E=0;
	  $N0410F=0;
	  $N0410G=0;
	  $oldMedQwayDateArray = array();
	  $oldMedQwayDateArrayNumber=0;
	  for($i=0;$i<$db33->num_rows();$i++) {
	  	  $r33 = $db33->fetch_assoc();
	  	  foreach ($r33 as $k=>$v) {
			   ${'nurseform17a_'.$k} = $v;
		  }
		  $WayArray = array("IP","IS","BI","EIF","EPIDUR","IA","IA infusion","IC","ICI","ID","IF","IF for EPS","IF CVC","IJ","IL","IM","IO","IT","ITI","IV","IV DRIP","IV PUSH","IV via line","IVI","PC","PL","SC","SUBC","SUBT","cEIF","cIF","cIF CVC","cIT","cSCI");
		  if(in_array($nurseform17a_Qway1,$WayArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate){
				  $oldMedQwayDate=$nurseform17a_QUseDate;
				  $oldMedQwayDateArray[$oldMedQwayDateArrayNumber]=$nurseform17a_QUseDate;
				  $oldMedQwayDateArrayNumber++;
			  }
		  }
		  $effectOptionArray = explode(";",$nurseform17a_QeffectOption1);
		  if(in_array("1",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate1){
				  $oldMedQwayDate1=$nurseform17a_QUseDate;
				  $N0410A++;
			  }
		  }
		  if(in_array("2",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate2){
				  $oldMedQwayDate2=$nurseform17a_QUseDate;
				  $N0410B++;
			  }
		  }
		  if(in_array("3",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate3){
				  $oldMedQwayDate3=$nurseform17a_QUseDate;
				  $N0410C++;
			  }
		  }
		  if(in_array("4",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate4){
				  $oldMedQwayDate4=$nurseform17a_QUseDate;
				  $N0410D++;
			  }
		  }
		  if(in_array("5",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate5){
				  $oldMedQwayDate5=$nurseform17a_QUseDate;
				  $N0410E++;
			  }
		  }
		  if(in_array("6",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate6){
				  $oldMedQwayDate6=$nurseform17a_QUseDate;
				  $N0410F++;
			  }
		  }
		  if(in_array("7",$effectOptionArray)){
			  if($nurseform17a_QUseDate!=$oldMedQwayDate7){
				  $oldMedQwayDate7=$nurseform17a_QUseDate;
				  $N0410G++;
			  }
		  }
	  }
	  /*=== 藥物注射判斷 END ===*/
	  /*=== 胰島素注射判斷 START ===*/
	  $db32 = new DB;
	  $db32->query("SELECT `Qstartdate1` FROM `nurseform18_1` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `QInsulinRecordType`='1' AND `Qstartdate1`>'".(date(Ymd)-7)."' ORDER BY `Qstartdate1` ASC");
      $N0350A=0;
	  $oldInsulinDate=0;
	  $oldInsulinDateArray = array();
	  $oldInsulinDateArrayNumber=0;
	  for($i=0;$i<$db32->num_rows();$i++) {
	  	  $r32 = $db32->fetch_assoc();
	  	  foreach ($r32 as $k=>$v) {
			   ${'nurseform18_1_'.$k} = $v;
		  }
		  if($nurseform18_1_Qstartdate1!=$oldInsulinDate){
			  $N0350A++;
			  $oldInsulinDate=$nurseform18_1_Qstartdate1;
		      $oldInsulinDateArray[$oldInsulinDateArrayNumber]=$nurseform18_1_Qstartdate1;
			  $oldInsulinDateArrayNumber++;
		  }
	  }
	  /*=== 胰島素注射判斷 END ===*/
	  /*===所有注射判斷 START ===*/
	  $InjectionDateArray = array_merge($oldMedQwayDateArray, $oldInsulinDateArray);
	  $InjectionDateArray = array_unique($InjectionDateArray);
	  $InjectionDateArray = array_diff($InjectionDateArray, array(null,'null','',' '));
	  sort($InjectionDateArray);
	  $N0300=count($InjectionDateArray);
	  /*===所有注射判斷 END ===*/
	  /*=== 胰島素處方簽判斷 START ===*/
	  $db34 = new DB;
	  $db34->query("SELECT `date` FROM `nurseform18` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`>'".(date(Ymd)-7)."' ORDER BY `date` ASC");
	  $N0350B=($db34->num_rows());
	  /*=== 胰島素處方簽判斷 END ===*/
	  $QN0300 = $N0300;  /* OK 判斷跳題 (If 0) N0410 */
	  if($N0300!="0"){
	  $QN0350A = $N0350A;
	  $QN0350B = $N0350B;
	  }
	  $QN0410A = $N0410A;
	  $QN0410B = $N0410B;
	  $QN0410C = $N0410C;
	  $QN0410D = $N0410D;
	  $QN0410E = $N0410E;
	  $QN0410F = $N0410F;
	  $QN0410G = $N0410G;
	  $page28Qfiller = array($_SESSION['ncareID_lwj']);
	  $page28Qfiller = array_unique($page28Qfiller);
	  sort($page28Qfiller);
	  for($i=0;$i<count($page28Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page28Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page28QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page28QfillerFilter = explode(";",$page28QfillerFilter);
	  $page28QfillerFilter = array_unique($page28QfillerFilter);
	  $page28Qfiller = array_diff($page28QfillerFilter, array(null,'null','',' '));
	  sort($page28Qfiller);
	  for($i=0;$i<count($page28Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page28Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QN0300","QN0350A","QN0350B","QN0410A","QN0410B","QN0410C","QN0410D","QN0410E","QN0410F","QN0410G");
	  $v = array($QN0300,$QN0350A,$QN0350B,$QN0410A,$QN0410B,$QN0410C,$QN0410D,$QN0410E,$QN0410F,$QN0410G);
	
	}elseif($j==29){  /*=============== 29 ===============*/

 	  if($A0050!="3"){
	  $QO0100A1 ="";
	  $QO0100A2 ="";
	  $QO0100B1 ="";
	  $QO0100B2 ="";
	  $QO0100C1 ="";
	  $QO0100C2 ="";
	  $QO0100D1 ="";
	  $QO0100D2 ="";
	  $QO0100E1 ="";
	  $QO0100E2 ="";
	  $QO0100F1 ="";
	  $QO0100F2 ="";
	  $QO0100G1 ="";
	  $QO0100G2 ="";
	  $QO0100H1 ="";
	  $QO0100H2 ="";
	  $QO0100I1 ="";
	  $QO0100I2 ="";
	  $QO0100J1 ="";
	  $QO0100J2 ="";
	  $QO0100K1 ="";
	  $QO0100K2 ="";
	  $QO0100L ="";
	  $QO0100M1 ="";
	  $QO0100M2 ="";
	  $QO0100Z1 ="";
	  $QO0100Z2 ="";
	  $QO0250A ="";  /* OK 判斷跳題 O0250C、O0250B */
	  if($O0250A!="0"){
	  $QO0250B_1 ="";
	  $QO0250B_2 ="";
	  $QO0250B_3 ="";
	  $QO0250B_4 ="";
	  $QO0250B_5 ="";
	  $QO0250B_6 ="";
	  $QO0250B_7 ="";
	  $QO0250B_8 ="";
	  }
	  if($O0250A=="0"){
	  $QO0250C ="";
	  }
	  $QO0300A ="";  /* OK 判斷跳題 O0300B、O0400 */
	  if($O0300A=="0"){
	  $QO0300B ="";
	  }
	  $page29Qfiller = array($_SESSION['ncareID_lwj']);
	  $page29Qfiller = array_unique($page29Qfiller);
	  sort($page29Qfiller);
	  for($i=0;$i<count($page29Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page29Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page29QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page29QfillerFilter = explode(";",$page29QfillerFilter);
	  $page29QfillerFilter = array_unique($page29QfillerFilter);
	  $page29Qfiller = array_diff($page29QfillerFilter, array(null,'null','',' '));
	  sort($page29Qfiller);
	  for($i=0;$i<count($page29Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page29Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QO0100A1","QO0100A2","QO0100B1","QO0100B2","QO0100C1","QO0100C2","QO0100D1","QO0100D2","QO0100E1","QO0100E2","QO0100F1","QO0100F2","QO0100G1","QO0100G2","QO0100H1","QO0100H2","QO0100I1","QO0100I2","QO0100J1","QO0100J2","QO0100K1","QO0100K2","QO0100L","QO0100M1","QO0100M2","QO0100Z1","QO0100Z2","QO0250A","QO0250B_1","QO0250B_2","QO0250B_3","QO0250B_4","QO0250B_5","QO0250B_6","QO0250B_7","QO0250B_8","QO0250C","QO0300A","QO0300B");
	  $v = array($QO0100A1,$QO0100A2,$QO0100B1,$QO0100B2,$QO0100C1,$QO0100C2,$QO0100D1,$QO0100D2,$QO0100E1,$QO0100E2,$QO0100F1,$QO0100F2,$QO0100G1,$QO0100G2,$QO0100H1,$QO0100H2,$QO0100I1,$QO0100I2,$QO0100J1,$QO0100J2,$QO0100K1,$QO0100K2,$QO0100L,$QO0100M1,$QO0100M2,$QO0100Z1,$QO0100Z2,$QO0250A,$QO0250B_1,$QO0250B_2,$QO0250B_3,$QO0250B_4,$QO0250B_5,$QO0250B_6,$QO0250B_7,$QO0250B_8,$QO0250C,$QO0300A,$QO0300B);
	
	}elseif($j==30){  /*=============== 30 ===============*/

 	  if($A0050!="3"){
	  $QO0400A1_1 ="";
	  $QO0400A1_2 ="";
	  $QO0400A1_3 ="";
	  $QO0400A1_4 ="";
	  $QO0400A2_1 ="";
	  $QO0400A2_2 ="";
	  $QO0400A2_3 ="";
	  $QO0400A2_4 ="";
	  $QO0400A3_1 ="";
	  $QO0400A3_2 ="";
	  $QO0400A3_3 ="";
	  $QO0400A3_4 ="";  /* OK 判斷跳題(如果O0400A1~3總合為0) O0400A5 */
	  if($QO0400A1_1=="0" && $QO0400A1_2=="0" && $QO0400A1_3=="0" && $QO0400A1_4=="0" && $QO0400A2_1=="0" && $QO0400A2_2=="0" && $QO0400A2_3=="0" && $QO0400A2_4=="0" && $QO0400A3_1=="0" && $QO0400A3_2=="0" && $QO0400A3_3=="0" && $QO0400A3_4=="0"){}else{	  
	  $QO0400A3A_1 ="";
	  $QO0400A3A_2 ="";
	  $QO0400A3A_3 ="";
	  $QO0400A3A_4 ="";
	  $QO0400A4 ="";
	  }
	  $QO0400A5_1 ="";
	  $QO0400A5_2 ="";
	  $QO0400A5_3 ="";
	  $QO0400A5_4 ="";
	  $QO0400A5_5 ="";
	  $QO0400A5_6 ="";
	  $QO0400A5_7 ="";
	  $QO0400A5_8 ="";
	  $QO0400A6_1 ="";
	  $QO0400A6_2 ="";
	  $QO0400A6_3 ="";
	  $QO0400A6_4 ="";
	  $QO0400A6_5 ="";
	  $QO0400A6_6 ="";
	  $QO0400A6_7 ="";
	  $QO0400A6_8 ="";
	  $QO0400B1_1 ="";
	  $QO0400B1_2 ="";
	  $QO0400B1_3 ="";
	  $QO0400B1_4 ="";
	  $QO0400B2_1 ="";
	  $QO0400B2_2 ="";
	  $QO0400B2_3 ="";
	  $QO0400B2_4 ="";
	  $QO0400B3_1 ="";
	  $QO0400B3_2 ="";
	  $QO0400B3_3 ="";
	  $QO0400B3_4 ="";  /* OK 判斷跳題(如果O0400B1~3總合為0) O0400B5 */
	  if($QO0400B1_1=="0" && $QO0400B1_2=="0" && $QO0400B1_3=="0" && $QO0400B1_4=="0" && $QO0400B2_1=="0" && $QO0400B2_2=="0" && $QO0400B2_3=="0" && $QO0400B2_4=="0" && $QO0400B3_1=="0" && $QO0400B3_2=="0" && $QO0400B3_3=="0" && $QO0400B3_4=="0"){}else{
	  $QO0400B3A_1 ="";
	  $QO0400B3A_2 ="";
	  $QO0400B3A_3 ="";
	  $QO0400B3A_4 ="";
	  $QO0400B4 ="";
	  }
	  $QO0400B5_1 ="";
	  $QO0400B5_2 ="";
	  $QO0400B5_3 ="";
	  $QO0400B5_4 ="";
	  $QO0400B5_5 ="";
	  $QO0400B5_6 ="";
	  $QO0400B5_7 ="";
	  $QO0400B5_8 ="";
	  $QO0400B6_1 ="";
	  $QO0400B6_2 ="";
	  $QO0400B6_3 ="";
	  $QO0400B6_4 ="";
	  $QO0400B6_5 ="";
	  $QO0400B6_6 ="";
	  $QO0400B6_7 ="";
	  $QO0400B6_8 ="";
	  $page30Qfiller = array($_SESSION['ncareID_lwj']);
	  $page30Qfiller = array_unique($page30Qfiller);
	  sort($page30Qfiller);
	  for($i=0;$i<count($page30Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page30Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page30QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page30QfillerFilter = explode(";",$page30QfillerFilter);
	  $page30QfillerFilter = array_unique($page30QfillerFilter);
	  $page30Qfiller = array_diff($page30QfillerFilter, array(null,'null','',' '));
	  sort($page30Qfiller);
	  for($i=0;$i<count($page30Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page30Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QO0400A1_1","QO0400A1_2","QO0400A1_3","QO0400A1_4","QO0400A2_1","QO0400A2_2","QO0400A2_3","QO0400A2_4","QO0400A3_1","QO0400A3_2","QO0400A3_3","QO0400A3_4","QO0400A3A_1","QO0400A3A_2","QO0400A3A_3","QO0400A3A_4","QO0400A4","QO0400A5_1","QO0400A5_2","QO0400A5_3","QO0400A5_4","QO0400A5_5","QO0400A5_6","QO0400A5_7","QO0400A5_8","QO0400A6_1","QO0400A6_2","QO0400A6_3","QO0400A6_4","QO0400A6_5","QO0400A6_6","QO0400A6_7","QO0400A6_8","QO0400B1_1","QO0400B1_2","QO0400B1_3","QO0400B1_4","QO0400B2_1","QO0400B2_2","QO0400B2_3","QO0400B2_4","QO0400B3_1","QO0400B3_2","QO0400B3_3","QO0400B3_4","QO0400B3A_1","QO0400B3A_2","QO0400B3A_3","QO0400B3A_4","QO0400B4","QO0400B5_1","QO0400B5_2","QO0400B5_3","QO0400B5_4","QO0400B5_5","QO0400B5_6","QO0400B5_7","QO0400B5_8","QO0400B6_1","QO0400B6_2","QO0400B6_3","QO0400B6_4","QO0400B6_5","QO0400B6_6","QO0400B6_7","QO0400B6_8");
	  $v = array($QO0400A1_1,$QO0400A1_2,$QO0400A1_3,$QO0400A1_4,$QO0400A2_1,$QO0400A2_2,$QO0400A2_3,$QO0400A2_4,$QO0400A3_1,$QO0400A3_2,$QO0400A3_3,$QO0400A3_4,$QO0400A3A_1,$QO0400A3A_2,$QO0400A3A_3,$QO0400A3A_4,$QO0400A4,$QO0400A5_1,$QO0400A5_2,$QO0400A5_3,$QO0400A5_4,$QO0400A5_5,$QO0400A5_6,$QO0400A5_7,$QO0400A5_8,$QO0400A6_1,$QO0400A6_2,$QO0400A6_3,$QO0400A6_4,$QO0400A6_5,$QO0400A6_6,$QO0400A6_7,$QO0400A6_8,$QO0400B1_1,$QO0400B1_2,$QO0400B1_3,$QO0400B1_4,$QO0400B2_1,$QO0400B2_2,$QO0400B2_3,$QO0400B2_4,$QO0400B3_1,$QO0400B3_2,$QO0400B3_3,$QO0400B3_4,$QO0400B3A_1,$QO0400B3A_2,$QO0400B3A_3,$QO0400B3A_4,$QO0400B4,$QO0400B5_1,$QO0400B5_2,$QO0400B5_3,$QO0400B5_4,$QO0400B5_5,$QO0400B5_6,$QO0400B5_7,$QO0400B5_8,$QO0400B6_1,$QO0400B6_2,$QO0400B6_3,$QO0400B6_4,$QO0400B6_5,$QO0400B6_6,$QO0400B6_7,$QO0400B6_8);
	
	}elseif($j==31){  /*=============== 31 ===============*/	  

 	  if($A0050!="3"){
	  $QO0400C1_1 ="";
	  $QO0400C1_2 ="";
	  $QO0400C1_3 ="";
	  $QO0400C1_4 ="";
	  $QO0400C2_1 ="";
	  $QO0400C2_2 ="";
	  $QO0400C2_3 ="";
	  $QO0400C2_4 ="";
	  $QO0400C3_1 ="";
	  $QO0400C3_2 ="";
	  $QO0400C3_3 ="";
	  $QO0400C3_4 ="";  /* OK 判斷跳題(如果O0400C1~3總合為0) O0400C5 */
	  if($QO0400C1_1=="0" && $QO0400C1_2=="0" && $QO0400C1_3=="0" && $QO0400C1_4=="0" && $QO0400C2_1=="0" && $QO0400C2_2=="0" && $QO0400C2_3=="0" && $QO0400C2_4=="0" && $QO0400C3_1=="0" && $QO0400C3_2=="0" && $QO0400C3_3=="0" && $QO0400C3_4=="0"){}else{
	  $QO0400C3A_1 ="";
	  $QO0400C3A_2 ="";
	  $QO0400C3A_3 ="";
	  $QO0400C3A_4 ="";
	  $QO0400C4 ="";
	  }
	  $QO0400C5_1 ="";
	  $QO0400C5_2 ="";
	  $QO0400C5_3 ="";
	  $QO0400C5_4 ="";
	  $QO0400C5_5 ="";
	  $QO0400C5_6 ="";
	  $QO0400C5_7 ="";
	  $QO0400C5_8 ="";
	  $QO0400C6_1 ="";
	  $QO0400C6_2 ="";
	  $QO0400C6_3 ="";
	  $QO0400C6_4 ="";
	  $QO0400C6_5 ="";
	  $QO0400C6_6 ="";
	  $QO0400C6_7 ="";
	  $QO0400C6_8 ="";
	  $QO0400D1_1 ="";
	  $QO0400D1_2 ="";
	  $QO0400D1_3 ="";
	  $QO0400D1_4 ="";  /* OK 判斷跳題(if 0) O0400E */
	  if($QO0400D1_1=="0" && $QO0400D1_2=="0" && $QO0400D1_3=="0" && $QO0400D1_4=="0"){}else{
	  $QO0400D2 ="";
	  }
	  $QO0400E1_1 ="";
	  $QO0400E1_2 ="";
	  $QO0400E1_3 ="";
	  $QO0400E1_4 ="";  /* OK 判斷跳題(if 0) O0400F */
	  if($QO0400E1_1=="0" && $QO0400E1_2=="0" && $QO0400E1_3=="0" && $QO0400E1_4=="0"){}else{
	  $QO0400E2 ="";
	  }
	  $QO0400F1_1 ="";
	  $QO0400F1_2 ="";
	  $QO0400F1_3 ="";
	  $QO0400F1_4 ="";  /* OK 判斷跳題(if 0) O0420 */
	  if($QO0400F1_1=="0" && $QO0400F1_2=="0" && $QO0400F1_3=="0" && $QO0400F1_4=="0"){}else{
	  $QO0400F2 ="";
	  }
	  $QO0420 ="";
	  if($A0310C=="2" || $A0310C=="3"){ /* OK O0450 Complete only if A0310C = 2 or 3 and A0310F = 99 */
	  if($A0310F=="99"){
	  $QO0450A ="";  /* OK 判斷跳題 O0500 */
	  if($O0450A!="0"){
	  $QO0450B_1 ="";
	  $QO0450B_2 ="";
	  $QO0450B_3 ="";
	  $QO0450B_4 ="";
	  $QO0450B_5 ="";
	  $QO0450B_6 ="";
	  $QO0450B_7 ="";
	  $QO0450B_8 ="";
	  }
	  }
	  }
	  $page31Qfiller = array($_SESSION['ncareID_lwj']);
	  $page31Qfiller = array_unique($page31Qfiller);
	  sort($page31Qfiller);
	  for($i=0;$i<count($page31Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page31Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page31QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page31QfillerFilter = explode(";",$page31QfillerFilter);
	  $page31QfillerFilter = array_unique($page31QfillerFilter);
	  $page31Qfiller = array_diff($page31QfillerFilter, array(null,'null','',' '));
	  sort($page31Qfiller);
	  for($i=0;$i<count($page31Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page31Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QO0400C1_1","QO0400C1_2","QO0400C1_3","QO0400C1_4","QO0400C2_1","QO0400C2_2","QO0400C2_3","QO0400C2_4","QO0400C3_1","QO0400C3_2","QO0400C3_3","QO0400C3_4","QO0400C3A_1","QO0400C3A_2","QO0400C3A_3","QO0400C3A_4","QO0400C4","QO0400C5_1","QO0400C5_2","QO0400C5_3","QO0400C5_4","QO0400C5_5","QO0400C5_6","QO0400C5_7","QO0400C5_8","QO0400C6_1","QO0400C6_2","QO0400C6_3","QO0400C6_4","QO0400C6_5","QO0400C6_6","QO0400C6_7","QO0400C6_8","QO0400D1_1","QO0400D1_2","QO0400D1_3","QO0400D1_4","QO0400D2","QO0400E1_1","QO0400E1_2","QO0400E1_3","QO0400E1_4","QO0400E2","QO0400F1_1","QO0400F1_2","QO0400F1_3","QO0400F1_4","QO0400F2","QO0420","QO0450A","QO0450B_1","QO0450B_2","QO0450B_3","QO0450B_4","QO0450B_5","QO0450B_6","QO0450B_7","QO0450B_8");
	  $v = array($QO0400C1_1,$QO0400C1_2,$QO0400C1_3,$QO0400C1_4,$QO0400C2_1,$QO0400C2_2,$QO0400C2_3,$QO0400C2_4,$QO0400C3_1,$QO0400C3_2,$QO0400C3_3,$QO0400C3_4,$QO0400C3A_1,$QO0400C3A_2,$QO0400C3A_3,$QO0400C3A_4,$QO0400C4,$QO0400C5_1,$QO0400C5_2,$QO0400C5_3,$QO0400C5_4,$QO0400C5_5,$QO0400C5_6,$QO0400C5_7,$QO0400C5_8,$QO0400C6_1,$QO0400C6_2,$QO0400C6_3,$QO0400C6_4,$QO0400C6_5,$QO0400C6_6,$QO0400C6_7,$QO0400C6_8,$QO0400D1_1,$QO0400D1_2,$QO0400D1_3,$QO0400D1_4,$QO0400D2,$QO0400E1_1,$QO0400E1_2,$QO0400E1_3,$QO0400E1_4,$QO0400E2,$QO0400F1_1,$QO0400F1_2,$QO0400F1_3,$QO0400F1_4,$QO0400F2,$QO0420,$QO0450A,$QO0450B_1,$QO0450B_2,$QO0450B_3,$QO0450B_4,$QO0450B_5,$QO0450B_6,$QO0450B_7,$QO0450B_8);
	
	}elseif($j==32){  /*=============== 32 ===============*/

 	  if($A0050!="3"){
	  $QO0500A ="";
	  $QO0500B ="";
	  $QO0500C ="";
	  $QO0500D ="";
	  $QO0500E ="";
	  $QO0500F ="";
	  $QO0500G ="";
	  $QO0500H ="";
	  $QO0500I ="";
	  $QO0500J ="";
	  $QO0600_1 ="";
	  $QO0600_2 ="";
	  $QO0700_1 ="";
	  $QO0700_2 ="";
	  $page32Qfiller = array($_SESSION['ncareID_lwj']);
	  $page32Qfiller = array_unique($page32Qfiller);
	  sort($page32Qfiller);
	  for($i=0;$i<count($page32Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page32Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page32QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page32QfillerFilter = explode(";",$page32QfillerFilter);
	  $page32QfillerFilter = array_unique($page32QfillerFilter);
	  $page32Qfiller = array_diff($page32QfillerFilter, array(null,'null','',' '));
	  sort($page32Qfiller);
	  for($i=0;$i<count($page32Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page32Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QO0500A","QO0500B","QO0500C","QO0500D","QO0500E","QO0500F","QO0500G","QO0500H","QO0500I","QO0500J","QO0600_1","QO0600_2","QO0700_1","QO0700_2");
	  $v = array($QO0500A,$QO0500B,$QO0500C,$QO0500D,$QO0500E,$QO0500F,$QO0500G,$QO0500H,$QO0500I,$QO0500J,$QO0600_1,$QO0600_2,$QO0700_1,$QO0700_2);
	
	}elseif($j==33){  /*=============== 33 ===============*/
    
 	  if($A0050!="3"){
	  /*=== Section P 判斷式 START ===*/
	  $P0100A0=0;
	  $P0100A1=0;
	  $P0100A2=0;
	  $P0100B0=0;
	  $P0100B1=0;
	  $P0100B2=0;
	  $P0100C0=0;
	  $P0100C1=0;
	  $P0100C2=0;
	  $P0100D0=0;
	  $P0100D1=0;
	  $P0100D2=0;
	  $P0100E0=0;
	  $P0100E1=0;
	  $P0100E2=0;
	  $P0100F0=0;
	  $P0100F1=0;
	  $P0100F2=0;
	  $P0100G0=0;
	  $P0100G1=0;
	  $P0100G2=0;
	  $P0100H0=0;
	  $P0100H1=0;
	  $P0100H2=0;
	  $sixtarget_part2_Qfiller="";
	  $Qfiller="";
	  $db18 = new DB;	  
      $db18->query("SELECT * FROM `sixtarget_part2` WHERE `HospNo`='".$HospNo."'");
		for ($i=0;$i<$db18->num_rows();$i++) {
	  	  $r18 = $db18->fetch_assoc();
	  	  foreach ($r18 as $k=>$v) {
	  		  if (substr($k,0,1)=="Q") {
	  			  $arrAnswer = explode("_",$k);
	  			  if (count($arrAnswer)==2) {
	  				  if ($v==1) { ${$arrAnswer[0]} = $arrAnswer[1]; }
	  			  } else {
	  				  ${$k} = $v;
	  			  }
	  		  }  else { ${$k} = $v; }
	  	  }
		  $sixtarget_part2_Qfiller .= $Qfiller.';';
	  if($releasedate!="" && $releasedate!=NULL){
	  $releasedate = str_replace(';','',$releasedate);
	  }
	  if($releasedate>date(Ymd) || $releasedate=="" || $releasedate==NULL){
	  if($UseInBed11=="1"){
		  $P0100A0++;
	  }elseif($UseInBed12=="1"){
		  $P0100A1++;
	  }elseif($UseInBed13=="1"){
		  $P0100A2++;
	  }else{}
	  if($UseInBed21=="1"){
		  $P0100B0++;
	  }elseif($UseInBed22=="1"){
		  $P0100B1++;
	  }elseif($UseInBed23=="1"){
		  $P0100B2++;
	  }else{}
	  if($UseInBed31=="1"){
		  $P0100C0++;
	  }elseif($UseInBed32=="1"){
		  $P0100C1++;
	  }elseif($UseInBed33=="1"){
		  $P0100C2++;
	  }else{}
	  if($UseInBed41=="1"){
		  $P0100D0++;
	  }elseif($UseInBed42=="1"){
		  $P0100D1++;
	  }elseif($UseInBed43=="1"){
		  $P0100D2++;
	  }else{}
	  if($UseInChair11=="1"){
		  $P0100E0++;
	  }elseif($UseInChair12=="1"){
		  $P0100E1++;
	  }elseif($UseInChair13=="1"){
		  $P0100E2++;
	  }else{}
	  if($UseInChair21=="1"){
		  $P0100F0++;
	  }elseif($UseInChair22=="1"){
		  $P0100F1++;
	  }elseif($UseInChair23=="1"){
		  $P0100F2++;
	  }else{}
	  if($UseInChair31=="1"){
		  $P0100G0++;
	  }elseif($UseInChair32=="1"){
		  $P0100G1++;
	  }elseif($UseInChair33=="1"){
		  $P0100G2++;
	  }else{}
	  if($UseInChair41=="1"){
		  $P0100H0++;
	  }elseif($UseInChair42=="1"){
		  $P0100H1++;
	  }elseif($UseInChair43=="1"){
		  $P0100H2++;
	  }else{}
	  }
	  }
	  if($P0100A2>0){$P0100A="2";}elseif($P0100A1>0){$P0100A="1";}else{$P0100A="0";}
	  if($P0100B2>0){$P0100B="2";}elseif($P0100B1>0){$P0100B="1";}else{$P0100B="0";}
	  if($P0100C2>0){$P0100C="2";}elseif($P0100C1>0){$P0100C="1";}else{$P0100C="0";}
	  if($P0100D2>0){$P0100D="2";}elseif($P0100D1>0){$P0100D="1";}else{$P0100D="0";}
	  if($P0100E2>0){$P0100E="2";}elseif($P0100E1>0){$P0100E="1";}else{$P0100E="0";}
	  if($P0100F2>0){$P0100F="2";}elseif($P0100F1>0){$P0100F="1";}else{$P0100F="0";}
	  if($P0100G2>0){$P0100G="2";}elseif($P0100G1>0){$P0100G="1";}else{$P0100G="0";}
	  if($P0100H2>0){$P0100H="2";}elseif($P0100H1>0){$P0100H="1";}else{$P0100H="0";}
	  /*=== Section P 判斷式 END ===*/
	  $QP0100A = $P0100A;
	  $QP0100B = $P0100B;
	  $QP0100C = $P0100C;
	  $QP0100D = $P0100D;
	  $QP0100E = $P0100E;
	  $QP0100F = $P0100F;
	  $QP0100G = $P0100G;
	  $QP0100H = $P0100H;
	  $QQ0100A = $Q0100A;
	  $QQ0100B = $Q0100B;
	  $QQ0100C = $Q0100C;
	  if($A0310E=="1"){ /* OK Q0300 Complete only if A0310E = 1 */	 
	  	if($nurseform02a_Q118=="1;"){$Q0300A="1";}elseif($nurseform02a_Q118=="2;"){$Q0300A="2";}elseif($nurseform02a_Q118=="3;"){$Q0300A="3";}elseif($nurseform02a_Q118=="4;"){$Q0300A="9";}else{$Q0300A="";}
	  	if($nurseform02a_Q119=="1;"){$Q0300B="1";}elseif($nurseform02a_Q119=="2;"){$Q0300B="2";}elseif($nurseform02a_Q119=="3;"){$Q0300B="3";}elseif($nurseform02a_Q119=="4;"){$Q0300B="9";}else{$Q0300B="";}
	  	$QQ0300A = $Q0300A;
	  	$QQ0300B = $Q0300B;
	  }
	  if($nurseform02a_Q120=="1;"){$Q0400A="0";}elseif($nurseform02a_Q120=="2;"){$Q0400A="1";}else{$Q0400A="";}
	  $QQ0400A = $Q0400A;  /* OK 判斷跳題 Q0600 */
	  $sixtarget_part2_Qfiller = explode(";",$sixtarget_part2_Qfiller);
	  if (count($sixtarget_part2_Qfiller)==1) {
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0]);
	  }elseif(count($sixtarget_part2_Qfiller)==2){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1]);
	  }elseif(count($sixtarget_part2_Qfiller)==3){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2]);
	  }elseif(count($sixtarget_part2_Qfiller)==4){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3]);
	  }elseif(count($sixtarget_part2_Qfiller)==5){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4]);
	  }elseif(count($sixtarget_part2_Qfiller)==6){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5]);
	  }elseif(count($sixtarget_part2_Qfiller)==7){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6]);
	  }elseif(count($sixtarget_part2_Qfiller)==8){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7]);
	  }elseif(count($sixtarget_part2_Qfiller)==9){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8]);
	  }elseif(count($sixtarget_part2_Qfiller)==10){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9]);
	  }elseif(count($sixtarget_part2_Qfiller)==11){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10]);
	  }elseif(count($sixtarget_part2_Qfiller)==12){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11]);
	  }elseif(count($sixtarget_part2_Qfiller)==13){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12]);
	  }elseif(count($sixtarget_part2_Qfiller)==14){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13]);
	  }elseif(count($sixtarget_part2_Qfiller)==15){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13],$sixtarget_part2_Qfiller[14]);
	  }elseif(count($sixtarget_part2_Qfiller)==16){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13],$sixtarget_part2_Qfiller[14],$sixtarget_part2_Qfiller[15]);
	  }elseif(count($sixtarget_part2_Qfiller)==17){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13],$sixtarget_part2_Qfiller[14],$sixtarget_part2_Qfiller[15],$sixtarget_part2_Qfiller[16]);
	  }elseif(count($sixtarget_part2_Qfiller)==18){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13],$sixtarget_part2_Qfiller[14],$sixtarget_part2_Qfiller[15],$sixtarget_part2_Qfiller[16],$sixtarget_part2_Qfiller[17]);
	  }elseif(count($sixtarget_part2_Qfiller)==19){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13],$sixtarget_part2_Qfiller[14],$sixtarget_part2_Qfiller[15],$sixtarget_part2_Qfiller[16],$sixtarget_part2_Qfiller[17],$sixtarget_part2_Qfiller[18]);
	  }elseif(count($sixtarget_part2_Qfiller)==20){
		  $page33Qfiller = array($_SESSION['ncareID_lwj'],$sixtarget_part2_Qfiller[0],$sixtarget_part2_Qfiller[1],$sixtarget_part2_Qfiller[2],$sixtarget_part2_Qfiller[3],$sixtarget_part2_Qfiller[4],$sixtarget_part2_Qfiller[5],$sixtarget_part2_Qfiller[6],$sixtarget_part2_Qfiller[7],$sixtarget_part2_Qfiller[8],$sixtarget_part2_Qfiller[9],$sixtarget_part2_Qfiller[10],$sixtarget_part2_Qfiller[11],$sixtarget_part2_Qfiller[12],$sixtarget_part2_Qfiller[13],$sixtarget_part2_Qfiller[14],$sixtarget_part2_Qfiller[15],$sixtarget_part2_Qfiller[16],$sixtarget_part2_Qfiller[17],$sixtarget_part2_Qfiller[18],$sixtarget_part2_Qfiller[19]);
	  }else{
		  $page33Qfiller = array($_SESSION['ncareID_lwj']);
	  }
	  $page33Qfiller = array_unique($page33Qfiller);
	  sort($page33Qfiller);
	  for($i=0;$i<count($page33Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page33Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page33QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page33QfillerFilter = explode(";",$page33QfillerFilter);
	  $page33QfillerFilter = array_unique($page33QfillerFilter);
	  $page33Qfiller = array_diff($page33QfillerFilter, array(null,'null','',' '));
	  sort($page33Qfiller);
	  for($i=0;$i<count($page33Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page33Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QP0100A","QP0100B","QP0100C","QP0100D","QP0100E","QP0100F","QP0100G","QP0100H","QQ0100A","QQ0100B","QQ0100C","QQ0300A","QQ0300B","QQ0400A");
	  $v = array($QP0100A,$QP0100B,$QP0100C,$QP0100D,$QP0100E,$QP0100F,$QP0100G,$QP0100H,$QQ0100A,$QQ0100B,$QQ0100C,$QQ0300A,$QQ0300B,$QQ0400A);
	
	}elseif($j==34){  /*=============== 34 ===============*/

 	  if($A0050!="3"){
	  if($Q0400A!="1"){
	  if($A0310A=="02" || $A0310A=="06" || $A0310A=="99"){ /* OK Complete only if A0310A = 02, 06, or 99 */
	  if($nurseform02b_Q80=="1;"){$Q0490="0";}elseif($nurseform02b_Q80=="2;"){$Q0490="1";}elseif($nurseform02b_Q80=="3;"){$Q0490="8";}else{$Q0490="";}
	  $QQ0490 = $Q0490; /* OK 判斷跳題 Q0600 */
	  }
	  if($Q0490!="1"){
	  	if($nurseform02b_Q81=="1;"){$Q0500B="0";}elseif($nurseform02b_Q81=="2;"){$Q0500B="1";}elseif($nurseform02b_Q81=="3;"){$Q0500B="9";}else{$Q0500B="";}
	  	if($nurseform02b_Q82=="1;"){$Q0550A="0";}elseif($nurseform02b_Q82=="2;"){$Q0550A="1";}elseif($nurseform02b_Q82=="3;"){$Q0550A="8";}else{$Q0550A="";}
	  	if($nurseform02b_Q83=="1;"){$Q0550B="1";}elseif($nurseform02b_Q83=="2;"){$Q0550B="2";}elseif($nurseform02b_Q83=="3;"){$Q0550B="3";}elseif($nurseform02b_Q83=="4;"){$Q0550B="8";}else{$Q0550B="";}
	  $QQ0500B = $Q0500B;
	  $QQ0550A = $Q0550A;
	  $QQ0550B = $Q0550B;
	  }
	  }
	  if($nurseform02b_Q84=="1;"){$Q0600="0";}elseif($nurseform02b_Q84=="2;"){$Q0600="1";}elseif($nurseform02b_Q84=="3;"){$Q0600="2";}else{$Q0600="";}
	  $QQ0600 = $Q0600;
	  $page34Qfiller = array($_SESSION['ncareID_lwj']);
	  $page34Qfiller = array_unique($page34Qfiller);
	  sort($page34Qfiller);
	  for($i=0;$i<count($page34Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page34Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page34QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page34QfillerFilter = explode(";",$page34QfillerFilter);
	  $page34QfillerFilter = array_unique($page34QfillerFilter);
	  $page34Qfiller = array_diff($page34QfillerFilter, array(null,'null','',' '));
	  sort($page34Qfiller);
	  for($i=0;$i<count($page34Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page34Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QQ0490","QQ0500B","QQ0550A","QQ0550B","QQ0600");
	  $v = array($QQ0490,$QQ0500B,$QQ0550A,$QQ0550B,$QQ0600);
	
	}elseif($j==35){  /*=============== 35 ===============*/
      
	  if($A0050!="3"){
	  if($A0310E=="0"){
 	  $db13 = new DB;
 	  $db13->query("SELECT `QA0310A`,`QA0310B` FROM `mdsform01` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
 	  if($db13->num_rows()>0){
		  $r13 = $db13->fetch_assoc();
		  $mdsform01_Qfiller = $r13['Qfiller'];
	  }
	  if($r13['QA0310A']=="01" || $r13['QA0310A']=="02" || $r13['QA0310A']=="03" || $r13['QA0310A']=="04" || $r13['QA0310A']=="05" || $r13['QA0310A']=="06" || $r13['QA0310B']=="01" || $r13['QA0310B']=="02" || $r13['QA0310B']=="03" || $r13['QA0310B']=="04" ||  $r13['QA0310B']=="05"){
	  /* OK V0100 Complete only if A0310E = 0 and if the following is true for the prior assessment: A0310A = 01- 06 or A0310B = 01- 06 */
 	  $db14 = new DB;
 	  $db14->query("SELECT `QA2300_1`,`QA2300_2`,`QA2300_3`,`QA2300_4`,`QA2300_5`,`QA2300_6`,`QA2300_7`,`QA2300_8` FROM `mdsform05` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
 	  if($db14->num_rows()>0){
		  $r14 = $db14->fetch_assoc();
	  }
 	  $db15 = new DB;
 	  $db15->query("SELECT `QC0500_1`,`QC0500_2` FROM `mdsform07` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
 	  if($db15->num_rows()>0){
		  $r15 = $db15->fetch_assoc();
	  }
 	  $db16 = new DB;
 	  $db16->query("SELECT `QD0300_1`,`QD0300_2` FROM `mdsform09` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
 	  if($db16->num_rows()>0){
		  $r16 = $db16->fetch_assoc();
	  }
 	  $db17 = new DB;
 	  $db17->query("SELECT `QD0600_1`,`QD0600_2` FROM `mdsform10` WHERE `HospNo`='".$HospNo."' AND `date`='".$r30['date']."' ORDER BY `date` DESC LIMIT 0,1");
 	  if($db17->num_rows()>0){
		  $r17 = $db17->fetch_assoc();
	  }
	  $QV0100A = $r13['QA0310A'];
	  $QV0100B = $r13['QA0310B'];
	  $QV0100C_1 = $r14['QA2300_1'];
	  $QV0100C_2 = $r14['QA2300_2'];
	  $QV0100C_3 = $r14['QA2300_3'];
	  $QV0100C_4 = $r14['QA2300_4'];
	  $QV0100C_5 = $r14['QA2300_5'];
	  $QV0100C_6 = $r14['QA2300_6'];
	  $QV0100C_7 = $r14['QA2300_7'];
	  $QV0100C_8 = $r14['QA2300_8'];
	  $QV0100D_1 = $r15['QC0500_1'];
	  $QV0100D_2 = $r15['QC0500_2'];
	  $QV0100E_1 = $r16['QD0300_1'];
	  $QV0100E_2 = $r16['QD0300_2'];
	  $QV0100F_1 = $r17['QD0600_1'];
	  $QV0100F_2 = $r17['QD0600_2'];
	  }
	  $page35Qfiller = array($_SESSION['ncareID_lwj'],$mdsform01_Qfiller);
	  $page35Qfiller = array_unique($page35Qfiller);
	  sort($page35Qfiller);
	  for($i=0;$i<count($page35Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page35Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page35QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page35QfillerFilter = explode(";",$page35QfillerFilter);
	  $page35QfillerFilter = array_unique($page35QfillerFilter);
	  $page35Qfiller = array_diff($page35QfillerFilter, array(null,'null','',' '));
	  sort($page35Qfiller);
	  for($i=0;$i<count($page35Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page35Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  }
	  $k = array("QV0100A","QV0100B","QV0100C_1","QV0100C_2","QV0100C_3","QV0100C_4","QV0100C_5","QV0100C_6","QV0100C_7","QV0100C_8","QV0100D_1","QV0100D_2","QV0100E_1","QV0100E_2","QV0100F_1","QV0100F_2");
	  $v = array($QV0100A,$QV0100B,$QV0100C_1,$QV0100C_2,$QV0100C_3,$QV0100C_4,$QV0100C_5,$QV0100C_6,$QV0100C_7,$QV0100C_8,$QV0100D_1,$QV0100D_2,$QV0100E_1,$QV0100E_2,$QV0100F_1,$QV0100F_2);
	
	}elseif($j==36){  /*=============== 36 ===============*/  

 	  if($A0050!="3"){
	  $QV0200A01A ="";
	  $QV0200A01B ="";
	  $QV0200A01 ="";
	  $QV0200A02A ="";
	  $QV0200A02B ="";
	  $QV0200A02 ="";
	  $QV0200A03A ="";
	  $QV0200A03B ="";
	  $QV0200A03 ="";
	  $QV0200A04A ="";
	  $QV0200A04B ="";
	  $QV0200A04 ="";
	  $QV0200A05A ="";
	  $QV0200A05B ="";
	  $QV0200A05 ="";
	  $QV0200A06A ="";
	  $QV0200A06B ="";
	  $QV0200A06 ="";
	  $QV0200A07A ="";
	  $QV0200A07B ="";
	  $QV0200A07 ="";
	  $QV0200A08A ="";
	  $QV0200A08B ="";
	  $QV0200A08 ="";
	  $QV0200A09A ="";
	  $QV0200A09B ="";
	  $QV0200A09 ="";
	  $QV0200A10A ="";
	  $QV0200A10B ="";
	  $QV0200A10 ="";
	  $QV0200A11A ="";
	  $QV0200A11B ="";
	  $QV0200A11 ="";
	  $QV0200A12A ="";
	  $QV0200A12B ="";
	  $QV0200A12 ="";
	  $QV0200A13A ="";
	  $QV0200A13B ="";
	  $QV0200A13 ="";
	  $QV0200A14A ="";
	  $QV0200A14B ="";
	  $QV0200A14 ="";
	  $QV0200A15A ="";
	  $QV0200A15B ="";
	  $QV0200A15 ="";
	  $QV0200A16A ="";
	  $QV0200A16B ="";
	  $QV0200A16 ="";
	  $QV0200A17A ="";
	  $QV0200A17B ="";
	  $QV0200A17 ="";
	  $QV0200A18A ="";
	  $QV0200A18B ="";
	  $QV0200A18 ="";
	  $QV0200A19A ="";
	  $QV0200A19B ="";
	  $QV0200A19 ="";
	  $QV0200A20A ="";
	  $QV0200A20B ="";
	  $QV0200A20 ="";
	  $sql = "SELECT `name` FROM `userinfo` WHERE `userID`='".$_SESSION['ncareID_lwj']."'";
	  $db21 = new DB2;
	  $db21->query($sql);
	  $r21 = $db21->fetch_assoc();
	  $QV0200Btext= $r21['name'];
	  $V0200B = str_split(date(Ymd));
	  $QV0200B_1 = $V0200B[4];
	  $QV0200B_2 = $V0200B[5];
	  $QV0200B_3 = $V0200B[6];
	  $QV0200B_4 = $V0200B[7];
	  $QV0200B_5 = $V0200B[0];
	  $QV0200B_6 = $V0200B[1];
	  $QV0200B_7 = $V0200B[2];
	  $QV0200B_8 = $V0200B[3];
	  $QV0200Ctext ="";
	  $QV0200C_1 ="";
	  $QV0200C_2 ="";
	  $QV0200C_3 ="";
	  $QV0200C_4 ="";
	  $QV0200C_5 ="";
	  $QV0200C_6 ="";
	  $QV0200C_7 ="";
	  $QV0200C_8 ="";
	  $page36Qfiller = array($_SESSION['ncareID_lwj']);
	  $page36Qfiller = array_unique($page36Qfiller);
	  sort($page36Qfiller);
	  for($i=0;$i<count($page36Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page36Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page36QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page36QfillerFilter = explode(";",$page36QfillerFilter);
	  $page36QfillerFilter = array_unique($page36QfillerFilter);
	  $page36Qfiller = array_diff($page36QfillerFilter, array(null,'null','',' '));
	  sort($page36Qfiller);
	  for($i=0;$i<count($page36Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page36Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QV0200A01A","QV0200A01B","QV0200A01","QV0200A02A","QV0200A02B","QV0200A02","QV0200A03A","QV0200A03B","QV0200A03","QV0200A04A","QV0200A04B","QV0200A04","QV0200A05A","QV0200A05B","QV0200A05","QV0200A06A","QV0200A06B","QV0200A06","QV0200A07A","QV0200A07B","QV0200A07","QV0200A08A","QV0200A08B","QV0200A08","QV0200A09A","QV0200A09B","QV0200A09","QV0200A10A","QV0200A10B","QV0200A10","QV0200A11A","QV0200A11B","QV0200A11","QV0200A12A","QV0200A12B","QV0200A12","QV0200A13A","QV0200A13B","QV0200A13","QV0200A14A","QV0200A14B","QV0200A14","QV0200A15A","QV0200A15B","QV0200A15","QV0200A16A","QV0200A16B","QV0200A16","QV0200A17A","QV0200A17B","QV0200A17","QV0200A18A","QV0200A18B","QV0200A18","QV0200A19A","QV0200A19B","QV0200A19","QV0200A20A","QV0200A20B","QV0200A20","QV0200Btext","QV0200B_1","QV0200B_2","QV0200B_3","QV0200B_4","QV0200B_5","QV0200B_6","QV0200B_7","QV0200B_8","QV0200Ctext","QV0200C_1","QV0200C_2","QV0200C_3","QV0200C_4","QV0200C_5","QV0200C_6","QV0200C_7","QV0200C_8");
	  $v = array($QV0200A01A,$QV0200A01B,$QV0200A01,$QV0200A02A,$QV0200A02B,$QV0200A02,$QV0200A03A,$QV0200A03B,$QV0200A03,$QV0200A04A,$QV0200A04B,$QV0200A04,$QV0200A05A,$QV0200A05B,$QV0200A05,$QV0200A06A,$QV0200A06B,$QV0200A06,$QV0200A07A,$QV0200A07B,$QV0200A07,$QV0200A08A,$QV0200A08B,$QV0200A08,$QV0200A09A,$QV0200A09B,$QV0200A09,$QV0200A10A,$QV0200A10B,$QV0200A10,$QV0200A11A,$QV0200A11B,$QV0200A11,$QV0200A12A,$QV0200A12B,$QV0200A12,$QV0200A13A,$QV0200A13B,$QV0200A13,$QV0200A14A,$QV0200A14B,$QV0200A14,$QV0200A15A,$QV0200A15B,$QV0200A15,$QV0200A16A,$QV0200A16B,$QV0200A16,$QV0200A17A,$QV0200A17B,$QV0200A17,$QV0200A18A,$QV0200A18B,$QV0200A18,$QV0200A19A,$QV0200A19B,$QV0200A19,$QV0200A20A,$QV0200A20B,$QV0200A20,$QV0200Btext,$QV0200B_1,$QV0200B_2,$QV0200B_3,$QV0200B_4,$QV0200B_5,$QV0200B_6,$QV0200B_7,$QV0200B_8,$QV0200Ctext,$QV0200C_1,$QV0200C_2,$QV0200C_3,$QV0200C_4,$QV0200C_5,$QV0200C_6,$QV0200C_7,$QV0200C_8);
	
	}elseif($j==37){  /*=============== 37 ===============*/
      
	  if($A0050=="2" || $A0050=="3"){  /* OK Complete Section X only if A0050 = 2 or 3 */
      /*== 取得要修改的 MDS 資料 START ==*/
 	  $db24 = new DB;
 	  $db24->query("SELECT * FROM `mdsform01` WHERE `HospNo`='".$HospNo."' AND `date`='".$OlderMDSdate."'");
 	  if($db24->num_rows()>0){
		  $r24 = $db24->fetch_assoc();
	  }
 	  $db25 = new DB;
 	  $db25->query("SELECT * FROM `mdsform02` WHERE `HospNo`='".$HospNo."' AND `date`='".$OlderMDSdate."'");
 	  if($db25->num_rows()>0){
		  $r25 = $db25->fetch_assoc();
	  }
 	  $db26 = new DB;
 	  $db26->query("SELECT * FROM `mdsform04` WHERE `HospNo`='".$HospNo."' AND `date`='".$OlderMDSdate."'");
 	  if($db26->num_rows()>0){
		  $r26 = $db26->fetch_assoc();
	  }
 	  $db27 = new DB;
 	  $db27->query("SELECT * FROM `mdsform05` WHERE `HospNo`='".$HospNo."' AND `date`='".$OlderMDSdate."'");
 	  if($db27->num_rows()>0){
		  $r27 = $db27->fetch_assoc();
	  }
 	  $db28 = new DB;
 	  $db28->query("SELECT * FROM `mdsform99` WHERE `HospNo`='".$HospNo."' AND `date`='".$OlderMDSdate."'");
 	  if($db28->num_rows()>0){
		  $r28 = $db28->fetch_assoc();
	  }
	  /*== 取得要修改的 MDS 資料 END ==*/
	  
 	  $QX0150 = $r24['QA0200'];
	  $QX0200A_1 = $r25['QA0500A_1'];
	  $QX0200A_2 = $r25['QA0500A_2'];
	  $QX0200A_3 = $r25['QA0500A_3'];
	  $QX0200A_4 = $r25['QA0500A_4'];
	  $QX0200A_5 = $r25['QA0500A_5'];
	  $QX0200A_6 = $r25['QA0500A_6'];
	  $QX0200A_7 = $r25['QA0500A_7'];
	  $QX0200A_8 = $r25['QA0500A_8'];
	  $QX0200A_9 = $r25['QA0500A_9'];
	  $QX0200A_10 = $r25['QA0500A_10'];
	  $QX0200A_11 = $r25['QA0500A_11'];
	  $QX0200A_12 = $r25['QA0500A_12'];
	  $QX0200C_1 = $r25['QA0500C_1'];
	  $QX0200C_2 = $r25['QA0500C_2'];
	  $QX0200C_3 = $r25['QA0500C_3'];
	  $QX0200C_4 = $r25['QA0500C_4'];
	  $QX0200C_5 = $r25['QA0500C_5'];
	  $QX0200C_6 = $r25['QA0500C_6'];
	  $QX0200C_7 = $r25['QA0500C_7'];
	  $QX0200C_8 = $r25['QA0500C_8'];
	  $QX0200C_9 = $r25['QA0500C_9'];
	  $QX0200C_10 = $r25['QA0500C_10'];
	  $QX0200C_11 = $r25['QA0500C_11'];
	  $QX0200C_12 = $r25['QA0500C_12'];
	  $QX0200C_13 = $r25['QA0500C_13'];
	  $QX0200C_14 = $r25['QA0500C_14'];
	  $QX0200C_15 = $r25['QA0500C_15'];
	  $QX0200C_16 = $r25['QA0500C_16'];
	  $QX0200C_17 = $r25['QA0500C_17'];
	  $QX0200C_18 = $r25['QA0500C_18'];
	  $QX0300 = $r25['QA0800'];
	  $QX0400_1 = $r25['QA0900_1'];
	  $QX0400_2 = $r25['QA0900_2'];
	  $QX0400_3 = $r25['QA0900_3'];
	  $QX0400_4 = $r25['QA0900_4'];
	  $QX0400_5 = $r25['QA0900_5'];
	  $QX0400_6 = $r25['QA0900_6'];
	  $QX0400_7 = $r25['QA0900_7'];
	  $QX0400_8 = $r25['QA0900_8'];
	  $QX0500_1 = $r25['QA0600A_1'];
	  $QX0500_2 = $r25['QA0600A_2'];
	  $QX0500_3 = $r25['QA0600A_3'];
	  $QX0500_4 = $r25['QA0600A_4'];
	  $QX0500_5 = $r25['QA0600A_5'];
	  $QX0500_6 = $r25['QA0600A_6'];
	  $QX0500_7 = $r25['QA0600A_7'];
	  $QX0500_8 = $r25['QA0600A_8'];
	  $QX0500_9 = $r25['QA0600A_9'];
	  $QX0600A = $r24['QA0310A'];
	  $QX0600B = $r24['QA0310B'];
	  $QX0600C = $r24['QA0310C'];
	  $page37Qfiller = array($_SESSION['ncareID_lwj']);
	  $page37Qfiller = array_unique($page37Qfiller);
	  sort($page37Qfiller);
	  for($i=0;$i<count($page37Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page37Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page37QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page37QfillerFilter = explode(";",$page37QfillerFilter);
	  $page37QfillerFilter = array_unique($page37QfillerFilter);
	  $page37Qfiller = array_diff($page37QfillerFilter, array(null,'null','',' '));
	  sort($page37Qfiller);
	  for($i=0;$i<count($page37Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page37Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QX0150","QX0200A_1","QX0200A_2","QX0200A_3","QX0200A_4","QX0200A_5","QX0200A_6","QX0200A_7","QX0200A_8","QX0200A_9","QX0200A_10","QX0200A_11","QX0200A_12","QX0200C_1","QX0200C_2","QX0200C_3","QX0200C_4","QX0200C_5","QX0200C_6","QX0200C_7","QX0200C_8","QX0200C_9","QX0200C_10","QX0200C_11","QX0200C_12","QX0200C_13","QX0200C_14","QX0200C_15","QX0200C_16","QX0200C_17","QX0200C_18","QX0300","QX0400_1","QX0400_2","QX0400_3","QX0400_4","QX0400_5","QX0400_6","QX0400_7","QX0400_8","QX0500_1","QX0500_2","QX0500_3","QX0500_4","QX0500_5","QX0500_6","QX0500_7","QX0500_8","QX0500_9","QX0600A","QX0600B","QX0600C");
	  $v = array($QX0150,$QX0200A_1,$QX0200A_2,$QX0200A_3,$QX0200A_4,$QX0200A_5,$QX0200A_6,$QX0200A_7,$QX0200A_8,$QX0200A_9,$QX0200A_10,$QX0200A_11,$QX0200A_12,$QX0200C_1,$QX0200C_2,$QX0200C_3,$QX0200C_4,$QX0200C_5,$QX0200C_6,$QX0200C_7,$QX0200C_8,$QX0200C_9,$QX0200C_10,$QX0200C_11,$QX0200C_12,$QX0200C_13,$QX0200C_14,$QX0200C_15,$QX0200C_16,$QX0200C_17,$QX0200C_18,$QX0300,$QX0400_1,$QX0400_2,$QX0400_3,$QX0400_4,$QX0400_5,$QX0400_6,$QX0400_7,$QX0400_8,$QX0500_1,$QX0500_2,$QX0500_3,$QX0500_4,$QX0500_5,$QX0500_6,$QX0500_7,$QX0500_8,$QX0500_9,$QX0600A,$QX0600B,$QX0600C);
	
	}elseif($j==38){  /*=============== 38 ===============*/

 	  if($A0050=="2" || $A0050=="3"){
	  if($QX0150=="2"){ /* OK Complete only if X0150 = 2 */
	  $QX0600D = $r24['QA0310D'];
	  }
	  $QX0600F = $r25['QA0310F'];
	  if($QX0600F=="99"){ /* OK X0700A Complete only if X0600F = 99 */
	  $QX0700A_1 = $r27['QA2300_1'];
	  $QX0700A_2 = $r27['QA2300_2'];
	  $QX0700A_3 = $r27['QA2300_3'];
	  $QX0700A_4 = $r27['QA2300_4'];
	  $QX0700A_5 = $r27['QA2300_5'];
	  $QX0700A_6 = $r27['QA2300_6'];
	  $QX0700A_7 = $r27['QA2300_7'];
	  $QX0700A_8 = $r27['QA2300_8'];
	  }
	  if($QX0600F=="10" || $QX0600F=="11" || $QX0600F=="12"){ /* OK X0700B Complete only if X0600F = 10, 11, or 12 */
	  $QX0700B_1 = $r26['QA2000_1'];
	  $QX0700B_2 = $r26['QA2000_2'];
	  $QX0700B_3 = $r26['QA2000_3'];
	  $QX0700B_4 = $r26['QA2000_4'];
	  $QX0700B_5 = $r26['QA2000_5'];
	  $QX0700B_6 = $r26['QA2000_6'];
	  $QX0700B_7 = $r26['QA2000_7'];
	  $QX0700B_8 = $r26['QA2000_8'];
	  }
	  if($QX0600F=="01"){ /* X0700C Complete only if X0600F = 01 */
	  $QX0700C_1 = $r26['QA1600_1'];
	  $QX0700C_2 = $r26['QA1600_2'];
	  $QX0700C_3 = $r26['QA1600_3'];
	  $QX0700C_4 = $r26['QA1600_4'];
	  $QX0700C_5 = $r26['QA1600_5'];
	  $QX0700C_6 = $r26['QA1600_6'];
	  $QX0700C_7 = $r26['QA1600_7'];
	  $QX0700C_8 = $r26['QA1600_8'];
	  }
	  $QX0800_1 ='1';
	  $QX0800_2 ='1';
	  if($A0050=="2"){ /* OK X0900 Complete only if Type of Record is to modify a record in error (A0050 = 2) */
	  $QX0900A = $X0900A;
	  $QX0900B = $X0900B;
	  $QX0900C = $X0900C;
	  $QX0900D = $X0900D;
	  $QX0900E = $X0900E;
	  $QX0900Z = $X0900Z;
	  $QX0900Ztext = $X0900Ztext;
	  }
	  if($A0050=="3"){ /* OK X1050 Complete only if Type of Record is to inactivate a record in error (A0050 = 3) */
	  $QX1050A = $X1050A;
	  $QX1050Z = $X1050Z;
	  $QX1050Ztext = $X1050Ztext;
	  }
	  $page38Qfiller = array($_SESSION['ncareID_lwj']);
	  $page38Qfiller = array_unique($page38Qfiller);
	  sort($page38Qfiller);
	  for($i=0;$i<count($page38Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page38Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page38QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page38QfillerFilter = explode(";",$page38QfillerFilter);
	  $page38QfillerFilter = array_unique($page38QfillerFilter);
	  $page38Qfiller = array_diff($page38QfillerFilter, array(null,'null','',' '));
	  sort($page38Qfiller);
	  for($i=0;$i<count($page38Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page38Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QX0600D","QX0600F","QX0700A_1","QX0700A_2","QX0700A_3","QX0700A_4","QX0700A_5","QX0700A_6","QX0700A_7","QX0700A_8","QX0700B_1","QX0700B_2","QX0700B_3","QX0700B_4","QX0700B_5","QX0700B_6","QX0700B_7","QX0700B_8","QX0700C_1","QX0700C_2","QX0700C_3","QX0700C_4","QX0700C_5","QX0700C_6","QX0700C_7","QX0700C_8","QX0800_1","QX0800_2","QX0900A","QX0900B","QX0900C","QX0900D","QX0900E","QX0900Z","QX0900Ztext","QX1050A","QX1050Z","QX1050Ztext");
	  $v = array($QX0600D,$QX0600F,$QX0700A_1,$QX0700A_2,$QX0700A_3,$QX0700A_4,$QX0700A_5,$QX0700A_6,$QX0700A_7,$QX0700A_8,$QX0700B_1,$QX0700B_2,$QX0700B_3,$QX0700B_4,$QX0700B_5,$QX0700B_6,$QX0700B_7,$QX0700B_8,$QX0700C_1,$QX0700C_2,$QX0700C_3,$QX0700C_4,$QX0700C_5,$QX0700C_6,$QX0700C_7,$QX0700C_8,$QX0800_1,$QX0800_2,$QX0900A,$QX0900B,$QX0900C,$QX0900D,$QX0900E,$QX0900Z,$QX0900Ztext,$QX1050A,$QX1050Z,$QX1050Ztext);
	
	}elseif($j==39){  /*=============== 39 ===============*/

 	  if($A0050=="2" || $A0050=="3"){
	  /*=== 取得工作人員名字 START ===*/
	  $sql = "SELECT `name`,`position` FROM `userinfo` WHERE `userID`='".$r28['Qfiller']."'";
	  $db31 = new DB2;
	  $db31->query($sql);
	  if ($db31->num_rows()>0) {
		  $r31 = $db31->fetch_assoc();
	  }
	  $X1100 = explode(" ",$r31['name']);
	  $X1100A = str_split($X1100[0]);
	  $X1100B = str_split($X1100[1]);
	  $X1100C = $r31['position'];
	  $X1100D = $r31['name'];
	  $X1100E = str_split(formatdate_Ymd($r28['date']));
	  /*=== 取得工作人員名字 END ===*/
	  $QX1100A_1 = $X1100A[0];
	  $QX1100A_2 = $X1100A[1];
	  $QX1100A_3 = $X1100A[2];
	  $QX1100A_4 = $X1100A[3];
	  $QX1100A_5 = $X1100A[4];
	  $QX1100A_6 = $X1100A[5];
	  $QX1100A_7 = $X1100A[6];
	  $QX1100A_8 = $X1100A[7];
	  $QX1100A_9 = $X1100A[8];
	  $QX1100A_10 = $X1100A[9];
	  $QX1100A_11 = $X1100A[10];
	  $QX1100A_12 = $X1100A[11];
	  $QX1100B_1 = $X1100B[0];
	  $QX1100B_2 = $X1100B[1];
	  $QX1100B_3 = $X1100B[2];
	  $QX1100B_4 = $X1100B[3];
	  $QX1100B_5 = $X1100B[4];
	  $QX1100B_6 = $X1100B[5];
	  $QX1100B_7 = $X1100B[6];
	  $QX1100B_8 = $X1100B[7];
	  $QX1100B_9 = $X1100B[8];
	  $QX1100B_10 = $X1100B[9];
	  $QX1100B_11 = $X1100B[10];
	  $QX1100B_12 = $X1100B[11];
	  $QX1100B_13 = $X1100B[12];
	  $QX1100B_14 = $X1100B[13];
	  $QX1100B_15 = $X1100B[14];
	  $QX1100B_16 = $X1100B[15];
	  $QX1100B_17 = $X1100B[16];
	  $QX1100B_18 = $X1100B[17];
	  $QX1100C = $X1100C;
	  $QX1100D = $X1100D;
	  $QX1100E_1 = $X1100E[4];
	  $QX1100E_2 = $X1100E[5];
	  $QX1100E_3 = $X1100E[6];
	  $QX1100E_4 = $X1100E[7];
	  $QX1100E_5 = $X1100E[0];
	  $QX1100E_6 = $X1100E[1];
	  $QX1100E_7 = $X1100E[2];
	  $QX1100E_8 = $X1100E[3];
	  $page39Qfiller = array($_SESSION['ncareID_lwj']);
	  $page39Qfiller = array_unique($page39Qfiller);
	  sort($page39Qfiller);
	  for($i=0;$i<count($page39Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page39Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page39QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page39QfillerFilter = explode(";",$page39QfillerFilter);
	  $page39QfillerFilter = array_unique($page39QfillerFilter);
	  $page39Qfiller = array_diff($page39QfillerFilter, array(null,'null','',' '));
	  sort($page39Qfiller);
	  for($i=0;$i<count($page39Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page39Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  }
	  $k = array("QX1100A_1","QX1100A_2","QX1100A_3","QX1100A_4","QX1100A_5","QX1100A_6","QX1100A_7","QX1100A_8","QX1100A_9","QX1100A_10","QX1100A_11","QX1100A_12","QX1100B_1","QX1100B_2","QX1100B_3","QX1100B_4","QX1100B_5","QX1100B_6","QX1100B_7","QX1100B_8","QX1100B_9","QX1100B_10","QX1100B_11","QX1100B_12","QX1100B_13","QX1100B_14","QX1100B_15","QX1100B_16","QX1100B_17","QX1100B_18","QX1100C","QX1100D","QX1100E_1","QX1100E_2","QX1100E_3","QX1100E_4","QX1100E_5","QX1100E_6","QX1100E_7","QX1100E_8");
	  $v = array($QX1100A_1,$QX1100A_2,$QX1100A_3,$QX1100A_4,$QX1100A_5,$QX1100A_6,$QX1100A_7,$QX1100A_8,$QX1100A_9,$QX1100A_10,$QX1100A_11,$QX1100A_12,$QX1100B_1,$QX1100B_2,$QX1100B_3,$QX1100B_4,$QX1100B_5,$QX1100B_6,$QX1100B_7,$QX1100B_8,$QX1100B_9,$QX1100B_10,$QX1100B_11,$QX1100B_12,$QX1100B_13,$QX1100B_14,$QX1100B_15,$QX1100B_16,$QX1100B_17,$QX1100B_18,$QX1100C,$QX1100D,$QX1100E_1,$QX1100E_2,$QX1100E_3,$QX1100E_4,$QX1100E_5,$QX1100E_6,$QX1100E_7,$QX1100E_8);
	
	}elseif($j==40){  /*=============== 40 ===============*/

 	  $QZ0100A_1 ='';
	  $QZ0100A_2 ='';
	  $QZ0100A_3 ='';
	  $QZ0100A_4 ='';
	  $QZ0100A_5 ='';
	  $QZ0100A_6 ='';
	  $QZ0100A_7 ='';
	  $QZ0100B_1 ='';
	  $QZ0100B_2 ='';
	  $QZ0100B_3 ='';
	  $QZ0100B_4 ='';
	  $QZ0100B_5 ='';
	  $QZ0100B_6 ='';
	  $QZ0100B_7 ='';
	  $QZ0100B_8 ='';
	  $QZ0100B_9 ='';
	  $QZ0100B_10 ='';
	  $QZ0100C ='';
	  $QZ0150A_1 ='';
	  $QZ0150A_2 ='';
	  $QZ0150A_3 ='';
	  $QZ0150A_4 ='';
	  $QZ0150A_5 ='';
	  $QZ0150A_6 ='';
	  $QZ0150A_7 ='';
	  $QZ0150B_1 ='';
	  $QZ0150B_2 ='';
	  $QZ0150B_3 ='';
	  $QZ0150B_4 ='';
	  $QZ0150B_5 ='';
	  $QZ0150B_6 ='';
	  $QZ0150B_7 ='';
	  $QZ0150B_8 ='';
	  $QZ0150B_9 ='';
	  $QZ0150B_10 ='';
	  $QZ0200A_1 ='';
	  $QZ0200A_2 ='';
	  $QZ0200A_3 ='';
	  $QZ0200A_4 ='';
	  $QZ0200A_5 ='';
	  $QZ0200A_6 ='';
	  $QZ0200A_7 ='';
	  $QZ0200A_8 ='';
	  $QZ0200A_9 ='';
	  $QZ0200A_10 ='';
	  $QZ0200B_1 ='';
	  $QZ0200B_2 ='';
	  $QZ0200B_3 ='';
	  $QZ0200B_4 ='';
	  $QZ0200B_5 ='';
	  $QZ0200B_6 ='';
	  $QZ0200B_7 ='';
	  $QZ0200B_8 ='';
	  $QZ0200B_9 ='';
	  $QZ0200B_10 ='';
	  $QZ0250A_1 ='';
	  $QZ0250A_2 ='';
	  $QZ0250A_3 ='';
	  $QZ0250A_4 ='';
	  $QZ0250A_5 ='';
	  $QZ0250A_6 ='';
	  $QZ0250A_7 ='';
	  $QZ0250A_8 ='';
	  $QZ0250A_9 ='';
	  $QZ0250A_10 ='';
	  $QZ0250B_1 ='';
	  $QZ0250B_2 ='';
	  $QZ0250B_3 ='';
	  $QZ0250B_4 ='';
	  $QZ0250B_5 ='';
	  $QZ0250B_6 ='';
	  $QZ0250B_7 ='';
	  $QZ0250B_8 ='';
	  $QZ0250B_9 ='';
	  $QZ0250B_10 ='';
	  $QZ0300A_1 ='';
	  $QZ0300A_2 ='';
	  $QZ0300A_3 ='';
	  $QZ0300A_4 ='';
	  $QZ0300A_5 ='';
	  $QZ0300A_6 ='';
	  $QZ0300A_7 ='';
	  $QZ0300A_8 ='';
	  $QZ0300A_9 ='';
	  $QZ0300A_10 ='';
	  $QZ0300B_1 ='';
	  $QZ0300B_2 ='';
	  $QZ0300B_3 ='';
	  $QZ0300B_4 ='';
	  $QZ0300B_5 ='';
	  $QZ0300B_6 ='';
	  $QZ0300B_7 ='';
	  $QZ0300B_8 ='';
	  $QZ0300B_9 ='';
	  $QZ0300B_10 ='';
	  $page40Qfiller = array($_SESSION['ncareID_lwj']);
	  $page40Qfiller = array_unique($page40Qfiller);
	  sort($page40Qfiller);
	  for($i=0;$i<count($page40Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page40Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page40QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page40QfillerFilter = explode(";",$page40QfillerFilter);
	  $page40QfillerFilter = array_unique($page40QfillerFilter);
	  $page40Qfiller = array_diff($page40QfillerFilter, array(null,'null','',' '));
	  sort($page40Qfiller);
	  for($i=0;$i<count($page40Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page40Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  $k = array("QZ0100A_1","QZ0100A_2","QZ0100A_3","QZ0100A_4","QZ0100A_5","QZ0100A_6","QZ0100A_7","QZ0100B_1","QZ0100B_2","QZ0100B_3","QZ0100B_4","QZ0100B_5","QZ0100B_6","QZ0100B_7","QZ0100B_8","QZ0100B_9","QZ0100B_10","QZ0100C","QZ0150A_1","QZ0150A_2","QZ0150A_3","QZ0150A_4","QZ0150A_5","QZ0150A_6","QZ0150A_7","QZ0150B_1","QZ0150B_2","QZ0150B_3","QZ0150B_4","QZ0150B_5","QZ0150B_6","QZ0150B_7","QZ0150B_8","QZ0150B_9","QZ0150B_10","QZ0200A_1","QZ0200A_2","QZ0200A_3","QZ0200A_4","QZ0200A_5","QZ0200A_6","QZ0200A_7","QZ0200A_8","QZ0200A_9","QZ0200A_10","QZ0200B_1","QZ0200B_2","QZ0200B_3","QZ0200B_4","QZ0200B_5","QZ0200B_6","QZ0200B_7","QZ0200B_8","QZ0200B_9","QZ0200B_10","QZ0250A_1","QZ0250A_2","QZ0250A_3","QZ0250A_4","QZ0250A_5","QZ0250A_6","QZ0250A_7","QZ0250A_8","QZ0250A_9","QZ0250A_10","QZ0250B_1","QZ0250B_2","QZ0250B_3","QZ0250B_4","QZ0250B_5","QZ0250B_6","QZ0250B_7","QZ0250B_8","QZ0250B_9","QZ0250B_10","QZ0300A_1","QZ0300A_2","QZ0300A_3","QZ0300A_4","QZ0300A_5","QZ0300A_6","QZ0300A_7","QZ0300A_8","QZ0300A_9","QZ0300A_10","QZ0300B_1","QZ0300B_2","QZ0300B_3","QZ0300B_4","QZ0300B_5","QZ0300B_6","QZ0300B_7","QZ0300B_8","QZ0300B_9","QZ0300B_10");
	  $v = array($QZ0100A_1,$QZ0100A_2,$QZ0100A_3,$QZ0100A_4,$QZ0100A_5,$QZ0100A_6,$QZ0100A_7,$QZ0100B_1,$QZ0100B_2,$QZ0100B_3,$QZ0100B_4,$QZ0100B_5,$QZ0100B_6,$QZ0100B_7,$QZ0100B_8,$QZ0100B_9,$QZ0100B_10,$QZ0100C,$QZ0150A_1,$QZ0150A_2,$QZ0150A_3,$QZ0150A_4,$QZ0150A_5,$QZ0150A_6,$QZ0150A_7,$QZ0150B_1,$QZ0150B_2,$QZ0150B_3,$QZ0150B_4,$QZ0150B_5,$QZ0150B_6,$QZ0150B_7,$QZ0150B_8,$QZ0150B_9,$QZ0150B_10,$QZ0200A_1,$QZ0200A_2,$QZ0200A_3,$QZ0200A_4,$QZ0200A_5,$QZ0200A_6,$QZ0200A_7,$QZ0200A_8,$QZ0200A_9,$QZ0200A_10,$QZ0200B_1,$QZ0200B_2,$QZ0200B_3,$QZ0200B_4,$QZ0200B_5,$QZ0200B_6,$QZ0200B_7,$QZ0200B_8,$QZ0200B_9,$QZ0200B_10,$QZ0250A_1,$QZ0250A_2,$QZ0250A_3,$QZ0250A_4,$QZ0250A_5,$QZ0250A_6,$QZ0250A_7,$QZ0250A_8,$QZ0250A_9,$QZ0250A_10,$QZ0250B_1,$QZ0250B_2,$QZ0250B_3,$QZ0250B_4,$QZ0250B_5,$QZ0250B_6,$QZ0250B_7,$QZ0250B_8,$QZ0250B_9,$QZ0250B_10,$QZ0300A_1,$QZ0300A_2,$QZ0300A_3,$QZ0300A_4,$QZ0300A_5,$QZ0300A_6,$QZ0300A_7,$QZ0300A_8,$QZ0300A_9,$QZ0300A_10,$QZ0300B_1,$QZ0300B_2,$QZ0300B_3,$QZ0300B_4,$QZ0300B_5,$QZ0300B_6,$QZ0300B_7,$QZ0300B_8,$QZ0300B_9,$QZ0300B_10);
	
	}elseif($j==41){  /*=============== 41 ===============*/
      
	  /*================  Qfiller 判斷式 START ================*/
	  for($p=1;$p<44;$p++){
		  if(${"page".$p."Qfiller"}=="" || ${"page".$p."Qfiller"}==NULL){
			  ${"page".$p."Qfiller"} = array($_SESSION['ncareID_lwj']);
		  }
		  
		  /*=== 取得所有 Qfiller START ===*/
		  /*for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
			  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
				  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
			  }
	      }
		  /*=== 取得所有 Qfiller END ===*/
		  /*=== 取得每個 Section Qfiller START ===*/
		  if($p>=1 && $p<=5){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionAQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==6){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionBQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==7 || $p==8){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionCQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==9 || $p==10){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionDQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==11 || $p==12){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionEQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==13 || $p==14){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionFQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==15 || $p==16){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionGQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==17){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionHQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==18 || $p==19){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionIQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p>=20 && $p<=22){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionJQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==23 || $p==24){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionKQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==24){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionLQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p>=25 && $p<=27){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionMQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==28){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionNQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p>=29 && $p<=32){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionOQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==33){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionPQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==33 || $p==34){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionQQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p==35 || $p==36){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionVQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p>=37 && $p<=39){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionXQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p>=40 && $p<=41){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionZQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }elseif($p>=42 && $p<=43){
			  for($i=0;$i<count(${"page".$p."Qfiller"});$i++){
				  if(${"page".$p."Qfiller"}[$i]!="" || ${"page".$p."Qfiller"}[$i]!=NULL){
					  $SectionSQfiller .= ${"page".$p."Qfiller"}[$i].';';
					  $TotalQfiller .= ${"page".$p."Qfiller"}[$i].';';
				  }
	          }
		  }else{}
		  /*=== 取得每個 Section Qfiller END ===*/
	  }
	  
	  /* Total Qfiller Array 篩選 START */
	  $TotalQfiller = explode(";",$TotalQfiller);
	  $TotalQfiller = array_unique($TotalQfiller);
	  $TotalQfiller = array_diff($TotalQfiller, array(null,'null','',' '));  /*explode後去除空陣列*/
	  sort($TotalQfiller); /*全部array_unique後都要sort  ======== 前面的每一頁還沒修改 ===============================   */
	  /* Total Qfiller Array 篩選 END */
	  /* Section A Qfiller Array 篩選 START */
	  $SectionAQfiller = explode(";",$SectionAQfiller);
	  $SectionAQfiller = array_unique($SectionAQfiller);
	  $SectionAQfiller = array_diff($SectionAQfiller, array(null,'null','',' '));
	  sort($SectionAQfiller);
	  /* Section A Qfiller Array 篩選 END */
	  /* Section B Qfiller Array 篩選 START */
	  $SectionBQfiller = explode(";",$SectionBQfiller);
	  $SectionBQfiller = array_unique($SectionBQfiller);
	  $SectionBQfiller = array_diff($SectionBQfiller, array(null,'null','',' '));
	  sort($SectionBQfiller);
	  /* Section B Qfiller Array 篩選 END */	  
	  /* Section C Qfiller Array 篩選 START */
	  $SectionCQfiller = explode(";",$SectionCQfiller);
	  $SectionCQfiller = array_unique($SectionCQfiller);
	  $SectionCQfiller = array_diff($SectionCQfiller, array(null,'null','',' '));
	  sort($SectionCQfiller);
	  /* Section C Qfiller Array 篩選 END */		  
	  /* Section D Qfiller Array 篩選 START */
	  $SectionDQfiller = explode(";",$SectionDQfiller);
	  $SectionDQfiller = array_unique($SectionDQfiller);
	  $SectionDQfiller = array_diff($SectionDQfiller, array(null,'null','',' '));
	  sort($SectionDQfiller);
	  /* Section D Qfiller Array 篩選 END */
	  /* Section E Qfiller Array 篩選 START */
	  $SectionEQfiller = explode(";",$SectionEQfiller);
	  $SectionEQfiller = array_unique($SectionEQfiller);
	  $SectionEQfiller = array_diff($SectionEQfiller, array(null,'null','',' '));
	  sort($SectionEQfiller);
	  /* Section E Qfiller Array 篩選 END */	
	  /* Section F Qfiller Array 篩選 START */
	  $SectionFQfiller = explode(";",$SectionFQfiller);
	  $SectionFQfiller = array_unique($SectionFQfiller);
	  $SectionFQfiller = array_diff($SectionFQfiller, array(null,'null','',' '));
	  sort($SectionFQfiller);
	  /* Section F Qfiller Array 篩選 END */		  
	  /* Section G Qfiller Array 篩選 START */
	  $SectionGQfiller = explode(";",$SectionGQfiller);
	  $SectionGQfiller = array_unique($SectionGQfiller);
	  $SectionGQfiller = array_diff($SectionGQfiller, array(null,'null','',' '));
	  sort($SectionGQfiller);
	  /* Section G Qfiller Array 篩選 END */		  
	  /* Section H Qfiller Array 篩選 START */
	  $SectionHQfiller = explode(";",$SectionHQfiller);
	  $SectionHQfiller = array_unique($SectionHQfiller);
	  $SectionHQfiller = array_diff($SectionHQfiller, array(null,'null','',' '));
	  sort($SectionHQfiller);
	  /* Section H Qfiller Array 篩選 END */		  
	  /* Section I Qfiller Array 篩選 START */
	  $SectionIQfiller = explode(";",$SectionIQfiller);
	  $SectionIQfiller = array_diff($SectionIQfiller, array(null,'null','',' '));
	  $SectionIQfiller = array_unique($SectionIQfiller);
	  sort($SectionIQfiller);
	  /* Section I Qfiller Array 篩選 END */	
	  /* Section J Qfiller Array 篩選 START */
	  $SectionJQfiller = explode(";",$SectionJQfiller);
	  $SectionJQfiller = array_unique($SectionJQfiller);
	  $SectionJQfiller = array_diff($SectionJQfiller, array(null,'null','',' '));
	  sort($SectionJQfiller);
	  /* Section J Qfiller Array 篩選 END */		  
	  /* Section K Qfiller Array 篩選 START */
	  $SectionKQfiller = explode(";",$SectionKQfiller);
	  $SectionKQfiller = array_unique($SectionKQfiller);
	  $SectionKQfiller = array_diff($SectionKQfiller, array(null,'null','',' '));
	  sort($SectionKQfiller);
	  /* Section K Qfiller Array 篩選 END */		  
	  /* Section L Qfiller Array 篩選 START */
	  $SectionLQfiller = explode(";",$SectionLQfiller);
	  $SectionLQfiller = array_unique($SectionLQfiller);
	  $SectionLQfiller = array_diff($SectionLQfiller, array(null,'null','',' '));
	  sort($SectionLQfiller);
	  /* Section L Qfiller Array 篩選 END */		  
	  /* Section M Qfiller Array 篩選 START */
	  $SectionMQfiller = explode(";",$SectionMQfiller);
	  $SectionMQfiller = array_unique($SectionMQfiller);
	  $SectionMQfiller = array_diff($SectionMQfiller, array(null,'null','',' '));
	  sort($SectionMQfiller);
	  /* Section M Qfiller Array 篩選 END */	
	  /* Section N Qfiller Array 篩選 START */
	  $SectionNQfiller = explode(";",$SectionNQfiller);
	  $SectionNQfiller = array_unique($SectionNQfiller);
	  $SectionNQfiller = array_diff($SectionNQfiller, array(null,'null','',' '));
	  sort($SectionNQfiller);
	  /* Section N Qfiller Array 篩選 END */		  
	  /* Section O Qfiller Array 篩選 START */
	  $SectionOQfiller = explode(";",$SectionOQfiller);
	  $SectionOQfiller = array_unique($SectionOQfiller);
	  $SectionOQfiller = array_diff($SectionOQfiller, array(null,'null','',' '));
	  sort($SectionOQfiller);
	  /* Section O Qfiller Array 篩選 END */		  
	  /* Section P Qfiller Array 篩選 START */
	  $SectionPQfiller = explode(";",$SectionPQfiller);
	  $SectionPQfiller = array_unique($SectionPQfiller);
	  $SectionPQfiller = array_diff($SectionPQfiller, array(null,'null','',' '));
	  sort($SectionPQfiller);
	  /* Section P Qfiller Array 篩選 END */		  
	  /* Section Q Qfiller Array 篩選 START */
	  $SectionQQfiller = explode(";",$SectionQQfiller);
	  $SectionQQfiller = array_unique($SectionQQfiller);
	  $SectionQQfiller = array_diff($SectionQQfiller, array(null,'null','',' '));
	  sort($SectionQQfiller);
	  /* Section Q Qfiller Array 篩選 END */	
	  /* Section V Qfiller Array 篩選 START */
	  $SectionVQfiller = explode(";",$SectionVQfiller);
	  $SectionVQfiller = array_unique($SectionVQfiller);
	  $SectionVQfiller = array_diff($SectionVQfiller, array(null,'null','',' '));
	  sort($SectionVQfiller);
	  /* Section V Qfiller Array 篩選 END */		  
	  /* Section X Qfiller Array 篩選 START */
	  $SectionXQfiller = explode(";",$SectionXQfiller);
	  $SectionXQfiller = array_unique($SectionXQfiller);
	  $SectionXQfiller = array_diff($SectionXQfiller, array(null,'null','',' '));
	  sort($SectionXQfiller);
	  /* Section X Qfiller Array 篩選 END */		  
	  /* Section Z Qfiller Array 篩選 START */
	  $SectionZQfiller = explode(";",$SectionZQfiller);
	  $SectionZQfiller = array_unique($SectionZQfiller);
	  $SectionZQfiller = array_diff($SectionZQfiller, array(null,'null','',' '));
	  sort($SectionZQfiller);
	  /* Section Z Qfiller Array 篩選 END */		  
	  /* Section S Qfiller Array 篩選 START */
	  $SectionSQfiller = explode(";",$SectionSQfiller);
	  $SectionSQfiller = array_unique($SectionSQfiller);
	  $SectionSQfiller = array_diff($SectionSQfiller, array(null,'null','',' '));
	  sort($SectionSQfiller);
	  /* Section S Qfiller Array 篩選 END */
	  /* Total Qfiller Array 取值過濾 START */
	  for($i=0;$i<count($TotalQfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$TotalQfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $TotalQfillerFilter .= $v.';';
		      }
		  }
	  }
	  $TotalQfillerFilter = explode(";",$TotalQfillerFilter);
	  $TotalQfillerFilter = array_unique($TotalQfillerFilter);
	  $TotalQfillerFilter = array_diff($TotalQfillerFilter, array(null,'null','',' '));
	  sort($TotalQfillerFilter);
	  /* Total Qfiller Array 取值過濾 END */
	  /* Total Qfiller Filter Array 取值 START */
	  for($i=0;$i<count($TotalQfillerFilter);$i++){
		  $sql = "SELECT `name`,`position` FROM `userinfo` WHERE `userID`='".$TotalQfillerFilter[$i]."'";
		  $db20 = new DB2;
		  $db20->query($sql);
		  $r20 = $db20->fetch_assoc();
		  if ($db20->num_rows()>0) {
			  foreach ($r20 as $k=>$v) {
				  ${"TotalQfiller_".$i."_".$k} = $v;
				  $DateSectionCompleted[$i] = date("m/d/Y");
				  if($TotalQfillerFilter[$i]==$_SESSION['ncareID_lwj'] && $k=="name"){
					  $Z0500A = $v;
				  }
		      }
		  }
	  }
	  
	  for($i=0;$i<count($TotalQfillerFilter);$i++){
		  
		  if(in_array($TotalQfillerFilter[$i],$SectionAQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section A".';';
		  }
		  if($QA0050!="3"){
		  if(in_array($TotalQfillerFilter[$i],$SectionBQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section B".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionCQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section C".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionDQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section D".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionEQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section E".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionFQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section F".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionGQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section G".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionHQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section H".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionIQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section I".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionJQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section J".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionKQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section K".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionLQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section L".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionMQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section M".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionNQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section N".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionOQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section O".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionPQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section P".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionQQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section Q".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionSQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section S".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionVQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section V".';';
		  }
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionXQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section X".';';
		  }
		  if(in_array($TotalQfillerFilter[$i],$SectionZQfiller)){
			  ${"TotalQfiller_".$i."_section"} .= "Section Z".';';
		  }
	  }
	  for($i=0;$i<count($TotalQfillerFilter);$i++){
		   ${"TotalQfiller_".$i."_section"} = str_replace(';Section',', Section', ${"TotalQfiller_".$i."_section"});
		   ${"TotalQfiller_".$i."_section"} = str_replace('Section','', ${"TotalQfiller_".$i."_section"});
		   ${"TotalQfiller_".$i."_section"} = str_replace(';','', ${"TotalQfiller_".$i."_section"});
	  }
	  /* Total Qfiller Filter Array 取值 END */
	  /*================  Qfiller 判斷式 EDN ================*/
 	  $QZ0400A = $TotalQfiller_0_name;
	  $QZ0400A1 = $TotalQfiller_0_position;
	  $QZ0400A2 = $TotalQfiller_0_section;
	  $QZ0400A3 = $DateSectionCompleted[0];
	  $QZ0400B = $TotalQfiller_1_name;
	  $QZ0400B1 = $TotalQfiller_1_position;
	  $QZ0400B2 = $TotalQfiller_1_section;
	  $QZ0400B3 = $DateSectionCompleted[1];
	  $QZ0400C = $TotalQfiller_2_name;
	  $QZ0400C1 = $TotalQfiller_2_position;
	  $QZ0400C2 = $TotalQfiller_2_section;
	  $QZ0400C3 = $DateSectionCompleted[2];
	  $QZ0400D = $TotalQfiller_3_name;
	  $QZ0400D1 = $TotalQfiller_3_position;
	  $QZ0400D2 = $TotalQfiller_3_section;
	  $QZ0400D3 = $DateSectionCompleted[3];
	  $QZ0400E = $TotalQfiller_4_name;
	  $QZ0400E1 = $TotalQfiller_4_position;
	  $QZ0400E2 = $TotalQfiller_4_section;
	  $QZ0400E3 = $DateSectionCompleted[4];
	  $QZ0400F = $TotalQfiller_5_name;
	  $QZ0400F1 = $TotalQfiller_5_position;
	  $QZ0400F2 = $TotalQfiller_5_section;
	  $QZ0400F3 = $DateSectionCompleted[5];
	  $QZ0400G = $TotalQfiller_6_name;
	  $QZ0400G1 = $TotalQfiller_6_position;
	  $QZ0400G2 = $TotalQfiller_6_section;
	  $QZ0400G3 = $DateSectionCompleted[6];
	  $QZ0400H = $TotalQfiller_7_name;
	  $QZ0400H1 = $TotalQfiller_7_position;
	  $QZ0400H2 = $TotalQfiller_7_section;
	  $QZ0400H3 = $DateSectionCompleted[7];
	  $QZ0400I = $TotalQfiller_8_name;
	  $QZ0400I1 = $TotalQfiller_8_position;
	  $QZ0400I2 = $TotalQfiller_8_section;
	  $QZ0400I3 = $DateSectionCompleted[8];
	  $QZ0400J = $TotalQfiller_9_name;
	  $QZ0400J1 = $TotalQfiller_9_position;
	  $QZ0400J2 = $TotalQfiller_9_section;
	  $QZ0400J3 = $DateSectionCompleted[9];
	  $QZ0400K = $TotalQfiller_10_name;
	  $QZ0400K1 = $TotalQfiller_10_position;
	  $QZ0400K2 = $TotalQfiller_10_section;
	  $QZ0400K3 = $DateSectionCompleted[10];
	  $QZ0400L = $TotalQfiller_11_name;
	  $QZ0400L1 = $TotalQfiller_11_position;
	  $QZ0400L2 = $TotalQfiller_11_section;
	  $QZ0400L3 = $DateSectionCompleted[11];
	  $QZ0500A = $Z0500A;
	  $Z0500B = str_split(date(Ymd));
	  $QZ0500B_1 = $Z0500B[4];
	  $QZ0500B_2 = $Z0500B[5];
	  $QZ0500B_3 = $Z0500B[6];
	  $QZ0500B_4 = $Z0500B[7];
	  $QZ0500B_5 = $Z0500B[0];
	  $QZ0500B_6 = $Z0500B[1];
	  $QZ0500B_7 = $Z0500B[2];
	  $QZ0500B_8 = $Z0500B[3];
	  $page41Qfiller = array($_SESSION['ncareID_lwj']);
	  $page41Qfiller = array_unique($page41Qfiller);
	  sort($page41Qfiller);
	  for($i=0;$i<count($page41Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page41Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page41QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page41QfillerFilter = explode(";",$page41QfillerFilter);
	  $page41QfillerFilter = array_unique($page41QfillerFilter);
	  $page41Qfiller = array_diff($page41QfillerFilter, array(null,'null','',' '));
	  sort($page41Qfiller);
	  for($i=0;$i<count($page41Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page41Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  $k = array("QZ0400A","QZ0400A1","QZ0400A2","QZ0400A3","QZ0400B","QZ0400B1","QZ0400B2","QZ0400B3","QZ0400C","QZ0400C1","QZ0400C2","QZ0400C3","QZ0400D","QZ0400D1","QZ0400D2","QZ0400D3","QZ0400E","QZ0400E1","QZ0400E2","QZ0400E3","QZ0400F","QZ0400F1","QZ0400F2","QZ0400F3","QZ0400G","QZ0400G1","QZ0400G2","QZ0400G3","QZ0400H","QZ0400H1","QZ0400H2","QZ0400H3","QZ0400I","QZ0400I1","QZ0400I2","QZ0400I3","QZ0400J","QZ0400J1","QZ0400J2","QZ0400J3","QZ0400K","QZ0400K1","QZ0400K2","QZ0400K3","QZ0400L","QZ0400L1","QZ0400L2","QZ0400L3","QZ0500A","QZ0500B_1","QZ0500B_2","QZ0500B_3","QZ0500B_4","QZ0500B_5","QZ0500B_6","QZ0500B_7","QZ0500B_8");
	  $v = array($QZ0400A,$QZ0400A1,$QZ0400A2,$QZ0400A3,$QZ0400B,$QZ0400B1,$QZ0400B2,$QZ0400B3,$QZ0400C,$QZ0400C1,$QZ0400C2,$QZ0400C3,$QZ0400D,$QZ0400D1,$QZ0400D2,$QZ0400D3,$QZ0400E,$QZ0400E1,$QZ0400E2,$QZ0400E3,$QZ0400F,$QZ0400F1,$QZ0400F2,$QZ0400F3,$QZ0400G,$QZ0400G1,$QZ0400G2,$QZ0400G3,$QZ0400H,$QZ0400H1,$QZ0400H2,$QZ0400H3,$QZ0400I,$QZ0400I1,$QZ0400I2,$QZ0400I3,$QZ0400J,$QZ0400J1,$QZ0400J2,$QZ0400J3,$QZ0400K,$QZ0400K1,$QZ0400K2,$QZ0400K3,$QZ0400L,$QZ0400L1,$QZ0400L2,$QZ0400L3,$QZ0500A,$QZ0500B_1,$QZ0500B_2,$QZ0500B_3,$QZ0500B_4,$QZ0500B_5,$QZ0500B_6,$QZ0500B_7,$QZ0500B_8);
	
	}elseif($j==42){  /*=============== 42 ===============*/

 	  if($A0050!="3"){
	  $QS0170A ="";
	  $QS0170B ="";
	  $QS0170C ="";
	  $QS0170D ="";
	  $QS0170E ="";
	  $QS0170F ="";
	  $QS0170G ="";
	  $QS0170H ="";
	  $QS0170Z ="";
	  $QS0171A ="";
	  $QS0171B ="";
	  $QS0172A ="";
	  $QS0172B ="";
	  $QS0172C ="";
	  $QS0172D ="";
	  $QS0172E ="";
	  $QS0172F ="";
	  $QS0172G ="";
	  }
	  $page42Qfiller = array($_SESSION['ncareID_lwj']);
	  $page42Qfiller = array_unique($page42Qfiller);
	  sort($page42Qfiller);
	  for($i=0;$i<count($page42Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page42Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page42QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page42QfillerFilter = explode(";",$page42QfillerFilter);
	  $page42QfillerFilter = array_unique($page42QfillerFilter);
	  $page42Qfiller = array_diff($page42QfillerFilter, array(null,'null','',' '));
	  sort($page42Qfiller);
	  for($i=0;$i<count($page42Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page42Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  $k = array("QS0170A","QS0170B","QS0170C","QS0170D","QS0170E","QS0170F","QS0170G","QS0170H","QS0170Z","QS0171A","QS0171B","QS0172A","QS0172B","QS0172C","QS0172D","QS0172E","QS0172F","QS0172G");
	  $v = array($QS0170A,$QS0170B,$QS0170C,$QS0170D,$QS0170E,$QS0170F,$QS0170G,$QS0170H,$QS0170Z,$QS0171A,$QS0171B,$QS0172A,$QS0172B,$QS0172C,$QS0172D,$QS0172E,$QS0172F,$QS0172G);
	
	}elseif($j==43){  /*=============== 43 ===============*/

 	  if($A0050!="3"){
	  $QS0173 ="";
	  $QS6230 ="";
	  $QS6232 ="";
	  $QS6234 ="";
	  $QS6236 ="";
	  $QS2060A ="";
	  $QS2060B ="";
	  $QS2060C ="";
	  $QS2060D ="";
	  $QS2060E ="";
	  $QS2060Z ="";
	  }
	  $page43Qfiller = array($_SESSION['ncareID_lwj']);
	  $page43Qfiller = array_unique($page43Qfiller);
	  sort($page43Qfiller);
	  for($i=0;$i<count($page43Qfiller);$i++){
		  $sql = "SELECT `userID` FROM `userinfo` WHERE `userID`='".$page43Qfiller[$i]."'";
		  $db19 = new DB2;
		  $db19->query($sql);
		  $r19 = $db19->fetch_assoc();
		  if ($db19->num_rows()>0) {
			  foreach ($r19 as $k=>$v) {
				  $page43QfillerFilter .= $v.';';
		      }
		  }
	  }
	  $page43QfillerFilter = explode(";",$page43QfillerFilter);
	  $page43QfillerFilter = array_unique($page43QfillerFilter);
	  $page43Qfiller = array_diff($page43QfillerFilter, array(null,'null','',' '));
	  sort($page43Qfiller);
	  for($i=0;$i<count($page43Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page43Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  $k = array("QS0173","QS6230","QS6232","QS6234","QS6236","QS2060A","QS2060B","QS2060C","QS2060D","QS2060E","QS2060Z");
	  $v = array($QS0173,$QS6230,$QS6232,$QS6234,$QS6236,$QS2060A,$QS2060B,$QS2060C,$QS2060D,$QS2060E,$QS2060Z);
	}else{
	  $formID ='99';
	  $page99Qfiller = $_SESSION['ncareID_lwj'];
	  $database_Qfiller = $page99Qfiller;
	  /*
	  $page99Qfiller = array($_SESSION['ncareID_lwj']);
	  $page99Qfiller = array_unique($page99Qfiller);
	  sort($page99Qfiller);
	  for($i=0;$i<count($page99Qfiller);$i++){
		  ${"database_page".$j."Qfiller"} .= $page99Qfiller[$i].'&';
		  $database_Qfiller = ${"database_page".$j."Qfiller"};
	  }
	  */
	  $k = NULL;
	  $v = NULL;
	}
	
	$formID = mysql_escape_string($_GET['mod']).$formID;
    /*============================ 資料擷取、判斷 END ============================*/
    /*============================ 儲存資料 START ============================*/
	if ($_POST['date']==NULL) {
		$filldate = date("Y-m-d");
		$db1 = new DB;
		$db1->query("SELECT * FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
	} else {
		$filldate = str_replace('/','',$_POST['date']);
		$db1 = new DB;
		$db1->query("SELECT * FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
	}
	if ($db1->num_rows()==0) {
		//New record
		$db2a = new DB;
		$db2a->query("INSERT INTO `".$formID."` (`no`, `HospNo`, `date`,`Qfiller`) VALUES ('', '".$HospNo."', '".$filldate."','".$database_Qfiller."');");
        $db2b = new DB;
		$db2b->query("SELECT `no` FROM `".$formID."` WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
		$r2b = $db2b->fetch_assoc();
		for($i=0;$i<count($k);$i++){
		  //個別表單資料
		  if ($k[$i]=="QA0500A_1" || $k[$i]=="QA0500A_2" || $k[$i]=="QA0500A_3" || $k[$i]=="QA0500A_4" || $k[$i]=="QA0500A_5" || $k[$i]=="QA0500A_6" || $k[$i]=="QA0500A_7" || $k[$i]=="QA0500A_8" || $k[$i]=="QA0500A_9" || $k[$i]=="QA0500A_10" || $k[$i]=="QA0500A_11" || $k[$i]=="QA0500A_12" || $k[$i]=="QA0500B" || $k[$i]=="QA0500C_1" || $k[$i]=="QA0500C_2" || $k[$i]=="QA0500C_3" || $k[$i]=="QA0500C_4" || $k[$i]=="QA0500C_5" || $k[$i]=="QA0500C_6" || $k[$i]=="QA0500C_7" || $k[$i]=="QA0500C_8" || $k[$i]=="QA0500C_9" || $k[$i]=="QA0500C_10" || $k[$i]=="QA0500C_11" || $k[$i]=="QA0500C_12" || $k[$i]=="QA0500C_13" || $k[$i]=="QA0500C_14" || $k[$i]=="QA0500C_15" || $k[$i]=="QA0500C_16" || $k[$i]=="QA0500C_17" || $k[$i]=="QA0500C_18" || $k[$i]=="QA0500D_1" || $k[$i]=="QA0500D_2" || $k[$i]=="QA0500D_3" || $k[$i]=="QA0600A_1" || $k[$i]=="QA0600A_2" || $k[$i]=="QA0600A_3" || $k[$i]=="QA0600A_4" || $k[$i]=="QA0600A_5" || $k[$i]=="QA0600A_6" || $k[$i]=="QA0600A_7" || $k[$i]=="QA0600A_8" || $k[$i]=="QA0600A_9" || $k[$i]=="QA0600B_1" || $k[$i]=="QA0600B_2" || $k[$i]=="QA0600B_3" || $k[$i]=="QA0600B_4" || $k[$i]=="QA0600B_5" || $k[$i]=="QA0600B_6" || $k[$i]=="QA0600B_7" || $k[$i]=="QA0600B_8" || $k[$i]=="QA0600B_9" || $k[$i]=="QA0600B_10" || $k[$i]=="QA0600B_11" || $k[$i]=="QA0600B_12" || $k[$i]=="QA0700_1" || $k[$i]=="QA0700_2" || $k[$i]=="QA0700_3" || $k[$i]=="QA0700_4" || $k[$i]=="QA0700_5" || $k[$i]=="QA0700_6" || $k[$i]=="QA0700_7" || $k[$i]=="QA0700_8" || $k[$i]=="QA0700_9" || $k[$i]=="QA0700_10" || $k[$i]=="QA0700_11" || $k[$i]=="QA0700_12" || $k[$i]=="QA1300A_1" || $k[$i]=="QA1300A_2" || $k[$i]=="QA1300A_3" || $k[$i]=="QA1300A_4" || $k[$i]=="QA1300A_5" || $k[$i]=="QA1300A_6" || $k[$i]=="QA1300A_7" || $k[$i]=="QA1300A_8" || $k[$i]=="QA1300A_9" || $k[$i]=="QA1300A_10" || $k[$i]=="QA1300A_11" || $k[$i]=="QA1300A_12" || $k[$i]=="QX0200A_1" || $k[$i]=="QX0200A_2" || $k[$i]=="QX0200A_3" || $k[$i]=="QX0200A_4" || $k[$i]=="QX0200A_5" || $k[$i]=="QX0200A_6" || $k[$i]=="QX0200A_7" || $k[$i]=="QX0200A_8" || $k[$i]=="QX0200A_9" || $k[$i]=="QX0200A_10" || $k[$i]=="QX0200A_11" || $k[$i]=="QX0200A_12" || $k[$i]=="QX0200C_1" || $k[$i]=="QX0200C_2" || $k[$i]=="QX0200C_3" || $k[$i]=="QX0200C_4" || $k[$i]=="QX0200C_5" || $k[$i]=="QX0200C_6" || $k[$i]=="QX0200C_7" || $k[$i]=="QX0200C_8" || $k[$i]=="QX0200C_9" || $k[$i]=="QX0200C_10" || $k[$i]=="QX0200C_11" || $k[$i]=="QX0200C_12" || $k[$i]=="QX0200C_13" || $k[$i]=="QX0200C_14" || $k[$i]=="QX0200C_15" || $k[$i]=="QX0200C_16" || $k[$i]=="QX0200C_17" || $k[$i]=="QX0200C_18" || $k[$i]=="QX0500_1" || $k[$i]=="QX0500_2" || $k[$i]=="QX0500_3" || $k[$i]=="QX0500_4" || $k[$i]=="QX0500_5" || $k[$i]=="QX0500_6" || $k[$i]=="QX0500_7" || $k[$i]=="QX0500_8" || $k[$i]=="QX0500_9") {
		    /*== 加 START ==*/
	  		  $rsa = new lwj('lwj/lwj');
	  		  $part = ceil(strlen($v[$i])/117);
	  		  if($part>1){
        		  $datapart = str_split($v[$i], 117);
        		  for($m=0;$m<$part;$m++){
	      		      $puepart = $rsa->pubEncrypt($datapart[$m]);
	      		      $v[$i] = $v[$i].$puepart." ";
        		  }
	  		  }else{
		  		  $v[$i] = $rsa->pubEncrypt($v[$i]);
	  		  }
			/*== 加 END ==*/
		  }
		  $db2c = new DB;
		  $db2c->query("UPDATE `".$formID."` SET `".mysql_escape_string($k[$i])."`='".mysql_escape_string($v[$i])."' WHERE `no`='".$r2b['no']."'");
        }
		$alert="New record";
    } else {
		$r1 = $db1->fetch_assoc();
		$daylastfill = calcperiod($r1['date'],$filldate);
		if ($arrFormFreq[$formID]==99 || $arrFormFreq[$formID] == -1 || $r1['date']==$filldate) {
			//更新原本紀錄 (無需定期更新資料) update original record(no need to update annually)
			if ($r1['Qfiller']!="" && $_SESSION['ncareLevel_lwj']<4) {
				echo '<script>alert("權限不足！請通知原輸入人員修改或選擇其他日期以另存新一筆資料！");history.go(-1);</script>';
			} else {
			  //個別表單資料
			    $db2c = new DB;
			    for($i=0;$i<count($k);$i++){
			      $db2c->query("UPDATE `".$formID."` SET `".mysql_escape_string($k[$i])."`='".mysql_escape_string($v[$i])."' WHERE `HospNo`='".$HospNo."' AND `date`='".$r1['date']."'");
			    }
				$alert="Update original record (No need to update annually)";
			  }
		} elseif ($daylastfill>=$arrFormFreq[$_POST['formID']]) {
			//比對過日期，新紀錄 confirmed date,new record
			$db2a = new DB;
			$db2a->query("INSERT INTO `".$formID."` (`HospNo`, `date`,`Qfiller`) VALUES ('".$HospNo."', '".$filldate."','".$database_Qfiller."');");	
				//個別表單資料
					$db2c = new DB;
					for($i=0;$i<count($k);$i++){
					$db2c->query("UPDATE `".$formID."` SET `".mysql_escape_string($k[$i])."`='".mysql_escape_string($v[$i])."' WHERE `HospNo`='".$HospNo."' AND `date`='".$filldate."'");
					}
					$alert="confirmed date,new record";
		} else {
			//更新原本紀錄  update original record
			if ($r1['Qfiller']!="" && $_SESSION['ncareLevel_lwj']<4) {
				echo '<script>alert("權限不足！請通知原輸入人員修改或選擇其他日期以另存新一筆資料！Lack of permission level!Please inform the person who type the original data to make the change or select another date  to save as a new data");history.go(-1);</script>';
			} else {
					//個別表單資料
						$db2c = new DB;
						for($i=0;$i<count($k);$i++){
						$db2c->query("UPDATE `".$formID."` SET `".mysql_escape_string($k[$i])."`='".mysql_escape_string($v[$i])."' WHERE `HospNo`='".$HospNo."' AND `date`='".$r1['date']."'");
						}
						$alert="Update original record";
			}
		}
	}
	/*============================ 儲存資料 END ============================*/
  }
?>
<script>
alert("<?php echo $alert; ?>\n( MDS: <?php echo formatdate_Ymd_Slash($filldate);?> )")
document.location.href="index.php?mod=mdsform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=99&date=<?php echo formatdate_Ymd($filldate);?>";
</script>