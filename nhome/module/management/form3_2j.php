<h3>Pain indicator monitoring</h3>
<div align="center" style="margin-bottom:10px;">
  <?php echo draw_option("tab7option","Not categorized;Can express;Can not express","xl","single","2",false,5); ?>  
</div>
<div id="tab7_part1">
<table width="100%">
  <tr class="title">
    <td valign="middle" width="65">Function</td>
    <td valign="middle" width="65"><p>Bed #<br>Full name</p></td>
    <td valign="middle"><p>Date<br>Time</p></td>
    <td valign="middle"><p>Body part </p></td>
    <td valign="middle"><p>Pain Severity </p></td>
    <td valign="middle"><p>Consciousness </p></td>
    <td valign="middle"><p>Duration </p></td>
    <td valign="middle"><p>Medication treatment</p></td>
    <td valign="middle"><p>Relieving/ aggravating factor</p></td>
    <td valign="middle"><p>Pain characterize</p></td>
    <td valign="middle"><p>Other treatment</p></td>
    <td valign="middle"><p>Revised care plan</p></td>
    <td valign="middle"><p>Staff</p></td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform02j` WHERE ((`Q7_1` IS NULL AND `Q7_2` IS NULL) OR (`Q7_1` = '0' AND `Q7_2` = '0')) AND `date`  LIKE '".$qdate."%' ORDER BY `date` DESC");

for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			${$arrPatientInfo[0]} = "";
		} else {
			${$k} = "";
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
	$pid = getPID($HospNo);
	$db1 = new DB;
	$db1->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT * FROM `socialform20_2` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td align="center">';
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		echo '<a href="index.php?mod=nurseform&func=formview&id=2j_1&pid='.$pid.'&date='.$r['date'].'"><img src="Images/edit_icon.png" width="24" /></a>';
	}
	//if ($r['Q20']==2 || $db1->num_rows()==0) {
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		echo '<a href="index.php?mod=nurseform&func=nurseform2jdelete&pid='.$pid.'&date='.$r['date'].'"><img src="Images/delete2.png" /></a>';
	}
	echo '</td>
    <td align="center">'.getBedID($pid).'<br>'.getPatientName($pid).'</td>
    <td align="center">'.$r['Q1'].'<br>'.$r['Q2'].':'.$r['Q3'].'</td>
    <td align="left">'.$r['Q13'].'</td>
    <td align="center">'.option_result("Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q15,false,5).'</td>
    <td align="center">'.option_result("Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","m","single",$Q4,false,0).'</td>
    <td align="center">'.option_result("Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$Q11,false,0).'</td>
    <td align="center">'.$r['Q22'].'</td>
    <td align="left">Aggravating :';		
		echo option_result("Q17","Movement;Touch;Pressing;Cough;Other","m","multi",$Q17,true,6).($Q17a==""?"":"：(".$Q17a.")");
		echo '<br>Relieving :'.option_result("Q18","Fixed;Not touch;Icing;Other","m","multi",$Q18,true,6).($Q18a==""?"":"：(".$Q18a.")");
		echo '</td>
	<td align="center">'.option_result("Q16","Soreness;Throbbing;Stinging;Dull pain;Searing pain;Indescribable;Can't express","m","multi",$Q16,false,5).'</td>
	<td align="center">'.$r['Q23'].'</td>
	<td align="center">'.option_result("Q24","YES;NO","s","single",$Q24,false,0).'</td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
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
}
?>
</table>
</div>
<div id="tab7_part2" style="display:none;">
<table width="100%">
  <tr class="title">
    <td valign="middle" width="65">Function</td>
    <td valign="middle" width="65"><p>Bed #<br>Full name</p></td>
    <td valign="middle"><p>Date<br>Time</p></td>
    <td valign="middle"><p>Body part </p></td>
    <td valign="middle"><p>Pain Severity </p></td>
    <td valign="middle"><p>Consciousness </p></td>
    <td valign="middle"><p>Duration </p></td>
    <td valign="middle"><p>Medication treatment</p></td>
    <td valign="middle"><p>Relieving/ aggravating factor</p></td>
    <td valign="middle"><p>Pain characterize</p></td>
    <td valign="middle"><p>Other treatment</p></td>
    <td valign="middle"><p>Revised care plan</p></td>
    <td valign="middle"><p>Staff</p></td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform02j` WHERE `Q7_1`='1' AND `date`  LIKE '".$qdate."%' ORDER BY `date` DESC");

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
	$pid = getPID($HospNo);
	$db1 = new DB;
	$db1->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT * FROM `socialform20_2` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td align="center">';
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		echo '<a href="index.php?mod=nurseform&func=formview&id=2j_1&pid='.$pid.'&date='.$r['date'].'"><img src="Images/edit_icon.png" width="24" /></a>';
	}
	//if ($r['Q20']==2 || $db1->num_rows()==0) {
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		echo '<a href="index.php?mod=nurseform&func=nurseform2jdelete&pid='.$pid.'&date='.$r['date'].'"><img src="Images/delete2.png" /></a>';
	}
	echo '</td>
    <td align="center">'.getBedID($pid).'<br>'.getPatientName($pid).'</td>
    <td align="center">'.$r['Q1'].'<br>'.$r['Q2'].':'.$r['Q3'].'</td>
    <td align="left">'.$r['Q13'].'</td>
    <td align="center">'.option_result("Q15","0;1;2;3;4;5;6;7;8;9;10","s","multi",$Q15,false,5).'</td>
    <td align="center">'.option_result("Q4","Clear & aware;Somnolence;Stupor;Semi-coma;Coma","m","single",$Q4,false,0).'</td>
    <td align="center">'.option_result("Q11","Intermittent pain <4 hours;Intermittent pain 4-8 hours;Daily 8-16 hours continuous pain;More than 16 hours a day","l","multi",$Q11,false,0).'</td>
    <td align="center">'.$r['Q22'].'</td>
    <td align="left">Aggravating :';		
		echo option_result("Q17","Movement;Touch;Pressing;Cough;Other","m","multi",$Q17,true,6).($Q17a==""?"":"：(".$Q17a.")");
		echo '<br>Relieving :'.option_result("Q18","Fixed;Not touch;Icing;Other","m","multi",$Q18,true,6).($Q18a==""?"":"：(".$Q18a.")");
		echo '</td>
	<td align="center">'.option_result("Q16","Soreness;Throbbing;Stinging;Dull pain;Searing pain;Indescribable;Can't express","m","multi",$Q16,false,5).'</td>
	<td align="center">'.$r['Q23'].'</td>
	<td align="center">'.option_result("Q24","YES;NO","s","single",$Q24,false,0).'</td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
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
</div>
<div id="tab7_part3" style="display:none;">
<table width="100%">
  <tr class="title">
    <td valign="middle" width="65">Function</td>
    <td valign="middle" width="65"><p>Bed #</p></td>
    <td valign="middle" width="65"><p>Full name</p></td>
    <td valign="middle"><p>Date</p></td>
    <td valign="middle"><p>Time</p></td>
    <td valign="middle"><p>Reassuring method </p></td>
    <td valign="middle"><p>Facial expression </p></td>
    <td valign="middle"><p>Physical activity </p></td>
    <td valign="middle"><p>Moan / cry </p></td>
    <td valign="middle"><p>Respiration</p></td>
    <td valign="middle"><p>Total score</p></td>
    <td valign="middle"><p>Staff</p></td>
  </tr>
