<?php

$edit_userID = $_GET['uID'];

$old = new DB2;
$old->query("SELECT * FROM `userinfo` WHERE `userID`='".$edit_userID."'");
$oldinfo = $old->fetch_assoc();

$userID = $oldinfo["userID"];
$name = $oldinfo["name"];
$email = $oldinfo["email"];

$error_no = 0;

if (isset($_POST["edit_userinfo"])) {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$position = $_POST["position"];
	$group = $_POST["group"];
	$level = $_POST["level"];
	$active = $_POST["active"];
	
	//更新其他資料
	$ch_info = new DB2;
	$ch_info->query("UPDATE `userinfo` SET `name`='".$name."', `position`='".$position."', `email`='".$email."', `group`='".$group."', `level`='".$level."', `active`='".$active."' WHERE `userID`='".$edit_userID."' AND `OrgID`='".$_SESSION['nOrgID_lwj']."'");
	
	//更新機構組別權限 orggroup
	$arrOrgList = $_POST['orguser_checklist'];
	$orgDB = new DB2;
	$orgDB->query("DELETE FROM `orguser` WHERE `userID`='".$userID."'");
	if (count($arrOrgList)>0) {
		foreach ($arrOrgList as $k=>$v) {
			$orgUDB = new DB2;
			$orgUDB->query("INSERT INTO `orguser` VALUES ('', '".$userID."', '".$v."');");
		}
	}
	
	$dbC = new DB2;
	$dbC->query("INSERT INTO `account_change` VALUES ('', '".$edit_userID."', 'active=".$active."', '".date("Y-m-d H:i:s").".0000000', '".$_SESSION['ncareID_lwj']."');");
	
	echo "<script>alert('User".$name."(".$userID.") edited successfully!');window.location.href='index.php?mod=humanresource&func=formview&id=3_1&uID=".$edit_userID."'</script>";
}
?>
<div class="moduleNoTab">
<form method="POST">
<div class="content-table" style="margin-top:10px;">
<table border="0" style="text-align:left;">
  <tr>
    <td width="150" height="30" class="title" style="text-align:center;"><b>User ID :</b></td>
    <td><?php echo $userID; ?><input type="hidden" name="olduserID" value="<?php echo $edit_userID; ?>" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Name:</b></td>
    <td><input type="text" name="name" value="<?php echo $oldinfo['name']; ?>" size="25" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Job title:</b></td>
    <td><input type="text" name="position" value="<?php echo $oldinfo['position']; ?>" size="25" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>E-mail：</b></td>
    <td><input type="text" name="email" id="email" value="<?php echo $oldinfo['email']; ?>" size="25" /></td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Group:</b></td>
    <td>
    <select name="group">
      <?php
      $arrGroup = array("", "Administration", "Nursing", "Domestic CNA", "Pharmacy", "Social worker", "Physiotherapist", "Nutritionist", "Public work", "General manage", "Foreign CNA");
	  foreach ($arrGroup as $k1=>$v1) {
		  echo '<option value="'.$k1.'"'.($k1==$oldinfo['group']?"selected":"").'>'.$v1.'</option>'."\n";
	  }
	  ?>
    </select>
    </td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>User permission :</b></td>
    <td>
    <select name="level">
      <option value="1" <?php echo $oldinfo['level']==1?"selected":""; ?>>General staff</option>
      <option value="4" <?php echo $oldinfo['level']==4?"selected":""; ?>>General staff (Deletion permission)</option>
      <option value="5" <?php echo $oldinfo['level']==5?"selected":""; ?>>Manager</option>
    </select>
    </td>
  </tr>
  <tr>
    <td height="30" class="title" style="text-align:center;"><b>Status:</b></td>
    <td>
    <select name="active">
      <option value="0" <?php echo $oldinfo['active']==0?"selected":""; ?>>Disabled</option>
      <option value="1" <?php echo $oldinfo['active']==1?"selected":""; ?>>Normal</option>
    </select>
    </td>
  </tr>
  <?php
  $db1 = new DB2;
  $db1->query("SELECT * FROM `orggroup` WHERE `OrgID`='".$_SESSION['nOrgID_lwj']."'");
  if ($db1->num_rows()>0) {
	  $r1 = $db1->fetch_assoc();
  ?>
  <tr>
    <td class="title" style="text-align:center;"><b>Organization：</b></td>
    <td>
    <?php
	$db2 = new DB2;
	$db2->query("SELECT * FROM `orggroup` a INNER JOIN `orginfo` b ON a.`OrgID` = b.`OrgID` WHERE a.`GroupID`='".$r1['GroupID']."'");
	for ($i2=0;$i2<$db2->num_rows();$i2++) {
		if ($i2 > 0 && $i2%6==0) { echo '<br>'; }
		$r2 = $db2->fetch_assoc();
		$db2a = new DB2;
		$db2a->query("SELECT * FROM `orguser` WHERE `userID`='".$userID."' AND `orgID`='".$r2['OrgID']."'");
		echo '<input type="checkbox" value="'.$r2['OrgID'].'" name="orguser_checklist[]" '.($db2a->num_rows()>0?"checked":"").'> '.$r2['ShortName'].'&nbsp;';
	}
	?>
    </td>
  </tr>
  <?php
  }
  ?>
  <!--<tr>
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
<!--<script>
$(document).ready(function() {
	if ($('#email').val()=="") {
		$("#pswmsg").attr('class','rangeH').html('要重設密碼請先填寫email');
		$("#resetpsw").fadeOut();
	} else {
		$("#pswmsg").attr('class','rangeL').html('重設後的新密碼會寄到使用者之email');
		$("#resetpsw").fadeIn();
	}
})
</script>-->