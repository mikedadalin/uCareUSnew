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
<h3>30# Nursing diagnosis - Fluid volume deficit</h3>
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
    <td colspan="3"><?php echo draw_checkbox("Q3","Fever;Diarrhea;Insufficient water intake;Control mechanism failure;Other(s):<input type='text' name='Q3a' id='Q3a' size='30' value='".$Q3a."' />",$Q3,"multi"); ?><?php echo draw_checkbox("Q3b","Caused by disease",$Q3b,"multi");?>
	<div style="margin-left:36px;"><?php echo draw_option("Q3c","Cardiogenic cause;Caused by kidney problem;Caused by liver problem","xl","multi",$Q3c,false,5);?>
    </div></td>
  </tr>
  <tr>
    <td class="title">Characteristics Identified</td>
    <td colspan="3"><?php echo draw_checkbox("Q4","Weak;Dried skin and mucous membranes;HR、BP↓;Mental status changes;Oliguria;Electrolytes;Sudden weight loss",$Q4,"multi"); ?></td>
  </tr>  
  <tr>
    <td class="title">Care goals</td>
    <td colspan="3"><?php echo draw_checkbox("Q5","Weak conditions improved;Maintain the balance of fluids intake;Prevent complications;Other(s):<input type='text' name='Q5a' id='Q5a' size='30' value='".$Q5a."' />",$Q5,"multi"); ?></td>
  </tr>
  <tr>
    <td class="title">Nursing intervention(s)</td>
    <td colspan="3">
	<?php echo draw_checkbox("Q6","Observe the cause of fluid volume deficit;Monitor input and output;Water intake;Regularly monitor of vital sign;Monitor the appearance of the skin to help avoid skin damage in every shift;According to the medical advice, apply intravenous fluids, such as:：<input type='text' name='Q6a' id='Q6a' size='30' value='".$Q6a."' />;Other(s):<input type='text' name='Q6b' id='Q6b' size='30' value='".$Q6b."' />",$Q6,"multi"); ?>
   </td>
  </tr>
</table>
<input type="hidden" id="date" name="date" value="<?php if (@$_GET['date']!='') { echo formatdate(@$_GET['date']); } else { echo date(Y."/".m."/".d); } ?>" />
<center><p><input type="hidden" name="formID" id="formID" value="nursediag<?php echo @$_GET['id']; ?>" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?></p></center>
</form>
<?php
include('assess.php');
?>
</div>