<?php
$db = new DB;
$db->query("SELECT * FROM `nurseform02j` WHERE `Q7_2`='1' AND `date`  LIKE '".$qdate."%' ORDER BY `date` DESC");

for ($i1=0;$i1<$db->num_rows();$i1++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo1 = explode("_",$k);
		if (count($arrPatientInfo1)==2) {
			if ($v==1) {
				${'n02j_'.$arrPatientInfo1[0]} .= $arrPatientInfo1[1].';';
			}
		} else {
			${$k} = $v;
		}
	}
	$pid = getPID($HospNo);
	$db1 = new DB;
	$db1->query("SELECT * FROM `socialform20_1` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r1 = $db1->fetch_assoc();
	$db2 = new DB;
	$db2->query("SELECT * FROM `socialform20_2` WHERE `HospNo`='".$r['HospNo']."' AND `Qreplyto`='".$r['date']."' ORDER BY `date` DESC");
	$r2 = $db2->fetch_assoc();
	echo '
  <tr>
    <td align="center">';
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		echo '<a href="index.php?mod=nurseform&func=formview&id=2j_1&pid='.$pid.'&date='.$r['date'].'"><img src="Images/edit_icon.png" width="24" /></a>';
	}
	//if ($r['Q20']==2 || $db1->num_rows()==0) {
	if ($_SESSION['ncareID_lwj']==$r['Qfiller'] || $_SESSION['ncareLevel_lwj']>=4) {
		echo '<a href="index.php?mod=nurseform&func=nurseform2jdelete&pid='.$pid.'&date='.$r['date'].'"><img src="Images/delete2.png" /></a>';
	}
	echo '</td>
    <td align="center">'.getBedID($pid).'</td>
    <td align="center">'.getPatientName($pid).'</td>
    <td align="center">'.$r['Q1'].'</td>
    <td align="center">'.$r['Q2'].':'.$r['Q3'].'</td>
    <td align="center">'.checkbox_result("Q25","Muscle relaxed without appease;Tight and stiff muscle but able to be appeased;Tight and stiff muscle, unable to be appeased",$n02j_Q25,"single").'</td>
    <td align="center">'.checkbox_result("Q26","Relax;Frowning or shock-like;Painful expression",$n02j_Q26,"single").'</td>
    <td align="center">'.checkbox_result("Q27","Relax;Restless;Struggling",$n02j_Q27,"single").'</td>
    <td align="center">'.checkbox_result("Q28","None;Occasionally;Continuous",$n02j_Q28,"single").'</td>
	<td align="center">'.checkbox_result("Q29","Normal & smooth;Occasionally fast or laborious;Continuously fast or laborious",$n02j_Q29,"single").'</td>
	<td align="center">'.$r['Qtotal'].'</td>
    <td align="center">'.checkusername($r['Qfiller']).'</td>
  </tr>
	'."\n";
	foreach ($r as $k=>$v) {
		$arrPatientInfo1 = explode("_",$k);
		if (count($arrPatientInfo1)==2) {
			if ($v==1) {
				${$arrPatientInfo1[0]} = "";
			}
		} else {
			${$k} = "";
		}
	}
}
?>
</table>
</div>
<script>
  $('#btn_tab7option_1').click(function() {
      $('#tab7_part1').show();
      $('#tab7_part2').hide();
      $('#tab7_part3').hide();
  });
  $('#btn_tab7option_2').click(function() {
      $('#tab7_part1').hide();
      $('#tab7_part2').show();
      $('#tab7_part3').hide();
  });
  $('#btn_tab7option_3').click(function() {
      $('#tab7_part1').hide();
      $('#tab7_part2').hide();
      $('#tab7_part3').show();
  });
</script>
