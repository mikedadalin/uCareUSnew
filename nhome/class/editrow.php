<?php
include("DB.php");
foreach ($_POST as $k => $v){
	$db = new DB;
	if($k != "formID" && $k != "nID"){
		$db->query("UPDATE `".$_POST['formID']."` SET `".$k."`='".$v."' WHERE `nID`=".$_POST['nID']."");		
	}
}
//echo "OK";
?>