<?php
if($_SESSION['ncareLevel_lwj']!=5){
	echo '<script>window.location.href="index.php?func=home"</script>';
}
if($_POST['action']=="new"){
	$db = new DB;
	$db->query("SELECT `formID` FROM `formmaker_list` ORDER BY `formID` DESC LIMIT 0,1");
	if ($db->num_rows()>0) {
		$r = $db->fetch_assoc();
		$db2 = new DB;
		$db2->query("INSERT INTO `formmaker_list` VALUES ('".($r['formID']+1)."','".mysql_escape_string($_POST['FormName'])."','".mysql_escape_string($_POST['row'])."','".mysql_escape_string($_POST['cell'])."','0','".mysql_escape_string($_POST['CategoryID'])."','1;2;3;4;5;6;7;8','1','2')");
		for($i=0;$i<$_POST['row'];$i++){
			for($j=0;$j<$_POST['cell'];$j++){
				foreach($_POST as $k=>$v){
					$arrName = explode("_",$k);
					if($arrName[0]=="Column" && $arrName[2]==$i && $arrName[3]==$j){
						if($arrName[1]=="LineFeed" && $v==''){ $v=0; }
						$db3 = new DB;
						$db3->query("SELECT `formID` FROM `formmaker_set` WHERE `formID`='".($r['formID']+1)."' AND `row`='".$i."' AND `cell`='".$j."'");
						if ($db3->num_rows()==0) {
							$db4 = new DB;
							$db4->query("INSERT INTO `formmaker_set` (`no`,`formID`,`row`,`cell`) VALUES ('','".($r['formID']+1)."','".$i."','".$j."')");
							$db5 = new DB;
							$db5->query("UPDATE `formmaker_set` SET `".$arrName[1]."`='".$v."' WHERE `formID`='".($r['formID']+1)."' AND `row`='".$i."' AND `cell`='".$j."'");
						}else{
							$db5 = new DB;
							$db5->query("UPDATE `formmaker_set` SET `".$arrName[1]."`='".$v."' WHERE `formID`='".($r['formID']+1)."' AND `row`='".$i."' AND `cell`='".$j."'");
						}
					}
				}
			}
		}
		$db6A = new DB;
		$db6A->query("SELECT `CategoryName` FROM `formmaker_category` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."'");
		$r6A = $db6A->fetch_assoc();
		$db6B = new DB;
		$db6B->query("SELECT `Show_Order` FROM `formmaker_order` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."' ORDER BY `Show_Order` DESC LIMIT 0,1");
		if($db6B->num_rows()>0){
			$r6B = $db6B->fetch_assoc();
			if($r6B['Show_Order']!=''){
				$order = $r6B['Show_Order']+1;
			}else{
				$order = 1;
			}
		}else{
			$order = 1;
		}
		$db6C = new DB;
		$db6C->query("INSERT INTO `formmaker_order` VALUES ('','".mysql_escape_string($_POST['CategoryID'])."','".$r6A['CategoryName']."','".($r['formID']+1)."','".mysql_escape_string($_POST['FormName'])."','".$order."')");
	}else{
		$db2 = new DB;
		$db2->query("INSERT INTO `formmaker_list` VALUES ('','".mysql_escape_string($_POST['FormName'])."','".mysql_escape_string($_POST['row'])."','".mysql_escape_string($_POST['cell'])."','0','".mysql_escape_string($_POST['CategoryID'])."','1;2;3;4;5;6;7;8','1','2')");
		$dbS = new DB;
		$dbS->query("SELECT `formID` FROM `formmaker_list` WHERE `FormName`='".mysql_escape_string($_POST['FormName'])."' AND `row`='".mysql_escape_string($_POST['row'])."' AND `cell`='".mysql_escape_string($_POST['cell'])."' ORDER BY `formID` DESC LIMIT 0,1");
		$rS = $dbS->fetch_assoc();
		for($i=0;$i<$_POST['row'];$i++){
			for($j=0;$j<$_POST['cell'];$j++){
				foreach($_POST as $k=>$v){
					$arrName = explode("_",$k);
					if($arrName[0]=="Column" && $arrName[2]==$i && $arrName[3]==$j){
						if($arrName[1]=="LineFeed" && $v==''){ $v=0; }
						$db3 = new DB;
						$db3->query("SELECT `formID` FROM `formmaker_set` WHERE `formID`='".$rS['formID']."' AND `row`='".$i."' AND `cell`='".$j."'");
						if ($db3->num_rows()==0) {
							$db4 = new DB;
							$db4->query("INSERT INTO `formmaker_set` (`no`,`formID`,`row`,`cell`) VALUES ('','".$rS['formID']."','".$i."','".$j."')");
							$db5 = new DB;
							$db5->query("UPDATE `formmaker_set` SET `".$arrName[1]."`='".$v."' WHERE `formID`='".$rS['formID']."' AND `row`='".$i."' AND `cell`='".$j."'");
						}else{
							$db5 = new DB;
							$db5->query("UPDATE `formmaker_set` SET `".$arrName[1]."`='".$v."' WHERE `formID`='".$rS['formID']."' AND `row`='".$i."' AND `cell`='".$j."'");
						}
					}
				}
			}
		}
		$db6A = new DB;
		$db6A->query("SELECT `CategoryName` FROM `formmaker_category` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."'");
		$r6A = $db6A->fetch_assoc();
		$db6B = new DB;
		$db6B->query("SELECT `Show_Order` FROM `formmaker_order` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."' ORDER BY `Show_Order` DESC LIMIT 0,1");
		if($db6B->num_rows()>0){
			$r6B = $db6B->fetch_assoc();
			if($r6B['Show_Order']!=''){
				$order = $r6B['Show_Order']+1;
			}else{
				$order = 1;
			}
		}else{
			$order = 1;
		}
		$db6C = new DB;
		$db6C->query("INSERT INTO `formmaker_order` VALUES ('','".mysql_escape_string($_POST['CategoryID'])."','".$r6A['CategoryName']."','".$rS['formID']."','".mysql_escape_string($_POST['FormName'])."','".$order."')");
	}
	?><script>alert('Add New Form!');</script><?
}elseif($_POST['action']=="edit"){
	$db = new DB;
	$db->query("SELECT `formID` FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
	if ($db->num_rows()>0) {
		$db2 = new DB;
		$db2->query("UPDATE `formmaker_list` SET `FormName`='".mysql_escape_string($_POST['FormName'])."',`row`='".mysql_escape_string($_POST['row'])."',`cell`='".mysql_escape_string($_POST['cell'])."',`CategoryID`='".mysql_escape_string($_POST['CategoryID'])."' WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
		$db2a = new DB;
		$db2a->query("DELETE FROM `formmaker_set` WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
		for($i=0;$i<$_POST['row'];$i++){
			for($j=0;$j<$_POST['cell'];$j++){
				foreach($_POST as $k=>$v){
					$arrName = explode("_",$k);
					if($arrName[0]=="Column" && $arrName[2]==$i && $arrName[3]==$j){
						if($arrName[1]=="LineFeed" && $v==''){ $v=0; }
						$db3 = new DB;
						$db3->query("SELECT `formID` FROM `formmaker_set` WHERE `formID`='".mysql_escape_string($_POST['formID'])."' AND `row`='".$i."' AND `cell`='".$j."'");
						if ($db3->num_rows()==0) {
							$db4 = new DB;
							$db4->query("INSERT INTO `formmaker_set` (`no`,`formID`,`row`,`cell`) VALUES ('','".mysql_escape_string($_POST['formID'])."','".$i."','".$j."')");
							$db5 = new DB;
							$db5->query("UPDATE `formmaker_set` SET `".$arrName[1]."`='".$v."' WHERE `formID`='".mysql_escape_string($_POST['formID'])."' AND `row`='".$i."' AND `cell`='".$j."'");
						}else{
							$db5 = new DB;
							$db5->query("UPDATE `formmaker_set` SET `".$arrName[1]."`='".$v."' WHERE `formID`='".mysql_escape_string($_POST['formID'])."' AND `row`='".$i."' AND `cell`='".$j."'");
						}
					}
				}
			}
		}
		$db6D = new DB;
		$db6D->query("SELECT `CategoryID` FROM `formmaker_order` WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
		$r6D = $db6D->fetch_assoc();
		if($r6D['CategoryID']!=$_POST['CategoryID']){
			$db6A = new DB;
			$db6A->query("SELECT `CategoryName` FROM `formmaker_category` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."'");
			$r6A = $db6A->fetch_assoc();
			$db6B = new DB;
			$db6B->query("SELECT `Show_Order` FROM `formmaker_order` WHERE `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."' ORDER BY `Show_Order` DESC LIMIT 0,1");
			if($db6B->num_rows()>0){
				$r6B = $db6B->fetch_assoc();
				if($r6B['Show_Order']!=''){
					$order = $r6B['Show_Order']+1;
				}else{
					$order = 1;
				}
			}else{
				$order = 1;
			}
			$db6C = new DB;
			$db6C->query("UPDATE `formmaker_order` SET `CategoryID`='".mysql_escape_string($_POST['CategoryID'])."',`CategoryName`='".$r6A['CategoryName']."',`Show_Order`='".$order."' WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");	
		}
		?><script>alert('Save!');</script><?
	}else{
		?><script>alert('Form ID isn\'t match');</script><?
	}
}elseif(@$_GET['action']=="delete"){
	$db = new DB;
	$db->query("DELETE FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_GET['id'])."'");
	$db2 = new DB;
	$db2->query("DELETE FROM `formmaker_set` WHERE `formID`='".mysql_escape_string($_GET['id'])."'");
	$db3 = new DB;
	$db3->query("DELETE FROM `formmaker_order` WHERE `formID`='".mysql_escape_string($_GET['id'])."'");
	?><script>alert('Delete!');</script><?
}else{}
if($_POST['action']=="new"){
	echo '<script>history.go(-3)</script>';
}else{
	echo '<script>history.go(-1)</script>';
}
?>