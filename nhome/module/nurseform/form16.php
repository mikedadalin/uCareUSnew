<h3>Resident's doctor appointment record</h3>
<div align="left">
	<form><input type="button" value="Add new appointment" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo mysql_escape_string($_GET['pid'])?>&id=16_1&action=new'" /></form>
</div>
<table width="100%">
  <tr class="title">
    <td width="6%" class="printcol">&nbsp;</td>
    <td>Appointment/visit date</td>
    <td>Visiting hospital</td>
    <td>Division</td>
    <td>AM/PM</td>
    <td>Clinical appoitment #</td>
    <td>Physician name</td>
    <td>Clinic</td>
    <td>Medical reasons</td>
    <td>Clinic classification<br /><font size="2">(Emergency / Outpatient)</font></td>
    <!--<td>醫療處置</td>-->
    <td width="6%" class="printcol">&nbsp;</td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform16` WHERE `HospNo`='".$HospNo."' ORDER BY `Q1` DESC");
for ($j=0;$j<$db->num_rows();$j++) {
	$r = $db->fetch_assoc();
	$Q2 = "";
	$Q4 = "";
	foreach ($r as $k=>$v) {
		$arrAnswer = explode("_",$k);
		if (count($arrAnswer)==2) {
			if ($v==1) {
				${$arrAnswer[0]} .= $arrAnswer[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
	$Q2 = explode(';',$Q2);
	$Q4 = explode(';',$Q4);
	echo '
  <tr>
    <td class="printcol"><center><a href="index.php?mod=nurseform&func=formview&pid='.mysql_escape_string($_GET['pid']).'&id=16_1&nID='.$nID.'&action=edit"><img src="Images/edit_icon.png" width="30"></a></center></td>
    <td align="center">'.$Q1.'</td>
    <td align="center">';
	$Hosp = "";
	for ($i=1;$i<=20;$i++) {
		if (in_array($i, $Q2)) {
			$db2 = new DB2;
			$db2->query("SELECT `Hosp".$i."` FROM `system_setting` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
			$r2 = $db2->fetch_assoc();
			if ($Hosp!="") { $Hosp .= '、'; }
			$Hosp .= $r2['Hosp'.$i];
		}
	}
	if($Hosp==""){$Hosp=$Q2a;}
	
	//$Hosp = substr($Hosp,0,strlen($Hosp)-6);
	echo $Hosp.'
	</td>
    <td align="center">'.$Q2b.'</td>
    <td align="center">'.option_result("Q6","AM;PM;Night","m","single",$Q6,true,5, 2).'</td>
    <td align="center">'.$Q2e.'</td>
    <td align="center">'.$Q2c.'</td>
    <td align="center">'.$Q2d.'</td>
    <td>'.$Q3.'</td>
    <td align="center">';
	$Emg = "";
	foreach ($Q4 as $k1=>$v1) { if ($v1!="") $Emg .= $arrForm16_Q4[$v1].'、'; };
	$Emg = substr($Emg,0,strlen($Emg)-3);
	//<td align="center">'.($Q5!=""?'<img src="Images/accept.png" width="30" title="已填寫">':'<img src="Images/warning.png" width="30" title="尚未填寫">').'</td>
	echo $Emg.'</td>
	<td width="6%" class="printcol"><center><a href="index.php?mod=nurseform&func=formdelete16&pid='.$_GET['pid'].'&nID='.$nID.'"><img src="Images/delete2.png" border="0" width="30"></a></center></td>
  </tr>'."\n";
  $Q2 = array();
  $Q4 = array();
  $Q2b = "";
  $Q2c = "";
  $Q2d = "";
  $Q6 = "";
}
?>
</table>