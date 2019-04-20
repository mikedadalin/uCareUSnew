<table border="0" style="text-align:left; padding-left:20px;" align="center">
  <tr>
    <td>
<?php
if (@$_GET['view']!='') {
	$viewpage = @$_GET['view'];
} else {
	$viewpage = 1;
}

$edit_userID = $_SESSION['ncareID_lwj'];

$old = new DB2;
$old->query("SELECT * FROM `userinfo` WHERE `userID`='".$edit_userID."'");
$oldinfo = $old->fetch_assoc();

$userID = $oldinfo["userID"];
$name = $oldinfo["name"];
$email = $oldinfo["email"];

$error_no = 0;

if (isset($_POST["edit_userinfo"]))
{
	$psw = md5($_POST["psw"]); //原有的密碼 old password
	$user_psw = md5($_POST["user_psw"]); //新密碼 new password
	$psw_confirm = md5($_POST["psw_confirm"]); //確認新密碼 confirm new password
	$VN = md5($_POST["VN"]); //原有VN
	$user_VN = md5($_POST["user_VN"]); //新VN
	$VN_confirm = md5($_POST["VN_confirm"]); //確認新VN
	$email = $_POST["email"];
	$position = $_POST["position"];
	$arrError = array();
	
	//檢查原有密碼 check old password
	if (empty($_POST["psw"])) {
		array_push($arrError,"Password not filled"); $error_no++;
	}elseif ($psw != $oldinfo["psw"]) {
		array_push($arrError,"Password error！"); $error_no++; 
	}elseif ($user_psw != $psw_confirm) {
		array_push($arrError,"Confirmation of new password not match"); $error_no++; 
	}else{}
	//檢查原有VN
	if (empty($_POST["VN"])) {
		array_push($arrError,"Verification Code not filled"); $error_no++;
	}elseif ($VN != $oldinfo["VN"]) {
		array_push($arrError,"Verification Code error！"); $error_no++;
	}elseif ($user_VN != $VN_confirm) {
		array_push($arrError,"Confirmation of new Verification Code not match"); $error_no++;
	}else{}
	
	if ($error_no == "0")
	{
	    //檢查是否要改密碼 check if changing password
	    if (strlen($_POST["user_psw"])!=0 && strlen($_POST["psw_confirm"])!=0)
	    {
	        $ch_psw = new DB2;
			$ch_psw->query("UPDATE `userinfo` SET `psw`='".$user_psw."' WHERE `userID`='".$edit_userID."'");
	    }
	    //檢查是否要改VN 
	    if (strlen($_POST["user_VN"])!=0 && strlen($_POST["VN_confirm"])!=0)
	    {
	        $ch_VN = new DB2;
			$ch_VN->query("UPDATE `userinfo` SET `VN`='".$user_VN."' WHERE `userID`='".$edit_userID."'");
	    }
		//更新其他資料 update other info
		$ch_info = new DB2;
		$ch_info->query("UPDATE `userinfo` SET  `position`='".$position."', `email`='".$email."' WHERE `userID`='".$edit_userID."'");
		echo "<script>alert('User".$name."(".$userID.")edited successfully！');</script>";
	}else{
		for($i=0;$i<count($arrError);$i++){
			$Error .= $arrError[$i].'\n';
		}
		?><script>alert('<?php echo $Error;?>');</script><?
	}
} elseif (isset($_POST["phrasesave"])) {
	$text = mysql_escape_string($_POST['phrasetext']);
	$order = mysql_escape_string($_POST['phraseorder']);
	$db_save = new DB;
	$db_save->query("INSERT INTO `phrase` VALUES ('', '".$_SESSION['ncareID_lwj']."', '".$order."', '".$text."', '0')");
	echo '<script>window.location.href="index.php?func=infoedit&view=3";</script>';
} elseif (isset($_POST["phrasedelete"])) {
	$order = mysql_escape_string($_POST['phraseorder']);
	$db_delete = new DB;
	$db_delete->query("DELETE FROM `phrase` WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `order`='".$order."'");
	$db_cdata = new DB;
	$db_cdata->query("SELECT * FROM `phrase` WHERE `userID`='".$_SESSION['ncareID_lwj']."' ORDER BY `order` ASC");
	for ($ci=1;$ci<=$db_cdata->num_rows();$ci++) {
		$cdata = $db_cdata->fetch_assoc();
		$db_reorder = new DB;
		$db_reorder->query("UPDATE `phrase` SET `order`='".$ci."' WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `order`='".$cdata['order']."'");
	}
} elseif (isset($_POST["phraseedit"])) {
	$text = mysql_escape_string($_POST['phrasetext']);
	$order = mysql_escape_string($_POST['phraseorder']);
	$db_save = new DB;
	$db_save->query("UPDATE `phrase` SET `text`='".$text."' WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `order`='".$order."'");
} elseif (isset($_POST["cantextsave"])) {
	$text = mysql_escape_string($_POST['cantexttext']);
	$order = mysql_escape_string($_POST['cantextorder']);
	$cateID = $_POST['service_cateID'];
	$db_save = new DB;
	$db_save->query("INSERT INTO `cantext` VALUES ('', '".$cateID."', '".$_SESSION['ncareID_lwj']."', '".$order."', '".$text."', '0')");
	echo '<script>window.location.href="index.php?func=infoedit&view=4";</script>';
} elseif (isset($_POST["cantextedit"])) {
	$text = mysql_escape_string($_POST['cantexttext']);
	$cateID = $_POST['service_cateID'];
	$cantextID = $_POST['cantextID'];
	$db_save = new DB;
	$db_save->query("UPDATE `cantext` SET `text`='".$text."', `service_cateID`='".$cateID."' WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `cantextID`='".$cantextID."' ");
} elseif (isset($_POST["cantextdelete"])) {
	$cateID = $_POST['service_cateID'];
	$cantextID = $_POST['cantextID'];
	$db_delete = new DB;
	$db_delete->query("DELETE FROM `cantext` WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `cantextID`='".$cantextID."' ");
	$db_cdata = new DB;
	$db_cdata->query("SELECT * FROM `cantext` WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `service_cateID`='".$cateID."' ORDER BY `order` ASC");
	for ($ci=1;$ci<=$db_cdata->num_rows();$ci++) {
		$cdata = $db_cdata->fetch_assoc();
		$db_reorder = new DB;
		$db_reorder->query("UPDATE `cantext` SET `order`='".$ci."' WHERE `userID`='".$_SESSION['ncareID_lwj']."' AND `service_cateID`='".$cdata['service_cateID']."' AND `cantextID`='".$cdata['cantextID']."'");
	}
}
?>
<script>
$(function() {
	var viewpage = '<?php echo $viewpage; ?>';
	for (i=1; i<=4; i++) {
		$('#tab'+i).hide();
	}
	$('#tab'+viewpage).show();
	$('#btn_account_'+viewpage).removeClass().addClass('tabbtn_xxl_middle_on');
	if (viewpage=='1') { $('#btn_account_'+viewpage).removeClass().addClass('tabbtn_xxl_left_on'); }
	else if (viewpage=='4') { $('#btn_account_'+viewpage).removeClass().addClass('tabbtn_xxl_right_on'); }
})

