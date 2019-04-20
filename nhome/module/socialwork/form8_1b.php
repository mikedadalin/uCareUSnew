<div class="moduleNoTab">
	<h3>Group activities record</h3>
	<?php
	if (isset($_POST['submit'])) {

		$db0b = new DB;
		$db0b->query("UPDATE `socialform08` SET `Qfiller`='".mysql_escape_string($_POST['Qfiller'])."' WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."';");

		$db1 = new DB;
		$db1->query("SELECT * FROM `socialform08a` WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."'");
		if($db1->num_rows()==0){
			$db = new DB;
			$db->query("INSERT INTO `socialform08a` (`actNo`) VALUES ('".mysql_escape_string($_GET['actNo'])."');");
		}
		$db1b = new DB;
		$db1b->query("UPDATE `socialform08a` SET `Q13` = '".mysql_escape_string($_POST['Q13'])."', `Q13a` = '".mysql_escape_string($_POST['Q13a'])."', `Q14` = '".mysql_escape_string($_POST['Q14'])."', `Q14a` = '".mysql_escape_string($_POST['Q14a'])."', `Q15` = '".mysql_escape_string($_POST['Q15'])."', `Q16` = '".mysql_escape_string($_POST['Q16'])."', `Q17` = '".mysql_escape_string($_POST['Q17'])."', `Q18` = '".mysql_escape_string($_POST['Q18'])."', `Q19` = '".mysql_escape_string($_POST['Q19'])."' WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."'");

		if (isset($_FILES['photo']['name']) && $_FILES['photo']['size']>0) {
			include('class/imageClass.php');
			$uploaddir = 'socialform08_pic/'.$_SESSION['nOrgID_lwj'].'/';
			if (!file_exists($uploaddir)) {	mkdir($uploaddir, 0777); }

			$parts=pathinfo($_FILES['photo']['name']); 
			$Extension = strtolower($parts['extension']);
			if($Extension=="jpeg" || $Extension=="jpg" || $Extension=="gif" || $Extension=="png" || $Extension=="bmp"){	
				$filename = $_GET['actNo'].'_Act.'.strtolower($Extension);	
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
			
			$db1 = new DB;
			$db1->query("SELECT * FROM `socialform08a` WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."'");
			if($db1->num_rows()>0){
				$db = new DB;
				$db->query("UPDATE `socialform08a` SET `Q20` = '".$filename."' WHERE `actNo`='".mysql_escape_string($_GET['actNo'])."'");
			}else{
				$db0c = new DB;
				$db0c->query("INSERT INTO `socialform08a` (`actNo`, `Q20`) VALUES ('".mysql_escape_string($_GET['actNo'])."', '".$filename."');");		}
			} else {
				echo "<script>alert('上傳格式錯誤');</script>";
			}
		}
		echo "<script>window.location.href='index.php?mod=socialwork&func=formview&id=8'</script>";
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
	<form id="socialform08" action="index.php?mod=socialwork&func=formview&id=8_1b&actNo=<?php echo @$_GET['actNo']; ?>" method="post"  enctype="multipart/form-data">
		<table width="100%" style="text-align:left;">
			<tr>
				<td width="160" class="title">Activity category</td>
				<td><?php echo $cateName . ' - ' . $actName; ?></td>
				<td width="160" class="title">Date</td>
				<td><?php echo $date; ?>&nbsp;Time:<?php echo $Q12;?></td>
			</tr>
			<tr>
				<td class="title">Resident name</td>
				<td>
					<?php
					for ($i=0;$i<count($arrSelectedHospNo);$i++){
						echo '<div style="width:140px; display:inline-block;">'.getHospNoDisplayByHospNo($arrSelectedHospNo[$i]).' '.getPatientName(getPID($arrSelectedHospNo[$i])).'</div>';
					}
					?>
				</td>
				<td class="title">Photo</td>
				<td width="250">
					<?php
					$picFolder = 'socialform08_pic/'.$_SESSION['nOrgID_lwj'].'/';
					if ($Q20!="") {
						echo '<a href="'.$picFolder.'/'.$Q20.'" class="example-image-link" data-lightbox="example-set"><img src="'.$picFolder.'/'.$Q20.'" border="0" width="200"></a>';	  
					} else {
						echo '<img border="0" width="800" style="display:none;">';
					}
					?>
					<input type="file" value="Upload image" id="photo" name="photo">
				</td>
			</tr>
			<tr>
				<td class="title">Activity theme</td>
				<td colspan="3"><?php echo $Q1; ?></td>
			</tr>
			<tr>
				<td width="160" class="title">活動帶領</td>
				<td>
					<select name="Q13" id="Q13">
						<?php
						$EmpList = getWorkingStaff(1);
						foreach ($EmpList as $k=>$v) {
							echo '<option value="1_'.$k.'" '.('1_'.$k==$Q13?"selected":"").'>'.$v.'</option>';
						}
						?>
						<?php 
						$ForeignEmpList = getWorkingStaff(2);
						foreach ($ForeignEmpList as $k=>$v) {
							echo '<option value="2_'.$k.'" '.('2_'.$k==$Q13?"selected":"").'>'.$v.'</option>';		
						}
						?>
					</select>&nbsp;
					<input type="text" id="Q13a" name="Q13a" size="17" value="<?php echo $Q13a;?>"></td>
					<td width="160" class="title">活動協助</td>
					<td>
						<select name="Q14" id="Q14">
							<?php 
							$EmpList = getWorkingStaff(1);
							foreach ($EmpList as $k=>$v) {
								echo '<option value="1_'.$k.'" '.('1_'.$k==$Q14?"selected":"").'>'.$v.'</option>';
							}
							?>
							<?php 
							$ForeignEmpList = getWorkingStaff(2);
							foreach ($ForeignEmpList as $k=>$v) {
								echo '<option value="2_'.$k.'" '.('2_'.$k==$Q14?"selected":"").'>'.$v.'</option>';		
							}
							?>
						</select>&nbsp;
						<input type="text" id="Q14a" name="Q14a" size="17" value="<?php echo $Q14a;?>"></td>
					</tr>
					<tr>
						<td class="title">準備用物</td>
						<td colspan="3" align="left"><textarea id="Q15" name="Q15" cols="30" rows="5"><?php echo ($Q15==""?getTitle('socialform08a','Q9',mysql_escape_string($_GET['actNo']),'actNo',''):$Q15); ?></textarea></td>
					</tr> 
					<tr>
						<td class="title">音樂</td>
						<td colspan="3" align="left"><input type="text" id="Q16" name="Q16" size="105" value="<?php echo $Q16; ?>"></td>
					</tr>
					<tr>
						<td class="title">重要的活動過程</td>
						<td colspan="3" align="left"><textarea id="Q17" name="Q17" cols="30" rows="5"><?php echo ($Q17==""?getTitle('socialform08a','Q10',mysql_escape_string($_GET['actNo']),'actNo',''):$Q17); ?></textarea></td>
					</tr> 
					<tr>
						<td class="title">長輩的重要反應</td>
						<td colspan="3" align="left"><textarea id="Q18" name="Q18" cols="30" rows="5"><?php echo $Q18; ?></textarea></td>
					</tr> 
					<tr>
						<td class="title">Comment</td>
						<td colspan="3"><input type="text" id="Q19" name="Q19" size="105" value="<?php echo $Q19; ?>"></td>
					</tr>  
					<tr>
						<td class="title">Filled by</td>
						<td colspan="4"><?php echo ($r1c['Qfiller']==""?checkusername($_SESSION['ncareID_lwj']):checkusername($r1c['Qfiller'])); ?><input type="hidden" id="Qfiller" name="Qfiller" value="<?php echo ($r1c['Qfiller']==""?($_SESSION['ncareID_lwj']):($r1c['Qfiller'])); ?>"></td>
					</tr>
					<tr>
						<td colspan="4" class="title"><input type="button" onClick="window.location.href='index.php?mod=socialwork&func=formview&id=8';" value="Back to list" /><input type="submit" name="submit" value="Save" /></td>
					</tr>
				</table>
			</form>
		</div>
		<script>
		$("#socialform08").validationEngine();
		$(function() {
			$("#Q13").change(function(){
				$("#Q13a").val($("#Q13 :selected").text());
			})
			$("#Q14").change(function(){
				$("#Q14a").val($("#Q14 :selected").text());
			})
		});
		</script>