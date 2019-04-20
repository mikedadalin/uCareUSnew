<?php
session_start();
$GNO_Change = 0;
$kGF3 = 'Gname_'.$_SESSION['GNO'];
$arr_Gname3 = explode("_",$_SESSION[$kGF3]);
$_SESSION[$kGF3] = $arr_Gname3[0].'_'.$arr_Gname3[1].'_1';
for($iGF=1;$iGF<11;$iGF++){
	$kGF = 'Glink_'.$iGF;
	if(isset($_SESSION[$kGF])){
	$kGF2 = 'Gname_'.$iGF;
	$arr_Gname2 = explode("_",$_SESSION[$kGF2]);
		if($arr_Gname2[2]=="0" && $GNO_Change==0){
			$_SESSION['GNO'] = $iGF;
			$GNO_Change = 1;
			echo '1;'.$_SESSION[$kGF];
		}
	}
}
if($GNO_Change==0){
	$ID = $_POST['ID'];
	$arr_ID = explode("_",$ID);
	if($arr_ID[2]=="2"){
		$Gurl = 'index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'].'&pid='.$_SESSION['G_pid'];
	}elseif($arr_ID[2]=="1"){
		$Gurl = 'index.php?mod='.$_SESSION['G_mod'].'&func='.$_SESSION['G_func'];
	}else{
		$Gurl = 'none';
	}
	for($iGF=1;$iGF<11;$iGF++){
		$kGF = 'Glink_'.$iGF;
		$kGF2 = 'Gname_'.$iGF;
		unset($_SESSION[$kGF]);
		unset($_SESSION[$kGF2]);
	}
	unset($_SESSION['GNO']);
	unset($_SESSION['GListName']);
	unset($_SESSION['G_Temp_Link']);
	unset($_SESSION['G_GNOnumber']);
	unset($_SESSION['G_mod']);
	unset($_SESSION['G_func']);
	unset($_SESSION['G_pid']);
	
	echo '0;'.$Gurl;
}
?>