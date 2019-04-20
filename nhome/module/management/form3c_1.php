<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['tID']);

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part1` WHERE `targetID`='".$targetID."'");
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
$pid = getPID($HospNo);
?>
<form  method="post" onSubmit="return checkForm();" action="index.php?func=database&action=delete&targetID=<?php echo $targetID; ?>">
<h3>Resident transfer to ER</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table width="100%">
  <tr>
    <td class="title" width="200px">Full name</td>
    <td><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
    <td class="title">Care ID#</td>
    <td><?php echo getHospNoDisplayByPID($pid); ?></td>
  </tr>
  <tr>
    <td class="title">Admission date</td>
    <td><input type="text" name="indate" id="indate" value="<?php echo $indate; ?>"></td>
    <td class="title">Previous returned from hospital date(last time)</td>
    <td><input type="text" name="outdate" id="outdate" value="<?php echo $outdate; ?>"></td>
  </tr>
  <tr>
    <td class="title">Transfer/ hospitalized date</td>
    <td><input type="text" name="thisoutdate" id="thisoutdate" value="<?php echo $thisoutdate; ?>" ></td>
    <td class="title">Stay in the facility/center day(s)</td>
    <td><input type="text" name="indays" id="indays" value="<?php echo $indays; ?>" size="3">Day(s)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><?php echo draw_checkbox("is72hr","Hospitalize within 72hrs after admission",$is72hr,"single"); ?></td>
  </tr>
  <tr>
    <td class="title">Occur shift</td>
    <td colspan="3"><?php echo draw_option("occurence","Graveyard shift;Day shift;Night shift","xm","single",$occurence,false,4); ?></td>
  </tr>
  <tr>
    <td class="title">Hospitalization main<br />diagnosis or reason</td>
    <td colspan="3"><?php echo draw_option("reason","Hypotension;Myocardial Infarction;Arrhythmia;Fracture;Gastrorrhagia;Intestinal obstruction;Urinary tract infection;Pneumonia;Septicemia;Electrolyte imbalance;Dyspnea;Asthma;Head injury;Other","xl","single",$reason,true,3); ?></td>
  </tr>
  <tr>
    <td class="title">Cause analysis</td>
    <td colspan="3"><?php echo draw_option("reasonanalysis","Changes in disease;Unstable condition when admission;Improper care","xxl","single",$reasonanalysis,false,4); ?></td>
  </tr>
  <tr>
    <td class="title">Results</td>
    <td colspan="3"><?php echo draw_option("result","Returns after treatment;Observing;Hospitalization;Death","xl","single",$result,true,2); ?></td>
  </tr>
  <tr>
    <td class="title">Category analysis</td>
    <td colspan="3"><?php echo draw_option("resultanalysis","Controllable;Uncontrollable","xm","single",$resultanalysis,false,4); ?></td>
  </tr>
  <tr>
    <td class="title">Returned from hospital date</td>
    <td><input type="text" name="lastoutdate" id="lastoutdate" value="<?php echo $lastoutdate; ?>"></td>
    <td class="title">Hospitalize days</td>
    <td><input type="text" name="outdays" id="outdays" value="<?php echo $outdays; ?>" size="3">Day(s)</td>
  </tr>
  <tr>
    <td class="title">Filled by</td>
    <td colspan="3"><?php echo checkusername($_SESSION['ncareID_lwj']); ?></td>
  </tr>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="3"><input type="hidden" name="formID" id="formID" value="sixtarget_part1" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
</table>
</form><br>