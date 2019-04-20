<?php
if (@$_GET['pid']==NULL) {
	if (@$_GET['id']==NULL) {
		if(substr($_SESSION['ncareID_lwj'],0,8)=="resident"){
			$HospNo = substr($_SESSION['ncareID_lwj'],8,6);
			$db = new DB;
			$db->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($HospNo)."'");
			$r = $db->fetch_assoc();
			$url = "index.php?mod=inputoutput&func=formview&pid=".$r['patientID'];
			echo "<script type='text/javascript'>";
			echo "window.location.href='".$url."'";
			echo "</script>";
		}else{
			include('allpatient.php');
		}
	} else {
		echo '
		<table border="0" style="text-align:left; margin-left:3px;">
		  <tr>
		    <td style="border:none;" colspan="3">
			<div class="nurseform-table">';
		include("form".@$_GET['id'].".php");
		echo '
		    </div>
			</td>
		  </tr>
		</table>';
	}
} else {
	include('patient.php');
}
?>