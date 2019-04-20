<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `socialform11c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `socialform11c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<center>
<form  id="socialform11c" method="post" onSubmit="return checkForm();" action="index.php?mod=socialwork&func=socialwork11csave"  enctype="multipart/form-data">
<h3>Assistive treatment activity</h3>
<table width="100%" border="0">
  <tr>
    <td class="title">Activity theme</td>
    <td>
    <select id="Qcate" name="Qcate" class="validate[required]">
    	<option value="">---Select activity theme---</option>
    <?php
	$db1b = new DB;
	$db1b->query("SELECT * FROM `socialform08_act` WHERE `cateName`='輔療性團體活動'");
	for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		$r1b = $db1b->fetch_assoc();
		echo '
		<option value="'.$r1b['actID'].'" '.($Qcate==$r1b['actID'] || $_GET['cate']==$r1b['actID'] ? "selected" : "").'>'.$r1b['actName'].'</option>
		';
	}
	?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="title">Activity objectives</td>
    <td><?php echo draw_checkbox_2col("Q1","Increase motivation to participate;Improve focusing sustainability;Improve physical coordination ;Improve interpersonal interaction;Enhance the sense of reality;Improve emotional stability;Improve oral expression skill;Enhance positive emotional expression;Improve cognitive function;Increase body endurance;Enhance sensory function;",$Q1,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Duration</td>
    <td><?php echo draw_option("Q2","0 point:Unable to fully focus;1 point:Focus for 15 minutes;2 points:Focus for 30 minutes;3 points:Focus for 45+ minutes","xxxl","single",$Q2,true,2); ?></td>
  </tr>
  <tr>
    <td class="title">Activity participation</td>
    <td><?php echo draw_option("Q3","0 point:Complete 0% of the activity;1 point:Complete 50% of the activity;2 points:Complete 75% of the activity;3 points:Complete of the activity on their own","xxxl","single",$Q3,true,2); ?></td>
  </tr>
  <tr>
    <td class="title">Social interaction</td>
    <td><?php echo draw_option("Q4","0 point:Not participate in the dialogue;1 point:Only answering question(s);2 points:Respond to participants;3 points:Actively trigger topic","xxxl","single",$Q4,true,2); ?></td>
  </tr>
  <tr>
    <td class="title">Emotions</td>
    <td><?php echo draw_option("Q5","0 point:Silence/no response;1 point:Complain/ excitement/ anxiety;2 points:Sometime pleasure;3 points:Throughout pleasure","xxxl","single",$Q5,true,2); ?></td>
  </tr>  
  <tr>
    <td class="title">Enjoyment of the group</td>
    <td><?php echo draw_option("Q6","0 point:No indication of enjoyment;1 point:Intermittent enjoyment;2 points:Enjoy most of the time;3 points:Fully enjoy","xxxl","single",$Q6,true,2); ?></td>
  </tr>
  <tr>
    <td class="title">Resident's <br>important reaction(s)</td>
    <td><textarea id="Q7" name="Q7"><?php echo $Q7; ?></textarea></td>
  </tr>    
</table>
<table width="100%">
  <tr>
    <td class="title">Event photos</td>
  </tr>
  <?php
  $picFolder = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/socialwork11c_pic/';
  if (file_exists($picFolder)) {
  ?>
  <tr>
  	<td colspan="4">
    <?php
	$arrFiles = scandir($picFolder);
	for ($i=2;$i<count($arrFiles);$i++) {
		$arrFileName = explode('_',$arrFiles[$i]);
		if ($arrFileName[0]==$date) {
			$delCountNo++;
			echo '
			<div style="margin:5px; padding:10px; background:#fff; display:inline-block;">
			<span class="printcol" id="txtDel'.$delCountNo.'"><input type="checkbox" name="Del'.$delCountNo.'" id="Del'.$delCountNo.'"> Delete<br></span>
			<a href="'.$picFolder.'/'.$arrFiles[$i].'" class="example-image-link" data-lightbox="example-set"><img src="'.$picFolder.'/'.$arrFiles[$i].'" width="200"></a>
			<input type="hidden" name="Delimg'.$delCountNo.'" id="Delimg'.$delCountNo.'" value="'.$picFolder.'/'.$arrFiles[$i].'">
			</div>
			';
		}
	}
	?>
    <input type="hidden" name="delCount" id="delCount" value="<?php echo $delCountNo; ?>">
    </td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="2"><?php if ($_GET['date']!="" && $act == "") { $act = "edit"; } elseif ($_GET['date']!="" && $act != "") { $act = "view"; } else { $act = "new"; } include("class/addImage.php"); ?></td>
  </tr>  
</table>

<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="socialform11c" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
<input type="hidden" name="act" id="act" value="<?php echo $act;?>" />
<input type="hidden" name="oldDate" id="oldDate" value="<?php echo $r1['date'];?>" />

</form></center><br>

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
<script>
function checkDel() {
	var delCount = $('#delCount').val();
	var count=0;
	if (delCount>0) {
		for (var i=1;i<=delCount;i++) {
			if ($('#Del'+i).attr('checked')) {
				count++;
			}
		}
		if (count>0) {
			if (confirm("確認刪除圖片?")) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	} else {
		return true;
	}
}
function checkThisForm() {
	if (checkForm() && checkDel()) {
		return true;
	} else {
		return false;
	}
}
</script>