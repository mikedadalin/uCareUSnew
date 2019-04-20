<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02l` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02l` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save" style="page-break-after:always;">
<h3>Geriatric Depression Scales(GDS)</h3>
<table width="100%">
  <tr>
    <td colspan="4" class="title" style="text-align:left;">&nbsp;Choose the best answer for how you have felt over the past week: </td>
  </tr>
  <tr class="title_s">
    <td colspan="2">Question</td>
    <td style="width:100px;">Yes</td>
    <td style="width:100px;">No</td>
  </tr>
  <tr>
    <td colspan="4" style="text-align:left;"><?php echo draw_checkbox("Q0","Unassessable",$Q0,"multi"); ?></td>
  </tr>
  <?php
  $arr2L = array('', '1.Are you basically satisfied with your life?','2.Have you dropped many of your activities and interests?','3.Do you feel that your life is empty?','4. Do you often get bored?','5. Are you in good spirits most of the time? ','6.Are you afraid that something bad is going to happen to you?','7.Do you feel happy most of the time?','8.Do you often feel helpless? ','9.Do you prefer to stay at home, rather than going out and doing new things (such as visiting a new restaurant)?','10.Do you feel you have more problems with memory than most people? ','11.Do you think it is wonderful to be alive now?','12.Do you feel pretty worthless the way you are now?','13.Do you feel full of energy?','14.Do you feel that your situation is hopeless?','15.Do you think that most people are better off than you are? ');
  $score1 =array(1, 5, 7, 11, 13);
  $Ans1 = "○;□";
  $Ans2 = "□;○";
  for ($i=1;$i<=15;$i++) {
  ?>
  <tr>
    <td colspan="2" class="title_s" style="text-align:left;">&nbsp;<?php echo $arr2L[$i]; ?></td>
    <td colspan="2" style="text-align:center;"><?php echo draw_option("Q".$i,(in_array($i,$score1)?$Ans2:$Ans1),"m","single",${'Q'.$i},false,0,2); ?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td class="title">Score (0-4 points: normal; 5-9 points: suggestive of depression; 10-15: almost always indicative of depression). Score >5  should warrant a follow-up comprehensive assessment.</td>
    <td width="100">
    <center>
    <h3>
    <span id="total"><?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?></span>
    <input type="hidden" name="Qtotal" id="Qtotal" value="<?php if ($Qtotal==NULL) { echo "0"; } else { echo $Qtotal; } ?>" />
    </h3>
    </center>
    </td>
    <td colspan="2">
    <span id="gdsmsg">
    <?php
	if ($Qtotal>=10) {
		echo "Reach diagnosis of depression";
	} elseif ($Qtotal>=5) {
		echo "Suggestive of depression";
	} else {
		echo "";
	}
	?>
    </span>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<div class="printcol">
<center>
<input type="hidden" name="formID" id="formID" value="nurseform02l" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
<button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
</center>
</div>
</form><br><br>
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
<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
if ($file=="index") {
?>
<script>
$(document).ready(function () {
	calc2dscore();
	for (i=1;i<=15;i++) {
		$("[id*='btn_Q"+i+"']").click(function() {
			calc2dscore();
		});
	}
});
function calc2dscore() {
	var totalscore=0;
	var score1 =[1, 5, 7, 11, 13];
	for (var i=1;i<=15;i++) {
		var iTxt = i.toString();
		var id1 = "Q"+iTxt+"_1";
		var id2 = "Q"+iTxt+"_2";
		var answer1 = document.getElementById(id1).value;
		var answer2 = document.getElementById(id2).value;
		//console.log(score1.indexOf(i));
		if(score1.indexOf(i) != -1) {
			if (answer2==1) { totalscore += parseInt(answer2); }
		} else {
			if (answer1==1) { totalscore += parseInt(answer1); }
		}
	}
	document.getElementById('Qtotal').value = totalscore;
	document.getElementById('total').innerHTML = totalscore;
	if (totalscore>=10) {
		document.getElementById('gdsmsg').innerHTML = "Reach diagnosis of depression";
	} else if (totalscore>=5) {
		document.getElementById('gdsmsg').innerHTML = "Suggestive of depression";
	} else {
		document.getElementById('gdsmsg').innerHTML = "";
	}
}
</script>
<?php
}
?>