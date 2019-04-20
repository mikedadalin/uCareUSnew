<?php
$arrPlan = array();

//care plan
$db1 = new DB;
$db1->query("SELECT * FROM `nursecareplan`");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	if ($r1['pText']!="") {
		$arrText = explode(";",$r1['pText']);
		${$r1['formID'].'_'.$r1['formQ']} = $arrText;
	}
}

//ADL
$db1 = new DB;
$db1->query("SELECT * FROM `nurseform02c` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC LIMIT 0,1");
$r1 = $db1->fetch_assoc();
foreach ($r1 as $k1=>$v1) {
	if (substr($k1,0,1)=="Q" && $v1==1) {
		if (count(${'nurseform02c_'.$k1})>0) {
			foreach (${'nurseform02c_'.$k1} as $k1a => $v1a) {
				array_push($arrPlan, $v1a);
			}
		}
	}
}
?>
<h3>個人化護理計畫</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table width="100%">
  <tr>
    <td>
      <textarea name="Qplan" id="Qplan" rows="30">
      <?php
      $count = 1;
      foreach ($arrPlan as $kP=>$vP) {
          echo $count.'. '.$vP."\n";
          $count++;
      }
      ?>
      </textarea>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform07" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>