$(function() {
	$('#btn_account_1').click(function() { window.location.href = 'index.php?func=infoedit&view=1'; });
	$('#btn_account_2').click(function() { window.location.href = 'index.php?func=infoedit&view=2'; });
	$('#btn_account_3').click(function() { window.location.href = 'index.php?func=infoedit&view=3'; });
	$('#btn_account_4').click(function() { window.location.href = 'index.php?func=infoedit&view=4'; });
});
</script>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<table width="100%">
  <tr>
    <td align="center" style="color:#69b3b6;">
    <?php
	if ($viewpage==1) { echo '<h3>System&nbspAnnouncement</h3>'; }
	if ($viewpage==2) { echo '<h3>&nbspEdit personal info</h3>'; }
	elseif ($viewpage==3) { echo '<h3>&nbspPhrase manage</h3>'; }
	elseif ($viewpage==4) { echo '<h3>&nbspCanned phrase manage</h3>'; }
	?>
    </td>
  </tr>
  <tr>
  	<td align="center"> <?php echo draw_option("account","System announcement;Edit account info;Phrase manage;Canned phrase manage","xxl","single","",false,5); ?></td>
  </tr>
</table>
<div id="tab1" style="margin-top:10px;">
<?php if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){ ?>
<div>
<input type="button" onclick="javascript:location.href='index.php?func=SystemUpdateInfoEdit&action=new'" value="Add New" style="background:red; color:white; font-size:15.35px; display:inline-block; padding:10px; border-radius:10px; border:none; cursor:pointer;">
</div>
<?php } ?>
<table width="100%" border="0" class="content-query" cellpadding="12">
  <tr class="title">
    <?php if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){ ?>
	<td style="border-top-left-radius:10px;">Edit</td>
	<td>Delete</td>
    <?php } ?>
    <td width="100">Date</td>
    <td style="border-top-right-radius:10px;">System Announcement Content</td>
  </tr>
  <?php
  $db_notice = new DB2;
  $db_notice->query("SELECT `date`, `content`, `noticeID` FROM `notice` WHERE (`orgID` LIKE '%".$_SESSION['nOrgID_lwj']."%' OR `orgID` LIKE '%ALL%') ORDER BY `date` DESC LIMIT 0,20");
  for ($inotice=0;$inotice<$db_notice->num_rows();$inotice++) {
	  $r_notice = $db_notice->fetch_assoc();
	  echo '
	  <tr>';
	  if($_SESSION['ncareID_lwj']=="Mor3Geneki6nge08" || $_SESSION['ncareID_lwj']=="Lejla05Mirzada12Asmira01"){
		  echo '<td><center><a href="index.php?func=SystemUpdateInfoEdit&noticeID='.$r_notice['noticeID'].'&action=edit"><img src="Images/edit_icon.png" width="20" border="0"></a></center></td>';
		  echo '<td><center><a href="index.php?func=SystemUpdateInfoDeleteCheck&noticeID='.$r_notice['noticeID'].'"><img src="Images/delete3.png" width="20" border="0"></a></center></td>';
	  }
	  echo '
	    <td><center>'.substr($r_notice['date'],0,10).'</center></td>
	    <td>'.$r_notice['content'].'</td>
	  </tr>
	  '."\n";
  }
  ?>
