<?php 
include("class/DB.php");

ignore_user_abort();//關掉瀏覽器，PHP腳本也可以繼續執行. close browser, php script can still execute
set_time_limit(3000);// 通過set_time_limit(0)可以讓程序無限制的執行下去 throght set_time_limit(0) will enable program execute without time(?) limit
$interval=5;// 每隔5s運行 run every 5 seconds

for($i=0;$i<120;$i++){ 
	$db = new DB;
	$db->query("INSERT INTO `testinterval` VALUES ('".$i*$interval."')");
	sleep($interval);// 等待5s  wait 5 seconds
} 
ob_flush(); 
flush(); 
?>