<?php
$HospNo = getHospNo(@$_GET['pid']);
$targetID = mysql_escape_string($_GET['tID']);

$db1 = new DB;
$db1->query("SELECT * FROM `sixtarget_part7` WHERE `targetID`='".$targetID."'");
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
<h3>Training record for removing nasogastric tube </h3>
<table width="100%">
  <tr class="printcol">
    <td class="title" width="160">Full name</td>
    <td><?php echo getBedID($pid).' '.getPatientName($pid); ?></td>
    <td class="title" width="160">Care ID#</td>
    <td><?php echo $r1['HospNo']; ?></td>
  </tr>
  <tr>
    <td class="title">Start date</td>
    <td colspan="3"><?php echo $startdate; ?></td>
  </tr>
  <tr>
    <td class="title">Reasons for indwelling nasogastric tube</td>
    <td colspan="3"><?php echo option_result("reason","Dysphagia;Easily choked;Indwelled during hospitalization;Other","l","single",$reason,false,3); ?> <?php echo $reasonother;?></td>
  </tr>
  <tr>
    <td class="title">Evaluation of results and follow up assessment</td>
    <td colspan="3"><?php echo $releasereason; ?></td>
  </tr>
  <tr>
    <td class="title">End date</td>
    <td colspan="3"><?php echo $enddate; ?></td>
  </tr>
  <tr>
    <td class="title">Results</td>
    <td colspan="3"><?php echo option_result("result","Success;Unsuccessful","m","single",$result,false,3); ?></td>
  </tr>
  <tr>
    <td class="title">Filled by</td>
    <td colspan="3"><?php echo checkusername($Qfiller); ?></td>
  </tr>
  <tr>
    <td colspan="4">
	<?php 
	$tmpArr=array("Date","Time","Record of training process","Filled by");
	$tmpArrCol=array("title","content1","content2","userID");
	$tmpLength = count($tmpArr);
	include("class/blockSubItem.php");
	?>
    </td>
  </tr>
  <tr>
    <td class="title"><span class="rangeH">Confirm delete?</span></td>
    <td colspan="3"><input type="hidden" name="formID" id="formID" value="sixtarget_part7" /><input type="submit" name="submit" value="Confirm!" style="color:#F00; border:1px solid #f00;"/></td>
  </tr>
</table>
</form>