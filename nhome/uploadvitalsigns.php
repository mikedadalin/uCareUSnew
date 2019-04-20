<div class="content-table">
<form><h3>Import vital sign report</h3>
<table width="100%">
  <tr class="title">
    <td>Resident name</td>
    <td>care ID#</td>
    <td>Vital sign category</td>
    <td>value</td>
    <td>Measurment time</td>
    <td>View</td>
  </tr>
<?php
$DestDIR = "C:\inetpub\wwwroot\uCare\uploadfile";
$File_Extension = explode(".", $_FILES['vitalsigncsv']['name']);
$File_Extension = $File_Extension[count($File_Extension)-1];
$File_Extension = strtolower($File_Extension);
$ServerFilename = date(YmdHis) . "." . $File_Extension;
if ($_FILES["vitalsigncsv"]['size']>0)
{
	$pathfile = $DestDIR . "/" . $ServerFilename;
	//copy($_FILES['vitalsigncsv']['tmp_name'] , $pathfile );
	$file_handle = fopen($_FILES['vitalsigncsv']['tmp_name'], "r");
	$count = 0;
	while (!feof($file_handle)) {
		$line = fgets($file_handle);
		if(strlen($line)>2) {
			$value = explode(',',$line);
			$bedID = str_replace(' ',"",$value[1]); $bedID = $bedID + 0; //Bed # bed number
			$MeasureDate = $value[2]; //量測日期 measurment date
			$MeasureTime = $value[3]; //Measured time measurment time
			$Vitals = $value[4]; //量測數值 measurment value
			$arrVitals = explode(' ;',$Vitals);
			$db= new DB;
			$db->query("SELECT `patientID` FROM `inpatientinfo` WHERE `bed`='".$bedID."'");
			$r = $db->fetch_assoc();
			$db1 = new DB;
			$db1->query("SELECT `HospNo` FROM `patient` WHERE `patientID`='".$r['patientID']."'");
			$r1 = $db1->fetch_assoc();
			$HospNo = $r1['HospNo'];
			
			foreach ($arrVitals as $k=>$v) {
				if($count!=0) {
					/*$SignValue = preg_match("/[a-zA-Z]/",$v);
					$arrValue = explode(' ',$SignValue);
					$SignValue = $arrValue[0];
					$SignCate = preg_match("/[0-9]/",$v);
					$arrCate = explode(':',$SignCate);
					$SignCate = $arrCate[0];
					if ($SignCate == "SpO") { $SignValue = substr($SignValue,1,strlen($SignValue)-1); $SignValue = str_replace(':','',$SignValue); } else { $SignValue = str_replace(':','',$SignValue); } //value
					
					$SignCate = $arrVitalConvert[$SignCate]; //量測數值種類measurment value type(category)*/
					
					$msgarray = explode(":",$v);
					$valuearray = explode(" ",$msgarray[1]);
					$SignValue = $valuearray[0];
					$SignCate = $arrVitalConvert[$msgarray[0]];
					
					if ($SignValue=='65535') { $SignValue = '65'; }
					
					$queryHospNo = new DB;
					$queryHospNo->query("SELECT `patientID`, `Name` FROM `patient` WHERE `HospNo`='".$HospNo."'");
					$rPID = $queryHospNo->fetch_assoc();
					
					$pid = $rPID['patientID']; //住民ID
					$pName = $rPID['Name'];
					
					$MeasureDate = str_replace('/','-',$MeasureDate);
					$MeasureDateWithYMOnly = substr($MeasureDate,0,4).substr($MeasureDate,5,2);
					/* 原V
					$MeasureDateTime = $MeasureDate.' '.$MeasureTime.".0000000"; //量測日期時間measurment date and time
					$UploadDateTime = date("Y-m-d H:i:s").".0000000";  //上傳日期時間upload date and time
					
					if ($pid!='0') {
						$checkexist = new DB;
						$checkexist->query("SELECT * FROM `vitalsigns` WHERE `PersonID`='".$pid."' AND `LoincCode`='".$SignCate."' AND `RecordedTime`='".$MeasureDateTime."' AND `Value`='".$SignValue."'");
						if ($checkexist->num_rows==0) {
							$insertdb = new DB;
							$insertdb->query("INSERT INTO `vitalsigns` VALUES ('', '".$pid."', '".$SignCate."', '".$MeasureDateWithYMOnly."', '".$MeasureDateTime."', '".$UploadDateTime."', '".$SignValue."', '1')");
						}
					}
					*/
					// 新V START
					$MeasureDateTime = $MeasureDate.' '.$MeasureTime; //量測日期時間measurment date and time
					$date = str_replace('-','',$MeasureDate);
					$time = substr($MeasureTime,0,2).substr($MeasureTime,3,2);
					if ($pid!='0') {
						$arrSignCate = explode("-",$SignCate);
						$LoincCode = "loinc_".$arrSignCate[0]."_".$arrSignCate[1];
						$checkexist = new DB;
						$checkexist->query("SELECT * FROM `vitalsign` WHERE `PatientID`='".$pid."' AND `date`='".$date."' AND `time`='".$time."' AND `".$LoincCode."`='".$SignValue."'");
						if ($checkexist->num_rows==0) {
							$insertdb = new DB;
							$insertdb->query("INSERT INTO `vitalsign` (`VitalSignID`, `PatientID`, `date`, `time`, `".$LoincCode."`) VALUES ('', '".$pid."', '".$MeasureDateTime."', '".$time."', '".$SignValue."')");
						}
					}
					// 新V END
					$msg .= '
  <tr>
    <td>'.$pName.'</td>
    <td>'.$HospNo.'</td>
    <td>'.$arrVital[$SignCate].'</td>
    <td>'.$SignValue.'</td>
    <td>'.$MeasureDateTime.'</td>
    <td><a href="index.php?mod=dailywork&func=formview&pid='.$pid.'" target="_blank"><img src="Images/nurseform_icons/notes.png"></a></td>
  </tr>
					';
				}
			}
			$count++;
		}
	}
	fclose($file_handle);
	unlink($_FILES['vitalsigncsv']['tmp_name']);
}
echo $msg;
?>
</table>
</form>
</div>