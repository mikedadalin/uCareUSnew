<?php
if (@$_GET['date']=='') {
	$sql = "SELECT * FROM `nurseform11a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `nurseform11a` WHERE `HospNo`='".mysql_escape_string($HospNo)."' AND `date`='".mysql_escape_string($_GET['date'])."'";
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
<h3>Happiness and misery index</h3>
<table width="100%" border="0">
  <tr>
    <td class="title" style="text-align:left; width:50%;">&nbsp;&nbsp;Can communicate wants. need & choices</td>
    <td><?php echo draw_option("Q1","None;Some;Obvious","xm","single",$Q1,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Make contact with other people</td>
    <td><?php echo draw_option("Q2","None;Some;Obvious","xm","single",$Q2,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Show warmth or affection</td>
    <td><?php echo draw_option("Q3","None;Some;Obvious","xm","single",$Q3,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Shows pleasure or enjoyment</td>
    <td><?php echo draw_option("Q4","None;Some;Obvious","xm","single",$Q4,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Alertness, responsiveness</td>
    <td><?php echo draw_option("Q5","None;Some;Obvious","xm","single",$Q5,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Uses remaining abilities</td>
    <td><?php echo draw_option("Q6","None;Some;Obvious","xm","single",$Q6,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Expresses self creatively</td>
    <td><?php echo draw_option("Q7","None;Some;Obvious","xm","single",$Q7,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Is co-operative emotions</td>
    <td><?php echo draw_option("Q8","None;Some;Obvious","xm","single",$Q8,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Appropriately react to people/situation</td>
    <td><?php echo draw_option("Q9","None;Some;Obvious","xm","single",$Q9,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Expresses appropriate emotions</td>
    <td><?php echo draw_option("Q10","None;Some;Obvious","xm","single",$Q10,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Relax posture or body language</td>
    <td><?php echo draw_option("Q11","None;Some;Obvious","xm","single",$Q11,false,0); ?></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Sense of humor</td>
    <td><?php echo draw_option("Q12","None;Some;Obvious","xm","single",$Q12,false,0); ?></td>
  </tr>  
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Sense of purpose</td>
    <td><?php echo draw_option("Q13","None;Some;Obvious","xm","single",$Q13,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Signs of self-respect</td>
    <td><?php echo draw_option("Q14","None;Some;Obvious","xm","single",$Q14,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Total score</td>
    <td><center><h3>
    <span id="total"><?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?></span>
    <input type="hidden" name="Qtotal" id="Qtotal" value="<?php if ($Qtotal==NULL) { echo "0"; } else { echo  $Qtotal; } ?>" />
    </h3></center></td>
  </tr>
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Depressed or despairing</td>
    <td><?php echo draw_option("Q15","None;Some;Obvious","xm","single",$Q15,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Intensively angry or aggressive</td>
    <td><?php echo draw_option("Q16","None;Some;Obvious","xm","single",$Q16,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Show anxiety or tear</td>
    <td><?php echo draw_option("Q17","None;Some;Obvious","xm","single",$Q17,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Agitated or restless</td>
    <td><?php echo draw_option("Q18","None;Some;Obvious","xm","single",$Q18,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Withdrawn or lasses</td>
    <td><?php echo draw_option("Q19","None;Some;Obvious","xm","single",$Q19,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Has physical discomfort or pain</td>
    <td><?php echo draw_option("Q20","None;Some;Obvious","xm","single",$Q20,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Unresolved grieving over lasses</td>
    <td><?php echo draw_option("Q21","None;Some;Obvious","xm","single",$Q21,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Bodily tension</td>
    <td><?php echo draw_option("Q22","None;Some;Obvious","xm","single",$Q22,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Easily 'walked over' by other people</td>
    <td><?php echo draw_option("Q23","None;Some;Obvious","xm","single",$Q23,false,0); ?></td>
  </tr>    
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;An outsider</td>
    <td><?php echo draw_option("Q24","None;Some;Obvious","xm","single",$Q24,false,0); ?></td>
  </tr> 
  <tr>
    <td class="title" style="text-align:left;">&nbsp;&nbsp;Total score</td>
    <td><center><h3>
    <span id="total1"><?php if ($Qtotal1==NULL) { echo "0"; } else { echo  $Qtotal1; } ?></span>
    <input type="hidden" name="Qtotal1" id="Qtotal1" value="<?php if ($Qtotal1==NULL) { echo "0"; } else { echo  $Qtotal1; } ?>" />
    </h3></center></td>
  </tr>
</table>


<table width="100%">
  <tr>
    <td>Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if($_GET['newDate']!="") { echo formatdate($_GET['newDate']); } else { if ($date != NULL) { echo formatdate($date); } } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><input type="hidden" name="formID" id="formID" value="nurseform11a" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form><br><br>
<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
if ($file=="index") {
?>
<script>
$(document).ready(function () {
	calcQtotal();
	$("[id*='btn_Q']").click(function() {
		calcQtotal();
	});
})
function calcQtotal() {
	var Qtotal = 0;
	var Qtotal1 = 0;
	for (i=1;i<=14;i++) {
		if ($('#Q'+i+'_2').val()==1) { Qtotal += 1; }
		if ($('#Q'+i+'_3').val()==1) { Qtotal += 2; }
	}
	for (i=15;i<=24;i++) {
		if ($('#Q'+i+'_2').val()==1) { Qtotal1 += 1; }
		if ($('#Q'+i+'_3').val()==1) { Qtotal1 += 2; }
	}
	//if ($('#Qtotal').val()==0) {
		$('#Qtotal').val(Qtotal);
		$('#total').html(Qtotal);
		$('#Qtotal1').val(Qtotal1);
		$('#total1').html(Qtotal1);
	//}
}
</script>
<?php
}
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