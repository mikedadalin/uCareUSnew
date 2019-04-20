<div class="moduleNoTab">
<h3>Physical examination report</h3>
<div align="right">
<?php
if ($_GET['EmpID']!="") {
	$EmpID = (int) @$_GET['EmpID'];
} else {
	$EmpID = "";
}
?>
<form>
<input type="button" value="Add new report" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=12_1&EmpID=<?php echo $EmpID; ?>'" />
<input type="button" value="Back to staff profile" onclick="window.location.href='index.php?mod=humanresource&func=formview&id=2'" />
</form>
</div>
<div class="content-table">
<table>
<tr class="title">
  <td>&nbsp;</td>
  <td>Date</td>
  <td>Chest X-ray</td>
  <td>Test items</td>
  <td>Physicians recommendation</td>
  <td>Follow-up</td>
  <td>Filled by</td>
</tr>
<?php
$sql1 = "SELECT * FROM `humanresource12` WHERE `EmpID`='".$EmpID."'";
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
	echo '
<tr>
  <td width="6%"><center><a href="index.php?mod=humanresource&func=formview&id=12_1&workID='.$workID.'&EmpID='.$r['EmpID'].'"><img src="Images/select.png"></a></center></td>
  <td>'.$date.'</td>
  <td>'.$cxr.'</td>
  <td>'.str_replace("\n","<br>",$lab).'</td>
  <td>'.str_replace("\n","<br>",$suggest).'</td>
  <td>'.str_replace("\n","<br>",$followup).'</td>
  <td>'.checkusername($Qfiller).'</td>
</tr>'."\n";
}
?>
</table>
</div>
</div>