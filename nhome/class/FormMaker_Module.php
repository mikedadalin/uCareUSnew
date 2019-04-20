<?php
include("DB.php");
foreach($_POST as $k=>$v){
	$arr_k = explode("_",$k);
	if(count($arr_k)==2){
		if($v==1){
			${$arr_k[0]} .= $arr_k[1].';';
		}
	}
}
$Module = substr($Module,0,strlen($Module)-1);
$db = new DB;
$db->query("UPDATE `formmaker_list` SET `Module`='".$Module."' WHERE `formID`='".mysql_escape_string($_POST['formID'])."'");
echo "OK";
?>