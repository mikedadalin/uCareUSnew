<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform12` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform12` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
?>
<form  id="socialform12" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>新進個案適應紀錄表</h3>
<table width="100%" border="0">
  <tr class="title">
    <td>評核項目</td>
    <td>評核內容</td>
    <td>Description</td>
  </tr>
  <tr>
    <td class="title_s">人際關係</td>
    <td><?php echo draw_checkbox("Q1","會主動與其他住民互動;只與部份住民互動;極少與其他住民互動",$Q1,"single"); ?></td>
    <td><textarea name="Q1a" id="Q1a" rows="8"><?php echo $Q1a; ?></textarea>
  </tr>
  <tr>
    <td class="title_s">用餐情況</td>
    <td><?php echo draw_checkbox("Q2","能適應中心的伙食;偶爾對中心的伙食有意見;不能適應中心的伙食",$Q2,"single"); ?></td>
    <td><textarea name="Q2a" id="Q2a" rows="8"><?php echo $Q2a; ?></textarea>
  </tr>
  <tr>
    <td class="title_s">Activity participation</td>
    <td><?php echo draw_checkbox("Q3","會主動參與中心活動;偶爾參與中心活動;從不參與中心活動",$Q3,"single"); ?></td>
    <td><textarea name="Q3a" id="Q3a" rows="8"><?php echo $Q3a; ?></textarea>
  </tr>
  <tr>
    <td class="title_s">家屬支持</td>
    <td><?php echo draw_checkbox("Q4","家屬經常來探視住民;家屬偶爾來探視住民;家屬從不來探視住民",$Q4,"single"); ?></td>
    <td><textarea name="Q4a" id="Q4a" rows="8"><?php echo $Q4a; ?></textarea>
  </tr>
  <tr>
    <td class="title_s">情緒反應</td>
    <td><?php echo draw_checkbox("Q5","住民每日均面帶笑容;住民大多愁眉不展;住民大都有哭泣情況",$Q5,"single"); ?></td>
    <td><textarea name="Q5a" id="Q5a" rows="8"><?php echo $Q5a; ?></textarea>
  </tr>
  <tr>
    <td class="title_s">評估說明及社工處遇</td>
    <td colspan="2"><textarea name="Q6" id="Q6" rows="8"><?php echo $Q6; ?></textarea>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform12" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>

<script>$("#socialform12").validationEngine();</script>
<?php
if ($r1) {
foreach ($r1 as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}  else {
		${$k} = "";
	}
}
}
?>