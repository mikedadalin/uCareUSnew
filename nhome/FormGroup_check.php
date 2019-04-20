<?php
$out_cycle = 0;
if(isset($_SESSION['GNO'])){
	$allow_func = array("database","databaseAI","nurseform2g2save","nurseform13save","socialwork11csave");  //  儲存流程 
	$not_allow_func = array("patientlist","careworklist","sociallist","rehabilitationlist","nutritionlist","medlist","");
	if(in_array($_GET['func'],$not_allow_func)){
		$out_cycle = 1;
	}
	if($out_cycle==0){
		if(isset($_SESSION['G_pid']) && !in_array($_GET['func'],$allow_func)){   //針對住民表單來 跳出連續性表單
			if($_SESSION['G_pid']!=$_GET['pid']){
				$arr_socialwork_nopid = array("8","8a","8b","8c","8d","8_1b");
				if($_SESSION['G_mod']=="nurseform" && (($_GET['mod']=="management" && $_GET['id']=="9_1") || $_GET['func']=="managementlist")){
					
				}elseif($_SESSION['G_mod']=="socialwork" && in_array($_GET['id'],$arr_socialwork_nopid)){
					
				}else{
					$out_cycle = 1;	
				}
			}
		}else{
			if(isset($_GET['pid'])){
				$out_cycle = 1;	
			}
		}
	}
	if($out_cycle==1){
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
	}
}
if(isset($_SESSION['GNO'])){
	if(isset($_GET['func']) && $_GET['func']!="database"){
		$G_Temp_Link = str_replace("nhome/","",$UserActionURL[1]);
		$_SESSION['G_Temp_Link'] = $G_Temp_Link;
	}
	//$G_check = 0;
	for($i=1;$i<11;$i++){
		$kGF = 'Glink_'.$i;
		if($_SESSION[$kGF]==$_SESSION['G_Temp_Link']){
			//$G_check = 1;
			$_SESSION['GNO'] = $i;
		}
	}
	//if($G_check==0){
		/*
		for($i=1;$i<11;$i++){
			$kGF = 'Glink_'.$i;
			$kGF2 = 'Gname_'.$i;
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
		*/
	//}else{
		echo '<script type="text/javascript" src="js/LWJ_CheckGF.js"></script>';
		echo '<script type="text/javascript" src="js/LWJ_CloseGF.js"></script>';
		$GNONO = 0;
		for($i=1;$i<11;$i++){
			$kGF = 'Glink_'.$i;
			if(isset($_SESSION[$kGF])){
				$GNONO = $GNONO+2;
			}
		}
		if($GNONO==0){ $GNONO = 1;}
		echo '<div id="ContinuousForm" class="ContinuousForm">';
		echo '<table align="center" style="text-align:center;">';
		echo '<tr>';
		echo '<td colspan="'.$GNONO.'" style="color:#fff; font-weight:bolder; font-size:11pt;">'.$_SESSION['GListName'].' <button type="button" onclick="CloseGF();" style="background-color:#f33548; color:#fff; border:0; border-radius:5px; height:23px;"><i class="fa fa-times-circle fa-lg"></i></button></td>';
		echo '</tr>';
		echo '<tr>';
		for($i=1;$i<11;$i++){
			$kGF = 'Glink_'.$i;
			$kGF2 = 'Gname_'.$i;
			if(isset($_SESSION[$kGF2])){
				$arr_Gname = explode("_",$_SESSION[$kGF2]);
				echo '<td>';
				if($_SESSION['GNO']==$i){
				//if($_SESSION[$kGF]==$_SESSION['G_Temp_Link']){
					if($arr_Gname[2]=="1"){
						echo '<button id="CheckGF_'.$i.'" style="color:white;" checked disabled><i class="fa fa-check-square-o"></i></button>';
					}else{
						if(isset($_SESSION['G_mod']) && isset($_SESSION['G_func']) && isset($_SESSION['G_pid'])){
							$mod_pid = '_2';
						}elseif(isset($_SESSION['G_mod']) && isset($_SESSION['G_func'])){
							$mod_pid = '_1';
						}else{
							$mod_pid = '';
						}
						echo '<button id="CheckGF_'.$i.$mod_pid.'" style="color:white;" onclick="CheckGF(this.id);"><i class="fa fa-square-o"></i></button>';
					}
				}elseif($arr_Gname[2]=="1"){
					echo '<button id="CheckGF_'.$i.'" style="color:white;" checked disabled><i class="fa fa-check-square-o"></i></button>';
				}else{
					echo '<button id="CheckGF_'.$i.'" style="color:white;" checked disabled><i class="fa fa-square-o"></i></button>';
				}
				echo '</td>';
				echo '<td></td>';
			}
		}
		echo '</tr>';
		echo '<tr>';
		$GNOnumber = 0;
		for($i=1;$i<11;$i++){
			$kGF = 'Glink_'.$i;
			$kGF2 = 'Gname_'.$i;
			if(isset($_SESSION[$kGF2])){
				$arr_Gname = explode("_",$_SESSION[$kGF2]);
				if($_SESSION['GNO']==$i){
				//if($_SESSION[$kGF]==$_SESSION['G_Temp_Link']){
					$Gname_style = ' style="color:#efd24d;"';
					$alink = ' href="'.$_SESSION[$kGF].'" style="color:#efd24d;"';
				}elseif($arr_Gname[2]=="1"){
					$Gname_style = ' style="color:rgb(149,219,208);"';
					$alink = '';
				}else{
					$Gname_style = '';
					$alink = ' href="'.$_SESSION[$kGF].'"';
				}
				echo '<td'.$Gname_style.'>';
				if($alink!=''){ echo '<a'.$alink.'>';}
				echo '<i class="fa fa-'.$arr_Gname[1].' fa-2x"></i><br>';
				echo $arr_Gname[0];
				if($alink!=''){ echo '</a>'; }
				echo '</td>';
				$GNOnumber++;
				if($GNOnumber!=$_SESSION['G_GNOnumber']){
					echo '<td'.$Gname_style.'>';
					echo '<i class="fa fa-caret-right"></i>';
					echo '</td>';
				}
			}
		}
		echo '</tr>';
		echo '</table>';
		echo '</div>';
	//}
}
?>