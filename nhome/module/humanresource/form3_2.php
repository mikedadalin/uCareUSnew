<?php

$error_no = 0;

if (isset($_POST["edit_userinfo"]))
{
	$email = $_POST["email"];
	$position = $_POST["position"];
	$group = $_POST["group"];
	$level = $_POST["level"];
	$active = $_POST["active"];
	
	$user_psw = md5($_POST["user_psw"]); //新密碼
	$psw_confirm = md5($_POST["psw_confirm"]); //確認新密碼
	$preVN = md5('0000');
	
	//檢查原有密碼
	if ($user_psw != $psw_confirm) { $error = "密碼二次輸入不符，請重新輸入！\n"; $error_no++; }
	
	if ($error_no == "0")
	{
		//更新其他資料
		$ch_info = new DB2;
		$ch_info->query("INSERT INTO `userinfo` VALUES ('".mysql_escape_string($_POST['userID'])."', '".$_SESSION['nOrgID_lwj']."', '".mysql_escape_string($_POST['name'])."', '".mysql_escape_string($_POST['position'])."', '".mysql_escape_string($_POST['email'])."', '".$user_psw."', '".$group."', '".$level."', '".$active."', '', '".$preVN."', '');");
		echo "<script>alert('User account".$name."(".$userID.") add successfully！');window.location.href='index.php?mod=humanresource&func=formview&id=3_1&uID=".$_POST['userID']."'</script>";
		
		//新增權限
		$strDB = 'a.`OrgID`=b.`OrgID`';
		$db1b = new DB2;
		$db1b->query("SELECT b.`PermissionSet` FROM `userinfo` a INNER JOIN `permissionset` b ON a.`group`=b.`Group` AND ".$strDB." WHERE a.`userID`='".mysql_escape_string($_POST['userID'])."'");
		$r1b = $db1b->fetch_assoc();
		$arrPerSet = explode(';',$r1b['PermissionSet']);
		foreach ($arrPerSet as $k=>$v) {
			$db1c = new DB2;
			$db1c->query("SELECT a.Name as `perName`, b.`name` as `subcateName`, c.`serNo`, c.icon, c.name as `itemname` FROM `permission2` a INNER JOIN `permission_subcate` b ON b.`cateID`=a.`PermissionID` INNER JOIN `permission_item` c ON c.`subcateID`=b.`subcateID` WHERE a.`PermissionID`='".$v."' ORDER BY a.`order`, b.`subcateID`, c.`subcateID`");
			for ($i1c=0;$i1c<$db1c->num_rows();$i1c++) {
				$r1c = $db1c->fetch_assoc();
				//$arrPerList[$r1c['serNo']] = 1;
				$db1d = new DB2;
				$db1d->query("INSERT INTO `user_permission` VALUES ('".mysql_escape_string($_POST['userID'])."', '".$r1c['serNo']."', '1');");
			}
		}
	}
}
?>
<div class="moduleNoTab">
<form method="POST" id="base">
<div class="content-table" style="margin-top:10px;">
<table border="0" style="text-align:left;">
  <tr>
    <td width="100" height="30" class="title" style="text-align:center;"><b>User ID :</b></td>
    <td><input type="text" name="userID" id="userID" value="<?php echo $_POST['userID']; ?>" onblur="checkUserID(this.value);" class="validate[required]" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Name:</b></td>
    <td><input type="text" name="name" value="<?php echo $_POST['name']; ?>" class="validate[required]" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Job title:</b></td>
    <td><input type="text" name="position" value="<?php echo $_POST['position']; ?>" size="25" class="validate[required]" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>E-mail：</b></td>
    <td><input type="text" name="email" id="email" value="<?php echo $_POST['email']; ?>" size="25" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Password:</b></td>
    <td><input type="password" name="user_psw" maxlength="20" value="" size="25" class="validate[required]" /><span class="rangeL"><?php echo $error; ?></span></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Confirm password:</b></td>
    <td><input type="password" name="psw_confirm" maxlength="20" value="" size="25" class="validate[required]" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Group:</b></td>
    <td>
    <select name="group" class="validate[required]">
      <?php
      $arrGroup = array("", "Administration", "Nursing", "Domestic CNA", "Pharmacy", "Social worker", "physiotherapist", "Nutritionist", "Public work", "General manage", "Foreign CNA");
	  foreach ($arrGroup as $k1=>$v1) {
		  echo '<option value="'.$k1.'"'.($k1==$_POST['group']?"selected":"").'>'.$v1.'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>User permission :</b></td>
    <td>
    <select name="level">
      <option value="1" <?php echo $_POST['level']==1?"selected":""; ?>>General staff</option>
      <option value="4" <?php echo $oldinfo['level']==4?"selected":""; ?>>General staff (Deletion permission)</option>
      <option value="5" <?php echo $_POST['level']==5?"selected":""; ?>>Manager</option>
    </select>
    </td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Status:</b></td>
    <td>
    <select name="active">
      <option value="1" <?php echo $_POST['active']=="1"?"selected":""; ?>>Normal</option>
      <option value="0" <?php echo $_POST['active']=="0"?"selected":""; ?>>Disabled</option>
    </select>
    </td>
  </tr>
 <!-- <tr>
    <td height="30" colspan="2" align="center" style="background:#ffffff;"><input type="submit" name="edit_userinfo" value="Complete" /></td>
  </tr>
-->
</table>
</div>
<div align="center" style="margin-top:30px;">
	<input type="submit" name="edit_userinfo" value="Complete" />
</div>
</form>
</div>
<script>
function checkUserID(userID) {
	$.ajax({
		url: "class/checkUserID.php",
		type: "post",
		data: {"userID": userID},
		success: function(data) {
			if (data=="EXISTED") {
				alert('此使用者名稱已被使用！');
				$("#userID").val("");
				$("#userID").focus();
			}
		}
	});
}
$(function() {
	$('#base').validationEngine();
});
</script>