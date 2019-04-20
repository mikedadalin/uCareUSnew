<h3>Vendor's info</h3>
<div align="right">
<form>
<?php

//模組名稱
$strModule = "firm";

if (@$_GET['query']==NULL || @$_GET['query']==1) {
	$strQry = " and t1.IsStop_1=1";
} else{
	$strQry = "";
}
//分類查詢
if($_GET['cateID'] <>''){
	$strQry .= " and t1.Fcode='".mysql_escape_string($_GET['cateID'])."'";
}

/*
分頁
ps 每頁顯示筆數
pn 頁次
*/
$ps = 10;
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

//Category
$cate = "select distinct Fcode from ".$strModule." where Fcode <> '' and IsStop_1=1";
$db1 = new DB;
$db1->query($cate);
if($db1->num_rows() >0){ 
?>
&nbsp;Vendors Category
<select name="cateID" id="cateID">
	<option value="">---All---</option> 
	<?php for ($i=0;$i<$db1->num_rows();$i++) {
		  $rs = $db1->fetch_assoc();
	?>
		<option value="<?php echo $rs['Fcode']; ?>" <?php if($_REQUEST['cateID']==$rs['Fcode']) echo "selected"; ?>><?php echo $rs['Fcode']; ?></option>
    <?php }?>
</select>
<?php }
//主SQL
$sql1="";
$sql1="SELECT * FROM ";
$sql1.="(SELECT t1.* from `".$strModule."` t1 where 1=1 ".$strQry."  ORDER BY t1.`".$strModule."ID` DESC LIMIT 0, ".abs($totalRecord-($pn-1)*$ps)." ) AS T2";
$sql1.=" ORDER BY T2.`".$strModule."ID`  LIMIT 0 ,".$ps."";

$pageString="query=".@$_GET['query'];
if($_GET['cateID'] <> '' ){
	$pageString .= "&cateID=".$_GET['cateID'];
}
?>
<input type="button" id="showAll" value="Display all vendors" style="cursor:pointer;" />
<input type="button" id="show" value="Display venders with current partnership only" style="cursor:pointer;" />
<input type="button" id="Add" value="Add vendor" style="cursor:pointer;" />
</form>
</div>
<div class="content-table">
<table>
<tr class="title">
  <td width="10%">&nbsp;</td>
  <td width="10%" style="padding:10px 5px;">ID #</td>
  <td width="20%" style="padding:10px 5px;">Vendor's Name</td>
  <td width="10%" style="padding:10px 5px;">Vendor Category</td>
  <td width="10%" style="padding:10px 5px;">Vendor's Phone</td>
  <td width="*" style="padding:10px 5px;">Vendor's Address</td>
  <td>Comment</td>
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
  <td width="6%"><center><a href="index.php?mod=consump&func=formview&id=1b&firmID=<?php echo $firmID ?>"><img src="Images/select.png"></a></center></td>
  <td><?php echo $firmID ?></td>
  <td><?php echo $Title ?></td>
  <td><?php echo $Fcode ?></td>
  <td><?php echo $Tel1 ?></td>
  <td><?php echo $Address ?></td>
  <td>
  <?php 
    echo $Fmark;
  	if($IsStop==2){
		echo "<br>"; echo "<font color='red' size='1'>己暫停合作</font>";
	}else{echo "";}
  ?>
  </td>
</tr>
<?php
}
?>
</table>
<!--page Start-->
<table width="100%" style="border-collapse: collapse;" cellpadding="5" border="0">
  <tr>
    <td align="center" class="title page" style="padding:10px 5px;">
	<?php
		changePageManager($totalRecord,$totalPage,$pn,$ps,$pageString,"index.php?mod=consump&func=formview&id=1a");
    ?>
    </td>
  </tr>
</table>
<!--page End-->

</div>
<script language="javascript">
$(function() {
   $('#cateID').change(function() {
      location.href = "index.php?mod=consump&func=formview&id=1a&cateID=" + $('#cateID').val();
	 }); 
   $('#showAll').click(function(){
	  location.href = "index.php?mod=consump&func=formview&id=1a&query=0"; 
	 });	   
   $('#show').click(function(){
	  location.href = "index.php?mod=consump&func=formview&id=1a&query=1"; 
	 });	   
   $('#Add').click(function(){
	  location.href = "index.php?mod=consump&func=formview&id=1b"; 
	 });	   
});
</script>