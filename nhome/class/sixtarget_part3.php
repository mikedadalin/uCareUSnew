<?php
include("../lwj/lwj.php");
include("DB.php");
include("array.php");
include("function.php");
$db = new DB;
$db->query("INSERT INTO `sixtarget_part3` (`targetID`) VALUES ('')");
$db1 = new DB;
$db1->query("SELECT LAST_INSERT_ID();");
$r1 = $db1->fetch_assoc();
$targetID = $r1['LAST_INSERT_ID()'];
$transform = $_POST['transform']; //是否轉換護字號; 1=None NULL=要
unset($_POST['transform']);
foreach ($_POST as $k=>$v) {
	if ($k=="HospNo") { ${'nr_'.$k} = $v; }
	if ($transform=="") {
		if ($k=="HospNo") { $v = getHospNoByHospNoDisplayNoType($v); ${'nr_'.$k}=$v; }
	}
	/*== 加 START ==*/
    if($k == "Name"){
	   $rsa = new lwj('../lwj/lwj');
	   $part = ceil(strlen($v)/117);
	   if($part>1){
	       $datapart = str_split($v, 117);
		   for($j=0;$j<$part;$j++){
			   $puepart = $rsa->pubEncrypt($datapart[$j]);
			   $v = $v.$puepart." ";
		   }
	   }else{
		   $v = $rsa->pubEncrypt($v);
	   }
	}
    /*== 加 END ==*/
	$arrinfo = explode("_",$k);
	if (count($arrinfo)>1) {
		if ($v==1) { ${$arrinfo[0]} .= $arrinfo[1].';'; }
	} else {
		${$k} = $v;
	}
	$db2 = new DB;
	$db2->query("UPDATE `sixtarget_part3` SET `".$k."`='".$v."' WHERE `targetID`='".$targetID."'");
}

echo "OK";
?>