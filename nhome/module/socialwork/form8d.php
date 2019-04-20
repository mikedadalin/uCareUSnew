<div class="moduleNoTab">
	<h3>Activity photo gallery</h3>
	<?php
	if (isset($_POST['submit'])) {
		include('class/imageClass.php');
		$uploaddir1 = 'socialform08_pic/'.$_SESSION['nOrgID_lwj'].'/';
		$uploaddir = 'socialform08_pic/'.$_SESSION['nOrgID_lwj'].'/'.$_GET['actNo'].'/';
		if (!file_exists($uploaddir1)) {	mkdir($uploaddir1, 0777); }
		if (!file_exists($uploaddir)) {	mkdir($uploaddir, 0777); }

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

	echo "<script>window.location.href='index.php?mod=socialwork&func=formview&id=8d&actNo=".$_GET['actNo']."'</script>";
}
$arrCateName = array();
$arrActName = array();
$db1a = new DB;
$db1a->query("SELECT DISTINCT `cateName` FROM `socialform08_act`");
for ($i1a=1;$i1a<=$db1a->num_rows();$i1a++) {
	$r1a = $db1a->fetch_assoc();
	$arrCateName[$i1a] = $r1a['cateName'];
	$db1b = new DB;
	$db1b->query("SELECT * FROM `socialform08_act` WHERE `cateName`='".$r1a['cateName']."'");
	for ($i1b=0;$i1b<$db1b->num_rows();$i1b++) {
		$r1b = $db1b->fetch_assoc();
		$arrActName[$i1a][$r1b['actID']] = $r1b['actName'];
	}
}
if (@$_GET['actNo']!="") {
	$db1c = new DB;
	$db1c->query("SELECT * FROM `socialform08` WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."'");
	$r1c = $db1c->fetch_assoc();
	$db1d = new DB;
	$db1d->query("SELECT * FROM `socialform08_act` WHERE `actID`='".$r1c['actID']."'");
	$r1d = $db1d->fetch_assoc();
	$cateName = $r1d['cateName'];
	$actName = $r1d['actName'];
	$date = formatdate($r1c['date']);
	$arrSelectedHospNo = explode(";",$r1c['HospNo']);
	
	$db1e = new DB;
	$db1e->query("SELECT * FROM `socialform08a` WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."'");
	if ($db1e->num_rows()>0) {
		$r1e = $db1e->fetch_assoc();
		foreach ($r1e as $k=>$v) {
			if (substr($k,0,1)=="Q") {
				$arrAnswer = explode("_",$k);
				if (count($arrAnswer)==2) {
					if ($v==1) {
						${$arrAnswer[0]} .= $arrAnswer[1].';';
					}
				} else {
					${$k} = $v;
				}
			}  else {
				${$k} = $v;
			}
		}
	}
}
?>
<form id="socialform08" method="post" enctype="multipart/form-data" onsubmit="return checkDel();">
	<table width="100%">
		<tr>
			<td width="160" class="title">Activity category</td>
			<td align="center"><?php echo $cateName . ' - ' . $actName; ?></td>
			<td width="160" class="title">Date</td>
			<td><input type="text" name="date" id="date" size="10" value="<?php echo $date==NULL?date("Y/m/d"):$date; ?>"  readonly />&nbsp;Time:&nbsp;<input type="text" id="Q12" name="Q12" value="<?php echo $Q12;?>" readonly></td>
		</tr>
		<?php
		$picFolder = 'socialform08_pic/'.$_SESSION['nOrgID_lwj'].'/'.$_GET['actNo'];
		if (file_exists($picFolder)) {
			?>
			<tr>
				<td colspan="4">
					<?php
					$arrFiles = scandir($picFolder);
					for ($i=2;$i<count($arrFiles);$i++) {
						echo '
						<div style="margin:5px; padding:10px; background:#fff; display:inline-block;">
						<input type="checkbox" name="Del'.$i.'" id="Del'.$i.'"> DELETE<br>
						<a href="'.$picFolder.'/'.$arrFiles[$i].'" class="example-image-link" data-lightbox="example-set"><img src="'.$picFolder.'/'.$arrFiles[$i].'" width="200"></a>
						<input type="hidden" name="Delimg'.$i.'" id="Delimg'.$i.'" value="'.$picFolder.'/'.$arrFiles[$i].'">
						</div>
						';
					}
					?>
					<input type="hidden" name="delCount" id="delCount" value="<?php echo count($arrFiles); ?>">
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="4">
				<?php include("class/addImage.php");?>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="title"><input type="hidden" id="actNo" name="actNo" value="<?php echo $_GET['actNo']; ?>"><input type="button" onClick="window.location.href='index.php?mod=socialwork&func=formview&id=8';" value="Back to list" /><input type="submit" name="submit" value="Save" /></td>
		</tr>
	</table>
</form>
</div>
<script>
function checkDel() {
	var delCount = $('#delCount').val();
	var count=0;
	for (var i=1;i<=delCount;i++) {
		if ($('#Del'+i).attr('checked')) {
			count++;
		}
	}
	if (count>0) {
		if (confirm("確認刪除圖片?")) {
			return true;
		} else {
			return false;
		}
	}
}
</script>