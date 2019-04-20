<div class="moduleNoTab">
<div class="content-table">
<h3>Pain evaluation form and rehabilitation<br>social worker visiting tracking form </h3>
<table style="padding-bottom:20px;">
  <tr class="title">
    <td valign="middle" style="border-top-left-radius:10px;"><p>Bed number</p></td>
    <td valign="middle"><p>Full name </p></td>
    <td valign="middle"><p>Date</p></td>
    <td valign="middle"><p>Time</p></td>
    <td valign="middle"><p>Pain severity</p></td>
    <td valign="middle"><p>Conscious </p></td>
    <td valign="middle"><p>Duration </p></td>
    <td valign="middle"><p>Staff</p></td>
    <td valign="middle"><p>Physiotherapist reply</p></td>
    <td valign="middle"><p>Social worker reply</p></td>
    <td valign="middle"><p>Evaluation date</p></td>
    <td valign="middle"><p>Case closed reason</p></td>
    <td valign="middle" style="border-top-right-radius:10px;"><p>Track evaluation</p></td>
  </tr>
<?php
$arrQ4 = array("1"=>"Sober", "2"=>"Lethargy", "3"=>"Stupor", "4"=>"Semi-coma", "5"=>"Coma");//1Sober, 2lethargy, 3stupor, 4semi-coma, 5coma
$arrQ11 = array("1"=>"Intermittent pain<4hrs", "2"=>"Intermittent pain between 4-8 hrs", "3"=>"Continued pain between 8-16hrs per day", "4"=>"Continued pain more then 16hrs per day");//1Intermittent pain<4hrs,2Intermittent pain between 4-8 hrs, 3Continued pain between 8-16hrs per day,4 Continued pain more then 16hrs per day
$db = new DB;
$db->query("SELECT * FROM `nurseform02j` ORDER BY `date` DESC");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$db3 = new DB;
	$db3->query("SELECT * FROM `nurseform02j_3` WHERE `HospNo`='".$r['HospNo']."' AND `Q1`='".$r['date']."' ORDER BY `date` DESC LIMIT 0,1");
	if ($db3->num_rows()>0) {
		$r3 = $db3->fetch_assoc();
		$form2j3_Q6 = "";
		foreach ($r3 as $k3=>$v3) {
			$arrPatientInfo = explode("_",$k3);
			if (count($arrPatientInfo)==2) {
				if ($v3==1) {
					${'form2j3_'.$arrPatientInfo[0]} .= $arrPatientInfo[1].';';
				}
			} else {
				${'form2j3_'.$k3} = $v3;
			}
		}
	}
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
	$pid = getPID($r['HospNo']);
	$db1 = new DB;
	$db1->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT * FROM `socialform20_2` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r2 = $db2->fetch_assoc();
	$db3 = new DB;
	$db3->query("SELECT `instat` FROM `patient` WHERE `patientID`='".$pid."'");
	$r3 = $db3->fetch_assoc();
	echo '
  <tr'.($_SESSION['ncareOrgStatus_lwj']==2 && $r3['instat']==0?' style="display:none"':'').'>
    <td align="center">'.getBedID($pid).'</td>
    <td align="center">'.getPatientName($pid).'</td>
    <td align="center">'.$r['Q1'].'</td>
    <td align="center">'.$r['Q2'].':'.$r['Q3'].'</td>
    <td align="center">'.option_result("Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q15,false,5).'</td>
    <td align="center">'.option_result("Q4","Sober;lethargy;stupor;semi-coma;coma","m","single",$Q4,false,0).'</td>
    <td align="center">'.option_result("Q11","Intermittent pain<4hrs;Intermittent pain between 4-8 hrs;Continued pain between 8-16hrs per day;Continued pain more then 16hrs per day","l","multi",$Q11,false,0).'</td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
    <td align="center">'; if ($Q20==2) { echo "No visit"; } else { if ($db1->num_rows()==0) { echo '<a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2j_2&date='.$r['date'].'">Visited</a>'; } else { echo '<a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2j_2&date='.$r['date'].'&reply='.$r1['date'].'">Replied</a>'; } } echo '</td>
    <td align="center">'; if ($Q21==2) { echo "No visit"; } else { if ($db2->num_rows()==0) { echo '<a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2j_2&date='.$r['date'].'">Visited</a>'; } else { echo '<a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2j_2&date='.$r['date'].'&reply='.$r2['date'].'">Replied</a>'; } } echo '</td>
	<td align="center">'.formatdate($form2j3_date).'</td>
	<td align="center">'.option_result("Q6","Improved;Check-out;Transfered;Pass away;Other","m","single",$form2j3_Q6,false,3).'</td>
	<td align="center"><a href="index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2j_3&date='.$r['date'].'">Track evaluated degree</a></td>
  </tr>
	'."\n";
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			${$arrPatientInfo[0]} = "";
		} else {
			${$k} = "";
		}
	}
	if ($db3->num_rows()>0) {
		foreach ($r3 as $k=>$v) {
			$arrPatientInfo = explode("_",$k);
			if (count($arrPatientInfo)==2) {
				${'form2j3_'.$arrPatientInfo[0]} = "";
			} else {
				${'form2j3_'.$k} = "";
			}
		}
	}
}
?>
</table>
</div>
</div>
