<div style="background-color: rgba(255,255,255,0.8); border-radius: 10px; padding:10px 10px 30px 10px; margin-bottom: 20px;">
<h3>Detail list</h3>
<div align="right">
<form>
<?php

//模組名稱
$strModule = "service_item";

if (@$_GET['action']!="") {  

$order = $_GET['order'];
$service_itemID = $_GET['service_itemID'];
$sord = new DB;
$sord->query("select * from `".$strModule."` WHERE `service_itemID`='".$service_itemID."' ");
$r = $sord->fetch_assoc();
  if (@$_GET['action']=="upper") {
	  //向上
	  $upID = $r['ord']-1;
  } else {
	  //向下
	  $upID = $r['ord']+1;
  }
$sord1 = new DB;
$sord1->query("select * from `".$strModule."` WHERE `service_cateID`='".$r['service_cateID']."' and ord='".$upID."'");  
$r1 = $sord1->fetch_assoc();
$updateitem = new DB;
$updateitem->query("UPDATE `".$strModule."` SET `ord`='".$upID."' WHERE `service_itemID`='".$r['service_itemID']."'");

$updateitem1 = new DB;
$updateitem1->query("UPDATE `".$strModule."` SET `ord`='".$r['ord']."' WHERE `service_itemID`='".$r1['service_itemID']."'");
echo '<script>location.replace("?mod=category&func=formview&id=2&code='.$_GET['code'].'&cate1='.$_GET['cate1'].'&cate2='.$_GET['cate2'].'");</script>';
}