</table>
</div>
<div id="tab2" style="display:none; margin-top:10px;">
<form action="index.php?func=infoedit&view=2" method="POST">
<table width="100%" border="0" class="content-query" cellpadding="7">
  <tr>
    <td width="130" height="40" class="title" style="text-align:center; padding:5px 5px; border-top-left-radius:10px;"><b>User code</b></td>
    <td colspan="3" style="padding-left:15px; border-top-right-radius:10px;"><?php echo $userID; ?><input type="hidden" name="olduserID" value="<?php echo $edit_userID; ?>" /></td>
  </tr>
  <tr>
    <td height="40" class="title" style="text-align:center; padding:5px 5px;"><b>Current Password</b></td>
    <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="psw" value="" size="25" />&nbsp;<font size="2" color="red">(required)</font></td>
    <td height="40" class="title" style="text-align:center; padding:5px 5px;"><b>Verification Code</b></td>
    <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="VN" maxlength="4" value="" size="25" />&nbsp;<font size="2" color="red">(required)</font></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>New Password</b></td>
    <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="user_psw" value="" size="25" />&nbsp;<font size="2" color="red"><br>(leave it blank if not changing password)</font></td>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>New Verification Code</b></td>
    <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="user_VN" maxlength="4" value="" size="25" />&nbsp;<font size="2" color="red"><br>(leave it blank if not changing Verification Code)</font></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Confirm New password</b></td>
    <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="psw_confirm" value="" size="25" />&nbsp;<font size="2" color="red"><br>(leave it blank if not changing password)</font></td>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Confirm New Verification Code</b></td>
    <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="VN_confirm" maxlength="4" value="" size="25" />&nbsp;<font size="2" color="red"><br>(leave it blank if not changing Verification Code)</font></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Full Name</b></td>
    <td colspan="3" style="padding-left:15px;"><?php echo $oldinfo['name']; ?></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Job Title</b></td>
    <td colspan="3" style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="text" name="position" value="<?php echo $oldinfo['position']; ?>" size="25" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>E-mail</b></td>
    <td colspan="3" style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="text" name="email" value="<?php echo $email; ?>" size="25" /></td>
  </tr>
  <tr>
    <td colspan="4" height="40" colspan="2" align="center" style="border-bottom-left-radius:10px; border-bottom-right-radius:10px;"><input type="submit" name="edit_userinfo" value="Complete" /></td>
  </tr>
