<div class="moduleNoTab">
<h3>Project maintenance</h3>
<div align="right">
<form>
<?php

//模組名稱
$strModule = "service_cate";

if (@$_GET['action']!="") {  

$order = $_GET['order'];
$service_cateID = $_GET['service_cateID'];
$sord = new DB;
$sord->query("select * from `".$strModule."` WHERE `service_cateID`='".$service_cateID."' ");
$r = $sord->fetch_assoc();
  if (@$_GET['action']=="upper") {
	  //向上
	  $upID = $r['ord']-1;
  } else {
	  //向下
	  $upID = $r['ord']+1;
  }
$sord1 = new DB;
$sord1->query("select * from `".$strModule."` WHERE `parentID`='".$r['parentID']."' and `typeCode`='".$r['typeCode']."' and layer='".$r['layer']."' and ord='".$upID."'");  
$r1 = $sord1->fetch_assoc();
$updateitem = new DB;
$updateitem->query("UPDATE `".$strModule."` SET `ord`='".$upID."' WHERE `service_cateID`='".$r['service_cateID']."'");

$updateitem1 = new DB;
$updateitem1->query("UPDATE `".$strModule."` SET `ord`='".$r['ord']."' WHERE `service_cateID`='".$r1['service_cateID']."'");
	if($r['layer']==2){
		echo '<script>location.replace("?mod=category&func=formview&id=1&code='.$_GET['code'].'&parentID='.$r['parentID'].'&layer='.$r['layer'].'");</script>';
	}else{
		echo '<script>location.replace("?mod=category&func=formview&id=1&code='.$_GET['code'].'");</script>';
	}
}


//分類查詢
if(strlen($_GET['layer'])==0 && strlen($_GET['parentID'])==0){ 
	$_SESSION['level']=0;
	$strQry .= " and t1.layer=1";	
	
}else{
	$_SESSION['level']=1;
	$strQry .= " and t1.parentID='".mysql_escape_string($_GET['parentID'])."' and t1.layer='2'";	
}
/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 30;
$pn = 1;
if (@$_GET['pn'] > 0) { $pn= @$_GET['pn']; }

// 總頁次及總筆數
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 where 1=1 and t1.typeCode='".mysql_escape_string($_GET['code'])."' ".$strQry."";

$dbpage = new DB;
$dbpage->query($strQry1);
$p = $dbpage->fetch_assoc();
$totalRecord = $p['tbCount'];

if($totalRecord < $ps){
	$totalPage = 1;	
}else{
	if($totalRecord % $ps <> 0){
		$totalPage = floor($totalRecord / $ps) +1;		
	}else{
		$totalPage = $totalRecord / $ps;
	}
}

//主SQL
$sql1="";
$sql1="SELECT * FROM ";
$sql1.="(SELECT t1.* from `".$strModule."` t1 where 1=1 and t1.typeCode='".mysql_escape_string($_GET['code'])."' ".$strQry."  ORDER BY t1.`ord` DESC LIMIT 0, ".abs($totalRecord-($pn-1)*$ps)." ) AS T2";
$sql1.=" ORDER BY T2.`ord`  LIMIT 0 ,".$ps."";
if($_SESSION['level']==1){
	$pageString .= "&layer=".$_GET['layer']."&parentID=".$_GET['parentID'];
	
	$dba = new DB;
	$dba->query("select title from ".$strModule." where `".$strModule."ID` = '".mysql_escape_string($_GET['parentID'])."'");
	$ra = $dba->fetch_assoc();
	echo '<h4 align="left">Main category:'.$ra['title'].'</h4>';
?>
<input type="button" value="Back to main category" onclick="window.location.href='index.php?mod=category&func=formview&id=1&code=<?php echo $_GET['code']?>'">
<?php 
}else{
	$arrback = array("property" => array("Property management",'consump',"16","0"), "humanresource" => array("Pre-employment training",'humanresource',"14","1"), "carework" => array("Cleansing and disinfection record",'carework',"1a","1"),"cantext" => array("罐頭字管理","cantext","","0"));
	if($arrback[$_GET['code']][3]=='0' || $arrback[$_GET['code']][3]=='1'){
?>
<input type="button" id="Add2" value="Back to <?php echo $arrback[$_GET['code']][0];?>" style="cursor:pointer;" onclick="goBack('<?php echo $arrback[$_GET['code']][1]; ?>','<?php echo $arrback[$_GET['code']][2]; ?>');" />
<?php		
	}else{	
?>
<input type="button" id="Add1" value="Detail list manage" style="cursor:pointer;" />
<?php 
	}
}?>
<?php 
if($_GET['lev']=="2"){
	echo '<input type="button" id="Add1" value="Detail list manage" style="cursor:pointer;" />';
}
?>
<input type="button" id="Add" value="New category" style="cursor:pointer;" />
<div class="content-table">
<table cellpadding="7">
<tr class="title">
  <td width="10%">Sort</td>
  <td width="15%">Display order</td>
  <td width="*">Category name</td>
  <td width="15%">Hierarchy</td>
  <td width="30%">Function</td>
