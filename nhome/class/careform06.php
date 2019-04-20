<?php
include("DB.php");
$arrQ = explode("_",$_POST['Q']);
foreach ($arrQ as $k=>$v){
	 $arrStrQ = $arrQ[1];
	 $arrStrQ1 = $arrQ[1].'_'.$arrQ[2];
}
$db = new DB;
$db->query("SELECT `".$arrStrQ."_filler`, SUM(`".$arrStrQ."_1`+`".$arrStrQ."_2`+`".$arrStrQ."_3`+`".$arrStrQ."_4`+`".$arrStrQ."_5`) as `sumQ`, `careform06`.* FROM `".$_POST['formID']."` WHERE `date`='".mysql_escape_string($_POST['date'])."' AND `HospNo`='".mysql_escape_string($_POST['HospNo'])."' GROUP BY `".$arrStrQ."_filler`");
$rs = $db->fetch_assoc();
if($db->num_rows() > 0){
	foreach ($rs as $k=>$v) {
		if (substr($k,0,2)==$arrStrQ) {
			if ($k==$arrStrQ."_filler") {
				$Qfiller = $v;
			} else {
				if ($Qfiller==$_SESSION['ncareID_lwj'] || $rs['sumQ']==0){
					if ($Qfiller=="") { $Qfiller = $_SESSION['ncareID_lwj']; }
					if ($k==$arrStrQ1) {$tmp=1;} else {$tmp=0;}
					$db2 = new DB;
					$db2->query("UPDATE `".$_POST['formID']."` SET `".$k."`='".$tmp."', `".$arrStrQ."_filler`='".$Qfiller."'  WHERE `date`='".mysql_escape_string($_POST['date'])."' AND `HospNo`='".mysql_escape_string($_POST['HospNo'])."'");
				} else {
					$err = '1';
				}
			}
		}
	}
}else{
	$strSQL = "INSERT INTO `".$_POST['formID']."` (`HospNo`,`date`,`".$arrStrQ1."`,`".$arrStrQ."_filler`) VALUES ( ";
	$strSQL .="'".mysql_escape_string($_POST['HospNo'])."','".mysql_escape_string($_POST['date'])."','1','".$_SESSION['ncareID_lwj']."')";
	$db1 = new DB;
	$db1->query($strSQL);	
}
echo $err;
?>