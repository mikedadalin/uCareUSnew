<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上傳照片</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content-query">
<?php
include("DB.php");
include("function.php");

if (@$_GET['EmpID']==0 || @$_GET['EmpID']=="") {
	echo '<script>alert(\'員工編號錯誤，請確認！\');self.close();</script>';
} else {
	$EmpID = @$_GET['EmpID'];
}

if (isset($_FILES['photo']['name']) && $_FILES['photo']['size']>0) {
	$parts=pathinfo($_FILES['photo']['name']); 
	$Extension = $parts['extension'];
	
	$filename = $EmpID.'_'.date(YmdHis).'.'.$Extension;
	
	$uploaddir = '../emp_pic/'.$_SESSION['nOrgID_lwj'].'/';
	//if (!is_dir($uploaddir)) mkdir($uploaddir);
	if (!file_exists($uploaddir)) {
		mkdir($uploaddir, 0777);
	}
	$uploadfile = $uploaddir . $filename;
	
	if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
	   $db3 = new DB;
	   $db3->query("UPDATE `employer_resume` SET `Photo`='".$filename."' WHERE `EmpID`='".$EmpID."'");
	}
	echo "<script>alert('上傳成功！'); window.opener.document.getElementById('fsjpg').style.display = 'block'; window.opener.document.getElementById('fsjpg').src='emp_pic/".$_SESSION['nOrgID_lwj'].'/'.$filename."'; self.close();</script>";
}
?>
<form action="uploadfilesEmp.php?EmpID=<?php echo @$_GET['EmpID']; ?>" method="post" enctype="multipart/form-data">
  <table width="400">
    <tr class="title">
      <td colspan="2">上傳員工照片</td>
    </tr>
    <tr>
      <td colspan="2"><input type="file" name="photo" id="photo"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="上傳" id="uplaod"></td>
    </tr>
  </table>
</form>
</div>

</body>
</html>