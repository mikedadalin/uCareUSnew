<?php
include("DB.php");
include("function.php");

$strModule = $_POST['table'];				//資料表
$lbllevel1 = $_POST['lbllevel1'];			//分類欄位名稱
$lbllevel1ID = $_POST['lbllevel1ID'];		//分類欄位代碼
$moduleName = $_POST['moduleName'];			//顯示欄位名稱
$moduleID = $_POST['moduleID'];				//顯示欄位代碼
$colID = $_POST['colID'];					//實際取得的流水號
$autoID = $_POST['autoID'];					//流水號
$display = $_POST['display'];				//是否顯示moduleID

$sql1 = "SELECT * FROM `".$strModule."` WHERE 1=1 And ".$lbllevel1." = '".$lbllevel1ID."' ORDER BY ".$moduleID."";
$db = new DB;
$db->query($sql1);

if($db->num_rows()> 0){	 
	echo '
	<select id="lbllevel2" name="lbllevel2">
	<option value="0">---</option>';
	for ($i=0;$i<$db->num_rows();$i++) {
		$rs = $db->fetch_assoc();		
		echo '<option value="'.$rs[$autoID].'" '.($rs[$autoID]==$colID?"selected='selected'":"").'>'.($display=="true"?"【".$rs[$moduleID]."】":"").$rs[$moduleName].'</option>';
	}
	echo '</select>';
}
?>