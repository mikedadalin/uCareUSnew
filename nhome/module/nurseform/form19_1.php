<?php
$db1 = new DB;
if (@$_GET['nID']==NULL) {
	$sql1 = "SELECT * FROM `nurseform19` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql1 = "SELECT * FROM `nurseform19` WHERE `nID`='".mysql_escape_string($_GET['nID'])."' AND `HospNo`='".$HospNo."'";
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
<h3><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo'洗腎紀錄';}else{ echo'Add new dialysis record';}?></h3>
<table width="100%">
<?php
if ($Q0=="") { $Q0 = date('Y/m/d');; }
?>
  <tr height="30">
    <td class="title">Dialysis date</td>
    <td colspan="3"><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script>$(function() { $('#Q0').datepicker(); });</script><?php }?><input type="text" name="Q0" id="Q0" size="18" value="<?php echo $Q0; ?>"></td>
  </tr>
  <tr height="30">
    <td class="title">Weight before dialysis</td>
    <td><input type="text" name="Q1" id="Q1" size="10" value="<?php echo $Q1; ?>" onkeyup="calcQ5();"> Kilogram</td>
    <td class="title">Blood pressure before dialysis</td>
    <td><input type="text" name="Q2a" id="Q2a" size="5" value="<?php echo $Q2a; ?>"> / <input type="text" name="Q2b" id="Q2b" size="5" value="<?php echo $Q2b; ?>"> mmHg</td>
  </tr>
  <tr height="30">
    <td class="title">Weight after dialysis</td>
    <td><input type="text" name="Q3" id="Q3" size="10" value="<?php echo $Q3; ?>" onkeyup="calcQ5();"> Kilogram</td>
    <td class="title">Blood pressure after dialysis</td>
    <td><input type="text" name="Q4a" id="Q4a" size="5" value="<?php echo $Q4a; ?>"> / <input type="text" name="Q4b" id="Q4b" size="5" value="<?php echo $Q4b; ?>"> mmHg</td>
  </tr>
  <tr height="30">
    <td class="title">Dehydration</td>
    <td colspan="3"><input type="text" name="Q5" id="Q5" size="10" value="<?php echo $Q5; ?>" readonly> Kilogram</td>
  </tr>
  </tr>
  <tr height="30">
    <td class="title">Medication</td>
    <td colspan="3"><?php echo draw_checkbox_2col("Q6","B-C 1c.c.;Vit C 1Amp;Sugar：<input type=\"text\" size=\"12\" name=\"Q6a\" id=\"Q6a\" value=\"".$Q6a."\">mg/dl;B12 1c.c.;Dpo(Epo)：<input type=\"text\" size=\"12\" name=\"Q6b\" id=\"Q6b\" value=\"".$Q6b."\">u;Other(s):<input type=\"text\" size=\"12\" name=\"Q6c\" id=\"Q6c\" value=\"".$Q6c."\">",$Q6,"multi"); ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><?php }?><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><input type="button" value="Today" onclick="inputdate('date');" /><?php }?></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform19" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><input type="hidden" name="nID" id="nID" value="<?php echo $_GET['nID']; ?>" /><input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" /><?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button><?php }?></center>
</form>
<script>
function calcQ5() {
	var Q1 = 0;
	var Q3 = 0;
	var err = 0;
	if ($('#Q1').val()!="" && !isNaN($('#Q1').val())) {
		Q1 = parseFloat($('#Q1').val());
	} else {
		$('#Q1').val('');
		$('#Q5').val('');
		err++;
	}
	if ($('#Q3').val()!="" && !isNaN($('#Q3').val())) {
		Q3 = parseFloat($('#Q3').val());
	} else {
		$('#Q3').val('');
		$('#Q5').val('');
		err++;
	}
	if (err==0) {
		var Q5 = Math.round((Q1-Q3)*10);
		$('#Q5').val(Q5/10);
	}
}
</script>