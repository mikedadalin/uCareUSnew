<?php
$pid = (int) @$_GET['pid'];
if(isset($_POST['submit'])){
	//print_r($_POST);
	foreach ($_POST as $k=>$v){
		if (substr($k,0,1)=="2") {
			$arrChk = explode("_",$k);
			if($v==1){
				$db1c = new DB;
				$db1c->query("UPDATE `".$_POST['formID']."` SET `".$arrChk[1].'_'.$arrChk[2]."`='".$_SESSION['ncareID_lwj']."' WHERE `nID`='".mysql_escape_string($_POST['nID'])."'");
				//echo "UPDATE `".$_POST['formID']."` SET `".$arrChk[1].'_'.$arrChk[2]."`='".$_SESSION['ncareID_lwj']."' WHERE `nID`='".mysql_escape_string($_POST['nID'])."'<br>";
			}
		}
	}
}
$sql = "SELECT * FROM `careform07` WHERE `nID`='".mysql_escape_string($_GET['nID'])."' AND `HospNo`='".$HospNo."'";
$db1 = new DB;
$db1->query($sql);
$r1 = $db1->fetch_assoc();
//print_r($r1);
if ($db1->num_rows()>0) {
	foreach ($r1 as $k=>$v) {
		if (substr($k,0,1)=="Q") {
			$arrAnswer = explode("_",$k);
			//echo $k.':'.count($arrAnswer).';'.$v.'<br>';
			if (count($arrAnswer)==2) {
				${$arrAnswer[0].'_'.$arrAnswer[1]} = $v;				
			} elseif (count($arrAnswer)==3){
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
?>
<div class="moduleNoTab">
<form method="post" onSubmit="return checkForm();">
<h3>Indwelling catheterization bladder training checks</h3>
<table style="width:100%;">
  <tr>
  	<td colspan="2" class="title">Start Date</td>
    <td colspan="5" style="text-align:left;"><script> $(function() { $( "#Q1").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q1" name="Q1" value="<?php if ($Q1==NULL) { echo date('Y/m/d'); } else { echo $Q1; } ?>" size="12" /></td>
  </tr>
<?php 
  for ($i=1;$i<=3;$i++){
?>  
  <tr>
    <td class="title" colspan="8">The <?php echo $i;?> Day(s)</td>
  </tr>
  <tr>
    <td class="title">Date of Training</td>
    <td colspan="6" style="text-align:left;"><script> $(function() { $( "#Q3_<?php echo $i;?>").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q3_<?php echo $i;?>" name="Q3_<?php echo $i;?>" size="12" value="<?php echo ${'Q3_'.$i};?>"/></td>  
  </tr>
  <tr>
      <td class="title_s">Tube Clamped Time</td>
      <td class="title_s">Tube Loosened Time</td>
      <td class="title_s">Water Intake (c.c)</td>
      <td class="title_s">Bladder Rxpanding+/-</td>
      <td class="title_s">Sense of Urination+/-</td>
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
      <td>
      <?php
	  if(${'Q27_'.$i} ==NULL){
      ?>
          <span style="display:none;" id="Q27_<?php echo $i;?>"><?php echo checkusername($_SESSION['ncareID_lwj']);?></span>
          <input type="button" onClick="chk('Q27_<?php echo $i;?>');" value="Confirm" id="1_Q27_<?php echo $i;?>">
          <input type="hidden" id="2_Q27_<?php echo $i;?>" name="2_Q27_<?php echo $i;?>">
      <?
	  } else{
      	  echo checkusername(${'Q27_'.$i});
	  }?>
      </td>
  </tr>
  <tr align="center">
      <td>09:00-10:50</td>
      <td>10:50-11:00</td>
      <td><input type="text" id="Q8_<?php echo $i;?>" name="Q8_<?php echo $i;?>" size="5" value="<?php echo ${'Q8_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q9_".$i,"+;-","s","single",${'Q9_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q10_".$i,"+;-","s","single",${'Q10_'.$i},false,5); ?></td>
      <td><input type="text" id="Q11_<?php echo $i;?>" name="Q11_<?php echo $i;?>" size="5" value="<?php echo ${'Q11_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td>
      <?php
	  if(${'Q28_'.$i} ==NULL){
      ?>
          <span style="display:none;" id="Q28_<?php echo $i;?>"><?php echo checkusername($_SESSION['ncareID_lwj']);?></span>
          <input type="button" onClick="chk('Q28_<?php echo $i;?>');" value="Confirm" id="1_Q28_<?php echo $i;?>">
          <input type="hidden" id="2_Q28_<?php echo $i;?>" name="2_Q28_<?php echo $i;?>">
      <?
	  } else{
      	  echo checkusername(${'Q28_'.$i});
	  }?>
      </td>
  </tr>
  <tr align="center">
      <td>11:00-12:50</td>
      <td>12:50-13:00</td>
      <td><input type="text" id="Q12_<?php echo $i;?>" name="Q12_<?php echo $i;?>" size="5" value="<?php echo ${'Q12_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q13_".$i,"+;-","s","single",${'Q13_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q14_".$i,"+;-","s","single",${'Q14_'.$i},false,5); ?></td>
      <td><input type="text" id="Q15_<?php echo $i;?>" name="Q15_<?php echo $i;?>" size="5" value="<?php echo ${'Q15_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td>
      <?php
	  if(${'Q29_'.$i} ==NULL){
      ?>
          <span style="display:none;" id="Q29_<?php echo $i;?>"><?php echo checkusername($_SESSION['ncareID_lwj']);?></span>
          <input type="button" onClick="chk('Q29_<?php echo $i;?>');" value="Confirm" id="1_Q29_<?php echo $i;?>">
          <input type="hidden" id="2_Q29_<?php echo $i;?>" name="2_Q29_<?php echo $i;?>">
      <?
	  } else{
      	  echo checkusername(${'Q29_'.$i});
	  }?>
      </td>
  </tr>
  <tr align="center">
      <td>13:00-15:50</td>
      <td>15:50-16:00</td>
      <td><input type="text" id="Q16_<?php echo $i;?>" name="Q16_<?php echo $i;?>" size="5" value="<?php echo ${'Q16_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q17_".$i,"+;-","s","single",${'Q17_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q18_".$i,"+;-","s","single",${'Q18_'.$i},false,5); ?></td>
      <td><input type="text" id="Q19_<?php echo $i;?>" name="Q19_<?php echo $i;?>" size="5" value="<?php echo ${'Q19_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td>
      <?php
	  if(${'Q30_'.$i} ==NULL){
      ?>
          <span style="display:none;" id="Q30_<?php echo $i;?>"><?php echo checkusername($_SESSION['ncareID_lwj']);?></span>
          <input type="button" onClick="chk('Q30_<?php echo $i;?>');" value="Confirm" id="1_Q30_<?php echo $i;?>">
          <input type="hidden" id="2_Q30_<?php echo $i;?>" name="2_Q30_<?php echo $i;?>">
      <?
	  } else{
      	  echo checkusername(${'Q30_'.$i});
	  }?>
      </td>
  </tr>
  <tr align="center">
      <td>16:00-17:50</td>
      <td>17:50-18:00</td>
      <td><input type="text" id="Q20_<?php echo $i;?>" name="Q20_<?php echo $i;?>" size="5" value="<?php echo ${'Q20_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td><?php echo draw_option("Q21_".$i,"+;-","s","single",${'Q21_'.$i},false,5); ?></td>
      <td><?php echo draw_option("Q22_".$i,"+;-","s","single",${'Q22_'.$i},false,5); ?></td>
      <td><input type="text" id="Q23_<?php echo $i;?>" name="Q23_<?php echo $i;?>" size="5" value="<?php echo ${'Q23_'.$i};?>" onBlur="calcQtotal('<?php echo $i; ?>');">cc</td>
      <td>
      <?php
	  if(${'Q31_'.$i} ==NULL){
      ?>
          <span style="display:none;" id="Q31_<?php echo $i;?>"><?php echo checkusername($_SESSION['ncareID_lwj']);?></span>
          <input type="button" onClick="chk('Q31_<?php echo $i;?>');" value="Confirm" id="1_Q31_<?php echo $i;?>">
          <input type="hidden" id="2_Q31_<?php echo $i;?>" name="2_Q31_<?php echo $i;?>">
      <?
	  } else{
      	  echo checkusername(${'Q31_'.$i});
	  }?>
      </td>
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
    <td class="title" colspan="2">End Date</td>
    <td colspan="5" style="text-align:left;"><script> $(function() { $( "#Q2").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" id="Q2" name="Q2" value="<?php echo $Q2; ?>" size="12" /></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Training Results</td>
    <td colspan="5"><textarea id="Q26" name="Q26" style="resize:none;"><?php echo $Q26; ?></textarea></td>
  </tr>
</table>
<table style="width:100%;">
  <tr>
    <td align="left">Filled Date：<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($date != NULL) { echo formatdate($date); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled By : <?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><div style="margin:20px 0 10px 0;">
<input type="hidden" name="formID" id="formID" value="careform07" />
<input type="hidden" name="nID" id="nID" value="<?php echo $nID; ?>" />
<input type="hidden" name="action" id="action" value="check" />
<input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" />
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<input type="button" value="Back to list" id="back">
<input type="hidden" id="submit" value="Save" name="submit"/><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button>
<?php }?>
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
		location.href = "index.php?mod=carework&func=formview&id=7&action=chk&pid=<?php echo $_GET['pid']; ?>";
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
function chk(id){
	$("#"+id).toggle();
		
	if($("#"+id).is(":hidden")){
		$("#1_"+id).val('Confirm');
		$("#2_"+id).val('0');
	}else{
		$("#1_"+id).val('Cancel');
		$("#2_"+id).val('1');
	}
}
</script>
<?php
foreach ($r1 as $k=>$v) {
	if (substr($k,0,1)=="Q") {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			${$arrAnswer[0].'_'.$arrAnswer[1]} = "";				
		} else if (count($arrAnswer)==3){
			if ($v==1) {
				${$arrAnswer[0].'_'.$arrAnswer[1]} = "";
			}
		}else {
			${$k} = "";
		}
	}  else {
		${$k} = "";
	}
}
?>

