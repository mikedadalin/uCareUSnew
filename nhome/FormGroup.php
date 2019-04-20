<?php
if(isset($_GET['GID']) && $_GET['GID']!=''){
	$dbFGa = new DB;
	$dbFGa->query("SELECT * FROM `formgroup` WHERE `GroupID`='".mysql_escape_string($_GET['GID'])."'");
	$rFGa = $dbFGa->fetch_assoc();
	$_SESSION['GListName'] = $rFGa['ListName'];
	$dbFG = new DB;
	$dbFG->query("SELECT * FROM `formorder` WHERE `GroupID`='".mysql_escape_string($_GET['GID'])."' ORDER BY `order` ASC");
	for($iFG=0;$iFG<$dbFG->num_rows();$iFG++){
		$rFG = $dbFG->fetch_assoc();
		if($rFG['serNo']!=''){
			$dbFG3 = new DB2;
			$dbFG3->query("SELECT `name`,`icon`,`link` FROM `permission_item` WHERE `serNo`='".$rFG['serNo']."'");
			$rFG3 = $dbFG3->fetch_assoc();
			$link = $rFG3['link'];
			$name = $rFG3['name'];
			$icon = $rFG3['icon'];
			if(isset($_GET['pid'])){ $link = str_replace("{PID}",$_GET['pid'],$link); }
			if(isset($_GET['nID'])){ $link = str_replace("{NID}",$_GET['nID'],$link); }
			if(isset($_GET['scheduleID'])){ $link = str_replace("{SCHEDULEID}",$_GET['scheduleID'],$link); }
			$kGF = 'Glink_'.$rFG['order'];
			$kGF2 = 'Gname_'.$rFG['order'];
			$_SESSION[$kGF] = $link;
			$_SESSION[$kGF2] = $name.'_'.$icon.'_0';
			//echo $_SESSION[$kGF].'<br>';
		}
	}
	$kGF_time = 0;
	for($i=1;$i<11;$i++){
		$kGF = 'Glink_'.$i;
		if($_SESSION[$kGF]!=''){
			if($kGF_time==0){
				$_SESSION['GNO'] = $i;
				$kGF_time = 1;
				?><script>window.location.href="<? echo $_SESSION[$kGF];?>"</script><?
			}
		}
	}
}
?>