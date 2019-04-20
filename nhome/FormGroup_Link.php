<?php
$_SESSION['G_func'] = mysql_escape_string($_GET['func']);
if(isset($_GET['pid'])){
	$_SESSION['G_pid'] = mysql_escape_string($_GET['pid']);
}

if($_GET['mod']=="consump"){
	$MOD_cateID = 8;
	$_SESSION['G_mod'] = 'consump';
}elseif($_GET['mod']=="humanresource"){
	$MOD_cateID = 9;
	$_SESSION['G_mod'] = 'humanresource';
}elseif($_GET['mod']=="management"){
	$MOD_cateID = 10;
	$_SESSION['G_mod'] = 'management';
}elseif($_GET['mod']=="carework"){
	$MOD_cateID = 12;
	$_SESSION['G_mod'] = 'carework';
}elseif($_GET['mod']=="nurseform"){
	$MOD_cateID = 1;
	$_SESSION['G_mod'] = 'nurseform';
}elseif($_GET['mod']=="nutrition"){
	$MOD_cateID = 6;
	$_SESSION['G_mod'] = 'nutrition';
}elseif($_GET['mod']=="rehabilitation"){
	$MOD_cateID = 5;
	$_SESSION['G_mod'] = 'rehabilitation';
}elseif($_GET['mod']=="socialwork"){
	$MOD_cateID = 4;
	$_SESSION['G_mod'] = 'socialwork';
}else{
	$MOD_cateID ='';
	unset($_SESSION['G_mod']);
	unset($_SESSION['G_func']);
	unset($_SESSION['G_pid']);
}
$dbFG = new DB;
$dbFG->query("SELECT * FROM `formgroup` WHERE `cateID`='".$MOD_cateID."' ORDER BY CAST(GroupID AS UNSIGNED) ASC");
if($dbFG->num_rows()>0){
	echo '<div class="formlistStyle">Continuous Form</div>';
	for($iFG=0;$iFG<$dbFG->num_rows();$iFG++){
		$rFG = $dbFG->fetch_assoc();
		$dbFG2 = new DB;
		$dbFG2->query("SELECT * FROM `formorder` WHERE `GroupID`='".$rFG['GroupID']."' AND `serNo`!=''");
		if($dbFG2->num_rows()>0){
			$_SESSION['G_GNOnumber'] = $dbFG2->num_rows();
			echo '<div class="formlistItem">';
			if(isset($_GET['pid'])){
				echo '<a href="index.php?func=FormGroup&GID='.$rFG['GroupID'].'&pid='.$_GET['pid'].'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-refresh fa-spin fa-stack-1x fa-inverse"></i></span><br>'.$rFG['ListName'].'</a>';
			}else{
				echo '<a href="index.php?func=FormGroup&GID='.$rFG['GroupID'].'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-refresh fa-spin fa-stack-1x fa-inverse"></i></span><br>'.$rFG['ListName'].'</a>';
			}
			echo '</div>';
		}
	}
}
?>