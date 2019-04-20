<?php
include("DB.php");
include("array.php");
include("function.php");

if($_POST['actID']==""){
  $db = new DB;
  $db->query("INSERT INTO `socialform08_act` (`cateName`,`actName`) VALUES ('".mysql_escape_string($_POST['cate1'])."', '".mysql_escape_string($_POST['cate2'])."')");  
  echo "OK";
}else{
  $db = new DB;
  $db->query("UPDATE `socialform08_act` SET `actName`='".mysql_escape_string($_POST['cate2'])."' WHERE actID='".mysql_escape_string($_POST['actID'])."'");  
  echo "OK1";	
}



?>