</tr>
<?php
$db = new DB;
$db->query($sql1);
for ($i=0;$i<$db->num_rows();$i++) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) {
		$arrPatientInfo = explode("_",$k);
		if (count($arrPatientInfo)==2) {
			if ($v==1) {
				${$arrPatientInfo[0]} = $arrPatientInfo[1];
			}
		} else {
			${$k} = $v;
		}
	}
?>
<tr>
  <td width="15%" align="center">
  <?php 	
  if($_SESSION['level']==1){
	  if ($i!=0) { echo '<a href="?mod=category&func=formview&id=1&code='.$_GET['code'].'&service_cateID='.$r['service_cateID'].'&action=upper&order='.$r['ord'].'"><span class="goUpper">UPPER</span></a>'; }
	  if ($i!=($db->num_rows()-1)) { echo '<a href="?mod=category&func=formview&id=1&code='.$_GET['code'].'&service_cateID='.$r['service_cateID'].'&action=lower&order='.$r['ord'].'"><span class="goLower">LOWER</span></a>'; }

  }else{
	  if ($i!=0) { echo '<a href="?mod=category&func=formview&id=1&code='.$_GET['code'].'&service_cateID='.$r['service_cateID'].'&action=upper&order='.$r['ord'].'"><span class="goUpper">UPPER</span></a>'; }
	  if ($i!=($db->num_rows()-1)) { echo '<a href="?mod=category&func=formview&id=1&code='.$_GET['code'].'&service_cateID='.$r['service_cateID'].'&action=lower&order='.$r['ord'].'"><span class="goLower">LOWER</span></a>'; }
  }
  ?>
  </td>
  <td width="10%" align="center"><?php echo $ord; ?></td>
  <td width="*"><?php echo str_replace("\n","<br>",$title); ?></td>
  <td width="10%" align="center"><?php echo $layer; ?></td>
  <td width="20%" align="center"><input type="button" value="Edit" onclick="window.location.href='index.php?mod=category&func=formview&id=1_2&code=<?php echo $_GET['code']?>&service_cateID=<?php echo $r['service_cateID']; ?>&layer=<?php echo $r['layer'];?>&parentID=<?php echo $r['parentID'];?>'">
  <?php 
  if($_SESSION['level']==0){
	  if($arrback[$_GET['code']][3]!='0'){
  ?>
  <input type="button" value="Subcategory" onclick="window.location.href='index.php?mod=category&func=formview&id=1&lev=<?php echo $_GET['lev']?>&code=<?php echo $_GET['code']?>&parentID=<?php echo $r['service_cateID']; ?>&layer=2'">
  <?php
   	  }
   }
   ?>
  </td>
</tr>
<?php
}
?>

</table>
</div>
<!--page Start-->
<table style="border-collapse: collapse;" cellpadding="5" bordercolor="#f7bbc3" border="1">
  <tr>
    <td align="center" class="title page">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=category&func=formview&id=1&code=".$_GET['code']."");
    ?>
    </td>
  </tr>
</table>
<!--page End-->
</form>
</div>
<script language="javascript">
$(function() {
   $('#Add').click(function(){
	  var type ='<?php echo $_GET['code'];?>';
	  var layer = '';
	  <?php if(strlen($_GET['layer'])==0){?>
	  	layer = '1';
	  <?php }else{?>
	    layer = '<?php echo $_GET['layer']; ?>';
	  <?php }?>
	  
	  if(layer==2){
		  var parentID='<?php echo $_GET['parentID'];?>';
		  location.href = "index.php?mod=category&func=formview&id=1_1&code="+type+'&parentID='+parentID+'&layer='+layer; 
	  }else{
		  location.href = "index.php?mod=category&func=formview&id=1_1&code="+type+'&layer='+layer; 
	  }
	  
	});	   
	 
	$("#Add1") .click(function(){
		var type ='<?php echo $_GET['code'];?>';
		location.href = "index.php?mod=category&func=formview&id=2&code="+type;
	});
});
function goBack(mod,id){
	if(mod=='cantext'){
		location.href = "index.php?func=infoedit&view=4";
	}else{
		location.href = "index.php?mod="+mod+"&func=formview&id="+id;
	}
}
</script></div>