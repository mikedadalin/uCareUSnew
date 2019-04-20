<?php
$data = '<?xml version="1.0"?>'."\r\n\t";
$TableName = "vitalsign";
$Select = "*";
$Condition = "WHERE `PatientID`=".$_GET['pid']."";
$data_tab = "VITALSIGN";
$last_k = "Qfiller";
$uploaddir = 'MMQ/'.$_SESSION['nOrgID_lwj'].'/';
$FileName = 'vitalsign-'.date("Y-m-d").'_'.$_GET['pid'].'.xml';
$getFileName = 'MMQ/'.$_SESSION['nOrgID_lwj'].'/'.$FileName;


$db = new DB;
$db->query("SELECT ".$Select." FROM `".$TableName."` ".$Condition."");
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	$data .= '<'.$data_tab.'_'.$i.'>'."\r\n\t\t";
	foreach ($r as $k=>$v) {
		//$data .= '<VITALSIGN TITLE="'.$k.'" VALUE="'.$v.'"/>\r\n';
		if($k==$last_k){
			$data .= '<'.$k.'>'.$v.'</'.$k.'>'."\r\n\t";
		}else{
			$data .= '<'.$k.'>'.$v.'</'.$k.'>'."\r\n\t\t";
		}
	}
	if($i<$db->num_rows()-1){
		$data .= '</'.$data_tab.'_'.$i.'>'."\r\n\t";
	}else{
		$data .= '</'.$data_tab.'_'.$i.'>'."\r\n";
	}
}


if (!file_exists($uploaddir)) { mkdir($uploaddir, 0777); }
//$data = iconv("UTF-8","big5",$data); //--------utf8轉big5-------- 
touch($getFileName);
if(@$fp = fopen($getFileName, 'w+')){
	fwrite($fp, $data);
	fclose($fp);
	?><script>alert('Export XML: <? echo $FileName;?>');</script><?
}
?>