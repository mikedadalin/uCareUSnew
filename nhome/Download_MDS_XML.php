<?php
    session_start();
	$file=$_GET['file'];//檔案名稱
	$url="MDS/".$_SESSION['nOrgID_lwj'].'/'; //路徑位置
	header("Content-type:application");
	header("Content-Disposition: attachment; filename=".$file);	
	readfile($url.str_replace("@","",$file));	
	exit(0);
?>