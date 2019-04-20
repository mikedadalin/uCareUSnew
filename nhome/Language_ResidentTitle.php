<?php
if($_GET['mod']=="nurseform" || $_GET['mod']=="mdsform" || $_GET['mod']=="mmqform" || $_GET['mod']=="nursediag" || $_GET['mod']=="carework" || $_GET['mod']=="socialwork" || $_GET['mod']=="rehabilitation" || $_GET['mod']=="nutrition" || $_GET['func']=="NurseRounds"){
	$dbLanguage = new DB;
	$dbLanguage->query("SELECT * FROM `languang_formview` WHERE `LanguangNumber`='".$_SESSION['LanguangNumber_lwj']."'");
	if ($dbLanguage->num_rows()>0) {
		$rLanguage = $dbLanguage->fetch_assoc();
		foreach ($rLanguage as $k=>$v) {
			${$k} = $v;
		}
	}
}
?>