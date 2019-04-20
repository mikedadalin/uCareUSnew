<?php
include("DB.php");
if ($_POST['where']=="") {
	$where = "`".$_POST['colID']."`=".$_POST['autoID']."";
} else {
	$where = str_replace("\\","",$_POST['where']);
}
foreach ($_POST as $k => $v){
	$db = new DB;
	if($k != "formID" && $k != "colID" && $k != "autoID" && $k != "where"){
		$db->query("UPDATE `".$_POST['formID']."` SET `".$k."`='".$v."' WHERE ".$where);
		//echo "UPDATE `".$_POST['formID']."` SET `".$k."`='".$v."' WHERE ".$where."\n";		
	}
}
//echo $where;
//echo "OK";
?>