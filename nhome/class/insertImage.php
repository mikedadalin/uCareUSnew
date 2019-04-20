<?php 
	include('imageClass.php');
	if (!file_exists($uploaddir1)) {	@mkdir($uploaddir1, 0777); }
	if (!file_exists($uploaddir)) {	@mkdir($uploaddir, 0777); }
	
	for($i=1;$i<=$_POST['imgCount'];$i++){
		if($_FILES['dImg'.$i]['name'] !="" && $_FILES['dImg'.$i]['size']>0){
			$parts=pathinfo($_FILES['dImg'.$i]['name']); 
			$Extension = strtolower($parts['extension']);
			if($Extension=="jpeg" || $Extension=="jpg" || $Extension=="gif" || $Extension=="png" || $Extension=="bmp"){	
				$filename = 'IMG'.$i.date(YmdHis).'.'.strtolower($Extension);
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

?>