<?php
include("DB.php");
include("function.php");

$strModule = "service_cate";
$parameters = $_POST['parent'];
$code = $_POST['code'];
$id = $_POST['id'];
if($parameters <> ""){
  $sql1 = "SELECT * FROM `".$strModule."` WHERE 1=1 And parentID = '".$parameters."' and typeCode='".$code."' and layer='2' and isHidden_1=1 order by ord";
  $db = new DB;
  $db->query($sql1);
  
  if($db->num_rows()> 0){	 
  		echo '2nd Hierarchy
			<select id="lbllevel2" name="lbllevel2">
				<option value="0">--</option>';
	  	for ($i=0;$i<$db->num_rows();$i++) {
			$rs = $db->fetch_assoc();
			echo '<option value="'.$rs['service_cateID'].'" class="'.$rs['parentID'].'" '.($rs['service_cateID']==$id?"selected='selected'":"").'>'.$rs['title'].'</option>';
		}
		echo '</select>';
  }
}
?>