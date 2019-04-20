<?php
if($_GET['mod']=="nurseform"){
	$arrOnBeforeUnload = array("1","1a","22","5_1","4_1","2a","2n","2d","2h","2f","2l","2m","2e","2c","2b","41","11a","2g","2g_1","2g_2","2g_3","2j_1","2j_2","2j_3","10b_1","10b_2","10b_3","10b_4","31_1","23_1","11","12","13","16_1","19_1","17_1","17_3","18","20_2","30_2","17_4a");
}elseif($_GET['mod']=="nursediag"){
	$arrOnBeforeUnload = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46");
}elseif($_GET['mod']=="mdsform"){
	$arrOnBeforeUnload = array("1-Alter","2-Alter","3-Alter","4-Alter","5-Alter","6-Alter","7-Alter","8-Alter","9-Alter","10-Alter","11-Alter","12-Alter","13-Alter","14-Alter","15-Alter","16-Alter","17-Alter","18-Alter","19-Alter","20-Alter","21-Alter","22-Alter","23-Alter","24-Alter","25-Alter","26-Alter","27-Alter","28-Alter","29-Alter","30-Alter","31-Alter","32-Alter","33-Alter","34-Alter","35-Alter","36-Alter","37-Alter","38-Alter","39-Alter","40-Alter","41-Alter","42-Alter","43-Alter");
}elseif($_GET['mod']=="carework"){
	$arrOnBeforeUnload = array("7_1","7_2","7_3","5_1","5_2","6_1","11b","13","3_1");
}elseif($_GET['mod']=="dailywork"){
	if($_GET['func']=="respedit" || $_GET['func']=="resplist2" || $_GET['func']=="resplist2_weight"){
		?><script>window.onbeforeunload = function(){ return 'The unsaved data will disappear, confirm leaving this page?'; }</script><?php
	}
}elseif($_GET['mod']=="inputoutput"){
	if($_GET['func']=="resplist2"){
		?><script>window.onbeforeunload = function(){ return 'The unsaved data will disappear, confirm leaving this page?'; }</script><?php
	}
}elseif($_GET['mod']=="socialwork"){
	$arrOnBeforeUnload = array("1a_1","8a","8b","8_1b","8d","1a_2","1a_3","2","4_1","6a","7","11c","11d","20_1","10b_1","10b_2","10b_3","10b_4");
}elseif($_GET['mod']=="rehabilitation"){
	$arrOnBeforeUnload = array("3","20_1","21_1","21_2","4","5","3","10b_1","10b_2","10b_3","10b_4");
}elseif($_GET['mod']=="nutrition"){
	$arrOnBeforeUnload = array("32","33","35","36");
	if($_GET['func']=="form31edit"){
		?><script>window.onbeforeunload = function(){ return 'The unsaved data will disappear, confirm leaving this page?'; }</script><?php
	}
}elseif($_GET['mod']=="consump"){
	$arrOnBeforeUnload = array("7a","16_1","16_3","17_1","17_2","17_3","17_4","17_6","1b","8","8_1","8_1a","8_1OC","12_1","12_2","8_4","1d","11_3","11_1","11_4","11_2");
}elseif($_GET['mod']=="humanresource"){
	$arrOnBeforeUnload = array("2_1","12_1","10_1","2_2","4_1","8_1","8_2","3_2","9_2","9_1","6");
}elseif($_GET['mod']=="management"){
	$arrOnBeforeUnload = array("9_2","9_3","3b_1","3b_2","3b_3","3b_4","1a","8","5","10_1","10_2","11","4","12_1","12_2","13","26c","6a_2","6a_1","3","3d_2","3c_1","3d_1");
}elseif($_GET['mod']=="category"){
	$arrOnBeforeUnload = array("1_1","1_2","2_1","2_2");
}elseif($_GET['mod']=="maintenance"){
	$arrOnBeforeUnload = array("1a");
}elseif($_GET['mod']=="mealadmin"){
	if($_GET['func']=="editroundmenu" || $_GET['func']=="newroundmenu"){
		?><script>window.onbeforeunload = function(){ return 'The unsaved data will disappear, confirm leaving this page?'; }</script><?php
	}
}elseif($_GET['func']=="FeedbackForm" || $_GET['func']=="NurseRounds" || $_GET['func']=="SystemUpdateInfoEdit" || $_GET['func']=="newcase" || $_GET['func']=="shiftadmin" || $_GET['func']=="shiftrecord1_1"){
	?><script>window.onbeforeunload = function(){ return 'The unsaved data will disappear, confirm leaving this page?'; }</script><?php
}else{}

if(@$_GET['mod']!=""){
	if(@in_array($_GET['id'],$arrOnBeforeUnload)){
		?><script>window.onbeforeunload = function(){ return 'The unsaved data will disappear, confirm leaving this page?'; }</script><?php
	}
}
?>