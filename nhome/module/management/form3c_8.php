<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['nID']);

$db1 = new DB;
$db1->query("SELECT * FROM `careform07` WHERE `nID`='".$targetID."'");
$r1 = $db1->fetch_assoc();

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
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=delete&targetID=<?php echo $targetID; ?>">
<h3>Indwelling catheterization bladder training record</h3>
<table width="100%">
  <tr>
  	<td colspan="2" class="title">Start date</td>
    <td colspan="5"><?php echo $Q1;  ?></td>
  </tr>
<?php 
  for ($i=1;$i<=3;$i++){
?>  
  <tr>
    <td class="title" colspan="8">The <?php echo $i;?>Day(s)</td>
  </tr>
  <tr>
    <td class="title">Date of training</td>
    <td colspan="6"><?php echo ${'Q3_'.$i}; ?></td>  
  </tr>
  <tr>
      <td class="title_s">Tube clamped time</td>
      <td class="title_s">Tube loosened time</td>
      <td class="title_s">Water intake (c.c)</td>
      <td class="title_s">Bladder expanding+/-</td>
      <td class="title_s">Sense of urination+/-</td>
      <td class="title_s">Urine output (c.c)</td>
      <td class="title_s">Nurse checks</td>
  </tr>
  <tr align="center">
      <td>07:00-08:50</td>
      <td>08:50-09:00</td>
      <td><?php echo ${'Q4_'.$i};?> cc</td>
      <td><?php echo option_result("Q5_".$i,"+;-","s","single",${'Q5_'.$i},false,5); ?></td>
      <td><?php echo option_result("Q6_".$i,"+;-","s","single",${'Q6_'.$i},false,5); ?></td>
      <td><?php echo ${'Q7_'.$i};?> cc</td>
      <td><?php echo checkusername(${'Q27_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>09:00-10:50</td>
      <td>10:50-11:00</td>
      <td><?php echo ${'Q8_'.$i};?> cc</td>
      <td><?php echo option_result("Q9_".$i,"+;-","s","single",${'Q9_'.$i},false,5); ?></td>
      <td><?php echo option_result("Q10_".$i,"+;-","s","single",${'Q10_'.$i},false,5); ?></td>
      <td><?php echo ${'Q11_'.$i};?> cc</td>
      <td><?php echo checkusername(${'Q28_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>11:00-12:50</td>
      <td>12:50-13:00</td>
      <td><?php echo ${'Q12_'.$i};?> cc</td>
      <td><?php echo option_result("Q13_".$i,"+;-","s","single",${'Q13_'.$i},false,5); ?></td>
      <td><?php echo option_result("Q14_".$i,"+;-","s","single",${'Q14_'.$i},false,5); ?></td>
      <td><?php echo ${'Q15_'.$i};?> cc</td>
      <td><?php echo checkusername(${'Q29_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>13:00-15:50</td>
      <td>15:50-16:00</td>
      <td><?php echo ${'Q16_'.$i};?> cc</td>
      <td><?php echo option_result("Q17_".$i,"+;-","s","single",${'Q17_'.$i},false,5); ?></td>
      <td><?php echo option_result("Q18_".$i,"+;-","s","single",${'Q18_'.$i},false,5); ?></td>
      <td><?php echo ${'Q19_'.$i};?> cc</td>
      <td><?php echo checkusername(${'Q30_'.$i}); ?></td>
  </tr>
  <tr align="center">
      <td>16:00-17:50</td>
      <td>17:50-18:00</td>
      <td><?php echo ${'Q20_'.$i};?> cc</td>
      <td><?php echo option_result("Q21_".$i,"+;-","s","single",${'Q21_'.$i},false,5); ?></td>
      <td><?php echo option_result("Q22_".$i,"+;-","s","single",${'Q22_'.$i},false,5); ?></td>
      <td><?php echo ${'Q23_'.$i};?> cc</td>
      <td><?php echo checkusername(${'Q31_'.$i}); ?></td>
  </tr>
  <tr align="center">
    <td class="title" colspan="2">Totally</td>
      <td><?php echo ${'Q24_'.$i};?> cc</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php echo ${'Q25_'.$i};?> cc</td>
      <td>&nbsp;</td>
  </tr>
<?php }?>  
  <tr>
    <td class="title" colspan="2">End date</td>
    <td colspan="5"><?php echo $Q2; ?></td>
  </tr>
  <tr>
    <td class="title" colspan="2">Training results</td>
    <td colspan="5"><?php echo $Q26; ?></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td class="title">Filled date</td>
    <td><?php echo formatdate($date); ?></td>
    <td class="title">Filled by</td>
	<td><?php echo checkusername($Qfiller); ?></td>
  </tr>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="3"><input type="hidden" name="formID" id="formID" value="careform07" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
</table>
</form>