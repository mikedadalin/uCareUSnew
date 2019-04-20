<h3>Rehabilitation Therapy Notification</h3>
<table>
  <tr class="title">
    <td valign="middle"><p>Edit</p></td>
    <td valign="middle"><p>Date</p></td>
    <td valign="middle"><p>Time </p></td>
    <td valign="middle"><p>Pain severity </p></td>
    <td valign="middle"><p>Consciousness </p></td>
    <td valign="middle"><p>Duration </p></td>
    <td valign="middle"><p>Staff</p></td>
    <td valign="middle"><p>Rehabilitation reply</p></td>
    <td valign="middle"><p>Physiotherapist</p></td>
    <td valign="middle"><p>Social working reply</p></td>
    <td valign="middle"><p>Social worker</p></td>
  </tr>
<?php
$arrQ4 = array("1"=>"Clear & aware", "2"=>"Somnolence", "3"=>"Stupor", "4"=>"Semi-coma", "5"=>"Coma");
$arrQ11 = array("1"=>"Intermittent pain <4 hours", "2"=>"Intermittent pain 4-8 hours", "3"=>"Daily 8-16 hours continuous pain", "4"=>"More than 16 hours a day");
$arrQ20 = array("1"=>"Notify", "2"=>"Do Not notify");
$db = new DB;
$db->query("SELECT * FROM `nurseform02j` WHERE `HospNo`='".$HospNo."' ORDER BY `date` DESC");
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
	$db1 = new DB;
	$db1->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".$HospNo."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT * FROM `socialform20_2` WHERE `HospNo`='".$HospNo."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td align="center">'; if ($db1->num_rows()>0) { echo '<a href="index.php?mod=rehabilitation&func=formview&pid='.@$_GET['pid'].'&id=20_1&date='.$r1['date'].'&reply='.$r['date'].'"><img src="Images/edit_icon.png"></a>'; } echo '</td>
    <td align="center">'.$r['Q1'].'</td>
    <td align="center">'.$r['Q2'].':'.$r['Q3'].'</td>
    <td align="center">'.option_result("Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q15,false,5).'</td>
    <td align="center">'.option_result("Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","m","single",$Q4,false,0).'</td>
    <td align="center">'.option_result("Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$Q11,false,0).'</td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
    <td align="center">'; if ($Q20==2) { echo "Not notify"; } else { if ($db1->num_rows()==0) { echo '<a href="index.php?mod=rehabilitation&func=formview&pid='.@$_GET['pid'].'&id=20_1&reply='.$r['date'].'">Not replied</a>'; } else { echo 'Replied'; } } echo '</td>
    <td align="center">'.checkusername($r1['Qfiller']).'</td>
    <td align="center">'; if ($Q21==2) { echo "Not notify"; } else { if ($db2->num_rows()==0) { echo 'Not replied'; } else { echo 'Replied'; } } echo '</td>
    <td align="center">'.checkusername($r2['Qfiller']).'</td>
  </tr>
	'."\n";
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