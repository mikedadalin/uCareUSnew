<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['tID']);

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part6` WHERE `targetID`='".$targetID."'");
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
<h3>Unplanned weight change</h3>
<div align="right" id="printbtn"><a href="print.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="Images/print.png" border="0"></a></div>
<table width="100%">
  <tr>
    <td class="title">Full name</td>
    <td><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
    <td class="title">Care ID#</td>
    <td><?php echo $HospNo; ?></td>
  </tr>
  <tr>
    <td class="title">Weight change</td>
    <td><?php echo $weight; ?> %</td>
    <td class="title">收案人員</td>
    <td><?php echo checkusername($Qfiller); ?></td>
  </tr>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="3"><input type="hidden" name="formID" id="formID" value="sixtarget_part6" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
</table>
</form>