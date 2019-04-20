<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload photo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content-query">
<?php
include("DB.php");
include("function.php");

if (@$_GET['pid']==0 || @$_GET['pid']=="") {
	echo '<script>alert(\'Error occur, please close and re-open the window to upload！\');self.close();</script>';
} else {
	$pid = @$_GET['pid'];
}

if (isset($_FILES['photo']['name']) && $_FILES['photo']['size']>0) {
	$parts=pathinfo($_FILES['photo']['name']); 
	$Extension = $parts['extension'];
	
	$filename = 'IDPhoto_'.date("YmdHis").'.'.$Extension;
	
	$uploaddir = '../uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.getHospNo($pid).'/';
	//if (!is_dir($uploaddir)) mkdir($uploaddir);
	if (!file_exists($uploaddir)) {
		mkdir($uploaddir, 0777);
	}
	$uploadfile = $uploaddir . $filename;
	
	if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
		$db3a = new DB;
		$db3a->query("SELECT * FROM `pat_idphoto` WHERE `HospNo`='".getHospNo($pid)."'");
		if ($db3a->num_rows()==0) {
			$db3b = new DB;
			$db3b->query("INSERT INTO `pat_idphoto` (`HospNo`) VALUES ('".getHospNo($pid)."')");
		}
		$db3c = new DB;
		$db3c->query("UPDATE `pat_idphoto` SET `photo`='".$filename."' WHERE `HospNo`='".getHospNo($pid)."'");
	}
	echo "<script>alert('uploaded successfully！'); window.opener.document.getElementById('fsjpg').style.display = 'block'; window.opener.document.getElementById('fsjpg').src='uploadfile/".$_SESSION['nOrgID_lwj'].'/'.getHospNo($pid).'/'.$filename."'; self.close();</script>";
}
?>
<form action="uploadfilesPatPic.php?pid=<?php echo @$_GET['pid']; ?>" method="post" enctype="multipart/form-data">
  <table width="400">
    <tr class="title">
      <td colspan="2">Upload resident profile photo</td>
    </tr>
    <tr>
      <td colspan="2"><input type="file" name="photo" id="photo"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="upload" id="uplaod"></td>
    </tr>
  </table>
</form>
</div>

</body>
</html>