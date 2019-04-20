<div class="moduleNoTab">
<?php
if (@$_GET['qdate']==NULL) { $qdate = date('Y-m-d'); } else { $qdate = @$_GET['qdate']; }
if (@$_GET['area']==NULL) { 
	$areaID = "";
} else { 
	$areaID = @$_GET['area']; 
}


if (isset($_POST['submit'])) {
	foreach ($_POST as $k=>$v) {
		if (substr($k,0,7)=="Qstatus") {
			$arrInfo = explode("_", $k);
			$arrInfo2 = explode("-", $arrInfo[0]);
			$cID = $arrInfo2[1];
			$db1 = new DB;
			$db1->query("SELECT `careworkID` FROM `careform01` WHERE `itemID`='".$cID."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `areaID`='".mysql_escape_string($_POST['areaID'])."'");
			if ($db1->num_rows()>0) {
				$r1 = $db1->fetch_assoc();
					$db1a = new DB;
					$db1a->query("UPDATE `careform01` SET `status_".$arrInfo[1]."`='".$v."', `uDate`='".date("Y-m-d H:i:s")."', `filler`='".$_SESSION['ncareID_lwj']."' WHERE `careworkID`='".$r1['careworkID']."'");
			} else {
				if ($v!=0) {
				$db1a = new DB;
				$db1a->query("INSERT INTO `careform01` VALUES ('', '".$cID."', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['areaID'])."', '".mysql_escape_string($_POST['Qstatus-'.$cID.'_1'])."', '".mysql_escape_string($_POST['Qstatus-'.$cID.'_2'])."', '".$_SESSION['ncareID_lwj']."', '".date("Y-m-d H:i:s")."', '')");
				}
			}
		}
	}	
	echo '<script>window.location.href="index.php?mod=carework&func=formview&id=1_2a&type=d&qdate='.substr(str_replace("/","-",$_POST['date']),0,7).'&area='.$_POST['areaID'].'"</script>';
	
}
?>
<center>
<form  method="post" onsubmit="return checkForm();" id="careform01">
<h3>Day shift cleansing and disinfection record</h3>
<?php

echo '<div align="left">Select floor ：<select id="areaID" name="areaID" class="validate[required]">';
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
echo '</select></div>';
?>
<table border="0">	
  <tr class="title">
    <td>Item(s)</td>
    <td>完成狀態</td>
  </tr>
<?php
$a = 1;
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 AND a.title like 'Day shift%'";
$str .=" ORDER BY a.ord";
$db->query($str);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();	
	$db2 = new DB;
	$db2->query("SELECT * FROM `careform01` WHERE `date`='".$qdate."' AND `areaID`='".$areaID."' AND `itemID`='".$r['cID']."'");
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
   echo ' <td class="title_s" style="text-align:left;padding:2px 8px;">'.str_replace("\n","<br>",$r['titlec']).'</td>
    <td align="center">'.draw_option("Qstatus-".$r['cID'],"Yes;No","s","single",$status,false,0).'</td>
  </tr>
	'."\n";
}
?>
</table>
<table>
  <tr>
    <td>Date:<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($qdate != NULL) { echo str_replace("-","/",$qdate); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>
    <td align="right">Filled by :<?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center>
	<div style="margin-top:20px;">
	    <input type="button" id="back" name="back" value="Back to list" />
	    <input type="submit" id="submit" name="submit" value="Save" />
	</div>
</center>
</form></center>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=1_2a&type=d";
		
	});
	$('#careform01').validationEngine();
});
</script>
</div>