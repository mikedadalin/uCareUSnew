<?php
include("../lwj/lwj.php");
include("DB.php");
include("array.php");
include("function.php");
if($_POST['type']=="insert"){
  $db = new DB;
	/*== 加 START ==*/
	   $rsa = new lwj('../lwj/lwj');
	   $part = ceil(strlen($_POST['Name'])/117);
	   if($part>1){
	       $datapart = str_split($v, 117);
		   for($j=0;$j<$part;$j++){
			   $puepart = $rsa->pubEncrypt($datapart[$j]);
			   $_POST['Name'] = $_POST['Name'].$puepart." ";
		   }
	   }else{
		   $_POST['Name'] = $rsa->pubEncrypt($_POST['Name']);
	   }
    /*== 加 END ==*/
  $db->query("INSERT INTO `general_io` (`HospNo`, `bedID`, `Name`, `outdate`, `reason_1`, `reason_2`, `reason_3`, `reason_4`, `reasonOther`, `rmk`, `Qfiller`) VALUES ('".getHospNoByHospNoDisplay(getTypeByHospNoDisplay($_POST['HospNo']),$_POST['HospNo'])."', '".mysql_escape_string($_POST['bedID'])."', '".mysql_escape_string($_POST['Name'])."', '".mysql_escape_string($_POST['outdate'])."', '".mysql_escape_string($_POST['reason_1'])."', '".mysql_escape_string($_POST['reason_2'])."', '".mysql_escape_string($_POST['reason_3'])."', '".mysql_escape_string($_POST['reason_4'])."', '".mysql_escape_string($_POST['reasonOther'])."', '".mysql_escape_string($_POST['rmk'])."', '".mysql_escape_string($_POST['Qfiller'])."')");
  
  echo "OK";
}else{
  $db1 = new DB;
  //echo "SELECT * FROM `general_io` WHERE `outdate`='".mysql_escape_string($_POST['outdate'])."' and `HospNo`='".mysql_escape_string($_POST['HospNo'])."'";
  $db1->query("SELECT * FROM `general_io` WHERE `outdate`='".mysql_escape_string($_POST['outdate'])."' and `HospNo`='".getHospNoByHospNoDisplay(getTypeByHospNoDisplay($_POST['HospNo']),$_POST['HospNo'])."'");
  if($db1->num_rows() > 0){
	  echo "離院日期已存在!";
  }else{
	  echo "OK";
  }	
}



?>
