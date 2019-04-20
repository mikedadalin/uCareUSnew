<?php
include("DB.php");
include("function.php");

$mainID = $_POST['mainID'];				

$sql1 = "SELECT * FROM `maintenance` WHERE 1=1 And `mainID` = '".$mainID."'";
$db = new DB;
$db->query($sql1);

if($db->num_rows()> 0){	 
	$rs = $db->fetch_assoc();
	$arrContent = explode("_",$rs['ApplyContent1']);
	foreach ($arrContent as $k=>$v){
		if(count($arrContent) ==2){
			$content = $arrContent[1];
			if($arrContent[0]!=""){
				$sql2 = "SELECT * FROM `property` WHERE 1=1 And `propertyID` = '".$arrContent[0]."' ORDER BY `p_no`";
				$db2 = new DB;
				$db2->query($sql2);
				if($db2->num_rows()> 0){
					$property = '
					<select id="lbllevel2" name="lbllevel2">
					<option value="0">---</option>';
					for ($i=0;$i<$db2->num_rows();$i++) {
						$rs2 = $db2->fetch_assoc();		
						$property .= '<option value="'.$rs2['propertyID'].'" '.($rs2['propertyID']==$arrContent[0]?"selected='selected'":"").'>'."【".$rs2['p_no']."】".$rs2['p_name'].'</option>';
					}
					$property .= '</select>';
				}
			}
		} else{
			$content = $rs['ApplyContent1'];
		}
	}
	echo $property.'_'.$rs['ApplyDate'].';'.$rs['ApplyFloor'].';'.$content.';'.$rs['ApplyContent2'].';';
}
?>