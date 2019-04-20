<?php
/* ICD 9
  $str = str_split($_POST['icdinput']);  
  
  if(preg_match("/^[0-9]/", $str[0])){
     include("DB2.php");
     $icd = $_POST['icdinput'];
     if (strlen($icd)==5) {
     	$qicd = round(($icd/100),2);
     } elseif (strlen($icd)==4) {
     	$qicd = round(($icd/10),1);
     } elseif (strlen($icd==3)) {
     	$qicd = $icd;
     } else {
     	for ($i=0;$i<(3-strlen($icd));$i++) {
     		$prefix .= '0';
     	}
     	$qicd = $prefix.$icd;
     }
     $db = new DB2;
     $db->query("SELECT `code`, `Englishname` FROM `icd9` WHERE `code` LIKE '%".$qicd."%'");
     for ($i=0;$i<$db->num_rows();$i++) {
     	$r = $db->fetch_assoc();
     	$result .= str_replace('.','',$r['code'])." ".$r['Englishname'].";";	
	 }
     echo substr($result,0,(strlen($result)));    
  }
  
  if(preg_match("/^[A-Za-z]/", $str[0])){
     include("DB2.php");
     $qicd = $_POST['icdinput'];
     $db = new DB2;
     $db->query("SELECT `code`, `Englishname` FROM `icd9` WHERE `Englishname` LIKE '%".$qicd."%'");
     for ($i=0;$i<$db->num_rows();$i++) {
     	$r = $db->fetch_assoc();
     	$result .= str_replace('.','',$r['code'])." ".$r['Englishname'].";";
     }
     echo substr($result,0,(strlen($result)));         
  }
  */
  
  
  /* ICD 10 */
     include("DB2.php");
     $qicd = $_POST['icdinput'];
     $db = new DB2;
     $db->query("SELECT `Code`, `LongDescript` FROM `icd10` WHERE `LongDescript` LIKE '%".$qicd."%'");
     for ($i=0;$i<$db->num_rows();$i++) {
     	$r = $db->fetch_assoc();
     	$result .= str_replace('.','',$r['Code'])." ".$r['LongDescript'].";";
     }
     $db2 = new DB2;
     $db2->query("SELECT `Code`, `LongDescript` FROM `icd10` WHERE `Code` LIKE '%".$qicd."%'");
     for ($i=0;$i<$db2->num_rows();$i++) {
     	$r2 = $db2->fetch_assoc();
     	$result .= str_replace('.','',$r2['Code'])." ".$r2['LongDescript'].";";	
	 }
     echo substr($result,0,(strlen($result)));
?>