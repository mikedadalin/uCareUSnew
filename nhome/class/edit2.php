<?php
include("DB2.php");
foreach ($_POST as $k => $v){
	$db = new DB2;
	if($k != "formID" && $k != "colID" && $k != "autoID"){
		$db->query("UPDATE `".$_POST['formID']."` SET `".$k."`='".$v."' WHERE `".$_POST['colID']."`='".mysql_escape_string($_POST['autoID'])."'");		
		echo $v;
	}
}

?>