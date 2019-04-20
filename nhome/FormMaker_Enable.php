<?php
if($_SESSION['ncareLevel_lwj']!=5){
	echo '<script>window.location.href="index.php?func=home"</script>';
}
$db = new DB;
$db->query("SELECT * FROM `formmaker_list` WHERE `formID`='".mysql_escape_string($_GET['id'])."' AND `Enable`='0'");
if($db->num_rows()>0){
	$r = $db->fetch_assoc();
	$dba = new DB;
	$dba->query("UPDATE `formmaker_list` SET `Enable`='1' WHERE `formID`='".$r['formID']."'");
	if(strlen((int)$r['formID'])==1){
		$tableName = 'fmform0'.$r['formID'];
	}else{
		$tableName = 'fmform'.$r['formID'];
	}
	$SQL = 'CREATE TABLE `'.$tableName.'`(';
	$SQL .= '`no` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,';
	$SQL .= '`HospNo` MEDIUMINT(6) UNSIGNED ZEROFILL NOT NULL,';
	$SQL .= '`date` DATE NOT NULL,';
	for($i=0;$i<$r['row'];$i++){
		for($j=0;$j<$r['cell'];$j++){
			$db2 = new DB;
			$db2->query("SELECT * FROM `formmaker_set` WHERE `formID`='".$r['formID']."' AND `row`='".$i."' AND `cell`='".$j."' AND `Type`='input'");
			for($z=0;$z<$db2->num_rows();$z++){
				$r2 = $db2->fetch_assoc();
				if($r2['InputType']=="text"){
					$Column = 'Qr'.$i.'c'.$j;
					$SQL .= '`'.$Column.'` TEXT CHARACTER SET utf8 collate utf8_unicode_ci NULL,';
				}elseif($r2['InputType']=="date"){
					$Column = 'Qr'.$i.'c'.$j;
					$SQL .= '`'.$Column.'` DATE NOT NULL,';
				}elseif($r2['InputType']=="number"){
					$Column = 'Qr'.$i.'c'.$j;
					$SQL .= '`'.$Column.'` MEDIUMINT(8) NOT NULL,';
				}elseif($r2['InputType']=="select"){
					$Column = 'Qr'.$i.'c'.$j;
					$SQL .= '`'.$Column.'` TEXT CHARACTER SET utf8 collate utf8_unicode_ci NULL,';
					if($r2['Other']=="1"){
						$Column = 'Qr'.$i.'c'.$j.'zOther';
						$SQL .= '`'.$Column.'` TEXT CHARACTER SET utf8 collate utf8_unicode_ci NULL,';
					}
				}elseif($r2['InputType']=="draw_option" || $r2['InputType']=="draw_checkbox"){
					$arr_Option = explode(";",$r2['InputOption']);
					for($zz=1;$zz<=count($arr_Option);$zz++){
						$Column = 'Qr'.$i.'c'.$j.'_'.$zz;
						$SQL .= '`'.$Column.'` CHAR(1) CHARACTER SET utf8 collate utf8_unicode_ci NULL,';
					}
					if($r2['Other']=="1"){
						$Column = 'Qr'.$i.'c'.$j.'zOther';
						$SQL .= '`'.$Column.'` TEXT CHARACTER SET utf8 collate utf8_unicode_ci NULL,';
					}
				}else{}
			}
		}
	}
	$SQL .= '`Qfiller` TEXT CHARACTER SET utf8 collate utf8_unicode_ci NULL';
	$SQL .= ');';
	$db3 = new DB;
	$db3->query($SQL);
	$db4 = new DB;
	$db4->query("ALTER TABLE `".$tableName."` ENGINE=MyISAM;");
}
?>
<script>history.go(-1)</script>