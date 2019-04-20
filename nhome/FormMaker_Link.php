<?php
if($_SESSION['ncareLevel_lwj']==5){
	echo '<div class="formlistStyle">Form Maker</div>';
	echo '<div class="formlistItem">';
	if($_GET['mod']=="consump"){
		echo '<a href="index.php?func=FormMaker_List&bk='.$_GET['mod'].'_'.$_GET['func'].'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></i></span><br>Form Maker</a>';
	}else{
		echo '<a href="index.php?func=FormMaker_List&bk='.$_GET['mod'].'_'.$_GET['pid'].'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></i></span><br>Form Maker</a>';
	}
	echo '</div>';
}
$first_time =0;
$dbOrder = new DB;
$dbOrder->query("SELECT `formID` FROM `formmaker_order` WHERE `CategoryID`='' ORDER BY CAST(Show_Order AS UNSIGNED) ASC,`formID` ASC");

for($iOrder=0;$iOrder<$dbOrder->num_rows();$iOrder++){
	$rOrder = $dbOrder->fetch_assoc();
	$dbFM = new DB;
	$dbFM->query("SELECT * FROM `formmaker_list` WHERE `Enable`='1' AND `formID`='".$rOrder['formID']."'");
	for($iFM=0;$iFM<$dbFM->num_rows();$iFM++){
		$arr_Module = array();
		$rFM = $dbFM->fetch_assoc();
		$arr_PermissionGroup = explode(";",$rFM['PermissionGroup']);
		if(in_array($_SESSION['ncareGroup_lwj'],$arr_PermissionGroup)){
			$arr_Module_DB = explode(";",$rFM['Module']);
			$arr_PermissionSet = explode(";",$allow_PermissionSet);
			for($iModule=0;$iModule<count($arr_Module_DB);$iModule++){
				if($arr_Module_DB[$iModule]=="1"){
					array_push($arr_Module,"1");
				}elseif($arr_Module_DB[$iModule]=="2"){
					array_push($arr_Module,"12");
				}elseif($arr_Module_DB[$iModule]=="3"){
					array_push($arr_Module,"4");
				}elseif($arr_Module_DB[$iModule]=="4"){
					array_push($arr_Module,"5");
				}elseif($arr_Module_DB[$iModule]=="5"){
					array_push($arr_Module,"6");
				}elseif($arr_Module_DB[$iModule]=="6"){
					array_push($arr_Module,"8");
				}elseif($arr_Module_DB[$iModule]=="7"){
					array_push($arr_Module,"9");
				}elseif($arr_Module_DB[$iModule]=="8"){
					array_push($arr_Module,"10");
				}else{}
			}
			if($_GET['mod']=="consump"){
				$PermissionSet = 8;
			}elseif($_GET['mod']=="humanresource"){
				$PermissionSet = 9;
			}elseif($_GET['mod']=="management"){
				$PermissionSet = 10;
			}elseif($_GET['mod']=="carework"){
				$PermissionSet = 12;
			}elseif($_GET['mod']=="nurseform"){
				$PermissionSet = 1;
			}elseif($_GET['mod']=="nutrition"){
				$PermissionSet = 6;
			}elseif($_GET['mod']=="rehabilitation"){
				$PermissionSet = 5;
			}elseif($_GET['mod']=="socialwork"){
				$PermissionSet = 4;
			}else{
				$PermissionSet ='';
			}
			if(in_array($PermissionSet,$arr_PermissionSet) && in_array($PermissionSet,$arr_Module)){
				if($rFM['PermissionLevel']==1 || ($rFM['PermissionLevel']==2 && $_SESSION['ncareLevel_lwj']==5)){
					if($_SESSION['ncareLevel_lwj']!=5 && $first_time==0){
						echo '<div class="formlistStyle">Form Maker</div>';
						$first_time++;
					}
					echo '<div class="formlistItem">';
					echo '<a href="index.php?mod=fmform&func=formview&id='.$rFM['formID'].'&pid='.$_GET['pid'].'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-file-text fa-stack-1x fa-inverse"></i></span><br>'.$rFM['FormName'].'</a>';
					echo '</div>';
				}
			}
		}
	}
}
$dbFM2 = new DB;
$dbFM2->query("SELECT * FROM `formmaker_category` ORDER BY CAST(Show_Order AS UNSIGNED) ASC,`CategoryID` ASC");
for($iFM2=0;$iFM2<$dbFM2->num_rows();$iFM2++){
	$rFM2 = $dbFM2->fetch_assoc();
	$first_time =0;
	$dbOrder = new DB;
	$dbOrder->query("SELECT `formID` FROM `formmaker_order` WHERE `CategoryID`='".$rFM2['CategoryID']."' ORDER BY CAST(Show_Order AS UNSIGNED) ASC,`formID` ASC");
	for($iOrder=0;$iOrder<$dbOrder->num_rows();$iOrder++){
		$rOrder = $dbOrder->fetch_assoc();
		$dbFM3 = new DB;
		$dbFM3->query("SELECT * FROM `formmaker_list` WHERE `Enable`='1' AND `formID`='".$rOrder['formID']."'");
		for($iFM3=0;$iFM3<$dbFM3->num_rows();$iFM3++){
			$arr_Module = array();
			$rFM3 = $dbFM3->fetch_assoc();
			$arr_PermissionGroup = explode(";",$rFM3['PermissionGroup']);
			if(in_array($_SESSION['ncareGroup_lwj'],$arr_PermissionGroup)){
				$arr_Module_DB = explode(";",$rFM3['Module']);
				$arr_PermissionSet = explode(";",$allow_PermissionSet);
				for($iModule=0;$iModule<count($arr_Module_DB);$iModule++){
					if($arr_Module_DB[$iModule]=="1"){
						array_push($arr_Module,"1");
					}elseif($arr_Module_DB[$iModule]=="2"){
						array_push($arr_Module,"12");
					}elseif($arr_Module_DB[$iModule]=="3"){
						array_push($arr_Module,"4");
					}elseif($arr_Module_DB[$iModule]=="4"){
						array_push($arr_Module,"5");
					}elseif($arr_Module_DB[$iModule]=="5"){
						array_push($arr_Module,"6");
					}elseif($arr_Module_DB[$iModule]=="6"){
						array_push($arr_Module,"8");
					}elseif($arr_Module_DB[$iModule]=="7"){
						array_push($arr_Module,"9");
					}elseif($arr_Module_DB[$iModule]=="8"){
						array_push($arr_Module,"10");
					}else{}
				}
				if($_GET['mod']=="consump"){
					$PermissionSet = 8;
				}elseif($_GET['mod']=="humanresource"){
					$PermissionSet = 9;
				}elseif($_GET['mod']=="management"){
					$PermissionSet = 10;
				}elseif($_GET['mod']=="carework"){
					$PermissionSet = 12;
				}elseif($_GET['mod']=="nurseform"){
					$PermissionSet = 1;
				}elseif($_GET['mod']=="nutrition"){
					$PermissionSet = 6;
				}elseif($_GET['mod']=="rehabilitation"){
					$PermissionSet = 5;
				}elseif($_GET['mod']=="socialwork"){
					$PermissionSet = 4;
				}else{
					$PermissionSet ='';
				}
				if(in_array($PermissionSet,$arr_PermissionSet) && in_array($PermissionSet,$arr_Module)){
					if($rFM3['PermissionLevel']==1 || ($rFM3['PermissionLevel']==2 && $_SESSION['ncareLevel_lwj']==5)){
						if($first_time==0){
							echo '<div class="formlistStyle">'.$rFM2['CategoryName'].'</div>';
							$first_time++;
						}
						echo '<div class="formlistItem">';
						echo '<a href="index.php?mod=fmform&func=formview&id='.$rFM3['formID'].'&pid='.$_GET['pid'].'"><span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-file-text fa-stack-1x fa-inverse"></i></span><br>'.$rFM3['FormName'].'</a>';
						echo '</div>';
					}
				}
			}
		}
	}		
}
?>