<script>
function switcharea2(bedarea) {
	if (document.getElementById('area2_'+bedarea).style.display=="none") {
		document.getElementById('area2_'+bedarea).style.display = "block";
		document.getElementById('expand2_'+bedarea).innerHTML = '-';
	} else {
		document.getElementById('area2_'+bedarea).style.display = "none";
		document.getElementById('expand2_'+bedarea).innerHTML = '+';
	}
}
</script>
      <?php
      $db = new DB;
      $db->query("SELECT `patientID`,`instat` FROM `patient` ORDER BY `patientID` ASC");
      $arrPatientList2 = array();
      $arrPatientName2 = array();
      $arrBedArea2 = array();
      for ($i=0;$i<$db->num_rows();$i++) {
            $r = $db->fetch_assoc();
            $db1 = new DB;
            $db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
            for ($j=0;$j<$db1->num_rows();$j++) {
                  $r1 = $db1->fetch_assoc();
				  if ($_SESSION['ncareOrgStatus_lwj']==2) {
					  if ($r['instat']==1) {
						  $arrPatientList2[$r1['bed']] = $r['patientID'];
						  $arrPatientName2[$r['patientID']] = getPatientName($r['patientID']);
					  }
				  } else {
					  $arrPatientList2[$r1['bed']] = $r['patientID'];
					  $arrPatientName2[$r['patientID']] = getPatientName($r['patientID']);
				  }
            }
      }
      $db2 = new DB;
      $db2->query("SELECT `bedID`, `Area` FROM `bedinfo` ORDER BY `AREA` ASC, `bedID` ASC");
      for ($i=0;$i<$db2->num_rows();$i++) {
            $r2 = $db2->fetch_assoc();
            $db3 = new DB;
            $db3->query("SELECT `areaID`,`areaName` FROM `areainfo` WHERE `areaID`='".$r2['Area']."'");
            for ($j=0;$j<$db3->num_rows();$j++) {
                  $r3 = $db3->fetch_assoc();
				  $arrBedArea2[$r3['areaName']] .= $r2['bedID'].";";
            }
			$arrBedAreaID2[$r3['areaName']] = $r3['areaID'];
      }
       echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
          <td align="center"><a style="color:#fff;font-size:16px; font-weight:bold; height:30px; border:none; cursor:pointer;" href="index.php?func=Calendar&type=4">ALL</a></td>
     </tr>
</table>';
	  ksort($arrBedArea2);
     foreach ($arrBedArea2 as $area2=>$bed2) {
		 foreach ($arrBedAreaID2 as $areaName2=>$areaNameareaID2) {
			 if($areaName2==$area2){
				 $areaID2=$areaNameareaID2;
			}
		 }
         echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
         <td align="center" style="color:rgb(255, 255, 255);"><button onclick="switcharea2(\''.$area2.'\')" style="background-color:#7a7a7a; color:white; font-size:14px; font-weight:bolder; width:80%; height:30px; border:none; border-radius:5px; cursor:pointer;"><span id="expand2_'.$area2.'">+</span> '.$area2.' </button></td>
     </tr>
</table>
<div id="area2_'.$area2.'" style="display:none; font-size:10pt;">
<table style="width:100%">
	'."\n";
	echo '<tr align="center" style="padding:5px;"><td><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=4&area='.$areaID2.'" style="color:rgb(149,219,208); font-size:11pt;">'.$area2.'</a></td></tr>';
	$bedlist2 = explode(";",$bed2);
	foreach ($bedlist2 as $bedno2=>$bedID2) {
		if ($arrPatientName2[$arrPatientList2[$bedID2]]!='') {
			echo '
     <tr>
         <td align="center" style="padding:5px;"><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=4&pid='.$arrPatientList2[$bedID2].'">'.$bedID2.' '.$arrPatientName2[$arrPatientList2[$bedID2]].'</a></td>
     </tr>
                  	 '."\n";
		}
	}
	echo '
</table>
</div>'."\n";
     }
?>