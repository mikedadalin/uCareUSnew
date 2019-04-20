<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform13` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform13` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>社會心理定期評估表</h3>
<iframe src="module/socialwork/form13_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170"></iframe>
<table width="100%">
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>一、入住意願及接受度</b></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q1","1分：個人缺乏意願，出於無奈;2分：個人無意見;3分：無法表達意願;4分：個人願意嘗試;5分：意願及接受度均強",$Q1,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>二、家屬對機構的配合度</b></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q2","1分：完全不配合機構;2分：大部分都不配合機構;3分：偶爾需要溝通才能配合;4分：大都能配合少部分依賴機構處理;5分：願意完全配合機構",$Q2,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>三、情緒</b></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q3","1分：完全沉默或經常有躁動行為出現;2分：有退縮、厭世或異常的行為出現;3分：情緒經常呈現不穩定;4分：偶爾有沮喪或興奮異常的情緒反應;5分：正常",$Q3,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>四、行為</b></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q4","1分：常有抱怨、拒絕或攻擊行為出現;2分：偶爾有抱怨、拒絕或攻擊行為出現;3分：無行為能力;4分：偶爾會抱怨、指責;5分：與人能和睦相處、配合度亦佳",$Q4,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>五、社會化</b></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q5","1分：語言障礙或無法參加社交活動;2分：逃避或抗拒社交活動;3分：能接受社交活動，但不主動參與;4分：每月至少參加一次社交活動、尚願意與人互動;5分：每週至少參加一次社交活動與人互動意願高",$Q5,"single"); ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>六、家庭支持力</b></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q6","1分：家屬幾乎不與本院或個案互動;2分：家人偶爾探視顯得較為被動冷漠;3分：家人輪流探視〈約每月一次〉尚能主動表示關懷;4分：家人每月至少關懷探視兩次，互動尚佳;5分：家人每週至少關懷探視一次，互動良好",$Q6,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s" width="120">Total score:</td>
    <td ><input type="text" name="Qtotal" id="Qtotal" size="2" value="<?php echo $Qtotal; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s">Comment</td>
    <td><textarea id="Q7" name="Q7" rows="6"><?php echo $Q7; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform13" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<script>
$(document).ready(function () {
	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Qtotal = 0;
	for(var i=1;i<=6;i++){
		for(var j=1;j<=5;j++){
			if ($('#Q'+i+'_'+j).val()==1) { Qtotal += parseInt(j); }	
		}
	}
	$('#Qtotal').val(Qtotal);
}
</script>
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