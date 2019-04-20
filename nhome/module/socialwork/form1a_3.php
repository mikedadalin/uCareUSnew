<?php
$sql = "SELECT * FROM `nurseform22` WHERE `HospNo`='".mysql_escape_string($HospNo)."' ORDER BY `date` DESC LIMIT 0,1";
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
<center>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=save">
<h3>Resident's brief history</h3>
<table width="100%">
  <tr>
    <td width="120" class="title">Birthplace</td>
    <td><textarea name="Q1" id="Q1" cols="80" rows="6" ><?php echo $Q1; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Childhood family status</td>
    <td><textarea name="Q2" id="Q2" cols="80" rows="6" ><?php echo $Q2; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Childhood experience indulge in elaborating</td>
    <td><textarea name="Q3" id="Q3" cols="80" rows="6" ><?php echo $Q3; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">School attended</td>
    <td><textarea name="Q4" id="Q4" cols="80" rows="6" ><?php echo $Q4; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Young proud deeds</td>
    <td><textarea name="Q5" id="Q5" cols="80" rows="6" ><?php echo $Q5; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Romance</td>
    <td><textarea name="Q6" id="Q6" cols="80" rows="6" ><?php echo $Q6; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Person/ family member that is significant to the resident</td>
    <td><textarea name="Q7" id="Q7" cols="80" rows="6" ><?php echo $Q7; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Work history</td>
    <td><textarea name="Q8" id="Q8" cols="80" rows="6" ><?php echo $Q8; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">History of serving military</td>
    <td><textarea name="Q9" id="Q9" cols="80" rows="6" ><?php echo $Q9; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Religious experience</td>
    <td><textarea name="Q10" id="Q10" cols="80" rows="6" ><?php echo $Q10; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Living experience</td>
    <td><textarea name="Q11" id="Q11" cols="80" rows="6" ><?php echo $Q11; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Personality</td>
    <td><textarea name="Q12" id="Q12" cols="80" rows="6" ><?php echo $Q12; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Hobbies, Interest, Expertise</td>
    <td><textarea name="Q13" id="Q13" cols="80" rows="6" ><?php echo $Q13; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Favorite clothing</td>
    <td><textarea name="Q14" id="Q14" cols="80" rows="6" ><?php echo $Q14; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Favorites</td>
    <td><textarea name="Q15" id="Q15" cols="80" rows="6" ><?php echo $Q15; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Favorite food</td>
    <td><textarea name="Q16" id="Q16" cols="80" rows="6" ><?php echo $Q16; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Taboo / Dislikes</td>
    <td><textarea name="Q17" id="Q17" cols="80" rows="6" ><?php echo $Q17; ?></textarea></td>
  </tr>
  <tr>
    <td width="120" class="title">Recent important deeds</td>
    <td><textarea name="Q18" id="Q18" cols="80" rows="6" ><?php echo $Q18; ?></textarea></td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td style="background:#ffffff;" align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<br />
<center><input type="hidden" name="date" id="date" value="<?php if ($date==NULL) { echo date("Y/m/d"); } else { echo formatdate($date); } ?>" /><input type="hidden" name="formID" id="formID" value="nurseform22" /><input type="hidden" name="HospNo" id="HospNo" value="<?php echo $HospNo; ?>" /><button type="submit" id="submit_<?php echo $_GET['id']?>" class="SubmitCloud" onclick="window.onbeforeunload=null;return true;"><i class="fa fa-cloud-upload fa-2x"></i>Submit</button><button type="button" id="VNFormOpen" class="ButtonVN" onclick="openVerificationForm2('<?php echo $_GET['id'] ;?>');"><div><i class="fa fa-cloud-upload fa-2x"></i> <i class="fa fa-key"></i></div>Password Required</button></center>
</form>
</center><br><br>
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