<?php
$db1 = new DB;
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `nurseform08` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql1 = "SELECT * FROM `nurseform08` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
	$db1->query($sql1);
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
}
?>
<form  method="post" onSubmit="return checkForm_nurseform08();" action="index.php?func=databaseAI">
<h3>特殊事件</h3>
<table width="100%">
<?php
if ($Q0=="") { $Q0 = date('Y/m/d');; }
?>
  <tr height="30">
    <td class="title">發生日期</td>
    <td colspan="3"><script>$(function() { $('#Q1').datetimepicker(); });</script><input type="text" name="Q1" id="Q1" size="18" value="<?php echo $Q1; ?>"></td>
  </tr>
  <tr height="30">
    <td class="title">Item(s)</td>
    <td><?php echo draw_option("Q2","Hospitalization;離院;特殊事件;客訴;新褥瘡產生;跌倒;Other","m","single",$Q2,false,5); ?><br>Note:<input type="text" name="Q3" id="Q3" size="80" value="<?php echo $Q3; ?>" /></td>
  </tr>
  <tr height="30">
    <td class="title">Cause of the event / treatment</td>
    <td><textarea name="Q4" id="Q4" rows="6"><?php echo $Q4; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform08" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" /><input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<?php
if ($_GET['action']=="edit") {
$pid = (int) @$_GET['pid'];
$parentName = "nurseform08";
$parentID = $_GET['nID'];
if (isset($_POST['submit'])) {
	include('class/insertSubItem.php');
	include('class/updateSubItem.php');
	echo '<script>window.location.href="index.php?mod=nurseform&func=formview&id=8_1&nID='.$_GET['nID'].'&action=edit&pid='.$pid.'";</script>';
}
?>
<hr>
<form method="post">
<h3>Follow up date/Results</h3>
<?php 
$tmpArr=array("Date","Time","Results","Filled by");
$tmpArrCol=array("title","content1","content2","content3");
$tmpLength = count($tmpArr);
include("class/blockSubItem.php");
include("class/addSubItem.php");
?>
<center>
<input type="button" value="Back to list" id="back">
<input type="submit" id="submit" value="Save" name="submit" class="printcol" />
</center>
</form>
<script>
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=8";
	});
});
</script>
<?php
}
?>
<script>
function checkForm_nurseform08() {
	var totalQ2 = 0;
	$(':input[id^="Q2_"]').each(function() {
		totalQ2 += parseInt($(this).val());
	});
	if (totalQ2==0) {
		alert('請選擇特殊事件項目！');
		return false;
	} else {
		return checkForm();
	}
}
$(function(){
	$("#btn_Q2_6").click(function(){
		location.href = "index.php?mod=nurseform&func=formview&pid=<?php echo $_GET['pid']; ?>&id=3_3&autoOpen=true";
	});
});
</script>