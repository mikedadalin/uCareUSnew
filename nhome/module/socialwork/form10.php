<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform07` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform07` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
}
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				if ($v==1) {
					${$arrAnswer[0]} .= $arrAnswer[1].';';
				}
			} else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}

//護理表單2h欄位
$db3 = new DB;
$db3->query("SELECT * FROM `nurseform02h` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r3 = $db3->fetch_assoc();
if ($db3->num_rows()>0) { foreach ($r3 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02h_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02h_'.$k} = $v; } }  else { ${'nurseform02h_'.$k} = $v; } } }

//護理表單2h欄位
$db4 = new DB;
$db4->query("SELECT * FROM `nurseform02c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r4 = $db4->fetch_assoc();
if ($db4->num_rows()>0) { foreach ($r4 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform02c_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform02c_'.$k} = $v; } }  else { ${'nurseform02c_'.$k} = $v; } } }

//社工表單01欄位
$db5 = new DB;
$db5->query("SELECT * FROM `socialform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r5 = $db5->fetch_assoc();
if ($db5->num_rows()>0) { foreach ($r5 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'socialform01_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'socialform01_'.$k} = $v; } }  else { ${'socialform01_'.$k} = $v; } } }

//護理表單01欄位
$db6 = new DB;
$db6->query("SELECT * FROM `nurseform01` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1");
$r6 = $db6->fetch_assoc();
if ($db6->num_rows()>0) { foreach ($r6 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${'nurseform01_'.$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${'nurseform01_'.$k} = $v; } }  else { ${'nurseform01_'.$k} = $v; } } }
?>
<h3>社工組照會各組服務單</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%" border="0">
  <tr>
    <td class="title" width="100">照會組別</td>
    <td colspan="5"><?php echo draw_option("Q1","行政組;Nursing group;Rehabilitation group;Other","m","multi",$Q1,true,5); ?> <input type="text" name="Q1a" id="Q1a" size="15" value="<?php echo $Q1a; ?>"></td>
    </tr>
  <tr>
    <td class="title">照會類別</td>
    <td colspan="5"><?php echo draw_option("Q2","新住民;原有住民;Respite care/臨托住民;Other","m","multi",$Q2,true,5); ?> <input type="text" name="Q2a" id="Q2a" size="15" value="<?php echo $Q2a; ?>">    
    </td>
    </tr>
  <tr>
    <td class="title">Reason for notification</td>
    <td colspan="5"><?php echo draw_checkbox_2col("Q3","Adaptational counseling-New resident admission/bed relocate;Emotional problem(s);衛教需求;對照護/Rehabilitation/社交活動安排的期待;建議/申訴處理;Hospice care;Social welfare resource consulting;身心障礙證明申辦業務;開立乙種診斷證明書;家庭經濟問題;轉介安置問題;其他：：<input type=\"text\" name=\"Q3a\" id=\"Q3a\" value=\"".$Q3a."\" size=\"20\" >",$Q3,"multi"); ?>
    </td>
    </tr>
  <tr>
    <td class="title">照會原因說明</td>
  
    <td colspan="5"><textarea id="Q4" name="Q4"  cols="60" rows="6"></textarea></td>
    </tr>
  <tr>
    <td class="title">主責社工</td>
    <td> <input type="text" name="Qfiller" id="Qfiller" value="<?php echo $Qfiller; ?>" size="8"></td>
    <td class="title">主管批示</td>
    <td><input type="text" name="Q6" id="Q6" value="<?php echo $Q6; ?>" size="8"></td>
    <td class="title">Notify date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> </td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title"> 答覆</td>
    <td class="title"><?php echo draw_checkbox_nobr("Q7a","行政組",$Q7a,"multi"); ?></td>
    <td class="title"><?php echo draw_checkbox_nobr("Q7b","Nursing group",$Q7b,"multi"); ?></td>
    <td class="title"><?php echo draw_checkbox_nobr("Q7c","Rehabilitation group",$Q7c,"multi"); ?></td>
    </tr>
  <tr>
    <td class="title" width="100">Process處理情形</td>
    <td><textarea id="Q8a" name="Q8a" rows="6" readonly="readonly"></textarea></td>
    <td><textarea id="Q8b" name="Q8b" rows="6" readonly="readonly"></textarea></td>
    <td><textarea id="Q8c" name="Q8c" rows="6" readonly="readonly"></textarea></td>
    </tr>
  <tr>
    <td class="title">主責人員</td>
    <td><input type="text" name="Q9a" id="Q9a" value="<?php echo $Q9a; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q9b" id="Q9b" value="<?php echo $Q9b; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q9c" id="Q9c" value="<?php echo $Q9c; ?>" size="8" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="title">主管批示</td>
    <td><input type="text" name="Q10a" id="Q10a" value="<?php echo $Q10a; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q10b" id="Q10b" value="<?php echo $Q10b; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q10c" id="Q10c" value="<?php echo $Q10c; ?>" size="8" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="title">Reply date</td>
    <td><script> $(function() { $( "#date1a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date1a" id="date1a" value="<?php if ($date1a != NULL) { echo formatdate($date1a); } ?>" size="12" readonly="readonly" /></td>
    <td><script> $(function() { $( "#date1b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date1b" id="date1b" value="<?php if ($date1b != NULL) { echo formatdate($date1b); } ?>" size="12" readonly="readonly" /></td>
    <td><script> $(function() { $( "#date1c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date1c" id="date1c" value="<?php if ($date1c != NULL) { echo formatdate($date1c); } ?>" size="12" readonly="readonly" /></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td class="title">Notify</td>
    <td class="title"><?php echo draw_checkbox_nobr("Q11a","行政組",$Q11a,"multi"); ?></td>
    <td class="title"><?php echo draw_checkbox_nobr("Q11b","Nursing group",$Q11b,"multi"); ?></td>
    <td class="title"><?php echo draw_checkbox_nobr("Q11c","Rehabilitation group",$Q11c,"multi"); ?></td>
    </tr>
  <tr>
    <td class="title" width="100">照會情形</td>  
    <td>
    <?php echo checkbox_result("Q12a","已知悉處理情形，感謝照會;預計提供:",$Q12a,"multi"); ?>
    <textarea id="Q12b" name="Q12b" rows="6" readonly="readonly"></textarea>
    </td>
    <td>
    <?php echo checkbox_result("Q12c","已知悉處理情形，感謝照會;預計提供:",$Q12c,"multi"); ?>
    <textarea id="Q12d" name="Q12d" rows="6" readonly="readonly"></textarea>
    </td>
    <td>
    <?php echo checkbox_result("Q12e","已知悉處理情形，感謝照會;預計提供:",$Q12e,"multi"); ?>
    <textarea id="Q12f" name="Q12f" rows="6" readonly="readonly"></textarea>
    </td>
    </tr>
  <tr>
    <td class="title">主責人員</td>
    <td><input type="text" name="Q14a" id="Q14a" value="<?php echo $Q14a; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q14b" id="Q14b" value="<?php echo $Q14b; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q14c" id="Q14c" value="<?php echo $Q14c; ?>" size="8" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="title">主管批示</td>
    <td><input type="text" name="Q15a" id="Q15a" value="<?php echo $Q15a; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q15b" id="Q15b" value="<?php echo $Q15b; ?>" size="8" readonly="readonly" /></td>
    <td><input type="text" name="Q15c" id="Q15c" value="<?php echo $Q15c; ?>" size="8" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="title">Notify date</td>
    <td><script> $(function() { $( "#date2a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date2a" id="date2a" value="<?php if ($date2a != NULL) { echo formatdate($date2a); } ?>" size="12" readonly="readonly" /></td>
    <td><script> $(function() { $( "#date2b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date2b" id="date2b" value="<?php if ($date2b != NULL) { echo formatdate($date2b); } ?>" size="12" readonly="readonly" /></td>
    <td><script> $(function() { $( "#date2c").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date2c" id="date2c" value="<?php if ($date2c != NULL) { echo formatdate($date2c); } ?>" size="12" readonly="readonly" /></td>
  </tr>
</table>

<center><input type="hidden" name="formID" id="formID" value="socialform10" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>