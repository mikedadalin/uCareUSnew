<script>
function switcharea5(bedarea) {
	if (document.getElementById('area5_'+bedarea).style.display=="none") {
		document.getElementById('area5_'+bedarea).style.display = "block";
		document.getElementById('expand5_'+bedarea).innerHTML = '-';
	} else {
		document.getElementById('area5_'+bedarea).style.display = "none";
		document.getElementById('expand5_'+bedarea).innerHTML = '+';
	}
}
</script>
      <?php
      $db = new DB;
      $db->query("SELECT `patientID`,`instat` FROM `patient` ORDER BY `patientID` ASC");
      $arrPatientList5 = array();
      $arrPatientName5 = array();
      $arrBedArea5 = array();
      for ($i=0;$i<$db->num_rows();$i++) {
            $r = $db->fetch_assoc();
            $db1 = new DB;
            $db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
            for ($j=0;$j<$db1->num_rows();$j++) {
                  $r1 = $db1->fetch_assoc();
				  if ($_SESSION['ncareOrgStatus_lwj']==2) {
					  if ($r['instat']==1) {
						  $arrPatientList5[$r1['bed']] = $r['patientID'];
						  $arrPatientName5[$r['patientID']] = getPatientName($r['patientID']);
					  }
				  } else {
					  $arrPatientList5[$r1['bed']] = $r['patientID'];
					  $arrPatientName5[$r['patientID']] = getPatientName($r['patientID']);
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
				  $arrBedArea5[$r3['areaName']] .= $r2['bedID'].";";
            }
			$arrBedAreaID5[$r3['areaName']] = $r3['areaID'];
      }
       echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
          <td align="center"><a style="color:#fff;font-size:16px; font-weight:bold; height:30px; border:none; cursor:pointer;" href="index.php?func=Calendar&type=7">ALL</a></td>
     </tr>
</table>';
	  ksort($arrBedArea5);
     foreach ($arrBedArea5 as $area5=>$bed5) {
		 foreach ($arrBedAreaID5 as $areaName5=>$areaNameareaID5) {
			 if($areaName5==$area5){
				 $areaID5=$areaNameareaID5;
			}
		 }
         echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
         <td align="center" style="color:rgb(255, 255, 255);"><button onclick="switcharea5(\''.$area5.'\')" style="background-color:#7a7a7a; color:white; font-size:14px; font-weight:bolder; width:80%; height:30px; border:none; border-radius:5px; cursor:pointer;"><span id="expand5_'.$area5.'">+</span> '.$area5.' </button></td>
     </tr>
</table>
<div id="area5_'.$area5.'" style="display:none; font-size:10pt;">
<table style="width:100%">
	'."\n";
	echo '<tr align="center" style="padding:5px;"><td><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=7&area='.$areaID5.'" style="color:rgb(231, 231, 207); font-size:11pt;">'.$area5.'</a></td></tr>';
	$bedlist5 = explode(";",$bed5);
	foreach ($bedlist5 as $bedno5=>$bedID5) {
		if ($arrPatientName5[$arrPatientList5[$bedID5]]!='') {
			echo '
     <tr>
         <td align="center" style="padding:5px;"><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=7&pid='.$arrPatientList5[$bedID5].'">'.$bedID5.' '.$arrPatientName5[$arrPatientList5[$bedID5]].'</a></td>
     </tr>
                  	 '."\n";
		}
	}
	echo '
</table>
</div>'."\n";
     }
?>