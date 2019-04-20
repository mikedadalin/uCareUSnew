<?php
$db1 = new DB;
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `socialform19` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql1 = "SELECT * FROM `socialform19` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
}
$db1->query($sql1);
if ($db1->num_rows()>0) {
	$r1 = $db1->fetch_assoc();
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseAI">
<h3>跨專業整合照顧計畫表</h3>
<table width="100%">
  <tr height="30">
    <td class="title" width="140">個案問題</td>
    <td><textarea type="text" name="Q1" id="Q1" rows="5"><?php echo $Q1; ?></textarea></td>
  </tr>
  <tr height="30">
    <td class="title">照會單位</td>
    <td><textarea type="text" name="Q2" id="Q2" rows="5"><?php echo $Q2; ?></textarea></td>
  </tr>
  <tr height="30">
    <td class="title">專業人員意見</td>
    <td><textarea type="text" name="Q3" id="Q3" rows="5"><?php echo $Q3; ?></textarea></td>
  </tr>
  <tr height="30">
    <td class="title">Execution</td>
    <td><textarea type="text" name="Q4" id="Q4" rows="5"><?php echo $Q4; ?></textarea></td>
  </tr>
  <tr height="30">
    <td class="title">Follow-up</td>
    <td><textarea type="text" name="Q5" id="Q5" rows="5"><?php echo $Q5; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform19" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" /><input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>