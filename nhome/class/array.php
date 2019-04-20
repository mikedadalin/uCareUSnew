<?php
$allowedip = array("114.34", "61.220");
$arrPatientType = array("", "General", "Temporary", "Respite", "Govnment", "Emergency");
$arrMedDay = array("Mon","Tues","Wed","Thur","Fri","Sat","Sun","1/day","1/2day");
$arrYesNo = array('---','yes','no');
$arrGender = array('Unfilled','Male','Female');
$arrInPatStatus = array('---','registered','checked-in');
$arrDay = array('1','2','3','4','5','6','7');
$arrPHPDay = array("Mon"=>"Mon","Tue"=>"Tue","Wed"=>"Wed","Thu"=>"Thu","Fri"=>"Fri","Sat"=>"Sat","Sun"=>"Sun");
$arrVital = array('8310-5'=>'Temperature', '8867-4'=>'Heartbeats', '8480-6'=>'Systolic BP', '8462-4'=>'Diastolic BP', '2710-2'=>'SpO2', '14743-9'=>'AC Blood glucose', '15075-5'=>'PC Blood glucose', '3141-9'=>'Body weight', '9279-1'=>'Respiration', '46033-7'=>'Pain scale', '18833-4'=>'Body weight', '39106-0'=>'Axillary temperature');
$arrVital2 = array('vs83105'=>'Temperature', 'vs88674'=>'Heartbeats', 'vs84806'=>'Systolic BP', 'vs84624'=>'Diastolic BP', 'vs27102'=>'SpO2', 'vs14743'=>'AC Blood glucose', 'vs150755'=>'PC Blood glucose', 'vs31419'=>'Body weight', 'vs92791'=>'Respiration', 'vs460337'=>'Pain scale', 'vs188334'=>'Body weight', 'vs391060'=>'Axillary temperature');
$arrVital3 = array('8310-5'=>'vs83105', '8867-4'=>'vs88674', '8480-6'=>'vs84806', '8462-4'=>'vs84624', '2710-2'=>'vs27102', '14743-9'=>'vs147439', '15075-5'=>'vs150755', '3141-9'=>'vs31419', '9279-1'=>'vs92791', '46033-7'=>'vs460337', '18833-4'=>'vs188334', '39106-0'=>'vs391060');
$arrVitalConvert = array('Ear'=>'8310-5', 'Pulse'=>'8867-4', 'Sys'=>'8480-6', 'Dia'=>'8462-4', 'SpO2'=>'2710-2', 'BG'=>'14743-9', 'BG'=>'15075-5');
$arrNursediag = array('1' => 'Airway clearance failure', '2' => 'Ineffective breathing pattern', '3' => 'Physical activity dysfunction', '4' => 'Stool pattern change.constipation', '5' => 'Stool pattern change.diarrhea', '6' => 'Phagocytic digestive dysfunction', '7' => 'Nutritional status change.less than body need', '8' => 'Nutritional status change.more than body need', '9' => 'Existing impaired skin integrity wound', '10' => 'Comfort status change-hyperthermia', '11' => 'Comfort status change-itching', '12' => 'Excessive fluid volume', '13' => 'Serious hazardous respiratory infections', '14' => 'Serious hazardous-urinary tract infections', '15' => 'Serious hazardous-fall', '16' => 'Sensory and perceptual changes-vision & Auditory, sense of direction', '17' => 'Self-care deficit-bathing and hygiene', '18' => 'Self-care deficit-clothing and accessory', '19' => 'Self-care deficit-intake', '20' => 'Self-care deficit-toilet', '21' => 'Sleep patterns disorder', '22' => 'New residents adaptation anxiety', '23' => 'Protective restraint', '24' => 'Oral mucosal changes', '25' => 'Potentially hazardous infections: indwelling urine catheter', '26' => 'Potentially hazardous wound: fall', '27' => 'Comfort status change-pain', '28' => 'Piping removed - the indwelling urine catheter', '29'=> 'Nasogastric tube removed', '30'=> 'Fluid volume deficit', '31'=> 'Poor glycemic control - too high', '32'=> 'Poor glycemic control - too low', '33'=> 'High cholesterol', '34'=> 'Fear', '35'=> 'Powerlessness', '36'=> 'Cognitive dysfunction', '37'=> 'Verbal communication impaired', '38'=> 'Anticipative/existing grieving', '39'=> 'Hospice care', '40'=> 'Self-directed violence-Moderate', '41'=> 'Self-directed violence-Severe', '42'=> 'Self-directed violence-Mild', '43'=> 'Noncompliance/Uncooperative', '44'=> 'Confusion/orderless-acute', '45'=> 'Sensory perception disturbed/abnormal(Hallucination)', '46'=> ' Violence (other-directed)');
$arrFormFreq = array(
//value X 為X天填寫一次，只需填寫一次的表單 X=99  value X means filling once per X day, one-time filling set X=99
'nurseform01' => -1, 'nurseform01a' => 99, 'nurseform02a' => 99, 'nurseform02b' => 90, 'nurseform02c' => 90, 'nurseform02d' => 90, 'nurseform02e' => 90, 'nurseform02f' => 90,  'nurseform02g' => -1, 'nurseform02g_1' => -1, 'nurseform02g_2' => -1, 'nurseform02h' => 90, 'nurseform02j' => -1, 'nurseform11' => 3, 'nurseform12' => 3, 'nurseform16' => 0, 'nursediag01' => -1, 'nursediag02' => -1, 'nursediag03' => -1, 'nursediag04' => -1, 'nursediag05' => -1, 'nursediag06' => -1, 'nursediag07' => -1, 'nursediag08' => -1, 'nursediag09' => -1, 'nursediag10' => -1, 'nursediag11' => -1, 'nursediag12' => -1, 'nursediag13' => -1, 'nursediag14' => -1, 'nursediag15' => -1, 'nursediag16' => -1, 'nursediag17' => -1, 'nursediag18' => -1, 'nursediag19' => -1,'nursediag20' => -1, 'nursediag21' => -1, 'nursediag22' => -1, 'nursediag23' => -1, 'nursediag24' => -1, 'nursediag25' => -1, 'nursediag26' => -1, 'nursediag27' => -1, 'nursediag28' => -1, 'socialform20_1' => -1, 'socialform20_2' => -1
);
$arrFormHospital = array('Hospital 1','Hospital 2','Hospital 3','Hospital 4','Hospital 5','Hospital 6','Hospital 7','Hospital 8','Hospital 9','Other');//Local hospital name + other hospital
$arrForm16_Q4 = array("1" =>'ER', "2" =>'outpatient');
$arrForm2k_Q1 = array("1"=>"urine catheter (Foley)", "2" =>"Urine catheter - Cystostomy (Foley)", "3"=>"(NG tube)", "4"=>"(Tracheal tube)",  "5"=>"Gastrostomy",  "6"=>"Enterostomy");
$arrForm2k_Q2 = array("1"=>"General", "2" =>"Siliceous", "3"=>"Steel", "4"=>"PVC", "5"=>"Shillen");
$arrSocialform05_Q1 = array("1"=>"adaptational problem", "2"=>"emotional problem", "3"=>"behavioral problem", "4"=>"health problem", "5"=>"economic issues", "6"=>"family problem", "7"=>"Other");
$arrSocialform06a_Q33 = array("0"=>"not evaluated", "1"=>"no adaptational problem,general casework service mode", "2"=>"adaptational problem,special service mode");
?>