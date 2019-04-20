<?php

if (@$_GET['qdate']==NULL) { $qdate = date('Y-m-d'); } else { $qdate = @$_GET['qdate']; }
if (@$_GET['area']==NULL) { 
	$areaID = "";
} else { 
	$areaID = @$_GET['area']; 
}


if (isset($_POST['submit'])) {
	$arrEffect2 = array("1"=>"Spider","2"=>"Worm & bug","3"=>"Ant","4"=>"Butterfly","5"=>"Cockroach","6"=>"Other");
	//print_r($_POST);
	foreach ($_POST as $k=>$v) {
			$arrInfo = explode("_", $k);
			if (count($arrInfo)==3) {
				//$arrInfo[0] = tmpX
				//$arrInfo[1] = cID
				//$arrInfo[2] = count
				$Effect=$_POST['tmp3_'.$arrInfo[1].'_'.$arrInfo[2]];
				for ($i2=1;$i2<=6;$i2++) {
					if ($_POST['tmp3_'.$arrInfo[1].'_'.$arrInfo[2].'_'.$i2]==1) {
						$Effect =  $arrEffect2[$i2];
					}
				}
				//echo $_POST['tmp3_'.$arrInfo[1].'_'.$arrInfo[2].'_'.$arrInfo[3]]."@@";
				$db1 = new DB;
				$db1->query("SELECT `careworkID` FROM `careform04` WHERE `itemID`='".$arrInfo[1]."' AND `date`='".str_replace("/","-",$_POST['date'])."' AND `areaID`='".mysql_escape_string($_POST['areaID'])."' AND `itemDetail` = '".mysql_escape_string($_POST['tmp1_'.$arrInfo[1].'_'.$arrInfo[2]])."'");
				if ($db1->num_rows()>0) {
					$r1 = $db1->fetch_assoc();
					$db1a = new DB;
					$db1a->query("UPDATE `careform04` SET `status_1`='".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="1"?"1":"0")."', `status_2`='".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="2"?"1":"0")."', `status_3`='".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="3"?"1":"0")."', `effect` = '".$Effect."', `uDate`='".date("Y-m-d H:i:s")."', `filler`='".$_SESSION['ncareID_lwj']."' WHERE `careworkID`='".$r1['careworkID']."'");	
					//echo "UPDATE `careform04` SET `status_1`='".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="1"?"1":"0")."', `status_2`='".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="2"?"1":"0")."', `status_3`='".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="3"?"1":"0")."', `effect` = '".$Effect."', `uDate`='".date("Y-m-d H:i:s")."', `filler`='".$_SESSION['ncareID_lwj']."' WHERE `careworkID`='".$r1['careworkID']."'<br>";				
				} else {
					$db1a = new DB;
					$db1a->query("INSERT INTO `careform04` VALUES ('', '".$arrInfo[1]."', '".mysql_escape_string($_POST['tmp1_'.$arrInfo[1].'_'.$arrInfo[2]])."', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['areaID'])."', '".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="1"?"1":"0")."', '".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="2"?"1":"0")."', '".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="3"?"1":"0")."', '".mysql_escape_string($_POST['tmp3_'.$arrInfo[1].'_'.$arrInfo[2]])."', '".$_SESSION['ncareID_lwj']."', '".date("Y-m-d H:i:s")."', '')");
					//echo "INSERT INTO `careform04` VALUES ('', '".$arrInfo[1]."', '".mysql_escape_string($_POST['tmp1_'.$arrInfo[1].'_'.$arrInfo[2]])."', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['areaID'])."', '".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="1"?"1":"0")."', '".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="2"?"1":"0")."', '".($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2]]=="3"?"1":"0")."', '".mysql_escape_string($_POST['tmp3_'.$arrInfo[1].'_'.$arrInfo[2]])."', '".$_SESSION['ncareID_lwj']."', '".date("Y-m-d H:i:s")."', '')<br>";
				}
				$db1a1 = new DB;
				$db1a1->query("UPDATE `careform04` SET `status_1`='".mysql_escape_string($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2].'_1'])."', `status_2`='".mysql_escape_string($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2].'_2'])."', `status_3`='".mysql_escape_string($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2].'_3'])."', `uDate`='".date("Y-m-d H:i:s")."', `filler`='".$_SESSION['ncareID_lwj']."' WHERE `careworkID`='".$arrInfo[2]."'");
				//echo "UPDATE `careform04` SET `status_1`='".mysql_escape_string($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2].'_1'])."', `status_2`='".mysql_escape_string($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2].'_2'])."', `status_3`='".mysql_escape_string($_POST['tmp2_'.$arrInfo[1].'_'.$arrInfo[2].'_3'])."', `effect` = '".$Effect."', `uDate`='".date("Y-m-d H:i:s")."', `filler`='".$_SESSION['ncareID_lwj']."' WHERE `careworkID`='".$arrInfo[2]."'";			
			}
			
	}
	echo '<script>window.location.href="index.php?mod=carework&func=formview&id=4&qdate='.substr(str_replace("/","-",$_POST['date']),0,7).'&area='.$_POST['areaID'].'"</script>';
	
}
?>
<div class="moduleNoTab">
<form  method="post" onsubmit="return checkForm();" id="careform01">
<h3>Bug elimination record</h3>
<?php

