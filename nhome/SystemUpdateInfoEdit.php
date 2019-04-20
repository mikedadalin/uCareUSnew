<?php
if($_GET['noticeID']!="" && $_GET['action']=="edit"){
  $db_notice = new DB2;
  $db_notice->query("SELECT * FROM `notice` WHERE (`orgID` LIKE '%".$_SESSION['nOrgID_lwj']."%' OR `orgID` LIKE '%ALL%') AND `noticeID`='".mysql_escape_string($_GET['noticeID'])."'");
  $r_notice = $db_notice->fetch_assoc();
  $arrOrgID = explode(";",$r_notice['orgID']);
}
if(isset($_POST['submit'])){
	$Selcet_orgID ="";
	foreach ($_POST as $k=>$v) {
		$arrAnswer = explode("_",$k);
		if(count($arrAnswer)==2){
			$Selcet_orgID .= $v.";";
		}
	}
	if ($_POST['action'] == "new") {
		//新增資料
		$db2 = new DB2;
		$db2->query("INSERT INTO `".$_POST['formID']."` (`noticeID`, `orgID`, `date`, `content`) VALUES ('', '".$Selcet_orgID."', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['content'])."')");
		?><script>document.location.href="index.php?func=infoedit";</script><?php
	}elseif($_POST['action'] == "edit"){
		//回應
		$db2 = new DB2;
		$db2->query("UPDATE `".$_POST['formID']."` SET `orgID`='".$Selcet_orgID."', `date`='".mysql_escape_string($_POST['date'])."', `content`='".mysql_escape_string($_POST['content'])."' WHERE `noticeID`='".mysql_escape_string($_POST['noticeID'])."'");
		?><script>document.location.href="index.php?func=infoedit";</script><?php
	}
}
?>
<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 20px 10px; margin-bottom: 40px;">
<h3>System Announcement Edit</h3>
<form method="post" action="">
<table width="100%" cellpadding="7" border="0" class="content-query" style="text-align:left;">
  <tr>
    <td class="title" style="border-top-left-radius:10px;">Organization/Facility code</td>
	<td style="border-top-right-radius:10px;">
	<?php
	  $db3 = new DB2;
	  $db3->query("SELECT `OrgID`,`Name` FROM `orginfo` WHERE `OrgType`='nhome' ORDER BY `OrgID`");
	  for ($i=1;$i<=$db3->num_rows();$i++){
		$r3 = $db3->fetch_assoc();
		echo '<div style="width:180px; display:inline-block;"><input type="checkbox" name="orgID_'.$i.'" value="'.$r3["OrgID"].'" ';
		if($_GET['noticeID']!="" && $_GET['action']=="edit"){
			if(in_array($r3["OrgID"],$arrOrgID)){ echo "checked";}
		}
		echo '>'.$r3["Name"].'</div>';
		if($i%5==0){
			echo "<br>";
		}
	  }
	  echo '<input type="checkbox" name="orgID_'.$i.'" value="ALL" ';
	  if($_GET['noticeID']!="" && $_GET['action']=="edit"){
		  if(in_array("ALL",$arrOrgID)){ echo "checked";}
	  }
	  echo'>ALL';
	?>
	</td>
  </tr>
  <tr>
    <td class="title">Date</td>
	<td><script> $(function() { $( "#date").datetimepicker({format:'Y-m-d H:i:s', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php echo $r_notice['date']; ?>" size="16" ></td>
  </tr>
  <tr>
	<td class="title" style="border-bottom-left-radius:10px">Content</td>
	<td style="border-bottom-right-radius:10px;"><textarea rows="10" id="content" name="content" style="width:100%"><?php echo $r_notice['content']; ?></textarea>(use < br > to wraps to newline)</td>
  </tr>
</table>
<div style="margin-top:20px;">
<input type="hidden" name="noticeID" id="noticeID" value="<?php echo $_GET['noticeID'];?>" />
<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
<input type="hidden" name="formID" id="formID" value="notice" />
<input type="submit" name="submit" id="submit" style="width:100px; height:34px; font-size:16px;" value="Submit" />
</div>
</form>
</div>