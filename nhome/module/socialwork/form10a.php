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
<h3>各組照會社工組服務單</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%" border="0">
  <tr>
    <td class="title" width="100">照會單位</td>
    <td colspan="5"><?php echo draw_option("Q1","行政組;Nursing group;Rehabilitation group;Other","m","multi",$Q1,true,5); ?> <input type="text" name="Q1a" id="Q1a" size="15" value="<?php echo $Q1a; ?>"></td>
    </tr>
  <tr>
    <td class="title">健康摘要</td>
    <td colspan="5"><?php echo draw_checkbox_nobr("Q2","MMSE：<input type=\"text\" name=\"Q2a\" id=\"Q2a\" value=\"".$Q2a."\" size=\"3\" >Score;ADL：<input type=\"text\" name=\"Q2b\" id=\"Q2b\" value=\"".$Q2b."\" size=\"3\" >Score;Other(s):<input type=\"text\" name=\"Q2c\" id=\"Q2c\" value=\"".$Q2c."\" size=\"20\" >",$Q2,"single"); ?></td>
    </tr>
  <tr>
    <td class="title">照會項目</td>
    <td colspan="5"><?php echo draw_option("Q3","Adaptational counseling;自殺個案;家庭經濟問題;社會福利資源問題;Emotional problem(s);生活照顧問題;醫病溝通問題;轉介安置問題;建議/申訴處理;家庭功能問題;衛教需求;Other","l","multi",$Q3,true,5); ?> <input type="text" name="Q3a" id="Q3a" size="25" value="<?php echo $Q3a; ?>"></td>
    </tr>
  <tr>
    <td class="title">照會原因說明</td>
    <td colspan="5"><textarea id="Q4" name="Q4"  cols="60" rows="6"></textarea></td>
    </tr>
  <tr>
    <td class="title">主責社工</td>
    <td> <input type="text" name="Qfiller" id="Qfiller" value="<?php echo $Qfiller; ?>" size="8"></td>
    <td class="title">主管批示</td>
    <td><input type="text" name="Q5" id="Q5" value="<?php echo $Q5; ?>" size="8"></td>
    <td class="title">Notify date</td>
    <td><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> </td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td colspan="6" class="title">Social working group&nbsp;處遇</td>
    </tr>
  <tr>
    <td class="title" width="100">Problem assessment</td>  
    <td colspan="5"><?php echo draw_checkbox("Q6","因：<input type=\"text\" name=\"Q6a\" id=\"Q6a\" value=\"".$Q6a."\" size=\"20\" >無需/無法評估。",$Q7,"single"); ?>
<div>
Emotional status:<input type="text" name="Q7a" id="Q7a" size="20" value="<?php echo $Q7a; ?>"><?php echo draw_checkbox_nobr("Q7","無法評估。",$Q7,"single"); ?>　　　　
Comprehension:<input type="text" name="Q8a" id="Q8a" size="20" value="<?php echo $Q8a; ?>"><?php echo draw_checkbox_nobr("Q8","無法評估。",$Q8,"single"); ?>
</div>
<div>
Behavior:<input type="text" name="Q9a" id="Q9a" size="20" value="<?php echo $Q9a; ?>"><?php echo draw_checkbox_nobr("Q9","無法評估。",$Q9,"single"); ?>　　　　
Social skills:<input type="text" name="Q10a" id="Q10a" size="20" value="<?php echo $Q10a; ?>"><?php echo draw_checkbox_nobr("Q10","無法評估。",$Q10,"single"); ?>
</div>
<div>
Attitude:<input type="text" name="Q11a" id="Q11a" size="20" value="<?php echo $Q11a; ?>"><?php echo draw_checkbox_nobr("Q11","無法評估。",$Q11,"single"); ?>　　　　
Ability to communicate::<input type="text" name="Q12a" id="Q12a" size="20" value="<?php echo $Q12a; ?>"><?php echo draw_checkbox_nobr("Q12","無法評估。",$Q12,"single"); ?>
</div>
<div>
注&nbsp;&nbsp;意&nbsp;&nbsp;力:<input type="text" name="Q13a" id="Q13a" size="20" value="<?php echo $Q13a; ?>"><?php echo draw_checkbox_nobr("Q13","無法評估。",$Q13,"single"); ?>　　　　
Interaction with family:<input type="text" name="Q14a" id="Q14a" size="20" value="<?php echo $Q14a; ?>"><?php echo draw_checkbox_nobr("Q14","無法評估。",$Q14,"single"); ?>
</div>
<div>
Cogitation:<input type="text" name="Q15a" id="Q15a" size="20" value="<?php echo $Q15a; ?>"><?php echo draw_checkbox_nobr("Q15","無法評估。",$Q15,"single"); ?>　　　　
住民互動:<input type="text" name="Q16a" id="Q16a" size="20" value="<?php echo $Q16a; ?>"><?php echo draw_checkbox_nobr("Q16","無法評估。",$Q16,"single"); ?>
</div>

    </td>
    </tr>
  <tr>
    <td class="title">初步處理情形</td>  
    <td colspan="5"><textarea id="Q17" name="Q17"  cols="60" rows="6" readonly="readonly"></textarea></td>
    </tr>
  <tr>
    <td class="title">服務計劃</td>  
    <td colspan="5">處遇期程:<?php echo draw_checkbox_nobr("Q18","短期：<input type=\"text\" name=\"Q18a\" id=\"Q18a\" value=\"".$Q18a."\" size=\"14\" >;中長期：<input type=\"text\" name=\"Q18b\" id=\"Q18b\" value=\"".$Q18b."\" size=\"14\" >",$Q18,"single"); ?><br />
    列入:<?php echo draw_checkbox("Q19","一般個案處遇;特殊個案處遇：<input type=\"text\" name=\"Q19a\" id=\"Q19a\" value=\"".$Q19a."\" size=\"50\" >",$Q19,"single"); ?>
    </td>
    </tr>
  <tr>
    <td class="title">主責人員</td>
    <td> <input type="text" name="Q20" id="Q20" value="<?php echo $Q20; ?>" size="8" readonly="readonly"></td>
    <td class="title">主管批示</td>
    <td><input type="text" name="Q21" id="Q21" value="<?php echo $Q21; ?>" size="8" readonly="readonly"></td>
    <td class="title">Notify date</td>
    <td><script> $(function() { $( "#date1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date1" id="date1" value="<?php if ($date1 != NULL) { echo formatdate($date1); } ?>" size="12" readonly="readonly"> </td>
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