echo '<a style="color:#3F3F3F; font-size:18px; font-weight:bold;">Select floor ： </a><select id="areaID" name="areaID" class="validate[required]">';
echo '  <option></option>';
$db3 = new DB;
$db3->query("SELECT * FROM `areainfo` ORDER BY `areaID` ASC");
for ($i3=0;$i3<$db3->num_rows();$i3++) {
	$r3 = $db3->fetch_assoc();
	echo '  <option value="'.$r3['areaID'].'"';
	if (@$_GET['area']==$r3['areaID']) { echo ' selected'; }
	echo '>'.$r3['areaName'].'</option>';
	$arrAreaName[$r3['areaID']] = $r3['areaName'];
}
echo '</select>';
?>
<table border="0" cellpadding="5">	
  <tr class="title">
    <td>Item(s)</td>
    <td width="150">Location</td>
    <td width="250">Execution</td>
    <td>Effectiveness</td>
  </tr>
<?php
$a = 1;
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 AND a.title like '消除蟲害%' ";
$str .=" ORDER BY a.ord ";
$db->query($str);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();	
	$db2 = new DB;
	$db2->query("SELECT * FROM `careform04` WHERE `date`='".$qdate."' AND `areaID`='".$areaID."' AND `itemID`='".$r['cID']."'");
	$status = "";
	if ($db2->num_rows()>0) {
		$r2 = $db2->fetch_assoc();
		foreach($r2 as $k=>$v){
			$info = explode("_",$k);
			if(count($info)==2){
				if ($v==1) {
					${$info[0]} .= $info[1].';';
				}
			}  else {
				${$k} = $v;
			}
		}
	}
	echo '
  <tr>';
   echo ' <td class="title_s" style="text-align:center; text-transform: capitalize;">'.str_replace("\n","<br>",$r['titlec']).'</td>
    <td align="center" colspan="3">';
	include("class/blockRecord.php");
	include("class/addRecord.php");
	echo '</td>
  </tr>
	'."\n";
}
?>
</table>
<table  style="width:100%;" cellpadding="7">
  <tr>
    <td>Date:<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($qdate != NULL) { echo str_replace("-","/",$qdate); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
	<div style="margin:20px 0 10px 0;">
    <input type="button" id="back" name="back" value="Back to list" />
    <input type="submit" id="submit" name="submit" value="Save" />
	</div>
</center>
</form>
</div>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=4";
		
	});
	$('#careform01').validationEngine();
});
</script>

