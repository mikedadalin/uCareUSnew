<h3>Inventory reconciliation</h3>
<fieldset><legend>Description</legend>This page is based on actual purchasing, delivery,adjustment quanities.</fieldset>
<?php

//模組名稱
$strModule = "stockform";

if ($_POST['Smonth']=="") { $Smonth = date(m); } else { $Smonth = $_POST['Smonth']; }
if ($_POST['Syear']=="") { $Syear = date(Y); } else { $Syear = $_POST['Syear']; }

if($Smonth=="01"){
	$Y1 = date($Syear)-1;
	$M1 = "12";			 
} else {
	$Y1 = date($Syear);
	$M1 = str_pad((date($Smonth)-1),2,'0',STR_PAD_LEFT);
}	 
$chkSdate = $Y1.'/'.$M1.'/'.chkDay($Y1.'/'.$M1.'/01',cSTKdate());
$Y2 = date($Syear);
$M2 = str_pad(date($Smonth),2,'0',STR_PAD_LEFT);
$chkEdate = $Y2.'/'.$M2.'/'.chkDay($Y2.'/'.$M2.'/01',cSTKdate());	

if($Smonth=="12"){
	$Y = date($Syear)+1;  
	$m = "01";
} else {
	$Y = date($Syear);
	$m = str_pad((date($Smonth)+1),2,'0',STR_PAD_LEFT);
}

//日期搜尋
$strQry = " AND a.IsStatus <> 'D' AND a.`STK_Date` > '".$chkSdate."' AND a.`STK_Date` <='".$chkEdate."'";

$db = new DB;
$strSQL .= "SELECT STK_NO, SUM( IF( TYPE =  'A', QTY, 0 ) ) AS A, SUM( IF( TYPE =  'A', Price, 0 ) ) AS A1,";
$strSQL .= "SUM( IF( TYPE =  'SP', QTY, 0 ) ) AS SP, SUM( IF( TYPE =  'SP', Price, 0 ) ) AS SP1,";
$strSQL .= "SUM( IF( TYPE =  'IC', QTY, 0 ) ) AS IC, SUM( IF( TYPE =  'IC', Price, 0 ) ) AS IC1,";
$strSQL .= "SUM( IF( TYPE =  'OC', QTY, 0 ) ) AS OC, SUM( IF( TYPE =  'IC', Price, 0 ) ) AS OC1,";
$strSQL .= "StockID FROM `firmstockinfo` a WHERE 1 ".$strQry."";
$strSQL .= "GROUP BY STK_NO, StockID";
$db->query($strSQL);
?>
<form method="post" action="index.php?<?php echo $_SERVER['QUERY_STRING']; ?>" id="form1" name="form1">
<div align="left" class="content-query">
<table>
  <tr class="title">
    <td colspan="4">Conditions input</td>
  </tr>
   <tr style="background-color:rgba(255,255,255,0.5);">
    <td class="title">Inventory (annual) </td>
    <td align="left" >
	<select name="Syear" id="Syear">
    <?php for($ii = 2014 ;$ii<= 2024; $ii++){ ?>
    	<option value="<?php echo $ii; ?>" <?php if($Syear==$ii) { echo 'selected'; } elseif ($Syear==$ii) { echo 'selected'; } ?>><?php echo $ii."Year"; ?></option>
    <?php }?>
    </select>
	</td>
    <td class="title">Inventory (monthly) </td>
    <td align="left">
	<select name="Smonth" id="Smonth">
    <?php 
		
		for($ii = 1 ;$ii<= 12; $ii++){
			
	?>
    	<option value="<?php if($ii<10){echo "0".$ii;}else{echo $ii;} ?>" <?php if($Smonth==$ii) { echo 'selected'; } elseif ($Smonth==$ii) { echo 'selected'; } ?>><?php echo $ii."Month"; ?></option>
      <?php }?>
    </select>
	</td>
    </tr>
  <tr style="background-color:rgba(255,255,255,0.5);">
    <td colspan="4"><center>
<input type="submit" value="Generate" id="submit" name="submit" /> 
    </center></td>
    </tr>
</table>
</div>
</form>
<?php 
$db3 = new DB;
$db3->query("SELECT distinct(STK_NO), StockID FROM `stockform` WHERE STK_YEAR='".$Syear."' and STK_MONTH='".$Smonth."'");
if ($db3->num_rows() > 0){
	for($i3=0;$i3<$db3->num_rows();$i3++){
	$r3 = $db3->fetch_assoc();
		$db4=new DB;
		$db4->query("SELECT distinct(a.STK_NO), a.StockID FROM `firmstockinfo` a WHERE 1 ".$strQry." AND a.`STK_NO`='".$r3['STK_NO']."' AND a.`StockID`='".$r3['StockID']."'");
		if($db4->num_rows() > 0){
			
		}else{
			//echo "@@".$r3['STK_NO'].' '.$r3['StockID'].'<br>';
			//$db2 = new DB;
			//$db2->query("UPDATE `stockform` SET `IN_STK`='0',`IN_PRC`='0',`OUT_STK`='0',`OUT_PRC`='0',`ADJ_STK`='0',`ADJ_PRC`='0' WHERE StockID='".$r3['StockID']."' AND STK_NO='".$r3['STK_NO']."' AND STK_YEAR='".$r3['STK_YEAR']."' and STK_MONTH='".$r3['STK_MONTH']."'");
		}
	}
}
if ($db->num_rows() > 0){
?>
<table id="stktable">
	<thead>
	<tr class="title">
        <th>Storehouse</th>
        <th>product serial number</th>
        <th>Product name</th>
        <th>Purchase quantity</th>
        <th>Delivery quantity</th>
        <th>Adjust quantity</th>
        <th>Return quantity</th>
        <th>Actual net in/out</th>
    </tr>
    </thead>
<?php
	for($i=0;$i<$db->num_rows();$i++){
		$r = $db->fetch_assoc();
		echo'
		<tr>
			<td>'.getStockName($r['StockID']).'</td>
			<td>'.$r['STK_NO'].'</td>
			<td>'.STK_NAME($r['STK_NO']).'</td>
			<td>'.$r['IC'].'</td>
			<td>'.$r['SP'].'</td>
			<td>'.$r['A'].'</td>
			<td>'.$r['OC'].'</td>
			<td>'.($r['IC']+$r['A']-$r['OC']-$r['SP']).'</td>
		</tr>
		';
		$db1 = new DB;
		$db1->query("SELECT * FROM `stockform` WHERE StockID='".$r['StockID']."' AND STK_NO='".$r['STK_NO']."' AND STK_YEAR='".$Syear."' and STK_MONTH='".$Smonth."'");
		if($db1->num_rows()>0){
			//$db2 = new DB;
			//$db2->query("UPDATE `stockform` SET `IN_STK`='".$r['IC']."',`IN_PRC`='".$r['IC1']."',`OUT_STK`='".$r['SP']."',`OUT_PRC`='".$r['SP1']."',`ADJ_STK`='".$r['A']."',`ADJ_PRC`='".$r['A1']."' WHERE StockID='".$r['StockID']."' AND STK_NO='".$r['STK_NO']."' AND STK_YEAR='".$Syear."' and STK_MONTH='".$Smonth."'");
		}
	}
?>    
</table>
<?php	
}
?>
<script>
$(function() {
	$('#stktable').dataTable({
		"order": [[1, "asc"], [0, "asc"]],
		"paging": false
	});
});
</script>