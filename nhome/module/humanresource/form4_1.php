<?php
if ($_GET['empid']!="") {
	$foreignID = (int) @$_GET['empid'];
} else {
	$foreignID = "";
}

if (isset($_POST['submit'])) {
	//讀寫資料
	$birthdate = str_replace("/","",$_POST['DOB']);
	$startdate1 = str_replace("/","",$_POST['Startdate1']);
	$startdate2 = str_replace("/","",$_POST['Startdate2']);
	$startdate3 = str_replace("/","",$_POST['Startdate3']);
	$startdate4 = str_replace("/","",$_POST['Startdate4']);
	$startdate5 = str_replace("/","",$_POST['Startdate5']);
	$enddate1 = str_replace("/","",$_POST['Enddate1']);
	$enddate2 = str_replace("/","",$_POST['Enddate2']);
	$enddate3 = str_replace("/","",$_POST['Enddate3']);
	$enddate4 = str_replace("/","",$_POST['Enddate4']);
	$enddate5 = str_replace("/","",$_POST['Enddate5']);
	
	$birthdate = str_replace("_","",$birthdate);
	$startdate1 = str_replace("_","",$startdate1);
	$startdate2 = str_replace("_","",$startdate2);
	$startdate3 = str_replace("_","",$startdate3);
	$startdate4 = str_replace("_","",$startdate4);
	$startdate5 = str_replace("_","",$startdate5);
	$enddate1 = str_replace("_","",$enddate1);
	$enddate2 = str_replace("_","",$enddate2);
	$enddate3 = str_replace("_","",$enddate3);
	$enddate4 = str_replace("_","",$enddate4);
	$enddate5 = str_replace("_","",$enddate5);
	
	$startdate1 = str_replace("---","",$startdate1);
	$startdate2 = str_replace("---","",$startdate2);
	$startdate3 = str_replace("---","",$startdate3);
	$startdate4 = str_replace("---","",$startdate4);
	$startdate5 = str_replace("---","",$startdate5);
	$enddate1 = str_replace("---","",$enddate1);
	$enddate2 = str_replace("---","",$enddate2);
	$enddate3 = str_replace("---","",$enddate3);
	$enddate4 = str_replace("---","",$enddate4);
	$enddate5 = str_replace("---","",$enddate5);
	
	if ($_POST['foreignID']==NULL) {
		//新員工
		/*== 加 START ==*/
		$LWJArray = array('PassportNo','ResidentNo','ResidentCardNo');
		$LWJdataArray = array($_POST['FPA_PassportNo'],$_POST['ResidentNo'],$_POST['FPA_ResidentCardNo']);
		for($z=0;$z<count($LWJdataArray);$z++){
	  	$rsa = new lwj('lwj/lwj');
	  	$part = ceil(strlen($LWJdataArray[$z])/117);
	  	if($part>1){
        	$datapart = str_split($LWJdataArray[$z], 117);
        	for($m=0;$m<$part;$m++){
	      		$puepart = $rsa->pubEncrypt($datapart[$m]);
	      		${$LWJArray[$z]} = ${$LWJArray[$z]}.$puepart." ";
        	}
	  	}else{
		  	${$LWJArray[$z]} = $rsa->pubEncrypt($LWJdataArray[$z]);
	  	}
		}
		/*== 加 END ==*/
		$db = new DB;
		$db->query("INSERT INTO `foreignemployer` VALUES ('', '".mysql_escape_string($_POST['eName'])."', '".mysql_escape_string($_POST['eNickname'])."', '".mysql_escape_string($_POST['cNickname'])."', '".mysql_escape_string($_POST['Gender_1'])."', '".mysql_escape_string($_POST['Gender_2'])."', '".mysql_escape_string($birthdate)."', '".mysql_escape_string($PassportNo)."', '".mysql_escape_string($ResidentNo)."', '".mysql_escape_string($startdate1)."', '".mysql_escape_string($startdate2)."', '".mysql_escape_string($startdate3)."', '".mysql_escape_string($startdate4)."', '".mysql_escape_string($startdate5)."', '".mysql_escape_string($enddate1)."', '".mysql_escape_string($enddate2)."', '".mysql_escape_string($enddate3)."', '".mysql_escape_string($enddate4)."', '".mysql_escape_string($enddate5)."', '".mysql_escape_string($_POST['position'])."', '".mysql_escape_string($_POST['account'])."', '".mysql_escape_string($_POST['rfidno'])."')");
		$db1 = new DB;
		$db1->query("SELECT LAST_INSERT_ID()");
		$r1 = $db1->fetch_assoc();
		$tmpID = $r1['LAST_INSERT_ID()'];
		$db2 = new DB;
		$db2->query("INSERT INTO `shift_member` VALUES ('".$r1['LAST_INSERT_ID()']."', '2', '', 0, '1', 0)");
		$db3 = new DB;
		$db3->query("INSERT INTO `foreign_personal_approval` VALUES (
		'".$r1['LAST_INSERT_ID()']."', 
		'',
		'".mysql_escape_string($_POST['FPA_AppID'])."', 
		'".mysql_escape_string($_POST['FPA_AppDate'])."', 
		'".mysql_escape_string($_POST['FPA_StayExtDate'])."', 
		'".mysql_escape_string($_POST['FPA_StayExtMemo'])."', 
		'".mysql_escape_string($_POST['FPA_StayExtAppDate'])."', 
		'".mysql_escape_string($_POST['FPA_InDate'])."', 
		'".mysql_escape_string($PassportNo)."', 
		'".mysql_escape_string($_POST['FPA_PassportExpireDate'])."', 
		'".mysql_escape_string($ResidentCardNo)."', 
		'".mysql_escape_string($_POST['FPA_ResidentCardDate'])."', 
		'".mysql_escape_string($_POST['FPA_ResidentCardAppDate'])."', 
		'".mysql_escape_string($_POST['FPA_ResidentCardMemo'])."', 
		'".mysql_escape_string($_POST['FPA_ResidentCardDoneDate'])."', 
		'".mysql_escape_string($_POST['FPA_PhyExamDate1'])."', 
		'".mysql_escape_string($_POST['FPA_PhyExamDate2'])."', 
		'".mysql_escape_string($_POST['FPA_CheckDate'])."');");
	} else {
		//更新員工資料
		/*== 加 START ==*/
		$LWJArray = array('PassportNo','ResidentNo','ResidentCardNo');
		$LWJdataArray = array($_POST['FPA_PassportNo'],$_POST['ResidentNo'],$_POST['FPA_ResidentCardNo']);
		for($z=0;$z<count($LWJdataArray);$z++){
	  	$rsa = new lwj('lwj/lwj');
	  	$part = ceil(strlen($LWJdataArray[$z])/117);
	  	if($part>1){
        	$datapart = str_split($LWJdataArray[$z], 117);
        	for($m=0;$m<$part;$m++){
	      		$puepart = $rsa->pubEncrypt($datapart[$m]);
	      		${$LWJArray[$z]} = ${$LWJArray[$z]}.$puepart." ";
        	}
	  	}else{
		  	${$LWJArray[$z]} = $rsa->pubEncrypt($LWJdataArray[$z]);
	  	}
		}
		/*== 加 END ==*/
		$db = new DB;
		$db->query("UPDATE `foreignemployer` SET `eName`='".mysql_escape_string($_POST['eName'])."', `eNickname`='".mysql_escape_string($_POST['eNickname'])."', `cNickname`='".mysql_escape_string($_POST['cNickname'])."', `Gender_1`='".mysql_escape_string($_POST['Gender_1'])."', `Gender_2`='".mysql_escape_string($_POST['Gender_2'])."', `DOB`='".mysql_escape_string($birthdate)."', `PassportNo`='".mysql_escape_string($PassportNo)."', `ResidentNo`='".mysql_escape_string($ResidentNo)."', `Startdate1`='".mysql_escape_string($startdate1)."', `Startdate2`='".mysql_escape_string($startdate2)."', `Startdate3`='".mysql_escape_string($startdate3)."', `Startdate4`='".mysql_escape_string($startdate4)."', `Startdate5`='".mysql_escape_string($startdate5)."', `Enddate1`='".mysql_escape_string($enddate1)."', `Enddate2`='".mysql_escape_string($enddate2)."', `Enddate3`='".mysql_escape_string($enddate3)."', `Enddate4`='".mysql_escape_string($enddate4)."', `Enddate5`='".mysql_escape_string($enddate5)."', `position`='".mysql_escape_string($_POST['position'])."', `account`='".mysql_escape_string($_POST['account'])."', `rfidno`='".mysql_escape_string($_POST['rfidno'])."' WHERE `foreignID`='".mysql_escape_string($_POST['foreignID'])."'");
		if ($_POST['Enddate5']!="" && $_POST['Startdate5']!="") {
			$db2 = new DB;
			$db2->query("UPDATE `shift_member` SET `available`='0' WHERE `EmpID`='".mysql_escape_string($_POST['foreignID'])."' AND `EmpGroup`='2'");
		} elseif ($_POST['Enddate4']!="" && $_POST['Startdate4']!="") {
			$db2 = new DB;
			$db2->query("UPDATE `shift_member` SET `available`='0' WHERE `EmpID`='".mysql_escape_string($_POST['foreignID'])."' AND `EmpGroup`='2'");
		} elseif ($_POST['Enddate3']!="" && $_POST['Startdate3']!="") {
			$db2 = new DB;
			$db2->query("UPDATE `shift_member` SET `available`='0' WHERE `EmpID`='".mysql_escape_string($_POST['foreignID'])."' AND `EmpGroup`='2'");
		} elseif ($_POST['Enddate2']!="" && $_POST['Startdate2']!="") {
			$db2 = new DB;
			$db2->query("UPDATE `shift_member` SET `available`='0' WHERE `EmpID`='".mysql_escape_string($_POST['foreignID'])."' AND `EmpGroup`='2'");
		} elseif ($_POST['Enddate1']!="" && $_POST['Startdate1']!="") {
			$db2 = new DB;
			$db2->query("UPDATE `shift_member` SET `available`='0' WHERE `EmpID`='".mysql_escape_string($_POST['foreignID'])."' AND `EmpGroup`='2'");
		} else {
			$db2 = new DB;
			$db2->query("UPDATE `shift_member` SET `available`='1' WHERE `EmpID`='".mysql_escape_string($_POST['foreignID'])."' AND `EmpGroup`='2'");
		}
		$db3 = new DB;
		$db3->query("UPDATE `foreign_personal_approval` SET `AppID`='".mysql_escape_string($_POST['FPA_AppID'])."', `AppDate`='".mysql_escape_string($_POST['FPA_AppDate'])."', `StayExtDate`='".mysql_escape_string($_POST['FPA_StayExtDate'])."', `StayExtMemo`='".mysql_escape_string($_POST['FPA_StayExtMemo'])."', `StayExtAppDate`='".mysql_escape_string($_POST['FPA_StayExtAppDate'])."', `InDate`='".mysql_escape_string($_POST['FPA_InDate'])."', `PassportNo`='".mysql_escape_string($PassportNo)."', `PassportExpireDate`='".mysql_escape_string($_POST['FPA_PassportExpireDate'])."', `ResidentCardNo`='".mysql_escape_string($ResidentCardNo)."', `ResidentCardDate`='".mysql_escape_string($_POST['FPA_ResidentCardDate'])."', `ResidentCardAppDate`='".mysql_escape_string($_POST['FPA_ResidentCardAppDate'])."', `ResidentCardMemo`='".mysql_escape_string($_POST['FPA_ResidentCardMemo'])."', `ResidentCardDoneDate`='".mysql_escape_string($_POST['FPA_ResidentCardDoneDate'])."', `PhyExamDate1`='".mysql_escape_string($_POST['FPA_PhyExamDate1'])."', `PhyExamDate2`='".mysql_escape_string($_POST['FPA_PhyExamDate2'])."', `CheckDate`='".mysql_escape_string($_POST['FPA_CheckDate'])."' WHERE `foreignID`='".mysql_escape_string($_POST['foreignID'])."'");
		$tmpID = $_POST['foreignID'];		
	}

		//Pre-employment training Start
		foreach ($_POST as $k=>$v){
			if(substr($k,0,12)=="trainingform"){
				$arrTraining = explode("_",$k);
				if($v==1){
					if ($training!="") { $training .= ';'; }
					$training .= $arrTraining[1];
				}
			}
		}
		$db1 = new DB;
		$db1->query("SELECT * FROM `employer_training` WHERE `EmpID`='".$tmpID."' AND `EmpGroup`='2'");
		$rs = $db1->fetch_assoc();
		if($db1->num_rows() > 0){
			$db2 = new DB;
			$db2->query("UPDATE `employer_training` SET `trainingformID`='".$training."' WHERE `trainingID`='".$rs['trainingID']."'");
		}else{
			$db2 = new DB;
			$db2->query("INSERT INTO `employer_training` VALUES ('','".$tmpID."', '2','".$training."')");
		}
		//Pre-employment training End
	
	if ($_POST['account']!="" && $_POST['rfidno']!="") {
		$db4 = new DB2;
		$db4->query("UPDATE `userinfo` SET `rfidno`='".mysql_escape_string($_POST['rfidno'])."' WHERE `userID`='".mysql_escape_string($_POST['account'])."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	}
	if ($_POST['account']!="") {
		$db4 = new DB2;
		$db4->query("UPDATE `userinfo` SET `EmpID`='".mysql_escape_string($_POST['foreignID'])."_2' WHERE `userID`='".mysql_escape_string($_POST['account'])."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	}
	echo "<script>window.location.href='index.php?mod=humanresource&func=formview&id=4_1&empid=".$tmpID."'</script>";
} else {
	//Edit/新增畫面
$db = new DB;
$db->query("SELECT * FROM `foreignemployer` WHERE `foreignID`='".mysql_escape_string($foreignID)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
}
if ($Birth=="") { $Birth = date(Ymd); }
if ($StartDate=="") { $StartDate = date(Ymd); }
if ($rfidno=="") {
	$rfid_style = "block";
	$rfid2_style = "none";
} else {
	$rfid_style = "none";
	$rfid2_style = "block";
}

$db = new DB;
$db->query("SELECT * FROM `foreign_personal_approval` WHERE `foreignID`='".mysql_escape_string($foreignID)."'");
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		${'FPA_'.$k} = $v;
	}
}
		/*== 解 START ==*/
		$LWJArray = array('FPA_PassportNo','ResidentNo','FPA_ResidentCardNo');
		$LWJdataArray = array($FPA_PassportNo,$ResidentNo,$FPA_ResidentCardNo);
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
?>
<div class="moduleNoTab">
<form  method="post" action="index.php?mod=humanresource&func=formview&id=4_1">
<h3>Foreign staff profile maintain</h3>
<table style="text-align:left;">
  <tr>
    <?php if (@$_GET['empid']!=NULL) { ?>
    <td width="120" class="title">Staff ID#</td>
    <td><input type="text" name="foreignID" id="foreignID" size="12" value="<?php echo $foreignID; ?>" readonly ></td>
    <?php } ?>
    <td width="120" class="title">Employee name</td>
    <td <?php if (@$_GET['empid']==NULL) { echo 'colspan="3"'; } ?>><input type="text" name="eName" id="eName" size="30" value="<?php echo $eName; ?>" ></td>
    <td class="title">Job title</td>
    <td><input type="text" name="position" id="position" size="12" value="<?php echo $position; ?>"></td>
  </tr>
  <tr>
    <td width="120" class="title">Nickname</td>
    <td><input type="text" name="eNickname" id="eNickname" size="12" value="<?php echo $eNickname; ?>" ></td>
    <td width="120" class="title">Preffered name</td>
    <td><input type="text" name="cNickname" id="cNickname" size="30" value="<?php echo $cNickname; ?>" ></td>
    <td width="120" class="title">Gender</td>
    <td><?php echo draw_option("Gender","Male;Female","m","single",$Gender,false,5); ?></td>
  </tr>
  <tr>
    <td class="title">Social Security number</td>
    <td><input type="text" name="ResidentNo" id="ResidentNo" size="14" value="<?php echo $ResidentNo; ?>"></td>
    <td class="title">DOB</td>
    <td colspan="3"><script> $(function() { $( "#DOB").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="DOB" id="DOB" value="<?php echo formatdate($DOB); ?>" size="12" ></td>
  </tr>
  <tr>
    <td class="title">Link to account</td>
    <td>
	<select name="account" id="account">
      <option></option>
      <?php
	  $db3 = new DB2;
	  $db3->query("SELECT * FROM `userinfo` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."' AND `active`='1'");
	  for ($i=0;$i<$db3->num_rows();$i++) {
		  $r3 = $db3->fetch_assoc();
		  $db3a = new DB;
		  $db3a->query("SELECT * FROM `employer` WHERE `account`='".$r3['userID']."'");
		  $db3b = new DB;
		  $db3b->query("SELECT * FROM `foreignemployer` WHERE `account`='".$r3['userID']."'");
		  if ($db3a->num_rows()==0 && $db3b->num_rows()==0 || ($account==$r3['userID'])) {
		  	echo '<option value="'.$r3['userID'].'" '.($account==$r3['userID']?"selected":"").'>'.$r3['userID'].' '.$r3['name'].'</option>';
		  }
	  }
	  ?>
    </select>
    </td>
    <td class="title">ID card setup</td>
    <td colspan="3"><input type="button" value="Setting" id="rfid" style="display:<?php echo $rfid_style; ?>;" onclick="rfid_click();"><input type="button" value="Off setting" id="rfid2" style="display:<?php echo $rfid2_style; ?>;" onclick="rfid2_click();"><input type="hidden" value="<?php echo $rfidno; ?>" name="rfidno" id="rfidno"></td>
  </tr>
  <tr>
    <td class="title">Immigration introduction letter</td>
    <td><input type="text" name="FPA_AppID" id="FPA_AppID" size="14" value="<?php echo $FPA_AppID; ?>"></td>
    <td class="title">Immigration introduction letter date</td>
    <td colspan="3"><script> $(function() { $( "#FPA_AppDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_AppDate" id="FPA_AppDate" size="12" value="<?php echo str_replace("-","/",$FPA_PassportExpireDate); ?>"></td>
  </tr>
  <tr>
    <td class="title">Passport number</td>
    <td><input type="text" name="FPA_PassportNo" id="FPA_PassportNo" size="14" value="<?php echo $FPA_PassportNo; ?>"></td>
    <td class="title">Passport expiry date</td>
    <td colspan="3"><script> $(function() { $( "#FPA_PassportExpireDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_PassportExpireDate" id="FPA_PassportExpireDate" size="12" value="<?php echo str_replace("-","/",$FPA_PassportExpireDate); ?>"></td>
  </tr>
  <tr>
    <td class="title">Extension of residency</td>
    <td><script> $(function() { $( "#FPA_StayExtDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_StayExtDate" id="FPA_StayExtDate" size="12" value="<?php echo str_replace("-","/",$FPA_StayExtDate); ?>"></td>
    <td class="title">Residency memo</td>
    <td><input type="text" name="FPA_StayExtMemo" id="FPA_StayExtMemo" size="24" value="<?php echo $FPA_StayExtMemo; ?>"></td>
    <td class="title">Process date</td>
    <td><script> $(function() { $( "#FPA_StayExtAppDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_StayExtAppDate" id="FPA_StayExtAppDate" size="12" value="<?php echo str_replace("-","/",$FPA_StayExtAppDate); ?>"></td>
  </tr>
  <tr>
    <td class="title">Residence permit number</td>
    <td><input type="text" name="FPA_ResidentCardNo" id="FPA_ResidentCardNo" size="12" value="<?php echo $FPA_ResidentCardNo; ?>"></td>
    <td class="title">Residence permit memo</td>
    <td colspan="5"><input type="text" name="FPA_ResidentCardMemo" id="FPA_ResidentCardMemo" size="24" value="<?php echo $FPA_ResidentCardMemo; ?>"></td>
  </tr>
  <tr>
    <td class="title">Residence permit expiration date</td>
    <td><script> $(function() { $( "#FPA_ResidentCardDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_ResidentCardDate" id="FPA_ResidentCardDate" size="12" value="<?php echo str_replace("-","/",$FPA_ResidentCardDate); ?>"></td>
    <td class="title">Residence permit apply extension date reminder</td>
    <td><script> $(function() { $( "#FPA_ResidentCardAppDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_ResidentCardAppDate" id="FPA_ResidentCardAppDate" size="12" value="<?php echo str_replace("-","/",$FPA_ResidentCardAppDate); ?>"></td>
    <td class="title">Residence permit apply extension date</td>
    <td><script> $(function() { $( "#FPA_ResidentCardDoneDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_ResidentCardDoneDate" id="FPA_ResidentCardDoneDate" size="12" value="<?php echo str_replace("-","/",$FPA_ResidentCardDoneDate); ?>"></td>
  </tr>
  <tr>
    <td class="title">Physical examination date</td>
    <td><script> $(function() { $( "#FPA_PhyExamDate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_PhyExamDate1" id="FPA_PhyExamDate1" size="12" value="<?php echo str_replace("-","/",$FPA_PhyExamDate1); ?>"></td>
    <td class="title">Physical examination reminder date</td>
    <td><script> $(function() { $( "#FPA_PhyExamDate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_PhyExamDate2" id="FPA_PhyExamDate2" size="12" value="<?php echo str_replace("-","/",$FPA_PhyExamDate2); ?>"></td>
    <td class="title">Next physical examination date</td>
    <td><script> $(function() { $( "#FPA_CheckDate").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="FPA_CheckDate" id="FPA_CheckDate" size="12" value="<?php echo str_replace("-","/",$FPA_CheckDate); ?>"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title" width="120">Pre-employment training</td>
    <td style="padding:10px;">
    <?php
	//取得訓練表
	$db5 = new DB;
	$db5->query("SELECT `trainingname` FROM `training_form` ORDER BY `ord`");
	for ($i5=0;$i5<$db5->num_rows();$i5++){
		$r5 = $db5->fetch_assoc();
		if ($trainingname!="") { $trainingname .= ';'; }
		$trainingname .= $r5['trainingname'];
	}
	//設定人員要用的訓練表
	$db6 = new DB;
	$db6->query("SELECT `trainingformID` FROM `employer_training` WHERE `EmpID`='".$foreignID."' AND `EmpGroup`=2");
	$r6 = $db6->fetch_assoc();
	echo draw_checkbox_nobr("trainingformID","".$trainingname."",$r6['trainingformID'],"multi");
	//echo '<a href="?'.$r5['link'].'&EmpID='.$empid.'&EmpGroup=1" target="_blank">aaa</a>';
    ?><br>
    <?php if($r6['trainingformID']==""){?>
    <span class="title">＊Setup the training list first！！</span>
    <?php }else{?>
    <input type="button" value="Pre-employment training" onClick="window.open('index.php?mod=humanresource&func=formview&id=9&EmpID=<?php echo $foreignID;?>&EmpGroup=2&trainingform=<?php echo $r6['trainingformID'];?>');">
    <?php }?>
    </td>
  </tr>
</table>
<table width="100%">
  <tr class="title">
    <td align="center" width="4%"></td>
    <td align="center" width="43%">Date of reporting for duty</td>
    <td align="center" width="15%"></td>
    <td align="center" width="43%">Resignation date</td>
  </tr>
  <tr>
    <td align="center" class="title_s">1</td>
    <td align="center"><script> $(function() { $( "#Startdate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate1" id="Startdate1" value="<?php echo formatdate($Startdate1); ?>" size="12" ></td>
    <td align="center">~</td>
    <td align="center"><script> $(function() { $( "#Enddate1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate1" id="Enddate1" value="<?php echo formatdate($Enddate1); ?>" size="12" ></td>
  </tr>
  <tr>
    <td align="center" class="title_s">2</td>
    <td align="center"><script> $(function() { $( "#Startdate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate2" id="Startdate2" value="<?php echo formatdate($Startdate2); ?>" size="12" ></td>
    <td align="center">~</td>
    <td align="center"><script> $(function() { $( "#Enddate2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate2" id="Enddate2" value="<?php echo formatdate($Enddate2); ?>" size="12" ></td>
  </tr>
  <tr>
    <td align="center" class="title_s">3</td>
    <td align="center"><script> $(function() { $( "#Startdate3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate3" id="Startdate3" value="<?php echo formatdate($Startdate3); ?>" size="12" ></td>
    <td align="center">~</td>
    <td align="center"><script> $(function() { $( "#Enddate3").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate3" id="Enddate3" value="<?php echo formatdate($Enddate3); ?>" size="12" ></td>
  </tr>
  <tr>
    <td align="center" class="title_s">4</td>
    <td align="center"><script> $(function() { $( "#Startdate4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate4" id="Startdate4" value="<?php echo formatdate($Startdate4); ?>" size="12" ></td>
    <td align="center">~</td>
    <td align="center"><script> $(function() { $( "#Enddate4").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate4" id="Enddate4" value="<?php echo formatdate($Enddate4); ?>" size="12" ></td>
  </tr>
  <tr>
    <td align="center" class="title_s">5</td>
    <td align="center"><script> $(function() { $( "#Startdate5").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Startdate5" id="Startdate5" value="<?php echo formatdate($Startdate5); ?>" size="12" ></td>
    <td align="center">~</td>
    <td align="center"><script> $(function() { $( "#Enddate5").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Enddate5" id="Enddate5" value="<?php echo formatdate($Enddate5); ?>" size="12" ></td>
  </tr>
</table>
<br />
<center><input type="hidden" name="foreignID" id="foreignID" value="<?php echo $foreignID; ?>" /><input style="margin-top:20px;" type="submit" name="submit" id="submit" value="Save" /></center>
</div>
</form>
</div>
<?php
}
?>
<script>
function rfid2_click(){
	$.ajax({
		url: "class/removeRFID.php",
		type: "POST",
		data: {"account": $("#account").val(), "rfidno": $('#rfidno').val() },
		success: function(data) {
			$('#rfidno').val("");
			$('#rfid').show();
			$('#rfid2').hide();
		}
	});
}
function rfid_click(){
	$('#rfid-dialog').dialog({
		autoOpen: true,
		height: 140,
		width: 280,
		modal: true
	});	
	$( "#rfid-dialog" ).dialog( "open" );
}
function saveRFID(cardno) {
	if (cardno.length==10) {
		$.ajax({
			url: "class/checkExistRFID.php",
			type: "POST",
			data: {"cardno": cardno },
			success: function(data) {
				var arr = data.split(':');
				if (arr[0]=="OK") {
					$( "#rfid-dialog" ).dialog( "close" );
					$('#rfidno').val(cardno);
					$('#rfid2').show();
					$('#rfid').hide();
				} else if (arr[0]=="EXISTED") {
					alert('此卡號已設定予「'+arr[1]+'」，請先解除設定！');
				}
			}
		});
	}
}
</script>
<div id="rfid-dialog" title="ID card setup" class="dialog-form">
	<form onsubmit="return false;">
	<fieldset>
		<table>
			<tr>
				<td class="title">請感應卡片：</td>
				<td><input type="text" size="8" onchange="saveRFID(this.value);"></td>
			</tr>
		</table>
	</fieldset>
	</form>
</div>