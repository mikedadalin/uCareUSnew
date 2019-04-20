<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform14` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform14` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>個案服務分組評估表</h3>
<iframe src="module/socialwork/form14_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170"></iframe>
<table width="100%">
  <tr class="title">
    <td>項     目</td>
    <td>向     度</td>
    <td>Score</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;" nowrap><b>Physiological function</b></td>
    <td><?php echo draw_checkbox("Q1","1. On foot;2. Walker;3. 坐輪椅;4. Bedfast(勾選此項者不評分，後三項免評直接判定為C組)",$Q1,"single"); ?></td>
    <td style="text-align:right;"><input type="text" name="Q1score" id="Q1score" size="3" value="<?php echo $Q1score; ?>" readonly /></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;"><b>Mental Status</b></td>
    <td><?php echo draw_checkbox("Q2","1. 有意識;2. 無意識(勾選此項者不評分，後三項免評直接判定為C組)",$Q2,"single"); ?></td>
    <td style="text-align:right;"><input type="text" name="Q2score" id="Q2score" size="3" value="<?php echo $Q2score; ?>" readonly /></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;"><b>Behavior status</b></td>
    <td><?php echo draw_checkbox("Q3","1. 自動/積極;2. Passive/不積極",$Q3,"single"); ?></td>
    <td style="text-align:right;"><input type="text" name="Q3score" id="Q3score" size="3" value="<?php echo $Q3score; ?>" readonly /></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left;"><b>Social interaction</b></td>
    <td><?php echo draw_checkbox("Q4","1. 能主動;2. Passive;3. 苛求/冷漠;4. Resist/Hostile",$Q4,"single"); ?></td>
    <td style="text-align:right;"><input type="text" name="Q4score" id="Q4score" size="3" value="<?php echo $Q4score; ?>" readonly /></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:right;">Total score:</td>
    <td style="text-align:right;" width="240"><input type="text" name="Qtotal" id="Qtotal" size="3" value="<?php echo $Qtotal; ?>" readonly /></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:right;">服務組別：</td>
    <td style="text-align:right;"><input type="text" name="Qgroup" id="Qgroup" size="3" value="<?php echo $Qgroup; ?>" readonly /></td>
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:right;">Note:</td>
    <td nowrap>學習活動分成A、B、C三組<br>
    A組4~6分：團體服務為主<br>
    B組7~9分：團體與個別分別進行<br>
    C組10以上：個別服務為主
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform14" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
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
	if ($('#Q1_1').val()==1) { Qtotal += 1; $('#Q1score').val('1'); }
	if ($('#Q1_2').val()==1) { Qtotal += 2; $('#Q1score').val('2'); }
	if ($('#Q1_3').val()==1) { Qtotal += 3; $('#Q1score').val('3'); }
	if ($('#Q1_4').val()==1) { Qtotal += 4; $('#Q1score').val('4'); }
	if ($('#Q2_1').val()==1) { Qtotal += 1; $('#Q2score').val('1'); }
	if ($('#Q2_2').val()==1) { Qtotal += 2; $('#Q2score').val('2'); }
	if ($('#Q3_1').val()==1) { Qtotal += 1; $('#Q3score').val('1'); }
	if ($('#Q3_2').val()==1) { Qtotal += 2; $('#Q3score').val('2'); }
	if ($('#Q4_1').val()==1) { Qtotal += 1; $('#Q4score').val('1'); }
	if ($('#Q4_2').val()==1) { Qtotal += 2; $('#Q4score').val('2'); }
	if ($('#Q4_3').val()==1) { Qtotal += 3; $('#Q4score').val('3'); }
	if ($('#Q4_4').val()==1) { Qtotal += 4; $('#Q4score').val('4'); }
	if ($('#Q1_4').val()==1 || $('#Q2_2').val()==1) {
		$('#Qgroup').val('C');
	} else {
		if (Qtotal>=4 && Qtotal<=6) {
			$('#Qgroup').val('A');
		} else if (Qtotal>=7 && Qtotal<=9) {
			$('#Qgroup').val('B');
		} else if (Qtotal>9) {
			$('#Qgroup').val('C');
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