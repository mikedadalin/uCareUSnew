<?php
$pid = (int) @$_GET['pid'];
$db = new DB;
$db->query("SELECT * FROM `patient` WHERE `patientID`='".mysql_escape_string($pid)."'");
if ($db->num_rows()>0) { $r = $db->fetch_assoc(); foreach ($r as $k=>$v) { $arrPatientInfo = explode("_",$k); if (count($arrPatientInfo)==2) { if ($v==1) { ${$arrPatientInfo[0]} .= $arrPatientInfo[1].';'; } } else { ${$k} = $v; } } }
$diagID = mysql_escape_string($_GET['id']);
if (@$_GET['date']!=NULL) {
	$db1 = new DB;
	$db1->query("SELECT * FROM `nursediag".$diagID."` WHERE `HospNo`='".mysql_escape_string($r['HospNo'])."' AND `date`='".mysql_real_escape_string(@$_GET['date'])."'");
	$r1 = $db1->fetch_assoc();
}
if ($db1->num_rows()>0) { foreach ($r1 as $k=>$v) { if (substr($k,0,1)=="Q") { $arrAnswer = explode("_",$k); if (count($arrAnswer)==2) { if ($v==1) { ${$arrAnswer[0]} .= $arrAnswer[1].';'; } } else { ${$k} = $v; } } else { ${$k} = $v; } } }
?>
<script>
$('#Q1').change(function(){
     
});
</script>
<form method="post" action="index.php?func=database&action=save" onSubmit="return checkForm();">
<h3>29# Nursing diagnosis -Nasogastric tube removed</h3>
<table>
  <tr>
    <td class="title"><p align="left">Problems established date</p></td>
    <td>
      <script> $(function() { $( "#Q1" ).datepicker() }); </script>
      <p align="left"><input type="text" id="Q1" name="Q1" value="<?php if ($Q1==NULL) { echo date(Y."/".m."/".d); } else { echo $Q1; } ?>" onchange="$('#date').val($(this).val());"  /><input type="hidden" id="Qrater_start" name="Qrater_start" value="<?php if ($Qrater_start==NULL) { echo $_SESSION['ncareID_lwj']; } else { echo $Qrater_start; } ?>" /></p>
    </td>
    <td class="title"><p align="left">Problems end date</p></td>
    <td>
      <p align="left">
      <?php
      if ($Q2==NULL) {
		  echo '<span id="end"><input type="button" onclick="endprob()" value="Deactivate" /></span><script> $(function() { $( "#Q2").datetimepicker({format:\'Y/m/d\', timepicker: false, mask: true}); }); </script><input type="text" id="Q2" name="Q2" value="" /><input type="hidden" id="Qrater_end" name="Qrater_end" value="" />'."\n";
	  } else {
		  echo '<input type="hidden" id="Q2" name="Q2" value="'.$Q2.'" />'.$Q2.'<input type="hidden" id="Qrater_end" name="Qrater_end" value="'.$_SESSION['ncareID_lwj'].'" />'."\n";
	  }
	  ?>
      </p>
      <script>
	   function endprob () {
		  RightNow = new Date();
		  var monthnow = RightNow.getMonth()+1;
		  monthnow = monthnow.toString();
		  if (monthnow.length == 1) { monthnow = "0"+monthnow; }
		  document.getElementById('Q2').value = RightNow.getFullYear() + "/" + monthnow +"/" + RightNow.getDate();
		  document.getElementById('Qrater_end').value = "<?php echo $_SESSION['ncareID_lwj']; ?>";
		  document.getElementById('end').innerHTML = "";
	  }
      </script>
    </td>
  </tr>
  <tr>
    <td class="title">Cause</td>
    <td colspan="3"><?php echo draw_checkbox("Q3","Vision and exercise capacity reduced, muscle weakness, strength and endurance decline.;Unable to masticate or swallow;Feelings or cognitive impairment;Pain or discomfort;Severe depression refuses to eat;Other(s):<input type='text' name='Q3a' id='Q3a' size='30' value='".$Q3a."' />",$Q3,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Care goals</td>
    <td colspan="3"><?php echo draw_checkbox("Q5","Within resident's capability, oral intake of food except water;Able to completely remove the nasogastric tube;Caregivers correctly assist and train resident to swallow;Other(s):<input type='text' name='Q5a' id='Q5a' size='30' value='".$Q5a."' />",$Q5,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Nursing intervention(s)</td>
    <td colspan="3">
	<?php echo draw_checkbox("Q6","Assess the reasons causing indwelling nasogastric tube;Residents discuss possible daily care model. Assess resident's chewing and swallowing ability and status of implementation.;For 'Cause' 3,4,5, teach resident and caregivers general care methods:",$Q6,"multi"); ?>
    <div style="margin-left:36px;"><?php echo draw_checkbox("Q7","Assess and note pain of the resident. First solve the discomfort caused by pain;Properly demonstrate and explain the activity before executing (give instruction as easy as possible).  Mind the privacy of care.;For conscious residents can place frequently used items, call bell, at the obvious and reachable location;Inform or make gentle sound before contacting the resident to avoid scaring the resident;Periodic execution environment safety assessment, reducing the risk factors caused by the environment in order to prevent residents injury;Provide and share relevant care experience, and timely give psychological support and encourage to the resident;Provide colorful, flavorful and tasty diet to the resident. And give multiple choices.;Encourage resident to eat independently and note their emotional state, pay attention to whether fatigue or excitement occur.;Understand residents food preferences, and maintain the correct temperature of the food. Cut food into strips or shredded, to facilitate access to the resident;Arrange fixed meal time and pleasant environment to reduce orderless or inability to concentrate;Arrangements resident dine in pleasant and friendly environment, and provide appropriate social contact, such as: with family or other residents;Use different colors to distinguish the plate, and describe the location and the type of dishes of food on each of plate, in order to facilitate eating and stimulate appetite.;Encourage residents to eat on their own, and give appropriate praise if the resident is able to accomplish, to increase self-confidence;Encourage and remind residents eat only a little bite of food at a time. And to determine whether a risk of choking or inhalation by checking whether there are food residues in the mouth;Select the appropriate way of dining, such as: feeding crushing diet or soft diet.;Encourage residents to clean the mouth before and after eating",$Q7,"multi"); ?></div>
    <?php echo draw_checkbox("Q8","For caused by illness or weakness:",$Q8,"multi"); ?>
    <div style="margin-left:36px;"><?php echo draw_checkbox("Q9","Apply the standard swallowing training specification to the resident;Passive facial massage,Cheeks, lips, tongue and breathing exercise;Direct swallowing training;Food served with a small volume-based;Record amount of food intake by the mouth and nasogastric tube feeding; pudding, mashed food, porridge-like food, paste food; concentrated liquid, dilute liquid, water;Close monitor of symptoms of aspiration pneumonia",$Q9,"multi"); ?></div></td>
  </tr>
</table>
<input type="hidden" id="date" name="date" value="<?php if (@$_GET['date']!='') { echo formatdate(@$_GET['date']); } else { echo date(Y."/".m."/".d); } ?>" />
<center><p><input type="hidden" name="formID" id="formID" value="nursediag<?php echo @$_GET['id']; ?>" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?></p></center>
</form>
<?php
include('assess.php');
?>
</div>