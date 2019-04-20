<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `rehabilitationform05` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `rehabilitationform05` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Wheelchair/Special Wheelchair Assessment</h3>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<table border="0" width="100%">
  <tr>
    <td colspan="4" class="title">Posture of Body Parts</td>
  </tr>
  <tr>
    <td width="21%" class="title_s">Pelvis</td>
    <td colspan="2"><?php echo draw_option("Q1","Normal;Anterior/posterior tilt;Left / right tilt","xl","multi",$Q1,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Spine</td>
    <td colspan="2"><?php echo draw_option("Q2","Normal;Scoliosis;Kyphosis;Lordosis","m","multi",$Q2,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Shoulder</td>
    <td colspan="2"><?php echo draw_option("Q3","Normal;Shrink back;Protrusion","xm","multi",$Q3,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Hip</td>
    <td colspan="2"><?php echo draw_option("Q4","Normal;Retracted;flared;Other","m","multi",$Q4,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Knee(s)</td>
    <td colspan="2"><?php echo draw_option("Q5","Normal;Bent;Hyperextended","l","multi",$Q5,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Ankle</td>
    <td colspan="2"><?php echo draw_option("Q6","Normal;Bent;Hyperextended","l","multi",$Q6,false,2); ?></td>
  </tr>
  <tr>
    <td class="title_s">Arthrogryposis site</td>
    <td colspan="2"><input type="text" id="Q7" name="Q7" value="<?php echo $Q7; ?>"></td>
  </tr>
  <tr>
    <td class="title">Sitting balance</td>
    <td colspan="2"><?php echo draw_checkbox_nobr("Q8","Good;Balanced with both hands supporting;Unbalanced with both hands supporting",$Q8,"single"); ?></td>
   </tr>
  <tr>
    <td class="title">Sensation</td>
    <td colspan="2"><?php echo draw_option("Q9","Normal;Abnormal;Unassessable","xl","multi",$Q9,false,2); ?></td>
  </tr>
  <tr>
    <td class="title">Wheelchair types</td>
    <td colspan="2"><?php echo draw_checkbox("Q10","General;Special",$Q10,"single"); ?><?php echo draw_checkbox_nobr("Q11","Hard and foldable;Hard and non-foldable;Lying back;Reclining back <br>;Other:<input type=\"text\" name=\"Q11a\" id=\"Q11a\" size=\"10\" value=\"".$Q11a."\" />",$Q11,"single"); ?></td>
  </tr>
  <tr>
    <td colspan="3" class="title">Wheelchair Check and Configuration</td>
  </tr>
  <tr>
    <td class="title">Item(s)</td>
    <td colspan="2" class="title">Inspection result</td>    
  </tr>
  <tr>
    <td class="title">Seat upholstery</td>
    <td colspan="2"><?php echo draw_option("Q12","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q12,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Seat carry strap</td>
    <td colspan="2"><?php echo draw_option("Q13","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q13,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Back upholstery</td>
    <td colspan="2"><?php echo draw_option("Q14","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q14,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">H shape band(vest)</td>
    <td colspan="2"><?php echo draw_option("Q15","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q15,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Headrest</td>
    <td colspan="2"><?php echo draw_option("Q16","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q16,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Padded armrest</td>
    <td colspan="2"><?php echo draw_option("Q17","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q17,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Wheel locks(breaks)</td>
    <td colspan="2"><?php echo draw_option("Q18","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q18,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Anti-tippers</td>
    <td colspan="2"><?php echo draw_option("Q19","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q19,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Rear tire</td>
    <td colspan="2"><?php echo draw_option("Q20","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q20,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Rims</td>
    <td colspan="2"><?php echo draw_option("Q21","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q21,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Footplate</td>
    <td colspan="2"><?php echo draw_option("Q22","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q22,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Legrest</td>
    <td colspan="2"><?php echo draw_option("Q23","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q23,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Calf pad</td>
    <td colspan="2"><?php echo draw_option("Q24","Intact;Damaged;Discomfort equipped;Need not;Need upgrades","xl","multi",$Q24,true,3); ?></td>
  </tr>
  <tr>
    <td rowspan="3" class="title">Summary:</td>
    <td >1.Wheelchairs or special wheelchair applicability:</td>
    <td ><?php echo draw_option("Q25","Appropriate;Need changes;Must replaced","l","multi",$Q25,false,2); ?></td>
  </tr>
  <tr>
    <td>2.Need to receive wheelchair operational training :</td>
    <td><?php echo draw_option("Q26","Need;Need not","m","multi",$Q26,false,2); ?></td>
  </tr>
  <tr>
    <td>3.Recommendations:</td>
    <td><input type="text" id="Q27" name="Q27" value="<?php echo $Q27; ?>" size="40"></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>

<center>
  <div style="margin-top:30px; margin-bottom:10px;">
  <input type="hidden" name="formID" id="formID" value="rehabilitationform05" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
  </div>
</center>
</form>
<?php
$url = explode('/',$_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
?>
<script>
$(document).ready(function () {
	<?php if($file=="index"){echo 'calcQtotal';}?>
//	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Qtotal1 = 0;
	var Qtotal2 = 0;
	var Qtotal3 = 0;
	var Qtotal4 = 0;
	for(var i=0;i<7;i++){
		if ($('#Q18_'+i).val()==1) { Qtotal1 += (i-1); }
		if ($('#Q19_'+i).val()==1) { Qtotal1 += (i-1); }		
		if ($('#Q20_'+i).val()==1) { Qtotal1 += (i-1); }		
		if ($('#Q21_'+i).val()==1) { Qtotal2 += (i-1); }		
		if ($('#Q22_'+i).val()==1) { Qtotal2 += (i-1); }		
		if ($('#Q23_'+i).val()==1) { Qtotal3 += (i-1); }		
		if ($('#Q24_'+i).val()==1) { Qtotal3 += (i-1); }		
		if ($('#Q25_'+i).val()==1) { Qtotal3 += (i-1); }		
		if ($('#Q26_'+i).val()==1) { Qtotal4 += (i-1); }		
		if ($('#Q27_'+i).val()==1) { Qtotal4 += (i-1); }		
	}
	$('#Qtotal1').val(Qtotal1);
	$('#Qtotal2').val(Qtotal2);	
	$('#Qtotal3').val(Qtotal3);
	$('#Qtotal4').val(Qtotal4);	
}
</script>