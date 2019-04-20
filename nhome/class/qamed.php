<?php
include("DB.php");
include("array.php");
include("function.php");
$HospNo = $_POST['HospNo'];
$question = $_POST['question'];
$Qmedicine = $_POST['Qmedicine'];


/*$db0 = new DB;
$db0->query("SELECT * FROM `medicineq` WHERE `HospNo` = '".$HospNo."' AND `Qmedicine` = '".$Qmedicine."'");
$r0 = $db0->fetch_assoc();
if($db0->num_rows() > 0){
  echo "此藥物已諮詢過!";
}else{
*/$db = new DB;
  $db2 = new DB;
  $db->query("INSERT INTO `medicineq` (`HospNo`, `date`, `Qmedicine`, `question`, `Qfiller`, `Q3a`) VALUES ('".mysql_escape_string($_POST['HospNo'])."', '".date("Y/m/d H:i:s")."', '".mysql_escape_string($_POST['Qmedicine'])."', '".mysql_escape_string($_POST['question'])."', '".mysql_escape_string($_POST['Qfiller'])."', '".mysql_escape_string($_POST['Q3a'])."')");
  $db2->query("SELECT LAST_INSERT_ID()"); 
  $r_n2 = $db2->fetch_assoc();
  $qID = $r_n2['LAST_INSERT_ID()'];
   
  foreach ($_POST as $k=>$v){
	  $arrQuestion = explode("_",$k);
	  if(count($arrQuestion)==2){
		$db1 = new DB;
	  	$db1->query("UPDATE `medicineq` SET `".$k."` = '".$v."' WHERE `qID` = '".$qID."'");
	  }
  }
  
  echo "已經成功新增藥物諮詢問題";

//}	

?>