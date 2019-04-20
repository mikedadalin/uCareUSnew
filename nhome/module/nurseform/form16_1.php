<?php
$db1 = new DB;
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `nurseform16` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql1 = "SELECT * FROM `nurseform16` WHERE `nID`='".mysql_escape_string($_GET['nID'])."'";
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
<form  method="post" onSubmit="return checkForm();" action="index.php?func=databaseAI">
<h3>Add new appointment</h3>
  <?php
  //檢查欄位是否存在
  $dbNumFields = new DB;
  $dbNumFields->query("SELECT * FROM `nurseform16` LIMIT 0,1");
  $rNumFields = $dbNumFields->num_fields();
  $field_array = array();
  for ($i=0;$i<$rNumFields;$i++) {
	  $dbFieldName = new DB;
	  $dbFieldName->query("SELECT * FROM `nurseform16` LIMIT 0,1");
	  $rFieldName = $dbFieldName->field_name($i);
	  if (substr($rFieldName,0,3)=="Q2_") { $field_array[$i] = $rFieldName; }
  }
  if (count($field_array)<21) {
	  if (!in_array('Q2_21',$field_array)) {
		  $dbU1 = new DB;
		  $dbU1->query('ALTER TABLE  `nurseform16` CHANGE  `Q2_'.count($field_array).'`  `Q2_21` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');
		  $movedCol = count($field_array);
	  }
	  for ($i=$movedCol;$i<=20;$i++) {
		  $dbU2 = new DB;
		  $dbU2->query('ALTER TABLE  `nurseform16` ADD  `Q2_'.$i.'` TEXT NOT NULL AFTER  `Q2_'.($i-1).'` ;');
	  }
  }
  //讀取系統設定
  $dbHosp = new DB2;
  $dbHosp->query("SELECT * FROM system_setting WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
  $rHosp = $dbHosp->fetch_assoc();
  for ($i1=1;$i1<=20;$i1++) {
	  if ($rHosp['Hosp'.$i1]!="") { $HospTxt .= $rHosp['Hosp'.$i1].';'; }
  }
  $HospTxt .= "Other";
  ?>
<table width="100%">
      <tr height="30">
        <td class="title">Visiting hospital</td>
        <td colspan="3"><?php echo draw_option("Q2",$HospTxt,"l","single",$Q2,true,5); ?> <input type="text" name="Q2a" id="Q2a" size="24" value="<?php echo $Q2a; ?>"></td>
      </tr>
      <tr height="30">
        <td class="title">Division</td>
        <td><input type="text" name="Q2b" id="Q2b" size="24" value="<?php echo $Q2b; ?>"></td>
        <td class="title">Clinical appoitment #</td>
        <td><input type="text" name="Q2e" id="Q2e" size="24" value="<?php echo $Q2e; ?>"></td>
      </tr>
      <tr height="30">
        <td class="title" width="120">Visiting date</td>
        <td><script> $(function() { $( "#Q1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="Q1" id="Q1" value="<?php if ($Q1 != NULL) { echo $Q1; } else { echo date('Y/m/d'); } ?>" size="12" ></td>
        <td class="title" width="120">AM/PM</td>
        <td colspan="3"><?php echo draw_option("Q6","AM;PM;Night","m","single",$Q6,true,5); ?></td>
      </tr>
      <tr height="30">
        <td class="title">Physician name</td>
        <td><input type="text" name="Q2c" id="Q2c" size="24" value="<?php echo $Q2c; ?>"></td>
        <td class="title">Clinic</td>
        <td><input type="text" name="Q2d" id="Q2d" size="24" value="<?php echo $Q2d; ?>"></td>
      </tr>
      <tr height="30">
        <td class="title">Visiting reason</td>
        <td colspan="3"><input type="text" name="Q3" id="Q3" size="24" value="<?php echo $Q3; ?>"></td>
      </tr>
      <tr height="30">
        <td class="title">Clinic classification</td>
        <td colspan="3"><?php echo draw_option("Q4","Emergency;Outpatient","l","multi",$Q4,true,5); ?></td>
      </tr>
      <!--<tr height="200">
        <td class="title" valign="top">醫療處置</td>
        <td colspan="3" valign="top"><textarea name="Q5" id="Q5" cols="80" rows="8" ><?php echo $Q5; ?></textarea></td>
      </tr>-->
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform16" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" /><input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>