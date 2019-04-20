<?php
$HospNo = getHospNo(@$_GET['pid']);
$date = mysql_escape_string($_GET['date']);
$no = mysql_escape_string($_GET['tID']);
$db1 = new DB;
$db1->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `no`='".$no."'");
$r1 = $db1->fetch_assoc();

foreach ($r1 as $k=>$v) {
	$arrPatientInfo = explode("_",$k);
	if (count($arrPatientInfo)>1) {
		$varname = "";
		for ($i=0;$i<(count($arrPatientInfo)-1);$i++) {
			if ($v==1) {
				if ($varname!="") { $varname .= '_'; }
				$varname .= $arrPatientInfo[$i];
			}
		}
		//echo $varname.'<br>';
		${$varname} .= $arrPatientInfo[(count($arrPatientInfo)-1)].';';
	} else {
		${$k} = $v;
	}
}
if (isset($_POST['submit'])) {
	$db1 = new DB;
	$db1->query("UPDATE `nurseform02g_2` SET `Q28_1`='0', `Q28_2`='1' WHERE `HospNo`='".$HospNo."' AND `date`='".$date."' AND `no`='".$no."'");
	echo '<script>alert("刪除成功!!");window.location.href="index.php?mod=management&func=formview&view=5&part=1&id=3";</script>';
}
?>
<form  method="post">
<h3>Pressure ulcer record</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table width="100%">
  <tr>
    <td width="120" class="title">Care ID#</td>
    <td><?php echo getHospNoDisplayByPID(@$_GET['pid']); ?></td>
    <td width="120" class="title">Resident name</td>
    <td><?php echo getPatientName(getPID($HospNo)); ?></td>
  </tr>
  <tr>
    <td class="title">Produced date</td>
    <td><?php echo $Q7; ?></td>
    <td class="title">Healed date</td>
    <td><?php echo $Q26; ?></td>
  </tr>
  <tr>
    <td class="title">Pressure ulcer(s) stage</td>
    <td>
	<?php echo checkbox_result("Q4","Stage 1;Stage 2;Stage 3;Stage 4;Unstageable<br>Non-removable dressing;Unstageable<br>Slough and/or eschar;Unstageable<br>Deep tissue",$Q4,"multi");	?>
    </td>
    <td class="title">Braden Pressure Sore Risk Scale</td>
    <td><?php echo $Q27; ?></td>
  </tr>
  <tr>
    <td class="title">Pressure sores location/body part(s)</td>
    <td colspan="3"><?php echo option_result("Q2","Forehead;Nose;Chin;Outer ear;Occipital;Breast;Chest;Rib cage;Costal arch;Scapula;Humerus;Elbow;Abdomen;Spine protruding spot;Scrotum;Perineum;Sacral vertebrae;Buttock;Hip ridge;Ischial tuberosity;Front knee;Medial knee;Fibula;Lateral ankle;Inner ankle;Heel;Toe;Plantar;Intertrochanteric;Other","m","multi",$Q2,true,6); ?></td>
  </tr>
  <tr>
    <td class="title">Wound size</td>
    <td colspan="3"> <?php 
	  	if($Q9 !="" && $Q9 != NULL){echo '(Length：'.$Q9.')';}
		if($Q10 !="" && $Q10 != NULL){echo ' X (Width：'.$Q10.')';}
		if($Q11 !="" && $Q11 != NULL){echo '(Depth：'.$Q11.')';}
		if($Q11a !="" && $Q11a != NULL){echo '，Tunneling：'.$Q11a.'';}
	  ?></td>
  </tr>
  <tr>
    <td width="120" height="30" class="title_s">Filled by</td>
    <td colspan="3"><?php echo checkusername($Qfiller); ?></td>
  </tr>
  <?php 
  if($_GET['view']==5 && $_GET['part']==1){   
  ?>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="3"><input type="hidden" name="formID" id="formID" value="sixtarget_part5" /><input type="submit" name="submit" value="Confirm" style="color:#F00; border:1px solid #f00;"/>&nbsp;<input type="button" value="Cancel" onClick="window.location.href='index.php?mod=management&func=formview&view=5&part=1&id=3';"></td>
  </tr>
  <?php }?>
</table>
</form>