<script>
function switcharea1(bedarea) {
	if (document.getElementById('area1_'+bedarea).style.display=="none") {
		document.getElementById('area1_'+bedarea).style.display = "block";
		document.getElementById('expand1_'+bedarea).innerHTML = '-';
	} else {
		document.getElementById('area1_'+bedarea).style.display = "none";
		document.getElementById('expand1_'+bedarea).innerHTML = '+';
	}
}
</script>
      <?php
      $db = new DB;
      $db->query("SELECT `patientID`,`instat` FROM `patient` ORDER BY `patientID` ASC");
      $arrPatientList1 = array();
      $arrPatientName1 = array();
      $arrBedArea1 = array();
      for ($i=0;$i<$db->num_rows();$i++) {
            $r = $db->fetch_assoc();
            $db1 = new DB;
            $db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
            for ($j=0;$j<$db1->num_rows();$j++) {
                  $r1 = $db1->fetch_assoc();
				  if ($_SESSION['ncareOrgStatus_lwj']==2) {
					  if ($r['instat']==1) {
						  $arrPatientList1[$r1['bed']] = $r['patientID'];
						  $arrPatientName1[$r['patientID']] = getPatientName($r['patientID']);
					  }
				  } else {
					  $arrPatientList1[$r1['bed']] = $r['patientID'];
					  $arrPatientName1[$r['patientID']] = getPatientName($r['patientID']);
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
				  $arrBedArea1[$r3['areaName']] .= $r2['bedID'].";";
            }
			$arrBedAreaID1[$r3['areaName']] = $r3['areaID'];
      }
       echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
          <td align="center"><a style="color:#fff;font-size:16px; font-weight:bold; height:30px; border:none; cursor:pointer;" href="index.php?func=Calendar&type=3">ALL</a></td>
     </tr>
</table>';
	  ksort($arrBedArea1);
     foreach ($arrBedArea1 as $area1=>$bed1) {
		 foreach ($arrBedAreaID1 as $areaName1=>$areaNameareaID1) {
			 if($areaName1==$area1){
				 $areaID1=$areaNameareaID1;
				 $arrAreaPID[$areaID1]="";
			}
		 }
         echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
         <td align="center" style="color:rgb(255, 255, 255);"><button onclick="switcharea1(\''.$area1.'\')" style="background-color:#7a7a7a; color:white; font-size:14px; font-weight:bolder; width:80%; height:30px; border:none; border-radius:5px; cursor:pointer;"><span id="expand1_'.$area1.'">+</span> '.$area1.' </button></td>
     </tr>
</table>
<div id="area1_'.$area1.'" style="display:none; font-size:10pt;">
<table style="width:100%;">
	'."\n";
	echo '<tr align="center" style="padding:5px;"><td><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=3&area='.$areaID1.'" style="color:rgb(255, 255, 184); font-size:11pt;">'.$area1.'</a></td></tr>';
	$bedlist1 = explode(";",$bed1);
	foreach ($bedlist1 as $bedno1=>$bedID1) {
		if ($arrPatientName1[$arrPatientList1[$bedID1]]!='') {
			$arrAreaPID[$areaID1] .= $arrPatientList1[$bedID1].";";
			echo '
     <tr>
         <td align="center" style="padding:5px;"><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=3&pid='.$arrPatientList1[$bedID1].'">'.$bedID1.' '.$arrPatientName1[$arrPatientList1[$bedID1]].'</a></td>
     </tr>
                  	 '."\n";
		}
	}
	echo '
</table>
</div>'."\n";
     }
?>