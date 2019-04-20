<?
if(substr($_SESSION['ncareID_lwj'],0,8)!="resident" && isset($_GET['pid']) && $_SESSION['ncareLevel_lwj']!=5 && $_SESSION['GroupLeader_lwj']!=1 && $_SESSION['ncareID_lwj']!=getPrimary_Duty_Nurse(getPatientArea($_GET['pid']))){
	$PatientArea = getPatientArea($_GET['pid']);
	if($PatientArea!="---" && !in_array($PatientArea,$User_Shift_Area)){
		echo "<script>alert('Insufficient permissions'); window.location.href='index.php?func=home';</script>";
	}
}
?>