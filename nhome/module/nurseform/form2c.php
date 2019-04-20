<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02c` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3><b style="font-size:20px">The Barthel Index</b></h3>
<iframe src="module/nurseform/form2c_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170" class="printcol"></iframe>
<table width="100%">
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp FEEDING</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q1","Unable;Needs help cutting, spreading butter, etc., or requires modified diet;Independent",$Q1,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp BATHING</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q2","Dependent;Independent (or in shower)",$Q2,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp GROOMING</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q3","Needs to help with personal care;Independent face/hair/teeth/shaving (implements provided)",$Q3,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp DRESSING</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q4","Dependent;Needs help but can do about half unaided;Independent (including buttons, zips, laces, etc.)",$Q4,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp BOWELS</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q5","Incontinent (or needs to be given enemas);Occasional accident;Continent",$Q5,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp BLADDER</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q6","Incontinent, or catheterized and unable to manage alone;Occasional accident;Continent",$Q6,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp TOILET USE</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q7","Dependent;Needs some help, but can do something alone;Independent (on and off, dressing, wiping)",$Q7,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp TRANSFERS (BED TO CHAIR AND BACK)</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q8","Unable, no sitting balance;Major help (one or two people, physical), can sit;Minor help (verbal or physical);Independent",$Q8,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp MOBILITY (ON LEVEL SURFACES)</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q9","Immobile or < 50 yards;Wheelchair independent, including corners, > 50 yards;Walks with help of one person (verbal or physical) > 50 yards;Independent (but may use any aid. for example, stick) > 50 yards",$Q9,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title" colspan="2" style="text-align:left;"><b>&nbsp STAIRS</b></td>
  </tr>

  <tr>
    <td colspan="2"><?php echo draw_checkbox("Q10","Unable;Needs help (verbal, physical, carrying aid);Independent",$Q10,"single"); ?></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:right;">Total score:</td>
    <td style="text-align:right;"><input type="text" name="Qtotal" id="Qtotal" size="2" value="<?php echo $Qtotal; ?>" /></td>
  </tr>
  <tr>
      <td colspan="2" class="title_s" style="text-align:left;">Note: 0-20 points: entirely dependent； 21-40 points: heavily dependent； 41-60 points: significant dependent;61-80 points: moderate dependent； 81-99 points: mild dependent； 100: fully independent;</td>
      </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>

  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02c" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
<br><br>
<script>
$(document).ready(function () {
	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Qtotal = 0;
	if ($('#Q1_1').val()==1) { Qtotal += 0; }
	if ($('#Q1_2').val()==1) { Qtotal += 5; }
	if ($('#Q1_3').val()==1) { Qtotal += 10; }
	if ($('#Q2_1').val()==1) { Qtotal += 0; }
	if ($('#Q2_2').val()==1) { Qtotal += 5; }
	if ($('#Q3_1').val()==1) { Qtotal += 0; }
	if ($('#Q3_2').val()==1) { Qtotal += 5; }
	if ($('#Q4_1').val()==1) { Qtotal += 0; }
	if ($('#Q4_2').val()==1) { Qtotal += 5; }
	if ($('#Q4_3').val()==1) { Qtotal += 10; }
	if ($('#Q5_1').val()==1) { Qtotal += 0; }
	if ($('#Q5_2').val()==1) { Qtotal += 5; }
	if ($('#Q5_3').val()==1) { Qtotal += 10; }
	if ($('#Q6_1').val()==1) { Qtotal += 0; }
	if ($('#Q6_2').val()==1) { Qtotal += 5; }
	if ($('#Q6_3').val()==1) { Qtotal += 10; }
	if ($('#Q7_1').val()==1) { Qtotal += 0; }
	if ($('#Q7_2').val()==1) { Qtotal += 5; }
	if ($('#Q7_3').val()==1) { Qtotal += 10; }
	if ($('#Q8_1').val()==1) { Qtotal += 0; }
	if ($('#Q8_2').val()==1) { Qtotal += 5; }
	if ($('#Q8_3').val()==1) { Qtotal += 10; }
	if ($('#Q8_4').val()==1) { Qtotal += 15; }
	if ($('#Q9_1').val()==1) { Qtotal += 0; }
	if ($('#Q9_2').val()==1) { Qtotal += 5; }
	if ($('#Q9_3').val()==1) { Qtotal += 10; }
	if ($('#Q9_4').val()==1) { Qtotal += 15; }
	if ($('#Q10_1').val()==1) { Qtotal += 0; }
	if ($('#Q10_2').val()==1) { Qtotal += 5; }
	if ($('#Q10_3').val()==1) { Qtotal += 10; }
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