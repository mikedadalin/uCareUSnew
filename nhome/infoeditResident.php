<?php
$edit_userID = $_SESSION['ncareID_lwj'];

$old = new DB2;
$old->query("SELECT * FROM `userinfo_resident` WHERE `userID`='".$edit_userID."'");
$oldinfo = $old->fetch_assoc();

$userID = $oldinfo["userID"];
$email = $oldinfo["email"];

$error_no = 0;

if (isset($_POST["edit_userinfo"]))
{
	$psw = md5($_POST["psw"]); //原有的密碼 old password
	$user_psw = md5($_POST["user_psw"]); //新密碼 new password
	$psw_confirm = md5($_POST["psw_confirm"]); //確認新密碼 confirm new password
	$email = $_POST["email"];
	$position = $_POST["position"];
	
	//檢查原有密碼 check old password
	if (empty($_POST["psw"])) { $error = "Password not filled\n"; $error_no++; }
	if ($psw != $oldinfo["psw"]) { $error = "Password error！\n"; $error_no++; }
	if ($user_psw != $psw_confirm) { $error = "Confirmation of new password not match\n"; $error_no++; }
	
	if ($error_no == "0")
	{
	    //檢查是否要改密碼 check if changing password
	    if (strlen($_POST["user_psw"])!=0 && strlen($_POST["psw_confirm"])!=0)
	    {
	        $ch_psw = new DB2;
			$ch_psw->query("UPDATE `userinfo_resident` SET `psw`='".$user_psw."' WHERE `userID`='".$edit_userID."'");
	    }
		//更新其他資料 update other info
		$ch_info = new DB2;
		$ch_info->query("UPDATE `userinfo_resident` SET  `position`='".$position."', `email`='".$email."' WHERE `userID`='".$edit_userID."'");
		echo "<script>alert('User".$_SESSION['ncareName_lwj']."(".$userID.")edited successfully！');</script>";
	}
}
?><center>
<div style="background-color:rgba(255,255,255,0.8); border-radius:24px; padding:40px; padding-top:10px; width:80%">
  <div style="padding-bottom:10px; padding-left:16px;"><a style="font-size:33px; font-weight:bolder; color:#e87217;">Edit personal info</a></div>
  <form action="" method="POST">
    <table width="100%" border="0" class="content-query">
      <tr>
        <td width="130" height="40" class="title" style="text-align:center; padding:5px 5px; border-top-left-radius:20px;"><b>User code</b></td>
        <td style="padding-left:15px; border-top-right-radius:25px;"><?php echo $userID; ?><input type="hidden" name="olduserID" value="<?php echo $edit_userID; ?>" /></td>
      </tr>
      <tr>
        <td height="40" class="title" style="text-align:center; padding:5px 5px;"><b>Current Password</b></td>
        <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="psw" maxlength="20" value="" size="25" />&nbsp;<font size="2" color="red">(required)</font></td>
      </tr>
      <tr>
        <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>New password</b></td>
        <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="user_psw" maxlength="20" value="" size="25" />&nbsp;<font size="2" color="red">(leave it blank if not changing password)</font></td>
      </tr>
      <tr>
        <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Confirm new password</b></td>
        <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="password" name="psw_confirm" maxlength="20" value="" size="25" />&nbsp;<font size="2" color="red">(leave it blank if not changing password)</font></td>
      </tr>
      <tr>
        <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Full name</b></td>
        <td style="padding-left:15px;"><?php echo $_SESSION['ncareName_lwj']; ?></td>
      </tr>
      <tr>
        <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>Title</b></td>
        <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="text" name="position" value="<?php echo $oldinfo['position']; ?>" size="25" /></td>
      </tr>
      <tr>
        <td height="30" class="title" style="text-align:center; padding:5px 5px;"><b>E-mail</b></td>
        <td style="padding-left:10px;"><input style="background-color:rgba(0,0,0,0.1);" type="text" name="email" value="<?php echo $email; ?>" size="25" /></td>
      </tr>
      <tr>
        <td height="40" colspan="2" align="center" style="border-bottom-left-radius:25px; border-bottom-right-radius:25px;"><input style="margin: 10px auto;" type="submit" name="edit_userinfo" value="Edit" /></td>
      </tr>
    </table>
  </form>
</div></center>