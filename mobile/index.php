<?php
session_start();
if ($_SESSION['ncareID_lwj']=="") {
	include("../class/DB.php");
} else {
	include("../".$_SESSION['nOrgID_lwj']."/class/DB.php");
}
include("../class/DB2.php");
include("../class/function.php");
include("../class/array.php");
include("../class/error.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>諾亞克護理資訊系統U-ARK NIS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.js"></script>
</head>

<body>
<div data-role="page">

    <div data-role="header">
		<h1>諾亞克護理資訊系統<br>u-ARK NIS</h1>
		<a href="index.php" data-icon="home" data-iconpos="notext" data-transition="fade">首頁Main Page</a>
	</div>

	<div data-role="content">	
	<?php
	if (isset($_POST['logout'])) {
		$_SESSION['ncareID_lwj']=NULL;
	}
    if ($_SESSION['ncareID_lwj']=="") {
	?>
    <div data-role="fieldcontain">
        <form action="index.php" method="post" data-ajax="false">
        <label for="name">使用者名稱 User ID</label>
        <input type="text" name="username" id="username" value=""  />
        <br><br>
        <label for="psw">密碼 Password</label>
        <input type="password" name="password" id="password" value=""  />
        <br><br>
        <input type="submit" name="login" id="login" value="登入" />
        </form>
    </div>
	<?php
    } elseif ($_SESSION['ncareID_lwj']!=="") {
    ?>
    <div data-role="fieldcontain">
    <span style="width:50%; display:inline-block;"><a href="javascript:history.go(-1);" data-role="button" data-icon="back">返回</a></span><span style="width:50%; display:inline-block;"><form action="index.php" method="post" data-ajax="false"><input type="submit" name="logout" id="logout" value="登出" data-role="button" data-icon="power" /></form></span>
    <?php
	if (@$_GET['func']=="" || @$_GET['func']=="home") {
	?>
        <a href="index.php?func=patientlist" data-role="button" data-icon="bullets">住民資料 resident info</a>
        <a href="index.php?func=" data-role="button" data-icon="action">Apply Item</a>
        <a href="index.php?func=" data-role="button" data-icon="comment">Nursing Record</a>
        <a href="index.php?func=" data-role="button" data-icon="heart">Vital sign</a>
        <a href="index.php?func=" data-role="button" data-icon="recycle">I/O狀況 Intake/Output situation</a>
    <?php
	} else {
		include(@$_GET['func'].'.php');
	}
	?>
    
    </div>
    <?php
    }
	if ($_SESSION['ncareID_lwj']=='' && isset($_POST['login'])) {
		$iprange = explode('.',$_SERVER['REMOTE_ADDR']);
		$iphead = $iprange[0].'.'.$iprange[1];
		if (isset($_POST['username'])) {
			$userID= $_POST['username'];
			$psw = $_POST['password'];
			$db = new DB;
			$db->query("SELECT * FROM `userinfo` WHERE `userID`='".mysql_escape_string($userID)."'");
			$r = $db->fetch_assoc();
			if (md5($psw)==$r['psw']) {
				if (!in_array($iphead,$allowedip) && $r['level']<5) {
					echo "<script>window.location='index.php?error=6';</script>";
				} elseif ($r['active']==0) {
					echo "<script>window.location='index.php?error=5';</script>";
				} else  {
					$db1= new DB;
					$db1->query("SELECT `Name` FROM `orginfo` WHERE `OrgID`='".$r['OrgID']."'");
					$r1 = $db1->fetch_assoc();
					$_SESSION['ncareID_lwj'] = $r['userID'];
					$_SESSION['nOrgID_lwj'] = $r['OrgID'];
					$_SESSION['nOrgName_lwj'] = $r1['Name'];
					$_SESSION['ncareName_lwj'] = $r['name'];
					$_SESSION['ncarePos_lwj'] = $r['position'];
					$_SESSION['ncareLevel_lwj'] = $r['level'];
					$_SESSION['ncareGroup_lwj'] = $r['group'];
					if (!in_array($iphead,$allowedip)) {
						$_SESSION['ncareIncompany_lwj'] = "0";
					} else {
						$_SESSION['ncareIncompany_lwj'] = "1";
					}
					echo "<script>window.location='index.php?func=home';</script>";
				}
			} else {
				echo "WRONG PASSWORD";
			}
		}    
	}
    ?>
	</div>
    
    <div data-role="footer">
	<center><font size="1" color="#999999">Copyright &copy; 2014.<br>
    All Rights Reserved.<br>
    諾亞克科技股份有限公司U-ARK Taiwan<br>
    106台北市大安區基隆路二段190號7樓 Address<br>
    (02)2378-0968 Tel</font></center>
	</div>
</div>
</body>
</html>
