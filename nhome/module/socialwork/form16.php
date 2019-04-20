<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform16` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform16` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  id="socialform11c" method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>個案服務照顧計畫表（三）</h3>
<table width="100%" border="0">
  <tr>
    <td class="title">Physical condition</td>
    <td><?php echo draw_option("Q1","Steady;虛弱;Hospitalization;Other","m","single",$Q1,false,0); ?>, description:<input type="text" name="Q1a" id="Q1a" size="30" value="<?php echo $Q1a; ?>" ></td>
  </tr>
  <tr>
    <td class="title">用餐情況</td>
    <td><?php echo draw_option("Q2","Normal;Normal;食慾不佳;管餵食","m","single",$Q2,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">情緒表現</td>
    <td><?php echo draw_option("Q3","Stable;Depression;Anxious;躁動;Other","m","single",$Q3,false,0); ?>, description:<input type="text" name="Q3a" id="Q3a" size="17" value="<?php echo $Q3a; ?>" ></td>
  </tr>
  <tr>
    <td class="title">睡眠狀況</td>
    <td><?php echo draw_option("Q4","Normal;Insomnia;中斷睡眠;服用安眠藥","m","single",$Q4,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">與家屬互動</td>
    <td><?php echo draw_option("Q5","Normal;Fair;Poor;Other","m","single",$Q5,false,0); ?>, description:<input type="text" name="Q5a" id="Q5a" size="30" value="<?php echo $Q5a; ?>" ></td>
  </tr>
  <tr>
    <td class="title">與住民互動</td>
    <td><?php echo draw_option("Q6","Normal;Fair;Poor;無行動能力","m","single",$Q6,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">家屬與中心之互動關係</td>
    <td><?php echo draw_option("Q7","Good;Fair;Poor","m","single",$Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title">參與活動情況</td>
    <td><?php echo draw_option("Q8","體能活動;才藝活動;團康活動;宗教活動;社區活動;節慶活動;戶外活動;Other","m","multi",$Q8,true,6); ?>, description:<input type="text" name="Q8a" id="Q8a" size="30" value="<?php echo $Q8a; ?>" ></td>
  </tr>
  <tr>
    <td class="title" rowspan="2">生活情況</td>
    <td><?php echo draw_option("Q9","Good;調適中;不能適應","m","single",$Q9,false,0); ?></td>
  </tr>
  <tr>
    <td><?php echo draw_option("Q10","喜歡與住民群聚聊天;看電視;協助廚房整理蔬菜;園藝;Other","l","multi",$Q10,false,0); ?><br>Note:<input type="text" name="Q10a" id="Q10a" size="30" value="<?php echo $Q10a; ?>" ></td>
  </tr>
  <tr>
    <td class="title" rowspan="2">本院提供之服務</td>
    <td>
	<script> $(function() { $( "#Q11a").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); $( "#Q11b").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script>
    <input type="text" name="Q11a" id="Q11a" value="<?php if ($Q11a != NULL) { echo formatdate($Q11a); } else { echo date("Y/m/d"); } ?>" size="12"> 至 
    <input type="text" name="Q11b" id="Q11b" value="<?php if ($Q11b != NULL) { echo formatdate($Q11b); } else { echo date("Y/m/d"); } ?>" size="12">
    </td>
  </tr>
  <tr>
    <td><?php echo draw_option("Q12","居家護理服務;參加團體活動;協助就醫;重度依賴住民活動;Other","l","multi",$Q12,false,0); ?><br>Note:<input type="text" name="Q12a" id="Q12a" size="30" value="<?php echo $Q12a; ?>" ></td>
  </tr>
  <tr>
    <td class="title">綜合評估</td>
    <td><textarea id="Q13" name="Q13" rows="8"><?php echo $Q13; ?></textarea></td>
  </tr>    
</table>


<table width="100%">
  <tr class="printcol">
    <td style="background:#ffffff;" >Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
  <tr class="noShowCol">
    <td style="border-style:none;">社工：</td>
    <td style="border-style:none;">主任：</td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform16" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>

<script>$("#socialform11c").validationEngine();</script>
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