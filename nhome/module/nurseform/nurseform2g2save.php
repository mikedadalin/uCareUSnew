<?php
if($_POST['CheckInRecord']=="0"){$CheckInRecord="0";}else{$CheckInRecord="1";}
$db = new DB;
$db->query("SELECT * FROM `nurseform02g_2` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".mysql_escape_string($_POST['no'])."'");
if ($db->num_rows()==0) {
	$db1 = new DB;
	$db1->query("INSERT INTO `nurseform02g_2` (`HospNo`, `date`, `no`, `ReportID`, `CheckInRecord`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."', '".mysql_escape_string($_POST['no'])."', '', '".$CheckInRecord."');");
}else{
	$r1b = $db->fetch_assoc();
}
$theno = $_POST['no'];

if($r1b['Q27']==NULL || $r1b['Q27']==""){
	$db3 = new DB;
	$db3->query("UPDATE `nurseform02g_2` SET `Q27`='".mysql_escape_string($_POST['Q27'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
}
foreach ($_POST as $k=>$v) {
	$k = str_replace("edit","",$k);
	$k = str_replace("view","",$k);
	$k = str_replace("new","",$k);
	if ($k!='act' && $k!='HospNo' && $k!='date' && $k!='no' && $k!='formID' && substr($k,0,4)!="dImg" && $k!="delCount" && substr($k,0,8)!="imgCount" && substr($k,0,6)!="Delimg" && substr($k,0,3)!="Del" && $k!='Q27' && $k!='view' && $k!='part' && $k!="" && $k!="oldDate" && $k!="oldNo") {
		$db3 = new DB;
		$db3->query("UPDATE `nurseform02g_2` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");
	}
}
$db3 = new DB;
$db3->query("UPDATE `nurseform02g_2` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' AND `no`='".$theno."'");

include('class/imageClass.php');
$uploaddir3 = 'uploadfile/'.$_SESSION['nOrgID_lwj'];
$uploaddir2 = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$_POST['HospNo'].'/';
$uploaddir = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$_POST['HospNo'].'/nurseform2g2_pic/';
if (!file_exists($uploaddir3)) { mkdir($uploaddir3, 0777); }
if (!file_exists($uploaddir2)) { mkdir($uploaddir2, 0777); }
if (!file_exists($uploaddir)) {	mkdir($uploaddir, 0777); }

if ($_POST['act']=="new") {
	$picno = $_POST['newimgCount'];
} else {
	$picno = $_POST[$_POST['act'].'imgCount'.str_replace("/","",$_POST['oldDate']).'_'.$_POST['oldNo']];
}
for($i=1;$i<=$picno;$i++){
	if($_FILES['dImg'.$i]['name'] !="" && $_FILES['dImg'.$i]['size']>0){
		$parts=pathinfo($_FILES['dImg'.$i]['name']); 
		$Extension = strtolower($parts['extension']);
		if($Extension=="jpg" || $Extension=="jpg" || $Extension=="gif" || $Extension=="png" || $Extension=="bmp"){	
			$filename = str_replace("/","",$_POST['date']).'_'.$theno.'_'.date(YmdHis).'_'.$i.strtolower($Extension);
			$uploadfile = $uploaddir . $filename;
			
			$image = new SimpleImage();
			$image->load($_FILES['dImg'.$i]['tmp_name']);
			$width = $image->getWidth();
			$height = $image->getHeight();
			if ($width > $height ) {
				if ($width > 800) { $image->resizeToWidth(800); } //橫
			} else {
				if ($height > 800) { $image->resizeToHeight(800); } //直
			}
			$image->save($uploadfile);			
		}else{
			echo "<script>alert('上傳格式錯誤')</script>";
		}
	}
}
//Delete
for($i=1;$i<=$_POST['delCount'];$i++){
	if ($_POST['Del'.$i]=="on") {
		unlink($_POST['Delimg'.$i]);
	}
}

$db4 = new DB;
$db4->query("SELECT `patientID` FROM `patient` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."'");
$r4 = $db4->fetch_assoc();
$pid = $r4['patientID'];

if($_POST['view'] ==5 && $_POST['part']==1){
	echo '<script>window.location.href=\'index.php?mod=management&func=formview&view=5&part=1&id=3\';</script>';
} else{
	/*echo '<script>history.go(-1);</script>';*/
	echo '<script>window.location.href=\'index.php?mod=nurseform&func=formview&pid='.$pid.'&id=2g_2\';</script>';	
}
?>