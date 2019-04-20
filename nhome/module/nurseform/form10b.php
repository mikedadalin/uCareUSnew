<h3>Individual care plan</h3>
<div align="left" class="printcol">
<form><input type="button" value="New Plan" onclick="window.location.href='index.php?mod=nurseform&func=formview&id=10b_1&pid=<?php echo @$_GET['pid']; ?>'"/></form></div>
<table width="100%">
  <tr class="title">
    <td><p>Edit</p></td>
    <td><p>Preliminary assessment date</p></td>
    <td><p>The first follow up<br />(3 months)</p></td>
    <td><p>Follow up<br />(6 months)</p></td>
    <td><p>Filled by</p></td>
    <td><p>Follow up assessment</p></td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `socialform10b` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
	echo '
  <tr>
    <td align="center">'; if ($db->num_rows()>0) { echo '<a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=10b_1&date='.$r2['date'].'"><img src="Images/edit_patient.png"></a>'; } echo '</td>
    <td align="center">'.formatdate($r['date']).'</td>
    <td align="center"><a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=10b_2&date='.$r['date'].'">'.($r['Qdate1']=="" || $r['Qdate1']==NULL?"Haven't done the first follow up":$r['Qdate1']).'</a></td>
	<td align="center"><a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=10b_3&date='.$r['date'].'">'.($r['Qdate2']=="" || $r['Qdate2']==NULL?"Haven't done the follow up":$r['Qdate2']).'</a></td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
    <td align="center"><form><input type="button" value="Assess" onclick="window.location.href=\'index.php?mod=nurseform&func=formview&id=10b_4&pid='.@$_GET['pid'].'&Qreply='.$r['date'].'\'" /></form></td>
  </tr>
	'."\n";
	
	$db1 = new DB;
	$db1->query("SELECT * FROM `socialform10b_1` WHERE `HospNo`='".$HospNo."' AND `Qreply`='".$r['date']."' ORDER BY `date` DESC");
	if ($db1->num_rows()>0) {
		echo '
		<tr>
		  <td colspan="6" align="right">
		    <table style="width:100%; text-align:center; text-transform:capitalize;">
			<tr style="height:14px;">
			  <td width="20" style="background:#3a87ad; color:#fff; border:2px solid #3a87ad; padding:4px;"></td>
			  <td width="100" style="background:#3a87ad; color:#fff; border:2px solid #3a87ad; padding:4px;">Follow-up assessment date</td>
			  <td width="250" style="background:#3a87ad; color:#fff; border:2px solid #3a87ad; padding:4px;">Nursing</td>
			  <td width="250" style="background:#3a87ad; color:#fff; border:2px solid #3a87ad; padding:4px;">Social worker</td>
			  <td width="250" style="background:#3a87ad; color:#fff; border:2px solid #3a87ad; padding:4px;">Physical therapist</td>
			</tr>'."\n";
		for ($i1=0;$i1<$db1->num_rows();$i1++) {
			$r1 = $db1->fetch_assoc();
			echo '
			<tr style="height:14px;">
			  <td width="20" style="background:#fff; border:0; padding:4px;" align="center"><a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=10b_4&date='.$r2['date'].'&Qreply='.$r1['Qreply'].'"><img src="Images/edit_icon.png" height="14"></a></td>
			  <td width="100" style="background:#fff; border:0; padding:4px;">'.formatdate($r1['date']).'</td>
			  <td width="250" style="background:#fff; border:0; padding:4px;">'.$r1['Q1'].'</td>
			  <td width="250" style="background:#fff; border:0; padding:4px;">'.$r1['Q3'].'</td>
			  <td width="250" style="background:#fff; border:0; padding:4px;">'.$r1['Q4'].'</td>
			</tr>
			'."\n";
		}
		echo '
			</table>
		  </td>
		</tr>'."\n";
	}
	
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}
}
?>
</table>