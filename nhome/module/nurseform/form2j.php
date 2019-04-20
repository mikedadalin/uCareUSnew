<h3>Pain assessment and rehabilitation,<br>social working notification form</h3>
<?php if(substr($_SESSION['ncareID_lwj'],0,8)!="resident"){?>
<form align="left"><input type="button" value="New Assessment" onclick="window.location.href='index.php?mod=nurseform&func=formview&pid=<?php echo @$_GET['pid']; ?>&id=2j_1'" /></form>
<?php }?>
<table style="table-layout: fixed;">
  <tr class="title">
    <td valign="middle"><?php if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'View';}else{ echo 'Function';}?></td>
    <td valign="middle">Date</td>
    <td valign="middle">Time</td>
    <td valign="middle">Pain severity</td>
    <td valign="middle">Consciousness</td>
    <td valign="middle">Duration</td>
    <td valign="middle">Staff</td>
    <td valign="middle">Rehabilitation reply</td>
    <td valign="middle">physiotherapist</td>
    <td valign="middle">Social working reply</td>
    <td valign="middle">Social worker</td>
    <td valign="middle">Tracing evaluation</td>
  </tr>
<?php
$arrQ4 = array("1"=>"Clear & aware", "2"=>"Somnolence", "3"=>"Stupor", "4"=>"Semi-coma", "5"=>"Coma");
$arrQ11 = array("1"=>"Intermittent pain <4 hours", "2"=>"Intermittent pain 4-8 hours", "3"=>"Daily 8-16 hours continuous pain", "4"=>"More than 16 hours a day");
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
    <td align="center">';
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
			echo '<a href="index.php?mod=nurseform&func=formview&id=2j_1&pid='.@$_GET['pid'].'&date='.$r['date'].'"><img src="Images/MDSView.png" width="80%" /></a>';
		}else{
			echo '<a href="index.php?mod=nurseform&func=formview&id=2j_1&pid='.@$_GET['pid'].'&date='.$r['date'].'"><img src="Images/edit_icon.png" width="24" /></a>';
		}
	}
	if ($Q20==2 || $db1->num_rows()==0) {
		echo '<a href="index.php?mod=nurseform&func=nurseform2jdelete&pid='.@$_GET['pid'].'&date='.$r['date'].'"><img src="Images/delete2.png" /></a>';
	}
	echo '</td>
    <td align="center">'.$r['Q1'].'</td>
    <td align="center">'.$r['Q2'].':'.$r['Q3'].'</td>
    <td align="center">'.option_result("Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q15,false,5).'</td>
    <td align="center">'.option_result("Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","m","single",$Q4,false,0).'</td>
    <td align="center">'.option_result("Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$Q11,false,0).'</td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
    <td align="center">'; if ($Q20==2) { echo "Not notify"; } else { if ($db1->num_rows()==0) { if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'Notified, not replied'; }else{ echo '<a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=2j_2&date='.$r['date'].'">Notified, not replied</a>'; }  } else { if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'Replied'; }else{ echo '<a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=2j_2&date='.$r['date'].'&reply='.$r1['date'].'">Replied</a>'; } } } echo '</td>
    <td align="center">'.checkusername($r1['Qfiller']).'</td>
    <td align="center">'; if ($Q21==2) { echo "Not notify"; } else { if ($db2->num_rows()==0) { if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'Notified, not replied'; }else{ echo '<a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=2j_2&date='.$r['date'].'">Notified, not replied</a>'; }  } else { if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){ echo 'Replied'; }else{ echo '<a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=2j_2&date='.$r['date'].'&reply='.$r2['date'].'">Replied</a>'; } } } echo '</td>
    <td align="center">'.checkusername($r2['Qfiller']).'</td>
	<td align="center"><a href="index.php?mod=nurseform&func=formview&pid='.@$_GET['pid'].'&id=2j_3&date='.$r['date'].'">Tracing evaluation</a></td>
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