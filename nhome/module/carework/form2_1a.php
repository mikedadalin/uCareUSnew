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
			$db1->query("SELECT `careworkID` FROM `careform02` WHERE `itemID`='".$cID."' AND `date`='".mysql_escape_string($_POST['date'])."' AND `areaID`='".mysql_escape_string($_POST['areaID'])."'");
			if ($db1->num_rows()>0) {
				$r1 = $db1->fetch_assoc();
					$db1a = new DB;
					$db1a->query("UPDATE `careform02` SET `status_".$arrInfo[1]."`='".$v."', `uDate`='".date("Y-m-d H:i:s")."', `filler`='".$_SESSION['ncareID_lwj']."' WHERE `careworkID`='".$r1['careworkID']."'");
			} else {
				if ($v!=0) {
				$db1a = new DB;
				$db1a->query("INSERT INTO `careform02` VALUES ('', '".$cID."', '".mysql_escape_string($_POST['date'])."', '".mysql_escape_string($_POST['areaID'])."', '".mysql_escape_string($_POST['Qstatus-'.$cID.'_1'])."', '".mysql_escape_string($_POST['Qstatus-'.$cID.'_2'])."', '".$_SESSION['ncareID_lwj']."', '".date("Y-m-d H:i:s")."', '')");
				}
			}
		}
	}
	echo '<script>window.location.href="index.php?mod=carework&func=formview&id=2&qdate='.substr(str_replace("/","-",$_POST['date']),0,7).'&area='.$_POST['areaID'].'"</script>';
}

?>
<center>
<form  method="post" onsubmit="return checkForm();"  id="careform02" style="width:100%;">
<h3>Night shift cleansing and disinfection record</h3>
<div align="right">
<?php

echo 'Select floor ：<select id="areaID" name="areaID" class="validate[required]">';
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
&nbsp;<input type="button" id="Item" name="Item" value="Project management">
</div>
<table width="100%" border="0">	
  <tr class="title">
    <td colspan="2">Item(s)</td>
    <td>完成狀態</td>
  </tr>
<?php
$a = 1;
$db = new DB;
$str =" SELECT a.title titlea, a.service_cateID aID, c.title titlec, c.service_cateID cID FROM  `service_cate` a ";
$str .=" LEFT JOIN  `service_cate` c ON c.`parentID` = a.`service_cateID` ";
$str .=" WHERE 1 and a.typeCode='".mysql_escape_string($_GET['mod'])."' AND a.`layer` =1 AND a.`isHidden_1` =1 AND a.title like 'Night shift%'";
$str .=" ORDER BY a.ord";

$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
		$db1 = new DB;
		$str1 = "SELECT * FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$cate."' and a.isHidden_1=1 and b.isHidden_1=1 and a.title like 'Night shift%' order by a.ord";
		$db1->query($str1);
		${'aa'.$r['aID']} += $db1->num_rows();
		$ab += $db1->num_rows();
	}
}

$db->query($str);
if($db->num_rows()>0){
	for ($i=0;$i<$db->num_rows();$i++) {
		$r = $db->fetch_assoc();
		
		$cate = ($r['cID']=="")? $r['aID']:$r['cID'];
		$db1 = new DB;
		$str1 = "SELECT a.title, a.service_itemID FROM `service_item` a inner join `service_cate` b on a.service_cateID=b.service_cateID  WHERE a.service_cateID='".$cate."' and a.isHidden_1=1 and b.isHidden_1=1 order by a.ord";


		$db1->query($str1);
		if($db1->num_rows()>0){
			
			for ($i1=0;$i1<$db1->num_rows();$i1++) {
			  $r1 = $db1->fetch_assoc();				
				$db2 = new DB;
				$db2->query("SELECT * FROM `careform02` WHERE `date`='".$qdate."' AND `areaID`='".$areaID."' AND `itemID`='".$r1['service_itemID']."'");
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
				  if($tmp1!=$cate){
					  echo '<td class="title_s" rowspan="'.$db1->num_rows().'">'.$r['titlec'].'</td>';
				  }			  
				  echo'
				  <td>'.str_replace("\n","<br>",$r1['title']).'</td>
				  <td align="center">'.draw_option("Qstatus-".$r1['service_itemID'],"Yes;No","s","single",$status,false,0).'</td>
			  </tr>
		  	  ';
			  
		$a +=1;
		$tmp=$r['titlea'];
		$tmp1=$cate;
		$tmp2 = getCate($r1['service_cateID']);
			}
		}
	}
	echo '
	';
}
 
?>  
</table>
<table width="100%" cellpadding="5">
  <tr>
 <td>Date:<script> $(function() { $( "#date").datetimepicker({format:'Y/m/d', timepicker: false, mask: true}); }); </script><input type="text" name="date" id="date" value="<?php if ($qdate != NULL) { echo str_replace("-","/",$qdate); } ?>" size="12"> <input type="button" value="Today" onclick="inputdate('date');" /></td>

    <td align="right">Filled By : <?php if ($Qfiller==NULL) { echo checkusername($_SESSION['ncareID_lwj']); } else { echo checkusername($Qfiller); } ?></td>
  </tr>
</table>
<center><div style="margin:20px 0 10px 0;">
    <input type="button" id="back" name="back" value="Back to list" />
    <input type="submit" id="submit" name="submit" value="Save" />
</div></center>
</form></center>
<script language="javascript">
$(function() {
	$('#back').click(function(){
		location.href = "index.php?mod=carework&func=formview&id=2";
	});
	$('#Item').click(function(){
		location.href = "index.php?mod=category&func=formview&id=2&lev=2&code=carework";
	});
	$('#careform02').validationEngine(); 
});
</script>
<?php
function getCate($id){
	$db = new DB;
	$str = "select * from service_cate a inner join service_item b on a.service_cateID=b.service_cateID ";
	$str .=" where b.service_cateID='".$id."'";
	$db->query($str);
	$r1 = $db->fetch_assoc();
	return $r1['parentID'];
}
?>
</div>