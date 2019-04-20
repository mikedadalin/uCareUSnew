<?php
$db1 = new DB;
$db1->query("SELECT * FROM `socialform11c` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."'");
if ($db1->num_rows()==0) {
	$db2 = new DB;
	$db2->query("INSERT INTO `socialform11c` (`HospNo`, `date`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".mysql_escape_string(str_replace("/","",$_POST['date']))."');");
	
}
foreach ($_POST as $k=>$v) {
	$k = str_replace("edit","",$k);
	$k = str_replace("view","",$k);
	$k = str_replace("new","",$k);
	if ($k!='act' && $k!='HospNo' && $k!='date' && $k!='no' && $k!='formID' && substr($k,0,4)!="dImg" && $k!="delCount" && substr($k,0,8)!="imgCount" && substr($k,0,6)!="Delimg" && substr($k,0,3)!="Del" && $k!="" && $k!="oldDate" ) {
		$db3 = new DB;
		$db3->query("UPDATE `socialform11c` SET `".mysql_escape_string($k)."`='".mysql_escape_string($v)."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."' ");
	}
}
$db3 = new DB;
$db3->query("UPDATE `socialform11c` SET `Qfiller`='".mysql_escape_string($_SESSION['ncareID_lwj'])."' WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `date`='".str_replace("/","",$_POST['date'])."'");

include('class/imageClass.php');
$uploaddir3 = 'uploadfile/'.$_SESSION['nOrgID_lwj'];
$uploaddir2 = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$_POST['HospNo'].'/';
$uploaddir = 'uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$_POST['HospNo'].'/socialwork11c_pic/';
if (!file_exists($uploaddir3)) { mkdir($uploaddir3, 0777); }
if (!file_exists($uploaddir2)) { mkdir($uploaddir2, 0777); }
if (!file_exists($uploaddir)) {	mkdir($uploaddir, 0777); }

if ($_POST['act']=="new") {
	$picno = $_POST['newimgCount'];
} else {
	$picno = $_POST[$_POST['act'].'imgCount'.str_replace("/","",$_POST['oldDate'])];
}
for($i=1;$i<=$picno;$i++){
	if($_FILES['dImg'.$i]['name'] !="" && $_FILES['dImg'.$i]['size']>0){
		$parts=pathinfo($_FILES['dImg'.$i]['name']); 
		$Extension = strtolower($parts['extension']);
		if($Extension=="jpg" || $Extension=="jpg" || $Extension=="gif" || $Extension=="png" || $Extension=="bmp"){	
			$filename = str_replace("/","",$_POST['date']).'_'.date("YmdHis").'_'.$i.'.'.strtolower($Extension);
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
if(isset($_SESSION['GNO'])){
	$GNO_Change = 0;
	$kGF3 = 'Gname_'.$_SESSION['GNO'];
	$arr_Gname3 = explode("_",$_SESSION[$kGF3]);
	$_SESSION[$kGF3] = $arr_Gname3[0].'_'.$arr_Gname3[1].'_1';
	for($iGF=1;$iGF<11;$iGF++){
		$kGF = 'Glink_'.$iGF;
		if(isset($_SESSION[$kGF])){
			$kGF2 = 'Gname_'.$iGF;
			$arr_Gname2 = explode("_",$_SESSION[$kGF2]);
			if($arr_Gname2[2]=="0" && $GNO_Change==0){
				$_SESSION['GNO'] = $iGF;
				$GNO_Change = 1;
				?><script>window.location.href="<? echo $_SESSION[$kGF];?>"</script><?
			}
		}
	}
	if($GNO_Change==0){
		if(isset($_SESSION['G_mod']) && isset($_SESSION['G_func']) && isset($_SESSION['G_pid'])){
			$GENDurl = '<script>index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'&pid='.$_SESSION['G_pid'].'</script>';
		}elseif(isset($_SESSION['G_mod']) && isset($_SESSION['G_func'])){
			$GENDurl = '<script>index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'</script>';
		}else{
			$GENDurl = '<script>history.go(-2)</script>';
		}
		for($iGF=1;$iGF<11;$iGF++){
			$kGF = 'Glink_'.$iGF;
			$kGF2 = 'Gname_'.$iGF;
			unset($_SESSION[$kGF]);
			unset($_SESSION[$kGF2]);
		}
		unset($_SESSION['GNO']);
		unset($_SESSION['GListName']);
		unset($_SESSION['G_Temp_Link']);
		unset($_SESSION['G_GNOnumber']);
		unset($_SESSION['G_mod']);
		unset($_SESSION['G_func']);
		unset($_SESSION['G_pid']);
		echo $GENDurl;
	}
}elseif($_POST['view'] ==5 && $_POST['part']==1){
	echo '<script>window.location.href=\'index.php?mod=management&func=formview&view=5&part=1&id=3\';</script>';
} else{
	echo '<script>history.go(-1);</script>';
}
?>