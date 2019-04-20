<?php
$pid = (int) @$_GET['pid'];
$sql = "SELECT * FROM `careform07` WHERE `nID`='".mysql_escape_string($_GET['nID'])."' AND `HospNo`='".$HospNo."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			if (count($arrAnswer)==2) {
				${$arrAnswer[0].'_'.$arrAnswer[1]} .= $v;					
			} else if (count($arrAnswer)==3){
				if ($v==1) {
					${$arrAnswer[0].'_'.$arrAnswer[1]} .= $arrAnswer[2].';';
				}
			}else {
				${$k} = $v;
			}
		}  else {
			${$k} = $v;
		}
	}
}
if($_GET['view']!=""){
	$url = "&url=".urlencode('index.php?mod=management&func=formview&id=3&view=9');
} else{
	$url = "";
}

?>
<div class="moduleNoTab">
<form method="post" onSubmit="return checkForm();" action="index.php?func=databaseAI<?php echo $url;?>">
<h3>Indwelling catheterization bladder training record</h3>
<table cellpadding="5" style="width:100%;">
  <tr>
  	<td colspan="2" class="title">Start Date</td>
    <td colspan="5" style="text-align:left;"><script> $(function() { $( "#Q1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q1" name="Q1" value="<?php if ($Q1==NULL) { echo date('Y/m/d'); } else { echo $Q1; } ?>" size="12" /></td>
  </tr>
<?php 
  for ($i=1;$i<=3;$i++){
?>  
  <tr>
    <td class="title" colspan="8">The <?php echo $i;?> Day</td>
  </tr>
  <tr>
    <td class="title">Date of Training</td>
    <td colspan="6" style="text-align:left;"><script> $(function() { $( "#Q3_<?php echo $i;?>").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q3_<?php echo $i;?>" name="Q3_<?php echo $i;?>" size="12" value="<?php echo ${'Q3_'.$i};?>"/></td>  
  </tr>
  <tr>
      <td class="title_s">Tube Clamped Time</td>
      <td class="title_s">Tube Loosened Time</td>
      <td class="title_s">Water Intake (c.c)</td>
      <td class="title_s">Bladder Expanding +/-</td>
      <td class="title_s">Sense of Urination +/-</td>
      <td class="title_s">Urine Output (c.c)</td>
      <td class="title_s">Nurse Checks</td>
  </tr>
  <tr align="center">
      <td>07:00-08:50</td>
      <td>08:50-09:00</td>
      <td><input type="text" id="Q4_<?php echo $i;?>" name="Q4_<?php echo $i;?>" size="5" value="<?php echo ${'Q4_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q5_".$i,"+;-","s","single",${'Q5_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q6_".$i,"+;-","s","single",${'Q6_'.$i},false,5); ?></td>
      <td><input type="text" id="Q7_<?php echo $i;?>" name="Q7_<?php echo $i;?>" size="5" value="<?php echo ${'Q7_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo checkusername(${'Q27_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>09:00-10:50</td>
      <td>10:50-11:00</td>
      <td><input type="text" id="Q8_<?php echo $i;?>" name="Q8_<?php echo $i;?>" size="5" value="<?php echo ${'Q8_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q9_".$i,"+;-","s","single",${'Q9_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q10_".$i,"+;-","s","single",${'Q10_'.$i},false,5); ?></td>
      <td><input type="text" id="Q11_<?php echo $i;?>" name="Q11_<?php echo $i;?>" size="5" value="<?php echo ${'Q11_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo checkusername(${'Q28_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>11:00-12:50</td>
      <td>12:50-13:00</td>
      <td><input type="text" id="Q12_<?php echo $i;?>" name="Q12_<?php echo $i;?>" size="5" value="<?php echo ${'Q12_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q13_".$i,"+;-","s","single",${'Q13_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q14_".$i,"+;-","s","single",${'Q14_'.$i},false,5); ?></td>
      <td><input type="text" id="Q15_<?php echo $i;?>" name="Q15_<?php echo $i;?>" size="5" value="<?php echo ${'Q15_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo checkusername(${'Q29_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>13:00-15:50</td>
      <td>15:50-16:00</td>
      <td><input type="text" id="Q16_<?php echo $i;?>" name="Q16_<?php echo $i;?>" size="5" value="<?php echo ${'Q16_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q17_".$i,"+;-","s","single",${'Q17_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q18_".$i,"+;-","s","single",${'Q18_'.$i},false,5); ?></td>
      <td><input type="text" id="Q19_<?php echo $i;?>" name="Q19_<?php echo $i;?>" size="5" value="<?php echo ${'Q19_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo checkusername(${'Q30_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>16:00-17:50</td>
      <td>17:50-18:00</td>
      <td><input type="text" id="Q20_<?php echo $i;?>" name="Q20_<?php echo $i;?>" size="5" value="<?php echo ${'Q20_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q21_".$i,"+;-","s","single",${'Q21_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q22_".$i,"+;-","s","single",${'Q22_'.$i},false,5); ?></td>
      <td><input type="text" id="Q23_<?php echo $i;?>" name="Q23_<?php echo $i;?>" size="5" value="<?php echo ${'Q23_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo checkusername(${'Q31_'.$i}); ?></td>
  </tr>
  <tr align="center">
    <td class="title" colspan="2">Totally</td>
      <td><input type="text" id="Q24_<?php echo $i;?>" name="Q24_<?php echo $i;?>" size="5" value="<?php echo ${'Q24_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="text" id="Q25_<?php echo $i;?>" name="Q25_<?php echo $i;?>" size="5" value="<?php echo ${'Q25_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td>&nbsp;</td>
  </tr>
<?php }?>  
  <tr>
    <td class="title" colspan="2">End date</td>
    <td colspan="5" style="text-align:left;"><script> $(function() { $( "#Q2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q2" name="Q2" value="<?php echo $Q2; ?>" size="12" /></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Training results</td>
    <td colspan="5"><textarea id="Q26" name="Q26"><?php echo $Q26; ?></textarea></td>
  </tr>
</table>
<table style="width:100%;">
  <tr>
    <td align="left">Filled date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><div style="margin:20px 0 10px 0;">
<input type="hidden" name="formID" id="formID" value="careform07" />
<input type="hidden" name="nID" id="nID" value="<?php echo $nID; ?>" />
<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>" />
<input type="button" value="Back to list" id="back">
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
</div>
</center>
</form>
</div>
<?php
$url = explode('/', $_SERVER['REQUEST_URI']);
$file = substr($url[3],0,5);
?>
<script>
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=7&pid=<?php echo $_GET['pid']; ?>";
	});
});
function calcQtotal(day) {
	var jj = 4;
	var QTY1 = 0;
	var QTY2 = 0;
	for(j=0;j<=4;j++){
		if($("#Q"+jj+"_"+day).val().length>0 && !isNaN($("#Q"+jj+"_"+day).val())){
			QTY1 += parseFloat($("#Q"+jj+"_"+day).val());	
		} else if (isNaN($("#Q"+jj+"_"+day).val())) {
			$("#Q"+jj+"_"+day).val('');
		}
		jj+=3;
		if($("#Q"+jj+"_"+day).val().length>0 && !isNaN($("#Q"+jj+"_"+day).val())){
			QTY2 += parseFloat($("#Q"+jj+"_"+day).val());
		} else if (isNaN($("#Q"+jj+"_"+day).val())) {
			$("#Q"+jj+"_"+day).val('');
		}
		jj+=1;
	}
	$("#Q24_"+day).val(QTY1);
	$("#Q25_"+day).val(QTY2);
}
</script>