</table>
</form>
</div>
<div id="tab3" style="display:none; margin-top:10px;">
<table width="100%" border="0" class="content-query" cellpadding="10">
  <tr class="title">
    <td width="120" style="border-top-left-radius:10px;">Sort</td>
    <td width="50">順序Sequence</td>
    <td>片語Phrase</td>
    <td width="50">Share</td>
    <td width="60" style="border-top-right-radius:10px;">Delete</td>
  </tr>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `phrase` WHERE `userID`='".$_SESSION['ncareID_lwj']."' ORDER BY `order` ASC");
for ($i=0;$i<$db1->num_rows();$i++) {
	$r1 = $db1->fetch_assoc();
	$img = ($r1['public']==1?"star_full":"star_empty");
	echo '
	<tr>
	  <td class="link1"><center>';
	  if ($i!=0) { echo '<a href="phrasesortdata.php?action=upper&phraseID='.$r1['phraseID'].'&order='.$r1['order'].'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i></span></a>'; }
	  if ($i!=($db1->num_rows()-1)) { echo '<a href="phrasesortdata.php?action=lower&tID='.$r1['phraseID'].'&order='.$r1['order'].'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrow-down fa-stack-1x fa-inverse"></i></span></a>'; }
	echo '
	</center></td>
	  <td><center>'.$r1['order'].'</center></td>
	  <td><form action="index.php?func=infoedit&view=3" method="post"><input type="hidden" name="phraseorder" id="phraseorder" value="'.$r1['order'].'" /><input type="text" name="phrasetext" id="phrasetext" size="72" value="'.$r1['text'].'" /><button type="submit" id="phraseedit" name="phraseedit"><i class="fa fa-save fa-2x"></i></button></form></td>
	  <td align="center"><img src="Images/'.$img.'.png" width="24" title="點選設定為公用" id="public_'.$r1['phraseID'].'"></td>
	  <td><center><form action="index.php?func=infoedit&view=3" method="post"><input type="hidden" name="phraseorder" id="phraseorder" value="'.$r1['order'].'" /><button type="submit" id="phrasedelete" name="phrasedelete"><i class="fa fa-trash fa-2x"></i></button></form></center></td>
	</tr>
	'."\n";
}
?>
  <tr>
    <td class="title" colspan="2" style="border-bottom-left-radius:10px;">Add New</td>
    <td colspan="3" style="border-bottom-right-radius:10px;">
    <form action="index.php?func=infoedit&view=3" method="post">
    <input type="text" name="phrasetext" id="phrasetext" size="96" /><input type="hidden" name="phraseorder" id="phraseorder" value="<?php echo $r1['order']+1; ?>" /><input type="submit" name="phrasesave" id="phrasesave" value="Add" />
    </form>
    </td>
  </tr>
</table>
</div>
<div id="tab4" style="display:none; margin-top:10px;">
<form>
	<div><input type="button" value="設定分類" onClick="window.location.href='index.php?mod=category&func=formview&id=1&code=cantext';"></div>
</form>
<table width="100%" border="0" class="content-query" cellpadding="10">
  <tr class="title">
    <td width="100" style="border-top-left-radius:10px;">Sort</td>
    <td width="50">順序</td>
    <td>片語</td>
    <td width="50">公用</td>
    <td width="50" style="border-top-right-radius:10px;">Delete</td>
  </tr>
