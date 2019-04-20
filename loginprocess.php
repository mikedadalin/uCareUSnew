<?php
if($_POST['VN']==$_POST['iVN']){
    $iprange = explode('.',$_SERVER['REMOTE_ADDR']);
    $iphead = $iprange[0].'.'.$iprange[1];
    if (isset($_POST['username'])) {
    	$userID= mysql_escape_string(htmlentities($_POST['username']));
    	$psw = mysql_escape_string(htmlentities($_POST['password']));
	    if(substr($userID,0,8)=="resident"){
	        $db = new DB;
	        $db->query("SELECT * FROM `userinfo_resident` WHERE `userID`='".$userID."'");
	        $r = $db->fetch_assoc();
	    }else{
	        $db = new DB;
	        $db->query("SELECT * FROM `userinfo` WHERE `userID`='".$userID."'");
	        $r = $db->fetch_assoc();
	    }
	    $db1= new DB;
	    $db1->query("SELECT `Name`, `ShortName`, `DBname`, `status`, `OrgType` FROM `orginfo` WHERE `OrgID`='".$r['OrgID']."'");
	    $r1 = $db1->fetch_assoc();
	    $db2= new DB;
	    $db2->query("SELECT * FROM `system_setting` WHERE `OrgID`='".$r['OrgID']."'");
	    $r2 = $db2->fetch_assoc();
	    if (md5($psw)==$r['psw']) {
    		if ($r2['allowNotInCompany']!=1 && !in_array($iphead,$allowedip) && $r['level']<5 && ($r['userID']!="Mor3Geneki6nge08" || substr($r['userID'],0,8)!="uarkdemo")) {
	    		echo "<script>window.location='index.php?error=6';</script>";
		    } elseif ($r['active']==0) {
			    echo "<script>window.location='index.php?error=5';</script>";
		    } elseif ($r['OrgID']!='admin' && $r1['status']==0) {
    			echo "<script>window.location='index.php?error=8';</script>";
	    	} else {
			
		    	if(substr($userID,0,8)=="resident"){
			    	$_SESSION['pid_lwj'] = $r['patientID'];
			    }
				if($r['EmpID']!=""){
					$arrEmpID = explode("_",$r['EmpID']);
					$_SESSION['EmpID_lwj'] = (int)$arrEmpID[0];
					$_SESSION['EmpGroup_lwj'] = $arrEmpID[1];
				}
			    $_SESSION['LanguangNumber_lwj'] = '1';
			    $_SESSION['ncareID_lwj'] = $r['userID'];
			    $_SESSION['nOrgID_lwj'] = $r['OrgID'];
			    $_SESSION['nOrgType_lwj'] = $r1['OrgType'];
			    $_SESSION['ncareName_lwj'] = $r['name'];
			    $_SESSION['ncarePos_lwj'] = $r['position'];
			    $_SESSION['ncareLevel_lwj'] = $r['level'];
			    $_SESSION['ncareGroup_lwj'] = $r['group'];
			    $_SESSION['ncareDBno_lwj'] = $r1['DBname'];
			    $_SESSION['nOrgName_lwj'] = $r1['Name'];
			    $_SESSION['nOrgSName_lwj'] = $r1['ShortName'];
			    $_SESSION['ncareOrgStatus_lwj'] = $r1['status']; //0:停用;1:正常;2:評鑑模式
			    $_SESSION['ncareContactPersonNo_lwj'] = $r2['ContactPersonNo']; //聯絡人數量 目前設定3
			    $_SESSION['ncareInsulinImage_lwj'] = $r2['InsulinImage']; //胰島素注射部位圖格式 目前設定2
			    $_SESSION['ncareglucoseRecord_lwj'] = $r2['glucoseRecord']; //血糖紀錄代入護理紀錄 目前設定1
			    $_SESSION['ncaremedFormat_lwj'] = $r2['medFormat']; //藥單格式 目前設定1
			    $_SESSION['ncareReceiptFormat_lwj'] = $r2['receiptFormat']; //收據格式 目前設定1
			    $_SESSION['ncarecSTKdate_lwj'] = $r2['cSTKdate']; //庫存關帳日
			    $_SESSION['userAction_lwj'] ="Login";
				
				
			    if (!in_array($iphead,$allowedip)) {
				    $_SESSION['ncareIncompany_lwj'] = "0"; //是否在機構內
    			} else {
	    			$_SESSION['ncareIncompany_lwj'] = "1";
		    	}
			
			    if ($r2['autoPatNo']=="1") { //每天自動居民計算人數 目前設定 1
				
				    $date = date(Ymd);
				
				    $db0 = new DB;
				    $db0->query("SELECT * FROM `".$r1['DBname']."`.`dailypatientno` WHERE `date`='".date("Y-m-d")."'");
				    if ($db0->num_rows()==0) {
    					autoPatNo($r1['DBname'], "dailypatientno", $date);
	    			}
		    		$db0 = new DB;
			    	$db0->query("SELECT * FROM `".$r1['DBname']."`.`dailypatientno1` WHERE `date`='".date("Y-m-d")."'");
				    if ($db0->num_rows()==0) {
					    autoPatNo($r1['DBname'], "dailypatientno1", $date);
				    }
				
			    }
			
			    if (substr($r['OrgID'],0,1)=="a") { //???????
    				$OrgType = "admin";
	    		} elseif (substr($r['OrgID'],0,1)=="S") { //???????
		    		$OrgType = "vendor";
			    } else {
				    $OrgType = $r1['OrgType'];
			    }
			
			    $db3 = new DB;
			    $db3->query("INSERT INTO `loginlog` VALUES ('', '".$r['userID']."', '".date("Y-m-d H:i:s")."', '".$_SERVER['REMOTE_ADDR']."');");

			    session_start();
			    if($_SESSION['QR_URL_lwj']!=""){
				    $_SESSION['QR_URL_lwj'] = str_replace("_TWNo1_","&",$_SESSION['QR_URL_lwj']);
				    echo '<script>document.location.href="'.$_SESSION['QR_URL_lwj'].'";</script>';
			    }else{
				    echo "<script>window.location='".$OrgType."/index.php?func=home';</script>";
			    }
		    }
	    } else {
		    echo "<script>window.location='index.php?error=1';</script>";
	    }
    }
}else{
	echo "<script>window.location='index.php?error=9';</script>";
}
?>