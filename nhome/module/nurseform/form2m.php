<?php
$pid = (int) @$_GET['pid'];
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform02m` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform02m` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Instrumental Activities of Daily Living (IADL)</h3>
<iframe src="module/nurseform/form2m_chart.php?pid=<?php echo $pid; ?>" frameborder="0" width="940" height="170" class="printcol" ></iframe>
<table width="100%">
  <tr>
      <td class="title" width="120">Shopping</td>
    <td><?php echo draw_checkbox("Q1","Not applicable;3 points: Takes care of all shopping needs independently;2 points： Shops independently for small purchases;1 point： Needs to be accompanied on any  shopping trip;0 point ： Completely unable to shop ",$Q1,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title">Mode of transportation</td>
    <td><?php echo draw_checkbox("Q2","Not applicable;4 points：Travels independently on public transportation or drives own car;3 points： Arranges own travel via taxi, but does not otherwise use public transportation;2 points：Travels on public transportation when assisted or accompanied by another ;1 point： Travel limited to taxi or automobile with assistance of another ;0 point： Does not travel at all ",$Q2,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title"> Food preparation</td>
    <td><?php echo draw_checkbox("Q3","Not applicable;3 points：Plans, prepares, and serves adequate meals independently ;2 points： Prepares adequate meals if supplied with ingredients ;1 point：Heats and serves prepared meals, or prepares meals but does not maintain  adequate diet ;0 point： Needs to have meals prepared and served",$Q3,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title">Housekeeping</td>
    <td><?php echo draw_checkbox("Q4","Not applicable;4 points：Maintains house alone or with occasional assistance (e.g., heavy work domestic help) ;3 points：Performs light daily tasks such as dishwashing, bed making;2 points：Performs light daily tasks but cannot maintain acceptable level of cleanliness;1 point：Needs help with all home maintenance tasks;0 point： Does not participate in any housekeeping tasks.",$Q4,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title">Laundry</td>
    <td><?php echo draw_checkbox("Q5","Not applicable;2 points：Does personal laundry completely;1 point：Launders small items such as rinses stockings, etc. ;0 point：All laundry must be done by others",$Q5,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title">Ability to use telephone</td>
    <td><?php echo draw_checkbox("Q6","Not applicable;3 points：Operates telephone on own initiative such as looks up and dials numbers, etc. ;2 points：Dials a few well-known numbers ;1 point：Answers telephone but does not dial;0 point：Does not use telephone at all",$Q6,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title">Responsibility for own medications</td>
    <td><?php echo draw_checkbox("Q7","Not applicable;3 points：Is responsible for taking medication in correct dosages at correct time;2 points： Takes responsibility if medication is prepared in advance in separate dosages ;1 point：Is not capable of dispensing own medication ",$Q7,"single"); ?></td>
    
    
  </tr>
  <tr>
      <td class="title">Ability to handle finances</td>
    <td><?php echo draw_checkbox("Q8","Not applicable;2 points： Manages financial matters independently (budgets, writes checks, pays rent and bills,  goes to bank), collects and keeps track of income ;1 point： Manages day-to-day purchases, but needs help with banking, major purchases, etc. ;0 point：Incapable of handling money.",$Q8,"single"); ?></td>
    
    
  </tr>
  <tr>
    <td class="title_s" style="text-align:right; text-align:center;">Total score:</td>
    <td style="text-align:right;"><input type="text" name="Qtotal" id="Qtotal" size="2" value="<?php echo $Qtotal; ?>" /></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform02m" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
<script>
$(document).ready(function () {
	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Scores = {'1':'3', '2':'4', '3':'3', '4':'4', '5':'2', '6':'3', '7':'3', '8':'2' };
	var Qtotal = 0;
	for (var i=1;i<=8;i++) {
		if ($('#Q'+i+'_1').val()==1) { Qtotal += parseInt(Scores[i]); }
		for (var i1=2;i1<=(parseInt(Scores[i])+1);i1++) {
			if ($('#Q'+i+'_'+i1).val()==1) { Qtotal += parseInt(Scores[i])-i1+2; }
		}
	}
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