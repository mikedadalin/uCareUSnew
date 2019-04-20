<table width="100%" style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
  <tr>
    <td width="150" rowspan="2" valign="top"><div style="background-color:rgba(150,150,150,0.8); padding-top:10px; padding-bottom:10px;"><?php include("ResidentCol.php"); ?></div></td>
    <td valign="top">
    <table width="100%">
      <tr>
        <td valign="middle" width="300"><h3 align="center">Body Weight</h3></td>
        <td align="right"><?php echo $basicinfo; ?></td>
      </tr>
    </table>
    <table cellpadding="6px" width="100%">
      <tr bgcolor="#f54d5d" style="color:#ffffff;" align="center">
        <td>Full name</td>
        <td>Type(s)</td>
        <td>Value(s)</td>
        <td>Measured time</td>
      </tr>
      <?php
	  if ($_SESSION['ncareOrgStatus_lwj']==2) {
		  $arrNotStat = array();
		  $db3 = new DB;
		  $db3->query("SELECT `patientID` FROM `patient` WHERE `instat`='0';");
		  for ($i3=0; $i3<$db3->num_rows(); $i3++) {
			  $r3 = $db3->fetch_assoc();
			  $arrNotStat[$i3] = $r3['patientID'];
		  }
	  }
	  /* 原V 
	  $db2 = new DB;
	  $db2->query("SELECT * FROM `vitalsigns` WHERE `LoincCode`='18833-4' AND `IsValid`='1' ORDER BY `VitalSignID` DESC LIMIT 0,30");
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = explode(".",$r2['RecordedTime']);
		  if ($i%2==0) { $bgcolor = '#feeced'; } else { $bgcolor = '#ffffff'; }
		  echo '
	  <tr bgcolor="'.$bgcolor.'" align="left"'.($_SESSION['ncareOrgStatus_lwj']==2 && in_array($r2['PersonID'], $arrNotStat)?' style="display:none;"':"").'>
        <td align="center"><a href="index.php?mod=nutrition&func=patient&id=1b&pid='.$r2['PersonID'].'" style="color:#5daeb1;">'.getPatientName($r2['PersonID']).'</a></td>
        <td align="center">'.$arrVital[$r2['LoincCode']].'</td>
        <td align="center">'.$r2['Value'].'</td>
        <td align="center">'.$RecordTime[0].'</td>
      </tr>  
		  '."\n";
	  }
	  */
	  // 新V START
	  $db2 = new DB;
	  $db2->query("SELECT `PatientID`,`date`,`time`,`loinc_18833_4` FROM `vitalsign` WHERE `loinc_18833_4`!='' ORDER BY `date` DESC, `time` DESC LIMIT 0,30");
	  for ($i=0;$i<$db2->num_rows();$i++) {
		  $r2 = $db2->fetch_assoc();
		  $RecordTime = date("Y-m-d",strtotime($r2['date']))." ".date("H:i",strtotime($r2['time']));
		  if ($i%2==0) { $bgcolor = '#feeced'; } else { $bgcolor = '#ffffff'; }
		  foreach ($r2 as $k=>$v) {
			  $arrVitalsign = explode("_",$k);
			  if ($arrVitalsign[0]=="loinc" && $v!="") {
				  $LoincCode = $arrVitalsign[1]."-".$arrVitalsign[2];
				  echo '
				  <tr bgcolor="'.$bgcolor.'" align="left"'.($_SESSION['ncareOrgStatus_lwj']==2 && in_array($r2['PatientID'], $arrNotStat)?' style="display:none;"':"").'>
				  <td align="center"><a href="index.php?mod=nutrition&func=patient&id=1b&pid='.$r2['PatientID'].'" style="color:#5daeb1;">'.getPatientName($r2['PatientID']).'</a></td>
				  <td align="center">'.$arrVital[$LoincCode].'</td>
				  <td align="center">'.$v.'</td>
				  <td align="center">'.$RecordTime.'</td>
				  </tr>'."\n";
			  }
		  }
	  }
	  // 新V END
	  ?>
    </table>
    </td>
  </tr>
</table><br><br>