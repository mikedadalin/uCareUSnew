<script>
function switcharea4(bedarea) {
	if (document.getElementById('area4_'+bedarea).style.display=="none") {
		document.getElementById('area4_'+bedarea).style.display = "block";
		document.getElementById('expand4_'+bedarea).innerHTML = '-';
	} else {
		document.getElementById('area4_'+bedarea).style.display = "none";
		document.getElementById('expand4_'+bedarea).innerHTML = '+';
	}
}
</script>
      <?php
      $db = new DB;
      $db->query("SELECT `patientID`,`instat` FROM `patient` ORDER BY `patientID` ASC");
      $arrPatientList4 = array();
      $arrPatientName4 = array();
      $arrBedArea4 = array();
      for ($i=0;$i<$db->num_rows();$i++) {
            $r = $db->fetch_assoc();
            $db1 = new DB;
            $db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
            for ($j=0;$j<$db1->num_rows();$j++) {
                  $r1 = $db1->fetch_assoc();
				  if ($_SESSION['ncareOrgStatus_lwj']==2) {
					  if ($r['instat']==1) {
						  $arrPatientList4[$r1['bed']] = $r['patientID'];
						  $arrPatientName4[$r['patientID']] = getPatientName($r['patientID']);
					  }
				  } else {
					  $arrPatientList4[$r1['bed']] = $r['patientID'];
					  $arrPatientName4[$r['patientID']] = getPatientName($r['patientID']);
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
				  $arrBedArea4[$r3['areaName']] .= $r2['bedID'].";";
            }
			$arrBedAreaID4[$r3['areaName']] = $r3['areaID'];
      }
       echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
          <td align="center"><a style="color:#fff;font-size:16px; font-weight:bold; height:30px; border:none; cursor:pointer;" href="index.php?func=Calendar&type=6">ALL</a></td>
     </tr>
</table>';
	  ksort($arrBedArea4);
     foreach ($arrBedArea4 as $area4=>$bed4) {
		 foreach ($arrBedAreaID4 as $areaName4=>$areaNameareaID4) {
			 if($areaName4==$area4){
				 $areaID4=$areaNameareaID4;
			}
		 }
         echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
         <td align="center" style="color:rgb(255, 255, 255);"><button onclick="switcharea4(\''.$area4.'\')" style="background-color:#7a7a7a; color:white; font-size:14px; font-weight:bolder; width:80%; height:30px; border:none; border-radius:5px; cursor:pointer;"><span id="expand4_'.$area4.'">+</span> '.$area4.' </button></td>
     </tr>
</table>
<div id="area4_'.$area4.'" style="display:none; font-size:10pt;">
<table style="width:100%">
	'."\n";
	echo '<tr align="center" style="padding:5px;"><td><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=6&area='.$areaID4.'" style="color:rgb(255, 168, 255); font-size:11pt;">'.$area4.'</a></td></tr>';
	$bedlist4 = explode(";",$bed4);
	foreach ($bedlist4 as $bedno4=>$bedID4) {
		if ($arrPatientName4[$arrPatientList4[$bedID4]]!='') {
			echo '
     <tr>
         <td align="center" style="padding:5px;"><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=6&pid='.$arrPatientList4[$bedID4].'">'.$bedID4.' '.$arrPatientName4[$arrPatientList4[$bedID4]].'</a></td>
     </tr>
                  	 '."\n";
		}
	}
	echo '
</table>
</div>'."\n";
     }
?>