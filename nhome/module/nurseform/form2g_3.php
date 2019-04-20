<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02g_3` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02g_3` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Braden Pressure Sore Risk Scale</h3>
<iframe src="module/nurseform/form2g_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170" class="printcol"></iframe>
<form action="" method="post" onSubmit="return checkForm();">
<table width="100%">
  <tr class="title">
    <td width="220">Assessment item</td>
    <td width="198">1 point</td>
    <td width="198">2 point</td>
    <td width="198">3 point</td>
    <td width="198">4 point</td>
    <td width="120">Subtotal</td>
  </tr>
  <tr>
    <td class="title">Sensory perception</td>
    <td valign="top"><?php echo draw_checkbox("Q1","<b>Completely Limited</b>(Unresponsive to painful stimuli)",$Q1,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q2","<b>Very Limited</b>(Responds only to painful stimuli) ",$Q2,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q3","<b>Slightly Limited</b>(Responds to verbal commands,but cannot always communicate)",$Q3,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q4","<b>No Impairment</b>",$Q4,"single"); ?></td>
    <td><input type="text" name="Q1total" id="Q1total" size="3" value="<?php echo $Q1total; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Moisture</td>
    <td valign="top"><?php echo draw_checkbox("Q5","<b>Constantly Moist</b>(Skin is kept moist almost constantly by perspiration,urine, etc)",$Q5,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q6","<b>Very Moist</b>(Skin is often, but not alway moist. Linen must be changed at least once a shift)",$Q6,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q7","<b>Occasionally</b> Moist(Skin is occasionally moist,requiring an extra linen change approximately once a day)",$Q7,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q8","<b>Rarely Moist</b>(Skin is usually dry, linen only requires changing at routine intervals)",$Q8,"single"); ?></td>
    <td><input type="text" name="Q2total" id="Q2total" size="3" value="<?php echo $Q2total; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Activity</td>
    <td valign="top"><?php echo draw_checkbox("Q9","<b>Bedfast</b>",$Q9,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q10","<b>Chairfast</b>(Ability to walk severely limited or non-existent)",$Q10,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q11","<b>Walks Occasionally</b> (Walks occasionally during day,but for very short distances)",$Q11,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q12","<b>No Limitation</b>(Makes major and frequent changes in position without assistance)",$Q12,"single"); ?></td>
    <td><input type="text" name="Q3total" id="Q3total" size="3" value="<?php echo $Q3total; ?>"/></td>
  </tr>
  <tr>
    <td class="title">Mobility</td>
    <td valign="top"><?php echo draw_checkbox("Q13","<b>Completely unable</b> to turn over on their own.",$Q13,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q14","<b>Very Limited</b>unable to make frequent or significant changes independently",$Q14,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q15","<b>Slightly Limited</b> makes frequent though slight changes in body or extremity position independently",$Q15,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q16","<b>No Limitation</b> makes major and frequent changes in position without assistance. ",$Q16,"single"); ?></td>
    <td><input type="text" name="Q4total" id="Q4total" size="3" value="<?php echo $Q4total; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Nutritional status</td>
    <td valign="top"><?php echo draw_checkbox("Q17","<b>Very Poor</b>( Never eats a complete meal.Rarely eats more than half of any food offered)",$Q17,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q18","<b>Probably Inadequate</b> (Rarely eats a complete meal and generally eats only about half of any food offered)",$Q18,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q19","<b>Adequate</b> (Occasionally will refuse a meal, but will usually take a supplement when offered)",$Q19,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q20","<b>Excellent</b> (Eats most of every meal. Never refuses a meal)",$Q20,"single"); ?></td>
    <td><input type="text" name="Q5total" id="Q5total" size="3" value="<?php echo $Q5total; ?>" /></td>
  </tr>
  <tr>
    <td class="title">Friction/Shear)</td>
    <td valign="top"><?php echo draw_checkbox("Q21","<b>Problem</b> (Requires moderate to maximum assistance in moving.)",$Q21,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q22","<b>Potential Problem</b> (Moves feebly or requires minimum assistance)",$Q22,"single"); ?></td>
    <td valign="top"><?php echo draw_checkbox("Q23","<b>No Apparent Problem</b>",$Q23,"single"); ?></td>
    <td valign="top">&nbsp;</td>
    <td><input type="text" name="Q6total" id="Q6total" size="3" value="<?php echo $Q6total; ?>" /></td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:right" colspan="5">Total score:</td>
    <td><input type="text" name="Qtotal" id="Qtotal" size="3" value="<?php echo $Qtotal; ?>" />/23</td>
  </tr>
  <tr>
    <td class="title_s" style="text-align:left" colspan="4">Risk<br />Low：Score ≧16：Daily skin condition assessment<br />
    Moderate：Score 12~15：Turnover and pat back every 2 hours plus skin assessment. <br />High: Score ≦11：Turnover,pat back every 2 hours plus skin assessment.Apply air bed.</td>
    <td class="title_s" style="text-align:right">Risk Assessment Results:</td>
    <td><input type="text" name="Qresult" id="Qresult" size="6"   value="<?php echo $Qresult; ?>"/></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02g_3" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>

<script>
$(document).ready(function () {
	//calcTotal2();
	$("[id*='btn_Q']").click(function() {
		calcTotal($(this).attr('id'));
	});
})

function calcQ1(btnid) {
	var Q1total = 0;
	if (btnid) {
		var btn = btnid.replace("btn_", "");
		var count = 1;
		for (var i=1;i<=4;i++) {
			if (btn!='Q'+i+'_1') {
				$('#Q'+i+'_1').val(0);
				$('#Q'+i+'_1').val(0);$('#btn_Q'+i+'_1').removeClass( "checkbox_on" ).addClass( "checkbox_off" );
				count++;
			} else {
				Q1total = count;
				count++;
			}
		}
		$('#Q1total').val(Q1total);
	}
}

function calcQ2(btnid) {
	var Q2total = 0;
	if (btnid) {
		var btn = btnid.replace("btn_", "");
		var count = 1;
		for (var i=5;i<=8;i++) {
			if (btn!='Q'+i+'_1') {
				$('#Q'+i+'_1').val(0);
				$('#Q'+i+'_1').val(0);$('#btn_Q'+i+'_1').removeClass( "checkbox_on" ).addClass( "checkbox_off" );
				count++;
			} else {
				Q2total = count;
				count++;
			}
		}
		$('#Q2total').val(Q2total);
	}
}

function calcQ3(btnid) {
	var Q3total = 0;
	if (btnid) {
		var btn = btnid.replace("btn_", "");
		var count = 1;
		for (var i=9;i<=12;i++) {
			if (btn!='Q'+i+'_1') {
				$('#Q'+i+'_1').val(0);
				$('#Q'+i+'_1').val(0);$('#btn_Q'+i+'_1').removeClass( "checkbox_on" ).addClass( "checkbox_off" );
				count++;
			} else {
				Q3total = count;
				count++;
			}
		}
		$('#Q3total').val(Q3total);
	}
}

function calcQ4(btnid) {
	var Q4total = 0;
	if (btnid) {
		var btn = btnid.replace("btn_", "");
		var count = 1;
		for (var i=13;i<=16;i++) {
			if (btn!='Q'+i+'_1') {
				$('#Q'+i+'_1').val(0);
				$('#Q'+i+'_1').val(0);$('#btn_Q'+i+'_1').removeClass( "checkbox_on" ).addClass( "checkbox_off" );
				count++;
			} else {
				Q4total = count;
				count++;
			}
		}
		$('#Q4total').val(Q4total);
	}
}

function calcQ5(btnid) {
	var Q5total = 0;
	if (btnid) {
		var btn = btnid.replace("btn_", "");
		var count = 1;
		for (var i=17;i<=20;i++) {
			if (btn!='Q'+i+'_1') {
				$('#Q'+i+'_1').val(0);
				$('#Q'+i+'_1').val(0);$('#btn_Q'+i+'_1').removeClass( "checkbox_on" ).addClass( "checkbox_off" );
				count++;
			} else {
				Q5total = count;
				count++;
			}
		}
		$('#Q5total').val(Q5total);
	}
}

function calcQ6(btnid) {
	var Q6total = 0;
	if (btnid) {
		var btn = btnid.replace("btn_", "");
		var count = 1;
		for (var i=21;i<=23;i++) {
			if (btn!='Q'+i+'_1') {
				$('#Q'+i+'_1').val(0);
				$('#Q'+i+'_1').val(0);$('#btn_Q'+i+'_1').removeClass( "checkbox_on" ).addClass( "checkbox_off" );
				count++;
			} else {
				Q6total = count;
				count++;
			}
		}
		$('#Q6total').val(Q6total);
	}
}

function calcTotal(btnid) {
	if ($('#Q1total').val()=="") { $('#Q1total').val(0); }
	if ($('#Q2total').val()=="") { $('#Q2total').val(0); }
	if ($('#Q3total').val()=="") { $('#Q3total').val(0); }
	if ($('#Q4total').val()=="") { $('#Q4total').val(0); }
	if ($('#Q5total').val()=="") { $('#Q5total').val(0); }
	if ($('#Q6total').val()=="") { $('#Q6total').val(0); }
	if (btnid) {
		var btn = btnid.replace("btn_Q", "");
		var arrBtn = btn.split("_");
		if (arrBtn[0]<=4) {
			calcQ1(btnid);
		} else if (arrBtn[0]<=8) { 
			calcQ2(btnid);
		} else if (arrBtn[0]<=12) {
			calcQ3(btnid);
		} else if (arrBtn[0]<=16) {
			calcQ4(btnid);
		} else if (arrBtn[0]<=20) {
			calcQ5(btnid);
		} else if (arrBtn[0]<=23) {
			calcQ6(btnid);
		}
	}
	var Qtotal = parseInt($('#Q1total').val())+parseInt($('#Q2total').val())+parseInt($('#Q3total').val())+parseInt($('#Q4total').val())+parseInt($('#Q5total').val())+parseInt($('#Q6total').val());
	$('#Qtotal').val(Qtotal);
	if (Qtotal>=16) { $('#Qresult').val("Low"); $('#Qresult').css({"background-color": "#D1E3B1"}); }
	else if (Qtotal>=12) { $('#Qresult').val("Moderate"); $('#Qresult').css({"background-color": "#FFB871"}); }
	else if (Qtotal>0){ $('#Qresult').val("High"); $('#Qresult').css({"background-color": "#FFB871"}); }
	else { $('#Qresult').val("None"); $('#Qresult').css({"background-color": "#FFFFFF"}); }
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