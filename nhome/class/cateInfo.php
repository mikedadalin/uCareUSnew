<?php
include("DB.php");
include("function.php");

$strModule = "service_cate";
$NAME = mysql_escape_string($_POST['NAME']);
$code = mysql_escape_string($_POST['code']);
$layer = mysql_escape_string($_POST['layer']);
$parent = mysql_escape_string($_POST['parent']);
$sql1 = "SELECT * FROM `".$strModule."` WHERE 1=1 And title = '".$NAME."' and typeCode='".$code."' and layer='".$layer."' and parentID='".$parent."'";

$db = new DB;
$db->query($sql1);

if($db->num_rows()> 0){
	$rs = $db->fetch_assoc();
	echo "T";
}else{
	echo "F";
}
?>