//分類查詢
if($_GET['cate1'] <> "" && $_GET['cate2'] == ""){ 
	$cateDB = new DB;
	$cateDB->query("select * from service_cate where parentID='".mysql_escape_string($_GET['cate1'])."' and typeCode='".mysql_escape_string($_GET['code'])."' order by ord");		
	if($cateDB->num_rows()>0){
	  for ($ii=0;$ii<$cateDB->num_rows();$ii++) { 
		  $cate1 = $cateDB->fetch_assoc();
		  $tmp .= "'".$cate1['service_cateID']."'".($cateDB->num_rows()-1!=$ii ? "," : "");
	  }
	  $strQry .= " and t1.service_cateID in (".$tmp.")";	
	}else{
	  $strQry .= " and t1.service_cateID =".$_GET['cate1'];
	}
}else{
	$strQry .= " and t1.service_cateID='".mysql_escape_string($_GET['cate2'])."'";	

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
$strQry1="select COUNT(1) AS tbCount from ".$strModule." t1 where 1=1 ".$strQry."";

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
$sql1.="(SELECT t1.* from `".$strModule."` t1 where 1=1 ".$strQry."  ORDER BY t1.service_cateID DESC, t1.`ord` DESC LIMIT 0, ".abs($totalRecord-($pn-1)*$ps)." ) AS T2";
$sql1.=" ORDER BY T2.service_cateID ,T2.`ord`  LIMIT 0 ,".$ps."";

$pageString .= "&layer=".$_GET['layer']."&parentID=".$_GET['parentID'];
$pageString .="&cate1=".$_GET['cate1']."&cate2=".$_GET['cate2'];
?>
    <select name="lbllevel1" id="lbllevel1">
	<?php 
        $LevDB = new DB;
        $LevDB->query("select * from service_cate where parentID=0 and typeCode='".mysql_escape_string($_GET['code'])."' and isHidden_1=1 order by ord");		
		if($LevDB->num_rows() > 0 ){
			echo '<option value=""> ------ </option>';						
			for ($i=0;$i<$LevDB->num_rows();$i++) {
        		$lev = $LevDB->fetch_assoc();
				echo '<option value='.$lev['service_cateID'].' '.($lev['service_cateID']==$_GET['cate1']?"selected='selected'":"").'>'.$lev['title'].'</option>';					
			}
		}
	
    ?>
	</select>
    <select name="lbllevel2" id="lbllevel2">
	<?php 
		if($_GET['cate1']!=""){
			$sql = " and parentID='".mysql_escape_string($_GET['cate1'])."'";
		}
        $LevDB = new DB;
        $LevDB->query("select * from service_cate where 1=1 ".$sql." and layer=2 and typeCode='".mysql_escape_string($_GET['code'])."' and isHidden_1=1  order by ord");		
		if($LevDB->num_rows() > 0 ){
			echo '<option value=""> ------ </option>';							
			for ($i=0;$i<$LevDB->num_rows();$i++) {
        		$lev = $LevDB->fetch_assoc();
				echo '<option value='.$lev['service_cateID'].' '.($lev['service_cateID']==$_GET['cate2']?"selected='selected'":"").'>'.substr($lev['title'],0,15).'</option>';					
			}
		}	
    ?>
	</select>
<?php 
	$arrCate = array("maintenance" => "Public Works", "carework" => "Cleansing and disinfection record");
?>    
<input type="button" id="back" value="Back to <?php echo $arrCate[$_GET['code']]; ?>" style="cursor:pointer;" />
<input type="button" id="Category" value="Category manage" style="cursor:pointer;" />
<input type="button" id="Add" value="Add list" style="cursor:pointer;" />

<div class="content-table">

<table>
<tr class="title">
  <td width="10%">Sort</td>
  <td width="10%">Display order</td>
  <td width="*">Name</td>
  <td width="10%">Main category</td>
  <td width="10%">Subcategory</td>
  <td width="10%">Function</td>
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
	  if ($i!=0) { echo '<a href="?mod=category&func=formview&id=2&code='.$_GET['code'].'&service_itemID='.$r['service_itemID'].'&action=upper&order='.$r['ord'].'&cate1='.$_GET['cate1'].'&cate2='.$_GET['cate2'].'"><img src="Images/upper.png" width="55" height="16" border"0" /></a>'; }
	  if ($i!=($db->num_rows()-1)) { echo '<a href="?mod=category&func=formview&id=2&code='.$_GET['code'].'&service_itemID='.$r['service_itemID'].'&action=lower&order='.$r['ord'].'&cate1='.$_GET['cate1'].'&cate2='.$_GET['cate2'].'"><img src="Images/lower.png" width="55" height="16" border"0" /></a>'; }
  ?>
  </td>
  <td width="10%" align="center"><?php echo $ord; ?></td>
  <td width="*"><?php echo $title; ?></td>
  <?php
	$typeDB = new DB;
	$strSQL = "select * from service_cate where service_cateID=".$r['service_cateID']."";
	$typeDB->query($strSQL);	
	$r1 = $typeDB->fetch_assoc();	
	if($r1['parentID']!=0){
	  $typeDB1 = new DB;
	  $strSQL = "select * from service_cate where service_cateID=".$r1['parentID']."";
	  $typeDB1->query($strSQL);			
	  $r2 = $typeDB1->fetch_assoc();	
	  $title1 = $r1['title'];
	  $title2 = $r2['title'];
	}else{
	  $title2 = $r1['title'];
	  $title1 = "";
	}
  ?>
  <td width="10%" align="center"><?php echo $title2; ?></td>
  <td width="10%" align="center"><?php echo $title1; ?></td>
  <td width="20%"><input type="button" value="Edit" onclick="window.location.href='index.php?mod=category&func=formview&id=2_2&code=<?php echo $_GET['code']?>&service_itemID=<?php echo $r['service_itemID']; ?>&service_cateID=<?php echo $r['service_cateID'];?>'">
  </td>
</tr>
<?php
}
?>

</table>
</div>
<!--page Start-->
<table width="100%" style="border-collapse: collapse;" cellpadding="5" bordercolor="#f7bbc3" border="1">
  <tr>
    <td align="center" class="title page">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=category&func=formview&id=2&code=".$_GET['code']."");
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
		  location.href = "index.php?mod=category&func=formview&id=2_1&code="+type; 
	});	  
	$("#Category") .click(function(){
		var type ='<?php echo $_GET['code'];?>';
		var lev = '<?php echo $_GET['lev'];?>';
		location.href = "index.php?mod=category&func=formview&id=1&lev="+lev+"&code="+type;
	});
   $('#lbllevel1').change(function() {
	   var type ='<?php echo $_GET['code'];?>';
       location.href = "index.php?mod=category&func=formview&id=2&code="+type+'&cate1='+$("#lbllevel1").val();
	 });   
   $('#lbllevel2').change(function() {
	   var type ='<?php echo $_GET['code'];?>';
       location.href = "index.php?mod=category&func=formview&id=2&code="+type+'&cate1='+$("#lbllevel1").val()+'&cate2='+$("#lbllevel2").val();
	 });   
   $('#back').click(function(){
	  var type ='<?php echo $_GET['code'];?>';
	  var lev = '<?php echo $_GET['lev'];?>';
		  location.href = "index.php?mod="+type+"&func=formview&id=1&lev="+lev;
	});	  
	
	 
});
</script></div>