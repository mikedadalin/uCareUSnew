<?php
include("DB.php");
include("function.php");
$db = new DB;
$db->query("SELECT `Insurance`,`InsuranceNumber`,`PeriodStart`,`PeriodEnd`,`Amount`,`BillTime` FROM `insurance` WHERE `HospNo`='".mysql_escape_string($_POST['HospNo'])."' AND `InsuranceNo`='".mysql_escape_string($_POST['InsuranceNo'])."'");
$r = $db->fetch_assoc();
foreach($r as $k=>$v){
	if($v==''){
		$r[$k] = 'none';
	}
}
echo $r['Insurance'].'||'.$r['InsuranceNumber'].'||'.formatdate($r['PeriodStart']).'||'.formatdate($r['PeriodEnd']).'||'.$r['Amount'].'||'.formatdate($r['BillTime']);
?>