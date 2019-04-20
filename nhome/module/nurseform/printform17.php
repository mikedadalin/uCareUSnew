<?php
$aID = mysql_escape_string($_GET['aid']);
$qID = mysql_escape_string($_GET['qid']);

$db = new DB;
$db->query("SELECT `patientID`,`HospNo`,`Birth` FROM `patient` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db1 = new DB;
	$db1->query("SELECT `bed`,`indate` FROM `inpatientinfo` WHERE `patientID`='".mysql_escape_string($_GET['pid'])."'");
	$r1 = $db1->fetch_assoc();
	$name = getPatientName($r['patientID']);
	$birth = formatdate($r['Birth']);
	$indate = formatdate($r1['indate']);
	$HospNo = $r['HospNo'];
	$bedID = $r1['bed'];
	$db2 = new DB;
	$db2->query("SELECT `Qdiag1`, `Qdiag2`, `Qdiag3`, `Qdiag4`, `Qdiag5`, `Qdiag6`, `Qdiag7`, `Qdiag8` FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
	$r2 = $db2->fetch_assoc();
	for ($j=1;$j<=8;$j++) { if ($r2['Qdiag'.$j]!=NULL) { $diagMsg .= $r2['Qdiag'.$j].', '; } }
	$diagMsg = substr($diagMsg, 0, strlen($diagMsg)-2);
}
$db_remind = new DB;
$db_remind->query("SELECT * FROM `reminder` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `remindDate` LIKE '".date('Y/m')."%' AND `active`='1'");
for ($i=0;$i<$db_remind->num_rows();$i++) {
	$reminder = $db_remind->fetch_assoc();
	if ($marqueetext != "") { $marqueetext .= ' ||| '; }
	$marqueetext .= '['.$reminder['remindDate'].'] '.$reminder['remindContent'];
}
?>
<div class="content-query">
<center><h3>藥物治療評估諮詢單</h3></center>
<table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
  <tr>
    <td class="title" width="70" style="border:none;">Bed #</td>
    <td width="90" style="border:none;"><?php echo $bedID; ?></td>   
    <td class="title" width="70" style="border:none;">Full name</td>
    <td width="90" style="border:none;"><?php echo $name; ?></td>
    <td class="title" width="70" style="border:none;">Care ID#</td>
    <td width="90" style="border:none;"><?php echo getHospNoDisplayByHospNo($HospNo); ?></td>
    <td class="title" width="70" style="border:none;">DOB</td>
    <td  style="border:none;"><?php echo $birth.' ('.checkgender(mysql_escape_string($_GET['pid'])).', '.calcage(str_replace('/','',$birth)).')'; ?></td>
  </tr>
  <tr>    
    <td class="title" style="border:none;">Diagnosis</td>
    <td style="border:none;" colspan="7"><?php echo $diagMsg; ?></td>
  </tr>
 <?php
	$db2 = new DB;
	$db2->query("SELECT * FROM `medicineq` WHERE `qID`='".$qID."'");
	for ($i3=0;$i3<$db2->num_rows();$i3++) {
	  $r2 = $db2->fetch_assoc();
	  //print_r($r1);
	  foreach ($r2 as $k=>$v) {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} .= $arrAnswer[1].';';
			}
		} else {
			${$k} = $v;
		}
	  }
  }
	?>
    <tr>
       <td colspan="8">Drug treatment issues:<br><?php echo draw_checkbox_2col("Q1","No indications;Have untreated disease(s);Contraindications or precautions;Formulations / dosage or frequency need to adjust;Drug-drug interaction;Repeated drug;Adverse drug reactions;Inappropriate treatment;Drugs health education;Drug expired(Please continue to fill)",$Q1,"multi"); ?><div style="margin-left:50px;"><?php echo draw_checkbox("Q2","Incorrect administration time (interval, before/after meal);Fail to comply with the special administration instructions (with food, flour, mix, open capsules, with one other solution);Drug dose to inappropriate (excessive or insufficient)",$Q2,"multi");?></div><?php echo draw_checkbox_2col("Q3","Other<input type=\"text\" id=\"Q3a\" name=\"Q3a\">",$Q3,"multi");?></td>
    </tr>
    <tr>
       <td colspan="8">獲得藥物治療問題的來源：<br><?php echo draw_checkbox_nobr("Q4","藥師親自到訪;Phone;e-mail;傳真",$Q4,"multi");?></td>

    </tr>
    <tr>
       <td colspan="8">問題敘述：(列出處方日期/目前使用藥物、住民健康方面反應)<br>藥物名稱：<?php echo $Qmedicine;?><br><?php echo $question;?></td>
    </tr>
    <tr>
       <td colspan="4">Nurses：<?php echo checkusername($Qfiller);?></td>
       <td colspan="4">Date:<?php echo date("Y-m-d",strtotime($date));?></td>
    </tr>
 <?php
	$db2 = new DB;
	$db2->query("SELECT * FROM `medicinea` WHERE `aID`='".$aID."'");
	for ($i3=0;$i3<$db2->num_rows();$i3++) {
	  $r2 = $db2->fetch_assoc();
	  //print_r($r1);
	  foreach ($r2 as $k=>$v) {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} .= $arrAnswer[1].';';
			}
		} else {
			${$k} = $v;
		}
	  }
  }
	?>
    <tr>
       <td colspan="8">藥師建議內容：<br><?php echo checkbox_result("Q1","會診醫師更改藥物劑量或頻次：".$Q1a.";會診醫師更改藥物或劑型：".$Q1b.";會診醫師停藥或改其他藥：".$Q1c.";進行藥物血中濃度監測：".$Q1d.";繼續維持目前用藥情形;住民服藥應注意事項：".$Q1e." ",$Q1,"multi"); ?></td>
    </tr>
    <tr>
       <td colspan="8">References:<br><?php echo checkbox_result("Q2","仿單;藥品手冊;參考書籍(或文獻)：",$Q2,"multi").'<br>'.$answer ;?></td>
    </tr>
    <tr>
       <td colspan="4">藥師：<?php echo checkusername($Qfiller);?></td>
       <td colspan="4">Date:<?php echo date("Y-m-d",strtotime($date));?></td>
    </tr>
</table>    
   
