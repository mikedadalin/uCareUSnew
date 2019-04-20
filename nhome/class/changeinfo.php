<?php
include("DB.php");
if($_POST['Export']=="Y"){//轉出打卡資料
	$strQry = " WHERE (DATE_FORMAT(`startdate`,'%Y/%m/%d') >='".mysql_escape_string($_POST['date'])."' AND DATE_FORMAT(`startdate`,'%Y/%m/%d') <='".mysql_escape_string($_POST['date'])."')"; 
	//$strQry .= "  OR  (DATE_FORMAT(`enddate`,'%Y/%m/%d') >='".mysql_escape_string($_POST['date'])."' AND DATE_FORMAT(`enddate`,'%Y/%m/%d') <='".mysql_escape_string($_POST['date'])."') "; 
	$db3 = new DB;
	$db3->query("DELETE FROM `humanresource11_1` ".$strQry."");
	$db3a = new DB;
	$db3a->query("INSERT INTO `humanresource11_1` (`workID`,`EmpID`,`EmpGroup`,`startdate`,`enddate`) SELECT `workID`,`EmpID`,`EmpGroup`,`startdate`,`enddate` FROM `humanresource11` ".$strQry."");
	echo "OK";
}else{	
	foreach ($_POST as $k => $v){
		$db = new DB;
		if($k != "formID" && $k != "colID" && $k !="autoID" && $k !="osdate" && $k !="oedate"){
			$db->query("UPDATE `".$_POST['formID']."` SET `".$k."`='".$v."' WHERE `".$_POST['colID']."`=".$_POST['autoID']."");		
		}
	}
	if($_POST['formID']=="humanresource11"){//原始刷卡時間修改才記log	
	//autoid_os舊上班時間@ns新上班時間@oe舊下班時間@ne新下班時間@u異動日時間;
		$new_content = $_POST['autoID']."_os".str_replace("-","",$_POST['osdate']).'@ns'.str_replace("-","",$_POST['startdate']);
		$new_content .= '@oe'.str_replace("-","",$_POST['oedate']).'@ne'.str_replace("-","",$_POST['enddate']).'@u'.date("Ymd").";";
		
		$db1 = new DB;
		$db1->query("SELECT * FROM `humanresource11_log` WHERE `date`='".substr($_POST['startdate'],0,7)."'");
		if($db1->num_rows() >0){
			$r = $db1->fetch_assoc();
			$db2 = new DB;
			$db2->query("UPDATE `humanresource11_log` SET `content`='".$r['content'].$new_content."' WHERE `workID`='".$r['workID']."'");
		}else{
			$db2 = new DB;
			$db2->query("INSERT INTO `humanresource11_log` (`workID`,`date`,`content`) VALUES ('','".date("Y-m")."','".$new_content."');");
		}
	}
echo "OK";
}
?>