<?php
$db1 = new DB;
$db1->query("SELECT * FROM `cantext` WHERE `userID`='".$_SESSION['ncareID_lwj']."' ORDER BY `service_cateID`, `order` ASC");
if($db1->num_rows() >0){
	for ($i=0;$i<$db1->num_rows();$i++) {
		$catecount ++;
		$r1 = $db1->fetch_assoc();
		$img = ($r1['public']==1?"star_full":"star_empty");
		$ord = 	$r1['order'];
		if ( $cate!=$r1['service_cateID']){$catecount=1;}
		echo '
		<tr>
		  <td class="link1"><center>';
		  if ( $cate==$r1['service_cateID']) { echo '<a href="cantextsortdata.php?action=upper&cantextID='.$r1['cantextID'].'&order='.$r1['order'].'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i></span></a>';}
		  if ($i!=($db1->num_rows()-1)) { echo '<a href="cantextsortdata.php?action=lower&cantextID='.$r1['cantextID'].'&order='.$r1['order'].'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-arrow-down fa-stack-1x fa-inverse"></i></span></a>'; }
		echo '
		</center></td>
		  <td><center>'.$r1['order'].'</center></td>
		  <td><form action="index.php?func=infoedit&view=4" method="post" id="collapse3">';
			$db_cate = new DB;
			$db_cate->query("SELECT * FROM `service_cate` WHERE `typeCode`='cantext' ORDER BY `ord` ");
			if($db_cate->num_rows()>0){
				echo '分類：<select name="service_cateID" id="service_cateID" class="validate[required]">';
				for($i1=0;$i1<$db_cate->num_rows();$i1++){
						$r_cate = $db_cate->fetch_assoc();
						echo '
						<option value="'.$r_cate['service_cateID'].'" '.($r_cate['service_cateID']==$r1['service_cateID']?"selected":"").'>'.$r_cate['title'].'</option>
						';
				}		
				echo '</select>';
			}
		  echo '<input type="hidden" name="cantextID" id="cantextID" value="'.$r1['cantextID'].'" />
		  <input type="text" name="cantexttext" id="cantexttext" size="65" value="'.$r1['text'].'" class="validate[required]" />
		  <button type="submit" id="cantextedit" name="cantextedit"><i class="fa fa-save fa-2x"></i></button>
		  </form></td>
		  <td align="center"><img src="Images/'.$img.'.png" width="24" title="點選設定為公用" id="public1_'.$r1['cantextID'].'"></td>
		  <td><center><form action="index.php?func=infoedit&view=4" method="post">
		  <input type="hidden" name="cantextID" id="cantextID" value="'.$r1['cantextID'].'" />
		  <input type="hidden" name="service_cateID" id="service_cateID" value="'.$r1['service_cateID'].'" />
		  <button type="submit" id="cantextdelete" name="cantextdelete"><i class="fa fa-trash fa-2x"></i></button></form></center></td>
		</tr>
		'."\n";
		$cate = $r1['service_cateID'];		
	}
}
?>
  <tr>
    <td class="title" style="border-bottom-left-radius:10px;">Add</td>
    <td colspan="4" style="border-bottom-right-radius:10px;">
    <form action="index.php?func=infoedit&view=4" method="post" id="collapse2">
    分類：<?php 
	$db_cate = new DB;
	$db_cate->query("SELECT * FROM `service_cate` WHERE `typeCode`='cantext' ORDER BY `ord` ");
	echo '<select name="service_cateID" id="service_cate" class="validate[required]">
	<option value="">==請選擇==</option>';
	if($db_cate->num_rows()>0){
		for($i1=0;$i1<$db_cate->num_rows();$i1++){
				$r_cate = $db_cate->fetch_assoc();
				echo '
				<option value="'.$r_cate['service_cateID'].'">'.$r_cate['title'].'</option>
				';
		}		
	}
	echo '</select>';
	?><br>
    <input type="text" name="cantexttext" id="cantexttext" size="96" class="validate[required]" />
    <input type="hidden" name="cantextorder" id="cantextorder" value="<?php echo $ord+1; ?>" />
    <input type="submit" name="cantextsave" id="cantextsave" value="Add" />
    </form>
    </td>
  </tr>
</table>
</div>
    </td>
  </tr>
</table>


</div>

<script>
$(function() {
	$("#collapse2").validationEngine();
	$("#collapse3").validationEngine();
	$("img[id^='public_']").click(function(){
		var id = $(this).attr("id").split('_');
		var idname = $(this).attr("id");
		$.ajax({
			url: "class/setEnableStar.php",
			type: "POST",
			data: {"table": 'phrase', "autoID":'phraseID', "colID":'public', "ID": id[1], "type": 4 },
			success: function(data) {
				$('#'+idname).attr("src", "Images/"+data+".png");
			}
		});
  });
	$("img[id^='public1_']").click(function(){
		var id = $(this).attr("id").split('_');
		var idname = $(this).attr("id");
		$.ajax({
			url: "class/setEnableStar.php",
			type: "POST",
			data: {"table": 'cantext', "autoID":'cantextID', "colID":'public', "ID": id[1], "type": 4 },
			success: function(data) {
				$('#'+idname).attr("src", "Images/"+data+".png");
			}
		});
  });
  $("#service_cate").change(function(){
	$.ajax({
		url: "class/getCol.php",
		type: "POST",
		data: {"table": 'cantext', "idName":'service_cateID', "id":$("#service_cate").val(), "title":"order"},
		success: function(data) {
			var ord = parseInt(data)+1;
			$("#cantextorder").val(ord);
		}
	});
  });
});
</script>