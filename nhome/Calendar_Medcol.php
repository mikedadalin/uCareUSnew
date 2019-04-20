<script>
function switcharea3(bedarea) {
	if (document.getElementById('area3_'+bedarea).style.display=="none") {
		document.getElementById('area3_'+bedarea).style.display = "block";
		document.getElementById('expand3_'+bedarea).innerHTML = '-';
	} else {
		document.getElementById('area3_'+bedarea).style.display = "none";
		document.getElementById('expand3_'+bedarea).innerHTML = '+';
	}
}
</script>
      <?php
      $db = new DB;
      $db->query("SELECT `patientID`,`instat` FROM `patient` ORDER BY `patientID` ASC");
      $arrPatientList3 = array();
      $arrPatientName3 = array();
      $arrBedArea3 = array();
      for ($i=0;$i<$db->num_rows();$i++) {
            $r = $db->fetch_assoc();
            $db1 = new DB;
            $db1->query("SELECT `bed` FROM `inpatientinfo` WHERE `patientID`='".$r['patientID']."' ORDER BY `patientID` DESC LIMIT 0,1");
            for ($j=0;$j<$db1->num_rows();$j++) {
                  $r1 = $db1->fetch_assoc();
				  if ($_SESSION['ncareOrgStatus_lwj']==2) {
					  if ($r['instat']==1) {
						  $arrPatientList3[$r1['bed']] = $r['patientID'];
						  $arrPatientName3[$r['patientID']] = getPatientName($r['patientID']);
					  }
				  } else {
					  $arrPatientList3[$r1['bed']] = $r['patientID'];
					  $arrPatientName3[$r['patientID']] = getPatientName($r['patientID']);
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
				  $arrBedArea3[$r3['areaName']] .= $r2['bedID'].";";
            }
			$arrBedAreaID3[$r3['areaName']] = $r3['areaID'];
      }
       echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
          <td align="center"><a style="color:#fff;font-size:16px; font-weight:bold; height:30px; border:none; cursor:pointer;" href="index.php?func=Calendar&type=5">ALL</a></td>
     </tr>
</table>';
	  ksort($arrBedArea3);
     foreach ($arrBedArea3 as $area3=>$bed3) {
		 foreach ($arrBedAreaID3 as $areaName3=>$areaNameareaID3) {
			 if($areaName3==$area3){
				 $areaID3=$areaNameareaID3;
			}
		 }
         echo '
<table style="margin:0px auto; width:100%">
     <tr height="30">
         <td align="center" style="color:rgb(255, 255, 255);"><button onclick="switcharea3(\''.$area3.'\')" style="background-color:#7a7a7a; color:white; font-size:14px; font-weight:bolder; width:80%; height:30px; border:none; border-radius:5px; cursor:pointer;"><span id="expand3_'.$area3.'">+</span> '.$area3.' </button></td>
     </tr>
</table>
<div id="area3_'.$area3.'" style="display:none; font-size:10pt;">
<table style="width:100%">
	'."\n";
	echo '<tr align="center" style="padding:5px;"><td><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=5&area='.$areaID3.'" style="color:rgb(255, 255, 204); font-size:11pt;">'.$area3.'</a></td></tr>';
	$bedlist3 = explode(";",$bed3);
	foreach ($bedlist3 as $bedno3=>$bedID3) {
		if ($arrPatientName3[$arrPatientList3[$bedID3]]!='') {
			echo '
     <tr>
         <td align="center" style="padding:5px;"><a style="color:rgb(255,255,255);" href="index.php?func=Calendar&type=5&pid='.$arrPatientList3[$bedID3].'">'.$bedID3.' '.$arrPatientName3[$arrPatientList3[$bedID3]].'</a></td>
     </tr>
                  	 '."\n";
		}
	}
	echo '
</table>
</div>'."\n";
     }
?>