<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload family tree image</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content-query">
<?php
include("DB.php");
include("function.php");
include('imageClass.php');
if (@$_GET['date']=="" || @$_GET['date']=="//") {
	echo '<script>alert(\'Select list date first！\');self.close();</script>';
} else {
	$date = str_replace("/","",@$_GET['date']);
}

if (@$_GET['pid']==0 || @$_GET['pid']=="") {
	echo '<script>alert(\'Care ID# not match, please comfirm！\');self.close();</script>';
} else {
	$pid = getHospNo(@$_GET['pid']);
}
if (isset($_FILES['photo']['name']) && $_FILES['photo']['size']>0) {
	
	$uploaddir3 = '../uploadfile/'.$_SESSION['nOrgID_lwj'];
	$uploaddir2 = '../uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$pid.'/';
	$uploaddir = '../uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$pid.'/socialform01_pic/';
	if (!file_exists($uploaddir3)) { mkdir($uploaddir3, 0777); }
	if (!file_exists($uploaddir2)) { mkdir($uploaddir2, 0777); }
	if (!file_exists($uploaddir)) {	mkdir($uploaddir, 0777); }
	
	$parts=pathinfo($_FILES['photo']['name']); 
	$Extension = strtolower($parts['extension']);
	if($Extension=="jpeg" || $Extension=="jpg" || $Extension=="gif" || $Extension=="png" || $Extension=="bmp"){	
		$filename = $pid.'_'.date(YmdHis).'.'.strtolower($Extension);	
	
		$uploadfile = $uploaddir . $filename;
		
		$image = new SimpleImage();
		$image->load($_FILES['photo']['tmp_name']);
		$width = $image->getWidth();
		$height = $image->getHeight();
		if ($width > $height ) {
			if ($width > 800) { $image->resizeToWidth(800); } //橫
		} else {
			if ($height > 800) { $image->resizeToHeight(800); } //直
		}
		$image->save($uploadfile);
		
		$db = new DB;
		$db->query("SELECT `QFamilyTreeJPG` FROM `socialform01` WHERE `HospNo`='".$pid."' AND `date`='".$date."'");
		if ($db->num_rows()==0) {
		   $db2 = new DB;
		   $db2->query("INSERT INTO `socialform01` (`HospNo`, `date`) VALUES ('".$pid."', '".$date."')");
		}
		$db3 = new DB;
		$db3->query("UPDATE `socialform01` SET `QFamilyTreeJPG`='".$filename."' WHERE `HospNo`='".$pid."' AND `date`='".$date."'");
		   
		echo "<script>alert('Upload successful！'); window.opener.document.getElementById('fsjpg').style.display = 'block'; window.opener.document.getElementById('fsjpg').src='uploadfile/".$_SESSION['nOrgID_lwj'].'/'.$pid.'/socialform01_pic/'.$filename."'; self.close();</script>";
	} else {
		echo "<script>alert('Incorrect file format');window.close();</script>";
	}
}
?>
<form action="uploadfiles.php?pid=<?php echo @$_GET['pid']; ?>&date=<?php echo @$_GET['date']; ?>" method="post" enctype="multipart/form-data">
  <table width="400">
    <tr class="title">
      <td colspan="2">Upload family tree image</td>
    </tr>
    <tr>
      <td colspan="2"><input type="file" name="photo" id="photo"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Upload" id="uplaod"></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>