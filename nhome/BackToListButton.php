<?php
$url = explode("/",$_SERVER['PHP_SELF']);
if (substr($url[3],0,5)!="print"){
	if($_GET['mod']=="consump"){
		if (@$_GET['id']!=NULL) {
			$BackButtonArray = array("6","7","16","17","1a","5","8_2","8_2a","12","9_2","11","9","8_3","9_3","18","19","13","14","15");
			if (in_array($_GET['id'],$BackButtonArray)) {
				echo '<tr><td><table><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=consump&func=formlist" style="font-size:14px;">Back to List</a></td></tr></table></td></tr>';
			}
		}
	}elseif($_GET['mod']=="humanresource"){
		if (@$_GET['id']!=NULL) {
			$BackButtonArray = array("2","4","6","8","3","5","14","16_2","7a","7b_1","7b_2","7b_3","7b_4","7b_5","15","13");
			if (in_array($_GET['id'],$BackButtonArray)) {
				echo '<tr><td><table><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=humanresource&func=formview" style="font-size:14px;">Back to List</a></td></tr></table></td></tr>';
			}
		}
	}elseif($_GET['mod']=="maintenance"){
        if (@$_GET['id']!=NULL) {
	        $BackButtonArray = array("1");
	        if (in_array($_GET['id'],$BackButtonArray)) {
		        echo '<tr><td><table><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=management&func=formview" style="font-size:14px;">Back to List</a></td></tr></table></td></tr>';
	        }
        }
	}elseif($_GET['mod']=="management"){
        if (@$_GET['id']!=NULL) {
	        $BackButtonArray = array("7b","6a","8","2","5","10","11","4","12","13","28","3a1","21","22","23","24","25","26","27","29","30");
	        if (in_array($_GET['id'],$BackButtonArray)) {
		        echo '<tr><td><table><tr id="backtr"><td class="backbtnn" align="center" id="backbtn" style="border:none; width:100px; height:30px;"><a href="index.php?mod=management&func=formview" style="font-size:14px;">Back to List</a></td></tr></table></td></tr>';
	        }
        }
	}else{}
}
?>