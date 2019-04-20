<?php
if($_GET['mod']=="nurseform"){
	if($_GET['id']=="1"){
		$LanguageformID = "languang_".$_GET['mod']."_".$_GET['id'];
		$dbLanguage = new DB;
		$dbLanguage->query("SELECT * FROM `".$LanguageformID."` WHERE `LanguangNumber`='".$_SESSION['LanguangNumber_lwj']."'");
		if ($dbLanguage->num_rows()>0) {
			$rLanguage = $dbLanguage->fetch_assoc();
			foreach ($rLanguage as $k=>$v) {
					${$k} = $v;
			}
		}
	}
}
if($_GET['mod']=="socialwork"){
	if($_GET['id']=="1a_1"){
		$LanguageformID = "languang_nurseform_1";
		$dbLanguage = new DB;
		$dbLanguage->query("SELECT * FROM `".$LanguageformID."` WHERE `LanguangNumber`='".$_SESSION['LanguangNumber_lwj']."'");
		if ($dbLanguage->num_rows()>0) {
			$rLanguage = $dbLanguage->fetch_assoc();
			foreach ($rLanguage as $k=>$v) {
					${$k} = $v;
			}
		}
	}
}
?>